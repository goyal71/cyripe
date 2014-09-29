<?php
	require_once("login_c/models/config.php");
	require_once("login_c/models/header.php");
	if(!isUserLoggedIn()){ header("Location: login_c/"); die(); }
	echo $loggedInUser->displayname;
?>
<script>
	function profileTypeSelectedIndexChanged(typeId) {
		if (typeId == "0") {
			document.getElementById("profileFieldSection").innerHTML = "";
			return;
		}
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				document.getElementById("profileFieldSection").innerHTML = xmlhttp.responseText;
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
		<form class="pure-form pure-form-stacked">
			<fieldset>
				<label for="profileType">Profile Type:</label>
				<select id="profileType" onchange="profileTypeSelectedIndexChanged(this.value)">
					<option style="width: 200px" value="0">Select One</option>
					<?php
						$types = getProfileTypes($loggedInUser->user_id);
						foreach($types as $type) {
							echo "<option value='{$type['id']}'>{$type['name']}</option>";
						}
					?>
				</select>
				<hr class="line-separator" />
				<div id="profileFieldSection"></div>
			</fieldset>
		</form>
	</div>
</div>