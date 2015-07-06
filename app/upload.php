<?php

	require_once '../framework/Vehicle.php';
	require_once '../framework/Job.php';

	//print_r($_POST);
    $criteria = trim($_POST['criteria']);
	$vehicle = trim($_POST['vehicle']);
	$lattitude = trim($_POST['lattitude']);
	$longitude = trim($_POST['longitude']);
	$address = trim($_POST['address']);
    $city = trim($_POST['city']);
	
	//echo "<br>".Vehicle::getIdByNumber($vehicle)."<br>";
	
	$mVehicle = new Vehicle(Vehicle::getIdByNumber($vehicle));
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