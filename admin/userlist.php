<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once '../framework/Connection.php';

// opening db connection
$db = new Connection();
$conn = $db->connect();

$ids = array();
$firstname = array();
$lastname = array();
$username = array();
$password = array();
$companyId = array();

$c_ids = array();
$c_name = array();
$c_admin = array();
$c_tin = array();

$sql = "SELECT * FROM user";


//echo "--->".$sql;
$action = mysqli_query($conn, $sql);

if (mysqli_num_rows($action) > 0) {
while($row = mysqli_fetch_assoc($action)) {
		array_push($ids, $row['id']);
		array_push($firstname, $row['firstname']);
		array_push($lastname, $row['lastname']);
		array_push($username, $row['username']);
		array_push($password, $row['password']);
		array_push($companyId, $row['company_id']);
	}
}

$sql = "SELECT * FROM company";
//echo "--->".$sql;
$action = mysqli_query($conn, $sql);

if (mysqli_num_rows($action) > 0) {
while($row = mysqli_fetch_assoc($action)) {
		array_push($c_ids, $row['id']);
		array_push($c_name, $row['name']);
		array_push($c_admin, $row['admin_user']);
		array_push($c_tin, $row['tin_number']);
	}
}
//echo sizeof($ids)."    < size<br>";
//return $result;
?>

<html>
<head><title>Admin Portal</title></head>
<body>
	<b> Member Count : <?php echo sizeof($ids); ?></b><br><br>
	<table border="1" style="border:solid #000">	
		<thead>
			<tr>
			   <th style="width:30">ID</th>
			   <th style="width:400">Name</th>
			   <th style="width:200">Username</th>
			   <th style="width:400">Password</th>
			   <th style="width:200">Company</th>
			</tr>			
		</thead>
		<tbody>
		<?php
		for($i=0;$i<sizeof($ids);$i++){
		?>
			<tr>
			   <td><?php echo $ids[$i]; ?></td>
			   <td><?php echo $firstname[$i]." ".$lastname[$i]; ?></td>
			   <td><?php echo $username[$i]; ?></td>
			   <td><?php echo $password[$i]; ?></td>
			   <td><?php echo $companyId[$i]; ?></td>
			</tr>
		<?php
		}
		?>
		</tbody>
	</table>
	<hr>
	<b> Company Count : <?php echo sizeof($c_ids); ?></b><br><br>
	<table border="1" style="border:solid #000">	
		<thead>
			<tr>
			   <th style="width:30">ID</th>
			   <th style="width:400">Name</th>
			   <th style="width:400">TIN</th>
			   <th style="width:200">Admin</th>
			</tr>			
		</thead>
		<tbody>
		<?php
		for($i=0;$i<sizeof($c_ids);$i++){
		?>
			<tr>
			   <td><?php echo $c_ids[$i]; ?></td>
			   <td><?php echo $c_name[$i]; ?></td>
			   <td><?php echo $c_tin[$i]; ?></td>
			   <td><?php echo $c_admin[$i]; ?></td>
			</tr>
		<?php
		}
		?>
		</tbody>
	</table>
</body>
