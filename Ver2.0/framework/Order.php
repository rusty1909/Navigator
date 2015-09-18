<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

if(!isset($_SESSION))
	session_start();
require_once 'Connection.php';
require_once 'User.php';


class Order {
	private $id;
	private $orderCode;
	private $title;
	private $clientId;
	private $jobId;
	private $destination;
	private $isDelivered;
	private $description;
	private $dateAdded;
	private $dateDelivered;
	
	function __construct($id) {
		// opening db connection
		$db = new Connection();
		$conn = $db->connect();

		$sql = "SELECT * FROM `order` WHERE id='$id'";
		//echo $sql;
		$action = mysqli_query($conn, $sql);

		if (mysqli_num_rows($action) > 0) {
			while($row = mysqli_fetch_assoc($action)) {
				$this->id = $row['id'];
				$this->orderCode = $row['order_code'];
				$this->title = $row['title'];
				$this->clientId = $row['client_id'];
				$this->jobId = $row['job_id'];
				$this->destination = $row['destination'];
				$this->isDelivered = $row['delivered'];
				$this->description = $row['description'];
				$this->dateAdded = $row['date_added'];
				$this->dateDelivered = $row['date_delivered'];
			}
		}
	}
	
	function add($title, $client, $destination, $description) {
		// opening db connection
		$db = new Connection();
		$conn = $db->connect();
		
		//user details
		$userId = $_SESSION['user']['id'];
		$companyId = $_SESSION['user']['company'];
		
		$todaysOrders = Order::getTodaysOrders($companyId);
		$orderCode = "ORD-".date('Ymd')."-".($todaysOrders+1);
		$date = date('Y-m-d');
		
		$sql = "INSERT INTO `order` (order_code, title, client_id, destination, description, company_id, added_by, date_added) VALUES ('$orderCode', '$title', '$client', '$destination', '$description', '$companyId', '$userId', '$date')";
		echo $sql;
		if (mysqli_query($conn, $sql)) {
			return true;
		} else {
			echo "error";
			return false;
		}
	}
	
	public static function getTodaysOrders($companyId) {
		// opening db connection
		$db = new Connection();
		$conn = $db->connect();
		
		$count = 0;
		$date = date('Y-m-d');
		
		$sql = "SELECT id FROM `order` WHERE company_id='$companyId' AND date_added='$date'";
		//echo "-->".$sql;
		$action = mysqli_query($conn, $sql);
		if (mysqli_num_rows($action) > 0) {
			while($row = mysqli_fetch_assoc($action)) {
				$count++;
			}
		}
		return $count;
	}

	function getId() {
		return $this->id;
	}
	
	function getCode() {
		return $this->orderCode;
	}
	
	function getClient() {
		return $this->clientId;
	}
	function getTitle() {
		return $this->title;
	}
	
	function getDestination() {
		return $this->destination;
	}
}



?>