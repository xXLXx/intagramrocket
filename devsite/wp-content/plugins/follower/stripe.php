<?php
 ini_set("display_errors", "1");
error_reporting(E_ALL);

  		try {
  				
  			
    		
 require_once('Stripe/lib/Stripe.php');

Stripe::setApiKey("sk_live_l4bFjb4a1dCzVCs37uJ2uHs4");

	$charge = Stripe_Charge::create(array(
  "amount" => $_POST['ammt'],
  "currency" => "usd",
  "card" => $_POST['stripeToken'],
  "description" => "Instarocket Payment"
));

echo 'done';


}catch(Stripe_CardError $e) {
  // Since it's a decline, Stripe_CardError will be caught
  $body = $e->getJsonBody();
  $err  = $body['error'];

  print('Status is:' . $e->getHttpStatus() . "\n");
  print('Type is:' . $err['type'] . "\n");
  print('Code is:' . $err['code'] . "\n");
  print('Message is:' . $err['message'] . "\n");
 

} catch (Stripe_InvalidRequestError $e) {
	print_r($e);
  
  // Invalid parameters were supplied to Stripe's API
} catch (Stripe_AuthenticationError $e) {
	print_r($e);

  // Authentication with Stripe's API failed
  // (maybe you changed API keys recently)
} catch (Stripe_ApiConnectionError $e) {
	print_r($e);

  // Network communication with Stripe failed
} catch (Stripe_Error $e) {
	print_r($e);

  // Display a very generic error to the user, and maybe send
  // yourself an email
} catch (Exception $e) {
	print_r($e);

  // Something else happened, completely unrelated to Stripe
}

						?>