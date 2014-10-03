 <?php
	require_once("login_c/models/config.php");
	require_once("login_c/models/header.php");
	if(!isUserLoggedIn()){ header("Location: login_c/"); die(); }
	
	if(!isset($_POST['p_type'])) { header("Location: index.php"); die(); }
	$profileType = $_POST['p_type'];
	global $mysqli;
	
	if($mysqli->query("DELETE FROM user_saved_fields 
						WHERE profile_fields_ID IN 
							(SELECT id FROM profile_fields 
								WHERE profile_types_ID = $profileType) 
						AND uc_users_ID = {$loggedInUser->user_id}")) {
		$successful = 'true';
	} else {
		$successful = 'false';
	}
	
	if($mysqli->query("DELETE FROM user_profile_map WHERE profile_types_ID = {$profileType} AND uc_users_ID = {$loggedInUser->user_id}")) {
		$successful = 'true';
	} else {
		$successful = 'false';
	}
	header("Location: index.php?profile_deleted=$successful");
	die();
 ?>