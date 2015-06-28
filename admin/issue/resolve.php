<?php
require_once '../../framework/Connection.php';
require_once '../../framework/User.php';
if(!isset($_SESSION))
	session_start();

// opening db connection
$db = new Connection();
$conn = $db->connect();

$id = $_GET['id'];
$sql = "SELECT * FROM issue WHERE id = '$id'";
//echo "--->".$sql;
$action = mysqli_query($conn, $sql);

if (mysqli_num_rows($action) > 0) {
while($row = mysqli_fetch_assoc($action)) {
		$problem = $row['problem'];
		//array_push($states, $row['state']);
		//array_push($solutions, $row['solution']);
		//array_push($closedBy, $row['closed_by']);
		//array_push($addedBy, $row['added_by']);
		//array_push($dateAdded, $row['date_added']);
	}
}
//echo sizeof($ids)."    < size<br>";
//return $result;
?>

<html>
<head>Issue Resolution<title>FindGaddi</title></head>
<body>
	<form action="resolveissue.php" method="POST">
	Id : <?php echo $id; ?>
	<input type="text" hidden value="<?php echo $id; ?>" name='id' id='id'><br>
	<b>Problem</b> : <?php echo $problem; ?>
	<br><br>
	Solution :<br> 
	<textarea cols='150' rows='10' name='solution' id='solution'></textarea>
	
	<input type="submit" value="resolve issue">
	</form>
	<hr>
	
</body>