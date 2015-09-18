<?php
	require_once "../../../framework/User.php";
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
		include('../../header.php');
	?>
	</div>
	<div id="container">
		<h2>Change Password</h2>
		<form action="../action.php?action=change" method="POST">
			Previous Password : <input type="password" name="old" id="old"><br>
			New Password : <input type="password" name="new" id="new"><br>
			Re-tpe Password : <input type="password" name="retype" id="retype"><br><br>
			<input type="submit" value="Change Password">
		</form>
		<hr>
		<h2>Update Profile</h2>
		<form action="../action.php?action=update" method="POST">
			Username : <input type="text" name="username" id="username"><br>
			Office Phone : <input type="text" name="phone_o" id="phone_o"><br>
			Mobile : <input type="text" name="phone_m" id="phone_m"><br>
			Email : <input type="email" name="email" id="email"><br><br>
			<input type="submit" value="Update Profile">
		</form>
	</div>
	
</body> 