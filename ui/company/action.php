<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../../framework/Company.php';
require_once '../../framework/User.php';


if(isset($_GET['action'])) {
	//die "q";
	$action = $_GET['action'];
} else {
	$action = "";
}

switch($action) {
	case "register" : 
		$name = $_POST['name'];
		$tin_number = $_POST['tin_number'];
		$address_1 = $_POST['address_1'];
		$address_2 = $_POST['address_2'];
		$landmark = $_POST['landmark'];
		$city = $_POST['city'];
		$state = $_POST['state'];
		$pincode = $_POST['pincode'];
		$email = $_POST['email'];
		$fax = $_POST['fax'];
		$phone = $_POST['phone'];
		$website = $_POST['website'];
		$description = "";//$_POST['description'];
		
		
		if(Company::add($name, $tin_number, $address_1, $address_2, $landmark, $city, $state, $pincode, $phone, $fax, $email, $website, $description)){
			$mUser = new User();
			$username = $_SESSION['user']['username'];
			$password = $_SESSION['user']['password'];
			$mUser->login($username, $password);
			echo "<script>alert('Company added successfully!!!');</script>";
			echo "<script>window.location.href = '../user/login.php'</script>";
			//header('Location:../user/login.php');
		} else {
			echo "<script>alert('Sorry, some error occured.');</script>";
			//echo "<script>window.location.href = 'register.php'</script>";
			//header('Location:register.php?error=1');
		}
		break;
    case "registerEmployee" : 
		$name = $_POST['name'];
		$emp_id = $_POST['emp_id'];
		$address_1 = $_POST['address_1'];
		$address_2 = $_POST['address_2'];
		$landmark = $_POST['landmark'];
		$city = $_POST['city'];
		$state = $_POST['state'];
		$pincode = $_POST['pincode'];
		$email = $_POST['email'];
		$phone = $_POST['phone'];
    	$fax = '';
        $website = '';
        $description ='';
		
        $retCode = Company::addEmployee($name, $emp_id, $address_1, $address_2, $landmark, $city, $state, $pincode, $phone, $fax, $email, $website, $description);
		if($retCode == 1){
			echo "<script>alert('Employee added successfully!!!');</script>";
         } else {
            echo "<script> var retVal = " .$retCode. " alert(retVal);</script>";
		  }
        echo "<script>window.location.href = '../user/login.php'</script>";
		
		break;
	case "nocompany" :
        $mUser = new User();
		if($mUser->setIndividualAccount()) {
			header('Location:../user/');
		} else {
			header('Location:register.php');
		}
		break;
    case "delete" :
        $id = $_GET['id'];
		$mUser = new User($id);

		if($mUser->delete())
			header('Location:index.php');
		else {
            header('Location:index.php');
        }
			
        break;
	case "update" :
		$mUser = new User();
		
		$mCompany = new Company($mUser->getCompany());
	
		$address_1 = $_POST['address_1'];
		$address_2 = $_POST['address_2'];
		$landmark = $_POST['landmark'];
		$city = $_POST['city'];
		$state = $_POST['state'];
		$pincode = $_POST['pincode'];
		$email = $_POST['email'];
		$fax = $_POST['fax'];
		$phone = $_POST['phone'];
		$website = $_POST['website'];
		$description = "";
		
		
		if($mCompany->update(/*$name, $tin_number, */$address_1, $address_2, $landmark, $city, $state, $pincode, $phone, $fax, $email, $website, $description)){
			//echo 'changes completed..';
			echo "<script>alert('Updated Successfully!!!')</script>";
			echo "<script>window.location.href = '../company/'</script>";			
		}else {
			echo "<script>alert('Some problem occured!!!')</script>";
			echo "<script>window.location.href = '../company/'</script>";
		}
		break;
}
?>