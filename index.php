<html>
	<head>
		<title>Cyripe</title>
		<link rel="stylesheet" href="styles/pure-min.css" />
		<link rel="stylesheet" href="styles/cyripe.css" />
		<script src="scripts/jquery-1.11.1.js"></script>
		<script src="scripts/jquery.mousewheel.min.js"></script>
		<script>
			$(document).ready(function() {
				$('html, body, *').mousewheel(function(e, delta) {
					this.scrollLeft -= (delta * 40);
					e.preventDefault();
				});
			});
		</script>
	</head>
	<body>
		<div id="page-filler"></div>
		<div class="header">
			<div class="pure-g">
				<div class="pure-u-19-24">
					<div class="pure-menu pure-menu-open pure-menu-horizontal">
						<a class="pure-menu-heading" href="#">Cyripe</a>
						<ul>
							<li><a href="#">Home</a></li>
						</ul>
					</div>
				</div>
				<div class="pure-u-5-24">
					<div class="pure-menu pure-menu-open pure-menu-horizontal">
						<ul>
							<li><a href="#">Login</a></li>
							<li><a href="#">Register</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="profile-list">
			<div class="block shopping-block">
				<img src="shopping-bag-icon.png" />
			</div>
			<div class="block"></div>
			<div class="block"></div>
			<div class="block"></div>
			<div class="block"></div>
		</div>
	</body>
</html>