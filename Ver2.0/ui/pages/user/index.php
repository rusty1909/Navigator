<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

	require_once "../../framework/User.php";
	require_once "../../framework/Vehicle.php";
	require_once "../../framework/Company.php";
	require_once "../../framework/Driver.php";
	require_once "../../framework/Expense.php";
	

if(!isset($_SESSION['user']))
	header('Location:../user/login.php');

	$mUser = new User();

	$mCompany = new Company($mUser->getCompany());
	$mEmployeeList = $mCompany->getEmployeeList();
	
	$mAlertList = $mUser->getAlerts();
	$mMonthlyAlertList = $mUser->getMonthlyAlerts();
	
	$mPendingExpenseList = $mUser->getPendingExpenseList();

	
    $mAllVehicleList = $mUser->getVehicleList();
	$mDeployedVehicleList = $mUser->getDeployedVehicleList();
	$mWaitingVehicleList = $mUser->getWaitingVehicleList();
	$mOnJobVehicleList = $mUser->getOnJobVehicleList();
	
	$mDriverList = $mUser->getCurrentDriverList();
	$mAvailableDriverList = $mUser->getAvailableDriverList();
	?>
<?php require_once "../../master/headerhome.php"; ?>

 <script type="text/javascript" src="../../../js/userindex.js"></script>
  
	<body onload='fetchNotification()'><div id="body-wrapper"> <!-- Wrapper for the radial gradient background -->
		
	<?php include('../sidebar.php');?>
		
		<div id="main-content"> <!-- Main Content Section with everything -->
			
			<noscript> <!-- Show a notification if the user has disabled javascript -->
				<div class="notification error png_bg">
					<div>
						Javascript is disabled or is not supported by your browser. Please <a href="http://browsehappy.com/" title="Upgrade to a better browser">upgrade</a> your browser or <a href="http://www.google.com/support/bin/answer.py?answer=23852" title="Enable Javascript in your browser">enable</a> Javascript to navigate the interface properly.
					</div>
				</div>
			</noscript>
			
			<div class="clear"></div> <!-- End .clear -->
			<div style="width:59%;height:88%;float:left">
				<div class="column-left" style="width:100%;height:50%">				
					<ul class="shortcut-buttons-set">
				
						<li><a class="shortcut-button" href="../vehicle/"><span>
							<b><span style="font-size:15px;border: none; display:block; padding: 0px;">VEHICLES</span></b>
							<img src="../../../images/truck.png" alt="icon"><br>
							<b><span style="font-size:30px;border: none; display:block; padding: 0px;"><?php echo sizeof($mAllVehicleList) ?></span></b> registered<br>drivers<br><br>
							<b><?php echo sizeof($mOnJobVehicleList) ?></b> on-road<br><br>
							<b><?php echo sizeof($mWaitingVehicleList) ?></b> waiting<br>
						</span></a></li>
						
						<li><a class="shortcut-button" href="../driver/"><span>
							<b><span style="font-size:15px;border: none; display:block; padding: 0px;">DRIVERS</span></b>
							<img src="../../../images/drivers.png" alt="icon"><br>
							<b><span style="font-size:30px;border: none; display:block; padding: 0px;"><?php echo sizeof($mDriverList) ?></span></b> registered<br>drivers<br><br>
							<b><?php echo sizeof($mAvailableDriverList) ?></b> available<br>
						</span></a></li>
						
						<li><a class="shortcut-button" href="<?php if($mUser->getCompany()==-1){echo "#";} else {echo "../company/index.php?page=staff";}?>"><span>
							<b><span style="font-size:15px;border: none; display:block; padding: 0px;">STAFFS</span></b>
							<img src="../../../images/staff.png" alt="icon"><br>
							<?php
							if($mUser->getCompany()==-1){
							?>
							<b><span style="border: none; display:block; padding: 0px;">Please add Company to add Staff</span></b>
							<?php } else { ?>
							<b><span style="font-size:30px;border: none; display:block; padding: 0px;"><?php echo sizeof($mEmployeeList) ?></span></b> registered<br>staff<br>
							<?php } ?>
						</span></a>
						</li>
						
						<li><a class="shortcut-button" href="#"><span>
							<b><span style="font-size:15px;border: none; display:block; padding: 0px;">ALERTS</span></b>
							<img src="../../../images/alerts.png" alt="icon"><br>
							<b><span style="font-size:30px;border: none; display:block; padding: 0px;"><?php echo sizeof($mMonthlyAlertList) ?></span></b> reported<br>this month<br><br>
							<b><?php echo sizeof($mAlertList) ?></b> total reported<br>
						</span></a></li>
						
					</ul><!-- End .shortcut-buttons-set -->
				</div> <!-- End .content-box -->
				<div class="clear"></div>
				<div class="content-box column-left" style="width:100%;height:50%">				
					<div class="content-box-header">					
						<h3 style="cursor: s-resize;">Pending Bills (<?php echo sizeof($mPendingExpenseList);?>)</h3>				
					</div> <!-- End .content-box-header -->				
					<div style="display: block;padding:0px;height:85%;overflow-y:auto" class="content-box-content">
					
						<div style="display:block;overflow-y:auto" class="tab-content default-tab">
						
							<table id="noti_table">
							<thead>
							<tr></tr>
							</thead>
							<tbody style="border-bottom:0px" id="bill_body">
							<?php
								for($i=0; $i<sizeof($mPendingExpenseList); $i++){
									$mExpense = new Expense($mPendingExpenseList[$i]);
									$vehicleId = $mExpense->getVehicle();
									$mVehicle = new Vehicle($vehicleId);
									
									$driverId = $mExpense->getDriver();
									$mDriver = new Driver($driverId);
									
									$reason = $mExpense->getReason();
									$amount = $mExpense->getAmount();
									echo "<tr onMouseOver='this.bgColor='#EEEEEE''>
											<td style='width:30%'><b><a href='../vehicle/detail.php?id=".$mVehicle->getId()."'>".$mVehicle->getVehicleNumber()."</a></b></td>
											<td style='width:30%'><b><a href='../driver/detail.php?id=".$mDriver->getId()."'>".$mDriver->getName()."</a></b></td>
											<td>".$reason."</td>
											<td><b>Rs.".$amount."</b></td>
											<td><a class='js-open-modal' href='#' data-modal-id='bill_popup' onClick='fetchBillDetails(".$mExpense->getId().")'><img src='../../../images/more_detail.png' width=20 height=20 style='cursor:hand;'/></a></td>
										</tr>";
								}
							?>
							</tbody>
							</table>
						</div>      
					
					</div> <!-- End .content-box-content -->			
				</div> <!-- End .content-box -->
				<!----------------- REMINDER TAB -------------------------------------------------------------------------------------
				<div class="content-box column-right" style="width:49%;height:50%">				
					<div class="content-box-header">					
						<h3 style="cursor: s-resize;">Reminders</h3>
						<a href="#" style="color:#57a000; float:right;padding:15px 10px 0 0 !important"><b>Add Reminder</b></a>		
					</div> 
					
					
					<div style="display: block;padding:0px;height:85%;overflow-y:auto" class="content-box-content">
					
						<div style="display:block;overflow-y:auto" class="tab-content default-tab" id="item-list">
						
							<table id="noti_table">
							<thead>
							<tr></tr>
							</thead>
							<tbody style="border-bottom:0px" id="rem_body">
							<tr><td><b>Coming soon...</b></td></tr>
							</tbody>
							</table>
						</div>      
					
					</div> 
					
				</div>
				---------------------------------------------------------------------------------------------------------------------------->
			</div>
			
			

			<div class="content-box column-right" style="width:40%;height:88%;">
			
				
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
					</div>      
					
				</div> <!-- End .content-box-content -->
				
			</div> <!-- End .content-box -->
			<div class="clear"></div>
			<?php include("../footer.php")?>
			
		</div> <!-- End #main-content -->
		
	</div>
	
	<div id="bill_popup" class="modal-box" style="width:40%;">  
	  <header>
		<h3>Bill Details</h3>
	  </header>
	  <div class="modal-body" id="item-list" style="padding-left:10px;padding-right:10px">
		<div style="float:left;width:250px">
			<table>
			<tbody style="border-bottom: 0px;">
				<tr style="border-bottom: 0px;"><td id="vehicle">vehicle...</td></tr>
				<tr style="border-bottom: 0px;"><td id="driver">driver...</td></tr>
				<tr style="border-bottom: 0px;"><td id="reason">reason...</td></tr>
				<tr style="border-bottom: 0px;"><td id="amount">amount...</td></tr>
				
			</tbody>
			</table>
		</div>
		<div style="float:right;" id="bill_image">
		</div>
		<div style="width:100%">
			<table>
			<tbody>
				<tr style="border-bottom: 0px;"><td id='address'>Loading</td><!--<td id='map'>map</td>--></tr>
				<tr style="border-bottom: 0px;"><td id="date_added">date_added...</td></tr>				
			</tbody>
			</table>
		</div>
	  </div>
	  <footer>
		<b><input class="button js-modal-close" value="APPROVE" type="submit" onClick="approveBill('1')"></b>&nbsp;
		<a href="#" class="js-modal-close" style="color:#D3402B" onClick="approveBill('-1')"><b>REJECT</b></a>&nbsp;
		<a href="#" class="js-modal-close" style="color:#D3402B"><b>LATER</b></a>
	  </footer>
	</div>
<?php require_once "../../master/footerhome.php"; ?>