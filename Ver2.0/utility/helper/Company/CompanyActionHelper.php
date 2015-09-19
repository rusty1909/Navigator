<?php
require_once '../../../framework/Company.php';
require_once '../../../framework/User.php';


if(isset($_GET['action'])) {
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
			echo "<script>window.location.href = 'http://www.findgaddi.com/navigator/Ver2.0/ui/pages/user/login.php'</script>";
		} else {
			echo "<script>alert('Sorry, some error occured.');</script>";
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
        echo "<script>window.location.href = 'http://www.findgaddi.com/navigator/Ver2.0/ui/pages/user/login.php'</script>";
		
		break;
	case "nocompany" :
        $mUser = new User();
		if($mUser->setIndividualAccount()) {
			 echo "<script>window.location.href = 'http://www.findgaddi.com/navigator/Ver2.0/ui/pages/user/'</script>";
		} else {
			 echo "<script>window.location.href = 'http://www.findgaddi.com/navigator/Ver2.0/ui/pages/company/register.php'</script>";
		}
		break;
    case "delete" :
        $id = $_GET['id'];
		$mUser = new User($id);

		if($mUser->delete())
			echo "<script>window.location.href = 'http://www.findgaddi.com/navigator/Ver2.0/ui/pages/company/index.php'</script>";
		else {
            echo "<script>window.location.href = 'http://www.findgaddi.com/navigator/Ver2.0/ui/pages/company/index.php'</script>";
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
			echo "<script>alert('Updated Successfully!!!')</script>";
			echo "<script>window.location.href = 'http://www.findgaddi.com/navigator/Ver2.0/ui/pages/company/'</script>";			
		}else {
			echo "<script>alert('Some problem occured!!!')</script>";
			echo "<script>window.location.href = 'http://www.findgaddi.com/navigator/Ver2.0/ui/pages/company/'</script>";
		}
		break;
}
?>