<?php
     require_once "../../../utility/helper/Driver/DriverHelper.php"; 
	 require_once "../../../utility/helper/Common/CommonHelper.php"; 
    if(!User::isLoggedIn())
	       header('Location: ../user/login.php');

	if(!isset($_GET['id'])) {
		header("Location:index.php");
		return;
	} 
	$mId = $_GET['id'];
	
	$mDriver = new Driver($mId);
	$mVehicle = new Vehicle($mDriver->getCurrentVehicle());
	
    require_once "../../master/headerhomehtml.php";
?>
<script type="text/javascript" src="http://www.findgaddi.com/navigator/Ver2.0/js/driverdetails.js"></script>
<script>
    var id = <?php echo $mId?>;
    $(document).ready(setId(id));
</script>

			<div class="content-box column-left" style="width:63%;max-height:88%">				
				<div class="content-box-header">
					
					<h3 style="cursor: s-resize;"><?php echo $mDriver->getName(); ?></h3>
					
					<ul class="content-box-tabs">
						<li><a href="#info" <?php if(!isset($_GET['page'])) echo "class='default-tab current'" ?>>Basic Information</a></li> <!-- href must be unique and match the id of target div -->
						<li><a href="#previous_jobs">Previous Jobs</a></li>
						<li><a href="#payment">Payments</a></li>						
						
					</ul>
					
					<div class="clear"></div>
					
				</div>
				<div class="content-box-content">
					<div style="display: block;" class="tab-content <?php if(!isset($_GET['page'])) echo " default-tab" ?>" id="info">
						<div id="basic">
							<form action="edit.php"><fieldset>
								<p class="column-left">
									<a class="button" class='js-open-modal' href='#' data-modal-id='edit-popup' >Edit Info</a>
									<br><br>
									<img id="address_icon" height="20" width="20" src="../../../images/address.png" title="Address" alt="Address">&nbsp;
									<b><span id="address_view" style='vertical-align:2px;'>
										<?php 
										echo $mDriver->getAddress();
										?>
										</span></b>
									<br><br>
									<img id="contact_icon" height="20" width="20" src="../../../images/phone_icon.png" title="Phone" alt="Phone">&nbsp;
									<b><span id="address_view" style='vertical-align:2px;'>
										<?php 
										echo $mDriver->getPhone();
										?>
										</span></b>
									<br><br>
									<img id="joining_date_icon" height="20" width="20" src="../../../images/calendar.png" title="Joining Date" alt="Joining Date">&nbsp;
									<b><span id="address_view" style='vertical-align:2px;'>
										<?php 
										echo $mDriver->getJoiningDate();
										?>
										</span></b>
								</p>

								
								<p class="column-right">

								</p>
								
								
							</fieldset></form>
						</div>
						
					</div>
					                    
                   <div style="display: block;" class="tab-content" id="previous_jobs">	
                       
						
					</div> <!-- End #prev -->
                
                
                    
                    <div style="display: block;" class="tab-content" id="payment">					
						<p>
                        
                        Make Payments and keep using the findgaddi services.
                        </p>
					</div> <!-- End #tab3 -->
				</div> <!-- End .content-box-content -->				
			</div> <!-- End .content-box -->
			<div style="float:right;width:35%;height:88%;">
				<div class="content-box column-right" style="width:100%;height:30%;">
					<div class="content-box-header"> <!-- Add the class "closed" to the Content box header to have it closed by default -->
						<h3 style="cursor: s-resize;">Current Location</h3>
					</div> <!-- End .content-box-header -->
					
					<div style="display: block;padding:10px;" class="content-box-content">
						<div id="vehicle_info">
							<?php
								//$mVehicle1 = new Vehicle($mId);
								//echo $mVehicle->getCurrentDriver();
								if($mDriver->getCurrentVehicle() == 0){
							?>									
							<b><img id="driver_icon" height="20" width="20" src="../../../images/vehicle_types/Truck.png" title="Vehicle" alt="Vehicle">&nbsp; <span style='vertical-align:5px;'>Click</span> <a class="js-open-modal" href="#" data-modal-id="popup" style="font-size:11px" ><img id="add" height="15" width="15" src="../../../images/add.png" title="Add Driver" alt="Add Driver"></a> <span style='vertical-align:5px;'>to assign vehicle</span></b>
							<?php 
								} else{
									echo "<img id='driver_icon' height='20' width='20' src='../../../images/vehicle_types/".$mVehicle->getType()."' title='".$mVehicle->getType()."' alt='".$mVehicle->getType()."'>&nbsp; <span style='vertical-align:5px;'><b><a href='../vehicle/detail.php?id=".$mVehicle->getId()."'>".$mVehicle->getVehicleNumber()."</a></b></span>";
							?>				
							&nbsp;&nbsp;&nbsp; 
							<?php    } ?>
						</div>
						<br>
						<?php 
							if($mDriver->getCurrentVehicle() != 0){
						?>
						<div id="location_info">
							<img id="location_icon" height="15" width="15" src="../../../images/location_icon.png" title="Location" alt="Location">&nbsp;
							<b><span id="location_view" style='vertical-align:2px;'>
								Locating...
								</span><br></b>									
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size:9px;vertical-align:2px;">Last updated <b id='last_updated'> -- -- -- </b></span>
								
						</div>	
						<?php } ?>
					</div> <!-- End .content-box-content -->
					
				</div>
				<div class="clear"></div>
				<div class="content-box column-right" style="width:100%;height:66%;">
					<div class="content-box-header"> <!-- Add the class "closed" to the Content box header to have it closed by default -->
						<h3 style="cursor: s-resize;">Events of the day (<span id='noti_count'></span>)</h3>
					</div> <!-- End .content-box-header -->
					
					<div style="display: block;padding:0px;height:93%;overflow-y:auto" class="content-box-content">
						
						<div style="display:block;overflow-y:auto" class="tab-content default-tab" id="item-list">
						
							<div style="display:block;" class="tab-content default-tab" id="item-list">
								
									<table id="noti_table">
									<thead>
									<tr></tr>
									</thead>
									<tbody style="border-bottom:0px" id="noti_body">
									<tr><td><b>Loading Notifications</b></td></tr>
									</tbody>
									</table>
								</div> <!-- End #tab3 -->  
						</div> <!-- End #tab3 -->  
					</div> <!-- End .content-box-content -->
					
				</div>
			</div>
            <!-- //////////////// POP UP Box for adding employee-->
    <div id="edit-popup" class="modal-box" style="width:50%;">  
				<header>
			<h3><?php echo $mDriver->getName(); ?></h3>
		</header>
		<div class="modal-body" id="item-list">
			<form action="../../../utility/helper/Driver/DriverActionHelper.php?action=update" method="POST">
				<input hidden type="text" value="<?php echo $mDriver->getId(); ?>" name="id">
				<fieldset> <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->
												
					<p class="column-left">
						<label>Name</label>
							<input class="text-input medium-input" id="name" name="name" disabled value="<?php echo $mDriver->getName(); ?>" type="text" required placeholder='Rudra XYZ'> 
					</p>
					
					<p class="column-right">
						<label>Phone</label>
							<b>+91- </b><input class="text-input medium-input" name="phone" value="<?php echo $mDriver->getPhone(); ?>" id="phone" type="text" maxlength="10" required placeholder='0123456789' min='1000000000' max='9999999999'> 
					</p>

					<p>
						<label>Address</label>
							<textarea name="address" id="address" required placeholder="House #12 , mayur vihar , new delhi"><?php echo $mDriver->getAddress(); ?></textarea>
					</p>

					<p>
						<label>Description</label>
						<input class="text-input large-input" name="description" id="description" value="<?php echo $mDriver->getDescription(); ?>" type="text" required placeholder="I was working in this company or having much experience.">
						<br><small>A small description of the driver which will help in identifying the driver with ease.</small>
					</p>
				
					<p class="column-left">
						<label>Joining Date</label>
							<input class="text-input medium-input" id="date_join" disabled value="<?php echo $mDriver->getJoiningDate(); ?>" name="date_join" type="text" required> 
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