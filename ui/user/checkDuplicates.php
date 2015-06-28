<?php
require_once '../../framework/User.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);


if(isset($_GET['username'])) {
	
	$username = $_GET['username'];
	if(User::isExists('username', $username)){
		echo 1;
	} else {
		echo 0;
	}
} else {
	if(isset($_POST['email'])) {
		$email = $_POST['email'];
		if(User::isExists('email', $email)){
			echo 1;
		} else {
			echo 0;
		}
	}
}
?>