<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

	require_once "../../../framework/User.php";
	require_once "../../../framework/Vehicle.php";
	require_once "../../../framework/Company.php";
	require_once "../../../framework/Driver.php";
	require_once "../../../framework/Expense.php";
    require_once "../../../framework/Job.php";
    require_once "../../../framework/PaymentHelper.php";

    $mUser = new User();
    $mCompany = new Company($mUser->getCompany());
?>

        