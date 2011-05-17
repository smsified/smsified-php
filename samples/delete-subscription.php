<?php

// Include the SMSifed class.
require '../smsified.class.php';

// SMSified Account settings.
$username = "";
$password = "";

try {
	
	// Create a new instance of the SMSified object.
	$sms = new SMSified($username, $password);
	
	// Subscribe to status updates for a number and decode the JSON response from SMSified.
	$response = $sms->deleteSubscriptions("8da123e54f91ee0dfb8ead8d4d60a318", MessageDirection::$outbound);
	$responseJson = json_decode($response);
	var_dump($response);
}

catch (SMSifiedException $ex) {
	echo $ex->getMessage();
}

?>