<?php 

require_once GMS_PLUGIN_DIR . '/lib/chart/GoogleCharts.class.php';



$GoogleCharts = new GoogleCharts;



$obj_dashboard= new MJ_gmgt_dashboard;



$obj_reservation = new MJ_gmgt_reservation;



$reservationdata = $obj_reservation->MJ_gmgt_get_all_reservation();



$cal_array = array();



//GET RESERVATION DATA



if(!empty($reservationdata))



{



	foreach ($reservationdata as $retrieved_data)



	{		



       $start_time_array = explode(":",$retrieved_data->start_time);



       $start_time_array_new = $start_time_array[0].":".$start_time_array[1]."".$start_time_array[2];



	   $start_time_formate =  date("H:i:s", strtotime($start_time_array_new)); 



	   $start_time_data = new DateTime($start_time_formate); 



	   $starttime=date_format($start_time_data,'H:i:s');

	   $starttime_new=date_format($start_time_data,'H:i A');

	   $event_start_date=date('Y-m-d',strtotime($retrieved_data->event_date));



	   $aevent_start_date_new=$event_start_date." ".$starttime;



	   $end_time_array = explode(":",$retrieved_data->end_time);



       $abcnew = $end_time_array[0].":".$end_time_array[1]."".$end_time_array[2];



	   $Hour_new =  date("H:i:s", strtotime($abcnew)); 



	   $dnew = new DateTime($Hour_new); 



	   $endtime=date_format($dnew,'H:i:s');

	   $endtime_new=date_format($dnew,'H:i A');



	   $event__end_date=$event_start_date." ".$endtime; 

	 	$reservation_place = get_the_title(esc_html($retrieved_data->place_id));

		$start_to_end_time = $starttime_new.' To '.$endtime_new;

		$reservation_staffmember = MJ_gmgt_get_display_name(esc_html($retrieved_data->staff_id));



		$cal_array [] = array (



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



		); 



	}



}



//GET USER BIRTHDATE



$birthday_boys=get_users(array('role'=>'member'));



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



//GET NOTICE DATA



$all_notice = "";



$args['post_type'] = 'gmgt_notice';



$args['posts_per_page'] = -1;



$args['post_status'] = 'public';



$q = new WP_Query();



$all_notice = $q->query( $args );



if (! empty ( $all_notice ))



{



	foreach ( $all_notice as $notice ) 



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

		

		$start_to_end_date = $notice_start_date.' '.esc_html__( 'To', 'gym_mgt' ).' '.$notice_end_date;

		$notice_title = $notice->post_title;

		$notice_for = ucfirst(get_post_meta($notice->ID, 'notice_for',true));

        $class_name='';

		if(get_post_meta( $notice->ID, 'gmgt_class_id',true) != "" && get_post_meta( $notice->ID, 'gmgt_class_id',true) =="all")

		{

			$class_name = esc_html__('All','gym_mgt');

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



?>

<style>

	.ui-dialog-titlebar-close

	{

		font-size: 13px !important;

		border: 1px solid transparent !important;

		border-radius: 0 !important;

		outline: 0!important;

		background-color: #fff !important;

		background-image: url("<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Close.png"?>");

		background-repeat: no-repeat;

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

<script>



	var calendar_laungage ="<?php echo MJ_gmgt_get_current_lan_code();?>";



	var $ = jQuery.noConflict();



    document.addEventListener('DOMContentLoaded', function() 



	{



		var calendarEl = document.getElementById('calendar');



		var calendar = new FullCalendar.Calendar(calendarEl, 



		{



			dayMaxEventRows: true,	



			locale: calendar_laungage,



			headerToolbar: 



			{



				// left: 'prev,next today',



				left: 'prev,today next',



				center: 'title',



				right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'



			},



			events: <?php echo json_encode($cal_array);?>,



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

			},



		});



		calendar.render();	



	});



</script>



<!--task-event POP up code -->



<div class="popup-bg">



	<div class="overlay-content content_width">



		<div class="modal-content border_5">



			<div class="task_event_list">



			</div>     



		</div>



	</div>     



</div>



 <!-- End task-event POP-UP Code -->







 <!DOCTYPE html>



	<html lang="en"><!-- HTML START -->



		<head>



		</head>



		<!-- body part start  -->



		<body>



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



			<div class="row gmgt-header admin_dashboard_main_div" style="margin: 0;">



				<!--HEADER PART IN SET LOGO & TITEL START-->



				<div class="col-sm-12 col-md-12 col-lg-2 col-xl-2 padding_0">



					<a href="<?php echo admin_url().'admin.php?page=gmgt_system';?>" class='gmgt-logo'>



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



				<?php



				$role_new =MJ_gmgt_get_roles(get_current_user_id());







				if($role_new == 'administrator')



				{



					$user_activity_view=1;



					$user_membership_view=1;



					$user_coupon_view=1;

					

					$user_class_schedule_view = 1;



					$user_attendence_view =1;



					$user_assign_workout_view = 1;



					$user_nutrition_view = 1;



					$user_product_view = 1;



					$user_store_view = 1;



					$user_payment_view = 1;



					$user_membership_payment_view = 1;



					$user_tax_view = 1;



					$user_reservation_view = 1;



					$user_report_view = 1;



					$user_news_letter_view = 1;



					$user_notice_view = 1;



					$user_message_view = 1;



					$user_sms_setting_view = 1;



					$user_mail_template_view = 1;



					$user_access_right_view =  1;



					$user_general_setting_view =  1;



					$user_workouts_view = 1;



					$group_add_access = 1;

					$accountant_add_access = 1;

					$staff_add_access = 1;

					$member_add_access = 1;



					$user_activity_add=1;



					$user_membership_add=1;



					$user_coupon_add=1;



					$user_class_schedule_add= 1;



					$user_attendence_add =1;



					$user_assign_workout_add = 1;



					$user_nutrition_add = 1;



					$user_product_add = 1;



					$user_store_add = 1;



					$user_payment_add = 1;



					$user_membership_payment_add = 1;



					$user_tax_add = 1;



					$user_reservation_add = 1;



					$user_report_add = 1;



					$user_news_letter_add = 1;



					$user_notice_add = 1;



					$user_message_add = 1;



					$user_sms_setting_add = 1;



					$user_mail_template_add = 1;



					$user_access_right_add =  1;



					$user_general_setting_add =  1;



					$user_workouts_add = 1;



					$user_attendance_add = 1;

				}



				else



				{



					$activity = 'activity';



					$activity=MJ_gmgt_get_userrole_wise_manually_page_access_right_array_for_management($activity);



					$membership = 'membership';



					$membership=MJ_gmgt_get_userrole_wise_manually_page_access_right_array_for_management($membership);



					$coupon = 'coupon';



					$coupon=MJ_gmgt_get_userrole_wise_manually_page_access_right_array_for_management($coupon);



					$class_schedule='class-schedule';



					$class_schedule=MJ_gmgt_get_userrole_wise_manually_page_access_right_array_for_management($class_schedule);



					$attendence='attendence';



					$attendence=MJ_gmgt_get_userrole_wise_manually_page_access_right_array_for_management($attendence);



					$assign_workout = 'assign-workout';



					$assign_workout=MJ_gmgt_get_userrole_wise_manually_page_access_right_array_for_management($assign_workout);

				

					$workouts = 'workouts';



					$workouts=MJ_gmgt_get_userrole_wise_manually_page_access_right_array_for_management($workouts);



					$nutrition='nutrition';



					$nutrition=MJ_gmgt_get_userrole_wise_manually_page_access_right_array_for_management($nutrition);



					$product = 'product';



					$product=MJ_gmgt_get_userrole_wise_manually_page_access_right_array_for_management($product);



					$store = 'store';



					$store=MJ_gmgt_get_userrole_wise_manually_page_access_right_array_for_management($store);



					$tax = 'tax';



					$tax=MJ_gmgt_get_userrole_wise_manually_page_access_right_array_for_management($tax);



					$membership_payment = 'membership_payment';



					$membership_payment=MJ_gmgt_get_userrole_wise_manually_page_access_right_array_for_management($membership_payment);



					$payment = 'payment';



					$payment=MJ_gmgt_get_userrole_wise_manually_page_access_right_array_for_management($payment);



					$reservation = 'reservation';



					$reservation=MJ_gmgt_get_userrole_wise_manually_page_access_right_array_for_management($reservation);



					$report = 'report';



					$report=MJ_gmgt_get_userrole_wise_manually_page_access_right_array_for_management($report);



					$news_letter_page = 'news_letter';



					$news_letter_module_access =MJ_gmgt_get_userrole_wise_manually_page_access_right_array_for_management($news_letter_page);



					$notice = 'notice';



					$notice=MJ_gmgt_get_userrole_wise_manually_page_access_right_array_for_management($notice);



					$message_page = 'message';



					$message_module_access =MJ_gmgt_get_userrole_wise_manually_page_access_right_array_for_management($message_page);



					$sms_setting = 'sms_setting';



					$sms_setting=MJ_gmgt_get_userrole_wise_manually_page_access_right_array_for_management($sms_setting);



					$mail_template = 'mail_template';



					$mail_template=MJ_gmgt_get_userrole_wise_manually_page_access_right_array_for_management($mail_template);



					$access_right = 'access_right';



					$access_right=MJ_gmgt_get_userrole_wise_manually_page_access_right_array_for_management($access_right);



					$general_setting = 'general_settings';



					$general_setting=MJ_gmgt_get_userrole_wise_manually_page_access_right_array_for_management($general_setting);



					$group = 'group';

					$group_module = MJ_gmgt_get_userrole_wise_manually_page_access_right_array_for_management($group);



					$user_activity_view = $activity['view'];



					$user_class_schedule_view = $class_schedule['view'];



					$user_membership_view = $membership['view'];



					$user_coupon_view = $coupon['view'];



					$user_attendence_view = $attendence['view'];



					$user_assign_workout_view = $assign_workout['view'];



					$user_workouts_view = $workouts['view'];



					$user_nutrition_view = $nutrition['view'];



					$user_product_view = $product['view'];



					$user_store_view = $store['view'];



					$user_tax_view = $tax['view'];



					$user_membership_payment_view = $membership_payment['view'];



					$user_payment_view = $payment['view'];



					$user_reservation_view = $reservation['view'];



					$user_report_view = $report['view'];



					$user_news_letter_view = $news_letter_module_access['view'];



					$user_notice_view = $notice['view'];



					$user_message_view = $message_module_access['view'];



					$user_sms_setting_view = $sms_setting['view'];



					$user_mail_template_view = $mail_template['view'];



					if(!empty($access_right['view']))

					{

						$user_access_right_view = $access_right['view'];

					}

					else

					{

						$user_access_right_view = 0;

					}

					if(!empty($general_setting['view']))

					{

						$user_general_setting_view = $general_setting['view'];

					}

					else

					{

						$user_general_setting_view = 0;

					}



					if(!empty($group_module['add']))

					{

						$group_add_access = $group_module['add'];

					}

					else

					{

						$group_add_access = 0;

					}

					

					$member = 'member';

					$member_module = MJ_gmgt_get_userrole_wise_manually_page_access_right_array_for_management($member);

					if(!empty($group_module['add']))

					{

						$member_add_access = $member_module['add'];

					}

					else

					{

						$member_add_access = 0;

					}



					$staff = 'staff_member';

					$staff_module = MJ_gmgt_get_userrole_wise_manually_page_access_right_array_for_management($staff);

					if(!empty($staff_module['add']))

					{

						$staff_add_access = $staff_module['add'];

					}

					else

					{

						$staff_add_access = 0;

					}



					$accountant = 'accountant';

					$accountant_module = MJ_gmgt_get_userrole_wise_manually_page_access_right_array_for_management($accountant);

					if(!empty($accountant_module['add']))

					{

						$accountant_add_access = $accountant_module['add'];

					}

					else

					{

						$accountant_add_access = 0;

					}



					$user_activity_add = $activity['add'];

					

					$user_class_schedule_add = $class_schedule['add'];



					$user_membership_add = $membership['add'];



					$user_coupon_add = $coupon['add'];



					$user_attendence_add = $attendence['add'];



					$user_assign_workout_add = $assign_workout['add'];



					$user_workouts_add = $workouts['add'];



					$user_nutrition_add = $nutrition['add'];



					$user_product_add = $product['add'];



					$user_store_add = $store['add'];



					$user_tax_add = $tax['add'];

					

					$user_membership_payment_add = $membership_payment['add'];



					$user_payment_add = $payment['add'];



					$user_reservation_add = $reservation['add'];



					$user_report_add = $report['add'];



					$user_news_letter_add = $news_letter_module_access['add'];



					$user_notice_add = $notice['add'];



					$user_message_add = $message_module_access['add'];



					$user_sms_setting_add = $sms_setting['add'];



					$user_mail_template_add = $mail_template['add'];



					if(!empty($access_right['add']))

					{

						$user_access_right_add = $access_right['add'];

					}

					else

					{

						$user_access_right_add = 0;

					}

					if(!empty($general_setting['add']))

					{

						$user_general_setting_add = $general_setting['add'];

					}

					else

					{

						$user_general_setting_add = 0;

					}



				}



				?>



				<div class="col-sm-12 col-md-12 col-lg-10 col-xl-10 gmgt-right-heder">



					<div class="row">



						<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 name_and_icon_dashboard align_items_unset_res smgt_header_width">



							<div class="smgt_title_add_btn">



								<!-- Page Name  -->



								<h3 class="gmgt-addform-header-title rtl_menu_backarrow_float">



									<?php



										$obj_gym = new MJ_gmgt_Gym_management ( get_current_user_id () );



										$page_name = "";

										$active_tab = "";

										$action = "";

										$invoice_type = '';

										if(!empty($_REQUEST['page']))  

										{

											$page_name = $_REQUEST ['page'];  

										}

										if(!empty($_REQUEST['tab']))  

										{

											$active_tab = $_REQUEST['tab'];

										}

										if(!empty($_REQUEST['action']))

										{

											$action = $_REQUEST['action'];

										}

										if(!empty($_REQUEST['invoice_type']))

										{

											$invoice_type = $_REQUEST['invoice_type'];

										}

										

										$role = $obj_gym->role;





									if($_REQUEST ['page']  && $_REQUEST ['page'] == 'gmgt_system')

									{

										echo esc_html_e( 'Welcome to ', 'gym_mgt' );

										if($role == 'management')

										{

											echo esc_html_e( "Management", 'gym_mgt' );

										}

										else

										{

											echo esc_html_e('Admin,', 'gym_mgt' );

										}

										echo esc_html_e( ' Dashboard', 'gym_mgt' );

									}

									elseif($page_name == 'gmgt_group')

									{



										if($active_tab == 'addgroup')



										{



											?>



											<a href='<?php echo admin_url().'admin.php?page=gmgt_group';?>'>



												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">



											</a>



											<?php



											if($action == 'edit')



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



									elseif($page_name == 'gmgt_member')



									{



										if($active_tab == 'addmember' || $active_tab == 'viewmember')



										{



											?>



											<a href='<?php echo admin_url().'admin.php?page=gmgt_member';?>'>



												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">



											</a>



											<?php



											if($action == 'edit')



											{



												echo esc_html_e('Edit Member', 'gym_mgt' );



											}



											elseif($action == 'view'){



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



									elseif($page_name == 'gmgt_staff')



									{



										if($active_tab == 'add_staffmember' || $active_tab == 'view_staffmember')



										{



											?>



											<a href='<?php echo admin_url().'admin.php?page=gmgt_staff';?>'>



												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">



											</a>



											<?php



											if($action == 'edit')



											{



												echo esc_html_e('Edit Staff Member', 'gym_mgt' );



											}



											elseif($action == 'view')



											{



												echo esc_html_e('View Staff Member', 'gym_mgt' );



											}



											else



											{



												echo esc_html_e( 'Add Staff Member', 'gym_mgt' );



											}



										}



										else



										{	



											echo esc_html_e( 'Staff Members', 'gym_mgt' );



										}



									}











									elseif($page_name == 'gmgt_activity')



									{



										if($active_tab == 'addactivity' || $active_tab == 'view_membership' || $active_tab == 'view_video')



										{



											?>



											<a href='<?php echo admin_url().'admin.php?page=gmgt_activity';?>'>



												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">



											</a>



											<?php



											if($action == 'edit')



											{



												echo esc_html_e('Edit Activity', 'gym_mgt' );



											}



											elseif($active_tab == 'view_membership' && $action == 'view')



											{



												echo esc_html_e('View Membership Plan', 'gym_mgt' );



											}



											elseif($active_tab == 'view_video' && $action == 'view')



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







									elseif($page_name == 'gmgt_membership_type')



									{



										if($active_tab == 'addmembership' || $active_tab == 'view-activity')



										{



											?>



											<a href='<?php echo admin_url().'admin.php?page=gmgt_membership_type';?>'>



												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">



											</a>



											<?php



											if($action == 'edit')



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

									elseif($page_name == 'gmgt_coupon')

									{

										if($active_tab == 'add_coupon'){

											?>

											<a href='<?php echo admin_url().'admin.php?page=gmgt_coupon';?>'>



												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">



											</a>

											<?php

											if($action == 'edit')



											{



												echo esc_html_e('Edit Coupon', 'gym_mgt' );



											}

											else

											{

												echo esc_html_e( 'Add New Coupon', 'gym_mgt' );

											}

											

										}

										else{

											echo esc_html_e( 'Coupon', 'gym_mgt' );

										}

									}



									elseif($page_name == 'gmgt_accountant')



									{



										if($active_tab == 'add_accountant' || $active_tab == 'view_accountant')



										{



											?>



											<a href='<?php echo admin_url().'admin.php?page=gmgt_accountant';?>'>



												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">



											</a>



											<?php



											if($action == 'edit')



											{



												echo esc_html_e('Edit Accountant', 'gym_mgt' );



											}



											elseif($action == 'view')



											{



												echo esc_html_e('View Accountant', 'gym_mgt' );



											}



											else



											{



												echo esc_html_e( 'Add Accountant', 'gym_mgt' );



											}



										}



										else



										{	



											echo esc_html_e( 'Accountant', 'gym_mgt' );



										}



									}







									elseif($page_name == 'gmgt_reservation')



									{



										if($active_tab == 'addreservation')



										{



											?>



											<a href='<?php echo admin_url().'admin.php?page=gmgt_reservation';?>'>



												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">



											</a>



											<?php



											if($action == 'edit')



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



									elseif($page_name == 'gmgt_notice')



									{



										if($active_tab == 'addnotice')



										{



											?>



											<a href='<?php echo admin_url().'admin.php?page=gmgt_notice';?>'>



												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">



											</a>



											<?php



											if($action == 'edit')



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



									elseif($page_name == 'gmgt_class')



									{



										if($active_tab == 'addclass')



										{



											?>



											<a href='<?php echo admin_url().'admin.php?page=gmgt_class';?>'>



												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">



											</a>



											<?php



											if($action == 'edit')



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



										elseif($active_tab == 'schedulelist')



										{



											?>



											<a href='<?php echo admin_url().'admin.php?page=gmgt_class';?>'>



												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">



											</a>



											<?php



											echo esc_html_e( 'Class Schedule', 'gym_mgt' );



										}



										elseif($active_tab == 'guest_list')



										{



											?>



											<a href='<?php echo admin_url().'admin.php?page=gmgt_class';?>'>



												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">



											</a>



											<?php



											echo esc_html_e( 'Class Schedule', 'gym_mgt' );



										}



										elseif($active_tab == 'booking_list')



										{



											?>



											<a href='<?php echo admin_url().'admin.php?page=gmgt_class';?>'>



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



									elseif($page_name == 'gmgt_attendence')



									{

										if($active_tab == 'attendence_list')

										{

											echo esc_html_e( 'Member Attendance', 'gym_mgt' );

										}elseif($active_tab == 'staff_attendence_list')

										{

											echo esc_html_e( 'Staff Member Attendance', 'gym_mgt' );

										}else{

											echo esc_html_e( 'Attendance', 'gym_mgt' );

										}



									}



									elseif($page_name == 'gmgt_workouttype')



									{



										if($active_tab == 'addworkouttype')



										{



											?>



											<a href='<?php echo admin_url().'admin.php?page=gmgt_workouttype';?>'>



												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">



											</a>



											<?php



											if($action == "edit")



											{



												echo esc_html_e( 'Edit Assign Workout', 'gym_mgt' );



											}



											elseif($action == "view")



											{



												echo esc_html_e('View Assign Workout', 'gym_mgt' );



											}



											else



											{



												echo esc_html_e( 'Add Assign Workout', 'gym_mgt' );



											}



										}



										elseif($active_tab == "view_video")



										{



											?>



											<a href='<?php echo admin_url().'admin.php?page=gmgt_workouttype';?>'>



												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">



											</a>



											<?php



											echo esc_html_e( 'View Video', 'gym_mgt' );



										}



										elseif($active_tab == "editworkouttype")



										{



											?>



											<a href='<?php echo admin_url().'admin.php?page=gmgt_workouttype';?>'>



												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">



											</a>



											<?php



											echo esc_html_e( 'Edit Assign Workout', 'gym_mgt' );



										}



										else



										{



											echo esc_html_e( 'Assign Workout', 'gym_mgt' );



										}



										



									}



									elseif($page_name == 'gmgt_workout')



									{



										if($active_tab == 'addworkout')



										{



											?>



											<a href='<?php echo admin_url().'admin.php?page=gmgt_workout';?>'>



												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">



											</a>



											<?php



											if($action == "view")



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



											if($action == "edit")



											{



												echo esc_html_e( 'Edit Measurement', 'gym_mgt' );



											}



											else{



												echo esc_html_e( 'Add Measurement', 'gym_mgt' );



											}



											//echo esc_html_e( 'Add Measurement', 'gym_mgt' );



										}



										else



										{



											echo esc_html_e( 'Workout Log', 'gym_mgt' );



										}



									}



									



									



									elseif($page_name == 'gmgt_product')



									{



										if($active_tab == 'addproduct')



										{



											?>



											<a href='<?php echo admin_url().'admin.php?page=gmgt_product';?>'>



												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">



											</a>



											<?php



											if($action == "edit")



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



									elseif($page_name == 'gmgt_store')



									{



										if($invoice_type == 'sell_invoice')



										{



											?>



											<a href='<?php echo admin_url().'admin.php?page=gmgt_store';?>'>



												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">



											</a>



											<?php



											echo esc_html_e( 'View Invoice', 'gym_mgt' );



										}



										elseif($active_tab == 'sellproduct')



										{



											?>



											<a href='<?php echo admin_url().'admin.php?page=gmgt_store';?>'>



												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">



											</a>



											<?php



											if($action == "edit")



											{



												echo esc_html_e( 'Edit Sale Product', 'gym_mgt' );



											}



											else



											{



												echo esc_html_e( 'Add Sale Product', 'gym_mgt' );



											}



										}



										else



										{



											echo esc_html_e( 'Sale Product', 'gym_mgt' );



										}



									}



									elseif($page_name == 'MJ_gmgt_gmgt_taxes')



									{



										if($active_tab == 'addtax')



										{



											?>



											<a href='<?php echo admin_url().'admin.php?page=MJ_gmgt_gmgt_taxes';?>'>



												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">



											</a>



											<?php



											if($action == "edit")



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



									elseif($page_name == 'MJ_gmgt_fees_payment')



									{



										if($invoice_type == 'membership_invoice')



										{



											?>



											<a href='<?php echo admin_url().'admin.php?page=MJ_gmgt_fees_payment';?>'>



												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">



											</a>



											<?php



											echo esc_html_e( 'View Invoice', 'gym_mgt' );



										}



										elseif($active_tab == 'addpayment')



										{



											?>



											<a href='<?php echo admin_url().'admin.php?page=MJ_gmgt_fees_payment';?>'>



												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">



											</a>



											<?php



											if($action == "edit")



											{



												echo esc_html_e( 'Edit Membership Payment', 'gym_mgt' );



											}



											else



											{



												echo esc_html_e( 'Add Membership Payment', 'gym_mgt' );



											}



										}



										else



										{



											echo esc_html_e( 'Membership Payment', 'gym_mgt' );



										}



									}



									elseif($page_name == 'gmgt_payment')



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



											if($invoice_type == 'income')



											{



												?>



												<a href='<?php echo admin_url().'admin.php?page=gmgt_payment&tab=incomelist';?>'>



													<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">



												</a>



												<?php



												echo esc_html_e( 'View Invoice', 'gym_mgt' );



											}



											if($invoice_type == 'expense')



											{



												?>



												<a href='<?php echo admin_url().'admin.php?page=gmgt_payment&tab=expenselist';?>'>



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



									elseif($page_name == 'gmgt_virtual_class')



									{



										if($active_tab == 'edit_meeting')



										{



											?>



											<a href='<?php echo admin_url().'admin.php?page=gmgt_virtual_class';?>'>



												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">



											</a>



											<?php



											echo esc_html_e('Edit Virtual Class', 'gym_mgt' );



										}



										elseif($active_tab == 'view_past_participle_list')



										{



											?>



											<a href='<?php echo admin_url().'admin.php?page=gmgt_virtual_class';?>'>



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



									elseif($page_name == 'gmgt_newsletter')



									{



										echo esc_html_e( 'Newsletter', 'gym_mgt' );



									}



									elseif($page_name == 'Gmgt_message')



									{



										echo esc_html_e( 'Message', 'gym_mgt' );



									}



									elseif($page_name == 'gmgt_sms_setting')



									{



										echo esc_html_e( 'SMS Setting', 'gym_mgt' );



									}



									elseif($page_name == 'gmgt_access_right')



									{



										echo esc_html_e( 'Access Rights', 'gym_mgt' );



									}



									elseif($page_name == 'gmgt_gnrl_settings')



									{



										echo esc_html_e( 'General Settings', 'gym_mgt' );



									}



									elseif($page_name == 'gmgt_mail_template')



									{



										echo esc_html_e( 'Email Template', 'gym_mgt' );



									}



									elseif($page_name == 'gmgt_report')



									{

										if($active_tab == 'member_information')

										{

											echo esc_html_e( 'Membership Information Report', 'gym_mgt' );

										}

										elseif($active_tab == 'membership_report')

										{

											echo esc_html_e( 'Membership Report', 'gym_mgt' );

										}

										elseif($active_tab == 'payment_report')

										{

											echo esc_html_e( 'Finance/Payment Report', 'gym_mgt' );

										}

										elseif($active_tab == 'attendance_report')

										{

											echo esc_html_e( 'Attendance Report', 'gym_mgt' );

										}

										elseif($active_tab == 'user_log')

										{

											echo esc_html_e( 'User Log Report', 'gym_mgt' );

										}

										elseif($active_tab == 'audit_trail')

										{

											echo esc_html_e( 'Audit Trail Report', 'gym_mgt' );

										}

										else{

											echo esc_html_e( 'Report', 'gym_mgt' );

										}



									}



									elseif($page_name == 'gmgt_setup')



									{



										echo esc_html_e( 'License Setting', 'gym_mgt' );



									}



									else



									{



										echo $page_name;



									}



									?>



								</h3>



								<div class="smgt_add_btn"><!-------- Plus button div -------->



									<?php



										if($page_name == "gmgt_group" && $active_tab != 'addgroup')



										{

											if($group_add_access == 1)

											{											

												?>



												<a href='<?php echo admin_url().'admin.php?page=gmgt_group&tab=addgroup';?>'>



													<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Add_new_Button.png" ?>">



												</a>



												<?php

											}

										}



										elseif($page_name == "gmgt_member" && $active_tab != 'addmember' && $active_tab != 'viewmember')



										{

											if($member_add_access == 1)

											{

												?>



												<a href='<?php echo admin_url().'admin.php?page=gmgt_member&tab=addmember';?>'>



													<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Add_new_Button.png" ?>">



												</a>



												<?php

											}

											



										}



										elseif($page_name == "gmgt_staff" && $active_tab != 'add_staffmember' && $active_tab != 'view_staffmember')



										{

											if($staff_add_access == 1)

											{

												?>



												<a href='<?php echo admin_url().'admin.php?page=gmgt_staff&tab=add_staffmember';?>'>



													<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Add_new_Button.png" ?>">



												</a>



												<?php

											}

										}



										elseif($page_name == "gmgt_accountant" && $active_tab != 'add_accountant' && $active_tab != 'view_accountant')



										{

											if($accountant_add_access == 1)

											{

												?>



												<a href='<?php echo admin_url().'admin.php?page=gmgt_accountant&tab=add_accountant';?>'>



													<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Add_new_Button.png" ?>">



												</a>



												<?php

											}

										}



										elseif($page_name == "gmgt_activity" && $active_tab != 'addactivity' && $active_tab != 'view_video' && $active_tab != 'view_membership')



										{

											if($user_activity_add == 1)

											{

												?>



												<a href='<?php echo admin_url().'admin.php?page=gmgt_activity&tab=addactivity';?>'>



													<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Add_new_Button.png" ?>">



												</a>



												<?php

											}

										}



										elseif($page_name == "gmgt_membership_type" && $active_tab != 'addmembership' && $active_tab != 'view-activity')



										{

											if($user_membership_add == 1)

											{

												?>



												<a href='<?php echo admin_url().'admin.php?page=gmgt_membership_type&tab=addmembership';?>'>



													<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Add_new_Button.png" ?>">



												</a>



												<?php

											}

										}

										elseif($page_name == "gmgt_coupon" && $active_tab != 'add_coupon')



										{

											if($user_coupon_add == 1)

											{

												?>



												<a href='<?php echo admin_url().'admin.php?page=gmgt_coupon&tab=add_coupon';?>'>



													<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Add_new_Button.png" ?>">



												</a>



												<?php

											}

										}



										elseif($page_name == "gmgt_reservation" && $active_tab != 'addreservation')



										{

											if($user_reservation_add == 1)

											{

												?>



												<a href='<?php echo admin_url().'admin.php?page=gmgt_reservation&tab=addreservation';?>'>



													<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Add_new_Button.png" ?>">



												</a>



												<?php

											}

										}



										elseif($page_name == "gmgt_notice" && $active_tab != 'addnotice')



										{

											if($user_notice_add == 1)

											{

												?>



												<a href='<?php echo admin_url().'admin.php?page=gmgt_notice&tab=addnotice';?>'>



													<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Add_new_Button.png" ?>">



												</a>



												<?php

											}

										}



										elseif($page_name == "gmgt_workouttype" && $active_tab != 'addworkouttype' && $active_tab != 'view_video' && $active_tab != 'editworkouttype')



										{

											if($user_assign_workout_add == 1)

											{

												?>



												<a href='<?php echo admin_url().'admin.php?page=gmgt_workouttype&tab=addworkouttype';?>'>



													<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Add_new_Button.png" ?>">



												</a>



												<?php

											}

										}



										elseif($page_name == "gmgt_workout" && $active_tab != 'addworkout' && $active_tab != 'addmeasurement')



										{

											if($user_workouts_add == 1)

											{

												?>



												<a href='<?php echo admin_url().'admin.php?page=gmgt_workout&tab=addworkout';?>'>



													<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Add_new_Button.png" ?>">



												</a>



												<?php

											}

										}



										elseif($page_name == "gmgt_nutrition" && $active_tab != 'addnutrition')



										{

											if($user_nutrition_add == 1)

											{

												?>



												<a href='<?php echo admin_url().'admin.php?page=gmgt_nutrition&tab=addnutrition';?>'>



													<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Add_new_Button.png" ?>">



												</a>



												<?php

											}

										}



										elseif($page_name == "Gmgt_message" && $active_tab != 'compose')



										{

											if($user_message_add == 1)

											{

												?>



												<a href='<?php echo admin_url().'admin.php?page=Gmgt_message&tab=compose';?>'>



													<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Add_new_Button.png" ?>">



												</a>



												<?php

											}

										}



										elseif($page_name == "gmgt_product" && $active_tab != 'addproduct')



										{

											if($user_product_add == 1)

											{

												?>



												<a href='<?php echo admin_url().'admin.php?page=gmgt_product&tab=addproduct';?>'>



													<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Add_new_Button.png" ?>">



												</a>



												<?php

											}

										}



										elseif($page_name == "gmgt_store" && $active_tab != 'sellproduct' && $active_tab != 'view_invoice')



										{

											if($user_store_add == 1)

											{

												?>



												<a href='<?php echo admin_url().'admin.php?page=gmgt_store&tab=sellproduct';?>'>



													<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Add_new_Button.png" ?>">



												</a>



												<?php

											}

										}



										elseif($page_name == "MJ_gmgt_gmgt_taxes" && $active_tab != 'addtax')



										{

											if($user_tax_add == 1)

											{

												?>



												<a href='<?php echo admin_url().'admin.php?page=MJ_gmgt_gmgt_taxes&tab=addtax';?>'>



													<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Add_new_Button.png" ?>">



												</a>



												<?php

											}

										}



										elseif($page_name == "MJ_gmgt_fees_payment" && $active_tab != 'addpayment' && $active_tab != 'view_invoice')



										{

											if($user_membership_payment_add == 1)

											{

												?>



												<a href='<?php echo admin_url().'admin.php?page=MJ_gmgt_fees_payment&tab=addpayment';?>'>



													<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Add_new_Button.png" ?>">



												</a>



												<?php

											}

										}



										elseif($page_name == "gmgt_payment")



										{

											if($user_payment_add == 1)

											{

												if($active_tab == 'incomelist')



												{



													?>



													<a href='<?php echo admin_url().'admin.php?page=gmgt_payment&tab=addincome';?>'>



														<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Add_new_Button.png" ?>">



													</a>



													<?php



												}



												elseif($active_tab == 'expenselist')



												{



													?>



													<a href='<?php echo admin_url().'admin.php?page=gmgt_payment&tab=addexpense';?>'>



														<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Add_new_Button.png" ?>">



													</a>



													<?php



												}

											}

											

										}



									?>



								</div><!-------- Plus button div -------->



							</div>



						</div>



						



						<!-- Right Header  -->



						<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">



							<div class="gmgt-setting-notification">



								<a href='<?php echo admin_url().'admin.php?page=gmgt_gnrl_settings';?>' class="gmgt-setting-notification-bg">



									<img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Settings.png"?>" class="gmgt-right-heder-list-link">



								</a>



								<a href='<?php echo admin_url().'admin.php?page=Gmgt_message';?>' class="gmgt-setting-notification-bg">



									<img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Bell-Notification.png"?>" class="gmgt-right-heder-list-link">



									<spna class="between_border123 gmgt-right-heder-list-link"> </span>



								</a>



								<div class="gmgt-user-dropdown">



									<ul class="">



										<!-- BEGIN USER LOGIN DROPDOWN -->



										<li class="">



											<a class="" href="#" data-bs-toggle="dropdown" aria-expanded="false">



												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Avatar1.png"?>" class="gmgt-dropdown-userimg" >



											</a>



											<ul class="dropdown-menu extended action_dropdawn logout_dropdown_menu logout heder-dropdown-menu" aria-labelledby="dropdownMenuLink">



												<li class="float_left_width_100 ">



													<a class="dropdown-item gmgt-back-wp float_left_width_100" href="<?php echo admin_url();?>"><i class="fa fa-user"></i>



													<?php esc_html_e('Back to wp-admin', 'gym_mgt' ); ?></a>



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



						<!-- Right Header  -->



					</div>	



				</div>	



			</div>



			<div class="row main_page admin_dashboard_menu_rs"  style="margin: 0;">



				<div class="col-sm-12 col-md-12 col-lg-2 col-xl-2 padding_0" id="main_sidebar-bgcolor">



					<!-- menu sidebar main div strat  -->



					<div class="main_sidebar">



						<nav id="sidebar">



							<ul class='gmgt-navigation navbar-collapse rs_side_menu_bgcolor' id="navbarNav">



								<?php

								if($_REQUEST ['page'] == "gmgt_setup")

								{

									?>

									<li class="card-icon">

										<a href="<?php echo admin_url().'admin.php?page=gmgt_setup';?>" class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "gmgt_setup") { echo "active"; } ?>">

											<img class="icon img-top" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/liecance.png"?>">

											<img class="icon " src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/liecance-white.png"?>">

											<span><?php esc_html_e( 'License Setting', 'gym_mgt' ); ?></span>

										</a>

									</li>

									<?php

								}

								?>

								

								<li class="card-icon">



									<a href="<?php echo admin_url().'admin.php?page=gmgt_system';?>" class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "gmgt_system") { echo "active"; } ?>">



										<img class="icon img-top" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/dashboards.png"?>">



										<!-- <img class="icon " src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/icons/White_icons/dashboards.png"?>"> -->



										<img class="icon " src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/dashboards.png"?>">



										<span><?php esc_html_e( 'Dashboard', 'gym_mgt' ); ?></span>



									</a>



								</li>



								<li class="has-submenu nav-item card-icon">



									<a href='#' class=" <?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "gmgt_member" || $_REQUEST ['page'] && $_REQUEST ['page'] == "gmgt_staff" || $_REQUEST ['page'] && $_REQUEST ['page'] == "gmgt_accountant" || $_REQUEST ['page'] && $_REQUEST ['page'] == "gmgt_group" ) { echo "active"; } ?>">



										<img class="icon img-top" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/User Management.png"?>">



										<img class="icon " src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/User Management.png"?>">



										<span><?php esc_html_e('User Management', 'gym_mgt' ); ?></span>



										<i class="fa <?php echo $rtl_left_icon_class; ?> dropdown-right-icon icon" aria-hidden="true"></i>



										<i class="fa fa-chevron-down icon dropdown-down-icon" aria-hidden="true"></i>



									</a>



									<ul class='submenu dropdown-menu'>



										<li class=''>



											<a href='<?php echo admin_url().'admin.php?page=gmgt_member';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "gmgt_member") { echo "active"; } ?>">



											<span><?php esc_html_e( 'Members', 'gym_mgt' ); ?></span>



											</a>



										</li>



										<li class=''>



											<a href='<?php echo admin_url().'admin.php?page=gmgt_staff';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "gmgt_staff") { echo "active"; } ?>">



											<span><?php esc_html_e( 'Staff Members', 'gym_mgt' ); ?></span>



											</a>



										</li>



										<li class=''>



											<a href='<?php echo admin_url().'admin.php?page=gmgt_accountant';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "gmgt_accountant") { echo "active"; } ?>">



											<span><?php esc_html_e( 'Accountant', 'gym_mgt' ); ?></span>



											</a>



										</li>



										<li class=''>



											<a href='<?php echo admin_url().'admin.php?page=gmgt_group';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "gmgt_group") { echo "active"; } ?>">



											<span><?php esc_html_e( 'Group', 'gym_mgt' ); ?></span>



											</a>



										</li>



									</ul> 



								</li>



								<?php

								

								if($user_activity_view == 1 || $user_membership_view == 1 || $user_coupon_view == 1 )



								{



									?>



									<li class="has-submenu nav-item card-icon">



										<a href='#' class=" <?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "gmgt_activity" || $_REQUEST ['page'] && $_REQUEST ['page'] == "gmgt_membership_type" || $_REQUEST ['page'] && $_REQUEST ['page'] == "gmgt_coupon") { echo "active"; } ?>">



											<img class="icon img-top" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/Membership.png"?>">



											<img class="icon " src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/Membership.png"?>">



											<span class="margin_left_10px"><?php esc_html_e('Membership Plan', 'gym_mgt' ); ?></span>



											<i class="fa <?php echo $rtl_left_icon_class; ?> dropdown-right-icon icon" aria-hidden="true"></i>



											<i class="fa fa-chevron-down icon dropdown-down-icon" aria-hidden="true"></i>



										</a>



										<ul class='submenu dropdown-menu'>



											<?php



											if($user_activity_view == 1)



											{



												?>



												<li class=''>



													<a href='<?php echo admin_url().'admin.php?page=gmgt_activity';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "gmgt_activity") { echo "active"; } ?>">



													<span><?php esc_html_e( 'Activity', 'gym_mgt' ); ?></span>



													</a>



												</li>



												<?php



											}



											if($user_membership_view == 1)



											{



												?>



												<li class=''>



													<a href='<?php echo admin_url().'admin.php?page=gmgt_membership_type';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "gmgt_membership_type") { echo "active"; } ?>">



													<span><?php esc_html_e( 'Membership Plan', 'gym_mgt' ); ?></span>



													</a>



												</li>



												<?php



											}

											if($user_coupon_view == 1)



											{



												?>



												<li class=''>



													<a href='<?php echo admin_url().'admin.php?page=gmgt_coupon';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "gmgt_coupon") { echo "active"; } ?>">

													

													<span><?php esc_html_e( 'Coupons', 'gym_mgt' ); ?></span>



													</a>



												</li>



												<?php



											}



											?>



										</ul> 



									</li>



									<?php



								}



								if($user_class_schedule_view == 1)



								{



									?>



									<li class="card-icon">



										<a href="<?php echo admin_url().'admin.php?page=gmgt_class';?>" class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "gmgt_class") { echo "active"; } ?>">



											<img class="icon img-top" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/Class Schedule.png"?>">



											<img class="icon " src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/Class Schedule.png"?>">



											<span><?php esc_html_e( 'Class Schedule', 'gym_mgt' ); ?></span>



										</a>



									</li>



									<?php



								}



								if(get_option('gmgt_enable_virtual_classschedule') == 'yes')



								{



									?>



									<li class="card-icon">



										<a href="<?php echo admin_url().'admin.php?page=gmgt_virtual_class';?>" class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "gmgt_virtual_class") { echo "active"; } ?>">



											<img class="icon img-top" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/White_Icons/Virtual_class_black.png"?>" style="height:20px;width:20px;">



											<img class="icon " src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/White_Icons/Virtual_class.png"?>" style="height:20px;width:20px;">



											<span><?php esc_html_e( 'Virtual Class', 'gym_mgt' ); ?></span>



										</a>



									</li>



									<?php



									



								}



								if($user_attendence_view == 1)



								{



									?>



									<li class="card-icon has-submenu nav-item">



										<a href="#" class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "gmgt_attendence") { echo "active"; } ?>">



											<img class="icon img-top" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/Attendance.png"?>">



											<img class="icon " src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/Attendance.png"?>">



											<span><?php esc_html_e( 'Attendance', 'gym_mgt' ); ?></span>

											<i class="fa <?php echo $rtl_left_icon_class; ?> dropdown-right-icon icon" aria-hidden="true"></i>



											<i class="fa fa-chevron-down icon dropdown-down-icon" aria-hidden="true"></i>



										</a>



										<ul class='submenu dropdown-menu'>



										<?php



										if($user_attendance_add == 1)



										{



											?>



											<li class=''>



												<a href='<?php echo admin_url().'admin.php?page=gmgt_attendence&tab=attendence_list';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "gmgt_workouttype") { echo "active"; } ?>">



												<span><?php esc_html_e( 'Member Attendance', 'gym_mgt' ); ?></span>



												</a>



											</li>	

											<li class=''>



												<a href='<?php echo admin_url().'admin.php?page=gmgt_attendence&tab=staff_attendence_list';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "gmgt_workouttype") { echo "active"; } ?>">



												<span><?php esc_html_e( 'Staff Member Attendance', 'gym_mgt' ); ?></span>



												</a>



											</li>

											<?php

										} ?>



											

										</ul> 



									</li>

									



									<?php



								}



								



								



								if($user_product_view == 1 || $user_store_view == 1)



								{



									?>



									<li class="has-submenu nav-item card-icon">



										<a href='#' class=" <?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "gmgt_product" || $_REQUEST ['page'] && $_REQUEST ['page'] == "gmgt_store" ) { echo "active"; } ?>">



											<img class="icon img-top" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/Store.png"?>">



											<img class="icon " src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/Store.png"?>">



											<span><?php esc_html_e('Store', 'gym_mgt' ); ?></span>



											<i class="fa <?php echo $rtl_left_icon_class; ?> dropdown-right-icon icon" aria-hidden="true"></i>



											<i class="fa fa-chevron-down icon dropdown-down-icon" aria-hidden="true"></i>



										</a>



										<ul class='submenu dropdown-menu'>



											<?php



											if($user_product_view == 1)



											{



												?>



												<li class=''>



													<a href='<?php echo admin_url().'admin.php?page=gmgt_product';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "gmgt_product") { echo "active"; } ?>">



													<span><?php esc_html_e( 'Product', 'gym_mgt' ); ?></span>



													</a>



												</li>



												<?php



											}



											if($user_store_view == 1)



											{



												?>



												<li class=''>



													<a href='<?php echo admin_url().'admin.php?page=gmgt_store';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "gmgt_store") { echo "active"; } ?>">



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



								if($user_tax_view == 1 || $user_membership_payment_view == 1 || $user_payment_view == 1)



								{



									?>



									<li class="has-submenu nav-item card-icon">



										<a href='#' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "MJ_gmgt_gmgt_taxes" || $_REQUEST ['page'] && $_REQUEST ['page'] == "MJ_gmgt_fees_payment" || $_REQUEST ['page'] && $_REQUEST ['page'] == "gmgt_payment") { echo "active"; } ?>">



											<img class="icon img-top" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/Payment.png"?>">



											<img class="icon " src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/Payment.png"?>">



											<span><?php esc_html_e( 'Payment', 'gym_mgt' ); ?></span>



											<i class="fa <?php echo $rtl_left_icon_class; ?> dropdown-right-icon icon" aria-hidden="true"></i>



											<i class="fa fa-chevron-down icon dropdown-down-icon" aria-hidden="true"></i>



										</a>



										<ul class='submenu dropdown-menu'>



											<?php



											if($user_tax_view == 1)



											{



												?>



												<li class=''>



													<a href='<?php echo admin_url().'admin.php?page=MJ_gmgt_gmgt_taxes';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "MJ_gmgt_gmgt_taxes") { echo "active"; } ?>">



													<span><?php esc_html_e( 'Tax', 'gym_mgt' ); ?></span>



													</a>



												</li>



												<?php



											}



											if($user_membership_payment_view == 1)



											{



												?>



												<li class=''>



													<a href='<?php echo admin_url().'admin.php?page=MJ_gmgt_fees_payment';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "MJ_gmgt_fees_payment") { echo "active"; } ?>">



													<span><?php esc_html_e( 'Membership Payment', 'gym_mgt' ); ?></span>



													</a>



												</li>



												<?php



											}



											if($user_payment_view == 1)



											{



												?>



												<li class=''>



													<a href='<?php echo admin_url().'admin.php?page=gmgt_payment&tab=incomelist';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "gmgt_payment") { echo "active"; } ?>">



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



								



								if($user_report_view == 1)



								{



									?>



									<li class="has-submenu nav-item card-icon general_setting_menu">



										<a href='#' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "gmgt_report") { echo "active"; } ?>">



											<img class="icon img-top" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/report.png"?>">



											<img class="icon " src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/report.png"?>">



											<span><?php esc_html_e( 'Reports', 'gym_mgt' ); ?></span>

											

											<i class="fa <?php echo $rtl_left_icon_class; ?> dropdown-right-icon icon" aria-hidden="true"></i>



											<i class="fa fa-chevron-down icon dropdown-down-icon" aria-hidden="true"></i>



										</a>



										<ul class='submenu dropdown-menu report_module'>

											<li class=''>



												<a href='<?php echo admin_url().'admin.php?page=gmgt_report&tab=member_information';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "gmgt_report") { echo "active"; } ?>">



												<span><?php esc_html_e( 'Member Information', 'gym_mgt' ); ?></span>



												</a>



											</li>

											<li class=''>



												<a href='<?php echo admin_url().'admin.php?page=gmgt_report&tab=membership_report&tab1=membership_report';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "gmgt_report") { echo "active"; } ?>">



												<span><?php esc_html_e( 'Membership', 'gym_mgt' ); ?></span>



												</a>



											</li>

											<li class=''>



												<a href='<?php echo admin_url().'admin.php?page=gmgt_report&tab=payment_report&tab1=report_graph';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "gmgt_report") { echo "active"; } ?>">



												<span><?php esc_html_e( 'Finance/Payment', 'gym_mgt' ); ?></span>



												</a>



											</li>

											<li class=''>



												<a href='<?php echo admin_url().'admin.php?page=gmgt_report&tab=attendance_report&tab1=report_graph';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "gmgt_report") { echo "active"; } ?>">



												<span><?php esc_html_e( 'Attendance', 'gym_mgt' ); ?></span>



												</a>



											</li>

											<li class=''>



												<a href='<?php echo admin_url().'admin.php?page=gmgt_report&tab=user_log';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "gmgt_report") { echo "active"; } ?>">



												<span><?php esc_html_e( 'User Log', 'gym_mgt' ); ?></span>



												</a>



											</li>

											<li class=''>



												<a href='<?php echo admin_url().'admin.php?page=gmgt_report&tab=audit_trail';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "gmgt_report") { echo "active"; } ?>">



												<span><?php esc_html_e( 'Audit Trail Report', 'gym_mgt' ); ?></span>



												</a>



											</li>

										</ul>

									</li>



									<?php



								}



								if($user_news_letter_view == 1 || $user_notice_view ==1 || $user_message_view == 1)



								{



									?>



									<li class="has-submenu nav-item card-icon">



										<a href='#' class=" <?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "gmgt_newsletter" || $_REQUEST ['page'] && $_REQUEST ['page'] == "gmgt_notice" || $_REQUEST ['page'] && $_REQUEST ['page'] == "Gmgt_message" ) { echo "active"; } ?>">



											<img class="icon img-top" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/Notification.png"?>">



											<img class="icon " src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/Notification.png"?>">



											<span><?php esc_html_e('Notifications', 'gym_mgt' ); ?></span>



											<i class="fa <?php echo $rtl_left_icon_class; ?> dropdown-right-icon icon" aria-hidden="true"></i>



											<i class="fa fa-chevron-down icon dropdown-down-icon" aria-hidden="true"></i>



										</a>



										<ul class='submenu dropdown-menu'>



											<?php



											if($user_news_letter_view == 1)



											{



												?>



												<li class=''>



													<a href='<?php echo admin_url().'admin.php?page=gmgt_newsletter';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "gmgt_newsletter") { echo "active"; } ?>">



													<span><?php esc_html_e( 'Newsletter', 'gym_mgt' ); ?></span>



													</a>



												</li>



												<?php



											}



											if($user_notice_view == 1)



											{



												?>



												<li class=''>



													<a href='<?php echo admin_url().'admin.php?page=gmgt_notice';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "gmgt_notice") { echo "active"; } ?>">



													<span><?php esc_html_e( 'Notice', 'gym_mgt' ); ?></span>



													</a>



												</li>



												<?php



											}



											if($user_message_view == 1)



											{



												?>



												<li class=''>



													<a href='<?php echo admin_url().'admin.php?page=Gmgt_message';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "Gmgt_message") { echo "active"; } ?>">



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



								if($user_sms_setting_view == 1 || $user_mail_template_view == 1 || $user_access_right_view == 1 || $user_general_setting_view == 1)



								{



									?>



									<li class="has-submenu nav-item card-icon <?php if($user_sms_setting_view == 1 && $user_mail_template_view == 1 && $user_access_right_view == 1 && $user_general_setting_view == 1){ ?> general_setting_menu <?php } ?>">



										<a href='#' class=" <?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "gmgt_sms_setting" || $_REQUEST ['page'] && $_REQUEST ['page'] == "gmgt_access_right" || $_REQUEST ['page'] && $_REQUEST ['page'] == "gmgt_mail_template" || $_REQUEST ['page'] && $_REQUEST ['page'] == "gmgt_gnrl_settings" ) { echo "active"; } ?>">



											<img class="icon img-top" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/Settings.png"?>">



											<img class="icon " src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/Settings.png"?>">



											<span><?php esc_html_e('System Settings', 'gym_mgt' ); ?></span>



											<i class="fa <?php echo $rtl_left_icon_class; ?> dropdown-right-icon icon" aria-hidden="true"></i>



											<i class="fa fa-chevron-down icon dropdown-down-icon" aria-hidden="true"></i>



										</a>



										<ul class='submenu dropdown-menu'>



											<?php



											if($user_sms_setting_view == 1)



											{



												?>



												<li class=''>



													<a href='<?php echo admin_url().'admin.php?page=gmgt_sms_setting';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "gmgt_sms_setting") { echo "active"; } ?>">



													<span><?php esc_html_e( 'SMS Setting', 'gym_mgt' ); ?></span>



													</a>



												</li>



												<?php



											}



											if($user_access_right_view == 1)



											{



												?>



												<li class=''>



													<a href='<?php echo admin_url().'admin.php?page=gmgt_access_right';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "gmgt_access_right") { echo "active"; } ?>">



													<span><?php esc_html_e( 'Access Rights', 'gym_mgt' ); ?></span>



													</a>



												</li>



												<?php



											}



											if($user_mail_template_view == 1)



											{



												?>



												<li class=''>



													<a href='<?php echo admin_url().'admin.php?page=gmgt_mail_template';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "gmgt_mail_template") { echo "active"; } ?>">



													<span><?php esc_html_e( 'Email Template', 'gym_mgt' ); ?></span>



													</a>



												</li>



												<?php



											}



											if($user_general_setting_view == 1)



											{



												?>



												<li class=''>



													<a href='<?php echo admin_url().'admin.php?page=gmgt_gnrl_settings';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "gmgt_gnrl_settings") { echo "active"; } ?>">



													<span><?php esc_html_e( 'General Settings', 'gym_mgt' ); ?></span>



													</a>



												</li>



												<?php



											}



											?>



										</ul> 



									</li>



									<?php



								}



								?>



							</ul>



						</nav>	



					</div>



					<!-- End menu sidebar main div  -->



				</div>



				<!-- dashboard content div start  -->



				<div class="col col-sm-12 col-md-12 col-lg-10 col-xl-10 gms_main_inner_bg dashboard_margin padding_left_0 padding_right_0">		



					<div class="page-inner min_height_1088 admin_homepage_padding_top">



						<!-- main-wrapper div START-->  



						<div id="main-wrapper" class="main-wrapper-div label_margin_top_15px admin_dashboard">



							<div class= "admin_page_main_div">



								<?php

							

								$page_name = $_REQUEST ['page'];



								if($_REQUEST ['page'] == 'gmgt_membership_type')



								{



									require_once GMS_PLUGIN_DIR. '/admin/membership/index.php';



								}

								elseif($_REQUEST ['page'] == 'gmgt_coupon')



								{



									require_once GMS_PLUGIN_DIR. '/admin/coupon/index.php';



								}

								elseif($_REQUEST ['page'] == 'gmgt_group'){



									require_once GMS_PLUGIN_DIR. '/admin/group/index.php';



								}



								elseif($_REQUEST ['page'] == 'gmgt_staff'){



									require_once GMS_PLUGIN_DIR. '/admin/staff-members/index.php';



								}



								elseif($_REQUEST ['page'] == 'gmgt_virtual_class'){



									require_once GMS_PLUGIN_DIR. '/admin/virtual_class/index.php';



								}



								elseif($_REQUEST ['page'] == 'gmgt_class'){



									require_once GMS_PLUGIN_DIR. '/admin/class-schedule/index.php';



								}



								elseif($_REQUEST ['page'] == 'gmgt_member'){



									require_once GMS_PLUGIN_DIR. '/admin/member/index.php';



								}



								elseif($_REQUEST ['page'] == 'gmgt_activity'){



									require_once GMS_PLUGIN_DIR. '/admin/activity/index.php';



								}



								elseif($_REQUEST ['page'] == 'gmgt_workouttype'){



									require_once GMS_PLUGIN_DIR. '/admin/workout-type/index.php';



								}



								elseif($_REQUEST ['page'] == 'gmgt_nutrition'){



									require_once GMS_PLUGIN_DIR. '/admin/nutrition/index.php';



								}



								elseif($_REQUEST ['page'] == 'gmgt_workout'){



									require_once GMS_PLUGIN_DIR. '/admin/workout/index.php';



								}



								elseif($_REQUEST ['page'] == 'gmgt_product'){



									require_once GMS_PLUGIN_DIR. '/admin/product/index.php';



								}



								elseif($_REQUEST ['page'] == 'gmgt_store'){



									require_once GMS_PLUGIN_DIR. '/admin/store/index.php';



								}



								elseif($_REQUEST ['page'] == 'gmgt_reservation'){



									require_once GMS_PLUGIN_DIR. '/admin/reservation/index.php';



								}



								elseif($_REQUEST ['page'] == 'gmgt_attendence'){



									require_once GMS_PLUGIN_DIR. '/admin/attendence/index.php';



								}



								elseif($_REQUEST ['page'] == 'gmgt_accountant'){



									require_once GMS_PLUGIN_DIR. '/admin/accountant/index.php';



								}



								elseif($_REQUEST ['page'] == 'MJ_gmgt_gmgt_taxes'){



									require_once GMS_PLUGIN_DIR. '/admin/tax/index.php';



								}



								elseif($_REQUEST ['page'] == 'MJ_gmgt_fees_payment'){



									require_once GMS_PLUGIN_DIR. '/admin/membership_payment/index.php';



								}



								elseif($_REQUEST ['page'] == 'gmgt_payment'){



									require_once GMS_PLUGIN_DIR. '/admin/payment/index.php';



								}



								elseif($_REQUEST ['page'] == 'Gmgt_message'){



									require_once GMS_PLUGIN_DIR. '/admin/message/index.php';



								}



								elseif($_REQUEST ['page'] == 'gmgt_newsletter'){



									require_once GMS_PLUGIN_DIR. '/admin/news-letter/index.php';



								}



								elseif($_REQUEST ['page'] == 'gmgt_notice'){



									require_once GMS_PLUGIN_DIR. '/admin/notice/index.php';



								}



								elseif($_REQUEST ['page'] == 'gmgt_report'){



									require_once GMS_PLUGIN_DIR. '/admin/report/index.php';



								}



								elseif($_REQUEST ['page'] == 'gmgt_sms_setting'){



									require_once GMS_PLUGIN_DIR. '/admin/sms_setting/index.php';



								}



								elseif($_REQUEST ['page'] == 'gmgt_mail_template'){



									require_once GMS_PLUGIN_DIR. '/admin/email-template/index.php';



								}



								elseif($_REQUEST ['page'] == 'gmgt_gnrl_settings'){



									require_once GMS_PLUGIN_DIR. '/admin/general-settings.php';



								}



								elseif($_REQUEST ['page'] == 'gmgt_access_right'){



									require_once GMS_PLUGIN_DIR. '/admin/access_right/index.php';



								}



								elseif($_REQUEST ['page'] == 'gmgt_setup'){



									require_once GMS_PLUGIN_DIR. '/admin/setupform/index.php';



								}

							

								?>



							</div>



							<?php



							if(isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == 'gmgt_system')



							{

							$wizard_option = get_option('gmgt_setup_wizard_step');

							$wizard_status = get_option('gmgt_setup_wizard_status');

								?>

								<div class = "setup_wizard_dashboard">

								<div class="accordion_wizzard">

									<h4 class="accordion-header wizard_heading" id="flush-heading">

										<button class="accordion-button wizzard_button  collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse_collapse" aria-controls="flush-heading">

											<?php esc_attr_e('Setup Wizard', 'gym_mgt'); ?>

										</button>

									</h4>



									<div id="flush-collapse_collapse" class="accordion-collapse collapse <?php if($wizard_status == 'no'){ echo "show";}?>" aria-labelledby="flush-heading" role="tabpanel" data-bs-parent="#accordionExample">

										<div class="m-auto panel_wizard">

											<div class="wizard_main">

												<div class="steps clearfix">

													

													<ul role="tablist">

														<li role="tab" class="first wizard_responsive disabled <?php if($wizard_option['step1_system_setting'] =='yes'){ echo 'done';} ?>" aria-disabled="false" aria-selected="true">

															<a id="form-total-t-0" href="admin.php?page=gmgt_gnrl_settings" aria-controls="form-total-p-0">

																<span class="current-info audible"> </span>

																<div class="title wizard-title">

																	<span class="step-icon">

																		<img class="center wizard_setting" src="<?php echo GMS_PLUGIN_URL."/assets/images/wizard/wizard_setting.png"?>">

																		<?php

																		if($wizard_option['step1_system_setting'] =='yes'){ ?>

																			<img class="status_image" src="<?php echo GMS_PLUGIN_URL."/assets/images/wizard/wizard_vector.png"?>">

																		<?php }

																			else{

																			?>

																			<img class="status_image" src="<?php echo GMS_PLUGIN_URL."/assets/images/wizard/wizard_hour_glass.png"?>">

																		<?php } ?>

																	</span>

																	<span class="step-number"><?php esc_html_e( 'System Settings', 'gym_mgt' ); ?></span>

																</div>

															</a>

														</li>

														<li role="tab" class="disabled wizard_responsive external_padding <?php if($wizard_option['step2_membership'] =='yes'){ echo 'done';} ?>" aria-disabled="true">

															<a id="form-total-t-1" href="admin.php?page=gmgt_membership_type&tab=addmembership" aria-controls="form-total-p-1">

																<div class="title wizard-title">

																	<span class="step-icon">

																		<img class="center wizard_setting" src="<?php echo GMS_PLUGIN_URL."/assets/images/wizard/wizard_membership.png"?>">

																		<?php

																		if($wizard_option['step2_membership'] =='yes'){ ?>

																			<img class="status_image" src="<?php echo GMS_PLUGIN_URL."/assets/images/wizard/wizard_vector.png"?>">

																		<?php }

																			else{

																			?>

																			<img class="status_image" src="<?php echo GMS_PLUGIN_URL."/assets/images/wizard/wizard_hour_glass.png"?>">

																		<?php } ?>

																	</span>

																	<span class="step-number"><?php echo esc_html_e( 'Membership', 'gym_mgt' );?></span>

																</div>

															</a>

														</li>

														<li role="tab" class="disabled wizard_responsive external_padding wizard-title <?php if($wizard_option['step3_staff'] =='yes'){ echo 'done';} ?>" aria-disabled="true">

															<a id="form-total-t-2" href="admin.php?page=gmgt_staff&tab=add_staffmember" aria-controls="form-total-p-2">

																<div class="title">

																	<span class="step-icon">

																		<img class="center wizard_setting" src="<?php echo GMS_PLUGIN_URL."/assets/images/wizard/wizard_staff.png"?>">

																		<?php

																		if($wizard_option['step3_staff'] =='yes'){ ?>

																			<img class="status_image" src="<?php echo GMS_PLUGIN_URL."/assets/images/wizard/wizard_vector.png"?>">

																		<?php }

																			else{

																			?>

																			<img class="status_image" src="<?php echo GMS_PLUGIN_URL."/assets/images/wizard/wizard_hour_glass.png"?>">

																		<?php } ?>

																	</span>

																	<span class="step-number"><?php echo esc_html_e( 'Staff Member', 'gym_mgt' ); ?></span>

																</div>

															</a>

														</li>

														<li role="tab" class="disabled wizard_responsive wizard-title <?php if($wizard_option['step4_activity'] =='yes'){ echo 'done';} ?>" aria-disabled="true">

															<a id="form-total-t-2" href="admin.php?page=gmgt_activity&tab=addactivity" aria-controls="form-total-p-2">

																<div class="title">

																	<span class="step-icon">

																		<img class="center wizard_setting" src="<?php echo GMS_PLUGIN_URL."/assets/images/wizard/wizard_activity.png"?>">

																		<?php

																		if($wizard_option['step4_activity'] =='yes'){ ?>

																			<img class="status_image" src="<?php echo GMS_PLUGIN_URL."/assets/images/wizard/wizard_vector.png"?>">

																		<?php }

																			else{

																			?>

																			<img class="status_image" src="<?php echo GMS_PLUGIN_URL."/assets/images/wizard/wizard_hour_glass.png"?>">

																		<?php } ?>

																	</span>

																	<span class="step-number"><?php echo esc_html_e( 'Activity', 'gym_mgt' ); ?></span>

																</div>

															</a>

														</li>

														<li role="tab" class="disabled wizard_responsive wizard-title last <?php if($wizard_option['step5_class'] =='yes'){ echo 'done';} ?>" aria-disabled="true">

															<a id="form-total-t-2" href="admin.php?page=gmgt_class&tab=addclass" aria-controls="form-total-p-2">

																<div class="title">

																	<span class="step-icon">

																		<img class="center wizard_setting" src="<?php echo GMS_PLUGIN_URL."/assets/images/wizard/wizard_class.png"?>">

																		<?php

																		if($wizard_option['step5_class'] =='yes'){ ?>

																			<img class="status_image" src="<?php echo GMS_PLUGIN_URL."/assets/images/wizard/wizard_vector.png"?>">

																		<?php }

																			else{

																			?>

																			<img class="status_image" src="<?php echo GMS_PLUGIN_URL."/assets/images/wizard/wizard_hour_glass.png"?>">

																		<?php } ?>

																	</span>

																	<span class="step-number"><?php echo esc_attr__('Class Schedule', 'gym_mgt'); ?></span>

																</div>

															</a>

														</li>

														<li role="tab" class="disabled wizard_responsive wizard-title last last_child <?php if($wizard_option['step6_member'] =='yes'){ echo 'done';} ?>" aria-disabled="true">

															<a id="form-total-t-2" href="admin.php?page=gmgt_member&tab=addmember" aria-controls="form-total-p-2">

																<div class="title">

																	<span class="step-icon">

																		<img class="center wizard_setting" src="<?php echo GMS_PLUGIN_URL."/assets/images/wizard/wizard_member.png"?>">

																		<?php

																		if($wizard_option['step6_member'] =='yes'){ ?>

																			<img class="status_image" src="<?php echo GMS_PLUGIN_URL."/assets/images/wizard/wizard_vector.png"?>">

																		<?php }

																			else{

																			?>

																			<img class="status_image" src="<?php echo GMS_PLUGIN_URL."/assets/images/wizard/wizard_hour_glass.png"?>">

																		<?php } ?>

																	</span>

																	<span class="step-number"><?php echo esc_html_e( 'Member', 'gym_mgt' ); ?></span>

																</div>

															</a>

														</li>

													</ul>

												</div>

											</div>

										</div>

									</div>

								</div>

								</div>

								<!-- Four Card , Chart and Invioce Payment Row Div Start  -->



								<div class="row menu_row dashboard_content_rs first_row_padding_top"><!-- Row Div Start  -->



									<div class="col-lg-4 col-md-4 col-xl-4 col-sm-4 four_card_div">



										<div class="row">



											<!-- Accountant card start -->



											<div class="col-lg-6 col-md-6 col-xl-6 col-sm-6 gmgt-card">



												<div class="gmgt-card-member-bg center" id="card-supportstaff-bg">



													<!-- <a href='<?php echo admin_url().'admin.php?page=gmgt_staff';?>'> -->



													<a href='<?php echo admin_url().'admin.php?page=gmgt_accountant';?>'>



														<img class="center" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/account_dashboard.png"?>">



													</a>



												</div>



												<div class="gmgt-card-number">



													<!--  -->



													<h3><?php echo count(get_users(array('role'=>'accountant')));?></h3>



												</div>



												<div class="gmgt-card-title">



													<!--  -->



													<span><?php esc_html_e('Accountant','gym_mgt');?></span>



												</div>



											</div>



											<!--  Accountant card end -->



											<!-- Staff Members card start -->



											<div class="col-lg-6 col-md-6 col-xl-6 col-sm-6 gmgt-card hmgt_card_2">



												<div class="gmgt-card-member-bg center" id="card-member-bg">



													<a href='<?php echo admin_url().'admin.php?page=gmgt_staff';?>'>



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



											<!-- Notice card start -->



											<div class="col-lg-6 col-md-6 col-xl-6 col-sm-6 gmgt-card">



												<div class="gmgt-card-member-bg center" id="card-notice-bg">



													<a href='<?php echo admin_url().'admin.php?page=gmgt_notice';?>'>



														<img class="center" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Notice_dashboard.png"?>">



													</a>



												</div>



												<div class="gmgt-card-number">



													<?php



													global $wpdb;



													$table_post = $wpdb->prefix . 'posts';



													$total_notice = $wpdb->get_row("SELECT COUNT(*) as total_notice FROM $table_post where post_type='gmgt_notice' ");



													?>



													<h3><?php echo $total_notice->total_notice; ?></h3>



												</div>



												<div class="gmgt-card-title prescription_name_div">



													<span><?php esc_html_e('Notices','gym_mgt');?></span>



												</div>



											</div>



											<!-- Notice card end -->



											<!-- Message card start -->



											<div class="col-lg-6 col-md-6 col-xl-6 col-sm-6 gmgt-card hmgt_card_2">



												<div class="gmgt-card-member-bg center" id="card-message-bg">



													<a href='<?php echo admin_url().'admin.php?page=Gmgt_message';?>'>



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



										</div>



									</div>







									<!-- Member active && Expired chat start -->



									<div class="col-lg-4 col-md-4 col-xs-12 col-sm-12 responsive_div_dasboard">



										<div class="panel panel-white gmgt-line-chat">



											<div class="panel-heading" id="gmgt-line-chat-p">



												<h3 class="panel-title"><?php esc_html_e('Member Status','gym_mgt');?></h3>



												<a href="<?php echo admin_url().'admin.php?page=gmgt_member'; ?>"><img class="vertical_align_unset" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Redirect.png"?>"></a>



											</div>



											<script src="https://github.com/chartjs/Chart.js/releases/download/v2.9.3/Chart.min.js"></script>



											<link rel="stylesheet" href="https://github.com/chartjs/Chart.js/releases/download/v2.9.3/Chart.min.css">



											<div class="gmgt-member-chart">



												<div class="outer">



													<canvas id="chartJSContainer" width="300" height="250"></canvas>



													



													<p class="percent">



														<?php

														$active_member= MJ_gmgt_get_user_total_active_member();



														$expired_member= MJ_gmgt_get_user_total_expired_member();



															$total_member=count(get_users(array('role'=>'member')));



															$total_member= str_pad($total_member, 2, '0', STR_PAD_LEFT); 



														 	echo $active_member+$expired_member;



														?> 



													</p>



													<p class="percent1">



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



												<div class="col-sm-5 col-md-5 col-lg-5 col-xl-5 col-xs-5 responsive_div_dasboard chart_div_1 gmgt_chart_div_2 inpatient_div">



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







									<!-- Invoice List card start -->



									<div class="col-lg-4 col-md-4 col-xs-12 col-sm-12 responsive_div_dasboard precription_padding_left1">



										<div class="panel panel-white admmision_div">



											<div class="panel-heading" id="gmgt-line-chat-p">



												<h3 class="panel-title"><?php esc_html_e('Invoice List','gym_mgt');?></h3>						



												<a class="page_link1" href="<?php echo admin_url().'admin.php?&page=gmgt_payment';?>">



													<img class="vertical_align_unset" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Redirect.png"?>">



												</a>



											</div>



											<div class="panel-body">



												<div class="events1">



													<?php



													$i= 0;



										



													$obj_payment=new MJ_gmgt_payment;



													$paymentdata=$obj_payment->MJ_gmgt_get_new_all_income_data_dashboard();







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



															<div class="fees_payment_height calendar-event show_task_event fees_payment_height calendar-event show_task_event cursor_pointer" id="<?php echo esc_attr($retrieved_data->invoice_id);?>" model="Invoice Details"> 



																<p class="cursor_pointer fees_payment_padding_top_0 remainder_title Bold viewbedlist  date_font_size" > 	  



																	<label for="" class="cursor_pointer date_assignbed_label">



																		<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?><?php echo esc_html($retrieved_data->total_amount); ?>



																		<?php //echo number_format(esc_html($retrieved_data->total_amount),2); ?>



																	</label>



																	<span class=" <?php echo $color_class; ?>"></span>



																</p>



																<p class="cursor_pointer remainder_date assignbed_name assign_bed_name_size">



																	<?php 	



																		$user=get_userdata($retrieved_data->supplier_name);



																		$memberid=get_user_meta($retrieved_data->supplier_name,'member_id',true);



																		// $display_label=$user->display_name;



																		$display_label = MJ_gmgt_get_member_full_display_name_with_memberid(esc_html($user->ID));

 



																		if($display_label)



																		// $display_label.=" (".$memberid.")";



																		echo esc_html($display_label);



																	?>



																</p>



																<p class="cursor_pointer remainder_date assign_bed_date assign_bed_name_size">



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



																<div class="col-md-12 dashboard_btn padding_top_30px">



																	<a href="<?php echo admin_url().'admin.php?page=gmgt_payment&tab=addincome'; ?>" class="btn save_btn event_for_alert line_height_31px"><?php esc_html_e('ADD Invoice','gym_mgt');?></a>



																</div>	



															</div>	



														<?php



													}		



													?>	



												</div>                       



											</div>



										</div>



									</div>



									<!-- Invoice List card End -->



								</div><!-- Row Div Start  -->



								<!-- Four Card , Chart and Invioce Payment Row Div End -->







								<!-- Today Report && Membership Report and Celender Row Start -->



								<div class="row calander-chart-div">



									<div class="col-md-6 col-lg-6 col-sm-12 com-xs-12">



										<div class="gmgt-attendance">



											<div class="gmgt-attendance-list panel">



												<div class="panel-heading">



													<h3 id="res_today_font_12px" class="panel-title"><?php esc_html_e('Today Member Attendance Report','gym_mgt');?></h3>



													<a href="<?php echo admin_url().'admin.php?page=gmgt_attendence&tab=attendence'; ?>" class="page_link1"><img class="" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Redirect.png"?>"></a>



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



													<!-- <div class="clear col-md-12 error_msg"><?php esc_html_e("No data available.",'gym_mgt');?></div> -->



													<div class="calendar-event-new no_data_img_center"> 



														<img class="no_data_img" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/no_data_img.png"?>" >



													</div>		



													<?php 



												}?>



											</div>







											



											<div class="gmgt-feesreport-list panel">



												<div class="panel-heading">



													<h3 class="panel-title"><?php esc_html_e('Membership Report','gym_mgt');?></h3>



													<a href="<?php echo admin_url().'admin.php?page=gmgt_membership_type'; ?>" class="page_link1"><img class="" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Redirect.png"?>"></a>



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







									<div class="col-md-6 col-lg-6 col-sm-12 com-xs-12">



										<div class="amgt-calendar panel">



											<div class="row panel-heading activities">



												<div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 width_30px_res">



													<h3 class="panel-title calander_heading_title_width"><?php esc_html_e('Calendar','gym_mgt');?></h3>



												</div>



												<div class="gmgt-cal-py col-sm-12 col-md-8 col-lg-8 col-xl-8 celender_dot_div width_70px_res">



													<div class="gmgt-card-head">



														<ul class="gmgt-cards-indicators gmgt-right padding_0">



															<li><span class="gmgt-indic gmgt-blue-indic"></span> <?php esc_html_e( 'Notice', 'gym_mgt' ); ?></li>



															<li><span class="gmgt-indic gmgt-green-indic"></span> <?php esc_html_e( 'Reservation', 'gym_mgt' );?></li>



														</ul>



													</div>   



												</div>



											</div>



											<div class="gmgt-cal-py gmgt-calender-margin-top">



												<div id="calendar"></div>



											</div>



										</div>



									</div>



								</div>



								<!-- Today Report && Membership Report and Celender Row End -->





								<!----------------------- Income Expense Card  ----------------------->

								<div class="row">

									<div  class="col-md-6 col-lg-6 col-sm-12 com-xs-12 responsive_div_dasboard precription_padding_left1">

										<div class="panel panel-white card_list_height operation">

											<div class="row">

												<div class="col-md-9 mb-9 input">

													<div class="panel-heading ">

														<h3 class="panel-title"><span class="income_month_value"><?php esc_html_e(date("F"),'gym_mgt');?></span><?php esc_html_e(' Income-Expense Report','gym_mgt');?></h3>						

													</div>

												</div>

												<div class="col-md-3 mb-3 col-6 input margin_top_20px margin_left_20px margin_rtl_30px">

													<label class="ml-1 custom-top-label month_label top" for="hmgt_contry"><?php esc_html_e('Month','gym_mgt');?><span class="require-field">*</span></label>

													<select id="month" name="month" class="line_height_30px form-control class_id_exam validate[required] dash_month_select">

														<!-- <option ><?php esc_attr_e('Selecte Month','gym_mgt');?></option> -->

														<?php

														$month =array('1'=>esc_html__('January','apartment_mgt'),'2'=>esc_html__('February','apartment_mgt'),'3'=>esc_html__('March','apartment_mgt'),'4'=>esc_html__('April','apartment_mgt'),'5'=>esc_html__('May','apartment_mgt'),'6'=>esc_html__('June','apartment_mgt'),'7'=>esc_html__('July','apartment_mgt'),'8'=>esc_html__('August','apartment_mgt'),'9'=>esc_html__('September','apartment_mgt'),'10'=>esc_html__('October','apartment_mgt'),'11'=>esc_html__('November','apartment_mgt'),'12'=>esc_html__('December','apartment_mgt'),);

														foreach($month as $key=>$value)

														{

															$selected = (date('m') == $key ? ' selected' : '');

															echo '<option value="'.$key.'"'.$selected.'>'.  esc_html__($value,'gym_mgt').'</option>'."\n";

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

								</div>

								<!----------------------- Income Expense Card  ----------------------->





								<!-- Fee Payment Report and Membership List && Activity Row Start -->



								<div class="row">



									<div class="col-md-6 col-lg-6 col-sm-12 com-xs-12 responsive_div_dasboard precription_padding_left">



										<div class="panel panel-white fees_card_height priscription">



											<div class="panel-heading ">					



												<h3 class="panel-title"><?php esc_html_e('Fee Payment Report','gym_mgt');?></h3>						



												<a class="page-link123" href="<?php echo admin_url().'admin.php?page=MJ_gmgt_fees_payment'; ?>"><img class="vertical_align_unset" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Redirect.png"?>"></a>



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







									<div  class="col-md-6 col-lg-6 col-sm-12 com-xs-12 responsive_div_dasboard precription_padding_left1">



										<div class="panel panel-white member_list_height operation">



											<div class="panel-heading ">



												<h3 class="panel-title"><?php esc_html_e('Membership','gym_mgt');?></h3>						



												<a class="page-link123" href="<?php echo admin_url().'admin.php?page=gmgt_membership_type';?>"><img class="vertical_align_unset" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Redirect.png"?>"></a>



											</div>



											<div class="panel-body">



												<div class="events1">



													<?php



													$obj_membership=new MJ_gmgt_membership;



													$membershipdata=$obj_membership->MJ_gmgt_get_new_all_membership_dashboard();



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



																<div class="d-flex align-items-center col-sm-7 col-md-7 col-lg-7 col-xl-7 gmgt-group-list-record-col-img">



																	<div class="cursor_pointer class_font_color cmgt-group-list-group-name remainder_title_pr gms_member_color Bold viewdetail gmgt_word_wrap" >



																		<span><?php echo esc_html($retrieved_data->membership_label); ?></span><span><?php esc_html_e('(','gym_mgt');?><?php echo esc_html($retrieved_data->membership_length_id); ?> <?php esc_html_e('- Days)','gym_mgt');?></span>



																	</div>



																</div>



																<div class="col-sm-3 col-md-3 col-lg-3 col-xl-3 justify-content-end d-flex align-items-center gmgt-group-list-record-col-count">



																	<div class="cursor_pointer gmgt-group-list-total-group">



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



															<div class="col-md-12 dashboard_btn">



																<a href="<?php echo admin_url().'admin.php?page=gmgt_membership_type&tab=addmembership'; ?>" class="btn save_btn event_for_alert line_height_31px"><?php esc_html_e('ADD Activity','gym_mgt');?></a>



															</div>	



														</div>		



														



														<?php



													}	



													?>		



												</div>                       



											</div>



										</div>







										<div class="panel panel-white member_list_height operation">



											<div class="panel-heading ">



												<h3 class="panel-title"><?php esc_html_e('Activity','gym_mgt');?></h3>						



												<a class="page-link123" href="<?php echo admin_url().'admin.php?&page=gmgt_activity';?>"><img class="vertical_align_unset" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Redirect.png"?>"></a>



											</div>



											<div class="panel-body">



												<div class="events notice_content_div">



													<?php         



													$obj_activity=new MJ_gmgt_activity;



													$activitydata=$obj_activity->MJgmet_new_all_activity_dashboard();



													if(!empty($activitydata))



													{ 



														foreach ($activitydata as $retrieved_data)



														{ 



															// var_dump($retrieved_data);die;



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



															<div class="col-md-12 dashboard_btn">



																<a href="<?php echo admin_url().'admin.php?page=gmgt_activity&tab=addactivity'; ?>" class="btn save_btn event_for_alert line_height_31px"><?php esc_html_e('ADD Activity','gym_mgt');?></a>



															</div>	



														</div>		



													<?php



													}	



													?>					



												</div>



											</div>



										</div>







									</div>







								</div>



								<!-- Fee Payment Report and Membership List Row End -->







								<!-- Notice List and Massage List Row Div Start  -->



								<div class="row">



									<div class="col-md-6 col-lg-6 col-sm-12 com-xs-12 responsive_div_dasboard precription_padding_left">



										<div class="panel panel-white event">



											<div class="panel-heading ">



												<h3 class="panel-title"><?php esc_html_e('Notice','gym_mgt');?></h3>						



												<a class="page-link123" href="<?php echo admin_url().'admin.php?&page=gmgt_notice';?>"><img class="vertical_align_unset" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Redirect.png"?>"></a>



											</div>					



											<div class="panel-body">



												<div class="events">	



													<?php         



													$args['post_type'] = 'gmgt_notice';



													$args['posts_per_page'] = 5;



													$args['post_status'] = 'public';



													$q = new WP_Query();



													$noticedata = $q->query( $args );



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



																			<label for="" class="cursor_pointer notice_heading_label notice_heading">



																				<?php echo esc_html($retrieved_data->post_title);?>	



																			</label>



																			



																			<a href="#" class="notice_date_div">



																				<?php echo MJ_gmgt_getdate_in_input_box(get_post_meta($retrieved_data->ID,'gmgt_start_date',true));?> &nbsp;|&nbsp; <?php echo MJ_gmgt_getdate_in_input_box(get_post_meta($retrieved_data->ID,'gmgt_start_date',true));?>



																			</a>



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



															<div class="col-md-12 dashboard_btn padding_top_60px">



																<a href="<?php echo admin_url().'admin.php?page=gmgt_notice&tab=addnotice'; ?>" class="btn save_btn event_for_alert line_height_31px"><?php esc_html_e('Add Notice','gym_mgt');?></a>



															</div>	



														</div>		



														<?php



													}	



													?>



												</div>                       



											</div>



										</div>



									</div>







									<div class="col-md-6 col-lg-6 col-sm-12 com-xs-12 responsive_div_dasboard precription_padding_left1">



										<div class="panel panel-white massage">



											<div class="panel-heading">



												<h3 class="panel-title"><?php esc_html_e('Message','gym_mgt');?></h3>						



												<a class="page-link123" href="<?php echo admin_url().'admin.php?page=Gmgt_message&tab=inbox'; ?>"><img class="vertical_align_unset" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Redirect.png"?>"></a>



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



																<p class="remainder_title_pr viewpriscription class_font_15px card_content_width class_width  assignbed_name1 card_margin_top"> 



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



															<div class="col-md-12 dashboard_btn padding_top_60px">



																<a href="<?php echo admin_url().'admin.php?page=Gmgt_message&tab=compose'; ?>" class="btn save_btn event_for_alert line_height_31px"><?php esc_html_e('ADD Message','gym_mgt');?></a>



															</div>	



														</div>		



													<?php



													}	



													?>					



												</div>



											</div>



										</div>



									</div>



								</div>



								<!-- Notice List and Massage List Row Div End  -->







								<!-- Schedule List Row Div Start  -->



								<div class="row">



									<div class="col-sm-12 col-md-12 col-lg-12 col-xs-12 responsive_div_dasboard ">



										<div class="panel panel-white">



											<div class="panel-heading ">



												<h3 class="panel-title"><?php esc_html_e('Schedule List','gym_mgt');?></h3>						



												<a class="page-link123" href="<?php echo admin_url().'admin.php?&page=gmgt_class&tab=schedulelist';?>"><img class="vertical_align_unset" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Redirect.png"?>"></a>



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



									<!-- Schedule List Row Div End  -->



								<?php



							} 



							?>



						</div>



					</div>



				</div>



				<!-- End dashboard content div -->



			</div>



			<!-- Footer Part Start  -->



			<footer class='gmgt-footer'>

				<p><?php echo get_option('gmgt_footer_description'); ?></p>

			</footer>



			<!-- Footer Part End  -->



		</body>



		<!-- body part End  -->



	</html>































<?php ?>