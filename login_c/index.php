<!doctype html>
<?php
	require_once("models/config.php");
	if (isUserLoggedIn()) {
		header("Location: ../"); die();
	}
?>
<html lang="en">
<head>
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="A layout example that shows off a responsive product landing page.">

    <title>Cyripe</title>

    


<link rel="stylesheet" href="../styles/pure-min.css">



<!--[if lte IE 8]>
  
    <link rel="stylesheet" href="http://yui.yahooapis.com/pure//grids-responsive-old-ie.css">
  
<![endif]-->
<!--[if gt IE 8]><!-->
  
    <link rel="stylesheet" href="http://yui.yahooapis.com/pure//grids-responsive.css">
  
<!--<![endif]-->

    <!--[if lte IE 8]>
        <link rel="stylesheet" href="css/layouts/marketing-old-ie.css">
    <![endif]-->
    <!--[if gt IE 8]><!-->
        <link rel="stylesheet" href="../styles/marketing.css">
    <!--<![endif]-->

</head>
<body>

<div class="splash-container">
    <div class="splash">
        <h1 class="splash-head">Cyripe</h1>
        <p class="splash-subhead">
            Extreme personalization, possible
        </p>
        <p>
            <a href="register.php" class="pure-button pure-button-primary">Register</a>
			<a href="login.php" class="pure-button pure-button-primary">Sign In</a>
        </p>
    </div>
</div>
</body>
</html>
