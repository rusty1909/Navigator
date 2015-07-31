<?php
	require_once "../../framework/User.php";
	require_once "../../framework/Vehicle.php";
	require_once "../../framework/Job.php";
	require_once "../../framework/Driver.php";

if(!isset($_SESSION['user']))
	header('Location:../user/login.php');

	$mUser = new User();
	
	if(!isset($_GET['id'])) {
		header("Location:index.php");
		return;
	} 
	$mId = $_GET['id'];
	
	$mDriver = new Driver($mId);
	$mVehicle = new Vehicle($mDriver->getCurrentVehicle());
	
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
		<script src="http://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true&key=AIzaSyBcmYGGYTH1hGEEr31Odpiou8thwx55f_o&sensor=false&libraries=places,geometry,drawing"></script>
		<script type="text/javascript">
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
		<script>
		function fetchLocation(){
			var id = $('#vehicle').val();
			if(id == "") return;
			jQuery.ajax({
					type: 'POST',
					url: '../vehicle/locationInfo.php',
					data: 'id='+ id,
					cache: false,
					success: function(response){
						//alert(response);
						if(response == 0){
						}
						else {
							var location = JSON.parse(response);
							latitude = location.lattitude;
							longitude = location.longitude;
							address = location.address;
							last_updated = location.last_update;
							vehicle_number = location.vehicle_number;
						}
					}
				});
				
			var geocoder = new google.maps.Geocoder();
			var latlng = new google.maps.LatLng(latitude, longitude);
			geocoder.geocode({'location': latlng}, function(results, status) {
				if (status == google.maps.GeocoderStatus.OK) {
					if (results[1]) {
						var formatted_address = results[1].formatted_address;
						document.getElementById("location_view").innerHTML = formatted_address;
					} else {
						console.log('No results found');
					}
				} else {
					console.log('Geocoder failed due to: ' + status);
				}
			});
			//document.getElementById("location_view").innerHTML = address;
			document.getElementById("last_updated").innerHTML = last_updated;
		}
		
		setInterval(function(){ fetchLocation() }, 2000);
		</script>

</head>
	
	<body><div id="body-wrapper"> <!-- Wrapper for the radial gradient background -->
	<?php include('../sidebar.php');?>
		<input type='text' hidden value='<?php echo $mVehicle->getId(); ?>' id='vehicle' name='vehicle'>
		
		<div id="main-content"> <!-- Main Content Section with everything -->
			
			<noscript> <!-- Show a notification if the user has disabled javascript -->
				<div class="notification error png_bg">
					<div>
						Javascript is disabled or is not supported by your browser. Please <a href="http://browsehappy.com/" title="Upgrade to a better browser">upgrade</a> your browser or <a href="http://www.google.com/support/bin/answer.py?answer=23852" title="Enable Javascript in your browser">enable</a> Javascript to navigate the interface properly.
					</div>
				</div>
			</noscript>
			
			<div class="clear"></div> <!-- End .clear -->		

				
				<div  class="content-box-content-detail" style="width:20%;height:88%;float:left;overflow-y:auto">

					
					<div id="personal_info" style="margin:15px 5px 20px 10px">
						<img id="type" height="35" width="35" src="../../res/driver_icon.png" > <span style="vertical-align:10px;"><b style="font-size:25px;"><?php echo $mDriver->getName(); ?> </b>	</span>	
						<br><br><input class="button" type='button' value='Edit'> &nbsp;&nbsp;&nbsp; 
						<br><br><br>
					
						<div id="address_info">
							<img id="address_icon" height="20" width="20" src="../../res/address.png" title="Address" alt="Address">&nbsp;
							<b><span id="address_view" style='vertical-align:2px;'>
								<?php 
								echo $mDriver->getAddress();
								?>
								</span>
							
						</div>
						<br><br>
						<div id="contact_info">
							<img id="contact_icon" height="20" width="20" src="../../res/phone_icon.png" title="Phone" alt="Phone">&nbsp;
							<b><span id="address_view" style='vertical-align:2px;'>
								<?php 
								echo $mDriver->getPhone();
								?>
								</span>
							
						</div>
						<br><br>
						<div id="joining_date_info">
							<img id="joining_date_icon" height="20" width="20" src="../../res/calendar.png" title="Joining Date" alt="Joining Date">&nbsp;
							<b><span id="address_view" style='vertical-align:2px;'>
								<?php 
								echo $mDriver->getJoiningDate();
								?>
								</span>
							
						</div>
					

														
					</div> 
				</div>

				<div class="column-right" style="width:25%;height:88%">				
					<div class="content-box-header">					
						<h3 style="cursor: s-resize;">Current Status</h3>					
					</div> <!-- End .content-box-header -->	
							<br>
							<div id="vehicle_info">
								<?php
									//$mVehicle1 = new Vehicle($mId);
									//echo $mVehicle->getCurrentDriver();
									if($mDriver->getCurrentVehicle() == 0){
								?>									
								<b><img id="driver_icon" height="20" width="20" src="../../res/vehicle_types/Truck.png" title="Vehicle" alt="Vehicle">&nbsp; <span style='vertical-align:5px;'>Click</span> <a class="js-open-modal" href="#" data-modal-id="popup" style="font-size:11px" ><img id="add" height="15" width="15" src="../../res/add.png" title="Add Driver" alt="Add Driver"></a> <span style='vertical-align:5px;'>to assign vehicle</span></b>
								<?php 
									} else{
										echo "<img id='driver_icon' height='20' width='20' src='../../res/vehicle_types/".$mVehicle->getType()."' title='".$mVehicle->getType()."' alt='".$mVehicle->getType()."'>&nbsp; <span style='vertical-align:5px;'><b><a href='../vehicle/detail.php?id=".$mVehicle->getId()."'>".$mVehicle->getVehicleNumber()."</a></b></span>";
								?>				
								&nbsp;&nbsp;&nbsp; 
								<?php    } ?>
							</div>				
							<br>
							<?php 
								if($mDriver->getCurrentVehicle() != 0){
							?>
							<div id="location_info">
								<img id="location_icon" height="15" width="15" src="../../res/location_icon.png" title="Location" alt="Location">&nbsp;
								<b><span id="location_view" style='vertical-align:2px;'>
									Locating...
									</span><br></b>									
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size:9px;vertical-align:2px;">Last updated <b id='last_updated'> -- -- -- </b></span>
									
							</div>	
								<?php } ?>
							
				</div> <!-- End .content-box -->
			<div style="display: block;padding:0px;width:45%;height:93%;overflow-y:auto" class="content-box-content">
					
					<div style="display:block;overflow-y:auto" class="tab-content default-tab" id="item-list">
						<h3 style="cursor: s-resize;">Notifications for <?php echo $mDriver->getName(); ?></h3>
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
			<div class="clear"></div>

			
<?php include("../footer.php")?>
			
		
		</div> <!-- End #main-content -->
		
	</div>
</body></html>