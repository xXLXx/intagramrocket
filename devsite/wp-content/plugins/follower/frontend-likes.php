<?php 

	session_start();

	get_header(); 

	global $wpdb;

	$process = "likes";
	$dir = plugin_dir_path( __FILE__ );

	$returnurl = get_site_url().'/buy-real-likes/';
	$subscriptionURL = get_site_url().'/likes?subscription=' . $_GET['subscription'];
	include($dir . "purchase.process.php");

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
					if(totalselect<=7)
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
						alert('Already Select Eight Images');
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
	            url: 'https://www.instagramrocket.com/devsite/wp-content/plugins/follower/callmore.php',
	            data: {username: username,getmorepost: 1}, 
	            type: 'GET',
	            dataType: 'json',
	            error: function(xhr, status, error) {
	               console.log(xhr);
	               console.log(status);
	               console.log(error);
	            },
	            success: function(jsonp) { 
	            	// var arr = jQuery.parseJSON(jsonp);

	            	var counts=0;

			jQuery.each(jsonp.nodes, function(idx, v) {


				
					if(v.__typename=='GraphImage')
					{
					  

					  var img='<img src="'+v.thumbnail_src+'"><span class="p_num">'+v.likes.count+'</span>';
					}
					else
					{
					  
					     var img='<img src="'+v.thumbnail_src+'"><span class="p_num">'+v.video_views+'</span>';
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

						document.getElementById('customButton').addEventListener('click', function(e) {




							if(totalselect<=0)
							{
								alert('Please choose one of the image');
								return false;
							}
							else
							{

								/*   var ammt=jQuery('#amt').val();

									
								  // Open Checkout with further options:
								  handler.open({
								    name: 'Instarocket',
								    description: '',
								    amount: ammt*100
								  });
								  e.preventDefault();*/

							}
						});

						// Close Checkout on page navigation:
						window.addEventListener('popstate', function() {
		
						  handler.close();
						});


 </script>
<?php
	get_footer();
?>