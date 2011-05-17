PHP Library for the SMSified API
=========================

A PHP library for interaction with the [SMSified](http://smsified.com) API.

SMSified API Overview
---------------------

SMSified is a simple REST SMS API, built to uniquely enable developers to create powerful SMS services with minimum effort. Through SMSified, developers can both send and receive SMS messages, as well as track usage and message history through a powerful reporting dashboard. You can use either standard phone numbers or short codes, and best of all, SMSified is backed by Voxeo - the world's largest real-time application cloud.

When you sign up, you automatically receive $20 in credit and one free phone number; this allows you to both receive and send free SMS messages while testing. When the credit runs out, just add a credit card for billing and you're live - but you get to keep the phone number for free! Check out our pricing page for more information.

More info here: [SMSified API Docs](http://smsified.eng.voxeo.com/docs)

Sending Outbound SMS Messages
-----------------------------

Here is a simple example of sending an outbound SMS message from (518) 432-1234 to (407) 897-1234.

	<?php
	
	// Include the SMSifed class.
	require 'path/to/smsified.class.php';

	try {	
		
		// Create a new instance of the SMSified object.
		$sms = new SMSified("username", "password");
		
		// Send an SMS message and decode the JSON response from SMSified.
		$response = $sms->sendMessage("5184321234", "14078971234", "PHP Rocks!");
		$responseJson = json_decode($response);
		var_dump($response);	
	}
	
	catch (SMSifiedException $ex) {
		echo $ex->getMessage();
	}
	
	?>

You can also set a callback URL where SMSified will send a JSON payload with the delivery status of your outbound message.  See the samples directory for more code samples.

Processing Inbound SMS Messages
-------------------------------

The SMSified PHP library also includes a convenience class that makes it easy to process and record inbound SMS messages.  In the example below, the InboundMessage class is extend to create a custom method for converting the JSON sent from SMSified on delivery status to a simple CSV string.

	<?php
	
	// Include the inboubd SMS class.
	require '../inbound.class.php';
	
	// Create a new custom object by extending the InboundMessage class.
	class SMSInbound extends InboundMessage {
		
		// Call the parent constructor, which parses SMSified JSON and sets class properties.
		public function __construct($json) {
			parent::__construct($json);
		}
		
		// Create a new method for the child class.
		public function __toString() {
			$csv = "";
			foreach($this as $key => $value) {
				$csv .= $value . ",";
			}
			$csv .= "\n";
			return $csv;
		}
	}
		
	// Get the JSON payload sumbitted from SMSified.
	$json = file_get_contents("php://input");
	
	// Create a new instance of the custom object.
	$sms = new SMSInbound($json);
	
	// Save SMS record to a text file using child class method for printing object.
	$fh = fopen('smsified.txt', 'a');
	fwrite($fh, sprintf($sms));
	fclose($fh);
	
	?>

You can extend the InboundMessage class to do anything you like with the JSON payload delivered from SMSified.  

Getting Delivery Status Information
-----------------------------------

The SMSified API also allows you to query the status of an SMS message, to better determine if it has been delivered.  The example below shows how to query the status of a specific SMS message.

	<?php
	
	// Include the SMSifed class.
	require '../smsified.class.php';
	
	try {
		
		// Create a new instance of the SMSified object.
		$sms = new SMSified("username", "password");
		
		// Check the status of an SMS message and decode the JSON response from SMSified.
		$response = $sms->getMessages("047bb537cca6f278c2d59729fd7w1456");
		$responseJson = json_decode($response);
		var_dump($response);
	}
	
	catch (SMSifiedException $ex) {
		echo $ex->getMessage();
	}

	?>