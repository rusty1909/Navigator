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

   

?>
<?php
$amount = isset($_POST['amount']);
$vehPayInfo = isset($_POST['veh_pay']);
$vehicleIDs = isset($_POST['vehicles']);    
?>

<html>
  <head>
  <script>
    var hash = '<?php echo $hash ?>';
    function submitPayuForm() {
      if(hash == '') {         return;      }
      var payuForm = document.forms.payuForm;
      payuForm.submit();
    }
   
function ChangeTable(){
    var code = document.getElementById("usercpnid").value;
     $.ajax({
        type:"POST",
        url:"applydiscountcode.php",
        data:{ 'code' : code
        },    // multiple data sent using ajax
        dataType: 'text',
        success: function (data) {
                if(data != "" && data != '0') {   
                   	    $("#couponTbl").hide(0);
                        var nPrice =  Math.ceil($('input[name="amount"]').val());
                        nPrice = nPrice *(100-data)/100;
                    
                        $('input[name="amount"]').val(nPrice);
                        document.getElementById("userMessage").innerHTML = "<h4>You have successfully applied the coupon code!!!</h4>";
                 }else{
                     document.getElementById("userMessage").innerHTML = "<h4>You applied wrong coupon code, please try again.</h4>";
                 }
            console.log(data); 
        },
   
         failure: function(){
        alert('wrong coupon code applied.');
     }
      });
      return false;
    }

document.title = "Payment Gateway | FindGaddi "; 
  </script>
  
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
  </head>
  <body onload="submitPayuForm()">
	<?php include('../sidebar.php');?>
		
		<div id="main-content"> <!-- Main Content Section with everything -->
             
    <?php if($formError) { ?>
	  <span style="color:red">Please fill all mandatory fields.</span>
      <br/>
      <br/>
    <?php } ?>
             
              <br />
             <div id="userMessage"> </div>
             <br>
            
    <form action="<?php echo $action; ?>" method="post" name="payuForm">
      <input type="hidden" name="key" value="<?php echo $MERCHANT_KEY ?>" />
      <input type="hidden" name="hash" value="<?php echo $hash ?>"/>
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
          <td ><input name="productcode" readonly value="<?php echo  $vehicleIDs; ?>" /></td>
        </tr>
        <tr>
          <td>Product Info: </td>
          <td ><input name="productinfo" readonly value="<?php echo (empty($posted['productinfo'])) ? $vehPayInfo : $posted['productinfo'] ?>" /></td>
        </tr>
      </table>
        <br>
        
              <?php if(!$hash) { ?>
            <div class="row"><button type="submit">Grab the Plan, now</button> </div>
          <?php } ?>
            
    </form>
             
<!--             <br><br>
<div id="couponTbl"> 
			
				<h2> Apply <span >Coupon!!! </span></h2>
				
				<h3> Apply Coupon Code and get upto 50% Discount on membership plans. </h3>			<br />		
				
				<table width="100%">
				<tr>
					<td width="20%"><h4> Coupon Code </h4></td>
					<td width="40%"><input name='usercpnid' type="text" id="usercpnid"></td>
					<td ><button name='cpnBtn' id='cpnBtn' value="Apply" style='width:100%' onclick="ChangeTable()">Apply</button></td>
				</tr> 
					<tr>
						<td colspan="3"><a href="https://www.facebook.com/findgaddi" style="float:right"  target="_blank" >Not Yet, Get the Promo Code now!!!</a></td>
					</tr>
					
				</table>
				<br />
			
</div> -->
			
	<!-- End Notifications -->
			
<?php include("../footer.php")?>
			
		</div> <!-- End #main-content -->
		
 </body></html>