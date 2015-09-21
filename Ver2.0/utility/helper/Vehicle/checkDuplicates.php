<?php
require_once '../../../framework/Vehicle.php';
if(isset($_POST['vehicle_number'])) {
	
	$vehicle_number = $_POST['vehicle_number'];
	if(Vehicle::isExists('vehicle_number', $vehicle_number)){
		echo 1;
	} else {
		echo 0;
	}
}
?>