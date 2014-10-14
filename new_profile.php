<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.js"></script>


<script>
function suggest(inputString){
		if(inputString.length == 0) {
			$('#suggestions').fadeOut();
		} else {
			$('#Color').addClass('load');
			$.post("autosuggest.php", {queryString: ""+inputString+""}, function(data){
				if(data.length >0) {
					$('#suggestions').fadeIn();
					$('#suggestionsList').html(data);
					$('#Color').removeClass('load');
				}
			});
		}
	}

	function fill(thisValue) {
		$('#Color').val(thisValue);
		setTimeout("$('#suggestions').fadeOut();", 600);
	}
	
	function fade() {
		setTimeout("$('#suggestions').fadeOut();", 600);
	}

</script>

<?php
	require_once("login_c/models/config.php");
	require_once("login_c/models/header.php");
	if(!isUserLoggedIn()){ header("Location: login_c/"); die(); }
	
	if(!empty($_POST)) {
		// save new profile
		$successful = saveUserProfileFields($_POST['newProfileType'], false);
		$successMessage = $successful ? 'true' : 'false';
		header("Location: index.php?new_profile_saved=$successMessage");
		die();
	}
	
?>
<body class="backlay">
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
					$("<form id=\"form\" action=\"#\"><div id=\"suggest\">").insertBefore('#Color');
					$('#Color').attr('onkeyup', 'suggest(this.value);');
					$('#Color').attr('onblur', 'fade();');
					$('#Color').attr('autocomplete', 'off');
					$("<div class=\"suggestionsBox\" id=\"suggestions\" style=\"display: none;\"> <div position:absolute> <img src=\"arrow.png\" style=\"position: relative; top: -12px; left: 30px;\" alt=\"upArrow\" /><div class=\"suggestionList\" id=\"suggestionsList\"> &nbsp; </div> </div> </div> </div> </form>").insertAfter('#Color');

				}
			}
			xmlhttp.open("GET", "get_profile_form_fields.php?p_type=" + typeId, true);
			xmlhttp.send();
		}
	</script>
	<div class="header">
		<?php /* menu header */ $selectedHeader = 'new_profile'; include("account_menu_header.php"); ?>
	</div>
	<div class="main-new-profile-form">
		<form name="saveNewProfileForm" class="pure-form pure-form-stacked" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
			<fieldset>
				<div class="pure-g">
					<div class="pure-u-1-3">
						<label for="profileType">Profile Type:</label>
						<select id="profileType" name="newProfileType" style="width: 100%" onchange="profileTypeSelectedIndexChanged(this.value)">
							<option value="0">Select One</option>
							<?php
								$types = getProfileTypes($loggedInUser->user_id, false);
								foreach($types as $type) {
									echo "<option value='{$type['id']}'>{$type['name']}</option>";
								}
							?>
						</select>
					</div>
				</div>
				<hr class="line-separator" />
				<div id="profileFieldSection"></div>
				<input id="saveNewProfileButton" type="submit" class="pure-button pure-input-1-4 pure-button-primary" value="Save" />
			</fieldset>
		</form>
	</div>
</body>