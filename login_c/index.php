<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
require_once("models/header.php");

echo "
<body>
<div id='wrapper'>
<div id='top'><div id='logo'></div></div>
<div id='content'>
<h1>Cyripe 1.0</h1>
<h2>Welcome</h2>
<div id='left-nav'>";
include("left-nav.php");

echo "
</div>
<div id='main'>
<p>Welcome to Cyripe </p>
</div>
<div id='bottom'></div>
</div>
</body>
</html>";

?>
