<?php
	
	$_SESSION = array(
		'byline' => '',
		'following' => '',
		'full_name' => '',
		'profile_pic_url' => '',
		'post' => '',
		'username' => '',
	);

	$sql = 'SELECT * FROM membership where ID = ' . $subscription;
	$result = $wpdb->get_row($sql);

	$num_follower = $price_follower = 0;

	if( ! empty($result) ){
		$num_follower = $result->num_follower;
		$price_follower = $result->price;
	}

	include($dir . "templates/subscription_" . $process . ".php");