<?php
error_reporting(E_ALL);
ini_set('display_errors',1);


if(!isset($_SESSION))
    session_start();

require_once 'Connection.php';
require_once 'User.php';

class Company {
    private $id;
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
        $sql ="SELECT * FROM company WHERE id='$id'";
        $action = mysqli_query($conn, $sql);
        if (mysqli_num_rows($action) > 0) {
            while($row = mysqli_fetch_assoc($action)) {
                $this->id = $row['id'];
                $this->name = $row['name'];
                $this->tinNumber = $row['tin_number'];
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


    public static function add($name, $tin_number, $address_1, $address_2, $landmark, $city, $state, $pincode, $phone, $fax, $email, $website, $description) {
        // opening db connection
        $db = new Connection();
        $conn = $db->connect();
        //user details
        $userId = $_SESSION['user']['id'];
        $username = $_SESSION['user']['username'];
        $sql = "INSERT INTO `company`( `name`, `tin_number`, `address_1`, `address_2`, `landmark`, `city`, `state`, `pincode`, `phone`, `fax`, `email`, `website`, `admin_user`, `description`) VALUES ('$name', '$tin_number', '$address_1', '$address_2', '$landmark', '$city', '$state', '$pincode', '$phone', '$fax', '$email', '$website', '$userId', '$description')";

        /*if($conn != null) echo "1111<br>";*/
        if (mysqli_query($conn, $sql)) {
            $getCompany = "SELECT id FROM company WHERE name='$name' AND tin_number='$tin_number' AND website='$website'";
       
            $action = mysqli_query($conn, $getCompany);
            if (mysqli_num_rows($action) > 0) {
                while($row = mysqli_fetch_assoc($action)) {
                    $companyId = $row['id'];
                    $_SESSION['user']['company'] = $companyId;
                    $mUser = new User();
                    $mUser->setCompany($companyId);
                    $mUser->updateCompanyToVehicle();
                    return true;
                }
            } else {
                return false;
            }
        } else {
            echo mysqli_error($conn);
            return false;
        }
    }

    function getName() {
        return $this->name;
    }

    public static function isCompanyRegistered($id) {
        $db = new Connection();
        $conn = $db->connect();

        $mUser = new User();
        $userid = $mUser->getId();

        $sql = "SELECT * FROM company WHERE id='$id' AND admin_user='$userid'";
        $action = mysqli_fetch_assoc(mysqli_query($conn, $sql));
        if($action != null)
            return true;

        return false;
    }

    public static function getIdByTin($tin) {
        // opening db connection
        $db = new Connection();
        $conn = $db->connect();

        $sql = "SELECT id FROM company WHERE tin_number = '$tin'";
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
    
    public function change($name, $tin_number, $address_1, $address_2, $landmark, $city, $state, $pincode, $phone, $fax, $email, $website, $description) {
        // opening db connection
        $db = new Connection();
        $conn = $db->connect();
        
        $mUser = new User();
        $comid = $mUser->getCompany();
        $id = $mUser->getId();
        $sql = "UPDATE `company` SET `name`='$name', `tin_number`='$tin_number', `address_1`='$address_1', `address_2`='$address_2', `landmark`='$landmark', `city`='$city', `state`='$state' , `pincode`='$pincode', `phone`='$phone', `fax`='$fax', `email`='$email', `website`='$website', `description`='$description' WHERE admin_user= '$id' AND id='$comid'";

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

        $sql = "SELECT id FROM company WHERE $col = '$value'";
        $action = mysqli_query($conn, $sql);
        if (mysqli_num_rows($action) > 0) {
            return true;
        }
        return false;
    }
    
    function getAdmin(){
		return $this->admin;
	}
    
    function getPhone(){
		return $this->phone;
	}
}
?>
