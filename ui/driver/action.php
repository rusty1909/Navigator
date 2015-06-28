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
		$dateJoin = $_POST['date_join'];
		$description = $_POST['description'];
		if(Driver::add($name, $phone, $address, $description, $dateJoin)){
			header('Location:index.php');
		} else {
			//header('Location:abc.php');
		}
		break;
}
?>