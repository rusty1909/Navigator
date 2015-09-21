<?php
require_once "../../../utility/helper/Vehicle/VehicleHelper.php";

if(!User::isLoggedIn())
	 header('Location:../user/login.php');

require_once "../../../utility/helper/Common/CommonHelper.php"; 

header("Access-Control-Allow-Origin: *");


$mDriverList = $mUser->getAvailableDriverList();

if(!isset($_GET['id'])) {
    header("Location:index.php");
    return;
} 
$mId = $_GET['id'];

$mVehicle = new Vehicle($mId);

$mLat=$mVehicle->getLat();
$mLong=$mVehicle->getLong();
$address = "Address";//trim($mVehicle->getAddress());

require_once "../../master/headerhomehtml.php";
?>
	<script type="text/javascript" src="http://www.findgaddi.com/navigator/Ver2.0/js/vehicledetails.js"></script>
<script>
    var id = <?php echo $mId?>;
    $(document).ready(setId(id));
</script>
		<input type=hidden value="<?php echo $mId; ?>" id="id_value">
			
			<div class="content-box" style="margin: 0 0 0 0;padding: 0 0 0 0;border:0px;height:100%px"><!-- Start Content Box -->
				
				<div class="content-box-content-map" style="padding:0;width:100%">
					
					
					<div style="display: block; " class="tab-content default-tab" id="map" style="width:100%;height:100%;"> <!-- This is the target div. id must match the href of this div's tab -->
					<?php
					if(!$mVehicle->isDeployed()) {
							echo "<div class='notification information png_bg' style='width:50%;float:left;margin:10px 10px 10px 10px;'><div>Tracking device has been installed yet.</div></div> ";
					} else {
						if($mVehicle->isLocationAvailable()==null) {
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
					
						<div id="vehicle_details" style="margin:15px 5px 20px 10px">
							<img id="type" height="45" width="45" src="../../../images/vehicle_types/<?php echo $mVehicle->getType();?>.png" title="<?php echo $mVehicle->getType()." : ".$mVehicle->getModel();?>" alt="<?php echo $mVehicle->getType();?>"> <span style="vertical-align:12px;"><b style="font-size:30px;"><?php echo $mVehicle->getVehicleNumber(); ?> </b>	</span>	
							<br><br><input class="button" type='button' value='View full details'>
							<br><br><br>
							<div id="location_info">
								<table>
								<tr><td><img id="location_icon" height="15" width="15" src="../../../images/location_icon.png" title="Location" alt="Location">&nbsp;</td>
									<td><b><span id="address_view" style='vertical-align:2px;'>
									Locating...
									</span><br></b>									
									<a href="#" style="font-size:11px" onClick="locatePosition()"><img id="add" height="15" width="15" src="../../../images/locate.png" title="Locate Vehicle" alt="Locate Vehicle"></a>&nbsp;&nbsp;<span style="font-size:9px;vertical-align:2px;">Last updated <b id='last_updated'> -- -- -- </b></span>
									<!--<input class="button" type="button" value="Locate" onClick="locatePosition()">-->
									</td>
									</tr>
								</table>
							</div>
							<br>
							<div id="driver_info">
								<img id="driver_icon" height="15" width="15" src="../../../images/driver_icon.png" title="Driver" alt="Driver">&nbsp;
								<?php
									$mDriverList = $mUser->getAvailableDriverList();
									$mVehicle1 = new Vehicle($mId);
									//echo $mVehicle->getCurrentDriver();
									if($mVehicle1->getCurrentDriver() == 0){
								?>									
								<b><span style='vertical-align:2px;'>Click</span> <a class="js-open-modal" href="#" data-modal-id="popup" style="font-size:11px" ><img id="add" height="15" width="15" src="../../../images/add.png" title="Add Driver" alt="Add Driver"></a> <span style='vertical-align:2px;'>to set driver</span></b>
								<?php 
									} else{
										$mDriver = new Driver($mVehicle1->getCurrentDriver());
										echo "<span style='vertical-align:2px;'><b><a href='../driver/detail.php?id=".$mDriver->getId()."'>".$mDriver->getName()."</a></b></span>";
								?>				
								&nbsp;&nbsp;&nbsp; <a href="#" style="font-size:11px" onClick="setDriver(<?php echo $mVehicle->getId();?>, 0);"><img id="add" height="15" width="15" src="../../../images/delete.png" title="Remove Driver" alt="Remove Driver"></a>
								<?php    } ?>
							</div>
							<br>
							<!--<img id="track_icon" height="2" width="70%" src="../../../images/separator.png">-->
							<br>
							<div id="trace_info">
								<table>
								<tr><td rowspan='3'><img id="track_icon" height="15" width="15" src="../../../images/track_icon.png" title="Trace" alt="Trace">&nbsp;</td>									
									<td>&nbsp;<input class="text-input" placeholder="Start Date" type='text' id='from_date' size='8' style="vertical-align:3px;"><br></td>
									<td style="width:25px;"><img height="15" width="15" src="../../../images/to_from.png"></td>
									<td><input class="text-input" placeholder="End Date" type='text' id='to_date' size='8' style="vertical-align:3px;"> <br></td></tr>
								<tr><td colspan='3' style="width:20px;padding:7px;"><b><span id="distance" style='vertical-align:2px;'><input class="button" type="submit" value="Show Route" onClick="showTrack(<?php echo $mId; ?>)"></span></b><td><tr>
								</table>
							</div>
						</div>
						<div id="notifications">
							<div class="content-box-header" style="padding:0px;"> <!-- Add the class "closed" to the Content box header to have it closed by default -->
								<h3 style="cursor: s-resize;">Events of the day (<span id='noti_count'></span>)</h3>
							</div> <!-- End .content-box-header -->
							
							<div class="content-box-content" style="display: block;padding:0px;overflow-y:auto;height:46%">
								
								<div style="display:block;" class="tab-content default-tab" id="item-list">
								
									<table id="noti_table">
									<thead>
									<tr></tr>
									</thead>
									<tbody style="border-bottom:0px" id="noti_body">
									<tr><td><b>Loading Notifications</b></td></tr>
									</tbody>
									</table>
								</div> <!-- End #tab3 -->  
							</div> <!-- End .content-box-content -->
						</div>						
					</div> 
					</div>
					
					<!-- End #map -->

					
				</div>

				<!-- End .content-box-content -->
              
        	<div id="popup" class="modal-box">  
	  <header>
		<h3>Select Driver</h3>
	  </header>
	  <div class="modal-body" id="item-list">
	  
		<table><tbody>
			<?php
				for($i=0; $i<sizeof($mDriverList); $i++){
					$mDriver = new Driver($mDriverList[$i]);
					echo "<tr><td><img height='15' width='15' src='../../../images/driver_icon.png'>&nbsp;&nbsp;<b><a href='#' style='text-transform:uppercase;vertical-align:2px;' class='js-modal-close' onClick='setDriver(".$mVehicle->getId().",".$mDriver->getId().")'>".$mDriver->getName()."</a><span style='float:right;'><img height='20' width='20' src='../../../images/phone_icon.png'><span style='vertical-align:5px;'>+91-".$mDriver->getPhone()."</span></span></b></td></tr>";
				}
			?>
		</tbody></table>
		
	  </div>
	  <footer>
		<a href="#" class="js-modal-close" style="color:#D3402B"><b>CANCEL</b></a>
	  </footer>
	</div>

<?php require_once "../../master/footerhome.php"; ?>
      