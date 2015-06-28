<?php
if(strtolower($_SERVER['SERVER_NAME']) === strtolower("localhost") ){
	
	define('DB_USERNAME', 'root');
	define('DB_PASSWORD', '');
	define('DB_HOST', 'localhost');
	define('DB_NAME', 'navigator');

}else{
	//die "qwerty";
	define ("DB_HOST", "localhost"); // set database host
	define ("DB_USERNAME", "findgz8e_admin"); // set database user
	define ("DB_PASSWORD","Sk2Lq4fW1q$("); // set database password
	define('DB_NAME', 'findgz8e_navigator');
} 
date_default_timezone_set("Asia/Kolkata");
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
    
    function getTimeNow(){
        $date = new DateTime();
        $date->setTimezone(new DateTimeZone('Asia/Kolkata'));

        $fdate = $date->format('Y-m-d H:i:s'); // same format as NOW()
        
        return $fdate;
    
    }
}

?>