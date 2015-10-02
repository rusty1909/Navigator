<?php
	require_once "../../framework/User.php";
	require_once "../../framework/Client.php";
	$mClientList = $mUser->getClientList();
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
				<tr><td style="width:200px;">Name</td>
					<td style="width:200px;">Phone</td>
					<td style="width:200px;">Email</td>
					<td style="width:200px;">Website</td>
					<td style="width:200px;">Action</td>
				</tr>
				<?php
				for($i=0; $i<sizeof($mClientList); $i++) {
					$mClient = new Client($mClientList[$i]);
					echo "<tr>";
					echo "<td>".$mClient->getName()."</td>";
					echo "<td>".$mClient->getPhone()."</td>";
					echo "<td>".$mClient->getEmail()."</td>";
					echo "<td>".$mClient->getWebsite()."</td>";
					echo "<td><input type='submit' value='Assign'><input type='submit' value='Track'></td>";
					echo "</tr>";	
				}
				?>
			</table>
		<div>
	</div>
	
</body> 