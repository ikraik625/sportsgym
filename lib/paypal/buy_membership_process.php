<?php



$obj_membership_payment=new MJ_gmgt_membership_payment;



$p 	= new Gmgt_paypal_class(); // paypal class



	//$p->admin_mail 	= GMS_EMAIL_ADD; // set notification email



//$action 		= $_REQUEST["fees_pay_id"];











if(isset($_REQUEST["buy_confirm_paypal"])){

	

	$user_id  = $_REQUEST["member_id"];

	$coupon_id = $_REQUEST["coupon_id"];

	

	$membership_id=$_REQUEST["membership_id"];



	$custom_var=$membership_id;



}



$meber_amount=MJ_gmgt_get_membership_price($membership_id);

	

$singup_amount=MJ_gmgt_get_membership_signup_amount($membership_id);

if(!empty($coupon_id))
{

	$discount_amount = get_discount_amount_by_membership_id($membership_id,$coupon_id,'');

	$tax_amount=MJ_gmgt_after_discount_tax_amount_by_membership_id($membership_id,$coupon_id,'');

}

else{

	$discount_amount = '';

	$tax_amount=MJ_gmgt_get_membership_tax_amount($membership_id,"");

}





$total_amount = $meber_amount + $singup_amount - (float)$discount_amount + (float)$tax_amount;





$user_info = get_userdata($user_id);



$this_script = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];



$p->add_field('business', get_option('gmgt_paypal_email')); // call the facilitator eaccount



$p->add_field('cmd', '_cart'); // cmd should be _cart for cart checkout



$p->add_field('upload', '1');



$referrer_ipn_success = array(				



	'fullpay' => 'yes',



	'action' => 'success'



);



if(isset($_REQUEST["action_frontend"]))



{



	$class_id1=$_REQUEST["class_id1"]; 



	$day_id1=$_REQUEST["day_id1"]; 



	$startTime_1=$_REQUEST["startTime_1"];



	$class_date=$_REQUEST["class_date"];



	$Remaining_Member_limit_1=$_REQUEST["Remaining_Member_limit_1"]; 



	$bookedclass_membershipid=$_REQUEST["membership_id"]; 



	$action_book=$_REQUEST["action_frontend"];



	$referrer_ipn_success = add_query_arg( $referrer_ipn_success, home_url() );



	$p->add_field('return', home_url().'/?fullpay=yes&action=success&action='. $action_book.'&class_id1='.$class_id1.'&day_id1='.$day_id1.'&startTime_1='.$startTime_1.'&class_date='.$class_date.'&Remaining_Member_limit_1='.$Remaining_Member_limit_1.'&bookedclass_membershipid='.$bookedclass_membershipid);



}



else



{



	$referrer_ipn_success = add_query_arg( $referrer_ipn_success, home_url() );



	$p->add_field('return', home_url().'/?fullpay=yes&action=success'); // return URL after the transaction got over



}



$p->add_field('cancel_return', home_url().'/?dashboard=user&page=membership_payment&action=cancel'); // cancel URL if the trasaction was cancelled during half of the transaction



$referrer_ipn = array(				



				'action' => 'ipn',



				'from'=>'buy_membership'



				);



	$referrer_ipn = add_query_arg( $referrer_ipn, home_url() );







$p->add_field('notify_url',$referrer_ipn); // Notify URL which received IPN (Instant Payment Notification)



$p->add_field('currency_code', get_option( 'gmgt_currency_code' ));



$p->add_field('invoice', date("His").rand(1234, 9632));



$p->add_field('item_name_1', MJ_gmgt_get_membership_name($membership_id));



$p->add_field('item_number_1', 4);



$p->add_field('quantity_1', 1);



//$p->add_field('amount_1', MJ_gmgt_get_membership_price($membership_id));



$p->add_field('amount_1', $total_amount);



//$p->add_field('amount_1', $_POST['amount']);



//$p->add_field('amount_1', 1);//Test purpose



$p->add_field('first_name',$user_info->first_name);



$p->add_field('last_name', $user_info->last_name);



$p->add_field('address1',$user_info->address);



$p->add_field('city', $user_info->city_name);







$p->add_field('custom', $user_id."_".$custom_var."_".$coupon_id);



$p->add_field('rm',2);



		



$p->add_field('state', get_user_meta($user_id,'state_name',true));



$p->add_field('country', get_option( 'gmgt_contry' ));



$p->add_field('zip', get_user_meta($user_id,'zip_code',true));



$p->add_field('email',$user_info->user_email);



$p->submit_paypal_post(); // POST it to paypal



//$p->dump_fields(); // Show the posted values for a reference, comment this line before app goes live



//echo "hello";



exit;



?>