<?php
require_once '../../framework/Company.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

if(isset($_POST['name'])) {	
	$name = $_POST['name'];
	if(Company::isExists('name', $name)){
		echo 1;
	} else {
		echo 0;
	}
} else 	if(isset($_POST['tin'])) {
		$tin = $_POST['tin'];
		if(Company::isExists('tin_number', $tin)){
			echo 1;
		} else {
			echo 0;
		}
} else 	if(isset($_POST['emp_id'])) {
    $emp_id = $_POST['emp_id'];
    if(Company::isEmployeeExists($_SESSION['user']['company'], $emp_id)){
        echo 1;
    } else {
        echo 0;
    }
}


?>