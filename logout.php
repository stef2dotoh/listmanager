<?php
	session_start();
	
	/******************************************************
	 ** File: logout.php
	 ** Author: Stephanie M. Brown
	 ** Date: October 2013
	 ** Description: This file logs user out.
	 ******************************************************/


	$toplinks = '<a href="login.php">Sign In</a>';
	
	if (isset($_SESSION))
	{
		$_SESSION = array();
		
		if (ini_get("session.use_cookies"))
		{
			$params = session_get_cookie_params;
			setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);	
		}
		
		session_destroy();
		
		header ('Location: login.php');
	}
?>