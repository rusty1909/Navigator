<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

	require_once '../../framework/Vehicle.php';
	require_once '../../framework/Notification.php';
	
	$mNotiResourceList = array();
	if(!isset($_GET['id'])){
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
		$id = $_GET['id'];
		$mVehicle = new Vehicle($id);
		
		$mNotificationList = $mVehicle->getNotifications();
		//echo sizeof($mNotificationList);
		for($i=0;$i<sizeof($mNotificationList);$i++){
			$noti = new Notification($mNotificationList[$i]);
			$temp = $noti->getResource();
			if(isset($_GET['date'])){
				$date = date("d-m-Y", strtotime($temp['time']));
				$today = date("d-m-Y");
				if($date == $today)
					array_push($mNotiResourceList, $temp);
			} else {
				array_push($mNotiResourceList, $temp);
			}
		}
	}
	echo json_encode($mNotiResourceList);
?>