<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
//echo "11111";

require_once '../../framework/Connection.php';
//if(!isset($_SESSION))
	

// opening db connection
$db = new Connection();
$conn = $db->connect();

$problem = $_POST['issue'];
$user = $_SESSION['user']['id'];	

$fgDate = $db->getTimeNow();
//add user
$issue = "INSERT INTO issue (`problem`, `added_by`, `date_added`) VALUES ('$problem', '$user', '$fgDate')";
//echo $issue;
if (mysqli_query($conn, $issue)) {
	echo "Issue successfully registered. Thank You!!!";
	echo "<br><br><a href='index.php'>BACK TO LIST</a>";
} else {
	echo "error";
}
?>