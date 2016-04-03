<?php
	require_once("default_includes.php");
	$items = [];
	$searchWord = "";
	$pageNum = 0;
	$itemsPerPage = 20;
	
	if(isset($_POST['search_button']))
	{
		$searchWord = strip_tags($_POST['searchWord']);
		if(preg_replace('/\s+/', '', $searchWord) != "")
		{
			$items = $user->searchItemByName($searchWord, $itemsPerPage, 0);
		}
		else
		{
			$items = $user->getItems($itemsPerPage, 0);
		}
	}
	else if(isset($_POST['prev_button']))
	{
		$searchWord = strip_tags($_POST['searchWord']);
		$pageNum = strip_tags($_POST['pageNum']);
		$pageNum -= 1;
		$offset = $pageNum * $itemsPerPage;
		if(preg_replace('/\s+/', '', $searchWord) != "")
		{
			$items = $user->searchItemByName($searchWord,$itemsPerPage, $offset);
		}
		else
		{
			$items = $user->getItems($itemsPerPage, $offset);
		}
		
	}
	else if(isset($_POST['next_button']))
	{
		$searchWord = strip_tags($_POST['searchWord']);
		$pageNum = strip_tags($_POST['pageNum']);
		$pageNum += 1;
		$offset = $pageNum * $itemsPerPage;
		if(preg_replace('/\s+/', '', $searchWord) != "")
		{
			$items = $user->searchItemByName($searchWord,$itemsPerPage, $offset);
		}
		else
		{
			$items = $user->getItems($itemsPerPage, $offset);
		}
	}
	else
	{
		$items = $user->getItems($itemsPerPage, 0);
	}
?>
<head>
	<title>home</title>
</head>
<body>
	<div class="center_wrapper">
		<div class="center_elements" style= "color:white">First Name: <?php echo $_SESSION['first_name']; ?></div>
		<div class="center_elements" style= "color:white">Last Name: <?php echo $_SESSION['last_name']; ?></div>
		<div class="center_elements" style= "color:white">Email: <?php echo $_SESSION['email']; ?></div>
		<div class="center_elements" style= "color:white">Position: <?php echo $_SESSION['position']; ?></div>
	</div>
	<div class= "center_wrapper">
		<form name= "search_form" method="POST">
			<input class= "container_field center_elements" type= "text" name= "searchWord" placeholder= "Search for an Item"></input>
			<button type= "submit" id="search_btn" name= "search_button" class= "center_elements green_btn">Search</button>
		</form>
	</div>
	<div class = "center_wrapper">
		<table class="center_elements table_styling">
			<thead class= "table_header">
  				<tr>
    				<th class= "table_heading" style= "width: 40%">Name</th>
    				<th class= "table_heading" style= "width: 25%">Category</th>
    				<th class= "table_heading" style= "width: 25%">Supplier</th> 
    				<th class= "table_heading">Price</th>
 	 			</tr>
 	 		</thead>
 	 		</tbody>
  				<?php if($items == [] || $items == false){ $itemsCount = 0;?>
  					<tr class= "table_row">
						<td>No Items To Display</td>
  					</tr>
  				<?php }else{ $itemsCount = count($items);?>
  					<?php for($i=0; $i < $itemsCount; $i++) { 
  						$link = "itemView.php?itemId=".$items[$i]['item_id'];?>
  						<tr class= "table_row">
  							<td><a id= "table_link" href= <?php echo $link?>><?php echo $items[$i]['name'];?></a></td>
  							<td><a id= "table_link" href= <?php echo $link?>><?php echo $items[$i]['category'];?></a></td>
  							<td><a id= "table_link" href= <?php echo $link?>><?php echo $items[$i]['supplier'];?></a></td>
  							<td><a id= "table_link" href= <?php echo $link?>>$<?php echo $items[$i]['price'];?></a></td>
  						</tr>
  					<?php } ?>
  				<?php }?>
  			<tbody>
		</table>
	</div>
	<div class= "center_wrapper">
		<form name= "prev_and_next" method="POST">
	    	<input type="hidden" name="pageNum" value= "<?php echo $pageNum; ?>" /> 
  			<input type="hidden" name="searchWord" value= "<?php echo $searchWord ?>" /> 
			<div style= "margin-top: 10px;">
				<button type= "submit" id="search_btn" name= "prev_button" class= <?php if($pageNum==0){ echo "'center_elements green_btn_dis'"; }else{ echo "'center_elements green_btn'"; }?> <?php if($pageNum==0){ echo 'disabled'; } ?> >Previous</button>
				<button type= "submit" id="search_btn" name= "next_button" class= <?php $next = $user->nextItemsCheck($itemsPerPage, ($pageNum + 1) * $itemsPerPage); if(!$next){ echo "'center_elements green_btn_dis'"; }else{ echo "'center_elements green_btn'"; }?> <?php if(!$next){ echo 'disabled'; } ?>>Next</button>
			</div>
		</form>
	</div>
</body>