<?php
if(is_plugin_active('paymaster/paymaster.php') && get_option('gmgt_paymaster_pack')=="yes"){
	$payment_method = get_option('pm_payment_method');
}
else{
	$payment_method = 'Paypal';
}

$obj_membership=new MJ_gmgt_membership;



$obj_activity=new MJ_gmgt_activity;



// $current_theme = get_current_theme();



$current_theme = wp_get_theme();


if((isset($_REQUEST['method'])) && ($_REQUEST['method'] == 'razorpay') && ($_REQUEST['where_payment'] == 'front_end'))
{
	$customer_id = $_REQUEST['customer_id'];
	$pay_id = $_REQUEST['payment_id'];
	$amount = $_REQUEST['amount'];
	$payment_type = 'Payment';
	$action = 'front_end';
	$coupon_id = $_REQUEST['coupon_id'];
	$payment_method = 'Razorpay';
	$type = '';
	$payment_result = MJ_gmgt_generate_membership_end_income_invoice_with_payment_online_payment($customer_id,$pay_id,$amount,$payment_type,$action,$payment_method,$coupon_id,$type);
	if($payment_result)
	{
		if(isset($_REQUEST['action'])&& $_REQUEST['action']=='frontend_book')
		{
			wp_redirect(home_url('class-booking')."?action=success&result=".$_REQUEST['result']);
			die();
		}
		else{
			wp_redirect(home_url() .'/?action=payment_success_message');
			die();
		}
		
	}
}	

if($current_theme == 'Twenty Twenty-Two' || $current_theme == 'Twenty Twenty-Three')



{



	?>



	<style>



		.wpgym-detail-box{



			position: absolute;



			top: 45%;



			width: 100%;



			text-align: -webkit-center;



		}



		footer



		{



			margin-top:10% !important;



		}



		.wp-site-blocks .wp-block-group .wp-block-post-title{



			margin-bottom: 0 !important;



		}



		.wp-block-group .alignwide{



			padding-bottom: 0 !important;



			padding-top: 0 !important;



		}



		#membership_buy_form



		{



			width: 40% !important;



		}



		#membership_buy_form table tbody tr th



		{



			border: 1px solid #eee !important;



			padding: 5px;



			float: left;



		}



		#membership_buy_form table tbody tr td



		{



			border: 1px solid #eee !important;



		}



		#membership_buy_form table



		{



			width: 100%;



			border: 0px solid #eee;



		}



	</style>



	<?php



}



if($current_theme == 'Twenty Twenty')



{



	?>



	<style>



		.wpgym-detail-box{



			position: absolute;



			top: 45%;



			width: 100%;



			text-align: -webkit-center;



		}



		footer



		{



			margin-top:10% !important;



		}



		.wp-site-blocks .wp-block-group .wp-block-post-title{



			margin-bottom: 0 !important;



		}



		.wp-block-group .alignwide{



			padding-bottom: 0 !important;



			padding-top: 0 !important;



		}



	</style>



	<?php



}



?>



<script type="text/javascript" src="<?php echo GMS_PLUGIN_URL.'/assets/js/jquery_3.6.0.js';?>">



</script>



<script type="text/javascript" src="<?php echo GMS_PLUGIN_URL.'/assets/js/jquery-ui-1.12.1.min.js';?>">



</script>



<link rel="stylesheet"	href="<?php echo GMS_PLUGIN_URL.'/assets/css/jquery-ui.css';?>">



<div class="membership_payment_custom_div" >



	<?php



	



	if(isset($_REQUEST['membership_id']))



	{		



		$retrieved_data=$obj_membership->MJ_gmgt_get_single_membership($_REQUEST['membership_id']);



	}



	else



	{



		$lable=esc_html__("Membership not selected.","gym_mgt");



		echo '<span style="margin-left: 7%;"> '.$lable.' </span>';



	}



	?>



</div>



<?php



//BUY MEMBERSHIP PAYMENT USING Stripe //



if(isset($_POST['buy_confirm_stripe']))



{	



	$obj_member=new MJ_gmgt_member; 



	$payment ="no";



	if (! is_user_logged_in ()) 



	{



		if(isset($_POST['member_id']))



		{



			$payment = "yes";	



		}



		else



		{		



			$page_id = get_option ( 'gmgt_login_page' );



			wp_redirect ( home_url () . "?page_id=" . $page_id);



		}



	}



	else



	{



		$payment = "yes";		



	}



	if($payment=="yes")



	{



		//Session Unset



		if(isset($_SESSION["action_frontend"]))



		{



			unset($_SESSION["action_frontend"]);



			unset($_SESSION["class_id1"]);



			unset($_SESSION["day_id1"]);



			unset($_SESSION["class_date"]);



			unset($_SESSION["Remaining_Member_limit_1"]);



			unset($_SESSION["bookedclass_membershipid"]);



		} 



		//store URL Parameter To session



		if(isset($_REQUEST['action'])&& $_REQUEST['action']=='frontend_book')



		{	



			//setcookie("action_frontend", $_REQUEST['action'], time()+86400,httponly:true,samesite='strict');



			setcookie("action_frontend", $_REQUEST['action'], time()+86400);



			setcookie("class_id1", $_REQUEST['class_id1'], time()+86400);



			setcookie("day_id1", $_REQUEST['day_id1'],time()+86400);



			setcookie("startTime_1", $_REQUEST['startTime_1'], time()+86400);



			setcookie("class_date", $_REQUEST['class_date'], time()+86400);



			setcookie("Remaining_Member_limit_1", $_REQUEST['Remaining_Member_limit_1'], time()+86400);



			setcookie("bookedclass_membershipid", $_REQUEST['bookedclass_membershipid'], time()+86400);







		}



		require_once GMS_PLUGIN_DIR. '/lib/stripe/index.php';



	}



}



//BUY MEMBERSHIP PAYMENT



if(isset($_POST['buy_confirm_paypal']))



{	



	$obj_member=new MJ_gmgt_member; 



	$payment ="no";



	if (! is_user_logged_in ()) 



	{



		if(isset($_POST['member_id']))



		{



			$payment = "yes";	



		}



		else



		{		

			$page_id = get_option ( 'gmgt_login_page' );

			wp_redirect ( home_url () . "?page_id=" . $page_id);

		}

	}



	else



	{



		$payment = "yes";		



	}



	if($payment=="yes")



	{



		//Session Unset



		if(isset($_SESSION["action_frontend"]))



		{



			unset($_SESSION["action_frontend"]);



			unset($_SESSION["class_id1"]);



			unset($_SESSION["day_id1"]);



			unset($_SESSION["class_date"]);



			unset($_SESSION["Remaining_Member_limit_1"]);



			unset($_SESSION["bookedclass_membershipid"]);



		} 



		//store URL Parameter To session



		if(isset($_REQUEST['action'])&& $_REQUEST['action']=='frontend_book')



		{	



			setcookie("action_frontend", $_REQUEST['action'], time()+86400);



			setcookie("class_id1", $_REQUEST['class_id1'], time()+86400);



			setcookie("day_id1", $_REQUEST['day_id1'],time()+86400);



			setcookie("startTime_1", $_REQUEST['startTime_1'], time()+86400);



			setcookie("class_date", $_REQUEST['class_date'], time()+86400);



			setcookie("Remaining_Member_limit_1", $_REQUEST['Remaining_Member_limit_1'], time()+86400);



			setcookie("bookedclass_membershipid", $_REQUEST['bookedclass_membershipid'], time()+86400);







		}



		



		



		if($payment_method == "Skrill")



		{



			require_once PM_PLUGIN_DIR. '/lib/skrill/skrill.php';



		}



		elseif($payment_method == "Stripe")



		{



			require_once PM_PLUGIN_DIR. '/lib/stripe/index.php';



		}



		elseif($payment_method == "Instamojo")



		{



			require_once PM_PLUGIN_DIR. '/lib/instamojo/instamojo.php';



		}



		elseif($payment_method == "PayUMony")



		{



			require_once PM_PLUGIN_DIR. '/lib/OpenPayU/index.php';



		}



		elseif($payment_method == "2CheckOut")



		{



			require_once PM_PLUGIN_DIR. '/lib/2checkout/index.php';



		}



		elseif($payment_method == "iDeal")



		{



			require_once PM_PLUGIN_DIR. '/lib/ideal/ideal.php';



		}



		elseif($payment_method == 'Paystack')



		{



			require_once PM_PLUGIN_DIR. '/lib/paystack/paystack.php';



		}



		elseif($payment_method == 'paytm')



		{



			require_once PM_PLUGIN_DIR. '/lib/PaytmKit/index.php';



		}



		elseif($payment_method == 'razorpay')



		{



			require_once PM_PLUGIN_DIR. '/lib/razorpay/index.php';



		}



		else



		{



			require_once GMS_PLUGIN_DIR. '/lib/paypal/buy_membership_process.php';



		}



	}



}







if(!empty($retrieved_data))



{ 



$tax_amount=MJ_gmgt_get_membership_tax_amount($retrieved_data->membership_id,'');



?>



	<style>



		.margin_top_15



		{



			margin-top:15px;



		}



		.wpgym-box-title .wpgym-membershiptitle {



			font-size: 30px !important;



			font-weight: 700 !important;



			color: #333333 !important;



			font-family: "poppins" !important;



		}



		.entry-content tr th,.entry-content tr td, body.et-pb-preview #main-content .container tr td {



			/* border-top: 1px solid #eee; */



			padding: 6px 24px;



		}



		.fronted_payment_button {



			border-radius: 28px;



			padding: 5px 20px;



			background-color: #014D67;



			border: 0px;



			color: #ffffff;



			font-size: 20px;



			text-transform: uppercase;



		}



		.margin_top_2



		{



			margin-top: 2% !important;



			border: 1px solid #eee;



		}



		#membership_buy_form



		{



			border: 1px solid;



			padding: 10px;



		}



		tr.highlighter {



			background-color: #ba170b;



			color: #ffffff;



		}



	</style>



		<?php



		



		if($current_theme != 'Twenty Twenty-Two' || $current_theme != 'Twenty Twenty-Three')



		{



			?>



			<style>



				.membership_payment_main_div_frontend_page



				{



					margin-top: 10%;



				}



			</style>



			<?php



		}



		



		?>



		<style>



			.post-inner



			{



				padding-top: 30rem !important;



			}



			.entry-content



			{



				max-width: 58rem;



				width: calc(100% - 4rem);



				margin: auto;



			}



			.save_btn



			{



				background-color: #ba170b !important;



			}



		</style>



	<?php



	if($current_theme == 'Twenty Twenty-Two')



	{



		?>







			<style>







			.membership_payment_main_div_frontend_page







			{







				margin-top: 0%;







			}



			.wp-block-spacer{



				height: 70px !important;



			}



			</style>



			<?php



	}



	if($current_theme == 'Twenty Twenty-One Child')



	{



		?>



		<style>



			.wpgym-detail-box{



				background-color: #ffff!important;



			}



			.membership_payment_main_div_frontend_page {



				margin-top: 5%;



			}



		</style>



		<?php



	}



	?>



	<?php



	if($current_theme == 'Twenty Twenty-One Child')



	{



		if(!empty(get_custom_logo()))



		{



			echo get_custom_logo();



		}



		else



		{



			?>



			<span class="custom-logo-link">



				<img width="400" height="99" src="<?php  echo get_option( 'gmgt_system_logo' ); ?>" class="custom-logo" alt="">



			</span>







			<?php



		}



	}



	?>



	<div class="wpgym-detail-box col-md-12 wpgym_details_box membership_payment_main_div_frontend_page" ><!--WP GYM DETAIL BOX START--> 



		<div class="wpgym-border-box"><!--WP GYM BORDER BOX START--> 



			<form name="membership_buy_form" id="membership_buy_form" method="post" action=""><!--BUY MEMBERSHIP FORM START--> 



				<div class="wpgym-box-title">



					<span class="wpgym-membershiptitle">



						<?php echo esc_html($retrieved_data->membership_label);?>



					</span>



				</div>



				<div class="wpgym-course-lession-list">				



				</div>



				<?php



					$singup=($retrieved_data->signup_fee);



					$amount_member=($retrieved_data->membership_amount);

					

					if(!empty($_REQUEST['coupon_id'])){

						

						$discount_amount = get_discount_amount_by_membership_id($_REQUEST['membership_id'],$_REQUEST['coupon_id'],'');

						

						$tax_amount = MJ_gmgt_after_discount_tax_amount_by_membership_id($_REQUEST['membership_id'],$_REQUEST['coupon_id'],'');



						$totel_Amount= $singup + $amount_member - $discount_amount + number_format($tax_amount,2);



					}



					else



					{



						$discount_amount = '0';



						$tax_amount=MJ_gmgt_get_membership_tax_amount($retrieved_data->membership_id,'');



						$totel_Amount= $singup + $amount_member + number_format($tax_amount,2);



					}



					?>



				<table class="margin_top_2">



					<tbody>



					<tr>	



						<th><?php esc_html_e('Membership Period','gym_mgt');?></th>



						<td><?php echo esc_html($retrieved_data->membership_length_id).' '.esc_html__('Days','gym_mgt');?></td>



					</tr>					



					<tr>	



						<th><?php esc_html_e('Membership Price','gym_mgt');?></th>



						<td><?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ))."".esc_html($retrieved_data->membership_amount);?></td>



					</tr>	



					<tr>	



						<th><?php esc_html_e('Singup Fee','gym_mgt');?></th>



						<td>+&nbsp;<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ))."".esc_html($retrieved_data->signup_fee);?></td>



					</tr>



					<tr>	



						<th><?php esc_html_e('Discount Amount','gym_mgt');?></th>



						<td>-&nbsp;<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ))."".esc_html($discount_amount);?></td>



					</tr>



					<tr>	



						<th><?php esc_html_e('Tax Amount','gym_mgt');?></th>



						<td>+&nbsp;<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ))."".esc_html($tax_amount);?></td>



					</tr>	



					</tbody>



				</table>



				<input type="hidden" name="amount" value="<?php echo esc_attr($totel_Amount); ?>">



				<input type="hidden" name="member_id" value="<?php if(isset($_REQUEST['user_id'])){ echo esc_attr($_REQUEST['user_id']);} else { echo get_current_user_id(); }?>">



				<input type="hidden" name="mp_id" value="<?php echo esc_attr($retrieved_data->membership_id);?>">



				<input type="hidden" name="coupon_id" value="<?php echo esc_attr($_REQUEST['coupon_id']);?>">



				<input type="hidden" name="stripe_plan_id" value="<?php echo esc_attr($retrieved_data->stripe_plan_id);?>">



				<input type="hidden" name="where_payment" value="front_end">



				<?php



				$gym_recurring_enable=get_option("gym_recurring_enable");



				$gmgt_one_time_payment_setting=get_option("gmgt_one_time_payment_setting");
				if(is_plugin_active('paymaster/paymaster.php') && get_option('gmgt_paymaster_pack')=="yes"){
					?>
	
	
	
					<input type="submit" name="buy_confirm_paypal" value="<?php echo esc_html__('Pay By','gym_mgt').' '.esc_attr($payment_method);?>" class="save_btn margin_top_15 fronted_payment_button">



				<?php
				}
				else
				{
					if($gym_recurring_enable == "yes" || $gmgt_one_time_payment_setting == '1')

					{
	
	
	
					?>
	
	
	
						<input type="submit" name="buy_confirm_stripe" value="<?php echo esc_html__('Pay By Stripe','gym_mgt');?>" class="save_btn margin_top_15 fronted_payment_button" style="border-radius: 20px;">
	
	
	
					<?php
	
	
	
					}
	
	
	
					else
	
	
	
					{
						?>
	
	
	
						<input type="submit" name="buy_confirm_paypal" value="<?php echo esc_html__('Pay By Paypal','gym_mgt');?>" class="save_btn margin_top_15 fronted_payment_button" style="border-radius: 20px;">
	
	
	
					<?php
	
					}
				}


				



				?>



				&nbsp;



				<span style="font-weight: 700;"><?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ))."".$totel_Amount;?></span>



						



			</form><!--BUY MEMBERSHIP FORM END--> 



		</div>	<!--WP GYM BORDER BOX END--> 



	</div><!--WP GYM DETAIL BOX END--> 



	<?php 



} 



?>