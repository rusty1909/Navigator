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
			Add Client
			<form action="action.php?action=add" method="POST">
			<table>
				<tr><td>Name</td><td><input type="text" name="name" id="name"></td></tr>
				<tr><td>Contact Person</td><td><input type="text" name="contact_person" id="contact_person"></td></tr>
				<tr><td>Phone</td><td><input type="text" name="phone" id="phone"></td></tr>
				<tr><td>Email</td><td><input type="text" name="email" id="email"></td></tr>
				<tr><td>Website</td><td><input type="text" name="website" id="website"></td></tr>
				<tr><td>Address</td><td><textarea name="address" id="address" ></textarea></td></tr>
				<tr><td>City</td><td><input type="text" name="city" id="city"></td><td>State</td><td><input type="text" name="state" id="state"></td></tr>
				<tr><td>Pincode</td><td><input type="text" name="pincode" id="pincode"></td></tr>
				<tr><td>Description</td><td><textarea name="description" id="description" ></textarea></td></tr>
				<tr><td><input type="submit" value="Add Client"></td></tr>
			</table>
			</form>
		<div>
	</div>
	
</body> 