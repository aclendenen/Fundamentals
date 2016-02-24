<?php 
   
	session_start();
	require_once("class.user.php");
	$user = new USER();
	include_once("nav_bar.php"); 
   


	if($user->is_loggedin()!="")
	{
		$user->redirect('home.php');
	}

	if(isset($_POST['signup_button']))
	{
		$fname = strip_tags($_POST['signup_fn']);
		$lname = strip_tags($_POST['signup_ln']);
		$pos = strip_tags($_POST['signup_position']);
		$pos_code = strip_tags($_POST['signup_position_id']);
		$email = strip_tags($_POST['signup_email']);
		$pass = strip_tags($_POST['signup_pw']);
		$repass = strip_tags($_POST['signup_pw_confirm']);	

		if($fname=="")	
		{	
			$user->redirect_with_flash("index.php", "Please enter a first name");
		}
		else if($lname=="")	
		{
			$user->redirect_with_flash("index.php", "Please enter a last name");
		}
		else if($pos=="")	
		{	
			$user->redirect_with_flash("index.php", "Please select a posistion");
		}
		else if($pos!="User" && !$user->pos_code_check($pos, $pos_code))	
		{
			   
			//$m = $user->pos_code_check($pos, $posId);
			//$user->redirect_with_flash("index.php", $m);
			$user->redirect_with_flash("index.php", "The position type is incorrect for the Id given");
		}
		else if(!filter_var($email, FILTER_VALIDATE_EMAIL))	
		{
			$user->redirect_with_flash("index.php", "Please enter a valid email address");
		}
		else if($pass=="")	
		{
			$user->redirect_with_flash("index.php", "Please enter a password");
		}
		else if(strlen($pass) < 6)
		{
			$user->redirect_with_flash("index.php", "The password must 6 or more characters");	
		}
		else if($pass!=$repass)
		{
			$user->redirect_with_flash("index.php", "Please make sure your passwords match");
		}
		else
		{ 
			try
			{
				$stmt = $user->runQuery("SELECT email FROM users WHERE email=:email");
				$stmt->execute(array(':email'=>$email));
				$row=$stmt->fetch(PDO::FETCH_ASSOC);
	   
				if($row['email']==$email) 
				{
					$user->redirect_with_flash("index.php", "Sorry email is already taken");
				}
				else
				{
					if($user->register($fname,$lname,$pos,$email,$pass))
					{
						$user->redirect_with_flash("index.php", "You have successfully registered! Please LogIn!");	
					}
					else
					{
						$user->redirect_with_flash("index.php", "Sorry something went wrong");
					}
				}
			}
			catch(PDOException $e)
			{
				$user->redirect_with_flash("index.php", "Sorry something went wrong");
				//echo $e->getMessage();
			}
		}
		   
	}
   
?>
<head>
	<title>Login_Signup</title>
</head>
<body>
	<div id= "signup_container" class= "center_wrapper">
		<div class= "container_head center_elements">
			<div class= "head_title center_elements">Register</div>
		</div>
		<form name= "register_form" method="POST">
			<div class= "container_body center_elements">
				<input class= "container_field center_elements" type= "text" name= "signup_fn" placeholder= "First Name" required></input>
				<input class= "container_field center_elements" type= "text" name= "signup_ln" placeholder= "Last Name" required></input>
				<select id= "positionDrop" class= "container_field center_elements" type= "text" name= "signup_position" required>
					<option value="" disabled selected>Select a position</option>
					<option id= "adminDrop" value="Administrator">Administrator</option>
					<option id= "managerDrop" value="Manager">Manager</option>
					<option id= "UserDrop" value="User">User</option>
				</select>
				<input id= "positionId" class= "container_field center_elements" type= "text" name= "signup_position_id" placeholder= "Id" required></input>
				<input class= "container_field center_elements" type= "email" name= "signup_email" placeholder= "Email" required></input>
				<input class= "container_field center_elements" type= "password" name= "signup_pw" placeholder= "Password" pattern=".{6,26}" required></input> 
				<input class= "container_field center_elements" type= "password" name= "signup_pw_confirm" placeholder= "Confirm Password" pattern=".{6,26}" required></input>  
			</div>
			<div class= "container_footer center_elements">
				<button type= "submit" id="signup_btn" name= "signup_button" class= "center_elements green_btn">Sign Me Up</button>
			</div>
		</form>
	<div>
</body>