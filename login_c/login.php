<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

//Prevent the user visiting the logged in page if he/she is already logged in
if(isUserLoggedIn()) { header("Location: ../"); die(); }

//Forms posted
if(!empty($_POST))
{
	$errors = array();
	$username = sanitize(trim($_POST["username"]));
	$password = trim($_POST["password"]);
	
	//Perform some validation
	//Feel free to edit / change as required
	if($username == "")
	{
		$errors[] = lang("ACCOUNT_SPECIFY_USERNAME");
	}
	if($password == "")
	{
		$errors[] = lang("ACCOUNT_SPECIFY_PASSWORD");
	}

	if(count($errors) == 0)
	{
		//A security note here, never tell the user which credential was incorrect
		if(!usernameExists($username))
		{
			$errors[] = lang("ACCOUNT_USER_OR_PASS_INVALID");
		}
		else
		{
			$userdetails = fetchUserDetails($username);
			//See if the user's account is activated
			if($userdetails["active"]==0)
			{
				$errors[] = lang("ACCOUNT_INACTIVE");
			}
			else
			{
				//Hash the password and use the salt from the database to compare the password.
				$entered_pass = generateHash($password,$userdetails["password"]);
				
				if($entered_pass != $userdetails["password"])
				{
					//Again, we know the password is at fault here, but lets not give away the combination incase of someone bruteforcing
					$errors[] = lang("ACCOUNT_USER_OR_PASS_INVALID");
				}
				else
				{
					//Passwords match! we're good to go'
					
					//Construct a new logged in user object
					//Transfer some db data to the session object
					$loggedInUser = new loggedInUser();
					$loggedInUser->email = $userdetails["email"];
					$loggedInUser->user_id = $userdetails["id"];
					$loggedInUser->hash_pw = $userdetails["password"];
					$loggedInUser->title = $userdetails["title"];
					$loggedInUser->displayname = $userdetails["display_name"];
					$loggedInUser->username = $userdetails["user_name"];
					
					//Update last sign in
					$loggedInUser->updateLastSignIn();
					$_SESSION["userCakeUser"] = $loggedInUser;
					
					//Redirect to user account page
					header("Location: ../");
					die();
				}
			}
		}
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
				<form name='login' class='pure-form' action='<?php echo $_SERVER['PHP_SELF'] ?>' method='post'>
					<legend>Login</legend>
					<fieldset class='pure-group'>
						<input type='text' class='pure-input-2-3' placeholder='Username' autcomplete='off' name='username' />
						<input type='password' class='pure-input-2-3' placeholder='Password' autocomplete='off' name='password' />
					</fieldset>
					<div class="grid-row-small">
						<input type='submit' class='pure-button pure-input-1-3 pure-button-primary' value='Login' />
						<div class="pure-u-1-24"></div>
						<div class="pure-u-1-3">
							<a href='forgot-password.php'>Forgot Password</a>
							<div>
								<?php
									if ($emailActivation) {
										echo "<a href='resend-activation.php'>Resend Activation Email</a>";
									}
								?>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="grid-row-medium">
			<div class="pure-g">
				<div class="pure-u-1-2"></div>
				<div class="pure-u-1-2">
					<span class="medium-size-text">Don't have an account? <a href='register.php'>Register here.</a></span>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
