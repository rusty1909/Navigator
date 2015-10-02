<?php
 require_once "../../../utility/helper/Pay/PayHelper.php"; 
	
if(!User::isLoggedIn())
	   header('Location: ../user/login.php');
	   
if(!empty($_GET)) {
    $vehPayInfo = $_GET['id'];         
}else{ 
    $vehPayInfo = 3;
}

$amount = $payHelper->GetPaymentByPayCode($vehPayInfo);

$vehicleIDs = $payHelper->GetVehicleListByPayCode($vehPayInfo);

?>
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
$(document).ready(submitPayuForm);
  </script>

		<div id="main-content"> <!-- Main Content Section with everything -->
              <h2>FindGaddi Payment System :</h2>
              <br />
            
    <?php  if(empty($amount)){ ?>
            <span style="color:green">Congrats, You have no due amount to pay!!!</span>
    <?php }else if($formError) { ?>
	  <span style="color:red">Please fill all mandatory fields.</span>
      <br/>
      <br/>
    <?php } ?>
            
             <div id="userMessage"> </div>
             <br>
            <?php include_once("../../../utility/helper/Pay/membershipplans.php"); ?>  <br><br>
            
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
          <td ><input name="productcode" readonly value="<?php echo (empty($posted['productcode'])) ? $vehPayInfo : $posted['productcode'] ?>" /></td>
        </tr>
        <tr>
          <td>Product Info: </td>
          <td ><input name="productinfo" readonly  value="<?php echo (empty($posted['productinfo'])) ? $vehicleIDs : $posted['productinfo'] ?>"/></td>
        </tr>
      </table>
        <br>
        
          <?php if(!empty($amount) && !$hash) { ?>
            <div class="row"><button type="submit">Pay, now</button> </div>
          <?php } ?>
            
    </form>
			</div>

<?php require_once "../../master/footerhome.php"; ?>