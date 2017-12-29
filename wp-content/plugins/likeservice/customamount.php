<?php session_start();
/**
 * @package WordPress
 * @subpackage NorthVantage
*/
	get_header(); 

?>

<?php if(isset($_GET['customgateshop']) && isset($_GET['amount']) && isset($_GET['username']))
	{
			global $wpdb;
			$url='https://www.instagram.com/'.$_GET['username'].'/';
			$process='custom';
			$amount=$_GET['amount'];


			$sql="INSERT INTO createorder (link,process,status,code) VALUES ('$url','$process',0,'$amount')";
            $wpdb->query($sql);
            $lastid = $wpdb->insert_id;



		
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
	else
	{
		?>


	<div class="Order_detail main1">
		     <div class="enter-order-deatil">
		  
		   
		  

		            <div class="">
		           <div class="order-headings">

		         <h2>Your Custom Order</h2>

		     	</div>




		           <div class="left-inner">  
		           		<?php if(isset($_GET['e']) ){ ?> 
		           		 <span class="error">Invalid Instagram username.</span> 

		           		 <?php } ?>
			           	
		           	<form  class="details-order-form" action="">

		           	<div class="input-field-here">		
		               <input required class="insta-feild" type="text" name="username" placeholder="Enter Username">
		               <span class="insta"><img src="<?php echo plugins_url( '/image/insta-icon.jpg', __FILE__ );?>"></span>
		               <span>Please enter your username without the @</span>
		            </div> 

		            <div class="input-field-here">		
		               <input required class="insta-feild" type="text" name="amount" placeholder="Enter Amount">
		               <span class="insta"><img width="33" height="33" src="<?php echo plugins_url( '/image/dollar.jpg', __FILE__ );?>"></span>
		               <span>Please enter your custom amount</span>
		            </div>
		               
		                <div class="next-button-div">
		                 <input type="hidden" name="customgateshop" value="1">
		               		<button type="submit" id="customButton">CONTINUE</button>
		           		</div>
		               </form>
		           </div>
		       </div>
		   </div>
		   </div>


<?php
	}
	// echo "\n\t\t". '<div class="clear"></div>';
	// echo "\n\t". '</div><!-- #content -->';	
	//call the wp foooter
	get_footer();
?>
