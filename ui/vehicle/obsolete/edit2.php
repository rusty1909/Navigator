<?php
	require_once "../../framework/User.php";
	$mUser = new User();
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
			Add Vehicle
			<form action="action.php?action=add" method="POST">
			<table>
				<tr><td>Type</td><td><select name="type" id="type"><option>Truck</option><option>Car</option></select></td></tr>
				<tr><td>Model</td><td><input type="text" name="model" id="model"></td></tr> 
				<tr><td>Make Year</td><td><input type="text" name="make_year" id="make_year"></td></tr> 
				<tr><td>Vehicle Number</td><td><input type="text" name="vehicle_number" id="vehicle_number"></td></tr> 
				<tr><td>Description</td><td><textarea name="description" id="description" ></textarea></td></tr>
				<tr><td><input type="submit" value="Add Vehicle"></td></tr>
			</table>
			</form>
		<div>
	</div>
	
</body> 