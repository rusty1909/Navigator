<?php
require_once '../../../../framework/Vehicle.php';
require_once '../../../../framework/Company.php';
require_once '../../../../framework/User.php';

class SetupResponse {
	public $status;
	public $request = "location";
	public $result;
}

class Error {
	public $reason;
	public $message;
}

class Result {
}

class Message {
	public $id;
	public $title;
	public $content;
	public $author;
	public $timestamp;
}

$setupResponse = new SetupResponse();
$setupResponse->request = "setup";
$result = new Result();

if(isset($_GET['vehicle'])&& isset($_GET['imei']) && isset($_GET['mac'])) {
	$vehicle = trim($_GET['vehicle']);
	$imei = trim($_GET['imei']);
	$mac = trim($_GET['mac']);
	
	$lat = trim($_GET['lat']);
	$lng = trim($_GET['lng']);
    $city = trim($_GET['city']);
	
	$mVehicle = new Vehicle($vehicle);
	if($mVehicle->getMAC()==$mac && $mVehicle->getIMEI()==$imei){
		if($city != "" && $mVehicle->getCurrentCity() != $city){
			$vehicleId = $mVehicle->getId();
			$driver = $mVehicle->getDriver();
			Notification::addLocationNotification($driver, $vehicleId, $lattitude, $longitude, $city);
		}
		if($mVehicle->setLocation($lattitude, $longitude, $address, $city) && $mVehicle->addTrack($lattitude, $longitude, $address)) {
			$setupResponse->status = "SUCCESS";	
		}
	} else {
		$setupResponse->status = "FAILURE";

		$error = new Error();
		$error->reason = "AUTHENTICATION ERROR";
		$error->message = "You are not authorized for this action.";
		
		$result->error = $error;		
	}
	
} else {
	$setupResponse->status = "FAILURE";

	$error = new Error();
	$error->reason = "AUTHENTICATION ERROR";
	$error->message = "Please provide authentication information.";
	
	$result->error = $error;
}
$setupResponse->result = $result;
echo json_encode($setupResponse);
?>