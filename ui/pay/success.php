<?php
	require_once "../../framework/User.php";
	require_once "../../framework/Vehicle.php";
	require_once "../../framework/Job.php";
	require_once "../../framework/Driver.php";
	require_once "../../framework/Company.php";
    require_once "../../framework/PaymentHelper.php";

    $status=$_POST["status"];
    $firstname=$_POST["firstname"];
    $amount=$_POST["amount"];
    $txnid=$_POST["txnid"];
    $posted_hash=$_POST["hash"];
    $key=$_POST["key"];
    $productinfo=$_POST["productinfo"];
    $email=$_POST["email"];
    $salt="GQs7yium";

If (isset($_POST["additionalCharges"])) {
       $additionalCharges=$_POST["additionalCharges"];
        $retHashSeq = $additionalCharges.'|'.$salt.'|'.$status.'|||||||||||'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;
        
                  }
	else {	  

        $retHashSeq = $salt.'|'.$status.'|||||||||||'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;

         }
		 $hash = hash("sha512", $retHashSeq);
		 
       if ($hash != $posted_hash) {
	       echo "Invalid Transaction. Please try again";
		   }
	   else {

            $payHelper = new PaymentHelper();
            $payHelper->ProcessPayment($amount, $productinfo , 'payu', $txnid, 1);
           
           header("refresh:1;url=http://www.findgaddi.com/navigator/ui/");
             echo "<h3>Thank You. Your order is ". $productinfo .".</h3>";
             echo "<h4>We have received a payment of Rs. " . $amount . ". Your order will soon be shipped.</h4>";
		   }         
?>	