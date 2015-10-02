<?php

if(!empty($_POST)){
    
require_once '../../../framework/User.php';
    
    if(empty($_POST['id']))
        $id = $_GET['id'];
    else
        $id = $_POST['id'];
    
   // die($id);
    $password = $_POST['password'];
    
    $_SESSION['user']['id'] = $id;
    
    $mUser = new User();
    
    if($mUser->resetPassword($password))    
        header('Location:login.php');
    
    exit();
}

if(isset($_GET['id']) && isset($_GET['key'])) {
	$id = $_GET['id'];
    $key = $_GET['key'];
} else {
	header('location : login.php');
    exit();
}

$pswdrstlink = "resetPassword.php?id=".$id;

require_once "../../../utility/helper/Common/CommonHelper.php"; 
require_once "../../master/headerhomehtml.php";
?>
    <script>
    function checkPassword() {
			var pass = document.getElementById("password").value;
			var retype = document.getElementById("retype").value;
			if(pass!=retype){
				document.getElementById("retype").value = "";
				document.getElementById("pass_success").innerHTML = "";
				document.getElementById("pass_error").innerHTML = "<b>Passwords do not match !</b>";			
			} else {
				document.getElementById("pass_error").innerHTML = "";
				document.getElementById("pass_success").innerHTML = "<b>We have a match ! !</b>";
			}
		}

    </script>
				
				<div class="content-box-content-no-border">
					
					<div style="display: block;" class="tab-content default-tab" id="tab2">
					
						<form action="<?php echo $pswdrstlink ?>" method="POST">
							
							<fieldset> <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->
							
                                <input type="hidden" name="id" value="<?php echo $id ?>" />
    
                                <p class="column-left">
									<label>Password <span class="mandatory">*</span></label>
									<input class="text-input medium-input" id="password" name="password" type="password" style="width:95% !important" required> <!--<span class="input-notification success png_bg">Successful message</span> 
										<br><small>A small description of the field</small>-->
								</p>
								
								<p class="column-right" style="margin: 0 -10px 0 0;" >
									<label>Re-Type Password <span class="mandatory">*</span></label>
									<input class="text-input medium-input" id="retype" name="retype" type="password"  style="width:95% !important" onBlur="checkPassword()" required><br><span class="input-notification error png_bg" id="pass_error"></span><span class="input-notification success png_bg" id="pass_success"></span>
								</p>

								<p id="notify">
									<input class="button" value="Reset Password" type="submit">
								</p>
								
							</fieldset>
							
							<div class="clear"></div><!-- End .clear -->
							
						</form>
						
					</div> <!-- End #tab2 -->        
					
				</div> <!-- End .content-box-content -->
				
			<?php require_once "../../master/footerhome.php"; ?>