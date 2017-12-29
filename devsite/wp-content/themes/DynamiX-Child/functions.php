<?php 
/**
 * DynamiX Child Theme Functions
 * Load languages directory for translation
*/ 

function wpse27856_set_content_type(){
    return "text/html";
}
add_filter( 'wp_mail_content_type','wpse27856_set_content_type' );