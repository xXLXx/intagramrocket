<?php

include($dir . "functions/purchase.process.php");

if( isset($_POST['email-submit']) ){

	include($dir . "includes/submit_email.php");

}elseif( isset($_GET['gateshop']) && isset($_GET['amount']) ){

	$amount = $_GET['amount'];
	include($dir . "includes/gate2shop.php");

}elseif( isset($_GET['stripedone']) && isset($_GET['subscription']) && isset($_GET['username']) && isset($_GET['random']) ){

	include($dir . "includes/stripedone_" . $process . ".php");

}elseif( isset($_GET['getdone']) ){

	require_once($dir . 'Monitor/CMBase.php');
	require_once($dir . 'createsend-php-master/csrest_transactional_smartemail.php');

	include($dir . "includes/payment_success_url.php");

}elseif( isset($_GET['username']) && isset($_GET['subscription']) ){

	$subscription = $_GET['subscription'];
	$username = $_GET['username'];

	include($dir . "includes/order_details_" . $process . ".php");

}elseif( isset($_GET['subscription']) ){

	$subscription = $_GET['subscription'];

	include($dir . "includes/subscription_" . $process . ".php");

}else{
		
	wp_redirect( $returnurl );
	exit;
}










