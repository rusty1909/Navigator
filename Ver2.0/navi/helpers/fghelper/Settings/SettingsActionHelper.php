<?php
require_once '../../../framework/User.php';

if(isset($_GET['action'])) {
	$action = $_GET['action'];
} else {
	$action = "";
}

$mUser = User::getCurrentUser(); 
switch($action) {
	case "change" : $old = $_POST['old'];
		$new = $_POST['new'];
		if($mUser->updatePassword($old, $new)) {
			echo "<script>alert('Updated Successfully!!!')</script>";
		} else {
			echo "<script>alert('Some problem occured!!!')</script>";
		}
		echo "<script>window.location.href = 'http://www.findgaddi.com/navigator/Ver2.0/ui/pages/setting/index.php'</script>";	
		break;
	case "update_contact" : $phone_m = $_POST['phone_m'];
		$phone_o = $_POST['phone_o'];
		$email = $_POST['email'];
		if($mUser->updateContact($phone_m, $phone_o, $email)) {
			echo "<script>alert('Updated Successfully!!!')</script>";
			echo "<script>window.location.href = 'http://www.findgaddi.com/navigator/Ver2.0/ui/pages/setting/index.php'</script>";	
		} else {
			echo "<script>alert('Some problem occured!!!')</script>";
			echo "<script>window.location.href = 'http://www.findgaddi.com/navigator/Ver2.0/ui/pages/setting/abc.php'</script>";	
		}
		break;
    default :
        echo "<script>window.location.href = 'http://www.findgaddi.com/navigator/Ver2.0/ui/pages/setting/index.php'</script>";	
		break;
}
?>