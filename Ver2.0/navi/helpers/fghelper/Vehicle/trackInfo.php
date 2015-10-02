 <?php
require_once '../../../framework/Vehicle.php';


if(isset($_GET['start']) && isset($_GET['end'])) {
    $id = $_GET['id'];
	$start = $_GET['start'];
    $end = $_GET['end'];
	$newStart = date("Y-m-d", strtotime($start));
	$newEnd = date("Y-m-d", strtotime($end));
    $mVehicle = new Vehicle($id);
	$mTrack = $mVehicle->getTrack($newStart, $newEnd);
    echo json_encode($mTrack);
} 
?>