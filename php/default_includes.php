<?php

	require_once("session.php");
	require_once("class.user.php");
	$user = new USER(); 
	$user_id = $_SESSION['user_session'];
	include_once("nav_bar.php"); 

?>