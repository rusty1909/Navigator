<?php
	require_once "../../framework/User.php";
	require_once "../../framework/Client.php";
	$mUser = new User();
	$mClientList = $mUser->getClientList();
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
				<tr><td>Client</td>
					<td><select name="client" id="client"><option> --- Select Client --- </option>
					<?php
					for($i=0; $i<sizeof($mClientList); $i++){
						$mClient = new Client($mClientList[$i]);
						echo "<option value=".$mClientList[$i].">".$mClient->getName()."</option>";
					}
					?>
					</select></td></tr>
				<tr><td>Destination</td><td><textarea name="destination" id="destination" ></textarea></td></tr>
				<tr><td>Description</td><td><textarea name="description" id="description" ></textarea></td></tr>
				<tr><td><input type="submit" value="Add Order"></td></tr>
			</table>
			</form>
		<div>
	</div>
	
</body> 