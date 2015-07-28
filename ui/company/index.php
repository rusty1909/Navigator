<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
	require_once "../../framework/User.php";
	require_once "../../framework/Vehicle.php";
	require_once "../../framework/Job.php";
	require_once "../../framework/Driver.php";
	require_once "../../framework/Company.php";
	$mUser = new User();

	$mCompany = new Company($mUser->getCompany());

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

    	  <!--  //modal box jquery -->
		<link rel="stylesheet"  href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
		<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
		<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    
		<script>
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
		
		$("#edit_button").click(function(){
			alert("clock");
			$("#basic").hide();
			$("#edit").show();
		});
		</script>
    
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
			if(modalBox == "detail-popup"){
				//alert("sdvdskvds");
				//$('#'+modalBox).load("edit.php");
			}
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
        
        function onDelete(id){
            if(confirm("You really want to delete this vehicle?"))
                window.location.href = "action.php?action=delete&id="+id;
           }
        
	</script>
    
    
</head>
  
	<body><div id="body-wrapper"> <!-- Wrapper for the radial gradient background -->
		
	<?php include('../sidebar.php');?>
		
		<div id="main-content"> <!-- Main Content Section with everything -->
			
			<noscript> <!-- Show a notification if the user has disabled javascript -->
				<div class="notification error png_bg">
					<div>
						Javascript is disabled or is not supported by your browser. Please <a href="http://browsehappy.com/" title="Upgrade to a better browser">upgrade</a> your browser or <a href="http://www.google.com/support/bin/answer.py?answer=23852" title="Enable Javascript in your browser">enable</a> Javascript to navigate the interface properly.
					</div>
				</div>
			</noscript>
			
			<div class="clear"></div> <!-- End .clear -->
			
			<div class="content-box">				
				<div class="content-box-header">
					
					<h3 style="cursor: s-resize;"><?php echo $mCompany->getName(); ?></h3>
					
					<ul class="content-box-tabs">
						<li><a href="#info" class="default-tab current">Basic Information</a></li> <!-- href must be unique and match the id of target div -->
						<li><a href="#staff">Staff</a></li>
						<li><a href="#payment">Payments</a></li>
						<li><a href="#setting">Settings</a></li>
					</ul>
					
					<div class="clear"></div>
					
				</div>
				<div class="content-box-content">
					<div style="display: block;" class="tab-content default-tab" id="info">
						<div id="basic">
							<form action="edit.php"><fieldset>
								<p class="column-left">
									<input class="button" value="   Edit   " type="submit" id="edit_button">
									<br><br>
									<b>TIN Number</b><br>
									<?php echo $mCompany->getTINNumber(); ?>
									<br><br>
									<b>Address</b><br>
									<?php echo $mCompany->getAddress(); ?>
									
								</p>
								
								<p class="column-right">
									<br><br>
									<b>Contact Details</b><br>
									<b>Phone : </b><?php if($mCompany->getPhone() != 0) echo $mCompany->getPhone(); ?><br>
									<b>Fax : </b><?php if($mCompany->getFax() != 0) echo $mCompany->getFax(); ?><br>
									<b>Email : </b><a target="_mail" href='mailto:<?php echo $mCompany->getEmail(); ?>'><?php echo $mCompany->getEmail(); ?></a><br>
									<b>Website : </b><a target="_website" href='http://<?php echo $mCompany->getWebsite(); ?>'><?php echo $mCompany->getWebsite(); ?></a><br>
								</p>
								
								
							</fieldset></form>
						</div>
						
					</div>
					                    
                   <div style="display: block;" class="tab-content" id="staff">	
						 Existing Employee Count : <?php echo  Company::totalEmployee();?>
                       
						<?php
						$mEployeelist = Company::totalEmployee();
						if(sizeof($mEployeelist) == 0) {
						?>
						<div class="notification attention png_bg">
							<div>
								You don't have any employee in this category.
							</div>
						</div>
						<?php } else {?>
						
						<table>
							
							<thead>
								<tr>
								   <th>Employee Name</th>
								   <th>Employee Phone</th>
								   <th>Address</th>
								   <th>Action</th>
								</tr>
								
							</thead>
						 
							<tfoot>
								<tr>
									<td colspan="6">
										<div class="bulk-actions align-left">
											<a class="button" class='js-open-modal' href='#' data-modal-id='add-employee' >Add Employee</a>
										</div>
										
										<!--<div class="pagination">
											<a href="#" title="First Page">« First</a><a href="#" title="Previous Page">« Previous</a>
											<a href="#" class="number" title="1">1</a>
											<a href="#" class="number" title="2">2</a>
											<a href="#" class="number current" title="3">3</a>
											<a href="#" class="number" title="4">4</a>
											<a href="#" title="Next Page">Next »</a><a href="#" title="Last Page">Last »</a>
										</div> --><!-- End .pagination -->
										<div class="clear"></div>
									</td>
								</tr>
							</tfoot>
						 
							<tbody>
								<?php
								$mEployeelist = Company::totalEmployeeArray();
								for($i=0; $i<sizeof($mEployeelist); $i++) {
                                    //echo $mEployeelist[$i];
									$mEmployee = new User($mEployeelist[$i]);
									echo "<tr>";
									echo "<td><img height='15' width='15' src='../../res/driver_icon.png'>&nbsp;&nbsp;<b>".$mEmployee->getFullName()."</b></td>";
									echo "<td>".$mEmployee->getPhoneMobile()."</td>";
									echo "<td>".$mEmployee->getAddress()."</td>";
									echo "									<td>
										<!-- Icons -->
										 <a href='#' title='Edit'><img src='../../res/pencil.png' alt='Edit'></a>
										 <a href='#' title='Delete' onClick='onDelete(".$mEmployee->getId().")'><img src='../../res/cross.png' alt='Delete'></a>&nbsp;&nbsp;
										 <a href='#' title='Edit Meta'><img src='../../res/hammer_screwdriver.png' alt='Edit Meta'></a>
									</td>";
									echo "</tr>";	
								}
								?>
							</tbody>
							
						</table>
						<?php } ?>
					</div> <!-- End #prev -->
                
                
                    
                    <div style="display: block;" class="tab-content" id="payment">					
						<p>
                        
                        Make Payments and keep using the findgaddi services.
                        </p>
					</div> <!-- End #tab3 -->					
                    
                    <div style="display: block;" class="tab-content" id="setting">					
						<p>
                            Change Settings for notifications and alerts.
                        </p>
					</div> <!-- End #tab3 -->					
                    
				</div> <!-- End .content-box-content -->				
			</div> <!-- End .content-box -->

			<div class="clear"></div>
            
            <!-- //////////////// POP UP Box for adding employee-->
    <div id="add-employee" class="modal-box" style="width:50%;">  
		<header>
			<h3>Add Driver</h3>
		</header>
		<div class="modal-body" id="item-list">
						
     <!---------------------------------------------------------------------------------------------------------------------------------->       
            <form action="action.php?action=registerEmployee" method="POST" onSubmit="return validate()">
							
							<fieldset> <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->
							
								<p class="column-left">
									<label>Employee Name <span class="mandatory">*</span></label>
									<input class="text-input medium-input" id="name" name="name" type="text" style="width:45.5% !important" required placeholder="Ranjan Singh"> <span class="input-notification error png_bg" id="name_error"></span><span class="input-notification success png_bg" id="name_success"></span>  
								</p>
							
								<p class="column-right">
									<label>Employee ID <span class="mandatory">*</span></label>
									<input class="text-input medium-input" id="tin_number" name="tin_number" type="text" style="width:45.5% !important"  required placeholder="11223344h"> <span class="input-notification error png_bg" id="tin_error"></span><span class="input-notification success png_bg" id="tin_success"></span>  
								</p>
								
								<p class="column-left">
									<label>Address Line 1 <span class="mandatory">*</span></label>
									<input class="text-input medium-input" id="address_1" name="address_1" type="text" style="width:99.5% !important"  required placeholder="Chawri bazar">
								</p>
							
								<p class="column-right">
									<label>Address Line 2</label>
									<input class="text-input medium-input" id="address_2" name="address_2" type="text" style="width:99.5% !important">
								</p>
								
								<p class="column-left">
									<label>Landmark </label>
									<input class="text-input medium-input" id="landmark" name="landmark" type="text" style="width:45.5% !important"> <!--<span class="input-notification success png_bg">Successful message</span> 
										<br><small>A small description of the field</small>-->
								</p>
								
								<p class="column-right">
									<label>City <span class="mandatory">*</span></label>
									<input class="text-input medium-input" id="city" name="city" type="text"  style="width:45.5% !important"  required placeholder="New Delhi"> 
								</p>
				
								<p class="column-left">
									<label>State <span class="mandatory">*</span></label>
									<input class="text-input medium-input" id="state" name="state" type="text" style="width:45.5% !important"  required placeholder="Delhi"> <!--<span class="input-notification success png_bg">Successful message</span> 
										<br><small>A small description of the field</small>-->
								</p>
								
								<p class="column-right">
									<label>Pin Code <span class="mandatory">*</span></label>
									<input class="text-input medium-input" id="pincode" name="pincode" type="text"  style="width:45.5% !important"> 
								</p>

								<p class="column-left">
									<label>Phone <span class="mandatory">*</span></label>
									<input class="text-input medium-input" id="phone" name="phone" type="number" style="width:45.5% !important"  required placeholder="0123456789"> <!--<span class="input-notification success png_bg">Successful message</span> 
										<br><small>A small description of the field</small>-->
								</p>
								
								<p class="column-left">
									<label>Email</label>
									<input class="text-input medium-input" id="email" name="email" type="email" style="width:45.5% !important"> <!--<span class="input-notification success png_bg">Successful message</span> 
										<br><small>A small description of the field</small>-->
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
			
			<!-- End Notifications -->
			
<?php include("../footer.php")?>
			
		</div> <!-- End #main-content -->
		
	</div>
 </body></html>