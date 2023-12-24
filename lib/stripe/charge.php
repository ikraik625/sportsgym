<?php 

//include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

ini_set('session.cookie_samesite', 'strict');

ini_set('session.cookie_secure', 'On');

ini_set('session.cookie_httponly', 'On');

session_start(); 



$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );







include_once($parse_uri[0]. 'wp-admin/includes/plugin.php' );



require_once( $parse_uri[0] . 'wp-load.php' );



if(is_plugin_active('gym-management/gym-management.php'))



{

	$payment_type =  $_REQUEST['payment_type'];	



	$amount =  $_REQUEST['amount'];	



	$pay_id = $_REQUEST['pay_id'];

	

	$stripe_plan_id = $_REQUEST['stripe_plan_id'];

	
	$customer_id = $_REQUEST['data_user'];


	$currency = get_option("gmgt_currency_code");
	if(isset($_REQUEST['coupon_id']))
	{
		$coupon_id = $_REQUEST['coupon_id'];
	}
	else 
	{
		$coupon_id = '';
	}
	if(isset($_REQUEST['frontend_class_action']))

	{

		$frontend_class_action = $_REQUEST['frontend_class_action'];

	}

	else {

		$frontend_class_action = '';

	}

	if(isset($_REQUEST['class_id1']))

	{

		$class_id1 = $_REQUEST['class_id1'];

	}

	else {

		$class_id1 = '';

	}

	if(isset($_REQUEST['day_id1']))

	{

		$day_id1 = $_REQUEST['day_id1'];

	}

	else {

		$day_id1 = '';

	}

	if(isset($_REQUEST['startTime_1']))

	{

		$startTime_1 = $_REQUEST['startTime_1'];

	}

	else{

		$startTime_1 = '';

	}

	if(isset($_REQUEST['class_date']))

	{

		$class_date = $_REQUEST['class_date'];

	}

	else{

		$class_date = '';

	}

}





if (isset($_REQUEST['secret_key'])) 

{

	$secret_key = $_REQUEST['secret_key'];

}



$result = get_userdata($customer_id);

if(!empty($result)){



$display_name = $result->display_name;



$user_login = $result->user_login;



$customer_email = $result->user_email;



}

else{

	$display_name = '';

	$customer_email = '';

}



if($payment_type == "change_subscription_for_exsting_member")



{



	$subscription_id=$_REQUEST['subscription_id'];



	$sub_id=$_REQUEST['sub_id'];



	//------------ change_subscription_for_exsting_member ---------------------//



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











			$subscription = \Stripe\Subscription::retrieve($subscription_id);



			\Stripe\Subscription::update($subscription_id, [



			'cancel_at_period_end' => false,



			'proration_behavior' => 'create_prorations',



			'items' => [



				[



				'id' => $subscription->items->data[0]->id,



				'price' => $stripe_plan_id,



				],



			],



			]);







			$subsData = $subscription->jsonSerialize();



			



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



			



				if(!empty($membershippayment))



				{



					global $wpdb;



					$table_gmgt_membership_payment=$wpdb->prefix.'Gmgt_membership_payment';



					$payment_data['payment_status'] = 0;



					$whereid['mp_id']=$membershippayment->mp_id;



					$wpdb->update( $table_gmgt_membership_payment, $payment_data ,$whereid);



					$plan_id =$membershippayment->mp_id;



				}



				else



				{



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



					$incomedata['paid_amount']=$amount;



					$incomedata['payment_status']='Fully Paid';



					$result_income=$wpdb->insert( $table_income,$incomedata); 



				}



				$feedata['mp_id']=$plan_id;



				//$feedata['memebership_id']=$_POST['custom'];



				$feedata['amount']=$amount;



				$feedata['payment_method']='Stripe';		



				$feedata['trasaction_id']='';



				$feedata['payment_description']='Recurring Membership Payment';



				$feedata['created_by']=$customer_id;



				$result=$obj_membership_payment->MJ_gmgt_add_feespayment_history($feedata);



				global $wpdb;



				//invoice number generate



				$table_gmgt_member_subscriptions_details=$wpdb->prefix.'gmgt_member_subscriptions_details';



				$membership_start_date_new=date("Y-m-d H:i:s", $subsData['lines']['data']['0']['period']['start']);



				$membership_end_date_new=date("Y-m-d H:i:s", $subsData['lines']['data']['0']['period']['end']);



				$whereid['id']=$sub_id;



				$subscription_data['stripe_subscription_id']=$subsData['id'];



				$subscription_data['membership_id']=$pay_id;



				$subscription_data['plan_period_start'] =date("Y-m-d H:i:s", $subsData['current_period_start']); 



				$subscription_data['plan_period_end'] =date("Y-m-d H:i:s", $subsData['current_period_end']); 



				$subscription_data['subscription_status']='active';



				$subscription_data['membership_status']='continue';



				$subscription_data['plan_amount'] = ($subsData['plan']['amount']/100); 



				$subscription_data['payer_email']=$_POST['stripeEmail']; 



				$subscription_data['updated_date'] =date("Y-m-d H:i:s"); 



				$result11=$wpdb->update( $table_gmgt_member_subscriptions_details,$subscription_data,$whereid); 







				update_user_meta( $customer_id, 'membership_id', $pay_id );					



				update_user_meta( $customer_id, 'subscription_id',$subsData['id'] );	







				if($result)



				{



					wp_safe_redirect(home_url()."?dashboard=user&page=subscription&message=3" );



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

else

{

	

	//--------------------------------  ALL OTHERS PAYAMRNT  ---------------------------------------//

	$check_membership_recurring_option= MJ_gmgt_check_membership_recurring_option($pay_id);



	$gym_recurring_enable=get_option("gym_recurring_enable");



	$gym_recurring_invoice_enable=get_option("gym_recurring_invoice_enable");



	$gmgt_one_time_payment_setting=get_option("gmgt_one_time_payment_setting");



	if($gym_recurring_enable == "yes" && !empty($stripe_plan_id) && $check_membership_recurring_option == "yes")

	{	



		//------------ MEMBERSHIP RECURRING PAYEMNT ----------//



		try {	 



			require_once GMS_PLUGIN_DIR . '/lib/stripe/init.php';



			require_once  GMS_PLUGIN_DIR .'/lib/stripe/lib/Stripe.php';



			



			$gmgt_stripe_product_id=get_option("gmgt_stripe_product_id");



			$gmgt_stripe_secret_key=get_option("gmgt_stripe_secret_key");



			



			\Stripe\Stripe::setApiKey($gmgt_stripe_secret_key);



			$customer = \Stripe\Customer::create(array(



				"email" => $customer_email,



				"source" => $_POST['stripeToken'], // The token submitted from Checkout



				"description" => 'Subscription Payment', // The token submitted from Checkout



				"metadata" => array( // Note: You can specify up to 20 keys, with key names up to 40 characters long and values up to 500 characters long.



				'NAME'          => $display_name,



				'EMAIL'         => $_POST['stripeEmail'],



				'ORDER DETAILS' => 'Subscription Payment',



			)



			));

			//var_dump($customer);

			// var_dump($stripe_plan_id);

			// var_dump($check_membership_recurring_option);

			//die;

			$subscription=\Stripe\Subscription::create([



			'customer' => $customer->id,



			'items' => 



				[



					['price' => $stripe_plan_id],



				],



			]);



			$subsData = $subscription->jsonSerialize();

			// echo "<pre>";

			// print_r($subsData['status']);

			// print_r($subsData);

			// echo "</pre>";

			// die;



			if($subsData['status'] == 'active')



			{ 



				if(isset($_REQUEST['where_payment']) && $_REQUEST['where_payment']=="front_end")



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



					if($_REQUEST['payment_type'] == "start_subscription_for_exsting_member")



					{



						$membershippayment="";



					}



					else



					{



						$membershippayment=$obj_membership_payment->MJ_gmgt_checkMembershipBuyOrNot($customer_id,$joiningdate,$expiredate);



					}



					



					if(!empty($membershippayment))



					{



						global $wpdb;



						$table_gmgt_membership_payment=$wpdb->prefix.'Gmgt_membership_payment';



						$payment_data['payment_status'] = 0;



						$whereid['mp_id']=$membershippayment->mp_id;



						$wpdb->update( $table_gmgt_membership_payment, $payment_data ,$whereid);



						$plan_id =$membershippayment->mp_id;



					}



					else



					{



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



						$incomedata['paid_amount']=$amount;



						$incomedata['payment_status']='Fully Paid';



						$result_income=$wpdb->insert( $table_income,$incomedata); 



					}



					$feedata['mp_id']=$plan_id;



					//$feedata['memebership_id']=$_POST['custom'];



					$feedata['amount']=$amount;



					$feedata['payment_method']='Stripe';		



					$feedata['trasaction_id']='';



					$feedata['payment_description']='Recurring Membership Payment';



					$feedata['created_by']=$customer_id;



					$result=$obj_membership_payment->MJ_gmgt_add_feespayment_history($feedata);



					global $wpdb;



					//invoice number generate



					$table_gmgt_member_subscriptions_details=$wpdb->prefix.'gmgt_member_subscriptions_details';



					$subscription_data['member_id']=$customer_id;



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



					$subscription_data['created_date'] =date("Y-m-d H:i:s"); 



					$subscription_data['updated_date'] =date("Y-m-d H:i:s"); 



					$result_subscription_data=$wpdb->insert( $table_gmgt_member_subscriptions_details,$subscription_data); 



		



					if($_REQUEST['payment_type'] == "start_subscription_for_exsting_member")



					{



						update_user_meta( $customer_id, 'membership_id', $pay_id );					



						update_user_meta( $customer_id, 'subscription_id',$subsData['id'] );					



						wp_redirect ( home_url() . '?dashboard=user&page=subscription_history&message=1');



					}



					else



					{



						$u = new WP_User($customer_id);



						$u->remove_role( 'subscriber' );



						$u->add_role( 'member' );



						//$gmgt_hash=delete_user_meta($customer_id, 'gmgt_hash');



						update_user_meta( $customer_id, 'membership_id', $pay_id );	



						update_user_meta( $customer_id, 'subscription_id',$subsData['id'] );				



						wp_redirect(home_url() .'/?action=payment_success_message');



						//wp_redirect( home_url(). get_option('gmgt_stripe_success_url'));	



					}



					/* if($result)



					{



						$u = new WP_User($customer_id);



						$u->remove_role( 'subscriber' );



						$u->add_role( 'member' );



						$gmgt_hash=delete_user_meta($customer_id, 'gmgt_hash');



						update_user_meta( $customer_id, 'membership_id', $pay_id );					



						wp_redirect(home_url() .'/?action=success');



						//wp_redirect( home_url(). get_option('gmgt_stripe_success_url'));	



					}  */



					if($_REQUEST['frontend_class_action']=='frontend_book')



					{



					



						$obj_class=new MJ_gmgt_classschedule;

						$result=$obj_class->booking_class_shortcode_frontend($_REQUEST['class_id1'],$_REQUEST['day_id1'],$_REQUEST['startTime_1'],$_REQUEST['frontend_class_action'],'',$_REQUEST['class_date'],$pay_id,$customer_id);



						if($result)



						{	



							$page_id = get_option ( 'gmgt_class_booking_page' );	



							$referrer_ipn = array(				



								'page_id' => $page_id,



								'message'=>$result					



							);				



							$referrer_ipn = add_query_arg( $referrer_ipn, home_url() );	



							wp_redirect ($referrer_ipn);



						}



					}



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

	elseif($gym_recurring_invoice_enable == "yes" && $check_membership_recurring_option == "yes")

	{

		

		// var_dump($gmgt_one_time_payment_setting);

		// die;

		//-------- ONE TIME PAYMENT ---------//



		try {	 



			require_once GMS_PLUGIN_DIR . '/lib/stripe/init.php';



			require_once  GMS_PLUGIN_DIR .'/lib/stripe/lib/Stripe.php';



			



			$gmgt_stripe_product_id=get_option("gmgt_stripe_product_id");



			$gmgt_stripe_secret_key=get_option("gmgt_stripe_secret_key");







			//\Stripe\Stripe::setApiKey($gmgt_stripe_secret_key);



			



			// $charge=\Stripe\Charge::create([



			// 	'amount' =>$amount*100,



			// 	'currency' =>$currency,



			// 	"source" => $_POST['stripeToken'], // The token submitted from Checkout



			// ]);



			$gmgt_stripe_secret_key=get_option("gmgt_stripe_secret_key");



			$stripe = new \Stripe\StripeClient(

				$gmgt_stripe_secret_key

			  );

	  

			//---------- CRAETE CUSTOMER ---------//

			$customer=$stripe->customers->create(array(

				"email" => $customer_email,

				//"source" => $_POST['stripeToken'], // The token submitted from Checkout

				"description" => 'Membership Payment', // The token submitted from Checkout

				"metadata" => array( // Note: You can specify up to 20 keys, with key names up to 40 characters long and values up to 500 characters long.

				'NAME'          => $display_name,

				'EMAIL'         => $_POST['stripeEmail'],

				'ORDER DETAILS' => 'Membership Payment',

				)

			));



			$customerId=$customer->id;

			

			//---------- CRAETE CUSTOMER ---------//

			//-------------- GET CUSTOMER PAYMENT METHOD DATA -------------//

			$paymentMethods=$stripe->paymentMethods->create([

			'type' => 'card',	

			'card' => [

				'token' => $_POST['stripeToken']		  

				],

			]);



			$paymentMethodsId=$paymentMethods->id;

		

			//-------------- GET CUSTOMER PAYMENT METHOD DATA -------------//

			//----------- CREATE PaymentIntent -------//

	

			$payment=$stripe->paymentIntents->create([

				'customer' => $customerId,

				'amount' =>$amount*100,

				//'amount' => 20000,

				'currency' =>$currency,

				'payment_method_types' => ['card'],

			]);

		   

		   $id=$payment->id;

		   $client_secret=$payment->client_secret;

			

		   //-----------CREATE PaymentIntent -------//



		   //-----------CONFIRM PaymentIntent -------//

		  $return_url= home_url() . '?dashboard=user&page=membership_payment&action=success&payment_type='.$payment_type.'&where_payment='.$_REQUEST['where_payment'].'&pay_id='.$_REQUEST['pay_id'].'&stripe_plan_id='.$_REQUEST['stripe_plan_id'].'&amount='.$_REQUEST['amount'].'&customer_id='.$customer_id;	

		   $confirm_payment=$stripe->paymentIntents->confirm(

			$id,

			['payment_method' => $paymentMethodsId,

			'return_url' => $return_url]

		 	);

  

		  $payment_id=$confirm_payment->id;

		  //-----------CONFIRM PaymentIntent -------//

		  ?>

		  <script src="https://js.stripe.com/v3/"></script>

  

		  <script src="//code.jquery.com/jquery-2.0.2.min.js"></script>

		  <script>

		  $(document).ready(function() 

		  {	

			  var action ="<?php print $confirm_payment->status; ?>";

			  var type="<?php print $confirm_payment->next_action->type; ?>";

			  var redirect_to_url="<?php print $confirm_payment->next_action->redirect_to_url->url; ?>";

			  var return_url="<?php print $confirm_payment->next_action->redirect_to_url->return_url; ?>";

			  //console.log(action);

			  //console.log(type);

			  //console.log(redirect_to_url);

			  if (action == "requires_action" && type === 'redirect_to_url') {

				  window.location = redirect_to_url;

			  }

		  });

		  </script>

		  <?php

			// echo "<pre>";

			// print_r($confirm_payment->status);

			// print_r($confirm_payment);

			// echo "</pre>";

			// die;

			if($confirm_payment->status =="succeeded")

			{ 

				//for gym plug in// 



				if(is_plugin_active('gym-management/gym-management.php'))



				{



					if(isset($_REQUEST['where_payment']) && $_REQUEST['where_payment']=="front_end")



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



						



							if(!empty($membershippayment))



							{



								global $wpdb;



								$table_gmgt_membership_payment=$wpdb->prefix.'Gmgt_membership_payment';



								$payment_data['payment_status'] = 0;



								$whereid['mp_id']=$membershippayment->mp_id;



								$wpdb->update( $table_gmgt_membership_payment, $payment_data ,$whereid);



								$plan_id =$membershippayment->mp_id;



							}



							else



							{



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



								$payment_data['start_date'] = $joiningdate;



								$payment_data['end_date'] = $expiredate;



								$payment_data['membership_status'] = $membership_status;



								$payment_data['payment_status'] = 0;



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



								$incomedata['paid_amount']=$amount;



								$incomedata['payment_status']='Fully Paid';



								$result_income=$wpdb->insert( $table_income,$incomedata); 



							}



							$feedata['mp_id']=$plan_id;



							//$feedata['memebership_id']=$_POST['custom'];



							$feedata['amount']=$amount;



							$feedata['payment_method']='Stripe';



							$feedata['payment_description']='Membership Payment';



							$feedata['trasaction_id']='';



							$feedata['created_by']=$customer_id;



							$result=$obj_membership_payment->MJ_gmgt_add_feespayment_history($feedata);



							if($result)



							{



								$u = new WP_User($customer_id);



								$u->remove_role( 'subscriber' );



								$u->add_role( 'member' );



								//$gmgt_hash=delete_user_meta($customer_id, 'gmgt_hash');



								update_user_meta( $customer_id, 'membership_id', $pay_id );					



								wp_redirect(home_url() .'/?action=success');	



								//wp_redirect( home_url(). get_option('gmgt_stripe_success_url'));	



							} 



							if($_REQUEST['frontend_class_action']=='frontend_book')



							{





								$obj_class=new MJ_gmgt_classschedule;



								$result=$obj_class->booking_class_shortcode_frontend($_REQUEST['class_id1'],$_REQUEST['day_id1'],$_REQUEST['startTime_1'],$_REQUEST['frontend_class_action'],'',$_REQUEST['class_date'],$pay_id,$customer_id);



								if($result)



								{	



									$page_id = get_option ( 'gmgt_class_booking_page' );	



									$referrer_ipn = array(				



										'page_id' => $page_id,



										'message'=>$result					



									);				



									$referrer_ipn = add_query_arg( $referrer_ipn, home_url() );	



									wp_redirect ($referrer_ipn);



								}



							}



							



						



					}



					else



					{

						

						if($_REQUEST['payment_type'] == 'Sales_Payment')
						{
							$obj_store=new MJ_gmgt_store;



							$saledata['mp_id']=$pay_id;



							$saledata['amount']=$amount;



							$saledata['payment_method']='Stripe';	



							$saledata['trasaction_id']="";



							$saledata['created_by']=$customer_id;



							//$result = $obj_membership_payment->add_feespayment_history($feedata);



							$sales_payment_result = $obj_store->MJ_gmgt_add_sellpayment_history($saledata);



							if($sales_payment_result)



							{



								wp_redirect ( home_url() . '?dashboard=user&page=store&action=success');			



							}



							else



							{



								wp_redirect ( home_url() . '?dashboard=user&page=store&action=cancle');								



							}



						}



						elseif($_REQUEST['payment_type'] == 'Income_Payment')



						{



							$obj_payment=new MJ_gmgt_payment;



							$incomedata['mp_id']=$pay_id;



							$incomedata['amount']=$amount;



							$incomedata['payment_method']='Stripe';	



							$incomedata['trasaction_id']="";



							$incomedata['created_by']=$customer_id;



							$income_result = $obj_payment->MJ_gmgt_add_income_payment_history($incomedata);



							if($income_result)



							{



								wp_redirect ( home_url() . '?dashboard=user&page=payment&action=success');	



							}



							else



							{



								wp_redirect ( home_url() . '?dashboard=user&page=payment&action=cancle');						



							}



						}



						else



						{

							

							$obj_membership_payment = new MJ_gmgt_membership_payment();



							$feedata['mp_id']=$pay_id;



							$feedata['amount']=$amount;



							$feedata['payment_method']='Stripe';



							$feedata['payment_description']='Membership Payment';	



							$feedata['trasaction_id']="";



							$feedata['created_by']=$customer_id;



							$feespayment_result = $obj_membership_payment->MJ_gmgt_add_feespayment_history($feedata);

							

							if($feespayment_result)



							{



								wp_redirect ( home_url() . '?dashboard=user&page=membership_payment&action=success');			



							}



							else



							{



								wp_redirect ( home_url() . '?dashboard=user&page=membership_payment&action=cancle');						



							}



							



						}



						



					}



				}



			}

		}



		catch(\Stripe\Error\Card $e) {



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

	elseif($gmgt_one_time_payment_setting == '1')

	{	

				

		try 

		{	

		

			require_once GMS_PLUGIN_DIR . '/lib/stripe/init.php';

			require_once  GMS_PLUGIN_DIR .'/lib/stripe/lib/Stripe.php';

			$gmgt_stripe_product_id=get_option("gmgt_stripe_product_id");

			$gmgt_stripe_secret_key=get_option("gmgt_stripe_secret_key");

			$stripe = new \Stripe\StripeClient(

				$gmgt_stripe_secret_key

			  );

			//---------- CRAETE CUSTOMER ---------//

			

			$customer=$stripe->customers->create(array(

				"email" => $customer_email,

				//"source" => $_POST['stripeToken'], // The token submitted from Checkout

				"description" => 'Membership Payment', // The token submitted from Checkout

				"metadata" => array( // Note: You can specify up to 20 keys, with key names up to 40 characters long and values up to 500 characters long.

				'NAME'          => $display_name,

				'EMAIL'         => $_POST['stripeEmail'],

				'ORDER DETAILS' => 'Membership Payment',

				)

			));

			

			$customerId=$customer->id;

			

			//---------- CRAETE CUSTOMER ---------//

			//-------------- GET CUSTOMER PAYMENT METHOD DATA -------------//

			$paymentMethods=$stripe->paymentMethods->create([

			'type' => 'card',	

			'card' => [

				'token' => $_POST['stripeToken']		  

				],

			]);

			$paymentMethodsId=$paymentMethods->id;

			//-------------- GET CUSTOMER PAYMENT METHOD DATA -------------//

			//----------- CREATE PaymentIntent -------//

	

			$payment=$stripe->paymentIntents->create([

				'customer' => $customerId,

				'amount' =>$amount*100,

				'currency' =>$currency,

				'payment_method_types' => ['card'],

			]);

		   

		   $id=$payment->id;

		   $client_secret=$payment->client_secret;

		   

		   //-----------CREATE PaymentIntent -------//



		   //-----------CONFIRM PaymentIntent -------//

		   // Indian Rupee

		  

		 

		  $return_url= home_url() . '?dashboard=user&page=membership_payment&action=success&payment_type='.$payment_type.'&where_payment='.$_REQUEST['where_payment'].'&pay_id='.$_REQUEST['pay_id'].'&stripe_plan_id='.$_REQUEST['stripe_plan_id'].'&amount='.$_REQUEST['amount'].'&customer_id='.$customer_id.'&coupon_id='.$coupon_id.'&frontend_class_action='.$frontend_class_action.'&class_id1='.$class_id1.'&day_id1='.$day_id1.'&startTime_1='.$startTime_1.'&class_date='.$class_date;	

		  

		   $confirm_payment=$stripe->paymentIntents->confirm(

			$id,

			['payment_method' => $paymentMethodsId,

			'return_url' => $return_url]

		 	);

			

		  $payment_id=$confirm_payment->id;

				

			

			

		  //-----------CONFIRM PaymentIntent -------//

		  ?>

		  <script src="https://js.stripe.com/v3/"></script>

  

		  <script src="//code.jquery.com/jquery-2.0.2.min.js"></script>

		  <script>

		  $(document).ready(function() 

		  {	

			  var action ="<?php print $confirm_payment->status; ?>";

			  var type="<?php print $confirm_payment->next_action->type; ?>";

			  var redirect_to_url="<?php print $confirm_payment->next_action->redirect_to_url->url; ?>";

			  var return_url="<?php print $confirm_payment->next_action->redirect_to_url->return_url; ?>";

			  if (action == "requires_action" && type === 'redirect_to_url') {

				  window.location = redirect_to_url;

			  }

		  });

		  </script>

		  <?php
			if($confirm_payment->status =="succeeded")
			{
				if(isset($_REQUEST['where_payment']) && $_REQUEST['where_payment']=="front_end")
				{
					    //FRONTEND MEMBERHSIP PAYMENT FLOW//
					    $action='front_end';
						$payment_method='Stripe';
						$result=MJ_gmgt_generate_membership_end_income_invoice_with_payment_online_payment($customer_id,$pay_id,$amount,$payment_type,$action,$payment_method,$coupon_id,'');
						if($result)

						{

							$u = new WP_User($customer_id);

							$u->remove_role( 'subscriber' );

							$u->add_role( 'member' );

							//$gmgt_hash=delete_user_meta($customer_id, 'gmgt_hash');

							update_user_meta( $customer_id, 'membership_id', $pay_id );					

								

						} 

						//END FRONTEND MEMBERHSIP PAYMENT FLOW//

						//BOOK FRONTEND CLASS PAYMENT FLOW//

						if($_REQUEST['frontend_class_action']=='frontend_book')

						{

						

							$obj_class=new MJ_gmgt_classschedule;

							$result=$obj_class->booking_class_shortcode_frontend($_REQUEST['class_id1'],$_REQUEST['day_id1'],$_REQUEST['startTime_1'],$_REQUEST['frontend_class_action'],'',$_REQUEST['class_date'],$pay_id,$customer_id);

							

							if($result)

							{	

								$page_id = get_option ( 'gmgt_class_booking_page' );	

								$referrer_ipn = array(				

									'page_id' => $page_id,

									'message'=>$result					

								);				

								$referrer_ipn = add_query_arg( $referrer_ipn, home_url() );	

								wp_redirect ($referrer_ipn);

								exit;

							}

						}

						else{

							wp_redirect(home_url() .'/member-registration-or-login/?action=success');

							exit;

						}

						//END BOOK FRONTEND CLASS PAYMENT FLOW//

				}

				elseif(isset($_REQUEST['where_payment']) && $_REQUEST['where_payment']=="renew_upgrade_membership_plan")

				{

					$action='renew_upgrade_membership_plan';

					$payment_method='Stripe';
					$type = 'upgrade_membership';
					$result=MJ_gmgt_generate_membership_end_income_invoice_with_payment_online_payment($customer_id,$pay_id,$amount,$payment_type,$action,$payment_method,$coupon_id,$type);
					if($result)

					{

						wp_redirect(home_url() .'?dashboard=user&page=membership_payment&action=success');

					}

				}

				else

				{

					

					if($_REQUEST['payment_type'] == 'Sales_Payment')

					{

						$obj_store=new MJ_gmgt_store;

						$saledata['mp_id']=$pay_id;

						$saledata['amount']=$amount;

						$saledata['payment_method']='Stripe';	

						$saledata['trasaction_id']="";

						$saledata['created_by']=$customer_id;

						$sales_payment_result = $obj_store->MJ_gmgt_add_sellpayment_history($saledata);

						if($sales_payment_result)

						{

							wp_redirect ( home_url() . '?dashboard=user&page=store&action=success');			

						}

						else

						{

							wp_redirect ( home_url() . '?dashboard=user&page=store&action=cancle');								

						}

					}

					elseif($_REQUEST['payment_type'] == 'Income_Payment')

					{

						$obj_payment=new MJ_gmgt_payment;

						$incomedata['mp_id']=$pay_id;

						$incomedata['amount']=$amount;

						$incomedata['payment_method']='Stripe';	

						$incomedata['trasaction_id']="";

						$incomedata['created_by']=$customer_id;

						$income_result = $obj_payment->MJ_gmgt_add_income_payment_history($incomedata);

						if($income_result)

						{

							wp_redirect ( home_url() . '?dashboard=user&page=payment&action=success');	

						}

						else

						{

							wp_redirect ( home_url() . '?dashboard=user&page=payment&action=cancle');						

						}

					}

					else

					{



						$obj_membership_payment = new MJ_gmgt_membership_payment();

						$feedata['mp_id']=$pay_id;

						$feedata['amount']=$amount;

						$feedata['payment_method']='Stripe';

						$feedata['payment_description']='Membership Payment';	

						$feedata['trasaction_id']="";

						$feedata['created_by']=$customer_id;

						$feespayment_result = $obj_membership_payment->MJ_gmgt_add_feespayment_history($feedata);

						if($feespayment_result)

						{

							wp_redirect ( home_url() . '?dashboard=user&page=membership_payment&action=success');			

						}

						else

						{

							wp_redirect ( home_url() . '?dashboard=user&page=membership_payment&action=cancle');						

						}

					}

				}

			}

		}

		catch(\Stripe\Error\Card $e) {



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

?>