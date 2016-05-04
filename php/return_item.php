<?php 
   
	session_start();
	require_once("class.user.php");
	$user = new USER();
	include_once("nav_bar.php"); 
	
  
	if(isset($_POST['changes_button']))
	{
		$itemName = strip_tags($_POST['item_name']);
			

		if($itemName=="")	
		{	
			$user->redirect_with_flash("return_item.php", "Please enter an item that we carry.");
		}
		
		else if(! $row['itemName']==$itemName) 
				{
					$user->redirect_with_flash("edit_info.php", "Sorry that is not an item we carry.");
				}
		else if($user-> makeReturn($itemName))
		{
			$user->redirect_with_flash("home.php", "Your return has been made.");
		}
		else
		{
			$user->redirect_with_flash("home.php", "Something went wrong. Changes were not saved.");
		}
	}
?>

<head>
	<title>Return Item</title>
</head>
<body>
	<div id= "signup_container" class= "center_wrapper">
		<div class= "container_head center_elements">
			<div class= "head_title center_elements">Return Page</div>
		</div>
		<form name= "register_form" method="POST">
			<div class= "container_body center_elements">
				<input class= "container_field center_elements" type= "text" name= "item_name" placeholder= "Item Name" required></input>
				<div>
				</div>
				</select>
			</div>
			<div class= "container_footer center_elements">
				<button type= "submit" id="signup_btn" name= "changes_button" class= "center_elements green_btn">Make return</button>
			</div>
		</form>
	<div>
</body>