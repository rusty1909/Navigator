<?php require_once "../../master/headerhomehtml.php"; ?>
			
		<!-- Page Head -->
		<p id="page-intro">Please fill the below detail to reset your password.</p>
			
			<div class="content-box-content-no-border">
				
				<div style="display: block;" class="tab-content default-tab" id="tab2">
				
					<form action="" method="POST" onSubmit="return notify()">
						
						<fieldset> <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->
						
							<p>
								<label>Email <span class="mandatory">*</span></label>
								<input class="text-input medium-input" id="email" name="email" type="email" style="width:45.5% !important">
							</p>

							<p id="notify">
								<input class="button" value="Reset Password" type="button" onClick='notify()'>
							</p>
							
						</fieldset>
						<div class="clear"></div><!-- End .clear -->
					</form>
				</div> <!-- End #tab2 -->        
				
			</div> <!-- End .content-box-content -->
			
		<?php require_once "../../master/footerhome.php"; ?>