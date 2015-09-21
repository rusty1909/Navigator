<?php
require_once '../../../framework/Job.php';


if(isset($_GET['action'])) {
	$action = $_GET['action'];
} else {
	$action = "";
}

switch($action) {
	case "add" : $title = $_POST['title'];
		$vehicle = $_POST['vehicle'];
		$driver = $_POST['driver'];
		$start_date = $_POST['start_date'];
		$destination = $_POST['destination'];
		$description = $_POST['description'];
		
		if(Job::add($title, $vehicle, $driver, $start_date, $destination, $description)){
			header('Location:index.php');
		}
		break;
}
?>