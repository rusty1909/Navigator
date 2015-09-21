<?php
require_once "../../../utility/helper/Common/CommonHelper.php"; 
require_once "../../master/headerhomehtml.php";
	
?>
<script>
function validate(){
    alert("ertyuio");
    var oldp = document.getElementById("old").value;
    var newp = document.getElementById("new").value;
    var re = document.getElementById("retype").value;

    if(re!=newp) {
        alert("Passwords do not match!!!");
        return false;
    } else {			
        if(oldp=="" || newp=="" || re=="") {
            alert("Please fill all mandatory details");
            return false;
        } else {
            return true;
        }
    }
}
</script>
				<div class="content-box-header">
					
					<h3 style="cursor: s-resize;"><?php echo $mUser->getFullName(); ?></h3>
					
					<ul class="content-box-tabs">
						<li><a href="#profile" class="default-tab current">My Profile</a></li> 
						<li><a href="#update_contact" >Update Contact </a></li>
						<li><a href="#update_password" >Update Password</a></li>
					</ul>
					
					<div class="clear"></div>
					
				</div> <!-- End .content-box-header -->
				
				<div class="content-box-content">
					
					<div style="display: none;" class="tab-content default-tab" id="profile"> 
							<form action="edit.php"><fieldset>
								<p class="column-left">
									<input class="button" value="   Edit   " type="submit" id="edit_button">
									<br><br>
									<b>Username</b><br>
									<?php echo $mUser->getUsername(); ?>
									<br><br>
									<b>Company</b><br>
									<?php 
										$mCompanyId = $mUser->getCompany();
										$mCompany = new Company($mCompanyId);
									?>
									<a href="../company/"><?php echo $mCompany->getName(); ?></a>
									
								</p>
								
								<p class="column-right">
									<br><br>
									<b>Contact Details</b><br>
									<b>Mobile : </b><?php if($mUser->getPhoneMobile() != 0) echo $mUser->getPhoneMobile(); ?><br>
									<b>Office Phone : </b><?php if($mUser->getPhoneOffice() != 0) echo $mUser->getPhoneOffice(); ?><br>
									<b>Email : </b><a target="_mail" href='mailto:<?php echo $mUser->getEmail(); ?>'><?php echo $mUser->getEmail(); ?></a><br>
								</p>
								
								
							</fieldset></form>					
					</div> <!-- End #all -->
					
					<div style="display: block;" class="tab-content" id="update_contact"> 
						<div style="display: block;" class="content-box-content-no-border">
							
							<div style="display: block;" class="tab-content default-tab">
							
								<form action="../../../utility/helper/Settings/SettingsActionHelper.php?action=update_contact" method="POST">
									
									<fieldset>
									
										<p>
											<label>Office Phone</label>
											<input class="text-input small-input" id="phone_o" name="phone_o" type="text" value=<?php echo $mUser->getPhoneOffice(); ?>>
										</p>
										
										<p>
											<label>Mobile</label>
												<input class="text-input small-input" id="phone_m" name="phone_m" type="text" value=<?php echo $mUser->getPhoneMobile(); ?>>
										</p>
										
										<p>
											<label>Email</label>
												<input class="text-input small-input" id="email" name="email" type="email" value=<?php echo $mUser->getEmail(); ?>>
										</p>
										<p>
											<input class="button" value="Update Details" type="submit">
										</p>
									</fieldset>
								</form>
								
							</div> <!-- End #tab3 -->        
							
						</div> <!-- End .content-box-content -->
						
					</div> <!-- End #deployed -->

                    <div style="display: none;" class="tab-content" id="update_password"> <!-- This is the target div. id must match the href of this div's tab -->			
						<div class="content-box-content-no-border">					
							<div style="display: block;" class="tab-content default-tab">					
								<form action="../../../utility/helper/Settings/SettingsActionHelper.php?action=change" method="POST" onSubmit="return validate()">
									
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
												<input class="text-input medium-input" id="retype" name="retype" type="password"> <!--<span id="notify" class="input-notification error png_bg">Passwords do not match.</span>-->
										</p>
										<p>
											<input class="button" value="Update Password" type="submit">
										</p>
									</fieldset>
								</form>
							</div> <!-- End #tab3 -->					
						</div> <!-- End .content-box-content -->
						
					</div> <!-- End #onjob -->

			
				</div> <!-- End .content-box-content -->

	<?php require_once "../../master/footerhome.php"; ?>