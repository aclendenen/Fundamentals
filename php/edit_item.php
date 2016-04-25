<?php
	require_once("default_includes.php");
	
	if(isset($_POST["editItem_button"]) )
	{
	  $itemID = strip_tags($_POST['itemID']);
	  $itemInfo = $user->getItemById($itemID);
	  
	  $itemName = $itemInfo['name'];
	  $itemCategory = $itemInfo['category'];
	  $itemSupplier = $itemInfo['supplier'];
	  $itemColor = $itemInfo['color'];
	  $itemDimensions = $itemInfo['dimensions'];
	  $itemPrice = $itemInfo['price'];
	  $itemStock = $itemInfo['in_stock'];
	  $itemDescription = $itemInfo['description'];
	  $lead_time = $itemInfo['lead_time'];
	
	}
	if(isset($_POST["updateItem_button"]))
	{
	  //TODO: handle stripping, and conversion better
	  
	  $itemName = strip_tags($_POST['itemName']);
	  $itemCategory = strip_tags($_POST['itemCategory']);
	  $itemSupplier = strip_tags($_POST['itemSupplier']);
	  $itemColor = strip_tags($_POST['itemColor']);
	  $itemDimensions = strip_tags($_POST['itemDimensions']);
	  $itemPrice = strip_tags($_POST['itemPrice']);
	  $itemStock = strip_tags($_POST['itemStock']);
	  $itemDescription = strip_tags($_POST['itemDescription']);
	  $lead_time = strip_tages($_POST['lead_time']);
	  
	  //TODO: verify and "clean" data for table input
	  try
	  {
	    if( $user->updateItem($itemID,$itemName,$itemCategory,$itemSupplier,$itemColor,$itemDimensions,$itemPrice,$itemStock,$lead_time,$itemDescription) )
	    {
	      $user->redirect_with_flash("add_item.php","update Success!");
	    }
	    else
	    {
	    	$user->redirect_with_flash("add_item.php", "update failure!");
	    }
	  }
	  catch(PDOException $e)
	  {
	    $user->redirect_with_flash("index.php", "Sorry something went wrong!");
	    //echo $e->getMessage();
	  }
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
			Item Name: <input type= "text" name= "itemName" placeholder= "Item Name" required> <?php echo $itemName ?> </input> <br> 

			Category: <input type= "text" name= "itemCategory" placeholder= "Category" required><?php echo $itemCategory ?></input> <br>
		      
			Supplier: <input type= "text" name= "itemSupplier" placeholder= "Supplier" required><?php echo $itemSupplier ?></input> <br>
		      
			Color: <input type="text" name= "itemColor" placeholder= "Color"><?php echo $itemColor ?></input> <br>
		      
			Dimensions: <input type= "text" name= "itemDimensions" placeholder= "Dimensions"><?php echo $itemDimensions ?></input> <br>
			
			Lead Time: <br>
			<div>
				<input id = "lead_radio" type = "radio" name = "lead_time" value ="1 to 3 days" checked> 1 to 3 days<br>
				<input type = "radio" name = "lead_time" value = "3 to 6 days">3 to 6 days<br>
				<input type = "radio" name = "lead_time" value = "6 to 10 days">6 to 10 days<br>
			</div>
		      
			Price: <input type= "number" min="0" name= "itemPrice" placeholder= "0.0" required><?php echo $itemPrice ?></input> <br>
		      
			Amount in Stock: <input type= "number" min="0" step="1" name= "itemStock" placeholder= "0" required><?php echo $itemStock ?></input> <br>
		      
		        Item Description: <input type= "text"  name="itemDescription" placeholder="Item Description" required><?php echo $itemDescription ?></input> <br>
		      </div>
		      
		   </div>
		<div class= "container_footer center_elements">
			<button type= "submit" id="updateItem_button" name="updateItem_button" class= "center_elements green_btn">Update Item</button>
		</div>
		</form>
	<div>
</body>
