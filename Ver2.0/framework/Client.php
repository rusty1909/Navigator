<?php

error_reporting(E_ALL);
ini_set('display_errors',1);

if(!isset($_SESSION))
	session_start();

require_once 'Connection.php';

class Client {
	private $id;
	private $name;
	private $contactPerson;
	private $phone;
	private $email;
	private $website;
	private $address;
	private $city;
	private $state;
	private $pincode;
	private $companyId;
	private $addedBy;
	private $description;
	private $dateAdded;
	
	function __construct($id){
		//require_once '../framework/DBConnect.php';
		
		// opening db connection
		$db = new Connection();
		$conn = $db->connect();

		$sql = "SELECT * FROM client WHERE id='$id'";
		$action = mysqli_query($conn, $sql);

		if (mysqli_num_rows($action) > 0) {
			while($row = mysqli_fetch_assoc($action)) {
				$this->id = $row['id'];
				$this->name = $row['name'];
				$this->contactPerson = $row['contact_person'];
				$this->phone = $row['phone'];
				$this->email = $row['email'];
				$this->website = $row['website'];
				$this->address = $row['address'];
				$this->city = $row['city'];
				$this->state = $row['state'];
				$this->pincode = $row['pincode'];
				$this->companyId = $row['company_id'];
				$this->addedBy = $row['added_by'];
				$this->description = $row['description'];
				$this->dateAdded = $row['date_added'];
			}
		}
	}
	
	public static function add($name, $contact_person, $phone, $email, $website, $address, $city, $state, $pincode, $description) {
		//require_once '../framework/DBConnect.php';
		
		// opening db connection
		$db = new Connection();
		$conn = $db->connect();
		
		//if(Driver::exists($conn, $name, $phone)) return false;
		$companyId = $_SESSION['user']['company'];
		$userId = $_SESSION['user']['id'];
		
		$sql = "INSERT INTO client (name, contact_person, phone, email, website, address, city, state, pincode, description, company_id, added_by) 
					VALUES ('$name', '$contact_person', '$phone', '$email', '$website', '$address', '$city', '$state', '$pincode', '$description', '$companyId', '$userId')";
		//echo $sql;
		if (mysqli_query($conn, $sql)) {
			return true;
		} else {
			return false;
		}
	}
	
	function delete() {
		//require_once '../framework/DBConnect.php';
		
		// opening db connection
		$db = new Connection();
		$conn = $db->connect();
		
		//if(!Driver::exists($conn, $driver)) return false;
		
		// sql to delete a record
		$sql = "UPDATE client SET status = '0' WHERE id='$this->id'";

		if (mysqli_query($conn, $sql)) {
			return true;
		} else {
			return false;
		}
	}

	
    function getOrderList($vehicle_number, $lattitude, $longitude) {
		//require_once '../framework/DBConnect.php';
		
		$result = array();
		
		// opening db connection
		$db = new Connection();
		$conn = $db->connect();
		
		//if(!Driver::exists($conn, $vehicle_number)) return $result;
		
		$sql = "SELECT id FROM order WHERE client_id = '$this->id'";
		$action = mysqli_query($conn, $sql);
		

		if (mysqli_num_rows($action) > 0) {
			// output data of each row
			while($row = mysqli_fetch_assoc($action)) {
				array_push($result, $row['id']);
			}
		}
		return $result;
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

	function getId() {
		return $this->id;
	}
	
	function getName(){
		return $this->name;
	}
	
	function getPhone(){
		return $this->phone;
	}
	
	function getAddress(){
		return $this->address.", ".$this->city.", ".$this->state." - ".$this->pincode;
	}

	function getWebsite(){
		return $this->website;
	}
	
	function getEmail(){
		return $this->email;
	}

}
?>