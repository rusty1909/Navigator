<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    
    ini_set('session.cookie_domain', '.findgaddi.com' );
    session_set_cookie_params(0, '/', '.findgaddi.com');

    if(!isset($_SESSION))
	   session_start();

	require_once "../../../framework/User.php";
	require_once "../../../framework/Vehicle.php";
	require_once "../../../framework/Company.php";
	require_once "../../../framework/Driver.php";
	require_once "../../../framework/Expense.php";
    require_once "../../../framework/Job.php";
    require_once "../../../framework/PaymentHelper.php";

    if(!User::isLoggedIn() && (strtolower("$_SERVER[HTTP_HOST]") !=  strtolower("login.findgaddi.com"))) {
        $_SESSION['cur_url'] = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        header("location: http://login.findgaddi.com/");
        exit();
    }

    $mUser = new User();
    $mCompany = new Company($mUser->getCompany());
?>

        