 <?php
	require_once("login_c/models/config.php");
	global $mysqli;
	$typeId = $_REQUEST['ptype'];
	$stmt = $mysqli->prepare("SELECT pf.Label, it.TypeName
								FROM input_types it, profile_fields pf
								WHERE pf.Input_Types_ID = it.ID
								AND pf.Profile_Types_ID = ?
								ORDER BY pf.Sequence ASC");
	$stmt->bind_param("i", $typeId);
	$stmt->execute();
	$stmt->bind_result($label, $type);
	while($stmt->fetch()) {
		echo formatInputField($label, $type);
	}
	$stmt->close();
 ?>