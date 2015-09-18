<?php
require_once '../../framework/Order.php';


if(isset($_GET['action'])) {
	//die "q";
	$action = $_GET['action'];
} else {
	$action = "";
}

switch($action) {
	case "add" : $title = $_POST['title'];
		$client = $_POST['client'];
		$destination = $_POST['destination'];
		$description = $_POST['description'];
		if(Order::add($title, $client, $destination, $description)){
			header('Location:index.php');
		} else {
			//header('Location:abc.php');
		}
		break;
}
?>