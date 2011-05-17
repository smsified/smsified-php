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


