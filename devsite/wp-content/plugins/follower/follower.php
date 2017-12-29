<?php
   /*
   Plugin Name: Follower
   Plugin URI: http://instagramrocket.com/
   Description: a plugin to create follower and like instagram
   Version: 1.0
   Author: Mrs. Ranju
   Author URI: http://instagramrocket.com/
   License: GPL2
   */
   ob_start();
   function elegance_referal_init()
	{
		wp_enqueue_style( 'myCSS1', plugins_url( '/css/style.css', __FILE__ ) );
		$dir = plugin_dir_path( __FILE__ );
		if(is_page('follower')){	
         include($dir."api.php");
         include($dir."apilikes.php");
			include($dir."frontend-form.php");
			die();
		}
	    if(is_page('likes')){ 
		 include($dir."api.php"); 
		 include($dir."apilikes.php");
	      include($dir."frontend-likes.php");
	      die();
	    }

	    if(is_page('success-page')){ 
	      include($dir."successpage.php");
	      die();
	    }

       if(is_page('custom-order')){ 
          include($dir."customorder.php");
          die();
        }
      

      if(is_page('ordercheck')){


         include($dir."api.php");
         include($dir."apilikes.php");
      

          
          global $wpdb;
         $sql = "SELECT * FROM createorder where status=0 and notify='APPROVED' ORDER BY ID";
         $result = $wpdb->get_results($sql);


             foreach( $result as $results ) {

              $item_number_1=$results->ID;
              $transaction=$results->transaction;
              $email=$results->email;



               $url=get_site_url().'/follower?getdone=1&item_number_1='.$item_number_1.'&PPP_TransactionID='.$transaction.'&email='.$email;



       

           global $wpdb;
           $sql = "SELECT * FROM createorder where status=0 and ID=".$item_number_1;
           $result = $wpdb->get_row($sql);
           $rowcount=count($result);

           if($rowcount==1)
           {
          
          

           $process=$result->process;
           $subscription=$result->subscription;
           $url=$result->link;
          $addservice=$result->addservice;
          $code=$result->code;
          $likeperpage=$result->likeperpage;






          if($process=='follower')
          {



            $transaction=$transaction;
            $email=$email;

             global $wpdb;

               $sql = 'SELECT * FROM membership where ID='.$subscription;
               $result = $wpdb->get_row($sql);



               $count=count($result);


              if($count>=1)
              {
                if($addservice==1 || $addservice==2)
                {
                  if($addservice==1)
                    {
                      $quan=1000;
                      $price_follower=$result->price+6.99;
                    }
                    else
                    {
                      $quan=2000;
                      $price_follower=$result->price+13.98;
                    }
                  $num_follower=$result->num_follower+$quan;
                }
                else{
                  $num_follower=$result->num_follower;
                  $price_follower=$result->price;
                }
              
              }
            else
            {
              $num_follower=0;
              $price_follower=0;
            }


            //$url='https://www.instagram.com/'.$_SESSION['username'].'/';

            $sql1 = 'SELECT * FROM service where ID=1';
                $result1 = $wpdb->get_row($sql1);


            $order = $api->order(array('service' => $result1->service_id, 'link' =>$url, 'quantity' => $num_follower));
              date_default_timezone_set('America/Los_Angeles');
            $dates=date("Y/m/d");
            

            $order_id=$order->order;
                  $sql="INSERT INTO orders (link, price,order_id,order_date,transaction_id,email) VALUES ('$url', $price_follower,$order_id,'$dates','$transaction','$email')";
                  $wpdb->query($sql);


                $sql="UPDATE createorder SET status = 1 WHERE ID =".$item_number_1;
                    $wpdb->query($sql);   
        }
        else if($process=='likes')
        {
          

            global $wpdb;

              $transaction=$transaction;
            $email=$email;
                  
          
            

               $sql = 'SELECT * FROM likes where ID='.$subscription;
               $result = $wpdb->get_row($sql);


               $count=count($result);


              if($count>=1)
              {
                
              $price_follower=$result->price;
              }
            else
            {
            
              $price_follower=0;
            }

            $sql1 = 'SELECT * FROM service where ID=2';
                $result1 = $wpdb->get_row($sql1);

          

            $array=explode(',',$code);

            $count=count($array);
            
            $c=1;
            foreach ($array as $key ) {

              if($c<$count)
              {
                $image_url='https://www.instagram.com/p/'.$key.'/';

                  $add_example_0 = array(
                      'api_key' => 'tUZyuuSLnAgpYTTQMs7eWltEW',
                      'action' => 'add',
                      'service_id' => $result1->service_id,
                      'url' => $image_url,
                      'quantity' => $likeperpage
                  );

              

                
                  $order = json_decode(submit_url('http://www.ytbot.com/api.php', $add_example_0));
                  date_default_timezone_set('America/Los_Angeles');
                  $dates=date("Y/m/d");
                
                      $order_id=$order->id;
                        $sql="INSERT INTO orders (link, price,order_id,order_date,transaction_id,email) VALUES ('$image_url', $price_follower,$order_id,'$dates','$transaction','$email')";
                        $wpdb->query($sql); 


                $c++;
              }
              
              
            }


            if($addservice==1 || $addservice==2)
              {

                //$url='https://www.instagram.com/'.$_SESSION['username'].'/';

              $sql1 = 'SELECT * FROM service where ID=1';
                  $result1 = $wpdb->get_row($sql1);

                  if($addservice==1)
                  {
                    $quan=1000;
                  }
                  else
                  {
                    $quan=2000;
                  }


              $order = $api->order(array('service' => $result1->service_id, 'link' =>$url, 'quantity' => $quan)); 
                date_default_timezone_set('America/Los_Angeles');
              $dates=date("Y/m/d");
              

              
                    $order_id=$order->order;
                      $sql="INSERT INTO orders (link, price,order_id,order_date,transaction_id,email) VALUES ('$url', 0,$order_id,'$dates','$transaction','$email')";
                      $wpdb->query($sql);


                        
              }  
              $sql="UPDATE createorder SET status = 1 WHERE ID =".$item_number_1;
                        $wpdb->query($sql); 


        }
        else if($process=='autolikes')
        {
          
          global $wpdb;

              $transaction=$transaction;
            $email=$email;
                  
          
            

               $sql = 'SELECT * FROM likeslikes where ID='.$subscription;
               $result = $wpdb->get_row($sql);


               $count=count($result);


              if($count>=1)
              {
                
              $price_follower=$result->price;
              $num_like=$result->num_like;
              $num_like_max=$result->num_like_max;

              $d_num_like=$result->d_num_like;
              $d_num_like_max=$result->d_num_like_max;
              }
            else
            {
            
              $price_follower=0;
              $num_like=0;
              $num_like_max=0;

              $d_num_like=0;
              $d_num_like_max=0;
            }

            $sql1 = 'SELECT * FROM service where ID=2';
                $result1 = $wpdb->get_row($sql1);


              $add_example_0 = array( //placing automatic service order, make sure to use same seed value otherwise price may differ
                'api_key' => 'tUZyuuSLnAgpYTTQMs7eWltEW',
                'action' => 'add',
                'service_id' => '165',
                'url' => $url,
                'dripfeed_mode' => true,
                'dripfeed_adv' => true,
                'dripfeed_interval' => '10',
                'min' => $num_like,
                'max' => $num_like_max,
                'd_min' => $d_num_like,
                'd_max' => $d_num_like_max,
                'new_s' => '5',
                'seed' => '3432'
            );


          

            
              $order = json_decode(submit_url('http://www.ytbot.com/api.php', $add_example_0));
              date_default_timezone_set('America/Los_Angeles');
              $dates=date("Y/m/d");
            
                  $order_id=$order->id;
                    $sql="INSERT INTO orders (link, price,order_id,order_date,transaction_id,email) VALUES ('$url', $price_follower,$order_id,'$dates','$transaction','$email')";
                    $wpdb->query($sql); 


              
          


            if($addservice==1 || $addservice==2)
              {

                //$url='https://www.instagram.com/'.$_SESSION['username'].'/';

              $sql1 = 'SELECT * FROM service where ID=1';
                  $result1 = $wpdb->get_row($sql1);

                  if($addservice==1)
                  {
                    $quan=1000;
                  }
                  else
                  {
                    $quan=2000;
                  }


              $order = $api->order(array('service' => $result1->service_id, 'link' =>$url, 'quantity' => $quan)); 
                date_default_timezone_set('America/Los_Angeles');
              $dates=date("Y/m/d");
              

              
                    $order_id=$order->order;
                      $sql="INSERT INTO orders (link, price,order_id,order_date,transaction_id,email) VALUES ('$url', 0,$order_id,'$dates','$transaction','$email')";
                      $wpdb->query($sql);


                        
              }  
              $sql="UPDATE createorder SET status = 1 WHERE ID =".$item_number_1;
                        $wpdb->query($sql); 



        }
        else if($process=='custom')
          {





            $transaction=$_REQUEST['PPP_TransactionID'];
            $email=$_REQUEST['email'];

             global $wpdb;



              date_default_timezone_set('America/Los_Angeles');
            $dates=date("Y/m/d");

            $code=(float) $code;


               $sql="UPDATE createorder SET status = 1 WHERE ID =".$item_number_1;
                    $wpdb->query($sql); 


          $sqls="INSERT INTO orders (link, price,order_id,order_date,transaction_id,email,charge,status,remains) VALUES ('$url', $code,$subscription,'$dates','$transaction','$email', '$code','Custom','$addservice')";
          $wpdb->query($sqls);




             


                   
                


          

            
            ?>


        


              <div class="success">
            <div class="wpb_wrapper">
                <div class="wpb_text_column wpb_content_element ">
                  <div class="wpb_wrapper">
                    <h2 style="text-align: center;">Processing your order…</h2>
              <h3 style="text-align: center;">Please wait, this may take a few seconds.</h3>

                  </div>
                </div>

                <div class="wpb_single_image wpb_content_element vc_align_center">
        
                  <figure class="wpb_wrapper vc_figure">
                    <div style="text-align:center"  class="vc_single_image-wrapper   vc_box_border_grey"><img width="225" height="187" src="https://www.instagramrocket.com/wp-content/uploads/2017/06/processing.gif" class="vc_single_image-img attachment-full" alt=""></div>
                  </figure>
                </div>
              </div>

              </div>


                <?php

          
            //$_SESSION['random']="";

            header("Location: https://www.instagramrocket.com/success-page/");
            die();
        }






        else{

        }
        }


      
      
          
               
          
             }


        die();


      }

       if(is_page('pending-url')){ 

         /*print_r($_REQUEST);*/
      $checksum = md5('D2V7CfsAaeWU3bi1Ee7BGb65DLsJM4UKRk8W2yT8se3cYAAeUEVUlHhYGqlp6LaL'.$_REQUEST['totalAmount'].$_REQUEST['currency'].$_REQUEST['responseTimeStamp'].$_REQUEST['PPP_TransactionID'].$_REQUEST['Status'].$_REQUEST['productId']); 

      $fp = fopen("log.txt","a+");
      //we use the serialize just becuase we write to a text file in this example.
      //in a normal case where you would write to a database - this is not needed.
      //You will write just some of the values in the $_REQUEST into the table columns.
      //For example, you would write $_REQUEST[Status] to a Status column in a table, you would write $_REQUEST[email] to a email column in a table, etc.
      fwrite($fp, serialize($_REQUEST)."\r\n");
      fwrite($fp, "Calculated checksum: ".$checksum."\r\n");


      //You need to check that your checksum is the same as the advanceResponseChecksum. This way you know that the DMN request is valid.
      //Then you can check the value of the ppp_status parameter to ensure all is OK
      if ($checksum === $_REQUEST['advanceResponseChecksum']) {
      //You can actually write the DMN data to a DATABASE. It will be better. The following is just an example.

        global $wpdb;
        $sql="UPDATE createorder SET notify = '".$_REQUEST['Status']."', email = '".$_REQUEST['email']."',transaction = '".$_REQUEST['PPP_TransactionID']."' WHERE ID =".$_REQUEST['item_number_1'];
        $wpdb->query($sql); 


        fwrite($fp, "The pending transaction is SUCCESSFUL. Transaction ID:".$_REQUEST[PPP_TransactionID]."\r\n");
        
          $url=get_site_url().'/follower?getdone=1&item_number_1='.$_REQUEST['item_number_1'].'&PPP_TransactionID='.$_REQUEST['PPP_TransactionID'].'&email='.$_REQUEST['email'];
    
          wp_redirect( $url );
          exit;

       
              } else {
        fwrite($fp, "The pending transaction is DECLINED. Transaction ID:".$_REQUEST[PPP_TransactionID]."\r\n");

     
      


      }

      fclose($fp);


      
      }

       if(is_page('notify-url')){ 


   

      


      /*print_r($_REQUEST);*/
      $checksum = md5('D2V7CfsAaeWU3bi1Ee7BGb65DLsJM4UKRk8W2yT8se3cYAAeUEVUlHhYGqlp6LaL'.$_REQUEST['totalAmount'].$_REQUEST['currency'].$_REQUEST['responseTimeStamp'].$_REQUEST['PPP_TransactionID'].$_REQUEST['Status'].$_REQUEST['productId']); 

      $fp = fopen("log.txt","a+");
      //we use the serialize just becuase we write to a text file in this example.
      //in a normal case where you would write to a database - this is not needed.
      //You will write just some of the values in the $_REQUEST into the table columns.
      //For example, you would write $_REQUEST[Status] to a Status column in a table, you would write $_REQUEST[email] to a email column in a table, etc.
      fwrite($fp, serialize($_REQUEST)."\r\n");
      fwrite($fp, "Calculated checksum: ".$checksum."\r\n");

      //You need to check that your checksum is the same as the advanceResponseChecksum. This way you know that the DMN request is valid.
      //Then you can check the value of the ppp_status parameter to ensure all is OK
      if ($checksum === $_REQUEST['advanceResponseChecksum']) {
      //You can actually write the DMN data to a DATABASE. It will be better. The following is just an example.
      
  
        global $wpdb;
        $sql="UPDATE createorder SET notify = '".$_REQUEST['Status']."', email = '".$_REQUEST['email']."',transaction = '".$_REQUEST['PPP_TransactionID']."' WHERE ID =".$_REQUEST['item_number_1'];
        $wpdb->query($sql); 

        fwrite($fp, "The notify transaction is SUCCESSFUL. Transaction ID:".$_REQUEST[PPP_TransactionID]."\r\n");
        
         
         // $url=get_site_url().'/follower?getdone=1&item_number_1='.$_REQUEST['item_number_1'].'&PPP_TransactionID='.$_REQUEST['PPP_TransactionID'].'&email='.$_REQUEST['email'];
    
        //  wp_redirect( $url );
        //  exit;

       
              } else {
        fwrite($fp, "The notify transaction is DECLINED. Transaction ID:".$_REQUEST[PPP_TransactionID]."\r\n");


      }

      fclose($fp);


      }
		  
      if(is_page('order-status')){ 
      
        include($dir."api.php"); 

         global $wpdb;
         $sql = "SELECT * FROM orders where status!='Completed' ORDER BY ID DESC LIMIT 50";
         $result = $wpdb->get_results($sql) or die(mysql_error());

             foreach( $result as $results ) {


               $status = $api->status($results->order_id); # return status, charge, remains, start count



                $st=$status->status;
                echo $st;


               $sql="UPDATE orders SET status = '$st' WHERE ID = $results->ID";
                $wpdb->query($sql); 

                  

                 
             }


        die();
      }
	}

	add_action( 'wp', 'elegance_referal_init' );

   add_action('admin_menu', 'test_plugin_setup_menu');
 
   function test_plugin_setup_menu(){
           add_menu_page( 'Follower', 'Follower', 'manage_options', 'follower', 'follower_init' );
           add_menu_page( 'Likes', 'Likes', 'manage_options', 'likes', 'likes_init' );
           add_menu_page( 'Coupon', 'Coupon', 'manage_options', 'coupon', 'coupon_init' );

           add_menu_page( 'Order', 'Order', 'manage_options', 'order', 'order_init' );
           add_menu_page( 'Service', 'Service', 'manage_options', 'service', 'service_init' );
   
           

   }

   function service_init(){

        ?>

         <div class="wrap">
         <h1>Service</h1>
      <?php if(isset($_POST['edit'])) { 
         global $wpdb;
         $sql = "SELECT * FROM service where ID=".$_POST['id'];
         $result = $wpdb->get_row($sql) or die(mysql_error());


        ?>



        <form method="post" action="<?php the_permalink(); ?>">
             
             <table class="form-table">
                 <tr valign="top">
                 <th scope="row">Service Id</th>
                 <td>
                 <input type="hidden" name="ids" value="<?php echo $result->ID; ?>" />

                 <input type="number" name="service_id" value="<?php echo $result->service_id; ?>" /></td>
                 </tr>
      
             </table>
             
          
             <input type="submit" name="update" id="submit" class="button button-primary" value="Update Changes">

         </form>



      <?php } ?>




         </div>


           <?php

               if($_REQUEST['update'])
               {
                  global $wpdb;
                  $service_id=$_REQUEST['service_id'];
                  $ids=$_REQUEST['ids'];
                  $sql="UPDATE service SET service_id = $service_id WHERE ID = $ids";
                  $wpdb->query($sql);  
                  echo 'Update SUCCESSFULLY';
               }

               ?>


         <div class="wrap">
         <h1>List of Service</h1>
          <table class="form-table">
          <tr>
               <th>ID</th>
               <th>Service Id</th>
               <th>Type</th>
               <th>Action</th>
          </tr>
         <?php
          global $wpdb;
         $sql = "SELECT * FROM service";
         $result = $wpdb->get_results($sql) or die(mysql_error());

             foreach( $result as $results ) { ?>

               <tr>
                 <td><?php echo $results->ID; ?></td>
               <td><?php echo $results->service_id; ?></td>
               <td><?php echo $results->types; ?></td>
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


   function order_init(){

       include($dir."api.php"); 

         global $wpdb;
         $sql = "SELECT ID, order_id FROM orders where status!='Completed' ORDER BY ID DESC LIMIT 50";
         $result = $wpdb->get_results($sql) or die(mysql_error());

             foreach( $result as $results ) {


               $status = $api->status($results->order_id); # return status, charge, remains, start count



                $st=$status->status;
                $charge=$status->charge;
                $start_count=$status->start_count;
                $remains=$status->remains;

                if($st!='')
                {
                       $sql="UPDATE orders SET status = '$st',charge = '$charge',start_count = '$start_count',remains = '$remains' WHERE ID = $results->ID";
                       $wpdb->query($sql); 
                }
               


          

                  

                 
             }

             if( $_REQUEST['refill'] ){
              
                $order_id = $_POST['order_id'];
                $url = $_POST['link'];
                $service_id = $_POST['service_id'];
                $quantity = $_POST['quantity'];
                $refills = (int) $_POST['refills'];

                $params = array('service' => $service_id, 'link' => $url, 'quantity' => $quantity);
                $order = $api->order($params); 

                if( ! isset($order->order) ){
          ?>
                    <div style="padding: 10px;background: #f71616;color: #000;font-weight: bold;">
                        Failed to process your request at this time. Please try again.
                    </div>
          <?php
                }else{

                    $refills++;
                    $sql = 'UPDATE orders SET refills = "' . $refills . '" WHERE ID = "' . $order_id . '"';
                    $wpdb->query($sql); 
        ?>
                    <div style="padding: 10px;background: #4ade0c;color: #000;font-weight: bold;">
                        <?=$quantity?> <?=($service_id == 325) ? "Followers" : "Likes"?> has been successfully added to <?=$url?>.
                    </div>
                    <!-- <div style="padding: 10px;background: #4ade0c;color: #000;font-weight: bold;">
                        This is under construction for verification.
                    </div> -->
        <?php
                }
             }

             if( $_REQUEST['approved'] ){

                $sql = "SELECT * FROM createorder where status = 1 and ID=" . $_REQUEST['item_number'];
                $result = $wpdb->get_row($sql);

                $subscription = $result->subscription;
                $addservice = $result->addservice;
                $url = $result->link;

                $sql = 'SELECT num_follower, price FROM membership where ID='.$subscription;
                $result = $wpdb->get_row($sql);

                $num_follower = $price_follower=0;

                if( ! empty($result) ){

                  $num_follower = $result->num_follower;
                  $price_follower = $result->price;

                  if( $addservice == 1 || $addservice == 2 ){
                      
                      $quan = 2000;
                        $price_follower = $result->price + 13.98;

                      if( $addservice == 1 )
                        {
                          $quan=1000;
                          $price_follower=$result->price+6.99;
                        }

                      $num_follower = $result->num_follower + $quan;
                    }

                }

                $sql1 = 'SELECT service_id FROM service where ID = 1';
                $result1 = $wpdb->get_row($sql1);

                switch ($subscription) {
                  case 1:
                    $service_id = 298;
                    break;
                  
                  default:
                    $service_id = $result1->service_id;
                    break;
                }

                $order = $api->order(array('service' => $service_id, 'link' =>$url, 'quantity' => $num_follower));
                date_default_timezone_set('America/Los_Angeles');
                // $dates=date("Y/m/d");
                
                if( ! isset($order->order) ){
        ?>
                    <div style="padding: 10px;background: #f71616;color: #000;font-weight: bold;">
                        Failed to process your request at this time. Please try again.
                    </div>
        <?php
                }else{

        ?>

        <?php
                $order_id=$order->order;

                $sql="UPDATE orders SET order_id = ".$order_id.", for_approval = 0 WHERE item_number =" . $_REQUEST['item_number'];
                $wpdb->query($sql); 

        ?>
                <div style="padding: 10px;background: #4ade0c;color: #000;font-weight: bold;">
                    Order ID <?=$order_id?> has been successfully approved.
                </div>
        <?php
                }
             }

        ?>

<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>


<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel='stylesheet' type='text/css'>
<link href="https://cdn.datatables.net/1.10.15/css/dataTables.bootstrap.min.css" rel='stylesheet' type='text/css'>

         <div class="wrap">
         <h1>Orders</h1>
         </div>



         <div class="wrap">
         <h1>List of Orders</h1>
          <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
          <thead>
          <tr>
               <th style="display: none;">&nbsp;</th>
               <th>ID</th>
               <th>Link</th>
               <th>Price</th>
               <th>Order Date</th>
               <th>Order Id</th>
               <th>Transaction Id</th>
               <th>Email</th>

               <th>Paid</th>
               <th>Remains</th>
               <th>Start Count</th>


               <th>Status</th>
               <th>Refill Count</th>
               <th>Action</th>
          </tr>
                  </thead>
                  <tbody>
         <?php
          global $wpdb;
         $sql = "SELECT ID, link, price, order_date, for_approval, order_id, transaction_id, email, charge, remains, start_count, status, service_type, quantity, refills, item_number FROM orders ORDER BY ID DESC";
         $result = $wpdb->get_results($sql) or die(mysql_error());
          $ctr = 0;
             foreach( $result as $results ) { 
              $ctr++;
          ?>

               <tr>
                 <td style="display: none;"><?php echo $results->ID; ?></td>
                 <td><?=$ctr?></td>
               <td><?php echo $results->link; ?></td>
               <td><?php echo $results->price; ?></td>
                <td><?php echo $results->order_date; ?></td>
               <td><?php echo $results->order_id; ?></td>

               <td><?php echo $results->transaction_id; ?></td>
               <td><?php echo $results->email; ?></td>

               <td><?php echo $results->charge; ?></td>
               <td><?php echo $results->remains; ?></td>
               <td><?php echo $results->start_count; ?></td>

                <td><?php echo $results->status; ?></td>
                <td align="center"><?php echo $results->refills; ?></td>
                <td>

                  <?php
                    if( $results->for_approval > 0 ){
                  ?>
                        <img src="../wp-content/plugins/follower/image/approved.png" style="cursor:pointer;" width="25" title="Approved Order" onclick="return approvedOrder('<?=$results->item_number?>')">
                        <!-- <input type="button" name="approved" value="Approved" onclick="return approvedOrder('<?=$results->item_number?>')" />  -->
                  <?php
                    }
                  ?>
                  <?php
                    if( $results->service_type <> 0 && $results->quantity <> 0 && $results->for_approval <= 0 ){
                  ?>
                        <img src="../wp-content/plugins/follower/image/reorder_icon.png" style="cursor:pointer;" width="25" title="Refill Order" onclick="return refill('<?=$results->service_type?>', '<?=$results->quantity?>', '<?=$results->link?>', '<?=$results->ID?>', '<?=$results->refills?>')">
                  <!-- <input type="button" name="refill" id="refill_<?=$ctr?>" value="Refill" onclick="return refill('<?=$results->service_type?>', '<?=$results->quantity?>', '<?=$results->link?>', '<?=$results->ID?>', '<?=$results->refills?>')"> -->
                  <?php
                    }
                  ?>
                  
                </td>

           
               </tr>
                  

                 
            <?php }
         ?>
         </tbody>
           </table>

           <form action="<?php the_permalink(); ?>" method="post">
             <input type="hidden" name="order_id" id="order_id" value="">
             <input type="hidden" name="link" id="link" value="">
             <input type="hidden" name="service_id" id="service_id" value="">
             <input type="hidden" name="quantity" id="quantity" value="">
             <input type="hidden" name="refills" id="refills" value="">
             <input type="submit" name="refill" value="refill" id="refill" style="display: none;">
           </form>

           <form action="<?php the_permalink(); ?>" method="post">
             <input type="hidden" name="item_number" id="item_number" value="">
             <input type="submit" name="approved" value="approved" id="approved" style="display: none;">
           </form>
         </div>

         <script type="text/javascript">
           

           $(document).ready(function() {
                $('#example').DataTable({
                  "order": [[ 0, "desc" ]]
                });
            } );

           function refill(serviceID, quantity, link, id, refills){
              var quantity = quantity * 0.10;
                
              if( confirm("Are you sure you want to refill?") ){
                  
                  $('#order_id').val(id);
                  $('#link').val(link);
                  $('#service_id').val(serviceID);
                  $('#quantity').val(quantity);
                  $('#refills').val(refills);

                  $('#refill').trigger("click");
              }
           }

           function approvedOrder(itemNumber){

              if( confirm("Are you sure you want to approved?") ){
                  
                  $('#item_number').val(itemNumber);

                  $('#approved').trigger("click");
              }

           }
         </script>


               <?php

    }
    

    function coupon_init(){

        ?>

         <div class="wrap">
         <h1>Coupon</h1>
      <?php if(isset($_POST['edit'])) { 
         global $wpdb;
         $sql = "SELECT * FROM coupon where ID=".$_POST['id'];
         $result = $wpdb->get_row($sql) or die(mysql_error());


        ?>



        <form method="post" action="<?php the_permalink(); ?>">
             
             <table class="form-table">
                 <tr valign="top">
                 <th scope="row">Coupon Code</th>
                 <td>
                 <input type="hidden" name="ids" value="<?php echo $result->ID; ?>" />

                 <input type="text" name="coupon_name" value="<?php echo $result->coupon_name; ?>" /></td>
                 </tr>
                  
                 <tr valign="top">
                 <th scope="row">Discount Rate (%)</th>
                 <td><input type="text" name="coupon_rate" value="<?php echo $result->rate; ?>" /></td>
                 </tr>

                  <tr valign="top">
                 <th scope="row">Expiry Date</th>
                 <td><input type="text" name="coupon_date" value="<?php echo $result->expiry; ?>" placeholder="YYYY-mm-dd"/></td>
                 </tr>
                 
             
             </table>
             
          
             <input type="submit" name="update" id="submit" class="button button-primary" value="Update Changes">

         </form>



      <?php }else { ?>

         <form method="post" action="<?php the_permalink(); ?>">
             
             <table class="form-table">
                 <tr valign="top">
                 <th scope="row">Coupon Code</th>
                 <td><input type="text" name="coupon_name" value="" /></td>
                 </tr>
                  
                 <tr valign="top">
                 <th scope="row">Discount Rate (%)</th>
                 <td><input type="number" name="coupon_rate" value="" /></td>
                 </tr>

                  <tr valign="top">
                 <th scope="row">Expiry Date</th>

                 <td><input type="text" name="coupon_date" value="" placeholder="YYYY-mm-dd" /></td>
                 </tr>
                 
             
             </table>
             
             <?php submit_button(); ?>

         </form>
         <?php } ?>




         </div>


           <?php

               if ($_REQUEST['submit']) {
                  global $wpdb;
                  $coupon_name=$_REQUEST['coupon_name'];
                  $coupon_rate=$_REQUEST['coupon_rate'];
                  $coupon_date=$_REQUEST['coupon_date'];
                  $sql="INSERT INTO coupon (coupon_name, rate,expiry) VALUES ('$coupon_name', $coupon_rate,'$coupon_date')";
                  $wpdb->query($sql);  
                  echo 'SAVED SUCCESSFULLY';
               }  
               else if($_REQUEST['update'])
               {
                  global $wpdb;
                  $coupon_name=$_REQUEST['coupon_name'];
                  $coupon_rate=$_REQUEST['coupon_rate'];
                  $coupon_date=$_REQUEST['coupon_date'];
                  $ids=$_REQUEST['ids'];
                  $sql="UPDATE coupon SET coupon_name = '$coupon_name', rate= '$coupon_rate', expiry= '$coupon_date' WHERE ID = $ids";
                  $wpdb->query($sql);  
                  echo 'Update SUCCESSFULLY';
               }

               ?>


         <div class="wrap">
         <h1>List of Coupon</h1>
          <table class="form-table">
          <tr>
               <th>ID</th>
               <th>Code</th>
               <th>Rate</th>
               <th>Expiry</th>
               <th>Action</th>
          </tr>
         <?php
          global $wpdb;
         $sql = "SELECT * FROM coupon";
         $result = $wpdb->get_results($sql) or die(mysql_error());

             foreach( $result as $results ) { ?>

               <tr>
                 <td><?php echo $results->ID; ?></td>
               <td><?php echo $results->coupon_name; ?></td>
               <td><?php echo $results->rate; ?></td>
               <td><?php echo $results->expiry; ?></td>
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
    
   function follower_init(){


    
           ?>

         <div class="wrap">
         <h1>Follower</h1>
      <?php if(isset($_POST['edit'])) { 
         global $wpdb;
         $sql = "SELECT * FROM membership where ID=".$_POST['id'];
         $result = $wpdb->get_row($sql) or die(mysql_error());


        ?>



        <form method="post" action="<?php the_permalink(); ?>">
             
             <table class="form-table">
                 <tr valign="top">
                 <th scope="row">Membership Name</th>
                 <td>
                 <input type="hidden" name="ids" value="<?php echo $result->ID; ?>" />

                 <input type="text" name="membership_name" value="<?php echo $result->membership_name; ?>" /></td>
                 </tr>
                  
                 <tr valign="top">
                 <th scope="row">Membership Price</th>
                 <td><input type="text" name="membership_price" value="<?php echo $result->price; ?>" /></td>
                 </tr>

                  <tr valign="top">
                 <th scope="row">Follower</th>
                 <td><input type="text" name="follower" value="<?php echo $result->num_follower; ?>" /></td>
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
                 <th scope="row">Membership Name</th>
                 <td><input type="text" name="membership_name" value="" /></td>
                 </tr>
                  
                 <tr valign="top">
                 <th scope="row">Membership Price</th>
                 <td><input type="text" name="membership_price" value="" /></td>
                 </tr>

                  <tr valign="top">
                 <th scope="row">Follower</th>
                 <td><input type="text" name="follower" value="" /></td>
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
                  $name=$_REQUEST['membership_name'];
                  $price=$_REQUEST['membership_price'];
                  $follower=$_REQUEST['follower'];
                  $sale=$_REQUEST['sale'];
                  $sql="INSERT INTO membership (membership_name, price,num_follower,sale) VALUES ('$name', $price,$follower,$sale)";
                  $wpdb->query($sql);  
                  echo 'SAVED SUCCESSFULLY';
               }  
               else if($_REQUEST['update'])
               {
                  global $wpdb;
                  $name=$_REQUEST['membership_name'];
                  $price=$_REQUEST['membership_price'];
                  $follower=$_REQUEST['follower'];
                  $sale=$_REQUEST['sale'];
                  $ids=$_REQUEST['ids'];
                  $sql="UPDATE membership SET membership_name = '$name', price= '$price', num_follower= '$follower', sale= '$sale' WHERE ID = $ids";
                  $wpdb->query($sql);  
                  echo 'Update SUCCESSFULLY';
               }

               ?>


         <div class="wrap">
         <h1>List of Packages</h1>
          <table class="form-table">
          <tr>
               <th>ID</th>
               <th>Name</th>
               <th>Price</th>
               <th>Follower</th>
               <th>Link</th>
               <th>Sale</th>
               <th>Action</th>
          </tr>
         <?php
          global $wpdb;
         $sql = "SELECT * FROM membership";
         $result = $wpdb->get_results($sql) or die(mysql_error());

             foreach( $result as $results ) { ?>

               <tr>
                 <td><?php echo $results->ID; ?></td>
               <td><?php echo $results->membership_name; ?></td>
               <td><?php echo $results->price; ?></td>
               <td><?php echo $results->num_follower; ?></td>
               <td><?php echo get_site_url(); ?>/follower?subscription=<?php echo $results->ID; ?></td>
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



    function likes_init(){


    
           ?>

         <div class="wrap">
         <h1>Likes</h1>
      <?php if(isset($_POST['edit'])) { 
         global $wpdb;
         $sql = "SELECT * FROM likes where ID=".$_POST['id'];
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
                 <th scope="row">LIkes</th>
                 <td><input type="text" name="num_like" value="<?php echo $result->num_like; ?>" /></td>
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
                 <th scope="row">Likes</th>
                 <td><input type="text" name="num_like" value="" /></td>
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
                  $sale=$_REQUEST['sale'];
                  $sql="INSERT INTO likes (like_name, price,num_like,sale) VALUES ('$like_name', $price,$num_like,$sale)";
                  $wpdb->query($sql);  
                  echo 'SAVED SUCCESSFULLY';
               }  
               else if($_REQUEST['update'])
               {
                  global $wpdb;
                   $like_name=$_REQUEST['like_name'];
                  $price=$_REQUEST['price'];
                  $num_like=$_REQUEST['num_like'];
                  $sale=$_REQUEST['sale'];
                  $ids=$_REQUEST['ids'];
                  $sql="UPDATE likes SET like_name = '$like_name', price= '$price', num_like= '$num_like', sale= '$sale' WHERE ID = $ids";
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
               <th>Likes</th>
               <th>Link</th>
               <th>Sale</th>
               <th>Action</th>
          </tr>
         <?php
          global $wpdb;
         $sql = "SELECT * FROM likes";
         $result = $wpdb->get_results($sql) or die(mysql_error());

             foreach( $result as $results ) { ?>

               <tr>
                 <td><?php echo $results->ID; ?></td>
               <td><?php echo $results->like_name; ?></td>
               <td><?php echo $results->price; ?></td>
               <td><?php echo $results->num_like; ?></td>
               <td><?php echo get_site_url(); ?>/likes?subscription=<?php echo $results->ID; ?></td>
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



   register_activation_hook(__FILE__, 'wnm_install');

   global $wnm_db_version;
   $wnm_db_version = "1.0";

   function wnm_install(){
   global $wpdb;
   global $wnm_db_version;
   $sql = "CREATE TABLE membership (
   ID int(11) NOT NULL AUTO_INCREMENT,
   membership_name varchar(128) NOT NULL,
   price float(11) NOT NULL ,
   sale int(11) NOT NULL ,
   num_follower int(11) NOT NULL ,
   PRIMARY KEY (ID)
   ) ;";

   $sqlss = "CREATE TABLE likes (
   ID int(11) NOT NULL AUTO_INCREMENT,
   like_name varchar(128) NOT NULL,
   price float(11) NOT NULL ,
   sale int(11) NOT NULL ,
   num_like int(11) NOT NULL ,
   PRIMARY KEY (ID)
   ) ;";


   $sqls = "CREATE TABLE coupon (
   ID int(11) NOT NULL AUTO_INCREMENT,
   coupon_name varchar(128) NOT NULL,
   rate int(11) NOT NULL ,
   expiry varchar(128) NOT NULL ,
   PRIMARY KEY (ID)
   ) ;";

   $sqls1 = "CREATE TABLE orders (
   ID int(11) NOT NULL AUTO_INCREMENT,
   link varchar(128) NOT NULL,
   order_date varchar(128) NOT NULL,
   transaction_id varchar(128) NOT NULL,
   status varchar(128) NOT NULL,
   email varchar(128) NOT NULL,
   charge varchar(128) NOT NULL,
   remains varchar(128) NOT NULL,
   start_count varchar(128) NOT NULL,
   order_id int(11) NOT NULL ,
   price float(11) NOT NULL ,
   PRIMARY KEY (ID)
   ) ;";



   $sqls1 = "CREATE TABLE createorder (
   ID int(11) NOT NULL AUTO_INCREMENT,
   link varchar(128) NOT NULL,
   subscription int(11) NOT NULL,
   process varchar(128) NOT NULL,
   addservice int(11) NOT NULL,
   code varchar(255) NOT NULL,
   likeperpage int(11) NOT NULL,
   status int(11) NOT NULL,
   notify varchar(128) NOT NULL,
   transaction varchar(128) NOT NULL,
   email varchar(128) NOT NULL,
   PRIMARY KEY (ID)
   ) ;";

   $sqls2 = "CREATE TABLE service (
   ID int(11) NOT NULL AUTO_INCREMENT,
   types varchar(128) NOT NULL,
   service_id int(11) NOT NULL ,
   PRIMARY KEY (ID)
   ) ;";






   require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
   dbDelta($sql);
   dbDelta($sqls);
   dbDelta($sqlss);
   dbDelta($sqls1);
   dbDelta($sqls2);

   add_option("wnm_db_version", $wnm_db_version);
   }


?>

