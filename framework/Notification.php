<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

if(!isset($_SESSION))
	session_start();
require_once 'Connection.php';
require_once 'User.php';

class Notification {
	private $id;
	private $category;
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
				$this->category = $row['category'];				
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
		$category = 3; // notification_category : search
		
		//user details
		$userId = $_SESSION['user']['id'];
		$companyId = $_SESSION['user']['company'];
		
		$sql = "INSERT INTO `notification` (category, type, origin, driver, vehicle, latitude, longitude, company, search_item, date_added) VALUES ('$category', '$type', '$origin', '$driver', '$vehicle', '$latitude', '$longitude', '$companyId', '$searchItem', '$fgDate')";
		echo $sql;
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
		$category = 1; // notification_category : location
		
		//user details
		$userId = $_SESSION['user']['id'];
		$companyId = $_SESSION['user']['company'];
		
		$sql = "INSERT INTO `notification` (category, type, origin, driver, vehicle, latitude, longitude, company, city, date_added) VALUES ('$category', '$type', '$origin', '$driver', '$vehicle', '$latitude', '$longitude', '$companyId', '$city', '$fgDate')";
		echo $sql;
		if (mysqli_query($conn, $sql)) {
			return true;
		} else {
			return false;
		}
	}
	
	public static function addReceiptNotification($driver, $vehicle, $lattitude, $longitude, $receipt_id){
				$db = new Connection();
		$conn = $db->connect();
		
		
		$today = date('Y-m-d');
        
		$fgDate = $db->getTimeNow();
		
		$type = "expenses";
		$origin = "driver";
		$category = 10; // notification_category : expenses
		
		//user details
		$userId = $_SESSION['user']['id'];
		$companyId = $_SESSION['user']['company'];
		
		$sql = "INSERT INTO `notification` (category, type, origin, driver, vehicle, latitude, longitude, company, receipt, date_added) VALUES ('$category', '$type', '$origin', '$driver', '$vehicle', '$latitude', '$longitude', '$companyId', '$receipt_id', '$fgDate')";
		echo $sql;
		if (mysqli_query($conn, $sql)) {
			return true;
		} else {
			return false;
		}
	}
	
	public static function addBatteryLowNotification($driver, $vehicle, $latitude, $longitude){
				$db = new Connection();
		$conn = $db->connect();
		
		
		$today = date('Y-m-d');
        
		$fgDate = $db->getTimeNow();
		
		$type = "power_battery_low";
		$origin = "vehicle";
		$category = 99; // notification_category : power_battery_low
		
		//user details
		$userId = $_SESSION['user']['id'];
		$companyId = $_SESSION['user']['company'];
		
		$sql = "INSERT INTO `notification` (category, type, origin, driver, vehicle, latitude, longitude, company, date_added) VALUES ('$category', '$type', '$origin', '$driver', '$vehicle', '$latitude', '$longitude', '$companyId', '$fgDate')";
		echo $sql;
		if (mysqli_query($conn, $sql)) {
			return true;
		} else {
			return false;
		}
	}
	
	public static function addBatteryPluggedNotification($driver, $vehicle, $latitude, $longitude){
				$db = new Connection();
		$conn = $db->connect();
		
		
		$today = date('Y-m-d');
        
		$fgDate = $db->getTimeNow();
		
		$type = "power_battery_plugged";
		$origin = "vehicle";
		$category = 10; // notification_category : power_battery_plugged
		
		//user details
		$userId = $_SESSION['user']['id'];
		$companyId = $_SESSION['user']['company'];
		
		$sql = "INSERT INTO `notification` (category, type, origin, driver, vehicle, latitude, longitude, company, date_added) VALUES ('$category', '$type', '$origin', '$driver', '$vehicle', '$latitude', '$longitude', '$companyId', '$fgDate')";
		echo $sql;
		if (mysqli_query($conn, $sql)) {
			return true;
		} else {
			return false;
		}
	}
	
	public static function addBatteryShutDownNotification($driver, $vehicle, $latitude, $longitude){
				$db = new Connection();
		$conn = $db->connect();
		
		
		$today = date('Y-m-d');
        
		$fgDate = $db->getTimeNow();
		
		$type = "power_shutdown";
		$origin = "vehicle";
		$category = 99; // notification_category : power_shutdown
		
		//user details
		$userId = $_SESSION['user']['id'];
		$companyId = $_SESSION['user']['company'];
		
		$sql = "INSERT INTO `notification` (category, type, origin, driver, vehicle, latitude, longitude, company, date_added) VALUES ('$category', '$type', '$origin', '$driver', '$vehicle', '$latitude', '$longitude', '$companyId', '$fgDate')";
		echo $sql;
		if (mysqli_query($conn, $sql)) {
			return true;
		} else {
			return false;
		}
	}
	
	public static function addBatteryUnPluggedNotification($driver, $vehicle, $latitude, $longitude){
				$db = new Connection();
		$conn = $db->connect();
		
		
		$today = date('Y-m-d');
        
		$fgDate = $db->getTimeNow();
		
		$type = "power_battery_unplugged";
		$origin = "vehicle";
		$category = 99; // notification_category : power_battery_unplugged
		
		//user details
		$userId = $_SESSION['user']['id'];
		$companyId = $_SESSION['user']['company'];
		
		$sql = "INSERT INTO `notification` (category, type, origin, driver, vehicle, latitude, longitude, company, date_added) VALUES ('$category', '$type', '$origin', '$driver', '$vehicle', '$latitude', '$longitude', '$companyId', '$fgDate')";
		echo $sql;
		if (mysqli_query($conn, $sql)) {
			return true;
		} else {
			return false;
		}
	}
	

}


//Notification::addBatteryLowNotification(23, 63, 73.5346, 28.4756);


?>