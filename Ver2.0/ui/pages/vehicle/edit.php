<?php
require_once "../../../utility/helper/Vehicle/VehicleHelper.php";

if(!User::isLoggedIn())
	 header('Location:../user/login.php');
	   
require_once "../../../utility/helper/Common/CommonHelper.php"; 
require_once "../../master/headerhomehtml.php";
?>
				<div class="content-box-header">
					
					<h3 style="cursor: s-resize;">Add Vehicle</h3>
									
				<div class="clear"></div>
					
				</div> <!-- End .content-box-header -->
				
				<div class="content-box-content">
					<div style="display: block;" class="tab-content default-tab" id="add">
					
						<form action="../../../utility/helper/Vehicle/VehicleActionHelper.php?action=add" method="POST">
							
							<fieldset> <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->
							
								<p>
									<label>Vehicle Type</label>
									<input name="type" value="Truck" type="radio" id="type"> Truck &nbsp;&nbsp;
									<input name="type" value="Mini-Truck" type="radio"> Mini-Truck &nbsp;&nbsp;
									<input name="type" value="Bus" type="radio"> Bus &nbsp;&nbsp;
								</p>
								
								<p class="column-left">
									<label>Vehicle Model</label>
										<input class="text-input medium-input" id="model" name="model" type="text"> <!--<span class="input-notification success png_bg">Successful message</span>  Classes for input-notification: success, error, information, attention 
										<br><small>A small description of the field</small>-->
								</p>
								
								<p class="column-right">
									<label>Make Year</label>
										<input class="text-input medium-input" name="make_year" id="make_year" type="text"> <!--<span class="input-notification success png_bg">Successful message</span>  Classes for input-notification: success, error, information, attention 
										<br><small>A small description of the field</small>-->
								</p>

								<p>
									<label>Vehicle Number</label>
										<input class="text-input small-input" name="vehicle_number" id="vehicle_number" type="text"> <span id="notify" class="input-notification error png_bg">Vehicle Number already registered</span>  <!--Classes for input-notification: success, error, information, attention 
										<br><small>A small description of the field</small>-->
								</p>
								
								<p>
									<label>Description</label>
									<input class="text-input large-input" name="description" id="description" type="text">
									<br><small>A small description of the vehicle which will help in identifying the vehicle with ease.</small>
								</p>
								
								<p>
									<input class="button" value="Submit" type="submit">
								</p>
								
							</fieldset>
							
							<div class="clear"></div><!-- End .clear -->
							
						</form>
						
					</div> <!-- End #tab2 -->        
					
				</div> <!-- End .content-box-content -->
				
<?php require_once "../../master/footerhome.php"; ?>