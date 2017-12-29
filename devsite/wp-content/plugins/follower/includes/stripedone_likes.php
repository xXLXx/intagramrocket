<?php

	if( ! isset($_GET['random']) ){
		
		wp_redirect( $subscriptionURL );
		exit;

	}

	$sql = 'SELECT * FROM likes where ID='.$_GET['subscription'];
	$result = $wpdb->get_row($sql);

	$price_follower = 0;

	if( ! empty($result) ) $price_follower = $result->price;


	$sql1 = 'SELECT * FROM service where ID = 2';
    $result1 = $wpdb->get_row($sql1);

    $codes = explode(',',$_COOKIE['codes']);
    $codes = array_filter($codes);

    foreach ($codes as $code) {
    	
    	$image_url = 'https://www.instagram.com/p/'.$code.'/';

		$add_example_0 = array(
		    'api_key' => '',
		    'action' => 'add',
		    'service_id' => $result1->service_id,
		    'url' => $image_url,
		    'quantity' => $_COOKIE['likeperpage']
		);

		$order = json_decode(submit_url('http://www.ytbot.com/api.php', $add_example_0));
		date_default_timezone_set('America/Los_Angeles');
		$dates = date("Y/m/d");
			
       	$order_id=$order->id;
        $sql="INSERT INTO orders (link, price,order_id,order_date) VALUES ('$image_url', $price_follower,$order_id,'$dates')";
        $wpdb->query($sql); 

    }
					
	if( $_COOKIE['addservice'] == 1 || $_COOKIE['addservice'] == 2 ){

		$url='https://www.instagram.com/' . $_GET['username'].'/';

		$sql1 = 'SELECT * FROM service where ID = 1';
     	$result1 = $wpdb->get_row($sql1);

     	$quan = 2000;

     	if( $_COOKIE['addservice']==1 ) $quan = 1000;


		$order = $api->order(array('service' => $result1->service_id, 'link' =>$url, 'quantity' => $quan)); 
	   	date_default_timezone_set('America/Los_Angeles');
		$dates = date("Y/m/d");
		
    	$order_id=$order->order;
        $sql="INSERT INTO orders (link, price,order_id,order_date) VALUES ('$url', 0,$order_id,'$dates')";
        $wpdb->query($sql);

	}


    include($dir . "templates/stripedone.php");

    $_SESSION['random']="";

	wp_redirect( get_site_url() . "/success-page/" );
	exit;



