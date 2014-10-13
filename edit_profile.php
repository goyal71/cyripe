<?php 
	require_once("login_c/models/config.php");
	require_once("login_c/models/header.php");
	if(!isUserLoggedIn()){ header("Location: login_c/"); die(); }
	
	if(!isset($_GET['p_type'])) { header("Location: index.php"); die(); }
	$profileType = $_GET['p_type'];
	
	if(!empty($_POST)) {
		// update profile
		$successful = saveUserProfileFields($_GET['p_type'], true);
		$successMessage = $successful ? 'true' : 'false';
		header("Location: index.php?profile_updated=$successMessage");
		die();
	}
	
	$result = $mysqli->query("SELECT DisplayName FROM profile_types WHERE Id = $profileType LIMIT 1");
	$profileName = $result->fetch_array();
 ?>
 <body class="backlay">
	<script>
		$(document).ready(function() {
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
					document.getElementById("profileFieldSection").innerHTML = xmlhttp.responseText;
				}
			}
			xmlhttp.open("GET", "get_profile_form_fields.php?p_type=<?php echo $profileType; ?>&update=true", true);
			xmlhttp.send();
		});
	</script>
	<div class="header">
		<?php include("account_menu_header.php"); ?>
	</div>
	<div class="main-new-profile-form">
		<span class="large-size-text"><?php echo $profileName['DisplayName']; ?></span>
		<span class="right">
			<form name="deleteProfile" class="pure-form" action="delete.php" method="post">
				<input type="hidden" name="p_type" value="<?php echo $profileType; ?>" />
				<input type="submit" class="button-error pure-button" onclick="if(!confirm('Are you sure you want to delete this profile?')){ return false; };" value="Delete Profile" />
			</form>
		</span>
		<hr class="line-separator" />
		<form name="editProfileForm" class="pure-form pure-form-stacked" method="post">
			<div id="profileFieldSection"></div>
			<input id="updateProfileButton" type="submit" class="pure-button pure-input-1-4 pure-button-primary" value="Save" />
		</form>
	</div>