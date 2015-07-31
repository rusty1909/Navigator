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
	case "change" : $old = $_POST['old'];
		$new = $_POST['new'];
		//echo $old."     ";
		//echo $new;
		if($mUser->updatePassword($old, $new)) {
			echo "<script>alert('Updated Successfully!!!')</script>";
			
		} else {
			echo "<script>alert('Some problem occured!!!')</script>";
		}
		//echo $_SESSION['user']['password'];
		echo "<script>window.location.href = 'index.php'</script>";	
		break;
	case "update_contact" : $phone_m = $_POST['phone_m'];
		$phone_o = $_POST['phone_o'];
		$email = $_POST['email'];
		if($mUser->updateContact($phone_m, $phone_o, $email)) {
			echo "<script>alert('Updated Successfully!!!')</script>";
			echo "<script>window.location.href = 'index.php'</script>";	
		} else {
			echo "<script>alert('Some problem occured!!!')</script>";
			echo "<script>window.location.href = 'abc.php'</script>";	
		}
		break;
    default : header('Location:index.php');
		break;
}
?>