<?php
	require_once "../../framework/User.php";
	require_once "../../framework/Vehicle.php";
	require_once "../../framework/Job.php";
	require_once "../../framework/Driver.php";

if(!isset($_SESSION['user']))
	header('Location:../user/login.php');

	$mUser = new User();
	

    $mAllVehicleList = $mUser->getVehicleList();
	$mPreviousVehicleList = $mUser->getPreviousVehicleList();
	$mDeployedVehicleList = $mUser->getDeployedVehicleList();
	$mOnJobVehicleList = $mUser->getOnJobVehicleList();
	$mFreeVehicleList = $mUser->getFreeVehicleList();
	$mWaitingVehicleList = $mUser->getWaitingVehicleList();

?>
<html xmlns="http://www.w3.org/1999/xhtml"><head>
		
		<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
		
		<title>FindGaddi</title>
		
		<!--                       CSS                       -->
	  
		<!-- Reset Stylesheet -->
		<link rel="stylesheet" href="../../res/reset.css" type="text/css" media="screen">
	  
		<!-- Main Stylesheet -->
		<link rel="stylesheet" href="../../res/style.css" type="text/css" media="screen">
		
		<!-- Invalid Stylesheet. This makes stuff look pretty. Remove it if you want the CSS completely valid -->
		<link rel="stylesheet" href="../../res/invalid.css" type="text/css" media="screen">	
  
		<!-- jQuery -->
		<script type="text/javascript" src="../../res/jquery-1.js"></script>
		
		<!-- jQuery Configuration -->
		<script type="text/javascript" src="../../res/simpla.js"></script>
		
		<!-- Facebox jQuery Plugin -->
		<script type="text/javascript" src="../../res/facebox.js"></script>
		
		<!-- jQuery WYSIWYG Plugin -->
		<script type="text/javascript" src="../../res/jquery_002.js"></script>
		
		<!-- jQuery Datepicker Plugin -->
		<script type="text/javascript" src="../../res/jquery.htm"></script>
		<script type="text/javascript" src="../../res/jquery.js"></script>
		<!--[if IE]><script type="text/javascript" src="resources/scripts/jquery.bgiframe.js"></script><![endif]-->
		<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
        <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
	  <!--  //modal box jquery -->
		<link rel="stylesheet"  href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
		<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
		<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

	
    <script type="text/javascript">
	function onDelete(id){
		if(confirm("You really want to delete this vehicle?"))
			window.location.href = "action.php?action=delete&id="+id;
	}
	</script>
<!-- //Modal Box Functionality  -->
	<script>
		$(document).ready(function () {
			console.log("clicked");
			$('#dialog_link').click(function () {
				$('#dialog').dialog('open');
				return false;
			});
			
			//$("#edit-form").load("edit.php");
		});

		$(function(){
		console.log("started");
		var appendthis =  ("<div class='modal-overlay js-modal-close'></div>");

		  $('a[data-modal-id]').click(function(e) {
			e.preventDefault();
			$("body").append(appendthis);
			$(".modal-overlay").fadeTo(500, 0.7);
			//$(".js-modalbox").fadeIn(500);
			var modalBox = $(this).attr('data-modal-id');
			$('#'+modalBox).fadeIn($(this).data());
		  });  
		  

		$(".js-modal-close, .modal-overlay").click(function() {
		  $(".modal-box, .modal-overlay").fadeOut(500, function() {
			$(".modal-overlay").remove();
		  });
		});

		$(window).resize(function() {
		  $(".modal-box").css({
			top: ($(window).height() - $(".modal-box").outerHeight()) / 3,
			left: ($(window).width() - $(".modal-box").outerWidth()) / 2
		  });
		});
		 
		$(window).resize();
		 
		});
		/* ************************** */
		$(document).ready(function(){
			$('#vehicle_number').blur(checkNumber); //use keyup,blur, or change
		});
		function checkNumber(){
			var vehicle_number = $('#vehicle_number').val();
			//alert(vehicle_number);
			if(vehicle_number == "") return;
			jQuery.ajax({
					type: 'POST',
					url: 'checkDuplicates.php',
					data: 'vehicle_number='+ vehicle_number,
					cache: false,
					success: function(response){
						//alert(response);
						if(response == 0){
							document.getElementById("number_error").innerHTML = "";
							document.getElementById("number_success").innerHTML = "<b>available ! ! !<b>";
						}
						else {
							document.getElementById("vehicle_number").value = "";
							document.getElementById("number_success").innerHTML = "";
							document.getElementById("number_error").innerHTML = "<b><i>'"+vehicle_number+"'</i></b>  already exists!";	
						}
					}
				});
		}
	</script>
		
	</head>
  
	<body><div id="body-wrapper"> <!-- Wrapper for the radial gradient background -->
		
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
			
			<div class="content-box column-left" style="width:63%"><!-- Start Content Box -->
				
				<div class="content-box-header">
					
					<h3 style="cursor: s-resize;">Vehicle List</h3>
					
					<ul class="content-box-tabs">
						<!--<li><a href="#all" title="List of all vehicles registered">All (<?php echo sizeof($mAllVehicleList); ?>)</a></li> <!-- href must be unique and match the id of target div -->
						<li><a href="#deployed" title="List of online vehicles" class="default-tab current">Online<!--Deployed alias--> (<?php echo sizeof($mDeployedVehicleList); ?>)</a></li>
						<!--<li><a href="#onjob">On-Job (<?php echo sizeof($mOnJobVehicleList); ?>)</a></li>
						<li><a href="#free">Free (<?php echo sizeof($mFreeVehicleList); ?>)</a></li>
						<li><a href="#prev">Previous (<?php echo sizeof($mPreviousVehicleList); ?>)</a></li>-->
						<li><a href="#wait" title="List of devices waiting for device deployement">Waiting  (<?php echo sizeof($mWaitingVehicleList); ?>)</a></li>
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
											<!--<select name="dropdown">
												<option selected="selected" value="option1">Choose an action...</option>
												<option value="option2">Edit</option>
												<option value="option3">Delete</option>
											</select>
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
								$mVehicleList = $mAllVehicleList;
								for($i=0; $i<sizeof($mVehicleList); $i++) {
									$mVehicle = new Vehicle($mVehicleList[$i]);
									$mJob = new Job($mVehicle->getCurrentJob());
									$mDriver = new Driver($mVehicle->getDriver());
									echo "<tr>";
									echo "<td><img id='type' height='20' width='20' src='../../res/vehicle_types/".$mVehicle->getType().".png' title=".$mVehicle->getType()." alt=".$mVehicle->getType()." style='vertical-align:-5px;'></td>";
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
											<!--<select name="dropdown">
												<option selected="selected" value="option1">Choose an action...</option>
												<option value="option2">Edit</option>
												<option value="option3">Delete</option>
											</select>
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
								$mVehicleList = $mDeployedVehicleList;
								for($i=0; $i<sizeof($mVehicleList); $i++) {
									$mVehicle = new Vehicle($mVehicleList[$i]);
									$mJob = new Job($mVehicle->getCurrentJob());
									$mDriver = new Driver($mVehicle->getDriver());
									echo "<tr>";
									echo "<td><img id='type' height='20' width='20' src='../../res/vehicle_types/".$mVehicle->getType().".png' title=".$mVehicle->getType()." alt=".$mVehicle->getType()." style='vertical-align:-5px;'></td>";
									echo "<td>".$mVehicle->getModel()."</td>";
									echo "<td><b><a style='text-transform:uppercase;' href='detail.php?id=".$mVehicle->getId()."'>".$mVehicle->getVehicleNumber()."</a></b></td>";
									if($mVehicle->getDriver() != "0"){
										echo "<td><img height='15' width='15' src='../../res/driver_icon.png'>&nbsp;<b><a href='../driver/detail.php?id=".$mDriver->getId()."' style='text-transform:uppercase;vertical-align:2px;'>".$mDriver->getName()."</a></b></td>";
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
											<!--<select name="dropdown">
												<option selected="selected" value="option1">Choose an action...</option>
												<option value="option2">Edit</option>
												<option value="option3">Delete</option>
											</select>
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
									echo "<tr>";
									echo "<td><img id='type' height='20' width='20' src='../../res/vehicle_types/".$mVehicle->getType().".png' title=".$mVehicle->getType()." alt=".$mVehicle->getType()." style='vertical-align:-5px;'></td>";
									echo "<td>".$mVehicle->getModel()."</td>";
									echo "<td><a href='detail.php?id=".$mVehicle->getId()."'>".$mVehicle->getVehicleNumber()."</a></td>";
									/*echo "									<td>
										<!-- Icons -->
										 <a href='#' title='Edit'><img src='../../res/pencil.png' alt='Edit'></a>
										 <a href='#' title='Delete' onClick='onDelete(".$mVehicle->getId().")'><img src='../../res/cross.png' alt='Delete'></a>&nbsp;&nbsp;
										 <a href='#' title='Edit Meta'><img src='../../res/hammer_screwdriver.png' alt='Edit Meta'></a>
									</td>";*/
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
									echo "<tr>";
									echo "<td><img id='type' height='20' width='20' src='../../res/vehicle_types/".$mVehicle->getType().".png' title=".$mVehicle->getType()." alt=".$mVehicle->getType()." style='vertical-align:-5px;'></td>";
									echo "<td>".$mVehicle->getModel()."</td>";
									echo "<td><a href='detail.php?id=".$mVehicle->getId()."'>".$mVehicle->getVehicleNumber()."</a></td>";
									echo "<td>".$mJob->getCode()."</td>";
									echo "<td>".$mDriver->getName()."</td>";
									echo "									<td>
										<!-- Icons -->
										 <a href='#' title='Edit'><img src='../../res/pencil.png' alt='Edit'></a>
										 <a href='#' title='Delete' onClick='onDelete(".$mVehicle->getId().")'><img src='../../res/cross.png' alt='Delete'></a>&nbsp;&nbsp;
										 <a href='#' title='Edit Meta'><img src='../../res/hammer_screwdriver.png' alt='Edit Meta'></a>
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
									echo "<tr>";
									echo "<td><img id='type' height='20' width='20' src='../../res/vehicle_types/".$mVehicle->getType().".png' title=".$mVehicle->getType()." alt=".$mVehicle->getType()." style='vertical-align:-5px;'></td>";
									echo "<td>".$mVehicle->getModel()."</td>";
									echo "<td><a href='detail.php?id=".$mVehicle->getId()."'>".$mVehicle->getVehicleNumber()."</a></td>";
									echo "<td>".$mJob->getCode()."</td>";
									echo "<td>".$mDriver->getName()."</td>";
									echo "									<td>
										<!-- Icons -->
										 <a href='#' title='Edit'><img src='../../res/pencil.png' alt='Edit'></a>
										 <a href='#' title='Delete' onClick='onDelete(".$mVehicle->getId().")'><img src='../../res/cross.png' alt='Delete'></a>&nbsp;&nbsp;
										 <a href='#' title='Edit Meta'><img src='../../res/hammer_screwdriver.png' alt='Edit Meta'></a>
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
											<!--<select name="dropdown">
												<option selected="selected" value="option1">Choose an action...</option>
												<option value="option2">Edit</option>
												<option value="option3">Delete</option>
											</select>
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
								$mVehicleList = $mWaitingVehicleList;
								for($i=0; $i<sizeof($mVehicleList); $i++) {
									$mVehicle = new Vehicle($mVehicleList[$i]);
									$mJob = new Job($mVehicle->getCurrentJob());
									$mDriver = new Driver($mJob->getDriver());
									echo "<tr>";
									echo "<td><img id='type' height='20' width='20' src='../../res/vehicle_types/".$mVehicle->getType().".png' title=".$mVehicle->getType()." alt=".$mVehicle->getType()." style='vertical-align:-5px;'></td>";
									echo "<td>".$mVehicle->getModel()."</td>";
									echo "<td><a href='detail.php?id=".$mVehicle->getId()."'>".$mVehicle->getVehicleNumber()."</a></td>";
									echo "<td>
										<!-- Icons -->
										 <a href='#' title='Delete' onClick='onDelete(".$mVehicle->getId().")'><img src='../../res/cross.png' alt='Delete'></a>
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
			
			<div class="content-box column-right" style="width:35%">
				<div class="content-box-header"> <!-- Add the class "closed" to the Content box header to have it closed by default -->
					<h3 style="cursor: s-resize;">Notifications</h3>
				</div> <!-- End .content-box-header -->
				
				<div style="display: block;" class="content-box-content">
					
					<div style="display: block;" class="tab-content default-tab">
					
						<table>
						<thead>
						<tr></tr>
						</thead>
						<tbody>
						<?php
							echo "<tr></tr>";
							echo "<tr><td>Total Vehicles</td><td>".sizeof($mAllVehicleList)."</td></tr>";
							echo "<tr><td>Already Deployed</td><td>".sizeof($mDeployedVehicleList)."</td></tr>";
							echo "<tr><td>Waiting Deployement</td><td>".sizeof($mWaitingVehicleList)."</td></tr>";
						?>
						</tbody>
						</table>
					</div> <!-- End #tab3 -->  
				</div> <!-- End .content-box-content -->
				
			</div>
			<div class="clear"></div>
			
<?php include("../footer.php")?>
			
		</div> <!-- End #main-content -->

	</div>

	<div id="popup" class="modal-box" style="width:50%;">  
	  <header>
		<h3>Add Vehicle</h3>
	  </header>
	  <div class="modal-body" id="item-list">
	  

				
<!-------------------------------------------------------------------------------------------------------------------------->
						<form action="action.php?action=add" method="POST">
							
							<fieldset> <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->
							
								<p>
									<label>Vehicle Type</label>
									<input name="type" value="Truck" type="radio" id="type"> <img id="type" height="25" width="25" src="../../res/vehicle_types/Truck.png" title="Truck" alt="Truck" style='vertical-align:-5px;'> &nbsp;&nbsp;
									<input name="type" value="Car" type="radio"><img id="type" height="25" width="25" src="../../res/vehicle_types/Car.png" title="Car" alt="Car" style='vertical-align:-5px;'> &nbsp;&nbsp;
									<input name="type" value="Bus" type="radio"><img id="type" height="25" width="25" src="../../res/vehicle_types/Bus.png" title="Bus" alt="Bus" style='vertical-align:-5px;'> &nbsp;&nbsp;
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
										<input class="text-input small-input" name="vehicle_number" id="vehicle_number" type="text"> <span class="input-notification error png_bg" id="number_error"></span><span class="input-notification success png_bg" id="number_success"></span>
								</p>
								
								<p>
									<label>Description</label>
									<input class="text-input large-input" name="description" id="description" type="text">
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
	
	

</body></html>