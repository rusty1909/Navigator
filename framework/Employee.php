<?php
error_reporting(E_ALL);
ini_set('display_errors',1);


if(!isset($_SESSION))
    session_start();

require_once 'Connection.php';
require_once 'User.php';



class Employee {
    private $id;
    public $company;
    public $name;
    public $tinNumber;
    public $address1;
    public $address2;
    public $landmark;
    public $city;
    public $state;
    public $pincode;
    public $email;
    public $phone;
    public $fax;
    public $website;
    private $admin;
    public $description;
    private $dateAdded;

    function __construct($id) {
        // opening db connection
        $db = new Connection();
        $conn = $db->connect();
        $sql ="SELECT * FROM employee WHERE id='$id'";
        $action = mysqli_query($conn, $sql);
        if ($action!= null && mysqli_num_rows($action) > 0) {
            while($row = mysqli_fetch_assoc($action)) {
                $this->id = $row['id'];
                $this->name = $row['name'];
                $this->tinNumber = $row['empID'];
                $this->address1 = $row['address_1'];
                $this->address2 = $row['address_2'];
                $this->landmark = $row['landmark'];
                $this->city = $row['city'];
                $this->state = $row['state'];
                $this->pincode = $row['pincode'];
                $this->phone = $row['phone'];
                $this->email = $row['email'];
                $this->fax = $row['fax'];
                $this->website = $row['website'];
                $this->admin = $row['admin_user'];
                $this->description = $row['description'];
                $this->dateAdded = $row['date_added'];
            }
        }
    }


    public static function add($company, $name, $empID, $address_1, $address_2, $landmark, $city, $state, $pincode, $phone, $email) {
        // opening db connection
        $db = new Connection();
        $conn = $db->connect();
        //user details
        $userId = $_SESSION['user']['id'];
        $username = $_SESSION['user']['username'];
        $company = $_SESSION['user']['company'];
        
        $website = "";
        $description = "";
             
        $sql = "INSERT INTO `employee`( `company` , `name`, `empID`, `address_1`, `address_2`, `landmark`, `city`, `state`, `pincode`, `phone`, `fax`, `email`, `website`, `admin_user`, `description`) VALUES ('$company', '$name', '$empID', '$address_1', '$address_2', '$landmark', '$city', '$state', '$pincode', '$phone', '', '$email', '', '$userId', '')";

        if (mysqli_query($conn, $sql)) {
            $getCompany = "SELECT id FROM employee WHERE name='$name' AND empID='$empID'";
       
            $action = mysqli_query($conn, $getCompany);
            if (mysqli_num_rows($action) > 0) {
                    if(User::add($name, '', $email, 'findgaddi', $phone, $phone, $email, $company))
                        return true;
                    else
                        return false;
            } else {
                return false;
            }
        } else {
            echo mysqli_error($conn);
            return false;
        }
    }

    public static function workingEmployee($com){
        $db = new Connection();
        $conn = $db->connect();
       
        $sql = "SELECT id FROM employee WHERE company = '$com'";
        $action = mysqli_query($conn, $sql);
       
        return mysqli_num_rows($action);        
    }
        
    function getName() {
        return $this->name;
    }

    public static function isCompanyRegistered($id) {
        $db = new Connection();
        $conn = $db->connect();

        $mUser = new User();
        $userid = $mUser->getId();

        $sql = "SELECT * FROM employee WHERE id='$id' AND admin_user='$userid'";
        $action = mysqli_fetch_assoc(mysqli_query($conn, $sql));
        if($action != null)
            return true;

        return false;
    }

    public static function getIdByTin($tin) {
        // opening db connection
        $db = new Connection();
        $conn = $db->connect();

        $sql = "SELECT id FROM employee WHERE empID = '$tin'";
        $action = mysqli_query($conn, $sql);
        if (mysqli_num_rows($action) > 0) {
            while($row = mysqli_fetch_assoc($action)) {
                return $row['id'];
            }
        }
        return null;
    }


    function getWaitingVehicleList() {
        // opening db connection
        $db = new Connection();
        $conn = $db->connect();
        
        $result = array();
        $sql = "SELECT id, vehicle_number FROM vehicle WHERE company_id = '$this->id' AND deployed='0'";
        $action = mysqli_query($conn, $sql);
        if (mysqli_num_rows($action) > 0) {
            while($row = mysqli_fetch_assoc($action)) {
                //array_push($result['id'], $row['id']);
                $result['vehicle'][]=$row;
            }
        }
        return $result;
    }

    function getAllVehicleList() {
        // opening db connection
        $db = new Connection();
        $conn = $db->connect();

        $result = array();
        $sql = "SELECT id, vehicle_number FROM vehicle WHERE company_id = '$this->id'";
        $action = mysqli_query($conn, $sql);
        if (mysqli_num_rows($action) > 0) {
            while($row = mysqli_fetch_assoc($action)) {
                //array_push($result['id'], $row['id']);
                $result['vehicle'][]=$row;
            }
        }
        return $result;

    }
    
    public function update(/*$name, $empID, */$address_1, $address_2, $landmark, $city, $state, $pincode, $phone, $fax, $email, $website, $description) {
        // opening db connection
        $db = new Connection();
        $conn = $db->connect();
        
        $mUser = new User();
        $comid = $mUser->getCompany();
        $id = $mUser->getId();
        $sql = "UPDATE `employee` SET `address_1`='$address_1', `address_2`='$address_2', `landmark`='$landmark', `city`='$city', `state`='$state' , `pincode`='$pincode', `phone`='$phone', `fax`='$fax', `email`='$email', `website`='$website', `description`='$description' WHERE admin_user= '$id' AND id='$comid'";

        if (mysqli_query($conn, $sql)) {
            return true;
        } else {
            echo mysqli_error($conn);
        }
    }

    public static function isExists($col, $value) {
        // opening db connection
        $db = new Connection();
        $conn = $db->connect();

        $sql = "SELECT id FROM employee WHERE $col = '$value'";
        $action = mysqli_query($conn, $sql);
        if (mysqli_num_rows($action) > 0) {
            return true;
        }
        return false;
    }
    
    function getAdmin(){
		return $this->admin;
	}
    
    function getId(){
		return $this->id;
	}
    
    function getPhone(){
		return $this->phone;
	}
	
    function getFax(){
		return $this->fax;
	}

    function getEmail(){
		return $this->email;
	}

    function getWebsite(){
		return $this->website;
	}
	
	function getTINNumber(){
		return $this->tinNumber;
	}
	
	function getLandmark(){
		return $this->landmark;
	}
	
	function getAddress1(){
		return $this->address1;
	}

	function getAddress2(){
		return $this->address2;
	}
	
	function getCity(){
		return $this->city;
	}

	function getState(){
		return $this->state;
	}

	function getPincode(){
		return $this->pincode;
	}
	
	function getAddress(){
		$address = "";
		if($this->address1 != "") $address.= $this->address1;
		if($this->address2 != "") $address.= "<br>".$this->address2;
		if($this->landmark != "") $address.= "<br><b>Near </b>".$this->landmark;
		if($this->city != "") $address.= "<br>".$this->city;
		if($this->state != "") $address.= ", ".$this->state;
		if($this->pincode != "") $address.= "<br>".$this->pincode;
		return $address;
	}
}
?>
