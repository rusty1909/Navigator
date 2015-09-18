 <?php
require_once '../../framework/Vehicle.php';

if(isset($_POST['id'])) {
	$id = $_POST['id'];
	$mVehicle = new Vehicle($id);
	$mLocation = $mVehicle->getLocation();
    echo json_encode($mLocation);
} else {
    //echo "";
}
?>