<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../../framework/User.php';
require_once '../../framework/Mailer.php';
require_once '../../framework/Expense.php';
require_once '../../framework/Driver.php';
require_once '../../framework/Vehicle.php';

if(isset($_GET['action'])) {
	//die "p";
	$action = $_GET['action'];
} else {
	//die "a";
	$action = "";
}

$mUser = User::getCurrentUser(); 

switch($action) {
	case "login" : $username = $_POST['username'];
		$password = $_POST['password'];
		$rememberme = $_POST['rememberme'];
		
		if($mUser->login($username, $password)) {
			$mUser = new User($username, $password, $mUser->getCompany());
			if($mUser->getActivatedState()==1) {
				if($rememberme) $mUser->SetCookieforUser($username, $password, $mUser->getCompany());
				echo "Redirecting to dashboard.";
				echo "<script>window.location.href = 'index.php'</script>";
				//header('Location:index.php');
			} else{
				echo "<script>window.location.href = 'activate.php'</script>";
			}
		} else {
			echo "<script>alert('Username or Password incorrect. Please try again.');</script>";
			echo "<script>window.location.href = 'login.php'</script>";
			//header('Location:login.php');
		}
		break;
	case "register" : $firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$username = $_POST['username'];
		$password = $_POST['password'];
		$phone_m = $_POST['phone_m'];
		$phone_o = $_POST['phone_o'];
		$email = $_POST['email'];
		if(User::add($firstname, $lastname, $username, $password, $phone_m, $phone_o, $email)) {
			echo "<script>alert('User registered successfully!!!');</script>";
			echo "<script>window.location.href = '../user/login.php'</script>";
			//echo "<script>window.location.href = '../company/register.php'</script>";
			//header('Location:../company/register.php');
		} else {
			echo "<script>alert('Sorry, some error occured.');</script>";
			echo "<script>window.location.href = 'register.php'</script>";
		}
		break;
	case "logout" : if($mUser->logout()) {
			header('Location:login.php');
			exit();
		} else {
			header('Location:abc.php');
			exit();
		}
		break;
	case "activate" : if(!isset($_GET['email']) || !isset($_GET['key'])) {
			echo "<script>window.location.href = '../user/login.php'</script>";
			break;
		}		
		$email = $_GET['email'];
		$key = $_GET['key'];
        $id = User::getIdByEmail($email);
		$securityKey = Security::getSecurityKey($id);
		if($key == $securityKey){
            //die("match!!");
			if(User::activate($id))
				header('Location:activate.php?q=1');
		} else {
            //die("sorry!!");
			echo "<script>window.location.href = '../user/login.php'</script>";
		}
		break;
    
    case "resetpassword" : if(!isset($_POST['email_id'])) {
			echo "<script>window.location.href = '../user/login.php'</script>";
			break;
		}		
    
		$email = stripslashes($_POST['email_id']);
        $id = User::getIdByEmail($email);
    
        if($id == -1){
            echo "<script>alert('Email ID does not exist in our database...\n Please use proper id or create a new account with us. !!!');</script>";
			echo "<script>window.location.href = '../user/login.php'</script>";
        	break;
        }
        
        if(User::resetpasswordmail($email)){
            echo "<script>alert('We have sent a mail, Please click on the link in mail to reset your mail.  !!!');</script>";
            echo "<script>window.location.href = '../user/login.php'</script>";
        }else{
               echo "<script>alert('There was some error, please try again...  !!!');</script>";
               echo "<script>window.location.href = '../user/login.php'</script>";

        }
		break;
	
	case "billdetail" : if(!isset($_GET['id'])) {
			break;
		}
		$id = $_GET['id'];
		$mExpense = new Expense($id);
		
		$vehicleId = $mExpense->getVehicle();
		$mVehicle = new Vehicle($vehicleId);
		$vehicleDetail['id'] = $mVehicle->getId();
		$vehicleDetail['number'] = $mVehicle->getVehicleNumber();
		$vehicleDetail['type'] = $mVehicle->getType();
		
		$driverId = $mExpense->getDriver();
		$mDriver = new Driver($driverId);
		$driverDetail['id'] = $mDriver->getId();
		$driverDetail['name'] = $mDriver->getName();
		
		$detail['id'] = $mExpense->getId();
		$detail['vehicle'] = $vehicleDetail;
		$detail['driver'] = $driverDetail;
		$detail['reason'] = $mExpense->getReason();
		$detail['amount'] = $mExpense->getAmount();
		$detail['filename'] = $mExpense->getFilename();
		$detail['date_added'] = $mExpense->getDateAdded();
		$detail['location'] = $mExpense->getLocation();
		
		echo json_encode($detail);
		break;
	
	case "billapproval" : if(!(isset($_GET['id']) && isset($_GET['approval']))) {
			break;
		}
		$id = $_GET['id'];
		$approval = $_GET['approval'];
		$mExpense = new Expense($id);
		if($mExpense->updateStatus($approval))
			echo "success";
		else
			echo "fail";
		break;
		
}
?>