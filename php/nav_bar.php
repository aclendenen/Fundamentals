<head>
	<link rel="stylesheet" type="text/css" href="http://localhost/Fundamentals/stylesheets/nav_bar_style.css">
	<?php
		//require 'vendor/autoload.php';
		use Parse\ParseClient;
		use Parse\ParseUser;
		use Parse\ParseException;
		use Parse\ParseQuery;
		use Parse\ParseSessionStorage;
	
		//ParseClient::initialize('SAekzGHmZgvl8BvnQNSR9xs63f038jC2BYT12RvV', 'IGy69aabyl9lFPPeQhro3VieZB9ciAWQ3XnFYpuX', 'r8kWQh6EfS8YlMuXnHTSoTGdLKyqocjhqHrp7dii');
		
		//ParseClient::setStorage( new ParseSessionStorage() );
	
		//$currentUser = ParseUser::getCurrentUser();
	?>
</head>
<div class = "nav_bar">
	<form action="logincheck.php" method="POST">
		<button type= "submit" class= "nav_btn inline_rt med_btn green_btn">Login</button>
		<input class= "med_field inline_rt nav_element" type= "password" name= "loginPassword" placeholder= "Password" required></input>
		<input class= "med_field inline_rt nav_element" type= "text" name= "loginEmail" placeholder= "Email" required></input> 
	</form>
</div>