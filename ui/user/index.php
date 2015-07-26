<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

	require_once "../../framework/User.php";
	require_once "../../framework/Vehicle.php";
	require_once "../../framework/Company.php";
	require_once "../../framework/Driver.php";

if(!isset($_SESSION['user']))
	header('Location:../user/login.php');

	$mUser = new User();

	$mCompany = new Company($mUser->getCompany());
	$mEmployeeList = $mCompany->getEmployeeList();

	
    $mAllVehicleList = $mUser->getVehicleList();
	$mDeployedVehicleList = $mUser->getDeployedVehicleList();
	$mWaitingVehicleList = $mUser->getWaitingVehicleList();
	$mOnJobVehicleList = $mUser->getOnJobVehicleList();
	
	$mDriverList = $mUser->getCurrentDriverList();
	$mAvailableDriverList = $mUser->getAvailableDriverList();
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
		
	<script>
	function fetchNotification(){
		//alert(id+" "+driver_id);
		var data = "";
        jQuery.ajax({
            type: 'POST',
            url: 'notification.php',
            cache: false,
            success: function(response){
				if(response == 0){
				}
				else {					
					var notiList = JSON.parse(response);
					for(var i=0; i<50 && i<notiList.length; i++){
						var image = "alert_ok";
						switch(notiList[i].type){
							case "expenses" : image = "alert_upload"; break;
							case "power_battery_plugged" : image = "alert_ok"; break;
							case "location" : image = "alert_location"; break;
							case "power_battery_low" :
							case "power_shutdown" :
							case "power_battery_unplugged" : image = "alert_high"; break;
							default : image = "alert_ok"; break;
						}
						data += "<tr style='background:#fff;border-bottom: 1px solid #ddd;'><td><img height='20' width='20' src='../../res/"+image+".png' title='Location' alt='Location'></td><td style='padding:10px;line-height:1em;'><span style='vertical-align:5px;'>"+notiList[i].string+"</span></td><td style='font-size:10px;padding-top:-10px'><span style='vertical-align:7px;'><b>"+notiList[i].time+"</b></span></td></tr>";
						console.log(image);
					}
					//alert(data);
					document.getElementById("noti_body").innerHTML = data;
					//$("#noti_table").find("tbody").find('#main-content table').;
					data="";
				}
            }
        });
       
        
	}
	
	var notificationUpdates = setInterval(function(){ fetchNotification() }, 2000);
	</script>
</head>
  
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
							<img src="../../res/truck.png" alt="icon"><br>
							<b><span style="font-size:30px;border: none; display:block; padding: 0px;"><?php echo sizeof($mAllVehicleList) ?></span></b> registered<br>drivers<br><br>
							<b><?php echo sizeof($mOnJobVehicleList) ?></b> on-road<br><br>
							<b><?php echo sizeof($mWaitingVehicleList) ?></b> waiting<br>
						</span></a></li>
						
						<li><a class="shortcut-button" href="../driver/"><span>
							<b><span style="font-size:15px;border: none; display:block; padding: 0px;">DRIVERS</span></b>
							<img src="../../res/drivers.png" alt="icon"><br>
							<b><span style="font-size:30px;border: none; display:block; padding: 0px;"><?php echo sizeof($mDriverList) ?></span></b> registered<br>drivers<br><br>
							<b><?php echo sizeof($mAvailableDriverList) ?></b> available<br>
						</span></a></li>
						
						<li><a class="shortcut-button" href="#"><span>
							<b><span style="font-size:15px;border: none; display:block; padding: 0px;">STAFFS</span></b>
							<img src="../../res/staff.png" alt="icon"><br>
							<b><span style="font-size:30px;border: none; display:block; padding: 0px;"><?php echo sizeof($mEmployeeList) ?></span></b> registered<br>staff<br>
						</span></a>
						</li>
						
						<li><a class="shortcut-button" href="#"><span>
							<b><span style="font-size:15px;border: none; display:block; padding: 0px;">ALERTS</span></b>
							<img src="../../res/alerts.png" alt="icon"><br>
							<b><span style="font-size:30px;border: none; display:block; padding: 0px;"><?php echo sizeof($mDriverList) ?></span></b> reported<br>this month<br><br>
							<b><?php echo sizeof($mAvailableDriverList) ?></b> total reported<br>
						</span></a></li>
						
					</ul><!-- End .shortcut-buttons-set -->
				</div> <!-- End .content-box -->
				<div class="clear"></div>
				<div class="content-box column-left" style="width:49%;height:50%">				
					<div class="content-box-header">					
						<h3 style="cursor: s-resize;">Pending Bills</h3>				
					</div> <!-- End .content-box-header -->				
					<div style="display: block;padding:0px;height:85%;overflow-y:auto" class="content-box-content">
					
						<div style="display:block;overflow-y:auto" class="tab-content default-tab" id="item-list">
						
							<table id="noti_table">
							<thead>
							<tr></tr>
							</thead>
							<tbody style="border-bottom:0px" id="bill_body">
							<tr><td><b>Coming soon...</b></td></tr>
							</tbody>
							</table>
						</div>      
					
					</div> <!-- End .content-box-content -->			
				</div> <!-- End .content-box -->
				<div class="content-box column-right" style="width:49%;height:50%">				
					<div class="content-box-header">					
						<h3 style="cursor: s-resize;">Reminders</h3>
						<a href="#" style="color:#57a000; float:right;padding:15px 10px 0 0 !important"><b>Add Reminder</b></a>		
					</div> <!-- End .content-box-header -->				
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
					
					</div> <!-- End .content-box-content -->
				</div>
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
  </body></html>