
<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="../stylesheets/application_style.css">
		<script src="../scripts/jquery-2.2.1.min.js"></script>
		<script src="../scripts/fundamentals.js"></script>
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
		<link rel='stylesheet' type='text/css' href='//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css'>
		
	</head>
	<body id= "app_body">
		<div class = "nav_bar">
			<?php if($user->is_loggedin()==""){ ?>
			<form method="POST">
				<button type= "submit" name="login_button" class= "nav_btn inline_rt med_btn green_btn">Login</button>
				<a class= "med_field inline_rt nav_element" href= "forgot_password.php">Forgot Password</a>
				<input class= "med_field inline_rt nav_element" type= "password" name= "loginPassword" placeholder= "Password" required></input>
				<input class= "med_field inline_rt nav_element" type= "text" name= "loginEmail" placeholder= "Email" required></input> 
			</form>
			<?php }else{ ?>
			<a href= "home.php" class= "inline_lf nav_text nav_link">Home</a>
			<form method="POST">
				<button type= "submit" name="logout_button" class= "nav_btn inline_rt med_btn green_btn">Logout</button>
			</form>
			<?php if($_SESSION['position'] == "user") { ?>
				<a class= "inline_rt nav_text nav_link" href = "cart.php">Cart</a>
			<?php }elseif($_SESSION['position'] == "admin"){ ?>
				<a class= "inline_rt nav_text nav_link" href = "promotion.php">Admin</a>
			<?php } ?>
			<div class= "inline_rt nav_text"> <?php echo $_SESSION['email']; ?> </div>
			<?php } ?>
		</div>
	</body>
</html>
<?php

if(isset($_POST["login_button"]))
{
	$email = strip_tags($_POST['loginEmail']);
	$pass = strip_tags($_POST['loginPassword']);
		
	if($user->login_user($email,$pass))
	{
		$user->redirect('main.php');
		//echo "<div>login</div>";
	}
	else
	{	
		$user->redirect_with_flash("index.php", "Incorrect login information");
		//header('Location: index.php?flash_msg=Incorrect login information');
		//$user->redirect('index.php');
		//echo "<div class= \"flash_message\">Incorrect login information</div>";
		//$user->redirect('fail.php');
		//echo "<div>nope</div>";
		//$error = "Wrong Details !";
	}	
}

if(isset($_POST["logout_button"]))
{
		$user->logout_user();
		$user->redirect('index.php');
}

if(!empty($_GET['flash_msg']))
{
			$flash_msg = strip_tags($_GET['flash_msg']);
			echo "<div class= \"flash_message\">$flash_msg</div>";
}

?>