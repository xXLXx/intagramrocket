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

			$sql = "INSERT INTO createorder (link, subscription,process,status,addservice) VALUES ('$url', $subscription,'$process',0,$addservice)";
			return $sql;

		break;
		case "likes":

			$url = $values['url'];
			$subscription = $values['subscription'];
			$addservice = $values['addservice'];
			$code = $values['code'];
			$likeperpage = $values['likeperpage'];

			$sql="INSERT INTO createorder (link, subscription,process,status,addservice,code,likeperpage) VALUES ('$url', $subscription,'$process',0,$addservice,'$code',$likeperpage)";
			return $sql;

		break;
		default:

	}

}