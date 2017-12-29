<?php
	//Sample using the CMBase.php wrapper to call Subscriber.AddWithCustomFields from any version of PHP
	
	//Relative path to CMBase.php. This example assumes the file is in the same folder
	require_once('CMBase.php');
	
	//Your API Key. Go to http://www.campaignmonitor.com/api/required/ to see where to find this and other required keys
	
	$api_key = '3f6d08bfb3660944e3e9f57aaf27b84c';
	$client_id = '69cd88f8ca0fb3298fe241c22d7c5928';
	$campaign_id = null;
	$list_id = 'b6ba12735f5a34b04af974f1a5cd2869';
	$cm = new CampaignMonitor( $api_key, $client_id, $campaign_id, $list_id );


	
	//Optional statement to include debugging information in the result
	//$cm->debug_level = 1;
	
	//This is the actual call to the method, passing email address, name.
	$result = $cm->subscriberAdd('test@esferasoft.com', 'Ranju');

	print_r($result);
	die;

	
	if($result['Result']['Code'] == 0)
		echo 'Success';
	else
		echo 'Error : ' . $result['Result']['Message'];
	
	//Print out the debugging info
	//print_r($cm);
?>