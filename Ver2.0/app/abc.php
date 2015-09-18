<?php
	require_once '../framework/Vehicle.php';
    require_once '../framework/Company.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);
//echo "hello11";
	//print_r($_POST);
//	if(1) {
		$tin = "987654321";
		//if($tin != "") {
		$companyId = Company::getIdByTin($tin);
		$mCompany = new Company($companyId);
		$mList = $mCompany->getAllVehicleList();
		//echo "hello";
		//print_r($mList);
		echo json_encode($mList);			
		//}
/*	} else {
		if(isset($_GET['vehicle'])) {
			$vehicle = trim($_GET['vehicle']);			
			//$vehicleId = Vehicle::getIdByNumber($vehicle);
			$mVehicle = new Vehicle($vehicle);

			if($mVehicle->deploy()) echo "set";
		}
	}
*/
?>