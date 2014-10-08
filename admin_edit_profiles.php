<body>
	<?php
		require_once("login_c/models/config.php");
		require_once("login_c/models/header.php");
		if(!isUserLoggedIn()){ header("Location: login_c/"); die(); }
		if (!$loggedInUser->checkPermission(array(2))){ header("Location: index.php"); die(); }
	?>
	<script>

		$(document).ready(function () {
			$("#saveNewProfileButton").hide();
		});
	
		function profileTypeSelectedIndexChanged(typeId) {
			if (typeId == "0") {
				document.getElementById("profileFieldSection").innerHTML = "";
				$("#saveNewProfileButton").hide();
				return;
			}
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
					document.getElementById("profileFieldSection").innerHTML = xmlhttp.responseText;
					$("#saveNewProfileButton").show();
				}
			}
			xmlhttp.open("GET", "admin_get_profile_form_fields.php?p_type=" + typeId, true);
			xmlhttp.send();
		}

	</script>
	<?php
		$successMessage = "";
		if(!empty($_POST)) {
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
				global $mysqli;
				$mysqli->query("DELETE FROM profile_fields WHERE id = {$_POST['delete_field_id']}");
				
				$deleteProfileId = $_POST['delete_profile_id'];
				echo "<script>profileTypeSelectedIndexChanged($deleteProfileId);</script>";
			}
		}
	?>

	<div id="page-filler"></div>
	<div class="header">
		<?php /* menu header */ $selectedHeader = 'admin'; include("account_menu_header.php"); ?>
		<?php echo $successMessage; ?>
		<div class="main-new-profile-form">
			<?php echo resultBlock($errors,$successes); ?>
			<form name="saveNewProfileForm" class="pure-form pure-form-stacked" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
				<fieldset>
					<div class="pure-g">
						<div class="pure-u-3-5">
							<label for="profileType">Profile Type:</label>
							<div class="pure-g">
								<div class="pure-u-1-2">
									<select id="profileType" name="newProfileType" style="width: 100%;" onchange="profileTypeSelectedIndexChanged(this.value)">
										<option value="0">Select One</option>
										<?php
											$types = getProfileTypes($loggedInUser->user_id);
											foreach($types as $type) {
												echo "<option value='{$type['id']}' ";
												if (isset($deleteProfileId) && $deleteProfileId == $type['id']) { echo "selected"; }
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
					<input id="saveNewProfileButton" type="submit" class="pure-button pure-input-1-4 pure-button-primary" value="Save" />
				</fieldset>
			</form>
			<div id="addNewProfileModal" class="addNewProfileModal">
				<div>
					<a href="#" title="Close" class="close">X</a>
					<form name="addNewProfileTypeForm" class="pure-form" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
						<input id="addNewProfileTypeNameField" type="text" name="newProfileTypeName" style="width: 325px;" placeholder="New Profile Name" />
						<input id="saveNewProfileType" type="submit" class="pure-button pure-button-primary" style="width: 70px;" value="Save" />
					</form>
				</div>
			</div>
		</div>
	</div>
	
	<script>
		$(document).ready(function() {
			$(".save-message").delay(2500).animate({ opacity: 0 });
		});
	</script>
</body>