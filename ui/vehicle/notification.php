<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
	require_once '../../framework/Vehicle.php';
	require_once '../../framework/Notification.php';
	
	$mNotiResourceList = array();
	$mNotificationList = Vehicle::getAllNotifications();
	//echo sizeof($mNotificationList);
	for($i=0;$i<sizeof($mNotificationList);$i++){
		$noti = new Notification($mNotificationList[$i]);
		array_push($mNotiResourceList, $noti->getResource());
		$temp = $noti->getResource();
		//echo $temp['string']."<br>";
	}
	
	echo json_encode($mNotiResourceList);
?>