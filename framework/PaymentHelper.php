<?php
require_once 'Payments.php';
require_once 'ComPayments.php';

class PaymentHelper {
	private $id;
	private $companyId;
    private $userId;
    
	private $totalAmount; 
	private $totalReqAmount;
	private $totalPaidAmount;
    private $amountreqfornextcycle;
    private $activationamount;
    
    private $paymenttype;
    private $paymentstatus;
    
	private $vehActivationDate;
    
	private $prevpaymentDate;
	private $nextpaymentDate;
    
	
	function __construct(){
        
        if(empty($_SESSION['user']))
            return null;
        
        $this->companyId = $_SESSION['user']['company'];
        
        $this->userId = new User();
        $mDeployedVehicleList = $this->userId->getDeployedVehicleList(); //currently running vehicles...
        
        $this->activationamount = $this->totalAmount = $this->totalPaidAmount = $this->amountreqfornextcycle = $this->totalRemainingAmount =  0;
       
        
        for($i=0; $i<sizeof($mDeployedVehicleList); $i++) {
            $mVehicle = new Vehicle($mDeployedVehicleList[$i]);
            
            $mVehPayments = new Payments($mVehicle->getId(), $this->companyId);
            
            if($mVehPayments->getId() != ""){
                
                $this->totalAmount +=  $mVehPayments->getTotalAmount();       
                $this->totalPaidAmount +=  $mVehPayments->getPaidpayment();       
                $this->totalRemainingAmount +=  $mVehPayments->getRemainingAmount();       
               
                if($mVehPayments->isDue())
                    $this->amountreqfornextcycle +=  $mVehPayments->isDue();       
              
            }
		
        }
        
        ///calculate amount with respect to the initate vehicels...
         $mPreviousVehicleList = $this->userId->getWaitingVehicleList();  //previous used vehicles...
        
         for($i=0; $i<sizeof($mPreviousVehicleList); $i++) {
            $mVehicle = new Vehicle($mPreviousVehicleList[$i]);
            
            $mVehPayments = new Payments($mVehicle->getId(), $this->companyId);
            
            $this->activationamount +=  $mVehPayments->getVehicleActivationAmount();      
            
        }
       
	}
    	
	function getId(){
		return $this->id;
	}

	function getCompany(){
		return $this->companyId;
	}
    
	function getUserId(){
		return $this->userId;
	}
    
    function getTotalAmount(){
		return $this->totalAmount;
	}
	
	function getTotalPaidpayment(){
		return $this->totalPaidAmount;
	}
	
	function getDuepayment(){
		return $this->amountreqfornextcycle;
	}
    
    function getDuepaymentForActivation(){
		return $this->activationamount;
	}
    
	function getRemainingAmount(){
		return $this->getTotalAmount();
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
    
    function CreatePaymentID(){
        return $this->getCompany() . $this->getUserId() . time();
    }
    
    function ProcessPayment($amount, $pay_type, $paymentmethod, $paymentdescription, $is_success){
        $paymetID  = $this->CreatePaymentID();
        
        if(ComPayments::add($paymetID, $amount, $is_success, $pay_type, $paymentmethod, $paymentdescription)){
        
            if($is_success == '1'){
                $mDeployedVehicleList = $this->userId->getDeployedVehicleList(); //currently running vehicles...
                
                $amount /=  sizeof($mDeployedVehicleList);
                
                for($i=0; $i<sizeof($mDeployedVehicleList); $i++) {
                    Payments::add($paymetID, $amount, '1', $pay_type, $mDeployedVehicleList[$i]);
                }
            }
        }else{
            echo 'unable to process payments for company<br>';
            die();
        }
    
        return true;
    }
    
}
/*
$myPay = new PaymentHelper();
echo $myPay->ProcessPayment(11111, 1 , 12, 12, 1);
echo "<br>";
echo $myPay->getDuepayment(); 
*/
?>