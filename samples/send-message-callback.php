<?php

// Include the SMSifed class.
require '../smsified.class.php';

// SMSified Account settings.
$username = "";
$password = "";
$senderAddress = "";

try {	
	
	// Create a new instance of the SMSified object.
	$sms = new SMSified($username, $password);
	
	// Send an SMS message and decode the JSON response from SMSified.
	$response = $sms->sendMessage($senderAddress, "14072341256", "I really love coding in PHP with callback.", "http://path-to-somewhere/file.php");
	$responseJson = json_decode($response);
	var_dump($response);	
}

catch (SMSifiedException $ex) {
	echo $ex->getMessage();
}

