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
								<form action="<?php the_permalink(); ?>">
									<input class="coup" id="usercode" type="hidden" name="username" value="<?php echo $_GET['username']; ?>">
									<input class="coup" type="hidden" name="subscription" value="<?php echo $_GET['subscription']; ?>">
									<input class="coup" required type="text" name="coupon_code" value="" placeholder="COUPON CODE">
									<input class="coup-sub" type="SUBMIT" name="" value="SUBMIT">
								</form>
							</div>

						<?php
							}else{
						?>
								<input class="coup" id="usercode" type="hidden" name="username" value="<?php echo $_GET['username']; ?>">
						<?php
							}
						?>
					</div>
				</div>

				<div class="order-d-footer">
					<script src="https://checkout.stripe.com/checkout.js" ></script>
					<div class="paypal-btn">
						<form id="payform" onsubmit="checkorder(); return false;" action="<?php the_permalink(); ?>" method="get">
							<input type="hidden" id="amt" name="amount" value="<?=$price_follower?>">
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
							<img src="<?php echo plugins_url( '../image/follower.png', __FILE__ );?>" alt="follower">
						 	<span>Current Followers</span>
						 	<span><?php echo $_SESSION["byline"]; ?></span>
						</div>
						<div class="post">
							<img src="<?php echo plugins_url( '../image/profile-check.png', __FILE__ );?>" alt="follower">
						 	<span>Profile Check</span>
							<span>COMPLETE</span>
						</div>	
						<span class="delivery">Delivery: Starts instantly</span>
					</div>

					<div class="check_status">
						<h4 id="status_text">
						Please choose the picture(s) below (max 8):<br>
						<span style="font-style:italic;color:#ADADAD;" class="multiple_status1">Selected: <span id="multiple_status1">0</span></span><br>
						<span style="font-style:italic;color:#ADADAD;" class="multiple_status2">Likes per image: <span id="multiple_status2"><?php echo $num_follower; ?></span></span></h4>
					</div>
					<div class="all_images" id="media_list">
						<input type="hidden" id="follower" value="<?php echo $num_follower;?>">	

						<?php
							$count=0;
							foreach ($posts['nodes'] as $key => $value) {

								if( $count > 5 ) continue;
								
								$thumbnail = $value['thumbnail_src'];
								$code = $value['code'];
								$typename = $value['__typename'];
						?>
								<div id="form_<?=$code?>" class="inactiveselect" onclick="select_code('<?=$code?>',<?php echo $num_follower;?>)" style="cursor: pointer;">
									<img src="<?=$thumbnail?>">
									<span class="p_num"><?php if(!$value['is_video']){ echo $value['likes']['count']; }else { echo $value['video_views']; }?></span>
								</div>
						<?php
								$count++;
							}

						?>

						<?php/* $count=0; foreach ($posts as $item) {  if($count<=5){?>

						<div id="form_<?php echo $item['code'];?>" class="inactiveselect" onclick="select_code('<?php echo $item['code'];?>',<?php echo $num_follower;?>)" style="cursor: pointer;">
							<img src="<?php echo $item['images']['thumbnail']['url'];?>">
							<span class="p_num"><?php if($item['type']=='image'){ echo $item['likes']['count']; }else { echo $item['video_views']; }?></span>
						</div>

					<?php $count=$count+1; } }*/
					?>

					</div>

					<div class="load_more">
						<div id="laoding" style="display: none;"><img src="<?php echo plugins_url( '../image/loading.gif', __FILE__ );?>"></div>
						<button onclick="load_more();">Load more</button>
					</div>

				</div>
			<div class="images likes">

				<div class="stripe">
					<img src="<?php echo plugins_url( '../image/stripe-secure-payment.png', __FILE__ );?>">

				</div>

				<!--  <div class="top">
				<div class="left"><img src="<?php echo plugins_url( '../image/pay-pal-secured.jpg', __FILE__ );?>"></div>

				<div class="credits"><img src="<?php echo plugins_url( '../image/visas-image.jpg', __FILE__ );?>"></div>		           					           		 
				</div> -->


				<div class="bottom">
					<div class="secure"><img src="<?php echo plugins_url( '../image/100-secure.png', __FILE__ );?>"></div>
					<div class="img-1"><img src="<?php echo plugins_url( '../image/bbb_logo.png', __FILE__ );?>"></div>
					<div class="img-2"><img src="<?php echo plugins_url( '../image/norton.png', __FILE__ );?>"></div>
				</div>

			</div>
		</div>
	</div>
</div>