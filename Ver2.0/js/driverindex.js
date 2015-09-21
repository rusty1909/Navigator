	function onDelete(id){
		if(confirm("You really want to delete this vehicle?"))
			window.location.href = "../../../utility/helper/Driver/DriverActionHelper.php?action=delete&id="+id;
	}
	
	function fetchNotification(){
		//alert(id+" "+driver_id);
		var data = "";
        jQuery.ajax({
            type: 'POST',
            url: '../../../utility/helper/Driver/notification.php',
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
						data += "<tr style='background:#fff;border-bottom: 1px solid #ddd;'><td ><img height='20' width='20' src='../../../images/"+image+".png' title='Location' alt='Location'></td><td style='padding:10px;line-height:1em;vertical-align:12px;'><span style='vertical-align:5px;'>"+notiList[i].string+"</span></td></tr>";
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

	$(document).ready(function() {
		$("#date_join").datepicker({
		  changeMonth: true,
		  changeYear: true
		});
		$( "#from_date").datepicker( "option", "yyyy-mm-dd", $( this ).val());
		$( "#to_date").datepicker( "option", "yyyy-mm-dd", $( this ).val());
	});

$(document).ready(fetchNotification);