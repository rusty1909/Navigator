<?php
	require_once "../../framework/User.php";
	require_once "../../framework/Client.php";
	require_once "../../framework/Vehicle.php";
	require_once "../../framework/Driver.php";
	
	$mUser = new User();
	$mVehicleList = $mUser->getDeployedVehicleList();
	$mDriverList = $mUser->getDriverList();
	//echo sizeof($mClientList);
?>
<html>
<head><title>Navigator</title>
</head>
<body>
	<div id="header">
	<?php
		include('../header.php');
	?>
	</div>
	<div id="container">
		<div id="sidebar" style="float:left;width:15%;">
		<?php include('sidebar.php'); ?>
		</div>
		<div id="content" style="float:right;width:85%;">
			Add Order
			<form action="action.php?action=add" method="POST">
			<table>
				<tr><td>Title</td><td><input type="text" name="title" id="title"></td></tr>
				<tr><td>Vehicle</td>
					<td><select name="vehicle" id="vehicle"><option> --- Select Vehicle --- </option>
					<?php
					for($i=0; $i<sizeof($mVehicleList); $i++){
						$mVehicle = new Vehicle($mVehicleList[$i]);
						if($mVehicle->getCurrentJob()=="")
							echo "<option value=".$mVehicleList[$i].">".$mVehicle->getVehicleNumber()."</option>";
					}
					?>
					</select></td></tr>
				<tr><td>Driver</td>
					<td><select name="driver" id="driver"><option> --- Select Driver --- </option>
					<?php
					for($i=0; $i<sizeof($mDriverList); $i++){
						$mDriver = new Driver($mDriverList[$i]);
						if($mDriver->getCurrentJob()=="")
							echo "<option value=".$mDriverList[$i].">".$mDriver->getName()."</option>";
					}
					?>
					</select></td></tr>
				<tr><td>Destination</td><td><textarea name="destination" id="destination" ></textarea></td></tr>
				<tr><td>Start Date</td><td><input type="text" name="start_date" id="start_date"></td></tr>
				<tr><td>Description</td><td><textarea name="description" id="description" ></textarea></td></tr>
				<tr><td><input type="submit" value="Add Order"></td></tr>
			</table>
			</form>
		<div>
	</div>
	
</body> 