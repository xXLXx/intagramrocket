<?php
   /*
   Plugin Name: Likeservice
   Plugin URI: http://instagramrocket.com/
   Description: a plugin to create follower and like instagram
   Version: 1.0
   Author: Mrs. Ranju
   Author URI: http://instagramrocket.com/
   License: GPL2
   */
   ob_start();
   function elegance_referal_like_init()
	{
		wp_enqueue_style( 'myCSS1', plugins_url( '/css/style.css', __FILE__ ) );
		$dir = plugin_dir_path( __FILE__ );
	
	    if(is_page('service-likes')){ 
		    include($dir."apiservice.php");
	      include($dir."service-likes.php");
	      die();
	    }

	    if(is_page('success-page')){ 
	      include($dir."successpage.php");
	      die();
	    }
       if(is_page('custom-amount')){ 
        include($dir."customamount.php");
        die();
      }
		
	}

	add_action( 'wp', 'elegance_referal_like_init' );

   add_action('admin_menu', 'service_plugin_setup_menu');
 
   function service_plugin_setup_menu(){

            add_menu_page( 'Likes Service', 'Likes Service', 'manage_options', 'likesservice', 'likeslikes_init' );
          /* add_menu_page( 'Likes Coupon', 'Likes Coupon', 'manage_options', 'likescoupon', 'couponlikes_init' );*/

           add_menu_page( 'Likes Order', 'Likes Order', 'manage_options', 'likesorder', 'orderlikes_init' );



           /*add_menu_page( 'Servicelike', 'Servicelike', 'manage_options', 'servicelike', 'servicelike_init' );*/

   }

   

   function orderlikes_init(){


        ?>





         <div class="wrap">
         <h1>Orders</h1>
         </div>



         <div class="wrap">
         <h1>List of Orders</h1>
          <table class="form-table">
          <tr>
               <th>ID</th>
               <th>Link</th>
               <th>Price</th>
               <th>Order Date</th>
               <th>Order Id</th>
          </tr>
         <?php
          global $wpdb;
         $sql = "SELECT * FROM orderslikes";
         $result = $wpdb->get_results($sql) or die(mysql_error());

             foreach( $result as $results ) { ?>

               <tr>
                 <td><?php echo $results->ID; ?></td>
               <td><?php echo $results->link; ?></td>
               <td><?php echo $results->price; ?></td>
                <td><?php echo $results->order_date; ?></td>
               <td><?php echo $results->order_id; ?></td>
           
               </tr>
                  

                 
            <?php }
         ?>
           </table>
         </div>


               <?php

    }
    

    



    function likeslikes_init(){


    
           ?>

         <div class="wrap">
         <h1>Likes</h1>
      <?php if(isset($_POST['edit'])) { 
         global $wpdb;
         $sql = "SELECT * FROM likeslikes where ID=".$_POST['id'];
         $result = $wpdb->get_row($sql) or die(mysql_error());


        ?>



        <form method="post" action="<?php the_permalink(); ?>">
             
             <table class="form-table">
                 <tr valign="top">
                 <th scope="row">Name</th>
                 <td>
                 <input type="hidden" name="ids" value="<?php echo $result->ID; ?>" />

                 <input type="text" name="like_name" value="<?php echo $result->like_name; ?>" /></td>
                 </tr>
                  
                 <tr valign="top">
                 <th scope="row">Price</th>
                 <td><input type="text" name="price" value="<?php echo $result->price; ?>" /></td>
                 </tr>

                  <tr valign="top">
                 <th scope="row">LIkes Min</th>
                 <td><input type="text" name="num_like" value="<?php echo $result->num_like; ?>" /></td>
                 </tr>

                 <tr valign="top">
                 <th scope="row">LIkes Max</th>
                 <td><input type="text" name="num_like_max" value="<?php echo $result->num_like_max; ?>" /></td>
                 </tr>

                  <tr valign="top">
                 <th scope="row">LIkes Min</th>
                 <td><input type="text" name="d_num_like" value="<?php echo $result->d_num_like; ?>" /></td>
                 </tr>

                 <tr valign="top">
                 <th scope="row">LIkes Max</th>
                 <td><input type="text" name="d_num_like_max" value="<?php echo $result->d_num_like_max; ?>" /></td>
                 </tr>



                  <tr valign="top">
                 <th scope="row">Sale</th>
                 <td> 
              <select name="sale">
                    <option <?php if($result->sale==1){ echo 'selected'; } ?> value="1">Sale</option>
                    <option <?php if($result->sale==0){ echo 'selected'; } ?> value="0">Not Sale</option></td>
                 </tr>
                 
             
             </table>
             
          
             <input type="submit" name="update" id="submit" class="button button-primary" value="Update Changes">

         </form>



      <?php }else { ?>

         <form method="post" action="<?php the_permalink(); ?>">
             
             <table class="form-table">
                 <tr valign="top">
                 <th scope="row">Name</th>
                 <td><input type="text" name="like_name" value="" /></td>
                 </tr>
                  
                 <tr valign="top">
                 <th scope="row"> Price</th>
                 <td><input type="text" name="price" value="" /></td>
                 </tr>

                  <tr valign="top">
                 <th scope="row">Likes Min</th>
                 <td><input type="text" name="num_like" value="" /></td>
                 </tr>

                 <tr valign="top">
                 <th scope="row">Likes Max</th>
                 <td><input type="text" name="num_like_max" value="" /></td>
                 </tr>

                   <tr valign="top">
                 <th scope="row">Likes Min</th>
                 <td><input type="text" name="d_num_like" value="" /></td>
                 </tr>

                 <tr valign="top">
                 <th scope="row">Likes Max</th>
                 <td><input type="text" name="d_num_like_max" value="" /></td>
                 </tr>
                 
                 

                  <tr valign="top">
                 <th scope="row">Sale</th>
                 <td> <select name="sale"><option value="1">Sale</option>
                    <option value="0">Not Sale</option></select></td>

                 </tr>
                 
             
             </table>
             
             <?php submit_button(); ?>

         </form>
         <?php } ?>




         </div>


           <?php

               if ($_REQUEST['submit']) {
                  global $wpdb;
                  $like_name=$_REQUEST['like_name'];
                  $price=$_REQUEST['price'];
                  $num_like=$_REQUEST['num_like'];
                  $num_like_max=$_REQUEST['num_like_max'];
                   $num_like=$_REQUEST['d_num_like'];
                  $num_like_max=$_REQUEST['d_num_like_max'];
                  $sale=$_REQUEST['sale'];
                  $sql="INSERT INTO likeslikes (like_name, price,num_like,num_like_max,d_num_like,d_num_like_max,sale) VALUES ('$like_name', $price,$num_like,$num_like_max,$d_num_like,$d_num_like_max,$sale)";
                  $wpdb->query($sql);  
                  echo 'SAVED SUCCESSFULLY';
               }  
               else if($_REQUEST['update'])
               {
                  global $wpdb;
                   $like_name=$_REQUEST['like_name'];
                  $price=$_REQUEST['price'];
                  $num_like=$_REQUEST['num_like'];
                  $num_like_max=$_REQUEST['num_like_max'];
                    $d_num_like=$_REQUEST['d_num_like'];
                  $d_num_like_max=$_REQUEST['d_num_like_max'];
                  $sale=$_REQUEST['sale'];
                  $ids=$_REQUEST['ids'];
                  $sql="UPDATE likeslikes SET like_name = '$like_name', price= '$price', num_like= '$num_like', num_like_max= '$num_like_max', d_num_like= '$d_num_like', d_num_like_max= '$d_num_like_max', sale= '$sale' WHERE ID = $ids";
                  $wpdb->query($sql);  
                  echo 'Update SUCCESSFULLY';
               }

               ?>


         <div class="wrap">
         <h1>List of Likes</h1>
          <table class="form-table">
          <tr>
               <th>ID</th>
               <th>Name</th>
               <th>Price</th>
               <th>Likes Min</th>
                <th>Likes Max</th>
                 <th>Likes D Min</th>
                <th>Likes D Max</th>
               <th>Link</th>
               <th>Sale</th>
               <th>Action</th>
          </tr>
         <?php
          global $wpdb;
         $sql = "SELECT * FROM likeslikes";
         $result = $wpdb->get_results($sql) or die(mysql_error());

             foreach( $result as $results ) { ?>

               <tr>
                 <td><?php echo $results->ID; ?></td>
               <td><?php echo $results->like_name; ?></td>
               <td><?php echo $results->price; ?></td>
               <td><?php echo $results->num_like; ?></td>
                 <td><?php echo $results->num_like_max; ?></td>
                   <td><?php echo $results->d_num_like; ?></td>
                 <td><?php echo $results->d_num_like_max; ?></td>
               <td><?php echo get_site_url(); ?>/service-likes?subscription=<?php echo $results->ID; ?></td>
                <td><?php if($results->sale==0){ echo 'No sale'; }else{ echo 'Sale'; }; ?></td>
                <td>
                   <form method="post" action="<?php the_permalink(); ?>">
                      <input type="hidden" name="id" value="<?php echo $results->ID; ?>">
                      <input type="submit" name="edit" value="EDIT">
                   </form>
                  

                </td>
               </tr>
                  

                 
            <?php }
         ?>
           </table>
         </div>


               <?php
   }



   register_activation_hook(__FILE__, 'wnm_install_service');

   global $wnm_db_version;
   $wnm_db_version = "1.0";

   function wnm_install_service(){
   global $wpdb;
   global $wnm_db_version;



   $sql = "CREATE TABLE likeslikes (
   ID int(11) NOT NULL AUTO_INCREMENT,
   like_name varchar(128) NOT NULL,
   price float(11) NOT NULL ,
   sale int(11) NOT NULL ,
   num_like int(11) NOT NULL ,
   num_like_max int(11) NOT NULL ,
   d_num_like int(11) NOT NULL ,
   d_num_like_max int(11) NOT NULL ,
   PRIMARY KEY (ID)
   ) ;";


   $sqls1 = "CREATE TABLE orderslikes (
   ID int(11) NOT NULL AUTO_INCREMENT,
   link varchar(128) NOT NULL,
   order_date varchar(128) NOT NULL,
   order_id int(11) NOT NULL ,
   price float(11) NOT NULL ,
   PRIMARY KEY (ID)
   ) ;";



   require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
   dbDelta($sql);
/*   dbDelta($sqls);*/
   dbDelta($sqls1);
  /* dbDelta($sqls2);*/

   add_option("wnm_db_version", $wnm_db_version);
   }


?>

