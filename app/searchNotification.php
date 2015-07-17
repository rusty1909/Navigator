<?php

	require_once '../framework/Notification.php';
	//require_once 'Vehicle.php';

	//print_r($_POST);
    //$driver = trim($_GET['driver']);
	$vehicle = trim($_GET['vehicle']);
	$latitude = trim($_GET['latitude']);
	$longitude = trim($_GET['longitude']);
	$searchItem = trim($_GET['item']);
	
	$vehicleId = Vehicle::getIdByNumber($vehicle);
	
	$mVehicle = new Vehicle($vehicleId);
	$driver = $mVehicle->getDriver();
	
	if(Notification::addSearchNotification($driver, $vehicleId, $latitude, $longitude, $searchItem)){
		echo "success";
	} else{
		echo "fail";
	}
?>