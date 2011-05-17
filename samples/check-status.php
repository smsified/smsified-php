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
	
	// Check the status of an SMS message and decode the JSON response from SMSified.
	$response = $sms->checkStatus($senderAddress, "6c7ec0327c18f28b1a6ee2dc3383ae6a");
	$responseJson = json_decode($response);
	var_dump($response);
}

catch (SMSifiedException $ex) {
	echo $ex->getMessage();
}

?>