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
						<a href="forgetpassword.php" style="float:right;"> Forget Password? </a>
					</p>
					
				</form>
			</div> <!-- End #login-content -->
			
		</div> <!-- End #login-wrapper -->
		
  
  

    <div id="facebox" style="display:none;">       <div class="popup">         <table>           <tbody>             <tr>               <td class="tl"></td><td class="b"></td><td class="tr"></td>             </tr>             <tr>               <td class="b"></td>               <td class="body">                 <div class="content">                 </div>                 <div class="footer">                   <a href="#" class="close">                     <img src="../../res/closelabel.gif" title="close" class="close_image">                   </a>                 </div>               </td>               <td class="b"></td>             </tr>             <tr>               <td class="bl"></td><td class="b"></td><td class="br"></td>             </tr>           </tbody>         </table>       </div>     </div></body></html>