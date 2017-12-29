<?php
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