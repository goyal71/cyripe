<?php 
	require_once("login_c/models/config.php");
	require_once("login_c/models/header.php");
	if(!isUserLoggedIn()){ header("Location: login_c/"); die(); }
	
	if(!isset($_GET['p_type'])) { header("Location: index.php"); die(); }
	$profileType = $_GET['p_type'];
	
	if(!empty($_POST)) {
		// update profile
		saveUserProfileFields($_GET['p_type'], true);
		header("Location: index.php");
		die();
	}
	
	$result = $mysqli->query("SELECT DisplayName FROM profile_types WHERE Id = $profileType LIMIT 1");
	$profileName = $result->fetch_array();
 ?>
 <body>
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
	<div id="page-filler"></div>
	<div class="header">
		<?php include("account_menu_header.php"); ?>
		<div class="main-new-profile-form">
			<div class="medium-size-text"><?php echo $profileName['DisplayName']; ?></div>
			<hr class="line-separator" />
			<form name="editProfileForm" class="pure-form pure-form-stacked" method="post">
				<div id="profileFieldSection"></div>
				<input id="updateProfileButton" type="submit" class="pure-button pure-input-1-4 pure-button-primary" value="Save" />
			</form>
		</div>
	</div>