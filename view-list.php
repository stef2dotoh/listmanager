<?php
	session_start();

	/******************************************************
	 ** File: view-list.php
	 ** Author: Stephanie M. Brown
	 ** Date: October 2013
	 ** Description: This file displays items in to-do list.
	 ******************************************************/
	
	$uid = $_SESSION['uid'];
	
	if(!(isset($_SESSION['name'])))
		header('Location: membersonly.php');
	else
	{
		$toplinks = 'Welcome, ' . $_SESSION['name'] . ' | <a href="logout.php">Sign Out</a>';
		
		// Connect to database
		require_once ('includes/mysqli_connect.php');
		
		$query = "SELECT tid, item FROM todo_list WHERE uid = '$uid'";
		
		if(!($result = $mysqli->prepare($query)))
			echo "Prepare failed " . $result->errno . " " . $result->error;
			
		if(!$result->execute())
			echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
		
		if(!$result->bind_result($tid, $item))
			echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
			
		$result->execute();
		$result->store_result();
?>		

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>List Manager - My To-do List</title>
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
        <p><a href="add.php">Add Item</a></p>
        <div id="todo_list">
        	<ul>
<?php		
			while($result->fetch())
			{
				echo '<li>' . htmlspecialchars($item) . '&nbsp;&nbsp;&nbsp;' . '<a href="remove.php?tid=' . htmlspecialchars($tid) . '">Remove</a></li>';
			}
?>		
			</ul>
        </div>
<?php
	}
?>
    </div>
</body>
</html>