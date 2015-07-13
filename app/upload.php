<?php

	require_once '../framework/Vehicle.php';
	require_once '../framework/Job.php';
	require_once '../framework/Notification.php';

	//print_r($_POST);
    $criteria = trim($_GET['criteria']);
	$vehicle = trim($_GET['vehicle']);
	$lattitude = trim($_GET['lattitude']);
	$longitude = trim($_GET['longitude']);
	$address = trim($_GET['address']);
    $city = trim($_GET['city']);
	
	//echo "<br>".Vehicle::getIdByNumber($vehicle)."<br>";
	
	$mVehicle = new Vehicle(Vehicle::getIdByNumber($vehicle));
	if($mVehicle->getCurrentCity() != $city){
		$vehicleId = $mVehicle->getId();
		$driver = $mVehicle->getDriver();
		Notification::addLocationNotification($driver, $vehicleId, $lattitude, $longitude, $city);
	}
	
	$mVehicle->setLocation($lattitude, $longitude, $address, $city);

	
    //not supporting Job feature now!!!
	//$mJob = new Job($mVehicle->getCurrentJob());
	//$mJob->setLocation($lattitude, $longitude);
    if($criteria == "location"){
        if($mVehicle->addTrack($lattitude, $longitude, $address)){
			echo "success";
		} else echo "fail";
    } else {
        if($mVehicle->updateDuration($lattitude, $longitude)){
			echo "success";
		} else echo "fail";
	}
?>