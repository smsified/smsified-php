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
	
	// Subscribe to status updates for a number and decode the JSON response from SMSified.
	$response = $sms->createSubscription($senderAddress, MessageDirection::$outbound, "http://path-to-somewhere/file.php");
	$responseJson = json_decode($response);
	var_dump($response);
}

catch (SMSifiedException $ex) {
	echo $ex->getMessage();
}

?>