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

<div class="content-wrapper">
    <div class="content">
        <h2 class="content-head is-center"></h2>

        <div class="pure-g">
            <div class="l-box pure-u-1 pure-u-md-1-2 pure-u-lg-1-4">

                <h3 class="content-subhead">
                    <i class="fa fa-rocket"></i>
                    
                </h3>
                
            </div>
            <div class="l-box pure-u-1 pure-u-md-1-2 pure-u-lg-1-4">
                <h3 class="content-subhead">
                    <i class="fa fa-mobile"></i>
                    
                </h3>
                
            </div>
            <div class="l-box pure-u-1 pure-u-md-1-2 pure-u-lg-1-4">
                <h3 class="content-subhead">
                    <i class="fa fa-th-large"></i>
                    
                </h3>
                
            </div>
            <div class="l-box pure-u-1 pure-u-md-1-2 pure-u-lg-1-4">
                <h3 class="content-subhead">
                    <i class="fa fa-check-square-o"></i>
                    
                </h3>
                
            </div>
        </div>
    </div>

    <div class="ribbon l-box-lrg pure-g">
        <div class="l-box-lrg is-center pure-u-1 pure-u-md-1-2 pure-u-lg-2-5">
            
        </div>
        <div class="pure-u-1 pure-u-md-1-2 pure-u-lg-3-5">

            <h2 class="content-head content-head-ribbon"></h2>
        </div>
    </div>

    <div class="content">
        <h2 class="content-head is-center"></h2>

        <div class="pure-g">
            <div class="l-box-lrg pure-u-1 pure-u-md-3-5">
                
            </div>
        </div>

    </div>

    <div class="footer l-box is-center">
        View the source of this layout to learn more. Made with love by the YUI Team.
    </div>

</div>






</body>
</html>
