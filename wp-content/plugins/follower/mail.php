<?php
	

			require_once('Monitor/CMBase.php');
			require_once 'createsend-php-master/csrest_transactional_smartemail.php';

			$api_key = '3f6d08bfb3660944e3e9f57aaf27b84c';
			$client_id = '69cd88f8ca0fb3298fe241c22d7c5928';
			$campaign_id = null;
			$email='sahil_kaushal@esferasoft.com';
			$auth = array('api_key' => 'fe1370b8e353bdcdc891eb91db0a72738a32bc19e1072efd');

			# The unique identifier for this smart email
			$smart_email_id = '8cafe4be-25f8-4df6-a623-5e33e1e3dc43';

			# Create a new mailer and define your message
			$wrap = new CS_REST_Transactional_SmartEmail($smart_email_id, $auth);


			$list_id = 'eb1f5924f666b9c047e658f341d7392f';
						$cm = new CampaignMonitor( $api_key, $client_id, $campaign_id, $list_id );

						$cm->subscriberAddWithCustomFields($email, $email, array('Service Type' => 'Follower'));

						$myemail=$email.' <'.$email.'>';				
						
						$message = array(
						    "To" => $myemail
						);

						
						$wrap->send($message);



die;

require_once 'csrest_transactional_smartemail.php';


	
# Authenticate with your API key
$auth = array('api_key' => 'fe1370b8e353bdcdc891eb91db0a72738a32bc19e1072efd');

# The unique identifier for this smart email
$smart_email_id = '8cafe4be-25f8-4df6-a623-5e33e1e3dc43';

# Create a new mailer and define your message
$wrap = new CS_REST_Transactional_SmartEmail($smart_email_id, $auth);
$message = array(
    "To" => 'Ranju <sahil_kaushal@esferasoft.com>'
);

# Send the message and save the response
$result = $wrap->send($message);

?>