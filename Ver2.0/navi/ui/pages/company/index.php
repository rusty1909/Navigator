<?php
	require_once "../../../utility/helper/Common/CommonHelper.php";

	$isCompanyAdmin = $mUser->isCompanyAdmin();

	$mEmployeeList = $mCompany->getEmployeeList();

    $payHelper = new PaymentHelper();

    $duePayment = ($payHelper->getDuepaymentForActivation() + $payHelper->getDuepayment());

    $vehPayInfo = $payHelper->GetPaymentCode();

    $vehicleList = $payHelper->GetVehicleList();

	require_once "../../master/headerhomehtml.php"; 

?>
 <script type="text/javascript" src="http://www.findgaddi.com/navigator/Ver2.0/js/companyindex.js"></script>
  		
<div class="content-box column-left" style="width:63%">				
    <div class="content-box-header">

        <h3 style="cursor: s-resize;"><?php echo $mCompany->getName(); ?></h3>

        <ul class="content-box-tabs">
            <li><a href="#info" <?php if(!isset($_GET['page'])) echo "class='default-tab current'" ?>>Basic Information</a></li> <!-- href must be unique and match the id of target div -->
            <li><a href="#staff" <?php if(isset($_GET['page']) && $_GET['page']=='staff') echo "class='default-tab current'" ?>>Staff(<?php echo sizeof($mEmployeeList); ?>)</a></li>

            <!--<li><a <?php if(isset($_GET['page']) && ($_GET['page']=='payment')) echo "class='default-tab current'" ?> 
                <?php if(!$isCompanyAdmin) {echo "style='cursor:not-allowed' title='This feature is available only to Company Admin.'";} else { echo "href='#payment'";} ?>>Due Payment(<?php echo -($duePayment); ?>)</a></li>-->

            <?php if($isCompanyAdmin) { ?>
                <li><a href="#payment" <?php if(isset($_GET['page']) && ($_GET['page']=='payment')) echo "class='default-tab current'" ?> >Due Payment(<?php echo -($duePayment); ?>)</a></li>
            <?php } ?>
            <li><a href="#setting">Settings</a></li>						

        </ul>

        <div class="clear"></div>

    </div>
    <div class="content-box-content">
        <div style="display: block;" class="tab-content <?php if(!isset($_GET['page'])) echo " default-tab" ?>" id="info">
            <div id="basic">
                <form action="edit.php"><fieldset>
                    <p class="column-left">
                        <input class="button" value="   Edit   " type="submit" id="edit_button">
                        <br><br>
                        <b>TIN Number</b><br>
                        <?php echo $mCompany->getTINNumber(); ?>
                        <br><br>
                        <b>Address</b><br>
                        <?php echo $mCompany->getAddress(); ?>

                    </p>

                    <p class="column-right">
                        <br><br>
                        <b>Contact Details</b><br>
                        <b>Phone : </b><?php if($mCompany->getPhone() != 0) echo $mCompany->getPhone(); ?><br>
                        <b>Fax : </b><?php if($mCompany->getFax() != 0) echo $mCompany->getFax(); ?><br>
                        <b>Email : </b><a target="_mail" href='mailto:<?php echo $mCompany->getEmail(); ?>'><?php echo $mCompany->getEmail(); ?></a><br>
                        <b>Website : </b><a target="_website" href='http://<?php echo $mCompany->getWebsite(); ?>'><?php echo $mCompany->getWebsite(); ?></a><br>
                    </p>


                </fieldset></form>
            </div>

        </div>
<!-- payments -->
<div style="display: block;" class="tab-content <?php if(isset($_GET['page']) && $_GET['page']=='payment') echo " default-tab" ?>" id="payment">	
 <table>
     <tr><td>Due Amount For Next Month :</td> <td>Vehicle List (<?php echo $payHelper->GetVehicleListPaymentReq(); ?>) </td> <td> <?php echo $payHelper->getDuepayment() ?> </td><td><button><a href='../pay/paymoney.php?id=2'>Pay Now</a></button></td></tr>
     <tr><td>Activate Your Waiting Vehicles in just :</td> <td>Activation Vehicle List (<?php echo $payHelper->GetVehicleListActivationReq(); ?>) </td> <td> <?php echo $payHelper->getDuepaymentForActivation() ?> </td><td><button><a href='../pay/paymoney.php?id=1'>Pay Now</a></button></td></tr>
      <tr><td>Activate and Pay All Dues :</td> <td>Vehicle List (<?php echo $payHelper->GetVehicleList(); ?>) </td> <td> <?php echo $duePayment ?> </td><td><button><a href='../pay/paymoney.php?id=3'>Pay Now</a></button></td></tr>
 </table>        

<!--    <form action="../pay/paymoney.php" method="POST">
    <input type="hidden" name="amount" value="<?php echo $duePayment; ?>" />
    <input type="hidden" name="veh_pay" value="<?php echo $vehPayInfo ?>" />
    <input type="hidden" name="vehicles" value="<?php echo $vehicleList ?>" />
    <input class="button" value="   Pay Now   " type="submit">
 </form>
-->
        </div> <!-- End #payments -->

       <div style="display: block;" class="tab-content <?php if(isset($_GET['page']) && $_GET['page']=='staff') echo " default-tab" ?>" id="staff">	

            <?php
            if(sizeof($mEmployeeList) == 0) {
            ?>
            <div class="notification attention png_bg">
                <div>
                    You don't have any employee in this category.
                </div>
            </div>
            <?php } else {?>

            <table>

                <thead>
                    <tr>
                       <th>Name</th>
                       <th>Phone</th>
                       <th>Address</th>
                       <th>Action</th>
                    </tr>

                </thead>

                <tfoot>
                    <tr>
                        <td colspan="6">
                            <div class="bulk-actions align-left">
                                <a class="button" class='js-open-modal' href='#' data-modal-id='add-employee' >Add Employee</a>
                            </div>

                            <!--<div class="pagination">
                                <a href="#" title="First Page">« First</a><a href="#" title="Previous Page">« Previous</a>
                                <a href="#" class="number" title="1">1</a>
                                <a href="#" class="number" title="2">2</a>
                                <a href="#" class="number current" title="3">3</a>
                                <a href="#" class="number" title="4">4</a>
                                <a href="#" title="Next Page">Next »</a><a href="#" title="Last Page">Last »</a>
                            </div> --><!-- End .pagination -->
                            <div class="clear"></div>
                        </td>
                    </tr>
                </tfoot>

                <tbody>
                    <?php
                    for($i=0; $i<sizeof($mEmployeeList); $i++) {
                        $mEmployee = new User($mEmployeeList[$i]);
                        echo "<tr>";
                        echo "<td><img height='15' width='15' src='http://www.findgaddi.com/navigator/Ver2.0/images/driver_icon.png'>&nbsp;&nbsp;<b>".$mEmployee->getFullName()."</b></td>";
                        echo "<td>".$mEmployee->getPhoneMobile()."</td>";
                        echo "<td>".$mEmployee->getAddress()."</td>";
                        if($mUser->isCompanyAdmin() && $mUser->getId() != $mEmployee->getId()) {
                            echo "<td>
                                <!-- Icons -->
                                 <a href='#' title='Edit'><img src='http://www.findgaddi.com/navigator/Ver2.0/images/pencil.png' alt='Edit'></a>
                                 <a href='#' title='Delete' onClick='onDelete(".$mEmployee->getId().")'><img src='http://www.findgaddi.com/navigator/Ver2.0/images/cross.png' alt='Delete'></a>
                            </td>";
                        } else{
                            echo "<td></td>";
                        }
                        echo "</tr>";	
                    }
                    ?>
                </tbody>

            </table>
            <?php } ?>
        </div> <!-- End #staff -->



        <div style="display: block;" class="tab-content" id="payment">					
            <p>

            Make Payments and keep using the findgaddi services.
            </p>
        </div> <!-- End #tab3 -->					

        <div style="display: block;" class="tab-content" id="setting">					
            <p>
                Change Settings for notifications and alerts.
            </p>
        </div> <!-- End #tab3 -->					

    </div> <!-- End .content-box-content -->				
</div>
<div class="content-box column-right" style="width:35%;height:88%;">
    <div class="content-box-header"> <!-- Add the class "closed" to the Content box header to have it closed by default -->
        <h3 style="cursor: s-resize;">Timeline</h3>
    </div> <!-- End .content-box-header -->

    <div style="display: block;padding:0px;height:93%;overflow-y:auto" class="content-box-content">

        <div style="display:block;overflow-y:auto" class="tab-content default-tab" id="item-list">

            <table id="timeline_table">
            <thead>
            <tr></tr>
            </thead>
            <tbody style="border-bottom:0px" id="timeline_body">
            <tr><td><b>Loading Notifications</b></td></tr>
            </tbody>
            </table>
        </div> <!-- End #tab3 -->  
    </div> <!-- End .content-box-content -->

</div>

<div id="add-employee" class="modal-box" style="width:50%;">  
		<header>
			<h3>Add Staff</h3>
		</header>
		<div class="modal-body" id="item-list">
						
     <!---------------------------------------------------------------------------------------------------------------------------------->       
            <form action="http://www.findgaddi.com/navigator/Ver2.0/utility/helper/Company/CompanyActionHelper.php?action=registerEmployee" method="POST" onSubmit="return validate()">
							
							<fieldset> <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->
							
								<p class="column-left">
									<label>Employee Name <span class="mandatory">*</span></label>
									<input class="text-input medium-input" id="name" name="name" type="text" style="width:45.5% !important" required placeholder="Ranjan Singh"> <span class="input-notification error png_bg" id="name_error"></span><span class="input-notification success png_bg" id="name_success"></span>  
								</p>
							
								<p class="column-right">
									<label>Employee ID <span class="mandatory">*</span></label>
									<input class="text-input medium-input" id="emp_id" name="emp_id" type="text" style="width:45.5% !important"  required placeholder="11223344h"> <span class="input-notification error png_bg" id="emp_id_error"></span><span class="input-notification success png_bg" id="emp_id_success"></span>  
								</p>
								
								<p class="column-left">
									<label>Address Line 1 <span class="mandatory">*</span></label>
									<input class="text-input medium-input" id="address_1" name="address_1" type="text" style="width:99.5% !important"  required placeholder="Chawri bazar">
								</p>
							
								<p class="column-right">
									<label>Address Line 2</label>
									<input class="text-input medium-input" id="address_2" name="address_2" type="text" style="width:99.5% !important">
								</p>
								
								<p class="column-left">
									<label>Landmark </label>
									<input class="text-input medium-input" id="landmark" name="landmark" type="text" style="width:45.5% !important"> <!--<span class="input-notification success png_bg">Successful message</span> 
										<br><small>A small description of the field</small>-->
								</p>
								
								<p class="column-right">
									<label>City <span class="mandatory">*</span></label>
									<input class="text-input medium-input" id="city" name="city" type="text"  style="width:45.5% !important"  required placeholder="New Delhi"> 
								</p>
				
								<p class="column-left">
									<label>State <span class="mandatory">*</span></label>
									<input class="text-input medium-input" id="state" name="state" type="text" style="width:45.5% !important"  required placeholder="Delhi"> <!--<span class="input-notification success png_bg">Successful message</span> 
										<br><small>A small description of the field</small>-->
								</p>
								
								<p class="column-right">
									<label>Pin Code <span class="mandatory">*</span></label>
									<input class="text-input medium-input" id="pincode" name="pincode" type="text" maxlength="6" style="width:45.5% !important"> 
								</p>

								<p class="column-left">
									<label>Phone <span class="mandatory">*</span></label>
									<input class="text-input medium-input" id="phone" name="phone" type="text" maxlength="10" style="width:45.5% !important"  required placeholder="0123456789"> <!--<span class="input-notification success png_bg">Successful message</span> 
										<br><small>A small description of the field</small>-->
								</p>
								
								<p class="column-left">
									<label>Email <span class="mandatory">*</span></label>
									<input class="text-input medium-input" id="email" name="email" type="email" required style="width:45.5%  !important"> <!--<span class="input-notification success png_bg">Successful message</span> 
										<br><small>A small description of the field</small>-->
								</p>
								
								</fieldset>
							
							<div class="clear"></div><!-- End .clear -->					
				
<!----------------------------------------------------------------------------------------------------------------------------->

	  <footer>
		<b><input class="button" value="SUBMIT" type="submit">&nbsp;</b>
		<a href="#" class="js-modal-close" style="color:#D3402B"><b>CANCEL</b></a>
	  </footer>
                            
	  </form>

		</div>		
	</div>
			
<?php require_once "../../master/footerhome.php"; ?>