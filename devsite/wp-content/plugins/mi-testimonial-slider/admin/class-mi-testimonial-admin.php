<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

ob_start();
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://miplugins.com
 * @since      1.0.0
 *
 * @package    Mi_Testimonial
 * @subpackage Mi_Testimonial/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Mi_Testimonial
 * @subpackage Mi_Testimonial/admin
 * @author     Mi Plugins <miplugins@gmail.com>
 */
class Mi_Testimonial_Admin
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
     * The basename of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string $basename The basename of the plugin.
     */
    protected $mi_public_defaults_values = array(

        'display_mode'  => array('style_one'),
        'grid'          => array(1,2,3,4),
        'layout'        => array('slider','grid'),
        'bool'          => array("true","false"),
        'designation'   => array("yes","no")
    );



    public $slides = array();


    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string $plugin_name The name of this plugin.
     * @param      string $version The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
        $this->register_option_key();
    }


    /*
     * get Option value
     * */
    private function get_option_value()
    {
        return get_option('_mi_testimonial_items');

    }


    function register_option_key()
    {
        $d_uid = $this->mi_uid();

        $testimonial_items[$d_uid] = array(
            'title' => 'no title',
            'shortcode' => '[mi-testimonial id ='.$d_uid.']',
            'testimonial' => array(),
            'category'=> null,
            'settings' => array(),
        );
        add_option('_mi_testimonial_items', $testimonial_items);
    }



    /**
     * Register the stylesheets for the admin area.
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
        wp_enqueue_style('wp-color-picker');
        wp_enqueue_style('mi-testimonial-admin', plugin_dir_url(__FILE__) . 'css/mi-testimonial-admin.css', array(), false, 'all');
    }


    /**
     * Add an setting page
     *
     * @since  1.0.0
     */
    public function add_settings_page()
    {

        $page_title = esc_html__('Mi Testimonial', 'mi-testimonial');
        $menu_title = esc_html__('Mi Testimonial', 'mi-testimonial');
        $capability = 'manage_options';
        $menu_slug = $this->plugin_name;
        $function = array($this, 'display_options_page_main');
        $icon_url = '';
        $position = 100;
        add_menu_page($page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position);


        $parent_slug = $this->plugin_name;
        $page_title = esc_html__('Get Premium', 'mi-testimonial');
        $menu_title = esc_html__('Get Premium', 'mi-testimonial');
        $capability = 'manage_options';
        $menu_slug = 'mi_testimonial_premium';
        $function = array($this, 'display_premium_page');
        add_submenu_page($this->plugin_name, $page_title, $menu_title, $capability, $menu_slug, $function);


        $parent_slug = $this->plugin_name;
        $page_title = esc_html__('Mi Others', 'mi-testimonial');
        $menu_title = esc_html__('Mi Others', 'mi-testimonial');
        $capability = 'manage_options';
        $menu_slug = 'mi_testimonial_others';
        $function = array($this, 'display_other_page');
        add_submenu_page($parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function);
        register_setting($menu_slug, '');
        
    }



    function show_row_form($id = null)
    {

        $title = '';
        $encoded_testimonials = '';
        $display_mode = '';
        $position = '';
        $design_option = '';
        $quote_txt_color = '';
        $quote_bg_color = '';
        $layout = '';
        $author_image_border = 50;
        $author_image_border_color = '';
        $author_name_font_size = 15;
        $author_name_font_color = '';
        $author_designation = '';
        $author_designation_font_size = 10;
        $large_desktop_number_of_grid = 4;
        $desktop_number_of_grid = 4;
        $tab_number_of_grid = 3;
        $mobile_number_of_grid = 2;
        $small_mobile_number_of_grid = 1;
        $author_designation_font_color = '';
        $nav_text_color = '';
        $nav_text_hover_color = '';
        $nav_background_color = '';
        $nav_background_hover_color = '';
        $author_image_border_hover_color = '';
        $nav_inner='';

        if ($id) {

            $optionValue = $this->get_option_value()[$id];
            $unique_id = $id;
            $genarated_shortcode = $optionValue['shortcode'];
            $title = $optionValue['title'];
            $uploaded_testimonials = $optionValue['testimonial'];

            $encoded_testimonials = json_encode($uploaded_testimonials, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);

            $settings_value = $optionValue['settings'];
                if(count($settings_value)>0):
            $display_mode = $settings_value['display_mode'];
            $design_option = $settings_value['design_option'];
            $position = $settings_value['position'];
            $nav_text_color = $settings_value['nav_text_color'];
            $nav_text_hover_color = $settings_value['nav_text_color'];
            $nav_background_color = $settings_value['nav_background_color'];
            $nav_background_hover_color = $settings_value['nav_background_hover_color'];
            $quote_txt_color = $settings_value['quote_txt_color'];
            $quote_bg_color = $settings_value['quote_bg_color'];
            $layout = $settings_value['layout'];
            $author_designation_font_color = $settings_value['author_designation_font_color'];
            $author_image_border = $settings_value['author_image_border'];
            $author_image_border_color = $settings_value['author_image_border_color'];
            $author_image_border_hover_color = $settings_value['author_image_border_hover_color'];
            $author_name_font_size = $settings_value['author_name_font_size'];
            $author_name_font_color = $settings_value['author_name_font_color'];
            $author_designation = $settings_value['author_designation'];
            $author_designation_font_size = $settings_value['author_designation_font_size'];
            $desktop_number_of_grid = $settings_value['desktop_number_of_grid'];
            $tab_number_of_grid = $settings_value['tab_number_of_grid'];
            $mobile_number_of_grid = $settings_value['mobile_number_of_grid'];
            $small_mobile_number_of_grid = $settings_value['small_mobile_number_of_grid'];
            $large_desktop_number_of_grid = $settings_value['large_desktop_number_of_grid'];
            $nav_inner = $settings_value['nav_inner'];
            endif;

        } else {
            $unique_id = $this->mi_uid();
            $genarated_shortcode = '[mi-testimonial id=' . $unique_id . ']';
        }


        ?>
        <form action="admin.php?page=<?php echo $this->plugin_name ?>&action=submit_data" method="post" enctype="multipart/form-data">
            <fieldset class="new-slide">
                <div class="wrap">
                    <h1><?php esc_html_e('Add New Testimonial', 'mi_testimonial'); ?></h1>
                </div>
                <div id="titlediv">
                    <div id="titlewrap">

                        <?php wp_nonce_field($this->plugin_name,'mi_testimonial_slider_nonce');?>
                        <input type='hidden' name="new_testimonial_id" placeholder="<?php esc_html_e('Title', 'mi_testimonial'); ?>" value='<?php echo $unique_id; ?>' readonly/>
                        <label class="screen-reader-text" id="title-prompt-text" for="title"><?php esc_html_e('Enter title here', 'mi_testimonial'); ?></label>
                        <input type='text' id="title" size="30" class="v" name="new_testimonial_title" placeholder="<?php esc_html_e('Title', 'mi_testimonial'); ?>" value='<?php echo esc_html($title); ?>'/>
                        <div class="mi-innner-shortcode">
                            <span><?php esc_html_e('Shortcode', 'mi_testimonial'); ?>: </span>
                            <input type='text' size="35" name="new_testimonial_shortcode" onfocus="this.select();" value='<?php echo esc_html($genarated_shortcode); ?>' readonly/>
                        </div>

                    </div>
                </div>

            </fieldset>

            <div class="mi-tab mi-tab-testimonial tabs-style-flip">

                <ul class="mi-testimonial-tabs-control">
                    <li class="tab-current"><a href="#mi-add-testimonial"><?php esc_html_e('Add Testimonial', 'mi_testimonial'); ?></a></li>
                    <li><a href="#mi-testimonial-settings"><?php esc_html_e('Settings', 'mi_testimonial'); ?></a></li>
                </ul>

                <div class="mi-testimonial-tabs-content">

                    <section id="mi-add-testimonial" class="content-current">
                        <fieldset class="testimonial_section testimonial_repeater">
                            <?php wp_enqueue_media(); ?>
                            <table data-repeater-list="add_more_testimonial" class='wp-list-table widefat fixed striped mi-plugin-table image-preview-wrapper'>
                                <thead>
                                <tr>
                                    <th scope="col" class="column-image"><?php esc_html_e('Image', 'mi_testimonial'); ?></th>
                                    <th scope="col" class="column-title"><?php esc_html_e('Name', 'mi_testimonial'); ?></th>
                                    <th scope="col" class="column-title"><?php esc_html_e('Designation/Company', 'mi_testimonial'); ?></th>
                                    <th scope="col" class="column-description"><?php esc_html_e('Testimonial', 'mi_testimonial'); ?></th>
                                    <th scope="col" class="column-action"><?php esc_html_e('Delete', 'mi_testimonial'); ?></th>
                                </tr>
                                </thead>
                                <tbody id="image-list">
                                <?php
                                if ($encoded_testimonials !== '' && isset($uploaded_testimonials) && count($uploaded_testimonials)>0):

                                    foreach ($uploaded_testimonials as $item):
                                        ?>
                                        <tr class="mi-testimonial-single mi-testimonial-id-<?php echo esc_attr($item->id); ?>"
                                            data-testimonial-id="<?php echo $item->id; ?>" data-repeater-item>

                                            <td class="column-thumb" data-colname="Title">
                                                <div class="thumb-wrapper-div">
                                                    <img class="mi-testimonial-author-image" width="40px" height="40px" src="<?php echo esc_attr($item->author_image); ?>" alt="">
                                                    <a href="#" class="mi-testimonial-thumb-change"><?php esc_html_e('Change', 'mi_testimonial'); ?></a>
                                                </div>
                                                <input type="button" class="button upload_image_button" style="display:none;" value="<?php _e('Upload image'); ?>"/>
                                                <input type="hidden" name="author_image" class='mi_testimonial_author_image' value="<?php echo esc_attr($item->author_image); ?>">
                                                <input type="hidden" name="id" class='mi_testimonial_id' value="<?php echo esc_attr($item->id); ?>">
                                            </td>

                                            <td class="column-title">
                                                <input class="testimonial-title" type="text" name="author_name" value="<?php echo esc_attr($item->author_name); ?>" placeholder="Name">
                                            </td>

                                            <td class="column-title">
                                                <input class="testimonial-title" type="text" name="designation" value="<?php echo esc_attr($item->designation); ?>">
                                            </td>

                                            <td class="column-description">
                                                <textarea class="testimonial-description" name="description"  placeholder="<?php esc_html_e('Testimonial Description', 'mi_testimonial'); ?>"><?php echo esc_attr($item->description); ?></textarea>
                                            </td>

                                            <td class="column-action" align="center">
                                                <input data-repeater-delete="" type="button" class="mi-logo-color-danger danger-button" value="X" align="center">
                                            </td>
                                        </tr>

                                    <?php endforeach;

                                else:
                                    ?>
                                    <tr class="mi-testimonial-single mi-testimonial-id-" data-repeater-item>
                                        <td>
                                            <input type="button" class="button upload_image_button" value="<?php _e('Upload image'); ?>"/>
                                            <input type='hidden' name='author_image' class='mi_testimonial_author_image'>
                                            <input type="hidden" name="id" class='mi_testimonial_id'>
                                        </td>
                                        <td><input type="text" name="author_name"></td>
                                        <td><input type="text" name="designation"></td>
                                        <td><textarea rows="3" name="description" placeholder="<?php esc_html_e('Testimonial Description', 'mi_testimonial'); ?>"></textarea></td>
                                        <td align="center"><input data-repeater-delete="" type="button" class="mi-logo-color-danger danger-button" value="X"></td>
                                    </tr>
                                <?php endif; ?>
                                </tbody>

                            </table>
                            <br>
                            <input data-repeater-create type='button' value='<?php esc_html_e('Add More', 'mi_testimonial'); ?>' class="button-primary"/>
                            <input type="hidden" name="mi_testimonial_data" class="mi_testimonial_data" value='<?php echo $encoded_testimonials; ?>'>

                        </fieldset>
                    </section>

                    <section id="mi-testimonial-settings">
                        <fieldset class="settings">
                            <h2 class="title remove-something"><?php esc_html_e('Testimonial Style', 'mi_testimonial'); ?> </h2>
                            <table class="form-table">
                                <tr>
                                    <th>
                                        <label for="Testimonial Style"> <?php esc_html_e('Testimonial Style', 'mi_testimonial'); ?></label>
                                    </th>
                                    <td>
                                        <select name="display_mode" id="display_mode" style="width: 150px">
                                            <option value="style_one" selected><?php esc_html_e('Style One', 'mi_testimonial'); ?></option>
                                            <option disabled><?php esc_html_e('Style Two', 'mi_testimonial'); ?></option>
                                            <option disabled><?php esc_html_e('Style Three', 'mi_testimonial'); ?></option>
                                            <option disabled><?php esc_html_e('Style Four', 'mi_testimonial'); ?></option>
                                            <option disabled><?php esc_html_e('Style Five', 'mi_testimonial'); ?></option>
                                        </select>
                                    </td>
                                </tr>
                            </table>


                            <!--For Style One-->
                            <div class="style-one">
                                <table class="form-table">
                                    <tr>
                                        <th>
                                            <label for="Layouts"><?php esc_html_e('Layouts', 'mi_testimonial'); ?> </label>
                                        </th>
                                        <td>
                                            <select class="style-one-layouts" name="style_one_layout">
                                                <option value="slider" <?php echo ($layout == 'slider') ? "selected" : "" ?>><?php esc_html_e('Slider', 'mi_testimonial'); ?></option>
                                                <option value="grid" <?php echo ($layout == 'grid') ? "selected" : "" ?>><?php esc_html_e('Grid', 'mi_testimonial'); ?></option>
                                                <option disabled><?php esc_html_e('Filter', 'mi_testimonial'); ?></option>
                                                <option disabled><?php esc_html_e('Combo Slider One', 'mi_testimonial'); ?></option>
                                                <option disabled><?php esc_html_e('Combo Slider Two', 'mi_testimonial'); ?></option>
                                            </select>
                                        </td>
                                    </tr>
                                </table>

                                <table class="form-table style-one-show-slider-option">
                                    <tr>
                                        <th>
                                            <label for="Slider Style"><?php esc_html_e('Slider Style', 'mi_testimonial'); ?> </label>
                                        </th>
                                        <td>
                                            <select class="style-one-slider-style-view" name="style_one_slider_style">
                                                <option value="nav" <?php echo ($design_option == 'nav') ? "selected" : "" ?>>
                                                    <?php esc_html_e('Nav View', 'mi_testimonial'); ?>
                                                </option>
                                            </select>

                                        </td>
                                    </tr>

                                    <tr class="style-one-nav-position">
                                        <th>
                                            <label for="nav-position-h"><?php esc_html_e('Nav Position', 'mi_testimonial'); ?></label>
                                        </th>
                                        <td class="style-one-nav-position-horizontal">
                                            <select name="style_one_nav_position" style="width: 150px">
                                                <option value="both_side" <?php echo ($position == 'both_side') ? "selected" : "" ?> >
                                                    <?php esc_html_e('Both Side', 'mi_testimonial'); ?>
                                                </option>
                                            </select>
                                        </td>
                                    </tr>

                                    <tr class="style-one-nav-color">
                                        <th><label for="nav_color"><?php esc_html_e('Nav Text Color', 'mi_testimonial'); ?></label></th>
                                        <td><input type="text" name="style_one_nav_text_color" class="color-field" value="<?php echo $nav_text_color; ?>"></td>
                                    </tr>

                                    <tr class="style-one-nav-color">
                                        <th><label for="nav_color"><?php esc_html_e('Nav Background Color', 'mi_testimonial'); ?></label></th>
                                        <td><input type="text" name="style_one_nav_background_color" class="color-field" value="<?php echo $nav_background_color; ?>"></td>
                                    </tr>

                                    <tr class="style-one-nav-color">
                                        <th><label for="nav_color"><?php esc_html_e('Nav Text Hover Color', 'mi_testimonial'); ?></label></th>
                                        <td><input type="text" name="style_one_nav_text_hover_color" class="color-field" value="<?php echo $nav_text_hover_color; ?>"></td>
                                    </tr>

                                    <tr class="style-one-nav-color">
                                        <th><label for="nav_color"><?php esc_html_e('Nav Background Hover Color', 'mi_testimonial'); ?></label></th>
                                        <td><input type="text" name="style_one_nav_background_hover_color" class="color-field" value="<?php echo $nav_background_hover_color; ?>"></td>
                                    </tr>

                                    <tr class="style-one-nav-color">
                                        <th><label for="nav_color"><?php esc_html_e('Nav Within Container', 'mi_testimonial'); ?></label></th>
                                        <td>
                                            <input type="checkbox" name="style_one_nav_inner" value="yes" <?php if ($nav_inner=='yes') {echo 'checked';} ?>>
                                            <p class="description"> <?php esc_html_e('This option allow you to include the nav in the container', 'mi_testimonial'); ?></p>
                                        </td>
                                    </tr>

                                </table>

                            </div>

                            <h2 class="title"><?php esc_html_e('Design Option', 'mi_testimonial'); ?></h2>

                            <table class="form-table">

                                <tr>
                                    <th><?php esc_html_e('Quote/Testimonial Design', 'mi_testimonial'); ?> :</th>
                                </tr>

                                <tr>
                                    <th><label for="quote_text_color"><?php esc_html_e('Text Color', 'mi_testimonial'); ?> </label></th>
                                    <td><input type="text" name="quote_txt_color" class="color-field" value="<?php echo $quote_txt_color; ?>">
                                    </td>
                                </tr>

                                <tr>
                                    <th><label for="quote_bg_color"><?php esc_html_e('Background Color', 'mi_testimonial'); ?> </label></th>
                                    <td><input type="text" name="quote_bg_color" class="color-field" value="<?php echo $quote_bg_color; ?>">
                                    </td>
                                </tr>

                                <tr>
                                    <th><?php esc_html_e('Author Design', 'mi_testimonial'); ?> :</th>
                                </tr>

                                <tr>
                                    <th><label for="author_image_border"><?php esc_html_e('Image Border (in percentage)', 'mi_testimonial'); ?> </label></th>
                                    <td><input type="text" name="author_image_border"  value="<?php echo $author_image_border; ?>">
                                    </td>
                                </tr>

                                <tr>
                                    <th><label for="author_image_border_color"><?php esc_html_e('Image Border Color', 'mi_testimonial'); ?> </label></th>
                                    <td><input type="text" name="author_image_border_color" class="color-field"   value="<?php echo $author_image_border_color; ?>">
                                    </td>
                                </tr>

                                <tr>
                                    <th><label for="author_image_border_hover_color"><?php esc_html_e('Image Border Hover Color', 'mi_testimonial'); ?> </label></th>
                                    <td><input type="text" name="author_image_border_hover_color" class="color-field" value="<?php echo $author_image_border_hover_color; ?>">
                                    </td>
                                </tr>

                                <tr>
                                    <th><label for="author_name_font_size"><?php esc_html_e('Author Name Font Size', 'mi_testimonial'); ?> </label></th>
                                    <td><input type="text" name="author_name_font_size" value="<?php echo $author_name_font_size; ?>">
                                    </td>
                                </tr>

                                <tr>
                                    <th><label for="author_name_font_color"><?php esc_html_e('Author Name Font Color', 'mi_testimonial'); ?> </label></th>
                                    <td><input type="text" name="author_name_font_color" class="color-field" value="<?php echo $author_name_font_color; ?>">
                                    </td>
                                </tr>


                                <tr>
                                    <th><label for="Designation"><?php esc_html_e('Author Designation/Company', 'mi_testimonial'); ?></label></th>
                                    <td>
                                        <select class="author-designation" name="author_designation"
                                                style="width: 100px">
                                            <option
                                                value="yes" <?php echo ($author_designation == 'yes') ? "selected" : "" ?>>
                                                <?php esc_html_e('Yes', 'mi_testimonial'); ?>
                                            </option>
                                            <option
                                                value="no" <?php echo ($author_designation == 'no') ? "selected" : "" ?>>
                                                <?php esc_html_e('No', 'mi_testimonial'); ?>
                                            </option>
                                        </select>
                                    </td>
                                </tr>


                                <tr class="show-author-designation">
                                    <th><label for="author_designation_font_size"> <?php esc_html_e('Designation/Company Font Size', 'mi_testimonial'); ?></label></th>
                                    <td><input type="text" name="author_designation_font_size" value="<?php echo $author_designation_font_size; ?>">
                                    </td>
                                </tr>

                                <tr class="show-author-designation">
                                    <th><label for="author_designation_font_color"><?php esc_html_e('Designation/Company Font Color', 'mi_testimonial'); ?> </label></th>
                                    <td><input type="text" name="author_designation_font_color" class="color-field" value="<?php echo $author_designation_font_color; ?>">
                                    </td>
                                </tr>

                            </table>

                            <h2 class="title responsive-design"><?php esc_html_e('Visibility Settings', 'mi_testimonial'); ?></h2>

                            <table class="form-table responsive-design">

                                <tr>
                                    <th>
                                        <label for="large-desktop-view"><?php esc_html_e('Large Desktop Grid Number', 'mi_testimonial'); ?></label>
                                    </th>
                                    <td class="nav-position-h">
                                        <select name="large_desktop_number_of_grid" id="large-desktop-view" style="width: 100px">
                                            <option value="1" <?php echo ($large_desktop_number_of_grid == '1') ? "selected" : "" ?>><?php esc_html_e('1', 'mi_testimonial'); ?>
                                            </option>
                                            <option value="2" <?php echo ($large_desktop_number_of_grid == '2') ? "selected" : "" ?>>
                                                <?php esc_html_e('2', 'mi_testimonial'); ?>
                                            </option>
                                            <option value="3" <?php echo ($large_desktop_number_of_grid == '3') ? "selected" : "" ?>>
                                                <?php esc_html_e('3', 'mi_testimonial'); ?>
                                            </option>
                                            <option value="4" <?php echo ($large_desktop_number_of_grid == '4') ? "selected" : "" ?>>
                                                <?php esc_html_e('4', 'mi_testimonial'); ?>
                                            </option>
                                        </select>
                                    </td>
                                </tr>

                                <tr>
                                    <th>
                                        <label for="desktop-view"> <?php esc_html_e('Desktop Grid Number', 'mi_testimonial'); ?> </label>
                                    </th>
                                    <td class="nav-position-h">
                                        <select name="desktop_number_of_grid" id="desktop-view" style="width: 100px">
                                            <option value="1" <?php echo ($desktop_number_of_grid == '1') ? "selected" : "" ?>>
                                                <?php esc_html_e('1', 'mi_testimonial'); ?>
                                            </option>
                                            <option value="2" <?php echo ($desktop_number_of_grid == '2') ? "selected" : "" ?>>
                                                <?php esc_html_e('2', 'mi_testimonial'); ?>
                                            </option>
                                            <option value="3" <?php echo ($desktop_number_of_grid == '3') ? "selected" : "" ?>>
                                                <?php esc_html_e('3', 'mi_testimonial'); ?>
                                            </option>
                                            <option value="4" <?php echo ($desktop_number_of_grid == '4') ? "selected" : "" ?>>
                                                <?php esc_html_e('4', 'mi_testimonial'); ?>
                                            </option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <label for="tab-view"><?php esc_html_e('Tab Grid Number', 'mi_testimonial'); ?> </label>
                                    </th>
                                    <td class="nav-position-h">
                                        <select name="tab_number_of_grid" id="tab-view" style="width: 100px">
                                            <option
                                                value="1" <?php echo ($tab_number_of_grid == '1') ? "selected" : "" ?>> <?php esc_html_e('1', 'mi_testimonial'); ?>
                                            </option>
                                            <option
                                                value="2" <?php echo ($tab_number_of_grid == '2') ? "selected" : "" ?>> <?php esc_html_e('2', 'mi_testimonial'); ?>
                                            </option>
                                            <option
                                                value="3" <?php echo ($tab_number_of_grid == '3') ? "selected" : "" ?>> <?php esc_html_e('3', 'mi_testimonial'); ?>
                                            </option>
                                            <option
                                                value="4" <?php echo ($tab_number_of_grid == '4') ? "selected" : "" ?>> <?php esc_html_e('4', 'mi_testimonial'); ?>
                                            </option>
                                        </select>
                                    </td>
                                </tr>

                                <tr>
                                    <th>
                                        <label for="mobile-view"><?php esc_html_e('Mobile Grid Number', 'mi_testimonial'); ?> </label>
                                    </th>
                                    <td class="nav-position-h">
                                        <select name="mobile_number_of_grid" id="mobile-view" style="width: 100px">
                                            <option value="1" <?php echo ($mobile_number_of_grid == '1') ? "selected" : "" ?>><?php esc_html_e('1', 'mi_testimonial'); ?></option>
                                            <option value="2" <?php echo ($mobile_number_of_grid == '2') ? "selected" : "" ?>><?php esc_html_e('2', 'mi_testimonial'); ?></option>
                                            <option value="3" <?php echo ($mobile_number_of_grid == '3') ? "selected" : "" ?>><?php esc_html_e('3', 'mi_testimonial'); ?></option>
                                            <option value="4" <?php echo ($mobile_number_of_grid == '4') ? "selected" : "" ?>><?php esc_html_e('4', 'mi_testimonial'); ?></option>
                                        </select>
                                    </td>
                                </tr>

                                <tr>
                                    <th>
                                        <label for="small-mobile-view"> <?php esc_html_e('Small Mobile Grid Number', 'mi_testimonial'); ?></label>
                                    </th>
                                    <td class="nav-position-h">
                                        <select name="small_mobile_number_of_grid" id="small-mobile-view"
                                                style="width: 100px">
                                            <option
                                                value="1" <?php echo ($small_mobile_number_of_grid == '1') ? "selected" : "" ?>><?php esc_html_e('1', 'mi_testimonial'); ?>
                                            </option>
                                            <option
                                                value="2" <?php echo ($small_mobile_number_of_grid == '2') ? "selected" : "" ?>><?php esc_html_e('2', 'mi_testimonial'); ?>
                                            </option>
                                            <option
                                                value="3" <?php echo ($small_mobile_number_of_grid == '3') ? "selected" : "" ?>><?php esc_html_e('3', 'mi_testimonial'); ?>
                                            </option>
                                            <option
                                                value="4" <?php echo ($small_mobile_number_of_grid == '4') ? "selected" : "" ?>><?php esc_html_e('4', 'mi_testimonial'); ?>
                                            </option>
                                        </select>
                                    </td>
                                </tr>
                            </table>


                        </fieldset>
                    </section>

                </div>

            </div>


            <input type="submit" value="Publish" id="mi-publish" class="button button-primary">


        </form>

        <?php

    }


    function display_options_page_main()
    {
        include_once 'partials/mi-plugin-admin-display-main.php';
    }

    function display_options_page_premium()
    {

    }

    function display_options_page_new()
    {
        include_once 'partials/admin-display-slide-new.php';
    }

    function _raid($l){
        return substr(str_shuffle(str_repeat('123456789',$l)),0,$l);
    }
    /**
     * Unique Id Generator
     **/

    public function mi_uid()
    {
        return $this->_raid(8);
    }


    /**
     * @param $value
     * @param string $type
     * @return string
     */

    public static function mi_form_validation($value, $type )
    {
        if(!in_array($type, array('text', 'color', 'title', 'url', 'int'))) {
            throw new Exception("type not valid");
            return;
        }

        $value = trim($value);
        $value = stripslashes($value);


        if ( $type == 'text' ) {
            return sanitize_text_field($value);
        }

        if ($type == "color"){
            return sanitize_hex_color($value);
        }

        if ($type == "title"){
            return sanitize_title($value);
        }


        if ($type == "url"){
            return esc_url($value);
        }


        if ($type == "int"){
            return intval($value);
        }



    }


    /**
     * @param $item
     * @return mixed
     */
    public static function walk_recursive(&$item, &$key)
    {
        $type = 'text';
        if($key == 'id'){
            $type = 'int';
        } ;
        if($key == 'url' || $key == 'link'){
            $type = 'url';
        } ;
        if ($key == 'title') {
            $type = 'title';
        };
        return $item = array_map('self::mi_form_validation', (array)$item,(array)$type)[0];//have to
        // replace value with previsous value and return it. just like item
    }


    /*
     * return Delete Slide
     * */
    public function delete_slide($id)
    {

        $optionValue = $this->get_option_value();
        unset($optionValue[$id]);

        update_option('_mi_testimonial_items', $optionValue, 'yes');

        wp_safe_redirect(add_query_arg(array('page' => 'mi-testimonial'), admin_url('admin.php')));
        exit;

    }

    function display_premium_page()
    {
        include_once 'partials/admin-display-get-premium.php';
    }

    function display_other_page()
    {
        include_once 'partials/admin-display-other-products.php';
    }


    /**
     * Add custom action links to the plugin
     *
     * @since  1.0.0
     */
    public function add_action_links($actions, $plugin_file)
    {

        $action_links = array();

        $action_links['settigns'] = array(
            'label' => __('Settings', 'mi-testimonial'),
            'url' => get_admin_url(null, 'admin.php?page=mi-testimonial-slider')
        );

        return $this->plugin_action_links($actions, $plugin_file, $action_links, 'before');

    }


    private function plugin_action_links($actions, $plugin_file, $action_links = array(), $position = 'after')
    {

        if ($this->basename == $plugin_file && !empty($action_links)) {

            foreach ($action_links as $key => $value) {

                $target = "";

                if (isset($value['new_tab']) && !empty($value['new_tab']) && $value['new_tab']) {
                    $target = "target='_blank'";
                }

                $link = array($key => '<a href="' . $value['url'] . '" ' . $target . '>' . $value['label'] . '</a>');

                if ($position == 'after') {
                    $actions = array_merge($actions, $link);
                } else {
                    $actions = array_merge($link, $actions);
                }

            }

        }

        return $actions;

    }


    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Mi_Plugin_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Mi_Plugin_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */



        // Include our custom jQuery file with WordPress Color Picker dependency
        wp_enqueue_script('mi-repater-js', plugin_dir_url(__FILE__) . 'js/jquery.repeater.js', array('jquery'), false, true);
        wp_enqueue_script('mi-testimonial-admin-js', plugin_dir_url(__FILE__) . 'js/mi-testimonial-admin.js', array('jquery', 'wp-color-picker', 'mi-repater-js'), false, true);

    }


}


if ( ! function_exists( 'sanitize_hex_color' ) ) {
    function sanitize_hex_color( $color ) {
        if ( '' === $color )
            return '';

        // 3 or 6 hex digits, or the empty string.
        if ( preg_match('|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) )
            return $color;

        return null;
    }
}