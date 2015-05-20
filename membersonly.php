<?php
	session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>List Manager - Members Only</title>
    <link rel="stylesheet" href="styles/styles.css">
</head>

<body>
    <header>
    	<div id="pagetop">
			<div id="sitename">List Manager</div>
            <div id="menu"><?php echo $toplinks; ?></div>
        </div>
    </header>
    
    <div id="main_content">
    	<h1>Members Only</h1>
        <p>Sorry, this is a members only area<br>
		You must be logged in to view.        
        <p>Please <a href="login.php">log in</a> or <a href="register.php">register</a>.<br>
</div>
</body>
</html>