<?php
require_once 'Payments.php';

class PaymentHelper {
	private $id;
	private $companyId;
    private $userId;
    
	private $totalAmount; 
	private $totalReqAmount;
	private $totalPaidAmount;
    private $amountreqfornextcycle;
    
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
        
        for($i=0; $i<sizeof($mDeployedVehicleList); $i++) {
            $mVehicle = new Vehicle($mDeployedVehicleList[$i]);
            
            $mVehPayments = new Payments($mDeployedVehicleList[$i], $companyId);
            
            $this->totalAmount +=  $mVehPayments->getTotalAmount();       
            $this->totalPaidAmount +=  $mVehPayments->getPaidpayment();       
            $this->amountreqfornextcycle +=  $mVehPayments->getDuepayment();       
            $this->totalRemainingAmount +=  $mVehPayments->getRemainingAmount();       
            
		
        }
        
///calculate amount with respect to the previous deployed vehicels...
         $mPreviousVehicleList = $this->userId->getPreviousVehicleList();  //previous used vehicles...
       
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
    
    
	function getTotalPaidpayment(){
		return $this->totalPaidAmount;
	}
	
	function getDuepayment(){
		return $this->amountreqfornextcycle;
	}
    
	function getRemainingAmount(){
		return $this->totalReqAmount;
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