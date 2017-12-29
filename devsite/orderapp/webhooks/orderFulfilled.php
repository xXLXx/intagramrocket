<?php

require_once '../header.php';
require_once '../shopify.php';
require_once '../keys.php';
require_once '../database_config.php';

$data     =(file_get_contents('php://input'));

//$data = '{"id":5248863044,"email":"test@gmail.com","closed_at":"2017-07-07T05:05:21-04:00","created_at":"2017-07-07T05:04:24-04:00","updated_at":"2017-07-07T05:05:21-04:00","number":3,"note":null,"token":"c3202ef19dfa4d5dba78d52a2c6582c9","gateway":"Cash on Delivery (COD)","test":false,"total_price":"4372.46","subtotal_price":"3697.00","total_weight":0,"total_tax":"665.46","taxes_included":false,"currency":"INR","financial_status":"paid","confirmed":true,"total_discounts":"0.00","total_line_items_price":"3697.00","cart_token":"0b64ec51a90d3e82056782aa29108362","buyer_accepts_marketing":false,"name":"#1003","referring_site":"","landing_site":"\/admin","cancelled_at":null,"cancel_reason":null,"total_price_usd":"67.55","checkout_token":"e71e410fab01bad50b3a43967447ec3d","reference":null,"user_id":null,"location_id":null,"source_identifier":null,"source_url":null,"processed_at":"2017-07-07T05:04:24-04:00","device_id":null,"phone":null,"customer_locale":"en","browser_ip":null,"landing_site_ref":null,"order_number":1003,"discount_codes":[],"note_attributes":[],"payment_gateway_names":["Cash on Delivery (COD)"],"processing_method":"manual","checkout_id":15536395460,"source_name":"web","fulfillment_status":"fulfilled","tax_lines":[{"title":"GST","price":"665.46","rate":0.18}],"tags":"","contact_email":"test@gmail.com","order_status_url":"https:\/\/checkout.shopify.com\/21595843\/checkouts\/e71e410fab01bad50b3a43967447ec3d\/thank_you_token?key=7e8c6fed7efa60e6a0078e95bb528ce7","line_items":[{"id":10191887940,"variant_id":44595643460,"title":"Aliexpress.com : Buy camisetas femininas","quantity":2,"price":"300.00","grams":0,"sku":"","variant_title":"","vendor":"kamini@esfera","fulfillment_service":"manual","product_id":11358417668,"requires_shipping":true,"taxable":true,"gift_card":false,"name":"Aliexpress.com : Buy camisetas femininas","variant_inventory_management":"shopify","properties":[],"product_exists":true,"fulfillable_quantity":0,"total_discount":"0.00","fulfillment_status":"fulfilled","tax_lines":[{"title":"GST","price":"108.00","rate":0.18}],"origin_location":{"id":3191633092,"country_code":"IN","province_code":"PB","name":"ProductSalesFundraising","address1":"SCF 20 , Phase 2","address2":"","city":"Mohali","zip":"160055"},"destination_location":{"id":3194120452,"country_code":"IN","province_code":"CH","name":"kamini dvd","address1":"vdeeg","address2":"","city":"grgv","zip":"160055"}},{"id":10191888004,"variant_id":44595641604,"title":"beautiful white flat shoe","quantity":2,"price":"799.00","grams":0,"sku":"","variant_title":"","vendor":"kamini@esfera","fulfillment_service":"manual","product_id":11358416900,"requires_shipping":true,"taxable":true,"gift_card":false,"name":"beautiful white flat shoe","variant_inventory_management":"shopify","properties":[],"product_exists":true,"fulfillable_quantity":0,"total_discount":"0.00","fulfillment_status":"fulfilled","tax_lines":[{"title":"GST","price":"287.64","rate":0.18}],"origin_location":{"id":3191633092,"country_code":"IN","province_code":"PB","name":"ProductSalesFundraising","address1":"SCF 20 , Phase 2","address2":"","city":"Mohali","zip":"160055"},"destination_location":{"id":3194120452,"country_code":"IN","province_code":"CH","name":"kamini dvd","address1":"vdeeg","address2":"","city":"grgv","zip":"160055"}},{"id":10191888068,"variant_id":44595649540,"title":"28-3851-womens-t-shirt","quantity":1,"price":"200.00","grams":0,"sku":"","variant_title":"","vendor":"kamini@esfera","fulfillment_service":"manual","product_id":11358418628,"requires_shipping":true,"taxable":true,"gift_card":false,"name":"28-3851-womens-t-shirt","variant_inventory_management":"shopify","properties":[],"product_exists":true,"fulfillable_quantity":0,"total_discount":"0.00","fulfillment_status":"fulfilled","tax_lines":[{"title":"GST","price":"36.00","rate":0.18}],"origin_location":{"id":3191633092,"country_code":"IN","province_code":"PB","name":"ProductSalesFundraising","address1":"SCF 20 , Phase 2","address2":"","city":"Mohali","zip":"160055"},"destination_location":{"id":3194120452,"country_code":"IN","province_code":"CH","name":"kamini dvd","address1":"vdeeg","address2":"","city":"grgv","zip":"160055"}},{"id":10191888132,"variant_id":44595637892,"title":"Aliexpress","quantity":1,"price":"1299.00","grams":0,"sku":"","variant_title":"small","vendor":"kamini@esfera","fulfillment_service":"manual","product_id":11358415364,"requires_shipping":true,"taxable":true,"gift_card":false,"name":"Aliexpress - small","variant_inventory_management":"shopify","properties":[],"product_exists":true,"fulfillable_quantity":0,"total_discount":"0.00","fulfillment_status":"fulfilled","tax_lines":[{"title":"GST","price":"233.82","rate":0.18}],"origin_location":{"id":3191633092,"country_code":"IN","province_code":"PB","name":"ProductSalesFundraising","address1":"SCF 20 , Phase 2","address2":"","city":"Mohali","zip":"160055"},"destination_location":{"id":3194120452,"country_code":"IN","province_code":"CH","name":"kamini dvd","address1":"vdeeg","address2":"","city":"grgv","zip":"160055"}}],"shipping_lines":[{"id":4275959428,"title":"Standard Shipping","price":"10.00","code":"Standard Shipping","source":"shopify","phone":null,"requested_fulfillment_service_id":null,"delivery_category":null,"carrier_identifier":null,"tax_lines":[]}],"billing_address":{"first_name":"kamini","address1":"vdeeg","phone":null,"city":"grgv","zip":"160055","province":"Chandigarh","country":"India","last_name":"dvd","address2":"","company":null,"latitude":null,"longitude":null,"name":"kamini dvd","country_code":"IN","province_code":"CH"},"shipping_address":{"first_name":"kamini","address1":"vdeeg","phone":null,"city":"grgv","zip":"160055","province":"Chandigarh","country":"India","last_name":"dvd","address2":"","company":null,"latitude":null,"longitude":null,"name":"kamini dvd","country_code":"IN","province_code":"CH"},"fulfillments":[{"id":4515949956,"order_id":5248863044,"status":"success","created_at":"2017-07-07T05:05:21-04:00","service":"manual","updated_at":"2017-07-07T05:05:21-04:00","tracking_company":null,"shipment_status":null,"tracking_number":null,"tracking_numbers":[],"tracking_url":null,"tracking_urls":[],"receipt":{},"line_items":[{"id":10191887940,"variant_id":44595643460,"title":"Aliexpress.com : Buy camisetas femininas","quantity":2,"price":"300.00","grams":0,"sku":"","variant_title":"","vendor":"kamini@esfera","fulfillment_service":"manual","product_id":11358417668,"requires_shipping":true,"taxable":true,"gift_card":false,"name":"Aliexpress.com : Buy camisetas femininas","variant_inventory_management":"shopify","properties":[],"product_exists":true,"fulfillable_quantity":0,"total_discount":"0.00","fulfillment_status":"fulfilled","tax_lines":[{"title":"GST","price":"108.00","rate":0.18}],"origin_location":{"id":3191633092,"country_code":"IN","province_code":"PB","name":"ProductSalesFundraising","address1":"SCF 20 , Phase 2","address2":"","city":"Mohali","zip":"160055"},"destination_location":{"id":3194120452,"country_code":"IN","province_code":"CH","name":"kamini dvd","address1":"vdeeg","address2":"","city":"grgv","zip":"160055"}},{"id":10191888004,"variant_id":44595641604,"title":"beautiful white flat shoe","quantity":2,"price":"799.00","grams":0,"sku":"","variant_title":"","vendor":"kamini@esfera","fulfillment_service":"manual","product_id":11358416900,"requires_shipping":true,"taxable":true,"gift_card":false,"name":"beautiful white flat shoe","variant_inventory_management":"shopify","properties":[],"product_exists":true,"fulfillable_quantity":0,"total_discount":"0.00","fulfillment_status":"fulfilled","tax_lines":[{"title":"GST","price":"287.64","rate":0.18}],"origin_location":{"id":3191633092,"country_code":"IN","province_code":"PB","name":"ProductSalesFundraising","address1":"SCF 20 , Phase 2","address2":"","city":"Mohali","zip":"160055"},"destination_location":{"id":3194120452,"country_code":"IN","province_code":"CH","name":"kamini dvd","address1":"vdeeg","address2":"","city":"grgv","zip":"160055"}},{"id":10191888068,"variant_id":44595649540,"title":"28-3851-womens-t-shirt","quantity":1,"price":"200.00","grams":0,"sku":"","variant_title":"","vendor":"kamini@esfera","fulfillment_service":"manual","product_id":11358418628,"requires_shipping":true,"taxable":true,"gift_card":false,"name":"28-3851-womens-t-shirt","variant_inventory_management":"shopify","properties":[],"product_exists":true,"fulfillable_quantity":0,"total_discount":"0.00","fulfillment_status":"fulfilled","tax_lines":[{"title":"GST","price":"36.00","rate":0.18}],"origin_location":{"id":3191633092,"country_code":"IN","province_code":"PB","name":"ProductSalesFundraising","address1":"SCF 20 , Phase 2","address2":"","city":"Mohali","zip":"160055"},"destination_location":{"id":3194120452,"country_code":"IN","province_code":"CH","name":"kamini dvd","address1":"vdeeg","address2":"","city":"grgv","zip":"160055"}},{"id":10191888132,"variant_id":44595637892,"title":"Aliexpress","quantity":1,"price":"1299.00","grams":0,"sku":"","variant_title":"small","vendor":"kamini@esfera","fulfillment_service":"manual","product_id":11358415364,"requires_shipping":true,"taxable":true,"gift_card":false,"name":"Aliexpress - small","variant_inventory_management":"shopify","properties":[],"product_exists":true,"fulfillable_quantity":0,"total_discount":"0.00","fulfillment_status":"fulfilled","tax_lines":[{"title":"GST","price":"233.82","rate":0.18}],"origin_location":{"id":3191633092,"country_code":"IN","province_code":"PB","name":"ProductSalesFundraising","address1":"SCF 20 , Phase 2","address2":"","city":"Mohali","zip":"160055"},"destination_location":{"id":3194120452,"country_code":"IN","province_code":"CH","name":"kamini dvd","address1":"vdeeg","address2":"","city":"grgv","zip":"160055"}}]}],"client_details":{"browser_ip":"182.71.22.106","accept_language":"en-US,en;q=0.5","user_agent":"Mozilla\/5.0 (X11; Ubuntu; Linux x86_64; rv:54.0) Gecko\/20100101 Firefox\/54.0","session_hash":"38018ab8e5ffc6d3578073b234a0f1a7","browser_width":1287,"browser_height":671},"refunds":[],"customer":{"id":5805049412,"email":"test@gmail.com","accepts_marketing":false,"created_at":"2017-07-07T00:22:09-04:00","updated_at":"2017-07-07T05:04:58-04:00","first_name":"kamini","last_name":"dvd","orders_count":3,"state":"disabled","total_spent":"4372.46","last_order_id":5248863044,"note":null,"verified_email":true,"multipass_identifier":null,"tax_exempt":false,"phone":null,"tags":"","last_order_name":"#1003","default_address":{"id":6090880516,"customer_id":5805049412,"first_name":"kamini","last_name":"dvd","company":null,"address1":"vdeeg","address2":"","city":"grgv","province":"Chandigarh","country":"India","zip":"160055","phone":null,"name":"kamini dvd","province_code":"CH","country_code":"IN","country_name":"India","default":true}}}';

$fh       =fopen('orderFulfilled.txt', 'w')  or die("Utyftyftf");
fwrite($fh, $data);

/* GET DOMAIN FROM HEDAERS  */
$_HEADERS = apache_request_headers();
$_DOMAIN  =$_HEADERS['X-Shopify-Shop-Domain'];
// echo 'domain'.$_DOMAIN = $_SESSION['shop'];
fwrite($fh, $_DOMAIN);

///////////// Get token from database /////////
$sql="SELECT * from shopDetails where shopDomain='$_DOMAIN' ";
$qex=mysqli_query($newCon,$sql);
$res = mysqli_fetch_array($qex);

$shopToken = $res['shopToken'];
fwrite($fh,$shopToken);

$sc = new ShopifyClient($_DOMAIN, $shopToken, $api_key, $secret);

$array    =json_decode($data);
// print_r($array);

mail('kamini_thakur@esferasoft.com', 'Order fulfilled on sales fundraising', json_decode($data));

$financial_status = $array->financial_status;
foreach ($array->processing_method as $key => $val) {
    $fulfillment_status = $val->fulfillment_status;
}
foreach ($array->line_items as $key => $value) {

  if( (!empty($value->product_id)) && $financial_status == 'paid' && $fulfillment_status == 'fulfilled' ) {
        $GetMeta = $sc->call('GET','/admin/products/'.$value->product_id.'/metafields.json?namespace=Fundraising');

        if(empty($GetMeta))
        {
            $meta = array("metafield"=>array(
              "namespace"=>"Fundraising",
              "key"=>"sales",
              "value"=>$value->price,
              "value_type"=>"string"
              )
            );

            $AddMetafield=$sc->call('POST','/admin/products/'.$value->product_id.'/metafields.json',$meta);
        }
        else
        {
          
            $key = array_search('Fundraising', array_column($GetMeta, 'namespace'));
            $metafield_id=$GetMeta[$key]['id']; 
            $prevProdPrice=$GetMeta[$key]['value']; 
            $newPrice=  ($value->price)*($value->quantity);
            $price = ($prevProdPrice)+($newPrice);

            $meta = array("metafield"=>array(
                          "id"=>$metafield_id,
                          "value"=>$price,
                          "value_type"=>"string"
                          )
            );
          
            $updateMetafield=$sc->call('PUT','/admin/products/'.$value->product_id.'/metafields/'.$metafield_id.'.json',$meta);  
        }               
  } 
}


?>