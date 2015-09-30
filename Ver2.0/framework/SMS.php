<?php

require_once 'Connection.php';

class SMS {
    private $authkey;
    private $senderID;
    private $route;
    private $url;
    
    private $db;
    private $conn;

    function __construct() {
        $this->db = new Connection();
        $this->conn = $this->db->connect();
        
        //init
        $this->senderID = "FGaddi";
        $this->authkey =  '93772AqJCNg0yia560bb59a';
        $this->route = "4";
        $this->url = "http://api.msg91.com/sendhttp.php";
        
    }
    
    private function prepareData($mobile, $message){
        $message = urlencode($message);
        
        $postData = array(
            'authkey' => $this->authkey,
            'mobiles' => $mobile,
            'message' => $message,
            'sender' => $this->senderID,
            'route' => $this->route
        );
        return $postData;
    }
    
    public function sendSms($mobile, $message) {
        $postData = $this->prepareData($mobile, $message);

        // init the resource
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $this->url,
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
        if(curl_errno($ch))
        {
            return 'error:' . curl_error($ch);
        }

        curl_close($ch);

        return $output;
    
    }
}


?>