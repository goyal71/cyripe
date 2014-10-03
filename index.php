<?php
	require_once("login_c/models/config.php");
	require_once("login_c/models/header.php");
	if(!isUserLoggedIn()){ header("Location: login_c/"); die(); }
?>	
	<body>
		<script>
			$(document).ready(function() {
				$('html, body, *').mousewheel(function(e, delta) {
					this.scrollLeft -= (delta * 40);
					e.preventDefault();
				});
			});
		</script>
		<div id="page-filler"></div>
		<div class="header">
			<?php $selectedHeader = 'home'; include("account_menu_header.php"); ?>
		</div>
		
		<div class="profile-list">
			<?php
				$profiles = getUserProfiles($loggedInUser->user_id);
				if (count($profiles) == 0) {
					echo "<div class='inset-text'>No profiles created yet.</div>";
				} else {
					foreach($profiles as $profile){
						echo "<div class='block'>
								<div class='block-image ". strtolower($profile['name']) ."-block'>
									<div class='valign-profile-img-helper'></div><img src='images/" . $profile['icon'] . "' />
								</div>
								<div class='edit-profile-button'>
									<span class='edit-profile-button-helper'></span>
									<a class='pure-button pure-button-primary' href='edit_profile.php?p_type={$profile['id']}' style='width: 50%'>Edit ". $profile['name'] ." Profile</a>
								</div>
							</div>";
					}
				}
			?>
		</div>
	</body>
</html>