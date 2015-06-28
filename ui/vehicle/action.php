<?php
require_once '../../framework/Vehicle.php';
if(!isset($_SESSION['user'])){
	echo "<script>window.location.href = '../user/login.php'</script>";
	//header('Location:../user/login.php');
}
if(isset($_GET['action'])) {
	//die "q";
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
			header('Location:index.php');
		} else {
			header('Location:abc.php');
		}
		break;
    
	case "delete" : $id = $_GET['id'];
		echo $_GET['id'];
		$mVehicle = new Vehicle($id);
		if($mVehicle->delete())
			header('Location:index.php');
		else {}
			//header('Location:abc.php');
        break;
    
    case "removedriver" : $id = $_GET['id'];
		//echo $_GET['id'];
		$mVehicle = new Vehicle($id);
    if($mVehicle->removeDriver()){
        //echo "<script>window.history.back()</script>";
        header('Location:detail.php');
    }else {}
			//header('Location:abc.php');
        break;
		

}
?>