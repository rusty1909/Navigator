<?php
require_once '../../framework/Driver.php';


if(isset($_GET['action'])) {
	//die "q";
	$action = $_GET['action'];
} else {
	$action = "";
}

switch($action) {
	case "add" : $name = $_POST['name'];
		$phone = $_POST['phone'];
		$address = $_POST['address'];
		$date = $_POST['date_join'];
		$dateJoin = date("Y-m-d", strtotime($date));
		$description = $_POST['description'];
		if(Driver::add($name, $phone, $address, $description, $dateJoin)){
			header('Location:index.php');
		} else {
			//header('Location:abc.php');
		}
		break;
}
?>