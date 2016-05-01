<?php
	require_once("default_includes.php");
	
	$itemId = strip_tags($_GET['itemId']);
	
	if(!empty($_GET['itemId']))
	{
	  $itemId = strip_tags($_GET['itemId']);
	  $item = $user->getItemById($itemId);
	  if($item == false)
	  {
	    $user->redirect('home.php');
	  }
	
	  $itemInfo = $user->getItemById($itemID);
	
	  $itemName = $itemInfo['name'];
	  $itemCategory = $itemInfo['category'];
	  $itemSupplier = $itemInfo['supplier'];
	  $itemColor = $itemInfo['color'];
	  $itemDimensions = $itemInfo['dimensions'];
	  $itemPrice = $itemInfo['price'];
	  $itemStock = $itemInfo['in_stock'];
	  $itemDescription = $itemInfo['description'];
	  $leadTime = $itemInfo['lead_time'];
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
	  $leadTime = strip_tags($_POST['lead_time']);
	  
	  //TODO: verify and "clean" data for table input
	  try
	  {
	    if( $user->updateItem($itemID,$itemName,$itemCategory,$itemSupplier,$itemColor,$itemDimensions,$itemPrice,$itemStock,$leadTime,$itemDescription) )
	    {
	      $user->redirect_with_flash("home.php","update Success!");
	    }
	    else
	    {
	    	$user->redirect_with_flash("edit_item.php", "update failure!");
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
	
	<title>Edit Item</title>	
</head>
<body>
	<div id= "editItem_container" class= "center_wrapper">
		
		<div class= "container_head center_elements">
			<div class= "head_title center_elements">Edit Item <?php echo "Hello $itemID"; ?> </div>
		</div>
		
		<form name= "edittem_form" method="POST">
		   <div class= "container_body center_elements">
			Item Name: <input type= "text" name= "itemName" placeholder= "Item Name" required> <?php echo $itemName; ?> </input> <br> 

			Category: <input type= "text" name= "itemCategory" placeholder= "Category" required><?php echo $itemCategory; ?></input> <br>
		      
			Supplier: <input type= "text" name= "itemSupplier" placeholder= "Supplier" required><?php echo $itemSupplier; ?></input> <br>
		      
			Color: <input type="text" name= "itemColor" placeholder= "Color"><?php echo $itemColor; ?></input> <br>
		      
			Dimensions: <input type= "text" name= "itemDimensions" placeholder= "Dimensions"><?php echo $itemDimensions; ?></input> <br>
			
			<select id= "leadTimeDrop" class= "container_field center_elements" type= "text" name="lead_time" required><div style= "display:inline-block" div>*</div>
					<option value="" disabled selected>Select a lead time</option>
					<option id= "fastest" value="1 to 3 days">1 to 3 days</option>
					<option id= "faster" value="3 to 6 days">3 to 6 days</option>
					<option id= "fast" value="6 to 10 days">6 to 10 days</option>
				</select>
				<br>
		      
			Price: <input type= "number" min="0" step="any" name= "itemPrice" placeholder= "0.0" required><?php echo $itemPrice; ?></input> <br>
		      
			Amount in Stock: <input type= "number" min="0" step="1" name= "itemStock" placeholder= "0" required><?php echo $itemStock; ?></input> <br>
		      
		        Item Description: <input type= "text"  name="itemDescription" placeholder="Item Description" required><?php echo $itemDescription; ?></input> <br>
		      </div>
		      
		   </div>
		<div class= "container_footer center_elements">
			<button type= "submit" id="updateItem_button" name="updateItem_button" class= "center_elements green_btn">Update Item</button>
		</div>
		</form>
	<div>
</body>
