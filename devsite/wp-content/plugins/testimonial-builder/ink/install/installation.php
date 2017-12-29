<?php 
if ( ! defined( 'ABSPATH' ) ) exit;
add_action('plugins_loaded', 'wpsm_test_tr');
function wpsm_test_tr() {
	load_plugin_textdomain( wpshopmart_test_b_text_domain, FALSE, dirname( plugin_basename(__FILE__)).'/languages/' );
}

function wpsm_test_b_front_script() {
    
		wp_enqueue_style('wpsm_test_b_bootstrap-front', wpshopmart_test_b_directory_url.'assets/css/bootstrap-front.css');
		wp_enqueue_style('wpsm_test_b_style-1', wpshopmart_test_b_directory_url.'assets/css/style-1.css');
		wp_enqueue_style('wpsm_test_b_style-2', wpshopmart_test_b_directory_url.'assets/css/style-2.css');
}

add_action( 'wp_enqueue_scripts', 'wpsm_test_b_front_script' );
add_filter( 'widget_text', 'do_shortcode');

add_action( 'admin_notices', 'wpsm_testi_b_review' );
function wpsm_testi_b_review() {

	// Verify that we can do a check for reviews.
	$review = get_option( 'wpsm_testi_b_review' );
	$time	= time();
	$load	= false;
	if ( ! $review ) {
		$review = array(
			'time' 		=> $time,
			'dismissed' => false
		);
		add_option('wpsm_testi_b_review', $review);
		//$load = true;
	} else {
		// Check if it has been dismissed or not.
		if ( (isset( $review['dismissed'] ) && ! $review['dismissed']) && (isset( $review['time'] ) && (($review['time'] + (DAY_IN_SECONDS * 2)) <= $time)) ) {
			$load = true;
		}
	}
	// If we cannot load, return early.
	if ( ! $load ) {
		return;
	}

	// We have a candidate! Output a review message.
	?>
	<div class="notice notice-info is-dismissible wpsm-testi-b-review-notice">
		<div style="float:left;margin-right:10px;margin-bottom:5px;">
			<img style="width:100%;width: 150px;height: auto;" src="<?php echo wpshopmart_test_b_directory_url.'assets/images/icon-show.png'; ?>" />
		</div>
		<p style="font-size:17px;">'Hi! We saw you have been using <strong>Testimonial Builder plugin</strong> for a few days and wanted to ask for your help to <strong>make the plugin better</strong>.We just need a minute of your time to rate the plugin. Thank you!</p>
		<p style="font-size:17px;"><strong><?php _e( '~ wpshopmart', '' ); ?></strong></p>
		<p style="font-size:18px;"> 
			<a style="color: #fff;background: #ef4238;padding: 3px 11px 7px 11px;border-radius: 4px;text-decoration:none" href="https://wordpress.org/support/plugin/testimonial-builder/reviews/?filter=5#new-post" class="wpsm-testi-b-dismiss-review-notice wpsm-testi-b-review-out" target="_blank" rel="noopener">Rate the plugin</a>&nbsp; &nbsp;
			<a style="color: #fff;background: #27d63c;padding: 3px 11px 7px 11px;border-radius: 4px;text-decoration:none" href="#"  class="wpsm-testi-b-dismiss-review-notice wpsm-rate-later" target="_self" rel="noopener"><?php _e( 'Nope, maybe later', '' ); ?></a>&nbsp; &nbsp;
			<a style="color: #fff;background: #31a3dd;padding: 3px 11px 7px 11px;border-radius: 4px;text-decoration:none" href="#" class="wpsm-testi-b-dismiss-review-notice wpsm-rated" target="_self" rel="noopener"><?php _e( 'I already did', '' ); ?></a>
		</p>
	</div>
	<script type="text/javascript">
		jQuery(document).ready( function($) {
			$(document).on('click', '.wpsm-testi-b-dismiss-review-notice, .wpsm-testi-b-dismiss-notice .notice-dismiss', function( event ) {
				if ( $(this).hasClass('wpsm-testi-b-review-out') ) {
					var wpsm_rate_data_val = "1";
				}
				if ( $(this).hasClass('wpsm-rate-later') ) {
					var wpsm_rate_data_val =  "2";
					event.preventDefault();
				}
				if ( $(this).hasClass('wpsm-rated') ) {
					var wpsm_rate_data_val =  "3";
					event.preventDefault();
				}

				$.post( ajaxurl, {
					action: 'wpsm_testi_b_dismiss_review',
					wpsm_rate_data_testi_b : wpsm_rate_data_val
				});
				
				$('.wpsm-testi-b-review-notice').hide();
				//location.reload();
			});
		});
	</script>
	<?php
}

add_action( 'wp_ajax_wpsm_testi_b_dismiss_review', 'wpsm_testi_b_dismiss_review' );
function wpsm_testi_b_dismiss_review() {
	if ( ! $review ) {
		$review = array();
	}
	
	if($_POST['wpsm_rate_data_testi_b']=="1"){
		$review['time'] 	 = time();
		$review['dismissed'] = false;
		
	}
	if($_POST['wpsm_rate_data_testi_b']=="2"){
		$review['time'] 	 = time();
		$review['dismissed'] = false;
		
	}
	if($_POST['wpsm_rate_data_testi_b']=="3"){
		$review['time'] 	 = time();
		$review['dismissed'] = true;
		
	}
	update_option( 'wpsm_testi_b_review', $review );
	die;
}
?>