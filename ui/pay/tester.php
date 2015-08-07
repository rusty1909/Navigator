<?php

	require_once "../../framework/User.php";
	require_once "../../framework/Vehicle.php";
	require_once "../../framework/Job.php";
	require_once "../../framework/Driver.php";
	require_once "../../framework/Company.php";
    require_once "../../framework/PaymentHelper.php";
    require_once "sensitivepayinfo.php";

    $mUser = new User();

	$mCompany = new Company($mUser->getCompany());
	
	$mEmployeeList = $mCompany->getEmployeeList();

    $payHelper = new PaymentHelper();

$amount = 1200;
$productinfo = 'activation';
$txnid = '121212';
   echo  $payHelper->ProcessPayment($amount, $productinfo , 'payu', $txnid, 1);
?>