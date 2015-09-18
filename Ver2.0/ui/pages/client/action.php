<?php
require_once '../../framework/Client.php';


if(isset($_GET['action'])) {
	//die "q";
	$action = $_GET['action'];
} else {
	$action = "";
}

switch($action) {
	case "add" : $name = $_POST['name'];
		$contact_person = $_POST['contact_person'];
		$phone = $_POST['phone'];
		$email = $_POST['email'];
		$website = $_POST['website'];
		$address = $_POST['address'];
		$city = $_POST['city'];
		$state = $_POST['state'];
		$pincode = $_POST['pincode'];
		$description = $_POST['description'];
		if(Client::add($name, $contact_person, $phone, $email, $website, $address, $city, $state, $pincode, $description)){
			header('Location:index.php');
		} else {
			header('Location:abc.php');
		}
		break;
}
?>