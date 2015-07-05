<?php
	require_once "../../framework/User.php";
	require_once "../../framework/Vehicle.php";
	require_once "../../framework/Job.php";
	require_once "../../framework/Driver.php";

if(!isset($_SESSION['user']))
	header('Location:../user/login.php');

	$mUser = new User();
	
    $mCurrentDriverList = $mUser->getCurrentDriverList();
	//$mAllDriverList = $mUser->getAllDriverList();
	//$mDeployedDriverList = $mDriverList;
	//$mAllDriverList = $mUser->getAllDriverList();
	$mPreviousDriverList = $mUser->getPreviousDriverList();

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
			if(modalBox == "detail-popup"){
				//alert("sdvdskvds");
				//$('#'+modalBox).load("edit.php");
			}
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
											<a class="button" href="edit.php">Add Driver</a>
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
											<!--<select name="dropdown">
												<option selected="selected" value="option1">Choose an action...</option>
												<option value="option2">Edit</option>
												<option value="option3">Delete</option>
											</select>
											<a class="button" href="#">Apply to selected</a>-->
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
									echo "<td><img height='15' width='15' src='../../res/driver_icon.png'>&nbsp;&nbsp;<b><a href='detail.php?id=".$mDriver->getId()."' style='text-transform:uppercase;vertical-align:2px;'>".$mDriver->getName()."</a></b></td>";
									echo "<td><b><img height='20' width='20' src='../../res/phone_icon.png'><span style='vertical-align:5px;'>+91-".$mDriver->getPhone()."</span></b></td>";
									if($mVehicle->getId() != ""){
										echo "<td><b><img height='15' width='15' src='../../res/vehicle_types/".$mVehicle->getType().".png'>&nbsp;<a style='text-transform:uppercase;vertical-align:2px;' href='../vehicle/detail.php?id=".$mVehicle->getId()."'>".$mVehicle->getVehicleNumber()."</a></b></td>";
									} else {
										echo "<td></td>";
									}
									/*echo "<td>
										 <a href='#' title='Edit'><img src='../../res/pencil.png' alt='Edit'></a>&nbsp;&nbsp;
										 <a href='#' title='Locate'><img src='../../res/hammer_screwdriver.png' alt='Locate'></a>&nbsp;&nbsp;
									</td>";*/
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
											<!--<select name="dropdown">
												<option selected="selected" value="option1">Choose an action...</option>
												<option value="option2">Edit</option>
												<option value="option3">Delete</option>
											</select>
											<a class="button" href="#">Apply to selected</a>-->
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
									echo "<td><img height='15' width='15' src='../../res/driver_icon.png'>&nbsp;&nbsp;<b><a href='detail.php?id=".$mDriver->getId()."' style='text-transform:uppercase;' >".$mDriver->getName()."</a></b></td>";
									echo "<td>".$mDriver->getPhone()."</td>";
									echo "<td>".$mDriver->getAddress()."</td>";
									echo "									<td>
										<!-- Icons -->
										 <a href='#' title='Edit'><img src='../../res/pencil.png' alt='Edit'></a>
										 <a href='#' title='Delete' onClick='onDelete(".$mDriver->getId().")'><img src='../../res/cross.png' alt='Delete'></a>&nbsp;&nbsp;
										 <a href='#' title='Edit Meta'><img src='../../res/hammer_screwdriver.png' alt='Edit Meta'></a>
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
							echo "<tr><td>Total Vehicles</td><td></td></tr>";
							echo "<tr><td>Already Deployed</td><td></td></tr>";
							echo "<tr><td>Waiting Deployement</td><td></td></tr>";
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

	
	<div id="edit-popup" class="modal-box" style="width:50%;">  
		<header>
			<h3>Add Driver</h3>
		</header>
		<div class="modal-body" id="item-list">
						<form action="action.php?action=add" method="POST">
							
							<fieldset> <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->
															
								<p class="column-left">
									<label>Name</label>
										<input class="text-input medium-input" id="name" name="name" type="text"> 
								</p>
								
								<p class="column-right">
									<label>Phone</label>
										<b>+91- </b><input class="text-input medium-input" name="phone" id="phone" type="text"> 
								</p>

								<p>
									<label>Address</label>
										<textarea name="address" id="address" ></textarea>
								</p>
								
								<p>
									<label>Description</label>
									<input class="text-input large-input" name="description" id="description" type="text">
									<br><small>A small description of the driver which will help in identifying the driver with ease.</small>
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

</body></html>