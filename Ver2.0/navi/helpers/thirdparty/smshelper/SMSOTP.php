<?php

require_once 'SMS.php';

class SMSOTP {
    private $sms;
    private $db;
    private $conn;

    function __construct() {
        $this->db = new Connection();
        $this->conn = $this->db->connect();
        
        $this->sms = new SMS();
        
    }
    
    function createOtp($user_id, $otp) {

        // delete the old otp if exists
        $sql = "DELETE FROM sms_codes where user_id = '$user_id'";
        $action = mysqli_query($this->conn, $sql);

        $sql = "INSERT INTO sms_codes(user_id, code, status) values('$user_id', '$otp', '0')";
        $action = mysqli_query($this->conn, $sql);

        return $action;
    }

    function otpGenerator(){
        return rand(100000, 999999);
    }

    public function sendOTPSMS($user_id, $mobile) {

        $otp = $this->otpGenerator();
        
        $this->createOtp($user_id, $otp);
        
        $message = urlencode("Hello! Welcome to FindGaddi. Your OPT is : $otp");

        return $this->sms->sendSms($mobile, $message);

    }
    
    public function activateUserStatus($user_id){
 
        $sql = "UPDATE sms_codes set status = 1 where user_id = '$user_id'";
        $action = mysqli_query($this->conn, $sql);
        
        return $action;
    }
    
}


?>