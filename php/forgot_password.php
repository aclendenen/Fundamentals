<?php 
   
	session_start();
	require_once("class.user.php");
	$user = new USER();
	include_once("nav_bar.php"); 
   


	if($user->is_loggedin()!="")
	{
		$user->redirect('home.php');
	}

	if(isset($_POST['email_button']))
	{
		$email = strip_tags($_POST['send_email']);

			try
			{
				$stmt = $user->runQuery("SELECT email FROM users WHERE email=:email");
				$stmt->execute(array(':email'=>$email));
				$row=$stmt->fetch(PDO::FETCH_ASSOC);
	   
				if($row['email']!=$email) 
				{
					$user->redirect_with_flash("index.php", "Sorry email doesn't match any account");
				}
				else
				{
						if($user->new_email_code($email))
						{
							
							$email_code = $user->get_email_code($email);
							$to      = $email; // Send email to our user
							$subject = 'Password reset'; // Give the email a subject 
							$message = '

							You have selected to reset you password. Click on the link to create a new password.
							http://localhost/Fundamentals/php/password_reset.php?email='.$email.'&email_code='.$email_code.'

							'; // Our message above including the link
				 
							$headers = 'From:noreply@localhost.com' . "\r\n"; // Set from headers
							if(mail($to, $subject, $message, $headers))
							{
								$user->redirect_with_flash("index.php", "You have been sent an email to reset you password");	
							}
							else
							{
								$user->redirect_with_flash("index.php", "Something went wrong, email couldn't be sent!");	
							}
						}
						else
						{
							$user->redirect_with_flash("index.php", "Something went wrong, email couldn't be sent");
						}
						
				}
			}
			catch(PDOException $e)
			{
				$user->redirect_with_flash("index.php", "Sorry something went wrong!");
				//echo $e->getMessage();
			}
		   
	}
   
?>
<head>
	<title>Forgot_password</title>
</head>
<body>
	<div id= "signup_container" class= "center_wrapper">
		<div class= "container_head center_elements">
			<div class= "head_title center_elements">Email Verify</div>
		</div>
		<form name= "email_form" method="POST">
			<div class= "container_body center_elements">
				<input class= "container_field center_elements" type= "email" name= "send_email" placeholder= "Email" required></input> 
			</div>
			<div class= "container_footer center_elements">
				<button type= "submit" id="signup_btn" name= "email_button" class= "center_elements green_btn">Send Email</button>
			</div>
		</form>
	<div>
</body>