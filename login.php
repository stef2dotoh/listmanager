<?php
	session_start();
	
	/******************************************************
	 ** File: login.php
	 ** Author: Stephanie M. Brown
	 ** Date: October 2013
	 ** Description: This file allows user to log in.
	 ******************************************************/

		
	// If user is already logged in, go to splash page, else process login
	if (isset($_SESSION['name']))
	{
?>
		<script>
            window.location.href = "view-list.php";
        </script>
<?php
	} else
	{	
		$toplinks = 'Not a member? <a href="register.php">Register now</a>!';
		
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>List Manager - Login</title>
    <link rel="stylesheet" href="styles/styles.css">
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery.validate.js"></script>
    <script src="js/jquery-migrate.min.js"></script>
    <script>
		$(document).ready(function() {
			$("#login_form").validate();
		});
	</script>
</head>

<body>
    <header>
    	<div id="pagetop">
			<div id="sitename"><a href="index.php">List Manager</a></div>
            <div id="menu"><?php echo $toplinks; ?></div>
        </div>
    </header>
    
    <div id="main_content">
    	<h1>Log In</h1>
            <form id="login_form" action="login.php" method="post" autocomplete="off">
                username<span id="userstatus"></span><br><input name="username" type="text" id="username" autocomplete="off" value="<?php if(isset($_POST['username'])) echo $_POST['username']; ?>" size="50"><br><br>
                password<span id="pwdstatus"></span><br><input name="password" type="password" id="password" size="50"><br><br>
                <input type="submit" name="submit" value="login"> 
            </form>
    </div>
</body>
</html>

<?php
		if (isset($_POST['submit']))
		{
			// Connect to database
			require_once ('includes/mysqli_connect.php');
          	//$mysqli = dbConnect("listmanager");
				
			// Get login info
			$username = $_POST['username'];
			$password = $_POST['password'];
			
			// Protect against MySQL injection
			$username = stripslashes($username);
			$password = stripslashes($password);
			
			$username = $mysqli->real_escape_string($username);
			$password = $mysqli->real_escape_string($password);
			
			$query = "SELECT uid, name, password, salt FROM users WHERE username = '$username' LIMIT 1";
			
			if(!($result = $mysqli->prepare($query)))
				echo "Prepare failed " . $result->errno . " " . $result->error;
				
			if(!$result->execute())
				echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
			
			if(!$result->bind_result($uid, $name, $getpwd, $salt))
				echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
				
			$result->execute();
			
			$result->store_result();
				
			if ($result->num_rows() < 1) // User doesn't exist
			{
?>
			<script>
				$("#userstatus").addClass('error').html(" No such user exists.");
			</script>

<?php	
			} else {
					while ($result->fetch()) // User exists
					{						
						$hash = hash('sha256', $salt . hash('sha256', $password)); // Get salt from DB and hash user-entered password

						// Compare entered password to password in DB
						if($hash != $getpwd) // Incorrect password
						{
?>
			<script>
				$("#pwdstatus").addClass('error').html(" Password incorrect.");
			</script>

<?php	
						} else // User verified, so proceed
						{
							// Set session variables
							$_SESSION['name'] = $name;
							$_SESSION['uid'] = $uid;
?>
							<script>
                            	window.location.href = "view-list.php";
							</script>
<?php
					}
			
					// $result->close();
					
					$mysqli->close();
					}
			}
		}
	}
?>