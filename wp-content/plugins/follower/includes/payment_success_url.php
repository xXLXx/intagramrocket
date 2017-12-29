<?php

	if( ! isset($_REQUEST['item_number_1']) ){

		$url = get_site_url();
		wp_redirect( $url );
		exit;

	}

	$sql = "SELECT * FROM createorder where status = 0 and ID=" . $_REQUEST['item_number_1'];
	$result = $wpdb->get_row($sql);

	if( empty($result) ){

		$redirect_url = get_site_url();
		wp_redirect( $redirect_url );
		exit;

	}

	$process = $result->process;
    $subscription = $result->subscription;
    $url = $result->link;
	$addservice = $result->addservice;
	$code = $result->code;
	$likeperpage = $result->likeperpage;

	$api_key = '3f6d08bfb3660944e3e9f57aaf27b84c';
	$client_id = '69cd88f8ca0fb3298fe241c22d7c5928';
	$campaign_id = null;
	
	$auth = array('api_key' => 'fe1370b8e353bdcdc891eb91db0a72738a32bc19e1072efd');

	# The unique identifier for this smart email
	$smart_email_id = '8cafe4be-25f8-4df6-a623-5e33e1e3dc43';

	# Create a new mailer and define your message
	$wrap = new CS_REST_Transactional_SmartEmail($smart_email_id, $auth);

	switch ( $process ) {
		case 'follower':
			
			include($dir . "includes/proc/follower.php");

			break;

		case 'likes':
			
			include($dir . "includes/proc/likes.php");

			break;

		case 'autolikes':

			include($dir . "includes/proc/autolikes.php");

			break;
		
		default:
			
			include($dir . "includes/proc/custom.php");

			break;
	}

