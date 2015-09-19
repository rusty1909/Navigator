$(document).ready(function(){
			$('#name').blur(checkCompanyname); //use keyup,blur, or change
		});
		function checkCompanyname(){
			var name = $('#name').val();
			if(name == "") return;
			jQuery.ajax({
					type: 'POST',
					url: 'checkDuplicates.php',
					data: 'name='+ name,
					cache: false,
					success: function(response){
						if(response == 0){
							document.getElementById("name_error").innerHTML = "";
							document.getElementById("name_success").innerHTML = "<b>available ! ! !<b>";
						}
						else {
							document.getElementById("name").value = "";
							document.getElementById("name_success").innerHTML = "";
							document.getElementById("name_error").innerHTML = "<b><i>'"+name+"'</i></b>  already exists!";	
						}
					}
				});
		}
		
		$(document).ready(function(){
			$('#tin_number').blur(checkTIN); //use keyup,blur, or change
		});
		function checkTIN(){
			var tin = $('#tin_number').val();
			if(tin == "") return;
			jQuery.ajax({
					type: 'POST',
					url: 'checkDuplicates.php',
					data: 'tin='+ tin,
					cache: false,
					success: function(response){
						if(response == 0){
							document.getElementById("tin_error").innerHTML = "";
							document.getElementById("tin_success").innerHTML = "<b>available ! ! !<b>";
						}
						else {
							document.getElementById("tin_number").value = "";
							document.getElementById("tin_success").innerHTML = "";
							document.getElementById("tin_error").innerHTML = "<b><i>'"+tin+"'</i></b>  already exists!";	
						}
					}
				});
		}
		
/*		function checkForName(name) {
			//var exists = f;
			if(name=="") return;
			if(name=="rusty"){
				document.getElementById("name").value = "";
				document.getElementById("name_success").innerHTML = "";
				document.getElementById("name_error").innerHTML = "<b><i>'"+name+"'</i></b>  already exists!";			
			} else {
				document.getElementById("name_error").innerHTML = "";
				document.getElementById("name_success").innerHTML = "<b>available ! ! !<b>";
			}
		}
*/
/*		function checkForTIN(tin) {
			if(tin=="") return;
			//var exists = f;
			if(tin=="rusty"){
				document.getElementById("tin_number").value = "";
				document.getElementById("tin_success").innerHTML = "";
				document.getElementById("tin_error").innerHTML = "<b><i>'"+tin+"'</i></b>  already exists!";			
			} else {
				document.getElementById("tin_error").innerHTML = "";
				document.getElementById("tin_success").innerHTML = "<b>available ! ! !<b>";
			}
		}
*/		
        function validate(){
			var name = document.getElementById("name").value;
			var tin = document.getElementById("tin_number").value;
			var address1 = document.getElementById("address_1").value;
			var city = document.getElementById("city").value;
			var state = document.getElementById("state").value;
			var pin = document.getElementById("pincode").value;
			var phone = document.getElementById("phone").value;
			
			/*if(re!=pass) {
				alert("Passwords do not match!!!");
				return false;
			} else {*/			
				if(name=="" || tin=="" || address1=="" || state=="" || city=="" || pin=="" || phone=="") {
					alert("Please fill all mandatory details");
					return false;
				} else {
					return true;
				}
			//}
		}