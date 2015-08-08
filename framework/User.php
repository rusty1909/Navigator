<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

if(!isset($_SESSION))
	session_start();

require_once 'Connection.php';
require_once 'Mailer.php';
require_once 'Company.php';
require_once 'Security.php';

class User {
	private $id;
	private $firstname;
	private $lastname;
	private $username;
	private $companyId;
	private $phoneMobile;
	private $phoneOffice;
	private $email;
	private $isLoggedIn;
	private $ipAddress;
	private $dateAdded;
	private $activated;
    
    
	private $address_1;
	private $address_2;
	private $city;
	private $state;
	private $landmark;
	private $pincode; 

	function __construct($id=-1) {
        
        //logic to check if user id has been passed or need to fetch from session...
        if($id==-1){
            if(isset($_SESSION['user'])) 
			     $user_id = $_SESSION['user']['id'];
            else
                 $user_id = null;
        }else
            $user_id = $id;
        
        if($user_id !=null){
            $db = new Connection();
            $conn = $db->connect();
            $sql = "SELECT * FROM user WHERE id='$user_id'";
            $action = mysqli_query($conn, $sql);
            if (mysqli_num_rows($action) > 0) {
                while($row = mysqli_fetch_assoc($action)) {
                    $this->id = $row['id'];
                    $this->firstname = $row['firstname'];
                    $this->username = $row['username'];
                    $this->lastname = $row['lastname'];
                    $this->companyId = $row['company_id'];
                    $this->phoneMobile = $row['phone_m'];
                    $this->phoneOffice = $row['phone_o'];
                    $this->email = $row['email'];
                    $this->isLoggedIn = $row['logged_in'];
                    $this->ipAddress = $row['ip_address'];
                    $this->dateAdded = $row['date_added'];
                    $this->activated = $row['activated'];
                    
                    
                    $this->address_1 = $row['address_1'];
                    $this->address_2 = $row['address_2'];
                    $this->city = $row['city'];
                    $this->state = $row['state'];
                    $this->landmark = $row['landmark'];
                    $this->pincode = $row['pincode'];
                    
                }
            }
        }
        
	}
    
	function SetCookieforUser($u, $p, $id) {
		
		$time1 =  time() + 86400*30;
		setcookie("c_username", $u , $time1,  "/","", 0);
		setcookie("c_passwd", $p , $time1 ,  "/","", 0);
		setcookie("c_uniqueid", $id , $time1 ,  "/","", 0);
		setcookie("c_company", $p , $time1 ,  "/","", 0);
		setcookie("c_email", $id , $time1 ,  "/","", 0);
	}
	function RemoveCookieforUser() {
		if(isset($_COOKIE['c_username']) || isset($_COOKIE['c_passwd'])|| isset($_COOKIE['c_uniqueid'])) {
			setcookie("c_username",'',  strtotime('-5 days'),'/');
			setcookie("c_passwd",'',  strtotime('-5 days'),'/');
			setcookie("c_uniqueid",'',  strtotime('-5 days'),'/');
			setcookie("c_company",'',  strtotime('-5 days'),'/');
			setcookie("c_email",'',  strtotime('-5 days'),'/');
		}
	}
	public static function getCurrentUser() {
		$mUser = null;
		if(isset($_SESSION['user'])) {
			$user_id = $_SESSION['user']['id'];
			$mUser = new User();
		} else $mUser = new User();
		return $mUser;
	}

	public static function add($firstname, $lastname, $username, $password, $phone_m, $phone_o, $email, $address_1, $address_2, $landmark, $city, $state, $pincode,$company=-1){
		$db = new Connection();
		$conn = $db->connect();
		//add user
		$user = "INSERT INTO user (firstname, lastname, username, password, phone_m, phone_o, email, company_id, `address_1`, `address_2`, `city`, `state`, `landmark`, `pincode`) VALUES ('$firstname', '$lastname', '$username', '$password', '$phone_m', '$phone_o', '$email', '$company', '$address_1', '$address_2', '$city', '$state', '$landmark', '$pincode')";
		
        if (mysqli_query($conn, $user)) {
			$getUser = "SELECT * FROM user WHERE username='$username' AND password='$password'";
			$action = mysqli_query($conn, $getUser);
			if (mysqli_num_rows($action) > 0) {
				while($row = mysqli_fetch_assoc($action)) {
					$id = $row['id'];
					$username = $row['username'];
					$email = $row['email'];
				}
				
				/*sending activation mail*/
                $securityKey = Security::getSecurityKey($id);
				Mailer::sendActivationMessage($firstname." ".$lastname, $username, $email, $securityKey);
                return true;
			} else {
				return false;
			}
		}
        
        return false;
	}
    
	function getAllNotifications(){
		$db = new Connection();
		$conn = $db->connect();
		
        $result = array();
        
		$sql = "SELECT id FROM notification WHERE admin = '$this->id' ORDER BY date_added DESC ";
		
        //print_r($sql);
		$action = mysqli_query($conn, $sql);
		
		if (mysqli_num_rows($action) > 0) {
			// output data of each row
			while($row = mysqli_fetch_assoc($action)) {
				array_push($result, $row['id']);
			}
		}
		
		return $result;
	}
	
    public static function getIdByEmail($email){
		$db = new Connection();
		$conn = $db->connect();

		$sql = "SELECT id FROM `user` WHERE email = '$email'";
		$action = mysqli_query($conn, $sql);

		if (mysqli_num_rows($action) > 0) {
			while($row = mysqli_fetch_assoc($action)) {
				return $row['id'];
            }
			$mUser = new User();
			$mUser->updateLoggedinState(1);
			return true;
		}else{
            return -1; //error when email id is not found is data base..
        }
		return false;
    }
	
	function setCompany($companyId) {
		// opening db connection
		$db = new Connection();
		$conn = $db->connect();

		$sql = "UPDATE user SET company_id = '$companyId' WHERE id = '$this->id'";
		$action = mysqli_query($conn, $sql);

		if (mysqli_query($conn, $sql)) {
			$this->companyId = $companyId;
		} else {
			/*echo "company not added!!!";*/
		}
	}
	
	function updateCompanyToVehicle(){
		$db = new Connection();
		$conn = $db->connect();
		
		$companyId = $this->companyId;
		$sql = "UPDATE vehicle SET company_id = '$companyId' WHERE added_by = '$this->id'";

		$action = mysqli_query($conn, $sql);
		if (mysqli_query($conn, $sql)) {
			return true;
		} else {
			return false;
		}		
	}

	function updateCompanyToNotification(){
		$db = new Connection();
		$conn = $db->connect();
		
		$companyId = $this->companyId;
		$sql = "UPDATE notification SET company = '$companyId' WHERE admin = '$this->id'";

		$action = mysqli_query($conn, $sql);
		if (mysqli_query($conn, $sql)) {
			return true;
		} else {
			return false;
		}		
	}

	function updateCompanyToDriver(){
		$db = new Connection();
		$conn = $db->connect();
		
		$companyId = $this->companyId;
		$sql = "UPDATE driver SET company_id = '$companyId' WHERE added_by = '$this->id'";

		$action = mysqli_query($conn, $sql);
		if (mysqli_query($conn, $sql)) {
			return true;
		} else {
			return false;
		}		
	}
	
	function updateLoggedinState($login) {				
		
		$value = 0;

		if(isset($_SESSION['user']['id'])) {
            $user_id = $_SESSION['user']['id'];
			
		}
		
		$value = $login;
		
		/* opening db connection*/
		$db = new Connection();
		$conn = $db->connect();

        $ip = $db->getIPAddress();
        
		$sql = "UPDATE user SET logged_in = '$value', ip_address = '$ip' WHERE id = '$this->id'";
		$action = mysqli_query($conn, $sql);
		if (mysqli_query($conn, $sql)) {
			return true;
		} else {
			return false;
		}
	}
	
	function login($username, $password) {
		
		// opening db connection
		$db = new Connection();
		$conn = $db->connect();

		$sql = "SELECT * FROM `user` WHERE username = '$username' AND password = '$password'";
		$action = mysqli_query($conn, $sql);

		if (mysqli_num_rows($action) > 0) {
			while($row = mysqli_fetch_assoc($action)) {
				$_SESSION['user']['id'] = $row['id'];
				$_SESSION['user']['username'] = $row['username'];
				$_SESSION['user']['email'] = $row['email'];
				$_SESSION['user']['company'] = $row['company_id'];
				$_SESSION['user']['password'] = $row['password'];
			}
			$mUser = new User();
			$mUser->updateLoggedinState(1);
			return true;
		}
		return false;
	}

	//FOR ISSUES...
	public static function getUserInfo($id) {
		//require_once '../framework/DBConnect.php';
//		session_start();
		
		// opening db connection
		$db = new Connection();
		$conn = $db->connect();

		$sql = "SELECT * FROM `user` WHERE id = '$id'";
		$action = mysqli_query($conn, $sql);

		if (mysqli_num_rows($action) > 0) {
			while($row = mysqli_fetch_assoc($action)) {
				return $row['firstname']." ".$row['lastname']." ( ".$row['username']." )";
			}
		}
		//return false;
	}
	
	function getAlerts(){
		$db = new Connection();
		$conn = $db->connect();
		
		$result = array();
		
		$mUser = new User();
		$companyId	= $mUser->getCompany();
		if($companyId == -1){
			$sql = "SELECT id FROM `notification` WHERE admin = '$this->id' AND priority = '99'";
		} else {
			$sql = "SELECT id FROM `notification` WHERE company = '$companyId' AND priority = '99'";
		}
		
		$action = mysqli_query($conn, $sql);

		if (mysqli_num_rows($action) > 0) {
			while($row = mysqli_fetch_assoc($action)) {
				array_push($result, $row['id']);
			}
		}
		
		return $result;
	}
	
	function getMonthlyAlerts(){
		$db = new Connection();
		$conn = $db->connect();
		
		$result = array();
		
		$mUser = new User();
		$companyId	= $mUser->getCompany();
		if($companyId == -1){
			$sql = "SELECT id FROM `notification` WHERE admin = '$this->id' AND priority = '99' AND MONTH(date_added) = MONTH(CURRENT_DATE) AND YEAR(date_added) = YEAR(CURRENT_DATE)";
		} else {
			$sql = "SELECT id FROM `notification` WHERE company = '$companyId' AND priority = '99' AND MONTH(date_added) = MONTH(CURRENT_DATE) AND YEAR(date_added) = YEAR(CURRENT_DATE)";
		}
		
		$action = mysqli_query($conn, $sql);

		if (mysqli_num_rows($action) > 0) {
			while($row = mysqli_fetch_assoc($action)) {
				array_push($result, $row['id']);
			}
		}
		
		return $result;
	}
	
	function getExpenseList(){
		$db = new Connection();
		$conn = $db->connect();
		
		$result = array();
		
		$mUser = new User();
		$companyId	= $mUser->getCompany();
		if($companyId == -1){
			$sql = "SELECT id FROM `expenses` WHERE admin = '$this->id'";
		} else {
			$sql = "SELECT id FROM `expenses` WHERE company = '$companyId'";
		}
		
		$action = mysqli_query($conn, $sql);

		if (mysqli_num_rows($action) > 0) {
			while($row = mysqli_fetch_assoc($action)) {
				array_push($result, $row['id']);
			}
		}		
		return $result;
	}
	
	function getPendingExpenseList(){
		$db = new Connection();
		$conn = $db->connect();
		
		$result = array();
		
		$mUser = new User();
		$companyId	= $mUser->getCompany();
		if($companyId == -1){
			$sql = "SELECT id FROM `expenses` WHERE admin = '$this->id' AND approved='0'";
		} else {
			$sql = "SELECT id FROM `expenses` WHERE company = '$companyId' AND approved='0'";
		}
		
		$action = mysqli_query($conn, $sql);

		if (mysqli_num_rows($action) > 0) {
			while($row = mysqli_fetch_assoc($action)) {
				array_push($result, $row['id']);
			}
		}		
		return $result;
	}
	
	function getRejectedExpenseList(){
		$db = new Connection();
		$conn = $db->connect();
		
		$result = array();
		
		$mUser = new User();
		$companyId	= $mUser->getCompany();
		if($companyId == -1){
			$sql = "SELECT id FROM `expenses` WHERE admin = '$this->id' AND approved='-1'";
		} else {
			$sql = "SELECT id FROM `expenses` WHERE company = '$companyId' AND approved='-1'";
		}
		
		$action = mysqli_query($conn, $sql);

		if (mysqli_num_rows($action) > 0) {
			while($row = mysqli_fetch_assoc($action)) {
				array_push($result, $row['id']);
			}
		}		
		return $result;
	}
	
	function getApprovedExpenseList(){
		$db = new Connection();
		$conn = $db->connect();
		
		$result = array();
		
		$mUser = new User();
		$companyId	= $mUser->getCompany();
		if($companyId == -1){
			$sql = "SELECT id FROM `expenses` WHERE admin = '$this->id' AND approved='1'";
		} else {
			$sql = "SELECT id FROM `expenses` WHERE company = '$companyId' AND approved='1'";
		}
		
		$action = mysqli_query($conn, $sql);

		if (mysqli_num_rows($action) > 0) {
			while($row = mysqli_fetch_assoc($action)) {
				array_push($result, $row['id']);
			}
		}		
		return $result;
	}

    function logout() {
		$mUser = new User();

		$mUser->updateLoggedinState(0);		
		unset($_SESSION['user']);
		if(!isset($_SESSION['user'])){

			$mUser->RemoveCookieforUser();
			return true;
	    } else {
			return false;
		}
	}
    
    
	
	function resetPassword($newPassword) {

		// opening db connection
		$db = new Connection();
		$conn = $db->connect();
				
		$sql = "UPDATE user SET password = '$newPassword' WHERE id = '$this->id'";
		
		if (mysqli_query($conn, $sql)) {
			$_SESSION['user']['password'] = $newPassword;
			return true;
		} else {
			return false;
		}
	}
    
	function updatePassword($oldPassword, $newPassword) {

		// opening db connection
		$db = new Connection();
		$conn = $db->connect();
		
		if($oldPassword != $_SESSION['user']['password']) return false;
		
		$sql = "UPDATE user SET password = '$newPassword' WHERE id = '$this->id' AND password = '$oldPassword'";
		//print_r($sql);
		//$action = mysqli_query($conn, $sql);

		if (mysqli_query($conn, $sql)) {
			$_SESSION['user']['password'] = $newPassword;
			return true;
		} else {
			return false;
		}
	}
	
	function updateContact($phone_m, $phone_o, $email) {
		//require_once '../framework/DBConnect.php';
//		session_start();
		
		// opening db connection
		$db = new Connection();
		$conn = $db->connect();
		
		$user_id = $_SESSION['user']['id'];
		
		$sql = "UPDATE user SET phone_m = '$phone_m', phone_o = '$phone_o', email = '$email' WHERE id= '$this->id'";
		//print_r($sql);

		if (mysqli_query($conn, $sql)) {
			return true;
		} else {
			return false;
		}
	}
	
	public static function isLoggedIn(){
	
		if(isset($_SESSION['user']['id']) && isset($_SESSION['user']['username']) && isset($_SESSION['user']['company']) && isset($_SESSION['user']['email']) && isset($_SESSION['user']['password'])) {
			
			$id = $_SESSION['user']['id'];
			$username = $_SESSION['user']['username'];
			$email = $_SESSION['user']['email'];
			$company = $_SESSION['user']['company'];
			$password = $_SESSION['user']['password'];
			
			// opening db connection
			$db = new Connection();
			$conn = $db->connect();
			
			$sql = "SELECT * FROM `user` WHERE username = '$username' AND password = '$password' AND email = '$email' AND company_id = '$company' AND id = '$id' AND activated = '1'";
			//echo $sql;
			$action = mysqli_query($conn, $sql);

			if (mysqli_num_rows($action) > 0) {
				while($row = mysqli_fetch_assoc($action)) {
					return true;
				}
			} else {
				return false;
			}
		}else if(isset($_COOKIE['c_username']) && isset($_COOKIE['c_passwd']) && isset($_COOKIE['c_uniqueid'])&& isset($_COOKIE['c_company']) && isset($_COOKIE['c_email']) ){
				
			$id = $_SESSION['user']['id'] = $_COOKIE['c_uniqueid'];
			$username = $_SESSION['user']['username'] = $_COOKIE['c_username'];
			$email = $_SESSION['user']['email'] = $_COOKIE['c_email'];
			$company = $_SESSION['user']['company'] = $_COOKIE['c_company'];
			$password = $_SESSION['user']['password'] = $_COOKIE['c_passwd'];
			
			// opening db connection
			$db = new Connection();
			$conn = $db->connect();
			
			$sql = "SELECT * FROM `user` WHERE username = '$username' AND password = '$password' AND email = '$email' AND company_id = '$company' AND id = '$id' AND activated = '1'";
			//echo $sql;
			$action = mysqli_query($conn, $sql);

			if (mysqli_num_rows($action) > 0) {
				while($row = mysqli_fetch_assoc($action)) {
					return true;
				}
			} else {
				return false;
			}
					
		}else{
					
			return false;
		}

	}

	public static function isExists($col, $value) {
		//require_once '../framework/DBConnect.php';
		// opening db connection
		$db = new Connection();
		$conn = $db->connect();
		$sql = "SELECT id FROM user WHERE $col = '$value'";
		//echo "--->".$sql;
		$action = mysqli_query($conn, $sql);

		if (mysqli_num_rows($action) > 0) {
			return true;
		}
		//echo sizeof($result)."    < size";
		return false;
	}
	
	function getVehicleList() {
		//require_once '../framework/DBConnect.php';
		
		// opening db connection
		$db = new Connection();
		$conn = $db->connect();
		
        if(empty($_SESSION['user']))
            return null;

		$result = array();
		if($this->companyId > 0)
			$sql = "SELECT id FROM vehicle WHERE company_id = '$this->companyId' AND status = '1' AND date_deactivate IS NULL ";
		else
			$sql = "SELECT id FROM vehicle WHERE added_by = '$this->id' AND status = '1' AND date_deactivate IS NULL ";
		//echo "--->".$sql;
		$action = mysqli_query($conn, $sql);

		if (!empty($action) && mysqli_num_rows($action) > 0) {
		while($row = mysqli_fetch_assoc($action)) {
				array_push($result, $row['id']);
			}
		}
		//echo sizeof($result)."    < size";
		return $result;
	}

	function getDeployedVehicleList() {
		//require_once '../framework/DBConnect.php';
		
		// opening db connection
		$db = new Connection();
		$conn = $db->connect();
		
         if(empty($_SESSION['user']))
            return null;

		$result = array();
		if($this->companyId > 0)
			$sql = "SELECT id FROM vehicle WHERE company_id = '$this->companyId' AND deployed='1' AND status = '1' AND date_deactivate IS NULL ";
		else
			$sql = "SELECT id FROM vehicle WHERE added_by = '$this->id' AND deployed='1' AND status = '1' AND date_deactivate IS NULL ";
		//echo "--->".$sql;
		$action = mysqli_query($conn, $sql);

        
		if (!empty($action) && mysqli_num_rows($action) > 0) {
		while($row = mysqli_fetch_assoc($action)) {
				array_push($result, $row['id']);
			}
		}
		//echo sizeof($result)."    < size";
		return $result;
	}

	function getPreviousVehicleList() {
		//require_once '../framework/DBConnect.php';
		
		// opening db connection
		$db = new Connection();
		$conn = $db->connect();
		
         if(empty($_SESSION['user']))
            return null;
        

		$result = array();
		
		$sql = "SELECT id FROM vehicle WHERE company_id = '$this->companyId' AND status = '0' OR date_deactivate IS NOT NULL  ";
		//echo "--->".$sql;
		$action = mysqli_query($conn, $sql);

		if (mysqli_num_rows($action) > 0) {
		while($row = mysqli_fetch_assoc($action)) {
				array_push($result, $row['id']);
			}
		}
		//echo sizeof($result)."    < size";
		return $result;
	}

	function getOnJobVehicleList() {
		//require_once '../framework/DBConnect.php';
		
		// opening db connection
		$db = new Connection();
		$conn = $db->connect();
		
         if(empty($_SESSION['user']))
            return null;
        
        
		$result = array();
		if($this->companyId > 0)
			$sql = "SELECT id FROM vehicle WHERE company_id = '$this->companyId' AND status = '1' AND driver != '0' AND date_deactivate IS NULL ";
		else
			$sql = "SELECT id FROM vehicle WHERE added_by = '$this->id' AND status = '1' AND driver != '0' AND date_deactivate IS NULL ";
		//echo "--->".$sql;
		$action = mysqli_query($conn, $sql);

		if (!empty($action) && mysqli_num_rows($action) > 0) {
		while($row = mysqli_fetch_assoc($action)) {
				array_push($result, $row['id']);
			}
		}
		//echo sizeof($result)."    < size";
		return $result;
	}

	function getFreeVehicleList() {
		//require_once '../framework/DBConnect.php';
		
		// opening db connection
		$db = new Connection();
		$conn = $db->connect();
        
         if(empty($_SESSION['user']))
            return null;
        
        
		

		$result = array();
		
		$sql = "SELECT id FROM vehicle WHERE company_id = '$this->companyId' AND status = '1' AND on_job='0' AND deployed='1' AND date_deactivate IS NULL ";
		//echo "--->".$sql;
		$action = mysqli_query($conn, $sql);

		if (!empty($action) && mysqli_num_rows($action) > 0) {
		while($row = mysqli_fetch_assoc($action)) {
				array_push($result, $row['id']);
			}
		}
		//echo sizeof($result)."    < size";
		return $result;
	}

	function getWaitingVehicleList() {
		//require_once '../framework/DBConnect.php';
		
		// opening db connection
		$db = new Connection();
		$conn = $db->connect();
		
        if(empty($_SESSION['user']))
            return null;
		
		$result = array();
		if($this->companyId > 0)
			$sql = "SELECT id FROM vehicle WHERE company_id = '$this->companyId' AND deployed='0' AND date_deactivate IS NULL ";
		else
			$sql = "SELECT id FROM vehicle WHERE added_by = '$this->id' AND deployed='0' AND date_deactivate IS NULL ";
		//echo "--->".$sql;
		$action = mysqli_query($conn, $sql);

		if (!empty($action) && mysqli_num_rows($action) > 0) {
		while($row = mysqli_fetch_assoc($action)) {
				array_push($result, $row['id']);
			}
		}
		//echo sizeof($result)."    < size";
		return $result;
	}
	
	function getOrderList() {
		// opening db connection
		$db = new Connection();
		$conn = $db->connect();
		
         if(empty($_SESSION['user']))
            return null;

		//echo $company_id;
		$result = array();
		
		$sql = "SELECT id FROM `order` WHERE company_id = '$this->companyId'";
		//echo "--->".$sql;
		$action = mysqli_query($conn, $sql);

		if (mysqli_num_rows($action) > 0) {
		while($row = mysqli_fetch_assoc($action)) {
				array_push($result, $row['id']);
			}
		}
		//echo sizeof($result)."    < size";
		return $result;
	}
	
	function getClientList() {
		//require_once '../framework/DBConnect.php';
		
		// opening db connection
		$db = new Connection();
		$conn = $db->connect();
		
         if(empty($_SESSION['user']))
            return null;
        
		$result = array();
		
		$sql = "SELECT id FROM client WHERE company_id = '$this->companyId'";
		//echo "--->".$sql;
		$action = mysqli_query($conn, $sql);

		if (mysqli_num_rows($action) > 0) {
		while($row = mysqli_fetch_assoc($action)) {
				array_push($result, $row['id']);
			}
		}
		//echo sizeof($result)."    < size";
		return $result;
	}
	
	function getCurrentDriverList() {
		//require_once '../framework/DBConnect.php';
		
		// opening db connection
		$db = new Connection();
		$conn = $db->connect();
		
         if(empty($_SESSION['user']))
            return null;
		
		$result = array();
		if($this->companyId > 0)
			$sql = "SELECT id FROM driver WHERE company_id = '$this->companyId' AND status = '1'";
		else
			$sql = "SELECT id FROM vehicle WHERE added_by = '$this->id' AND status = '1'";
		//echo "--->".$sql;
		$action = mysqli_query($conn, $sql);

		if (mysqli_num_rows($action) > 0) {
		while($row = mysqli_fetch_assoc($action)) {
				array_push($result, $row['id']);
			}
		}
		//echo sizeof($result)."    < size";
		return $result;
	}
	
	function getAvailableDriverList() {
		//require_once '../framework/DBConnect.php';
		
		// opening db connection
		$db = new Connection();
		$conn = $db->connect();
		
         if(empty($_SESSION['user']))
            return null;
        
		$result = array();
		if($this->companyId > 0)
			$sql = "SELECT id FROM driver WHERE company_id = '$this->companyId' AND status = '1'";
		else
			$sql = "SELECT id FROM vehicle WHERE added_by = '$this->id' AND status = '1'";
		//echo "--->".$sql;
		$action = mysqli_query($conn, $sql);

		if (mysqli_num_rows($action) > 0) {
		while($row = mysqli_fetch_assoc($action)) {
				$driver = new Driver($row['id']);
				if($driver->getCurrentVehicle() == 0)
					array_push($result, $row['id']);
			}
		}
		//echo sizeof($result)."    < size";
		return $result;
	}

	function getPreviousDriverList() {
		//require_once '../framework/DBConnect.php';
		
		// opening db connection
		$db = new Connection();
		$conn = $db->connect();
        
         if(empty($_SESSION['user']))
            return null;
        
		$result = array();
		if($this->companyId > 0)
			$sql = "SELECT id FROM driver WHERE company_id = '$this->companyId' AND status = '0'";
		else
			$sql = "SELECT id FROM vehicle WHERE added_by = '$this->id' AND status = '0'";
		//echo "--->".$sql;
		$action = mysqli_query($conn, $sql);

		if (mysqli_num_rows($action) > 0) {
		while($row = mysqli_fetch_assoc($action)) {
				array_push($result, $row['id']);
			}
		}
		//echo sizeof($result)."    < size";
		return $result;
	}

	function getCurrentJobList() {
		//require_once '../framework/DBConnect.php';
		
		// opening db connection
		$db = new Connection();
		$conn = $db->connect();
		
         if(empty($_SESSION['user']))
            return null;
        
        
		$result = array();

		$sql = "SELECT id FROM job WHERE company_id = '$this->companyId' AND status = '0'";
		//echo "--->".$sql;
		$action = mysqli_query($conn, $sql);

		if (mysqli_num_rows($action) > 0) {
		while($row = mysqli_fetch_assoc($action)) {
				array_push($result, $row['id']);
			}
		}
		//echo sizeof($result)."    < size";
		return $result;
	}
	
	function getPreviousJobList() {
		//require_once '../framework/DBConnect.php';
		
		// opening db connection
		$db = new Connection();
		$conn = $db->connect();
		
		$result = array();

		$sql = "SELECT id FROM job WHERE company_id = '$this->companyId' AND status = '1'";
		//echo "--->".$sql;
		$action = mysqli_query($conn, $sql);

		if (mysqli_num_rows($action) > 0) {
		while($row = mysqli_fetch_assoc($action)) {
				array_push($result, $row['id']);
			}
		}
		//echo sizeof($result)."    < size";
		return $result;
	}

	function setIndividualAccount(){
		// opening db connection
		$db = new Connection();
		$conn = $db->connect();
		echo $this->id;
		$sql = "UPDATE user SET company_id = '-1' WHERE id = '$this->id'";
		$action = mysqli_query($conn, $sql);

		if (mysqli_query($conn, $sql)) {
			return true;
		} else {
			return false;
		}
	}
    
    public static function resetpasswordmail($id) {
		$securityKey = Security::getSecurityKey($id);
    
        $idk = User::getIdByEmail($id);
    
        $passresetlink = "http://www.findgaddi.com/navigator/ui/user/resetPassword.php?id=$idk&key=$securityKey";
    
        $messagereset =  '<br > Please click on the below link or if link does not work please copy paste the link in your browser.<br >';
        $messagereset .= $passresetlink ;
    
        return Mailer::SendResetPasswd($id, 'Please reset your passwword', $messagereset);
	}

    public static function activate($id) {
		// opening db connection
		$db = new Connection();
		$conn = $db->connect();
		//echo $this->id;
		$sql = "UPDATE user SET activated = '1' WHERE id = '$id'";
		$action = mysqli_query($conn, $sql);

		if (mysqli_query($conn, $sql)) {
			return true;
		} else {
			return false;
		}		
	}
		
	function getId() {
		return $this->id;
	}
	
	function getFullName() {
		return $this->firstname." ".$this->lastname;
	}
	
	function getUsername() {
		return $this->username;
	}
	
	function getCompany() {
		return $this->companyId;
	}
	
	function getAddress() {
        $add = !empty($this->address_1) ? $this->address_1 : "";
        $add .= "<br>";
        $add .= !empty($this->address_2) ? $this->address_2 : "";
        $add .= "<br>";        
        $add .= !empty($this->landmark) ? $this->landmark : "";
        $add .= "<br>";
        $add .= !empty($this->city) ? $this->city : "";
        $add .= "<br>";
        $add .= !empty($this->state) ? $this->state : "";
        $add .= "<br>";
        $add .= !empty($this->pincode) ? $this->pincode : "";
        $add .= "<br>";
        
		return $add;
	}
	
	function getLandmark(){
		return $this->landmark;
	}
	
	function isCompanyAdmin(){
		$selfCompany = new Company(User::getCompany());
		if($this->id == $selfCompany->getAdmin()) return true;
		else return false;
	}
	
	function getPhoneOffice(){
		return $this->phoneOffice;
	}

	function getPhoneMobile(){
		return $this->phoneMobile;
	}

	function getEmail(){
		return $this->email;
	}

	function getWebsite(){
		return $this->website;
	}
	
	function getActivatedState() {
		return $this->activated;
	}
    
    function delete() {
		$db = new Connection();
		$conn = $db->connect();
		
        if($this->id == User::getCurrentUser())
            return false;
        $mUser = new User($this->id);
        $sql = "UPDATE user SET activated = '0' , status = '0' WHERE id = '$this->id'";
		if (mysqli_query($conn, $sql)) {
			//echo "<br>".$mUser->getFullName()." ".$mUser->isCompanyAdmin();
			if(!$mUser->isCompanyAdmin()){
				$mAddedBy = User::getCurrentUser();
				//echo "User  delete staff";
				return Timeline::addTimelineEvent("staff_addition", "", "", $this->getId(), $mAddedBy->getId(), -1);
			} else
				return true;
		} else {
			return false;
		}
	}
    
    function SetAddedby($id){
  
       $db = new Connection();
       $conn = $db->connect();


        $sql = "UPDATE user SET added_by = '$id' WHERE id = '$this->id'";
        if(mysqli_query($conn, $sql))        
            return true;
        else
            return false;

      }

    
    
}

//User::resetpasswordmail('dheerajagrawal19@gmail.com');
?>