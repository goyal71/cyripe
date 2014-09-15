<html>
	<head>
		<title>Cyripe</title>
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
		<div class="header">Static Header</div>
		<div class="profile-list">
			<div class="block"></div>
			<div class="block"></div>
			<div class="block"></div>
			<div class="block"></div>
			<div class="block"></div>
		</div>
	</body>
</html>