	var vehicle_id;
	
	function setId(id){
		vehicle_id = id;
	}
	
	function fetchNotification(){
		var data = "";
        jQuery.ajax({
            type: 'POST',
            url: '../../../utility/helper/Driver/notification.php?id='+vehicle_id+"&date=today",
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
							document.getElementById("last_updated").innerHTML = last_updated;
						}
					}
				});
		}
		
		setInterval(function(){ fetchLocation() }, 2000);
		
		$(document).ready(fetchNotification);