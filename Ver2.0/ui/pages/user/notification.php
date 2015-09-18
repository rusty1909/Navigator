<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
	require_once '../../framework/Vehicle.php';
	require_once '../../framework/Notification.php';
	
	$mUser = new User();
	$companyId = $mUser->getCompany();
	$mCompany = new Company($companyId);
	
	$mNotiResourceList = array();

	if($companyId != -1)
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
	echo json_encode($mNotiResourceList);
?>