<?php

	require_once '../framework/Vehicle.php';
	require_once '../framework/Notification.php';

	//print_r($_POST);
    $vehicle = trim($_POST['vehicle']);
	$vehicleId = Vehicle::getIdByNumber($vehicle);
	$mVehicle = new Vehicle($vehicleId);
	
    $driver = $mVehicle->getDriver();

    $latitude = trim($_POST['latitude']);
    $longitude = trim($_POST['longitude']);
    $address = "";
    $reason = trim($_POST['reason']);
    $amount = trim($_POST['amount']);

    $filename = date("YmdHis");

    $image = trim($_POST['bill_image']);
    $binary=base64_decode($image);
    header('Content-Type: bitmap; charset=utf-8');
	
	//checks whether the folder exists or not
	$folderpath = "../res/bills/".$vehicle;
	if (!file_exists($folderpath)) {
		mkdir($folderpath, 0777, true);
	}
	
    $filepath = $folderpath."/".$filename.".png";
    //echo $filepath;
    $file = fopen($filepath, 'wb');
    fwrite($file, $binary);
    fclose($file);
	
	if($mVehicle->updateExpenses($driver, $latitude, $longitude, $address, $reason, $amount, $filename)) {	
		$latestReceiptId = $mVehicle->getLatestReceipt();
		Notification::addReceiptNotification($driver, $mVehicle->getId(), $latitude, $longitude, $latestReceiptId);

		echo "success";
	} else{
		echo "fail";
	}
?>