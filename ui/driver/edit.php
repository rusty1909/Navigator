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
			Add Driver
			<form action="action.php?action=add" method="POST">
			<table>
				<tr><td>Name</td><td><input type="text" name="name" id="name"></td></tr>
				<tr><td>Phone</td><td><input type="text" name="phone" id="phone"></td></tr>
				<tr><td>Address</td><td><textarea name="address" id="address" ></textarea></td></tr>
				<tr><td>Joining Date</td><td><input type="text" name="date_join" id="date_join"></td></tr>
				<tr><td>Description</td><td><textarea name="description" id="description" ></textarea></td></tr>
				<tr><td><input type="submit" value="Add Driver"></td></tr>
			</table>
			</form>
		<div>
	</div>
	
</body> 