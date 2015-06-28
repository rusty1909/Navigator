<?php

require_once '../../framework/User.php';

if(isset($_GET['action'])) {
	//die "p";
	$action = $_GET['action'];
} else {
	//die "a";
	$action = "";
}

$mUser = User::getCurrentUser(); 
//if($mUser()==null) $mUser = new User("");

switch($action) {
	case "change" : $username = $_POST['username'];
		$password = $_POST['password'];
		if($mUser->login($username, $password)) {
			header('Location:index.php');
		} else {
			header('Location:login.php?err=wrongpassword');
		}
		break;
	case "update" : $firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$username = $_POST['username'];
		$password = $_POST['password'];
		$phone_m = $_POST['phone_m'];
		$phone_o = $_POST['phone_o'];
		$email = $_POST['email'];
		if(User::add($firstname, $lastname, $username, $password, $phone_m, $phone_o, $email)) {
			header('Location:index.php');
		} else {
			header('Location:abc.php');
		}
		break;
    default : header('Location:index.php');
		break;
}
?>