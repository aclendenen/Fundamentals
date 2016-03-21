<?php
	session_start();
	require_once("class.user.php");
	$user = new USER();
	
	if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['email_code']) && !empty($_GET['email_code']))
	{
    // Verify data
    	$email = $_GET['email'];
    	$email_code = $_GET['email_code'];
		//$email = mysql_escape_string($_GET['email']); // Set email variable
		//$hash = mysql_escape_string($_GET['email_code']); // Set hash variable
				 
		//$search = mysql_query("SELECT email, hash, active FROM users WHERE email='".$email."' AND hash='".$hash."' AND active='0'") or die(mysql_error()); 
		//$match  = mysql_num_rows($search);
                 
		if($user->verify_email($email,$email_code))
		{
			$user->redirect_with_flash("index.php", "Your email has been confirmed! You may now login!");	
		}
		else
		{
			$user->redirect_with_flash("index.php", "Sorry, your email was not confirmed!");	
		}
                 
	}
	else
	{
		// Invalid approach
		$user->redirect_with_flash("index.php", "Sorry, your email was not confirmed!");
	}
?>