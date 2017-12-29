<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://miplugins.com
 * @since             1.0.0
 * @package           Mi_Testimonial
 *
 * @wordpress-plugin
 * Plugin Name:       Mi Testimonial Slider
 * Plugin URI:        https://miplugins.com/plugin/mi-testimonial-slider-plugin-wordpress/
 * Description:       Mi Testimonial Slider is perfect to showcase clients & users testimonials.
 * Version:           1.0.0
 * Author:            Mi Plugins
 * Author URI:        https://miplugins.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       mi-testimonial
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-mi-testimonial-activator.php
 */
function activate_mi_testimonial() {
    $compare_plugins = array('mi-testimonial-pro/mi-testimonial-pro.php','mi-testimonial-vc/mi-testimonial-vc.php');
    $target = apply_filters( 'active_plugins', get_option( 'active_plugins' ) );
    if(count(array_intersect($compare_plugins, $target))>0){
        deactivate_plugins( plugin_basename( __FILE__ ) );
        wp_die( esc_html('Please make sure "Mi Testimonial Pro" & "Mi Testimonial VC" is deactivated  , Before Activate "Mi Testimonial"','mi_testimonial') );
    }

    require_once plugin_dir_path( __FILE__ ) . 'includes/class-mi-testimonial-activator.php';
    Mi_Testimonial_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-mi-testimonial-deactivator.php
 */
function deactivate_mi_testimonial() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-mi-testimonial-deactivator.php';
	Mi_Testimonial_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_mi_testimonial' );
register_deactivation_hook( __FILE__, 'deactivate_mi_testimonial' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-mi-testimonial.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_mi_testimonial() {

	$plugin = new Mi_Testimonial();
	$plugin->run();

}
run_mi_testimonial();
