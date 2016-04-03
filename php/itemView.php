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
		<div class="center_elements" style= "color:white">Name: <?php echo $item['name']; ?></div>
		<div class="center_elements" style= "color:white">Category: <?php echo $item['category']; if($item['category']==""){ echo "--";} ?></div>
		<div class="center_elements" style= "color:white">Supplier: <?php echo $item['supplier']; if($item['supplier']==""){ echo "--";} ?></div>
		<div class="center_elements" style= "color:white">Color: <?php echo $item['color']; if($item['color']==""){ echo "--";} ?></div>
		<div class="center_elements" style= "color:white">Dimensions: <?php echo $item['dimensions']; if($item['dimensions']==""){ echo "--";} ?></div>
		<div class="center_elements" style= "color:white">Price: <?php echo $item['price']; ?></div>
		<div class="center_elements" style= "color:white">In Stock: <?php echo $item['in_stock']; ?></div>
		<form name= "add_to_cart" method="POST">
			<input type="hidden" name="itemId" value= "<?php echo $item['item_id']; ?>" /> 
			<div style= "color:white">Quantity:</div>
			<input type= "number" onkeypress="return event.charCode >= 48 && event.charCode <= 57" name= "quantity" required></input>
			<button type= "submit" id="search_btn" name= "addToCart" class="center_elements green_btn">Add to Cart</button>
		</form>
	</div>
</body>