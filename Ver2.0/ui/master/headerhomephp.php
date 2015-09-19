<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once "../../../framework/User.php";
require_once "../../../framework/Company.php";

$mUser = new User();

$mCompany = new Company($mUser->getCompany());
	
?>