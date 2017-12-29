<?php

	$transaction = $_REQUEST['PPP_TransactionID'];
	$email = $_REQUEST['email'];

   	date_default_timezone_set('America/Los_Angeles');
	$dates = date("Y/m/d");

	$code = (int) $code;

	$sql="UPDATE createorder SET status = 1 WHERE ID =" . $_REQUEST['item_number_1'];
	$wpdb->query($sql); 

	$sqls = "INSERT INTO orders (link, price,order_id,order_date,transaction_id,email,charge,status,remains) VALUES ('$url', $code,$subscription,'$dates','$transaction','$email', '$code','Custom','$addservice')";
    $wpdb->query($sqls);

    include($dir . "templates/proc/custom.php");

	wp_redirect( get_site_url() . "/success-page/" );
	exit;