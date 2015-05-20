<?php
	session_start();
			
	$tid = $_GET['tid'];
	$uid = $_SESSION['uid'];
		
	if(!(isset($_SESSION['name'])))
		header('Location: membersonly.php');
	else
	{		
		// Connect to database
		require_once ('includes/mysqli_connect.php');
        //$mysqli = dbConnect("listmanager");
		
		$delete = "DELETE FROM todo_list WHERE tid = ? AND uid = ?";
		
		if(!($result = $mysqli->prepare($delete)))
			echo "Prepare failed " . $result->errno . " " . $result->error;
			
		if(!($result->bind_param('ii',$tid,$uid))){
			echo "Bind failed: "  . $result->errno . " " . $result->error;
		}
		
		if(!$result->execute()){
			echo "Execute failed: "  . $result->errno . " " . $result->error;
		} else {
?>
		<script>
			window.location.href = document.referrer;
		</script>
<?php
		}
	}
?>