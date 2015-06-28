<?php
require_once '../../framework/Connection.php';
require_once '../../framework/User.php';
if(!isset($_SESSION))
	session_start();

$user = $_SESSION['user']['username'];

// opening db connection
$db = new Connection();
$conn = $db->connect();

$ids = array();
$problems = array();
$states = array();
$solutions = array();
$closedBy = array();
$addedBy = array();
$dateAdded = array();
$dateClosed = array();

$sql = "SELECT * FROM issue";
//echo "--->".$sql;
$action = mysqli_query($conn, $sql);

if (mysqli_num_rows($action) > 0) {
while($row = mysqli_fetch_assoc($action)) {
		array_push($ids, $row['id']);
		array_push($problems, $row['problem']);
		array_push($states, $row['state']);
		array_push($solutions, $row['solution']);
		array_push($closedBy, $row['closed_by']);
		array_push($addedBy, $row['added_by']);
		array_push($dateAdded, $row['date_added']);
		array_push($dateClosed, $row['date_closed']);
	}
}
//echo sizeof($ids)."    < size<br>";
//return $result;
?>

<html>
<head>Issue Report<title>Issue Portal</title></head>
<body>
	<form action="addissue.php" method="POST">
	Problem<br>
	<textarea cols='150' rows='10' name='issue' id='issue'></textarea>
	<input type="submit" value="submit issue">
	</form>
	<hr>
	<b> Issue Count : <?php echo sizeof($ids); ?></b><br><br>
	<table border="1" style="border:solid #000">	
		<thead>
			<tr>
			   <th style="width:100">State</th>
			   <th style="width:30">ID</th>
			   <th style="width:400">Problem</th>
			   <th style="width:200">Added By</th>
			   <th style="width:400">Solution</th>
			   <th style="width:200">Closed By</th>
			</tr>			
		</thead>
		<tbody>
		<?php
		for($i=0;$i<sizeof($ids);$i++){
		?>
			<tr>
			   <td style='<?php if($states[$i] == "open") echo "background:#f00"; ?>'><?php echo $states[$i]." "; 
					if($states[$i] == "open" &&($user == "rusty" || $user == "dheerajagrawal19@live.com")){
					?><a href="resolve.php?id=<?php echo $ids[$i]; ?>">Resolve</a>
					<?php }
					?></th>
			   <td><?php echo $ids[$i]; ?></th>
			   <td><?php echo $problems[$i]; ?></th>
			   <td style="font-size:13px"><?php echo User::getUserInfo($addedBy[$i])."<br>".$dateAdded[$i]; ?></th>
			   <td><?php echo $solutions[$i]; ?></th>
			   <td style="font-size:13px"><?php echo User::getUserInfo($closedBy[$i])."<br>".$dateClosed[$i]; ?></th>
			</tr>
		<?php
		}
		?>
		</tbody>
</body>