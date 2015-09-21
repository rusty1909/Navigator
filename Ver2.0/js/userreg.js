$(document).ready(function(){
			$('#username').blur(checkUsername); //use keyup,blur, or change
		});
		function checkUsername(){
			var username = $('#username').val();
			if(username == "") return;
			jQuery.ajax({
					type: 'POST',
					url: '../../../utility/helper/User/checkDuplicates.php',
					data: 'username='+ username,
					cache: false,
					success: function(response){
						if(response == 0){
							document.getElementById("user_error").innerHTML = "";
							document.getElementById("user_success").innerHTML = "<b>available ! ! !<b>";
						}
						else {
							document.getElementById("username").value = "";
							document.getElementById("user_success").innerHTML = "";
							document.getElementById("user_error").innerHTML = "<b><i>'"+username+"'</i></b>  already exists!";	
						}
					}
				});
		}

		$(document).ready(function(){
			$('#email').blur(checkEmail); //use keyup,blur, or change
		});
		function checkEmail(){
			var email = $('#email').val();
			if(email == "") return;
			jQuery.ajax({
					type: 'POST',
					url: '../../../utility/helper/User/checkDuplicates.php',
					data: 'email='+ email,
					cache: false,
					success: function(response){
						if(response == 0){
							document.getElementById("email_error").innerHTML = "";
							document.getElementById("email_success").innerHTML = "<b>available ! ! !<b>";
						}
						else {
							document.getElementById("email").value = "";
							document.getElementById("email_success").innerHTML = "";
							document.getElementById("email_error").innerHTML = "<b><i>'"+email+"'</i></b>  already exists!";	
						}
					}
				});
		}

		function checkPassword() {
			var pass = document.getElementById("password").value;
			var retype = document.getElementById("retype").value;
			if(pass!=retype){
				document.getElementById("retype").value = "";
				document.getElementById("pass_success").innerHTML = "";
				document.getElementById("pass_error").innerHTML = "<b>Passwords do not match !</b>";			
			} else {
				document.getElementById("pass_error").innerHTML = "";
				document.getElementById("pass_success").innerHTML = "<b>We have a match ! !</b>";
			}
		}

        function validate(){
			var first = document.getElementById("firstname").value;
			var user = document.getElementById("username").value;
			var pass = document.getElementById("password").value;
			var re = document.getElementById("retype").value;
			var email = document.getElementById("email").value;
			var mobile = document.getElementById("phone_m").value;
			
			if(re!=pass) {
				alert("Passwords do not match!!!");
				return false;
			} else {			
				if(first=="" || user=="" || pass=="" || email=="" || mobile=="" || re=="") {
					alert("Please fill all mandatory details");
					return false;
				} else {
					return true;
				}
			}
		}