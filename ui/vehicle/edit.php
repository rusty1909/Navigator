<?php
	require_once "../../framework/User.php";
	require_once "../../framework/Vehicle.php";
	require_once "../../framework/Job.php";
	require_once "../../framework/Driver.php";

if(!isset($_SESSION['user']))
	header('Location:../user/login.php');

	$mUser = new User();
/*
    $mAllVehicleList = $mUser->getVehicleList();
	$mPreviousVehicleList = $mUser->getPreviousVehicleList();
	$mDeployedVehicleList = $mUser->getDeployedVehicleList();
	$mOnJobVehicleList = $mUser->getOnJobVehicleList();
	$mFreeVehicleList = $mUser->getFreeVehicleList();
	$mWaitingVehicleList = $mUser->getWaitingVehicleList();
	
    if(!isset($_GET['list']))
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
		
	</head>
  
	<body><div id="body-wrapper"> <!-- Wrapper for the radial gradient background -->
		
		<?php include("../sidebar.php"); ?>
		
		<div id="main-content"> <!-- Main Content Section with everything -->
			
			<noscript> <!-- Show a notification if the user has disabled javascript -->
				<div class="notification error png_bg">
					<div>
						Javascript is disabled or is not supported by your browser. Please <a href="http://browsehappy.com/" title="Upgrade to a better browser">upgrade</a> your browser or <a href="http://www.google.com/support/bin/answer.py?answer=23852" title="Enable Javascript in your browser">enable</a> Javascript to navigate the interface properly.
					</div>
				</div>
			</noscript>
		
			
			<div class="clear"></div> <!-- End .clear -->
			
			<div class="content-box"><!-- Start Content Box -->
				
				<div class="content-box-header">
					
					<h3 style="cursor: s-resize;">Add Vehicle</h3>
									
					<!--<ul class="content-box-tabs">
						<li><a href="#add" class="default-tab current">Add</a></li> 
					</ul>-->
					
					<div class="clear"></div>
					
				</div> <!-- End .content-box-header -->
				
				<div class="content-box-content">
					<div style="display: block;" class="tab-content default-tab" id="add">
					
						<form action="action.php?action=add" method="POST">
							
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
				
			</div> <!-- End .content-box -->

			
<?php include("../footer.php")?>
			
		</div> <!-- End #main-content -->
		
	</div>
	</body></html>