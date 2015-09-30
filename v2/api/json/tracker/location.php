<?php
require_once '../../../../framework/Vehicle.php';
require_once '../../../../framework/Company.php';
require_once '../../../../framework/User.php';
require_once '../../../../framework/Notification.php';

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

function getAddress($lat,$lng)
{
	$url = 'http://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($lat).','.trim($lng).'&sensor=false';
	$json = @file_get_contents($url);
	$data=json_decode($json);
	$status = $data->status;
	if($status=="OK")
		return $data;
	else
		return false;
}

function getCity($address) {
	$city = "";
	foreach ($address->address_components as $component) {
		switch ($component->types) {
			case in_array('administrative_area_level_2', $component->types):
				if($city == "") {
					$city = $component->long_name;
				}
				break;
			case in_array('locality', $component->types):
				$city = $component->long_name;
				break;
		}
	}
	return $city;
}
function getSnappedLatLng($lat, $lng) { 
	$url = 'http://router.project-osrm.org/locate?loc='.trim($lat).','.trim($lng).'';
	$json = @file_get_contents($url);
	$data=json_decode($json);
	$mapped = $data->mapped_coordinate;
	return $mapped;
}

$setupResponse = new SetupResponse();
$setupResponse->request = "location";
$result = new Result();

if(isset($_GET['vehicle'])&& isset($_GET['imei']) && isset($_GET['mac']) && isset($_GET['company'])) {
	$vehicle = trim($_GET['vehicle']);
	$imei = trim($_GET['imei']);
	$mac = trim($_GET['mac']);
	$company = trim($_GET['company']);
	
	$rawlat = trim($_GET['lat']);
	$rawlng = trim($_GET['lng']);
	
	$latlng = getSnappedLatLng($rawlat, $rawlng);
	$lat = $latlng[0];
	$lng = $latlng[1];
	
	$mVehicle = new Vehicle($vehicle);
	if($mVehicle == null || $mVehicle->getCompany() != $company) {
		$setupResponse->status = "FAILURE";

		$error = new Error();
		$error->reason = "VEHICLE ERROR";
		$error->message = "No such vehicle exists";
		
		$result->error = $error;		
	} else {
		if(/*$mVehicle->getMAC()==$mac && */$mVehicle->getIMEI()==$imei){
			$addressInfo = getAddress($lat, $lng);
			$address = $addressInfo->results[0]->formatted_address;
			$city = getCity($addressInfo->results[0]);
			
			//echo $address."   ".$city;
			
			if($city != "" && $mVehicle->getCurrentCity() != $city){
				$vehicleId = $mVehicle->getId();
				$driver = $mVehicle->getDriver();
				Notification::addLocationNotification($driver, $vehicleId, $lat, $lng, $city);
			}
			if(isset($_GET['accuracy']) && $_GET['accuracy'] <=20){
				if($mVehicle->setLocation($lat, $lng, $address, $city) && $mVehicle->addTrack($lat, $lng, $address)) {
					$setupResponse->status = "SUCCESS";
					$setupResponse->request = "location, track";
				}
			} else {
				if($mVehicle->setLocation($lat, $lng, $address, $city)) {
					$setupResponse->status = "SUCCESS";
					$setupResponse->request = "location";
				}
			}
		} else {
			$setupResponse->status = "FAILURE";

			$error = new Error();
			$error->reason = "AUTHENTICATION ERROR";
			$error->message = "You are not authorized for this action.";
			
			$result->error = $error;		
		}
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