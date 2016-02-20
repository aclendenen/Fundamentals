<!DOCTYPE html>
<html>
	<head>
		<title>Login_Signup</title>
		<?php include_once("nav_bar.php"); ?>
	</head>
	<body>
		<div id= "signup_container" class= "center_wrapper">
			<div class= "container_head center_elements">
				<div class= "head_title center_elements">Register</div>
			</div>
			<form action="signup_check.php" method="POST">
				<div class= "container_body center_elements">
					<input class= "container_field center_elements" type= "text" name= "signup_fn" placeholder= "First Name" required></input>
					<input class= "container_field center_elements" type= "text" name= "signup_ln" placeholder= "Last Name" required></input>
					<select class= "container_field center_elements" type= "text" name= "signup_position" required>
  						<option value="" disabled selected>Select a position</option>
  						<option value="Administrator">Administrator</option>
  						<option value="Manager">Manager</option>
  						<option value="User">User</option>
					</select>
					<input class= "container_field center_elements" type= "text" name= "signup_position_id" placeholder= "Id" required></input>
					<input class= "container_field center_elements" type= "email" name= "signup_email" placeholder= "Email" required></input>
					<input class= "container_field center_elements" type= "password" name= "signup_pw" placeholder= "Password" pattern=".{6,26}" required></input> 
					<input class= "container_field center_elements" type= "password" name= "signup_pw_confirm" placeholder= "Confirm Password" pattern=".{6,26}" required></input>  
				</div>
				<div class= "container_footer center_elements">
					<button type= "submit" id="signup_btn" class= "center_elements green_btn">Sign Me Up</button>
				</div>
			</form>
		<div>
    </body>
</html>