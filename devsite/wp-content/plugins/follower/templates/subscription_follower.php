<div class="Order_detail main1">
	<div class="enter-order-deatil">
		<div class="right">
       		<div class="order-headings">
       			<h2>Order Details</h2>
       			<p><?=$num_follower?> </p>
       			<span class="insta-">Instagram Followers</span>
       		</div>
       		<div class="right-inner">
           		<ul class="foll-desc">
               		<li><img src="<?php echo plugins_url( '../image/check-sign.png', __FILE__ );?>">#1 Follower Service</li>
               		<li><img src="<?php echo plugins_url( '../image/check-sign.png', __FILE__ );?>">Money-Back Guarantee</li>
	            	<li><img src="<?php echo plugins_url( '../image/check-sign.png', __FILE__ );?>">Express Order Delivery</li>
               		<li><img src="<?php echo plugins_url( '../image/check-sign.png', __FILE__ );?>">24/7 Priority Service</li>
               		<li><img src="<?php echo plugins_url( '../image/check-sign.png', __FILE__ );?>">100% Safe. No Login Needed</li>
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
           		 
       			<form  class="details-order-form" action="" method="GET">
	       			<div class="input-field-here">		
	           			<input class="insta-feild" type="text" name="username" placeholder="Enter Username">
	           			<input type="hidden" name="subscription" value="<?=$subscription?>">
	           			<span class="insta"><img src="<?php echo plugins_url( '../image/insta-icon.jpg', __FILE__ );?>"></span>
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