<?php
require_once "../../../utility/helper/Common/CommonHelper.php"; 

	$companyId = $mUser->getCompany();
	
	$mNotiResourceList = array();
	if(!isset($_GET['id'])){
		if($companyId != -1)
			$mNotificationList = $mCompany->getAllNotifications();
		else
			$mNotificationList = $mUser->getAllNotifications();
		for($i=0;$i<sizeof($mNotificationList);$i++){
			$noti = new Notification($mNotificationList[$i]);
			$temp = $noti->getResource();
			if($temp['priority'] != 1)
				array_push($mNotiResourceList, $temp);
		}
	} else {
		$id = $_GET['id'];
		$mVehicle = new Vehicle($id);
		
		$mNotificationList = $mVehicle->getNotifications();
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