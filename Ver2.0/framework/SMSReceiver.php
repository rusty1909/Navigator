<?php

require_once 'SMS.php';

class SMSReceiver {
    private $sms;
    private $db;
    private $conn;

    function __construct() {
        $this->db = new Connection();
        $this->conn = $this->db->connect();
        
        $this->sms = new SMS();
        
    }
    
    function VerifyFields($keyword, $mobile, $mess){
        if(strtolower($keyword) != strtolower('findgaddi')){
            return false;
        }
        
        if(strlen($mobile) < 10){
            return false;
        }
    
        if(strlen($mess) < 10){
            return false;
        }
    }
    
    function ProcessMessage($mess){
        $action = strtolower($mess);
        
        $pieces = explode(" ", $data);
        $code = $pieces[0];
        
        $message = $pieces[1];
            
        switch($code) {
                case "driver" :{
                }
                break;
                case "vehicle" :{
                }
                break;
                case "location" :{
                }
                break;
                case "sm" :{
                }
                break;
                
        }
    }
    
    function ProcessData($keyword, $mobile, $mess){
        if($this->VerifyFields($keyword, $mobile, $mess)){
            $msg = $this->ProcessMessage($mess);
            return $this->sms->sendSms($mobile, $msg);
        }
        return false;
    }
    
}


?>