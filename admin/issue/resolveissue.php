<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

require_once '../../framework/Connection.php';
//if(!isset($_SESSION))
	

// opening db connection
$db = new Connection();
$conn = $db->connect();
//print_r($_POST);
//print_r($_POST);
$id= $_POST['id'];
$solution = $_POST['solution'];
$user = $_SESSION['user']['id'];	
$state = "closed";

$fgDate = $db->getTimeNow();

//add user
$issue = "UPDATE issue SET `state` = '$state', `solution` = '$solution ', `closed_by` = '$user', `date_closed` = '$fgDate' WHERE id = '$id'";
//echo $issue;
if (mysqli_query($conn, $issue)) {
	echo "Issue Resolved!!!";
	echo "<br><br><a href='index.php'>BACK TO LIST</a>";
} else {
	echo "<br>error";
}
?>