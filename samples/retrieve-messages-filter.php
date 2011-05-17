<?php

// Include the SMSifed class.
require '../smsified.class.php';

// SMSified Account settings.
$username = "";
$password = "";

try {
	
	// Create a new instance of the SMSified object.
	$sms = new SMSified($username, $password);
	
	// Check the status of an SMS message and decode the JSON response from SMSified.
	$response = $sms->getMessages(null, array("status" => "fail", "direction" => "out"));
	$responseJson = json_decode($response);
	var_dump($response);
}

catch (SMSifiedException $ex) {
	echo $ex->getMessage();
}

?>