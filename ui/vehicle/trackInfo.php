 <?php
require_once '../../framework/Vehicle.php';

/*error_reporting(E_ALL);
ini_set('display_errors', 1);*/

if(isset($_GET['start']) && isset($_GET['end'])) {
    $id = $_GET['id'];
	$start = $_GET['start'];
    $end = $_GET['end'];
	//$originalDate = "2010-03-21";
	$newStart = date("Y-m-d", strtotime($start));
	$newEnd = date("Y-m-d", strtotime($end));
    //echo "sckdshvkhsdvhsokdhv";
	$mVehicle = new Vehicle($id);
	$mTrack = $mVehicle->getTrack($newStart, $newEnd);
    //echo sizeof($mTrack);
    echo json_encode($mTrack);
} else {
//echo "ertyuikl;";
}
?>