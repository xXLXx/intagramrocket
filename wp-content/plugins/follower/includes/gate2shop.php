<?php

	$url = 'https://www.instagram.com/'.$_SESSION['username'].'/';
	$secret_key = "D2V7CfsAaeWU3bi1Ee7BGb65DLsJM4UKRk8W2yT8se3cYAAeUEVUlHhYGqlp6LaL";
	
	$process = $_SESSION['process'];

	$params = array(
		"url" => $url,
		"subscription" => $_SESSION['subscription'],
		"addservice" => $_COOKIE['addservice'],
	);

	if( $process == "likes" ){
		$params["code"] = $_COOKIE['codes'];
		$params["likeperpage"] = $_COOKIE['likeperpage'];
	}

	$sql = createOrder($process, $params);
    $wpdb->query($sql);

    $lastid = $wpdb->insert_id;

	$timestamp = date("Y-m-d.h:i:s",time());

	$params = array(
		'currency' => 'USD',
        'item_name_1' => 'Instagram Promotion Package',
        'item_number_1' => $lastid,
        'item_amount_1' => $amount,
        'item_quantity_1' => '1',
        'numberofitems' => '1',
        'encoding' => 'utf-8',    
        'merchant_id' =>'5788005443334360451',    
        'merchant_site_id' =>'161739',
        'time_stamp' => $timestamp, 
        'version' => "3.0.0",
        'success_url' => get_site_url() . '/follower?getdone=1',
        'invoice_id' => (int)($lastid).'_'.date('YmdHis'),
        'merchant_unique_id' => (int)($lastid).'_'.date('YmdHis'),
        'total_amount' => number_format($amount,2,'.', ''),
        'handling' => 0 
    );

	$JoinedInfo = "";
	$JoinedInfo .= $params['merchant_id'];
	$JoinedInfo .= $params['currency'];
	$JoinedInfo .= $params['total_amount'];
	$JoinedInfo .= $params['item_name_1'];
	$JoinedInfo .= $params['item_amount_1'];
	$JoinedInfo .= $params['item_quantity_1'];
	$JoinedInfo .= $timestamp;

	$params["checksum"] = md5($secret_key . $JoinedInfo);           
	 
	$query_string = "";
	foreach($params as $key => $value) { 
		$string = $key . "=".urlencode($value)."&";
		$query_string .= $string; 
	}

	$query_string = rtrim($query_string, "&");
	 
	header("Location:"."https://secure.gate2shop.com/ppp/purchase.do?" . $query_string);