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
	
	$mVehicle = new Vehicle($mId);
	
	$mLat=$mVehicle->getLat();
	$mLong=$mVehicle->getLong();
	$address = "Address";//trim($mVehicle->getAddress());
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
	<script src="http://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true&key=AIzaSyBcmYGGYTH1hGEEr31Odpiou8thwx55f_o"></script>
	<script>
    //defining map properties    
    
        
    //declaring map variable
    var map;
        
    //declaring markers and content variables
    var marker;
    var contentString;
        
    //declaring location elements
    var latitude = 0;
    var longitude = 0;
    var address = "Loading...";
    var last_updated = "";
    var vehicle_number = "";
	var isMoved = false;
        
    function clearMap(){
        marker.setMap(null);
    }
        
    function fetchLocation(){
        var id = $('#id_value').val();
			if(id == "") return;
			jQuery.ajax({
					type: 'POST',
					url: 'locationInfo.php',
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
    }
	
	function updateAddressView(address){
		document.getElementById("address_view").innerHTML = address;
	}
        
    function updateMarker(isMoved){
      fetchLocation();
      clearMap();
      addMarker();
	  if(isMoved){
		  locatePosition();
		  isMoved=false;
	  }
	  updateAddressView(address);
    }
	
	function locatePosition(){
		map.panTo(marker.getPosition());
	}
        
    function addMarker(){
      marker=new google.maps.Marker({
          position:new google.maps.LatLng(latitude, longitude),
          title:vehicle_number
	  });
	  marker.setAnimation(google.maps.Animation.BOUNCE);
      //map.panTo(marker.getPosition());
	  marker.setMap(map);
	  
	  contentString = '<div id="content">'+
		  '<div id="siteNotice">'+
		  '</div>'+
		  '<h1 id="firstHeading" class="firstHeading">Vehicle Number</h1>'+
		  '<div id="bodyContent">'+
		  '<p><b>address</b></p>'+
		  '<p>(last updated at lat_updated)</p>'+
		  '</div>'+
		  '</div>';
        
        //alert(contentString);
    }
        
        
        
	function initialize() {
      fetchLocation();
      var mapProp = {
		center:new google.maps.LatLng(<?php echo $mLat.", ".$mLong; ?>),
		zoom:13,
		mapTypeId:google.maps.MapTypeId.ROADMAP
	  };
      map=new google.maps.Map(document.getElementById("googleMap"),mapProp);        
      addMarker();
	  
	  var infowindow = new google.maps.InfoWindow({
		  content: contentString
	  }); 

	  google.maps.event.addListener(marker, 'click', function() {
        alert(contentString);
		infowindow.open(map,marker);
	  });
      window.setTimeout(function() {
         updateMarker(false);
		 //alert();
		 map.panTo(marker.getPosition());
      }, 1000);
	  
	}
        
	google.maps.event.addDomListener(window, 'load', initialize);
        
    var updates = setInterval(function(){ updateMarker(true) }, 2000);
	</script>
</head>
  
	<body><div id="body-wrapper"> <!-- Wrapper for the radial gradient background -->
		<input type=hidden value="<?php echo $mId; ?>" id="id_value">
	<?php include('../sidebar.php');?>
		
		<div id="main-content-map"> <!-- Main Content Section with everything -->
			
			<noscript> <!-- Show a notification if the user has disabled javascript -->
				<div class="notification error png_bg">
					<div>
						Javascript is disabled or is not supported by your browser. Please <a href="http://browsehappy.com/" title="Upgrade to a better browser">upgrade</a> your browser or <a href="http://www.google.com/support/bin/answer.py?answer=23852" title="Enable Javascript in your browser">enable</a> Javascript to navigate the interface properly.
					</div>
				</div>
			</noscript>
			
			<div class="clear"></div> <!-- End .clear -->
			

			<div class="clear"></div>
			
			<div class="content-box" style="margin: 0 0 0 0;padding: 0 0 0 0;border:0px"><!-- Start Content Box -->
				

				
				<div class="content-box-content-map" style="padding:0;width:100%">
					
					
					<div style="display: block; " class="tab-content default-tab" id="map" style="width:100%;height:100%;"> <!-- This is the target div. id must match the href of this div's tab -->
					<?php
					if(!$mVehicle->isDeployed()) {
							echo "<div class='notification information png_bg' style='width:50%;float:left;margin:10px 10px 10px 10px;'><div>Tracking device has been installed yet.</div></div> ";
					} else {
						if($mVehicle->getAddress()==null) {
							echo "<div class='notification attention png_bg' style='width:50%;float:left;margin:10px 10px 10px 10px;'><div>Could not find location at this moment, Please be patient and be with us.</div></div> ";
						} else {
							//echo $mVehicle->getAddress();
					?>
					<div id="googleMap" style="width:70%;height:100%;float:left;"></div>
					<?php
						}
					}
					?>
					<div class="content-box-content-detail" style="width:30%;height:100%;float:right;overflow-y:auto">
					
						<div id="vehicle_number" style="margin:15px 5px 20px 5px">
						<b style="font-size:30px"><?php echo $mVehicle->getVehicleNumber(); ?> </b>
						<span style="font-size:12px">(<?php echo $mVehicle->getType();?>)</span>	
						<br><br><input type='button' value='View full details'> &nbsp;&nbsp;&nbsp; <input type='button' value='Notifications'>					
						</div>
						
					 
					
						<div class="content-box" style="margin:5px 5px 5px 5px" id="address_block">
							<div style="display: block;" class="content-box-content-no-border">
						
								<div style="display: block;" class="tab-content default-tab">
									<b> Current Location : </b><br><br>
									<div id="address_view">
									Locating...
									</div><br>
									<input type="button" value="Locate" onClick="locatePosition()">
								</div> <!-- End #tab3 -->        
								
							</div>
						</div>
						
						<div class="content-box" style="margin:5px 5px 5px 5px" id="driver_info_block">
							<div style="display: block;" class="content-box-content-no-border">
						
								<div style="display: block;" class="tab-content default-tab">
									<b> Current Driver : </b><br><br>
									<div id="driver_view">
									Locating...
									</div><br>
									<a href="#" style="font-size:11px">Assign driver</a>
								</div>        
								
							</div>
						</div>
						
						<div class="content-box" style="margin:5px 5px 5px 5px" id="alert_block">
							<div style="display: block;" class="content-box-content-no-border">
						
								<div style="display: block;" class="tab-content default-tab">
									<b> Track Vehicle Path : </b><br><br>
									<form>
									<table>
									<tr><td style="width:20px;padding:7px;">From</td><td><input type='date' id='from_date'> <br></td></tr>
									<tr><td style="width:20px;padding:7px;">To</td><td> <input type='date' id='from_date'> <br></td></tr>
									<tr><td colspan='2' style="width:20px;padding:7px;"><input type="submit" value="Show Route" onClick="locatePosition()"><tr><td>
									</table>
									</form>
									
								</div>      
								
							</div>
						</div>
						
						<div class="content-box" style="margin:5px 5px 5px 5px" id="latest_news_block">
							<div style="display: block;" class="content-box-content-no-border">
						
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
								
							</div>
						</div>
						
					</div> 
					</div>
					
					<!-- End #map -->

					
				</div>

				<!-- End .content-box-content -->
				
			</div> <!-- End .content-box -->
			
		</div> <!-- End #main-content -->
		
	</div>
</body></html>