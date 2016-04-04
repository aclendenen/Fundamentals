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
<body>
	<div id= "addItem_container" class= "center_wrapper">
		<div class= "container_head center_elements">
			<div class= "head_title center_elements">Add Item</div>
		</div>
		<form name= "addItem_form" method="POST">
		   <div class= "container_body center_elements">
		      <input class= "med_field inline_rt nav_element" type= "text" name= "itemName" placeholder= "Item Name" required></input><br>
		      <input class= "med_field inline_rt nav_element" type= "text" name= "itemCategory" placeholder= "Category" required></input><br> 
		      <input class= "med_field inline_rt nav_element" type= "text" name= "itemSupplier" placeholder= "Supplier" required></input><br>
		      <input class= "med_field inline_rt nav_element" type= "text" name= "itemColor" placeholder= "Color"></input><br>
		      <input class= "med_field inline_rt nav_element" type= "text" name= "itemDimensions" placeholder= "Dimensions"></input><br>
		      <input class= "med_field inline_rt nav_element" type= "number" min="0" name= "itemPrice" placeholder= "Price" required></input><br>
		      <input class= "med_field inline_rt nav_element" type= "number" min="0" step="1" name= "itemStock" placeholder= "Amount in Stock" required></input><br>
		      <input class= "med_field inline_rt nav_element" type= "text" name="itemDescription" placeholder="Item Description" required></input><br>
		   </div>
		<div class= "container_footer center_elements">
			<button type= "submit" id="addItem_button" name="addItem_button" class= "center_elements green_btn">Add Item</button>
		</div>
		</form>
	<div>
</body>