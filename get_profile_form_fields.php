 <?php
	require_once("login_c/models/config.php");
	global $mysqli;
	if (isset($_REQUEST['p_type'])) {
		$typeId = $_REQUEST['p_type'];
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
		if (isset($_REQUEST['update']) && $_REQUEST['update'] === 'true') { 
			$isUpdating = true; 
		} else {
			$isUpdating = false;
		}
		foreach($fields as $field) {
			echo "<div class='grid-row-medium'>
					<div class='pure-g'>
						<div class='pure-u-1-3'>" . formatInputField($field['label'], $field['type'], $field['id'], $isUpdating) . "</div>
					</div>
				</div>";
		}
	}
 ?>