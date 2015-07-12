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
		<!--[if IE]><script type="text/javascript" src="resources/scripts/jquery.bgiframe.js"></script><![endif]-->

		<script>
		$(document).ready(function(){
			$('#username').blur(checkUsername); //use keyup,blur, or change
		});
		function checkUsername(){
			var username = $('#username').val();
			if(username == "") return;
			jQuery.ajax({
					type: 'POST',
					url: 'checkDuplicates.php',
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
					url: 'checkDuplicates.php',
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
		</script>
		
		<style>
		
		.column-right {
		  width: 48%;
		  float: left;
		  margin: auto;
		}
		</style>
	</head>
  
	<body><div id="body-wrapper"> <!-- Wrapper for the radial gradient background -->
		

	<h1 id="sidebar-title"><a href="#">FindGaddi</a></h1>
		  
		<div id="main-content"style="width:45%;float:right;"> <!-- Main Content Section with everything -->
			
			<noscript> <!-- Show a notification if the user has disabled javascript -->
				<div class="notification error png_bg">
					<div>
						Javascript is disabled or is not supported by your browser. Please <a href="http://browsehappy.com/" title="Upgrade to a better browser">upgrade</a> your browser or <a href="http://www.google.com/support/bin/answer.py?answer=23852" title="Enable Javascript in your browser">enable</a> Javascript to navigate the interface properly.
					</div>
				</div>
			</noscript>
			
			<!-- Page Head -->
			<h2>Welcome !!!</h2>
			<p id="page-intro">Please fill the below form to register to Navigator.</p>
			
			<div class="clear"></div> <!-- End .clear -->
			
			<div class="content-box"><!-- Start Content Box -->

				
				<div class="content-box-content-no-border">
					
					<div style="display: block;" class="tab-content default-tab" id="tab2">
					
						<form action="action.php?action=register" method="POST" onSubmit="return validate()">
							
							<fieldset> <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->
								
								<p class="column-left">
									<label>FirstName <span class="mandatory">*</span></label>
									<input class="text-input medium-input" id="firstname" name="firstname" type="text" style="width:95% !important" required placeholder='Rudra'> <!--<span class="input-notification success png_bg">Successful message</span> 
										<br><small>A small description of the field</small>-->
								</p>
								
								<p class="column-right" style="margin: 0 -10px 0 0;">
									<label>LastName</label>
									<input class="text-input medium-input" id="lastname" name="lastname" type="text"  style="width:95% !important" required placeholder='Goyal'> 
								</p>
								
								<p>
									<label>Username <span class="mandatory">*</span></label>
									<input class="text-input medium-input" id="username" name="username" type="text" style="width:45.5% !important" onBlur="checkForUser(this.value)" required placeholder='xyz132'><span class="input-notification error png_bg" id="user_error"></span><span class="input-notification success png_bg" id="user_success"></span>
								</p>

								<p class="column-left">
									<label>Password</label>
									<input class="text-input medium-input" id="password" name="password" type="password" style="width:95% !important" required> <!--<span class="input-notification success png_bg">Successful message</span> 
										<br><small>A small description of the field</small>-->
								</p>
								
								<p class="column-right">
									<label>Re-Type Password </label>
									<input class="text-input medium-input" id="retype" name="retype" type="password"  style="width:95% !important" onBlur="checkPassword()" required><br><span class="input-notification error png_bg" id="pass_error"></span><span class="input-notification success png_bg" id="pass_success"></span>
								</p>

								<p>
									<label>Email <span class="mandatory">*</span></label>
									<input class="text-input medium-input" id="email" name="email" type="email" style="width:45.5% !important" onBlur="checkForEmail(this.value)" required placeholder='xyz@xyz.com'> <span class="input-notification error png_bg" id="email_error"></span><span class="input-notification success png_bg" id="email_success"></span>
								</p>

								<p class="column-left">
									<label>Office Phone</label>
									<input class="text-input medium-input" type="number" id="phone_o" name="phone_o" style="width:95% !important" required placeholder='0123456789'> <!--<span class="input-notification success png_bg">Successful message</span> 
										<br><small>A small description of the field</small>-->
								</p>
								
								<p class="column-right">
									<label>Mobile <span class="mandatory">*</span></label>
									<input class="text-input medium-input" id="phone_m" name="phone_m" type="number"  style="width:95% !important" required placeholder='0123456789'> 
								</p>
								
								<p>
									<input class="button" value="   Register User   " type="submit">
								</p>
								
							</fieldset>
							
							<div class="clear"></div><!-- End .clear -->
							
						</form>
						
					</div> <!-- End #tab2 -->        
					
				</div> <!-- End .content-box-content -->
				
			</div> <!-- End .content-box -->
			<div class="clear"></div>
			
		</div> <!-- End #main-content -->
		<div class="clear"></div>
		<!--<div id="footer" style="width:95%;margin:0 auto;">
			<small>
					© Copyright 2015 FindGaddi  Solutions Pvt Ltd  | <a href="#">Top</a>
			</small>
		</div><! -- End #footer -->
		
	</div>
  

</body></html>