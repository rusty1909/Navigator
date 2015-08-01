<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

if(!isset($_SESSION))
	session_start();
require_once 'Connection.php';

class Driver {
	private $id;
	private $name;
	private $phone;
	private $address;
	private $status;
	private $companyId;
	private $addedBy;
	private $description;
	private $dateJoin;
	private $dateSeparate;
	
	function __construct($id){
		//require_once '../framework/DBConnect.php';
		
		// opening db connection
		$db = new Connection();
		$conn = $db->connect();

		$sql = "SELECT * FROM driver WHERE id='$id'";
		$action = mysqli_query($conn, $sql);

		if (mysqli_num_rows($action) > 0) {
			while($row = mysqli_fetch_assoc($action)) {
				$this->id = $row['id'];
				$this->name = $row['name'];
				$this->phone = $row['phone'];
				$this->address = $row['address'];
				$this->status = $row['status'];
				$this->companyId = $row['company_id'];
				$this->addedBy = $row['added_by'];
				$this->description = $row['description'];
				$this->dateJoin = $row['date_join'];
				$this->dateSeparate = $row['date_separate'];
			}
		}
	}
	
	public static function add($name, $phone, $address, $description, $dateJoin) {
		//require_once '../framework/DBConnect.php';
		
		// opening db connection
		$db = new Connection();
		$conn = $db->connect();
		
		//if(Driver::exists($conn, $name, $phone)) return false;
		$companyId = $_SESSION['user']['company'];
		$userId = $_SESSION['user']['id'];
		
		$sql = "INSERT INTO driver (name, phone, address, date_join, description, company_id, added_by) 
					VALUES ('$name', '$phone', '$address', '$dateJoin', '$description', '$companyId', '$userId')";
		echo $sql;
		if (mysqli_query($conn, $sql)) {
			return true;
		} else {
			return false;
		}
	}
	
	function delete($id) {
		//require_once '../framework/DBConnect.php';
		
		// opening db connection
		$db = new Connection();
		$conn = $db->connect();
		
		//if(!Driver::exists($conn, $driver)) return false;
		
		// sql to delete a record
		$sql = "UPDATE driver SET status = '0' WHERE id='$id'";

		if (mysqli_query($conn, $sql)) {
			return true;
		} else {
			return false;
		}
	}

    function getCurrentVehicle(){
		
		// opening db connection
		$db = new Connection();
		$conn = $db->connect();
		
		$sql = "SELECT id FROM vehicle WHERE driver = '$this->id'";
		$action = mysqli_query($conn, $sql);		

		if (mysqli_num_rows($action) > 0) {
			while($row = mysqli_fetch_assoc($action)) {
				return $row['id'];
			}
		}
		return 0;
	}
	
	function getCurrentJob() {
		//require_once '../framework/DBConnect.php';
		
		$job = null;
		
		// opening db connection
		$db = new Connection();
		$conn = $db->connect();
		
		//if(!Driver::exists($conn, $vehicle_number)) return $result;
		
		$sql = "SELECT id FROM job WHERE driver_id = '$this->id' AND status = '0'";
		$action = mysqli_query($conn, $sql);
		

		if (mysqli_num_rows($action) > 0) {
			// output data of each row
			while($row = mysqli_fetch_assoc($action)) {
				$job = $row['id'];
			}
		}
		return $job;
	}
	
    function getPreviousJobList() {
		//require_once '../framework/DBConnect.php';
		
		$job = array();
		
		// opening db connection
		$db = new Connection();
		$conn = $db->connect();
		
		//if(!Driver::exists($conn, $vehicle_number)) return $result;
		
		$sql = "SELECT id FROM job WHERE driver_id = '$this->id' AND status = '1'";
		$action = mysqli_query($conn, $sql);
		

		if (mysqli_num_rows($action) > 0) {
			// output data of each row
			while($row = mysqli_fetch_assoc($action)) {
				array_push($job, $row['id']);
			}
		}
		return $job;
	}
	
	public static function exists($conn, $name, $phone) {
		$sql = "SELECT id FROM vehicle WHERE name = '$name' AND phone = '$phone'";
		$action = mysqli_query($conn, $sql);

		if (mysqli_num_rows($action) > 0) {
			return true;
		}
		return false;		
	}
	
	function search($customer_id, $type, $model, $vehicle_number, $destination, $deployed) {
		
	}


	function getId(){
		return $this->id;
	}
	
	function getName(){
		return $this->name;
	}
	
	function getPhone(){
		return $this->phone;
	}
	
	function getAddress(){
		return $this->address;
	}

	function getJoiningDate(){
		return $this->dateJoin;
	}
	
	function getSeparationDate(){
		return $this->dateSeparate;
	}

}
?>