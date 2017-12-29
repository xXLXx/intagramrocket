<?php

require_once '../shopify.php';
require_once '../keys.php';
require_once '../database_config.php';

/*      getting the domain from which request is made      */

$data = file_get_contents('php://input');
$fh=fopen('Uninstall.txt', 'w');

fwrite($fh,$data);
$Array    =json_decode($data);

$_DOMAIN  =$_SERVER['HTTP_X_SHOPIFY_SHOP_DOMAIN'];
fwrite($fh, $_DOMAIN);

try
{

		if(!empty($Array))
		{
           	$deleteRecord="DELETE from shopDetails where shopDomain='$_DOMAIN' ";
			$executeDelete=mysqli_query($newCon,$deleteRecord);	
			if($executeDelete)
			{
				$response = 'True';
			}
			else
			{
				$response = 'False';
			}
			fwrite($fh, $response);
			mysqli_close($newCon);	
		}

}
catch (ShopifyApiException $e)
    {
		
        //fwrite($fh, $e->getMethod());// -> http method (GET, POST, PUT, DELETE)
        fwrite($fh,$e->getPath());// -> path of failing request
        fwrite($fh,$e->getResponseHeaders());// -> actually response headers from failing request
        fwrite($fh,$e->getResponse());// -> curl response object
        fwrite($fh,$e->getParams());// -> optional data that may have been passed that caused the failure
		
    }


?>

