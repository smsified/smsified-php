<?php
/**
 * 
 * A PHP class for interacting with the SMSified API.
 *
 */
class SMSified {
	
	// Private class members.
	private $base_url = 'https://api.smsified.com/v1/';
	private $username;
	private $password;

	
	/**
	 * 
	 * Class constructor
	 * @param string $username
	 * @param string $password
	 */
	public function __construct($username, $password) {
		$this->username = $username;
		$this->password = $password;
	}
	
	/**
	 * 
	 * Send an outbound SMS message.
	 * @param string $senderAddress
	 * @param string $address
	 * @param string $message
	 * @param string $notifyURL
	 */
	public function sendMessage($senderAddress, $address, $message, $notifyURL=NULL) {
		$message = urlencode($message);
		$url = $this->base_url . "smsmessaging/outbound/$senderAddress/requests?address=$address&message=$message";
		if($notifyURL) {
			$url .= "&notifyURL=$notifyURL";
		}
		return self::makeAPICall('POST', $url);
	}
	
	/**
	 * 
	 * Check the delivery status of an outbound SMS message.
	 * @param unknown_type $senderAddress
	 * @param unknown_type $requirestId
	 */
	public function checkStatus($senderAddress, $requestId) {
		$url = $this->base_url . "smsmessaging/outbound/$senderAddress/requests/$requestId/deliveryInfos";
		return self::makeAPICall('GET', $url);
	}
	
	/**
	 * 
	 * Create a subscription.
	 * @param string $senderAddress
	 * @param string $direction
	 * @param string $notifyURL
	 */
	public function createSubscription($senderAddress, $direction, $notifyURL) {
		$url = $this->base_url . "smsmessaging/$direction/$senderAddress/subscriptions?notifyURL=$notifyURL";
		return self::makeAPICall('POST', $url);
	}
	
	/**
	 * 
	 * View subscrptions
	 * @param string $senderAddress
	 * @param string $direction
	 */
	public function viewSubscriptions($senderAddress, $direction) {
		$url = $this->base_url . "smsmessaging/$direction/subscriptions/?senderAddress=$senderAddress";
		return self::makeAPICall('GET', $url);
	}
	
	/**
	 * 
	 * Delete an active subscription.
	 * @param string $subscriptionId
	 * @param string $direction
	 */
	public function deleteSubscriptions($subscriptionId, $direction) {
		$url = $this->base_url . "smsmessaging/$direction/subscriptions/$subscriptionId";
		return self::makeAPICall('DELETE', $url);
	}
	
	/**
	 * 
	 * Get the details of SMS message delivery.
	 * @param string $messageId
	 * @param array $params
	 */
	public function getMessages($messageId=NULL, $params=NULL) {
		$url = $this->base_url . "messages/";
		
		if($messageId) {
			$url .= "$messageId";
		}
		else {
			$url .= '?';
			foreach($params as $key => $value) {
				$url .= "$key=$value&";
			}
		}
		
		return self::makeAPICall('GET', $url);
		
	}
	
	
	/**
	 * Method to make REST API call.
	 *
	 * @param string $method
	 * @param string $url
	 * @param string $payload
	 * @return string JSON
	 */
	private function makeAPICall($method, $url) {

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_USERPWD, $this->username.':'.$this->password);
		
		switch($method) {
			
			case 'POST':
				curl_setopt($ch, CURLOPT_POST, true);
			    break;
			    
			case 'DELETE':
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
				break;
				
			default:
				curl_setopt($ch, CURLOPT_HTTPGET, true);
				break;			
			
		}
		
		$result = curl_exec($ch);
		$error = curl_error($ch);
		$curl_http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		
		if($result === false) {
	    	throw new SMSifiedException('An error occurred: '.$error);
		 } else {
		 	if (substr($curl_http_code, 0, 2) != '20') {
		     throw new SMSifiedException('An error occurred: Invalid HTTP response returned: '.$curl_http_code);
		    }
		  return $result;
		 }		
	}
	
}

/**
 * 
 * A simple class to wrap exceptions.
 *
 */
class SMSifiedException extends Exception {}

/**
 * 
 * Helper class with message direction.
 *
 */
class MessageDirection {
	public static $inbound = 'inbound';
	public static $outbound = 'outbound';
}

?>