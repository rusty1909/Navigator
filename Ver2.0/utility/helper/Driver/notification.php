<?php
    require_once "../../../utility/helper/Driver/DriverHelper.php"; 
    require_once "../../../utility/helper/Common/CommonHelper.php"; 
	
    $companyId = $mUser->getCompany();
	
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