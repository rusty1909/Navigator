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
	private $employee;
	private $company;
	private $admin;
	private $addedBy;
	private $dateAdded;
	private $stringRes;
	
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
				$this->employee = $row['employee'];
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
		
		$addedById = $this->addedBy;
		$mAddedBy = new User($addedById);
		
		switch($this->type){
			case "vehicle_addition" : $vehicleId = $this->vehicle;
				$mVehicle = new Vehicle($vehicleId);
				
				$resArray['image'] = "vehicle_icon";
				
				$resArray['string'] = "<a href=\"/navigator/ui/vehicle/detail.php?id=".$vehicleId."\"><b>".$mVehicle->getVehicleNumber()."</b></a> was added by ";
				break;
				
			case "driver_addition" : $driverId = $this->driver;
				$mDriver = new Driver($driverId);
				
				$resArray['image'] = "driver_icon";
				
				$resArray['string'] = "<a href=\"/navigator/ui/driver/detail.php?id=".$driverId."\"><b>".$mDriver->getName()."</b></a> was added by ";
				break;
			
			case "driver_allotment" : $vehicleId = $this->vehicle;
				$mVehicle = new Vehicle($vehicleId);
				$driverId = $this->driver;
				$mDriver = new Driver($driverId);
				$receiptId = $this->receipt;
				$mExpense = new Expense($receiptId);
				$expenseAmount = $mExpense->getAmount();
				$expenseReason = $mExpense->getReason();
				
				$resArray['image'] = "allotment_icon";
				
				$resArray['string'] = "<a href=\"/navigator/ui/driver/detail.php?id=".$driverId."\"><b>".$mDriver->getName()."</b></a> was assigned to <a href=\"/navigator/ui/vehicle/detail.php?id=".$vehicleId."\"><b>".$mVehicle->getVehicleNumber()."</b></a> by";
				break;
			
			case "staff_addition" : $employeeId = $this->employee;
				$mEmployee = new User($employeeId);
				
				$resArray['image'] = "staff_icon";
				
				$resArray['string'] = "<a href='#'><b>".$mEmployee->getFullName()."</b></a> was added by ";
				break;
				
			default : $resArray['string'] = "Qwerty";
				$resArray['image'] = "alert_ok";
				break;
		}
		
		$resAddedBy = "<a href='#'><b>".$mAddedBy->getFullName()."</b></a>";
		
		$resArray['string'].=$resAddedBy;
		
		$date = $this->dateAdded;
		$resArray['time'] = date("d-m-Y H:i:s", strtotime($date));
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
		//echo $sql;
		if (mysqli_query($conn, $sql)) {
			return true;
		} else {
			return false;
		}
	}
	
	
}

?>