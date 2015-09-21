<?php
	require_once "../../../utility/helper/Common/CommonHelper.php";
	require_once "../../master/headerhomehtml.php"; 
?>

 <script type="text/javascript" src="http://www.findgaddi.com/navigator/Ver2.0/js/companyreg.js"></script>
 
				<div class="content-box-header">					
					<h3 style="cursor: s-resize;">Register Company</h3>					
				</div> 				
				<div class="content-box-content">					
					<div style="display: block;" class="tab-content default-tab">					
<form action="http://www.findgaddi.com/navigator/Ver2.0/utility/helper/Company/CompanyActionHelper.php?action=register" method="POST" onSubmit="return validate()">
							
							<fieldset> <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->
							
								<p class="column-left">
									<label>CompanyName <span class="mandatory">*</span></label>
									<input class="text-input medium-input" id="name" name="name" type="text" style="width:45.5% !important" onBlur="checkForName(this.value)" required placeholder="XYZ Pvt Ltd"> <span class="input-notification error png_bg" id="name_error"></span><span class="input-notification success png_bg" id="name_success"></span>  
								</p>
							
								<p class="column-right">
									<label>TIN Number <span class="mandatory">*</span></label>
									<input class="text-input medium-input" id="tin_number" name="tin_number" type="text" maxlength="11" style="width:45.5% !important" onBlur="checkForTIN(this.value)"  required> <span class="input-notification error png_bg" id="tin_error"></span><span class="input-notification success png_bg" id="tin_success"></span>  
								</p>
								
								<p class="column-left">
									<label>Address Line 1 <span class="mandatory">*</span></label>
									<input class="text-input medium-input" id="address_1"  required placeholder="Indira Bazar" name="address_1" type="text" style="width:99.5% !important">
								</p>
							
								<p class="column-right">
									<label>Address Line 2</label>
									<input class="text-input medium-input" id="address_2" name="address_2" type="text" style="width:99.5% !important">
								</p>
								
								<p class="column-left">
									<label>Landmark </label>
									<input class="text-input medium-input" id="landmark" name="landmark" type="text"  placeholder="Sanganeri Gate" style="width:45.5% !important"> <!--<span class="input-notification success png_bg">Successful message</span> 
										<br><small>A small description of the field</small>-->
								</p>
								
								<p class="column-right">
									<label>City <span class="mandatory">*</span></label>
									<input class="text-input medium-input" id="city" name="city" type="text"   required placeholder="New Delhi" style="width:45.5% !important"> 
								</p>
				
								<p class="column-left">
									<label>State <span class="mandatory">*</span></label>
									<input class="text-input medium-input" id="state" name="state" type="text" style="width:45.5% !important"  required placeholder="Delhi"> <!--<span class="input-notification success png_bg">Successful message</span> 
										<br><small>A small description of the field</small>-->
								</p>
								
								<p class="column-right">
									<label>Pin Code <span class="mandatory">*</span></label>
									<input class="text-input medium-input" id="pincode" name="pincode" type="text" maxlength="6" required placeholder="110091" style="width:45.5% !important"> 
								</p>

								<p class="column-left">
									<label>Phone <span class="mandatory">*</span></label>
									<input class="text-input medium-input" id="phone" name="phone" type="text" maxlength="10"  required placeholder="011 23456789" style="width:45.5% !important"> <!--<span class="input-notification success png_bg">Successful message</span> 
										<br><small>A small description of the field</small>-->
								</p>
								
								<p class="column-right">
									<label>Fax </label>
									<input class="text-input medium-input" id="fax" name="fax" type="text"  style="width:45.5% !important"> 
								</p>

								<p class="column-left">
									<label>Email</label>
									<input class="text-input medium-input" id="email" name="email" type="email" style="width:45.5% !important"> <!--<span class="input-notification success png_bg">Successful message</span> 
										<br><small>A small description of the field</small>-->
								</p>
								
								<p class="column-right">
									<label>Website </label>
									<input class="text-input medium-input" id="website" name="website" type="text"  style="width:45.5% !important"> 
								</p>
								
								<p>
									<input class="button" value="   Register Company   " type="submit">
								</p>
								
							</fieldset>
							
							<div class="clear"></div><!-- End .clear -->
							
						</form>
					</div> <!-- End #tab3 -->					
				</div> <!-- End .content-box-content -->				
			<?php require_once "../../master/footerhome.php"; ?>