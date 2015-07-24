<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

if(!isset($_SESSION))
	session_start();
require_once 'Connection.php';
require_once 'User.php';
require_once 'Vehicle.php';

class Notification {
	private $id;
	private $priority;
	private $type;
	private $vehicle;
	private $driver;
	private $origin;
	private $latitude;
	private $longitude;
	private $companyId;
	private $searchItem;
	private $dateAdded;
	
	function __construct($id) {
		// opening db connection
		$db = new Connection();
		$conn = $db->connect();

		$sql = "SELECT * FROM job WHERE id='$id'";
		$action = mysqli_query($conn, $sql);
		if (mysqli_num_rows($action) > 0) {
			while($row = mysqli_fetch_assoc($action)) {
				$this->id = $row['id'];
				$this->priority = $row['priority'];				
				$this->type = $row['type'];
				$this->origin = $row['origin'];
				$this->driver = $row['driver'];
				$this->vehicle = $row['vehicle'];
				$this->latitude = $row['latitude'];
				$this->longitude = $row['longitude'];
				$this->company = $row['company'];
				$this->searchItem = $row['search_item'];
				$this->dateAdded = $row['date_added'];
			}
		}
	}
	
	public static function addSearchNotification($driver, $vehicle, $latitude, $longitude, $searchItem) {
		// opening db connection
		$db = new Connection();
		$conn = $db->connect();
		
		
		$today = date('Y-m-d');
        
		$fgDate = $db->getTimeNow();
		
		$type = "search";
		$origin = "driver";
		$priority = Notification::getPriority($type); // notification_category : search
		
		
		$mVehicle = new Vehicle($vehicle);
		$companyId = $mVehicle->getCompany();
		//echo "companyId = ".$companyId."                      ";
		
		$sql = "INSERT INTO `notification` (priority, type, origin, driver, vehicle, latitude, longitude, company, search_item, date_added) VALUES ('$priority', '$type', '$origin', '$driver', '$vehicle', '$latitude', '$longitude', '$companyId', '$searchItem', '$fgDate')";
		//echo $sql;
		if (mysqli_query($conn, $sql)) {
			return true;
		} else {
			return false;
		}
	}
	
	public static function addLocationNotification($driver, $vehicle, $latitude, $longitude, $city){
		// opening db connection
		$db = new Connection();
		$conn = $db->connect();
		
		
		$today = date('Y-m-d');
        
		$fgDate = $db->getTimeNow();
		
		$type = "location";
		$origin = "vehicle";
		$priority = Notification::getPriority($type); // notification_category : location
		
		$mVehicle = new Vehicle($vehicle);
		$companyId = $mVehicle->getCompany();
		
		$sql = "INSERT INTO `notification` (priority, type, origin, driver, vehicle, latitude, longitude, company, city, date_added) VALUES ('$priority', '$type', '$origin', '$driver', '$vehicle', '$latitude', '$longitude', '$companyId', '$city', '$fgDate')";
		//echo $sql;
		if (mysqli_query($conn, $sql)) {
			return true;
		} else {
			return false;
		}
	}
	
	public static function addReceiptNotification($driver, $vehicle, $latitude, $longitude, $receipt_id){
				$db = new Connection();
		$conn = $db->connect();
		
		
		$today = date('Y-m-d');
        
		$fgDate = $db->getTimeNow();
		
		$type = "expenses";
		$origin = "driver";
		$priority = Notification::getPriority($type); // notification_category : expenses
		
		$mVehicle = new Vehicle($vehicle);
		$companyId = $mVehicle->getCompany();
		
		$sql = "INSERT INTO `notification` (priority, type, origin, driver, vehicle, latitude, longitude, company, receipt, date_added) VALUES ('$priority', '$type', '$origin', '$driver', '$vehicle', '$latitude', '$longitude', '$companyId', '$receipt_id', '$fgDate')";
		//echo $sql;
		if (mysqli_query($conn, $sql)) {
			return true;
		} else {
			return false;
		}
	}
	
	public static function addBatteryNotification($type, $driver, $vehicle, $latitude, $longitude){
		$db = new Connection();
		$conn = $db->connect();
		
		
		$today = date('Y-m-d');
        
		$fgDate = $db->getTimeNow();
		
		//$type = "power_battery_plugged";
		$origin = "vehicle";
		$priority = Notification::getPriority($type);
		
		$mVehicle = new Vehicle($vehicle);
		$companyId = $mVehicle->getCompany();
		
		$sql = "INSERT INTO `notification` (priority, type, origin, driver, vehicle, latitude, longitude, company, date_added) VALUES ('$priority', '$type', '$origin', '$driver', '$vehicle', '$latitude', '$longitude', '$companyId', '$fgDate')";
		//echo $sql;
		if (mysqli_query($conn, $sql)) {
			return true;
		} else {
			return false;
		}
	}
	
	public static function getPriority($type){
		$db = new Connection();
		$conn = $db->connect();
		$priority = -1;
		$sql = "SELECT priority FROM notification_category WHERE name = '$type'";
		$action = mysqli_query($conn, $sql);
		
		if (mysqli_num_rows($action) > 0) {
			// output data of each row
			if($row = mysqli_fetch_assoc($action)) {
				$priority = $row['priority'];
			}
		}
		return $priority;
	}
}
?>