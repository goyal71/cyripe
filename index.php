<?php
	require_once("login_c/models/config.php");
	require_once("login_c/models/header.php");
	if(!isUserLoggedIn()){ header("Location: login_c/"); die(); }
?>	
	<script src="scripts/jquery.mousewheel.min.js"></script>
	<script>
		$(document).ready(function() {
			$('html, body, *').mousewheel(function(e, delta) {
				this.scrollLeft -= (delta * 40);
				e.preventDefault();
			});
		});
	</script>
	<body>
		<div id="page-filler"></div>
		<div class="header">
			<div class="pure-g">
				<div class="pure-u-19-24">
					<div class="pure-menu pure-menu-open pure-menu-horizontal">
						<a class="pure-menu-heading" href="#">Cyripe</a>
						<ul>
							<li class="pure-menu-selected"><a href="#">Home</a></li>
							<li><a href="new_profile.php">Create New Profile</a></li>
							<li><a href="#">Edit Information</a></li>
						</ul>
					</div>
				</div>
				<div class="pure-u-5-24">
					<div class="pure-menu pure-menu-open pure-menu-horizontal">
						<ul>
							<li>Welcome, <?php echo $loggedInUser->displayname; ?>!</li>
							<li><a href="login_c/logout.php">Logout</a></li>
						</ul>
					</div>
				</div>
			</div>
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
									<a class='pure-button pure-button-primary' style='width: 50%'>Edit ". $profile['name'] ." Profile</a>
								</div>
							</div>";
					}
				}
			?>
		</div>
	</body>
</html>