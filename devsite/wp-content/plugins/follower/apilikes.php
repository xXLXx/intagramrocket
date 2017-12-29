<?php

function submit_url($url, $post)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    if (isset($post)) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    }
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    $content = curl_exec($ch);
    curl_close($ch);
    return $content;
}




// $add_example_0 = array(
//     'api_key' => 'tUZyuuSLnAgpYTTQMs7eWltEW',
//     'action' => 'add',
//     'service_id' => 262,
//     'url' => 'https://www.instagram.com/p/BSkekoSBRHe/',
//     'quantity' => 50,
//     'order_mode' => 'dripfeed',
//     'dripfeed_quantity' => 20,
//     'dripfeed_interval' => 0.2
// );


// $stat_example_1 = array(
//     'api_key' => 'tUZyuuSLnAgpYTTQMs7eWltEW',
//     'action' => 'status',
//     'order_id' => 4981,
//     'order_mode' => 'dripfeed'
// );


// $order = json_decode(submit_url('http://www.ytbot.com/api.php', $stat_example_1)); 


// print_r($order);
// die();
                        

/*
$result = json_decode(submit_url('http://www.ytbot.com/api.php', $add_example_1)); //adding custom youtube comments
if ($result->id) {
    //means order was successfully submitted so now you can store the id($result->id)in your database
} else {
    echo $result->error_msg;
}

$result = json_decode(submit_url('http://www.ytbot.com/api.php', $add_example_2)); //adding soundcloud plays
var_dump($result);

$result = json_decode(submit_url('http://www.ytbot.com/api.php', $add_example_4)); //calculating price for automatic instagram likes
var_dump($result);

$result = json_decode(submit_url('http://www.ytbot.com/api.php', $add_example_5)); //adding automatic instagram likes
var_dump($result);

$result = json_decode(submit_url('http://www.ytbot.com/api.php', $add_example_6)); //adding dripfeed youtube views
var_dump($result);


$result = json_decode(submit_url('http://www.ytbot.com/api.php', $stat_example_1)); //checking order status
if (!isset($result->error_msg)) {
    echo "status:$result->status\n";
    echo "start_count:$result->start_count\n";
    echo "current_count:$result->current_count";
} else {
    echo $result->error_msg;
}

$result = json_decode(submit_url('http://www.ytbot.com/api.php', $stat_example_2)); //checking order status for automatic services
var_dump($result);


$result = json_decode(submit_url('http://www.ytbot.com/api.php', $stat_example_3)); //checking order status for dripfeed services
var_dump($result);


$result = json_decode(submit_url('http://www.ytbot.com/api.php', $delete_example_1)); //delete order
var_dump($result);
*/

?>