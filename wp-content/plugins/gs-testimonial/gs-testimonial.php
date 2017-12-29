<?php
/**
 *
 * @package   GS_Testimonial
 * @author    Golam Samdani <samdani1997@gmail.com>
 * @license   GPL-2.0+
 * @link      http://www.gsamdani.com
 * @copyright 2015 Golam Samdani
 *
 * @wordpress-plugin
 * Plugin Name:			GS Testimonial Lite
 * Plugin URI:			http://www.gsamdani.com/wordpress-plugins
 * Description:       	Best Responsive Testimonials slider to display client's testimonials / recommendations. Display anywhere at your site using shortcode like [gs_testimonial] Check more shortcode examples and documention at <a href="http://testimonial.gsamdani.com">GS Testimonial Pro Docs</a> 
 * Version:           	1.7
 * Author:       		Golam Samdani
 * Author URI:       	http://www.gsamdani.com
 * Text Domain:       	golamsamdani
 * License:           	GPL-2.0+
 * License URI:       	http://www.gnu.org/licenses/gpl-2.0.txt
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

require_once dirname( __FILE__ ) . '/gs-testimonial-cpt.php';
require_once dirname( __FILE__ ) . '/gs-testimonial-metabox.php';
require_once dirname( __FILE__ ) . '/gs-testimonial-column.php';
require_once dirname( __FILE__ ) . '/gs-testimonial-shortcode.php';
require_once dirname( __FILE__ ) . '/gs-plugins/gs-plugins.php';
require_once dirname( __FILE__ ) . '/gs-plugins/gs-plugins-free.php';
require_once dirname( __FILE__ ) . '/gs-plugins/gs-testimonial-help.php';
require_once dirname( __FILE__ ) . '/gs-testimonial-script.php';


add_action('do_meta_boxes', 'gs_testimonial_change_image_box');
function gs_testimonial_change_image_box()
{
    remove_meta_box( 'postimagediv', 'gs_testimonial', 'side' );
    add_meta_box('postimagediv', __('Testimonial Author Image'), 'post_thumbnail_meta_box', 'gs_testimonial', 'side', 'low');
}


/**
 * Admin notice for Free
 */
function gst_get_free() { ?>
	
	<?php ob_start(); ?>
	<div class="update-nag">
			<h3>Upgrade to PRO GS Testimonial Slider for free!!</h3>
			<p>Dear GS Testimonial Slider User --<br>
			Great News! <br>
			Upgrade your existing one to PRO version, it's 100% free !!
			 As we are lunching, offering you to download GS Testimonial slider wordpress PRO plugin completely free till 15th March'15. Hurry up & grab your copy. <br>

			Download here <a href="http://goo.gl/6SrINy" target="_blank">Download PRO version</a></p>
			<p>GS Testimonial Slider Team</p>
	</div>
	<?php echo ob_get_clean();
}
//add_action('admin_notices', 'gst_get_free');
//add_action('network_admin_notices', 'gst_get_free');

if ( ! function_exists('gs_testimonial_pro_link') ) {
	function gs_testimonial_pro_link( $gsTesti_links ) {
		$gsTesti_links[] = '<a class="gs-pro-link" href="https://www.gsamdani.com/product/gs-testimonial-slider" target="_blank">Go Pro!</a>';
		$gsTesti_links[] = '<a href="https://www.gsamdani.com/wordpress-plugins" target="_blank">GS Plugins</a>';
		return $gsTesti_links;
	}
	add_filter( 'plugin_action_links_' .plugin_basename(__FILE__), 'gs_testimonial_pro_link' );
}