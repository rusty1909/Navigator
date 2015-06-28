<?php
	require_once "../../framework/User.php";
	require_once "../../framework/Vehicle.php";
	require_once "../../framework/Job.php";
	require_once "../../framework/Driver.php";
	$mUser = new User();
	if(!isset($_GET['list']))
		$mVehicleList = $mUser->getVehicleList();
	else {
		$list = $_GET['list'];
		switch($list) {
			case "prev" : $mVehicleList = $mUser->getPreviousVehicleList(); break;
			case "deployed" : $mVehicleList = $mUser->getDeployedVehicleList(); break;
			case "onjob" : $mVehicleList = $mUser->getOnJobVehicleList(); break;
			case "free" : $mVehicleList = $mUser->getFreeVehicleList(); break;
			case "wait" : $mVehicleList = $mUser->getWaitingVehicleList(); break;
			default : $mVehicleList = $mUser->getVehicleList(); break;
		}
	}
	//echo sizeof($mVehicleList);
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
			<table>
				<tr><td style="width:200px;">Vehicle Type</td>
					<td style="width:200px;">Model</td>
					<td style="width:200px;">Vehicle Number</td>
					<td style="width:200px;">Current Job</td>
					<td style="width:200px;">Current Driver</td>
					<td style="width:200px;">Action</td>
				</tr>
				<?php
				for($i=0; $i<sizeof($mVehicleList); $i++) {
					$mVehicle = new Vehicle($mVehicleList[$i]);
					$mJob = new Job($mVehicle->getCurrentJob());
					$mDriver = new Driver($mJob->getDriver());
					echo "<tr>";
					echo "<td>".$mVehicle->getType()."</td>";
					echo "<td>".$mVehicle->getModel()."</td>";
					echo "<td>".$mVehicle->getVehicleNumber()."</td>";
					echo "<td>".$mJob->getCode()."</td>";
					echo "<td>".$mDriver->getName()."</td>";
					echo "<td><input type='submit' value='Assign'><input type='submit' value='Track'></td>";
					echo "</tr>";	
				}
				?>
			</table>
		<div>
	</div>
	
</body> 