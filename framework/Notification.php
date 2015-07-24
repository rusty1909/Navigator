<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

if(!isset($_SESSION))
	session_start();
require_once 'Connection.php';
require_once 'User.php';
require_once 'Vehicle.php';
require_once 'Driver.php';

class Notification {
	private $id;
	private $priority;
	private $type;
	private $vehicle;
	private $driver;
	private $origin;
	private $latitude;
	private $longitude;
	private $company;
	private $admin;
	private $searchItem;
	private $city;
	private $dateAdded;
	
	function __construct($id) {
		// opening db connection
		$db = new Connection();
		$conn = $db->connect();

		$sql = "SELECT * FROM notification WHERE id='$id'";
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
				$this->admin = $row['admin'];
				$this->searchItem = $row['search_item'];
				$this->city = $row['city'];
				$this->dateAdded = $row['date_added'];
			}
		}
	}
	
	function getResource(){
		$resArray = array();
		$resArray['id'] = $this->id;
		switch($this->type){
			case "search" : $driverId = $this->driver;
				$mDriver = new Driver($driverId);
				$item = $this->searchItem;
				$vehicleId = $this->vehicle;
				$mVehicle = new Vehicle($vehicleId);
				
				$resArray['string'] = "<a href=\"/navigator/ui/driver/detail.php?id=".$driverId."\">".$mDriver->getName()."</a> searched for <b>".$item."</b> from <a href=\"/navigator/ui/vehicle/detail.php?id=".$vehicleId."\">".$mVehicle->getVehicleNumber()."</a>";
				break;
				
			case "location" : $vehicleId = $this->vehicle;
				$mVehicle = new Vehicle($vehicleId);
				$city = $this->city;
				
				$resArray['string'] = "<a href=\"/navigator/ui/vehicle/detail.php?id=".$vehicleId."\">".$mVehicle->getVehicleNumber()."</a> reached <b>".$city."</b>";
				break;
			
			case "expenses" : $vehicleId = $this->vehicle;
				$mVehicle = new Vehicle($vehicleId);
				$driverId = $this->driver;
				$mDriver = new Driver($driverId);
				
				$resArray['string'] = "<a href=\"/navigator/ui/driver/detail.php?id=".$driverId."\">".$mDriver->getName()."</a> uploaded bill from <a href=\"/navigator/ui/vehicle/detail.php?id=".$vehicleId."\">".$mVehicle->getVehicleNumber()."</a>";
				break;
			
			case "power_battery_low" : $vehicleId = $this->vehicle;
				$mVehicle = new Vehicle($vehicleId);
				$driverId = $this->driver;
				$mDriver = new Driver($driverId);
				
				$resArray['string'] = "<b>Low Battery</b> reported for <a href=\"/navigator/ui/vehicle/detail.php?id=".$vehicleId."\">".$mVehicle->getVehicleNumber()."</a>";
				break;
				
			case "power_shutdown" : $vehicleId = $this->vehicle;
				$mVehicle = new Vehicle($vehicleId);
				$driverId = $this->driver;
				$mDriver = new Driver($driverId);
				
				$resArray['string'] = "<b>Device shutdown</b> reported for <a href=\"/navigator/ui/vehicle/detail.php?id=".$vehicleId."\">".$mVehicle->getVehicleNumber()."</a>";
				break;
			
			case "power_battery_unplugged" : $vehicleId = $this->vehicle;
				$mVehicle = new Vehicle($vehicleId);
				$driverId = $this->driver;
				$mDriver = new Driver($driverId);
				
				$resArray['string'] = "<b>Power Unplugged</b> reported for <a href=\"/navigator/ui/vehicle/detail.php?id=".$vehicleId."\">".$mVehicle->getVehicleNumber()."</a>";
				break;
			
			case "power_battery_plugged" : $vehicleId = $this->vehicle;
				$mVehicle = new Vehicle($vehicleId);
				$driverId = $this->driver;
				$mDriver = new Driver($driverId);
				
				$resArray['string'] = "Power is back on <a href=\"/navigator/ui/vehicle/detail.php?id=".$vehicleId."\">".$mVehicle->getVehicleNumber()."</a>";
				break;
				
			default : $resArray['string'] = "";
				break;
		}
		//echo $resArray['string']."<br>";
		$date = $this->dateAdded;
		$resArray['time'] = date("d-m-Y H:i:s", strtotime($date));
		$resArray['lat'] = $this->latitude;
		$resArray['long'] = $this->longitude;
		$resArray['priority'] = $this->priority;
		
		return $resArray;
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
		$adminId = $mVehicle->getAddedBy();
		//echo "companyId = ".$companyId."                      ";
		
		$sql = "INSERT INTO `notification` (priority, type, origin, driver, vehicle, latitude, longitude, company, admin, search_item, date_added) VALUES ('$priority', '$type', '$origin', '$driver', '$vehicle', '$latitude', '$longitude', '$companyId', '$adminId', '$searchItem', '$fgDate')";
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
		$adminId = $mVehicle->getAddedBy();
		$sql = "INSERT INTO `notification` (priority, type, origin, driver, vehicle, latitude, longitude, company, admin, city, date_added) VALUES ('$priority', '$type', '$origin', '$driver', '$vehicle', '$latitude', '$longitude', '$companyId', '$adminId', '$city', '$fgDate')";
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
		$adminId = $mVehicle->getAddedBy();
		$sql = "INSERT INTO `notification` (priority, type, origin, driver, vehicle, latitude, longitude, company, admin, receipt, date_added) VALUES ('$priority', '$type', '$origin', '$driver', '$vehicle', '$latitude', '$longitude', '$companyId', '$adminId', '$receipt_id', '$fgDate')";
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
		$adminId = $mVehicle->getAddedBy();
		$sql = "INSERT INTO `notification` (priority, type, origin, driver, vehicle, latitude, longitude, company, admin, date_added) VALUES ('$priority', '$type', '$origin', '$driver', '$vehicle', '$latitude', '$longitude', '$companyId', '$adminId', '$fgDate')";
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