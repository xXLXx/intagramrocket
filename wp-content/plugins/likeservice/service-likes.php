<?php session_start();
/**
 * @package WordPress
 * @subpackage NorthVantage
*/
	get_header(); 

	// $NV_layout = of_get_option('arhlayout','layout_four');
	
	
	// $count = 1;
	// $NV_postlayout = of_get_option('arhpostdisplay','');
	// $NV_gridcols = of_get_option('arhpostcolumns','2');

	// $columns = '';
		
	// if( $NV_layout == "layout_one" ) 		$columns = 'twelve';
	// elseif( $NV_layout == "layout_two" )	$columns = 'eight last';
	// elseif( $NV_layout == "layout_three" )	$columns = 'six last';
	// elseif( $NV_layout == "layout_four" )	$columns = 'eight';
	// elseif( $NV_layout == "layout_five" )   $columns = 'six';
	// elseif( $NV_layout == "layout_six" )  	$columns = 'six';
	// else $columns = 'eight';	
		
	// echo "\n\t". '<div id="content" class="columns '. $columns .' '. $NV_layout .'">';

	if(isset($_POST['email-submit']))
	{
	
	
					$url = 'https://a.klaviyo.com/api/v1/email-templates?api_key=pk_1914c7c0c49493748a43efdf0735d61e59';
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, $url);
					curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
					curl_setopt($ch, CURLOPT_HEADER, 0);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);	 
					$result = curl_exec($ch);
					$items = json_decode((string) $result, true);
			
			
					$insta = '';
					$name='';
			     	$count=0;
			     	foreach ($items['data'] as $key => $value) {
			       

			         	if($value['id']=='KsEW3n')
			         	{
				         	$insta= $value['html'];
				         	$name= $value['name'];
				         	break;
			         	}

			         	
			         	
			         }

			        if($_POST['email-submit']!='')
			    	{
						wp_mail( $_POST['email-submit'], $name, $insta );
			    	}

			    	?>

			    	<div class="sucess_coupon">
			    		<img src="<?php echo plugins_url( '/image/checked-(3).png', __FILE__ );?>">
			    		<h2>Success, your coupon has been sent to your inbox!</h2>
			    	</div>

			    	<?php
	 }
	else if(isset($_GET['gateshop']) && isset($_GET['amount']))
	{

		
		    global $wpdb;
			$url='https://www.instagram.com/'.$_SESSION['username'].'/';
			$subscription=$_SESSION['subscription'];
			$process=$_SESSION['process'];
			$addservice=$_COOKIE['addservice'];


			$sql="INSERT INTO createorder (link, subscription,process,status,addservice) VALUES ('$url', $subscription,'$process',0,$addservice)";
            $wpdb->query($sql);
            $lastid = $wpdb->insert_id;



		
		    $timestamp = date("Y-m-d.h:i:s",time());
		    $custom_id = $lastid; //custom order id
		    $total_amount=$_GET['amount']; // total order amount
		    $item_price_total = $_GET['amount']; // all products total sum
		    $handling = number_format(($total_amount-$item_price_total),2,'.', ''); // 15.00-11.90
		    $params = array('currency' =>'USD',
		                'item_name_1'=>'Instagram Promotion Package',
		                'item_number_1'=>$custom_id,
		                'item_amount_1'=>$_GET['amount'],
		                'item_quantity_1'=>'1',
		                'numberofitems'=>'1',
		                'encoding' => 'utf-8',    
		                'merchant_id' =>'5788005443334360451',    
		                'merchant_site_id' =>'161739',
		                'time_stamp' => $timestamp, 
		                'version' => "3.0.0",
		                'success_url' => 'https://instagramrocket.com/follower?getdone=1',
		                'invoice_id' => (int)($custom_id).'_'.date('YmdHis'),
		                'merchant_unique_id' => (int)($custom_id).'_'.date('YmdHis'),
		                'total_amount'=>number_format($total_amount,2,'.', ''),
		                'handling'=>$handling);
		  
		    $JoinedInfo = $params['merchant_id'].$params['currency'].$params['total_amount'].$params['item_name_1'].$params['item_amount_1'].$params['item_quantity_1'].$timestamp;
		    $params["checksum"] = md5("D2V7CfsAaeWU3bi1Ee7BGb65DLsJM4UKRk8W2yT8se3cYAAeUEVUlHhYGqlp6LaL" . $JoinedInfo);           
		     
		    $fields_string="";
		    foreach($params as $key=>$value) { $fields_string .= $key."=".urlencode($value)."&"; }
		    $fields_string = rtrim($fields_string, "&");
		     
		    header("Location:"."https://secure.gate2shop.com/ppp/purchase.do?".$fields_string);


	}
	 else if(isset($_GET['stripedone']) && isset($_GET['subscription']) && isset($_GET['username']) && isset($_GET['random']))
	{

	


			if($_GET['random'])
			{

						 global $wpdb;



				

					     $sql = 'SELECT * FROM likes where ID='.$_GET['subscription'];
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

					

						$array=explode(',',$_COOKIE['codes']);

						$count=count($array);
						
						$c=1;
						foreach ($array as $key ) {

							if($c<$count)
							{
								$image_url='https://www.instagram.com/p/'.$key.'/';

								$add_example_0 = array(
								    'api_key' => '',
								    'action' => 'add',
								    'service_id' => $result1->service_id,
								    'url' => $image_url,
								    'quantity' => $_COOKIE['likeperpage']
								);

							

								
									$order = json_decode(submit_url('http://www.ytbot.com/api.php', $add_example_0));
									date_default_timezone_set('America/Los_Angeles');
									$dates=date("Y/m/d");
								
					        	  $order_id=$order->id;
					              $sql="INSERT INTO orders (link, price,order_id,order_date) VALUES ('$image_url', $price_follower,$order_id,'$dates')";
					              $wpdb->query($sql); 


								$c++;
							}
							
							
						}


						if($_COOKIE['addservice']==1 || $_COOKIE['addservice']==2)
				    	{

				    		$url='https://www.instagram.com/'.$_GET['username'].'/';

							$sql1 = 'SELECT * FROM service where ID=1';
				         	$result1 = $wpdb->get_row($sql1);

				         	if($_COOKIE['addservice']==1)
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
				              $sql="INSERT INTO orders (link, price,order_id,order_date) VALUES ('$url', 0,$order_id,'$dates')";
				              $wpdb->query($sql);
				    	}  



				    			

						
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

						$_SESSION['random']="";
						header("Location: https://www.instagramrocket.com/success-page/");
				
						die;


						  
		}
		else
		{
			$url=get_site_url().'/likes?subscription='.$_GET['subscription'];
		
			wp_redirect( $url );
			exit;

		}
	}
	else if(isset($_GET['getdone']))
	{

		

			if($_SESSION['process']=='autolikes')
			{

				

						 global $wpdb;


					     $sql = 'SELECT * FROM likeslikes where ID='.$_SESSION['subscription'];
					     $result = $wpdb->get_row($sql);


					     $count=count($result);


					    if($count>=1)
					    {
							$price_follower=$result->price;
							$num_like=$result->num_like;
							$num_like_max=$result->num_like_max;
					    }
						else
						{
						
							$price_follower=0;
							$num_like=0;
							$num_like_max=0;
						}


						$image_url='https://www.instagram.com/'.$_SESSION['username'].'/';

					

						$add_example_0 = array(
					    'api_key' => 'tUZyuuSLnAgpYTTQMs7eWltEW',
					    'action' => 'add',
					    'service_id' => '301',
					    'url' => $image_url,
					    'order_mode' => 'auto_buy',
					    'min' => $num_like,
						'max' => $num_like_max,
						'new_s' => '5',
						'seed' => '' //random number, ideally best to use unix timestamp!
					);



	print_r($add_example_0);

				

					
						$order = json_decode(submit_url('http://www.ytbot.com/api.php', $add_example_0));

						print_r($order);
						die;
						date_default_timezone_set('America/Los_Angeles');
						$dates=date("Y/m/d");
					
		        	  $order_id=$order->id;
		              $sql="INSERT INTO orderslikes (link, price,order_id,order_date) VALUES ('$image_url', $price_follower,$order_id,'$dates')";
		              $wpdb->query($sql); 


				
							
						


						if($_COOKIE['addservice']==1 || $_COOKIE['addservice']==2)
				    	{

				    		$url='https://www.instagram.com/'.$_SESSION['username'].'/';

							$sql1 = 'SELECT * FROM service where ID=1';
				         	$result1 = $wpdb->get_row($sql1);

				         	if($_COOKIE['addservice']==1)
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
				              $sql="INSERT INTO orders (link, price,order_id,order_date) VALUES ('$url', 0,$order_id,'$dates')";
				              $wpdb->query($sql);
				    	}  



				    			

						
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

						$_SESSION['random']="";
						header("Location: https://www.instagramrocket.com/success-page/");
				
						die;
		}
	}
	else if(isset($_GET['username']) && isset($_GET['subscription']))
	{

		 	global $wpdb;

	         $sql = 'SELECT * FROM likeslikes where ID='.$_GET['subscription'];
	         $result = $wpdb->get_row($sql);







	         $count=count($result);


	         if($count>=1)
	         {
	         	$num_follower=$result->num_like;
				$price_follower=$result->price;
				$sale=$result->sale;
	         }
			else
			{
				$num_follower=0;
				$price_follower=0;
				$sale=0;
			}


	


		$insta = [];

		$_GET['username'] = str_replace(' ', '', $_GET['username']);

	

		//$url='https://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20html%20where%20url=%22https://www.instagram.com/'.$_GET['username'].'/%22%20and%20xpath=%22/html/body/script[1]%22&format=json';

		$url='https://www.instagram.com/web/search/topsearch/?context=blended&query='.$_GET['username'].'&rank_token=0.07259959734289434';

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$data = curl_exec($ch);
		curl_close($ch);
		//var_dump(json_decode($response, true));

		// $itemss = json_decode((string) $data, true)['query']['results']['script']['content'];

		// $itemss =str_replace("window._sharedData = ","",$itemss);
		// $itemss =str_replace(";","",$itemss);
		// $itemss = (array) json_decode($itemss);

		$itemss = json_decode((string) $data, true);


		
		$insta = [];

		 foreach ($itemss['users'] as $key => $value) {
		
         	if($value['user']['username']==strtolower($_GET['username']))
         	{
	         	$insta['full_name']= $value['user']['full_name'];
	         	$insta['byline']= $value['user']['byline'];
	         	$insta['profile_pic_url']= $value['user']['profile_pic_url'];
	         	break;
         	}
         	
         }


		if($insta==null)
		{
			$url=get_site_url().'/service-likes?subscription='.$_GET['subscription'].'&e=1';
		
		
			wp_redirect( $url );
			exit;
		}
		else
		{
			

			// $insta['byline']=$itemss['entry_data']->ProfilePage[0]->user->followed_by->count;
			// $insta['following']=$itemss['entry_data']->ProfilePage[0]->user->follows->count;
			// $insta['full_name']=$itemss['entry_data']->ProfilePage[0]->user->full_name;
			// $insta['profile_pic_url']=$itemss['entry_data']->ProfilePage[0]->user->profile_pic_url;
			// $insta['post']=$itemss['entry_data']->ProfilePage[0]->user->media->count;

			// if($_SESSION['username']!=$_GET['username'])
			// {
			// 	$_SESSION['byline']=$itemss['entry_data']->ProfilePage[0]->user->followed_by->count;
			// 	$_SESSION['following']=$itemss['entry_data']->ProfilePage[0]->user->follows->count;
			// 	$_SESSION['full_name']=$itemss['entry_data']->ProfilePage[0]->user->full_name;
			// 	$_SESSION['profile_pic_url']=$itemss['entry_data']->ProfilePage[0]->user->profile_pic_url;
			// 	$_SESSION['post']=$itemss['entry_data']->ProfilePage[0]->user->media->count;
			// 	$_SESSION['username']=$_GET['username'];
			// }

			$_SESSION['byline']= $value['user']['byline'];

			$_SESSION['full_name']=$value['user']['full_name'];
			$_SESSION['profile_pic_url']=$value['user']['profile_pic_url'];

			$_SESSION['username']=$value['user']['username'];

			$_SESSION['subscription']= $_GET['subscription'];
	        $_SESSION['username']= $_GET['username'];
	        $_SESSION['process']= 'autolikes';


			$length=6;
			$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		    $charactersLength = strlen($characters);
		    $random = '';
		    for ($i = 0; $i < $length; $i++) {
		        $random .= $characters[rand(0, $charactersLength - 1)];
		    }


			$_SESSION['random']=$random;
			
			
			$_SESSION['random']=$random;
			echo '<span class="session">';
			echo $_SESSION['random'];
			echo '</span>';


	




			if(isset($_GET['coupon_code']))
			{
				 global $wpdb;

				 $status=0;
				 $message='';
				 $discount=0;
				 date_default_timezone_set('America/Los_Angeles');
				 $date = date('Y-m-d');

		         $sql = 'SELECT * FROM coupon where coupon_name="'.$_GET['coupon_code'].'"';
		         $result = $wpdb->get_row($sql);

		         $count=count($result);


		        $time = strtotime($result->expiry);

				$newformat = date('Y-m-d',$time);

				if($count>=1)
				{

					if($date<=$newformat)
					{
						$status=1;
						$discount=$result->rate;
						$message='Coupon Success';

					}
					else
					{
						$status=1;
						$message='Coupon Expired';
					}

				}

				

			}


			$urls='https://www.instagram.com/'.$_GET['username'].'/media/';


			$chs = curl_init($urls);
			curl_setopt($chs, CURLOPT_TIMEOUT, 10);
			curl_setopt($chs, CURLOPT_CONNECTTIMEOUT, 10);
			curl_setopt($chs, CURLOPT_RETURNTRANSFER, true);
			$datas = curl_exec($chs);
			curl_close($chs);
			//var_dump(json_decode($response, true));

			$posts = json_decode((string) $datas, true)['items'];

		

	




	


		
		?>

 <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800,800i" rel="stylesheet"> 


		<div class="Order_detail">
		     <div class="enter-order-deatil">

		       <div class="right">
		           <div class="order-headings">
		           		<h2>Order Details</h2>
		           		<p><?php echo $num_follower; ?> <span>Instagram Likes</span></p>
		           		<textarea style="display: none;" id="list" rows="4" cols="20"></textarea>
		           	</div>
		           	<div class=profile-mobile>
		           	<div class="profile-review">
		            	<h2><span><?php echo $_SESSION['full_name']; ?></span></h2>
		           	</div>
		           	<div class="user-img1">
		           			<img src="<?php echo $_SESSION['profile_pic_url']; ?>">
		           		</div>
		           	<div class="user-detail">   
		           	 <div class="follower1">
		           		   	 <span>Current Followers</span>
		           		   	 <span><?php echo $_SESSION["byline"]; ?></span>
		           		   	
		           		   </div>
		           		   <div class="post1">
		           		   	 <span>Profile Check:</span>
			           		   <span>COMPLETE</span>
			           		   
		           	      </div>	
		         </div>
		         </div>
                   <span class="del_status">DELIVERY STATUS READY</span>

		           	<div class="coupon">
		           		<div class="main_coupon">ADD ON EXTRA AND SAVE <i class="fa fa-sort-desc" aria-hidden="true"></i></div>
		           		
		           		<div class="extra_feature">
		           		<h3>Add More Followers to your Order NOW <br><span> Save 50% </span></h3>	
		           		<div class="checkout">
		           			<input id="checkMeOut" type="checkbox" onclick="addservice(1);">
		           			<label></label>
		           			<span>ADD 1000 FOLLOWERS - 6.99</span>
		           		</div>	
		           		<div class="checkout">
		           			<input id="checkMeOut1" type="checkbox" onclick="addservice(2);">
		           			<label></label>
		           			<span>ADD 2000 FOLLOWERS - 13.98</span>
		           		</div>
		           		</div>
		           		
		           		
		           		<div class="coupon_order">
		           		<span class="total">Order Total</span>
		           		<?php if($status==0){ ?>
		           			<span class="follo">$<?php echo number_format((float)$price_follower, 2, '.', ''); ?></span>
		           		<?php }else { ?>
		           			<span class="follo">$<?php echo number_format((float)$price_follower-($price_follower*$discount)/100, 2, '.', ''); ?></span>
		           			<span class="coupon_message">Promo Code <?php echo $_GET['coupon_code']; ?>: <span class="coupon_follo">-$<?php echo number_format((float)($price_follower*$discount)/100, 2, '.', ''); ?></span></span>

		           		

		           		<?php } ?>


		           		<?php if($sale==0)
		           		{
		           			?>

		           			<div class="couponssss">	
			           			<form action="<?php the_permalink(); ?>">
			           			<input class="coup" id="usercode" type="hidden" name="username" value="<?php echo $_GET['username']; ?>">
			           			<input class="coup" type="hidden" name="subscription" value="<?php echo $_GET['subscription']; ?>">
			           			<input class="coup" required type="text" name="coupon_code" value="" placeholder="COUPON CODE">
			           			<input class="coup-sub" type="SUBMIT" name="" value="SUBMIT">
			           			</form>
		           			</div>

		           			<?php
		           		}
		           		?>
		           		
		           			



		           		</div>

		           	</div>

		           	<div class="order-d-footer">

		           
					  <script src="https://checkout.stripe.com/checkout.js" ></script>


		       

                        <div class="paypal-btn">
                         	<form id="payform" action="<?php the_permalink(); ?>" method="get">
                         	
						   
						    <?php if($status==0){ ?>
		           			 <input type="hidden" id="amt" name="amount" value="<?php echo $price_follower; ?>">
		           		<?php }else { ?>
		           			 <input type="hidden" id="amt" name="amount" value="<?php echo $price_follower-($price_follower*$discount)/100; ?>">

		           		<?php } ?>
						     
						     <input type="hidden" name="gateshop" value="1">

						  

						      <button type="submit" id="customButton">CONTINUE</button>
						   
							</form>
               
                         </div>


                        
		           		</div>

		         
		       </div>

		        <div class="profile-left">
		       	<div class="order-headings">

		         <h2>Your Order Details</h2>

		     	</div>


		           <div class="profile-left-inner"> 
                        <!-- images -->
		           		<div class="user-img">
		           			<img src="<?php echo $_SESSION['profile_pic_url']; ?>">
		           		</div>
		           		<div class="user-detail">
		           		   <h2><span><?php echo $_SESSION['full_name']; ?></span></h2>
		           		   
		           		   <div class="follower">
		           		     <img src="<?php echo plugins_url( '/image/follower.png', __FILE__ );?>" alt="follower">
		           		   	 <span>Current Followers</span>
		           		   	 <span><?php echo $_SESSION["byline"]; ?></span>
		           		   	
		           		   </div>
		           		   <div class="post">
		           		     <img src="<?php echo plugins_url( '/image/profile-check.png', __FILE__ );?>" alt="follower">
		           		   	 <span>Profile Check</span>
			           		   <span>COMPLETE</span>
			           		   
		           		   </div>	
		           		   <span class="delivery">AUTO LIKES</span>
		           		</div>

		           	






		           		

		           		

		           		

		           </div>
		           <div class="images likes">

		           			<div class="stripe">
		           	      	<img src="<?php echo plugins_url( '/image/stripe-secure-payment.png', __FILE__ );?>">

		           	      </div>

		           		<!--  <div class="top">
		           			<div class="left"><img src="<?php echo plugins_url( '/image/pay-pal-secured.jpg', __FILE__ );?>"></div>

		           			<div class="credits"><img src="<?php echo plugins_url( '/image/visas-image.jpg', __FILE__ );?>"></div>		           					           		 
		           		</div> -->


		           		 <div class="bottom">
		           		  	<div class="secure"><img src="<?php echo plugins_url( '/image/100-secure.png', __FILE__ );?>"></div>
		           			
		           			
		           			<div class="img-1"><img src="<?php echo plugins_url( '/image/bbb_logo.png', __FILE__ );?>"></div>
		           			
		           			<div class="img-2"><img src="<?php echo plugins_url( '/image/norton.png', __FILE__ );?>"></div>
		           		 </div>

		           		</div>
		       </div>
		   </div>
		   </div>


		<?php }
	}
	else if(isset($_GET['subscription']))
	{

			 global $wpdb;

			$_SESSION['byline']='';
			$_SESSION['following']='';
			$_SESSION['full_name']='';
			$_SESSION['profile_pic_url']='';
			$_SESSION['post']='';
			$_SESSION['username']='';


	         $sql = 'SELECT * FROM likeslikes where ID='.$_GET['subscription'];
	         $result = $wpdb->get_row($sql);



	         $count=count($result);


	         if($count>=1)
	         {
	         	$num_follower=$result->num_like;
				$price_follower=$result->price;
	         }
			else
			{
				$num_follower=0;
				$price_follower=0;
			}
		?>

		<div class="Order_detail main1">
		     <div class="enter-order-deatil">
		  
		       <div class="right">
		           <div class="order-headings">
		           		<h2>Order Details</h2>
		           		<p><?php echo $num_follower; ?> </p>
		           		<span class="insta-">Instagram Likes</span>
		           			<span class="del_status">DELIVERY STATUS READY</span>
		           	</div>
		           <div class="right-inner">
		               <ul class="foll-desc">
		                   <li><img src="<?php echo plugins_url( '/image/check-sign.png', __FILE__ );?>">#1 Likes Service</li>
		                   
		                   <li><img src="<?php echo plugins_url( '/image/check-sign.png', __FILE__ );?>">Money-Back Guarantee</li>
		                   
		                   <li><img src="<?php echo plugins_url( '/image/check-sign.png', __FILE__ );?>">Express Order Delivery</li>

		                   <li><img src="<?php echo plugins_url( '/image/check-sign.png', __FILE__ );?>">24/7 Priority Service</li>

		                   <li><img src="<?php echo plugins_url( '/image/check-sign.png', __FILE__ );?>">100% Safe. No Login Needed</li>
		                   
		               </ul>
		              
		           </div>
		       </div>
		       <hr>

		            <div class="left">
		           <div class="order-headings">

		         <h2>Your Order Details</h2>

		     	</div>




		           <div class="left-inner">  
		           		<?php if(isset($_GET['e']) ){ ?> 
		           		 <span class="error">Invalid Instagram username.</span> 

		           		 <?php } ?>
			           		 
		           		<form  class="details-order-form" action="">

		           	<div class="input-field-here">		
		               <input class="insta-feild" type="text" name="username" placeholder="Enter Username">
		               <input type="hidden" name="subscription" value="<?php echo $_GET['subscription']; ?>">
		               <span class="insta"><img src="<?php echo plugins_url( '/image/insta-icon.jpg', __FILE__ );?>"></span>
		               <span>Please enter your username without the @</span>
		               <span>Enter Coupon Code on the Next Page</span>
		            </div> 
		               
		                <div class="next-button-div">
		               		<button>NEXT</button>
		           		</div>
		               </form>
		           </div>
		       </div>
		   </div>
		   </div>
		

		<?php
	}
	else
	{
			$url=get_site_url().'/buy-real-likes/';
		
			wp_redirect( $url );
			exit;
	}

	?>

	<script type="text/javascript">

		

		var totalselect=0;
		var total=0;
		var codes='';
		var d = new Date();
		d.setTime(d.getTime() + (1*24*60*60*1000));
	    var expires = "expires="+ d.toUTCString();
		document.cookie = 'codes' + "=" + '' + ";" + expires + ";path=/";
		function select_code(code,likes)
		{

	
				//document.cookie = 'codes' + '=;expires=Thu, 01 Jan 1970 00:00:01 GMT;';

				var ids='form_'+code;

				var textArea = jQuery("#list");
				console.log(ids);

			   
				if(document.getElementById(''+ids+'').className=='inactiveselect')
				{	
					if(totalselect<=4)
					{
						document.getElementById(''+ids+'').className = "activeselect";
						totalselect=totalselect+1;
						total=parseInt(likes/totalselect);
						textArea.val(function(_, val) {
							codes=val + code + ',';

				    
				    		document.cookie = 'codes' + "=" + codes + ";" + expires + ";path=/";
					        return val + code + ',';
					      });

						document.cookie = 'likeperpage' + "=" + total + ";" + expires + ";path=/";
					}
					else{
						alert('Already Select Five Images');
					}
									
					
				}
				else
				{
					document.getElementById(''+ids+'').className = "inactiveselect";
					totalselect=totalselect-1;
					if(totalselect!=0)
					{
						total=parseInt(likes/totalselect);
					}
					else
					{
						total=likes;
					}

					textArea.val(function(_, val) {
						codes=val.replace(code + ',', '');
						document.cookie = 'codes' + "=" + codes + ";" + expires + ";path=/";
			        	return val.replace(code + ',', '');
			      });

					document.cookie = 'likeperpage' + "=" + total + ";" + expires + ";path=/";
					
					
					
				}


			
				console.log(totalselect);

				document.getElementById('multiple_status1').innerHTML=totalselect;
				document.getElementById('multiple_status2').innerHTML=total;
			
			


			
			
		}


		function checkorder()
		{
			if(totalselect<=0)
			{
				//alert('Please choose one of the image');
				return false;
			}
			else
			{
				jQuery('form#payform').submit();
				return true;

			}
			

		}


	

		var load=0;
		var pagecount=5;
		var nextsix=11;
		
		function load_more()
		{


			jQuery('#laoding').show();
      

   	
			var follower=parseInt(jQuery('input#follower').val());


			var username=document.getElementById('usercode').value; 
			var urls='https://www.instagram.com/'+username+'/media/';

		
			  jQuery.ajax({
	            url: 'https://www.instagramrocket.com/wp-content/plugins/follower/callmore.php',
	            data: {username: username,getmorepost: 1}, 
	            type: 'GET',
	            error: function(xhr, status, error) {
	               console.log(xhr);
	               console.log(status);
	               console.log(error);
	            },
	            success: function(jsonp) { 
	            	var arr = jQuery.parseJSON(jsonp);

	            	var counts=0;

			jQuery.each(arr.items, function(idx, v) {


				
					if(v.type=='image')
					{
					  

					  var img='<img src="'+v.images.standard_resolution.url+'"><span class="p_num">'+v.likes.count+'</span>';
					}
					else
					{
					  
					     var img='<img src="'+v.images.thumbnail.url+'"><span class="p_num">'+v.video_views+'</span>';
					}

//onclick="select_code('+v.code+',100)"

					var test ="<div id='form_"+v.code+"' class='inactiveselect' onclick='select_code(\""+v.code+"\","+follower+")'  style='cursor: pointer;'>"+img+"</div>";

				
					if(counts>pagecount && counts<=nextsix)
					{
						jQuery( "#media_list" ).append(test);
						
					}
			
					


					counts=counts+1;
			
				});

			nextsix=nextsix+6;
			pagecount=pagecount+6;

			jQuery('#laoding').hide();

	            }
	        });
    

			

			



			
		}

		

			
		
	
	</script>
	<script src="https://checkout.stripe.com/checkout.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script type="text/javascript">

 			var now = new Date();
            var time = now.getTime();
            time += 3600 * 1000 * 700;
            now.setTime(time);
            document.cookie = 
            'addservice=0' + 
            '; expires=' + now.toGMTString() + 
            '; path=/';

         

    var paypalamt=parseFloat(jQuery('#amt').val());        
    console.log(paypalamt);
 	function addservice(id){
 		if(id==1)
 		{
 			var val=jQuery('#checkMeOut').prop('checked');
	 		if(val==true)
	 		{
	 
	            document.cookie = 
	            'addservice=1' + 
	            '; expires=' + now.toGMTString() + 
	            '; path=/';

	            jQuery('#checkMeOut1').prop('checked',false);

	            var amount=paypalamt+6.99;
	            amount=amount.toFixed(2)
	            jQuery('#amt').val(amount);

	            var tt='$'+amount;

	            jQuery('.follo').html(tt);
	          
	 			
	 		}
	 		else
	 		{
	            document.cookie = 
	            'addservice=0' + 
	            '; expires=' + now.toGMTString() + 
	            '; path=/';

	            var amount=paypalamt;
	            amount=amount.toFixed(2)
	            jQuery('#amt').val(amount);

	            var tt='$'+amount;

	            jQuery('.follo').html(tt);
	 			
	 			
	 		}
 		}
 		else
 		{
 			var val=jQuery('#checkMeOut1').prop('checked');
	 		if(val==true)
	 		{
	 
	            document.cookie = 
	            'addservice=2' + 
	            '; expires=' + now.toGMTString() + 
	            '; path=/';

	           jQuery('#checkMeOut').prop('checked',false);

	           var amount=paypalamt+13.98;
	          amount=amount.toFixed(2)
	            jQuery('#amt').val(amount);

	            var tt='$'+amount;

	            jQuery('.follo').html(tt);
	 			
	 		}
	 		else
	 		{
	            document.cookie = 
	            'addservice=0' + 
	            '; expires=' + now.toGMTString() + 
	            '; path=/';

	            var amount=paypalamt;
	           amount=amount.toFixed(2)
	            jQuery('#amt').val(amount);

	            var tt='$'+amount;

	            jQuery('.follo').html(tt);
	 			
	 			
	 		}

 		}
 		

 	
 	}



 					var handler = StripeCheckout.configure({
						  key: 'pk_live_6t96m9jPCg0n8x1dwO9msPZ6',
						  image: 'https://www.instagramrocket.com/wp-content/uploads/2017/05/new-logo1-1.png',
						  zipcode:'true',
						  locale: 'auto',
						  token: function(token,args) {

						  
						  	var ammt=jQuery('#amt').val();

						  	var amount = Math.round(ammt*100)

						  	jQuery.ajax({
							      type: 'POST',
							      url: "wp-content/plugins/follower/stripe.php",
							      data: {'stripeToken':token.id,'ammt':amount},
							      dataType: "text",
							      success: function(resultData) {

							      	if(resultData=='done')
							      	{
							      		var test='<?php echo get_site_url(); ?>/likes?subscription=<?php echo $_GET['subscription']; ?>&username=<?php echo $_GET['username']; ?>&stripedone=1&random=<?php echo $random; ?>';
							      			  		console.log(test);
						  					window.location.href = test;
							      	}
								     else
								     {
								     	alert(resultData);
								     }
							   
		
							      


							   }
							});

					
								

						  }
						});

					

						// Close Checkout on page navigation:
						window.addEventListener('popstate', function() {
		
						  handler.close();
						});



 	//jQuery('#edValue').on("keyup", function() {
 // 		$('input#edValue').bind("change keyup input",function() {

	//  	var e= jQuery(this).val();
	//   console.log(e);
	// 	document.cookie = 
 //            'addaddress=' +e+ 
 //            '; expires=' + now.toGMTString() + 
 //            '; path=/';
	// });

 </script>
	<?php

	
	// echo "\n\t\t". '<div class="clear"></div>';
	// echo "\n\t". '</div><!-- #content -->';	
	//call the wp foooter
	get_footer();
?>
