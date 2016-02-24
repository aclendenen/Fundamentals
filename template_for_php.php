//this is how to set up all of our pages

<?php
	require_once("default_includes.php");			//this file needs to be loaded first on any page that a user needs
													//to be logged in for. It sets up the session, $user and the navbar
													
	//you can also include other php for dealing with GET and POST if needed
	//-------------Example php for a get and post------------
	if(isset($_POST["Name of submit button"]))  //you could use !empty($_POST["login_button"]) not sure what is better 
	{
	 //do something
	}
?>
// note you do not need <html> tags or doc include because the nav bar takes car of that
<head> // this header merges with the navbar header
	
	<title>Sample_Page</title>  //the title isn't really necessary but is good practice
	
	//the head is where you may want to include any other files that are specific to this page such as your own styling or js
	//fundamentals.js and application_style.css are loaded for every page
	
	//-------------Example tags------------
	<link rel="stylesheet" type="text/css" href="../stylesheets/YourFileName.css">
	<script src="../scripts/YourFileName.js"></script>
	// the ../ means go back to parent directory then look so this page should be in the php fold so 
	//it will go back to the fundamentals folder then to where you direct it
</head>
<body> this will merge with the nav bar body but will be under it

	//note you can put php tags anywhere and it will work for example
	<?php if($thisVar == false){ ?>
		<div>hello</div>  //and whatever html you may want
				.
				.
				.
	<?php } ?>  //dont forget to close and use ; or it may be hard to debug
	
	//-------------Example form------------
	<form method="POST">  //method can be a GET or POST and there can be an action if you want to post to a different page
						  // example action        <form action= "nameOfFile.php" method="POST">
			
			//everything in-between the form is considered part of the form and its value will submit with the form
			//Label the button as type= "submit" to activate the post and name it whatever you decided to look for at the top
			
			<button type= "submit" name="login_button" class= "nav_btn inline_rt med_btn green_btn">Login</button>
			<input class= "med_field inline_rt nav_element" type= "password" name= "loginPassword" placeholder= "Password" required></input>
			<input class= "med_field inline_rt nav_element" type= "text" name= "loginEmail" placeholder= "Email" required></input> 
	</form>
	
	//you also have access to $user and every public method in class.user.php by calling $user->name_of_method()
	<?php
		//you have access to cookies which is info on the user    $_SESSION['attribute_name']
		//here are what we have access to 
		$_SESSION['user_session'] //user_id in database
		$_SESSION['first_name']
		$_SESSION['last_name']
		$_SESSION['position']
		$_SESSION['email']
		
		//here is an example of how to query the database
		//everything in the runQuery(  are mysql commands this says get all the attribes (aka first_name last_name...) in the user table for a user with this user_id
		$stmt = $user->runQuery("SELECT * FROM users WHERE user_id=:user_id");
		$stmt->execute(array(":user_id"=>$user_id));
		$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
		
	?>
</body>