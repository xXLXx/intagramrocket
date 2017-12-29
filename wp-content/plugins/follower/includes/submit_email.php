<?php

	$url = 'https://a.klaviyo.com/api/v1/email-templates?api_key=pk_1914c7c0c49493748a43efdf0735d61e59';

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);	 
	$result = curl_exec($ch);
	$items = json_decode((string) $result, true);

	$insta = $name='';
 	$count = 0;

 	foreach ($items['data'] as $key => $value) {

     	if( $value['id'] == 'KsEW3n' )
     	{
         	$insta = $value['html'];
         	$name = $value['name'];
         	break;
     	}

     }

    if( $_POST['email-submit'] != '' ) wp_mail( $_POST['email-submit'], $name, $insta );

	include($dir . "templates/submit_email.php");