<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

	require_once '../../framework/Company.php';
	require_once '../../framework/User.php';
	require_once '../../framework/Timeline.php';
	
	$mUser = User::getCurrentUser();
	$mCompany = new Company($mUser->getCompany());
	
	$mTimelineResourceList = array();

	$mTimelineList = $mCompany->getTimeline();
	//echo sizeof($mTimelineList);
	for($i=0;$i<sizeof($mTimelineList);$i++){
		$tl = new Timeline($mTimelineList[$i]);
		$temp = $tl->getResource();
		//echo $temp['type'];
		array_push($mTimelineResourceList, $temp);
	}
	
	echo json_encode($mTimelineResourceList);
?>