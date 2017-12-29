<?php

function check_account( $username = "" ){

	$url = 'https://www.instagram.com/web/search/topsearch/?context=blended&query='.$username.'&rank_token=0.07259959734289434';

	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_TIMEOUT, 5);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$data = curl_exec($ch);
	curl_close($ch);

	$itemss = json_decode((string) $data, true);

	return $itemss;

}

function createOrder( $process = "", $values = "" ){

	switch( $process ){

		case "follower":

			$url = $values['url'];
			$subscription = $values['subscription'];
			$addservice = $values['addservice'];
			$username = $values['username'];
			$ipaddress = $_SERVER['REMOTE_ADDR'];

			$sql = "INSERT INTO createorder (link, subscription,process,status,addservice, username, ipaddress) VALUES ('$url', $subscription,'$process',0,$addservice, '$username', '$ipaddress')";
			return $sql;

		break;
		case "likes":

			$url = $values['url'];
			$subscription = $values['subscription'];
			$addservice = $values['addservice'];
			$code = $values['code'];
			$likeperpage = $values['likeperpage'];
			$username = $values['username'];
			$ipaddress = $_SERVER['REMOTE_ADDR'];

			$sql="INSERT INTO createorder (link, subscription,process,status,addservice,code,likeperpage, username, ipaddress) VALUES ('$url', $subscription,'$process',0,$addservice,'$code',$likeperpage, '$username', '$ipaddress')";
			return $sql;

		break;
		default:

	}

}

function forApprovalPurchase( $username = "", $current_time = "" ){

	global $wpdb;

	$ip_address = $_SERVER['REMOTE_ADDR'];
	$sql = "Select created_at, ID from createorder where ipaddress = '" . $ip_address . "' AND username = '" . $username . "' AND status = 1 ORDER BY ID DESC LIMIT 1";

	$result1 = $wpdb->get_row($sql);

	if( empty($result1) ) return false;

	$expire_time = strtotime($result1->created_at . "+1 hour");
	$current_time = strtotime($current_time);

	// echo "created at - " . $result1->created_at . "<br>";
	// echo "expire time - " . $expire_time . "<br>";
	// echo "current time - " . $current_time;
	// exit;

	if( $expire_time > $current_time ) return true;

	return false;

}