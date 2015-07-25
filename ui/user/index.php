<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

	require_once "../../framework/User.php";
	require_once "../../framework/Vehicle.php";
	require_once "../../framework/Job.php";
	require_once "../../framework/Driver.php";

if(!isset($_SESSION['user']))
	header('Location:../user/login.php');

	$mUser = new User();


	
    $mAllVehicleList = $mUser->getVehicleList();
//	$mPreviousVehicleList = $mUser->getPreviousVehicleList();
	$mDeployedVehicleList = $mUser->getDeployedVehicleList();
//	$mOnJobVehicleList = $mUser->getOnJobVehicleList();
//	$mFreeVehicleList = $mUser->getFreeVehicleList();
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
						data += "<tr style='background:#fff;border-bottom: 1px solid #ddd;'><td ><img height='20' width='20' src='../../res/"+image+".png' title='Location' alt='Location'></td><td style='padding:10px;line-height:1em;vertical-align:12px;'><span style='vertical-align:5px;'>"+notiList[i].string+"</span></td></tr>";
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
			<div style="width:58%;height:88%;float:left">
				<div class="content-box column-left" style="width:100%;height:49%">				
					<div class="content-box-header">					
						<h3 style="cursor: s-resize;">Reminders</h3>				
					</div> <!-- End .content-box-header -->				
					<div class="content-box-content">										
					</div> <!-- End .content-box-content -->				
				</div> <!-- End .content-box -->
				<br>
				<div class="content-box column-left" style="width:100%;height:49%">				
					<div class="content-box-header">					
						<h3 style="cursor: s-resize;">Reminders</h3>					
					</div> <!-- End .content-box-header -->				
					<div class="content-box-content">										
					</div> <!-- End .content-box-content -->				
				</div> <!-- End .content-box -->
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