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
	$response = $sms->sendMessage($senderAddress, "14078971234", "PHP Rocks!");
	$responseJson = json_decode($response);
	var_dump($response);	
}

catch (SMSifiedException $ex) {
	echo $ex->getMessage();
}

