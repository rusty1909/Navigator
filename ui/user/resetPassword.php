<?php

if(!empty($_POST)){
    
require_once '../../../framework/User.php';
    
    if(empty($_POST['id']))
        $id = $_GET['id'];
    else
        $id = $_POST['id'];
    
    $password = $_POST['password'];
    
    $_SESSION['user']['id'] = $id;
    
    $mUser = new User();
    
    if($mUser->resetPassword($password))    
        header('Location:login.php');
    
    exit();
}

if(isset($_GET['id']) && isset($_GET['key'])) {
	$id = $_GET['id'];
    $key = $_GET['key'];
} else {
	header('location : login.php');
    exit();
}

$pswdrstlink = "resetPassword.php?id=".$id;
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
		<!--[if IE]><script type="text/javascript" src="resources/scripts/jquery.bgiframe.js"></script><![endif]-->

    <script>
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

    </script>
		
	</head>
  
	<body><div id="body-wrapper"> <!-- Wrapper for the radial gradient background -->
		
	
			<h1 id="sidebar-title"><a href="#">FindGaddi</a></h1>
		  

		<div id="main-content"style="width:45%;float:left;"> <!-- Main Content Section with everything -->
			
			<noscript> <!-- Show a notification if the user has disabled javascript -->
				<div class="notification error png_bg">
					<div>
						Javascript is disabled or is not supported by your browser. Please <a href="http://browsehappy.com/" title="Upgrade to a better browser">upgrade</a> your browser or <a href="http://www.google.com/support/bin/answer.py?answer=23852" title="Enable Javascript in your browser">enable</a> Javascript to navigate the interface properly.
					</div>
				</div>
			</noscript>
			
			<!-- Page Head -->
			<p id="page-intro">Please enter your new password.</p>
			
			<div class="clear"></div> <!-- End .clear -->
			
			<div class="content-box"><!-- Start Content Box -->

				
				<div class="content-box-content-no-border">
					
					<div style="display: block;" class="tab-content default-tab" id="tab2">
					
						<form action="<?php echo $pswdrstlink ?>" method="POST">
							
							<fieldset> <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->
							
                                <input type="hidden" name="id" value="<?php echo $id ?>" />
    
                                <p class="column-left">
									<label>Password <span class="mandatory">*</span></label>
									<input class="text-input medium-input" id="password" name="password" type="password" style="width:95% !important" required> <!--<span class="input-notification success png_bg">Successful message</span> 
										<br><small>A small description of the field</small>-->
								</p>
								
								<p class="column-right" style="margin: 0 -10px 0 0;" >
									<label>Re-Type Password <span class="mandatory">*</span></label>
									<input class="text-input medium-input" id="retype" name="retype" type="password"  style="width:95% !important" onBlur="checkPassword()" required><br><span class="input-notification error png_bg" id="pass_error"></span><span class="input-notification success png_bg" id="pass_success"></span>
								</p>

								<p id="notify">
									<input class="button" value="Reset Password" type="submit">
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