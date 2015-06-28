<?php
	require_once "../../framework/User.php";
	require_once "../../framework/Order.php";
	require_once "../../framework/Client.php";
	$mUser = new User();
	$mOrderList = $mUser->getOrderList();
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
				<tr><td style="width:200px;">Order</td>
					<td style="width:200px;">Title</td>
					<td style="width:200px;">Client</td>
					<td style="width:200px;">Destination</td>
					<td style="width:200px;">Action</td>
				</tr>
				<?php
				for($i=0; $i<sizeof($mOrderList); $i++) {
					$mOrder = new Order($mOrderList[$i]);
					$mClient = new Client($mOrder->getClient());
					echo "<tr>";
					echo "<td>".$mOrder->getCode()."</td>";
					echo "<td>".$mOrder->getTitle()."</td>";
					echo "<td>".$mClient->getName()."</td>";
					echo "<td>".$mOrder->getDestination()."</td>";
					echo "<td><input type='submit' value='Assign'><input type='submit' value='Track'></td>";
					echo "</tr>";	
				}
				?>
			</table>
		<div>
	</div>
	
</body> 