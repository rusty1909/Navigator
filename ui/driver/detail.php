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

	  <!--  //modal box jquery -->
		<link rel="stylesheet"  href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
		<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
		<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
		<script>
	var vehicle_id;
	
	function setId(id){
		vehicle_id = id;
		//alert(vehicle_id);
	}
	
	function fetchNotification(){
		var data = "";
        jQuery.ajax({
            type: 'POST',
            url: 'notification.php?id='+vehicle_id+"&date=today",
            cache: false,
            success: function(response){
				if(response == 0){
				}
				else {					
					var notiList = JSON.parse(response);
					for(var i=0; i<notiList.length; i++){
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
						console.log(i);
					}
					//alert(data);
					document.getElementById("noti_body").innerHTML = data;
					document.getElementById("noti_count").innerHTML = notiList.length;
					//$("#noti_table").find("tbody").find('#main-content table').;
					data="";
				}
            }
        });
       
        
	}
	
	var notificationUpdates = setInterval(function(){ fetchNotification() }, 2000);

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
					}
				});
		}
		
		setInterval(function(){ fetchLocation() }, 2000);
		
		</script>
		<script>

/* modal box display */
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
		</script>

</head>
	
	<body onload='setId(<?php echo $mId?>);fetchNotification();'><div id="body-wrapper"> <!-- Wrapper for the radial gradient background -->
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
			
			<div class="content-box column-left" style="width:63%;max-height:88%">				
				<div class="content-box-header">
					
					<h3 style="cursor: s-resize;"><?php echo $mDriver->getName(); ?></h3>
					
					<ul class="content-box-tabs">
						<li><a href="#info" <?php if(!isset($_GET['page'])) echo "class='default-tab current'" ?>>Basic Information</a></li> <!-- href must be unique and match the id of target div -->
						<li><a href="#previous_jobs">Previous Jobs</a></li>
						<li><a href="#payment">Payments</a></li>						
						
					</ul>
					
					<div class="clear"></div>
					
				</div>
				<div class="content-box-content">
					<div style="display: block;" class="tab-content <?php if(!isset($_GET['page'])) echo " default-tab" ?>" id="info">
						<div id="basic">
							<form action="edit.php"><fieldset>
								<p class="column-left">
									<a class="button" class='js-open-modal' href='#' data-modal-id='edit-popup' >Edit Info</a>
									<br><br>
									<img id="address_icon" height="20" width="20" src="../../res/address.png" title="Address" alt="Address">&nbsp;
									<b><span id="address_view" style='vertical-align:2px;'>
										<?php 
										echo $mDriver->getAddress();
										?>
										</span></b>
									<br><br>
									<img id="contact_icon" height="20" width="20" src="../../res/phone_icon.png" title="Phone" alt="Phone">&nbsp;
									<b><span id="address_view" style='vertical-align:2px;'>
										<?php 
										echo $mDriver->getPhone();
										?>
										</span></b>
									<br><br>
									<img id="joining_date_icon" height="20" width="20" src="../../res/calendar.png" title="Joining Date" alt="Joining Date">&nbsp;
									<b><span id="address_view" style='vertical-align:2px;'>
										<?php 
										echo $mDriver->getJoiningDate();
										?>
										</span></b>
								</p>

								
								<p class="column-right">

								</p>
								
								
							</fieldset></form>
						</div>
						
					</div>
					                    
                   <div style="display: block;" class="tab-content" id="previous_jobs">	
                       
						
					</div> <!-- End #prev -->
                
                
                    
                    <div style="display: block;" class="tab-content" id="payment">					
						<p>
                        
                        Make Payments and keep using the findgaddi services.
                        </p>
					</div> <!-- End #tab3 -->
				</div> <!-- End .content-box-content -->				
			</div> <!-- End .content-box -->
			<div style="float:right;width:35%;height:88%;">
				<div class="content-box column-right" style="width:100%;height:30%;">
					<div class="content-box-header"> <!-- Add the class "closed" to the Content box header to have it closed by default -->
						<h3 style="cursor: s-resize;">Current Location</h3>
					</div> <!-- End .content-box-header -->
					
					<div style="display: block;padding:10px;" class="content-box-content">
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
					</div> <!-- End .content-box-content -->
					
				</div>
				<div class="clear"></div>
				<div class="content-box column-right" style="width:100%;height:66%;">
					<div class="content-box-header"> <!-- Add the class "closed" to the Content box header to have it closed by default -->
						<h3 style="cursor: s-resize;">Events of the day (<span id='noti_count'></span>)</h3>
					</div> <!-- End .content-box-header -->
					
					<div style="display: block;padding:0px;height:93%;overflow-y:auto" class="content-box-content">
						
						<div style="display:block;overflow-y:auto" class="tab-content default-tab" id="item-list">
						
							<div style="display:block;" class="tab-content default-tab" id="item-list">
								
									<table id="noti_table">
									<thead>
									<tr></tr>
									</thead>
									<tbody style="border-bottom:0px" id="noti_body">
									<tr><td><b>Loading Notifications</b></td></tr>
									</tbody>
									</table>
								</div> <!-- End #tab3 -->  
						</div> <!-- End #tab3 -->  
					</div> <!-- End .content-box-content -->
					
				</div>
			</div>

			<div class="clear"></div>
			
			<!-- End Notifications -->
			
<?php include("../footer.php")?>
			
		</div> <!-- End #main-content -->
		
	</div>

            <!-- //////////////// POP UP Box for adding employee-->
    <div id="edit-popup" class="modal-box" style="width:50%;">  
				<header>
			<h3><?php echo $mDriver->getName(); ?></h3>
		</header>
		<div class="modal-body" id="item-list">
			<form action="action.php?action=update" method="POST">
				<input hidden type="text" value="<?php echo $mDriver->getId(); ?>" name="id">
				<fieldset> <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->
												
					<p class="column-left">
						<label>Name</label>
							<input class="text-input medium-input" id="name" name="name" disabled value="<?php echo $mDriver->getName(); ?>" type="text" required placeholder='Rudra XYZ'> 
					</p>
					
					<p class="column-right">
						<label>Phone</label>
							<b>+91- </b><input class="text-input medium-input" name="phone" value="<?php echo $mDriver->getPhone(); ?>" id="phone" type="text" maxlength="10" required placeholder='0123456789' min='1000000000' max='9999999999'> 
					</p>

					<p>
						<label>Address</label>
							<textarea name="address" id="address" required placeholder="House #12 , mayur vihar , new delhi"><?php echo $mDriver->getAddress(); ?></textarea>
					</p>

					<p>
						<label>Description</label>
						<input class="text-input large-input" name="description" id="description" value="<?php echo $mDriver->getDescription(); ?>" type="text" required placeholder="I was working in this company or having much experience.">
						<br><small>A small description of the driver which will help in identifying the driver with ease.</small>
					</p>
				
					<p class="column-left">
						<label>Joining Date</label>
							<input class="text-input medium-input" id="date_join" disabled value="<?php echo $mDriver->getJoiningDate(); ?>" name="date_join" type="text" required> 
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