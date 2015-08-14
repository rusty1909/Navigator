<?php
require_once 'Payments.php';
require_once 'ComPayments.php';
require_once 'VehicleMailer.php';
require_once 'PaymentMailer.php';

/*
Payments code
1>> Due Amount
2>> Activation 
3>> Both
*/

class PaymentHelper {
	private $id;
	private $companyId;
    private $userId;
    
	private $totalAmount; 
	private $totalReqAmount;
	private $totalPaidAmount;
    private $amountreqfornextcycle;
    private $activationamount;
    
    private $vehList;
    private $vehListActivationReq;
    private $vehListPayReq;
    
    
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
       
        $this->vehListActivationReq = $this->vehListPayReq = $this->vehList = "";
        
        //calcultaion for deplyoed vehicles....
        for($i=0; $i<sizeof($mDeployedVehicleList); $i++) {
            $mVehicle = new Vehicle($mDeployedVehicleList[$i]);
            
            $this->vehListPayReq .= $mVehicle->getId() . ", "; 
         
            $mVehPayments = new Payments($mVehicle->getId(), $this->companyId);
            
            if($mVehPayments->getId() != ""){
                
                $this->totalAmount +=  $mVehPayments->getTotalAmount();       
                $this->totalPaidAmount +=  $mVehPayments->getPaidpayment();       
                $this->totalRemainingAmount +=  $mVehPayments->getRemainingAmount();       
               
                echo $mVehPayments->isDue();
                if($mVehPayments->isDue() != 0)
                    $this->amountreqfornextcycle +=  $mVehPayments->isDue();       
              
            }
		
        }
        
        ///calculate amount with respect to the initate vehicels...
         $mPreviousVehicleList = $this->userId->getWaitingVehicleList();  //previous used vehicles...
        
         for($i=0; $i<sizeof($mPreviousVehicleList); $i++) {
            $mVehicle = new Vehicle($mPreviousVehicleList[$i]);
             
            $this->vehListActivationReq .= $mVehicle->getId() . ", "; 
             
            $mVehPayments = new Payments($mVehicle->getId(), $this->companyId);
            
            $this->activationamount +=  $mVehPayments->getVehicleActivationAmount();      
            
        }
        
        $this->vehList = $this->vehListPayReq . $this->vehListActivationReq ;
       
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
        return $this->getCompany() . $this->getUserId()->getId() . time();
    }
    
    function ProcessPaymnetSucess($amount, $pay_type, $paymentmethod, $paymentdescription){
        $this->ProcessPayment($amount, $pay_type, $paymentmethod, $paymentdescription, true);
    }
    
    function ProcessPaymnetFailure($amount, $pay_type, $paymentmethod, $paymentdescription){
        $this->ProcessPayment($amount, $pay_type, $paymentmethod, $paymentdescription, false);
    }
   
    function ProcessActivatioPayment($paymetID, $amount){
        $mDeployedVehicleList = $this->userId->getWaitingVehicleList(); 
        $cnt = sizeof($mDeployedVehicleList);
        
        if($amount == 0 || $cnt ==0)
            return 0;
       
        
        $amount1 = $amount/$cnt;

        for($i=0; $i<$cnt; $i++) {
            Payments::add($paymetID, $amount1, 1, 2, $mDeployedVehicleList[$i]);
            $adder = new VehicleMailer($mDeployedVehicleList[$i]);
            $adder->sendVehicleActivatedMessage();
        }
        
        return $cnt;
    }
    
    function ProcessDuePayment($paymetID, $amount){
        $mDeployedVehicleList = $this->userId->getDeployedVehicleList(); 
        $cnt = sizeof($mDeployedVehicleList);
         if($amount == 0 || $cnt==0)
            return 0;
       
        $amount /=  $cnt;

        for($i=0; $i<$cnt; $i++) {
            Payments::add($paymetID, $amount, 1, 1, $mDeployedVehicleList[$i]);
        }
        return $cnt;
    }
    
    function ProcessPayment($amount, $pay_type, $paymentmethod, $paymentdescription, $is_success){
        $paymetID  = $this->CreatePaymentID();
        $vehActivated = $vehDuePaid = 0;
        
        if(ComPayments::add($paymetID, $amount, $is_success, $pay_type, $paymentmethod, $paymentdescription) && $is_success){
       
            if($pay_type == 3 ){ //Both payments....
               $vehActivated =  $this->ProcessActivatioPayment($paymetID, $this->getDuepaymentForActivation());
               $vehDuePaid =  $this->ProcessDuePayment($paymetID, $amount - $this->getDuepaymentForActivation());
            }else if(($pay_type == 2 )){  //vehicle need activcation only....
               $vehActivated =    $this->ProcessActivatioPayment($paymetID, $amount);
            }else if(($pay_type == 1 )){  //only Due Payment
               $vehDuePaid = $this->ProcessDuePayment($paymetID, $amount);
            }
            
        }else{
         //   echo 'unable to process payments for company<br>';
        //   return false;// die();
        }
    
        $payProcessmailer = new PaymentMailer();
        $payProcessmailer->SendPaymentReceivedMessage($paymetID, $amount,$pay_type, $paymentmethod, $paymentdescription, $is_success, $vehActivated, $vehDuePaid);
        
        
        return true;
    }
    
    function SetPaymentType(){
    
    }
    
    function GetPaymentCode(){
            /* Payment Code Generation... */
        if($this->getDuepaymentForActivation() && $this->getDuepayment()){
            //both paymenst are non zero
            $vehPayInfo = 3;
        }else if($this->getDuepaymentForActivation()){
            $vehPayInfo = 2;
        }else if($this->getDuepayment()){
            $vehPayInfo = 1;
        }else{
         $vehPayInfo = 0;
        }
        
        return $vehPayInfo;
    }
    
    
    function GetVehicleList(){
            /* Payment Code Generation... */
       return $this->vehList;
    }
        
    function GetVehicleListActivationReq(){
            /* Payment Code Generation... */
       return $this->vehListActivationReq;
    }
    
    function GetVehicleListPaymentReq(){
            /* Payment Code Generation... */
       return $this->vehListPayReq;
    }
    
    function GetVehicleListByPayCode($p){
        if($p == 1){
            return $this->GetVehicleListPaymentReq();
        }else if($p == 2){
            return $this->GetVehicleListActivationReq();
        }else if($p == 3){
            return $this->GetVehicleListPaymentReq() .  $this->GetVehicleListActivationReq() ;
        }
        return "No Vehicles";
    }
    
    function GetPaymentByPayCode($p){
        if($p == 1){
            return $this->getDuepayment();
        }else if($p == 2){
            return $this->getDuepaymentForActivation();
        }else if($p == 3){
            return $this->getDuepayment() +  $this->getDuepaymentForActivation() ;
        }
        return 0;
    }
    
    function getJson($id){
        $vehlist = $this->GetVehicleListByPayCode($id);
        $getProdPrice = $this->GetPaymentByPayCode($id);

        $array = array($vehlist, $getProdPrice, $id);
        return json_encode( $array );
    }
    
}

?>