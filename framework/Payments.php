<?php
require_once 'Vehicle.php';
require_once 'Mailer.php';
require_once 'Company.php';
require_once 'User.php';

class Payments {
	private $id;
	private $companyId;
    private $userId;
	private $vehicleNumber;
    
	private $paidpayment; 
	private $duepaymentfornextmonth;
	private $restpayment;
    private $paymentPercentage;
    
    private $paymenttype;
    private $paymentstatus;
    
	private $vehActivationDate;
    
	private $prevpaymentDate;
	private $nextpaymentDate;
    
	
	function __construct($veh_id, $com_id){
		
		 if(empty($_SESSION['user']))
            return null;
        
		// opening db connection
		$db = new Connection();
		$conn = $db->connect();

		$sql = "SELECT * FROM payments WHERE id='$id'";
		$action = mysqli_query($conn, $sql);

		if (mysqli_num_rows($action) > 0) {
			while($row = mysqli_fetch_assoc($action)) {
				$this->id = $row['id'];
				$this->vehicleNumber = $row['vehicle_number'];
				$this->type = $row['type'];
				$this->model = $row['model'];
				$this->makeYear = $row['make_year'];
				$this->userId = $row['company_id'];
				$this->companyId = $row['company_id'];
				$this->isDeployed = $row['deployed'];
				$this->isOnJob = $row['on_job'];
				$this->addedBy = $row['added_by'];
				$this->description = $row['description'];
				$this->dateAdded = $row['date_added'];
				$this->address = $row['address'];
				$this->driver = $row['driver'];
				$this->city = $row['city'];
				$this->LatLong["lat"] = $row['lattitude'];
				$this->LatLong["long"] = $row['longitude'];
			}
		}
	}
	
	public static function add($vehicleNumber, $paidpayment, $restpayment, $paymenttype, $paymentstatus) {
		
		$companyId = $_SESSION['user']['company'];
		$userId = $_SESSION['user']['id'];
		
        $db = new Connection();
		$conn = $db->connect();
		
        
		$sql = "INSERT INTO payments (type, model, vehicle_number, make_year, company_id, added_by, description) VALUES ('$type','$model','$vehicle_number','$make_year','$companyId','$userId','$description')";
		
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
		
		//if(!Vehicle::exists($conn, $vehicle_number)) return false;
		
        if($this->isDeployed())
            return false;
        
        $sql = "UPDATE vehicle SET date_deactivate = now() WHERE id = '$this->id'";
        mysqli_query($conn, $sql);
            
		// sql to delete a record
        /*
		$sql = "DELETE FROM vehicle WHERE id='$this->id'";

		if (mysqli_query($conn, $sql)) {
			return true;
		} else {
			return false;
		}
        */
        
        return true;
	}
		
	function getId(){
		return $this->id;
	}

	function getVehicleNumber(){
		return $this->vehicleNumber;
	}

	function getCompany(){
		return $this->companyId;
	}
    
	function getUserId(){
		return $this->userId;
	}
    
    function getTotalAmount(){
        return 6000; //default for each vehicle...
    }
    
	function getPaidpayment(){
		return $this->paidpayment;
	}
	
	function getDuepayment(){
		return $this->duepaymentfornextmonth;
	}
    
	function getRemainingAmount(){
		return $this->restpayment;
	}
    
	function getVehicleActivationDate(){
		return strftime("%b %d, %Y", strtotime($this->vehActivationDate));
	}
	
    function getPrevPaymentDate(){
        return 	strftime("%b %d, %Y", strtotime($this->prevpaymentDate));
    }
    
    function getNextPaymentDate(){
        return 	strftime("%b %d, %Y", strtotime($this->nextpaymentDate));
    }
    
	function wasPaymentSuccessful() {
		return $this->paymentstatus;
	}
	
	function getPaymenttype() {
		return $this->paymenttype;
	}
    
}

?>