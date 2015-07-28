<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

	require_once "../../framework/User.php";
	require_once "../../framework/Vehicle.php";
	require_once "../../framework/Company.php";
	require_once "../../framework/Driver.php";
	require_once "../../framework/Expense.php";
	

if(!isset($_SESSION['user']))
	header('Location:../user/login.php');

	$mUser = new User();

	$mCompany = new Company($mUser->getCompany());
	$mEmployeeList = $mCompany->getEmployeeList();
	
	$mAlertList = $mUser->getAlerts();
	$mMonthlyAlertList = $mUser->getMonthlyAlerts();
	
	$mPendingExpenseList = $mUser->getPendingExpenseList();

	
    $mAllVehicleList = $mUser->getVehicleList();
	$mDeployedVehicleList = $mUser->getDeployedVehicleList();
	$mWaitingVehicleList = $mUser->getWaitingVehicleList();
	$mOnJobVehicleList = $mUser->getOnJobVehicleList();
	
	$mDriverList = $mUser->getCurrentDriverList();
	$mAvailableDriverList = $mUser->getAvailableDriverList();
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
	<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
    
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
    <script src="http://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true&key=AIzaSyBcmYGGYTH1hGEEr31Odpiou8thwx55f_o&sensor=false&libraries=places,geometry,drawing"></script>

	<!-- //Modal Box Functionality  -->
	<script>
	$(document).ready(function () {
		//$('#dialog').dialog(); 
		console.log("clicked");
		$('#dialog_link').click(function () {
			$('#dialog').dialog('open');
			return false;
		});
	});

	$(function(){
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
        
    function onDelete(id){
		if(confirm("You really want to delete this User?"))
			window.location.href = "action.php?action=delete&id="+id;
	}
        
	</script>

	<script>
	var bill_id;
	function fetchBillDetails(id){
		var data = "";
        jQuery.ajax({
            type: 'POST',
            url: 'action.php?action=billdetail&id='+id,
            cache: false,
            success: function(response){
				if(response == 0){
				}
				else {
					//alert(response)
					bill_id = id;
					var billDetail = JSON.parse(response);
					
					var vehicle_image = '../../res/vehicle_types/'+billDetail.vehicle.type+'.png';
					var vehicle_text = "<img height='18' width='18' src='"+vehicle_image+"'>&nbsp;&nbsp;<b><a href='../vehicle/detail.php?id="+billDetail.vehicle.id+"' style='text-transform:uppercase;vertical-align:2px;' class='js-modal-close'>"+billDetail.vehicle.number+"</a>";					
					document.getElementById("vehicle").innerHTML = vehicle_text;
					
					var driver_image = '../../res/driver_icon.png';
					var driver_text = "<img height='15' width='15' src='"+driver_image+"'>&nbsp;&nbsp;<b><a href='../driver/detail.php?id="+billDetail.driver.id+"' style='text-transform:uppercase;vertical-align:2px;' class='js-modal-close'>"+billDetail.driver.name+"</a>";
					document.getElementById("driver").innerHTML = driver_text;
					
					var bill_image_path = '../../res/bills/'+billDetail.vehicle.number+'/'+billDetail.filename+'.jpg';
					var bill_image_text = "<img width='100' src='"+bill_image_path+"'>";
					document.getElementById("bill_image").innerHTML = bill_image_text;
					
					var reason_image = '../../res/info.png';
					var reason_text = "<img height='18' width='18' src='"+reason_image+"'>&nbsp;&nbsp<b>"+billDetail.reason+"</b>";
					document.getElementById("reason").innerHTML = reason_text;
					
					var amount_image = '../../res/amount.png';
					document.getElementById("amount").innerHTML = "<img height='18' width='18' src='"+amount_image+"'>&nbsp;&nbsp<b>Rs."+billDetail.amount+"</b>";
					
					var calendar_image = '../../res/calendar.png';
					var date_added_text = "<img height='15' width='15' src='"+calendar_image+"'>&nbsp;&nbsp<b>"+billDetail.date_added+"</b>";
					document.getElementById("date_added").innerHTML = date_added_text;
					
					//document.getElementById("latlng").innerHTML = billDetail.location.lat+","+billDetail.location.lng;
					
					updateAddressView(billDetail.location.lat, billDetail.location.lng);
				}
            }
        });
	}
	
	function approveBill(isApproval) {
		jQuery.ajax({
            type: 'POST',
            url: 'action.php?action=billapproval&id='+bill_id+'&approval='+isApproval,
            cache: false,
            success: function(response){
				if(response == 0){
				}
				else {
					if(response=='success'){
						location.reload();
						if(isApproval==1){
							alert("Bill Approved!!!");
						} else {
							alert("Bill Rejected!!!");
						}
					} else{
						alert("some problem occurred");
					}
				}
            }
        });
	}
	
	function updateAddressView(latitude, longitude){
		var geocoder = new google.maps.Geocoder();
		var latlng = new google.maps.LatLng(latitude, longitude);
		geocoder.geocode({'location': latlng}, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				if (results[1]) {
					var formatted_address = results[1].formatted_address;
					var calendar_image = '../../res/location_icon.png';
					document.getElementById("address").innerHTML = "<img height='15' width='15' src='"+calendar_image+"'>&nbsp;&nbsp<b>"+formatted_address+"<br>("+latitude+","+longitude+")</b>";
				} else {
					console.log('No results found');
				}
			} else {
				console.log('Geocoder failed due to: ' + status);
			}
		});
	}
	
	function fetchNotification(){
		//alert(id+" "+driver_id);
		var data = "";
        jQuery.ajax({
            type: 'POST',
            url: 'notification.php',
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
						data += "<tr style='background:#fff;border-bottom: 1px solid #ddd;'><td><img height='20' width='20' src='../../res/"+image+".png' title='Location' alt='Location'></td><td style='padding:10px;line-height:1em;'><span style='vertical-align:5px;'>"+notiList[i].string+"</span></td><td style='font-size:10px;padding-top:-10px'><span style='vertical-align:7px;'><b>"+notiList[i].time+"</b></span></td></tr>";
						//console.log(image);
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
	</script>
</head>
  
	<body onload='fetchNotification()'><div id="body-wrapper"> <!-- Wrapper for the radial gradient background -->
		
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
			<div style="width:59%;height:88%;float:left">
				<div class="column-left" style="width:100%;height:50%">				
					<ul class="shortcut-buttons-set">
				
						<li><a class="shortcut-button" href="../vehicle/"><span>
							<b><span style="font-size:15px;border: none; display:block; padding: 0px;">VEHICLES</span></b>
							<img src="../../res/truck.png" alt="icon"><br>
							<b><span style="font-size:30px;border: none; display:block; padding: 0px;"><?php echo sizeof($mAllVehicleList) ?></span></b> registered<br>drivers<br><br>
							<b><?php echo sizeof($mOnJobVehicleList) ?></b> on-road<br><br>
							<b><?php echo sizeof($mWaitingVehicleList) ?></b> waiting<br>
						</span></a></li>
						
						<li><a class="shortcut-button" href="../driver/"><span>
							<b><span style="font-size:15px;border: none; display:block; padding: 0px;">DRIVERS</span></b>
							<img src="../../res/drivers.png" alt="icon"><br>
							<b><span style="font-size:30px;border: none; display:block; padding: 0px;"><?php echo sizeof($mDriverList) ?></span></b> registered<br>drivers<br><br>
							<b><?php echo sizeof($mAvailableDriverList) ?></b> available<br>
						</span></a></li>
						
						<li><a class="shortcut-button" href="#"><span>
							<b><span style="font-size:15px;border: none; display:block; padding: 0px;">STAFFS</span></b>
							<img src="../../res/staff.png" alt="icon"><br>
							<?php
							if($mUser->getCompany()==-1){
							?>
							<b><span style="border: none; display:block; padding: 0px;">Please add Company to add Staff</span></b>
							<?php } else { ?>
							<b><span style="font-size:30px;border: none; display:block; padding: 0px;"><?php echo sizeof($mEmployeeList) ?></span></b> registered<br>staff<br>
							<?php } ?>
						</span></a>
						</li>
						
						<li><a class="shortcut-button" href="#"><span>
							<b><span style="font-size:15px;border: none; display:block; padding: 0px;">ALERTS</span></b>
							<img src="../../res/alerts.png" alt="icon"><br>
							<b><span style="font-size:30px;border: none; display:block; padding: 0px;"><?php echo sizeof($mMonthlyAlertList) ?></span></b> reported<br>this month<br><br>
							<b><?php echo sizeof($mAlertList) ?></b> total reported<br>
						</span></a></li>
						
					</ul><!-- End .shortcut-buttons-set -->
				</div> <!-- End .content-box -->
				<div class="clear"></div>
				<div class="content-box column-left" style="width:49%;height:50%">				
					<div class="content-box-header">					
						<h3 style="cursor: s-resize;">Pending Bills (<?php echo sizeof($mPendingExpenseList);?>)</h3>				
					</div> <!-- End .content-box-header -->				
					<div style="display: block;padding:0px;height:85%;overflow-y:auto" class="content-box-content">
					
						<div style="display:block;overflow-y:auto" class="tab-content default-tab">
						
							<table id="noti_table">
							<thead>
							<tr></tr>
							</thead>
							<tbody style="border-bottom:0px" id="bill_body">
							<?php
								for($i=0; $i<sizeof($mPendingExpenseList); $i++){
									$mExpense = new Expense($mPendingExpenseList[$i]);
									$vehicleId = $mExpense->getVehicle();
									$mVehicle = new Vehicle($vehicleId);
									$reason = $mExpense->getReason();
									$amount = $mExpense->getAmount();
									echo "<tr onMouseOver='this.bgColor='#EEEEEE''><td style='width:50%'><b><a href='../vehicle/detail.php?id=".$mVehicle->getId()."'>".$mVehicle->getVehicleNumber()."</a></b></td><td>".$reason."</td><td><b>Rs.".$amount."</b></td><td><a class='js-open-modal' href='#' data-modal-id='bill_popup' onClick='fetchBillDetails(".$mExpense->getId().")'><img src='../../res/more_detail.png' width=20 height=20 style='cursor:hand;'/></a></td></tr>";
								}
							?>
							</tbody>
							</table>
						</div>      
					
					</div> <!-- End .content-box-content -->			
				</div> <!-- End .content-box -->
				<div class="content-box column-right" style="width:49%;height:50%">				
					<div class="content-box-header">					
						<h3 style="cursor: s-resize;">Reminders</h3>
						<a href="#" style="color:#57a000; float:right;padding:15px 10px 0 0 !important"><b>Add Reminder</b></a>		
					</div> <!-- End .content-box-header -->				
					<div style="display: block;padding:0px;height:85%;overflow-y:auto" class="content-box-content">
					
						<div style="display:block;overflow-y:auto" class="tab-content default-tab" id="item-list">
						
							<table id="noti_table">
							<thead>
							<tr></tr>
							</thead>
							<tbody style="border-bottom:0px" id="rem_body">
							<tr><td><b>Coming soon...</b></td></tr>
							</tbody>
							</table>
						</div>      
					
					</div> <!-- End .content-box-content -->
				</div>
			</div>
			
			

			<div class="content-box column-right" style="width:40%;height:88%;">
			
				
				<div class="content-box-header"> <!-- Add the class "closed" to the Content box header to have it closed by default -->
					
					<h3 style="cursor: s-resize;">Notifications</h3>
					
				</div> <!-- End .content-box-header -->
				
				<div style="display: block;padding:0px;height:93%;overflow-y:auto" class="content-box-content">
					
					<div style="display:block;overflow-y:auto" class="tab-content default-tab" id="item-list">
					
						<table id="noti_table">
						<thead>
						<tr></tr>
						</thead>
						<tbody style="border-bottom:0px" id="noti_body">
						<tr><td><b>Loading Notifications</b></td></tr>
						</tbody>
						</table>
					</div>      
					
				</div> <!-- End .content-box-content -->
				
			</div> <!-- End .content-box -->
			<div class="clear"></div>
			<?php include("../footer.php")?>
			
		</div> <!-- End #main-content -->
		
	</div>
	
	<div id="bill_popup" class="modal-box" style="width:40%;">  
	  <header>
		<h3>Bill Details</h3>
	  </header>
	  <div class="modal-body" id="item-list" style="padding-left:10px;padding-right:10px">
		<div style="float:left;width:250px">
			<table>
			<tbody style="border-bottom: 0px;">
				<tr style="border-bottom: 0px;"><td id="vehicle">vehicle...</td></tr>
				<tr style="border-bottom: 0px;"><td id="driver">driver...</td></tr>
				<tr style="border-bottom: 0px;"><td id="reason">reason...</td></tr>
				<tr style="border-bottom: 0px;"><td id="amount">amount...</td></tr>
				
			</tbody>
			</table>
		</div>
		<div style="float:right;" id="bill_image">
		</div>
		<div style="width:100%">
			<table>
			<tbody>
				<tr style="border-bottom: 0px;"><td id='address'>Loading</td><!--<td id='map'>map</td>--></tr>
				<tr style="border-bottom: 0px;"><td id="date_added">date_added...</td></tr>				
			</tbody>
			</table>
		</div>
	  </div>
	  <footer>
		<b><input class="button js-modal-close" value="APPROVE" type="submit" onClick="approveBill('1')"></b>&nbsp;
		<a href="#" class="js-modal-close" style="color:#D3402B" onClick="approveBill('-1')"><b>REJECT</b></a>&nbsp;
		<a href="#" class="js-modal-close" style="color:#D3402B"><b>LATER</b></a>
	  </footer>
	</div>
  </body></html>