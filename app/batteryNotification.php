<?php

	require_once '../framework/Notification.php';

	//print_r($_POST);
    $driver = trim($_GET['driver']);
	$vehicle = trim($_GET['vehicle']);
	$latitude = trim($_GET['latitude']);
	$longitude = trim($_GET['longitude']);
	$type = trim($_GET['type']);
	
	Notification::addBatteryNotification($type, $driver, $vehicle, $latitude, $longitude);
?>