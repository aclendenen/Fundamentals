<?php
	require_once("default_includes.php");
	$people = [];
	$searchWord = "";
	$pageNum = 0;
	$peoplePerPage = 20;

	if(isset($_POST['search_button']))
	{
		$searchWord = strip_tags($_POST['searchWord']);
		if(preg_replace('/\s+/', '', $searchWord) != "")
		{
			$people = $user->searchPersonByName($searchWord, $peoplePerPage, 0);
		}
		else
		{
			$people = $user->getPeople($peoplePerPage, 0);
		}
	}
	else if(isset($_POST['prev_button']))
	{
		$searchWord = strip_tags($_POST['searchWord']);
		$pageNum = strip_tags($_POST['pageNum']);
		$pageNum -= 1;
		$offset = $pageNum * $peoplePerPage;
		if(preg_replace('/\s+/', '', $searchWord) != "")
		{
			$people = $user->searchPersonByName($searchWord,$peoplePerPage, $offset);
		}
		else
		{
			$people = $user->getPeople($peoplePerPage, $offset);
		}
		
	}
	else if(isset($_POST['next_button']))
	{
		$searchWord = strip_tags($_POST['searchWord']);
		$pageNum = strip_tags($_POST['pageNum']);
		$pageNum += 1;
		$offset = $pageNum * $peoplePerPage;
		if(preg_replace('/\s+/', '', $searchWord) != "")
		{
			$people = $user->searchPersonByName($searchWord,$peoplePerPage, $offset);
		}
		else
		{
			$people = $user->getPeople($peoplePerPage, $offset);
		}
	}
	else
	{
		$people = $user->getPeople($peoplePerPage, 0);
	}
?>
<head>
	<title>Promotion</title>
</head>	
<body>
<div class= "center_wrapper">
		<form name= "search_form" method="POST">
			<input class= "container_field center_elements" type= "text" name= "searchWord" placeholder= "Search for an Person"></input>
			<button type= "submit" id="search_btn" name= "search_button" class= "center_elements green_btn">Search</button>
		</form>
	</div>
	<div class = "center_wrapper">
		<table class="center_elements table_styling">
			<thead class= "table_header">
  				<tr>
    				<th class= "table_heading" style= "width: 40%">Name</th>
    				<th class= "table_heading" style= "width: 30%">Gender</th>
    				<th class= "table_heading" style= "width: 30%">Position</th> 
 	 			</tr>
 	 		</thead>
 	 		</tbody>
  				<?php if($people == [] || $people == false){ $peopleCount = 0;?>
  					<tr class= "table_row">
						<td>No people To Display</td>
  					</tr>
  				<?php }else{ $peopleCount = count($people);?>
  					<?php for($i=0; $i < $peopleCount; $i++) {?>
  						<tr class= "table_row">
  							<td><a id= "table_link" href= "#"><?php echo $people[$i]['first_name'];?> <?php echo $people[$i]['last_name'];?></a></td>
  							<td><a id= "table_link" href= "#"><?php echo $people[$i]['gender'];?></a></td>
  							<td><a id= "table_link" href= "#"><?php echo $people[$i]['position'];?></a></td>
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
				<button type= "submit" id="search_btn" name= "next_button" class= <?php $next = $user->nextPeopleCheck($peoplePerPage, ($pageNum + 1) * $peoplePerPage); if(!$next){ echo "'center_elements green_btn_dis'"; }else{ echo "'center_elements green_btn'"; }?> <?php if(!$next){ echo 'disabled'; } ?>>Next</button>
			</div>
		</form>
	</div>
</body>