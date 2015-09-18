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
		function checkForName(name) {
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

		function checkForTIN(tin) {
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
		</script>
		
	</head>
  
	<body><div id="body-wrapper"> <!-- Wrapper for the radial gradient background -->
		

		<div id="sidebar" style="width:45%;background:#f0f0f0"><div id="sidebar-wrapper"> <!-- Sidebar with logo and menu -->
			
			<h1 id="sidebar-title"><a href="#">FindGaddi</a></h1>
		  
			<!-- Logo (221px wide) -->
			<a href="#"><img id="logo" src="../../res/logo.png" alt="FindGaddi logo"></a>


			
		</div></div> <!-- End #sidebar -->
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
			<p id="page-intro">Please fill your company details to register to Navigator Corporate Account.<br>
			<!--<small>click <a href='../user/login.php'>skip</a> to start using your individual account</small></p>-->
			
			<div class="clear"></div> <!-- End .clear -->
			
			<div class="content-box"><!-- Start Content Box -->

				
				<div class="content-box-content-no-border">
					
					<div style="display: block;" class="tab-content default-tab" id="tab2">
					
						<form action="action.php?action=register" method="POST" onSubmit="return validate()">
							
							<fieldset> <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->
							
								<p>
									<label>CompanyName <span class="mandatory">*</span></label>
									<input class="text-input medium-input" id="name" name="name" type="text" style="width:45.5% !important" onBlur="checkForName(this.value)"> <span class="input-notification error png_bg" id="name_error"></span><span class="input-notification success png_bg" id="name_success"></span>  
								</p>
							
								<p>
									<label>TIN Number <span class="mandatory">*</span></label>
									<input class="text-input medium-input" id="tin_number" name="tin_number" type="text" style="width:45.5% !important" onBlur="checkForTIN(this.value)"> <span class="input-notification error png_bg" id="tin_error"></span><span class="input-notification success png_bg" id="tin_success"></span>  
								</p>
								
								<p>
									<label>Address Line 1 <span class="mandatory">*</span></label>
									<input class="text-input medium-input" id="address_1" name="address_1" type="text" style="width:99.5% !important">
								</p>
							
								<p>
									<label>Address Line 2</label>
									<input class="text-input medium-input" id="address_2" name="address_2" type="text" style="width:99.5% !important">
								</p>
								
								<p class="column-left">
									<label>Landmark </label>
									<input class="text-input medium-input" id="landmark" name="landmark" type="text" style="width:95% !important"> <!--<span class="input-notification success png_bg">Successful message</span> 
										<br><small>A small description of the field</small>-->
								</p>
								
								<p class="column-right" style="margin: 0 -10px 0 0;">
									<label>City <span class="mandatory">*</span></label>
									<input class="text-input medium-input" id="city" name="city" type="text"  style="width:95% !important"> 
								</p>
				
								<p class="column-left">
									<label>State <span class="mandatory">*</span></label>
									<input class="text-input medium-input" id="state" name="state" type="text" style="width:95% !important"> <!--<span class="input-notification success png_bg">Successful message</span> 
										<br><small>A small description of the field</small>-->
								</p>
								
								<p class="column-right" style="margin: 0 -10px 0 0;">
									<label>Pin Code <span class="mandatory">*</span></label>
									<input class="text-input medium-input" id="pincode" name="pincode" type="text"  style="width:95% !important"> 
								</p>

								<p class="column-left">
									<label>Phone <span class="mandatory">*</span></label>
									<input class="text-input medium-input" id="phone" name="phone" type="text" style="width:95% !important"> <!--<span class="input-notification success png_bg">Successful message</span> 
										<br><small>A small description of the field</small>-->
								</p>
								
								<p class="column-right" style="margin: 0 -10px 0 0;" >
									<label>Fax </label>
									<input class="text-input medium-input" id="fax" name="fax" type="text"  style="width:95% !important"> 
								</p>

								<p class="column-left">
									<label>Email</label>
									<input class="text-input medium-input" id="email" name="email" type="email" style="width:95% !important"> <!--<span class="input-notification success png_bg">Successful message</span> 
										<br><small>A small description of the field</small>-->
								</p>
								
								<p class="column-right" style="margin: 0 -10px 0 0;" >
									<label>Website </label>
									<input class="text-input medium-input" id="website" name="website" type="text"  style="width:95% !important"> 
								</p>
								
								<p>
									<input class="button" value="   Register Company   " type="submit">
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
		<div id="footer" style="width:95%;margin:0 auto;">
			<small>
					� Copyright 2015 FindGaddi  Solutions Pvt Ltd  | <a href="#">Top</a>
			</small>
		</div><!-- End #footer -->
		
	</div>
  

</body></html>