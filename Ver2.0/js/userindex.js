	var bill_id;
	function fetchBillDetails(id){
		var data = "";
        jQuery.ajax({
            type: 'POST',
            url: 'action.php?action=billdetail&id='+id,
            cache: false,
            success: function(response){
				if(response == 0){
				}
				else {
					//alert(response)
					bill_id = id;
					var billDetail = JSON.parse(response);
					
					var vehicle_image = '../../res/vehicle_types/'+billDetail.vehicle.type+'.png';
					var vehicle_text = "<img height='18' width='18' src='"+vehicle_image+"'>&nbsp;&nbsp;<b><a href='../vehicle/detail.php?id="+billDetail.vehicle.id+"' style='text-transform:uppercase;vertical-align:2px;' class='js-modal-close'>"+billDetail.vehicle.number+"</a>";					
					document.getElementById("vehicle").innerHTML = vehicle_text;
					
					var driver_image = '../../res/driver_icon.png';
					var driver_text = "<img height='15' width='15' src='"+driver_image+"'>&nbsp;&nbsp;<b><a href='../driver/detail.php?id="+billDetail.driver.id+"' style='text-transform:uppercase;vertical-align:2px;' class='js-modal-close'>"+billDetail.driver.name+"</a>";
					document.getElementById("driver").innerHTML = driver_text;
					
					var bill_image_path = '../../res/bills/'+billDetail.vehicle.number+'/'+billDetail.filename+'.jpg';
					var bill_image_text = "<img width='100' src='"+bill_image_path+"'>";
					document.getElementById("bill_image").innerHTML = bill_image_text;
					
					var reason_image = '../../res/info.png';
					var reason_text = "<img height='18' width='18' src='"+reason_image+"'>&nbsp;&nbsp<b>"+billDetail.reason+"</b>";
					document.getElementById("reason").innerHTML = reason_text;
					
					var amount_image = '../../res/amount.png';
					document.getElementById("amount").innerHTML = "<img height='18' width='18' src='"+amount_image+"'>&nbsp;&nbsp<b>Rs."+billDetail.amount+"</b>";
					
					var calendar_image = '../../res/calendar.png';
					var date_added_text = "<img height='15' width='15' src='"+calendar_image+"'>&nbsp;&nbsp<b>"+billDetail.date_added+"</b>";
					document.getElementById("date_added").innerHTML = date_added_text;
					
					//document.getElementById("latlng").innerHTML = billDetail.location.lat+","+billDetail.location.lng;
					
					updateAddressView(billDetail.location.lat, billDetail.location.lng);
				}
            }
        });
	}
	
	function approveBill(isApproval) {
		jQuery.ajax({
            type: 'POST',
            url: 'action.php?action=billapproval&id='+bill_id+'&approval='+isApproval,
            cache: false,
            success: function(response){
				if(response == 0){
				}
				else {
					if(response=='success'){
						location.reload();
						if(isApproval==1){
							alert("Bill Approved!!!");
						} else {
							alert("Bill Rejected!!!");
						}
					} else{
						alert("some problem occurred");
					}
				}
            }
        });
	}
	
	function updateAddressView(latitude, longitude){
		var geocoder = new google.maps.Geocoder();
		var latlng = new google.maps.LatLng(latitude, longitude);
		geocoder.geocode({'location': latlng}, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				if (results[1]) {
					var formatted_address = results[1].formatted_address;
					var calendar_image = '../../res/location_icon.png';
					document.getElementById("address").innerHTML = "<img height='15' width='15' src='"+calendar_image+"'>&nbsp;&nbsp<b>"+formatted_address+"<br>("+latitude+","+longitude+")</b>";
				} else {
					console.log('No results found');
				}
			} else {
				console.log('Geocoder failed due to: ' + status);
			}
		});
	}
	
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
						//console.log(image);
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