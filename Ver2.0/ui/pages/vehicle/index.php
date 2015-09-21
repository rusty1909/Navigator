<?php
	require_once "../../../utility/helper/Vehicle/VehicleHelper.php";

	if(!User::isLoggedIn())
		header('Location:../user/login.php');

	require_once "../../../utility/helper/Common/CommonHelper.php"; 

    $mAllVehicleList = $mUser->getVehicleList();
	$mPreviousVehicleList = $mUser->getPreviousVehicleList();
	$mDeployedVehicleList = $mUser->getDeployedVehicleList();
	$mOnJobVehicleList = $mUser->getOnJobVehicleList();
	$mFreeVehicleList = $mUser->getFreeVehicleList();
	$mWaitingVehicleList = $mUser->getWaitingVehicleList();

	require_once "../../master/headerhomehtml.php";
?>
 <script type="text/javascript" src="http://www.findgaddi.com/navigator/Ver2.0/js/vehicleindex.js"></script>
			<div class="content-box column-left" style="width:63%"><!-- Start Content Box -->
				
				<div class="content-box-header">
					
					<h3 style="cursor: s-resize;">Vehicle List</h3>
					
					<ul class="content-box-tabs">
						<li><a href="#deployed" title="List of online vehicles" class="default-tab current">Online<!--Deployed alias--> (<?php echo sizeof($mDeployedVehicleList); ?>)</a></li>
						<li><a href="#wait" title="List of devices waiting for device deployment">Waiting  (<?php echo sizeof($mWaitingVehicleList); ?>)</a></li>
					</ul>
					
					<div class="clear"></div>
					
				</div> <!-- End .content-box-header -->
				
				<div class="content-box-content">
					
					<div style="display: none;" class="tab-content" id="all"> <!-- This is the target div. id must match the href of this div's tab -->
						<?php
						$mVehicleList = $mAllVehicleList;
						if(sizeof($mVehicleList) == 0) {
						?>
						<div class="notification attention png_bg">
							<div>
								You have not registered any device yet. Please add vehicles to start using the tool.
							</div>
						</div>
						<table>
							<tfoot>
								<tr>
									<td colspan="6">
										<div class="bulk-actions align-left">
											<a class="button js-open-modal" href="#" data-modal-id="popup">Add Vehicle</a>
										</div>
										<div class="clear"></div>
									</td>
								</tr>
							</tfoot>
						</table>
						<?php } else { ?>
						
						<table>
							
							<thead>
								<tr>
								   <th></th>
								   <th>Model</th>
								   <th>Vehicle Number</th>
								   <th>Current Driver</th>
								</tr>
								
							</thead>
						 
							<tfoot>
								<tr>
									<td colspan="6">
										<div class="bulk-actions align-left">
											<a class="button js-open-modal" href="#" data-modal-id="popup">Add Vehicle</a>
										</div>
										
											<?php
											if((sizeof($mAllVehicleList)/10) > 1) {
												echo "<a href='#' title='First Page'>« First</a><a href='#' title='Previous Page'>« Previous</a>";
											
												for($i=0; $i<(sizeof($mAllVehicleList)/10);$i++) {
													$k = $i+1;
													echo "<a href='#' class='number current' title='".$k."'>".$k."</a>";
												}
												echo "<a href='#' title='Next Page'>Next »</a><a href='#' title='Last Page'>Last »</a>";
											}
											?>
										</div> -->
										<div class="clear"></div>
									</td>
								</tr>
							</tfoot>   
						 
							<tbody>

								<?php
								$mVehicleList = $mAllVehicleList;
								for($i=0; $i<sizeof($mVehicleList); $i++) {
									$mVehicle = new Vehicle($mVehicleList[$i]);
									$mJob = new Job($mVehicle->getCurrentJob());
									$mDriver = new Driver($mVehicle->getDriver());
									$vehType = $mVehicle->getType();
									if(empty($vehType))
										$vehType = 'Truck';
									echo "<tr>";
									echo "<td><img id='type' height='20' width='20' src='../../../images/vehicle_types/".$vehType.".png' title=".$vehType." alt=".$vehType." style='vertical-align:-5px;'></td>";
									
									echo "<td>".$mVehicle->getModel()."</td>";
									echo "<td><a href='detail.php?id=".$mVehicle->getId()."'>".$mVehicle->getVehicleNumber()."</a></td>";
									echo "<td>".$mDriver->getName()."</td>";
									echo "</tr>";	
								}
								?>
							</tbody>
							
						</table>
						
						<?php } ?>
						
					</div> <!-- End #all -->
					
					<div style="display: block;" class="tab-content default-tab" id="deployed"> <!-- This is the target div. id must match the href of this div's tab -->
						<?php
						$mVehicleList = $mAllVehicleList;
						if(sizeof($mVehicleList) == 0) {
						?>
						<div class="notification attention png_bg">
							<div>
								You have not registered any device yet. Please add vehicles to start using the tool.
							</div>
						</div>
						<table>
							<tfoot>
								<tr>
									<td colspan="6">
										<div class="bulk-actions align-left">
											<a class="button js-open-modal" href="#" data-modal-id="popup">Add Vehicle</a>
										</div>
										<div class="clear"></div>
									</td>
								</tr>
							</tfoot>
						</table>
						<?php } else { 
						$mVehicleList = $mDeployedVehicleList;
						if(sizeof($mVehicleList) == 0) {
						?>
						<div class="notification attention png_bg">
							<div>
								None of your vehicles are deployed with the tracking device. Please contact operator.
							</div>
						</div>
						<?php } else {?>
						
						<table>
							
							<thead>
								<tr>
								   <th></th>
								   <th>Model</th>
								   <th>Vehicle Number</th>
								   <th>Current Driver</th>
								</tr>
								
							</thead>
						 
							<tfoot>
								<tr>
									<td colspan="6">
										<div class="bulk-actions align-left">
											<a class="button" href="#">Apply to selected</a> -->
											<a class="button js-open-modal" href="#" data-modal-id="popup">Add Vehicle</a>
										</div>
										
										<!--<div class="pagination">
											<?php
											if((sizeof($mAllVehicleList)/10) > 1) {
												echo "<a href='#' title='First Page'>« First</a><a href='#' title='Previous Page'>« Previous</a>";
											
												for($i=0; $i<(sizeof($mAllVehicleList)/10);$i++) {
													$k = $i+1;
													echo "<a href='#' class='number current' title='".$k."'>".$k."</a>";
												}
												echo "<a href='#' title='Next Page'>Next »</a><a href='#' title='Last Page'>Last »</a>";
											}
											?>
										</div> -->
										<div class="clear"></div>
									</td>
								</tr>
							</tfoot> 
						 
							<tbody>
								<?php
								$mVehicleList = $mDeployedVehicleList;
								for($i=0; $i<sizeof($mVehicleList); $i++) {
									$mVehicle = new Vehicle($mVehicleList[$i]);
									$mJob = new Job($mVehicle->getCurrentJob());
									$mDriver = new Driver($mVehicle->getDriver());
									$vehType = $mVehicle->getType();
									if(empty($vehType))
										$vehType = 'Truck';
									echo "<tr>";
									echo "<td><img id='type' height='20' width='20' src='../../../images/vehicle_types/".$vehType.".png' title=".$vehType." alt=".$vehType." style='vertical-align:-5px;'></td>";
									echo "<td>".$mVehicle->getModel()."</td>";
									echo "<td><b><a style='text-transform:uppercase;' href='detail.php?id=".$mVehicle->getId()."'>".$mVehicle->getVehicleNumber()."</a></b></td>";
									if($mVehicle->getDriver() != "0"){
										echo "<td><img height='15' width='15' src='../../../images/driver_icon.png'>&nbsp;<b><a href='../driver/detail.php?id=".$mDriver->getId()."' style='text-transform:uppercase;vertical-align:2px;'>".$mDriver->getName()."</a></b></td>";
									} else{
										echo "<td></td>";
									}
									echo "</tr>";	
								}
								?>
							</tbody>
							
						</table>
						<?php } 
						}	?>
						
					</div> <!-- End #deployed -->

                    <div style="display: none;" class="tab-content" id="onjob"> <!-- This is the target div. id must match the href of this div's tab -->
						
						<?php
						$mVehicleList = $mOnJobVehicleList;
						if(sizeof($mVehicleList) == 0) {
						?>
						<div class="notification attention png_bg">
							<div>
								You don't have any device in this category.
							</div>
						</div>
						<?php } else {?>
						
						<table>
							
							<thead>
								<tr>
								   <th></th>
								   <th>Model</th>
								   <th>Vehicle Number</th>
								   <th>Action</th>
								</tr>
								
							</thead>
						 
<tfoot>
								<tr>
									<td colspan="6">
										<div class="bulk-actions align-left">
											<a class="button" href="#">Apply to selected</a> -->
											<a class="button js-open-modal" href="#" data-modal-id="popup">Add Vehicle</a>
										</div>
										
										<!--<div class="pagination">
											<?php
											//echo sizeof($mAllVehicleList)/10;
											if((sizeof($mAllVehicleList)/10) > 1) {
												echo "<a href='#' title='First Page'>« First</a><a href='#' title='Previous Page'>« Previous</a>";
											
												for($i=0; $i<(sizeof($mAllVehicleList)/10);$i++) {
													$k = $i+1;
													echo "<a href='#' class='number current' title='".$k."'>".$k."</a>";
												}
												echo "<a href='#' title='Next Page'>Next »</a><a href='#' title='Last Page'>Last »</a>";
											}
											?>
										</div> -->
										<div class="clear"></div>
									</td>
								</tr>
							</tfoot> 
						 
							<tbody>
								<?php
								$mVehicleList = $mOnJobVehicleList;
								for($i=0; $i<sizeof($mVehicleList); $i++) {
									$mVehicle = new Vehicle($mVehicleList[$i]);
									$mJob = new Job($mVehicle->getCurrentJob());
									$mDriver = new Driver($mJob->getDriver());
									$vehType = $mVehicle->getType();									
									if(empty($vehType))
										$vehType = 'Truck';
									echo "<tr>";
									echo "<td><img id='type' height='20' width='20' src='../../../images/vehicle_types/".$vehType.".png' title=".$vehType." alt=".$vehType." style='vertical-align:-5px;'></td>";
									
									echo "<td>".$mVehicle->getModel()."</td>";
									echo "<td><a href='detail.php?id=".$mVehicle->getId()."'>".$mVehicle->getVehicleNumber()."</a></td>";
									echo "</tr>";	
								}
								?>
							</tbody>
							
						</table>
						<?php } ?>
						
					</div> <!-- End #onjob -->

                    <div style="display: none;" class="tab-content" id="free"> <!-- This is the target div. id must match the href of this div's tab -->
						
						<?php
						$mVehicleList = $mFreeVehicleList;
						if(sizeof($mVehicleList) == 0) {
						?>
						<div class="notification attention png_bg">
							<div>
								You don't have any device in this category.
							</div>
						</div>
						<?php } else { ?>
						
						<table>
							
							<thead>
								<tr>
								   <th></th>
								   <th>Model</th>
								   <th>Vehicle Number</th>
								   <th>Current Job</th>
								   <th>Current Driver</th>
								   <th>Action</th>
								</tr>
								
							</thead>
						 
							<tfoot>
								<tr>
									<td colspan="6">
										<div class="bulk-actions align-left">
											<select name="dropdown">
												<option selected="selected" value="option1">Choose an action...</option>
												<option value="option2">Edit</option>
												<option value="option3">Delete</option>
											</select>
											<a class="button" href="#">Apply to selected</a>
											<a class="button js-open-modal" href="#" data-modal-id="popup">Add Vehicle</a>
										</div>
										
										<div class="pagination">
											<a href="#" title="First Page">« First</a><a href="#" title="Previous Page">« Previous</a>
											<a href="#" class="number" title="1">1</a>
											<a href="#" class="number" title="2">2</a>
											<a href="#" class="number current" title="3">3</a>
											<a href="#" class="number" title="4">4</a>
											<a href="#" title="Next Page">Next »</a><a href="#" title="Last Page">Last »</a>
										</div> <!-- End .pagination -->
										<div class="clear"></div>
									</td>
								</tr>
							</tfoot>
						 
							<tbody>
								<?php
								$mVehicleList = $mFreeVehicleList;
								for($i=0; $i<sizeof($mVehicleList); $i++) {
									$mVehicle = new Vehicle($mVehicleList[$i]);
									$mJob = new Job($mVehicle->getCurrentJob());
									$mDriver = new Driver($mJob->getDriver());
									$vehType = $mVehicle->getType();
									if(empty($vehType))
										$vehType = 'Truck';
									echo "<tr>";
									echo "<td><img id='type' height='20' width='20' src='../../../images/vehicle_types/".$vehType.".png' title=".$vehType." alt=".$vehType." style='vertical-align:-5px;'></td>";
									
									echo "<td>".$mVehicle->getModel()."</td>";
									echo "<td><a href='detail.php?id=".$mVehicle->getId()."'>".$mVehicle->getVehicleNumber()."</a></td>";
									echo "<td>".$mJob->getCode()."</td>";
									echo "<td>".$mDriver->getName()."</td>";
									echo "									<td>
										<!-- Icons -->
										 <a href='#' title='Edit'><img src='../../../images/pencil.png' alt='Edit'></a>
										 <a href='#' title='Delete' onClick='onDelete(".$mVehicle->getId().")'><img src='../../../images/cross.png' alt='Delete'></a>&nbsp;&nbsp;
										 <a href='#' title='Edit Meta'><img src='../../../images/hammer_screwdriver.png' alt='Edit Meta'></a>
									</td>";
									echo "</tr>";	
								}
								?>
							</tbody>
							
						</table>
						<?php } ?>
						
					</div> <!-- End #free -->

                    <div style="display: none;" class="tab-content" id="prev"> <!-- This is the target div. id must match the href of this div's tab -->
						
						<?php
						$mVehicleList = $mPreviousVehicleList;
						if(sizeof($mVehicleList) == 0) {
						?>
						<div class="notification attention png_bg">
							<div>
								You don't have any device in this category.
							</div>
						</div>
						<?php } else {?>
						
						<table>
							
							<thead>
								<tr>
								   <th></th>
								   <th>Model</th>
								   <th>Vehicle Number</th>
								   <th>Current Job</th>
								   <th>Current Driver</th>
								   <th>Action</th>
								</tr>
								
							</thead>
						 
							<tfoot>
								<tr>
									<td colspan="6">
										<div class="bulk-actions align-left">
											<select name="dropdown">
												<option selected="selected" value="option1">Choose an action...</option>
												<option value="option2">Edit</option>
												<option value="option3">Delete</option>
											</select>
											<a class="button" href="#">Apply to selected</a>
											<a class="button js-open-modal" href="#" data-modal-id="popup">Add Vehicle</a>
										</div>
										
										<div class="pagination">
											<a href="#" title="First Page">« First</a><a href="#" title="Previous Page">« Previous</a>
											<a href="#" class="number" title="1">1</a>
											<a href="#" class="number" title="2">2</a>
											<a href="#" class="number current" title="3">3</a>
											<a href="#" class="number" title="4">4</a>
											<a href="#" title="Next Page">Next »</a><a href="#" title="Last Page">Last »</a>
										</div> <!-- End .pagination -->
										<div class="clear"></div>
									</td>
								</tr>
							</tfoot>
						 
							<tbody>
								<?php
								$mVehicleList = $mPreviousVehicleList;
								for($i=0; $i<sizeof($mVehicleList); $i++) {
									$mVehicle = new Vehicle($mVehicleList[$i]);
									$mJob = new Job($mVehicle->getCurrentJob());
									$mDriver = new Driver($mJob->getDriver());
									$vehType = $mVehicle->getType();
									if(empty($vehType))
										$vehType = 'Truck';
									echo "<tr>";
									echo "<td><img id='type' height='20' width='20' src='../../../images/vehicle_types/".$vehType.".png' title=".$vehType." alt=".$vehType." style='vertical-align:-5px;'></td>";
									
									echo "<td>".$mVehicle->getModel()."</td>";
									echo "<td><a href='detail.php?id=".$mVehicle->getId()."'>".$mVehicle->getVehicleNumber()."</a></td>";
									echo "<td>".$mJob->getCode()."</td>";
									echo "<td>".$mDriver->getName()."</td>";
									echo "									<td>
										<!-- Icons -->
										 <a href='#' title='Edit'><img src='../../../images/pencil.png' alt='Edit'></a>
										 <a href='#' title='Delete' onClick='onDelete(".$mVehicle->getId().")'><img src='../../../images/cross.png' alt='Delete'></a>&nbsp;&nbsp;
										 <a href='#' title='Edit Meta'><img src='../../../images/hammer_screwdriver.png' alt='Edit Meta'></a>
									</td>";
									echo "</tr>";	
								}
								?>
							</tbody>
							
						</table>
						<?php } ?>
					</div> <!-- End #prev -->

                    <div style="display: none;" class="tab-content" id="wait"> <!-- This is the target div. id must match the href of this div's tab -->
						
						<?php
						$mVehicleList = $mAllVehicleList;
						if(sizeof($mVehicleList) == 0) {
						?>
						<div class="notification attention png_bg">
							<div>
								You have not registered any device yet. Please add vehicles to start using the tool.
							</div>
						</div>
						<table>
							<tfoot>
								<tr>
									<td colspan="6">
										<div class="bulk-actions align-left">
											<a class="button js-open-modal" href="#" data-modal-id="popup">Add Vehicle</a>
										</div>
										<div class="clear"></div>
									</td>
								</tr>
							</tfoot>
						</table>
						<?php } else { 
						$mVehicleList = $mWaitingVehicleList;
						if(sizeof($mVehicleList) == 0) {
						?>
						<div class="notification attention png_bg">
							<div>
								All your registered vehicles are already deployed with the tracking device.
							</div>
						</div>
						<?php } else {?>
						
						<table>
							
							<thead>
								<tr>
								   <th></th>
								   <th>Model</th>
								   <th>Vehicle Number</th>
								   <th>Action</th>
								</tr>
								
							</thead>
						 
							<tfoot>
								<tr>
									<td colspan="6">
										<div class="bulk-actions align-left">
											<a class="button js-open-modal" href="#" data-modal-id="popup">Add Vehicle</a>
										</div>
										
										<!--<div class="pagination">
											<?php
											//echo sizeof($mAllVehicleList)/10;
											if((sizeof($mAllVehicleList)/10) > 1) {
												echo "<a href='#' title='First Page'> First</a><a href='#' title='Previous Page'> Previous</a>";
											
												for($i=0; $i<(sizeof($mAllVehicleList)/10);$i++) {
													$k = $i+1;
													echo "<a href='#' class='number current' title='".$k."'>".$k."</a>";
												}
												echo "<a href='#' title='Next Page'>Next </a><a href='#' title='Last Page'>Last </a>";
											}
											?>
										</div> -->
										<div class="clear"></div>
									</td>
								</tr>
							</tfoot> 
						 
							<tbody>
								<?php
								$mVehicleList = $mWaitingVehicleList;
								for($i=0; $i<sizeof($mVehicleList); $i++) {
									$mVehicle = new Vehicle($mVehicleList[$i]);
									$mJob = new Job($mVehicle->getCurrentJob());
									$mDriver = new Driver($mJob->getDriver());
									$vehType = $mVehicle->getType();
									if(empty($vehType))
										$vehType = 'Truck';
									echo "<tr>";
									echo "<td><img id='type' height='20' width='20' src='../../../images/vehicle_types/".$vehType.".png' title=".$vehType." alt=".$vehType." style='vertical-align:-5px;'></td>";
									
									echo "<td>".$mVehicle->getModel()."</td>";
									echo "<td><a href='detail.php?id=".$mVehicle->getId()."'>".$mVehicle->getVehicleNumber()."</a></td>";
									echo "<td>
										<!-- Icons -->
										 <a href='#' title='Delete' onClick='onDelete(".$mVehicle->getId().")'><img src='../../../images/cross.png' alt='Delete'></a>
									</td>";
									echo "</tr>";	
								}
								?>
							</tbody>
							
						</table>
						<?php } 
						}	?>
					</div> <!-- End #wait -->


					
				</div> <!-- End .content-box-content -->
	
			</div> <!-- End .content-box -->
			
			<div class="content-box column-right" style="width:35%;height:100%;">
				<div class="content-box-header"> <!-- Add the class "closed" to the Content box header to have it closed by default -->
					<h3 style="cursor: s-resize;">Notifications</h3>
				</div> <!-- End .content-box-header -->
				
				<div style="display: block;padding:0px;height:93%;overflow-y:auto" class="content-box-content">
					
					<div style="display:block;overflow-y:auto" class="tab-content default-tab" id="item-list">
					
						<table id="noti_table">
						<thead>
						<tr></tr>
						</thead>
						<tbody style="border-bottom:0px" id="noti_body">
						<tr><td><b>Loading Notifications</b></td></tr>
						</tbody>
						</table>
					</div> <!-- End #tab3 -->  
				</div> <!-- End .content-box-content -->
				
			</div>

	<div id="popup" class="modal-box" style="width:50%;">  
	  <header>
		<h3>Add Vehicle</h3>
	  </header>
	  <div class="modal-body" id="item-list">
	  

				
<!-------------------------------------------------------------------------------------------------------------------------->
						<form action="../../../utility/helper/Vehicle/VehicleActionHelper.php?action=add" method="POST">
							
							<fieldset> <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->
							
								<p>
									<label>Vehicle Type</label>
									<input name="type" value="Truck" type="radio" id="type"> <img id="type" height="25" width="25" src="../../../images/vehicle_types/Truck.png" title="Truck" alt="Truck" style='vertical-align:-5px;'> &nbsp;&nbsp;
									<input name="type" value="Car" type="radio"><img id="type" height="25" width="25" src="../../../images/vehicle_types/Car.png" title="Car" alt="Car" style='vertical-align:-5px;'> &nbsp;&nbsp;
									<input name="type" value="Bus" type="radio"><img id="type" height="25" width="25" src="../../../images/vehicle_types/Bus.png" title="Bus" alt="Bus" style='vertical-align:-5px;'> &nbsp;&nbsp;
								</p>
								
								<p class="column-left">
									<label>Vehicle Model</label>
										<input class="text-input medium-input" id="model" name="model" type="text" required placeholder='Honda City'> <!--<span class="input-notification success png_bg">Successful message</span>  Classes for input-notification: success, error, information, attention 
										<br><small>A small description of the field</small>-->
								</p>
								
								<p class="column-right">
									<label>Make Year</label>
										<input class="text-input medium-input" name="make_year" id="make_year" type="number" min="1400" max="2015" placeholder='2012'> <!--<span class="input-notification success png_bg">Successful message</span>  Classes for input-notification: success, error, information, attention 
										<br><small>A small description of the field</small>-->
								</p>

								<p>
									<label>Vehicle Number</label>
										<input class="text-input small-input" name="vehicle_number" id="vehicle_number" type="text" required placeholder='DL 12 UB 1234' > <span class="input-notification error png_bg" id="number_error"></span><span class="input-notification success png_bg" id="number_success"></span>
								</p>
								
								<p>
									<label>Description</label>
									<input class="text-input large-input" name="description" id="description" type="text" required placeholder='Honda City 12 years old good condition'>
									<br><small>A small description of the vehicle which will help in identifying the vehicle with ease.</small>
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