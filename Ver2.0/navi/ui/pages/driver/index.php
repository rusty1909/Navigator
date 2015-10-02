<?php
    require_once "../../../utility/helper/Driver/DriverHelper.php"; 
	
    if(!User::isLoggedIn())
	       header('Location: ../user/login.php');

    require_once "../../../utility/helper/Common/CommonHelper.php"; 
	
    $mCurrentDriverList = $mUser->getCurrentDriverList();
	$mPreviousDriverList = $mUser->getPreviousDriverList();
	require_once "../../master/headerhomehtml.php";
?>
<script type="text/javascript" src="http://www.findgaddi.com/navigator/Ver2.0/js/driverindex.js"></script>
			
			<div class="content-box column-left" style="width:63%"><!-- Start Content Box -->
				
				<div class="content-box-header">
					
					<h3 style="cursor: s-resize;">Driver List</h3>
					
					<ul class="content-box-tabs">
						<li><a href="#current" title="List of all drivers registered" class="default-tab current">Current Drivers (<?php echo sizeof($mCurrentDriverList); ?>)</a></li> <!-- href must be unique and match the id of target div -->
						<li><a href="#prev">Previous Drivers (<?php echo sizeof($mPreviousDriverList); ?>)</a></li>
					</ul>
					
					<div class="clear"></div>
					
				</div> <!-- End .content-box-header -->
				
				<div class="content-box-content">
					
					<div style="display: none;" class="tab-content default-tab" id="current"> <!-- This is the target div. id must match the href of this div's tab -->
						<?php
						$mDriverList = $mCurrentDriverList;
						if(sizeof($mDriverList) == 0) {
						?>
						<div class="notification attention png_bg">
							<div>
								You have not added any driver yet. Please add drivers to start using the tool.
							</div>
						</div>
						<table>
							<tfoot>
								<tr>
									<td colspan="6">
										<div class="bulk-actions align-left">
											<a class="button" class='js-open-modal' href='#' data-modal-id='edit-popup' >Add Driver</a>
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
								   <th>Driver Name</th>
								   <th>Driver Phone</th>
								   <th>Current Vehicle</th>
								</tr>
								
							</thead>
						 
							<tfoot>
								<tr>
									<td colspan="6">
										<div class="bulk-actions align-left">
											<a class="button" class='js-open-modal' href='#' data-modal-id='edit-popup' >Add Driver</a>
										</div>
										
										<div class="pagination">
											<?php
											//echo sizeof($mAllDriverList)/10;
											if((sizeof($mDriverList)/10) > 1) {
												echo "<a href='#' title='First Page'>« First</a><a href='#' title='Previous Page'>« Previous</a>";
											
												for($i=0; $i<(sizeof($mDriverList)/10);$i++) {
													$k = $i+1;
													echo "<a href='#' class='number current' title='".$k."'>".$k."</a>";
												}
												echo "<a href='#' title='Next Page'>Next »</a><a href='#' title='Last Page'>Last »</a>";
											}
											?>
										</div> <!-- End .pagination -->
										<div class="clear"></div>
									</td>
								</tr>
							</tfoot>
						 
							<tbody>
								<?php
								//$mDriverList = $mAllDriverList;
								for($i=0; $i<sizeof($mDriverList); $i++) {
									$mDriver = new Driver($mDriverList[$i]);
									$mJob = new Job($mDriver->getCurrentJob());
									$mVehicle = new Vehicle($mDriver->getCurrentVehicle());
									echo "<tr>";
									echo "<td><img height='15' width='15' src='../../../images/driver_icon.png'>&nbsp;&nbsp;<b><a href='detail.php?id=".$mDriver->getId()."' style='text-transform:uppercase;vertical-align:2px;'>".$mDriver->getName()."</a></b></td>";
									echo "<td><b><img height='20' width='20' src='../../../images/phone_icon.png'><span style='vertical-align:5px;'>+91-".$mDriver->getPhone()."</span></b></td>";
									if($mVehicle->getId() != ""){
										echo "<td><b><img height='15' width='15' src='../../../images/vehicle_types/".$mVehicle->getType().".png'>&nbsp;<a style='text-transform:uppercase;vertical-align:2px;' href='../vehicle/detail.php?id=".$mVehicle->getId()."'>".$mVehicle->getVehicleNumber()."</a></b></td>";
									} else {
										echo "<td></td>";
									}
									echo "</tr>";	
								}
								?>
							</tbody>
							
						</table>
						
						<?php } ?>
						
					</div> <!-- End #all -->
					
					<div style="display: none;" class="tab-content" id="prev"> <!-- This is the target div. id must match the href of this div's tab -->
						
						<?php
						$mDriverList = $mPreviousDriverList;
						if(sizeof($mDriverList) == 0) {
						?>
						<div class="notification attention png_bg">
							<div>
								You don't have any driver in this category.
							</div>
						</div>
						<?php } else {?>
						
						<table>
							
							<thead>
								<tr>
								   <th>Driver Name</th>
								   <th>Driver Phone</th>
								   <th>Address</th>
								   <th>Action</th>
								</tr>
								
							</thead>
						 
							<tfoot>
								<tr>
									<td colspan="6">
										<div class="bulk-actions align-left">
                                            <a class="button" class='js-open-modal' href='#' data-modal-id='edit-popup' >Add Driver</a>
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
								$mDriverList = $mPreviousDriverList;
								for($i=0; $i<sizeof($mDriverList); $i++) {
									$mDriver = new Driver($mDriverList[$i]);
									$mJob = new Job($mDriver->getCurrentJob());
									$mVehicle = new Vehicle($mDriver->getCurrentVehicle());
									echo "<tr>";
									echo "<td><img height='15' width='15' src='../../../images/driver_icon.png'>&nbsp;&nbsp;<b><a href='detail.php?id=".$mDriver->getId()."' style='text-transform:uppercase;' >".$mDriver->getName()."</a></b></td>";
									echo "<td>".$mDriver->getPhone()."</td>";
									echo "<td>".$mDriver->getAddress()."</td>";
									echo "									<td>
										<!-- Icons -->
										 <a href='#' title='Edit'><img src='../../../images/pencil.png' alt='Edit'></a>
										 <a href='#' title='Delete' onClick='onDelete(".$mDriver->getId().")'><img src='../../../images/cross.png' alt='Delete'></a>&nbsp;&nbsp;
										 <a href='#' title='Edit Meta'><img src='../../../images/hammer_screwdriver.png' alt='Edit Meta'></a>
									</td>";
									echo "</tr>";	
								}
								?>
							</tbody>
							
						</table>
						<?php } ?>
					</div> <!-- End #prev -->

                   
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
	
	<div id="edit-popup" class="modal-box" style="width:50%;">  
		<header>
			<h3>Add Driver</h3>
		</header>
		<div class="modal-body" id="item-list">
						<form action="../../../utility/helper/Driver/DriverActionHelper.php?action=add" method="POST">
							
							<fieldset> <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->
															
								<p class="column-left">
									<label>Name</label>
										<input class="text-input medium-input" id="name" name="name" type="text" required placeholder='Rudra XYZ'> 
								</p>
								
								<p class="column-right">
									<label>Phone</label>
										<b>+91- </b><input class="text-input medium-input" name="phone" id="phone" type="text" maxlength="10" required placeholder='0123456789' min='1000000000' max='9999999999'> 
								</p>

								<p>
									<label>Address</label>
										<textarea name="address" id="address" required placeholder="House #12 , mayur vihar , new delhi"></textarea>
								</p>

								<p>
									<label>Description</label>
									<input class="text-input large-input" name="description" id="description" type="text" required placeholder="I was working in this company or having much experience.">
									<br><small>A small description of the driver which will help in identifying the driver with ease.</small>
								</p>
							
								<p class="column-left">
									<label>Joining Date</label>
										<input class="text-input medium-input" id="date_join" name="date_join" type="text" required> 
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

	<div id="detail-popup" class="modal-box" style="width:50%;">  
		<header>
			<h3>Driver Info</h3>
		</header>
		<div class="detail-popup-body" id="item-list">
					

	  <footer>
		<b><input class="button" value="SUBMIT" type="submit">&nbsp;</b>
		<a href="#" class="js-modal-close" style="color:#D3402B"><b>CANCEL</b></a>
	  </footer>

		</div>
	</div>

<?php require_once "../../master/footerhome.php"; ?>