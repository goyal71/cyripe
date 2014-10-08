<?php
	$selected = isset($selectedHeader) ? $selectedHeader : NULL;
?>
<script>
	$(document).ready(function(){
		if (window.innerWidth < 900) {
			$('.pure-menu-heading').hide();
			$('.header-welcome-message').hide();
		}
	});
	
	$(window).resize(function(){
		if (window.innerWidth < 900) {
			$('.pure-menu-heading').hide();
			$('.header-welcome-message').hide();
		} else {
			$('.pure-menu-heading').show();
			$('.header-welcome-message').show();
		}
	});
</script>
<div class="header-shadow">
	<div class="pure-g">
		<div class="pure-u-3-4">
			<div class="pure-menu pure-menu-open pure-menu-horizontal">
				<a class="pure-menu-heading" href="#"><h1 class="splash-head-logo">Cyripe</h1></a>
				<ul>
					<li <?php if($selected == 'home') { echo "class='pure-menu-selected'"; } ?>><a href="index.php">Home</a></li>
					<li <?php if($selected == 'new_profile') { echo "class='pure-menu-selected'"; } ?>><a href="new_profile.php">Create New Profile</a></li>
					<li <?php if($selected == 'edit_account') { echo "class='pure-menu-selected'"; } ?>><a href="#">Edit Account</a></li>
					<?php
						if ($loggedInUser->checkPermission(array(2))) {
							$admin_link = "<li ";
							if ($selected == 'admin') {
								$admin_link .= "class='pure-menu-selected'";
							}
							$admin_link .= "><a href='login_c/account.php'>Admin</a></li>";
							echo $admin_link;
						}
					?>
				</ul>
			</div>
		</div>
		<div class="pure-u-1-4">
			<div class="right">
			<div class="pure-menu pure-menu-open pure-menu-horizontal">
				<ul>
					<li class="header-welcome-message">Welcome, <?php echo $loggedInUser->displayname; ?>!</li>
					<li><a href="login_c/logout.php">Logout</a></li>
				</ul>
			</div>
			</div>
		</div>
	</div>
</div>