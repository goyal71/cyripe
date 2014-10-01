 <?php
	require_once("login_c/models/config.php");
	global $mysqli;
	$typeId = $_REQUEST['ptype'];
	$stmt = $mysqli->prepare("SELECT pf.Id, pf.Label, it.TypeName
								FROM input_types it, profile_fields pf
								WHERE pf.Input_Types_ID = it.ID
								AND pf.Profile_Types_ID = ?
								ORDER BY pf.Sequence ASC");
	$stmt->bind_param("i", $typeId);
	$stmt->execute();
	$stmt->bind_result($fieldId, $label, $type);
	$fields = array();
	while($stmt->fetch()) {
		$fields[] = array('id' => $fieldId, 'label' => $label, 'type' => $type);
	}
	$stmt->close();
	foreach($fields as $field) {
		echo formatInputField($field['label'], $field['type'], $field['id']);
	}
 ?>