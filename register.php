<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>List Manager - Register</title>
    <link rel="stylesheet" href="styles/styles.css">
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery.validate.js"></script>
    <script src="js/jquery-migrate.min.js"></script>
    <script>
		$(document).ready(function() {
			$("#reg_form").validate();
		});
	</script>
</head>

<body>
    <header>
    	<div id="pagetop">
			<div id="sitename">List Manager</div>
            <div id="menu"><?php echo $toplinks; ?></div>
        </div>
    </header>

    <div id="main_content">
        <h1>Register</h1>
            <form id="reg_form" action="register.php" method="post">
                Name<br> <input name="name" type="text" class="required" id="name" size="50" maxlength="20" value="<?php if (isset($_POST['name'])) echo $_POST['name'] ?>"><br>
                Username<br> <input name="username" type="text" class="required" id="username" size="50" value="<?php if (isset($_POST['username'])) echo $_POST['username'] ?>"><br>
                Password<br> <input name="password" type="password" class="required" id="password" size="50"><br>
                Email<span id="emailstatus"></span><br> <input name="email" type="text" class="required" id="email" size="50" value="<?php if (isset($_POST['email'])) echo $_POST['email'] ?>"><br><br>
                <input type="submit" name="submit" id="submit" value="Register">
            </form>
</div>
</body>
</html>

<?php
	session_start();
	
	// Set top nav
	$toplinks = '<a href="login.php">Sign In</a>';
	
	// If form was submitted...
	if (isset($_POST['submit']))
	{
		// Connect to database
		require_once ('includes/mysqli_connect.php');
        //$mysqli = dbConnect("listmanager");
		
		$email = $_POST['email'];
		$email = $mysqli->real_escape_string($email);

		// Check email before insert to make sure it's not a duplicate
		$select = "SELECT email FROM users WHERE email='$email'" ;
		$checkEmail = $mysqli->prepare($select);
		$checkEmail->execute();
		$checkEmail->bind_result($e);
		$checkEmail->store_result();
				
		$numrows = $checkEmail->num_rows();
		 
		if ($numrows > 0) // Email exists already
			// header ('Location: register.php');
		{
?>
			<script>
				$("#emailstatus").addClass('error').html(" Email exists.");
			</script>
<?php
		} else {	
			$name = $_POST['name'];
			$username = $_POST['username'];
			$password = $_POST['password'];

			$name = stripslashes($name);
			$username = stripslashes($username);
			$password = stripslashes($password);
					
			$name = $mysqli->real_escape_string($name);
			$username = $mysqli->real_escape_string($username);
			$password = $mysqli->real_escape_string($password);
		
			
			// Hash password
			$hash = hash('sha256', $password);
			
			//Generates 3 character sequence for salt
			function createSalt()
			{
				$string = md5(uniqid(rand(), true));
				return substr($string, 0, 3);
			}
		
			$salt = createSalt();
			$hash = hash('sha256', $salt . $hash);

			$insert = "INSERT INTO users (name, username, password, salt, email) VALUES (?,?,?,?,?)";
			if(!($result = $mysqli->prepare($insert)))
				echo "Prepare failed " . $result->errno . " " . $result->error;
				
			if(!$result->bind_param('sssss', $name, $username, $hash, $salt, $email))
				echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
				
			if(!$result->execute())
				echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;	
			else {
?>
				<script>
                   	window.location.href = "login.php";
				</script>
<?php
			}
			// Send confirmation e-mail to sender
			$body1 = "Dear {$_POST['name']},\n\nWelcome to To-Do List! Here are your login credentials.  Please keep this information in a safe place.\n\nUsername: {$_POST['username']}\n\nPassword: {$_POST['password']}\n\nSincerely,\n\n[Your signature here]\nMyTVDB";
			$body1 = stripslashes($body1);
			mail ($_POST['email'], 'Thank you for your e-mail!', $body1, 'From: admin@yourdomain.com');
		
			// Send e-mail to admin
			$body2 = "{$_POST['name']} at {$_POST['email']} has joined To-Do List!\n\n";
			$body2 = stripslashes($body2);
			$subject = "New To-Do List User Account Created";
			mail ('admin@yourdomain.com', $subject, $body2, 'From: admin@yourdomain.com');
			
			// Quit script
			exit();

			$insert->close();
			$mysqli->close();
				
		} // endif execute	
	}
		
?>