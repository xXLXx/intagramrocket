<?php

	$sql = 'SELECT num_follower, price, sale FROM membership where ID=' . $subscription;
	$result = $wpdb->get_row($sql);

	$num_follower = $price_follower = $sale = 0;

	if( ! empty($result) ){

		$num_follower = $result->num_follower;
		$price_follower = $result->price;
		$sale = $result->sale;

	}

	$insta = array();


	// $username = str_replace(' ', '', $username);
	$username = trim($username, " ");


	$check_account = check_account( $username );

	if( ! empty($check_account['users']) ){

		foreach ($check_account['users'] as $key => $value) {
			
			if($value['user']['username'] == strtolower($username)){
	         	$insta['username']= $value['user']['username'];
	         	$insta['full_name']= $value['user']['full_name'];
	         	$insta['byline']= $value['user']['byline'];
	         	$insta['profile_pic_url']= $value['user']['profile_pic_url'];
	         	break;
         	}

		}

	}

	if( empty($insta) ){

		$url=get_site_url().'/follower?subscription=' . $subscription . '&e=1';
		wp_redirect( $url );
		exit;
	}

	$_SESSION = array(
		"byline" => $insta["byline"],
		"full_name" => $insta["full_name"],
		"profile_pic_url" => $insta["profile_pic_url"],
		"username" => $insta["username"],
		"subscription" => $subscription,
		"process" => $process
	);

	$length=6;
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $random = '';
    for ($i = 0; $i < $length; $i++) {
        $random .= $characters[rand(0, $charactersLength - 1)];
    }

   
	$_SESSION['random']=$random;
	echo '<span class="session">';
	echo $_SESSION['random'];
	echo '</span>';

	if( isset($_GET['coupon_code']) ){

		$status = $discount = $coupon_status = 0;
		$message = 'Invalid Coupon.';

		date_default_timezone_set('America/Los_Angeles');
		$today = date('Y-m-d');

		$sql = 'SELECT expiry, rate FROM coupon where coupon_name="' . $_GET['coupon_code'] . '"';
		$result = $wpdb->get_row($sql);

		if( ! empty($result) ){

			$time = strtotime($result->expiry);
			$expiryDate = date('Y-m-d',$time);

			if( $today <= $expiryDate ){

				$coupon_status = 1;
				$discount = ($price_follower * $result->rate) / 100;
				$price_follower = $price_follower - $discount;
				$price_follower = (float) $price_follower;
				$price_follower = number_format( $price_follower, 2, '.', '' );

				$message = 'Coupon Success';

			}else{

				$coupon_status = 0;
				$price_follower = (float) $price_follower;
				$price_follower = number_format( $price_follower, 2, '.', '' );

				$message = 'Coupon Expired';

			}
		}
	}

	include($dir . "templates/order_details_" . $process . ".php");