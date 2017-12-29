<?php
   class Api
   {
      public $api_url = 'http://instant-fans.com/api/v2'; // API URL

      public $api_key = '0576506bd4d0272004abb2f2e21b2951'; // Your API key

      public function order($data) { // add order
        $post = array_merge(array('key' => $this->api_key, 'action' => 'add'), $data);
        return json_decode($this->connect($post));
      }

      public function status($order_id) { // get order status
        return json_decode($this->connect(array(
          'key' => $this->api_key,
          'action' => 'status',
          'id' => $order_id
        )));
      }

      public function services() { // get services
        return json_decode($this->connect(array(
          'key' => $this->api_key,
          'action' => 'services',
        )));
      }


      private function connect($post) {
        $_post = Array();
        if (is_array($post)) {
          foreach ($post as $name => $value) {
            $_post[] = $name.'='.urlencode($value);
          }
        }
        $ch = curl_init($this->api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        if (is_array($post)) {
          curl_setopt($ch, CURLOPT_POSTFIELDS, join('&', $_post));
        }
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        $result = curl_exec($ch);
        if (curl_errno($ch) != 0 && empty($result)) {
          $result = false;
        }
        curl_close($ch);
        return $result;
      }
   }

   // Examples

   $api = new Api();

   $services = $api->services(); # return all services

   // add order

   // $order = $api->order(array('service' => 1, 'link' => 'http://example.com/test', 'quantity' => '100')); # Default
   
   // $order = $api->order(array('service' => 1, 'link' => 'http://example.com/test', 'quantity' => '100', 'keywords'=>"test, testing")); # SEO

   // $order = $api->order(array('service' => 1, 'link' => 'http://example.com/test', 'comments' => "good pic\ngreat photo\n:)\n;)")); # Custom Comments

   // $order = $api->order(array('service' => 4, 'link' => 'http://example.com/test', 'quantity' => '100', 'usernames'=>"test, testing", 'hashtags'=>"#goodphoto")); # Mentions with Hashtags

   // $order = $api->order(array('service' => 5, 'link' => 'http://example.com/test', 'usernames' => "test\nexample\nfb")); # Mentions Custom List

   // $order = $api->order(array('service' => 6, 'link' => 'http://example.com/test', 'quantity' => '100', 'hashtag'=>"test")); # Mentions Hashtag

   // $order = $api->order(array('service' => 7, 'link' => 'http://example.com/test', 'quantity' => '1000', 'username'=>"test")); # Mentions User Followers

   // $order = $api->order(array('service' => 8, 'link' => 'http://example.com/test', 'quantity' => '1000', 'media'=>"http://example.com/p/Ds2kfEr24Dr")); # Mentions Media Likers

   // $order = $api->order(array('service' => 9, 'link' => 'http://example.com/test', 'quantity' => '1000', 'usernames'=>"test")); # Mentions

   // $order = $api->order(array('service' => 10, 'link' => 'http://example.com/test')); # Package

   // $status = $api->status($order->order); # return status, charge, remains, start count

?>