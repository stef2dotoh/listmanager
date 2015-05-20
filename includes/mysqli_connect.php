<?php
	// This file sets up connection to MySQL database.

	// Connect to database
	$mysqli = mysqli_connect('localhost', 'root', 'root', 'listmanager');

	// Check connection
	if (!$mysqli || $mysqli->connect_errno)
	{
		echo "Connection error: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
		exit();
	}
?>