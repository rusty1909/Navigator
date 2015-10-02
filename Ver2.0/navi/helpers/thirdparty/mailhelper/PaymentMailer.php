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
            $this->db = (new Connection());
            $this->conn = $this->db->connect();
        }
    
    function  getUserId(){
        return $this->admin;
    }
   
    
    function SendPaymentReceivedMessage($paymetID, $amount,$pay_type, $paymentmethod, $paymentdescription, $is_success, $vehActivated, $vehDuePaid){
        
        $message = "Dear ".$this->admin->getFullName().",<br /><br />

        Payment Transaction Details are given below :<br /><br />
        Payment Transaction Code : {$pay_type} <br />
        Payment Transaction Mode : {$paymentmethod} <br />
        Payment Transaction Description: {$paymentdescription} <br /><br />
        Payment Transaction ID: {$paymetID} <br /><br />";
        
        if($is_success){
            $message .= "Number of Vehicles Activated : {$vehActivated}  <br /><br />

            Due Payment Done For Vehicles : {$vehDuePaid}  <br /><br />

            Payment Transaction Time : {$this->db->getTimeNow()} <br />

            Premium Service Start Date : {$this->db->getTimeNow()} <br />

            Next Premium Date : {$this->db->getTimeNow('+1 month')} <br />
         ";

        }
        $message = Mailer::makeMessage($message); 
        
        
        if($is_success)
            return $this->SendPaymentSuccess($message);
        else
            return $this->SendPaymentFailure($message);
        
        return false;
    }
    
    function SendPaymentSuccess($message){
       $subject = "Payment Transaction with ". WEB_FULL_NAME . " was successfull !!!";
        
       return Mailer::SendMail($this->admin->getEmail(), $subject, $message);
    }
    
    function SendPaymentFailure($message){
       $subject = "Payment Transaction with ". WEB_FULL_NAME . " was not successfull !!!";
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