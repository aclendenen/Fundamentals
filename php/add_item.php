<?php
	require_once("default_includes.php");
	if(isset($_POST["addItem_button"]))
	{
	  $itemName = strip_tags($_POST['itemName']);
	  $itemCategory = strip_tags($_POST['itemCategory']);
	  $itemSupplier = strip_tags($_POST['itemSupplier']);
	  $itemColor = strip_tags($_POST['itemColor']);
	  $itemDimensions = strip_tags($_POST['itemDimensions']);
	  $itemPrice = strip_tags($_POST['itemPrice']);
	  $itemStock = strip_tags($_POST['itemStock']);
	  $itemDescription = strip_tags($_POST['itemDescription']);  
	  
	  echo "Hello"
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
			Item Name: <input type= "text" name= "itemName" placeholder= "Item Name" required></input> <br> 

			Category: <input type= "text" name= "itemCategory" placeholder= "Category" required></input> <br>
		      
			Supplier: <input type= "text" name= "itemSupplier" placeholder= "Supplier" required></input> <br>
		      
			Color: <input type="text" name= "itemColor" placeholder= "Color"></input> <br>
		      
			Dimensions: <input type= "text" name= "itemDimensions" placeholder= "Dimensions"></input> <br>
		      
			Price: <input type= "number" min="0" name= "itemPrice" placeholder= "0.0" required></input> <br>
		      
			Amount in Stock: <input type= "number" min="0" step="1" name= "itemStock" placeholder= "0" required></input> <br>
		      
		        Item Description: <input type= "text"  name="itemDescription" placeholder="Item Description" required></input> <br>
		      </div>
		      
		   </div>
		<div class= "container_footer center_elements">
			<button type= "submit" id="addItem_button" name="addItem_button" class= "center_elements green_btn">Add Item</button>
		</div>
		</form>
	<div>
</body>
