<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800,800i" rel="stylesheet"> 
<div class="Order_detail">
	<div class="enter-order-deatil">
		<div class="right">
	        <div class="order-headings">
	           	<h2>Order Details</h2>
	           	<p><span id="addfollower"><?php echo $num_follower; ?></span> <span>Instagram Followers</span></p>
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
			        <h3>Add More Followers to your Order Now <br><span> Save 50% </span></h3>	
	    		    <div class="checkout">
	           			<input id="checkMeOut" type="checkbox" onclick="addservice(1);">
	           			<label></label>
	           			<span>ADD 1000 FOLLOWERS - 6.99</span>
	           		</div>
            		<div class="checkout">
            			<input id="checkMeOut1" type="checkbox" onclick="addservice(2);">
            			<label></label>
            			<span> ADD 2000 FOLLOWERS - 13.98</span>
            		</div>
	           	</div>
	           	<div class="coupon_order">
	           		<span class="total">Order Total</span>
	           		<span class="follo">$<?=$price_follower?></span>

	           		<?php
	           			if( $coupon_status > 0 ){
	           		?>
	           				<span class="coupon_message">
			           			Promo Code <?php echo $_GET['coupon_code']; ?>: 
			           			<span class="coupon_follo">
			           				- $<?=number_format( (float) $discount, 2, '.', ''); ?>
			           			</span>
			           		</span>
	           		<?php
	           			}
	           		?>


   					<?php 
   						if( $sale == 0 ){
   					?>
	           			<div class="couponssss">	
	           				<?php 
	           					if( $coupon_status <= 0 ){
	           				?>
	           						<span style="color: #ff0000;display: block;text-align: left;padding: 10px 10px 10px 0px;font-weight:bold;"><?=$message?></span>
	           				<?php
	           					}
	           				?>
		           			<form action="<?php the_permalink(); ?>">
		           				<input class="coup" type="hidden" name="username" value="<?php echo $_GET['username']; ?>">
		           				<input class="coup" type="hidden" name="subscription" value="<?php echo $_GET['subscription']; ?>">
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
        	 		<div class="paypal-btn">
         				<form action="<?php the_permalink(); ?>" method="get">
         					<input type="hidden" id="amt" name="amount" value="<?=$price_follower?>">
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
   		     			<img src="<?php echo plugins_url( '../image/follower.png', __FILE__ );?>" alt="follower">
   		   	 			<span>Current Followers</span>
   		   	 			<span><?php echo $_SESSION["byline"]; ?></span>
   		   			</div>
   		   			<div class="post">
   		     			<img src="<?php echo plugins_url( '../image/profile-check.png', __FILE__ );?>" alt="follower">
   		   	 			<span>Profile Check</span>
       		 			<span>COMPLETE</span>
   		   			</div>	
   				</div>
	        </div>
   			<div class="images">
   	      		<div class="stripe">
   	      			<img src="<?php echo plugins_url( '../image/stripe-secure-payment.png', __FILE__ );?>">
   	      		</div>
   		 		<div class="bottom">
   		  			<div class="secure">
   		  				<img src="<?php echo plugins_url( '../image/100-secure.png', __FILE__ );?>">
   		  			</div>
   					<div class="img-1">
   						<img src="<?php echo plugins_url( '../image/bbb_logo.png', __FILE__ );?>">
   					</div>
   					<div class="img-2">
   						<img src="<?php echo plugins_url( '../image/norton.png', __FILE__ );?>">
   					</div>
   		 		</div>
   			</div>
	    </div>
	</div>
</div>

<script type="text/javascript">
	
	function addservice(id){

 		if( id == 1 ){

 			var val = $('#checkMeOut').prop('checked');

	 		if(val == true){
	 
	            document.cookie = 'addservice=1' + '; expires=' + now.toGMTString() + '; path=/';

	            $('#checkMeOut1').prop('checked',false);

	            var amount = paypalamt+6.99;
	            amount = amount.toFixed(2)
	            $('#amt').val(amount);

	            var tt = '$' + amount;

	            $('.follo').html(tt);
	            $('#addfollower').html(followeramt + 1000);

	            return;
	 			
	 		}
	 		
	 		document.cookie = 'addservice=0' + '; expires=' + now.toGMTString() + '; path=/';

            var amount = paypalamt;
            amount = amount.toFixed(2)
            $('#amt').val(amount);

            var tt='$'+amount;

            $('.follo').html(tt);
            $('#addfollower').html(followeramt);

 		}else{

 			var val = $('#checkMeOut1').prop('checked');
	 		if( val == true )
	 		{
	 
	            document.cookie = 'addservice=2' + '; expires=' + now.toGMTString() + '; path=/';

	           	$('#checkMeOut').prop('checked',false);

	           	var amount = paypalamt+13.98;
	           	amount = amount.toFixed(2)
	        	$('#amt').val(amount);

	            var tt = '$'+amount;

	            $('.follo').html(tt);
	            $('#addfollower').html(followeramt + 2000);

	            return;
	 			
	 		}

	 		document.cookie = 'addservice=0' + '; expires=' + now.toGMTString() + '; path=/';

            var amount = paypalamt;
            amount = amount.toFixed(2)
            $('#amt').val(amount);

            var tt = '$'+amount;

            $('.follo').html(tt);
            $('#addfollower').html(followeramt);
            
 		}
 		

 	
 	}

</script>