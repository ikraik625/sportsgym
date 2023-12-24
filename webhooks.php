<?php 
	require_once GMS_PLUGIN_DIR . '/lib/stripe/init.php';

	$gmgt_stripe_secret_key=get_option("gmgt_stripe_secret_key");

	\Stripe\Stripe::setApiKey($gmgt_stripe_secret_key);
	
    $payload = @file_get_contents('php://input');
	$event = null;
	
	try 
	{
		$event = \Stripe\Event::constructFrom(
			json_decode($payload, true)
		);
	} 
	catch(\UnexpectedValueException $e)
	{
		// Invalid payload
		http_response_code(400);
		exit();
	}
	
	// Handle the event
	switch ($event->type) 
    {
			case 'payment_intent.succeeded':
				$paymentIntent = $event->data->object; // contains a StripePaymentIntent
				paymentIntent_function($paymentIntent);
				break;
			case 'invoice.payment_succeeded':
				$invoicepaymentsucceededdata = $event->data->object; // contains a StripePaymentMethod
				if($invoicepaymentsucceededdata['billing_reason'] == 'subscription_cycle')
				{
					$gym_recurring_enable=get_option("gym_recurring_enable");
					if($gym_recurring_enable == "yes")
					{
				  		invoicepaymentsucceeded_function($invoicepaymentsucceededdata);
					}
				}
				break;
			// ... handle other event types
			default:
				echo 'Received unknown event type ' . $event->type;
	}
	function paymentIntent_function($subsData)
	{
		$fp = fopen(GMS_PLUGIN_DIR . '/test.txt',"wb");
		fwrite($fp,$subsData);
		fclose($fp); 
		die;
	}
	function invoicepaymentsucceeded_function($subsData)
	{
		$subscription_id=$subsData['subscription'];
		$membership_start_date_new=date("Y-m-d H:i:s", $subsData['lines']['data']['0']['period']['start']);
	    $membership_end_date_new=date("Y-m-d H:i:s", $subsData['lines']['data']['0']['period']['end']);
		$membership_amount=$subsData['amount_paid']/100;
		//----------- UPDATE SUBSCRIPTION DETAILS -----------//
		global $wpdb;
		$table_gmgt_member_subscriptions_details = $wpdb->prefix. 'gmgt_member_subscriptions_details';
		$result = $wpdb->get_row("SELECT * FROM $table_gmgt_member_subscriptions_details where stripe_subscription_id ='$subscription_id'");
		
		$member_id=$result->member_id;
		$plan_id=$result->membership_id;
		$start_date=date("Y-m-d", $subsData['lines']['data']['0']['period']['start']);
		$end_date=date("Y-m-d", $subsData['lines']['data']['0']['period']['end']);
	
		$subscriptions_id_data['id']=$result->id;
		$subscriptions_data['updated_date']=date("Y-m-d H:i:s");
		$subscriptions_data['plan_period_start']=$membership_start_date_new;
		$subscriptions_data['plan_period_end']=$membership_end_date_new;
		$subscriptions_data['subscription_status']='active';
		$subscriptions_data['membership_status']='continue';
		$result=$wpdb->update( $table_gmgt_member_subscriptions_details, $subscriptions_data,$subscriptions_id_data);
		
		$payment_status=MJ_gym_frontend_membership_payment($member_id,$plan_id,$start_date,$end_date,$subscription_id,$membership_amount);
		
	}
	die;
?>