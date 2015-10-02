<?php
if(strtolower($_SERVER['SERVER_NAME']) === strtolower("localhost") ){
	
	define('DB_USERNAME', 'root');
	define('DB_PASSWORD', 'sn123456');
	define('DB_HOST', 'localhost');
	define('DB_NAME', 'navigator');

}else{
	//die "qwerty";
	define ("DB_HOST", "localhost"); // set database host
	define ("DB_USERNAME", "findgz8e_admin"); // set database user
	define ("DB_PASSWORD","Sk2Lq4fW1q$("); // set database password
	define('DB_NAME', 'findgz8e_navigator');
} 

//Company Details...
define ("WEB_FULL_NAME", "FindGaddi.com"); // set database host
define ("WEBSITE_NAME", "www.findgaddi.com"); // set database host
define ("WEB_MAIL_ID", "info@findgaddi.com"); // set database host
define ("WEB_MAIL_REPLY_ID", "info@findgaddi.com"); // set database host
define ("WEB_MAIL_ACTIVATION_ID", "activate@findgaddi.com"); // set database host

define('DEF_MEM_AMOUNT', '6000');

date_default_timezone_set("Asia/Kolkata");


//enable debugging....
error_reporting(E_ALL);
ini_set('display_errors',1);


?>