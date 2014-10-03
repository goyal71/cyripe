<?php
	require_once("login_c/models/config.php");
	require_once("login_c/models/header.php");
	if(!isUserLoggedIn()){ header("Location: login_c/"); die(); }
	
	if(!empty($_POST)) {
		// save new profile
		saveUserProfileFields($_POST['newProfileType'], false);
		header("Location: index.php");
		die();
	}
	
?>
<body>
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
			xmlhttp.open("GET", "get_profile_form_fields.php?p_type=" + typeId, true);
			xmlhttp.send();
		}
	</script>
	<div id="page-filler"></div>
	<div class="header">
		<?php /* menu header */ $selectedHeader = 'new_profile'; include("account_menu_header.php"); ?>
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
</body>