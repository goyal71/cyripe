<?php
	$selected = isset($selectedHeader) ? $selectedHeader : NULL;
?>
<div class="header-shadow">
	<div class="pure-g">
		<div class="pure-u-19-24">
			<div class="pure-menu pure-menu-open pure-menu-horizontal">
				<a class="pure-menu-heading" href="#"><h1 class="splash-head-logo">Cyripe</h1></a>
				<ul>
					<li <?php if($selected == 'home') { echo "class='pure-menu-selected'"; } ?>><a href="index.php">Home</a></li>
					<li <?php if($selected == 'new_profile') { echo "class='pure-menu-selected'"; } ?>><a href="new_profile.php">Create New Profile</a></li>
					<li <?php if($selected == 'edit_account') { echo "class='pure-menu-selected'"; } ?>><a href="#">Edit Account</a></li>
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