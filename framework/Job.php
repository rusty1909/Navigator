<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

if(!isset($_SESSION))
	session_start();
require_once 'Connection.php';
require_once 'User.php';

class Job {
	private $id;
	private $title;
	private $jobCode;
	private $vehicleId;
	private $driverId;
	private $destination;
	private $source;
	private $totalCost;
	private $fuelConsumed;
	private $distanceTravelled;
	private $actualDistance;
	private $startDate;
	private $completionDate;
	private $companyId;
	private $addedBy;
	private $dateAdded;
	private $status; /* -1:DELETED, 0:RUNNING, 1:COMPLETED */
	
	function __construct($id) {
		// opening db connection
		$db = new Connection();
		$conn = $db->connect();

		$sql = "SELECT * FROM job WHERE id='$id'";
		$action = mysqli_query($conn, $sql);

		if (mysqli_num_rows($action) > 0) {
			while($row = mysqli_fetch_assoc($action)) {
				$this->id = $row['id'];
				$this->title = $row['title'];				
				$this->jobCode = $row['job_code'];
				$this->vehicleId = $row['vehicle_id'];
				$this->driverId = $row['driver_id'];
				$this->destination = $row['destination'];
				$this->source = $row['source'];
				$this->totalCost = $row['total_cost'];
				$this->fuelConsumed = $row['fuel_consumed'];
				$this->distanceTravelled = $row['distance_travelled'];
				$this->actualDistance = $row['actual_distance'];
				$this->startDate = $row['start_date'];				
				$this->completionDate = $row['completion_date'];
				$this->companyId = $row['company_id'];
				$this->addedBy = $row['added_by'];				
				$this->description = $row['description'];
				$this->dateAdded = $row['date_added'];
				$this->status = $row['status'];
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

	function addLocation($vehicle_id, $driver_id) {
		// opening db connection
		$db = new Connection();
		$conn = $db->connect();
		
		//user details
		$userId = $_SESSION['user']['id'];
		$companyId = $_SESSION['user']['company'];
		
		$sql = "INSERT INTO `location` (job_id, vehicle_id, driver_id) VALUES ('$this->id', '$vehicle_id', '$driver_id')";
		echo $sql;
		if (mysqli_query($conn, $sql)) {
			echo "success";
		} else {
			echo "error";
		}
	}
	
	public static function getIdByCode($jobCode) {
		// opening db connection
		$db = new Connection();
		$conn = $db->connect();
		
		$count = 0;
		$date = date('Y-m-d');
		
		$sql = "SELECT id FROM `job` WHERE job_code='$jobCode'";
		//echo "-->".$sql;
		$action = mysqli_query($conn, $sql);
		if (mysqli_num_rows($action) > 0) {
			while($row = mysqli_fetch_assoc($action)) {
				return $row['id'];
			}
		}
	}

    

	public static function getTodaysJobs($companyId) {
		// opening db connection
		$db = new Connection();
		$conn = $db->connect();
		
		$count = 0;
		$date = date('Y-m-d');
		
		$sql = "SELECT id FROM `job` WHERE company_id='$companyId' AND date_added='$date'";
		//echo "-->".$sql;
		$action = mysqli_query($conn, $sql);
		if (mysqli_num_rows($action) > 0) {
			while($row = mysqli_fetch_assoc($action)) {
				$count++;
			}
		}
		return $count;
	}
	
	function getLocationId() {
		// opening db connection
		$db = new Connection();
		$conn = $db->connect();
		
		$sql = "SELECT id FROM `location` WHERE job_id='$this->id' AND status='1'";
		//echo "-->".$sql;
		$action = mysqli_query($conn, $sql);
		if (mysqli_num_rows($action) > 0) {
			while($row = mysqli_fetch_assoc($action)) {
				return $row['id'];
			}
		}
	}
	
    function setLocation($lattitude, $longitude) {
		//require_once '../framework/DBConnect.php';
		// opening db connection
		$db = new Connection();
		$conn = $db->connect();
		
		$lattitude_list;
		$longitude_list;
		$last_last_update;		
		/*
		* Select values from vehicle table
		*/
		$sql = "SELECT * FROM location WHERE job_id = '$this->id'";
		$result = $conn->query($sql);
		echo "-------->".$sql."<br>";
		
		if ($result->num_rows > 0) {
			print_r($sql);
			while($row = $result->fetch_assoc()) {
				$lattitude_list = floatval($_POST['lattitude']).";".$row['lattitude_list'];
				$longitude_list = floatval($_POST['longitude']).";".$row['longitude_list'];
				$last_last_update = $row['last_update'];
			}
		}
		
		/*
		* Finally update the vehicle table with latest values
		*/		$fgDate = $db->getTimeNow();		
		$sql = "UPDATE location SET lattitude = '$lattitude', longitude = '$longitude', last_update = '$fgDate', lattitude_list = '$lattitude_list', longitude_list = '$longitude_list', last_last_update = '$last_last_update' WHERE job_id = '$this->id'";
		print_r($sql);

		if (mysqli_query($conn, $sql)) {
			print_r("Record updated successfully");
		} else {
			print_r("Error updating record: " . mysqli_error($conn));
		}
	}
	
	function getLocation() {		
		$result = null;
		
		// opening db connection
		$db = new Connection();
		$conn = $db->connect();
		
		//if(!Vehicle::exists($conn, $vehicle_number)) return $result;
		
		$sql = "SELECT * FROM location WHERE job_id = '$this->id'";
		$action = mysqli_query($conn, $sql);
		

		if (mysqli_num_rows($action) > 0) {
			// output data of each row
			while($row = mysqli_fetch_assoc($action)) {
				$result = array(
					"id" => $row['id'],
					"lattitude" => $row['lattitude'],
					"longitude" => $row['longitude'],
					"lattitude_list" => $row['lattitude_list'],
					"longitude_list" => $row['longitude_list'],
					"last_update" => $row['last_update'],
					"last_last_update" => $row['last_last_update'],
				);
			}
		}
		return $result;
	}
	
	function getOrderList() {
		// opening db connection
		$db = new Connection();
		$conn = $db->connect();
		
		$company_id = $_SESSION['user']['company'];
		$result = array();
		
		$sql = "SELECT id FROM `order` WHERE job_id='$this->id' AND company_id = '$company_id'";
		//echo "--->".$sql;
		$action = mysqli_query($conn, $sql);

		if (mysqli_num_rows($action) > 0) {
		while($row = mysqli_fetch_assoc($action)) {
				//echo $row['id'];
				array_push($result, $row['id']);
			}
		}
		//echo sizeof($result)."    < size";
		return $result;
	}
	
	function setCompleted() {
		// opening db connection
		$db = new Connection();
		$conn = $db->connect();

		$sql = "UPDATE job SET status = '1' WHERE id = '$this->id'";
		$action = mysqli_query($conn, $sql);

		if (mysqli_query($conn, $sql)) {
			echo "company added";
		} else {
			echo "company not added!!!";
		}
		$this->status = 1;
	}

	function getId(){
		return $this->id;
	}
	
	function getCode(){
		return $this->jobCode;
	}
	
	function getDriver(){
		return $this->driverId;
	}
	
	function getVehicle(){
		return $this->vehicleId;
	}
	
	function getTitle(){
		return $this->title;
	}
	
    function getStatus(){
		return $this->status;
	}
}


?>