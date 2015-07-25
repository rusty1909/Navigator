<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

	$id = "";
	if(isset($_POST['id'])){
		$id = $_POST['id'];
	}

	require_once '../../framework/Vehicle.php';
	require_once '../../framework/Notification.php';
	
	$mNotiResourceList = array();
	if($id == ""){
		$mNotificationList = Vehicle::getAllNotifications();
		//echo sizeof($mNotificationList);
		for($i=0;$i<sizeof($mNotificationList);$i++){
			$noti = new Notification($mNotificationList[$i]);
			$temp = $noti->getResource();
			if($temp['priority'] != 1)
				array_push($mNotiResourceList, $temp);
			
			//echo $temp['string']."<br>";
		}
	} else{
		$mNotificationList = Vehicle::getAllNotifications();
		//echo sizeof($mNotificationList);
		for($i=0;$i<sizeof($mNotificationList);$i++){
			$noti = new Notification($mNotificationList[$i]);
			$temp = $noti->getResource();
			array_push($mNotiResourceList, $temp);
			
			//echo $temp['string']."<br>";
		}
	}
	echo json_encode($mNotiResourceList);
?>