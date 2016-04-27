<?php
	require_once("default_includes.php");
	
	if(isset($_POST['addToCart']))
	{
		$itemId = strip_tags($_POST['itemId']);
		$quant = strip_tags($_POST['quantity']);
		if($quant > 0)
		{
			$item = $user->getItemById($itemId);
			$exists = $user->isItemInCart($_SESSION['user_session'], $itemId);
			if($exists != false)
			{	
				$quant = $exists["quantity"] + $quant;
				if($item["in_stock"] < $quant)
				{
					$quant = $item["in_stock"];
				}
				$user->editCartItem($exists["cart_id"], $exists["quantity"] + $quant);
			}
			else
			{
				if($item["in_stock"] < $quant)
				{
					$quant = $item["in_stock"];
				} 
					$user->createCartItem($_SESSION['user_session'], $itemId, $quant);
				
			}	
		}
		$user->redirect('cart.php');
	}
	else if(!empty($_GET['itemId']))
	{
			$itemId = strip_tags($_GET['itemId']);
			$item = $user->getItemById($itemId);
			if($item == false)
			{
				$user->redirect('home.php');
			}
	}
	else
	{
		$user->redirect('home.php');
	}	
?>
<head>
	<title>itemView</title>
</head>
<body>
	<div class="center_wrapper">
		<div class = "center_elements description_container">
			<div class="center_elements description_text">Name: <?php echo $item['name']; ?></div>
			<div class="center_elements description_text">Category: <?php echo $item['category']; if($item['category']==""){ echo "--";} ?></div>
			<div class="center_elements description_text">Supplier: <?php echo $item['supplier']; if($item['supplier']==""){ echo "--";} ?></div>
			<div class="center_elements description_text">Color: <?php echo $item['color']; if($item['color']==""){ echo "--";} ?></div>
			<div class="center_elements description_text">Dimensions: <?php echo $item['dimensions']; if($item['dimensions']==""){ echo "--";} ?></div>
			<div class="center_elements description_text">Price: <?php echo $item['price']; ?></div>
			<div class="center_elements description_text">In Stock: <?php echo $item['in_stock']; ?></div>
			<div class="center_elements description_text">Description: <?php echo $item['description']; if($item['description']==""){ echo "--";}?></div>
		</div>
		<?php if($_SESSION['position'] == "user") { ?>
		<form name= "add_to_cart" method="POST" style= "margin-top:10px">
			<input type="hidden" name="itemId" value= "<?php echo $item['item_id']; ?>" /> 
			<div class= "description_white" style= "color:white">Quantity:</div>
			<input class= "qnty_input" type= "number" onkeypress="return event.charCode >= 48 && event.charCode <= 57" name= "quantity" required></input>
			<button type= "submit" id="cart_btn" name= "addToCart" class="center_elements green_btn">Add to Cart</button>
		</form>
		<?php }elseif($_SESSION['position'] == "manager") { ?>
		<!-- ***************** place button to edit item if manager-->
		<form action="edit_item.php" method="post" style= "margin-top:10px">
			<input type="hidden" name="itemId" value= "<?php echo $item['item_id']; ?>" /> 				
			<button type= "submit" id="editItem_button" name="editItem_button" class="center_elements green_btn">Add to Cart</button>
		</form>
		<?php }?>
	</div>
</body>