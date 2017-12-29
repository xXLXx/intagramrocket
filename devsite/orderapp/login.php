<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);
ob_start();
session_start();
require_once 'keys.php';
define('SHOPIFY_API_KEY', $api_key);
define('SHOPIFY_SECRET',  $secret);
define('SHOPIFY_SCOPE', 'read_products,write_products,read_themes,write_themes,write_script_tags,read_orders,write_orders,read_content, write_content,read_customers, write_customers,read_script_tags, write_script_tags,read_checkouts, write_checkouts');

    require 'shopify.php';
    if (isset($_GET['code'])) { // if the code param has been sent to this page... we are in Step 2
        // Step 2: do a form POST to get the access token
        $shopifyClient = new ShopifyClient($_GET['shop'], "", SHOPIFY_API_KEY, SHOPIFY_SECRET);
        session_unset();

        // Now, request the token and store it in your session.
        $_SESSION['token'] = $shopifyClient->getAccessToken($_GET['code']);
        $accessToken=$_SESSION['token'];
        $shopURL= $_GET['shop'];
        if ($_SESSION['token'] != '')
            $_SESSION['shop'] = $_GET['shop'];
        $shopURL='https://'.$_SESSION['shop']; ?>
         <script src="https://cdn.shopify.com/s/assets/external/app.js"></script>
  
        <script type="text/javascript">
    ShopifyApp.init({
      apiKey: '<?php echo $api_key; ?>',
      shopOrigin:"<?php echo $shopURL; ?>",    
      debug: true
    });

    ShopifyApp.Modal.open({
  src: 'index.php',
  title: 'Silhouettes'
  width: 'large',
  height: 500,
  buttons: {
    
}
  });
  </script>
<?php        
header("Location:index.php");
        exit;       
    }
    // if they posted the form with the shop name
    else if (isset($_POST['shop']) || isset($_GET['shop'])) {

  
        // Step 1: get the shopname from the user and redirect the user to the
        // shopify authorization page where they can choose to authorize this app
        $shop = isset($_POST['shop']) ? $_POST['shop'] : $_GET['shop'];
        $shopifyClient = new ShopifyClient($shop, "", SHOPIFY_API_KEY, SHOPIFY_SECRET);

        // get the URL to the current page
        $pageURL = 'http';
        if ($_SERVER["HTTPS"] == "on") { $pageURL .= "s"; }
        $pageURL .= "://";
        if ($_SERVER["SERVER_PORT"] != "80") {
            $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
        } else {
            $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
        }

        // redirect to authorize url
        header("Location: " . $shopifyClient->getAuthorizeUrl(SHOPIFY_SCOPE, $pageURL));
        exit;
    }

    // first time to the page, show the form below
?>
<!DOCTYPE html>
<html>
<head>
  <title>SHOPIFY APP</title>
  <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
  <style type="text/css">
    #shopifyAPP{

      background:url('https://strategistmagazine.co/wp-content/uploads/2015/04/shopify-logo.jpg') no-repeat center fixed;
      background-size: cover;
    }

  </style>
</head>
<body id="shopifyAPP">

 
 
<h4>Install this app in a shop to get access to its private admin data. Don&rsquo;t have a shop to install your app in handy? <a href="https://app.shopify.com/services/partners/api_clients/test_shops">Create a test shop.</a></h4>
    <div class="modal-dialog">
 <div class="modalBody">
    <form action="" method="POST" class="form col-md-12 center-block">
    <div class="form-group">
      <label for='shop'>
        <h4 class="hint"><strong>The URL of the Shop</strong> (enter it exactly like this: myshop.myshopify.com)</h4> 
      </label> 
      </div>
     <div class="form-group">
        <input id="shop" name="shop" size="45" type="text" value="" class="form-control input-lg" /> 
        <input name="commit" type="submit" value="Install" class="btn btn-primary btn-lg btn-block" /> 
      </div> 
    </form>
    </div>
    </div>

</div>
</body>
</html>
    
