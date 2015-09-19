
	function fetchNotification(){
		//alert(id+" "+driver_id);
		var data = "";
        jQuery.ajax({
            type: 'POST',
            url: 'timeline.php',
            cache: false,
            success: function(response){
				if(response == 0){
				}
				else {					
					var notiList = JSON.parse(response);
					for(var i=0; i<50 && i<notiList.length; i++){
						var image = notiList[i].image;
						data += "<tr style='background:#fff;border-bottom: 1px solid #ddd;'><td ><img height='20' width='20' src='../../res/"+image+".png' title='Location' alt='Location'></td><td style='padding:10px;line-height:1em;vertical-align:12px;'><span style='vertical-align:5px;'>"+notiList[i].string+"</span></td></tr>";
						console.log(image);
					}
					//alert(data);
					document.getElementById("timeline_body").innerHTML = data;
					//$("#noti_table").find("tbody").find('#main-content table').;
					data="";
				}
            }
        }); 
	}
	
	var notificationUpdates = setInterval(function(){ fetchNotification() }, 2000);
		
		$(document).ready(function(){
			$('#emp_id').blur(checkEmpID); //use keyup,blur, or change
		});
            
		function checkEmpID(){
			var tin = $('#emp_id').val();
			if(tin == "") return;
			jQuery.ajax({
					type: 'POST',
					url: 'checkDuplicates.php',
					data: 'emp_id='+ tin,
					cache: false,
					success: function(response){
						if(response == 0){
							document.getElementById("emp_id_error").innerHTML = "";
							document.getElementById("emp_id_success").innerHTML = "<b>available ! ! !<b>";
						}
						else {
							document.getElementById("emp_id").value = "";
							document.getElementById("emp_id_success").innerHTML = "";
							document.getElementById("emp_id_error").innerHTML = "<b><i>'"+tin+"'</i></b>  already exists!";	
						}
					}
				});
		}
		
	
        function validate(){
			var name = document.getElementById("name").value;
			var tin = document.getElementById("emp_id").value;
			var address1 = document.getElementById("address_1").value;
			var city = document.getElementById("city").value;
			var state = document.getElementById("state").value;
			var pin = document.getElementById("pincode").value;
			var phone = document.getElementById("phone").value;
						
            if(name=="" || tin=="" || address1=="" || state=="" || city=="" || pin=="" || phone=="") {
                alert("Please fill all mandatory details");
                return false;
            } else {
                return true;
            }

		}
		
		$("#edit_button").click(function(){
			alert("clock");
			$("#basic").hide();
			$("#edit").show();
		});

	$(document).ready(fetchNotification);