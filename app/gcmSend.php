<?php

	if(!isset($_GET['regkey']) || !isset($_GET['message'])) {
		echo "fail";
	} else{
		$registatoin_ids = array($_GET['regkey']);
		$message = array('data1' => $_GET['message']);		
		//$message = json_encode($msg);
		
		$url = 'https://android.googleapis.com/gcm/send';
		$fields = array(
			'registration_ids' => $registatoin_ids,
			'data' => $message,
		);
		// Update your Google Cloud Messaging API Key
		define("GOOGLE_API_KEY", "AIzaSyCHqUJxbs3XYWSRTVeSiR6pUILkkzg5vew"); 		
		$headers = array(
			'Authorization: key=' . GOOGLE_API_KEY,
			'Content-Type: application/json'
		);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);	
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
		$result = curl_exec($ch);				
		if ($result === FALSE) {
			echo('Curl failed: ' . curl_error($ch));
		}
		curl_close($ch);
		echo $result;
	}
	

?>