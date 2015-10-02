<?php
	require_once "../../../utility/helper/Job/JobHelper.php"; 
	require_once "../../../utility/helper/Common/CommonHelper.php";
	$mJobList = null;
	if(isset($_GET['list'])) {
		if($_GET['list'] == "prev") {
			$mJobList = $mUser->getPreviousJobList();
		}
	} else {
		$mJobList = $mUser->getCurrentJobList();
	}
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
				<tr><td style="width:200px;">Job</td>
					<td style="width:200px;">Title</td>
					<td style="width:200px;">Vehicle</td>
					<td style="width:200px;">Driver</td>
					<td style="width:200px;">Action</td>
				</tr>
				<?php
				for($i=0; $i<sizeof($mJobList); $i++) {
					$mJob = new Job($mJobList[$i]);
					$mVehicle = new Vehicle($mJob->getVehicle());
					$mDriver = new Driver($mJob->getDriver());
					echo "<tr>";
					echo "<td><a href='detail.php?id=".$mJob->getId()."'>".$mJob->getCode()."</a></td>";
					echo "<td>".$mJob->getTitle()."</td>";
					echo "<td><a href='../vehicle/detail.php?id=".$mVehicle->getId()."'>".$mVehicle->getVehicleNumber()."</a></td>";
					echo "<td><a href='../driver/detail.php?id=".$mDriver->getId()."'>".$mDriver->getName()."</a></td>";
					echo "<td><input type='submit' value='Assign'><input type='submit' value='Track'></td>";
                    echo "</tr>";
				}
				?>
			</table>
		<div>
	</div>
	
</body> 