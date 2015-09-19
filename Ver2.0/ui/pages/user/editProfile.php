<?php
    require_once "../../../utility/helper/User/UserHelper.php"; 
	
    if(!User::isLoggedIn())
	       header('Location: login.php');

	require_once "../../master/headerhomephp.php"; 
    require_once "../../master/headerhomehtml.php";
?>			
	<script type="text/javascript" src="http://www.findgaddi.com/navigator/Ver2.0/js/userindex.js"></script>
<div class="content-box column-left">				
				<div class="content-box-header">					
					<h3 style="cursor: s-resize;"> Update Password</h3>					
				</div> <!-- End .content-box-header -->				
				<div class="content-box-content">					
					<div style="display: block;" class="tab-content default-tab">					
						<form action="../../../utility/helper/User/UserActionHelper.php?action=change" method="POST">
							
							<fieldset> <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->
							
								<p>
									<label>Current Password</label>
									<input class="text-input medium-input" id="old" name="old" type="password">
								</p>
								
								<p>
									<label>New Password</label>
										<input class="text-input medium-input" id="new" name="new" type="password">
								</p>
								
								<p>
									<label>Re-type Password</label>
										<input class="text-input medium-input" id="retype" name="retype" type="password"> <span id="notify" class="input-notification error png_bg">Passwords do not match.</span>
								</p>
								<p>
									<input class="button" value="Update Password" type="submit">
								</p>
							</fieldset>
						</form>
					</div> <!-- End #tab3 -->					
				</div> <!-- End .content-box-content -->				
			</div> <!-- End .content-box -->

			<div class="content-box column-right">
				
				<div class="content-box-header"> <!-- Add the class "closed" to the Content box header to have it closed by default -->
					
					<h3 style="cursor: s-resize;">Update Contact Details</h3>
					
				</div> <!-- End .content-box-header -->
				
				<div style="display: block;" class="content-box-content">
					
					<div style="display: block;" class="tab-content default-tab">
					
						<form action="../../../utility/helper/User/UserActionHelper.php?action=update" method="POST">
							
							<fieldset>
							
								<p>
									<label>Office Phone</label>
									<input class="text-input medium-input" id="phone_o" name="phone_o" type="text">
								</p>
								
								<p>
									<label>Mobile</label>
										<input class="text-input medium-input" id="phone_m" name="phone_m" type="text">
								</p>
								
								<p>
									<label>Email</label>
										<input class="text-input medium-input" id="email" name="email" type="email">
								</p>
								<p>
									<input class="button" value="Update Details" type="submit">
								</p>
							</fieldset>
						</form>
						
					</div> <!-- End #tab3 -->        
					
				</div> <!-- End .content-box-content -->
</div>
<?php require_once "../../master/footerhome.php"; ?>