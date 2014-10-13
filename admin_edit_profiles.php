<?php
	require_once("login_c/models/config.php");
	require_once("login_c/models/header.php");
	if(!isUserLoggedIn()){ header("Location: login_c/"); die(); }
	if (!$loggedInUser->checkPermission(array(2))){ header("Location: index.php"); die(); }
?>
<body class="backlay">
	<script>

		$(document).ready(function () {
			$(".add-new-field-container").hide();
		});
		
		function validateNewField() {
			var ctr = 0;
			var msg = "Failed Save: \n";
			if($("#addNewFieldLabel").val().trim() == "") {
				msg += "- Label is required\n";
				ctr++;
			}
			if ($("#addNewFieldType").val() == "0") {
				msg += "- Type is required\n";
				ctr++;
			}
			if (ctr > 0) {
				alert(msg);
				return false;
			} else {
				return true;
			}
		}
		
		function profileTypeSelectedIndexChanged(typeId) {
			if (typeId == "0") {
				document.getElementById("profileFieldSection").innerHTML = "";
				$(".add-new-field-container").hide();
				return;
			}
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
					document.getElementById("profileFieldSection").innerHTML = xmlhttp.responseText;
					$("#addNewFieldProfileId").val(typeId);
					$("#addNewFieldLabel").val("");
					$("#addNewFieldType").val("0");
					$("#addNewFieldSeq").val("");
					$(".add-new-field-container").show();
				}
			}
			xmlhttp.open("GET", "admin_get_profile_form_fields.php?p_type=" + typeId, true);
			xmlhttp.send();
		}

	</script>
	<?php
		$successMessage = "";
		if(!empty($_POST)) {
			global $mysqli;
			if (isset($_POST['newProfileTypeName'])){
				// save profile
				$typeName = trim($_POST['newProfileTypeName']);
				if ($typeName === "") {
					$errors[] = "Profile name is required.";
				} else {
					if ($mysqli->query("INSERT INTO profile_types (DisplayName) VALUES ('$typeName')") === FALSE) {
						$successMessage = "<div class='save-message error-save-message'>Error creating profile type. Please try again later.</div>";
					} else {
						$successMessage = "<div class='save-message successful-save-message'>Profile type was created successfully.</div>";
					}
				}
			} elseif (isset($_POST['delete_field_id'])) {
				// delete profile field
				$mysqli->query("DELETE FROM user_saved_fields WHERE profile_fields_ID = {$_POST['delete_field_id']}");
				$mysqli->query("DELETE FROM profile_fields WHERE id = {$_POST['delete_field_id']}");
				
				$selectedProfileId = $_POST['delete_profile_id'];
				echo "<script>profileTypeSelectedIndexChanged($selectedProfileId);</script>";
			} elseif (isset($_POST['newFieldProfileId'])) {
				// add profile field
				$mysqli->query("INSERT INTO profile_fields (Label, input_types_ID, profile_types_ID, Sequence) 
								VALUES ('{$_POST['newFieldLabel']}', '{$_POST['newFieldType']}', '{$_POST['newFieldProfileId']}', '{$_POST['newFieldSeq']}')");
				
				$selectedProfileId = $_POST['newFieldProfileId'];
				echo "<script>profileTypeSelectedIndexChanged($selectedProfileId);</script>";
			}
		} elseif(isset($_GET['p_type'])) {
			$selectedProfileId = $_GET['p_type'];
			echo "<script>profileTypeSelectedIndexChanged($selectedProfileId);</script>";
		}
	?>

	<div class="header">
		<?php /* menu header */ $selectedHeader = 'admin'; include("account_menu_header.php"); ?>
		<?php echo $successMessage; ?>
	</div>
	<div class="main-new-profile-form">
		<?php echo resultBlock($errors,$successes); ?>
		<div class="pure-g">
			<div class="pure-u-3-5">
				<label for="profileType">Profile Type:</label>
				<div class="pure-g">
					<div class="pure-u-1-2">
						<select id="profileType" name="newProfileType" style="width: 100%;" onchange="profileTypeSelectedIndexChanged(this.value)">
							<option value="0">Select One</option>
							<?php
								$types = getProfileTypes($loggedInUser->user_id, true);
								foreach($types as $type) {
									echo "<option value='{$type['id']}' ";
									if (isset($selectedProfileId) && $selectedProfileId == $type['id']) { echo "selected"; }
									echo " >{$type['name']}</option>";
								}
							?>
						</select>
					</div>
					<div class="pure-u-1-24"></div>
					<div class="pure-u-1-6">
						<a id="addNewProfileTypeButton" class="add-new-link" href="#addNewProfileModal">Add New Profile</a>
					</div>
					<div class="pure-u-7-24"></div>
				</div>
			</div>
		</div>
		<hr class="line-separator" />
		<div id="profileFieldSection"></div>
		<div class="add-new-field-container">
			<div class="medium-size-text grid-row-medium"><u>Add New Field</u></div>
			<form name="addNewFieldForm" class="pure-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
				<input type="hidden" id="addNewFieldProfileId" name="newFieldProfileId" />
				<input id="addNewFieldLabel" type="text" name="newFieldLabel" style="width: 400px" placeholder="Label" />
				<select id="addNewFieldType" style="width: 250px" name="newFieldType">
					<option value='0' selected="selected">Select One</option>
					<?php
						$result = getFieldTypes();
						while($inputType = $result->fetch_assoc()) {
							echo "<option value='{$inputType['ID']}'>{$inputType['TypeName']}</option>";
						}
					?>
				</select>
				<input id="addNewFieldSeq" type="text" name="newFieldSeq" style="width: 100px" placeholder="Seq #" />
				<div class="grid-row-small">
					<input type="submit" onclick="if(!validateNewField()){ return false; }" class="pure-button pure-button-primary" value="Save" />
				</div>
			</form>
		</div>
		<div id="addNewProfileModal" class="addNewProfileModal">
			<div>
				<a href="#" title="Close" class="close">X</a>
				<form name="addNewProfileTypeForm" class="pure-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
					<input id="addNewProfileTypeNameField" type="text" name="newProfileTypeName" style="width: 325px;" placeholder="New Profile Name" />
					<input id="saveNewProfileType" type="submit" class="pure-button pure-button-primary" style="width: 70px;" value="Save" />
				</form>
			</div>
		</div>
	</div>
	
	<script>
		$(document).ready(function() {
			$(".save-message").delay(2500).animate({ opacity: 0 });
		});
	</script>
</body>