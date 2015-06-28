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
	//echo "------------------------------------------------------------------------------------->".sizeof($mWaitingVehicleList);
	
/*    if(!isset($_GET['list']))
		$mAllVehicleList = $mUser->getVehicleList();
	else {
		$list = $_GET['list'];
		switch($list) {
			case "prev" : $mPreviousVehicleList = $mUser->getPreviousVehicleList(); break;
			case "deployed" : $mDeployedVehicleList = $mUser->getDeployedVehicleList(); break;
			case "onjob" : $mOnJobVehicleList = $mUser->getOnJobVehicleList(); break;
			case "free" : $mFreeVehicleList = $mUser->getFreeVehicleList(); break;
			case "wait" : $mWaitingVehicleList = $mUser->getWaitingVehicleList(); break;
			default : $mVehicleList = $mUser->getVehicleList(); break;
		}
	} */
	//echo sizeof($mVehicleList);
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

		
		<!-- Internet Explorer .png-fix -->
		
		<!--[if IE 6]>
			<script type="text/javascript" src="resources/scripts/DD_belatedPNG_0.0.7a.js"></script>
			<script type="text/javascript">
				DD_belatedPNG.fix('.png_bg, img, li');
			</script>
		<![endif]-->
	
    <script type="text/javascript">
	function onDelete(id){
		if(confirm("You really want to delete this vehicle?"))
			window.location.href = "action.php?action=delete&id="+id;
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
			
			<!-- Page Head -- >
			<h2>Welcome John</h2>
			<p id="page-intro">What would you like to do?</p>
			
			<ul class="shortcut-buttons-set">
				
				<li><a class="shortcut-button" href="#"><span>
					<img src="../../res/pencil_48.png" alt="icon"><br>
					Write an Article
				</span></a></li>
				
				<li><a class="shortcut-button" href="#"><span>
					<img src="../../res/paper_content_pencil_48.png" alt="icon"><br>
					Create a New Page
				</span></a></li>
				
				<li><a class="shortcut-button" href="#"><span>
					<img src="../../res/image_add_48.png" alt="icon"><br>
					Upload an Image
				</span></a></li>
				
				<li><a class="shortcut-button" href="#"><span>
					<img src="../../res/clock_48.png" alt="icon"><br>
					Add an Event
				</span></a></li>
				
				<li><a class="shortcut-button" href="#messages" rel="modal"><span>
					<img src="../../res/comment_48.png" alt="icon"><br>
					Open Modal
				</span></a></li>
				
			</ul><! -- End .shortcut-buttons-set -->
			
			<div class="clear"></div> <!-- End .clear -->
			
			<div class="content-box"><!-- Start Content Box -->
				
				<div class="content-box-header">
					
					<h3 style="cursor: s-resize;">Vehicle List</h3>
					
					<ul class="content-box-tabs">
						<li><a href="#all" title="List of all vehicles registered">All (<?php echo sizeof($mAllVehicleList); ?>)</a></li> <!-- href must be unique and match the id of target div -->
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
											<a class="button" href="edit.php">Add Vehicle</a>
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
								   <th>Vehicle Type</th>
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
											<a class="button" href="edit.php">Add Vehicle</a>
										</div>
										
										<div class="pagination">
											<?php
											//echo sizeof($mAllVehicleList)/10;
											if((sizeof($mAllVehicleList)/10) > 1) {
												echo "<a href='#' title='First Page'>« First</a><a href='#' title='Previous Page'>« Previous</a>";
											
												for($i=0; $i<(sizeof($mAllVehicleList)/10);$i++) {
													$k = $i+1;
													echo "<a href='#' class='number current' title='".$k."'>".$k."</a>";
												}
											
											//<a href="#" class="number" title="1">1</a>
											//<a href="#" class="number" title="2">2</a>
											//<a href="#" class="number current" title="3">3</a>
											//<a href="#" class="number" title="4">4</a>
												echo "<a href='#' title='Next Page'>Next »</a><a href='#' title='Last Page'>Last »</a>";
											}
											?>
										</div> <!-- End .pagination -->
										<div class="clear"></div>
									</td>
								</tr>
							</tfoot>    -->
						 
							<tbody>
<!--								<tr>
								<div id="search" style="display: none;" class="tab-content">
								<td><input type="text" id="type"></td>
								<td><input type="text" id="model"></td>
								<td><input type="text" id="number"></td>
								<td><input type="text" id="job"></td>
								<td><input type="text" id="driver"></td>
								<td><input type="button" id="search" value="Search"></td>
								</div>
								</tr>   -->
								<?php
								$mVehicleList = $mAllVehicleList;
								for($i=0; $i<sizeof($mVehicleList); $i++) {
									$mVehicle = new Vehicle($mVehicleList[$i]);
									$mJob = new Job($mVehicle->getCurrentJob());
									$mDriver = new Driver($mJob->getDriver());
									echo "<tr>";
									echo "<td>".$mVehicle->getType()."</td>";
									echo "<td>".$mVehicle->getModel()."</td>";
									echo "<td><a href='detail.php?id=".$mVehicle->getId()."'>".$mVehicle->getVehicleNumber()."</a></td>";
									echo "<td>".$mJob->getCode()."</td>";
									echo "<td>".$mDriver->getName()."</td>";
									echo "<td>
										 <a href='#' title='Edit'><img src='../../res/pencil.png' alt='Edit'></a>&nbsp;&nbsp;
										 <a href='#' title='Locate'><img src='../../res/hammer_screwdriver.png' alt='Locate'></a>&nbsp;&nbsp;
									</td>";
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
											<a class="button" href="edit.php">Add Vehicle</a>
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
								   <th>Vehicle Type</th>
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
											<a class="button" href="edit.php">Add Vehicle</a>
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
								$mVehicleList = $mDeployedVehicleList;
								for($i=0; $i<sizeof($mVehicleList); $i++) {
									$mVehicle = new Vehicle($mVehicleList[$i]);
									$mJob = new Job($mVehicle->getCurrentJob());
									$mDriver = new Driver($mJob->getDriver());
									echo "<tr>";
									echo "<td>".$mVehicle->getType()."</td>";
									echo "<td>".$mVehicle->getModel()."</td>";
									echo "<td><a href='detail.php?id=".$mVehicle->getId()."'>".$mVehicle->getVehicleNumber()."</a></td>";
									echo "<td>".$mJob->getCode()."</td>";
									echo "<td>".$mDriver->getName()."</td>";
									echo "									<td>
										<!-- Icons -->
										 <a href='#' title='Edit'><img src='../../res/pencil.png' alt='Edit'></a>
										 <a href='#' title='Edit Meta'><img src='../../res/hammer_screwdriver.png' alt='Edit Meta'></a>
									</td>";
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
								   <th>Vehicle Type</th>
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
											<a class="button" href="edit.php">Add Vehicle</a>
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
								$mVehicleList = $mOnJobVehicleList;
								for($i=0; $i<sizeof($mVehicleList); $i++) {
									$mVehicle = new Vehicle($mVehicleList[$i]);
									$mJob = new Job($mVehicle->getCurrentJob());
									$mDriver = new Driver($mJob->getDriver());
									echo "<tr>";
									echo "<td>".$mVehicle->getType()."</td>";
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
								   <th>Vehicle Type</th>
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
											<a class="button" href="edit.php">Add Vehicle</a>
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
									echo "<td>".$mVehicle->getType()."</td>";
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
								   <th>Vehicle Type</th>
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
											<a class="button" href="edit.php">Add Vehicle</a>
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
									echo "<td>".$mVehicle->getType()."</td>";
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
											<a class="button" href="edit.php">Add Vehicle</a>
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
								   <th>Vehicle Type</th>
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
											<a class="button" href="edit.php">Add Vehicle</a>
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
								$mVehicleList = $mWaitingVehicleList;
								for($i=0; $i<sizeof($mVehicleList); $i++) {
									$mVehicle = new Vehicle($mVehicleList[$i]);
									$mJob = new Job($mVehicle->getCurrentJob());
									$mDriver = new Driver($mJob->getDriver());
									echo "<tr>";
									echo "<td>".$mVehicle->getType()."</td>";
									echo "<td>".$mVehicle->getModel()."</td>";
									echo "<td><a href='detail.php?id=".$mVehicle->getId()."'>".$mVehicle->getVehicleNumber()."</a></td>";
									echo "<td>".$mJob->getCode()."</td>";
									echo "<td>".$mDriver->getName()."</td>";
									echo "<td>
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
						<?php } 
						}	?>
					</div> <!-- End #wait -->


					
				</div> <!-- End .content-box-content -->
				
			</div> <!-- End .content-box -->
			
<?php include("../footer.php")?>
			
		</div> <!-- End #main-content -->
		
	</div>
</body></html>