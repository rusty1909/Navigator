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
    
    <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
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
	
	var vehicle_id;
	var API_KEY = "AIzaSyCHqUJxbs3XYWSRTVeSiR6pUILkkzg5vew";
	var gcmKey;
	
	function setId(id){
		vehicle_id = id;
		//alert(vehicle_id);
	}
	
	function setGCMKey(key){
		gcmKey = key;
		//alert(gcmKey);
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
						//console.log(i);
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
					sendGCMUpdates("DRIVER_INFO", gcmKey);
					if(driver_id == 0) {
						/*
						* in case driver is removed, refresh whole page...
						* temp fix
						*/
						location.reload(true);
						alert("Driver removed successfully!!!");
					}else {
						//closeModal();
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

	function sendGCMUpdates(data, key){
        jQuery.ajax({
            type: 'POST',
            url: '../../app/gcmSend.php?regkey='+ key + '&message='+data,
            cache: false,
            success: function(response){
				console.log(response);
            }
        });
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
	
	var distance = 0;
	
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
	
	function updateAddressView(){
		var geocoder = new google.maps.Geocoder();
		var latlng = new google.maps.LatLng(latitude, longitude);
		geocoder.geocode({'location': latlng}, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				if (results[1]) {
					var formatted_address = results[1].formatted_address;
					document.getElementById("address_view").innerHTML = formatted_address;
				} else {
					console.log('No results found');
				}
			} else {
				//console.log('Geocoder failed due to: ' + status);
			}
		});
		
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
	  updateAddressView();
    }
	
	function locatePosition(){
		map.panTo(marker.getPosition());
	}
        
    function addMarker(){
      marker=new google.maps.Marker({
          position:new google.maps.LatLng(latitude, longitude),
          title:vehicle_number
	  });
	  //marker.setAnimation(google.maps.Animation.BOUNCE);
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
			console.log("clearing map 1");
			track_marker.setMap(null);
		}
		if(snappedPolyline != null){
			console.log("clearing map 2");
			snappedPolyline.setMap(null);
		}

        var start = $('#from_date').val();
        var end = $('#to_date').val();
		//alert(start + " "+ end);
        if(start=="" || end=="") {
            alert("Enter start and end date.");
            return;
        }
		document.getElementById("from_date").disabled = true; 
		document.getElementById("to_date").disabled = true; 
        
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
		document.getElementById("distance").innerHTML = "Calculating...";
    }
	
	function reload(){
		document.getElementById("distance").innerHTML="";
		$('#distance').load(document.URL +  ' #distance');
		document.getElementById("from_date").value="";
		document.getElementById("to_date").value="";
		document.getElementById("from_date").disabled = false; 
		document.getElementById("to_date").disabled = false;
		initialize();
		//$('#googleMap').load(document.URL +  ' #googleMap');
	}
	
	function drawPath(i) {
		console.log(i+", time = "+new Date().getTime());
		if(i == trace.track.length-1)  {
			document.getElementById("distance").innerHTML = "Distance travelled : "+distance+" KM&nbsp;<a href='#' onClick='reload()'><img id='add' height='15' width='15' src='../../res/delete.png' title='Clear' alt='Clear' ></a>";
			return;
		}
		nlat = trace.track[i].lattitude;
		nlong = trace.track[i].longitude;
		naddress = trace.track[i].address;
		nlastupdated = trace.track[i].last_updated;
		addTrack(nlat, nlong, naddress, nlastupdated);
		if(i == 1) {
			map.panTo(track_marker.getPosition());
		}
		
		first = nlat+","+nlong;

		var loc_first = new google.maps.LatLng(nlat, nlong);
				
		nextlat = trace.track[i+1].lattitude;
		nextlong = trace.track[i+1].longitude;
		
		var loc_sec = new google.maps.LatLng(nextlat, nextlong);
		
		next = nextlat+","+nextlong;
		pathPair = first+"|"+next;
		runSnapToRoad(pathPair);
		window.setTimeout(
			function(){
				drawPath(i+1)
			}, 1000);
		distance = parseFloat(distance) + parseFloat((google.maps.geometry.spherical.computeDistanceBetween(loc_first, loc_sec) / 1000).toFixed(2));
			
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
			strokeWeight: 3,
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
        //alert(contentString);
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
  
	<body onload='setId(<?php echo $mId?>);fetchNotification();setGCMKey(<?php echo $mVehicle->getGCMKey()?>)'><div id="body-wrapper"> <!-- Wrapper for the radial gradient background -->
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
			
			<div class="content-box" style="margin: 0 0 0 0;padding: 0 0 0 0;border:0px;height:100%px"><!-- Start Content Box -->
				
				<div class="content-box-content-map" style="padding:0;width:100%">
					
					
					<div style="display: block; " class="tab-content default-tab" id="map" style="width:100%;height:100%;"> <!-- This is the target div. id must match the href of this div's tab -->
					<?php
					if(!$mVehicle->isDeployed()) {
							echo "<div class='notification information png_bg' style='width:50%;float:left;margin:10px 10px 10px 10px;'><div>Tracking device has been installed yet.</div></div> ";
					} else {
						if($mVehicle->isLocationAvailable()==null) {
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
					
						<div id="vehicle_details" style="margin:15px 5px 20px 10px">
							<img id="type" height="45" width="45" src="../../res/vehicle_types/<?php echo $mVehicle->getType();?>.png" title="<?php echo $mVehicle->getType()." : ".$mVehicle->getModel();?>" alt="<?php echo $mVehicle->getType();?>"> <span style="vertical-align:12px;"><b style="font-size:30px;"><?php echo $mVehicle->getVehicleNumber(); ?> </b>	</span>	
							<br><br><input class="button" type='button' value='View full details'>
							<br><br><br>
							<div id="location_info">
								<table>
								<tr><td><img id="location_icon" height="15" width="15" src="../../res/location_icon.png" title="Location" alt="Location">&nbsp;</td>
									<td><b><span id="address_view" style='vertical-align:2px;'>
									Locating...
									</span><br></b>									
									<a href="#" style="font-size:11px" onClick="locatePosition()"><img id="add" height="15" width="15" src="../../res/locate.png" title="Locate Vehicle" alt="Locate Vehicle"></a>&nbsp;&nbsp;<span style="font-size:9px;vertical-align:2px;">Last updated <b id='last_updated'> -- -- -- </b></span>
									<!--<input class="button" type="button" value="Locate" onClick="locatePosition()">-->
									</td>
									</tr>
								</table>
							</div>
							<br>
							<div id="driver_info">
								<img id="driver_icon" height="15" width="15" src="../../res/driver_icon.png" title="Driver" alt="Driver">&nbsp;
								<?php
									$mDriverList = $mUser->getAvailableDriverList();
									$mVehicle1 = new Vehicle($mId);
									//echo $mVehicle->getCurrentDriver();
									if($mVehicle1->getCurrentDriver() == 0){
								?>									
								<b><span style='vertical-align:2px;'>Click</span> <a class="js-open-modal" href="#" data-modal-id="popup" style="font-size:11px" ><img id="add" height="15" width="15" src="../../res/add.png" title="Add Driver" alt="Add Driver"></a> <span style='vertical-align:2px;'>to set driver</span></b>
								<?php 
									} else{
										$mDriver = new Driver($mVehicle1->getCurrentDriver());
										echo "<span style='vertical-align:2px;'><b><a href='../driver/detail.php?id=".$mDriver->getId()."'>".$mDriver->getName()."</a></b></span>";
								?>				
								&nbsp;&nbsp;&nbsp; <a href="#" style="font-size:11px" onClick="setDriver(<?php echo $mVehicle->getId();?>, 0);"><img id="add" height="15" width="15" src="../../res/delete.png" title="Remove Driver" alt="Remove Driver"></a>
								<?php    } ?>
							</div>
							<br>
							<!--<img id="track_icon" height="2" width="70%" src="../../res/separator.png">-->
							<br>
							<div id="trace_info">
								<table>
								<tr><td rowspan='3'><img id="track_icon" height="15" width="15" src="../../res/track_icon.png" title="Trace" alt="Trace">&nbsp;</td>									
									<td>&nbsp;<input class="text-input" placeholder="Start Date" type='text' id='from_date' size='8' style="vertical-align:3px;"><br></td>
									<td style="width:25px;"><img height="15" width="15" src="../../res/to_from.png"></td>
									<td><input class="text-input" placeholder="End Date" type='text' id='to_date' size='8' style="vertical-align:3px;"> <br></td></tr>
								<tr><td colspan='3' style="width:20px;padding:7px;"><b><span id="distance" style='vertical-align:2px;'><input class="button" type="submit" value="Show Route" onClick="showTrack(<?php echo $mId; ?>)"></span></b><td><tr>
								</table>
							</div>
						</div>
						<div id="notifications">
							<div class="content-box-header" style="padding:0px;"> <!-- Add the class "closed" to the Content box header to have it closed by default -->
								<h3 style="cursor: s-resize;">Events of the day (<span id='noti_count'></span>)</h3>
							</div> <!-- End .content-box-header -->
							
							<div class="content-box-content" style="display: block;padding:0px;overflow-y:auto;height:46%">
								
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
							</div> <!-- End .content-box-content -->
						</div>						
					</div> 
					</div>
					
					<!-- End #map -->

					
				</div>

				<!-- End .content-box-content -->
				
			</div> <!-- End .content-box -->
			
		</div> <!-- End #main-content -->
		
	</div>

	<!-- //Modal Box Functionality  -->
	<script>
	$(document).ready(function () {
		//$('#dialog').dialog(); 
		console.log("clicked");
		$('#dialog_link').click(function () {
			$('#dialog').dialog('open');
			return false;
		});
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
		top: ($(window).height() - $(".modal-box").outerHeight()) / 2,
		left: ($(window).width() - $(".modal-box").outerWidth()) / 2
	  });
	});
	 
	$(window).resize();
	 
	});
	</script>

	<div id="popup" class="modal-box">  
	  <header>
		<h3>Select Driver</h3>
	  </header>
	  <div class="modal-body" id="item-list">
	  
		<table><tbody>
			<?php
				for($i=0; $i<sizeof($mDriverList); $i++){
					$mDriver = new Driver($mDriverList[$i]);
					echo "<tr><td><img height='15' width='15' src='../../res/driver_icon.png'>&nbsp;&nbsp;<b><a href='#' style='text-transform:uppercase;vertical-align:2px;' class='js-modal-close' onClick='setDriver(".$mVehicle->getId().",".$mDriver->getId().")'>".$mDriver->getName()."</a><span style='float:right;'><img height='20' width='20' src='../../res/phone_icon.png'><span style='vertical-align:5px;'>+91-".$mDriver->getPhone()."</span></span></b></td></tr>";
				}
			?>
		</tbody></table>
		
	  </div>
	  <footer>
		<a href="#" class="js-modal-close" style="color:#D3402B"><b>CANCEL</b></a>
	  </footer>
	</div>
</body></html>