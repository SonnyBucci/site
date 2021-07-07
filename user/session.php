<?php
	session_start();
	// if user session is not active(not loggedin) this page will help 'home.php and /user/profile.php' to redirect to login page
	// put this file within secured pages that users (users can't access without login)
	if(!isset($_SESSION['user_session']))
		header("Location: ../index.php");
?>