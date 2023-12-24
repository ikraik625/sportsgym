<?php //======FRONT END TEMPLATE PAGE=========//
error_reporting(0);
$obj_payment=new MJ_gmgt_payment;
$obj_store=new MJ_gmgt_store;
$obj_membership_payment=new MJ_gmgt_membership_payment;

//Paytm Success//
if(isset($_REQUEST) && $_REQUEST['method'] == 'razorpay')
{
	if($_REQUEST['type'] =="membership_payment")
	{
		$feedata['mp_id']=$_REQUEST['payment_id'];
		
		$feedata['amount']=esc_attr($_REQUEST['amount']);

		$feedata['payment_method']='Razorpay';	

		$feedata['trasaction_id']='';

		$feedata['created_by']=get_current_user_id();

		$result = $obj_membership_payment->MJ_gmgt_add_feespayment_history($feedata);		

		if($result)

		{ 
			wp_redirect ( home_url() . '?dashboard=user&page=membership_payment&action=success');
			die();
		}	
	}
	elseif($_REQUEST['type'] =="income_payment")
	{
		
		$incomedata['member_id']=get_current_user_id();

		$incomedata['income_id']=$_REQUEST['payment_id'];

		$incomedata['amount']=esc_attr($_REQUEST['amount']);

		$incomedata['trasaction_id']='';

		$incomedata['payment_method']='Razorpay';

		$incomedata['created_by']=get_current_user_id();

		$result = $obj_payment->MJ_gmgt_add_income_payment_history($incomedata);

		if($result)
		{
			wp_redirect ( home_url() . '?dashboard=user&page=payment&tab=incomelist&action=success');
			die();
		}
	}
	elseif ($_REQUEST['type'] =="sales_payment") 
	{
		$saledata['member_id']=get_current_user_id();

		$saledata['sell_id']=$_REQUEST['payment_id'];

		$saledata['amount']=esc_attr($_REQUEST['amount']);

		$saledata['payment_method']='Razorpay';

		$saledata['trasaction_id']='';

		$result = $obj_store->MJ_gmgt_add_sellpayment_history($saledata);

		if($result)
		{
			wp_redirect ( home_url() . '?dashboard=user&page=store&action=success');
			die();
		}
	}

}
if(isset($_REQUEST['STATUS']) && $_REQUEST['STATUS'] == 'TXN_SUCCESS')
{ 
	if($_REQUEST['type'] == 'membership_payment')
	{
		$trasaction_id  = esc_attr($_REQUEST["TXNID"]);

		$custom_array = explode("_",esc_attr($_REQUEST['ORDERID']));
	
		$feedata['mp_id']=$custom_array[1];
	
		$feedata['amount']=esc_attr($_REQUEST['TXNAMOUNT']);
	
		$feedata['payment_method']='Paytm';	
	
		$feedata['trasaction_id']=$trasaction_id;
	
		$feedata['created_by']=get_current_user_id();	
	
		$result = $obj_membership_payment->MJ_gmgt_add_feespayment_history($feedata);		
	
		if($result)
		{ 
			wp_redirect ( home_url() . '?dashboard=user&page=membership_payment&action=success');
			die();
		}
	}
	elseif($_REQUEST['type'] == 'income_payment')
	{
		
		$trasaction_id  = esc_attr($_REQUEST["TXNID"]);

		$custom_array = explode("_",esc_attr($_REQUEST['ORDERID']));

		$incomedata['member_id']=get_current_user_id();

		$incomedata['income_id']=$custom_array[1];

		$incomedata['amount']=esc_attr($_REQUEST['TXNAMOUNT']);

		$incomedata['trasaction_id']=$trasaction_id;

		$incomedata['payment_method']='Paytm';

		$incomedata['created_by']=get_current_user_id();

		$result = $obj_payment->MJ_gmgt_add_income_payment_history($incomedata);

		if($result)
		{
			wp_redirect ( home_url() . '?dashboard=user&page=payment&tab=incomelist&action=success');
			die();
		}	
	}
	elseif($_REQUEST['type'] == 'sale_payment')
	{
		$trasaction_id  = esc_attr($_REQUEST["TXNID"]);

		$custom_array = explode("_",esc_attr($_REQUEST['ORDERID']));

		$saledata['member_id']=get_current_user_id();

		$saledata['sell_id']=$custom_array[1];

		$saledata['amount']=esc_attr($_REQUEST['TXNAMOUNT']);

		$saledata['payment_method']='Paytm';

		$saledata['trasaction_id']=$trasaction_id;

		$result = $obj_store->MJ_gmgt_add_sellpayment_history($saledata);

		if($result)
		{
			wp_redirect (home_url() . '?dashboard=user&page=store&action=success');
			die();
		}
	}
		

}
if((isset($_REQUEST['payer_status'])) && $_REQUEST['payer_status'] == 'VERIFIED' && (isset($_REQUEST['payment_status'])) && ($_REQUEST['payment_status']=='Completed') && (isset($_REQUEST['half'])) && ($_REQUEST['half']=='yes') )

{
	if(isset($_REQUEST['type']) && ($_REQUEST['type'] == 'membership_payment'))
	{
		
		$trasaction_id  = sanitize_text_field($_POST["txn_id"]);
	
		$custom_array = explode("_",sanitize_text_field($_POST['custom']));
	
		$feedata['mp_id']=$custom_array[1];
	
		$feedata['amount']=sanitize_text_field($_POST['mc_gross_1']);
	
		$feedata['payment_method']='paypal';	
	
		$feedata['trasaction_id']=$trasaction_id ;

		$feedata['created_by']=$custom_array[0];
		
		$result = $obj_membership_payment->MJ_gmgt_add_feespayment_history($feedata);		
	
		if($result)
		{
			wp_redirect ( home_url() . '?dashboard=user&page=membership_payment&action=success');
			die();

		}
	
	}
	elseif(isset($_REQUEST['type']) && ($_REQUEST['type'] == 'sell_payment')) 
	{
		$saledata['member_id']=get_current_user_id();

		$custom_array = explode("_",sanitize_text_field($_POST['custom']));

		$saledata['sell_id']=$custom_array[1];

		$saledata['amount']=sanitize_text_field($_POST['mc_gross_1']);

		$saledata['payment_method']='paypal';

		$saledata['trasaction_id']=sanitize_text_field($_POST["txn_id"]);

		$result = $obj_store->MJ_gmgt_add_sellpayment_history($saledata);

		if($result)
		{
			wp_redirect ( home_url() . '?dashboard=user&page=store&action=success');
			die();
		}
	}
	elseif (isset($_REQUEST['type']) && ($_REQUEST['type'] == 'income_payment')) 
	{
		
		$trasaction_id  = sanitize_text_field($_POST["txn_id"]);

		$incomedata['member_id']=get_current_user_id();

		$custom_array = explode("_",sanitize_text_field($_POST['custom']));

		$incomedata['income_id']=$custom_array[1];

		$incomedata['amount']=sanitize_text_field($_POST['mc_gross_1']);

		$incomedata['trasaction_id']=$trasaction_id ;

		$incomedata['payment_method']='paypal';

		$incomedata['created_by']=get_current_user_id();

		$result = $obj_payment->MJ_gmgt_add_income_payment_history($incomedata);

		if($result)
		{
			wp_redirect ( home_url() . '?dashboard=user&page=payment&tab=incomelist&action=success');
			die();
		}

	}
}

if(isset($_REQUEST['renew_upgrade_membership_plan'])) 

{
	if($_REQUEST['payment_method'] == 'Stripe')

	{

	   require_once GMS_PLUGIN_DIR. '/lib/stripe/index.php';

	}

	elseif($_REQUEST['payment_method'] == 'Paypal')

	{

		require_once GMS_PLUGIN_DIR. '/lib/paypal/paypal_process.php';	

	}

	else

	{

		require_once GMS_PLUGIN_DIR. '/lib/paypal/paypal_process.php';

	}

}
if(isset($_REQUEST) && ($_REQUEST['action'] == 'renew_upgrade_membership_plan') && ($_REQUEST['full']== 'yes')){
	
	$custom_array = explode("_",$_POST['custom']);

	$customer_id=$custom_array[0];

	$action='';

	$payment_method='Paypal';

	$pay_id=$custom_array[1];

	$amount=$_POST['mc_gross_1'];

	$coupon_id = $custom_array[2];

	$result=MJ_gmgt_generate_membership_end_income_invoice_with_payment_online_payment($customer_id,$pay_id,$amount,$payment_type,$action,$payment_method,$coupon_id,'upgrade_membership');
	if($result)
	{
		wp_redirect ( home_url() . '?dashboard=user&page=membership_payment&action=success');
		die();
	}
}
$nonce = $_REQUEST['_wpnonce'];

/* if ( ! wp_verify_nonce( $nonce, 'wp_url_senitize' ) ) 

{

  die( __( 'Security check', 'textdomain' ) ); 

}

else

{ */

require_once(ABSPATH.'wp-admin/includes/user.php' );

global $current_user;

$user = wp_get_current_user ();

$obj_dashboard= new MJ_gmgt_dashboard;

$user_id=get_current_user_id(); 

//GET USER ROLE //

$user_roles = $current_user->roles;

$user_role = array_shift($user_roles);

$frontend_class_booking=get_option('gym_frontend_class_booking');

$obj_virtual_classroom = new MJ_gmgt_virtual_classroom;

//CHECK USER APPROVE OR NOT //

if(MJ_gmgt_check_approve_user($user_id)!='')

{

	wp_logout();

	wp_redirect(site_url().'/index.php/gym-management-login-page/?na=1');

}

$obj_gym = new MJ_gmgt_Gym_management(get_current_user_id());

//CHECK USER LOGIN IF LOGIN SO REDIRECT IN PAGE //

if (! is_user_logged_in ())
{

	$page_id = get_option ( 'gmgt_login_page' );

	wp_redirect ( home_url () . "?page_id=" . $page_id );

}

//CHECK USER LOGIN IF LOGIN SO REDIRECT ADMIN SIDE //

if (is_super_admin () OR $user_role == 'management') 

{

	wp_redirect ( admin_url () . 'admin.php?page=gmgt_system' );

}

?>

<!--task-event POP up code -->

<div class="popup-bg">

	<div class="overlay-content content_width">

		<div class="modal-content" id="border_top_5">

			<div class="task_event_list">

			</div>     

		</div>

	</div>     

</div>

 <!-- End task-event POP-UP Code -->

<!-- CLASS BOOK IN CALANDER POPUP HTML CODE -->

<div id="eventContent" class="modal-body " style="display:none;"><!--MODAL BODY DIV START-->

	<style>

		/* .ui-dialog .ui-dialog-titlebar-close

		{

			margin: -15px -4px 0px 0px;

		} */

	    .ui-dialog 

		{

			margin-left: 70%;

			top: 1920px;

			z-index: 10000;

	    }

		.ui-dialog .ui-dialog-titlebar-close {

			margin: -18px 5px 0px 0px;

			font-size: 20px;

			background: none;

		}

		.ui-widget-header {

			border: none;

			background: none;

			color: #333;

			font-weight: bold;

			font-family: 'Poppins';

		}

		.ui-dialog .ui-dialog-title {

    		font-size: 16px;

		}

		

	</style>



	<div class="penal-body">

		<div class="row">

			<div class="col-md-6 popup_padding_15px">

				<label for="" class="popup_label_heading"><?php esc_html_e('Name','gym_mgt');?></label><br>

				<label for="" class="label_value" id="class_name"></label>

			</div>

			<div class="col-md-6 popup_padding_15px">

				<label for="" class="popup_label_heading"><?php esc_html_e('Trainer Name','gym_mgt');?></label><br>

				<label for="" class="label_value" id="staff_member_name"></label>

			</div>

			<div class="col-md-6 popup_padding_15px">

				<label for="" class="popup_label_heading"><?php esc_html_e('Start Date & Time','gym_mgt');?></label><br>

				<label for="" class="label_value" id="startTime"></label>

			</div>

			<div class="col-md-6 popup_padding_15px">

				<label for="" class="popup_label_heading"><?php esc_html_e('End Date & Time','gym_mgt');?></label><br>

				<label for="" class="label_value" id="endTime"></label>

			</div>

			<div class="col-md-6 popup_padding_15px">

				<label for="" class="popup_label_heading"><?php esc_html_e('Member Limit','gym_mgt');?></label><br>

				<label for="" class="label_value" id="Member_limit"></label>

			</div>

			<div class="col-md-6 popup_padding_15px">

				<label for="" class="popup_label_heading"><?php esc_html_e('Remaining Member','gym_mgt');?></label><br>

				<label for="" class="label_value " id="Remaining_Member_limit"> </label>

			</div>

		</div>  

	</div>



	<form method="post" class="fd_cal_book_class" accept-charset="utf-8" action="?dashboard=user&page=class-schedule&tab=class_booking&action=book_now">

		<input type="hidden" id="class_name_1" name="class_name_1" value="" />

		<input type="hidden" id="startTime_1" name="startTime_1" value="" />

		<input type="hidden" id="endTime_1" name="endTime_1" value="" />

		<input type="hidden" id="class_id1" name="class_id1" value="" />

		<input type="hidden" id="day_id1" name="day_id1" value="" />

		<input type="hidden" id="Remaining_Member_limit_1" name="Remaining_Member_limit_1" value="" />

		<input type="hidden" id="class_date1" name="class_date" value="" />

		

		<div class="submit">

			<input type="submit" name="Book_Class" id="d_id" class="btn btn-primary sumit display" value="<?php esc_html_e('Book Class','gym_mgt'); ?>"/>

		</div>

		<?php

		?>

	</form>		

</div><!--MODAL BODY DIV END-->

<!-- END CLASS BOOK IN CALANDER POPUP HTML CODE -->

<div id="zoom_booked_popup" class="modal-body " style="display:none;"><!--MODAL BODY DIV START-->

	<style>

		.ui-dialog .ui-dialog-titlebar-close

		{

			margin: -15px -4px 0px 0px;

		}

	    .ui-dialog 

		{

			margin-left: 70%;

			top: 1920px;

			z-index: 10000;

	    }

	</style>

	<p><b><?php esc_html_e('Class Name:','gym_mgt');?></b> <span id="class_name"></span></p><br>

	<p><b><?php esc_html_e('Start Date & Time:','gym_mgt');?> </b> <span id="startTime"></span></p><br>

	<p><b><?php esc_html_e('End Date & Time:','gym_mgt');?></b> <span id="endTime"></span></p><br>

	<p><b><?php esc_html_e('Trainer Name:','gym_mgt');?></b> <span id="staff_member_name"></span></p><br>

	<p><b><?php esc_html_e('Member Limit In CLass:','gym_mgt');?></b> <span id="Member_limit"></span></p><br>

	<p><b><?php esc_html_e('Remaining Member In Class:','gym_mgt');?></b> <span id="Remaining_Member_limit"></span></p><br>

	<form method="post" accept-charset="utf-8">

		<a id="join_link_href" href="#" class="btn btn-success" target="_blank"><i class="fa fa-video-camera" aria-hidden="true"></i> <?php esc_html_e('Join','gym_mgt');?> </a>

	</form>		

</div><!--MODAL BODY DIV END-->



<?php 

$obj_class=new MJ_gmgt_classschedule;

$obj_nutrition=new MJ_gmgt_nutrition;

$booking_data=$obj_class->MJ_gmgt_get_member_book_class_dashboard(get_current_user_id());



if($user_role == 'member')

{

	//START GET CLASS DATA CODE//

	$obj_class=new MJ_gmgt_classschedule;

	$class_data_all=$obj_class->MJ_gmgt_get_all_classes_by_user_membership(); 



	if(!empty($class_data_all))

	{

		foreach ($class_data_all as $classdatas)			

		{

			$user_data= get_userdata($classdatas->staff_id);

			$staff_member_name=$user_data->display_name;

			$date_from =  date('Y-m-d');

			if($date_from == "0000-00-00")

			{

				$date_from = date('Y-m-d');

				$date_from = strtotime($date_from);

			}	

			else

			{

				$date_from =  date('Y-m-d');

				$date_from = strtotime($date_from);

			}				

			$date_check = $classdatas->end_date; 

			$member_limit = $classdatas->member_limit; 

			if($date_check == "0000-00-00")

			{

				$date_to = 2050-12-31;

				$date_to = strtotime($date_to);

			}	

			else

			{

				$date_to = $classdatas->end_date; 

				$date_to = strtotime($date_to);

			}

			$new_time = DateTime::createFromFormat('h:i A', $classdatas->start_time);

			$startTime_24 = $new_time->format('H:i:s');

			$new_time_end = DateTime::createFromFormat('h:i A', $classdatas->end_time);

			$endTime_24 = $new_time_end->format('H:i:s');

			for ($i=$date_from; $i<=$date_to; $i+=86400)

			{  

				$date1=date("Y-m-d", $i);

				$day = date("l", strtotime($date1));

				$day_array=json_decode($classdatas->day);

				$class_id=$classdatas->class_id;

				$booked_class_data=$obj_class->MJ_gmgt_get_book_class_bydate($class_id,$date1);

				$booked_class_status=$obj_class->MJ_gmgt_get_book_class_status_bydate($class_id,$date1,get_current_user_id());

				$meeting_data_join_link = $obj_virtual_classroom->MJ_gmgt_get_singal_meeting_join_link__class_id_in_zoom($class_id);

				if(!empty($meeting_data_join_link))

				{

					$zoom_link=$meeting_data_join_link;



				}

				else

				{

					$zoom_link='';

				}

				$remaning_memmber=$member_limit -  $booked_class_data;

			

				if (is_array($day_array) && in_array($day, $day_array))

				{

					$cal_array [] = array (

					'type' =>  'class',

					'class_id' => $classdatas->class_id,

					'day' => $day,

					'title' => $classdatas->class_name,

					'trainer' => $staff_member_name,

					'start' => $date1."T".$startTime_24,

					'end' => $date1."T".$endTime_24,

					'color' => $classdatas->color,

					'Member_limit' => $member_limit,

					'remaning_memmber' => $remaning_memmber,

					'class_date' => $date1,

					'meeting_data_join_link' => $zoom_link,

					'booked_class_status' => $booked_class_status,

					);

				}

	

			}

		} 

	}

	//START GET BIRTHDAY DATA CODE //

	$birthday_boys=get_users(array('role'=>'member'));

	$boys_list="";

	//END GET BIRTHDAY DATA CODE //

	//START GET NOTICE DATA CODE //

	if (! empty ( $obj_gym->notice )) 

	{

		foreach ( $obj_gym->notice as $notice ) 

		{

			$notice_start_date=get_post_meta($notice->ID,'gmgt_start_date',true);



			$notice_end_date=get_post_meta($notice->ID,'gmgt_end_date',true);



			if(!empty($notice->post_content))

			{

				$notice_comment = $notice->post_content;

			}

			else

			{

				$notice_comment = "N/A";

			}

			$start_to_end_date = $notice_start_date.' To '.$notice_end_date;

			$notice_title = $notice->post_title;

			$notice_for = ucfirst(get_post_meta($notice->ID, 'notice_for',true));



			if(get_post_meta( $notice->ID, 'gmgt_class_id',true) != "" && get_post_meta( $notice->ID, 'gmgt_class_id',true) =="all")

			{

				$class_name = 'All';

			}

			elseif(get_post_meta( $notice->ID, 'gmgt_class_id',true) != "")

			{

				$class_name = mj_gmgt_get_class_name(get_post_meta($notice->ID, 'gmgt_class_id',true));

			}

			else

			{

				$class_name='N/A';

			}

			$i=1;

			$cal_array[] = array (



				'event_title' => esc_html__( 'Notice Details', 'gym_mgt' ),



			  	'type' =>  'notice',

					

				'notice_title' => $notice_title,



				'description' => 'notice',



				'notice_comment' => $notice_comment,



				'notice_for' => $notice_for,



				'title' => $notice->post_title,



				'class_name' => $class_name,



				'start' => mysql2date('Y-m-d', $notice_start_date ),



				'end' => date('Y-m-d',strtotime($notice_end_date.' +'.$i.' days')),



				'color' => '#12AFCB',



				'start_to_end_date' => $start_to_end_date

				

			);	

				

		}

	}

	//END GET NOTICE DATA CODE //

	//GET Booked Class DATA CODE //

	if (! empty ($booking_data )) 

	{

		foreach ($booking_data as $booking ) 

		{

			

			$booking_start_date=$booking->class_booking_date;

			$booking_end_date=$booking->class_booking_date;

			//$i=1;

			$cal_array[] = array (

				'type' =>  'booking',

				'title' => "",

				//'start' => mysql2date('Y-m-d', $booking_start_dates ),

				'start' => $booking_start_date,

				//'end' => date('Y-m-d',strtotime($notice_end_date.' +'.$i.' days')),

				'end' => $booking_end_date,

				'display' => 'background',

				'overlap'=> false,

				'color' => '#008000'

			);	

		}

	}

	//END GET Booked Class DATA CODE //



	//---------------- START NUTRITION DATA CODE -------------------//



	$nutritiondata = $obj_nutrition->MJ_gmgt_get_member_nutrition($user_id);



	if (!empty ($nutritiondata)) 

	{

		foreach ( $nutritiondata as $nutrition_data ) 

		{

			$start_date = $nutrition_data->start_date;

			$end_date = $nutrition_data->expire_date;

			$user=get_userdata($nutrition_data->user_id);

			$nutrition_member_title=$user->display_name;

			$intrestid=get_user_meta($nutrition_data->user_id,'intrest_area',true);

			if(!empty($intrestid))

			{

				$calander_nutrition_membership = get_the_title($intrestid);

			}

			else

			{

				$calander_nutrition_membership = "N/A";

			}

			$i=1;

			$cal_array[] = array (

				'event_title' => esc_html__( 'Nutrition Details', 'gym_mgt' ),

				'type' =>  'nutrition',

				'description' => 'nutrition',

				'title' => "Nutrition Record",

				'calander_nutrition_membership'=>$calander_nutrition_membership,

				'nutrition_member_title'=>$nutrition_member_title,

				'nutrition_start_date'=>$start_date,

				'nutrition_end_date'=>$end_date,

				'start' => mysql2date('Y-m-d', $start_date ),

				'end' => date('Y-m-d',strtotime($end_date.' +'.$i.' days')),

				'color' => '#FF9054'

			);	

		}

	}

	//---------------- END NUTRITION DATA CODE ---------------------//

}

elseif($user_role == 'staff_member')

{

	//START GET RESERVATION DATA CODE //

	$obj_reservation = new MJ_gmgt_reservation;

	$reservationdata = $obj_reservation->MJ_gmgt_get_all_reservation();

	$cal_array = array();

	if(!empty($reservationdata))

	{

		foreach ($reservationdata as $retrieved_data)

		{

		   	$start_time_array = explode(":",$retrieved_data->start_time);

		   	$start_time_array_new = $start_time_array[0].":".$start_time_array[1]."".$start_time_array[2];

		   	$start_time_formate =  date("H:i:s", strtotime($start_time_array_new)); 

		   	$start_time_data = new DateTime($start_time_formate); 

		   	$starttime=date_format($start_time_data,'H:i:s');		   

		   	$event_start_date=date('Y-m-d',strtotime($retrieved_data->event_date));

		   	$aevent_start_date_new=$event_start_date." ".$starttime;  

		   	$end_time_array = explode(":",$retrieved_data->end_time);

		   	$abcnew = $end_time_array[0].":".$end_time_array[1]."".$end_time_array[2];

		   	$Hour_new =  date("H:i:s", strtotime($abcnew)); 

		   	$dnew = new DateTime($Hour_new); 

		   	$endtime=date_format($dnew,'H:i:s');

		   	$event__end_date=$event_start_date." ".$endtime; 



			$reservation_place = get_the_title(esc_html($retrieved_data->place_id));

			$start_to_end_time = $starttime_new.' To '.$endtime_new;

			$reservation_staffmember = MJ_gmgt_get_display_name(esc_html($retrieved_data->staff_id));

			$i=1;

			$cal_array [] = array 

			(

				'event_title' => esc_html__( 'Reservation Details', 'gym_mgt' ),



		        'type' =>  'reservationdata',



				'reservation_title' =>$retrieved_data->event_name,



				'reservation_date' => $event_start_date,



				'start_to_end_time' => $start_to_end_time,



				'reservation_staffmember' => $reservation_staffmember,

				

				'reservation_place' => $reservation_place,



				'title' => $retrieved_data->event_name,



				'description' => 'reservation',



				'start' => $aevent_start_date_new,



				'end' => $event__end_date,



				'color' => '#FF9054'

			);

		}

	}

	//END GET RESERVATION DATA CODE //

	//START GET BIRTHDAY DATA CODE //

	$birthday_boys=get_users(array('role'=>'member'));

	$boys_list="";

	if (! empty ( $birthday_boys )) 

	{

		foreach ( $birthday_boys as $boys ) 

		{

			$startdate = date("Y",strtotime($boys->birth_date));

			$enddate = $startdate + 90;

			$years = range($startdate,$enddate,1);

			foreach($years as $year)

			{	

				$startdate1=date("m-d",strtotime($boys->birth_date));

				$cal_array[] = array (

				'type' =>  'Birthday',

				'title' => $boys->first_name."'s '".esc_html__( 'Birthday', 'gym_mgt' ),

				'start' =>"{$year}-{$startdate1}",

				'end' =>"{$year}-{$startdate1}",

				'backgroundColor' => '#F25656');

			}

		}

			

	}

	//END GET BIRTHDAY DATA CODE //

	//START GET NOTICE DATA CODE //

	if (! empty ( $obj_gym->notice )) 

	{

		foreach ( $obj_gym->notice as $notice ) 

		{

			$notice_start_date=get_post_meta($notice->ID,'gmgt_start_date',true);



			$notice_end_date=get_post_meta($notice->ID,'gmgt_end_date',true);

			if(!empty($notice->post_content))

			{

				$notice_comment = $notice->post_content;

			}

			else

			{

				$notice_comment = "N/A";

			}

			$start_date =  $notice->start_date;

			$end_date =  $notice->end_date;

			$start_to_end_date = $start_date.' To '.$end_date;

			$notice_title = $notice->post_title;

			$notice_for = ucfirst(get_post_meta($notice->ID, 'notice_for',true));



			if(get_post_meta( $notice->ID, 'gmgt_class_id',true) != "" && get_post_meta( $notice->ID, 'gmgt_class_id',true) =="all")

			{

				$class_name = 'All';

			}

			elseif(get_post_meta( $notice->ID, 'gmgt_class_id',true) != "")

			{

				$class_name = mj_gmgt_get_class_name(get_post_meta($notice->ID, 'gmgt_class_id',true));

			}

			else

			{

				$class_name = "N/A";

			}

			$i=1;

			$cal_array[] = array (



				'event_title' => esc_html__( 'Notice Details', 'gym_mgt' ),



			  	'type' =>  'notice',

					

				'notice_title' => $notice_title,



				'description' => 'notice',



				'notice_comment' => $notice_comment,



				'notice_for' => $notice_for,



				'title' => $notice->post_title,



				'class_name' => $class_name,



				'start' => mysql2date('Y-m-d', $notice_start_date ),



				'end' => date('Y-m-d',strtotime($notice_end_date.' +'.$i.' days')),



				'color' => '#12AFCB',



				'start_to_end_date' => $start_to_end_date

				

			);	

				

		}

	}

	//START GET NOTICE DATA CODE //



	//---------------- START CLASS BOOKING DATA CODE -------------------//



	$bookingdata=$obj_class->MJ_gmgt_get_all_booked_class();

	if (!empty ($bookingdata)) 

	{

		foreach ( $bookingdata as $class_booking ) 

		{

			$start_date = $class_booking->class_booking_date;

			$class_name = $obj_class->MJ_gmgt_get_class_name(esc_html($class_booking->class_id));

			$i=1;

			$cal_array[] = array (

			   	'type' =>  'booking_class',

				'title' => $class_name,

				'start' => mysql2date('Y-m-d', $start_date ),

				'end' => mysql2date('Y-m-d', $start_date ),

				'color' => '#28C76F'

			);	

				

		}

	}

	//---------------- END CLASS BOOKING DATA CODE ---------------------//

}

else

{

	//START GET NOTICE DATA CODE //

	if (! empty ( $obj_gym->notice )) 

	{

		foreach ( $obj_gym->notice as $notice ) 

		{

			$notice_start_date=get_post_meta($notice->ID,'gmgt_start_date',true);



			$notice_end_date=get_post_meta($notice->ID,'gmgt_end_date',true);

			if(!empty($notice->post_content))

			{

				$notice_comment = $notice->post_content;

			}

			else

			{

				$notice_comment = "N/A";

			}

			$start_date =  $notice->start_date;

			$end_date =  $notice->end_date;

			$start_to_end_date = $start_date.' To '.$end_date;

			$notice_title = $notice->post_title;

			$notice_for = ucfirst(get_post_meta($notice->ID, 'notice_for',true));



			if(get_post_meta( $notice->ID, 'gmgt_class_id',true) != "" && get_post_meta( $notice->ID, 'gmgt_class_id',true) =="all")

			{

				$class_name = 'All';

			}

			elseif(get_post_meta( $notice->ID, 'gmgt_class_id',true) != "")

			{

				$class_name = mj_gmgt_get_class_name(get_post_meta($notice->ID, 'gmgt_class_id',true));

			}

			else

			{

				$class_name = "N/A";

			}

			$i=1;

			$cal_array[] = array (



				'event_title' => esc_html__( 'Notice Details', 'gym_mgt' ),



			  	'type' =>  'notice',

					

				'notice_title' => $notice_title,



				'description' => 'notice',



				'notice_comment' => $notice_comment,



				'notice_for' => $notice_for,



				'title' => $notice->post_title,



				'class_name' => $class_name,



				'start' => mysql2date('Y-m-d', $notice_start_date ),



				'end' => date('Y-m-d',strtotime($notice_end_date.' +'.$i.' days')),



				'color' => '#12AFCB',



				'start_to_end_date' => $start_to_end_date

				

			);	

				

		}

	}

	//START GET NOTICE DATA CODE //

}

//var_dump($cal_array);

?>

<style>

	.ui-dialog-titlebar-close

	{

		font-size: 13px !important;

		border: 1px solid transparent !important;

		border-radius: 0 !important;

		outline: 0!important;

		background-color: #fff !important;

		background-image: url("<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Close.png"?>") !important;

		background-repeat: no-repeat !important;

		float: right;

		color: #fff !important;

		width: 10% !important;

		height: 30px !important;

	}

	.ui-dialog-titlebar {

		border: 0px solid #aaaaaa !important;

		background: unset !important;

		font-size: 22px !important;

		color: #333333 !important;

		font-weight: 500 !important;

		font-style: normal!important;

		font-family: Poppins!important;

	}

	<?php

	if (!is_rtl())

	{

		?>

		.ui-dialog.ui-corner-all.ui-widget.ui-widget-content.ui-front.ui-draggable.ui-resizable

		{

			left: -500px !important;

		}

		<?php

	}

	?>

	

	.ui-dialog {

		background: #ffffff none repeat scroll 0 0;

		border-radius: 4px;

		box-shadow: 0 0 5px rgb(0 0 0 / 90%);

		cursor: default;

	}

	@media (max-width: 768px)

	{

		.ui-dialog.ui-corner-all.ui-widget.ui-widget-content.ui-front.ui-draggable.ui-resizable

		{

			width: 340px !important;

			left: 30px !important;

			top: 2878.5px !important;

		}

	}

</style>

<!--------------- NOTICE CALENDER POPUP ---------------->

<div id="event_booked_popup" class="modal-body " style="display:none;"><!--MODAL BODY DIV START-->

	<div class="penal-body">

		<div class="row">

			<div class="col-md-6 popup_padding_15px">

				<label for="" class="popup_label_heading"><?php esc_attr_e('Title','gym_mgt');?></label><br>

				<label for="" class="label_value" id="calander_notice_title"></label>

			</div>

			<div class="col-md-6 popup_padding_15px">

				<label for="" class="popup_label_heading"><?php esc_attr_e('Start Date To End Date','gym_mgt');?></label><br>

				<label for="" class="label_value" id="calander_start_to_end_date"></label>

			</div>

			<div class="col-md-6 popup_padding_15px">

				<label for="" class="popup_label_heading"><?php esc_attr_e('Notice For','gym_mgt');?></label><br>

				<label for="" class="label_value" id="calander_notice_for"></label>

			</div>

			<div class="col-md-6 popup_padding_15px">

				<label for="" class="popup_label_heading"><?php esc_attr_e('Class Name','gym_mgt');?></label><br>

				<label for="" class="label_value" id="calander_class_name"></label>

			</div>

			<div class="col-md-12 popup_padding_15px">

				<label for="" class="popup_label_heading"><?php esc_attr_e('Comment','gym_mgt');?></label><br>

				<label for="" class="label_value " id="calander_discription"> </label>

			</div>

		</div>  

	</div>

</div>



<!--------------- RESERVATION CALENDER POPUP ---------------->

<div id="reservation_booked_popup" class="modal-body " style="display:none;"><!--MODAL BODY DIV START-->

	<div class="penal-body">

		<div class="row">

			<div class="col-md-6 popup_padding_15px">

				<label for="" class="popup_label_heading"><?php esc_attr_e('Title','gym_mgt');?></label><br>

				<label for="" class="label_value" id="calander_reservation_title"></label>

			</div>

			<div class="col-md-6 popup_padding_15px">

				<label for="" class="popup_label_heading"><?php esc_attr_e('Place','gym_mgt');?></label><br>

				<label for="" class="label_value" id="calander_reservation_place"></label>

			</div>

			<div class="col-md-6 popup_padding_15px">

				<label for="" class="popup_label_heading"><?php esc_attr_e('Date','gym_mgt');?></label><br>

				<label for="" class="label_value " id="calander_reservation_date"> </label>

			</div>

			<div class="col-md-6 popup_padding_15px">

				<label for="" class="popup_label_heading"><?php esc_attr_e('Start Time To End Time','gym_mgt');?></label><br>

				<label for="" class="label_value" id="calander_reservation_start_to_end_time"></label>

			</div>

			<div class="col-md-6 popup_padding_15px">

				<label for="" class="popup_label_heading"><?php esc_attr_e('Staff Member','gym_mgt');?></label><br>

				<label for="" class="label_value" id="calander_reservation_staffmember"></label>

			</div>

			

		</div>  

	</div>

</div>

<!--------------- NUTRITION CALENDER POPUP ---------------->

<div id="nutrition_booked_popup" class="modal-body " style="display:none;"><!--MODAL BODY DIV START-->

	<div class="penal-body">

		<div class="row">

			<div class="col-md-6 popup_padding_15px">

				<label for="" class="popup_label_heading"><?php esc_attr_e('Member Name','gym_mgt');?></label><br>

				<label for="" class="label_value" id="calander_member_title"></label>

			</div>

			<div class="col-md-6 popup_padding_15px">

				<label for="" class="popup_label_heading"><?php esc_attr_e('Membership Name','gym_mgt');?></label><br>

				<label for="" class="label_value" id="calander_nutrition_membership"></label>

			</div>

			<div class="col-md-6 popup_padding_15px">

				<label for="" class="popup_label_heading"><?php esc_attr_e('Start Date','gym_mgt');?></label><br>

				<label for="" class="label_value " id="nutrition_start_date"> </label>

			</div>

			<div class="col-md-6 popup_padding_15px">

				<label for="" class="popup_label_heading"><?php esc_attr_e('End Date','gym_mgt');?></label><br>

				<label for="" class="label_value" id="nutrition_end_date"></label>

			</div>

		</div>  

	</div>

</div>

<script>



	var calendar_laungage ="<?php echo MJ_gmgt_get_current_lan_code();?>";



	//var $ = jQuery.noConflict();



	document.addEventListener('DOMContentLoaded', function() {



	var calendarEl = document.getElementById('calendar');



	var calendar = new FullCalendar.Calendar(calendarEl, {



		dayMaxEventRows: 1,	



		headerToolbar: {



			left: 'prev,today next ',



			center: 'title',



			right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'



		},



		locale: calendar_laungage,



			editable: false,



			slotEventOverlap: false,



		



			eventTimeFormat: { // like '14:30:00'



				hour: 'numeric',



				minute: '2-digit',



				meridiem: 'short'



			},



			// allow "more" link when too many events



			events: <?php echo json_encode($cal_array);?>,



			forceEventDuration : true,



			//start add class in pop up//





			eventClick:  function(event, jsEvent, view) 



			{



			

				//----------FOR ZOOM ----------//

				if(event.event._def.extendedProps.description=='notice')

				{

					$("#event_booked_popup #calander_notice_title").html(event.event._def.extendedProps.notice_title);

					$("#event_booked_popup #calander_start_to_end_date").html(event.event._def.extendedProps.start_to_end_date);

					$("#event_booked_popup #calander_discription").html(event.event._def.extendedProps.notice_comment);	

					$("#event_booked_popup #calander_notice_for").html(event.event._def.extendedProps.notice_for);					

					$("#event_booked_popup #calander_class_name").html(event.event._def.extendedProps.class_name);

					

					$( "#event_booked_popup" ).removeClass( "display_none" );

					$("#event_booked_popup").dialog({ modal: true, title: event.event._def.extendedProps.event_title,width:550, height:300 });

				}

				//----------FOR ZOOM ----------//

				if(event.event._def.extendedProps.description=='reservation')

				{

					$("#reservation_booked_popup #calander_reservation_title").html(event.event._def.extendedProps.reservation_title);

					$("#reservation_booked_popup #calander_reservation_place").html(event.event._def.extendedProps.reservation_place);

					$("#reservation_booked_popup #calander_reservation_start_to_end_time").html(event.event._def.extendedProps.start_to_end_time);

					$("#reservation_booked_popup #calander_reservation_staffmember").html(event.event._def.extendedProps.reservation_staffmember);	

					$("#reservation_booked_popup #calander_reservation_date").html(event.event._def.extendedProps.reservation_date);					

					

					$( "#reservation_booked_popup" ).removeClass( "display_none" );

					$("#reservation_booked_popup").dialog({ modal: true, title: event.event._def.extendedProps.event_title,width:550, height:300 });

				}

				//----------FOR ZOOM ----------//

				if(event.event._def.extendedProps.description=='nutrition')

				{

					$("#nutrition_booked_popup #calander_member_title").html(event.event._def.extendedProps.nutrition_member_title);

					$("#nutrition_booked_popup #calander_nutrition_membership").html(event.event._def.extendedProps.calander_nutrition_membership);

					$("#nutrition_booked_popup #nutrition_start_date").html(event.event._def.extendedProps.nutrition_start_date);

					$("#nutrition_booked_popup #nutrition_end_date").html(event.event._def.extendedProps.nutrition_end_date);					

					

					$( "#nutrition_booked_popup" ).removeClass( "display_none" );

					$("#nutrition_booked_popup").dialog({ modal: true, title: event.event._def.extendedProps.event_title,width:550, height:300 });

				}

				<?php $dformate=get_option('gmgt_datepicker_format'); ?>



				var dateformate_value='<?php echo $dformate;?>';	



				if(dateformate_value == 'yy-mm-dd')



				{	



				var dateformate='YYYY-MM-DD h:mm A';



				}



				if(dateformate_value == 'yy/mm/dd')



				{	



				var dateformate='YYYY/MM/DD h:mm A';	



				}



				if(dateformate_value == 'dd-mm-yy')



				{	



				var dateformate='DD-MM-YYYY h:mm A';



				}



				if(dateformate_value == 'mm-dd-yy')



				{	



				var dateformate='MM-DD-YYYY h:mm A';



				}



				if(dateformate_value == 'mm/dd/yy')



				{	



				var dateformate='MM/DD/YYYY h:mm A';	



				}



				$("#eventContent #class_name").html(event.event._def.title);



				$("#eventContent #startTime").html(moment(event.event.start).format(dateformate));



				$("#eventContent #endTime").html(moment(event.event.end).format(dateformate)); 



				$("#eventContent #staff_member_name ").html(event.event._def.extendedProps.trainer);



				$("#eventContent #Member_limit ").html(event.event._def.extendedProps.Member_limit);



				$("#eventContent #Remaining_Member_limit ").html(event.event._def.extendedProps.remaning_memmber);



				$("#eventContent #class_date_id ").html(event.event._def.extendedProps.class_date);



				$("#class_name_1").val(event.event._def.title);



				$("#startTime_1").val(moment(event.event.start).format(dateformate));



				$("#endTime_1").val(moment(event.event.end).format(dateformate));



				$("#staff_member_name_1").val(event.event._def.extendedProps.trainer);



				$("#Member_limit_1").val(event.event._def.extendedProps.Member_limit);



				$("#Remaining_Member_limit_1").val(event.event._def.extendedProps.remaning_memmber);



				$("#class_id1").val(event.event._def.extendedProps.class_id);



				$("#day_id1").val(event.event._def.extendedProps.day);



				$("#class_date1").val(event.event._def.extendedProps.class_date);



				$("#d_id").html();



				//----------FOR ZOOM ----------//



				$("#zoom_booked_popup #class_name").html(event.event._def.title);



				$("#zoom_booked_popup #startTime").html(moment(event.event.start).format(dateformate));



				$("#zoom_booked_popup #endTime").html(moment(event.event.end).format(dateformate)); 



				$("#zoom_booked_popup #staff_member_name ").html(event.event._def.extendedProps.trainer);



				$("#zoom_booked_popup #Member_limit ").html(event.event._def.extendedProps.Member_limit);



				$("#zoom_booked_popup #Remaining_Member_limit ").html(event.event._def.extendedProps.remaning_memmber);



				$("#zoom_booked_popup #class_date_id ").html(event.event._def.extendedProps.class_date);



				//----------------------//



				var today = new Date();



				var class_dates= event.event._def.extendedProps.class_date;



				var class_ids= event.event._def.extendedProps.class_id;



				var booked_class_status= event.event._def.extendedProps.booked_class_status;



				var meeting_data_join_link= event.event._def.extendedProps.meeting_data_join_link;



				var dd = today.getDate();



				var mm = today.getMonth()+1; 



				var yyyy = today.getFullYear();



				if(dd<10) 



				{



					dd='0'+dd;



				} 







				if(mm<10) 



				{



					mm='0'+mm;



				} 



				var new_today = yyyy+'-'+mm+'-'+dd;



				



				if(new_today <= class_dates )



				{



					if(meeting_data_join_link == '')



					{                      



						$("#eventLink").attr('href', event.event._def.extendedProps.url);



						$("#eventContent").dialog({ modal: true, title: '<?php echo esc_html_e( "Book Class", 'gym_mgt' ); ?>',width:340, height:410 });



						$( "#eventContent" ).removeClass( "display_none" );



						if(booked_class_status == "yes")



						{



						$("#d_id").hide();



						} 



						else 



						{



							$("#d_id").show();



						}



						$(".ui-dialog-titlebar-close").text('x');



						$(".ui-dialog-titlebar-close").css('height',30);



					}



					else



					{



						var gmgt_enable_virtual_classschedule = '<?php echo get_option('gmgt_enable_virtual_classschedule');?>';



						if(booked_class_status == "yes")



						{



							if(gmgt_enable_virtual_classschedule== 'yes')



							{



								$("#d_id").hide();



								$("#zoom_booked_popup").dialog({ modal: true, title: 'Virtual Class',width:340, height:410 });



								$( "#zoom_booked_popup" ).removeClass( "display_none" );



								$("#join_link_href").attr('href', meeting_data_join_link);



								$(".ui-dialog-titlebar-close").text('x');



								$(".ui-dialog-titlebar-close").css('height',30);



							}



						} 



						else 



						{



							$("#d_id").show();



							$("#eventLink").attr('href', event.event._def.extendedProps.url);



							$("#eventContent").dialog({ modal: true, title: 'Class Book',width:340, height:410 });



							$(".ui-dialog-titlebar-close").text('x');



							$(".ui-dialog-titlebar-close").css('height',30);



						}



					}



				}



			},



			//end  add class in pop up//



			//start add mouse over event only notice,birthday and reservation event//



			



			//eventMouseEnter



			eventMouseover: function (event, jsEvent, view) 



			{



				<?php $dformate=get_option('gmgt_datepicker_format'); ?>



				var dateformate_value='<?php echo $dformate;?>';	



				if(dateformate_value == 'yy-mm-dd')



				{	



				var dateformate='YYYY-MM-DD';



				}



				if(dateformate_value == 'yy/mm/dd')



				{	



				var dateformate='YYYY/MM/DD';	



				}



				if(dateformate_value == 'dd-mm-yy')



				{	



				var dateformate='DD-MM-YYYY';



				}



				if(dateformate_value == 'mm-dd-yy')



				{	



				var dateformate='MM-DD-YYYY';



				}



				if(dateformate_value == 'mm/dd/yy')



				{	



				var dateformate='MM/DD/YYYY';	



				}



				var newstartdate = event.start;



				var date = new Date(newstartdate);



				var startdate = new Date(date);



				var dateObjstart = new Date(startdate);



				var momentObjstart = moment(dateObjstart);



				var momentStringstart = momentObjstart.format(dateformate);



				var newdate = event.end;



				var type = event.type;



				var date = new Date(newdate);



				var newdate1 = new Date(date);



				if(type == 'reservationdata')



				{



					newdate1.setDate(newdate1.getDate());



				}



				else



				{



					newdate1.setDate(newdate1.getDate() - 1);



				}



				var dateObj = new Date(newdate1);



				var momentObj = moment(dateObj);



				var momentString = momentObj.format(dateformate);



				var data_type=event.type;



				if(data_type == 'Birthday' || data_type == 'reservationdata' || data_type == 'notice' )



				{



					tooltip = '<div class="tooltiptopicevent dasboard_Birthday">' + '<?php esc_html_e('Title Name','gym_mgt'); ?>' + ': ' + event.title + '</br>' + ' <?php esc_html_e('Start Date','gym_mgt'); ?>' + ': ' + momentStringstart + '</br>' + '<?php esc_html_e('End Date','gym_mgt'); ?>' + ': ' + momentString + '</br>' +  ' </div>';



					$("body").append(tooltip);



					$(this).mouseover(function (e) 



					{



						"use strict";



						$(this).css('z-index', 10000);



						$('.tooltiptopicevent').fadeIn('500');



						$('.tooltiptopicevent').fadeTo('10', 1.9);



					}).mousemove(function (e) 



					{



						"use strict";



						$('.tooltiptopicevent').css('top', e.pageY + 10);



						$('.tooltiptopicevent').css('left', e.pageX + 20);



					});



				}



			},



			eventMouseLeave: function (data, event, view)



			{



				"use strict";



				$(this).css('z-index', 8);



				$('.tooltiptopicevent').remove();



			},



			//end add mouse over event only notice,birthday and reservation event//



	})



	calendar.render();	



	});



</script>



<html lang="en"><!--HTML START-->

	<head>



		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">



		<meta charset="utf-8">



		<meta http-equiv="X-UA-Compatible" content="IE=edge">



		<meta name="viewport" content="width=device-width, initial-scale=1">

		



		<title><?php echo esc_html__(get_option( 'gmgt_system_name' ));?></title>

		<!-- CSS Sart -->

		<?php  



		if (is_rtl())



		{



		?>



		<link rel="stylesheet"	href="<?php echo GMS_PLUGIN_URL.'/assets/css/bootstrap-rtl_min.css'; ?>">



		<link rel="stylesheet"	href="<?php echo GMS_PLUGIN_URL.'/assets/css/custom_rtl.css'; ?>">



		<link rel="stylesheet"	href="<?php echo GMS_PLUGIN_URL.'/assets/css/new_design_rtl.css'; ?>">



		<?php 



		} ?>



		<link rel="stylesheet"	href="<?php echo GMS_PLUGIN_URL.'/assets/css/new_style.css'; ?>">



		<link rel="stylesheet"	href="<?php echo GMS_PLUGIN_URL.'/assets/css/responsive_new_design.css'; ?>">

		<link rel="stylesheet"	href="<?php echo GMS_PLUGIN_URL.'/assets/css/material/bootstrap-inputs.css'; ?>">

		<link rel="stylesheet"	href="<?php echo GMS_PLUGIN_URL.'/assets/css/popping_font.css'; ?>">

		

		<script type="text/javascript"	src="<?php echo GMS_PLUGIN_URL.'/assets/js/material/material.min.js'; ?>"></script>

		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

		<script type="text/javascript" src="<?php echo GMS_PLUGIN_URL.'/assets/js/workout_activity.js';?>"></script>

		<script type="text/javascript"	src="<?php echo GMS_PLUGIN_URL.'/assets/js/jquery-3-6-0.js'; ?>"></script>



		<link rel="stylesheet"	href="<?php echo GMS_PLUGIN_URL.'/assets/css/dashboard.css'; ?>">



		<link rel="stylesheet"	href="<?php echo GMS_PLUGIN_URL.'/assets/css/style.css'; ?>">



		<link rel="stylesheet"	href="<?php echo GMS_PLUGIN_URL.'/assets/css/dataTables.css'; ?>">



		<link rel="stylesheet"	href="<?php echo GMS_PLUGIN_URL.'/assets/css/dataTables_editor_min.css'; ?>">



		<link rel="stylesheet"	href="<?php echo GMS_PLUGIN_URL.'/assets/css/dataTables_tableTools.css'; ?>">



		<link rel="stylesheet"	href="<?php echo GMS_PLUGIN_URL.'/assets/css/dataTables_responsive.css'; ?>">



		<link rel="stylesheet"	href="<?php echo GMS_PLUGIN_URL.'/assets/css/jquery-ui.css'; ?>">



		<link rel="stylesheet"	href="<?php echo GMS_PLUGIN_URL.'/assets/css/font-awesome_min.css'; ?>">



		<link rel="stylesheet"	href="<?php echo GMS_PLUGIN_URL.'/assets/css/popup.css'; ?>">



		<link rel="stylesheet"	href="<?php echo GMS_PLUGIN_URL.'/assets/css/custom.css'; ?>">



		<link rel="stylesheet"	href="<?php echo GMS_PLUGIN_URL.'/assets/css/fullcalendar.css'; ?>">



		<link rel="stylesheet"	href="<?php echo GMS_PLUGIN_URL.'/assets/css/bootstrap_min.css'; ?>">	



		<link rel="stylesheet"	href="<?php echo GMS_PLUGIN_URL.'/assets/css/datepicker_min.css'; ?>">



		<link rel="stylesheet"	href="<?php echo GMS_PLUGIN_URL.'/assets/css/bootstrap-multiselect.css'; ?>">	



		<link rel="stylesheet"	href="<?php echo GMS_PLUGIN_URL.'/assets/css/white.css'; ?>">



		<link rel="stylesheet"	href="<?php echo GMS_PLUGIN_URL.'/assets/css/gymmgt_min.css'; ?>">



		<link rel="stylesheet"	href="<?php echo GMS_PLUGIN_URL.'/assets/css/gym-responsive.css'; ?>">



		<?php  



		if (is_rtl())



		{



		?>



		<link rel="stylesheet"	href="<?php echo GMS_PLUGIN_URL.'/assets/css/bootstrap-rtl_min.css'; ?>">



		<link rel="stylesheet"	href="<?php echo GMS_PLUGIN_URL.'/assets/css/custom_rtl.css'; ?>">



		<?php 



		} ?>



		<link rel="stylesheet"	href="<?php echo GMS_PLUGIN_URL.'/lib/validationEngine/css/validationEngine_jquery.css'; ?>">



		<link rel="stylesheet"	href="<?php echo GMS_PLUGIN_URL.'/lib/select2-3.5.3/select2.css'; ?>">



		<link rel="stylesheet"	href="<?php echo GMS_PLUGIN_URL.'/assets/css/gym-responsive.css'; ?>">



		<!-- 



		CSS END



		JS Start  -->



		<script type="text/javascript"	src="<?php echo GMS_PLUGIN_URL.'/assets/js/jquery-ui.js'; ?>"></script>



		<script type="text/javascript"	src="<?php echo GMS_PLUGIN_URL.'/assets/js/jquery-ui-lan.min.js'; ?>"></script>



		<script type="text/javascript"	src="<?php echo GMS_PLUGIN_URL.'/assets/js/moment_min.js'; ?>"></script>



		<script type="text/javascript"	src="<?php echo GMS_PLUGIN_URL.'/assets/js/fullcalendar_min.js'; ?>"></script>



		<script type="text/javascript"	src="<?php echo GMS_PLUGIN_URL.'/assets/js/popper.min.js'; ?>"></script>







		<?php /*--------Full calendar multilanguage---------*/



		$lancode=get_locale();



		$code=substr($lancode,0,2);



		?>



		<script type="text/javascript"	src="<?php echo GMS_PLUGIN_URL.'/assets/js/calendar-lang/'.$code.'.js'; ?>"></script>



		<script type="text/javascript"	src="<?php echo GMS_PLUGIN_URL.'/lib/select2-3.5.3/select2_min.js'; ?>"></script>



		<script type="text/javascript"	src="<?php echo GMS_PLUGIN_URL.'/assets/js/jquery_dataTables_min.js'; ?>"></script>



		<script type="text/javascript"	src="<?php echo GMS_PLUGIN_URL.'/assets/js/dataTables_tableTools_min.js'; ?>"></script>



		<script type="text/javascript"	src="<?php echo GMS_PLUGIN_URL.'/assets/js/dataTables_editor_min.js'; ?>"></script>



		<script type="text/javascript"	src="<?php echo GMS_PLUGIN_URL.'/assets/js/dataTables_responsive.js'; ?>"></script>



		<script type="text/javascript"	src="<?php echo GMS_PLUGIN_URL.'/assets/js/bootstrap_min.js'; ?>"></script>



		<script type="text/javascript"	src="<?php echo GMS_PLUGIN_URL.'/assets/js/bootstrap-multiselect.js'; ?>"></script>



		<script type="text/javascript"	src="<?php echo GMS_PLUGIN_URL.'/assets/js/responsive-tabs.js'; ?>"></script>







		<script type="text/javascript"	src="<?php echo GMS_PLUGIN_URL.'/lib/validationEngine/js/languages/jquery.validationEngine-'.$code.'.js'; ?>"></script>



		<script type="text/javascript"	src="<?php echo GMS_PLUGIN_URL.'/lib/validationEngine/js/jquery_validationEngine.js'; ?>"></script>



		<script type="text/javascript" src="<?php echo GMS_PLUGIN_URL.'/assets/js/jssor_slider_mini.js';?>"></script>







		<!-- Print & PDF -->



		<script type="text/javascript"	src="<?php echo GMS_PLUGIN_URL.'/assets/js/dataTables-buttons-min.js'; ?>"></script>



		<link rel="stylesheet"	href="<?php echo GMS_PLUGIN_URL.'/assets/css/buttons.dataTables.min.css'; ?>">







		<script type="text/javascript"	src="<?php echo GMS_PLUGIN_URL.'/assets/js/gmgt-buttons-print-min.js'; ?>"></script>



		<script type="text/javascript"	src="<?php echo GMS_PLUGIN_URL.'/assets/js/pdfmake-min.js'; ?>"></script>



		<script type="text/javascript"	src="<?php echo GMS_PLUGIN_URL.'/assets/js/vfs_fonts.js'; ?>"></script>



		<script type="text/javascript"	src="<?php echo GMS_PLUGIN_URL.'/assets/js/buttons.html5.min.js'; ?>"></script>



		<!-- Js END -->



		<link rel="stylesheet"	href="<?php echo GMS_PLUGIN_URL.'/assets/css/sweetalert2.css'; ?>">

		<script type="text/javascript"	src="<?php echo GMS_PLUGIN_URL.'/assets/js/sweetalert2.js'; ?>"></script>



		<?php



		if(isset($_REQUEST['dashboard']) && $_REQUEST['dashboard'] == 'user')



		{



		?>	



		<script id="gmgt-popup-front-js-extra">



		var gmgt = {"ajax":"<?php echo admin_url('admin-ajax.php'); ?>"};



		var language_translate = {"select_one_member_alert_new":esc_html__( 'Please select at least one member', 'gym_mgt' ),"select_one_member_alert":esc_html__( 'please select member', 'gym_mgt' ), "membership_member_limit_alert":"Membership member limit is full","select_one_membership_alert":"please select at least one member type","product_out_of_stock_alert":"Product out of stock","min_lable":"Min","assigned_workout_lable":"Assign Workout","days_lable":"Days","nutrition_schedule_details_lable":"Nutrition Schedule Details","dinner_lable":"Dinner Nutrition","breakfast_lable":"Break Fast Nutrition","afternoon_snack_lable":"Afternoon Snacks","midmorning_snack_lable":"Mid Morning Snacks","lunch_lable":"Lunch Nutrition","measurement_workout_delete_record_alert":"Do you really want to delete this record?","daily_workout_exercise_delete_alert":"Are you sure you want to delete this?","membership_category_delete_record_alert":"Are you sure want to delete this record?","sunday_days":"Sunday","monday_days":"Monday","Tuesday_days":"Tuesday","Wednesday_days":"Wednesday","Thursday_days":"Thursday","Friday_days":"Friday","Saturday_days":"Saturday","rest_time_lable":"Rest Time","kg_lable":"KG","reps_lable":"Reps","sets_lable":"Sets","edit_record_alert":"Are you sure want to edit this record?","category_alert":"You must fill out the field!","class_limit_alert":"Class Limit Is Full.","enter_room_alert":"Please Enter Room Category Name.","enter_value_alert":"Please Enter Value.","delete_record_alert":"Are you sure want to delete this record?","select_hall_alert":"Please Select Exam Hall","one_record_alert":"Please Checked Atleast One Student"};





		</script>



		<?php



		}



		?>

		<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>

		<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet"/> 



	</head> 

	<?php

	if ( is_rtl() )

	{

		$rtl_left_icon_class = "fa-chevron-left";

	}

	else

	{

		$rtl_left_icon_class = "fa-chevron-right";

	}

	?>

	<body class="gym-management-content <?php if($_REQUEST['page_action'] == 'web_view_hide') echo "staffmember_body_content"; ?>">

		<div class="row gmgt-header forntend_dashboard_main_div" style="margin: 0;">

			<div class="col-sm-12 col-md-12 col-lg-2 col-xl-2 padding_0 staff_member_app_dis_none">

				<a href="<?php echo home_url().'?dashboard=user';?>" class='gmgt-logo'>

					<img src="<?php  echo get_option( 'gmgt_system_logo' ); ?>" class="system_logo_height_width">

				</a>

				

				<!--  toggle button && desgin start-->

				<button type="button" id="sidebarCollapse" class="navbar-btn">

					<span></span>

					<span></span>

					<span></span>

				</button>

				<!--  toggle button && desgin end-->

			</div>

			<div class="col-sm-12 col-md-12 col-lg-10 col-xl-10 gmgt-right-heder">

				<div class="row">

					<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 name_and_icon_dashboard align_items_unset_res smgt_header_width">

						<div class="smgt_title_add_btn">

							<h3 class="gmgt-addform-header-title rtl_menu_backarrow_float">

								<?php

								$obj_gym = new MJ_gmgt_Gym_management ( get_current_user_id () );

								$page_name = $_REQUEST['page'];    

								$active_tab = $_REQUEST["tab"];

								$action_name =$_REQUEST['action'];

								$role = $obj_gym->role;

								

								if(isset($_REQUEST['dashboard']) && $_REQUEST['dashboard'] == 'user' && $_REQUEST['page'] == "")

								{

									echo esc_html_e( 'Welcome', 'gym_mgt' );echo esc_html_e( ', ', 'gym_mgt' );

									echo $user->display_name;

								}

								elseif($page_name == 'member')

								{

									if($active_tab == 'addmember' || $active_tab == 'viewmember')

									{

										if(isset($_REQUEST['member_list_app']) && $_REQUEST['member_list_app'] == 'memberlist_app' || isset($_REQUEST['page_action']) && $_REQUEST['page_action'] == 'web_view_hide')

										{

											?>

											<a href='<?php echo home_url().'?dashboard=user&page=member&tab=memberlist&page_action=web_view_hide&member_list_app=memberlist_app';?>'>

												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">

											</a>

											<?php

										}

										else

										{

											?>

											<a href='<?php echo home_url().'?dashboard=user&page=member';?>'>

												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">

											</a>

											<?php

										}

										if($_REQUEST['action'] == 'edit')

										{

											echo esc_html_e('Edit Member', 'gym_mgt' );

										}

										elseif($_REQUEST['action'] == 'view'){

											echo esc_html_e('View Member', 'gym_mgt' );

										}

										else

										{

											echo esc_html_e( 'Add Member', 'gym_mgt' );

										}

									}

									else

									{	

										echo esc_html_e( 'Members', 'gym_mgt' );

									}

								}

								elseif($page_name == 'staff_member')

								{

									if( $active_tab == 'view_staffmember')

									{

										if(isset($_REQUEST['staff_member_app']) && $_REQUEST['staff_member_app'] == 'staff_lsit_app' || isset($_REQUEST['page_action']) && $_REQUEST['page_action'] == 'web_view_hide')

										{

											?>

											<a href='<?php echo home_url().'?dashboard=user&page=staff_member&tab=staff_member_list&page_action=web_view_hide&staff_member_app=staff_lsit_app';?>'>

												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">

											</a>

											<?php

										}

										else

										{

											?>

											<a href='<?php echo home_url().'?dashboard=user&page=staff_member';?>'>

												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">

											</a>

											<?php

										}

										if($_REQUEST['action'] == 'view')

										{

											echo esc_html_e('View Staff Member', 'gym_mgt' );

										}

									}

									else

									{	

										echo esc_html_e( 'Staff Members', 'gym_mgt' );

									}

								}

								elseif($page_name == 'accountant')

								{

									if($active_tab == 'view_accountant')

									{

										if(isset($_REQUEST['accountant_list_app']) && $_REQUEST['accountant_list_app'] == 'accountantlist_app' || isset($_REQUEST['page_action']) && $_REQUEST['page_action'] == 'web_view_hide')

										{

											?>

											<a href='<?php echo home_url().'?dashboard=user&page=accountant&tab=accountant_list&page_action=web_view_hide&accountant_list_app=accountantlist_app';?>'>

												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">

											</a>

											<?php

										}

										else

										{

											?>

											<a href='<?php echo home_url().'?dashboard=user&page=accountant';?>'>

												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">

											</a>

											<?php

										}

										if($_REQUEST['action'] == 'view')

										{

											echo esc_html_e('View Accountant', 'gym_mgt' );

										}

									}

									else

									{	

										echo esc_html_e( 'Accountant', 'gym_mgt' );

									}

								}

								elseif($page_name == 'group')

								{

									if($active_tab == 'addgroup')

									{

										if(isset($_REQUEST['group_app_view']) && $_REQUEST['group_app_view'] == 'grouplist_app_view' || isset($_REQUEST['page_action']) && $_REQUEST['page_action'] == 'web_view_hide')

										{

											?>

											<a href='<?php echo home_url().'?dashboard=user&page=group&tab=grouplist&page_action=web_view_hide&group_app_view=grouplist_app_view';?>'>

												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">

											</a>

											<?php

										}

										else

										{

											?>

											<a href='<?php echo home_url().'?dashboard=user&page=group';?>'>

												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">

											</a>

											<?php

										}

										if($_REQUEST['action'] == 'edit')

										{

											echo esc_html_e('Edit Group', 'gym_mgt' );

										}

										else

										{

											echo esc_html_e( 'Add Group', 'gym_mgt' );

										}

									}

									else

									{

										echo esc_html_e( 'Group', 'gym_mgt' );

									}

								}

								elseif($page_name == 'activity')

								{

									if($active_tab == 'addactivity' || $active_tab == 'view_membership' || $active_tab == 'view_video')

									{

										if(isset($_REQUEST['activity_list_app']) && $_REQUEST['activity_list_app'] == 'activitylist_app' || isset($_REQUEST['page_action']) && $_REQUEST['page_action'] == 'web_view_hide')

										{

											?>

											<a href='<?php echo home_url().'?dashboard=user&page=activity&tab=activitylist&page_action=web_view_hide&activity_list_app=activitylist_app';?>'>

												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">

											</a>

											<?php

										}

										else

										{

											?>

											<a href='<?php echo home_url().'?dashboard=user&page=activity';?>'>

												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">

											</a>

											<?php

										}

										if($_REQUEST['action'] == 'edit')

										{

											echo esc_html_e('Edit Activity', 'gym_mgt' );

										}

										elseif($active_tab == 'view_membership' && $_REQUEST['action'] == 'view')

										{

											echo esc_html_e('View Membership Plan', 'gym_mgt' );

										}

										elseif($active_tab == 'view_video' && $_REQUEST['action'] == 'view')

										{

											echo esc_html_e('View Video', 'gym_mgt' );

										}

										else

										{

											echo esc_html_e( 'Add Activity', 'gym_mgt' );

										}

									}

									else

									{	

										echo esc_html_e( 'Activity', 'gym_mgt' );

									}

								}

								elseif($page_name == 'attendence')

                                {

									if($active_tab == 'attendance_list')

									{

										echo esc_html_e( 'Member Attendance', 'gym_mgt' );

									}elseif($active_tab == 'staff_attendance_list')

									{

										echo esc_html_e( 'Staff Member Attendance', 'gym_mgt' );

									}else{

										echo esc_html_e( 'Attendance', 'gym_mgt' );

									}

                                }

                                elseif($page_name == 'assign-workout')

                                {

                                    if($active_tab == 'assignworkout')

                                    {

										if(isset($_REQUEST['workout_list_app']) && $_REQUEST['workout_list_app'] == 'workoutassignlist_app' || isset($_REQUEST['page_action']) && $_REQUEST['page_action'] == 'web_view_hide')

										{

											?>

											<a href='<?php echo home_url().'?dashboard=user&page=assign-workout&tab=workoutassignlist&page_action=web_view_hide&workout_list_app=workoutassignlist_app';?>'>

												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">

											</a>

											<?php

										}

										else

										{

											?>

											<a href='<?php echo home_url().'?dashboard=user&page=assign-workout';?>'>

												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">

											</a>

											<?php

										}

                                        if($_REQUEST['action'] == "edit")

                                        {

                                            echo esc_html_e( 'Edit Assign Workout', 'gym_mgt' );

                                        }

                                        elseif($_REQUEST['action'] == "view")

                                        {

											echo esc_html_e('View Assign Workout', 'gym_mgt' );

                                        }

                                        else

                                        {

                                            echo esc_html_e( 'Add Assign Workout', 'gym_mgt' );

                                        }

                                    }

                                    else

                                    {

										if($_REQUEST['tab'] == 'edit_assignworkout')

										{

											?>

											<a href='<?php echo home_url().'?dashboard=user&page=assign-workout';?>'>

												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">

											</a>

											<?php

										}

                                        echo esc_html_e( 'Assign Workout', 'gym_mgt' );

                                    }

                                }

                                elseif($page_name == 'workouts')

                                {

                                    if($active_tab == 'addworkout')

                                    {

										if(isset($_REQUEST['workout_list_app_view']) && $_REQUEST['workout_list_app_view'] == 'workoutlist_app' || isset($_REQUEST['page_action']) && $_REQUEST['page_action'] == 'web_view_hide')

										{

											?>

											<a href='<?php echo home_url().'?dashboard=user&page=workouts&tab=workoutlist&page_action=web_view_hide&workout_list_app_view=workoutlist_app';?>'>

												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">

											</a>

											<?php

										}

										else

										{

											?>

											<a href='<?php echo home_url().'?dashboard=user&page=workouts';?>'>

												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">

											</a>

											<?php

										}

                                        if($_REQUEST['action'] == "edit")

                                        {

                                            echo esc_html_e( 'Edit Workout Log', 'gym_mgt' );

                                        }

                                        elseif($_REQUEST['action'] == "view")

                                        {

                                            echo esc_html_e( 'View Workout Log', 'gym_mgt' );

                                        }

                                        else

                                        {

                                            echo esc_html_e( 'Add Workout Log', 'gym_mgt' );

                                        }

                                    }

                                    elseif($active_tab == 'addmeasurement')

                                    {

                                        if($_REQUEST['action'] == "edit")

                                        {

                                            echo esc_html_e( 'Edit Measurement', 'gym_mgt' );

                                        }

                                        else

                                        {

                                            echo esc_html_e( 'Add Measurement', 'gym_mgt' );

                                        }

                                    }

                                    else

                                    {

                                        echo esc_html_e( 'Workout Log', 'gym_mgt' );

                                    }

                                }

								elseif($page_name == 'nutrition')

                                {

                                    if($active_tab == 'addnutrition')

                                    {

										if(isset($_REQUEST['nutrition_list_app']) && $_REQUEST['nutrition_list_app'] == 'nutritionlist_app' || isset($_REQUEST['page_action']) && $_REQUEST['page_action'] == 'web_view_hide')

										{

											?>

											<a href='<?php echo home_url().'?dashboard=user&page=nutrition&tab=nutritionlist&page_action=web_view_hide&nutrition_list_app=nutritionlist_app';?>'>

												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">

											</a>

                                        	<?php

										}

										else

										{

											?>

											<a href='<?php echo home_url().'?dashboard=user&page=nutrition';?>'>

												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">

											</a>

                                        	<?php

										}

                                        if($_REQUEST['action'] == "edit")

                                        {

                                            echo esc_html_e( 'Edit Nutrition Schedule', 'gym_mgt' );

                                        }

                                        elseif($_REQUEST['action'] == "view")

                                        {

                                            echo esc_html_e( 'Edit Nutrition Schedule', 'gym_mgt' );

                                        }

                                        else

                                        {

                                            echo esc_html_e( 'Add Nutrition Schedule', 'gym_mgt' );

                                        }

                                    }

                                    else

                                    {

                                        echo esc_html_e( 'Nutrition Schedule', 'gym_mgt' );

                                    }

                                }

								elseif($page_name == 'product')

                                {

                                    if($active_tab == 'addproduct')

                                    {

										if(isset($_REQUEST['product_list_app_view']) && $_REQUEST['product_list_app_view'] == 'productlist_app' || isset($_REQUEST['page_action']) && $_REQUEST['page_action'] == 'web_view_hide')

										{

											?>

											<a href='<?php echo home_url().'?dashboard=user&page=product&tab=productlist&page_action=web_view_hide&product_list_app_view=productlist_app';?>'>

												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">

											</a>

											<?php

										}

										else

										{

											?>

											<a href='<?php echo home_url().'?dashboard=user&page=product';?>'>

												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">

											</a>

											<?php

										}

                                        if($_REQUEST['action'] == "edit")

                                        {

                                            echo esc_html_e( 'Edit Product', 'gym_mgt' );

                                        }

                                        else

                                        {

                                            echo esc_html_e( 'Add Product', 'gym_mgt' );

                                        }

                                    }

                                    else

                                    {

                                        echo esc_html_e( 'Product', 'gym_mgt' );

                                    }

                                }

								elseif($page_name == 'store')

                                {

                                    if($active_tab == 'sellproduct')

                                    {

										if(isset($_REQUEST['store_list_app_view']) && $_REQUEST['store_list_app_view'] == 'storelist_app' || isset($_REQUEST['page_action']) && $_REQUEST['page_action'] == 'web_view_hide')

										{

											?>

											<a href='<?php echo home_url().'?dashboard=user&page=store&tab=store&page_action=web_view_hide&store_list_app_view=storelist_app';?>'>

												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">

											</a>

											<?php

										}

										else

										{

											?>

											<a href='<?php echo home_url().'?dashboard=user&page=store';?>'>

												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">

											</a>

											<?php

										}

                                        if($_REQUEST['action'] == "edit")

                                        {

                                            echo esc_html_e( 'Edit Sale Product', 'gym_mgt' );

                                        }

                                        else

                                        {

                                            echo esc_html_e( 'Add Sale Product', 'gym_mgt' );

                                        }

                                    }

									elseif($active_tab == 'view_invoice')

                                    {

										if(isset($_REQUEST['store_list_app_view']) && $_REQUEST['store_list_app_view'] == 'storelist_app' || isset($_REQUEST['page_action']) && $_REQUEST['page_action'] == 'web_view_hide')

										{

											?>

											<a href='<?php echo home_url().'?dashboard=user&page=store&tab=store&page_action=web_view_hide&store_list_app_view=storelist_app';?>'>

												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">

											</a>

											<?php

										}

										else

										{

											?>

											<a href='<?php echo home_url().'?dashboard=user&page=store';?>'>

												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">

											</a>

											<?php

										}

										echo esc_html_e( 'View Invoice', 'gym_mgt' );

									}

                                    else

                                    {

                                        echo esc_html_e( 'Sale Product', 'gym_mgt' );

                                    }

                                }

								elseif($page_name == 'tax')

                                {

                                    if($active_tab == 'addtax')

                                    {

                                        ?>

                                        <a href='<?php echo home_url().'?dashboard=user&page=tax';?>'>

                                            <img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">

                                        </a>

                                        <?php

                                        if($_REQUEST['action'] == "edit")

                                        {

                                            echo esc_html_e( 'Edit Tax', 'gym_mgt' );

                                        }

                                        else

                                        {

                                            echo esc_html_e( 'Add Tax', 'gym_mgt' );

                                        }

                                    }

                                    else

                                    {

                                        echo esc_html_e( 'Tax', 'gym_mgt' );

                                    }

                                }

								elseif($page_name == 'payment')

								{

									if($active_tab == 'addincome' ||  $active_tab == 'incomelist')

									{

										echo esc_html_e( 'Invoice', 'gym_mgt' );

									}

									elseif($active_tab == 'addexpense' || $active_tab == 'expenselist')

									{

										echo esc_html_e( 'Expense', 'gym_mgt' );

									}

									elseif($active_tab == 'view_invoice')

									{

										if($_REQUEST['invoice_type'] == 'income')

										{

											?>

											<a href='<?php echo home_url().'?dashboard=user&page=payment&tab=incomelist';?>'>

												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">

											</a>

											<?php

											echo esc_html_e( 'View Invoice', 'gym_mgt' );

										}

										if($_REQUEST['invoice_type'] == 'expense')

										{

											?>

											<a href='<?php echo home_url().'?dashboard=user&page=payment&tab=expenselist';?>'>

												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">

											</a>

											<?php

											echo esc_html_e( 'View Invoice', 'gym_mgt' );

										}

									}

									else

									{

										echo esc_html_e( 'Invoice', 'gym_mgt' );

									}

								}

								elseif($page_name == 'membership_payment')

                                {

                                    if($active_tab == 'addpayment')

                                    {

                                        ?>

                                        <a href='<?php echo home_url().'?dashboard=user&page=membership_payment';?>'>

                                            <img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">

                                        </a>

                                        <?php

                                        if($_REQUEST['action'] == "edit")

                                        {

                                            echo esc_html_e( 'Edit Membership Payment', 'gym_mgt' );

                                        }

                                        else

                                        {

                                            echo esc_html_e( 'Add Membership Payment', 'gym_mgt' );

                                        }

                                    }

									elseif($active_tab == 'view_invoice')

                                    {

										?>

                                        <a href='<?php echo home_url().'?dashboard=user&page=membership_payment';?>'>

                                            <img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">

                                        </a>

                                        <?php

										echo esc_html_e( 'View Invoice', 'gym_mgt' );

									}

                                    else

                                    {

                                        echo esc_html_e( 'Membership Payment', 'gym_mgt' );

                                    }

                                }

								elseif($page_name == 'sms_setting')

                                {

									echo esc_html_e( 'SMS Setting', 'gym_mgt' );

								}

								elseif($page_name == 'mail_template')

                                {

									echo esc_html_e( 'Email Template', 'gym_mgt' );

								}

								elseif($page_name == 'subscription_history')

                                {

									if($active_tab == 'view_invoice')

                                    {

										if(isset($_REQUEST['page_action'])== 'web_view_hide')

										{

											?>

											<a href='<?php echo home_url().'?dashboard=user&page_action=web_view_hide&page=subscription_history';?>'>

												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">

											</a>

												<?php

										}else{

											?>

												<a href='<?php echo home_url().'?dashboard=user&page=subscription_history';?>'>

												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">

											</a>

											<?php

										}

										echo esc_html_e( 'View Invoice', 'gym_mgt' );

									}

									else

									{

										echo esc_html_e( 'Membership History', 'gym_mgt' );

									}

								}

								elseif($page_name == 'membership')

								{

									if($active_tab == 'addmembership' || $active_tab == 'view-activity')

									{

										if(isset($_REQUEST['membership_app_view']) && $_REQUEST['membership_app_view'] == 'membershiplist_app_view' || isset($_REQUEST['page_action']) && $_REQUEST['page_action'] == 'web_view_hide')

										{

											?>

											<a href='<?php echo home_url().'?dashboard=user&page=membership&tab=membershiplist&page_action=web_view_hide&membership_app_view=membershiplist_app_view';?>'>

												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">

											</a>

											<?php

										}

										else

										{

											?>

											<a href='<?php echo home_url().'?dashboard=user&page=membership';?>'>

												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">

											</a>

											<?php

										}

										if($_REQUEST['action'] == 'edit')

										{

											echo esc_html_e('Edit Membership Plan', 'gym_mgt' );

										}

										elseif($active_tab == 'view-activity')

										{

											echo esc_html_e('View Activity', 'gym_mgt' );

										}

										else

										{

											echo esc_html_e( 'Add Membership Plan', 'gym_mgt' );

										}

									}

									else

									{	

										echo esc_html_e( 'Membership Plan', 'gym_mgt' );

									}

								}

								elseif ($page_name == 'coupon') {

									if($active_tab == 'add_coupon'){

										?>

										<a href='<?php echo home_url().'?dashboard=user&page=coupon';?>'>

											<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">

										</a>

										<?php

										if($_REQUEST['action'] == 'edit')

										{

											echo esc_html_e('Edit Coupon', 'gym_mgt' );

										}else{

											echo esc_html_e('Add New Coupon', 'gym_mgt' );

										}

									}

									else{

										echo esc_html_e( 'Coupon', 'gym_mgt' );

									}

								}

								elseif($page_name == 'class-schedule')

								{

									if($active_tab == 'addclass')

									{

										?>

										<a href='<?php echo home_url().'?dashboard=user&page=class-schedule';?>'>

											<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">

										</a>

										<?php

										if($_REQUEST['action'] == 'edit')

										{

											?>

											<?php

											echo esc_html_e('Class Schedule', 'gym_mgt' );

										}

										else

										{

											?>

											<?php

											echo esc_html_e( 'Class Schedule', 'gym_mgt' );

										}

									}

									elseif($active_tab == 'schedulelist' )

									{

										?>

										<a href='<?php echo home_url().'?dashboard=user&page=class-schedule';?>'>

											<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">

										</a>

										<?php

										echo esc_html_e( 'Class Schedule', 'gym_mgt' );

									}

									elseif($active_tab == 'guest_list')

									{

										?>

										<a href='<?php echo home_url().'?dashboard=user&page=class-schedule';?>'>

											<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">

										</a>

										<?php

										echo esc_html_e( 'Class Schedule', 'gym_mgt' );

									}

									elseif($active_tab == 'class_booking')

									{

										?>

										<a href='<?php echo home_url().'?dashboard=user&page=class-schedule';?>'>

											<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">

										</a>

										<?php

										echo esc_html_e( 'Class Schedule', 'gym_mgt' );

									}

									else

									{

										?>

										<?php

										echo esc_html_e( 'Class Schedule', 'gym_mgt' );

									}

									//echo esc_html_e( 'Class Schedule', 'gym_mgt' );

								}

								elseif($page_name == 'reservation')

								{

									if($active_tab == 'addreservation')

									{

										if(isset($_REQUEST['reservation_list_app_view']) && $_REQUEST['reservation_list_app_view'] == 'reservationlist_app' || isset($_REQUEST['page_action']) && $_REQUEST['page_action'] == 'web_view_hide')

										{

											?>

											<a href='<?php echo home_url().'?dashboard=user&page=reservation&tab=reservationlist&page_action=web_view_hide&reservation_list_app_view=reservationlist_app';?>'>

												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">

											</a>

											<?php

										}

										else

										{

											?>

											<a href='<?php echo home_url().'?dashboard=user&page=reservation';?>'>

												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">

											</a>

											<?php

										}

										if($_REQUEST['action'] == 'edit')

										{

											echo esc_html_e('Edit Reservation', 'gym_mgt' );

										}

										else

										{

											echo esc_html_e( 'Add Reservation', 'gym_mgt' );

										}

									}

									else

									{	

										echo esc_html_e( 'Reservation', 'gym_mgt' );

									}

								}

								elseif($page_name == 'notice')

								{

									if($active_tab == 'addnotice')

									{

										if(isset($_REQUEST['notice_list_app_view']) && $_REQUEST['notice_list_app_view'] == 'noticelist_app' || isset($_REQUEST['page_action']) && $_REQUEST['page_action'] == 'web_view_hide')

										{

											?>

											<a href='<?php echo home_url().'?dashboard=user&page=notice&tab=noticelist&page_action=web_view_hide&notice_list_app_view=noticelist_app';?>'>

												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">

											</a>

											<?php

										}

										else

										{

											?>

											<a href='<?php echo home_url().'?dashboard=user&page=notice';?>'>

												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">

											</a>

											<?php

										}

										if($_REQUEST['action'] == 'edit')

										{

											echo esc_html_e('Edit Notice', 'gym_mgt' );

										}

										else

										{

											echo esc_html_e( 'Add Notice', 'gym_mgt' );

										}

									}

									else

									{	

										echo esc_html_e( 'Notice', 'gym_mgt' );

									}

								}

								elseif($page_name == 'account')

								{

									echo esc_html_e( 'Account', 'gym_mgt' );

								}

								elseif($page_name == 'news_letter')

								{

									echo esc_html_e( 'Newsletter', 'gym_mgt' );

								}

								elseif($page_name == 'message')

								{

									echo esc_html_e( 'Message', 'gym_mgt' );

								}

								elseif($page_name == 'report')

								{

									if($active_tab == 'member_information')

									{

										echo esc_html_e( 'Membership Information Report', 'gym_mgt' );

									}

									elseif($active_tab == 'membership_report'){

										echo esc_html_e( 'Membership Report', 'gym_mgt' );

									}

									elseif($active_tab == 'payment_report'){

										echo esc_html_e( 'Finance/Payment Report', 'gym_mgt' );

									}

									elseif($active_tab == 'attendance_report'){

										echo esc_html_e( 'Attendance Report', 'gym_mgt' );

									}

									elseif($active_tab == 'user_log'){

										echo esc_html_e( 'User Log Report', 'gym_mgt' );

									}

									elseif($active_tab == 'audit_trail'){

										echo esc_html_e( 'Audit Trail Report', 'gym_mgt' );

									}

									else{

										echo esc_html_e( 'Report', 'gym_mgt' );

									}

								}

								elseif($page_name == 'virtual_class')

								{

									if($active_tab == 'edit_meeting')

									{

										?>

										<a href='<?php echo home_url().'?dashboard=user&page=virtual_class';?>'>

											<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">

										</a>

										<?php

										echo esc_html_e('Edit Virtual Class', 'gym_mgt' );

									}

									elseif($active_tab == 'view_past_participle_list')

									{

										?>

										<a href='<?php echo home_url().'?dashboard=user&page=virtual_class';?>'>

											<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">

										</a>

										<?php

										echo esc_html_e('Past Participle List', 'gym_mgt' );

										

									}

									else

									{	

										echo esc_html_e( 'Virtual Class', 'gym_mgt' );

									}

									

								}

								elseif($page_name == 'subscription')

								{

									echo esc_html_e( 'Subscription', 'gym_mgt' );

								}

								elseif($page_name == 'virtual_class')

								{

									if($active_tab == 'edit_meeting')

									{

										?>

										<a href='<?php echo home_url().'?dashboard=user&page=virtual_class';?>'>

											<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">

										</a>

										<?php

										echo esc_html_e('Edit Virtual Class', 'gym_mgt' );

									}

									elseif($active_tab == 'view_past_participle_list')

									{

										?>

										<a href='<?php echo home_url().'?dashboard=user&page=virtual_class';?>'>

											<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">

										</a>

										<?php

										echo esc_html_e('Past Participle List', 'gym_mgt' );

										

									}

									else

									{	

										echo esc_html_e( 'Virtual Class', 'gym_mgt' );

									}

									

								}

								elseif($page_name == 'subscription')

								{

									echo esc_html_e( 'Subscription', 'gym_mgt' );

								}

								?>

							</h3>

							<div class="smgt_add_btn"><!-------- Plus button div -------->

								<?php

								$page_name = $_REQUEST['page'];    

								$active_tab = $_REQUEST['tab'];

								$action_name =$_REQUEST['action'];

								//access right

								$user_access=MJ_gmgt_get_userrole_wise_page_access_right_array();

								if($page_name == "member" && $active_tab != 'addmember' && $active_tab != 'viewmember')

								{

									if($user_access['add']=='1')

									{

										if(isset($_REQUEST['member_list_app']) && $_REQUEST['member_list_app'] == 'memberlist_app' || isset($_REQUEST['page_action']) && $_REQUEST['page_action'] == 'web_view_hide')

										{

											?>

											<a href='<?php echo home_url().'?dashboard=user&page=member&tab=addmember&action=insert&member_list_app=memberlist_app&page_action=web_view_hide';?>'>

												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Add_new_Button.png" ?>">

											</a>

											<?php

										}

										else

										{

											?>

											<a href='<?php echo home_url().'?dashboard=user&page=member&tab=addmember&&action=insert';?>'>

												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Add_new_Button.png" ?>">

											</a>

											<?php

										}

									}

									

								}

								elseif($page_name == "group" && $active_tab != 'addgroup')

								{

									if($user_access['add']=='1')

									{

										if(isset($_REQUEST['group_app_view']) && $_REQUEST['group_app_view'] == 'grouplist_app_view' || isset($_REQUEST['page_action']) && $_REQUEST['page_action'] == 'web_view_hide')

										{

											?>

											<a href='<?php echo home_url().'?dashboard=user&page=group&tab=addgroup&action=insert&group_app_view=grouplist_app_view&page_action=web_view_hide';?>'>

												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Add_new_Button.png" ?>">

											</a>

											<?php

										}

										else

										{

											?>

											<a href='<?php echo home_url().'?dashboard=user&page=group&tab=addgroup&&action=insert';?>'>

												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Add_new_Button.png" ?>">

											</a>

											<?php

										}

									}

								}

								elseif($page_name == "activity" && $active_tab != 'addactivity' && $active_tab != 'view_video' && $active_tab != 'view_membership')

								{

									if($user_access['add']=='1')

									{

										if(isset($_REQUEST['activity_list_app']) && $_REQUEST['activity_list_app'] == 'activitylist_app' || isset($_REQUEST['page_action']) && $_REQUEST['page_action'] == 'web_view_hide')

										{

											?>

											<a href='<?php echo home_url().'?dashboard=user&page=activity&tab=addactivity&&action=insert&page_action=web_view_hide&activity_list_app=activitylist_app';?>'>

												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Add_new_Button.png" ?>">

											</a>

											<?php

										}

										else

										{

											?>

											<a href='<?php echo home_url().'?dashboard=user&page=activity&tab=addactivity&&action=insert';?>'>

												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Add_new_Button.png" ?>">

											</a>

											<?php

										}

									}

								}

								elseif($page_name == "assign-workout" && $active_tab != 'assignworkout' && $active_tab != 'edit_assignworkout')

                                {

                                    if($user_access['add']=='1')

                                    {

										if(isset($_REQUEST['workout_list_app']) && $_REQUEST['workout_list_app'] == 'workoutassignlist_app' || isset($_REQUEST['page_action']) && $_REQUEST['page_action'] == 'web_view_hide')

										{	

											?>

											<a href='<?php echo home_url().'?dashboard=user&page=assign-workout&tab=assignworkout&page_action=web_view_hide&workout_list_app=workoutassignlist_app';?>'>

												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Add_new_Button.png" ?>">

											</a>

											<?php

										}

										else

										{

											?>

											<a href='<?php echo home_url().'?dashboard=user&page=assign-workout&tab=assignworkout';?>'>

												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Add_new_Button.png" ?>">

											</a>

											<?php

										}

                                    }

                                }

                                elseif($page_name == "workouts" && $active_tab != 'addworkout' && $active_tab != 'addmeasurement')

                                {

                                    if($user_access['add']=='1')

                                    {

										if(isset($_REQUEST['workout_list_app_view']) && $_REQUEST['workout_list_app_view'] == 'workoutlist_app' || isset($_REQUEST['page_action']) && $_REQUEST['page_action'] == 'web_view_hide')

										{

											?>

											<a href='<?php echo home_url().'?dashboard=user&page=workouts&tab=addworkout&page_action=web_view_hide&workout_list_app_view=workoutlist_app&action=insert';?>'>

												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Add_new_Button.png" ?>">

											</a>

											<?php

										}

										else

										{

											?>

											<a href='<?php echo home_url().'?dashboard=user&page=workouts&tab=addworkout';?>'>

												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Add_new_Button.png" ?>">

											</a>

											<?php

										}

                                    }

                                }

								elseif($page_name == "nutrition" && $active_tab != 'addnutrition')

                                {

                                    if($user_access['add']=='1')

                                    {

										if(isset($_REQUEST['nutrition_list_app']) && $_REQUEST['nutrition_list_app'] == 'nutritionlist_app' || isset($_REQUEST['page_action']) && $_REQUEST['page_action'] == 'web_view_hide')

										{

											?>

											<a href='<?php echo home_url().'?dashboard=user&page=nutrition&tab=addnutrition&&action=insert&page_action=web_view_hide&nutrition_list_app=nutritionlist_app';?>'>

												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Add_new_Button.png" ?>">

											</a>

											<?php

										}

										else

										{

											?>

											<a href='<?php echo home_url().'?dashboard=user&page=nutrition&tab=addnutrition';?>'>

												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Add_new_Button.png" ?>">

											</a>

											<?php

										}

                                    }

                                }

								elseif($page_name == "product" && $active_tab != 'addproduct')

                                {

                                    if($user_access['add']=='1')

                                    {

										if(isset($_REQUEST['product_list_app_view']) && $_REQUEST['product_list_app_view'] == 'productlist_app' || isset($_REQUEST['page_action']) && $_REQUEST['page_action'] == 'web_view_hide')

										{

											?>

											<a href='<?php echo home_url().'?dashboard=user&page=product&tab=addproduct&action=insert&page_action=web_view_hide&product_list_app_view=productlist_app';?>'>

												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Add_new_Button.png" ?>">

											</a>

											<?php

										}

										else

										{

											?>

											<a href='<?php echo home_url().'?dashboard=user&page=product&tab=addproduct';?>'>

												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Add_new_Button.png" ?>">

											</a>

											<?php

										}

                                    }

                                }

								elseif($page_name == "store" && $active_tab != 'sellproduct' && $active_tab != 'view_invoice')

                                {

                                    if($user_access['add']=='1')

                                    {

										if(isset($_REQUEST['store_list_app_view']) && $_REQUEST['store_list_app_view'] == 'storelist_app' || isset($_REQUEST['page_action']) && $_REQUEST['page_action'] == 'web_view_hide')

										{

											?>

											<a href='<?php echo home_url().'?dashboard=user&page=store&tab=sellproduct&page_action=web_view_hide&store_list_app_view=storelist_app&action=insert';?>'>

												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Add_new_Button.png" ?>">

											</a>

											<?php

										}

										else

										{

											?>

											<a href='<?php echo home_url().'?dashboard=user&page=store&tab=sellproduct';?>'>

												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Add_new_Button.png" ?>">

											</a>

											<?php

										}

                                    }

                                }

								elseif($page_name == "tax" && $active_tab != 'addtax')

                                {

                                    if($user_access['add']=='1')

                                    {

                                        ?>

                                        <a href='<?php echo home_url().'?dashboard=user&page=tax&tab=addtax';?>'>

                                            <img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Add_new_Button.png" ?>">

                                        </a>

                                        <?php

                                    }

                                }

								elseif($page_name == "payment")

								{

									if($user_access['add']=='1')

                                    {

										if($active_tab == 'incomelist')

										{

											?>

											<a href='<?php echo home_url().'?dashboard=user&page=payment&tab=addincome';?>'>

												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Add_new_Button.png" ?>">

											</a>

											<?php

										}

										elseif($active_tab == 'expenselist')

										{

											?>

											<a href='<?php echo home_url().'?dashboard=user&page=payment&tab=addexpense';?>'>

												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Add_new_Button.png" ?>">

											</a>

											<?php

										}

									}

								}

								elseif($page_name == "membership_payment" && $active_tab != 'addpayment' && $active_tab != 'view_invoice' )

                                {

                                    if($user_access['add']=='1')

                                    {

                                        ?>

                                        <a href='<?php echo home_url().'?dashboard=user&page=membership_payment&tab=addpayment';?>'>

                                            <img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Add_new_Button.png" ?>">

                                        </a>

                                        <?php

                                    }

                                }

								elseif($page_name == "membership" && $active_tab != 'addmembership' && $active_tab != 'view-activity')

								{

									if($user_access['add']=='1')

                                    {

										if(isset($_REQUEST['membership_app_view']) && $_REQUEST['membership_app_view'] == 'membershiplist_app_view' || isset($_REQUEST['page_action']) && $_REQUEST['page_action'] == 'web_view_hide')

										{

											?>

											<a href='<?php echo home_url().'?dashboard=user&page=membership&tab=addmembership&action=insert&membership_app_view=membershiplist_app_view&page_action=web_view_hide';?>'>

												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Add_new_Button.png" ?>">

											</a>

											<?php

										}

										else

										{

											?>

											<a href='<?php echo home_url().'?dashboard=user&page=membership&tab=addmembership&&action=insert';?>'>

												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Add_new_Button.png" ?>">

											</a>

											<?php

										}

                                    }

								}

								elseif($page_name == "coupon" && $active_tab != 'add_coupon'){

									if($user_access['add']=='1')

                                    {

										?>

											<a href='<?php echo home_url().'?dashboard=user&page=coupon&tab=add_coupon';?>'>

												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Add_new_Button.png" ?>">

											</a>

											<?php

									}

								}

								elseif($page_name == "reservation" && $active_tab != 'addreservation')

								{

									if($user_access['add']=='1')

                                    {

										if(isset($_REQUEST['reservation_list_app_view']) && $_REQUEST['reservation_list_app_view'] == 'reservationlist_app' || isset($_REQUEST['page_action']) && $_REQUEST['page_action'] == 'web_view_hide')

										{

											?>

											<a href='<?php echo home_url().'?dashboard=user&page=reservation&tab=addreservation&page_action=web_view_hide&reservation_list_app_view=reservationlist_app&action=insert';?>'>

												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Add_new_Button.png" ?>">

											</a>

											<?php

										}

										else

										{

											?>

											<a href='<?php echo home_url().'?dashboard=user&page=reservation&tab=addreservation&&action=insert';?>'>

												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Add_new_Button.png" ?>">

											</a>

											<?php

										}

									}

								}

								elseif($page_name == "notice" && $active_tab != 'addnotice')

								{

									if($user_access['add']=='1')

                                    {

										if(isset($_REQUEST['notice_list_app_view']) && $_REQUEST['notice_list_app_view'] == 'noticelist_app' || isset($_REQUEST['page_action']) && $_REQUEST['page_action'] == 'web_view_hide')

										{

											?>

											<a href='<?php echo home_url().'?dashboard=user&page=notice&tab=addnotice&page_action=web_view_hide&notice_list_app_view=noticelist_app&action=insert';?>'>

												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Add_new_Button.png" ?>">

											</a>

											<?php

										}

										else

										{

											?>

											<a href='<?php echo home_url().'?dashboard=user&page=notice&tab=addnotice&action=insert';?>'>

												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Add_new_Button.png" ?>">

											</a>

											<?php

										}

									}

								}

								elseif($page_name == "message" && $active_tab != 'compose')

								{

									if($user_access['add']=='1')

									{

										if(isset($_REQUEST['message_list_app_view']) && $_REQUEST['message_list_app_view'] == 'messagelist_app')

										{

											?>

											<a href='<?php echo home_url().'?dashboard=user&page=message&tab=compose&page_action=web_view_hide&message_list_app_view=messagelist_app';?>'>

												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Add_new_Button.png" ?>">

											</a>

											<?php

										}

										else

										{

											?>

											<a href='<?php echo home_url().'?dashboard=user&page=message&tab=compose';?>'>

												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Add_new_Button.png" ?>">

											</a>

											<?php

										}	

									}

								}

								?>

							</div>

						</div>

					</div>

					<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 staff_member_app_dis_none">

						<div class="gmgt-setting-notification">

							<a href='<?php echo home_url().'?dashboard=user&page=message';?>' class="gmgt-setting-notification-bg">

								<img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Bell-Notification.png"?>" class="gmgt-right-heder-list-link">

								<spna class="between_border123 gmgt-right-heder-list-link"> </span>

							</a>

							<div class="gmgt-user-dropdown">

								<ul class="">

									<!-- BEGIN USER LOGIN DROPDOWN -->

									<li class="">

										<?php

										$role_name=mj_gmgt_get_user_role(get_current_user_id());

										$user_info = get_userdata(get_current_user_id());

										$userimage=$user_info->gmgt_user_avatar;

										?>

										<a class="" href="#" data-bs-toggle="dropdown" aria-expanded="false">

											<img src="

											<?php

											if(!empty($userimage)) 

											{

												echo $userimage;

											}

											else

											{

												if($role_name == "staff_member")

												{

													echo get_option( 'gmgt_Staffmember_logo' ); 

												}

												elseif($role_name == "member")

												{

													echo get_option( 'gmgt_member_logo' ); 

												}

												else

												{

													echo get_option( 'gmgt_Account_logo' ); 

												}

											} 

											?>

											" class="gmgt-dropdown-userimg" >

										</a>

										<ul class="dropdown-menu extended action_dropdawn logout_dropdown_menu logout heder-dropdown-menu" aria-labelledby="dropdownMenuLink">

											<li class="float_left_width_100 ">

												<a class="dropdown-item gmgt-back-wp float_left_width_100" href="<?php echo home_url().'?dashboard=user&page=account';?>"><i class="fa fa-user"></i>

												<?php esc_html_e( 'My Profile', 'gym_mgt' ); ?></a>

											</li>

											<li class="float_left_width_100 ">

												<a class="dropdown-item float_left_width_100" href="<?php echo wp_logout_url(home_url()); ?>"><i class="fa fa-sign-out"></i><?php esc_html_e( 'Log Out', 'gym_mgt' ); ?></a>

											</li>

										</ul>

									</li>

									<!-- END USER LOGIN DROPDOWN -->

								</ul>

							</div>

						</div>

					</div>

				</div>

			</div>

		</div>

		<div class="row main_page forntend_dashboard_main_div"  style="margin: 0;">

			<div class="col-sm-12 col-md-12 col-lg-2 col-xl-2 padding_0 staff_member_app_dis_none" id="main_sidebar-bgcolor">

				<!-- menu sidebar main div strat  -->

				<div class="main_sidebar">

					<nav id="sidebar">

						<ul class='gmgt-navigation gmgt-navigation-forntend navbar-collapse rs_side_menu_bgcolor' id="navbarNav">

							<li class="card-icon">

								<a href="<?php echo home_url().'?dashboard=user';?>" class="<?php if (isset ( $_REQUEST ['dashboard'] ) && $_REQUEST ['dashboard'] == "user" && $_REQUEST ['page'] == "") { echo "active"; } ?>">

									<img class="icon img-top" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/dashboards.png"?>">

									<!-- <img class="icon " src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/icons/White_icons/dashboards.png"?>"> -->

									<img class="icon " src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/dashboards.png"?>">

									<span><?php esc_html_e( 'Dashboard', 'gym_mgt' ); ?></span>

								</a>

							</li>

							<?php

							$page = 'member';

							$member=MJ_gmgt_page_access_rolewise_accessright_dashboard($page);

							$page_1='staff_member';

							$staff_member=MJ_gmgt_page_access_rolewise_accessright_dashboard($page_1);

							$page_2='accountant';

							$accountant=MJ_gmgt_page_access_rolewise_accessright_dashboard($page_2);

							$page_3='group';

							$group=MJ_gmgt_page_access_rolewise_accessright_dashboard($page_3);

							if($member == 1 || $staff_member == 1 || $accountant == 1 || $group == 1)

							{

								?>

								<li class="has-submenu nav-item card-icon">

									<a href='#' class=" <?php if ($_REQUEST ['page'] == "member" ||  $_REQUEST ['page'] == "staff_member" || $_REQUEST ['page'] == "accountant" || $_REQUEST ['page'] == "group" ) { echo "active"; } ?>">

										<img class="icon img-top" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/User Management.png"?>">

										<img class="icon " src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/User Management.png"?>">

										<span><?php esc_html_e('User Management', 'gym_mgt' ); ?></span>

										<i class="fa <?php echo $rtl_left_icon_class; ?> dropdown-right-icon icon" aria-hidden="true"></i>

										<i class="fa fa-chevron-down icon dropdown-down-icon" aria-hidden="true"></i>

									</a>

									<ul class='submenu dropdown-menu'>

										<?php

										if($member)

										{

											?>

											<li class=''>

												<a href='<?php echo home_url().'?dashboard=user&page=member';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "member") { echo "active"; } ?>">

												<span><?php esc_html_e( 'Members', 'gym_mgt' ); ?></span>

												</a>

											</li>

											<?php

										}

										if($staff_member)

										{

											?>

											<li class=''>

												<a href='<?php echo home_url().'?dashboard=user&page=staff_member';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "staff_member") { echo "active"; } ?>">

												<span><?php esc_html_e( 'Staff Members', 'gym_mgt' ); ?></span>

												</a>

											</li>

											<?php

										}

										if($accountant)

										{

											?>

											<li class=''>

												<a href='<?php echo home_url().'?dashboard=user&page=accountant';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "accountant") { echo "active"; } ?>">

												<span><?php esc_html_e( 'Accountant', 'gym_mgt' ); ?></span>

												</a>

											</li>

											<?php

										}

										if($group)

										{

											?>

											<li class=''>

												<a href='<?php echo home_url().'?dashboard=user&page=group';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "group") { echo "active"; } ?>">

												<span><?php esc_html_e( 'Group', 'gym_mgt' ); ?></span>

												</a>

											</li>

											<?php

										}

										?>

									</ul> 

								</li>

								<?php

							}

							$activity = 'activity';

							$activity=MJ_gmgt_page_access_rolewise_accessright_dashboard($activity);

							$membership = 'membership';

							$membership=MJ_gmgt_page_access_rolewise_accessright_dashboard($membership);

							$coupon = 'coupon';

							$coupon=MJ_gmgt_page_access_rolewise_accessright_dashboard($coupon);

							if($activity == 1 || $membership == 1 || $coupon == 1)

							{

								?>

								<li class="has-submenu nav-item card-icon">

									<a href='#' class=" <?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "activity" || $_REQUEST ['page'] && $_REQUEST ['page'] == "membership" || $_REQUEST ['page'] && $_REQUEST ['page'] == "coupon") { echo "active"; } ?>">

										<img class="icon img-top" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/Membership.png"?>">

										<img class="icon " src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/Membership.png"?>">

										<span class="margin_left_15px"><?php esc_html_e('Membership Plan', 'gym_mgt' ); ?></span>

										<i class="fa <?php echo $rtl_left_icon_class; ?> dropdown-right-icon icon" aria-hidden="true"></i>

										<i class="fa fa-chevron-down icon dropdown-down-icon" aria-hidden="true"></i>

									</a>

									<ul class='submenu dropdown-menu'>

										<?php

										if($activity)

										{

											?>

											<li class=''>

												<a href='<?php echo home_url().'?dashboard=user&page=activity';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "activity") { echo "active"; } ?>">

												<span><?php esc_html_e( 'Activity', 'gym_mgt' ); ?></span>

												</a>

											</li>

											<?php

										}

										if($membership)

										{

											?>

											<li class=''>

												<a href='<?php echo home_url().'?dashboard=user&page=membership';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "membership") { echo "active"; } ?>">

												<span><?php esc_html_e( 'Membership Plan', 'gym_mgt' ); ?></span>

												</a>

											</li>

											<?php

										}

										if($coupon)

										{

											?>

											<li class=''>

												<a href='<?php echo home_url().'?dashboard=user&page=coupon';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "coupon") { echo "active"; } ?>">

												<span><?php esc_html_e( 'Coupon', 'gym_mgt' ); ?></span>

												</a>

											</li>

											<?php

										}

										?>

									</ul> 

								</li>

								<?php

							}

							$class_schedule='class-schedule';

							$class_schedule=MJ_gmgt_page_access_rolewise_accessright_dashboard($class_schedule);

							if($class_schedule)

							{

								?>

								<li class="card-icon">

									<a href="<?php echo home_url().'?dashboard=user&page=class-schedule';?>" class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "class-schedule") { echo "active"; } ?>">

										<img class="icon img-top" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/Class Schedule.png"?>">

										<img class="icon " src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/Class Schedule.png"?>">

										<span><?php esc_html_e( 'Class Schedule', 'gym_mgt' ); ?></span>

									</a>

								</li>

								<?php

							}

							$virtual_class='virtual_class';

							$virtual_class=MJ_gmgt_page_access_rolewise_accessright_dashboard($virtual_class);

							if(get_option('gmgt_enable_virtual_classschedule') == 'yes')

							{

								if($virtual_class)

								{

									?>

									<li class="card-icon">

										<a href="<?php echo home_url().'?dashboard=user&page=virtual_class';?>" class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "virtual_class") { echo "active"; } ?>">

											<img class="icon img-top" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/White_Icons/Virtual_class_black.png"?>" style="height:20px;width:20px;">

											<img class="icon " src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/White_Icons/Virtual_class.png"?>" style="height:20px;width:20px;">

											<span><?php esc_html_e( 'Virtual Class', 'gym_mgt' ); ?></span>

										</a>

									</li>

									<?php

								}

							}

							$attendence='attendence';

							$attendence=MJ_gmgt_page_access_rolewise_accessright_dashboard($attendence);

							if($attendence)

							{

								?>

								<li class="card-icon has-submenu nav-item">

									<a href="#" class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "attendence") { echo "active"; } ?>">

										<img class="icon img-top" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/Attendance.png"?>">

										<img class="icon " src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/Attendance.png"?>">

										<span><?php esc_html_e( 'Attendance', 'gym_mgt' ); ?></span>

										<i class="fa <?php echo $rtl_left_icon_class; ?> dropdown-right-icon icon" aria-hidden="true"></i>

										<i class="fa fa-chevron-down icon dropdown-down-icon" aria-hidden="true"></i>

									</a>



									<ul class='submenu dropdown-menu'>

										<li class=''>

											<a href='<?php echo home_url().'?dashboard=user&page=attendence&tab=attendance_list';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "assign-workout") { echo "active"; } ?>">

											<span><?php esc_html_e( 'Member Attendance', 'gym_mgt' ); ?></span>

											</a>

										</li>

										<?php

										if($obj_gym->role == 'staff_member')

										{

											?>

											<li class=''>

												<a href='<?php echo home_url().'?dashboard=user&page=attendence&tab=staff_attendance_list';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "assign-workout") { echo "active"; } ?>">

												<span><?php esc_html_e( 'Staff Member Attendance', 'gym_mgt' ); ?></span>

												</a>

											</li>

											<?php

										}

										?>

									</ul> 

								</li>

								</li>

								<?php

							}

							$assign_workout = 'assign-workout';

							$assign_workout=MJ_gmgt_page_access_rolewise_accessright_dashboard($assign_workout);

							$workouts = 'workouts';

							$workouts=MJ_gmgt_page_access_rolewise_accessright_dashboard($workouts);

							if($assign_workout == 1 || $workouts == 1)

							{

								?>

								<li class="has-submenu nav-item card-icon">

									<a href='#' class=" <?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "assign-workout" || $_REQUEST ['page'] && $_REQUEST ['page'] == "workouts"  ) { echo "active"; } ?>">

										<img class="icon img-top" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/Workout.png"?>">

										<img class="icon " src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/Workout.png"?>">

										<span class=""><?php esc_html_e('Workout', 'gym_mgt' ); ?></span>

										<i class="fa <?php echo $rtl_left_icon_class; ?> dropdown-right-icon icon" aria-hidden="true"></i>

										<i class="fa fa-chevron-down icon dropdown-down-icon" aria-hidden="true"></i>

									</a>

									<ul class='submenu dropdown-menu'>

										<?php

										if($assign_workout)

										{

											?>

											<li class=''>

												<a href='<?php echo home_url().'?dashboard=user&page=assign-workout';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "assign-workout") { echo "active"; } ?>">

												<span><?php esc_html_e( 'Assign Workout', 'gym_mgt' ); ?></span>

												</a>

											</li>

											<?php

										}

										if($workouts)

										{

											?>

											<li class=''>

												<a href='<?php echo home_url().'?dashboard=user&page=workouts';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "workouts") { echo "active"; } ?>">

												<span><?php esc_html_e( 'Daily Workout', 'gym_mgt' ); ?></span>

												</a>

											</li>

											<li class=''>

												<a href='<?php echo home_url().'?dashboard=user&page=workouts&tab=addmeasurement';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "gmgt_workout") { echo "active"; } ?>">

												<span><?php esc_html_e( 'Measurement', 'gym_mgt' ); ?></span>

												</a>

											</li>

											<?php

										}

										?>

									</ul> 

								</li>

								<?php

							}

							$nutrition='nutrition';

							$nutrition=MJ_gmgt_page_access_rolewise_accessright_dashboard($nutrition);

							if($nutrition)

							{

								?>

								<li class="card-icon">

									<a href='<?php echo home_url().'?dashboard=user&page=nutrition';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "nutrition") { echo "active"; } ?>">

										<img class="icon img-top" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/Nutrition Schedule.png"?>">

										<img class="icon " src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/Nutrition Schedule.png"?>">

										<span><?php esc_html_e( 'Nutrition Schedule', 'gym_mgt' ); ?></span>

									</a>

								</li>

								<?php

							}

							$product = 'product';

							$product=MJ_gmgt_page_access_rolewise_accessright_dashboard($product);

							$store = 'store';

							$store=MJ_gmgt_page_access_rolewise_accessright_dashboard($store);

							if($product == 1 || $store == 1)

							{

								?>

								<li class="has-submenu nav-item card-icon">

									<a href='#' class=" <?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "product" || $_REQUEST ['page'] && $_REQUEST ['page'] == "store" ) { echo "active"; } ?>">

										<img class="icon img-top" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/Store.png"?>">

										<img class="icon " src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/Store.png"?>">

										<span><?php esc_html_e('Store', 'gym_mgt' ); ?></span>

										<i class="fa <?php echo $rtl_left_icon_class; ?> dropdown-right-icon icon" aria-hidden="true"></i>

										<i class="fa fa-chevron-down icon dropdown-down-icon" aria-hidden="true"></i>

									</a>

									<ul class='submenu dropdown-menu'>

										<?php

										if($product)

										{

											?>

											<li class=''>

												<a href='<?php echo home_url().'?dashboard=user&page=product';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "product") { echo "active"; } ?>">

												<span><?php esc_html_e( 'Product', 'gym_mgt' ); ?></span>

												</a>

											</li>

											<?php

										}

										if($store)

										{

											?>

											<li class=''>

												<a href='<?php echo home_url().'?dashboard=user&page=store';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "store") { echo "active"; } ?>">

												<span><?php esc_html_e( 'Sale Product', 'gym_mgt' ); ?></span>

												</a>

											</li>

											<?php

										}

										?>

									</ul> 

								</li>

								<?php

							}

							$tax = 'tax';

							$tax=MJ_gmgt_page_access_rolewise_accessright_dashboard($tax);

							$membership_payment = 'membership_payment';

							$membership_payment=MJ_gmgt_page_access_rolewise_accessright_dashboard($membership_payment);

							$payment = 'payment';

							$payment=MJ_gmgt_page_access_rolewise_accessright_dashboard($payment);

							if($tax == 1 || $membership_payment == 1 || $payment == 1)

							{

								?>

								<li class="has-submenu nav-item card-icon">

									<a href='#' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "tax" || $_REQUEST ['page'] && $_REQUEST ['page'] == "membership_payment" || $_REQUEST ['page'] && $_REQUEST ['page'] == "payment") { echo "active"; } ?>">

										<img class="icon img-top" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/Payment.png"?>">

										<img class="icon " src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/Payment.png"?>">

										<span><?php esc_html_e( 'Payment', 'gym_mgt' ); ?></span>

										<i class="fa <?php echo $rtl_left_icon_class; ?> dropdown-right-icon icon" aria-hidden="true"></i>

										<i class="fa fa-chevron-down icon dropdown-down-icon" aria-hidden="true"></i>

									</a>

									<ul class='submenu dropdown-menu'>

										<?php

										if($tax)

										{

											?>

											<li class=''>

												<a href='<?php echo home_url().'?dashboard=user&page=tax';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "tax") { echo "active"; } ?>">

												<span><?php esc_html_e( 'Tax', 'gym_mgt' ); ?></span>

												</a>

											</li>

											<?php

										}

										if($membership_payment)

										{

											?>

											<li class=''>

												<a href='<?php echo home_url().'?dashboard=user&page=membership_payment';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "membership_payment") { echo "active"; } ?>">

												<span><?php esc_html_e( 'Membership Payment', 'gym_mgt' ); ?></span>

												</a>

											</li>

											<?php

										}

										if($payment)

										{

											?>

											<li class=''>

												<a href='<?php echo home_url().'?dashboard=user&page=payment&tab=incomelist';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "payment") { echo "active"; } ?>">

												<span><?php esc_html_e( 'Payment', 'gym_mgt' ); ?></span>

												</a>

											</li>

											<?php

										}

										?>

									</ul> 

								</li>

								<?php

							}

							$reservation = 'reservation';

							$reservation=MJ_gmgt_page_access_rolewise_accessright_dashboard($reservation);

							if($reservation)

							{

								?>

								<li class="card-icon ">

									<a href='<?php echo home_url().'?dashboard=user&page=reservation';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "reservation") { echo "active"; } ?>">

									<img class="icon img-top" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/Reservation.png"?>">

									<img class="icon " src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/Reservation.png"?>">

									<span><?php esc_html_e( 'Reservation', 'gym_mgt' ); ?></span>

									</a>

								</li>

								<?php

							}

							$report = 'report';

							$report=MJ_gmgt_page_access_rolewise_accessright_dashboard($report);

							if($report)

							{

								?>

								<li class="card-icon has-submenu nav-item">

									<a href='#' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "report") { echo "active"; } ?>">

										<img class="icon img-top" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/report.png"?>">

										<img class="icon " src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/report.png"?>">

										<span><?php esc_html_e( 'Report', 'gym_mgt' ); ?></span>

										<i class="fa <?php echo $rtl_left_icon_class; ?> dropdown-right-icon icon" aria-hidden="true"></i>

										<i class="fa fa-chevron-down icon dropdown-down-icon" aria-hidden="true"></i>

									</a>

									<ul class='submenu dropdown-menu'>

										

										<li class=''>

											<a href='<?php echo home_url().'?dashboard=user&page=report&tab=member_information';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "report") { echo "active"; } ?>">

											<span><?php esc_html_e( 'Member Information', 'gym_mgt' ); ?></span>

											</a>

										</li>

										<li class=''>

											<a href='<?php echo home_url().'?dashboard=user&page=report&tab=membership_report&tab1=membership_report';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "report") { echo "active"; } ?>">

											<span><?php esc_html_e( 'Membership', 'gym_mgt' ); ?></span>

											</a>

										</li>

										<li class=''>

											<a href='<?php echo home_url().'?dashboard=user&page=report&tab=payment_report';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "report") { echo "active"; } ?>">

											<span><?php esc_html_e( 'Finance/Payment', 'gym_mgt' ); ?></span>

											</a>

										</li>

										<li class=''>

											<a href='<?php echo home_url().'?dashboard=user&page=report&tab=attendance_report';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "report") { echo "active"; } ?>">

											<span><?php esc_html_e( 'Attendance', 'gym_mgt' ); ?></span>

											</a>

										</li>

										<li class=''>

											<a href='<?php echo home_url().'?dashboard=user&page=report&tab=user_log';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "report") { echo "active"; } ?>">

											<span><?php esc_html_e( 'User Log', 'gym_mgt' ); ?></span>

											</a>

										</li>

										<li class=''>

											<a href='<?php echo home_url().'?dashboard=user&page=report&tab=audit_trail';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "report") { echo "active"; } ?>">

											<span><?php esc_html_e( 'Audit Trail Report', 'gym_mgt' ); ?></span>

											</a>

										</li>

									</ul>

								</li>

								<?php

							}

							$news_letter = 'news_letter';

							$news_letter=MJ_gmgt_page_access_rolewise_accessright_dashboard($news_letter);

							$notice = 'notice';

							$notice=MJ_gmgt_page_access_rolewise_accessright_dashboard($notice);

							$message = 'message';

							$message=MJ_gmgt_page_access_rolewise_accessright_dashboard($message);

							if($news_letter == 1 || $notice == 1 || $message == 1)

							{

								?>

								<li class="has-submenu nav-item card-icon">

									<a href='#' class=" <?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "news_letter" || $_REQUEST ['page'] && $_REQUEST ['page'] == "notice" || $_REQUEST ['page'] && $_REQUEST ['page'] == "message" ) { echo "active"; } ?>">

										<img class="icon img-top" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/Notification.png"?>">

										<img class="icon " src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/Notification.png"?>">

										<span><?php esc_html_e('Notifications', 'gym_mgt' ); ?></span>

										<i class="fa <?php echo $rtl_left_icon_class; ?> dropdown-right-icon icon" aria-hidden="true"></i>

										<i class="fa fa-chevron-down icon dropdown-down-icon" aria-hidden="true"></i>

									</a>

									<ul class='submenu dropdown-menu'>

										<?php

										if($news_letter)

										{

											?>

											<li class=''>

												<a href='<?php echo home_url().'?dashboard=user&page=news_letter';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "news_letter") { echo "active"; } ?>">

												<span><?php esc_html_e( 'Newsletter', 'gym_mgt' ); ?></span>

												</a>

											</li>

											<?php

										}

										if($notice)

										{

											?>

											<li class=''>

												<a href='<?php echo home_url().'?dashboard=user&page=notice';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "notice") { echo "active"; } ?>">

												<span><?php esc_html_e( 'Notice', 'gym_mgt' ); ?></span>

												</a>

											</li>

											<?php

										}

										if($message)

										{

											?>

											<li class=''>

												<a href='<?php echo home_url().'?dashboard=user&page=message';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "message") { echo "active"; } ?>">

												<span><?php esc_html_e( 'Message', 'gym_mgt' ); ?></span>

												</a>

											</li>

											<?php

										}

										?>

									</ul> 

								</li>

								<?php

							}

							$sms_setting = 'sms_setting';

							$sms_setting=MJ_gmgt_page_access_rolewise_accessright_dashboard($sms_setting);

							$mail_template = 'mail_template';

							$mail_template=MJ_gmgt_page_access_rolewise_accessright_dashboard($mail_template);

							if($sms_setting == 1 || $mail_template == 1)

							{

								?>

								<li class="has-submenu nav-item card-icon">

									<a href='#' class=" <?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "sms_setting" || $_REQUEST ['page'] && $_REQUEST ['page'] == "mail_template" ) { echo "active"; } ?>">

										<img class="icon img-top" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/Settings.png"?>">

										<img class="icon " src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/Settings.png"?>">

										<span><?php esc_html_e('System Settings', 'gym_mgt' ); ?></span>

										<i class="fa <?php echo $rtl_left_icon_class; ?> dropdown-right-icon icon" aria-hidden="true"></i>

										<i class="fa fa-chevron-down icon dropdown-down-icon" aria-hidden="true"></i>

									</a>

									<ul class='submenu dropdown-menu'>

										<li class=''>

											<a href='<?php echo home_url().'?dashboard=user&page=sms_setting';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "sms_setting") { echo "active"; } ?>">

											<span><?php esc_html_e( 'SMS Setting', 'gym_mgt' ); ?></span>

											</a>

										</li>

										<li class=''>

											<a href='<?php echo home_url().'?dashboard=user&page=mail_template';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "mail_template") { echo "active"; } ?>">

											<span><?php esc_html_e( 'Email Template', 'gym_mgt' ); ?></span>

											</a>

										</li>

									</ul> 

								</li>

								<?php

							}

							$subscription_history = 'subscription_history';

							$subscription_history=MJ_gmgt_page_access_rolewise_accessright_dashboard($subscription_history);

							if($subscription_history)

							{

								?>

								<li class="card-icon">

									<a href='<?php echo home_url().'?dashboard=user&page=subscription_history';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "subscription_history") { echo "active"; } ?>">

									<img class="icon img-top" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/suscription_history.png"?>">

									<img class="icon " src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/subcription-white.png"?>">

									<span><?php esc_html_e( 'Membership History', 'gym_mgt' ); ?></span>

									</a>

								</li>

								<?php

							}

							$subscription = 'subscription';

							$subscription=MJ_gmgt_page_access_rolewise_accessright_dashboard($subscription);

							if(get_option('gym_recurring_enable') == 'yes' || !empty(get_option('gym_recurring_enable')))

							{

								// if($subscription)

								// {

									?>

									<li class="card-icon">

										<a href='<?php echo home_url().'?dashboard=user&page=subscription';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "subscription") { echo "active"; } ?>">

										<img class="icon img-top" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/suscription_history.png"?>">

										<img class="icon " src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/subcription-white.png"?>">

										<span><?php esc_html_e( 'Subscription', 'gym_mgt' ); ?></span>

										</a>

									</li>

									<?php

								// }

							}

							$account = 'account';

							$account=MJ_gmgt_page_access_rolewise_accessright_dashboard($account);

							if($account)

							{

								?>

								<li class="card-icon">

									<a href='<?php echo home_url().'?dashboard=user&page=account';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "account") { echo "active"; } ?>">

									<img class="icon img-top" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/Account.png"?>">

									<img class="icon " src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/Account-white.png"?>">

									<span><?php esc_html_e( 'Account', 'gym_mgt' ); ?></span>

									</a>

								</li>

								<?php

							}

							?>

						</ul>

					</nav>	

				</div>

				<!-- End menu sidebar main div  -->

			</div>

			<div class="col col-sm-12 col-md-12 col-lg-10 col-xl-10 gms_main_inner_bg dashboard_margin padding_left_0 padding_right_0">

				<div class="page-inner min_height_1088 admin_homepage_padding_top frontend_homepage_padding_top">

					<div id="main-wrapper" class="main-wrapper-div label_margin_top_15px admin_dashboard">

						<?php 

						if (isset( $_REQUEST ['page'] )) 

						{

							

							$membershistatus=get_user_meta($user_id,'membership_status',true);



							$unpaid_membership_status=get_user_meta($user_id,'unpaid_membership_status',true);



							if($role == 'member')

							{

								if($membershistatus == 'Expired')

								{

									if($_REQUEST ['page'] == "subscription" || $_REQUEST ['page'] == "subscription_history" || $_REQUEST ['page'] == "membership_payment")

									{

										?>

										<div class="page_main_div">

											<?php

											$page_name = $_REQUEST ['page']; 

											require_once GMS_PLUGIN_DIR . '/template/'.$page_name.'.php';

											?>

										</div>

									<?php 

									}

									else

									{

										?>

										<div class="membership_Expired">

											<h2 class="membership_label"><?php esc_html_e("Your membership has been expired. Please contact your system administrator.",'gym_mgt'); ?></h2>

										</div>

										<?php die;

									}

								}

								elseif($membershistatus == 'Dropped')

								{

									?>

									<div class="membership_Expired">

										<h2 class="membership_label"><?php esc_html_e("Your membership has been dropped. Please contact your system administrator.",'gym_mgt'); ?></h2>

									</div>

									<?php die;	

								}

								else

								{

									if($unpaid_membership_status == 'Expired')

									{

										if($_REQUEST ['page'] == "subscription" || $_REQUEST ['page'] == "subscription_history" || $_REQUEST ['page'] == "membership_payment" || $_REQUEST['page'] == "payment")

										{

											?>

											<div class="page_main_div">

												<?php

												$page_name = $_REQUEST ['page']; 

												require_once GMS_PLUGIN_DIR . '/template/'.$page_name.'.php';

												?>

											</div>

										<?php 

										}

										else

										{

											?>

											<div class="membership_Expired">

												<h2 class="membership_label"><?php esc_html_e("Account suspended due to unpaid invoices.Please contact your system administrator OR Pay Your Due Invoice.",'gym_mgt'); ?></h2>

											</div>

											<?php die;

										}

									}

									else

									{

										?>

										<div class="page_main_div">

											<?php

											$page_name = $_REQUEST ['page']; 

											require_once GMS_PLUGIN_DIR . '/template/'.$page_name.'.php';

											?>

										</div>

										<?php

									}

								}

							}

							else

							{

								?>

								<div class="page_main_div">

									<?php

										$page_name = $_REQUEST ['page']; 

										require_once GMS_PLUGIN_DIR . '/template/'.$page_name.'.php';

									?>

								</div>

								<?php

							}

						}



						if(isset($_REQUEST['dashboard']) && $_REQUEST['dashboard'] == 'user' && $_REQUEST ['page'] == "")

						{

							$membershistatus=get_user_meta($user_id,'membership_status',true);

							$unpaid_membership_status=get_user_meta($user_id,'unpaid_membership_status',true);

							if($role == 'member' && $membershistatus == 'Expired')

							{

								?>

								<div class="membership_Expired">

									<h2 class="membership_label"><?php esc_html_e("Your membership has been expired. Please contact your system administrator OR Renew Plan.",'gym_mgt'); ?></h2>

								</div>

								<div class="margin_top_20px renew_upgrade">

									<a class="btn save_btn renew_upgrade_btn renew_popup" style="height:auto !important;" href=""><?php esc_html_e('Renew/Upgrade','gym_mgt');?></a>

								</div>

								<?php die;

							}

							elseif($role == 'member' && $unpaid_membership_status == 'Expired')

							{

								?>

								<div class="membership_Expired">

									<h2 class="membership_label"><?php esc_html_e("Account suspended due to unpaid invoices.Please contact your system administrator OR Pay Your Invoice.",'gym_mgt'); ?></h2>

								</div>

								<div class="margin_top_20px renew_upgrade">

									<a class="btn save_btn renew_upgrade_btn" href="<?php echo home_url().'?dashboard=user&page=membership_payment'; ?>"><?php esc_html_e('Pay','gym_mgt');?></a>

								</div>

								<?php die;

							}

							elseif($role == 'member' && $membershistatus == 'Dropped')

							{

								?>

								<div class="membership_Expired">

									<h2 class="membership_label"><?php esc_html_e("Your membership has been dropped.Please contact your system administrator.",'gym_mgt'); ?></h2>

								</div>

								<?php die;	

							}

							

							?>

						

							<!-- Four Card , Chart and Invioce Payment Row Div Start  -->

							<div class="row menu_row dashboard_content_rs first_row_padding_top"><!-- Row Div Start  -->

								<?php  $dashboard_result = MJ_gmgt_frontend_dashboard_card_access(); ?>

								<?php

							

								if($dashboard_result['gmgt_accountant'] == "yes" || $dashboard_result['gmgt_staff'] == "yes" || $dashboard_result['gmgt_notices'] == "yes" || $dashboard_result['gmgt_messages'] == "yes")

								{

									?>

									<div class="col-lg-4 col-md-4 col-xl-4 col-sm-4 four_card_div">

										<div class="row">

											<?php

											if($dashboard_result['gmgt_accountant'] == "yes")

											{

												?>

												<!-- Accountant card start -->

												<div class="col-lg-6 col-md-6 col-xl-6 col-sm-6 gmgt-card">

													<div class="gmgt-card-member-bg center" id="card-supportstaff-bg">

														<a href='<?php echo home_url().'?dashboard=user&page=member';?>'>

															<img class="center" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/account_dashboard.png"?>">

														</a>

													</div>

													<div class="gmgt-card-number">

														<h3><?php echo count(get_users(array('role'=>'accountant')));?></h3>

													</div>

													<div class="gmgt-card-title">

														<span><?php esc_html_e('Accountant','gym_mgt');?></span>

													</div>

												</div>

												<!--  Accountant card end -->

												<?php

											}

											if($dashboard_result['gmgt_staff'] == "yes")

											{

												?>

												<!-- Staff Members card start -->

												<div class="col-lg-6 col-md-6 col-xl-6 col-sm-6 gmgt-card hmgt_card_2">

													<div class="gmgt-card-member-bg center" id="card-member-bg">

														<a href='<?php echo home_url().'?dashboard=user&page=staff_member';?>'>

														<img class="center" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/trainer_dashboard.png"?>">

														</a>

													</div>

													<div class="gmgt-card-number">

														<h3><?php echo esc_html(count(get_users(array('role'=>'staff_member'))));?></h3>

													</div>

													<div class="gmgt-card-title">

														<span><?php esc_html_e('Staff Members','gym_mgt');?></span>

													</div>

												</div>

												<!-- Staff Members card end -->

												<?php

											}

											if($dashboard_result['gmgt_notices'] == "yes")

											{

												?>

												<!-- Notice card start -->

												<div class="col-lg-6 col-md-6 col-xl-6 col-sm-6 gmgt-card">

													<div class="gmgt-card-member-bg center" id="card-notice-bg">

														<a href='<?php echo home_url().'?dashboard=user&page=notice';?>'>

															<img class="center" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Notice_dashboard.png"?>">

														</a>

													</div>

													<div class="gmgt-card-number">

														<?php

														global $wpdb;

														$table_post = $wpdb->prefix . 'posts';

														$total_notice = $wpdb->get_row("SELECT COUNT(*) as  total_notice FROM $table_post where post_type='gmgt_notice' ");

														?>

														<h3><?php echo $total_notice->total_notice; ?></h3>

													</div>

													<div class="gmgt-card-title prescription_name_div">

														<span><?php esc_html_e('Notices','gym_mgt');?></span>

													</div>

												</div>

												<!-- Notice card end -->

												<?php

											}

											if($dashboard_result['gmgt_messages'] == "yes")

											{

												?>

												<!-- Message card start -->

												<div class="col-lg-6 col-md-6 col-xl-6 col-sm-6 gmgt-card hmgt_card_2">

													<div class="gmgt-card-member-bg center" id="card-message-bg">

														<a href='<?php echo home_url().'?dashboard=user&page=message';?>'>

															<img class="center" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Message_dashboard.png"?>">

														</a>

													</div>

													<div class="gmgt-card-number">

														<h3><?php echo esc_html(MJ_gmgt_count_unread_message(get_current_user_id()));?></h3>

													</div>

													<div class="gmgt-card-title">

														<span><?php esc_html_e('Messages','gym_mgt');?></span>

													</div>

												</div>

												<!--Message card end -->

												<?php

											}

											?>

										</div>

									</div>

									<?php

								}

								if($dashboard_result['gmgt_member_status_chart'] == "yes")

								{

									?>

									<!-- Member active && Expired chat start -->

									<div class="col-lg-4 col-md-4 col-xs-12 col-sm-12 responsive_div_dasboard">

										<div class="panel panel-white gmgt-line-chat">

											<div class="panel-heading" id="gmgt-line-chat-p">

												<h3 class="panel-title"><?php esc_html_e('Member Status','gym_mgt');?></h3>

												<a href="<?php echo home_url().'?dashboard=user&page=member'; ?>"><img class="vertical_align_unset" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Redirect.png"?>"></a>

											</div>

											<script src="https://github.com/chartjs/Chart.js/releases/download/v2.9.3/Chart.min.js"></script>

											<link rel="stylesheet" href="https://github.com/chartjs/Chart.js/releases/download/v2.9.3/Chart.min.css">

											<div class="gmgt-member-chart">

												<div class="outer">

													<canvas id="chartJSContainer" width="300" height="250"></canvas>

													

													<p class="percent">

														<?php

															$total_member=count(get_users(array('role'=>'member')));

															$total_member= str_pad($total_member, 2, '0', STR_PAD_LEFT); 

															echo $total_member;

														?> 

													</p>

													<p class="percent1">

														<!-- <?php esc_html_e('Active & Expired ','gym_mgt');?> -->

														<?php esc_html_e('Active','gym_mgt');?><?php esc_html_e(' & ','gym_mgt');?><?php esc_html_e('Expired','gym_mgt');?>

													</p>

												</div>

												<?php

													$active_member= MJ_gmgt_get_user_total_active_member();

													$expired_member= MJ_gmgt_get_user_total_expired_member();



												?>

												<script>

													var options1 = {

														type: 'doughnut',

														data: {

															labels: ["<?php esc_html_e('Active Member','gym_mgt');?>", "<?php esc_html_e('Expired Member','gym_mgt');?>"],

															datasets: [

																{

																	label: '# of Votes',

																	data: [<?php echo $active_member; ?>,<?php echo $expired_member?>],

																	backgroundColor: [

																		'#FFB400',

																		'#44CB7F',

																	],

																	borderColor: [

																		'rgba(255, 255, 255 ,1)',

																		'rgba(255, 255, 255 ,1)',

																	],

																	borderWidth: 5,

																}

															]

														},

														options: {

															rotation: 1 * Math.PI,

															circumference: 1 * Math.PI,

															legend: {

																display: false

															},

															tooltip: {

																enabled: false

															},

															cutoutPercentage: 85

														}

													}



													var ctx1 = document.getElementById('chartJSContainer').getContext('2d');

													new Chart(ctx1, options1);



													var options2 = {

														type: 'doughnut',

														data: {

															labels: ["", "Purple", ""],

															datasets: [

																{

																	data: [88.5, 1],

																	backgroundColor: [

																		"rgba(0,0,0,0)",

																		"rgba(255,255,255,1)",

																		

																	],

																	borderColor: [

																		'rgba(0, 0, 0 ,0)',

																		'rgba(46, 204, 113, 1)',

																		

																	],

																	borderWidth: 5

																		

																}

															]

														},

														options: {

															cutoutPercentage: 95,

															rotation: 1 * Math.PI,

															circumference: 1 * Math.PI,

															legend: {

																display: false

															},

															tooltips: {

																enabled: false

															}

														}

													}

													var ctx2 = document.getElementById('secondContainer').getContext('2d');

													new Chart(ctx2, options2);

												</script>

											</div>



											<div class="row hmgt-line-chat">

												<div class="col line-chart-checkcolor-center color_dot_div_left chart_div_1">

													<p class="line-chart-checkcolor-RegularMember"></p>

												</div>

												<!-- <div  class="col-md-2 chart_div_3"></div> -->

												<div class="col line-chart-checkcolor-center color_dot_div_right chart_div_1 padding_0">

													<p class="line-chart-checkcolor-VolunteerMember"></p>

												</div>

											</div>

											<div class="row d-flex align-items-center justify-content-center gmgt_das_chat">

												<div class="col-sm-5 col-md-5 col-lg-5 col-xl-5 col-xs-5 responsive_div_dasboard chart_div_1 gmgt_chart_div_1" id="gmgt-line-chat-right-border">

													<p class="count_patient">

														<?php

															$active_member = str_pad($active_member, 2, '0', STR_PAD_LEFT); 

															echo $active_member;

														?>

													</p>

													<p class="name_patient">

														<?php esc_html_e('Active Member','gym_mgt');?>

													</p>

												</div>

												<div class="col-sm-2 col-md-2 col-lg-2 col-xl-2 col-xs-2 chart_div_3">

													<p class="between_border"></p>

												</div>

												<div class="col-sm-5 col-md-5 col-lg-5 col-xl-5 col-xs-5 responsive_div_dasboard chart_div_1 gmgt_chart_div_2 inpatient_div ">

													<p class="count_patient">

														<?php

															$expired_member= str_pad($expired_member, 2, '0', STR_PAD_LEFT); 

															echo $expired_member;

														?>

													</p>

													<p class="name_patient">

														<?php esc_html_e('Expired Member','gym_mgt');?>

													</p>

												</div>

											</div>

										</div>

									</div>

									<!-- Member active && Expired chat End -->

									<?php

								}

								if($dashboard_result['gmgt_invoice_chart'] == "yes")

								{

									?>

									<!-- Invoice List card start -->

									<div class="col-lg-4 col-md-4 col-xs-12 col-sm-12 responsive_div_dasboard precription_padding_left1">

										<div class="panel panel-white admmision_div">

											<div class="panel-heading" id="gmgt-line-chat-p">

												<h3 class="panel-title"><?php esc_html_e('Invoice List','gym_mgt');?></h3>						

												<a class="page_link1" href="<?php echo home_url().'?dashboard=user&page=payment&tab=incomelist';?>">

													<img class="vertical_align_unset" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Redirect.png"?>">

												</a>

											</div>

											<div class="panel-body">

												<div class="events1">

													<?php

													$i= 0;

													$payment_1 = 'payment';

													$payment_1=MJ_gmgt_get_userrole_wise_manually_page_access_right_array($payment_1);

												

													$obj_payment=new MJ_gmgt_payment;

												

													if($obj_gym->role == 'member')

													{

														if($payment_1['own_data']=='1')

														{

															$paymentdata=$obj_payment->MJ_gmgt_new_get_all_income_data_by_member();

														}

														else

														{

															$paymentdata=$obj_payment->MJ_gmgt_get_new_all_income_data_dashboard();

														}							

													}

													else

													{

														if($payment_1['own_data']=='1')

														{

															$user_id=get_current_user_id();

															$paymentdata=$obj_payment->MJ_gmgt_new_get_all_income_data_by_created_by($user_id);

														}

														else

														{

															$paymentdata=$obj_payment->MJ_gmgt_get_new_all_income_data_dashboard();

														}							

													}	

													

													if(!empty($paymentdata))

													{

														foreach ($paymentdata as $retrieved_data)

														{

															if($i == 0)

															{

																$color_class='smgt_assign_bed_color0';

															}

															elseif($i == 1)

															{

																$color_class='smgt_assign_bed_color1';



															}

															elseif($i == 2)

															{

																$color_class='smgt_assign_bed_color2';



															}

															elseif($i == 3)

															{

																$color_class='smgt_assign_bed_color3';



															}

															elseif($i == 4)

															{

																$color_class='smgt_assign_bed_color4';



															}

															?>									

															<div class="fees_payment_height cursor_pointer calendar-event show_task_event" id="<?php echo esc_attr($retrieved_data->invoice_id);?>" model="Invoice Details"> 

																<p class="fees_payment_padding_top_0 cursor_pointer remainder_title Bold viewbedlist  date_font_size" > 	  

																	<label for="" class="date_assignbed_label">

																		<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?><?php echo esc_html($retrieved_data->total_amount); ?>

																		<?php //echo number_format(esc_html($retrieved_data->total_amount),2); ?>

																	</label>

																	<span class=" <?php echo $color_class; ?>"></span>

																</p>

																<p class="remainder_date assignbed_name assign_bed_name_size cursor_pointer">

																	<?php 	

																		$user=get_userdata($retrieved_data->supplier_name);

																		$memberid=get_user_meta($retrieved_data->supplier_name,'member_id',true);

																		// $display_label=$user->display_name;



																		$display_label = MJ_gmgt_get_member_full_display_name_with_memberid(esc_html($user->ID));																		if($memberid)

																		// $display_label.=" (".$memberid.")";

																		echo esc_html($display_label);

																	?>

																</p>

																<p class="remainder_date assign_bed_date assign_bed_name_size res_date_width">

																	<?php echo MJ_gmgt_getdate_in_input_box($retrieved_data->invoice_date); ?>

																</p>

															</div>		

														<?php

														$i++;

														}



													}

													else

													{

														

															?>

															<div class="calendar-event-new"> 

																<img class="no_data_img" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/no_data_img.png"?>" >

																<?php

																if($payment_1['add'] == 1)

																{

																	?>

																	<div class="col-md-12 dashboard_btn">

																		<a href="<?php echo home_url().'?dashboard=user&page=payment&tab=addincome&action=insert'; ?>" class="btn save_btn event_for_alert line_height_31px"><?php esc_html_e('Add Invoice','gym_mgt');?></a>

																	</div>	

																	<?php

																}

																?>

															</div>	

															<?php

														

													}		

													?>	

												</div>                       

											</div>

										</div>

									</div>

									<?php

								}

								?>

								<!-- Invoice List card End -->

							</div><!-- Row Div Start  -->

							<!-- Four Card , Chart and Invioce Payment Row Div End -->



							<!-- Today Report && Membership Report and Celender Row Start -->

							<div class="row calander-chart-div">

								<?php 

								if($role != "member")

								{

									?>

									<div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">

										<div class="gmgt-attendance">

											<div class="gmgt-attendance-list panel">

												<div class="panel-heading">

													<h3 class="panel-title"><?php esc_html_e('Today Member Attendance Report','gym_mgt');?></h3>

													<a href="<?php echo home_url().'?dashboard=user&page=attendence&tab=add_attendence'; ?>" class="page_link1"><img class="" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Redirect.png"?>"></a>

												</div>

												<?php

												global $wpdb;

												$table_attendance = $wpdb->prefix .'gmgt_attendence';

												$table_class = $wpdb->prefix .'gmgt_class_schedule';

												$chart_array = array();

												$report_2 =$wpdb->get_results("SELECT  at.class_id,

													SUM(case when `status` ='Present' then 1 else 0 end) as Present,

													SUM(case when `status` ='Absent' then 1 else 0 end) as Absent

													from $table_attendance as at,$table_class as cl where at.attendence_date >  DATE_SUB(NOW(), INTERVAL 1 DAY) AND at.class_id = cl.class_id  AND at.role_name = 'member' GROUP BY at.class_id") ;

													$chart_array[] = array(esc_html__('Class','gym_mgt'),esc_html__('Present','gym_mgt'),esc_html__('Absent','gym_mgt'));

													if(!empty($report_2))

														foreach($report_2 as $result)

														{

															$class_id =MJ_gmgt_get_class_name($result->class_id);

															$chart_array[] = array("$class_id",(int)$result->Present,(int)$result->Absent);

														}

														$options = Array(

																		'title' => esc_html__('Member Attendance Report','gym_mgt'),

																		'titleTextStyle' => Array('color' => '#4e5e6a','fontSize' => 16,'bold'=>false,'italic'=>false,'fontName' =>'-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif;'),

																		'legend' =>Array('position' => 'right',

																		'textStyle'=> Array('color' => '#4e5e6a','fontSize' => 13,'italic'=>false,'fontName' =>'-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif;')),

																		'hAxis' => Array(

																							'title' => esc_html__('Class','gym_mgt'),

																							'titleTextStyle' => Array('color' => '#4e5e6a','fontSize' => 16,'italic'=>false,'fontName' =>'-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif;'),

																							'textStyle' => Array('color' => '#4e5e6a','fontSize' => 13,'italic'=>false,'fontName' =>'-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif;'),

																							'maxAlternation' => 2

																						),

																		'vAxis' => Array(

																							'title' => esc_html__('No of Member','gym_mgt'),

																							'minValue' => 0,

																							'maxValue' => 4,

																							'format' => '#',

																							'titleTextStyle' => Array('color' => '#4e5e6a','fontSize' => 16,'italic'=>false,'fontName' =>'-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif;'),

																							'textStyle' => Array('color' => '#4e5e6a','fontSize' => 13,'italic'=>false,'fontName' =>'-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif;')

																						),

																		'colors' => array('#22BAA0','#f25656')

																									);

												require_once GMS_PLUGIN_DIR. '/lib/chart/GoogleCharts.class.php';

												$GoogleCharts = new GoogleCharts;

												if(!empty($report_2))

												{

													$chart = $GoogleCharts->load( 'column' , 'today_attendance_report' )->get( $chart_array , $options );

												}

												if(isset($report_2) && count($report_2) >0)

												{

													?>

														<div id="today_attendance_report" class=""></div>

														<!-- Javascript --> 

														<script type="text/javascript" src="https://www.google.com/jsapi"></script> 

														<script type="text/javascript">

																<?php echo $chart;?>

														</script>



													<?php 

												}

												if(isset($report_2) && empty($report_2))

												{ ?>

													<div class="calendar-event-new no_data_img_center"> 

														<img class="no_data_img" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/no_data_img.png"?>" >

													</div>		

													<?php 

												}?>

											</div>



											

											<div class="gmgt-feesreport-list panel">

												<div class="panel-heading">

													<h3 class="panel-title"><?php esc_html_e('Membership Report','gym_mgt');?></h3>

													<a href="<?php echo home_url().'?dashboard=user&page=membership'; ?>" class="page_link1"><img class="" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Redirect.png"?>"></a>

												</div>

												<?php 

												global $wpdb;

												$table_name = $wpdb->prefix."gmgt_membershiptype";

												$q="SELECT * From $table_name";

												$member_ship_array = array();

												$result_membership=$wpdb->get_results($q);

												foreach($result_membership as $retrive)

												{

													$membership_id = $retrive->membership_id;		

													$member_ship_count =  count(get_users(array('role'=>'member','meta_key' => 'membership_id', 'meta_value' => $retrive->membership_id)));

													$member_ship_array[] = array('member_ship_id'=>$membership_id,

																				'member_ship_count'=>	$member_ship_count

																				);

												}

												$chart_array = array();

												$chart_array[] = array(esc_html__('Membership','gym_mgt'),esc_html__('Number Of Member','gym_mgt'));	

												foreach($member_ship_array as $r)

												{

													$chart_array[]=array( MJ_gmgt_get_membership_name($r['member_ship_id']),$r['member_ship_count']);

												}

												$options = Array(

														'title' => esc_html__('Membership Report','gym_mgt'),

														'titleTextStyle' => Array('color' => '#4e5e6a','fontSize' => 16,'bold'=>false,'italic'=>false,'fontName' =>'-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif;'),

															'legend' =>Array('position' => 'right',

															'textStyle'=> Array('color' => '#4e5e6a','fontSize' => 13,'bold'=>false,'italic'=>false,'fontName' =>'-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif;')),

														'hAxis' => Array(

																'title' => esc_html__('Membership Name','gym_mgt'),

																'format' => '#',

																'titleTextStyle' => Array('color' => '#4e5e6a','fontSize' => 16,'bold'=>false,'italic'=>false,'fontName' =>'-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif;'),

																'textStyle'=> Array('color' => '#4e5e6a','fontSize' => 13,'bold'=>false,'italic'=>false,'fontName' =>'-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif;'),

																'maxAlternation' => 2

														),

														'vAxis' => Array(

																'title' => esc_html__('No of Member','gym_mgt'),

																'minValue' => 0,

																'maxValue' => 6,

																'format' => '#',

																'titleTextStyle' => Array('color' => '#4e5e6a','fontSize' => 16,'bold'=>false,'italic'=>false,'fontName' =>'-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif;'),

																'textStyle'=> Array('color' => '#4e5e6a','fontSize' => 13,'bold'=>false,'italic'=>false,'fontName' =>'-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif;'),

														),

														'colors' => array('#ba170b')

												);

												require_once GMS_PLUGIN_DIR. '/lib/chart/GoogleCharts.class.php';

												$GoogleCharts = new GoogleCharts;

												if(!empty($result_membership))

												{

													$chart = $GoogleCharts->load( 'column' , 'chart_div_membership' )->get( $chart_array , $options );

												}

												if(isset($result_membership) && count($result_membership) >0)

												{

													?>

													<div id="chart_div_membership" class=""></div>

													<!-- Javascript --> 

													<script type="text/javascript" src="https://www.google.com/jsapi"></script> 

													<script type="text/javascript">

															<?php echo $chart;?>

													</script>

													<?php 

												}

												if(isset($result_membership) && empty($result_membership))

												{   ?>

														<div class="calendar-event-new no_data_img_center"> 

															<img class="no_data_img" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/no_data_img.png"?>" >

														</div>	

													<?php 

												}?>

											</div>

											

										</div>

									</div>

									<?php

								}

								?>

								<div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">

									<div class="gmgt-calendar panel">

										<div class="row panel-heading activities height_80px_res">

											<div class="col-sm-12 col-md-3 col-lg-3 col-xl-3">

												<h3 class="panel-title calander_heading_title_width"><?php esc_html_e('Calendar','gym_mgt');?></h3>

											</div>

											<div class="gmgt-cal-py col-sm-12 col-md-9 col-lg-9 col-xl-9 Calender_responsive_margin celender_dot_div">

												<div class="gmgt-card-head">

													<ul class="gmgt-cards-indicators gmgt-right">

														<li><span class="gmgt-indic gmgt-blue-indic"></span> <?php esc_html_e( 'Notice', 'gym_mgt' ); ?></li>

														<?php

														if($user_role == 'staff_member')

														{

															?>

															<li><span class="gmgt-indic gmgt-orang-indic"></span> <?php esc_html_e( 'Reservation', 'gym_mgt' ); ?></li>

															<li><span class="gmgt-indic gmgt-light-green-indic"></span> <?php esc_html_e( 'Class Schedule', 'gym_mgt' );?></li>

															<?php

														}

														elseif($user_role == 'member')

														{

															?>

															<li><span class="gmgt-indic gmgt-orang-indic"></span> <?php esc_html_e( 'Nutrition', 'gym_mgt' ); ?></li>

															<li><span class="gmgt-indic gmgt-light-green-indic"></span> <?php esc_html_e( 'Class Booking', 'gym_mgt' );?></li>

															<?php

														}

														?>

													</ul>

												</div>   

											</div>

										</div>

										<div class="gmgt-cal-py gmgt-calender-margin-top">

											<div id="calendar"></div>

										</div>

									</div>

								</div>

							

								<!-- Today Report && Membership Report and Celender Row End -->



								<?php

								if($role != "member")

								{

									?>

									<!----------------------- Income Expense Card  ----------------------->

									

									<div  class="col-md-6 col-lg-6 col-sm-12 com-xs-12 responsive_div_dasboard precription_padding_left1">

									    <div class="panel panel-white card_list_height operation">

											<div class="row">

												<div class="col-md-9 mb-9 input">

													<div class="panel-heading ">

														<h3 class="panel-title"><span class="income_month_value"><?php esc_html_e(date("F"),'gym_mgt');?></span><?php esc_html_e(' Income-Expense Report','gym_mgt');?></h3>						

													</div>

												</div>

												<div class="col-md-3 mb-3 col-6 input margin_top_20px margin_left_20px margin_rtl_30px">

													<label class="ml-1 custom-top-label month_label top" for="hmgt_contry"><?php esc_html_e('Months','gym_mgt');?><span class="require-field">*</span></label>

													<select id="month" name="month" class="line_height_30px form-control class_id_exam validate[required] dash_month_select">

														<!-- <option ><?php esc_attr_e('Selecte Month','gym_mgt');?></option> -->

														<?php

														$month =array('1'=>esc_html__('January','apartment_mgt'),'2'=>esc_html__('February','apartment_mgt'),'3'=>esc_html__('March','apartment_mgt'),'4'=>esc_html__('April','apartment_mgt'),'5'=>esc_html__('May','apartment_mgt'),'6'=>esc_html__('June','apartment_mgt'),'7'=>esc_html__('July','apartment_mgt'),'8'=>esc_html__('August','apartment_mgt'),'9'=>esc_html__('September','apartment_mgt'),'10'=>esc_html__('October','apartment_mgt'),'11'=>esc_html__('November','apartment_mgt'),'12'=>esc_html__('December','apartment_mgt'),);

														foreach($month as $key=>$value)

														{

															$selected = (date('m') == $key ? ' selected' : '');

															echo '<option value="'.$key.'"'.$selected.'>'. esc_html__($value,'gym_mgt').'</option>'."\n";

														}

															?>

													</select>   

												</div>

											</div>

											<div class="panel-body">

												<div class="events notice_content_div">

													<?php

														$obj_payment=new MJ_gmgt_payment;

														$monthly_income = $obj_payment->MJ_get_monthly_income();

														$monthly_expense = $obj_payment->MJ_get_monthly_expense();

														$income_amount = 0;

														if(!empty($monthly_income))

														{

															foreach($monthly_income as $income)

															{

																$all_entry=json_decode($income->entry);

																$incomeamount=0;

																foreach($all_entry as $entry)

																{

																	if(isset($entry->amount))

																	{

																		$incomeamount+=$entry->amount;

																	}

																}

																

																$income_amount += $incomeamount;

															}

														}

														$expense_amount = 0;

														if(!empty($monthly_expense))

														{

															foreach($monthly_expense as $expense)

															{

																$all_entry=json_decode($expense->entry);

																$amount=0;

																foreach($all_entry as $entry)

																{

																	$amount+=$entry->amount;

																}



																$expense_amount += $amount;

															}

														}



														$net_profit = $income_amount - $expense_amount;



													?>

													<div class="das_month_report_div">

														<table class="table workour_edit_table" width="100%">

															<thead>

																<tr class="assign_workout_table_header_tr">

																	<th class="assign_workout_table_header assign_workout_right_border" scope="col"><?php esc_html_e('Total Income','gym_mgt');?></th>

																	<th class="assign_workout_table_header assign_workout_right_border" scope="col"><?php esc_html_e('Total Expense','gym_mgt');?></th>

																	<th class="assign_workout_table_header assign_workout_right_border" scope="col"><?php esc_html_e('Net Profit','gym_mgt');?></th>

																</tr>

															</thead>

															<tbody>

																<tr class="assign_workout_table_body_tr">

																	<th class="assign_workout_table_body table_body_border_right" scope="row"><?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?> <?php echo $income_amount; ?></th>

																	<th class="assign_workout_table_body table_body_border_right" scope="row"><?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?> <?php echo $expense_amount; ?></th>

																	<th class="assign_workout_table_body table_body_border_right" scope="row" style="<?php if($net_profit < 0){ echo "color: red !important"; } ?>"><?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?> <?php echo $net_profit; ?></th>

																</tr>

															</tbody>

														</table>

													</div>

												</div>

											</div>

										</div>

									</div>

									<div  class="col-md-6 col-lg-6 col-sm-12 com-xs-12 responsive_div_dasboard precription_padding_left1">

									    <div class="panel panel-white card_list_height operation">

											<div class="row">

												<div class="col-md-9 mb-9 input">

													<div class="panel-heading ">

														<h3 class="panel-title"><span class="income_year_value"><?php esc_html_e(date("Y"),'gym_mgt');?></span><?php esc_html_e(' Income-Expense Report','gym_mgt');?></h3>						

													</div>

												</div>

												<div class="col-md-3 mb-3 col-6 input margin_top_20px margin_left_20px margin_rtl_30px">

													<label class="ml-1 custom-top-label month_label top" for="hmgt_contry"><?php esc_html_e('Year','gym_mgt');?><span class="require-field">*</span></label>

													<select name="year" class="line_height_30px form-control validate[required] dash_year_select">

														<!-- <option ><?php esc_attr_e('Selecte year','gym_mgt');?></option> -->

															<?php

															$current_year = date('Y');

															$min_year = $current_year - 10;

															

															for($i = $min_year; $i <= $current_year; $i++){

																$year_array[$i] = $i;

																$selected = ($current_year == $i ? ' selected' : '');

																echo '<option value="'.$i.'"'.$selected.'>'.$i.'</option>'."\n";

															}

															?>

													</select>     

												</div>

											</div>

											

											<div class="panel-body">

												<div class="events notice_content_div">

													<?php

														$obj_payment=new MJ_gmgt_payment;

														$yearly_income = $obj_payment->MJ_get_yearly_income();

														$yearly_expense = $obj_payment->MJ_get_yearly_expense();

													

														$income_yearly_amount = 0;

														if(!empty($yearly_income))

														{

															foreach($yearly_income as $income)

															{

																$all_entry=json_decode($income->entry);

																$incomeamount=0;

																foreach($all_entry as $entry)

																{

																	$all_entry=json_decode($income->entry);

																	$incomeamount=0;

																	foreach($all_entry as $entry)

																	{

																		if(isset($entry->amount))

																		{

																			$incomeamount+=$entry->amount;

																		}

																	}

																	$income_yearly_amount += $incomeamount;

																}



															}

														}

														

														$expense_yearly_amount = 0;

														if(!empty($yearly_expense))

														{

															foreach($yearly_expense as $expense)

															{

																$all_entry=json_decode($expense->entry);

																$amount=0;

																foreach($all_entry as $entry)

																{

																	$amount+=$entry->amount;

																}



																$expense_yearly_amount += $amount;

															}

														}



														$net_profit = $income_yearly_amount - $expense_yearly_amount;



													?>



													<div class="das_year_report_div">

														<table class="table workour_edit_table" width="100%">

															<thead>

																<tr class="assign_workout_table_header_tr">

																	<th class="assign_workout_table_header assign_workout_right_border" scope="col"><?php esc_html_e('Total Income','gym_mgt');?></th>

																	<th class="assign_workout_table_header assign_workout_right_border" scope="col"><?php esc_html_e('Total Expense','gym_mgt');?></th>

																	<th class="assign_workout_table_header assign_workout_right_border" scope="col"><?php esc_html_e('Net Profit','gym_mgt');?></th>

																</tr>

															</thead>

															<tbody>

																<tr class="assign_workout_table_body_tr">

																	<th class="assign_workout_table_body table_body_border_right" scope="row"><?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?> <?php echo $income_yearly_amount; ?></th>

																	<th class="assign_workout_table_body table_body_border_right" scope="row"><?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?> <?php echo $expense_yearly_amount; ?></th>

																	<th class="assign_workout_table_body table_body_border_right" scope="row" style="<?php if($net_profit < 0){ echo "color: red !important"; } ?>"><?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?> <?php echo $net_profit; ?></th>

																</tr>

															</tbody>

														</table>

													</div>

												</div>

											</div>

										</div>

									</div>

									

									<!----------------------- Income Expense Card  ----------------------->

									<?php

								}

								?>



								<!-- Fee Payment Report and Membership List && Activity Row Start -->

								<?php 

								if($role != "member")

								{

									?>

									<div class="col-md-6 col-lg-6 col-sm-12 com-xs-12 responsive_div_dasboard precription_padding_left">

										<div class="panel panel-white fees_card_height priscription">

											<div class="panel-heading ">					

												<h3 class="panel-title"><?php esc_html_e('Fee Payment Report','gym_mgt');?></h3>						

												<a class="page-link123" href="<?php echo home_url().'?dashboard=user&page=payment&tab=incomelist'; ?>"><img class="vertical_align_unset" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Redirect.png"?>"></a>

											</div>

											<div class="panel-body class_padding">

												<?php  $month =array('1'=>esc_html__('January','gym_mgt'),'2'=>esc_html__('February','gym_mgt'),'3'=>esc_html__('March','gym_mgt'),'4'=>esc_html__('April','gym_mgt'),'5'=>esc_html__('May','gym_mgt'),'6'=>esc_html__('June','gym_mgt'),'7'=>esc_html__('July','gym_mgt'),'8'=>esc_html__('August','gym_mgt'),'9'=>esc_html__('September','gym_mgt'),'10'=>esc_html__('October','gym_mgt'),'11'=>esc_html__('November','gym_mgt'),'12'=>esc_html__('December','gym_mgt'),);		

												$year =isset($_POST['year'])?sanitize_text_field($_POST['year']):date('Y');

												global $wpdb;

												$currency=MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ));

												$table_name = $wpdb->prefix."gmgt_membership_payment_history";

												$q="SELECT EXTRACT(MONTH FROM paid_by_date) as date,sum(amount) as count FROM ".$table_name." WHERE YEAR(paid_by_date) =".$year." group by month(paid_by_date) ORDER BY paid_by_date ASC";

												$result_payment=$wpdb->get_results($q);

												$chart_array = array();

												$chart_array[] = array(esc_html__('Month','gym_mgt'),esc_html__('Fee Payment','gym_mgt'));

												foreach($result_payment as $r)

												{	

													$chart_array[]=array( $month[$r->date],(int)$r->count);

												}

												$options = Array(

															'title' => esc_html__('Fee Payment Report By Month','gym_mgt'),

															'titleTextStyle' => Array('color' => '#4e5e6a','fontSize' => 16,'bold'=>false,'italic'=>false,'fontName' =>'-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif;'),

															'legend' =>Array('position' => 'right',

															'textStyle'=> Array('color' => '#4e5e6a','fontSize' => 13,'bold'=>false,'italic'=>false,'fontName' =>'-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif;')),

															'hAxis' => Array(

																'title' => esc_html__('Month','gym_mgt'),

																'Data Type'=>'date',

																'format' => 'MMM',

																'titleTextStyle' => Array('color' => '#4e5e6a','fontSize' => 16,'bold'=>false,'italic'=>false,'fontName' =>'-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif;'),

																'textStyle'=> Array('color' => '#4e5e6a','fontSize' => 13,'bold'=>false,'italic'=>false,'fontName' =>'-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif;'),

																'maxAlternation' => 2



																),

															'vAxis' => Array(

																'title' => esc_html__('Fee Payment','gym_mgt'),

																'minValue' => 0,

																'maxValue' => 6,

																'format' => html_entity_decode($currency),

																'titleTextStyle' => Array('color' => '#4e5e6a','fontSize' => 16,'bold'=>false,'italic'=>false,'fontName' =>'-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif;'),

																'textStyle'=> Array('color' => '#4e5e6a','fontSize' => 13,'bold'=>false,'italic'=>false,'fontName' =>'-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif;')

																),

														'colors' => array('#ba170b')

															);

												require_once GMS_PLUGIN_DIR. '/lib/chart/GoogleCharts.class.php';

												$GoogleCharts = new GoogleCharts;

												if(!empty($result_payment))

												{

													$chart = $GoogleCharts->load( 'column' , 'chart_div_fees' )->get( $chart_array , $options );

												}

												if(isset($result_payment) && count($result_payment) >0)

												{

												?>

													<div id="chart_div_fees" class="width_100 height_500"></div>

													<!-- Javascript --> 

													<script type="text/javascript" src="https://www.google.com/jsapi"></script> 

													<script type="text/javascript">

															<?php echo $chart;?>

													</script>

												<?php 

												}

												if(isset($result_payment) && empty($result_payment))

												{?>

													<div class="calendar-event-new no_data_img_center no_data_margin_25"> 

														<img class="no_data_img" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/no_data_img.png"?>" >

													</div>	

													<?php 

												}?>                        

											</div>

										</div>

									</div>

									<?php

								}

								$membership_access='membership';

								$access_membership=MJ_gmgt_page_access_rolewise_accessright_dashboard($membership_access);

								$activity_new='activity';

								$activity_access=MJ_gmgt_page_access_rolewise_accessright_dashboard($activity_new);

								$activity_1=MJ_gmgt_get_userrole_wise_manually_page_access_right_array($activity_new);

								$membership_1 = 'membership';

								$membership_1=MJ_gmgt_get_userrole_wise_manually_page_access_right_array($membership_1);

								if($activity_1['view'] == 1 || $membership_1['view'] == 1)

								{

									?>

									<div  class="col-md-6 col-lg-6 col-sm-12 com-xs-12 responsive_div_dasboard precription_padding_left1">

										<?php

										if($access_membership)

										{

											?>

											<div class="panel panel-white member_list_height operation">

												<div class="panel-heading ">

													<h3 class="panel-title"><?php esc_html_e('Membership','gym_mgt');?></h3>						

													<a class="page-link123" href="<?php echo home_url().'?dashboard=user&page=membership';?>"><img class="vertical_align_unset" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Redirect.png"?>"></a>

												</div>

												<div class="panel-body">

													<div class="events1">

														<?php



														$membership_1 = 'membership';

														$membership_1=MJ_gmgt_get_userrole_wise_manually_page_access_right_array($membership_1);



														$obj_membership=new MJ_gmgt_membership;



														if($obj_gym->role == 'member')

														{	

															if($membership_1['own_data']=='1')

															{

																$user_id=get_current_user_id();

																$membership_id = get_user_meta( $user_id,'membership_id', true ); 

																$membershipdata=$obj_membership->MJ_gmgt_new_get_member_own_membership($membership_id);			

															}

															else

															{

																$membershipdata=$obj_membership->MJ_gmgt_get_new_all_membership_dashboard();

															}	

														}

														elseif($obj_gym->role == 'staff_member' || $obj_gym->role == 'accountant')

														{

															if($membership_1['own_data'] == '1')

															{

																$user_id=get_current_user_id();							

																$membershipdata=$obj_membership->MJ_gmgt_new_get_membership_by_created_by($user_id);

																

															}

															else

															{

																$membershipdata=$obj_membership->MJ_gmgt_get_new_all_membership_dashboard();

															}

														}

														

														$i=0;

														if(!empty($membershipdata))

														{

															foreach ($membershipdata as $retrieved_data)

															{	

																//$cid=$retrieved_data->class_id;	

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

																?>

																

								

																<div class="row gmgt-group-list-record profile_image_class class_record_height show_task_event" id="<?php echo esc_attr($retrieved_data->membership_id);?>" model="Membership Details">

																	<div class="cursor_pointer col-sm-2 col-md-2 col-lg-2 col-xl-2 <?php echo $color_class; ?> remainder_title class_tag Bold save1 show_task_event_list profile_image_appointment smgt_class_color0 <?php echo $color_class;?>" >

																		<img class="class_image_1 center" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/Membership.png"?>">

																	</div>

																	<div class="cursor_pointer d-flex align-items-center col-sm-7 col-md-7 col-lg-7 col-xl-7 gmgt-group-list-record-col-img">

																		<div class="cursor_pointer class_font_color cmgt-group-list-group-name remainder_title_pr gms_member_color Bold viewdetail" >

																			<span><?php echo esc_html($retrieved_data->membership_label); ?></span><span><?php esc_html_e('(','gym_mgt');?><?php echo esc_html($retrieved_data->membership_length_id); ?> <?php esc_html_e('- Days)','gym_mgt');?></span>

																		</div>

																	</div>

																	<div class="col-sm-3 cursor_pointer col-md-3 col-lg-3 col-xl-3 justify-content-end d-flex align-items-center gmgt-group-list-record-col-count">

																		<div class="gmgt-group-list-total-group">

																			<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?><?php echo esc_html($retrieved_data->membership_amount); ?>

																		</div>

																	</div>

																</div>

																<?php

																$i++;

															}

														}	

														else

														{

															?>	

															<div class="calendar-event-new"> 

																<img class="das_no_data_height_150px" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/no_data_img.png"?>" >

																<?php

																if($membership_1['add'] == 1)

																{

																	?>

																	<div class="col-md-12 dashboard_btn">

																		<a href="<?php echo home_url().'?dashboard=user&page=membership&tab=addmembership&action=insert'; ?>" class="btn save_btn event_for_alert line_height_31px"><?php esc_html_e('ADD Membership','gym_mgtt');?></a>

																	</div>	

																	<?php

																}

																?>

															</div>		

															

															<?php

														}	

														?>		

													</div>                       

												</div>

											</div>

											<?php

										}

										if($activity_access)

										{

											?>

											<div class="panel panel-white member_list_height operation">

												<div class="panel-heading ">

													<h3 class="panel-title"><?php esc_html_e('Activity','gym_mgt');?></h3>						

													<a class="page-link123" href="<?php echo home_url().'?dashboard=user&page=activity';?>"><img class="vertical_align_unset" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Redirect.png"?>"></a>

												</div>

												<div class="panel-body">

													<div class="events notice_content_div">

														<?php         

														$obj_activity=new MJ_gmgt_activity;

														if($activity_1['own_data']=='1')

														{

															if($obj_gym->role == 'member')

															{

																$member_activity_ids=MJ_gmgt_get_member_activity_by_membership_id();

																$activitydata=$obj_activity->MJgmet_new_all_activity_by_activity_ids($member_activity_ids);

															}

															else

															{

																$user_id=get_current_user_id();							

																$activitydata=$obj_activity->MJ_gmgt_new_get_all_activity_by_activity_added_by($user_id);

															}

														}

														else

														{

															$activitydata=$obj_activity->MJgmet_new_all_activity_dashboard();

														}

														

														if(!empty($activitydata))

														{ 

															foreach ($activitydata as $retrieved_data)

															{ 

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

																?>						

																<div class="calendar-event profile_image_class show_task_event" id="<?php echo $retrieved_data->activity_id; ?>" model="Activities Details"> 

																	<p class="cursor_pointer class_tag Bold save1 show_task_event_list profile_image_appointment <?php echo $color_class; ?>">

																		<img class="class_image center" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/Activity.png"?>">

																	</p>

																	<p class="cursor_pointer padding_top_5px_res remainder_title_pr card_content_width show_task_event padding_top_card_content viewpriscription class_width" style="color: #333333;"  id="<?php echo $retrieved_data->activity_id; ?>" model="Activities Details"> 

																		<?php echo esc_html($retrieved_data->activity_title);?>

																	</p>

																	<p class="cursor_pointer remainder_date_pr date_background class_width"> <label for="" class="cursor_pointer label_for_date"><?php echo MJ_gmgt_getdate_in_input_box($retrieved_data->activity_added_date); ?></label> </p>

																	<p class="cursor_pointer remainder_title_pr viewpriscription class_font_15px card_content_width class_width assignbed_name1 card_margin_top"> 

																		<?php echo esc_html(get_the_title($retrieved_data->activity_cat_id));?>

																	</p>

																	

																</div>		

																<?php

																$i++;

															}

														}

														else

														{

															?>

															<div class="calendar-event-new"> 

																<img class="das_no_data_height_150px" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/no_data_img.png"?>" >

																<?php

																if($activity_1['add'] == 1)

																{

																	?>

																	<div class="col-md-12 dashboard_btn">

																		<a href="<?php echo home_url().'?dashboard=user&page=activity&tab=addactivity&action=insert'; ?>" class="btn save_btn event_for_alert line_height_31px"><?php esc_html_e('ADD Activity','gym_mgtt');?></a>

																	</div>	

																	<?php

																}

																?>

															</div>		

														<?php

														}	

														?>					

													</div>

												</div>

											</div>

											<?php

										}

										?>

									</div>

									<?php

								}

								?>

							

								<!-- Fee Payment Report and Membership List Row End -->



								<!-- Notice List and Massage List Row Div Start  -->

								<?php

								$notice_1 = 'notice';

								$notice_1=MJ_gmgt_get_userrole_wise_manually_page_access_right_array($notice_1);

								if($notice_1['view'] == 1)

								{ 

									?>

									<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12 responsive_div_dasboard precription_padding_left">

										<div class="panel panel-white event">

											<div class="panel-heading ">

												<h3 class="panel-title"><?php esc_html_e('Notice','gym_mgt');?></h3>						

												<a class="page-link123" href="<?php echo home_url().'?dashboard=user&page=notice';?>"><img class="vertical_align_unset" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Redirect.png"?>"></a>

											</div>					

											<div class="panel-body">

												<div class="events">	

													<?php 

													$obj_notice=new MJ_gmgt_notice;   

													if($notice_1['own_data']=='1')

													{

														$noticedata =$obj_notice->MJ_gmgt_get_notice_dashboard($obj_gym->role);

													}

													else	

													{

														$noticedata =$obj_notice->MJ_gmgt_get_all_notice_dashboard();

													}



													$i=0;

													if(!empty($noticedata))

													{ 

														foreach ($noticedata as $retrieved_data)

														{ 

															if($i == 0)

															{

																$color_class='smgt_notice_color0';

															}

															elseif($i == 1)

															{

																$color_class='smgt_notice_color1';



															}

															elseif($i == 2)

															{

																$color_class='smgt_notice_color2';



															}

															elseif($i == 3)

															{

																$color_class='smgt_notice_color3';



															}

															elseif($i == 4)

															{

																$color_class='smgt_notice_color4';

															}

															?>

															<div class="calendar-event notice_div <?php echo $color_class; ?>"> 

																<div class="notice_div_contant profile_image_prescription">

																	<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 notice_description_div show_task_event" id="<?php echo esc_attr($retrieved_data->ID);?>" model="Notice Details">

																		<p class="cursor_pointer remainder_title Bold viewdetail notice_descriptions  notice_heading notice_content_rs" style="width: 100%;">	

																			<label for="" class="cursor_pointer notice_heading_label notice_heading_label_frontend notice_heading">

																				<?php echo esc_html($retrieved_data->post_title);?>	

																				<a href="#" class="cursor_pointer notice_date_div">

																					<?php echo MJ_gmgt_getdate_in_input_box(get_post_meta($retrieved_data->ID,'gmgt_start_date',true));?> &nbsp;|&nbsp; <?php echo MJ_gmgt_getdate_in_input_box(get_post_meta($retrieved_data->ID,'gmgt_start_date',true));?>

																				</a>

																			</label>

																		</p>

																		<p class="cursor_pointer remainder_title viewdetail notice_descriptions notice_comm_pr" style="width: 100%;">

																			<?php 

																				$strlength= strlen($retrieved_data->post_content);

																				if($strlength > 90)

																				{

																					echo substr(esc_html($retrieved_data->post_content), 0,90).'...';

																				}

																				else

																				{

																					echo esc_html($retrieved_data->post_content);

																				}

																			?>

																		</p>

																	</div>

																</div>

															</div>	

														<?php

														$i++;

														}

													}

													else

													{

														?>

														<div class="calendar-event-new"> 

															<img class="no_data_img" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/no_data_img.png"?>" >

															<?php

															if($notice_1['add'] == 1)

															{

																?>

																<div class="col-md-12 dashboard_btn padding_top_30px">

																	<a href="<?php echo home_url().'?dashboard=user&page=notice&tab=addnotice&action=insert'; ?>" class="btn save_btn event_for_alert line_height_31px"><?php esc_html_e('ADD Notice','gym_mgt');?></a>

																</div>	

																<?php

															}

															?>

														</div>		

														<?php

													}	

													?>

												</div>                       

											</div>

										</div>

									</div>

									<?php

								}

								$message_1 = 'message';

								$message_1=MJ_gmgt_get_userrole_wise_manually_page_access_right_array($message_1);

								if($message_1['view'] == 1)

								{

									?>

									<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12 responsive_div_dasboard precription_padding_left1">

										<div class="panel panel-white massage">

											<div class="panel-heading">

												<h3 class="panel-title"><?php esc_html_e('Message','gym_mgt');?></h3>						

												<a class="page-link123" href="<?php echo home_url().'?dashboard=user&page=message&tab=inbox'; ?>"><img class="vertical_align_unset" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Redirect.png"?>"></a>

											</div>

											<div class="panel-body">

												<div class="events notice_content_div">

													<?php         

													$max = 5;

													if(isset($_GET['pg']))

													{

														$p = $_GET['pg'];

													}

													else

													{

														$p = 1;

													}

													$limit = ($p - 1) * $max;



													$post_id=0;

													$message_data = MJ_gmgt_get_inbox_message(get_current_user_id($limit,$max));

													$i=0;

													if(!empty($message_data))

													{ 

														foreach ($message_data as $retrieved_data)

														{ 

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

															?>						

															<div class="calendar-event profile_image_class show_task_event" id="<?php echo $retrieved_data->message_id; ?>" model="Message Details"> 

																

																<p class="cursor_pointer class_tag Bold save1  show_task_event_list profile_image_appointment <?php echo $color_class; ?>" >

																	<img class="class_image center" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/Message.png"?>">

																</p>

																<p class="cursor_pointer padding_top_5px_res remainder_title_pr card_content_width show_task_event padding_top_card_content viewpriscription class_width" style="color: #333333;"  id="<?php echo $retrieved_data->message_id; ?>" model="Message Details"> 

																	<?php echo $retrieved_data->subject; ?>

																</p>

																<p class="cursor_pointer remainder_date_pr date_background class_width"> <label for="" class="cursor_pointer label_for_date"><?php echo MJ_gmgt_getdate_in_input_box($retrieved_data->date); ?></label> </p>

																<p class="cursor_pointer remainder_title_pr viewpriscription class_font_15px card_content_width class_width  assignbed_name1 card_margin_top"> 

																	<?php

																		$strlength = strlen($retrieved_data->message_body);

																		if ($strlength > 90) 

																		{

																			echo substr($retrieved_data->message_body, 10, 90) . '...';

																		} else 

																		{

																			echo $retrieved_data->message_body;

																		}

																	?>

																</p>

																

															</div>		

															<?php

															$i++;

														}

													}

													else

													{

														?>

														<div class="calendar-event-new"> 

															<img class="no_data_img" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/no_data_img.png"?>" >

															<?php

															if($message_1['add'] == 1)

															{

																?>

																<div class="col-md-12 dashboard_btn padding_top_30px">

																	<a href="<?php echo home_url().'?dashboard=user&page=message&tab=compose'; ?>" class="btn save_btn event_for_alert line_height_31px"><?php esc_html_e('ADD Message','gym_mgt');?></a>

																</div>	

																<?php

															}

															?>

														</div>		

													<?php

													}	

													?>					

												</div>

											</div>

										</div>

									</div>

									<?php

								}

								?>

							</div>

							<!-- Notice List and Massage List Row Div End  -->



							<!-- Schedule List Row Div Start  -->

							<?php

							$classschedule_1 = 'class-schedule';

							$classschedule_1=MJ_gmgt_get_userrole_wise_manually_page_access_right_array($classschedule_1);

							if($classschedule_1['view'] == 1)

							{

								?>

								<div class="row">

									<div class="col-sm-12 col-md-12 col-lg-12 col-xs-12 responsive_div_dasboard ">

										<div class="panel panel-white">

											<div class="panel-heading ">

												<h3 class="panel-title"><?php esc_html_e('Schedule List','gym_mgt');?></h3>						

												<a class="page-link123" href="<?php echo home_url().'?dashboard=user&page=class-schedule';?>"><img class="vertical_align_unset" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Redirect.png"?>"></a>

											</div>					

											<div class="panel-body gmgt_das_main_schedule">

												<table class="table table-bordered less schedule_btn class_border_div">

														<?php		   

														foreach(MJ_gmgt_days_array() as $daykey => $dayname)

														{

														?>			  

															<tr>

																<th width="100"><?php echo esc_html_e($dayname);?></th>

																<td>

																	<?php

																		$obj_class=new MJ_gmgt_classschedule;

																		$period = $obj_class->MJ_gmgt_get_schedule_byday($daykey);

																		if(!empty($period))

																		{

																			foreach($period as $period_data)

																			{

																				if(!empty($period_data))

																				{

																					echo '<div class="btn-group m-b-sm">';

																					echo '<button class="btn btn-primary"><span class="period_box" id='.$period_data['class_id'].'>'.MJ_gmgt_get_single_class_name($period_data['class_id']);

																					echo '<span class="time"> ('.MJ_gmgt_timeremovecolonbefoream_pm($period_data['start_time']).' - '.MJ_gmgt_timeremovecolonbefoream_pm($period_data['end_time']).') </span>';

																					echo '</div>';

																				}									

																			}

																		}

																	?>

																</td>

															</tr>

														<?php	

														}

														?>

												</table>

											</div>



										</div>

									</div>

								</div>

								<?php

							}

							

						} 

						?>

					</div>

					

				</div>

			</div>

		</div>

	    <footer class='gmgt-footer'>

			<p><?php echo get_option('gmgt_footer_description'); ?></p>

		</footer>

	</body>

</html><!--HTML END-->