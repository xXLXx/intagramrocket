<?php
	//Sample using the CMBase.php wrapper to call Subscribers.GetActive from any version of PHP
	
	//Relative path to CMBase.php. This example assumes the file is in the same folder
	require_once('CMBase.php');
	
	//Your API Key. Go to http://www.campaignmonitor.com/api/required/ to see where to find this and other required keys
	
	$api_key = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';
	$client_id = null;
	$campaign_id = null;
	$list_id = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';
	$date = '2000-01-01'; // Subscribers added after this date will be returned. Use the format YYYY-MM-DD HH:MM:SS
	$cm = new CampaignMonitor($api_key, $client_id, $campaign_id, $list_id);
	
	//Optional statement to include debugging information in the result
	//$cm->debug_level = 1;
	
	$result = $cm->subscribersGetActive($date, $list_id);
	
	if ($result['anyType']['Code'] == 0) {
		echo 'Success';
		print_r($result);
	} else {
		echo 'Error : ' . $result['anyType']['Message'];
	}
	
	//Print out the debugging info
	//print_r($cm);
?>