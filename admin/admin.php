<?php 



 // This is adminside main First page of Gym management management plug in 



add_action( 'admin_head', 'MJ_gmgt_admin_menu_icon' );



//ADMIN MENU ICON FUNCTION



function MJ_gmgt_admin_menu_icon()



{



?>



	<style type="text/css">



	</style>



<?php 



}



add_action( 'admin_menu', 'MJ_gmgt_system_menu' );



//ADMIN SIDE MENU FUNCTION



function MJ_gmgt_system_menu()



{



	if (function_exists('MJ_gmgt_setup'))  



	{



		 //User Role//



        $user = new WP_User(get_current_user_id());



        $user_role=$user->roles[0];



         //ENd //		



		if($user_role == 'administrator' )



		{



			add_menu_page(esc_html__('Gym Management','gym_mgt'),esc_html__('WPGYM','gym_mgt'),'manage_options','gmgt_system','MJ_gmgt_system_dashboard',plugins_url('gym-management/assets/images/gym-1.png' )); 



			if($_SESSION['gmgt_verify'] == '')



			{



				add_submenu_page('gmgt_system', esc_html__('License Settings','gym_mgt'), esc_html__( 'License Settings', 'gym_mgt' ),'manage_options','gmgt_setup','MJ_gmgt_system_dashboard');



			}



			add_submenu_page('gmgt_system', 'Dashboard', esc_html__( 'Dashboard', 'gym_mgt' ), 'administrator', 'gmgt_system', 'MJ_gmgt_system_dashboard');



			add_submenu_page('gmgt_system',esc_html__( 'Membership Type', 'gym_mgt' ) , esc_html__( 'Membership Type', 'gym_mgt' ), 'administrator', 'gmgt_membership_type', 'MJ_gmgt_system_dashboard');



			add_submenu_page('gmgt_system',esc_html__( 'Coupons', 'gym_mgt' ) , esc_html__( 'Coupons', 'gym_mgt' ), 'administrator', 'gmgt_coupon', 'MJ_gmgt_system_dashboard');



			add_submenu_page('gmgt_system', esc_html__( 'Groups', 'gym_mgt' ), esc_html__( 'Groups', 'gym_mgt' ), 'administrator', 'gmgt_group', 'MJ_gmgt_system_dashboard');



			add_submenu_page('gmgt_system', esc_html__( 'Staff Members', 'gym_mgt' ), esc_html__( 'Staff Members', 'gym_mgt' ), 'administrator', 'gmgt_staff', 'MJ_gmgt_system_dashboard');



			add_submenu_page('gmgt_system', esc_html__( 'Class Schedule', 'gym_mgt' ), esc_html__( 'Class Schedule', 'gym_mgt' ), 'administrator', 'gmgt_class', 'MJ_gmgt_system_dashboard');



			$gmgt_enable_virtual_classschedule=get_option("gmgt_enable_virtual_classschedule");



			if($gmgt_enable_virtual_classschedule == "yes")



			{



				add_submenu_page('gmgt_system', esc_html__('Virtual Class Schedule','gym_mgt'), esc_html__('Virtual Class Schedule','gym_mgt'), 'administrator', 'gmgt_virtual_class', 'MJ_gmgt_system_dashboard');



			}



			add_submenu_page('gmgt_system', esc_html__( 'Members', 'gym_mgt' ), esc_html__( 'Members', 'gym_mgt' ), 'administrator', 'gmgt_member', 'MJ_gmgt_system_dashboard');



			add_submenu_page('gmgt_system', esc_html__( 'Activity', 'gym_mgt' ), esc_html__( 'Activity', 'gym_mgt' ), 'administrator', 'gmgt_activity', 'MJ_gmgt_system_dashboard');



			add_submenu_page('gmgt_system', esc_html__( 'Assign Workout', 'gym_mgt' ), esc_html__( 'Assign Workout', 'gym_mgt' ), 'administrator', 'gmgt_workouttype', 'MJ_gmgt_system_dashboard');



			// add_submenu_page('gmgt_system', esc_html__( 'Nutrition Schedule', 'gym_mgt' ), esc_html__( 'Nutrition Schedule', 'gym_mgt' ), 'administrator', 'gmgt_nutrition', 'MJ_gmgt_system_dashboard');



			add_submenu_page('gmgt_system', esc_html__( 'Daily Workout', 'gym_mgt' ), esc_html__( 'Daily Workout', 'gym_mgt' ), 'administrator', 'gmgt_workout', 'MJ_gmgt_system_dashboard');



			add_submenu_page('gmgt_system', esc_html__( 'Products', 'gym_mgt' ), esc_html__( 'Products', 'gym_mgt' ), 'administrator', 'gmgt_product', 'MJ_gmgt_system_dashboard');



			add_submenu_page('gmgt_system', esc_html__( 'Store', 'gym_mgt' ), esc_html__( 'Store', 'gym_mgt' ), 'administrator', 'gmgt_store', 'MJ_gmgt_system_dashboard');



			add_submenu_page('gmgt_system', esc_html__( 'Reservation', 'gym_mgt' ), esc_html__( 'Reservation', 'gym_mgt' ), 'administrator', 'gmgt_reservation', 'MJ_gmgt_system_dashboard');



			add_submenu_page('gmgt_system', esc_html__( 'Attendance', 'gym_mgt' ), esc_html__( 'Attendance', 'gym_mgt' ), 'administrator', 'gmgt_attendence', 'MJ_gmgt_system_dashboard');



			add_submenu_page('gmgt_system', esc_html__( 'Accountant', 'gym_mgt' ), esc_html__( 'Accountant', 'gym_mgt' ), 'administrator', 'gmgt_accountant', 'MJ_gmgt_system_dashboard');



			add_submenu_page('gmgt_system', esc_html__( 'Tax', 'gym_mgt' ), esc_html__( 'Tax', 'gym_mgt' ), 'administrator', 'MJ_gmgt_gmgt_taxes', 'MJ_gmgt_system_dashboard');



			add_submenu_page('gmgt_system', esc_html__( 'Membership Payment', 'gym_mgt' ), esc_html__( 'Membership Payment', 'gym_mgt' ), 'administrator', 'MJ_gmgt_fees_payment', 'MJ_gmgt_system_dashboard');



		$gym_recurring_enable=get_option("gym_recurring_enable");



		if($gym_recurring_enable == "yes")



		{



			add_submenu_page('gmgt_system', esc_html__( 'Subscription', 'gym_mgt' ), esc_html__( 'Subscription', 'gym_mgt' ), 'administrator', 'MJ_gmgt_subscription', 'MJ_gmgt_system_dashboard');



		}



			add_submenu_page('gmgt_system', esc_html__( 'Payment', 'gym_mgt' ), esc_html__( 'Payment', 'gym_mgt' ), 'administrator', 'gmgt_payment', 'MJ_gmgt_system_dashboard');



			add_submenu_page('gmgt_system', esc_html__( 'Message', 'gym_mgt' ), esc_html__( 'Message', 'gym_mgt' ), 'administrator', 'Gmgt_message', 'MJ_gmgt_system_dashboard');



			add_submenu_page('gmgt_system', esc_html__( 'Newsletter', 'gym_mgt' ), esc_html__( 'Newsletter', 'gym_mgt' ), 'administrator', 'gmgt_newsletter', 'MJ_gmgt_system_dashboard');



			add_submenu_page('gmgt_system',  esc_html__( 'Notice', 'gym_mgt' ), esc_html__( 'Notice', 'gym_mgt' ), 'administrator', 'gmgt_notice', 'MJ_gmgt_system_dashboard');



			add_submenu_page('gmgt_system', esc_html__( 'Report', 'gym_mgt' ), esc_html__( 'Report', 'gym_mgt' ), 'administrator', 'gmgt_report', 'MJ_gmgt_system_dashboard');



			add_submenu_page('gmgt_system',esc_html__( 'SMS Setting', 'gym_mgt' ), esc_html__( 'SMS Setting', 'gym_mgt' ), 'administrator', 'gmgt_sms_setting', 'MJ_gmgt_system_dashboard');



			add_submenu_page('gmgt_system', esc_html__( 'Email Template', 'gym_mgt' ), esc_html__( 'Email Template', 'gym_mgt' ), 'administrator', 'gmgt_mail_template', 'MJ_gmgt_system_dashboard');



			add_submenu_page('gmgt_system', esc_html__( 'General Settings', 'gym_mgt' ), esc_html__( 'General Settings', 'gym_mgt' ), 'administrator', 'gmgt_gnrl_settings', 'MJ_gmgt_system_dashboard');



			//	add_submenu_page('gmgt_system', 'Gnrl_setting', esc_html__( 'General Settings', 'gym_mgt' ), 'administrator', 'gmgt_gnrl_settings', 'MJ_gmgt_gnrl_settings');



			//add_submenu_page('gmgt_system','access_right', esc_html__( 'Access Rights', 'gym_mgt' ), 'administrator', 'gmgt_access_right', 'MJ_gmgt_access_right');



			add_submenu_page('gmgt_system',esc_html__( 'Access Rights', 'gym_mgt' ), esc_html__( 'Access Rights', 'gym_mgt' ), 'administrator', 'gmgt_access_right', 'MJ_gmgt_system_dashboard');



		}



		elseif($user_role == 'management' )



	    {



			$accountant=MJ_gmgt_get_userrole_wise_access_right_array_by_page('accountant'); 



			$attendence=MJ_gmgt_get_userrole_wise_access_right_array_by_page('attendence'); 



			$membership=MJ_gmgt_get_userrole_wise_access_right_array_by_page('membership'); 

			

			$coupon=MJ_gmgt_get_userrole_wise_access_right_array_by_page('coupon');



			$group=MJ_gmgt_get_userrole_wise_access_right_array_by_page('group'); 



			$staff_member=MJ_gmgt_get_userrole_wise_access_right_array_by_page('staff_member'); 



			$class_schedule=MJ_gmgt_get_userrole_wise_access_right_array_by_page('class-schedule'); 



			$member=MJ_gmgt_get_userrole_wise_access_right_array_by_page('member'); 



			$activity=MJ_gmgt_get_userrole_wise_access_right_array_by_page('activity'); 



			$assign_workout=MJ_gmgt_get_userrole_wise_access_right_array_by_page('assign-workout'); 



			$nutrition=MJ_gmgt_get_userrole_wise_access_right_array_by_page('nutrition'); 



			$workouts=MJ_gmgt_get_userrole_wise_access_right_array_by_page('workouts'); 



			$product=MJ_gmgt_get_userrole_wise_access_right_array_by_page('product'); 



			$store=MJ_gmgt_get_userrole_wise_access_right_array_by_page('store'); 



			$reservation=MJ_gmgt_get_userrole_wise_access_right_array_by_page('reservation'); 



			$tax=MJ_gmgt_get_userrole_wise_access_right_array_by_page('tax'); 



			$membership_payment=MJ_gmgt_get_userrole_wise_access_right_array_by_page('membership_payment'); 



			$payment=MJ_gmgt_get_userrole_wise_access_right_array_by_page('payment'); 



			$message=MJ_gmgt_get_userrole_wise_access_right_array_by_page('message'); 



			$news_letter=MJ_gmgt_get_userrole_wise_access_right_array_by_page('news_letter'); 



			$notice=MJ_gmgt_get_userrole_wise_access_right_array_by_page('notice'); 



			$report=MJ_gmgt_get_userrole_wise_access_right_array_by_page('report'); 



			$sms_setting=MJ_gmgt_get_userrole_wise_access_right_array_by_page('sms_setting'); 



			$mail_template=MJ_gmgt_get_userrole_wise_access_right_array_by_page('mail_template'); 



			$general_settings=MJ_gmgt_get_userrole_wise_access_right_array_by_page('general_settings'); 



			add_menu_page(esc_html__('Gym Management','gym_mgt'),esc_html__('WPGYM','gym_mgt'),'management','gmgt_system','MJ_gmgt_system_dashboard',plugins_url('gym-management/assets/images/gym-1.png' )); 



			//Comment in demo //



			if($_SESSION['gmgt_verify'] == '')



			{



				add_submenu_page('gmgt_system', esc_html__('License Settings','gym_mgt'), esc_html__( 'License Settings', 'gym_mgt' ),'management','gmgt_setup','MJ_gmgt_system_dashboard');



			}



			add_submenu_page('gmgt_system', 'Dashboard', esc_html__( 'Dashboard', 'gym_mgt' ), 'management', 'gmgt_system', 'MJ_gmgt_system_dashboard');



			if($membership == 1)



			{



			  add_submenu_page('gmgt_system',esc_html__( 'Membership Type', 'gym_mgt' ) , esc_html__( 'Membership Type', 'gym_mgt' ), 'management', 'gmgt_membership_type', 'MJ_gmgt_system_dashboard');



			}



			if($coupon == 1)



			{

				add_submenu_page('gmgt_system',esc_html__( 'Coupons', 'gym_mgt' ) , esc_html__( 'Coupons', 'gym_mgt' ), 'management', 'gmgt_coupon', 'MJ_gmgt_system_dashboard');

			//   add_submenu_page('gmgt_system',esc_html__( 'Membership Type', 'gym_mgt' ) , esc_html__( 'Membership Type', 'gym_mgt' ), 'management', 'gmgt_membership_type', 'MJ_gmgt_system_dashboard');



			}



			if($group == 1)



			{



			   add_submenu_page('gmgt_system', esc_html__( 'Groups', 'gym_mgt' ), esc_html__( 'Groups', 'gym_mgt' ), 'management', 'gmgt_group', 'MJ_gmgt_system_dashboard');



			}



			if($staff_member == 1)



			{



			  add_submenu_page('gmgt_system', esc_html__( 'Staff Members', 'gym_mgt' ), esc_html__( 'Staff Members', 'gym_mgt' ), 'management', 'gmgt_staff', 'MJ_gmgt_system_dashboard');



			}



			if($class_schedule == 1)



			{



			add_submenu_page('gmgt_system', esc_html__( 'Class Schedule', 'gym_mgt' ), esc_html__( 'Class Schedule', 'gym_mgt' ), 'management', 'gmgt_class', 'MJ_gmgt_system_dashboard');



			



			}



			if($class_schedule== 1)



			{



			$gmgt_enable_virtual_classschedule=get_option("gmgt_enable_virtual_classschedule");



			if($gmgt_enable_virtual_classschedule == "yes")



			{



				add_submenu_page('gmgt_system', esc_html__('Virtual Class Schedule','gym_mgt'), esc_html__('Virtual Class Schedule','gym_mgt'), 'management', 'gmgt_virtual_class', 'MJ_gmgt_system_dashboard');



			}



			}



			if($member == 1)



			{



			   add_submenu_page('gmgt_system', esc_html__( 'Members', 'gym_mgt' ), esc_html__( 'Members', 'gym_mgt' ), 'management', 'gmgt_member', 'MJ_gmgt_system_dashboard');



			}



			if($activity == 1)



			{



			   add_submenu_page('gmgt_system', esc_html__( 'Activity', 'gym_mgt' ), esc_html__( 'Activity', 'gym_mgt' ), 'management', 'gmgt_activity', 'MJ_gmgt_system_dashboard');



			}



			



			if($assign_workout == 1)



			{



				add_submenu_page('gmgt_system', esc_html__( 'Assign Workout', 'gym_mgt' ), esc_html__( 'Assign Workout', 'gym_mgt' ), 'management', 'gmgt_workouttype', 'MJ_gmgt_system_dashboard');



			}



			if($nutrition == 1)



			{



			   add_submenu_page('gmgt_system', esc_html__( 'Nutrition Schedule', 'gym_mgt' ), esc_html__( 'Nutrition Schedule', 'gym_mgt' ), 'management', 'gmgt_nutrition', 'MJ_gmgt_system_dashboard');



			}



			if($workouts == 1)



			{



			add_submenu_page('gmgt_system', esc_html__( 'Daily Workout', 'gym_mgt' ), esc_html__( 'Daily Workout', 'gym_mgt' ), 'management', 'gmgt_workout', 'MJ_gmgt_system_dashboard');



			}



			if($product == 1)



			{



			add_submenu_page('gmgt_system', esc_html__( 'Products', 'gym_mgt' ), esc_html__( 'Products', 'gym_mgt' ), 'management', 'gmgt_product', 'MJ_gmgt_system_dashboard');



			}



			if($store == 1)



			{



			add_submenu_page('gmgt_system', esc_html__( 'Store', 'gym_mgt' ), esc_html__( 'Store', 'gym_mgt' ), 'management', 'gmgt_store', 'MJ_gmgt_system_dashboard');



			}



			if($reservation == 1)



			{



			add_submenu_page('gmgt_system', esc_html__( 'Reservation', 'gym_mgt' ), esc_html__( 'Reservation', 'gym_mgt' ), 'management', 'gmgt_reservation', 'MJ_gmgt_system_dashboard');



			



			}



			if($attendence == 1)



			{



			  add_submenu_page('gmgt_system', esc_html__( 'Attendance', 'gym_mgt' ), esc_html__( 'Attendance', 'gym_mgt' ), 'management', 'gmgt_attendence', 'MJ_gmgt_system_dashboard');



			}



			if($accountant == 1)



			{



			  add_submenu_page('gmgt_system', esc_html__( 'Accountant', 'gym_mgt' ), esc_html__( 'Accountant', 'gym_mgt' ), 'management', 'gmgt_accountant', 'MJ_gmgt_system_dashboard');



			}



			if($tax == 1)



			{



			  add_submenu_page('gmgt_system', esc_html__( 'Tax', 'gym_mgt' ), esc_html__( 'Tax', 'gym_mgt' ), 'management', 'MJ_gmgt_gmgt_taxes', 'MJ_gmgt_system_dashboard');



			}



			if($membership_payment == 1)



			{



			  add_submenu_page('gmgt_system', esc_html__( 'Membership Payment', 'gym_mgt' ), esc_html__( 'Membership Payment', 'gym_mgt' ), 'management', 'MJ_gmgt_fees_payment', 'MJ_gmgt_system_dashboard');



			}



			if($membership_payment == 1)



			{



			$gym_recurring_enable=get_option("gym_recurring_enable");



			if($gym_recurring_enable == "yes")



			{



				add_submenu_page('gmgt_system', esc_html__( 'Subscription', 'gym_mgt' ), esc_html__( 'Subscription', 'gym_mgt' ), 'management', 'MJ_gmgt_subscription', 'MJ_gmgt_system_dashboard');



			}



			}



			if($payment == 1)



			{



			   add_submenu_page('gmgt_system', esc_html__( 'Payment', 'gym_mgt' ), esc_html__( 'Payment', 'gym_mgt' ), 'management', 'gmgt_payment', 'MJ_gmgt_system_dashboard');



			}



			if($message == 1)



			{



			   add_submenu_page('gmgt_system', esc_html__( 'Message', 'gym_mgt' ), esc_html__( 'Message', 'gym_mgt' ), 'management', 'Gmgt_message', 'MJ_gmgt_system_dashboard');



			}



			if($news_letter == 1)



			{



			  add_submenu_page('gmgt_system', esc_html__( 'Newsletter', 'gym_mgt' ), esc_html__( 'Newsletter', 'gym_mgt' ), 'management', 'gmgt_newsletter', 'MJ_gmgt_system_dashboard');



			}



			if($notice == 1)



			{



			   add_submenu_page('gmgt_system',  esc_html__( 'Notice', 'gym_mgt' ), esc_html__( 'Notice', 'gym_mgt' ), 'management', 'gmgt_notice', 'MJ_gmgt_system_dashboard');



			}



			if($report == 1)



			{



			  add_submenu_page('gmgt_system', esc_html__( 'Report', 'gym_mgt' ), esc_html__( 'Report', 'gym_mgt' ), 'management', 'gmgt_report', 'MJ_gmgt_system_dashboard');



			}



			if($sms_setting == 1)



			{



			   add_submenu_page('gmgt_system',esc_html__( 'SMS Setting', 'gym_mgt' ), esc_html__( 'SMS Setting', 'gym_mgt' ), 'management', 'gmgt_sms_setting', 'MJ_gmgt_system_dashboard');



			}



			if($mail_template == 1)



			{



			  add_submenu_page('gmgt_system', esc_html__( 'Email Template', 'gym_mgt' ), esc_html__( 'Email Template', 'gym_mgt' ), 'management', 'gmgt_mail_template', 'MJ_gmgt_system_dashboard');



			}



			if($general_settings == 1)



			{



			  add_submenu_page('gmgt_system', esc_html__( 'General Settings', 'gym_mgt' ), esc_html__( 'General Settings', 'gym_mgt' ), 'management', 'gmgt_gnrl_settings', 'MJ_gmgt_system_dashboard');



			}



			//add_submenu_page('gmgt_system',esc_html__( 'Access Rights', 'gym_mgt' ), esc_html__( 'Access Rights', 'gym_mgt' ), 'management', 'gmgt_access_right', 'MJ_gmgt_access_right');



		}



    }



	else



	{ 		      



		die;



	}



}



//BELOW ALL PAGE call BY MENU FUNCTIONS







// function MJ_gmgt_options_page()



// {



// 	require_once GMS_PLUGIN_DIR. '/admin/setupform/index.php';



// }



// function MJ_gmgt_system_dashboard()



// {



// 	require_once GMS_PLUGIN_DIR. '/admin/dasboard.php';



// }	



// function MJ_gmgt_membership_manage()



// {



// 	require_once GMS_PLUGIN_DIR. '/admin/membership/index.php';



// }



// function MJ_gmgt_group_manage()



// {



// 	require_once GMS_PLUGIN_DIR. '/admin/group/index.php';



// }



// function MJ_gmgt_staff_manage()



// {



// 	require_once GMS_PLUGIN_DIR. '/admin/staff-members/index.php';



// }



// function MJ_gmgt_accountant_manage()



// {



// 	require_once GMS_PLUGIN_DIR. '/admin/accountant/index.php';



// }



// function MJ_gmgt_class_manage()



// {



// 	require_once GMS_PLUGIN_DIR. '/admin/class-schedule/index.php';



// }



// function MJ_gmgt_member_manage()



// {



// 	require_once GMS_PLUGIN_DIR. '/admin/member/index.php';



// }



// function MJ_gmgt_product_manage()



// {



// 	require_once GMS_PLUGIN_DIR. '/admin/product/index.php';



// }



// function MJ_gmgt_store_manage()



// {



// 	require_once GMS_PLUGIN_DIR. '/admin/store/index.php';



// }



// function MJ_gmgt_nutrition_manage()



// {



// 	require_once GMS_PLUGIN_DIR. '/admin/nutrition/index.php';



// }



// function MJ_gmgt_reservation_manage()



// {



// 	require_once GMS_PLUGIN_DIR. '/admin/reservation/index.php';



// }



// function MJ_gmgt_attendence_manage()



// {



// 	require_once GMS_PLUGIN_DIR. '/admin/attendence/index.php';



// }



// function MJ_gmgt_gmgt_taxes()



// {



// 	require_once GMS_PLUGIN_DIR. '/admin/tax/index.php';



// }



// function MJ_gmgt_fees_payment()



// {



// 	require_once GMS_PLUGIN_DIR. '/admin/membership_payment/index.php';



// }



// function MJ_gmgt_subscription()



// {



// 	require_once GMS_PLUGIN_DIR. '/admin/subcription/index.php';



// }



// function MJ_gmgt_payment_manage()



// {



// 	require_once GMS_PLUGIN_DIR. '/admin/payment/index.php';



// }



// function MJ_gmgt_message_manage()



// {



// 	require_once GMS_PLUGIN_DIR. '/admin/message/index.php';



// }



// function MJ_gmgt_newsletter_manage()



// {



// 	require_once GMS_PLUGIN_DIR. '/admin/news-letter/index.php';



// }



// function MJ_gmgt_activity_manage()



// {



// 	require_once GMS_PLUGIN_DIR. '/admin/activity/index.php';



// }



// function MJ_gmgt_workouttype_manage()



// {



// 	require_once GMS_PLUGIN_DIR. '/admin/workout-type/index.php';



// }



// function MJ_gmgt_workout_manage()



// {



// 	require_once GMS_PLUGIN_DIR. '/admin/workout/index.php';



// }



// function MJ_gmgt_notice_manage()



// {



// 	require_once GMS_PLUGIN_DIR. '/admin/notice/index.php';



// }



// function MJ_gmgt_report_manage()



// {



// 	require_once GMS_PLUGIN_DIR. '/admin/report/index.php';



// }



// function MJ_gmgt_mail_template_manage()



// {



// 	require_once GMS_PLUGIN_DIR. '/admin/email-template/index.php';



// }



// function MJ_gmgt_gnrl_settings()



// {



// 	require_once GMS_PLUGIN_DIR. '/admin/general-settings.php';



// }



// function MJ_gmgt_access_right()



// {



// 	require_once GMS_PLUGIN_DIR. '/admin/access_right/index.php';



// }



// function MJ_gmgt_sms_setting()



// {



// 	require_once GMS_PLUGIN_DIR. '/admin/sms_setting/index.php';



// }



// function MJ_gmgt_virtual_class_manage()



// {



// 	require_once GMS_PLUGIN_DIR. '/admin/virtual_class/index.php';



// }



function MJ_gmgt_system_dashboard()



{



	require_once GMS_PLUGIN_DIR. '/admin/dasboard.php';



}



?>