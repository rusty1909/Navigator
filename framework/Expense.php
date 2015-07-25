<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

if(!isset($_SESSION))
	session_start();
require_once 'Connection.php';
require_once 'User.php';

class Expense {
	private $id;
	private $vehicleId;
	private $driverId;
	private $latitude;
	private $longitude;
	private $reason;
	private $amount;
	private $filename;
	private $approved;
	private $reject_comment;
	private $description;
	private $companyId;
	private $adminId;
	private $dateAdded;
	
	function __construct($id) {
		// opening db connection
		$db = new Connection();
		$conn = $db->connect();

		$sql = "SELECT * FROM expenses WHERE id='$id'";
		$action = mysqli_query($conn, $sql);

		if (mysqli_num_rows($action) > 0) {
			while($row = mysqli_fetch_assoc($action)) {
				$this->id = $row['id'];
				$this->vehicleId = $row['vehicle_id'];
				$this->driverId = $row['driver_id'];
				$this->latitude = $row['lattitude'];
				$this->longitude = $row['longitude'];
				$this->reason = $row['reason'];
				$this->amount = $row['amount'];
				$this->filename = $row['filename'];
				$this->approved = $row['approved'];
				$this->reject_comment = $row['reject_comment'];				
				$this->description = $row['description'];
				$this->companyId = $row['company'];
				$this->adminId = $row['admin'];
				$this->dateAdded = $row['date_added'];
			}
		}
	}
	
	function add($title, $vehicle_id, $driver_id, $start_date, $destination, $description) {
		// opening db connection
		$db = new Connection();
		$conn = $db->connect();
		
		//user details
		$userId = $_SESSION['user']['id'];
		$companyId = $_SESSION['user']['company'];
		
		$todaysJobs = Job::getTodaysJobs($companyId);
		$jobCode = "JOB-".date('Ymd')."-".($todaysJobs+1);
		$date = date('Y-m-d');
		
		$sql = "INSERT INTO `job` (title, job_code, vehicle_id, driver_id, start_date, destination, description, company_id, added_by, date_added) VALUES ('$title', '$jobCode', '$vehicle_id', '$driver_id', '$start_date', '$destination', '$description', '$companyId', '$userId', '$date')";
		echo $sql;
		if (mysqli_query($conn, $sql)) {
			$jobId = Job::getIdByCode($jobCode);
			$mJob = new Job($jobId);
			$mJob->addLocation($vehicle_id, $driver_id);
			return true;
		} else {
			echo "error";
			return false;
		}
	}

	function getId(){
		return $this->id;
	}
	
	function getDriver(){
		return $this->driverId;
	}
	
	function getVehicle(){
		return $this->vehicleId;
	}
	
	function getLocation(){
		$location['lat'] = $this->latitude;
		$location['lng'] = $this->longitude;
		return $location;
	}
	
    function getReason(){
		return $this->reason;
	}
	
    function getAmount(){
		return $this->amount;
	}
	
	function getFilename() {
		return $this->filename;
	}

	function getStatus() {
		return $this->approved;
	}

	function getRejectComment() {
		return $this->reject_comment;
	}
	
	function getCompany(){
		return $this->companyId;
	}
	
	function getAdmin(){
		return $this->adminId;
	}

	function getDateAdded(){
		return $this->dateAdded;
	}
}


?>