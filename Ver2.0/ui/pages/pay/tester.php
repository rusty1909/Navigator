<?php
	require_once "../../../utility/helper/Pay/PayHelper.php"; 

	$mEmployeeList = $mCompany->getEmployeeList();

    $payHelper = new PaymentHelper();

    $amount = 1200;
    $productinfo = 'activation';
    $txnid = '121212';
    echo  $payHelper->ProcessPayment($amount, $productinfo , 'payu', $txnid, 1);
?>