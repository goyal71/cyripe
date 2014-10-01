<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

//Prevent the user visiting the logged in page if he/she is already logged in
if(isUserLoggedIn()) { header("Location: account.php"); die(); }

//Forms posted
if(!empty($_POST))
{
	$errors = array();
	$email = trim($_POST["email"]);
	$username = trim($_POST["username"]);
	$displayname = trim($_POST["displayname"]);
	$password = trim($_POST["password"]);
	$confirm_pass = trim($_POST["passwordc"]);
	$captcha = md5($_POST["captcha"]);
	
	
	if ($captcha != $_SESSION['captcha'])
	{
		$errors[] = lang("CAPTCHA_FAIL");
	}
	if(minMaxRange(5,25,$username))
	{
		$errors[] = lang("ACCOUNT_USER_CHAR_LIMIT",array(5,25));
	}
	if(!ctype_alnum($username)){
		$errors[] = lang("ACCOUNT_USER_INVALID_CHARACTERS");
	}
	if(minMaxRange(2,25,$displayname))
	{
		$errors[] = lang("ACCOUNT_DISPLAY_CHAR_LIMIT",array(5,25));
	}
	if(!ctype_alnum($displayname)){
		$errors[] = lang("ACCOUNT_DISPLAY_INVALID_CHARACTERS");
	}
	if(minMaxRange(8,50,$password) && minMaxRange(8,50,$confirm_pass))
	{
		$errors[] = lang("ACCOUNT_PASS_CHAR_LIMIT",array(8,50));
	}
	else if($password != $confirm_pass)
	{
		$errors[] = lang("ACCOUNT_PASS_MISMATCH");
	}
	if(!isValidEmail($email))
	{
		$errors[] = lang("ACCOUNT_INVALID_EMAIL");
	}
	//End data validation
	if(count($errors) == 0)
	{	
		//Construct a user object
		$user = new User($username,$displayname,$password,$email);
		
		//Checking this flag tells us whether there were any errors such as possible data duplication occured
		if(!$user->status)
		{
			if($user->username_taken) $errors[] = lang("ACCOUNT_USERNAME_IN_USE",array($username));
			if($user->displayname_taken) $errors[] = lang("ACCOUNT_DISPLAYNAME_IN_USE",array($displayname));
			if($user->email_taken) 	  $errors[] = lang("ACCOUNT_EMAIL_IN_USE",array($email));		
		}
		else
		{
			//Attempt to add the user to the database, carry out finishing  tasks like emailing the user (if required)
			if(!$user->userCakeAddUser())
			{
				if($user->mail_failure) $errors[] = lang("MAIL_ERROR");
				if($user->sql_failure)  $errors[] = lang("SQL_ERROR");
			}
		}
	}
	if(count($errors) == 0) {
		$successes[] = $user->success;
	}
}

require_once("models/header.php");
?>
<body class="login-background">
	<div class="login-header"></div>
	<div class="login-main">
		<?php echo resultBlock($errors,$successes); ?>
		<div class="pure-g">
			<div class="pure-u-1-2">
				<h1 class="splash-head">Cyripe</h1>
			</div>
			<div class="pure-u-1-2">
				<form name='newUser' class="pure-form" action='<?php $_SERVER['PHP_SELF'] ?>' method='post'>
					<legend>Register</legend>
					<div class="grid-row-small"><input type='text' class="pure-input-2-3" autocomplete="off" placeholder="Username" name='username' /></div>
					<div class="grid-row-small"><input type='text' class="pure-input-2-3" autocomplete="off" placeholder="Display Name" name='displayname' /></div>
					<div class="grid-row-small"><input type='password' class="pure-input-2-3" autocomplete="off" placeholder="Password" name='password' /></div>
					<div class="grid-row-small"><input type='password' class="pure-input-2-3" autocomplete="off" placeholder="Retype Password" name='passwordc' /></div>
					<div class="grid-row-small"><input type='text' class="pure-input-2-3" autocomplete="off" placeholder="Email" name='email' /></div>
					<div class="pure-g">
						<div class="pure-u-1-3">
							<input name='captcha' class="pure-input-1" placeholder="Enter Security Code" type='text'>
						</div>
						<div class="pure-u-1-24"></div>
						<div class="pure-u-1-3">
							<img style="vertical-align: middle; height: 50px" src='models/captcha.php'>
						</div>
					</div>
					<input type='submit' class="pure-button pure-input-1-3 pure-button-primary" value='Register'/>
				</form>
			</div>
		</div>
		<div class="grid-row-small">
			<div class="pure-g">
				<div class="pure-u-1-2"></div>
				<div class="pure-u-1-2">
					<span class="medium-size-text">Already have an account? <a href='login.php'>Login here...</a></span>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
