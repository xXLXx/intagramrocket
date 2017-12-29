<?php

	$transaction=$_REQUEST['PPP_TransactionID'];
	$email=$_REQUEST['email'];
			
	$list_id = 'a7fd6ed04a1ecf8722974a60b799e534';
	$cm = new CampaignMonitor( $api_key, $client_id, $campaign_id, $list_id );

	$cm->subscriberAddWithCustomFields($email, $email, array('Service Type' => 'Likes'));


	$myemail=$email.' <'.$email.'>';				

	$message = array(
	    "To" => $myemail
	);

	$subscription = 'SELECT price FROM likes where ID=' . $subscription;
	$subscription_result = $wpdb->get_row($subscription);

    $price_follower = 0;

    if( ! empty($subscription_result) ) $price_follower = $subscription_result->price;

	$sql = 'SELECT service_id FROM service where ID = 2';
    $service = $wpdb->get_row($sql);

	$code_Array = explode(',', $code);
	$code_Array = array_filter($code_Array);

	foreach ($code_Array as $_code) {
		
		$image_url = 'https://www.instagram.com/p/'.$_code.'/';
		
		$params = array('service' => $service->service_id, 'link' =>$image_url, 'quantity' => $likeperpage);
		$order = $api->order($params); 

   		date_default_timezone_set('America/Los_Angeles');
		$dates = date("Y/m/d");

  		$order_id = $order->order;

  		$sql = "INSERT INTO orders (link, price,order_id,order_date,transaction_id,email, service_type, quantity) VALUES ('$image_url', $price_follower,$order_id,'$dates','$transaction','$email', '$service->service_id', '$likeperpage')";
        $wpdb->query($sql); 

	}

	if( $addservice == 1 || $addservice == 2 ){

		$sql1 = 'SELECT * FROM service where ID = 1';
	    $result1 = $wpdb->get_row($sql1);

	    $quan=2000;
	    if( $addservice == 1 ) $quan=1000;

		$order = $api->order(array('service' => $result1->service_id, 'link' => $url, 'quantity' => $quan)); 
		date_default_timezone_set('America/Los_Angeles');
		$dates = date("Y/m/d");
				
	    $order_id = $order->order;
	    $sql = "INSERT INTO orders (link, price,order_id,order_date,transaction_id,email, service_type, quantity) VALUES ('$url', 0,$order_id,'$dates','$transaction','$email', '$result1->service_id', '$quan')";
	    $wpdb->query($sql);

	}  
	
  	$sql = "UPDATE createorder SET status = 1 WHERE ID = " . $_REQUEST['item_number_1'];
	$wpdb->query($sql); 

	include($dir . "templates/proc/likes.php");

	wp_redirect( get_site_url() . "/success-page/" );
	exit;