<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

if(!isset($_SESSION))
	session_start();
require_once 'Connection.php';
require_once 'User.php';
require_once 'Vehicle.php';
require_once 'Driver.php';
require_once 'Expense.php';

class Timeline {
	private $id;
	private $type;
	private $vehicle;
	private $driver;
	private $staff;
	private $company;
	private $admin;
	private $addedBy;
	private $dateAdded;
	
	function __construct($id) {
		// opening db connection
		$db = new Connection();
		$conn = $db->connect();

		$sql = "SELECT * FROM timeline WHERE id='$id'";
		$action = mysqli_query($conn, $sql);
		if (mysqli_num_rows($action) > 0) {
			while($row = mysqli_fetch_assoc($action)) {
				$this->id = $row['id'];			
				$this->type = $row['type'];
				$this->driver = $row['driver'];
				$this->vehicle = $row['vehicle'];
				$this->staff = $row['staff'];
				$this->company = $row['company'];
				$this->admin = $row['admin'];
				$this->addedBy = $row['added_by'];
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
				
				$resArray['string'] = "<a href=\"/navigator/ui/driver/detail.php?id=".$driverId."\"><b>".$mDriver->getName()."</b></a> searched for <b>".$item."</b> from <a href=\"/navigator/ui/vehicle/detail.php?id=".$vehicleId."\"><b>".$mVehicle->getVehicleNumber()."</b></a>";
				break;
				
			case "location" : $vehicleId = $this->vehicle;
				$mVehicle = new Vehicle($vehicleId);
				$city = $this->city;
				
				$resArray['string'] = "<a href=\"/navigator/ui/vehicle/detail.php?id=".$vehicleId."\"><b>".$mVehicle->getVehicleNumber()."</b></a> reached <b>".$city."</b>";
				break;
			
			case "expenses" : $vehicleId = $this->vehicle;
				$mVehicle = new Vehicle($vehicleId);
				$driverId = $this->driver;
				$mDriver = new Driver($driverId);
				$receiptId = $this->receipt;
				$mExpense = new Expense($receiptId);
				$expenseAmount = $mExpense->getAmount();
				$expenseReason = $mExpense->getReason();
				
				$resArray['string'] = "<a href=\"/navigator/ui/driver/detail.php?id=".$driverId."\"><b>".$mDriver->getName()."</b></a> uploaded bill of <b>Rs.".$expenseAmount."</b> for <b>".$expenseReason."</b> from <a href=\"/navigator/ui/vehicle/detail.php?id=".$vehicleId."\"><b>".$mVehicle->getVehicleNumber()."</b></a>";
				break;
			
			case "power_battery_low" : $vehicleId = $this->vehicle;
				$mVehicle = new Vehicle($vehicleId);
				$driverId = $this->driver;
				$mDriver = new Driver($driverId);
				
				$resArray['string'] = "<b>Low Battery</b> reported for <a href=\"/navigator/ui/vehicle/detail.php?id=".$vehicleId."\"><b>".$mVehicle->getVehicleNumber()."</b></a>";
				break;
				
			case "power_shutdown" : $vehicleId = $this->vehicle;
				$mVehicle = new Vehicle($vehicleId);
				$driverId = $this->driver;
				$mDriver = new Driver($driverId);
				
				$resArray['string'] = "<b>Device shutdown</b> reported for <a href=\"/navigator/ui/vehicle/detail.php?id=".$vehicleId."\"><b>".$mVehicle->getVehicleNumber()."</b></a>";
				break;
			
			case "power_battery_unplugged" : $vehicleId = $this->vehicle;
				$mVehicle = new Vehicle($vehicleId);
				$driverId = $this->driver;
				$mDriver = new Driver($driverId);
				
				$resArray['string'] = "<b>Power Unplugged</b> reported for <a href=\"/navigator/ui/vehicle/detail.php?id=".$vehicleId."\"><b>".$mVehicle->getVehicleNumber()."</b></a>";
				break;
			
			case "power_battery_plugged" : $vehicleId = $this->vehicle;
				$mVehicle = new Vehicle($vehicleId);
				$driverId = $this->driver;
				$mDriver = new Driver($driverId);
				
				$resArray['string'] = "Power is back on <a href=\"/navigator/ui/vehicle/detail.php?id=".$vehicleId."\"><b>".$mVehicle->getVehicleNumber()."</b></a>";
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
		$resArray['type'] = $this->type;
		
		return $resArray;
	}
	
	public static function addTimelineEvent($type, $vehicle, $driver, $employee, $addedBy) {
		// opening db connection
		$db = new Connection();
		$conn = $db->connect();
		
		
		$today = date('Y-m-d');
        
		$fgDate = $db->getTimeNow();
		
		if($vehicle != ""){
			$mVehicle = new Vehicle($vehicle);
		}
		if($driver != ""){
			$mDriver = new Vehicle($driver);
		}
		if($employee != ""){
			$mEmployee = new Vehicle($employee);
		}

		$mAddedBy = new User($addedBy);
		$companyId = $mAddedBy->getCompany();
		$mCompany = new Company($companyId);
		$adminId = $mCompany->getAdmin();

		
		$sql = "INSERT INTO `timeline` (`type`, `vehicle`, `driver`, `employee`, `company`, `admin`, `added_by`, `date_added`) VALUES ('$type', '$vehicle', '$driver', '$employee', '$companyId', '$adminId', '$addedBy', '$fgDate')";
		echo $sql;
		if (mysqli_query($conn, $sql)) {
			return true;
		} else {
			return false;
		}
	}
	
	
}

?>