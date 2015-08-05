<?php
require_once 'Vehicle.php';
require_once 'Mailer.php';
require_once 'Company.php';
require_once 'User.php';

class ComPayments {
	private $paymetID;
	private $companyId;
    private $userId;
	    
    private $amount;
	private $paymenttype; 
	private $paymentdate;
	private $is_success;
    private $paymentmethod;
    private $paymentdescription;
    
    private $ipinfo;
    private $deviceinfo;
    
	function __construct($paymetID){
		
		 // opening db connection
		$db = new Connection();
		$conn = $db->connect();
        
		$sql = "SELECT * FROM compayments WHERE paymetID='$paymetID'";
      	$action = mysqli_query($conn, $sql);

        $this->id = 0;
      	if (mysqli_num_rows($action) > 0) {
			while($row = mysqli_fetch_assoc($action)) {
				    $this->paymetID = $row['paymetID'];
                    $this->companyId = $row['companyId'];
                    $this->userId = $row['userId'];

                    $this->amount = $row['amount'];
                    $this->paymenttype = $row['paymenttype'];
                    $this->paymentdate = $row['paymentdate'];
                    $this->is_success = $row['is_success'];
                
                    $this->paymentmethod = $row['paymentmethod'];
                    $this->paymentdescription = $row['paymentdescription'];

                    $this->deviceinfo = $row['deviceinfo'];
                    $this->ipinfo = $row['ipinfo'];

			}
		}
	}
	
    public static function add($paymetID, $amount, $is_success, $pay_type, $paymentmethod, $paymentdescription) {
		if(!isset($_SESSION['user']))
		      return false;
            
        $db = new Connection();
		$conn = $db->connect();

        $companyId = $_SESSION['user']['company'];
		$userId = $_SESSION['user']['id'];
		
        $ip = $db->getIPAddress();
        $device_details = $db->getDeviceDetails();
               
		$sql = "INSERT INTO `compayments`(`paymetID`, `companyId`, `userId`, `amount`, `paymenttype`, `paymentdate`, `is_success`, `paymentmethod`, `paymentdescription`, `deviceinfo`, `ipinfo`) VALUES  ('$paymetID','$companyId','$userId', '$amount','$pay_type',now(),'$is_success','$paid_per','$paymentmethod','$paymentdescription', '$device_details', '$ip')";
		
		if (mysqli_query($conn, $sql)) {
			return true;
		} else {
			return false;
		}
	}
	 
		
	function getPaymentId(){
		return $this->paymetID;
	}

	function getCompany(){
		return $this->companyId;
	}
    
	function getUserId(){
		return $this->userId;
	}
    
    function getTotalAmount(){
       $this->amount;
    }
    
	function getPaidpayment(){
		return $this->paidpayment;
	}
	
	function getDuepayment(){
		return $this->duepaymentfornextmonth;
	}
    
	function getPaymentMethod(){
		return $this->paymentmethod;
	}
	
	function getPayDescription(){
		return $this->paymentdescription;
	}
    
    function getDeviceInfo(){
		return $this->deviceinfo;
	}
	
	function getIP(){
		return $this->ipinfo;
	}
    

	function getPaymentDate(){
		return strftime("%b %d, %Y", strtotime($this->paymentdate));
	}
	
	function wasPaymentSuccessful() {
		return $this->is_success;
	}
	
	function getPaymenttype() {
		return $this->paymenttype;
	}
    
}

//Payments::add('600', '1', 'qw', '121');
?>