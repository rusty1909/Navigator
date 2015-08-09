<?php
	require_once '../framework/Vehicle.php';


	if(isset($_GET['vehicle']) && isset($_GET['gcmkey'])) {
		$vehicle = trim($_GET['vehicle']);	
		$key = trim($_GET['gcmkey']);
		$vehicleId = Vehicle::getIdByNumber($vehicle);
		
		$mVehicle = new Vehicle($vehicleId);
		if($mVehicle->syncGCMKey($key))
			echo "success";
		else "fail";
	} else {
		echo "fail";
	}


?>