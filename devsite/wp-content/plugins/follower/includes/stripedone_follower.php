<?php

	if( ! isset($_GET['random']) ){
		
		wp_redirect( $subscriptionURL );
		exit;

	}

	$sql = 'SELECT * FROM membership where ID = ' .$_GET['subscription'];
	$result = $wpdb->get_row($sql);

	$num_follower = $price_follower = 0;

	if( ! empty($result) ){

		$num_follower = $result->num_follower;
     	$price_follower = $result->price;

		if( $_COOKIE['addservice'] == 1 || $_COOKIE['addservice'] == 2 ){
    		
    		$quan = 2000;
    		$price_follower = $result->price + 13.98;

    		if( $_COOKIE['addservice'] == 1 )
         	{
         		$quan = 1000;
         		$price_follower = $result->price + 6.99;
         	}

    		$num_follower = $result->num_follower + $quan;
    	}

	}

	$url='https://www.instagram.com/'.$_GET['username'].'/';

	$sql1 = 'SELECT * FROM service where ID = 1';
 	$result1 = $wpdb->get_row($sql1);


	$order = $api->order(array('service' => $result1->service_id, 'link' =>$url, 'quantity' => $num_follower));
   	date_default_timezone_set('America/Los_Angeles');
	$dates = date("Y/m/d");
	

	$order_id = $order->order;
    $sql = "INSERT INTO orders (link, price,order_id,order_date) VALUES ('$url', $price_follower,$order_id,'$dates')";
    $wpdb->query($sql);


    include($dir . "templates/stripedone.php");

    $_SESSION['random']="";

	wp_redirect( get_site_url() . "/success-page/" );
	exit;



