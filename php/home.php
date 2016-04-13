<?php
	require_once("default_includes.php");
?>
<head>
	<title>home</title>
</head>
<a href="edit_info.php">Edit Profile</a>
<body>
	<div class="center_wrapper">
		<div class="center_elements" style= "color:white">First Name: <?php echo $_SESSION['first_name']; ?></div>
		<div class="center_elements" style= "color:white">Last Name: <?php echo $_SESSION['last_name']; ?></div>
		<div class="center_elements" style= "color:white">Email: <?php echo $_SESSION['email']; ?></div>
		<div class="center_elements" style= "color:white">Position: <?php echo $_SESSION['position']; ?></div>
	</div>
</body>