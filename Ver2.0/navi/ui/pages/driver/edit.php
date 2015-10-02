<?php
	 require_once "../../../utility/helper/Common/CommonHelper.php"; 
     require_once "../../master/headerhomehtml.php";
?>

		<div id="content" style="float:right;width:85%;">
			Add Driver
			<form action="../../../utility/helper/Driver/DriverActionHelper.php?action=add" method="POST">
			<table>
				<tr><td>Name</td><td><input type="text" name="name" id="name"></td></tr>
				<tr><td>Phone</td><td><input type="text" name="phone" id="phone"></td></tr>
				<tr><td>Address</td><td><textarea name="address" id="address" ></textarea></td></tr>
				<tr><td>Joining Date</td><td><input type="text" name="date_join" id="date_join"></td></tr>
				<tr><td>Description</td><td><textarea name="description" id="description" ></textarea></td></tr>
				<tr><td><input type="submit" value="Add Driver"></td></tr>
			</table>
			</form>
		</div>
	<?php require_once "../../master/footerhome.php"; ?>