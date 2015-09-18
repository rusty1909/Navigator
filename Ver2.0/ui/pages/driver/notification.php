<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

	require_once '../../framework/Driver.php';
	require_once '../../framework/User.php';
	require_once '../../framework/Notification.php';
	require_once '../../framework/Company.php';
	
	$mUser = new User();
	$companyId = $mUser->getCompany();
	$mCompany = new Company($companyId);
	
	$mNotiResourceList = array();
	if(!isset($_GET['id'])){
		if($mCompany != null)
			$mNotificationList = $mCompany->getAllNotifications();
		else
			$mNotificationList = $mUser->getAllNotifications();
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
		$mDriver = new Driver($id);
		
		$mNotificationList = $mDriver->getNotifications();
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