<?php
require_once '../../framework/Vehicle.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

//echo $_POST['vehicle_number'];
if(isset($_POST['vehicle_number'])) {
	
	$vehicle_number = $_POST['vehicle_number'];
	if(Vehicle::isExists('vehicle_number', $vehicle_number)){
		echo 1;
	} else {
		echo 0;
	}
}
?>