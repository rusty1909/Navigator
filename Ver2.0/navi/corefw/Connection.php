<?php
require_once '../constants/Constants.php';

require_once 'Security.php';	
class Connection {
 
    private $conn;
 
    function __construct() {        
    }

    function connect() {
        $this->conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
        // Check for database connection error
		
		if (mysqli_connect_errno($this->conn )) {
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
        // returing connection resource
        return $this->conn;
    }
    
    function getTimeNow($time=-1){
       if($time != -1)
            return date('Y-m-d', strtotime($time));
        
        return date('Y-m-d H:i:s');        
    }
    
    function getDeviceDetails(){        
        return  $_SERVER['HTTP_USER_AGENT'];
    }
    
    function getIPAddress(){
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
        return $ip;
    }
}

?>