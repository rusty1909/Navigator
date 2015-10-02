<?php
require_once 'Vehicle.php';
require_once 'Mailer.php';
require_once 'Company.php';
require_once 'User.php';


class VehicleMailer{

    private $vehicle;
    private $company;
    private $admin;
    
    function __construct($id) {

            $cmp = $_SESSION['user']['company'];

            $this->vehicle = new Vehicle($id);
            $this->company = new Company($cmp);
            $this->admin = new User($this->company->getAdmin());
        }

    function sendVehicleAddedMessage(){

            $addedby = new User($this->vehicle->getAddedBy());    

            $subject = 'Vehicle Added with ' . WEB_FULL_NAME;

            $message = "Dear ".$this->admin->getFullName().",<br /><br />

            You have successfully added vehicle with us.<br />


            Vehicle Added Under Company : {$this->company->getName()}<br /><br />

            Vehicle Added By : {$addedby->getFullName()}<br /><br />

            Vehicle Details :<br /><br />
            Vehicle Type : {$this->vehicle->getType()} <br />
            Vehicle Model : {$this->vehicle->getModel()} <br />
            Make Year: {$this->vehicle->getMakeYear()} <br /><br />
            Vehicle Number: {$this->vehicle->getVehicleNumber()} <br /><br />
            Description: {$this->vehicle->getType()} <br /><br />
            Adding Date : {$this->vehicle->getDateAdded()} <br /><br />

            Activate your vehicle account at ".WEB_FULL_NAME."<br />";

            $message = Mailer::makeMessage($message); 

//           if(mail($this->admin->getEmail(), $subject, $message, activation_headers)) {
//               return true;
//           }else {		
//               return false;
//            }
        
        return Mailer::SendMail($this->admin->getEmail(), $subject, $message);
        }

    function sendVehicleActivatedMessage(){

            $addedby = new User($this->vehicle->getAddedBy());    

            $subject = 'Vehicle Activated with ' . WEB_FULL_NAME;

            $message = "Dear ".$this->admin->getFullName().",<br /><br />

            You have successfully activated vehicle with us.<br />


            Vehicle Added Under Company : {$this->company->getName()}<br /><br />

            Vehicle Added By : {$addedby->getFullName()}<br /><br />

            Vehicle Details :<br /><br />
            Vehicle Type : {$this->vehicle->getType()} <br />
            Vehicle Model : {$this->vehicle->getModel()} <br />
            Make Year: {$this->vehicle->getMakeYear()} <br /><br />
            Vehicle Number: {$this->vehicle->getVehicleNumber()} <br /><br />
            Description: {$this->vehicle->getType()} <br /><br />
            Adding Date : {$this->vehicle->getDateAdded()} <br /><br />

            Vehicle Activate Date : {$this->vehicle->getVehicleDepolyDate()} <br /><br />";

            $message = Mailer::makeMessage($message); 

           return Mailer::SendMail($this->admin->getEmail(), $subject, $message);
        }

    function sendVehicleDeletedMessage(){

            $addedby = new User($this->vehicle->getAddedBy());    

            $subject = 'Vehicle Deleted with ' . WEB_FULL_NAME;

            $message = "Dear ".$this->admin->getFullName().",<br /><br />

            You have successfully removed vehicle with us.<br />


            Vehicle Added Under Company : {$this->company->getName()}<br /><br />

            Vehicle Added By : {$addedby->getFullName()}<br /><br />

            Vehicle Details :<br /><br />
            Vehicle Type : {$this->vehicle->getType()} <br />
            Vehicle Model : {$this->vehicle->getModel()} <br />
            Make Year: {$this->vehicle->getMakeYear()} <br /><br />
            Vehicle Number: {$this->vehicle->getVehicleNumber()} <br /><br />
            Description: {$this->vehicle->getType()} <br /><br />
            Adding Date : {$this->vehicle->getDateAdded()} <br /><br />

            Vehicle Activate Date : {$this->vehicle->getVehicleDepolyDate()} <br /><br />

            Vehicle Deactivate Date : {$this->vehicle->getVehicleDeActivatedDate()} <br /><br />";

            $message = Mailer::makeMessage($message); 

           return Mailer::SendMail($this->admin->getEmail(), $subject, $message);
        }

    function sendPaymentReminder(){
        $subject = 'Vehicle Payment Reminder with ' . WEB_FULL_NAME;

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