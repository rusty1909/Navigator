<?php
/*success : 
{
    status : "SUCCESS"
    request : "setup"
    result : {
        vehicle : {
            id : "142763"
            type : "Truck"
            number : "DL12T3426"
            year : "2012"
            date_added : "15-06-2015"
        }
        company : {
            id : "4725"
            name : "Enroute India Pvt Ltd"
            phone : "8756345472"
            admin : {
                id : "2648"
                name : "Prateek Srivastava"
                phone : "8354627345"
            }
        }
    }
} */

/*fail : 
{
    status : "FAILURE"
    request : "setup"
    result : {
		error : {
			reason : "FAIL_VEHICLE"
			message : "No such vehicle available!!!"
		}
    }
}*/

private class SetupResponse {
	public $status;
	public $request = "setup";
	public $result;
}

private class Error {
	public $reason;
	public $message;
}

private class Vehicle {
	public $id;
	public $number;
	public $type;
	public $year;
	public $date_added;
}

private class Company {
	public $id;
	public $name;
	public $phone;
	public $admin;
}

private class Admin {
	public $id;
	public $name;
	public $phone;
}

$setupResponse = new SetupResponse();

if(isset($_GET['vehicle']) && isset($_GET['type']) && isset($_GET['imei']) && isset($_GET['mac'])) {
	$vehicle = trim($_GET['vehicle']);
	$type = trim($_GET['type']);
	$imei = trim($_GET['imei']);
	$mac = trim($_GET['mac']);
} else {
	$setupResponse->status = "FAILURE";
	$setupResponse->request = "setup";
	
	$error = new Error();
	$error->reason = "INSUFFICIENT DATA";
	$error->message = "Please provide complete information."
	
	$setupResponse->error = $error;
	echo json_encode($setupResponse);
}
?>