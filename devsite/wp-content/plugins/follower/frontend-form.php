<?php

session_start();

get_header(); 

global $wpdb;

$dir = plugin_dir_path( __FILE__ );

$process = "follower";
$returnurl = get_site_url().'/buy-real-followers/';
$subscriptionURL = get_site_url().'/follower?subscription=' . $_GET['subscription'];
include($dir . "purchase.process.php");

?>

<script src="https://checkout.stripe.com/checkout.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<script type="text/javascript">
	
	var now = new Date(),
		time = now.getTime(),
		paypalamt = parseFloat($('#amt').val()),
		followeramt = parseInt($('#addfollower').html());
    
    time += 3600 * 1000 * 700;
    now.setTime(time);
    document.cookie = 'addservice=0' + '; expires=' + now.toGMTString() + '; path=/';

    

    var handler = StripeCheckout.configure({
					key: 'pk_live_6t96m9jPCg0n8x1dwO9msPZ6',
					image: 'https://www.instagramrocket.com/devsite/wp-content/uploads/2017/05/new-logo1-1.png',
					zipcode:'true',
					locale: 'auto',
					token: function(token) {
						  		
						var ammt = $('#amt').val();
						var amount = Math.round(ammt*100)

					  	$.ajax({
						      type: 'POST',
						      url: "wp-content/plugins/follower/stripe.php",
						      data: {'stripeToken':token.id,'ammt':amount},
						      dataType: "text",
						      success: function(resultData) {

						      	if(resultData=='done'){

						    		var test='<?php echo get_site_url(); ?>/follower/?subscription=<?php echo $_GET['subscription']; ?>&username=<?php echo $_GET['username']; ?>&stripedone=1&random=<?php echo $random; ?>';
				    				window.location.href = test;
				    				return;

				    			}

				    			alert(resultData);

						   }
						});

					}
				});

   	window.addEventListener('popstate', function() {
	  	handler.close();
	});

</script>

<?php
	get_footer();
?>