<?php
	session_start();
	if(isset($_SESSION['user_session']))
	{
		header("Location: ../home.php");
	}
	if(isset($_GET['logout']) && $_GET['logout']=="true")
	{
		session_destroy();
		unset($_SESSION['user_session']);
		header("Location: ../index.php");
	}
?>