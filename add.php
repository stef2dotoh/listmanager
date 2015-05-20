<?php
	session_start();
	
	/******************************************************
	 ** File: add.php
	 ** Author: Stephanie M. Brown
	 ** Date: October 2013
	 ** Description: This file adds items to the to-do list.
	 ******************************************************/

	$uid = $_SESSION['uid'];
			
	if(!(isset($_SESSION['name'])))
		header('Location: membersonly.php');
	else
	{
		$toplinks = 'Welcome, ' . $_SESSION['name'] . ' | <a href="logout.php">Sign Out</a>';
		
		// If form was submitted...
		if (isset($_POST['submit']))
		{
			// Connect to database
			require_once ('includes/mysqli_connect.php');
			
			// Add item to database
			$item = $_POST['item'];
			
			$item = stripslashes($item);
		
			$item = $mysqli->real_escape_string($item);
		
			$insert = "INSERT INTO todo_list (uid, item) VALUES (?, ?)";
			
			if(!($result = $mysqli->prepare($insert)))
				echo "Prepare failed " . $result->errno . " " . $result->error;
				
			if(!$result->bind_param('is', $uid, $item))
				echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;

			if(!$result->execute())
				echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;		
			else {
				header('Location: view-list.php');

			}
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>List Manager - Add To-do List Item</title>
    <link rel="stylesheet" href="styles/styles.css">
</head>

<body>
    <header>
    	<div id="pagetop">
			<div id="sitename"><a href="index.php">List Manager</a></div>
            <div id="menu"><?php echo $toplinks; ?></div>
        </div>
    </header>
    
    <div id="main_content">
    	<h1><?php echo $_SESSION['name'] . "'s" ?> To-Do List</h1>
        <p><a href="view-list.php">View List</a></p>
        
        <form id="add_form" action="add.php" method="post">
        	<input type="text" name="item" id="item"> <input type="submit" name="submit" id="submit" value="Add Item">
        </form>
    </div>
</body>
</html>