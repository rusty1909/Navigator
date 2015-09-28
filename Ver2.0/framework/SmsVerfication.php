<?php

require_once 'Connection.php';

define('MSG91_AUTH_KEY', "88276AGwzewOEdFs559d2888");
// sender id should 6 character long
define('MSG91_SENDER_ID', 'ANHIVE');

class SmsVerfication {
    
    private $db;
    private $conn;

    function __construct() {
        $this->db = new Connection();
        $this->conn = $this->db->connect();
    }
    
    public function createOtp($user_id, $otp) {
 
        // delete the old otp if exists
        $sql = "DELETE FROM sms_codes where user_id = '$user_id'";
        $action = mysqli_query($this->conn, $sql);
 
        $sql = "INSERT INTO sms_codes(user_id, code, status) values('$user_id', '$otp', '0')";
        $action = mysqli_query($this->conn, $sql);
       
        return $action;
    }
    
    public function otpGenerator(){
        return rand(100000, 999999);
    }
    
    public function sendOTPSms($mobile) {
     
        $otp = $this->otpGenerator();
        $otp_prefix = ':';
        
        $message = urlencode("Hello! Welcome to FindGaddi. Your OPT is '$otp_prefix $otp'");
        
        return $this->sendSms($mobile, $message);

    }
    
    public function sendSms($mobile, $message) {
     
        $response_type = 'json';

        //Define route 
        $route = "4";

        //Prepare you post parameters
        $postData = array(
            'authkey' => MSG91_AUTH_KEY,
            'mobiles' => $mobile,
            'message' => $message,
            'sender' => MSG91_SENDER_ID,
            'route' => $route,
            'response' => $response_type
        );

    //API URL
        $url = "https://control.msg91.com/sendhttp.php";

    // init the resource
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $postData
                //,CURLOPT_FOLLOWLOCATION => true
        ));


        //Ignore SSL certificate verification
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);


        //get response
        $output = curl_exec($ch);

        //Print error if any
        if (curl_errno($ch)) {
            echo 'error:' . curl_error($ch);
        }

        curl_close($ch);
    }
    
     public function activateUserStatus($user_id){
 
        $sql = "UPDATE sms_codes set status = 1 where user_id = '$user_id'";
        $action = mysqli_query($this->conn, $sql);
    }
}
?>