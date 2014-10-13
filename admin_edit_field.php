 <?php
	require_once("login_c/models/config.php");
	require_once("login_c/models/header.php");
	if(!isUserLoggedIn()){ header("Location: login_c/"); die(); }
	if (!$loggedInUser->checkPermission(array(2))){ header("Location: index.php"); die(); }
	if(!isset($_GET['fieldId'])){ header("Location: index.php"); die(); }
	global $mysqli;
	$result = $mysqli->query("SELECT pf.Id, pf.Label, pf.profile_types_ID, pf.Sequence, it.TypeName
							FROM input_types it, profile_fields pf
							WHERE pf.Input_Types_ID = it.ID
							AND pf.ID = {$_GET['fieldId']}");
	$fieldInfo = $result->fetch_assoc();
?>
<body class="backlay">
	<div class="header">
		<?php /* menu header */ $selectedHeader = 'admin'; include("account_menu_header.php"); ?>
	</div>
		<div class="main-new-profile-form">
			<div>
				<span class="large-size-text"><?php echo $fieldInfo['Label']; ?></span>
				<span class="medium-size-text"><?php echo " - " . $fieldInfo['TypeName']; ?></span>
			</div>
			<div class="right">
				<a style="text-decoration: none" href="admin_edit_profiles.php?p_type=<?php echo $fieldInfo['profile_types_ID']; ?>">&larr; Back to edit profile</a>
			</div>
			<hr class="line-separator" />
			<form class="pure-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" action="post">
				<div class="grid-row-small">
					<div class="small-size-text">Label:</div>
					<input type="text" name="fieldLabel" value="<?php echo $fieldInfo['Label'] ?>" style="width: 400px" />
				</div>
				<div class="grid-row-small">
					<div class="small-size-text">Sequence #:</div>
					<input type="text" name="fieldSeq" value="<?php echo $fieldInfo['Sequence']; ?>" style="width: 100px" />
				</div>
			</form>
		</div>
</body>