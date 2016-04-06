<?php
	session_start();
	require_once("class.user.php");
	$user = new USER();
	include_once("nav_bar.php"); 
	
	if(isset($_POST['password_reset']))
	{
		$email = strip_tags($_POST['email']);
		$pass_reset = strip_tags($_POST['new_password']);
		$repass_reset = strip_tags($_POST['new_password_confirm']);
		
		if($pass_reset=="")	
		{
			$user->redirect_with_flash("index.php", "Password was not reset");
		}
		else if(strlen($pass_reset) < 6)
		{
			$user->redirect_with_flash("index.php", "Password was not reset");	
		}
		else if($pass_reset!=$repass_reset)
		{
			$user->redirect_with_flash("index.php", "Password was not reset");
		}
		else if($user->update_password($email, $pass_reset))
		{
			$user->redirect_with_flash("index.php", "Password was reset");
		}
		else
		{
			$user->redirect_with_flash("index.php", "Password was not reset");
		}
			
	}
	
	if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['email_code']) && !empty($_GET['email_code']))
	{
    // Verify data
    	$email = $_GET['email'];
    	$email_code = $_GET['email_code'];
		//$email = mysql_escape_string($_GET['email']); // Set email variable
		//$hash = mysql_escape_string($_GET['email_code']); // Set hash variable
				 
		//$search = mysql_query("SELECT email, hash, active FROM users WHERE email='".$email."' AND hash='".$hash."' AND active='0'") or die(mysql_error()); 
		//$match  = mysql_num_rows($search);
                 
		if(!$user->verify_email($email,$email_code))
		{
			$user->redirect_with_flash("index.php", "Sorry, the link could not be found");	
		}
                 
	}
	else
	{
		// Invalid approach
		$user->redirect_with_flash("index.php", "Sorry, the link could not be found");
	}
?>

<head>
	<title>Password_reset</title>
</head>
<body>
	<div id= "signup_container" class= "center_wrapper">
		<div class= "container_head center_elements">
			<div class= "head_title center_elements">Password Reset</div>
		</div>
		<form name= "password_reset" method="POST">
			<div class= "container_body center_elements">
				<input type="hidden" name="email" value = <?php echo $email;?>></input>
				<input class= "container_field center_elements" type= "password" name= "new_password" placeholder= "Password" pattern=".{6,26}" required></input> 
				<input class= "container_field center_elements" type= "password" name= "new_password_confirm" placeholder= "Confirm Password" pattern=".{6,26}" required></input>  
			</div>
			<div class= "container_footer center_elements">
				<button type= "submit" id="signup_btn" name= "password_reset" class= "center_elements green_btn">Reset Password</button>
			</div>
		</form>
	<div>
</body>