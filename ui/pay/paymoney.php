<?php
require_once "../../framework/User.php";
require_once "../../framework/Vehicle.php";
require_once "../../framework/Job.php";
require_once "../../framework/Driver.php";
require_once "../../framework/Company.php";
require_once "../../framework/PaymentHelper.php";
require_once "sensitivepayinfo.php";

$mUser = new User();
$payHelper = new PaymentHelper();

if(!empty($_GET)) {
    $vehPayInfo = $_GET['id'];         
}else{ 
    $vehPayInfo = 3;
}

$amount = $payHelper->GetPaymentByPayCode($vehPayInfo);

$vehicleIDs = $payHelper->GetVehicleListByPayCode($vehPayInfo);

?>
<html>
  <head>
  		<!-- Reset Stylesheet -->
		<link rel="stylesheet" href="../../res/reset.css" type="text/css" media="screen">
	  
		<!-- Main Stylesheet -->
		<link rel="stylesheet" href="../../res/style.css" type="text/css" media="screen">
		
		<!-- Invalid Stylesheet. This makes stuff look pretty. Remove it if you want the CSS completely valid -->
		<link rel="stylesheet" href="../../res/invalid.css" type="text/css" media="screen">	
  
		<!-- jQuery -->
		<script type="text/javascript" src="../../res/jquery-1.js"></script>
		
		<!-- jQuery Configuration -->
		<script type="text/javascript" src="../../res/simpla.js"></script>
		
		<!-- Facebox jQuery Plugin -->
		<script type="text/javascript" src="../../res/facebox.js"></script>
		
		<!-- jQuery WYSIWYG Plugin -->
		<script type="text/javascript" src="../../res/jquery_002.js"></script>
		
		<!-- jQuery Datepicker Plugin -->
		<script type="text/javascript" src="../../res/jquery.htm"></script>
		<script type="text/javascript" src="../../res/jquery.js"></script>

    	  <!--  //modal box jquery -->
		<link rel="stylesheet"  href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
		<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
		<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
      
      <script>
    var hash = '<?php echo $hash ?>';
    function submitPayuForm() {
      if(hash == '') {
        return;
      }
      var payuForm = document.forms.payuForm;
      payuForm.submit();
    }
 
document.title = "Payment Gateway | FindGaddi "; 
  </script>
      
  </head>
   <body onload="submitPayuForm()">
	<?php include('../sidebar.php');?>
		
		<div id="main-content"> <!-- Main Content Section with everything -->
             
    <?php if($formError) { ?>
	  <span style="color:red">Please fill all mandatory fields.</span>
      <br/>
      <br/>
    <?php } ?>
             <h2>FindGaddi Payment System :</h2>
              <br />
             <div id="userMessage"> </div>
             <br>
            <?php include_once("membershipplans.php"); ?>  <br><br>
            
    <form action="<?php echo $action; ?>" method="post" name="payuForm">
      <input type="hidden" name="key" value="<?php echo $MERCHANT_KEY ?>" />
      <input type="hidden" name="hash" value="<?php echo $hash; ?>" />
      <input type="hidden" name="txnid" value="<?php echo $txnid ?>" />
      <input type="hidden" name="surl" value="<?php echo $sucUrl; ?>" size="64" />
      <input type="hidden" name="furl" value="<?php echo $failUrl;  ?>" size="64" />
      <input type="hidden" name="service_provider" value="payu_paisa" size="64" />
        <table width='90%'>
        <tr>
          <td><b>Please confirm all details and submit the amount.</b></td>
        </tr>
        <tr>
          <td>Amount: </td>
          <td><input name="amount" value="<?php echo (empty($posted['amount'])) ? $amount : $posted['amount'] ?>" readonly /></td>
        </tr>
        <tr>
              <td>First Name: </td>
              <td><input name="firstname" id="firstname" value="<?php echo (empty($posted['firstname'])) ? $mUser->getFullName() : $posted['firstname']; ?>" /></td>
        </tr>
          <tr>
              <td>Phone: </td> 
              <td><input name="phone" value="<?php echo (empty($posted['phone'])) ? $mUser->getPhoneMobile() : $posted['phone']; ?>" /></td>
          </tr>
        <tr>
          <td>Email: </td>
          <td><input name="email" id="email" value="<?php echo (empty($posted['email'])) ? $mUser->getEmail() : $posted['email']; ?>" /></td>
        </tr>
        <tr>
          <td>Product Code: </td>
          <td ><input name="productcode" readonly value="<?php echo (empty($posted['productinfo'])) ? $vehPayInfo : $posted['productinfo'] ?>" /></td>
        </tr>
        <tr>
          <td>Product Info: </td>
          <td ><input name="productinfo" readonly value="<?php echo  $vehicleIDs; ?>" /></td>
        </tr>
      </table>
        <br>
        
          <?php if(!$hash) { ?>
            <div class="row"><button type="submit">Pay, now</button> </div>
          <?php } ?>
            
    </form>
			
<?php include("../footer.php")?>
			
		</div> <!-- End #main-content -->
		
 </body></html>