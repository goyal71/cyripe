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
				
				setTimeout(function(){
					$('.save-message').fadeOut();
				}, 2500);
			});
		</script>
		<div id="page-filler"></div>
		<div class="header">
			<?php $selectedHeader = 'home'; include("account_menu_header.php"); ?>
			<?php 
				if (@$_GET['new_profile_saved'] == 'true') {
					echo "<div class='save-message successful-save-message'>Profile was created successfully.</div>";
				} elseif (@$_GET['new_profile_saved'] == 'false') {
					echo "<div class='save-message error-save-message'>Error creating profile. Please try again later.</div>";
				} elseif (@$_GET['profile_updated'] == 'true') {
					echo "<div class='save-message successful-save-message'>Profile was updated successfully.</div>";
				} elseif (@$_GET['profile_updated'] == 'false') {
					echo "<div class='save-message error-save-message'>Error updating profile. Please try again later.</div>";
				} elseif (@$_GET['profile_deleted'] == 'true') {
					echo "<div class='save-message successful-save-message'>Profile was deleted successfully.</div>";
				} elseif (@$_GET['profile_deleted'] == 'false') {
					echo "<div class='save-message error-save-message'>Error deleting profile. Please try again later.</div>";
				}
			?>
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