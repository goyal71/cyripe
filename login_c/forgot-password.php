<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

//User has confirmed they want their password changed 
if(!empty($_GET["confirm"]))
{
	$token = trim($_GET["confirm"]);
	
	if($token == "" || !validateActivationToken($token,TRUE))
	{
		$errors[] = lang("FORGOTPASS_INVALID_TOKEN");
	}
	else
	{
		$rand_pass = getUniqueCode(15); //Get unique code
		$secure_pass = generateHash($rand_pass); //Generate random hash
		$userdetails = fetchUserDetails(NULL,$token); //Fetchs user details
		$mail = new userCakeMail();		
		
		//Setup our custom hooks
		$hooks = array(
			"searchStrs" => array("#GENERATED-PASS#","#USERNAME#"),
			"subjectStrs" => array($rand_pass,$userdetails["display_name"])
			);
		
		if(!$mail->newTemplateMsg("your-lost-password.txt",$hooks))
		{
			$errors[] = lang("MAIL_TEMPLATE_BUILD_ERROR");
		}
		else
		{	
			if(!$mail->sendMail($userdetails["email"],"Your new password"))
			{
				$errors[] = lang("MAIL_ERROR");
			}
			else
			{
				if(!updatePasswordFromToken($secure_pass,$token))
				{
					$errors[] = lang("SQL_ERROR");
				}
				else
				{	
					if(!flagLostPasswordRequest($userdetails["user_name"],0))
					{
						$errors[] = lang("SQL_ERROR");
					}
					else {
						$successes[]  = lang("FORGOTPASS_NEW_PASS_EMAIL");
					}
				}
			}
		}
	}
}

//User has denied this request
if(!empty($_GET["deny"]))
{
	$token = trim($_GET["deny"]);
	
	if($token == "" || !validateActivationToken($token,TRUE))
	{
		$errors[] = lang("FORGOTPASS_INVALID_TOKEN");
	}
	else
	{
		
		$userdetails = fetchUserDetails(NULL,$token);
		
		if(!flagLostPasswordRequest($userdetails["user_name"],0))
		{
			$errors[] = lang("SQL_ERROR");
		}
		else {
			$successes[] = lang("FORGOTPASS_REQUEST_CANNED");
		}
	}
}

//Forms posted
if(!empty($_POST))
{
	$email = $_POST["email"];
	$username = sanitize($_POST["username"]);
	
	//Perform some validation
	//Feel free to edit / change as required
	
	if(trim($email) == "")
	{
		$errors[] = lang("ACCOUNT_SPECIFY_EMAIL");
	}
	//Check to ensure email is in the correct format / in the db
	else if(!isValidEmail($email) || !emailExists($email))
	{
		$errors[] = lang("ACCOUNT_INVALID_EMAIL");
	}
	
	if(trim($username) == "")
	{
		$errors[] = lang("ACCOUNT_SPECIFY_USERNAME");
	}
	else if(!usernameExists($username))
	{
		$errors[] = lang("ACCOUNT_INVALID_USERNAME");
	}
	
	if(count($errors) == 0)
	{
		
		//Check that the username / email are associated to the same account
		if(!emailUsernameLinked($email,$username))
		{
			$errors[] =  lang("ACCOUNT_USER_OR_EMAIL_INVALID");
		}
		else
		{
			//Check if the user has any outstanding lost password requests
			$userdetails = fetchUserDetails($username);
			if($userdetails["lost_password_request"] == 1)
			{
				$errors[] = lang("FORGOTPASS_REQUEST_EXISTS");
			}
			else
			{
				//Email the user asking to confirm this change password request
				//We can use the template builder here
				
				//We use the activation token again for the url key it gets regenerated everytime it's used.
				
				$mail = new userCakeMail();
				$confirm_url = lang("CONFIRM")."\n".$websiteUrl."forgot-password.php?confirm=".$userdetails["activation_token"];
				$deny_url = lang("DENY")."\n".$websiteUrl."forgot-password.php?deny=".$userdetails["activation_token"];
				
				//Setup our custom hooks
				$hooks = array(
					"searchStrs" => array("#CONFIRM-URL#","#DENY-URL#","#USERNAME#"),
					"subjectStrs" => array($confirm_url,$deny_url,$userdetails["user_name"])
					);
				
				if(!$mail->newTemplateMsg("lost-password-request.txt",$hooks))
				{
					$errors[] = lang("MAIL_TEMPLATE_BUILD_ERROR");
				}
				else
				{
					if(!$mail->sendMail($userdetails["email"],"Lost password request"))
					{
						$errors[] = lang("MAIL_ERROR");
					}
					else
					{
						//Update the DB to show this account has an outstanding request
						if(!flagLostPasswordRequest($userdetails["user_name"],1))
						{
							$errors[] = lang("SQL_ERROR");
						}
						else {
							
							$successes[] = lang("FORGOTPASS_REQUEST_SUCCESS");
						}
					}
				}
			}
		}
	}
}

require_once("models/header.php");
?>

<body class="login-background">
	<script>
		$(document).ready(function() {
			if (window.innerWidth < 1250) {
				$(".splash-head").hide();
				$("#forgotPasswordFormContainer").attr("class", "pure-u-1");
			}
		});
		
		$(window).resize(function() {
			if (window.innerWidth < 1250) {
				$(".splash-head").hide();
				$("#forgotPasswordFormContainer").attr("class", "pure-u-1");
			} else {
				$(".splash-head").show();
				$("#forgotPasswordFormContainer").attr("class", "pure-u-1-2");
			}
		});
	</script>
	<div class="login-header"></div>
	<div class="login-main header-shadow">
		<?php echo resultBlock($errors, $successes) ?>
		<div class="pure-g">
			<div class="pure-u-1-2">
				<h1 class="splash-head">Cyripe</h1>
			</div>
			<div id="forgotPasswordFormContainer" class="pure-u-1-2">
				<form name='newLostPass' class="pure-form" action='<?php $_SERVER['PHP_SELF'] ?>' method='post'>
					<legend>Forgot Password</legend>
					<fieldset class="pure-group">
						<input type='text' class="pure-input-2-3" autocomplete="off" placeholder="Username" name='username' />
						<input type='text' class="pure-input-2-3" autocomplete="off" placeholder="Email" name='email' />
					</fieldset>
					<input type='submit' class="pure-button pure-input-1-3 pure-button-primary" value='Submit' class='submit' />
				</form>
			</div>
		</div>
	</div>
</body>
</html>