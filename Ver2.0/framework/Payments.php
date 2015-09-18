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
    
	private $paymetID;
    
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

                    $this->vehActivationDate = $row['veh_activation_date'];
                    
                    $this->paymenttype = $row['pay_type'];
                    $this->paymentstatus = $row['is_success'];

                }
               
			}
		}
	}
	
    function getExpectedPaymentDone(){
   
        $diff1 = $this->getVehicleRunningDuration();
        
        $expextedPaidAmount = $diff1 * $this->getVehicleMonthlyDueAmount();
        
        return $expextedPaidAmount;
    }
    
    function isDue(){
        $amountPaid = $this->getPaidpayment();
        $amountPaid = $amountPaid - $this->getVehicleActivationAmount();
        
        $expextedPaidAmount = $this->getExpectedPaymentDone();
            
        if($expextedPaidAmount >= $amountPaid + $this->getVehicleMonthlyDueAmount())
            return $expextedPaidAmount - $amountPaid;
        
        if($expextedPaidAmount > $amountPaid)
            return $expextedPaidAmount - $amountPaid  + $this->getVehicleMonthlyDueAmount();
        
        if($expextedPaidAmount < $amountPaid)
            return 0;
        
    }
    
    public static function add($paymetID, $amount, $is_success, $pay_type, $veh_id) {
		
		$companyId = $_SESSION['user']['company'];
		$userId = $_SESSION['user']['id'];
		
        $db = new Connection();
		$conn = $db->connect();
	    $paytime = $db->getTimeNow();
        
        if($pay_type == 2){
            $paid_amount = 0;
            $act_date = $paytime;
        }else{
            $act_date = Payments::getVehicleActivationDateFromDB($veh_id);
            $paid_amount = Payments::getPreviousPaymentForVehicle($veh_id, $companyId);
        }
        $total_amount = DEF_MEM_AMOUNT;
        $paid_amount += $amount; 
     
        $paid_per = 100 - (($total_amount - $paid_amount)/$total_amount)*100;
        $rest_amount = $total_amount - $paid_amount;
        
		$sql = "INSERT INTO `payments`(`amount`, `company_id`, `user_id`, `timestamp`, `is_success`, `pay_type`, `rest_amount`, `paid_perc`, `paid_amount`, `vehicle_id`, `total_amount`, `veh_activation_date`, `paymentId`) VALUES ('$amount','$companyId','$userId','$paytime','$is_success','$pay_type','$rest_amount','$paid_per','$paid_amount', '$veh_id', '$total_amount', '$act_date', '$paymetID')";
		
		if (mysqli_query($conn, $sql)) {
			return true;
		} else {
           return mysqli_error($conn);
		}
        
        return false;
	}
	
	function delete() {
		
		// opening db connection
		$db = new Connection();
		$conn = $db->connect();
		
        if($this->isDeployed())
            return false;
        
        $sql = "UPDATE vehicle SET date_deactivate = now() WHERE id = '$this->id'";
        mysqli_query($conn, $sql);
            
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
    
    function  getVehicleActivationAmount(){
        return 3000;
    }
    
    function  getVehicleMonthlyDueAmount(){
        return 600;
    }
    
    function getDateofMonthEnd($date){
      // $ts2 = date('Y-m-d' , $date);
       return  date("Y-m-t", strtotime($date));
    }
    
        
    function getMonthsCountOfVehicleRun(){
        $ts1 = strtotime($this->getVehicleActivationDate());
        $ts2 = strtotime($this->getDateofMonthEnd(time()));

        $year1 = date('Y', $ts1);
        $year2 = date('Y', $ts2);

        $month1 = date('m', $ts1);
        $month2 = date('m', $ts2);

        $diff = (($year2 - $year1) * 12) + ($month2 - $month1);
        return $diff;
    }
    
    function getDaysCountSinceVehicleActivation(){
        $ts1 = strtotime($this->getVehicleActivationDate());
        $ts2 = strtotime($this->getDateofMonthEnd($ts1));

        $year1 = date('Y', $ts1);
        $year2 = date('Y', $ts2);
        
        $month1 = date('m', $ts1);
        $month2 = date('m', $ts2);

        $date1 = date('d', $ts1);
        $date2 = date('d', $ts2);

        
        $diff =  (($year2 - $year1) * 12) + (($month2 - $month1)*30) +  ($date2 - $date1);
        $x =  ceil($diff/$date2);
        return $x;
    }
    
    function getVehicleRunningDuration(){
        return $this->getDaysCountSinceVehicleActivation() +  $this->getMonthsCountOfVehicleRun();
    }

    function getTotalAmount(){
       return DEF_MEM_AMOUNT; //$this->totalpayment;// return 6000; //default for each vehicle...
    }
    
	function getPaidpayment(){
		return $this->paidpayment;
	}
	
	function getDuepayment(){
		return $this->duepaymentfornextmonth;
	}
    
    public static function getVehicleActivationDateFromDB($veh_id){
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
		return strftime('Y-m-d', strtotime($this->vehActivationDate));
	}
	
    function getPrevPaymentDate(){
        return 	strftime('Y-m-d', strtotime($this->prevpaymentDate));
    }
    
    function getNextPaymentDate(){
        $activatDate = $this->getVehicleActivationDate();
    }
    
	function wasPaymentSuccessful() {
		return $this->paymentstatus;
	}
	
	function getPaymenttype() {
		return $this->paymenttype;
	}
    
}
?>