<?php
	require_once("login_c/models/config.php");
	require_once("login_c/models/header.php");
	if(!isUserLoggedIn()){ header("Location: login_c/"); die(); }
	
	if(!empty($_POST)) {
		// save new profile
		$profileType = $_POST['newProfileType'];
		global $mysqli;
		$stmt = $mysqli->prepare("SELECT id FROM profile_fields WHERE profile_types_ID = ?");
		$stmt->bind_param("i", $profileType);
		$stmt->execute();
		$stmt->bind_result($fieldId);
		$savedProfileFields = array();
		while($stmt->fetch()) {
			$savedProfileFields[] = $fieldId;
		}
		$stmt->close();
		foreach ($savedProfileFields as $field) {
			echo "field: $field, value: ".$_POST[$field]."<br />";
			$mysqli->query("INSERT INTO user_saved_fields (`value`, `profile_fields_ID`, `uc_users_ID`) 
							VALUES ('{$_POST[$field]}', '{$field}', '{$loggedInUser->user_id}')");
		}
		$mysqli->query("INSERT INTO user_profile_map (`profile_types_ID`, `uc_users_ID`) VALUES ('{$profileType}', '{$loggedInUser->user_id}')");
		$mysqli->close();
		header("Location: index.php");
	}
	
?>
<script>
	$(document).ready(function () {
		$("#saveNewProfileButton").hide();
	});

	function profileTypeSelectedIndexChanged(typeId) {
		if (typeId == "0") {
			document.getElementById("profileFieldSection").innerHTML = "";
			$("#saveNewProfileButton").hide();
			return;
		}
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				document.getElementById("profileFieldSection").innerHTML = xmlhttp.responseText;
				$("#saveNewProfileButton").show();
			}
		}
		xmlhttp.open("GET", "get_profile_form_fields.php?ptype=" + typeId, true);
		xmlhttp.send();
	}
</script>
<div id="page-filler"></div>
<div class="header">
	<div class="pure-g">
		<div class="pure-u-19-24">
			<div class="pure-menu pure-menu-open pure-menu-horizontal">
				<a class="pure-menu-heading" href="#">Cyripe</a>
				<ul>
					<li><a href="index.php">Home</a></li>
					<li class="pure-menu-selected"><a href="new_profile.php">Create New Profile</a></li>
					<li><a href="#">Edit Information</a></li>
				</ul>
			</div>
		</div>
		<div class="pure-u-5-24">
			<div class="pure-menu pure-menu-open pure-menu-horizontal">
				<ul>
					<li>Welcome, <?php echo $loggedInUser->displayname; ?>!</li>
					<li><a href="login_c/logout.php">Logout</a></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="main-new-profile-form">
		<form name="saveNewProfileForm" class="pure-form pure-form-stacked" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
			<fieldset>
				<div class="pure-g">
					<div class="pure-u-1-3">
						<label for="profileType">Profile Type:</label>
						<select id="profileType" name="newProfileType" style="width: 100%" onchange="profileTypeSelectedIndexChanged(this.value)">
							<option value="0">Select One</option>
							<?php
								$types = getProfileTypes($loggedInUser->user_id);
								foreach($types as $type) {
									echo "<option value='{$type['id']}'>{$type['name']}</option>";
								}
							?>
						</select>
					</div>
				</div>
				<hr class="line-separator" />
				<div id="profileFieldSection"></div>
				<input id="saveNewProfileButton" type="submit" class="pure-button pure-input-1-4 pure-button-primary" value="Save" />
			</fieldset>
		</form>
	</div>
</div>