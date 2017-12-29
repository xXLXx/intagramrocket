<?php
// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>
<div class="wrap">
    <?php

    $action = (isset($_GET['action'])) ? $_GET['action'] : false;

    //add or edit new logo row.
    if ($action === 'submit_data' && isset($_REQUEST['new_testimonial_id']) && wp_verify_nonce($_POST['mi_testimonial_slider_nonce'], $this->plugin_name)) {


        $id = $this->mi_form_validation($_REQUEST['new_testimonial_id'],'int'); //get the logo id
        $testimonial_items = $this->get_option_value();
        $title = $this->mi_form_validation($_POST['new_testimonial_title'],'title');


        if (empty(trim($title))) {
            $title = '( no title )';
        }

        $shortcode = $this->mi_form_validation($_POST['new_testimonial_shortcode'],'text');
        $image_data = $_POST['add_more_testimonial'];
        $image_data = json_encode($image_data);
        $image_data = json_decode(stripslashes($image_data));

        foreach ($image_data as $key => $value) {
            array_walk_recursive($value, 'Mi_Testimonial_Admin::walk_recursive');

        }

        $display_mode = $this->mi_form_validation($_POST['display_mode'],'text');
        $display_mode = (!in_array($display_mode, $this->mi_public_defaults_values['display_mode'])) ?
            $this->mi_public_defaults_values['display_mode'][0] : $display_mode;
        $position = '';
        $filter_text_color = '';
        $filter_bg_color = '';
        $layout = '';
        $author_position = '';
        $filter_text_hover_color = '';
        $filter_text_bg_hover_color = '';
        $dot_text_color = '';
        $dot_background_color = '';
        $dot_text_hover_color = '';
        $dot_background_hover_color = '';
        $nav_text_color = '';
        $nav_text_hover_color = '';
        $nav_background_color = '';
        $nav_background_hover_color = '';
        $nav_inner='';
        $large_desktop_number_of_grid='';

        if ($display_mode == 'style_one') {

            $layout = $this->mi_form_validation($_POST['style_one_layout'],'text');
            $layout = (!in_array($layout, $this->mi_public_defaults_values['layout'])) ?
                $this->mi_public_defaults_values['layout'][0] : $layout;
            $design_option = $this->mi_form_validation($_POST['style_one_slider_style'],'text');

            if ($design_option == 'dot') {
                $position = $this->mi_form_validation($_POST['style_one_dot_position'],'text');
                $dot_text_color = $this->mi_form_validation($_POST['style_one_dot_text_color'],'color');
                $dot_text_hover_color = $this->mi_form_validation($_POST['style_one_dot_text_hover_color'],'color');
                $dot_background_color = $this->mi_form_validation($_POST['style_one_dot_background_color'],'color');
                $dot_background_hover_color = $this->mi_form_validation($_POST['style_one_dot_background_hover_color'],'color');
            } else {
                $position = $this->mi_form_validation($_POST['style_one_nav_position'],'text');
                $nav_text_color = $this->mi_form_validation($_POST['style_one_nav_text_color'],'color');
                $nav_text_hover_color = $this->mi_form_validation($_POST['style_one_nav_text_hover_color'],'color');
                $nav_background_color = $this->mi_form_validation($_POST['style_one_nav_background_color'],'color');
                $nav_background_hover_color = $this->mi_form_validation($_POST['style_one_nav_background_hover_color'],'color');
                if(isset($_POST['style_one_nav_inner'])){
                    $nav_inner=$this->mi_form_validation($_POST['style_one_nav_inner'],'text');
                    $nav_inner = (!in_array($nav_inner, $this->mi_public_defaults_values['designation'])) ?
                        $this->mi_public_defaults_values['designation'][0] : $nav_inner;
                }
            }

        } else {
            $design_option = '';
        }

        $quote_txt_color = $this->mi_form_validation($_POST['quote_txt_color'],'color');
        $quote_bg_color = $this->mi_form_validation($_POST['quote_bg_color'],'color');
        $author_image_border = $this->mi_form_validation($_POST['author_image_border'],'int');
        $author_image_border_color = $this->mi_form_validation($_POST['author_image_border_color'],'color');
        $author_image_border_hover_color = $this->mi_form_validation($_POST['author_image_border_hover_color'],'color');
        $author_name_font_size = $this->mi_form_validation($_POST['author_name_font_size'],'int');
        $author_name_font_color = $this->mi_form_validation($_POST['author_name_font_color'],'color');
        $author_designation = $this->mi_form_validation($_POST['author_designation'],'text');
        $author_designation = (!in_array($author_designation, $this->mi_public_defaults_values['designation'])) ?
            $this->mi_public_defaults_values['designation'][0] : $author_designation;

        if ($author_designation == 'yes') {
            $author_designation_font_color = $this->mi_form_validation($_POST['author_designation_font_color'],'color');
            $author_designation_font_size = $this->mi_form_validation($_POST['author_designation_font_size'],'int');
        } else {
            $author_designation_font_color = '';
            $author_designation_font_size = '';
        }
        $author_Rating ='';
        if(isset($_POST['author_Rating'])){

            $author_Rating = $this->mi_form_validation($_POST['author_Rating'],'text');
            $author_Rating = (!in_array($author_Rating, $this->mi_public_defaults_values['designation'])) ?
                $this->mi_public_defaults_values['designation'][0] : $author_Rating;
        }

        if ($author_Rating == 'yes') {
            $author_rating_color = $this->mi_form_validation($_POST['author_rating_color'],'color');
        } else {
            $author_rating_color = '';
        }

        $desktop_number_of_grid = $this->mi_form_validation($_POST['desktop_number_of_grid'],'int');

        $desktop_number_of_grid = (!in_array($desktop_number_of_grid, $this->mi_public_defaults_values['grid'])) ?
            $this->mi_public_defaults_values['grid'][0] : $desktop_number_of_grid;

        $tab_number_of_grid = $this->mi_form_validation($_POST['tab_number_of_grid'],'int');
        $tab_number_of_grid = (!in_array($tab_number_of_grid, $this->mi_public_defaults_values['grid'])) ?
            $this->mi_public_defaults_values['grid'][0] : $tab_number_of_grid;
        $mobile_number_of_grid = $this->mi_form_validation($_POST['mobile_number_of_grid'],'int');
        $mobile_number_of_grid = (!in_array($mobile_number_of_grid, $this->mi_public_defaults_values['grid'])) ?
            $this->mi_public_defaults_values['grid'][0] : $mobile_number_of_grid;
        $small_mobile_number_of_grid = $this->mi_form_validation($_POST['small_mobile_number_of_grid'],'int');
        $small_mobile_number_of_grid = (!in_array($small_mobile_number_of_grid, $this->mi_public_defaults_values['grid'])) ?
            $this->mi_public_defaults_values['grid'][0] : $small_mobile_number_of_grid;
        $large_desktop_number_of_grid = $this->mi_form_validation($_POST['large_desktop_number_of_grid'],'int');
        $large_desktop_number_of_grid = (!in_array($large_desktop_number_of_grid, $this->mi_public_defaults_values['grid'])) ?
            $this->mi_public_defaults_values['grid'][0] : $large_desktop_number_of_grid;


        /*add item on arr(array)*/
        $arr = array(
            'title' => $title,
            'shortcode' => $shortcode,
            'testimonial' => $image_data,
            'category' => null,
            'settings' => array()
        );


        /*add setting value*/

        if ($display_mode !== false) {
            $arr['settings']['display_mode'] = $display_mode;
        }


        if ($layout !== false) {
            $arr['settings']['layout'] = $layout;
        }

        if ($design_option !== false) {
            $arr['settings']['design_option'] = $design_option;
        }

        if ($position !== false) {
            $arr['settings']['position'] = $position;
        }

        if ($dot_text_color !== false) {
            $arr['settings']['dot_text_color'] = $dot_text_color;
        }

        if ($dot_text_hover_color !== false) {
            $arr['settings']['dot_text_hover_color'] = $dot_text_hover_color;
        }

        if ($dot_background_color !== false) {
            $arr['settings']['dot_background_color'] = $dot_background_color;
        }

        if ($dot_background_hover_color !== false) {
            $arr['settings']['dot_background_hover_color'] = $dot_background_hover_color;
        }


        if ($nav_text_color !== false) {
            $arr['settings']['nav_text_color'] = $nav_text_color;
        }

        if ($nav_text_hover_color !== false) {
            $arr['settings']['nav_text_hover_color'] = $nav_text_hover_color;
        }

        if ($nav_background_color !== false) {
            $arr['settings']['nav_background_color'] = $nav_background_color;
        }

        if ($nav_background_hover_color !== false) {
            $arr['settings']['nav_background_hover_color'] = $nav_background_hover_color;
        }

        if ($nav_inner !== false) {
            $arr['settings']['nav_inner'] = $nav_inner;
        }

        if ($author_position !== false) {
            $arr['settings']['author_position'] = $author_position;
        }

        if ($filter_text_color !== false) {
            $arr['settings']['filter_text_color'] = $filter_text_color;
        }

        if ($filter_bg_color !== false) {
            $arr['settings']['filter_bg_color'] = $filter_bg_color;
        }

        if ($filter_bg_color !== false) {
            $arr['settings']['filter_bg_color'] = $filter_bg_color;
        }

        if ($filter_text_hover_color !== false) {
            $arr['settings']['filter_text_hover_color'] = $filter_text_hover_color;
        }
        if ($filter_text_bg_hover_color !== false) {
            $arr['settings']['filter_text_bg_hover_color'] = $filter_text_bg_hover_color;
        }

        if ($quote_txt_color !== false) {
            $arr['settings']['quote_txt_color'] = $quote_txt_color;
        }

        if ($quote_bg_color !== false) {
            $arr['settings']['quote_bg_color'] = $quote_bg_color;
        }

        if ($author_image_border !== false) {
            $arr['settings']['author_image_border'] = $author_image_border;
        }

        if ($author_image_border_color !== false) {
            $arr['settings']['author_image_border_color'] = $author_image_border_color;
        }

        if ($author_image_border_hover_color !== false) {
            $arr['settings']['author_image_border_hover_color'] = $author_image_border_hover_color;
        }


        if ($author_name_font_size !== false) {
            $arr['settings']['author_name_font_size'] = $author_name_font_size;
        }

        if ($author_name_font_color !== false) {
            $arr['settings']['author_name_font_color'] = $author_name_font_color;
        }

        if ($author_designation !== false) {
            $arr['settings']['author_designation'] = $author_designation;
        }

        if ($author_designation_font_size !== false) {
            $arr['settings']['author_designation_font_size'] = $author_designation_font_size;
        }

        if ($author_designation_font_color !== false) {
            $arr['settings']['author_designation_font_color'] = $author_designation_font_color;
        }

        if ($author_Rating !== false) {
            $arr['settings']['author_rating'] = $author_Rating;
        }

        if ($author_rating_color !== false) {
            $arr['settings']['author_rating_color'] = $author_rating_color;
        }

        if ($desktop_number_of_grid !== false) {
            $arr['settings']['desktop_number_of_grid'] = $desktop_number_of_grid;
        }

        if ($tab_number_of_grid !== false) {
            $arr['settings']['tab_number_of_grid'] = $tab_number_of_grid;
        }

        if ($mobile_number_of_grid !== false) {
            $arr['settings']['mobile_number_of_grid'] = $mobile_number_of_grid;
        }

        if ($small_mobile_number_of_grid !== false) {
            $arr['settings']['small_mobile_number_of_grid'] = $small_mobile_number_of_grid;
        }

        if ($large_desktop_number_of_grid !== false) {
            $arr['settings']['large_desktop_number_of_grid'] = $large_desktop_number_of_grid;
        }

        if ($testimonial_items !== false) { //if option registered

            $testimonial_items[$id] = $arr;

            update_option('_mi_testimonial_items', $testimonial_items);

        } else {
            add_option('_mi_testimonial_items', array($id => $arr));
        }

        $this->show_row_form($id);

        wp_safe_redirect(add_query_arg(array(
            'page' => $this->plugin_name,
            'action' => 'edit',
            'new_testimonial_id' => $id
        ), admin_url('admin.php')));
        exit;

    } elseif ($action === 'edit') {

        $id = $this->mi_form_validation($_REQUEST['new_testimonial_id'],'int');

        $this->show_row_form($id);

    } else {

        $this->show_row_form();
    }

    ?>


</div>


