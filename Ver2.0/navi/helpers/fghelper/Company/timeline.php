<?php
	require_once '../../../framework/Company.php';
	require_once '../../../framework/User.php';
	require_once '../../../framework/Timeline.php';
	
	$mUser = User::getCurrentUser();
	$mCompany = new Company($mUser->getCompany());
	
	$mTimelineResourceList = array();

	$mTimelineList = $mCompany->getTimeline();
	for($i=0;$i<sizeof($mTimelineList);$i++){
		$tl = new Timeline($mTimelineList[$i]);
		$temp = $tl->getResource();
		array_push($mTimelineResourceList, $temp);
	}
	
	echo json_encode($mTimelineResourceList);
?>