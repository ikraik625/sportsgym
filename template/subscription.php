<?php $curr_user_id=get_current_user_id();

$obj_gym=new MJ_gmgt_Gym_management($curr_user_id);

$obj_membership_payment=new MJ_gmgt_membership_payment;

$obj_membership=new MJ_gmgt_membership;

$active_tab = isset($_GET['tab'])?$_GET['tab']:'subscription_list';

//access right

$user_access=MJ_gmgt_get_userrole_wise_page_access_right_array();

// if (isset ( $_REQUEST ['page'] ))

// {	

// 	if($user_access['view']=='0')

// 	{	

// 		MJ_gmgt_access_right_page_not_access_message();

// 		die;

// 	}

// }

if(isset($_POST['change_subscription_for_exsting_member']))

{

	$retrieved_data=$obj_membership->MJ_gmgt_get_single_membership($_POST['selected_membership']);

	$payment_type="change_subscription_for_exsting_member";

	$secret_key=get_option('gmgt_stripe_secret_key');

	$publisable_key=get_option('gmgt_stripe_publishable_key');

	$system_name =  get_option('gmgt_system_name');	

	$system_logo =  get_option('gmgt_system_logo');

	$currency =  get_option('gmgt_currency_code');

	$description = "Membership Payment";

	$fornt_end="fornt_end";

	?>

	<form action="<?php print GMS_PLUGIN_URL.'/lib/stripe/charge.php'; ?>" method="POST"> 

		<input type="hidden" name="amount" value="<?php print $retrieved_data->membership_amount ?>">

		<input type="hidden" name="pay_id" value="<?php print $retrieved_data->membership_id ?>">

		<input type="hidden" name="stripe_plan_id" value="<?php print $retrieved_data->stripe_plan_id ?>">

		<input type="hidden" name="where_payment" value="<?php print isset($fornt_end)?$fornt_end:'' ?>">

		<input type="hidden" name="secret_key" value="<?php print $secret_key ?>">

		<input type="hidden" name="payment_type" value="<?php print $payment_type ?>">

		<input type="hidden" name="data_user" value="<?php print $_POST['member_id'] ?>">

		<input type="hidden" name="subscription_id" value="<?php print $_POST['subscription_id'] ?>">

		<input type="hidden" name="sub_id" value="<?php print $_POST['sub_id'] ?>">

		<script src="//code.jquery.com/jquery-2.0.2.min.js"></script>

		<script

			src="https://checkout.stripe.com/checkout.js" class="stripe-button"

			data-key="<?php print $publisable_key; ?>" // your publishable keys

			data-image="<?php print $system_logo ?>" // your company Logo

			data-name="<?php print $system_name ?>"

			data-description="<?php print $description ?>"

			data-currency="<?php print $currency ?>"

			data-locale="auto"

			data-amount="<?php print $amount*100; ?>" 

			data-user="<?php print $data_user; ?>">



  		</script>

		<script>

			$(function(){

				$(".stripe-button-el").css("display","none");



				$(".stripe-button-el").get(0).click();

			});

		</script>

	</form>

	<?php

}

if (isset ( $_REQUEST ['action'] ) && $_REQUEST ['action'] == "cancle_subscription")

{

	

	$pay_id=esc_attr($_REQUEST['membership_id']);

	$id=esc_attr($_REQUEST['id']);

	$stripe_subscription_id=$_REQUEST['subscription_id'];

	$stripe_customer_id=$_REQUEST['stripe_customer_id'];

	

	$customer_id=esc_attr($_REQUEST['member_id']);

	$check_membership_recurring_option= MJ_gmgt_check_membership_recurring_option($pay_id);

	

	$gym_recurring_enable=get_option("gym_recurring_enable");



	if($gym_recurring_enable == "yes" && !empty($stripe_subscription_id) && $check_membership_recurring_option == "yes")

	{

		//------------ MEMBERSHIP RECURRING PAYEMNT ----------//

		try 

		{	 

			require_once GMS_PLUGIN_DIR . '/lib/stripe/init.php';

			require_once  GMS_PLUGIN_DIR .'/lib/stripe/lib/Stripe.php';

			

			$gmgt_stripe_product_id=get_option("gmgt_stripe_product_id");

			$gmgt_stripe_secret_key=get_option("gmgt_stripe_secret_key");

			

			$stripe = new \Stripe\StripeClient(

				$gmgt_stripe_secret_key

			);

			

			$subscription=$stripe->subscriptions->cancel(

				$stripe_subscription_id,

				[]

			);

			$subsData = $subscription->jsonSerialize();

			

			if($subsData['status'] == 'canceled')

			{ 

				global $wpdb;

				//invoice number generate

				$table_gmgt_member_subscriptions_details=$wpdb->prefix.'gmgt_member_subscriptions_details';

				$whereid['id']=$id;

				$subscription_data['stripe_subscription_id']=$subsData['id'];

				$subscription_data['subscription_status']= $subsData['status']; 

				$subscription_data['membership_status']= 'Expired';

				$subscription_data['updated_date'] =date("Y-m-d H:i:s"); 

				$result=$wpdb->update( $table_gmgt_member_subscriptions_details,$subscription_data,$whereid); 

				if($result)

				{

					wp_safe_redirect(home_url()."?dashboard=user&page=subscription&message=1" );

				}

			}

			

		}catch(\Stripe\Error\Card $e) {

			//var_dump($e);

			//die;

		// Since it's a decline, \Stripe\Error\Card will be caught

		$body = $e->getJsonBody();

		$err  = $body['error'];

		

		print('Status is:' . $e->getHttpStatus() . "\n");

		print('Type is:' . $err['type'] . "\n");

		print('Code is:' . $err['code'] . "\n");

		// param is '' in this case

		print('Param is:' . $err['param'] . "\n");

		print('Message is:' . $err['message'] . "\n");

		} catch (\Stripe\Error\RateLimit $e) {

			//var_dump($e);

			//die;

		// Too many requests made to the API too quickly

		} catch (\Stripe\Error\InvalidRequest $e) {

			//var_dump($e);

			//die;

		// Invalid parameters were supplied to Stripe's API

		} catch (\Stripe\Error\Authentication $e) {

			//var_dump($e);

			//die;

		// Authentication with Stripe's API failed

		// (maybe you changed API keys recently)

		} catch (\Stripe\Error\ApiConnection $e) {

			//var_dump($e);

			//die;

		// Network communication with Stripe failed

		} catch (\Stripe\Error\Base $e) {

			//var_dump($e);

			//die;

		// Display a very generic error to the user, and maybe send

		// yourself an email

		} catch (Exception $e) {

			//var_dump($e);

			//die;

		// Something else happened, completely unrelated to Stripe

		}

	}

	

}

if (isset ( $_REQUEST ['action'] ) && $_REQUEST ['action'] == "start_subscription")

{

	$pay_id=$_REQUEST['membership_id'];

	$stripe_plan_id=$_REQUEST['stripe_plan_id'];

	$stripe_customer_id=$_REQUEST['stripe_customer_id'];

	$customer_id=$_REQUEST['member_id'];

	$check_membership_recurring_option= MJ_gmgt_check_membership_recurring_option($pay_id);

	$gym_recurring_enable=get_option("gym_recurring_enable");

	if($gym_recurring_enable == "yes" && !empty($stripe_plan_id) && $check_membership_recurring_option == "yes")

	{	

		//------------ MEMBERSHIP RECURRING PAYEMNT ----------//

		try {	 

			require_once GMS_PLUGIN_DIR . '/lib/stripe/init.php';

			require_once  GMS_PLUGIN_DIR .'/lib/stripe/lib/Stripe.php';

			

			$gmgt_stripe_product_id=get_option("gmgt_stripe_product_id");

			$gmgt_stripe_secret_key=get_option("gmgt_stripe_secret_key");

			

			\Stripe\Stripe::setApiKey($gmgt_stripe_secret_key);

			

			$subscription=\Stripe\Subscription::create([

			'customer' => $stripe_customer_id,

			'items' => 

				[

					['price' => $stripe_plan_id],

				],

			]);

			$subsData = $subscription->jsonSerialize();

			/* var_dump($subsData);

			die; */

			if($subsData['status'] == 'active')

			{ 

				

					$obj_membership_payment=new MJ_gmgt_membership_payment;

					$obj_membership=new MJ_gmgt_membership;	

					$obj_member=new MJ_gmgt_member;

					

					$trasaction_id  = '';

					

					$joiningdate=date("Y-m-d");

					$membership=$obj_membership->MJ_gmgt_get_single_membership($pay_id);

					

					$validity=$membership->membership_length_id;

					

					$expiredate= date('Y-m-d', strtotime($joiningdate. ' + '.$validity.' days'));

					$membership_status = 'continue';

					$payment_data = array();

					$membershippayment=$obj_membership_payment->MJ_gmgt_checkMembershipBuyOrNot($customer_id,$joiningdate,$expiredate);

				

					/* if(!empty($membershippayment))

					{

						global $wpdb;

						$table_gmgt_membership_payment=$wpdb->prefix.'Gmgt_membership_payment';

						$payment_data['payment_status'] = 0;

						$whereid['mp_id']=$membershippayment->mp_id;

						$wpdb->update( $table_gmgt_membership_payment, $payment_data ,$whereid);

						$plan_id =$membershippayment->mp_id;

					}

					else

					{ */

						global $wpdb;

						//invoice number generate

						$table_income=$wpdb->prefix.'gmgt_income_expense';

						$result_invoice_no=$wpdb->get_results("SELECT * FROM $table_income");						

						

						if(empty($result_invoice_no))

						{							

							$invoice_no='00001';

						}

						else

						{							

							$result_no=$wpdb->get_row("SELECT invoice_no FROM $table_income where invoice_id=(SELECT max(invoice_id) FROM $table_income)");

							$last_invoice_number=$result_no->invoice_no;

							$invoice_number_length=strlen($last_invoice_number);

							

							if($invoice_number_length=='5')

							{

								$invoice_no = str_pad($last_invoice_number+1, 5, 0, STR_PAD_LEFT);

							}

							else	

							{

								$invoice_no='00001';

							}				

						}

								

						$payment_data['invoice_no']=$invoice_no;

						$payment_data['member_id'] = $customer_id;

						$payment_data['membership_id'] = $pay_id;

						$payment_data['membership_amount'] = MJ_gmgt_get_membership_price($pay_id);

						$payment_data['membership_fees_amount'] = MJ_gmgt_get_membership_price($pay_id);

						$payment_data['start_date'] = $joiningdate;

						$payment_data['end_date'] = $expiredate;

						$payment_data['membership_status'] = $membership_status;

						$payment_data['payment_status'] ="Fully Paid";

						$payment_data['created_date'] = date("Y-m-d");

						$payment_data['created_by'] = $customer_id;

						$plan_id = $obj_member->MJ_gmgt_add_membership_payment_detail($payment_data);

						

						//save membership payment data into income table							

						$membership_name=MJ_gmgt_get_membership_name($pay_id);

						$entry_array[]=array('entry'=>$membership_name,'amount'=>MJ_gmgt_get_membership_price($pay_id));	

						$incomedata['entry']=json_encode($entry_array);	

						

						$incomedata['invoice_type']='income';

						$incomedata['invoice_label']=__("Fees Payment","gym_mgt");

						$incomedata['supplier_name']=$customer_id;

						$incomedata['invoice_date']=date('Y-m-d');

						$incomedata['receiver_id']=$customer_id;

						$incomedata['amount']=MJ_gmgt_get_membership_price($pay_id);

						$incomedata['total_amount']=MJ_gmgt_get_membership_price($pay_id);

						$incomedata['invoice_no']=$invoice_no;

						$incomedata['paid_amount']=MJ_gmgt_get_membership_price($pay_id);

						$incomedata['payment_status']='Fully Paid';

						$result_income=$wpdb->insert( $table_income,$incomedata); 

					//}

					$feedata['mp_id']=$plan_id;

					//$feedata['memebership_id']=$_POST['custom'];

					$feedata['amount']=MJ_gmgt_get_membership_price($pay_id);

					$feedata['payment_method']='Stripe';		

					$feedata['trasaction_id']='';

					$feedata['payment_description']='Recurring Membership Payment';

					$feedata['created_by']=$customer_id;

					$result=$obj_membership_payment->MJ_gmgt_add_feespayment_history($feedata);

					global $wpdb;

					//invoice number generate

					$table_gmgt_member_subscriptions_details=$wpdb->prefix.'gmgt_member_subscriptions_details';

					$member_id['member_id']=$customer_id;

					$subscription_data['membership_id']=$pay_id;

					$subscription_data['payment_method']='Stripe';		

					$subscription_data['stripe_subscription_id']=$subsData['id'];

					$subscription_data['stripe_customer_id']=$subsData['customer'];

					$subscription_data['stripe_plan_id']=$subsData['plan']['id']; 

					$subscription_data['payer_email']=$_POST['stripeEmail']; 

					$subscription_data['subscription_status']= $subsData['status']; 

					$subscription_data['membership_status']= 'continue';

					$subscription_data['plan_amount'] = ($subsData['plan']['amount']/100); 

					$subscription_data['plan_amount_currency'] = $subsData['plan']['currency']; 

					$subscription_data['plan_period_start'] =date("Y-m-d H:i:s", $subsData['current_period_start']); 

					$subscription_data['plan_period_end'] =date("Y-m-d H:i:s", $subsData['current_period_end']); 

					$subscription_data['updated_date'] =date("Y-m-d H:i:s"); 

					$result=$wpdb->update( $table_gmgt_member_subscriptions_details,$subscription_data,$member_id); 

					if($result)

					{

						wp_safe_redirect(home_url()."?dashboard=user&page=subscription&message=2" );

					}

			}

		}catch(\Stripe\Error\Card $e) {

			var_dump($e);

			//die;

		// Since it's a decline, \Stripe\Error\Card will be caught

		$body = $e->getJsonBody();

		$err  = $body['error'];

		

		print('Status is:' . $e->getHttpStatus() . "\n");

		print('Type is:' . $err['type'] . "\n");

		print('Code is:' . $err['code'] . "\n");

		// param is '' in this case

		print('Param is:' . $err['param'] . "\n");

		print('Message is:' . $err['message'] . "\n");

		} catch (\Stripe\Error\RateLimit $e) {

			var_dump($e);

			//die;

		// Too many requests made to the API too quickly

		} catch (\Stripe\Error\InvalidRequest $e) {

			var_dump($e);

			//die;

		// Invalid parameters were supplied to Stripe's API

		} catch (\Stripe\Error\Authentication $e) {

			var_dump($e);

			//die;

		// Authentication with Stripe's API failed

		// (maybe you changed API keys recently)

		} catch (\Stripe\Error\ApiConnection $e) {

			var_dump($e);

			//die;

		// Network communication with Stripe failed

		} catch (\Stripe\Error\Base $e) {

			var_dump($e);

			//die;

		// Display a very generic error to the user, and maybe send

		// yourself an email

		} catch (Exception $e) {

			var_dump($e);

			//die;

		// Something else happened, completely unrelated to Stripe

		}

	}

}

if(isset($_REQUEST['message']))

{

	$message =esc_attr($_REQUEST['message']);

	if($message == 1)

	{?>

		<div id="message" class="updated below-h2 ">

			<p><?php esc_html_e('Subscription cancle successfully, You can use our system till membership end date','gym_mgt');?></p>

		</div>

		<?php 		

	}

	elseif($message == 2)

	{?>

		<div id="message" class="updated below-h2 ">

			<p><?php esc_html_e("Subscription Start successfully.",'gym_mgt');?></p>

		</div>

	<?php

	}

	elseif($message == 3) 

	{?>

		<div id="message" class="updated below-h2">

			<p><?php esc_html_e('Subscription Change successfully.','gym_mgt');?></p>

		</div>

	<?php		

	}

}

?>

<script type="text/javascript">

$(document).ready(function() 

{

	"use strict";

	jQuery('#subscription_list').DataTable({

		// "responsive": true,

		dom: 'lifrtp',

		"order": [[ 0, "asc" ]],

		"aoColumns":[

	                {"bSortable": false},

					{"bSortable": true},

					{"bSortable": true},

					{"bSortable": true},

					{"bSortable": true},

					{"bSortable": true},

					{"bSortable": true},

					{"bSortable": true},

					{"bSortable": false},

					{"bSortable": false}],

				language:<?php echo MJ_gmgt_datatable_multi_language();?>		  

		});

		$('.dataTables_filter input').attr("placeholder", "<?php esc_html_e('Search...', 'gym_mgt') ?>");

} );

</script>

<!-- POP up code -->

<div class="popup-bg">

    <div class="overlay-content">

		<div class="modal-content">

		  <div class="invoice_data"></div>

		</div>

    </div> 

</div>

<!-- End POP-UP Code -->

<div class="panel-body panel-white padding_0 gms_main_list"><!--PANEL WHITE DIV START -->

	<div class="tab-content padding_0"><!--TAB CONTENT DIV START -->

		<?php 

		if($active_tab == 'subscription_list')

		{

			if($obj_gym->role == 'member')

			{	

				if($user_access['own_data']=='1')

				{

					//$paymentdata=$obj_membership_payment->MJ_gmgt_get_member_subscription_history($curr_user_id);

					$subscription_data=$obj_membership_payment->MJ_gmgt_get_own_member_subscription($curr_user_id);

				}

				else

				{

					$subscription_data=$obj_membership_payment->MJ_gmgt_get_all_subscription();

				}	

			}

			else

			{

				$subscription_data=$obj_membership_payment->MJ_gmgt_get_all_subscription();

			}

			if(!empty($subscription_data))

			{

				?>	

				<div class="panel-body padding_0"><!--PANEL BODY DIV START -->

					<div class="table-responsive"><!--TABLE RESPONSIVE START -->

						<table id="subscription_list" class="display" cellspacing="0" width="100%"><!--SUBSCRIPTION HISTORY LIST TABLE START -->
							<thead>
								<tr>
									<th><?php esc_html_e('Photo','gym_mgt');?></th>
									<th><?php esc_html_e('Subcription ID','gym_mgt');?></th>
									<th><?php esc_html_e('Member Name','gym_mgt');?></th>
									<th><?php esc_html_e('Membership Name','gym_mgt');?></th>
									<th><?php esc_html_e('Amount','gym_mgt');?></th>
									<th><?php esc_html_e('Subcription start date','gym_mgt');?></th>
									<th><?php esc_html_e('Subcription end date','gym_mgt');?></th>
									<th><?php esc_html_e('Subcription Status','gym_mgt');?></th>
									<th><?php esc_html_e('Payment Status','gym_mgt');?></th>
									<th><?php esc_html_e('Action','gym_mgt');?></th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<th><?php esc_html_e('Photo','gym_mgt');?></th>
									<th><?php esc_html_e('Subcription ID','gym_mgt');?></th>
									<th><?php esc_html_e('Member Name','gym_mgt');?></th>
									<th><?php esc_html_e('Membership Name','gym_mgt');?></th>
									<th><?php esc_html_e('Amount','gym_mgt');?></th>
									<th><?php esc_html_e('Subcription start date','gym_mgt');?></th>
									<th><?php esc_html_e('Subcription end date','gym_mgt');?></th>
									<th><?php esc_html_e('Subcription Status','gym_mgt');?></th>
									<th><?php esc_html_e('Payment Status','gym_mgt');?></th>
									<th><?php esc_html_e('Action','gym_mgt');?></th>
								</tr>
							</tfoot>
							<tbody>

								<?php 

								if(!empty($subscription_data))

								{

									$i = 0;

									foreach ($subscription_data as $retrieved_data)

									{ 

										if($i == 10)

										{

											$i=0;

										}

										if($i == 0)

										{

											$color_class='smgt_class_color0';

										}

										elseif($i == 1)

										{

											$color_class='smgt_class_color1';

										}

										elseif($i == 2)

										{

											$color_class='smgt_class_color2';

										}

										elseif($i == 3)

										{

											$color_class='smgt_class_color3';

										}

										elseif($i == 4)

										{

											$color_class='smgt_class_color4';

										}

										elseif($i == 5)

										{

											$color_class='smgt_class_color5';

										}

										elseif($i == 6)

										{

											$color_class='smgt_class_color6';

										}

										elseif($i == 7)

										{

											$color_class='smgt_class_color7';

										}

										elseif($i == 8)

										{

											$color_class='smgt_class_color8';

										}

										elseif($i == 9)

										{

											$color_class='smgt_class_color9';

										}

										?>

										<tr>

											<td class="user_image width_50px profile_image_prescription padding_left_0">	

												<p class="prescription_tag padding_15px margin_bottom_0px <?php echo $color_class; ?>">	

													<img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/subcription-white.png"?>" alt="" class="massage_image center image_icon_height_25px margin_top_3px">

												</p>

											</td>

											<td class="productname"><?php echo esc_html($retrieved_data->stripe_subscription_id); ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Subcription ID','gym_mgt');?>" > </td>

											<td class=""><?php 

												$user=get_userdata($retrieved_data->member_id);

												$memberid=get_user_meta($retrieved_data->member_id,'member_id',true);

												if(!empty($user->display_name))

												{

													$display_label=$user->display_name;

												}

												else

												{

													$display_label="-";

												}

												if($memberid)

												{

													$display_label.=" (".$memberid.")";

												}	

												echo esc_html($display_label);

												?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Member Name','gym_mgt');?>" >

											</td>

											<td class="productname"><?php echo MJ_gmgt_get_membership_name(esc_html($retrieved_data->membership_id));?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Membership Name','gym_mgt');?>" ></td>

											<td class="totalamount"><?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?> <?php echo esc_html($retrieved_data->plan_amount);?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Amount','gym_mgt');?>" ></td>

											<td class="paymentdate"><?php echo MJ_gmgt_getdate_in_input_box(esc_html($retrieved_data->plan_period_start));?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Subcription Start Date','gym_mgt');?>" ></td>

											<td class="paymentdate"><?php echo MJ_gmgt_getdate_in_input_box(esc_html($retrieved_data->plan_period_end));?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Subcription End Date','gym_mgt');?>" ></td>

											<td class="productname"><?php echo esc_html($retrieved_data->subscription_status);?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Subcription Status','gym_mgt');?>" ></td>

											<td class="paymentdate">

												<?php 

													echo "<span class='fullpaid_status_color'>";

													echo esc_html__(MJ_gmgt_get_membership_paymentstatus($retrieved_data->mp_id), 'gym_mgt' );

													echo "</span>"; 

												?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Payment Status','gym_mgt');?>" >

											</td>

											<td class="action"> 

												<div class="gmgt-user-dropdown">

													<ul class="" style="margin-bottom: 0px !important;">

														<li class="">

															<a class="" href="#" data-bs-toggle="dropdown" aria-expanded="false">

																<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/More.png"?>" >

															</a>

															<ul class="dropdown-menu heder-dropdown-menu action_dropdawn" aria-labelledby="dropdownMenuLink">

																<?php

																$membershistatus=get_user_meta($retrieved_data->member_id,'membership_status',true);

																												

																if($membershistatus == 'Expired' && $retrieved_data->subscription_status == 'canceled')

																{ 

																	$gym_recurring_enable=get_option("gym_recurring_enable");

																	if($gym_recurring_enable == "yes")

																	{

																		?>

																		<li class="float_left_width_100">

																			<a href="?dashboard=user&page=subscription&action=start_subscription&membership_id=<?php echo $retrieved_data->membership_id; ?>&stripe_customer_id=<?php echo $retrieved_data->stripe_customer_id; ?>&stripe_plan_id=<?php echo $retrieved_data->stripe_plan_id; ?>&subscription_id=<?php echo $retrieved_data->stripe_subscription_id ?>&member_id=<?php echo esc_attr($retrieved_data->member_id);?>" class="float_left_width_100" ><i class="fa fa-credit-card" aria-hidden="true"></i> <?php esc_html_e('Start Subscription','gym_mgt');?></a>

																		</li>

																		<?php

																	}

																}

																elseif($retrieved_data->subscription_status == "active")

																{

																	?>

																	<li class="float_left_width_100">

																		<a href="?dashboard=user&page=subscription&action=cancle_subscription&id=<?php echo $retrieved_data->id; ?>&membership_id=<?php echo $retrieved_data->membership_id; ?>&stripe_customer_id=<?php echo $retrieved_data->stripe_customer_id; ?>&stripe_plan_id=<?php echo $retrieved_data->stripe_plan_id; ?>&subscription_id=<?php echo $retrieved_data->stripe_subscription_id; ?>&member_id=<?php echo esc_attr($retrieved_data->member_id);?>"><i class="fa fa-credit-card" aria-hidden="true"></i> <?php esc_html_e('Cancle Subscription','gym_mgt');?></a>

																	</li>

																	<?php

																}

																?>

																<li class="float_left_width_100 border_top_item">

																	<a href="#" sub_id="<?php echo esc_attr($retrieved_data->id);?>" membership_id="<?php echo $retrieved_data->membership_id; ?>" stripe_customer_id="<?php echo $retrieved_data->stripe_customer_id; ?>" stripe_plan_id="<?php echo $retrieved_data->stripe_plan_id; ?>" subscription_id="<?php echo $retrieved_data->stripe_subscription_id ?>" member_id="<?php echo esc_attr($retrieved_data->member_id);?>" class="change_subscription float_left_width_100"><i class="fa fa-eye" aria-hidden="true"></i> <?php esc_html_e('Change Subscription', 'gym_mgt' ) ;?></a>

																</li>

															</ul>

														</li>

													</ul>

												</div>	

											</td>

										</tr>

										<?php

										$i++;

									} 			

								}

								?>				 

							</tbody>

						</table><!--SUBSCRIPTION HISTORY LIST TABLE END -->

					</div><!--TABLE RESPONSIVE END -->

				</div><!--PANEL BODY END -->

				<?php 

			}

			else

			{

				?>

				<div class="calendar-event-new"> 

					<img class="no_data_img" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/no_data_img.png"?>" >

				</div>

				<?php

			}

		} 

		?>

	</div><!--TAB CONTENT DIV END -->

</div><!--PANEL BODY DIV END -->