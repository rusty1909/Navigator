<?php
	require_once "../../framework/User.php";
	require_once "../../framework/Vehicle.php";
	require_once "../../framework/Job.php";
	require_once "../../framework/Driver.php";

if(!isset($_SESSION['user']))
	header('Location:../user/login.php');

	$mUser = new User();
	
	if(!isset($_GET['id'])) {
		header("Location:index.php");
		return;
	} 
	$mId = $_GET['id'];
	
	$mVehicle = new Vehicle($mId);
	
	$mLat=$mVehicle->getLat();
	$mLong=$mVehicle->getLong();
	$address = "Address";//trim($mVehicle->getAddress());
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
        <script type="text/javascript" src="../../res/jquery/jquery-ui.min.js" ></script>
	<script src="http://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true&key=AIzaSyBcmYGGYTH1hGEEr31Odpiou8thwx55f_o"></script>
	<script>
    //defining map properties    
    
        
    //declaring map variable
    var map;
        
    //declaring markers and content variables
    var marker;
    var contentString;
        
    //declaring location elements
    var latitude = 0;
    var longitude = 0;
    var address = "Loading...";
    var last_updated = "";
    var vehicle_number = "";
	var isMoved = false;
        
    function clearMap(){
        marker.setMap(null);
    }
        
    function fetchLocation(){
        var id = $('#id_value').val();
			if(id == "") return;
			jQuery.ajax({
					type: 'POST',
					url: 'locationInfo.php',
					data: 'id='+ id,
					cache: false,
					success: function(response){
                        //alert(response);
						if(response == 0){
						}
						else {
                            var location = JSON.parse(response);
                            latitude = location.lattitude;
                            longitude = location.longitude;
                            address = location.address;
                            last_updated = location.last_update;
                            vehicle_number = location.vehicle_number;
						}
					}
				});
    }
	
	function updateAddressView(address){
		document.getElementById("address_view").innerHTML = address;
	}
        
    function updateMarker(isMoved){
      fetchLocation();
      clearMap();
      addMarker();
/*	  if(isMoved){
		  locatePosition();
		  isMoved=false;
	  }*/
	  updateAddressView(address);
    }
	
	function locatePosition(){
		map.panTo(marker.getPosition());
	}
        
    function addMarker(){
      marker=new google.maps.Marker({
          position:new google.maps.LatLng(latitude, longitude),
          title:vehicle_number
	  });
	  marker.setAnimation(google.maps.Animation.BOUNCE);
      //map.panTo(marker.getPosition());
	  marker.setMap(map);
	  
	  contentString = '<div id="content">'+
		  '<div id="siteNotice">'+
		  '</div>'+
		  '<h1 id="firstHeading" class="firstHeading">Vehicle Number</h1>'+
		  '<div id="bodyContent">'+
		  '<p><b>address</b></p>'+
		  '<p>(last updated at lat_updated)</p>'+
		  '</div>'+
		  '</div>';
        
        //alert(contentString);
    }
    
    function addTrack(nlat, nlong, naddress, nlastupdated){
      marker=new google.maps.Marker({
          position:new google.maps.LatLng(nlat, nlong),
          title:naddress+"\n"+nlastupdated
	  });
	  //marker.setAnimation(google.maps.Animation.BOUNCE);
      //map.panTo(marker.getPosition());
	  marker.setMap(map);
    }
    
    function showTrack(id){
        var start = $('#from_date').val();
        var end = $('#to_date').val();
        if(start=="" && end=="") {
            alert("Enter start and end date.");
            return;
        }
        
        jQuery.ajax({
            type: 'POST',
            url: 'trackInfo.php?id='+ id + '&start=' + start + "&end=" + end,
            //data: 'id='+ id + '&start=' + start + "&end=" + end,
            cache: false,
            success: function(response){
                if(response == 0){
                    alert("qwertyu");
                }
                else {
                    //updateAddressView(response);
					//alert(response);
                    var trace = JSON.parse(response);
                    //alert(trace.track[1].id);
                    alert(trace.track.length);
/*                    nlat = trace.track[1].lattitude;
                        nlong = trace.track[1].longitude;
                        naddress = trace.track[1].address;
                        nlastupdated = trace.track[1].last_updated;
                        addTrack(nlat, nlong, naddress, nlastupdated);*/
                    for(var i=1; i<trace.track.length; i++){
                        nlat = trace.track[i].lattitude;
                        nlong = trace.track[i].longitude;
                        naddress = trace.track[i].address;
                        nlastupdated = trace.track[i].last_updated;
                        addTrack(nlat, nlong, naddress, nlastupdated);
                    }
                    //alert(trace.id);
                }
            }
        });
    }
        
        
        
	function initialize() {
      fetchLocation();
      var mapProp = {
		center:new google.maps.LatLng(<?php echo $mLat.", ".$mLong; ?>),
		zoom:13,
		mapTypeId:google.maps.MapTypeId.ROADMAP
	  };
      map=new google.maps.Map(document.getElementById("googleMap"),mapProp);        
      addMarker();
	  
	  var infowindow = new google.maps.InfoWindow({
		  content: contentString
	  }); 

	  google.maps.event.addListener(marker, 'click', function() {
        alert(contentString);
		infowindow.open(map,marker);
	  });
/*      window.setTimeout(function() {
         updateMarker(false);
		 //alert();
		 map.panTo(marker.getPosition());
      }, 1000);*/
	  
	}
        
	google.maps.event.addDomListener(window, 'load', initialize);
        
    var updates = setInterval(function(){ updateMarker(true) }, 2000);
	</script>
</head>
  
	<body><div id="body-wrapper"> <!-- Wrapper for the radial gradient background -->
		<input type=hidden value="<?php echo $mId; ?>" id="id_value">
	<?php include('../sidebar.php');?>
		
		<div id="main-content-map"> <!-- Main Content Section with everything -->
			
			<noscript> <!-- Show a notification if the user has disabled javascript -->
				<div class="notification error png_bg">
					<div>
						Javascript is disabled or is not supported by your browser. Please <a href="http://browsehappy.com/" title="Upgrade to a better browser">upgrade</a> your browser or <a href="http://www.google.com/support/bin/answer.py?answer=23852" title="Enable Javascript in your browser">enable</a> Javascript to navigate the interface properly.
					</div>
				</div>
			</noscript>
			
			<div class="clear"></div> <!-- End .clear -->
			

			<div class="clear"></div>
			
			<div class="content-box" style="margin: 0 0 0 0;padding: 0 0 0 0;border:0px"><!-- Start Content Box -->
				

				
				<div class="content-box-content-map" style="padding:0;width:100%">
					
					
					<div style="display: block; " class="tab-content default-tab" id="map" style="width:100%;height:100%;"> <!-- This is the target div. id must match the href of this div's tab -->
					<?php
					if(!$mVehicle->isDeployed()) {
							echo "<div class='notification information png_bg' style='width:50%;float:left;margin:10px 10px 10px 10px;'><div>Tracking device has been installed yet.</div></div> ";
					} else {
						if($mVehicle->getAddress()==null) {
							echo "<div class='notification attention png_bg' style='width:50%;float:left;margin:10px 10px 10px 10px;'><div>Could not find location at this moment, Please be patient and be with us.</div></div> ";
						} else {
							//echo $mVehicle->getAddress();
					?>
					<div id="googleMap" style="width:70%;height:100%;float:left;"></div>
					<?php
						}
					}
					?>
					<div class="content-box-content-detail" style="width:30%;height:100%;float:right;overflow-y:auto">
					
						<div id="vehicle_number" style="margin:15px 5px 20px 5px">
						<b style="font-size:30px"><?php echo $mVehicle->getVehicleNumber(); ?> </b>
						<span style="font-size:12px">(<?php echo $mVehicle->getType();?>)</span>	
						<br><br><input type='button' value='View full details'> &nbsp;&nbsp;&nbsp; <input type='button' value='Notifications'>					
						</div>
						
					 
					
						<div class="content-box" style="margin:5px 5px 5px 5px" id="address_block">
							<div style="display: block;" class="content-box-content-no-border">
						
								<div style="display: block;" class="tab-content default-tab">
									<b> Current Location : </b><br><br>
									<div id="address_view">
									Locating...
									</div><br>
									<input type="button" value="Locate" onClick="locatePosition()">
								</div> <!-- End #tab3 -->        
								
							</div>
						</div>
						
						<div class="content-box" style="margin:5px 5px 5px 5px" id="driver_info_block">
                          	<div style="display: block;" class="content-box-content-no-border">
						
								<div style="display: block;" class="tab-content default-tab">
									<b> Current Driver : </b><br><br>
                                    <?php
                                        //echo $mVehicle->getCurrentDriver();
                                        if($mVehicle->getCurrentDriver() == 0){
                                    ?>
                                            <div id="driver_view">
                                            No Driver Set!!!
                                            </div><br>
                                            <a href="#" style="font-size:11px">Assign driver</a>
                                    <?php } else{
                                            $mDriver = new Driver($mVehicle->getCurrentDriver());
                                            ?>
                                            <div id="driver_view">
                                             <?php echo $mDriver->getName();?>
                                            </div><br>
                                            <a href="action.php?action=removedriver&id=<?php echo $mVehicle->getId() ?>" style="font-size:11px">Remove Driver</a>
                                    <?php    } ?>
                                    
                                    <style>
                                    .modal-box {
  display: none;
  position: absolute;
  z-index: 1000;
  width: 28%;
  background: white;
  border-bottom: 1px solid #aaa;
  border-radius: 4px;
  box-shadow: 0 3px 9px rgba(0, 0, 0, 0.5);
  border: 1px solid rgba(0, 0, 0, 0.1);
  background-clip: padding-box;
}

.modal-box header,
.modal-box .modal-header {
  padding: 1.25em 1.5em;
  border-bottom: 1px solid #ddd;
}

.modal-box header h3,
.modal-box header h4,
.modal-box .modal-header h3,
.modal-box .modal-header h4 { margin: 0; }

.modal-box .modal-body { padding: 2em 1.5em; }

.modal-box footer,
.modal-box .modal-footer {
  padding: 1em;
  border-top: 1px solid #ddd;
  background: rgba(0, 0, 0, 0.02);
  text-align: right;
}

.modal-overlay {
  opacity: 0;
  filter: alpha(opacity=0);
  position: absolute;
  top: 0;
  left: 0;
  z-index: 900;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.3) !important;
}

a.close {
  line-height: 1;
  font-size: 1.5em;
  position: absolute;
  top: 5%;
  right: 2%;
  text-decoration: none;
  color: #bbb;
}

a.close:hover {
  color: #222;
  -webkit-transition: color 1s ease;
  -moz-transition: color 1s ease;
  transition: color 1s ease;
}
                                    </style>
                                    <script>
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
    top: ($(window).height() - $(".modal-box").outerHeight()) / 2,
    left: ($(window).width() - $(".modal-box").outerWidth()) / 2
  });
});
 
$(window).resize();
 
});
                                    </script>
                                    <div id="popup" class="modal-box">  
  <header>
    <a href="#" class="js-modal-close close"> X </a>
    <h3> Title</h3>
  </header>
  <div class="modal-body">
    <p>Please select a driver.</p>
      <?php 
      
      ?>
  </div>
  <footer>
    <a href="#" class="js-modal-close">OK</a>
  </footer>
</div>
<a class="js-open-modal" href="#" data-modal-id="popup"> Click me </a>
<script>
                                    $(document).ready(function () {
    //$('#dialog').dialog(); 
    $('#dialog_link').click(function () {
        $('#dialog').dialog('open');
        return false;
    });
});</script>
                                    
                                    <div id="dialog" title="Dialog Title" style="display:none"> Some text</div>  
   <button id="dialog_link">Open Dialog</button>

								</div>        
								
							</div>
						</div>
						
						<div class="content-box" style="margin:5px 5px 5px 5px" id="alert_block">
							<div style="display: block;" class="content-box-content-no-border">
						
								<div style="display: block;" class="tab-content default-tab">
									<b> Track Vehicle Path : </b><br><br>
									
									<table>
									<tr><td style="width:20px;padding:7px;">From</td><td><input type='date' id='from_date'> <br></td></tr>
									<tr><td style="width:20px;padding:7px;">To</td><td> <input type='date' id='to_date'> <br></td></tr>
									<tr><td colspan='2' style="width:20px;padding:7px;"><input type="submit" value="Show Route" onClick="showTrack(<?php echo $mId; ?>)"><tr><td>
									</table>
									
									
								</div>      
								
							</div>
						</div>
						
						<div class="content-box" style="margin:5px 5px 5px 5px" id="latest_news_block">
							<div style="display: block;" class="content-box-content-no-border">
						
								<div style="display: block;" class="tab-content default-tab">
								
									<table>
									<thead>
									<tr></tr>
									</thead>
									<tbody>
									<?php
										echo "<tr></tr>";
										echo "<tr><td>Total Vehicles</td><td></td></tr>";
										echo "<tr><td>Already Deployed</td><td></td></tr>";
										echo "<tr><td>Waiting Deployement</td><td></td></tr>";
									?>
									</tbody>
									</table>
								</div> <!-- End #tab3 -->        
								
							</div>
						</div>
						
					</div> 
					</div>
					
					<!-- End #map -->

					
				</div>

				<!-- End .content-box-content -->
				
			</div> <!-- End .content-box -->
			
		</div> <!-- End #main-content -->
		
	</div>
</body></html>