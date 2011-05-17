<?php

/*
 * Convenience class that parses inbound SMSified JSON into a simple object.
 */
class InboundMessage {

	// Class properties.
	protected $timeStamp;
	protected $destinationAddress;
	protected $message;
	protected $messageId;
	protected $senderAddress;

	// Class constructor.
	public function __construct($json) {
		$notification = json_decode($json);
		$this->timeStamp = $notification->inboundSMSMessageNotification->inboundSMSMessage->dateTime;
		$this->destinationAddress = $notification->inboundSMSMessageNotification->inboundSMSMessage->destinationAddress;
		$this->message = $notification->inboundSMSMessageNotification->inboundSMSMessage->message;
		$this->messageId = $notification->inboundSMSMessageNotification->inboundSMSMessage->messageId;
		$this->senderAddress = $notification->inboundSMSMessageNotification->inboundSMSMessage->senderAddress;
	}
	
	public function getTimeStamp() {
		return $this->timeStamp;
	}
	
	public function getDestinationAddress() {
		return $this->destinationAddress;
	}
	
	public function getMessage() {
		return $this->message;
	}
	
	public function getMessageId() {
		return $this->messageId;
	}
	
	public function getSenderAddress() {
		return $this->senderAddress;
	}

}

?>