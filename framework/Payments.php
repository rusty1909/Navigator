<?php
require_once 'Vehicle.php';
require_once 'Mailer.php';
require_once 'Company.php';
require_once 'User.php';

define('DEF_MEM_AMOUNT', '6000');

class Payments {
	private $id;
	private $companyId;
    private $userId;
	private $vehicleNumber;
    
    private $totalpayment;
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
		
		 // opening db connection
		$db = new Connection();
		$conn = $db->connect();
        
		$sql = "SELECT * FROM payments WHERE ( vehicle_id='$veh_id' AND company_id='$com_id' )";
      	$action = mysqli_query($conn, $sql);

        $this->id = 0;
      	if (mysqli_num_rows($action) > 0) {
			while($row = mysqli_fetch_assoc($action)) {
				if($this->id < $row['id']){ //update only most recent activity....
                    $this->id = $row['id'];
                    $this->vehicleNumber = $row['vehicle_id'];
                    $this->companyId = $row['company_id'];
                    $this->companyId = $row['user_id'];

                    $this->totalpayment = $row['total_amount'];
                    $this->paidpayment = $row['paid_amount'];
                    $this->duepaymentfornextmonth = $row['rest_amount'];
                    $this->restpayment = $row['rest_amount'];
                    $this->paymentPercentage = $row['paid_perc'];

                    $this->paymenttype = $row['pay_type'];
                    $this->paymentstatus = $row['is_success'];

                    $this->vehActivationDate = $row['veh_activation_date'];

                    $this->prevpaymentDate = $row['timestamp'];
                    $this->nextpaymentDate = $row['timestamp'];
                }
               
			}
		}
	}
	
    public static function add($amount, $is_success, $pay_type, $veh_id) {
		
		$companyId = $_SESSION['user']['company'];
		$userId = $_SESSION['user']['id'];
		
        $db = new Connection();
		$conn = $db->connect();
		$act_date = null;
        
        if($pay_type == 'activation'){
            $paid_amount = 0;
            $act_date = now();
        }else{
            $act_date = Payments::getVehicleActivationDate($veh);
            $paid_amount = Payments::getPreviousPaymentForVehicle($veh_id, $companyId);
        }
        $total_amount = DEF_MEM_AMOUNT;
        $paid_amount += $amount;
     
        $paid_per = 100 - (($total_amount - $paid_amount)/$total_amount)*100;
        $rest_amount = $total_amount - $paid_amount;
        
		$sql = "INSERT INTO `payments`(`amount`, `company_id`, `user_id`, `timestamp`, `is_success`, `pay_type`, `rest_amount`, `paid_perc`, `paid_amount`, `total_amount`, `vehicle_id`, `veh_activation_date`) VALUES  ('$amount','$companyId','$userId',now(),'$is_success','$pay_type','$rest_amount','$paid_per','$paid_amount','$total_amount', '$veh_id', '$act_date')";
		
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
       $this->totalpayment;// return 6000; //default for each vehicle...
    }
    
	function getPaidpayment(){
		return $this->paidpayment;
	}
	
	function getDuepayment(){
		return $this->duepaymentfornextmonth;
	}
    
    public static function getVehicleActivationDate($veh){
        $conn = (new Connection())->connect();
		$sql = "SELECT * FROM payments WHERE vehicle_id='$veh_id'";
      	$action = mysqli_query($conn, $sql);

        $payments = 0;
      	if (mysqli_num_rows($action) > 0) {
			while($row = mysqli_fetch_assoc($action)) {
                return $row['veh_activation_date'];
			}
		}
        return $payments;
    }
    
	public static function getPreviousPaymentForVehicle($veh_id, $com_id){
        $conn = (new Connection())->connect();
		$sql = "SELECT * FROM payments WHERE ( vehicle_id='$veh_id' AND company_id='$com_id' )";
      	$action = mysqli_query($conn, $sql);

        $payments = 0;
      	if (mysqli_num_rows($action) > 0) {
			while($row = mysqli_fetch_assoc($action)) {
                $payments += $row['amount'];
               
			}
		}
        
        return $payments;
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

//Payments::add('600', '1', 'qw', '121');
?>