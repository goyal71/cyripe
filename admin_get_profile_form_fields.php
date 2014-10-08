<?php
	require_once("login_c/models/config.php");
	require_once("login_c/models/header.php");
	if(!isUserLoggedIn()){ header("Location: login_c/"); die(); }
	if (!$loggedInUser->checkPermission(array(2))){ header("Location: index.php"); die(); }
	
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
		echo "<table class='admin-table'>
				<tr>
					<th>ID</th>
					<th>Label</th>
					<th>Input Type</th>
					<th></th>
				</tr>";
		$counter = 0;
		foreach($fields as $field) {
			$altClass = $counter % 2 == 1 ? "class='alt'" : "";
			echo "<tr $altClass>
					<td>{$field['id']}</td>
					<td>{$field['label']}</td>
					<td>{$field['type']}</td>
					<td>
						<input type='submit' class='pure-button pure-button-edit' value='Edit' />
						<form style='display: inline' name='delete_profile_field_form' action='admin_edit_profiles.php' method='post'>
							<input type='hidden' name='delete_field_id' value='{$field['id']}' />
							<input type='hidden' name='delete_profile_id' value='$typeId' />
							<input type='submit' onclick='if(!confirm('Are you sure you want to delete this profile?')){ return false; };' class='pure-button pure-button-delete' value='Delete' />
						</form>
					</td>
				</tr>";
			$counter++;
		}
		echo "</table>";
	}
?>