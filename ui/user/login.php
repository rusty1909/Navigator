<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
require_once '../../framework/User.php';

if(User::isLoggedIn())
	header('Location:index.php');
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
		
		<!-- Colour Schemes
	  
		Default colour scheme is green. Uncomment prefered stylesheet to use it.
		
		<link rel="stylesheet" href="resources/css/blue.css" type="text/css" media="screen" />
		
		<link rel="stylesheet" href="resources/css/red.css" type="text/css" media="screen" />  
	 
		-->
		
		<!-- Internet Explorer Fixes Stylesheet -->
		
		<!--[if lte IE 7]>
			<link rel="stylesheet" href="resources/css/ie.css" type="text/css" media="screen" />
		<![endif]-->
		
		<!--                       Javascripts                       -->
	  
		<!-- jQuery -->
		<script type="text/javascript" src="../../res/jquery-1.js"></script>
		
		<!-- jQuery Configuration -->
		<script type="text/javascript" src="../../res/simpla.js"></script>
		
		<!-- Facebox jQuery Plugin -->
		<script type="text/javascript" src="../../res/facebox.js"></script>
		
		<!-- jQuery WYSIWYG Plugin -->
		<script type="text/javascript" src="../../res/jquery.js"></script>
		
		<!-- Internet Explorer .png-fix -->
		
		<!--[if IE 6]>
			<script type="text/javascript" src="resources/scripts/DD_belatedPNG_0.0.7a.js"></script>
			<script type="text/javascript">
				DD_belatedPNG.fix('.png_bg, img, li');
			</script>
		<![endif]-->
		
    
          <!--  //modal box jquery -->
        <link rel="stylesheet"  href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
        <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
        <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
    
    <script>
		$(document).ready(function () {
			console.log("clicked");
			$('#dialog_link').click(function () {
				$('#dialog').dialog('open');
				return false;
			});
			
			//$("#edit-form").load("edit.php");
		});

		$(function(){
		console.log("started");
		var appendthis =  ("<div class='modal-overlay js-modal-close'></div>");

		  $('a[data-modal-id]').click(function(e) {
			e.preventDefault();
			$("body").append(appendthis);
			$(".modal-overlay").fadeTo(500, 0.7);
			//$(".js-modalbox").fadeIn(500);
			var modalBox = $(this).attr('data-modal-id');
			$('#'+modalBox).fadeIn($(this).data());
		  });  
		  

		$(".js-modal-close, .modal-overlay").click(function() {
		  $(".modal-box, .modal-overlay").fadeOut(500, function() {
			$(".modal-overlay").remove();
		  });
		});

		$(window).resize(function() {
		  $(".modal-box").css({
			top: ($(window).height() - $(".modal-box").outerHeight()) / 3,
			left: ($(window).width() - $(".modal-box").outerWidth()) / 2
		  });
		});
		 
		$(window).resize();
		 
		});
        
    </script>

    
	</head>
  
	<body id='login'>
		
		<div id="login-wrapper" class="png_bg">
			<div id="login-top">
			
				<h1>FindGaddi</h1>
				<!-- Logo (221px width) -->
				<img id="logo" src="../../res/logo.png" alt="FindGaddi logo">
			</div> <!-- End #logn-top -->
			
			<div id="login-content">

				
				<form action="action.php?action=login" method="POST">
				
					<!--<div class="notification information png_bg">
						<div>
							Just click "Sign In". No password needed.
						</div>
					</div>-->
					
					<p>
						<label>Username</label>
						<input class="text-input" type="text"  name="username" id="username">
					</p>
					<div class="clear"></div>
					<p>
						<label>Password</label>
						<input class="text-input" type="password"  name="password" id="password">
					</p>
					<div class="clear"></div>
					<p id="remember-password">
						<input type="checkbox" name='rememberme' id='rememberme' value="yes" checked="checked">Remember me
					</p>
					<div class="clear"></div>
					<p>
						<input class="button" value="Sign In" type="submit">
					</p>
					<div class="clear"></div>
					<p>
						<a href="register.php" style="float:right;"> New User Register Here </a>
					</p>
					<div class="clear"></div>
					<p>
						<a href="forgetpassword.php" style="float:right;"  class="js-open-modal" href="#" data-modal-id="resetpswdpopup"> Forget Password? </a>
					</p>
					
				</form>
			</div> <!-- End #login-content -->
			
		</div> <!-- End #login-wrapper -->
		
  <div id="resetpswdpopup" class="modal-box" style="width:50%;">  
	  <header>
		<h3>Reset Your Password</h3>
	  </header>
	  <div class="modal-body" id="item-list">		
<!-------------------------------------------------------------------------------------------------------------------------->
						<form action="action.php?action=resetpassword" method="POST">
							
							<fieldset> <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->
								<p>
									<label>Email ID</label>
										<input class="text-input small-input" name="email_id" id="email_id" type="email" required placeholder='xyz@abc.com'> <span class="input-notification error png_bg" id="number_error"></span><span class="input-notification success png_bg" id="number_success"></span>
								</p>
								
								
							</fieldset>
							
							<div class="clear"></div><!-- End .clear -->
							
						
<!----------------------------------------------------------------------------------------------------------------------------->

	  <footer>
		<b><input class="button" value="SUBMIT" type="submit">&nbsp;</b>
		<a href="#" class="js-modal-close" style="color:#D3402B"><b>CANCEL</b></a>
	  </footer>
	  </form>
	  </div>
	</div>
	
  

</body></html>