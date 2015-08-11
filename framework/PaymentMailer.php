<?php
require_once 'Vehicle.php';
require_once 'Mailer.php';
require_once 'Company.php';
require_once 'User.php';


class PaymentMailer{

    private $company;
    private $admin;
    private $conn;
    
    function __construct() {

            $cmp = $_SESSION['user']['company'];

            $this->company = new Company($cmp);
            $this->admin = new User($this->company->getAdmin());
            $this->conn = (new Connection())->connect();
        }
    
    function  getUserId(){
        return $this->admin;
    }
   
    
    function SendPaymentReceivedMessage($amount,$pay_type, $paymentmethod, $paymentdescription, $is_success){
        
        $message = "Dear ".$this->admin->getFullName().",<br /><br />

        Payment Transaction Details are given below :<br /><br />
        Payment Transaction Type : {$paymentmethod} <br />
        Payment Transaction Mode : {$paymentmethod} <br />
        Payment Transaction Time : {$this->conn->getTimeNow()} <br /><br />
        Payment Transaction ID: {$paymentdescription} <br /><br />
        Payment Transaction Description: {$paymentdescription} <br /><br />
        
        Premium Service Start Date : {$this->conn->getTimeNow()} <br /><br />

        Premium Service End Date : {$this->conn->getTimeNow()} <br /><br />

        Expected Payment Amount For Next Month : {$this->conn->getTimeNow()} <br /><br />

        ";


        $message = Mailer::makeMessage($message); 
        
        
        
        
        
        
        if($is_success)
            return SendPaymentSuccess($message);
        else
            return SendPaymentFailure($message);
        
        return false;
    }
    
    function SendPaymentSuccess($message){
       $subject = "Payment Transaction with ". WEB_FULL_NAME . "was successfull !!!";
        
       return Mailer::SendMail($this->admin->getEmail(), $subject, $message);
    }
    
    function SendPaymentFailure($message){
       $subject = "Payment Transaction with ". WEB_FULL_NAME . "was not successfull !!!";
       return Mailer::SendMail($this->admin->getEmail(), $subject, $message);
    }
    

    function sendPaymentReminder(){
        $subject = 'Vehicle Payment Reminder with' . WEB_FULL_NAME;

        $message = "Dear ".$this->admin->getFullName().",<br /><br />

        You are using our premium services from {$this->vehicle->getVehicleDepolyDate()} .<br />

        Vehicle was Added Under Company : {$this->company->getName()}<br /><br />

        Vehicle was Added By : {$addedby->getFullName()}<br /><br />

        Vehicle Details :<br /><br />
        Vehicle Type : {$this->vehicle->getType()} <br />
        Vehicle Model : {$this->vehicle->getModel()} <br />
        Make Year: {$this->vehicle->getMakeYear()} <br /><br />
        Vehicle Number: {$this->vehicle->getVehicleNumber()} <br /><br />
        Description: {$this->vehicle->getType()} <br /><br />
        Adding Date : {$this->vehicle->getDateAdded()} <br /><br />

        Vehicle Activate Date : {$this->vehicle->getVehicleDepolyDate()} <br /><br />

        Premium Service Start Date : {$this->vehicle->getVehicleDepolyDate()} <br /><br />

        Premium Service End Date : {$this->vehicle->getVehicleDepolyDate()} <br /><br />

        Payment Done Till Today :{$this->vehicle->getVehicleDepolyDate()} <br /><br />

        Expected Payment Amount :{$this->vehicle->getVehicleDepolyDate()} <br /><br />

        ";


        $message = Mailer::makeMessage($message); 
        
        return Mailer::SendMail($this->admin->getEmail(), $subject, $message);

     }

}
?>