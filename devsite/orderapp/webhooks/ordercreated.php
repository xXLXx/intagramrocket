<?php

//require_once '../header.php';
require_once '../shopify.php';
require_once '../keys.php';
require_once '../database_config.php';
$data     =(file_get_contents('php://input'));
$fh       =fopen('ordercreated.txt', 'w')  or die("Utyftyftf");


$_HEADERS = apache_request_headers();
$_DOMAIN  =$_HEADERS['X-Shopify-Shop-Domain'];



$array    =json_decode($data);
$order_id = $array->order_number;
$first_name = $array->customer->first_name;
$last_name = $array->customer->last_name;
$created_date = $array->created_at;
$currency = $array->currency;
foreach ($array->line_items as $key => $value) {


	$schedule = $value->properties[0]->value;
	$item_name = $value->name;
	$quantity = $value->quantity;
	$price = $value->price;
	$total_discount = $value->total_discount;


	$date1 = $value->properties[1]->value;
	if($date1!='')
	{

		$sql = "INSERT INTO orderDetails (shopdomain, date1, order_id,schedule,first_name,last_name,created_date,currency,item_name,quantity,price,total_discount)
		VALUES ('$_DOMAIN', '$date1', $order_id,'$schedule','$first_name','$last_name','$created_date','$currency','$item_name','$quantity','$price','$total_discount')";

		$newCon->query($sql);

	}
	$date2 = $value->properties[2]->value;
	if($date2!='')
	{

		$sql = "INSERT INTO orderDetails (shopdomain, date2, order_id,schedule,first_name,last_name,created_date,currency,item_name,quantity,price,total_discount)
		VALUES ('$_DOMAIN', '$date2', $order_id,'$schedule','$first_name','$last_name','$created_date','$currency','$item_name','$quantity','$price','$total_discount')";

		$newCon->query($sql);
	}
	$date3 = $value->properties[3]->value;
	if($date3!='')
	{

		$sql = "INSERT INTO orderDetails (shopdomain, date3, order_id,schedule,first_name,last_name,created_date,currency,item_name,quantity,price,total_discount)
		VALUES ('$_DOMAIN', '$date3', $order_id,'$schedule','$first_name','$last_name','$created_date','$currency','$item_name','$quantity','$price','$total_discount')";

		$newCon->query($sql);
	}
	$date4 = $value->properties[4]->value;
	if($date4!='')
	{

		$sql = "INSERT INTO orderDetails (shopdomain, date4, order_id,schedule,first_name,last_name,created_date,currency,item_name,quantity,price,total_discount)
		VALUES ('$_DOMAIN', '$date4', $order_id,'$schedule','$first_name','$last_name','$created_date','$currency','$item_name','$quantity','$price','$total_discount')";

		$newCon->query($sql);
	}

	$date5 = $value->properties[5]->value;
	if($date5!='')
	{

		$sql = "INSERT INTO orderDetails (shopdomain, date5, order_id,schedule,first_name,last_name,created_date,currency,item_name,quantity,price,total_discount)
		VALUES ('$_DOMAIN', '$date5', $order_id,'$schedule','$first_name','$last_name','$created_date','$currency','$item_name','$quantity','$price','$total_discount')";

		$newCon->query($sql);
	}
	$date6 = $value->properties[6]->value;
	if($date6!='')
	{

		$sql = "INSERT INTO orderDetails (shopdomain, date6, order_id,schedule,first_name,last_name,created_date,currency,item_name,quantity,price,total_discount)
		VALUES ('$_DOMAIN', '$date6', $order_id,'$schedule','$first_name','$last_name','$created_date','$currency','$item_name','$quantity','$price','$total_discount')";

		$newCon->query($sql);
	}
	$date7 = $value->properties[7]->value;
	if($date7!='')
	{

		$sql = "INSERT INTO orderDetails (shopdomain, date7, order_id,schedule,first_name,last_name,created_date,currency,item_name,quantity,price,total_discount)
		VALUES ('$_DOMAIN', '$date7', $order_id,'$schedule','$first_name','$last_name','$created_date','$currency','$item_name','$quantity','$price','$total_discount')";

		$newCon->query($sql);
	}
	$date8 = $value->properties[8]->value;
	if($date8!='')
	{

		$sql = "INSERT INTO orderDetails (shopdomain, date8, order_id,schedule,first_name,last_name,created_date,currency,item_name,quantity,price,total_discount)
		VALUES ('$_DOMAIN', '$date8', $order_id,'$schedule','$first_name','$last_name','$created_date','$currency','$item_name','$quantity','$price','$total_discount')";

		$newCon->query($sql);
	}

	$date9 = $value->properties[9]->value;
	if($date9!='')
	{

		$sql = "INSERT INTO orderDetails (shopdomain, date9, order_id,schedule,first_name,last_name,created_date,currency,item_name,quantity,price,total_discount)
		VALUES ('$_DOMAIN', '$date9', $order_id,'$schedule','$first_name','$last_name','$created_date','$currency','$item_name','$quantity','$price','$total_discount')";

		$newCon->query($sql);
	}
	$date10 = $value->properties[10]->value;
	if($date10!='')
	{

		$sql = "INSERT INTO orderDetails (shopdomain, date10, order_id,schedule,first_name,last_name,created_date,currency,item_name,quantity,price,total_discount)
		VALUES ('$_DOMAIN', '$date10', $order_id,'$schedule','$first_name','$last_name','$created_date','$currency','$item_name','$quantity','$price','$total_discount')";

		$newCon->query($sql);
	}
	


}




fwrite($fh, $data);




?>