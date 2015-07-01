<?php
	require_once "../../framework/User.php";
	require_once "../../framework/Vehicle.php";
	require_once "../../framework/Job.php";
	require_once "../../framework/Driver.php";

header("Access-Control-Allow-Origin: *");

if(!isset($_SESSION['user']))
	header('Location:../user/login.php');

	$mUser = new User();
	
	$mDriverList = $mUser->getAvailableDriverList();
	
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
		  <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
	<script src="http://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true&key=AIzaSyBcmYGGYTH1hGEEr31Odpiou8thwx55f_o&sensor=false&libraries=places,geometry,drawing"></script>
	<!--<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places,geometry,drawing"></script>-->

  <!--  //modal box jquery -->
    <link rel="stylesheet"  href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    
	<script>
	
	function setDriver(id, driver_id){
		//alert(id+" "+driver_id);
        jQuery.ajax({
            type: 'POST',
            url: 'action.php?action=set_driver&id='+ id + '&driverid='+driver_id,
            cache: false,
            success: function(response){
				//alert(response);
                if(response == 1){
					$('#driver_info').load(document.URL +  ' #driver_info');
					//$('#driver_form_div').load(document.URL +  ' #driver_form_div');
					
					if(driver_id == 0) {
						alert("Driver removed successfully!!!");
					}else {
						closeModal();
						alert("Driver updated successfully!!!");   
					}
                }
                else {
					alert("Some problem occured!!!");					
                }
            }
        });
        
        $('#driver_form_div').dialog('close');
	}

	$(document).ready(function() {
		$("#from_date, #to_date").datepicker({
		  changeMonth: true,
		  changeYear: true
		});
		$( "#from_date").datepicker( "option", "yyyy-mm-dd", $( this ).val());
		$( "#to_date").datepicker( "option", "yyyy-mm-dd", $( this ).val());
	});
	

    //defining map properties    
    
        
    //declaring map variable
    var map;
        
    //declaring markers and content variables
    var marker;
	var track_marker;
    var contentString;
	
	var trace;
        
    //declaring location elements
    var latitude = 0;
    var longitude = 0;
    var address = "Loading...";
    var last_updated = "";
    var vehicle_number = "";
	var isMoved = false;
	
	var pathValues = [];
	var polylines = [];
	var snappedPolyline;
	
	var API_KEY = "AIzaSyCz-2M1YhnS8ee4O9W1da15dXpSNIN7oqs";
        
    function clearMap(){
		if(marker != null)
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
		document.getElementById("last_updated").innerHTML = last_updated;		
	}
        
    function updateMarker(isMoved){
      fetchLocation();
      clearMap();
      addMarker();
/*	  if(isMoved){
		  locatePosition();
		  isMoved=false;
	  }*/
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
    
    function addTrack(nlat, nlong, naddress, nlastupdated){
		track_marker=new google.maps.Marker({
			position:new google.maps.LatLng(nlat, nlong),
			title:nlastupdated,
			icon:'/navigator/res/route.png'
		});	  
		track_marker.setMap(map);
    }
	
	function sleep(milliseconds) {
		var start = new Date().getTime();
		for (var i = 0; i < 1e7; i++) {
			if ((new Date().getTime() - start) > milliseconds){
				break;
			}
		}
	}	
    
    function showTrack(id){
		if(track_marker != null){
			alert("clearing map 1");
			track_marker.setMap(null);
		}
		if(snappedPolyline != null){
			alert("clearing map 2");
			snappedPolyline.setMap(null);
		}
        var start = $('#from_date').val();
        var end = $('#to_date').val();
		//alert(start + " "+ end);
        if(start=="" && end=="") {
            alert("Enter start and end date.");
            return;
        }
        
        jQuery.ajax({
            type: 'POST',
            url: 'trackInfo.php?id='+ id + '&start=' + start + "&end=" + end,
            cache: false,
            success: function(response){
                if(response == 0){
                }
                else {			
                    trace = JSON.parse(response);
					pathValue = [];
					drawPath(1);
                }
            }
        });
    }
	
	function drawPath(i) {
		console.log(i+", time = "+new Date().getTime());
		if(i == trace.track.length-1)  return;
		nlat = trace.track[i].lattitude;
		nlong = trace.track[i].longitude;
		naddress = trace.track[i].address;
		nlastupdated = trace.track[i].last_updated;
		addTrack(nlat, nlong, naddress, nlastupdated);
		if(i == 1) {
			map.panTo(track_marker.getPosition());
		}
		
		first = nlat+","+nlong;		
		nextlat = trace.track[i+1].lattitude;
		nextlong = trace.track[i+1].longitude;
		next = nextlat+","+nextlong;
		pathPair = first+"|"+next;
		runSnapToRoad(pathPair);
		window.setTimeout(
			function(){
				drawPath(i+1)
			}, 1000);
	}
	
	function createCORSRequest(method, url) {
	  var xhr = new XMLHttpRequest();
	  if ("withCredentials" in xhr) {
		xhr.open(method, url, true);
	  } else if (typeof XDomainRequest != "undefined") {
		xhr = new XDomainRequest();
		xhr.open(method, url);
	  } else {
		xhr = null;
	  }
	  return xhr;
	}

	// Snap a user-created polyline to roads and draw the snapped path
	function runSnapToRoad(path) {
		url = 'https://roads.googleapis.com/v1/snapToRoads?interpolate=true&key='+API_KEY+'&path='+ path;
		//console.log(url);
		var xhr = createCORSRequest('GET', url);
		if (!xhr) {
		  throw new Error('CORS not supported');
		}
		//xhr.withCredentials = true;

		xhr.onload = function() {
		 var responseText = xhr.responseText;
		 //alert(responseText);
		 //console.log(responseText);
		 var pathTrace = JSON.parse(responseText);
		 processSnapToRoadResponse(pathTrace);
		 drawSnappedPolyline();
		 // process the response.
		};

		xhr.onerror = function() {
		  console.log('There was an error!');
		};
		
		xhr.send();
	}

	// Store snapped polyline returned by the snap-to-road method.
	function processSnapToRoadResponse(data) {
		snappedCoordinates = [];
		placeIdArray = [];
		//console.log(data.snappedPoints.length);
		for (var i = 0; i < data.snappedPoints.length; i++) {
			var latlng = new google.maps.LatLng(
			data.snappedPoints[i].location.latitude,
			data.snappedPoints[i].location.longitude);
			snappedCoordinates.push(latlng);
			placeIdArray.push(data.snappedPoints[i].placeId);
		}
	}
	


	// Draws the snapped polyline (after processing snap-to-road response).
	function drawSnappedPolyline() {
		
		var lineSymbol = {
			path: google.maps.SymbolPath.FORWARD_CLOSED_ARROW
		};
		snappedPolyline = new google.maps.Polyline({
			path: snappedCoordinates,
			strokeColor: 'blue',
			strokeWeight: 5,
			icons: [{
				icon: lineSymbol,
				offset: '100%'
			}],
		});
		
		//snappedPolyline.setMap(null);
		//polylines.push(snappedPolyline);
		var track = new google.maps.DirectionsService(),snappedPolyline,snap_path1=[];
		snappedPolyline.setMap(map);
		for(j=0;j<snappedCoordinates.length-1;j++){
			track.route({origin: snappedCoordinates[j],destination: snappedCoordinates[j+1],travelMode: google.maps.DirectionsTravelMode.DRIVING},function(result, status) {
				if(status == google.maps.DirectionsStatus.OK) {
					snap_path1 = snap_path1.concat(result.routes[0].overview_path);
					snappedPolyline.setPath(snap_path1);
				} else {
					console.log("Directions request failed: "+status);  
				}      
			});
		}
		
		//animateArrow();
		
	}

	// Use the DOM setInterval() function to change the offset of the symbol
	// at fixed intervals.
	function animateArrow() {
		var count = 0;
		window.setInterval(function() {
			count = (count + 1) % 200;

			var icons = snappedPolyline.get('icons');
			icons[0].offset = (count / 2) + '%';
			snappedPolyline.set('icons', icons);
		}, 20);
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
/*      window.setTimeout(function() {
         updateMarker(false);
		 //alert();
		 map.panTo(marker.getPosition());
      }, 1000);*/
	  
	  
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
									<span style="font-size:9px">Last updated <b id='last_updated'> -- -- -- </b></span><br><br>
									<input type="button" value="Locate" onClick="locatePosition()">
								</div> <!-- End #tab3 -->        
								
							</div>
						</div>

<!-- //Modal Box Functionality  -->
<script>
function OpenModal()
{
 $("#driver_form_div" ).dialog({
   width: 460,
      show: {
        effect: "blind",
        duration: 1000
      },
      hide: {
        effect: "clip",
        duration: 500
      }
    });
}

function closeModal()
{
 $("#driver_form_div" ).dialog({
   width: 0,
/*      show: {
        effect: "blind",
        duration: 1000
      },
      hide: {
        effect: "clip",
        duration: 500
      */
    });
}
</script>
 <style>
#driver_form_div ul {
	list-style-type: none;
	margin: 20px 0px 0px;
	padding: 0;
}
 
#driver_form_div li {
  font: 200 20px/1.5 Helvetica, Verdana, sans-serif;
  border-bottom: 1px solid #ccc;
}
 
#driver_form_div li:last-child {
  border: none;
}
 
#driver_form_div li a {
  text-decoration: none;
  color: #000;
  display: block;
  width: 100%;
  padding-top: 10px;
    
  -webkit-transition: font-size 0.3s ease, background-color 0.3s ease;
  -moz-transition: font-size 0.3s ease, background-color 0.3s ease;
  -o-transition: font-size 0.3s ease, background-color 0.3s ease;
  -ms-transition: font-size 0.3s ease, background-color 0.3s ease;
  transition: font-size 0.3s ease, background-color 0.3s ease;
}
 
#driver_form_div li a:hover {
  
  background: #f6f6f6;
  
}
</style>

						<div id="driver_form_div" title="Select Driver ( <?php  echo sizeof($mDriverList);?> )" style="display:none;" width='60%'>
						
							<!--Driver Count : <?php  echo sizeof($mDriverList);?>-->
						   <ul>
							<?php
								for($i=0; $i<sizeof($mDriverList); $i++){
									$mDriver = new Driver($mDriverList[$i]);
									echo "<li><a href='#' onClick='setDriver(".$mVehicle->getId().",".$mDriver->getId().")'>".$mDriver->getName()."</a></li>";
								}
							?>
						  </ul>  
					   
						</div>
						
						<div class="content-box" style="margin:5px 5px 5px 5px" id="driver_info_block">
							<div style="display: block;" class="content-box-content-no-border">
						
								<div style="display: block;" class="tab-content default-tab" id="driver_info">
									<b> Current Driver : </b><br><br>
                                    <?php
										$mDriverList = $mUser->getAvailableDriverList();
										$mVehicle1 = new Vehicle($mId);
                                        //echo $mVehicle->getCurrentDriver();
                                        if($mVehicle1->getCurrentDriver() == 0){
                                    ?>
                                            <div id="driver_view">
                                            No Driver Set!!!
                                            </div><br>
                                            <a href="#" style="font-size:11px" onClick="OpenModal();">Assign driver</a>
                                    <?php } else{
                                            $mDriver = new Driver($mVehicle1->getCurrentDriver());
                                            ?>
                                            <div id="driver_view">
                                             <?php echo $mDriver->getName();?>
                                            </div><br>
                                            <a href="#" style="font-size:11px" onClick="setDriver(<?php echo $mVehicle->getId();?>, 0);">Remove Driver</a>
                                    <?php    } ?>

								</div>        
								
							</div>
						</div>
						
						<div class="content-box" style="margin:5px 5px 5px 5px" id="alert_block">
							<div style="display: block;" class="content-box-content-no-border">
						
								<div style="display: block;" class="tab-content default-tab">
									<b> Track Vehicle Path : </b><br><br>
									
									<table>
									<tr><td style="width:20px;padding:7px;">From</td><td><input type='text' id='from_date'> <br></td></tr>
									<tr><td style="width:20px;padding:7px;">To</td><td> <input type='text' id='to_date'> <br></td></tr>
									<tr><td colspan='2' style="width:20px;padding:7px;"><input type="submit" value="Show Route" onClick="showTrack(<?php echo $mId; ?>)"><td><tr>
									</table>
									
									
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