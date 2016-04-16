<?php 
   
	session_start();
	require_once("class.user.php");
	$user = new USER();
	include_once("nav_bar.php"); 
	
   if($user->is_loggedin()!="")
	{
		
	}
	else{
		$user ->redirect_with_flash("index.php", "Must be signed in to view this page");
	}
	if(isset($_POST['changes_button']))
	{
		$fname = strip_tags($_POST['signup_fn']);
		$lname = strip_tags($_POST['signup_ln']);
		$gender = strip_tags($_POST['gender']);
		$dob = strip_tags($_POST['dob']);
		$pos = strip_tags($_POST['signup_position']);
		$pos_code = strip_tags($_POST['signup_position_id']);
		$address = strip_tags($_POST['signup_address']);	

		if($fname=="")	
		{	
			$user->redirect_with_flash("edit_info.php", "Please enter a first name");
		}
		else if($lname=="")	
		{
			$user->redirect_with_flash("edit_info.php", "Please enter a last name");
		}
		else if($pos=="")	
		{	
			$user->redirect_with_flash("edit_info.php", "Please select a posistion");
		}
		else if($dob=="")
		{
			$user->redirect_with_flash("edit_info.php", "Please enter a correct Date.");
		}
		else if($pos!="User" && !$user->pos_code_check($pos, $pos_code))	
		{
			   
			//$m = $user->pos_code_check($pos, $posId);
			//$user->redirect_with_flash("index.php", $m);
			$user->redirect_with_flash("edit_info.php", "The position type is incorrect for the Id given.");
		}
		else if ($address = "")
		{
			$user->redirect_with_flash("edit_info.php", "Please input an address");
		}
		else if($user->saveChanges($fname,$lname,$pos,$gender,$dob,$address))
		{
			$user->redirect_with_flash("home.php", "Your changes have been saved.");
		}
		else
		{
			$user->redirect_with_flash("home.php", "Something went wrong. Changes were not saved.");
		}
	}
?>

<head>
	<title>Login_Signup</title>
</head>
<body>
	<div id= "signup_container" class= "center_wrapper">
		<div class= "container_head center_elements">
			<div class= "head_title center_elements">Edit Information</div>
		</div>
		<form name= "register_form" method="POST">
			<div class= "container_body center_elements">
				<input class= "container_field center_elements" type= "text" name= "signup_fn" placeholder= "First Name" required></input>
				<input class= "container_field center_elements" type= "text" name= "signup_ln" placeholder= "Last Name" required></input>
				<div>
					<input id = "gender_radio" type = "radio" name = "gender" value = "male" checked> Male<br>
					<input type = "radio" name = "gender" value = "female"> Female<br>
				</div>
				<div class= "container_field center_elements">Date of Birth</div>
				<input class= "container_field center_elements" type= "date" name= "dob" required></input>
				<select id= "positionDrop" class= "container_field center_elements" type= "text" name= "signup_position" required>
					<option value="" disabled selected>Select a position</option>
					<option id= "adminDrop" value="Administrator">Administrator</option>
					<option id= "managerDrop" value="Manager">Manager</option>
					<option id= "UserDrop" value="User">User</option>
				</select>
				<input id= "positionId" class= "container_field center_elements" type= "text" name= "signup_position_id" placeholder= "Id" required></input>
				<input class= "container_field center_elements" type= "address" name= "signup_address" placeholder= "Address" required></input>  
			</div>
			<div class= "container_footer center_elements">
				<button type= "submit" id="signup_btn" name= "changes_button" class= "center_elements green_btn">Save Changes</button>
			</div>
		</form>
	<div>
</body>