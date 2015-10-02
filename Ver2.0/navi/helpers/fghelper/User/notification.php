<?php
    require_once "../../../utility/helper/Notification/NotificationHelper.php"; 
	
	$mUser = new User();
	$companyId = $mUser->getCompany();
	$mCompany = new Company($companyId);
	
	$mNotiResourceList = array();

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
	echo json_encode($mNotiResourceList);
?>