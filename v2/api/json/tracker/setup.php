<?php
require_once '../../../../framework/Vehicle.php';
require_once '../../../../framework/Company.php';
require_once '../../../../framework/User.php';

class SetupResponse {
	public $status;
	public $request = "setup";
	public $result;
}

class Error {
	public $reason;
	public $message;
}

class Result {
}

class TempVehicle {
	public $id;
	public $number;
	public $type;
	public $year;
	public $date_added;
}

class TempCompany {
	public $id;
	public $name;
	public $phone;
	public $admin;
}

class TempAdmin {
	public $id;
	public $name;
	public $phone;
}

$setupResponse = new SetupResponse();
$setupResponse->request = "setup";
$result = new Result();

if(isset($_GET['vehicle']) && isset($_GET['type']) && isset($_GET['imei']) && isset($_GET['mac'])) {
	$vehicle = trim($_GET['vehicle']);
	$type = trim($_GET['type']);
	$imei = trim($_GET['imei']);
	$mac = trim($_GET['mac']);
	
	$vehicleId = Vehicle::getIdByNumber($vehicle);
	if($vehicleId==null) {
        $setupResponse->status = "FAILURE";
		$error = new Error();
		$error->reason = "VEHICLE";
		$error->message = "No such vehicle registered.";
		$result->error = $error;
    } else{
		$mVehicle = new Vehicle($vehicleId);
		if($mVehicle->getType()!=$type){
			$setupResponse->status = "FAILURE";
			$error = new Error();
			$error->reason = "VEHICLE_TYPE";
			$error->message = "Vehicle type does not match";
			$result->error = $error;
		} else{
			if($mVehicle->isDeployed()==1){
				$setupResponse->status = "FAILURE";
				
				$error = new Error();
				$error->reason = "VEHICLE";
				$error->message = $vehicle." is already deployed";
				$result->error = $error;
			} else {
				if($mVehicle->deploy($imei, $mac)) {
					$setupResponse->status = "SUCCESS";
					
					$vehicle = new TempVehicle();
					$vehicle->id = $mVehicle->getId();
					$vehicle->number = $mVehicle->getVehicleNumber();
					$vehicle->type = $mVehicle->getType();
					$vehicle->year = $mVehicle->getMakeYear();
					$vehicle->date_added = $mVehicle->getDateAdded();
					$result->vehicle = $vehicle;
					
					$mCompany = new Company($mVehicle->getCompany());
					$company = new TempCompany();
					$company->id = $mVehicle->getCompany();
					$company->name = $mCompany->getName();
					$company->phone = $mCompany->getPhone();
					
					$mAdmin = new User($mCompany->getAdmin());
					$admin = new TempAdmin();
					$admin->id = $mAdmin->getId();
					$admin->name = $mAdmin->getFullName();
					$admin->phone = $mAdmin->getPhoneMobile();
					$company->admin = $admin;
					$result->company = $company;
				}
			}
		}
	}
} else {
	$setupResponse->status = "FAILURE";

	$error = new Error();
	$error->reason = "INSUFFICIENT DATA";
	$error->message = "Please provide complete information.";
	
	$result = new Result();
	
	$result->error = $error;
}
$setupResponse->result = $result;
echo json_encode($setupResponse);
?>