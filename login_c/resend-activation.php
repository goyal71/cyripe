<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

//Forms posted
if(!empty($_POST) && $emailActivation)
{
	$email = $_POST["email"];
	$username = $_POST["username"];
	
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
		$errors[] =  lang("ACCOUNT_SPECIFY_USERNAME");
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
			$errors[] = lang("ACCOUNT_USER_OR_EMAIL_INVALID");
		}
		else
		{
			$userdetails = fetchUserDetails($username);
			
			//See if the user's account is activation
			if($userdetails["active"]==1)
			{
				$errors[] = lang("ACCOUNT_ALREADY_ACTIVE");
			}
			else
			{
				if ($resend_activation_threshold == 0) {
					$hours_diff = 0;
				}
				else {
					$last_request = $userdetails["last_activation_request"];
					$hours_diff = round((time()-$last_request) / (3600*$resend_activation_threshold),0);
				}
				
				if($resend_activation_threshold!=0 && $hours_diff <= $resend_activation_threshold)
				{
					$errors[] = lang("ACCOUNT_LINK_ALREADY_SENT",array($resend_activation_threshold));
				}
				else
				{
					//For security create a new activation url;
					$new_activation_token = generateActivationToken();
					
					if(!updateLastActivationRequest($new_activation_token,$username,$email))
					{
						$errors[] = lang("SQL_ERROR");
					}
					else
					{
						$mail = new userCakeMail();
						
						$activation_url = $websiteUrl."login_c/activate-account.php?token=".$new_activation_token;
						
						//Setup our custom hooks
						$hooks = array(
							"searchStrs" => array("#ACTIVATION-URL","#USERNAME#"),
							"subjectStrs" => array($activation_url,$userdetails["display_name"])
							);
						
						if(!$mail->newTemplateMsg("resend-activation.txt",$hooks))
						{
							$errors[] = lang("MAIL_TEMPLATE_BUILD_ERROR");
						}
						else
						{
							if(!$mail->sendMail($userdetails["email"],"Activate your ".$websiteName." Account"))
							{
								$errors[] = lang("MAIL_ERROR");
							}
							else
							{
								//Success, user details have been updated in the db now mail this information out.
								$successes[] = lang("ACCOUNT_NEW_ACTIVATION_SENT");
							}
						}
					}
				}
			}
		}
	}
}

//Prevent the user visiting the logged in page if he/she is already logged in
if(isUserLoggedIn()) { header("Location: account.php"); die(); }
require_once("models/header.php");
?>

<body class="login-background">
	<script>
		$(document).ready(function() {
			if (window.innerWidth < 1250) {
				$(".splash-head").hide();
				$("#resendActivationFormContainer").attr("class", "pure-u-1");
			}
		});
		
		$(window).resize(function() {
			if (window.innerWidth < 1250) {
				$(".splash-head").hide();
				$("#resendActivationFormContainer").attr("class", "pure-u-1");
			} else {
				$(".splash-head").show();
				$("#resendActivationFormContainer").attr("class", "pure-u-1-2");
			}
		});
	</script>
	<div class="login-header"></div>
	<div class="login-main header-shadow">
		<?php echo resultBlock($errors,$successes); ?>
		<div class="pure-g">
			<div class="pure-u-1-2">
				<h1 class="splash-head">Cyripe</h1>
			</div>
			<div id="resendActivationFormContainer" class="pure-u-1-2">
				<?php
					//Show disabled if email activation not required
					if(!$emailActivation)
					{ 
						echo lang("FEATURE_DISABLED");
					}
					else
					{
						echo "<form name='resendActivation' class='pure-form' action='".$_SERVER['PHP_SELF']."' method='post'>
								<legend>Resend Activation</legend>
								<fieldset class='pure-group'>
									<input type='text' class='pure-input-2-3' autocomplete='off' placeholder='Username' name='username' />
									<input type='text' class='pure-input-2-3' autocomplete='off' placeholder='Email' name='email' />
								</fieldset>
								<input type='submit' class='pure-button pure-input-1-3 pure-button-primary' value='Submit' class='submit' />
							</form>";
					}
				?>
			</div>
		</div>
	</div>
</body>
</html>