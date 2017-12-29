<?php

	$transaction = $_REQUEST['PPP_TransactionID'];
	$email = $_REQUEST['email'];	

	$list_id = 'edef7ff6f89aedb7bfff1afcd41818d9';
	$cm = new CampaignMonitor( $api_key, $client_id, $campaign_id, $list_id );

	$cm->subscriberAddWithCustomFields($email, $email, array('Service Type' => 'Auto Likes'));	

	$myemail=$email.' <'.$email.'>';				
	
	$message = array(
	    "To" => $myemail
	);

	//$wrap->send($message);

 	$sql = 'SELECT price, num_like, num_like_max, d_num_like, d_num_like_max FROM likeslikes where ID= ' . $subscription;
 	$result = $wpdb->get_row($sql);

 	$price_follower = $num_like = $num_like_max = $d_num_like = $d_num_like_max=0;

 	if( ! empty($result) ){

 		$price_follower = $result->price;
		$num_like = $result->num_like;
		$num_like_max = $result->num_like_max;

		$d_num_like = $result->d_num_like;
		$d_num_like_max = $result->d_num_like_max;

 	}

	$sql1 = 'SELECT service_id FROM service where ID = 3';
	$result1 = $wpdb->get_row($sql1);

	$add_example_0 = array( 
	    'api_key' => 'tUZyuuSLnAgpYTTQMs7eWltEW',
	    'action' => 'add',
	    'service_id' => $result1->service_id,
	    'url' => $url,
	    'dripfeed_mode' => true,
	    'dripfeed_adv' => true,
	    'dripfeed_interval' => '0.25',
	    'min' => $num_like,
	    'max' => $num_like_max,
	    'd_min' => $d_num_like,
	    'd_max' => $d_num_like_max,
	    'new_s' => '5',
	    'seed' => '3432'
	);

	$order = json_decode(submit_url('http://www.ytbot.com/api.php', $add_example_0));
	date_default_timezone_set('America/Los_Angeles');
	$dates = date("Y/m/d");
	
	$order_id = $order->id;
    $sql = "INSERT INTO orders (link, price,order_id,order_date,transaction_id,email, service_type, quantity) VALUES ('$url', $price_follower,$order_id,'$dates','$transaction','$email', '$result1->service_id', '$num_like')";
    $wpdb->query($sql); 

    if( $addservice == 1 || $addservice == 2 ){

		$sql1 = 'SELECT service_id FROM service where ID = 1';
		$result1 = $wpdb->get_row($sql1);

		$quan=2000;
		if($addservice==1) $quan=1000;

		$order = $api->order(array('service' => $result1->service_id, 'link' =>$url, 'quantity' => $quan)); 
	   	date_default_timezone_set('America/Los_Angeles');
		$dates = date("Y/m/d");
							
	  	$order_id = $order->order;
      	$sql = "INSERT INTO orders (link, price,order_id,order_date,transaction_id,email, service_type, quantity) VALUES ('$url', 0,$order_id,'$dates','$transaction','$email', '$result1->service_id', '$quan')";
      	$wpdb->query($sql);

	} 

	$sql = "UPDATE createorder SET status = 1 WHERE ID = " . $_REQUEST['item_number_1'];
    $wpdb->query($sql); 

    include($dir . "templates/proc/autolikes.php");

	wp_redirect( get_site_url() . "/success-page/" );
	exit;