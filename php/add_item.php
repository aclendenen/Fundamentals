//this is how to set up all of our pages

<?php
	require_once("default_includes.php");
	if(isset($_POST["addItem_button"]))
	{
	 $user->redirect_with_flash("add_item.php", "Please enter a first name");
	}
?>
// note you do not need <html> tags or doc include because the nav bar takes car of that
<head> // this header merges with the navbar header
	
	<title>Add Item</title>	
</head>
<body> this will merge with the nav bar body but will be under it

	
	
	<form method="POST">  //method can be a GET or POST and there can be an action if you want to post to a different page
						  // example action        <form action= "nameOfFile.php" method="POST">
			
			//everything in-between the form is considered part of the form and its value will submit with the form
			//Label the button as type= "submit" to activate the post and name it whatever you decided to look for at the top
			
			<button type= "submit" name="addItem_button" class= "nav_btn inline_rt med_btn green_btn">Login</button>
			<input class= "med_field inline_rt nav_element" type= "text" name= "itemName" placeholder= "Item Name" required></input>
			<input class= "med_field inline_rt nav_element" type= "text" name= "itemCategory" placeholder= "Category" required></input> 
			<input class= "med_field inline_rt nav_element" type= "text" name= "itemSupplier" placeholder= "Supplier" required></input> 
			<input class= "med_field inline_rt nav_element" type= "text" name= "itemColor" placeholder= "Color"></input> 
			<input class= "med_field inline_rt nav_element" type= "text" name= "itemDimensions" placeholder= "Dimensions"></input> 
			<input class= "med_field inline_rt nav_element" type= "number" min="0" name= "itemPrice" placeholder= "Price" required></input> 
			<input class= "med_field inline_rt nav_element" type= "number" min="0" step="1" name= "itemStock" placeholder= "Amount in Stock" required></input> 
			<input class= "med_field inline_rt nav_element" type= "text" name="itemDescription" placeholder="Item Description" required></input> 
	</form>
	
	//you also have access to $user and every public method in class.user.php by calling $user->name_of_method()
	<?php
		//you have access to cookies which is info on the user    $_SESSION['attribute_name']
		//here are what we have access to 
		$_SESSION['user_session'] //user_id in database
		$_SESSION['first_name']
		$_SESSION['last_name']
		$_SESSION['position']
		$_SESSION['email']
		
		//here is an example of how to query the database
		//everything in the runQuery(  are mysql commands this says get all the attribes (aka first_name last_name...) in the user table for a user with this user_id
		$stmt = $user->runQuery("SELECT * FROM users WHERE user_id=:user_id");
		$stmt->execute(array(":user_id"=>$user_id));
		$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
		
	?>
</body>