<?php

	require_once '../framework/Notification.php';

	//print_r($_POST);
    //$driver = trim($_GET['driver']);
	$vehicle = trim($_GET['vehicle']);
	$latitude = trim($_GET['latitude']);
	$longitude = trim($_GET['longitude']);
	$reason = trim($_GET['reason']);
	
	$vehicleId = Vehicle::getIdByNumber($vehicle);
	
	$mVehicle = new Vehicle($vehicleId);
	$driver = $mVehicle->getDriver();
	
	if(Notification::addBatteryNotification($reason, $driver, $vehicleId, $latitude, $longitude)){
		echo "success";
	} else {
		echo "fail";
	}
?>