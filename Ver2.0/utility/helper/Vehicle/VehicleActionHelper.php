<?php
require_once '../../../framework/Vehicle.php';
require_once '../../../framework/VehicleMailer.php';

if(isset($_GET['action'])) {
	$action = $_GET['action'];
} else {
	$action = "";
}

switch($action) {
	case "add" : $type = $_POST['type'];
		$model = $_POST['model'];
		$make_year = $_POST['make_year'];
		$vehicle_number = $_POST['vehicle_number'];
		$description = $_POST['description'];
		if(Vehicle::add($type, $model, $vehicle_number, $make_year, $description)){
            $veh_id = Vehicle::getIdByNumber($vehicle_number);
            $adder = new VehicleMailer($veh_id);
            $adder->sendVehicleAddedMessage();
			
            echo "<script>window.location.href = 'http://www.findgaddi.com/navigator/Ver2.0/ui/pages/vehicle/index.php'</script>";
		} else {
			echo "<script>window.location.href = 'http://www.findgaddi.com/navigator/Ver2.0/ui/pages/vehicle/abc.php'</script>";
		}
		break;
    
	case "delete" : $id = $_GET['id'];
		echo $_GET['id'];
		$mVehicle = new Vehicle($id);
    
       /* if getCurrentJob() retruns o means vehicle is not on job... */
        if($mVehicle->isOnTrip() != 0|| $mVehicle->getCurrentJob() != 0){
            echo '<script language="javascript">';
            echo 'alert("Vehicle is on Job, can\'t delte now !!!")';
            echo '</script>';
            
             echo "<script>window.location.href = 'http://www.findgaddi.com/navigator/Ver2.0/ui/pages/vehicle/index.php'</script>";
            
            break;
        }
    
		if($mVehicle->delete()){
            $adder = new VehicleMailer($id);
            $adder->sendVehicleDeletedMessage();
            echo "<script>window.location.href = 'http://www.findgaddi.com/navigator/Ver2.0/ui/pages/vehicle/index.php'</script>";
        }else {
            echo "<script>window.location.href = 'http://www.findgaddi.com/navigator/Ver2.0/ui/pages/vehicle/index.php'</script>";
        }
		break;

	case "set_driver" : $id = $_GET['id'];
		$driver_id = $_GET['driverid'];
		$mVehicle = new Vehicle($id);
		if($mVehicle->setDriver($driver_id)){
			echo 1;
		} else {
			echo 0;
		}
        break;
    
    case "removedriver" : $id = $_GET['id'];
		$mVehicle = new Vehicle($id);
		if($mVehicle->removeDriver()){
			echo "<script>window.location.href = 'http://www.findgaddi.com/navigator/Ver2.0/ui/pages/vehicle/detail.php'</script>";
		}else {}
			break;
		

}
?>