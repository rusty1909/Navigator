<?php
    require_once "../../../utility/helper/Job/JobHelper.php"; 
	require_once "../../../utility/helper/Common/CommonHelper.php";
    if(!isset($_GET['id'])) {
		header("Location:index.php");
		return;
	} 
	$mId = $_GET['id'];
	$mJob = new Job($mId);
	$locationId = $mJob->getLocationId();
	$orderList = $mJob->getOrderList();

	$mDriver = new Driver($mJob->getDriver());
	$mVehicle = new Vehicle($mJob->getVehicle());
	
?>
<html>
<head><title>Navigator</title>
<script>
function setCompleted() {
	alert();
	<?php //$mJob->setCompleted(); ?>
}
</script>
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
			<?php
			echo "Code : ".$mJob->getCode()."<br>";
			echo "Vehicle : ".$mVehicle->getVehicleNumber()."<br>";
			echo "Driver : ".$mDriver->getName()."<br>";
			echo "Location : ".$locationId."<br>";
			echo "No of orders : ".sizeof($orderList)."<br>";
			//echo $mJob->getStatus();
			//if($mJob->getStatus() == '0') {
			?>
			<input type="submit" value="Complete" onClick="setCompleted()">
			<?php
			//}
			?>
			<hr>
			<table>
				<tr><td style="width:200px;">Order Code</td>
					<td style="width:200px;">Title</td>
					<td style="width:200px;">Client</td>
					<td style="width:200px;">Destination</td>
					<td style="width:200px;">Action</td>
				</tr>
				<?php
				for($i=0; $i<sizeof($orderList); $i++) {
					$mOrder = new Order($orderList[$i]);
					$mClient = new Client($mOrder->getClient());
					echo "<tr>";
					echo "<td><a href='../order/detail.php?id=".$mOrder->getId()."'>".$mOrder->getCode()."</a></td>";
					echo "<td>".$mOrder->getTitle()."</td>";
					echo "<td><a href='../client/detail.php?id=".$mClient->getId()."'>".$mClient->getName()."</a></td>";
					echo "<td>".$mOrder->getDestination()."</td>";
					echo "<td><input type='submit' value='Assign'><input type='submit' value='Track'></td>";
                    echo "</tr>";
				}
				?>
			</table>
		<div>
	</div>
	
</body> 