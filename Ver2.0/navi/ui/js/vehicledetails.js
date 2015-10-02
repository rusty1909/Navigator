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
            url: '../../../utility/helper/Vehicle/notification.php?id='+vehicle_id+"&date=today",
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
						data += "<tr style='background:#fff;border-bottom: 1px solid #ddd;'><td ><img height='20' width='20' src='../../../images/"+image+".png' title='Location' alt='Location'></td><td style='padding:10px;line-height:1em;vertical-align:12px;'><span style='vertical-align:5px;'>"+notiList[i].string+"</span></td></tr>";
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
		jQuery.ajax({
            type: 'POST',
            url: '../../../utility/helper/Vehicle/VehicleActionHelper.php?action=set_driver&id='+ id + '&driverid='+driver_id,
            cache: false,
            success: function(response){
				//alert(response);
                if(response == 1){
					$('#driver_info').load(document.URL +  ' #driver_info');
					//$('#driver_form_div').load(document.URL +  ' #driver_form_div');
					sendGCMUpdates("DRIVER_INFO", gcmKey);
					if(driver_id == 0) {
						location.reload(true);
						alert("Driver removed successfully!!!");
					}else {
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
	
    var map;
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
					url: '../../../utility/helper/Vehicle/locationInfo.php',
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
			icon:'../../../images/route.png'
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
            url: '../../../utility/helper/Vehicle/trackInfo.php?id='+ id + '&start=' + start + "&end=" + end,
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
			document.getElementById("distance").innerHTML = "Distance travelled : "+distance+" KM&nbsp;<a href='#' onClick='reload()'><img id='add' height='15' width='15' src='../../../images/delete.png' title='Clear' alt='Clear' ></a>";
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
	  
	}
        
	google.maps.event.addDomListener(window, 'load', initialize);
        
    var updates = setInterval(function(){ updateMarker(true) }, 2000);

    $(document).ready(fetchNotification);