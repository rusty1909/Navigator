<?php require_once "../../master/headerhomephp.php"; ?>
<?php require_once "../../master/headerhomehtml.php"; ?>
		<div id="login-wrapper" class="png_bg">
			
			<div id="login-content">
				<form action="action.php?action=login" method="POST">
                    <p>
						<label>Username</label>
						<input class="text-input" type="text"  name="username" id="username">
					</p>
					<div class="clear"></div>
					<p>
						<label>Password</label>
						<input class="text-input" type="password"  name="password" id="password">
					</p>
					<div class="clear"></div>
					<p id="remember-password">
						<input type="checkbox" name='rememberme' id='rememberme' value="yes" checked="checked">Remember me
					</p>
					<div class="clear"></div>
					<p>
						<input class="button" value="Sign In" type="submit">
					</p>
					<div class="clear"></div>
					<p>
						<a href="register.php" style="float:right;"> New User Register Here </a>
					</p>
					<div class="clear"></div>
					<p>
						<a href="forgetpassword.php" style="float:right;"  class="js-open-modal" href="#" data-modal-id="resetpswdpopup"> Forget Password? </a>
					</p>
					
				</form>
			</div> <!-- End #login-content -->
			
		</div> <!-- End #login-wrapper -->
		
  <div id="resetpswdpopup" class="modal-box" style="width:50%;">  
	  <header>
		<h3>Reset Your Password</h3>
	  </header>
	  <div class="modal-body" id="item-list">		
<!-------------------------------------------------------------------------------------------------------------------------->
						<form action="action.php?action=resetpassword" method="POST">
							
							<fieldset> <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->
								<p>
									<label>Email ID</label>
										<input class="text-input small-input" name="email_id" id="email_id" type="email" required placeholder='xyz@abc.com'> <span class="input-notification error png_bg" id="number_error"></span><span class="input-notification success png_bg" id="number_success"></span>
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