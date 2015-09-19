<?php
require_once "../../master/headerhomephp.php"; 
require_once "../../master/headerhomehtml.php";
?>
<style>

.column-right {
  width: 48%;
  float: left;
  margin: auto;
}
</style>

 <script type="text/javascript" src="http://www.findgaddi.com/navigator/Ver2.0/js/userreg.js"></script>
 						
				<div class="content-box-content-no-border">
					<div class="content-box-content-no-border">
					
					<div style="display: block;" class="tab-content default-tab" id="tab2">
					
						<form action="../../../utility/helper/User/UserActionHelper.php?action=register" method="POST" onSubmit="return validate()">
							
							<fieldset> <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->
								
								<p class="column-left">
									<label>FirstName <span class="mandatory">*</span></label>
									<input class="text-input medium-input" id="firstname" name="firstname" type="text" style="width:95% !important" required placeholder='Rudra'> <!--<span class="input-notification success png_bg">Successful message</span> 
										<br><small>A small description of the field</small>-->
								</p>
								
								<p class="column-right" style="margin: 0 -10px 0 0;">
									<label>LastName</label>
									<input class="text-input medium-input" id="lastname" name="lastname" type="text"  style="width:95% !important" required placeholder='Goyal'> 
								</p>
								
								<p>
									<label>Username <span class="mandatory">*</span></label>
									<input class="text-input medium-input" id="username" name="username" type="text" style="width:45.5% !important" onBlur="checkForUser(this.value)" required placeholder='xyz132'><span class="input-notification error png_bg" id="user_error"></span><span class="input-notification success png_bg" id="user_success"></span>
								</p>

								<p class="column-left">
									<label>Password <span class="mandatory">*</span></label>
									<input class="text-input medium-input" id="password" name="password" type="password" style="width:95% !important" required> <!--<span class="input-notification success png_bg">Successful message</span> 
										<br><small>A small description of the field</small>-->
								</p>
								
								<p class="column-right">
									<label>Re-Type Password <span class="mandatory">*</span></label>
									<input class="text-input medium-input" id="retype" name="retype" type="password"  style="width:95% !important" onBlur="checkPassword()" required><br><span class="input-notification error png_bg" id="pass_error"></span><span class="input-notification success png_bg" id="pass_success"></span>
								</p>

								<p>
									<label>Email <span class="mandatory">*</span></label>
									<input class="text-input medium-input" id="email" name="email" type="email" style="width:45.5% !important" onBlur="checkForEmail(this.value)" required placeholder='xyz@xyz.com'> <span class="input-notification error png_bg" id="email_error"></span><span class="input-notification success png_bg" id="email_success"></span>
								</p>

								<p class="column-left">
									<label>Office Phone</label>
									<input class="text-input medium-input" type="number" id="phone_o" name="phone_o" style="width:95% !important" required placeholder='0123456789'> <!--<span class="input-notification success png_bg">Successful message</span> 
										<br><small>A small description of the field</small>-->
								</p>
								
								<p class="column-right">
									<label>Mobile <span class="mandatory">*</span></label>
									<input class="text-input medium-input" id="phone_m" name="phone_m" type="text" maxlength="10" style="width:95% !important" required placeholder='0123456789'> 
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
									<input class="text-input medium-input" id="pincode" name="pincode" type="text"  maxlength="6" required placeholder="110091" style="width:45.5% !important"> 
								</p>
								
								<p>
									<input class="button" value="   Register User   " type="submit">
								</p>
								
							</fieldset>
							
							<div class="clear"></div><!-- End .clear -->
							
						</form>
						
					</div> <!-- End #tab2 -->        
					
				</div> <!-- End .content-box-content -->
</div>
			<?php require_once "../../master/footerhome.php"; ?>