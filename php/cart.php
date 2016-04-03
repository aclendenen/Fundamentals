<?php
	require_once("default_includes.php");
	$items = [];
	$order_confirm = false;
	if(isset($_POST['delete_button']))
	{
		$cartId = strip_tags($_POST['cartId']);
		$user->deleteCartItem($cartId);
		
	}
	else if(isset($_POST['purchaseItems']))
	{
		$order_confirm = true;
	}
	else if(isset($_POST['confirmPurchase']))
	{
		$total = strip_tags($_POST['total']);
		$confirmTotal = strip_tags($_POST['confirm_total']);
		//$userId = $_SESSION['user_session'];
		//$user->deleteCart($userId);
		//$orderId = $user->createOrder($userId);
		//$order = $user->getOrderById($orderId);
		//$user->redirect_with_flash("cart.php", $order["user_id"]);
		//$cart = $user->getCart($userId);
		//$suc = $user->editItemInStock(5,333);
		//$suc = $user->addOrderItem(1, 55, 123);
		/*for($i = 0; $i < count($cart); $i++)
		{
					if($cart[$i]["quantity"]<= $cart[$i]["in_stock"])
					{
						$success = $user->editItemInStock($cart[$i]["item_id"],$cart[$i]["in_stock"] - $cart[$i]["quantity"]);
						if($success != false)
						{
						
							$user->addOrderItem($order["order_id"], $cart[$i]["item_id"],$cart[$i]["quantity"]);
						}
						
					}
					
		}*/
		if( money_format('$%i', $total) ==  money_format('$%i', $confirmTotal))
		{
			$order = $user->orderCart($_SESSION['user_session']);
			if($order == false)
			{
				//$user->redirect_with_flash("cart.php", "Something went wrong your order was not processed");
				$user->redirect_with_flash("cart.php", $order);
			}
			else
			{
				$user->redirect_with_flash("cart.php", $order);
				//$user->redirect_with_flash("cart.php", "Thank you for your order");
			}
		}
		else
		{
			$user->redirect_with_flash("cart.php", "The total you confirmed $total did not match the cart total $confirmTotal");
		}
	}
	$items = $user->getCart($_SESSION['user_session']);
?>
<head>
	<title>cart</title>
</head>
<body>
	<div class = "center_wrapper">
		<table class="center_elements table_styling">
			<thead class= "table_header">
  				<tr>
    				<th class= "table_heading" style= "width: 30%">Name</th>
    				<th class= "table_heading" style= "width: 20%">Category</th>
    				<th class= "table_heading" style= "width: 20%">Supplier</th> 
    				<th class= "table_heading" style= "width: 10%">Quantity</th> 
    				<th class= "table_heading" style= "width: 10%">Price</th>
    				<th></th>
 	 			</tr>
 	 		</thead>
 	 		</tbody>
  				<?php if($items == [] || $items == false){ $itemsCount = 0;?>
  					<tr class= "table_row">
						<td>No Items In Your Cart</td>
  					</tr>
  				<?php }else{ $itemsCount = count($items);?>
  					<?php 
  					$total = 0;
  					for($i=0; $i < $itemsCount; $i++) { 
  						$link = "itemView.php?itemId=".$items[$i]['item_id'];
  						$total = $total + ($items[$i]['price'] * $items[$i]['quantity']);?>
  						<tr class= "table_row">
  							<td><a id= "table_link" href= <?php echo $link?>><?php echo $items[$i]['name'];?></a></td>
  							<td><a id= "table_link" href= <?php echo $link?>><?php echo $items[$i]['category'];?></a></td>
  							<td><a id= "table_link" href= <?php echo $link?>><?php echo $items[$i]['supplier'];?></a></td>
  							<td><a id= "table_link" href= <?php echo $link?>><?php echo $items[$i]['quantity'];?></a></td>
  							<td><a id= "table_link" href= <?php echo $link?>><?php echo money_format('$%i',$items[$i]['price']);?></a></td>
  							<td>
  								<form name= "deleteItem" method="POST">
  									<input type="hidden" name="cartId" value= "<?php echo $items[$i]['cart_id']; ?>" /> 
  									<button type= "submit" id="delete_btn" class="red_btn" name= "delete_button">Delete</button>
  								</form>
  							</td>
  						</tr>
  					<?php } ?>
  				<?php }?>
  			<tbody>
		</table>
	</div>
	<div class= "center_wrapper">
		<?php if(!$order_confirm && $itemsCount != 0){ ?>
			<div style = "color:white; margin-top: 10px">Total:  <?php echo money_format('$%i', $total);?></div>
			<form name= "checkout" method="POST">
				<button style = "margin-top: 10px" type= "submit" id="search_btn" name= "purchaseItems" class="center_elements green_btn">Purchase Items</button>
			</form>
		<?php }else if($itemsCount != 0){ ?>
			<form name= "checkout" method="POST">
				<input type="hidden" name="total" value= <?php echo $total;?>" />
				<div style = "color:white; margin-top: 10px">Total:  <?php echo money_format('$%i', $total);?></div>
				<input type= "number" min="1" step="any" name= "confirm_total" required></input>
				<button style = "margin-top: 10px" type= "submit" id="search_btn" name= "confirmPurchase" class="center_elements green_btn">Confirm Order</button>
			</form>		
		<?php } ?>
	</div>
</body>