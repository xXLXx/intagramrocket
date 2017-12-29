<?php
	
	$transaction=$_REQUEST['PPP_TransactionID'];
	$email=$_REQUEST['email'];

	$list_id = 'eb1f5924f666b9c047e658f341d7392f';
	$cm = new CampaignMonitor( $api_key, $client_id, $campaign_id, $list_id );

	$cm->subscriberAddWithCustomFields($email, $email, array('Service Type' => 'Follower'));

	$myemail = $email.' <'.$email.'>';				

	$message = array(
	    "To" => $myemail
	);

	//$wrap->send($message);

	$sql = 'SELECT num_follower, price FROM membership where ID='.$subscription;
	$result = $wpdb->get_row($sql);

	$num_follower = $price_follower=0;

	if( ! empty($result) ){

		$num_follower = $result->num_follower;
		$price_follower = $result->price;

		if( $addservice == 1 || $addservice == 2 ){
    		
    		$quan = 2000;
         	$price_follower = $result->price + 13.98;

    		if( $addservice == 1 )
         	{
         		$quan=1000;
         		$price_follower=$result->price+6.99;
         	}

    		$num_follower = $result->num_follower + $quan;
    	}

	}

	$sql1 = 'SELECT service_id FROM service where ID = 1';
 	$result1 = $wpdb->get_row($sql1);

 	switch ($subscription) {
 		case 1:
 			$service_id = 298;
 			break;
 		
 		default:
 			$service_id = $result1->service_id;
 			break;
 	}

	$forApproval = forApprovalPurchase( $username, $created_at );

	$dates=date("Y/m/d");

 	if( $forApproval ){

 		$item_number = $_REQUEST['item_number_1'];
	    $sql="INSERT INTO orders (link, price,order_date,transaction_id,email, service_type, quantity, item_number, for_approval) VALUES ('$url', $price_follower,'$dates','$transaction','$email', '$service_id', '$num_follower','$item_number', 1)";
	    $wpdb->query($sql);

 	}else{

 		$order = $api->order(array('service' => $service_id, 'link' =>$url, 'quantity' => $num_follower));
	   	date_default_timezone_set('America/Los_Angeles');
		
		$order_id=$order->order;
	    $sql="INSERT INTO orders (link, price,order_id,order_date,transaction_id,email, service_type, quantity) VALUES ('$url', $price_follower,$order_id,'$dates','$transaction','$email', '$service_id', '$num_follower')";
	    $wpdb->query($sql);

 	}

 	$sql="UPDATE createorder SET status = 1 WHERE ID =" . $_REQUEST['item_number_1'];
	$wpdb->query($sql); 

	include($dir . "templates/proc/follower.php");

	wp_redirect( get_site_url() . "/success-page/" );
	exit;

	