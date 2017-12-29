<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://miplugins.com
 * @since      1.0.0
 *
 * @package    Mi_Testimonial
 * @subpackage Mi_Testimonial/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Mi_Testimonial
 * @subpackage Mi_Testimonial/public
 * @author     Mi Plugins <miplugins@gmail.com>
 */
class Mi_Testimonial_Public
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $plugin_name The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;

    /**
     * @var get all the cats id in column
     */
    private static $mi_testimonail_cats_id;


    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string $plugin_name The name of the plugin.
     * @param      string $version The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
        add_shortcode('mi-testimonial', array($this, 'mi_testimonial_shortcode_callback'));

    }


    /**
     * @return url
     * @param file name first part
     * @param  file name second part
     */

    public function mi_get_plugin_style_path($first_part_file_name, $second_part_file_name = null)
    {
        $this->firstPart = $first_part_file_name;
        $this->secondPart = $second_part_file_name;
        $this->fullName = $first_part_file_name;

        if ($this->secondPart) {
            $this->fullName = $first_part_file_name . "-" . $second_part_file_name;
        }
        $this->pathName = plugin_dir_path(__FILE__);
        return realpath($this->pathName) . '/' . $this->fullName . '.php';

    }


    /*
   * get Option value
   * */

    private function get_option_value()
    {
        return get_option('_mi_testimonial_items');
    }

    /**
     * implode function to implode array and data class
     */
    public function mi_get_class($array_value, $string = null)
    {
        $this->class = (array)$array_value;
        return implode($this->class, ' ') . " " . $string;
    }


    public function mi_testimonial_shortcode_callback($atts, $content = null)
    {
        $default = shortcode_atts(array('id' => null), $atts);
        $mi_testimonial_id = $default['id'];
        $mi_testimonial_value = $this->get_option_value();
        $mi_testimonial_values_id = array_keys($mi_testimonial_value);
        $mi_valid_testimonial = in_array($mi_testimonial_id, $mi_testimonial_values_id);

        if ($mi_testimonial_id && $mi_valid_testimonial) {

            $mi_testimonial_inner_value = $mi_testimonial_value[$mi_testimonial_id];
            $mi_testimonial_testimonials = $mi_testimonial_inner_value['testimonial'];
            $mi_testimonial_settings = $mi_testimonial_inner_value['settings'];

            $mi_testimonial_display_mode = $mi_testimonial_settings['display_mode'];
            $mi_testimonial_layout = $mi_testimonial_settings['layout'];
            $mi_testimonial_design_option = $mi_testimonial_settings['design_option'];
            $mi_testimonial_position = $mi_testimonial_settings['position'];
            $mi_testimonial_dot_background_color = $mi_testimonial_settings['dot_background_color'];
            $mi_testimonial_dot_background_hover_color = $mi_testimonial_settings['dot_background_hover_color'];
            $mi_testimonial_nav_text_color = $mi_testimonial_settings['nav_text_color'];
            $mi_testimonial_nav_text_hover_color = $mi_testimonial_settings['nav_text_hover_color'];
            $mi_testimonial_nav_background_color = $mi_testimonial_settings['nav_background_color'];
            $mi_testimonial_nav_background_hover_color = $mi_testimonial_settings['nav_background_hover_color'];
            $mi_testimonial_filter_text_h_color = $mi_testimonial_settings['filter_text_hover_color'];
            $mi_testimonial_filter_bg_h_color = $mi_testimonial_settings['filter_text_bg_hover_color'];
            $mi_testimonial_quote_txt_color = $mi_testimonial_settings['quote_txt_color'];
            $mi_testimonial_quote_bg_color = $mi_testimonial_settings['quote_bg_color'];
            $mi_testimonial_author_image_border = $mi_testimonial_settings['author_image_border'];
            $mi_testimonial_author_image_border_color = $mi_testimonial_settings['author_image_border_color'];
            $mi_testimonial_author_name_font_size = $mi_testimonial_settings['author_name_font_size'];
            $mi_testimonial_author_name_font_color = $mi_testimonial_settings['author_name_font_color'];
            $mi_testimonial_author_designation = $mi_testimonial_settings['author_designation'];
            $mi_testimonial_author_designation_font_size = $mi_testimonial_settings['author_designation_font_size'];
            $mi_testimonial_author_designation_font_color = $mi_testimonial_settings['author_designation_font_color'];
            $mi_testimonial_desktop_number_of_grid = $mi_testimonial_settings['desktop_number_of_grid'];
            $mi_testimonial_tab_number_of_grid = $mi_testimonial_settings['tab_number_of_grid'];
            $mi_testimonial_mobile_number_of_grid = $mi_testimonial_settings['mobile_number_of_grid'];
            $mi_testimonial_small_mobile_number_of_grid = $mi_testimonial_settings['small_mobile_number_of_grid'];
            $mi_testimonial_author_image_h_border_color = $mi_testimonial_settings['author_image_border_hover_color'];
            $mi_testimonial_nav_inner = $mi_testimonial_settings['nav_inner'];
            $mi_testimonial_large_desktop_number_of_grid=$mi_testimonial_settings['large_desktop_number_of_grid'];

            //======================================================================
            // Grid Class
            //======================================================================
            $mi_testimonial_lg_grid_number = ' mi-testimonial-col-lg-' . $mi_testimonial_large_desktop_number_of_grid;
            $mi_testimonial_md_grid_number = ' mi-testimonial-col-md-' . $mi_testimonial_desktop_number_of_grid;
            $mi_testimonial_sm_grid_number = ' mi-testimonial-col-sm-' . $mi_testimonial_tab_number_of_grid;
            $mi_testimonial_xs_grid_number = ' mi-testimonial-col-xs-' . $mi_testimonial_mobile_number_of_grid;
            $mi_testimonial_xxs_grid_number = ' mi-testimonial-col-xxs-' . $mi_testimonial_small_mobile_number_of_grid;

            $mi_testimonial_wrap_class_default = ' mi-testimonial-container-' . $mi_testimonial_id;
            $mi_testimonial_main_class_default = 'mi-testimonial';
            $mi_testimonial_main_class_default .= ' mi-testimonial-'.$mi_testimonial_layout;
            $mi_testimonial_grid_wrapper ='';

            $mi_testimonial_grid_classes=$mi_testimonial_lg_grid_number.$mi_testimonial_md_grid_number.$mi_testimonial_sm_grid_number.$mi_testimonial_xs_grid_number.$mi_testimonial_xxs_grid_number;

            //======================================================================
            // For All Layouts
            //======================================================================

            if ($mi_testimonial_layout=='filter' || $mi_testimonial_layout=='combo_slider_one' || $mi_testimonial_layout=='combo_slider_two' || $mi_testimonial_layout=='combo_slider'){
                $mi_testimonial_layout='slider';
                $mi_testimonial_design_option='nav';
            }

            switch ($mi_testimonial_layout) {
                case 'slider':
                    $mi_testimonial_slider_wrapper = ' mi-owl-carousel';
                    $mi_testimonial_wrap_class_default .= ' mi-testimonial-layout-' . $mi_testimonial_layout;

                    if ($mi_testimonial_design_option == 'dot') {
                        $mi_testimonial_wrap_class_default .= ' mi-testimonial-design-option-dot';
                        $mi_testimonial_wrap_class_default .= ' mi-testimonial-dot-position-' . $mi_testimonial_position;
                        $mi_testimonial_has_dot = 'true';
                        $mi_testimonial_has_nav = 'false';

                    } else {
                        $mi_testimonial_has_nav = 'true';
                        $mi_testimonial_has_dot = 'false';
                        $mi_testimonial_wrap_class_default .= ' mi-testimonial-design-option-nav';
                        $mi_testimonial_wrap_class_default .= ' mi-testimonial-nav-position-' . $mi_testimonial_position;

                        if ( $mi_testimonial_nav_inner == 'yes' ) {
                            $mi_testimonial_main_class_default .= ' mi-testimonial-inner-nav';
                        }
                    }
                    break;

                case 'grid':
                    $mi_testimonial_wrap_class_default .= ' mi-testimonial-layout-' . $mi_testimonial_layout;
                    $mi_testimonial_grid_wrapper .= ' mi-testimonial-row mi-testimonial-row--masonry';
                    $mi_testimonial_wrap_class_default .= ' mi-testimonial-design-option-grid';
                    break;



            }


            $mi_testimonial_default_block = ' mi-testimonial-block';
            $mi_testimonial_block_quote = ' mi-testimonial-block__quote';
            $mi_testimonial_block_para = ' mi-testimonial-block__para';
            $mi_testimonial_default_media_block = ' mi-testimonial-block__media';
            $mi_testimonial_block_container = ' mi-testimonial-block-container-' . $mi_testimonial_id;


            //======================================================================
            // For Style
            //======================================================================
            $mi_testimonial_wrap_class_default .= ' mi-testimonial-style-' . $mi_testimonial_display_mode;

            $mi_testimonial_grid_wrapper .= ' mi-testimonial-gutter-25';

            if ($mi_testimonial_layout=='filter' || $mi_testimonial_layout=='combo_slider_one' || $mi_testimonial_layout=='combo_slider_two' || $mi_testimonial_layout=='combo_slider'){
                $mi_testimonial_has_dot = 'false';
                $mi_testimonial_has_nav = 'true';
                include($this->mi_get_plugin_style_path('styles/slider'));
            }else{
                include($this->mi_get_plugin_style_path('styles/' . $mi_testimonial_layout));
            }

            ?>
            <style>

                <?php
                if ($mi_testimonial_quote_txt_color!==false){
                ?>
                .mi-testimonial-container-<?php echo $mi_testimonial_id; ?> .mi-testimonial-block__para {
                    color: <?php echo $mi_testimonial_quote_txt_color;?>
                }

                <?php
                }
                ?>

                <?php
                    if ($mi_testimonial_quote_bg_color!==false){
                ?>
                .mi-testimonial-container-<?php echo $mi_testimonial_id; ?> .mi-testimonial-block__quote {
                    background-color: <?php echo $mi_testimonial_quote_bg_color; ?>;
                }

                <?php
                }
                ?>

                <?php
                if ($mi_testimonial_quote_bg_color!==false){
                ?>
                .mi-testimonial-container-<?php echo $mi_testimonial_id; ?> .mi-testimonial-block__quote::before {
                    background: <?php echo $mi_testimonial_quote_bg_color; ?>;
                }

                <?php
                }
                ?>

                <?php
                if ($mi_testimonial_quote_bg_color!==false){
                ?>
                .mi-testimonial-container-<?php echo $mi_testimonial_id; ?> .mi-testimonial-block__quote::after {
                    background: <?php echo $mi_testimonial_quote_bg_color; ?>;
                }

                <?php
                }
                ?>

                .mi-testimonial-container-<?php echo $mi_testimonial_id; ?> .mi-testimonial-block__media-left .mi-testimonial-block__media-object {
                <?php
                 if ($mi_testimonial_author_image_border!==false){
                 ?> border-radius: <?php echo $mi_testimonial_author_image_border; ?>%;
                <?php
                }
                if ($mi_testimonial_author_image_border_color!==false){
                ?> border-color: <?php echo $mi_testimonial_author_image_border_color; ?>;
                <?php
                }
               ?>
                }

                .mi-testimonial-container-<?php echo $mi_testimonial_id; ?> .mi-testimonial-block__heading {

                <?php
             if ($mi_testimonial_author_name_font_size!==false){
             ?> font-size: <?php echo $mi_testimonial_author_name_font_size; ?>px !important;
                <?php
                }
                if ($mi_testimonial_author_name_font_color!==false){
                ?> color: <?php echo $mi_testimonial_author_name_font_color; ?> !important;
                <?php
                }
               ?>
                }

                .mi-testimonial-container-<?php echo $mi_testimonial_id; ?> .mi-testimonial-block__subheading {
                    font-size: <?php echo $mi_testimonial_author_designation_font_size; ?>px !important;
                    color: <?php echo $mi_testimonial_author_designation_font_color; ?> !important;
                }

                .mi-testimonial-container-<?php echo $mi_testimonial_id; ?> .mi-testimonial-block .mi-testimonial-block__media-left a img {
                    border-color: <?php echo $mi_testimonial_author_image_border_color;?>;
                }

                .mi-testimonial-container-<?php echo $mi_testimonial_id; ?> .mi-testimonial-block:hover .mi-testimonial-block__media-left a img {
                    border-color: <?php echo $mi_testimonial_author_image_h_border_color;?>;
                }

                .mi-testimonial-container-<?php echo $mi_testimonial_id; ?> .mi-testimonial-block__media-object-wrapper::before {
                    background: <?php echo $mi_testimonial_quote_bg_color;?>;
                }


                .mi-testimonial-container-<?php echo $mi_testimonial_id; ?> .mi-owl-prev {
                    color: <?php echo $mi_testimonial_nav_text_color;?> !important;
                    background-color: <?php echo $mi_testimonial_nav_background_color; ?> !important;
                }

                .mi-testimonial-container-<?php echo $mi_testimonial_id; ?> .mi-owl-next {
                    color: <?php echo $mi_testimonial_nav_text_color;?> !important;
                    background-color: <?php echo $mi_testimonial_nav_background_color; ?> !important;
                }

                .mi-testimonial-container-<?php echo $mi_testimonial_id; ?> .mi-owl-prev:hover {
                    color: <?php echo $mi_testimonial_nav_text_hover_color;?> !important;
                    background-color: <?php echo $mi_testimonial_nav_background_hover_color; ?> !important;
                }

                .mi-testimonial-container-<?php echo $mi_testimonial_id; ?> .mi-owl-next:hover {
                    color: <?php echo $mi_testimonial_nav_text_hover_color;?> !important;
                    background-color: <?php echo $mi_testimonial_nav_background_hover_color; ?> !important;
                }


                .mi-testimonial-container-<?php echo $mi_testimonial_id; ?> .mi-testimonial-block--bg {
                    background-color: <?php echo $mi_testimonial_quote_bg_color; ?> !important;
                }

                .mi-testimonial-container-<?php echo $mi_testimonial_id; ?> .mi-testimonial-carousel-active-trigger .mi-testimonial-carousel-trigger-image::before {
                    background-color: <?php echo $mi_testimonial_quote_bg_color; ?> !important;
                }

                .mi-testimonial-container-<?php echo $mi_testimonial_id; ?> .mi-testimonial-carousel-active-trigger .mi-testimonial-carousel-trigger-image::after {
                    background-color: <?php echo $mi_testimonial_quote_bg_color; ?> !important;
                }

            </style>

            <?php

        }


    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Mi_Testimonial_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Mi_Testimonial_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style('mi-owl-css', plugin_dir_url(__FILE__) . 'css/owl.carousel.css', array(), false, 'all');
        wp_enqueue_style('mi-testimonial', plugin_dir_url(__FILE__) . 'css/mi-testimonial-public.css', array(), false, 'all');
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Mi_Testimonial_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Mi_Testimonial_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_script('jquery');
        wp_enqueue_script('mi-owl-js', plugin_dir_url(__FILE__) . 'js/owl.carousel.js', array(), false, true);
        wp_enqueue_script('mi-testimonial', plugin_dir_url(__FILE__) . 'js/mi-testimonial-public.js', array('jquery', 'mi-owl-js'), false, true);

    }

}
