<?php
if ( ! defined( 'ABSPATH' ) ) exit;
class wpsm_test_b {
	private static $instance;
    public static function forge() {
        if (!isset(self::$instance)) {
            $className = __CLASS__;
            self::$instance = new $className;
        }
        return self::$instance;
    }
	
	private function __construct() {
		add_action('admin_enqueue_scripts', array(&$this, 'wpsm_test_b_admin_scripts'));
        if (is_admin()) {
			add_action('init', array(&$this, 'test_b_register_cpt'), 1);
			add_action('add_meta_boxes', array(&$this, 'wpsm_test_b_meta_boxes_group'));
			add_action('admin_init', array(&$this, 'wpsm_test_b_meta_boxes_group'), 1);
			add_action('save_post', array(&$this, 'add_test_b_save_meta_box_save'), 9, 1);
			add_action('save_post', array(&$this, 'test_b_settings_meta_box_save'), 9, 1);
		}
    }
	// admin scripts
	public function wpsm_test_b_admin_scripts(){
		if(get_post_type()=="test_builder"){
			
			wp_enqueue_script('theme-preview');
			wp_enqueue_media();
			wp_enqueue_script('jquery-ui-datepicker');
			//color-picker css n js
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_style('thickbox');
			wp_enqueue_script( 'wpsm_test_b-color-pic', wpshopmart_test_b_directory_url.'assets/js/color-picker.js', array( 'wp-color-picker' ), false, true );
			wp_enqueue_style('wpsm_test_b-panel-style', wpshopmart_test_b_directory_url.'assets/css/panel-style.css');
			 wp_enqueue_script('wpsm_test_b-media-uploads',wpshopmart_test_b_directory_url.'assets/js/media-upload-script.js',array('media-upload','thickbox','jquery')); 
			//font awesome css
			wp_enqueue_style('wpsm_test_b-font-awesome', wpshopmart_test_b_directory_url.'assets/css/font-awesome/css/font-awesome.min.css');
			wp_enqueue_style('wpsm_test_b_bootstrap', wpshopmart_test_b_directory_url.'assets/css/bootstrap.css');
			wp_enqueue_style('wpsm_test_b_jquery-css', wpshopmart_test_b_directory_url .'assets/css/ac_jquery-ui.css');
			
			//css line editor
			wp_enqueue_style('wpsm_test_b_line-edtor', wpshopmart_test_b_directory_url.'assets/css/jquery-linedtextarea.css');
			wp_enqueue_script( 'wpsm_test_b-line-edit-js', wpshopmart_test_b_directory_url.'assets/js/jquery-linedtextarea.js');
			
			wp_enqueue_script( 'wpsm_tabs_bootstrap-js', wpshopmart_test_b_directory_url.'assets/js/bootstrap.js');
			
			//tooltip
			wp_enqueue_style('wpsm_test_b_tooltip', wpshopmart_test_b_directory_url.'assets/tooltip/darktooltip.css');
			wp_enqueue_script( 'wpsm_test_b-tooltip-js', wpshopmart_test_b_directory_url.'assets/tooltip/jquery.darktooltip.js');
			
			// tab settings
			wp_enqueue_style('wpsm_test_b_settings-css', wpshopmart_test_b_directory_url.'assets/css/settings.css');
			
			
		}
	}
	public function test_b_register_cpt(){
		require_once('cpt-reg.php');
		add_filter( 'manage_edit-test_builder_columns', array(&$this, 'test_builder_columns' )) ;
		add_action( 'manage_test_builder_posts_custom_column', array(&$this, 'test_builder_manage_columns' ), 10, 2 );
	}
	function test_builder_columns( $columns ){
        $columns = array(
            'cb' => '<input type="checkbox" />',
            'title' => __( 'testimonial' ),
            'count' => __( 'testimonial Count' ),
            'shortcode' => __( 'testimonial Shortcode' ),
            'date' => __( 'Date' )
        );
        return $columns;
    }

    function test_builder_manage_columns( $column, $post_id ){
        global $post;
		$TotalCount =  get_post_meta( $post_id, 'wpsm_test_b_count', true );
		if(!$TotalCount || $TotalCount==-1){
		$TotalCount =0;
		}
        switch( $column ) {
          case 'shortcode' :
            echo '<input style="width:225px" type="text" value="[TEST_B id='.$post_id.']" readonly="readonly" />';
            break;
			case 'count' :
            echo $TotalCount;
            break;
          default :
            break;
        }
    }
	// metaboxes
	public function wpsm_test_b_meta_boxes_group(){
		add_meta_box('test_b_design', __('Select Design', wpshopmart_test_b_text_domain), array(&$this, 'wpsm_add_test_b_design_function'), 'test_builder', 'normal', 'low' );
		add_meta_box('test_b_add', __('Add testimonial Panel', wpshopmart_test_b_text_domain), array(&$this, 'wpsm_add_test_b_meta_box_function'), 'test_builder', 'normal', 'low' );
		add_meta_box ('test_b_shortcode', __('Testimonial Shortcode', wpshopmart_test_b_text_domain), array(&$this, 'wpsm_pic_test_b_shortcode'), 'test_builder', 'normal', 'low');
		add_meta_box ('test_b_more_pro', __('More Pro Plugin From Wpshopmart', wpshopmart_test_b_text_domain), array(&$this, 'wpsm_pic_test_b__more_pro'), 'test_builder', 'normal', 'low');
		add_meta_box('test_b_donate', __('Donate Us', wpshopmart_test_b_text_domain), array(&$this, 'wpsm_test_b_donate_meta_box_function'), 'test_builder', 'side', 'low');
		add_meta_box('test_b_rateus', __('Rate Us If You Like This Plugin', wpshopmart_test_b_text_domain), array(&$this, 'wpsm_test_b_rateus_meta_box_function'), 'test_builder', 'side', 'low');
		add_meta_box('test_b_setting', __('Testimonial Settings', wpshopmart_test_b_text_domain), array(&$this, 'wpsm_add_test_b_setting_function'), 'test_builder', 'side', 'low');
	}
	
	public function wpsm_add_test_b_design_function($post){
		require_once('design.php');
	}
	
	public function wpsm_add_test_b_meta_box_function($post){
		require_once('add-test.php');
	}
	public function add_test_b_save_meta_box_save($PostID){
		require('data-post/test-save-data.php');
	}
	public function test_b_settings_meta_box_save($PostID){
		require('data-post/test-settings-save-data.php');
	}
	public function wpsm_pic_test_b_shortcode(){
		require('test-shortcode-css.php');
	}
	
	public function wpsm_test_b_donate_meta_box_function(){
		?>
			<style>
				#test_b_donate{
				background:transparent;
				text-align:center;
				box-shadow:none;
				}
				#test_b_donate .hndle , #test_b_donate .handlediv{
				display:none;
				}
				
				a, a:focus{
					box-shadow:none;
					text-decoration:none;
				}
				#test_b_donate h3 {
				margin-bottom:5PX;
				margin-top:3px;
				padding:0px;
				}
			</style>
			<a href="http://wpshopmart.com/members/signup/tabs-responsive-donation" target="_blank" >
			<img src="<?php echo wpshopmart_test_b_directory_url.'assets/images/donate-1.jpg'; ?>" style="width:100%;height:auto"/>
			<h3> We Need Your Support</h3>
			<img src="<?php echo wpshopmart_test_b_directory_url.'assets/images/donate-b.png'; ?>" style="width:100%;height:auto"/>
			</a>
			<?php 
		
			
	}
	public function wpsm_test_b_rateus_meta_box_function(){
		?>
		<style>
		#test_b_rateus{
				background-color: #7242e7;
			}
			#test_b_rateus .hndle , #test_b_rateus .handlediv{
			display:none;
			}
			#test_b_rateus h1{
			color:#fff;
			
			}
			 #test_b_rateus h3 {
			color:#fff;
			font-size:15px;
			}
			#test_b_rateus .button-hero{
			  background: #fff;
					color: #000;
					box-shadow: none;
					text-shadow: none;
					font-weight: 500;
					font-size: 16px;
					border:1px solid #000;
			}
			.wpsm-rate-us{
			text-align:center;
			}
			.wpsm-rate-us span.dashicons {
				width: 40px;
				height: 40px;
				font-size:20px;
				color : #EAC121 !important;
			}
			.wpsm-rate-us span.dashicons-star-filled:before {
				content: "\f155";
				font-size: 40px;
			}
		</style>
		 <h1>Need Help </h1>
			<h3>Feel free to ask any query to us related to this plugin here </h3>
			<a href="https://wordpress.org/support/plugin/testimonial-builder" target="_blank" class="button button-primary button-hero ">Submit Your Query Here</a>
			
			<?php
	}
	public function wpsm_add_test_b_setting_function($post){
		require_once('settings.php');
	}
	
	public function wpsm_pic_test_b__more_pro(){
		require_once('more-pro.php');
	}
	
}
global $wpsm_test_b;
$wpsm_test_b = wpsm_test_b::forge();
	

?>