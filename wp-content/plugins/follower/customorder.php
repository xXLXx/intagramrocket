<?php session_start();
/**
 * @package WordPress
 * @subpackage NorthVantage
*/
	get_header(); 

	if(isset($_GET['gateshop']) && isset($_GET['amount']))
	{




		 	global $wpdb;
			$url='https://www.instagram.com/'.$_SESSION['username'].'/';
			$subscription=$_SESSION['subscription'];
			$process=$_SESSION['process'];
			$addservice=$_SESSION['deliverytime'];
			$amt=$_GET['amount'];


			$sql="INSERT INTO createorder (link, subscription,process,status,addservice,code) VALUES ('$url', $subscription,'$process',0,$addservice,$amt)";
            $wpdb->query($sql);
            $lastid = $wpdb->insert_id;

          	/*  echo $sql;
            print_r($lastid);
            die;*/

            if($lastid==0)
            {
            	$url=get_site_url().'/custom-order?e=1';
				wp_redirect( $url );
				exit;
            }
            else
            {
            	 $timestamp = date("Y-m-d.h:i:s",time());
			    $custom_id = $lastid; //custom order id
			    $total_amount=$_GET['amount']; // total order amount
			    $item_price_total = $_GET['amount']; // all products total sum
			    $handling = number_format(($total_amount-$item_price_total),2,'.', ''); // 15.00-11.90
			    $params = array('currency' =>'USD',
			                'item_name_1'=>'Instagram Custom Package',
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

		
		   


	}
	elseif(isset($_GET['username']))
	{

		 	global $wpdb;

	        

	


		$insta = [];

		$_GET['username'] = str_replace(' ', '', $_GET['username']);


		//$url='https://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20html%20where%20url=%22https://www.instagram.com/'.$_GET['username'].'/%22%20and%20xpath=%22/html/body/script[1]%22&format=json';

		$url='https://www.instagram.com/web/search/topsearch/?context=blended&query='.$_GET['username'].'&rank_token=0.07259959734289434';

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_TIMEOUT, 5);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
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
			$url=get_site_url().'/custom-order?e=1';
		
		
			wp_redirect( $url );
			exit;
		}
		else
		{
				
			$follow=$_GET['follower'];
			if($follow==500)
			{
					$num_follower=500;
					$price_follower=9.99;
			}
			elseif($follow==1000)
			{
					$num_follower=1000;
					$price_follower=19.99;
			}
			elseif($follow==3000)
			{
					$num_follower=3000;
					$price_follower=33.99;
			}
			elseif($follow==5000)
			{
					$num_follower=5000;
					$price_follower=49.99;
			}
			elseif($follow==7500)
			{
					$num_follower=7500;
					$price_follower=65;
			}	
			elseif($follow==10000)
			{
					$num_follower=10000;
					$price_follower=79;
			}	
			elseif($follow==15000)
			{
					$num_follower=15000;
					$price_follower=119;
			}
			elseif($follow==20000)
			{
					$num_follower=20000;
					$price_follower=150;
			}
			elseif($follow==50000)
			{
					$num_follower=20000;
					$price_follower=275;
			}
			elseif($follow==75000)
			{
					$num_follower=75000;
					$price_follower=325;
			}
			else
			{
				$num_follower=0;
				$price_follower=0;
			}

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


        
	        $_SESSION['username']= $_GET['username'];

	        $_SESSION['subscription']= $_GET['follower'];

	        $_SESSION['deliverytime']= $_GET['deliverytime'];
	   
	        $_SESSION['process']='custom';

			$length=6;
			$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		    $charactersLength = strlen($characters);
		    $random = '';
		    for ($i = 0; $i < $length; $i++) {
		        $random .= $characters[rand(0, $charactersLength - 1)];
		    }

		   
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



	


		
		?>

 <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800,800i" rel="stylesheet"> 


		<div class="Order_detail">
		     <div class="enter-order-deatil">

		       <div class="right">
		           <div class="order-headings">
		           		<h2>Order Details</h2>
		           		<p><span id="addfollower"><?php echo $_GET['follower']; ?></span> <span>Instagram Followers</span></p>
		           		
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

		           	      <!-- <div class="mob_del1" style="display: none"> -->
		           	      	
		           	      <!-- </div>	 -->
		         </div>
		         </div>
                 <span class="del_status"><?php echo $_GET['deliverytime']; ?> DAY DELIVERY</span>

		           	<div class="coupon">
		           	




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
			           			<input class="coup" type="hidden" name="username" value="<?php echo $_GET['username']; ?>">
			           			<input class="coup" type="hidden" name="deliverytime" value="<?php echo $_GET['deliverytime']; ?>">
			           			<input class="coup" type="hidden" name="follower" value="<?php echo $_GET['follower']; ?>">
			           			<input class="coup" type="text" name="coupon_code" value="" placeholder="COUPON CODE">
			           			<input class="coup-sub" type="SUBMIT" name="" value="SUBMIT">
			           			</form>
		           			</div>

	           			<?php
		           		}
		           		?>

		           			

		           		</div>

		           	</div>


		           	<div class="order-d-footer">
                         <div class="paypal-btn">

                    


                       

                         <script src="https://checkout.stripe.com/checkout.js"></script>

		

			     





                        	 <div class="paypal-btn">
                         	<form action="<?php the_permalink(); ?>" method="get">
                         	
						   
						    <?php if($status==0){ ?>
		           			 <input type="hidden" id="amt" name="amount" value="<?php echo number_format((float)$price_follower, 2, '.', ''); ?>">
		           		<?php }else { ?>
		           			 <input type="hidden" id="amt" name="amount" value="<?php echo number_format((float)$price_follower-($price_follower*$discount)/100, 2, '.', ''); ?>">

		           		<?php } ?>
						     
						     <input type="hidden" name="gateshop" value="1">

						


						     <button type="submit" id="customButton">CONTINUE</button>
						   
							</form>
               
                         </div>

							
                         
                         </div>
                      
		           		</div>

		         
		       </div>

		        <div class="profile-left">
		       	<div class="order-headings">

		         <h2>Your Order Details</h2>

		     	</div>


		           <div class="profile-left-inner"> 
                         <!-- <h2>Review Detail:</h2> -->
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
		           		</div>
		           		


		           		

		           </div>

		           
		           		<div class="images">
		           		  
<!-- 		           	      <div class="mob_del2">
		           	      	<span class="del_status">DELIVERY STATUS READY</span>
		           	      </div> -->
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
	else
	{


		?>

		<div class="Order_detail main1 ordercustom">
		     <div class="enter-order-deatil">
		  
		   

		            <div class="">
		        <div class="order-headings">

		         <h2>Custom Order</h2>

		     	</div>




		           <div class="left-inner">  
		           		<?php if(isset($_GET['e']) ){ ?> 
		           		 <span class="error">Invalid Instagram username.</span> 

		           		 <?php } ?>
			           		 
		           		<form  class="details-order-form order-custom" action="">

		           	<div class="input-field-here">	
                        <label>Followers</label>
		           		<select name="follower">
		           				<option value="500">500</option>
		           				<option value="1000">1000</option>	
		           				<option value="2000">2000</option>
		           				<option value="3000">3000</option>
		           				<option value="5000">5000</option>
		           				<option value="7500">7500</option>
		           				<option value="10000">10000</option>
		           				<option value="20000">20000</option>
		           				<option value="50000">50000</option>
		           				<option value="75000">75000</option>
		           		</select>	
                        <label>Delivery time</label>
		           		<select name="deliverytime">
		           				<option value="7">1 week</option>	
		           				<option value="14">2 weeks</option>
		           				<option value="30">1 month</option>
		           		</select>		
		               <input class="insta-feild" type="text" name="username" placeholder="Enter Username">
		          
		               <span class="insta"><img src="<?php echo plugins_url( '/image/insta-icon.jpg', __FILE__ );?>"></span>
		                <div class="next-button-div">
		               		<button>Continue</button>
		           		</div>		               
<!-- 		               <span>Please enter your username without the @</span>
		               <span>Enter Coupon Code on the Next Page</span> -->
		            </div> 
		               
		               </form>
		           </div>
		       </div>
		   </div>
		   </div>


		<?php
	}



	?>
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
   var followeramt=parseInt(jQuery('#addfollower').html()); 




	//jQuery('#edValue').on("keyup", function() {
	// 	$('#edValue').bind("change keyup input",function() {
	//  	var e= jQuery(this).val();
	//   console.log(e);
	// 	document.cookie = 
 //            'addaddress=' +e+ 
 //            '; expires=' + now.toGMTString() + 
 //            '; path=/';
	// });


	// function myFunction(e){ 

		
	
		

	// }


   
    console.log(followeramt);
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

	         
	            jQuery('#addfollower').html(followeramt+1000);
	          
	 			
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

	            jQuery('#addfollower').html(followeramt);
	 			
	 			
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
	            
	            jQuery('#addfollower').html(followeramt+2000);
	 			
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
	             jQuery('#addfollower').html(followeramt);
	 			
	 			
	 		}

 		}
 		

 	
 	}




 	

 		var handler = StripeCheckout.configure({
						  key: 'pk_live_6t96m9jPCg0n8x1dwO9msPZ6',
						  image: 'https://www.instagramrocket.com/wp-content/uploads/2017/05/new-logo1-1.png',
						  zipcode:'true',
						  locale: 'auto',
						  token: function(token) {


						  		var ammt=jQuery('#amt').val();

							  	var amount = Math.round(ammt*100)

							  	jQuery.ajax({
								      type: 'POST',
								      url: "wp-content/plugins/follower/stripe.php",
								      data: {'stripeToken':token.id,'ammt':amount},
								      dataType: "text",
								      success: function(resultData) {

								      	console.log(resultData);

								      
								      	if(resultData=='done')
							      		{

								    	var test='<?php echo get_site_url(); ?>/follower/?subscription=<?php echo $_GET['subscription']; ?>&username=<?php echo $_GET['username']; ?>&stripedone=1&random=<?php echo $random; ?>';
								      			console.log(test);
						    					window.location.href = test;

						    			}
								     else
								     {
								     	alert(resultData);
								     }

								

								   }
								});



						    	
				
								//window.location.href = test;
						  }
						});

						document.getElementById('customButton').addEventListener('click', function(e) {                  




								/*var ammt=jQuery('#amt').val();


								  handler.open({
								    name: 'Instarocket',
								    description: '',
								    amount: ammt*100
								  });
								  e.preventDefault();
*/
							





						});

						// Close Checkout on page navigation:
						window.addEventListener('popstate', function() {
						  handler.close();
						});

 </script>


	<?php


	// echo "\n\t\t". '<div class="clear"></div>';
	// echo "\n\t". '</div><!-- #content -->';	
	//call the wp foooter
	get_footer();
?>
