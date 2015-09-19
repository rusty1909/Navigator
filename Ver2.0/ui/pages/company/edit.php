<?php
	require_once "../../../utility/helper/Company/CompanyHelper.php"; 
	require_once "../../master/headerhomephp.php";
	require_once "../../master/headerhomehtml.php"; 
?>		
 <script type="text/javascript" src="http://www.findgaddi.com/navigator/Ver2.0/js/companyedit.js"></script>
				<div class="content-box-header">					
					<h3 style="cursor: s-resize;"> Update Company Details</h3>					
				</div> <!-- End .content-box-header -->				
				<div class="content-box-content">					
					<div style="display: block;" class="tab-content default-tab">					
<form action="http://www.findgaddi.com/navigator/Ver2.0/utility/helper/Company/CompanyActionHelper.php?action=update" method="POST" onSubmit="return validate()">
							
							<fieldset> <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->
							
								<p class="column-left">
									<label>Address Line 1 <span class="mandatory">*</span></label>
									<input class="text-input medium-input" id="address_1" name="address_1" value="<?php echo $mCompany->getAddress1(); ?>" type="text" style="width:99.5% !important">
								</p>
							
								<p class="column-right">
									<label>Address Line 2</label>
									<input class="text-input medium-input" id="address_2" name="address_2" value="<?php echo $mCompany->getAddress2(); ?>" type="text" style="width:99.5% !important">
								</p>
								
								<p class="column-left">
									<label>Landmark </label>
									<input class="text-input medium-input" id="landmark" name="landmark" value="<?php echo $mCompany->getLandmark(); ?>" type="text" style="width:45.5% !important"> <!--<span class="input-notification success png_bg">Successful message</span> 
										<br><small>A small description of the field</small>-->
								</p>
								
								<p class="column-right">
									<label>City <span class="mandatory">*</span></label>
									<input class="text-input medium-input" id="city" name="city" value="<?php echo $mCompany->getCity(); ?>" type="text"  style="width:45.5% !important"> 
								</p>
				
								<p class="column-left">
									<label>State <span class="mandatory">*</span></label>
									<input class="text-input medium-input" id="state" name="state" value="<?php echo $mCompany->getState(); ?>" type="text" style="width:45.5% !important"> <!--<span class="input-notification success png_bg">Successful message</span> 
										<br><small>A small description of the field</small>-->
								</p>
								
								<p class="column-right">
									<label>Pin Code <span class="mandatory">*</span></label>
									<input class="text-input medium-input" id="pincode" name="pincode" type="text" value="<?php echo $mCompany->getPincode(); ?>" style="width:45.5% !important"> 
								</p>

								<p class="column-left">
									<label>Phone <span class="mandatory">*</span></label>
									<input class="text-input medium-input" id="phone" name="phone" type="text" value="<?php echo $mCompany->getPhone(); ?>" style="width:45.5% !important"> <!--<span class="input-notification success png_bg">Successful message</span> 
										<br><small>A small description of the field</small>-->
								</p>
								
								<p class="column-right">
									<label>Fax </label>
									<input class="text-input medium-input" id="fax" name="fax" type="text" value="<?php echo $mCompany->getFax(); ?>" style="width:45.5% !important"> 
								</p>

								<p class="column-left">
									<label>Email</label>
									<input class="text-input medium-input" id="email" name="email" type="email" value="<?php echo $mCompany->getEmail(); ?>" style="width:45.5% !important"> <!--<span class="input-notification success png_bg">Successful message</span> 
										<br><small>A small description of the field</small>-->
								</p>
								
								<p class="column-right">
									<label>Website </label>
									<input class="text-input medium-input" id="website" name="website" type="text" value="<?php echo $mCompany->getWebsite(); ?>" style="width:45.5% !important"> 
								</p>
								
								<p>
									<input class="button" value="   Update Changes   " type="submit">
								</p>
								
							</fieldset>
							
							<div class="clear"></div><!-- End .clear -->
							
						</form>
					</div> <!-- End #tab3 -->					
				</div> <!-- End .content-box-content -->	

			<?php require_once "../../master/footerhome.php"; ?>