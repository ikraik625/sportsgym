<?php 

ob_start();
$check_id_user = null;

require_once GMS_PLUGIN_DIR. '/admin/ajax/gms-ajax.php';

require_once GMS_PLUGIN_DIR. '/gmgt_function.php';

require_once GMS_PLUGIN_DIR. '/class/membership.php';

require_once GMS_PLUGIN_DIR. '/class/coupon.php';

require_once GMS_PLUGIN_DIR. '/class/group.php';

require_once GMS_PLUGIN_DIR. '/class/member.php';

require_once GMS_PLUGIN_DIR. '/class/class_schedule.php';

require_once GMS_PLUGIN_DIR. '/class/product.php';

require_once GMS_PLUGIN_DIR. '/class/store.php';

require_once GMS_PLUGIN_DIR. '/class/reservation.php';

require_once GMS_PLUGIN_DIR. '/class/attendence.php';

require_once GMS_PLUGIN_DIR. '/class/membership_payment.php';

require_once GMS_PLUGIN_DIR. '/class/payment.php';

require_once GMS_PLUGIN_DIR. '/class/activity.php';

require_once GMS_PLUGIN_DIR. '/class/workout_type.php';

require_once GMS_PLUGIN_DIR. '/class/workout.php';

require_once GMS_PLUGIN_DIR. '/class/notice.php';

require_once GMS_PLUGIN_DIR. '/class/nutrition.php';

require_once GMS_PLUGIN_DIR. '/class/MailChimp.php';

require_once GMS_PLUGIN_DIR. '/class/MCAPI.class.php';

require_once GMS_PLUGIN_DIR. '/class/gym-management.php';

require_once GMS_PLUGIN_DIR. '/class/dashboard.php';

require_once GMS_PLUGIN_DIR. '/class/message.php';

require_once GMS_PLUGIN_DIR. '/class/tax.php';

require_once GMS_PLUGIN_DIR. '/class/guset_booking.php';

require_once GMS_PLUGIN_DIR. '/lib/paypal/paypal_class.php';

require_once GMS_PLUGIN_DIR. '/class/class_virtual_classroom.php';

add_action( 'admin_head', 'MJ_gmgt_admin_css' );

//ADMIN SIDE CSS FUNCTION

function MJ_gmgt_admin_css()

{

	?>

    <style>

    a.toplevel_page_gmgt_system:hover,  a.toplevel_page_gmgt_system:focus,.toplevel_page_gmgt_system.opensub a.wp-has-submen

    {

	 	background: url("<?php echo GMS_PLUGIN_URL;?>/assets/images/gym-2.png") no-repeat scroll 8px 9px rgba(0, 0, 0, 0) !important;

	}

	.toplevel_page_gmgt_system:hover .wp-menu-image.dashicons-before img {

	  display: none;

	}

	.toplevel_page_gmgt_system:hover .wp-menu-image.dashicons-before {

	  min-width: 23px !important;

	}  

	</style>

	<?php

}

add_action('init', 'MJ_gmgt_session_manager'); 

//SESSION MANAGER FUNCTION

function MJ_gmgt_session_manager() 

{	

	if (!session_id())

	{



		session_start();		



		if(!isset($_SESSION['gmgt_verify']))



		{			



			$_SESSION['gmgt_verify'] = '';



		}		



   		session_write_close();



	}



}



//LOGOUT FUNCTION 







function MJ_gmgt_logout()







{







	if(isset($_SESSION['gmgt_verify']))







	{ 







		unset($_SESSION['gmgt_verify']);







	}   







}







add_action('wp_logout','MJ_gmgt_logout');



add_action('init','MJ_gmgt_setup');
function MJ_gmgt_setup()
{







	$is_cmgt_pluginpage = MJ_gmgt_is_gmgtpage();







	$is_verify = false;







	if(!isset($_SESSION['gmgt_verify']))







		$_SESSION['gmgt_verify'] = '';







	$server_name = $_SERVER['SERVER_NAME'];







	$is_localserver = MJ_gmgt_chekserver($server_name);

	if($is_localserver)

	{		

		return true;

	}

	if($is_cmgt_pluginpage)

	{	







		if($_SESSION['gmgt_verify'] == '')







		{		







			if( get_option('licence_key') && get_option('gmgt_setup_email'))







			{			







				$domain_name = $_SERVER['SERVER_NAME'];







				$licence_key = get_option('licence_key');







				$email = get_option('gmgt_setup_email');







				$result = MJ_gmgt_check_productkey($domain_name,$licence_key,$email);



				



				$is_server_running = MJ_gmgt_check_ourserver();







				if($is_server_running)







					$_SESSION['gmgt_verify'] =$result;







				else







					$_SESSION['gmgt_verify'] = '0';







				$is_verify = MJ_gmgt_check_verify_or_not($result);







			







			}







		}







	}







	$is_verify = MJ_gmgt_check_verify_or_not($_SESSION['gmgt_verify']);







	if($is_cmgt_pluginpage)







		if(!$is_verify)







		{







			if($_REQUEST['page'] != 'gmgt_setup')







			wp_redirect(admin_url().'admin.php?page=gmgt_setup');







		}







}















if ( is_admin() )







{







	require_once GMS_PLUGIN_DIR. '/admin/admin.php';







	//INSTALL ROLE AND TABLE FUNCTION







	function MJ_gmgt_install()







	{







			add_role('staff_member', esc_html__( 'Instructor' ,'gym_mgt'),array( 'read' => true, 'level_1' => true ));







			add_role('accountant', esc_html__( 'Accountant' ,'gym_mgt'),array( 'read' => true, 'level_1' => true ));







			add_role('member', esc_html__( 'Member' ,'gym_mgt'),array( 'read' => true, 'level_0' => true ));







			add_role('management', __( 'Management' ,'gym_mgt'),array( 'read' => true, 'level_1' => true ));







			







			MJ_gmgt_install_tables();			







	}







	register_activation_hook(GMS_PLUGIN_BASENAME, 'MJ_gmgt_install' );







	//ADD OPTION FUNCTION







	function MJ_gmgt_option()







	{







		$access_right_member = array();







		$access_right_member['member'] = [







							"staff_member"=>["menu_icone"=>plugins_url('gym-management/assets/images/icon/staff-member.png'),







							           "menu_title"=>'Staff Members',







							           "page_link"=>'staff_member',







									   "own_data" =>isset($_REQUEST['staff_member_own_data'])?$_REQUEST['staff_member_own_data']:0,







									   "add" =>isset($_REQUEST['staff_member_add'])?$_REQUEST['staff_member_add']:0,







										"edit"=>isset($_REQUEST['staff_member_edit'])?$_REQUEST['staff_member_edit']:0,







										"view"=>isset($_REQUEST['staff_member_view'])?$_REQUEST['staff_member_view']:1,







										"delete"=>isset($_REQUEST['staff_member_delete'])?$_REQUEST['staff_member_delete']:0







										],







												







						   "membership"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/membership-type.png'),







						              "menu_title"=>'Membership Type',







						              "page_link"=>'membership',







									 "own_data" => isset($_REQUEST['membership_own_data'])?$_REQUEST['membership_own_data']:0,







									 "add" => isset($_REQUEST['membership_add'])?$_REQUEST['membership_add']:0,







									 "edit"=>isset($_REQUEST['membership_edit'])?$_REQUEST['membership_edit']:0,







									 "view"=>isset($_REQUEST['membership_view'])?$_REQUEST['membership_view']:1,







									 "delete"=>isset($_REQUEST['membership_delete'])?$_REQUEST['membership_delete']:0







						  ],







						  "coupon"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/membership-type.png'),







						              "menu_title"=>'Coupon',







						              "page_link"=>'coupon',







									 "own_data" => isset($_REQUEST['coupon_own_data'])?$_REQUEST['coupon_own_data']:0,







									 "add" => isset($_REQUEST['coupon_add'])?$_REQUEST['coupon_add']:0,







									 "edit"=>isset($_REQUEST['coupon_edit'])?$_REQUEST['coupon_edit']:0,







									 "view"=>isset($_REQUEST['coupon_view'])?$_REQUEST['coupon_view']:1,







									 "delete"=>isset($_REQUEST['coupon_delete'])?$_REQUEST['coupon_delete']:0







						  ],



									  







							"group"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/group.png'),







							        "menu_title"=>'Group',







									"page_link"=>'group',







									 "own_data" => isset($_REQUEST['group_own_data'])?$_REQUEST['group_own_data']:0,







									 "add" => isset($_REQUEST['group_add'])?$_REQUEST['group_add']:0,







									"edit"=>isset($_REQUEST['group_edit'])?$_REQUEST['group_edit']:0,







									"view"=>isset($_REQUEST['group_view'])?$_REQUEST['group_view']:1,







									"delete"=>isset($_REQUEST['group_delete'])?$_REQUEST['group_delete']:0







						  ],







									  







							  "member"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/member.png'),







							            "menu_title"=>'Member',







										"page_link"=>'member',







										"own_data" => isset($_REQUEST['member_own_data'])?$_REQUEST['member_own_data']:1,







										 "add" => isset($_REQUEST['member_add'])?$_REQUEST['member_add']:0,







										 "edit"=>isset($_REQUEST['member_edit'])?$_REQUEST['member_edit']:0,







										"view"=>isset($_REQUEST['member_view'])?$_REQUEST['member_view']:1,







										"delete"=>isset($_REQUEST['member_delete'])?$_REQUEST['member_delete']:0







							  ],







							  







							  "activity"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/activity.png'),







							             "menu_title"=>'Activity',







										 "page_link"=>'activity',







										 "own_data" => isset($_REQUEST['activity_own_data'])?$_REQUEST['activity_own_data']:0,







										 "add" => isset($_REQUEST['activity_add'])?$_REQUEST['activity_add']:0,







										"edit"=>isset($_REQUEST['activity_edit'])?$_REQUEST['activity_edit']:0,







										"view"=>isset($_REQUEST['activity_view'])?$_REQUEST['activity_view']:1,







										"delete"=>isset($_REQUEST['activity_delete'])?$_REQUEST['activity_delete']:0







							  ],







							  "class-schedule"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/class-schedule.png'),







							               "menu_title"=>'Class schedule',







										   "page_link"=>'class-schedule',







										 "own_data" => isset($_REQUEST['class_schedule_own_data'])?$_REQUEST['class_schedule_own_data']:0,







										 "add" => isset($_REQUEST['class_schedule_add'])?$_REQUEST['class_schedule_add']:0,







										"edit"=>isset($_REQUEST['class_schedule_edit'])?$_REQUEST['class_schedule_edit']:0,







										"view"=>isset($_REQUEST['class_schedule_view'])?$_REQUEST['class_schedule_view']:1,







										"delete"=>isset($_REQUEST['class_schedule_delete'])?$_REQUEST['class_schedule_delete']:0







							  ],







							  







							   "virtual_class"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/class-schedule.png'),							       







												"menu_title"=>'Virtual class schedule',







												"page_link"=>'virtual_class',







												"own_data" => isset($_REQUEST['virtual_class_own_data'])?$_REQUEST['virtual_class_own_data']:1,







												"add" => isset($_REQUEST['virtual_class_add'])?$_REQUEST['virtual_class_add']:0,







												"edit"=>isset($_REQUEST['virtual_class_edit'])?$_REQUEST['virtual_class_edit']:0,







												"view"=>isset($_REQUEST['virtual_class_view'])?$_REQUEST['virtual_class_view']:1,







												"delete"=>isset($_REQUEST['virtual_class_delete'])?$_REQUEST['virtual_class_delete']:0







									  ],















							    "attendence"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/attandance.png'),







								         "menu_title"=>'Attendence',







										 "page_link"=>'attendence',







										 "own_data" => isset($_REQUEST['attendence_own_data'])?$_REQUEST['attendence_own_data']:0,







										 "add" => isset($_REQUEST['attendence_add'])?$_REQUEST['attendence_add']:0,







										"edit"=>isset($_REQUEST['attendence_edit'])?$_REQUEST['attendence_edit']:0,







										"view"=>isset($_REQUEST['attendence_view'])?$_REQUEST['attendence_view']:0,







										"delete"=>isset($_REQUEST['attendence_delete'])?$_REQUEST['attendence_delete']:0







							  ],						  







							  







							    "assign-workout"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/assigne-workout.png'),







								         "menu_title"=>'Assigned Workouts',







										 "page_link"=>'assign-workout',







										 "own_data" => isset($_REQUEST['assign_workout_own_data'])?$_REQUEST['assign_workout_own_data']:1,







										 "add" => isset($_REQUEST['assign_workout_add'])?$_REQUEST['assign_workout_add']:0,







										"edit"=>isset($_REQUEST['assign_workout_edit'])?$_REQUEST['assign_workout_edit']:0,







										"view"=>isset($_REQUEST['assign_workout_view'])?$_REQUEST['assign_workout_view']:1,







										"delete"=>isset($_REQUEST['assign_workout_delete'])?$_REQUEST['assign_workout_delete']:0







							  ],







							  "nutrition"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/nutrition-schedule.png'),







							            "menu_title"=>'Nutrition Schedule',







										"page_link"=>'nutrition',







										 "own_data" => isset($_REQUEST['nutrition_own_data'])?$_REQUEST['nutrition_own_data']:1,







										 "add" => isset($_REQUEST['nutrition_add'])?$_REQUEST['nutrition_add']:0,







										"edit"=>isset($_REQUEST['nutrition_edit'])?$_REQUEST['nutrition_edit']:0,







										"view"=>isset($_REQUEST['nutrition_view'])?$_REQUEST['nutrition_view']:1,







										"delete"=>isset($_REQUEST['nutrition_delete'])?$_REQUEST['nutrition_delete']:0







							  ],







							    "workouts"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/workout.png'),







								         "menu_title"=>'Workouts',







										 "page_link"=>'workouts',







										 "own_data" => isset($_REQUEST['workouts_own_data'])?$_REQUEST['workouts_own_data']:1,







										 "add" => isset($_REQUEST['workouts_add'])?$_REQUEST['workouts_add']:1,







										"edit"=>isset($_REQUEST['workouts_edit'])?$_REQUEST['workouts_edit']:0,







										"view"=>isset($_REQUEST['workouts_view'])?$_REQUEST['workouts_view']:1,







										"delete"=>isset($_REQUEST['workouts_delete'])?$_REQUEST['workouts_delete']:0







							  ],







							    "accountant"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/accountant.png'),







								          "menu_title"=>'Accountant',







										  "page_link"=>'accountant',







										 "own_data" => isset($_REQUEST['accountant_own_data'])?$_REQUEST['accountant_own_data']:0,







										 "add" => isset($_REQUEST['accountant_add'])?$_REQUEST['accountant_add']:0,







										"edit"=>isset($_REQUEST['accountant_edit'])?$_REQUEST['accountant_edit']:0,







										"view"=>isset($_REQUEST['accountant_view'])?$_REQUEST['accountant_view']:1,







										"delete"=>isset($_REQUEST['accountant_delete'])?$_REQUEST['accountant_delete']:0







							  ],







							  







							  "membership_payment"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/fee.png'),







							             "menu_title"=>'Fee Payment',







										 "page_link"=>'membership_payment',







										 "own_data" => isset($_REQUEST['membership_payment_own_data'])?$_REQUEST['membership_payment_own_data']:1,







										 "add" => isset($_REQUEST['membership_payment_add'])?$_REQUEST['membership_payment_add']:0,







										"edit"=>isset($_REQUEST['membership_payment_edit'])?$_REQUEST['membership_payment_edit']:0,







										"view"=>isset($_REQUEST['membership_payment_view'])?$_REQUEST['membership_payment_view']:1,







										"delete"=>isset($_REQUEST['membership_payment_delete'])?$_REQUEST['membership_payment_delete']:0







							  ],







							  







							  "subscription"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/payment.png'),







							  "menu_title"=>'subscription',







							  "page_link"=>'subscription',







							  "own_data" => isset($_REQUEST['subscription_own_data'])?($_REQUEST['subscription_own_data']):1,







							  "add" => isset($_REQUEST['subscription_add'])?esc_attr($_REQUEST['subscription_add']):0,







							 "edit"=>isset($_REQUEST['subscription_edit'])?esc_attr($_REQUEST['subscription_edit']):0,







							 "view"=>isset($_REQUEST['subscription_view'])?esc_attr($_REQUEST['subscription_view']):1,







							 "delete"=>isset($_REQUEST['subscription_delete'])?esc_attr($_REQUEST['subscription_delete']):0







				  			 ],















							  "payment"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/payment.png'),







							             "menu_title"=>'Payment',







										 "page_link"=>'payment',







										 "own_data" => isset($_REQUEST['payment_own_data'])?$_REQUEST['payment_own_data']:1,







										 "add" => isset($_REQUEST['payment_add'])?$_REQUEST['payment_add']:0,







										"edit"=>isset($_REQUEST['payment_edit'])?$_REQUEST['payment_edit']:0,







										"view"=>isset($_REQUEST['payment_view'])?$_REQUEST['payment_view']:1,







										"delete"=>isset($_REQUEST['payment_delete'])?$_REQUEST['payment_delete']:0







							  ],







							  "product"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/products.png'),







							           "menu_title"=>'Product',







									   "page_link"=>'product',







										 "own_data" => isset($_REQUEST['product_own_data'])?$_REQUEST['product_own_data']:0,







										 "add" => isset($_REQUEST['product_add'])?$_REQUEST['product_add']:0,







										"edit"=>isset($_REQUEST['product_edit'])?$_REQUEST['product_edit']:0,







										"view"=>isset($_REQUEST['product_view'])?$_REQUEST['product_view']:1,







										"delete"=>isset($_REQUEST['product_delete'])?$_REQUEST['product_delete']:0







							  ],







							  "store"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/store.png'),







							              "menu_title"=>'Store',







										  "page_link"=>'store',







										 "own_data" => isset($_REQUEST['store_own_data'])?$_REQUEST['store_own_data']:1,







										 "add" => isset($_REQUEST['store_add'])?$_REQUEST['store_add']:0,







										"edit"=>isset($_REQUEST['store_edit'])?$_REQUEST['store_edit']:0,







										"view"=>isset($_REQUEST['store_view'])?$_REQUEST['store_view']:1,







										"delete"=>isset($_REQUEST['store_delete'])?$_REQUEST['store_delete']:0







							  ],







							  "news_letter"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/newsletter.png'),







							            "menu_title"=>'Newsletter',







										"page_link"=>'news_letter',







										 "own_data" => isset($_REQUEST['news_letter_own_data'])?$_REQUEST['news_letter_own_data']:0,







										 "add" => isset($_REQUEST['news_letter_add'])?$_REQUEST['news_letter_add']:0,







										"edit"=>isset($_REQUEST['news_letter_edit'])?$_REQUEST['news_letter_edit']:0,







										"view"=>isset($_REQUEST['news_letter_view'])?$_REQUEST['news_letter_view']:0,







										"delete"=>isset($_REQUEST['news_letter_delete'])?$_REQUEST['news_letter_delete']:0







							  ],







							  "message"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/message.png'),







							             "menu_title"=>'Message',







										 "page_link"=>'message',







										 "own_data" => isset($_REQUEST['message_own_data'])?$_REQUEST['message_own_data']:1,







										 "add" => isset($_REQUEST['message_add'])?$_REQUEST['message_add']:1,







										"edit"=>isset($_REQUEST['message_edit'])?$_REQUEST['message_edit']:0,







										"view"=>isset($_REQUEST['message_view'])?$_REQUEST['message_view']:1,







										"delete"=>isset($_REQUEST['message_delete'])?$_REQUEST['message_delete']:1







							  ],







							  







							   "notice"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/notice.png'),







							           "menu_title"=>'Notice',







									   "page_link"=>'notice',







										 "own_data" => isset($_REQUEST['notice_own_data'])?$_REQUEST['notice_own_data']:1,







										 "add" => isset($_REQUEST['notice_add'])?$_REQUEST['notice_add']:0,







										"edit"=>isset($_REQUEST['notice_edit'])?$_REQUEST['notice_edit']:0,







										"view"=>isset($_REQUEST['notice_view'])?$_REQUEST['notice_view']:1,







										"delete"=>isset($_REQUEST['notice_delete'])?$_REQUEST['notice_delete']:0







							  ],







							  







							   							  







							   "reservation"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/reservation.png'),							       







								         "menu_title"=>'Reservation',







										 "page_link"=>'reservation',







										 "own_data" => isset($_REQUEST['reservation_own_data'])?$_REQUEST['reservation_own_data']:0,







										 "add" => isset($_REQUEST['reservation_add'])?$_REQUEST['reservation_add']:0,







										"edit"=>isset($_REQUEST['reservation_edit'])?$_REQUEST['reservation_edit']:0,







										"view"=>isset($_REQUEST['reservation_view'])?$_REQUEST['reservation_view']:1,







										"delete"=>isset($_REQUEST['reservation_delete'])?$_REQUEST['reservation_delete']:0







							  ],







							  







							   "account"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/account.png'),







							              "menu_title"=>'Account',







										  "page_link"=>'account',







										 "own_data" => isset($_REQUEST['account_own_data'])?$_REQUEST['account_own_data']:0,







										 "add" => isset($_REQUEST['account_add'])?$_REQUEST['account_add']:0,







										"edit"=>isset($_REQUEST['account_edit'])?$_REQUEST['account_edit']:1,







										"view"=>isset($_REQUEST['account_view'])?$_REQUEST['account_view']:1,







										"delete"=>isset($_REQUEST['account_delete'])?$_REQUEST['account_delete']:0







							  ],







							   "subscription_history"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/subscription_history.png'),







							             "menu_title"=>'Membership History',







										 "page_link"=>'subscription_history',







										 "own_data" => isset($_REQUEST['subscription_history_own_data'])?$_REQUEST['subscription_history_own_data']:1,







										 "add" => isset($_REQUEST['subscription_history_add'])?$_REQUEST['subscription_history_add']:0,







										"edit"=>isset($_REQUEST['subscription_history_edit'])?$_REQUEST['subscription_history_edit']:0,







										"view"=>isset($_REQUEST['subscription_history_view'])?$_REQUEST['subscription_history_view']:1,







										"delete"=>isset($_REQUEST['subscription_history_delete'])?$_REQUEST['subscription_history_delete']:0







							  ]







			];







			







		$access_right_staff_member = array();







		$access_right_staff_member['staff_member'] = [







							"staff_member"=>["menu_icone"=>plugins_url('gym-management/assets/images/icon/staff-member.png'),







							           "menu_title"=>'Staff Members',







							           "page_link"=>'staff_member',







									   "own_data" =>isset($_REQUEST['staff_member_own_data'])?$_REQUEST['staff_member_own_data']:1,







									   "add" =>isset($_REQUEST['staff_member_add'])?$_REQUEST['staff_member_add']:0,







										"edit"=>isset($_REQUEST['staff_member_edit'])?$_REQUEST['staff_member_edit']:0,







										"view"=>isset($_REQUEST['staff_member_view'])?$_REQUEST['staff_member_view']:1,







										"delete"=>isset($_REQUEST['staff_member_delete'])?$_REQUEST['staff_member_delete']:0







										],







												







						   "membership"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/membership-type.png'),







						              "menu_title"=>'Membership Type',







						              "page_link"=>'membership',







									 "own_data" => isset($_REQUEST['membership_own_data'])?$_REQUEST['membership_own_data']:0,







									 "add" => isset($_REQUEST['membership_add'])?$_REQUEST['membership_add']:1,







									 "edit"=>isset($_REQUEST['membership_edit'])?$_REQUEST['membership_edit']:1,







									 "view"=>isset($_REQUEST['membership_view'])?$_REQUEST['membership_view']:1,







									 "delete"=>isset($_REQUEST['membership_delete'])?$_REQUEST['membership_delete']:1







						  ],







						  "coupon"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/membership-type.png'),







						              "menu_title"=>'Coupon',







						              "page_link"=>'coupon',







									 "own_data" => isset($_REQUEST['coupon_own_data'])?$_REQUEST['coupon_own_data']:0,







									 "add" => isset($_REQUEST['coupon_add'])?$_REQUEST['coupon_add']:1,







									 "edit"=>isset($_REQUEST['coupon_edit'])?$_REQUEST['coupon_edit']:1,







									 "view"=>isset($_REQUEST['coupon_view'])?$_REQUEST['coupon_view']:1,







									 "delete"=>isset($_REQUEST['coupon_delete'])?$_REQUEST['coupon_delete']:1







						  ],



									  







							"group"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/group.png'),







							        "menu_title"=>'Group',







									"page_link"=>'group',







									 "own_data" => isset($_REQUEST['group_own_data'])?$_REQUEST['group_own_data']:0,







									 "add" => isset($_REQUEST['group_add'])?$_REQUEST['group_add']:1,







									"edit"=>isset($_REQUEST['group_edit'])?$_REQUEST['group_edit']:1,







									"view"=>isset($_REQUEST['group_view'])?$_REQUEST['group_view']:1,







									"delete"=>isset($_REQUEST['group_delete'])?$_REQUEST['group_delete']:1







						  ],







									  







							  "member"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/member.png'),







							            "menu_title"=>'Member',







										"page_link"=>'member',







										"own_data" => isset($_REQUEST['member_own_data'])?$_REQUEST['member_own_data']:0,







										"add" => isset($_REQUEST['member_add'])?$_REQUEST['member_add']:0,







										"edit"=>isset($_REQUEST['member_edit'])?$_REQUEST['member_edit']:0,







										"view"=>isset($_REQUEST['member_view'])?$_REQUEST['member_view']:1,







										"delete"=>isset($_REQUEST['member_delete'])?$_REQUEST['member_delete']:1







							  ],







							  







							  "activity"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/activity.png'),







							             "menu_title"=>'Activity',







										 "page_link"=>'activity',







										 "own_data" => isset($_REQUEST['activity_own_data'])?$_REQUEST['activity_own_data']:0,







										 "add" => isset($_REQUEST['activity_add'])?$_REQUEST['activity_add']:1,







										"edit"=>isset($_REQUEST['activity_edit'])?$_REQUEST['activity_edit']:1,







										"view"=>isset($_REQUEST['activity_view'])?$_REQUEST['activity_view']:1,







										"delete"=>isset($_REQUEST['activity_delete'])?$_REQUEST['activity_delete']:1







							  ],







							  "class-schedule"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/class-schedule.png'),







							               "menu_title"=>'Class schedule',







										   "page_link"=>'class-schedule',







										 "own_data" => isset($_REQUEST['class_schedule_own_data'])?$_REQUEST['class_schedule_own_data']:0,







										 "add" => isset($_REQUEST['class_schedule_add'])?$_REQUEST['class_schedule_add']:1,







										"edit"=>isset($_REQUEST['class_schedule_edit'])?$_REQUEST['class_schedule_edit']:1,







										"view"=>isset($_REQUEST['class_schedule_view'])?$_REQUEST['class_schedule_view']:1,







										"delete"=>isset($_REQUEST['class_schedule_delete'])?$_REQUEST['class_schedule_delete']:1







							  ],







							  







							  "virtual_class"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/class-schedule.png'),							       







												 "menu_title"=>'Virtual class schedule',







												 "page_link"=>'virtual_class',







												 "own_data" => isset($_REQUEST['virtual_class_own_data'])?$_REQUEST['virtual_class_own_data']:0,







												 "add" => isset($_REQUEST['virtual_class_add'])?$_REQUEST['virtual_class_add']:1,







												"edit"=>isset($_REQUEST['virtual_class_edit'])?$_REQUEST['virtual_class_edit']:1,







												"view"=>isset($_REQUEST['virtual_class_view'])?$_REQUEST['virtual_class_view']:1,







												"delete"=>isset($_REQUEST['virtual_class_delete'])?$_REQUEST['virtual_class_delete']:1







									  ],















							    "attendence"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/attandance.png'),







								         "menu_title"=>'Attendence',







										 "page_link"=>'attendence',







										 "own_data" => isset($_REQUEST['attendence_own_data'])?$_REQUEST['attendence_own_data']:0,







										 "add" => isset($_REQUEST['attendence_add'])?$_REQUEST['attendence_add']:1,







										"edit"=>isset($_REQUEST['attendence_edit'])?$_REQUEST['attendence_edit']:1,







										"view"=>isset($_REQUEST['attendence_view'])?$_REQUEST['attendence_view']:1,







										"delete"=>isset($_REQUEST['attendence_delete'])?$_REQUEST['attendence_delete']:0







							  ],						  







							  







							    "assign-workout"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/assigne-workout.png'),







								         "menu_title"=>'Assigned Workouts',







										 "page_link"=>'assign-workout',







										 "own_data" => isset($_REQUEST['assign_workout_own_data'])?$_REQUEST['assign_workout_own_data']:0,







										 "add" => isset($_REQUEST['assign_workout_add'])?$_REQUEST['assign_workout_add']:1,







										"edit"=>isset($_REQUEST['assign_workout_edit'])?$_REQUEST['assign_workout_edit']:1,







										"view"=>isset($_REQUEST['assign_workout_view'])?$_REQUEST['assign_workout_view']:1,







										"delete"=>isset($_REQUEST['assign_workout_delete'])?$_REQUEST['assign_workout_delete']:1







							  ],







							   "nutrition"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/nutrition-schedule.png'),







							            "menu_title"=>'Nutrition Schedule',







										"page_link"=>'nutrition',







										 "own_data" => isset($_REQUEST['nutrition_own_data'])?$_REQUEST['nutrition_own_data']:0,







										 "add" => isset($_REQUEST['nutrition_add'])?$_REQUEST['nutrition_add']:1,







										"edit"=>isset($_REQUEST['nutrition_edit'])?$_REQUEST['nutrition_edit']:0,







										"view"=>isset($_REQUEST['nutrition_view'])?$_REQUEST['nutrition_view']:1,







										"delete"=>isset($_REQUEST['nutrition_delete'])?$_REQUEST['nutrition_delete']:1







							  ],







							    "workouts"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/workout.png'),







								         "menu_title"=>'Workouts',







										 "page_link"=>'workouts',







										 "own_data" => isset($_REQUEST['workouts_own_data'])?$_REQUEST['workouts_own_data']:0,







										 "add" => isset($_REQUEST['workouts_add'])?$_REQUEST['workouts_add']:1,







										"edit"=>isset($_REQUEST['workouts_edit'])?$_REQUEST['workouts_edit']:0,







										"view"=>isset($_REQUEST['workouts_view'])?$_REQUEST['workouts_view']:1,







										"delete"=>isset($_REQUEST['workouts_delete'])?$_REQUEST['workouts_delete']:0







							  ],







							    "accountant"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/accountant.png'),







								          "menu_title"=>'Accountant',







										  "page_link"=>'accountant',







										 "own_data" => isset($_REQUEST['accountant_own_data'])?$_REQUEST['accountant_own_data']:0,







										 "add" => isset($_REQUEST['accountant_add'])?$_REQUEST['accountant_add']:0,







										"edit"=>isset($_REQUEST['accountant_edit'])?$_REQUEST['accountant_edit']:0,







										"view"=>isset($_REQUEST['accountant_view'])?$_REQUEST['accountant_view']:1,







										"delete"=>isset($_REQUEST['accountant_delete'])?$_REQUEST['accountant_delete']:0







							  ],







							  







							  "membership_payment"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/fee.png'),







							             "menu_title"=>'Fee Payment',







										 "page_link"=>'membership_payment',







										 "own_data" => isset($_REQUEST['membership_payment_own_data'])?$_REQUEST['membership_payment_own_data']:0,







										 "add" => isset($_REQUEST['membership_payment_add'])?$_REQUEST['membership_payment_add']:0,







										"edit"=>isset($_REQUEST['membership_payment_edit'])?$_REQUEST['membership_payment_edit']:0,







										"view"=>isset($_REQUEST['membership_payment_view'])?$_REQUEST['membership_payment_view']:0,







										"delete"=>isset($_REQUEST['membership_payment_delete'])?$_REQUEST['membership_payment_delete']:0







							  ],







							  







							  "payment"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/payment.png'),







							             "menu_title"=>'Payment',







										 "page_link"=>'payment',







										 "own_data" => isset($_REQUEST['payment_own_data'])?$_REQUEST['payment_own_data']:0,







										 "add" => isset($_REQUEST['payment_add'])?$_REQUEST['payment_add']:0,







										"edit"=>isset($_REQUEST['payment_edit'])?$_REQUEST['payment_edit']:0,







										"view"=>isset($_REQUEST['payment_view'])?$_REQUEST['payment_view']:0,







										"delete"=>isset($_REQUEST['payment_delete'])?$_REQUEST['payment_delete']:0







							  ],







							  "product"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/products.png'),







							           "menu_title"=>'Product',







									   "page_link"=>'product',







										 "own_data" => isset($_REQUEST['product_own_data'])?$_REQUEST['product_own_data']:0,







										 "add" => isset($_REQUEST['product_add'])?$_REQUEST['product_add']:1,







										"edit"=>isset($_REQUEST['product_edit'])?$_REQUEST['product_edit']:1,







										"view"=>isset($_REQUEST['product_view'])?$_REQUEST['product_view']:1,







										"delete"=>isset($_REQUEST['product_delete'])?$_REQUEST['product_delete']:1







							  ],







							  "store"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/store.png'),







							              "menu_title"=>'Store',







										  "page_link"=>'store',







										 "own_data" => isset($_REQUEST['store_own_data'])?$_REQUEST['store_own_data']:0,







										 "add" => isset($_REQUEST['store_add'])?$_REQUEST['store_add']:1,







										"edit"=>isset($_REQUEST['store_edit'])?$_REQUEST['store_edit']:0,







										"view"=>isset($_REQUEST['store_view'])?$_REQUEST['store_view']:1,







										"delete"=>isset($_REQUEST['store_delete'])?$_REQUEST['store_delete']:0







							  ],







							  "news_letter"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/newsletter.png'),







							            "menu_title"=>'Newsletter',







										"page_link"=>'news_letter',







										 "own_data" => isset($_REQUEST['news_letter_own_data'])?$_REQUEST['news_letter_own_data']:0,







										 "add" => isset($_REQUEST['news_letter_add'])?$_REQUEST['news_letter_add']:0,







										"edit"=>isset($_REQUEST['news_letter_edit'])?$_REQUEST['news_letter_edit']:0,







										"view"=>isset($_REQUEST['news_letter_view'])?$_REQUEST['news_letter_view']:1,







										"delete"=>isset($_REQUEST['news_letter_delete'])?$_REQUEST['news_letter_delete']:0







							  ],







							  "message"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/message.png'),







							             "menu_title"=>'Message',







										 "page_link"=>'message',







										 "own_data" => isset($_REQUEST['message_own_data'])?$_REQUEST['message_own_data']:1,







										 "add" => isset($_REQUEST['message_add'])?$_REQUEST['message_add']:1,







										"edit"=>isset($_REQUEST['message_edit'])?$_REQUEST['message_edit']:0,







										"view"=>isset($_REQUEST['message_view'])?$_REQUEST['message_view']:1,







										"delete"=>isset($_REQUEST['message_delete'])?$_REQUEST['message_delete']:1







							  ],







							  







							   "notice"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/notice.png'),







							           "menu_title"=>'Notice',







									   "page_link"=>'notice',







										 "own_data" => isset($_REQUEST['notice_own_data'])?$_REQUEST['notice_own_data']:1,







										 "add" => isset($_REQUEST['notice_add'])?$_REQUEST['notice_add']:0,







										"edit"=>isset($_REQUEST['notice_edit'])?$_REQUEST['notice_edit']:0,







										"view"=>isset($_REQUEST['notice_view'])?$_REQUEST['notice_view']:1,







										"delete"=>isset($_REQUEST['notice_delete'])?$_REQUEST['notice_delete']:0







							  ],







							  							  







							   "reservation"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/reservation.png'),							       







								         "menu_title"=>'Reservation',







										 "page_link"=>'reservation',







										 "own_data" => isset($_REQUEST['reservation_own_data'])?$_REQUEST['reservation_own_data']:0,







										 "add" => isset($_REQUEST['reservation_add'])?$_REQUEST['reservation_add']:1,







										"edit"=>isset($_REQUEST['reservation_edit'])?$_REQUEST['reservation_edit']:1,







										"view"=>isset($_REQUEST['reservation_view'])?$_REQUEST['reservation_view']:1,







										"delete"=>isset($_REQUEST['reservation_delete'])?$_REQUEST['reservation_delete']:1







							  ],







							  







							  "report"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/reports.png'),							       







										"menu_title"=>'Report',







										"page_link"=>'report',







										"own_data" => isset($_REQUEST['report_own_data'])?esc_attr($_REQUEST['report_own_data']):0,







										"add" => isset($_REQUEST['report_add'])?esc_attr($_REQUEST['report_add']):0,







										"edit"=>isset($_REQUEST['report_edit'])?esc_attr($_REQUEST['report_edit']):0,







										"view"=>isset($_REQUEST['report_view'])?esc_attr($_REQUEST['report_view']):1,







										"delete"=>isset($_REQUEST['report_delete'])?esc_attr($_REQUEST['report_delete']):0







								],







								







							   "account"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/account.png'),







							              "menu_title"=>'Account',







										  "page_link"=>'account',







										 "own_data" => isset($_REQUEST['account_own_data'])?$_REQUEST['account_own_data']:0,







										 "add" => isset($_REQUEST['account_add'])?$_REQUEST['account_add']:0,







										"edit"=>isset($_REQUEST['account_edit'])?$_REQUEST['account_edit']:1,







										"view"=>isset($_REQUEST['account_view'])?$_REQUEST['account_view']:1,







										"delete"=>isset($_REQUEST['account_delete'])?$_REQUEST['account_delete']:0







							  ],







							  "tax"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/setting.png'),							       







											"menu_title"=>'Tax',







											"page_link"=>'tax',







											"own_data" => isset($_REQUEST['tax_own_data'])?esc_attr($_REQUEST['tax_own_data']):0,







											"add" => isset($_REQUEST['tax_add'])?esc_attr($_REQUEST['tax_add']):1,







											"edit"=>isset($_REQUEST['tax_edit'])?esc_attr($_REQUEST['tax_edit']):1,







											"view"=>isset($_REQUEST['tax_view'])?esc_attr($_REQUEST['tax_view']):1,







											"delete"=>isset($_REQUEST['tax_delete'])?esc_attr($_REQUEST['tax_delete']):1







								],







							  "sms_setting"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/sms_setting.png'),							       







										"menu_title"=>'SMS Setting',







										"page_link"=>'sms_setting',







										"own_data" => isset($_REQUEST['sms_setting_own_data'])?esc_attr($_REQUEST['sms_setting_own_data']):0,







										"add" => isset($_REQUEST['sms_setting_add'])?esc_attr($_REQUEST['sms_setting_add']):0,







										"edit"=>isset($_REQUEST['sms_setting_edit'])?esc_attr($_REQUEST['sms_setting_edit']):0,







										"view"=>isset($_REQUEST['sms_setting_view'])?esc_attr($_REQUEST['sms_setting_view']):1,







										"delete"=>isset($_REQUEST['sms_setting_delete'])?esc_attr($_REQUEST['sms_setting_delete']):0







								],















							   "subscription_history"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/subscription_history.png'),







							             "menu_title"=>'Membership History',







										 "page_link"=>'subscription_history',







										 "own_data" => isset($_REQUEST['subscription_history_own_data'])?$_REQUEST['subscription_history_own_data']:0,







										 "add" => isset($_REQUEST['subscription_history_add'])?$_REQUEST['subscription_history_add']:0,







										"edit"=>isset($_REQUEST['subscription_history_edit'])?$_REQUEST['subscription_history_edit']:0,







										"view"=>isset($_REQUEST['subscription_history_view'])?$_REQUEST['subscription_history_view']:1,







										"delete"=>isset($_REQUEST['subscription_history_delete'])?$_REQUEST['subscription_history_delete']:0







							],















							"mail_template"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/mail_template.png'),							       







												"menu_title"=>'Mail Template',







												"page_link"=>'mail_template',







												"own_data" => isset($_REQUEST['mail_template_own_data'])?esc_attr($_REQUEST['mail_template_own_data']):0,







												"add" => isset($_REQUEST['mail_template_add'])?esc_attr($_REQUEST['mail_template_add']):0,







												"edit"=>isset($_REQUEST['mail_template_edit'])?esc_attr($_REQUEST['mail_template_edit']):0,







												"view"=>isset($_REQUEST['mail_template_view'])?esc_attr($_REQUEST['mail_template_view']):1,







												"delete"=>isset($_REQUEST['mail_template_delete'])?esc_attr($_REQUEST['mail_template_delete']):0







										],







			];	







				







		$access_right_accountant = array();







		$access_right_accountant['accountant'] = [







							"staff_member"=>["menu_icone"=>plugins_url('gym-management/assets/images/icon/staff-member.png'),







							           "menu_title"=>'Staff Members',







							           "page_link"=>'staff_member',







									   "own_data" =>isset($_REQUEST['staff_member_own_data'])?$_REQUEST['staff_member_own_data']:0,







									   "add" =>isset($_REQUEST['staff_member_add'])?$_REQUEST['staff_member_add']:0,







										"edit"=>isset($_REQUEST['staff_member_edit'])?$_REQUEST['staff_member_edit']:0,







										"view"=>isset($_REQUEST['staff_member_view'])?$_REQUEST['staff_member_view']:1,







										"delete"=>isset($_REQUEST['staff_member_delete'])?$_REQUEST['staff_member_delete']:0







										],







												







						   "membership"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/membership-type.png'),







						              "menu_title"=>'Membership Type',







						              "page_link"=>'membership',







									 "own_data" => isset($_REQUEST['membership_own_data'])?$_REQUEST['membership_own_data']:0,







									 "add" => isset($_REQUEST['membership_add'])?$_REQUEST['membership_add']:0,







									 "edit"=>isset($_REQUEST['membership_edit'])?$_REQUEST['membership_edit']:0,







									 "view"=>isset($_REQUEST['membership_view'])?$_REQUEST['membership_view']:0,







									 "delete"=>isset($_REQUEST['membership_delete'])?$_REQUEST['membership_delete']:0







						  ],







									  







							"group"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/group.png'),







							        "menu_title"=>'Group',







									"page_link"=>'group',







									 "own_data" => isset($_REQUEST['group_own_data'])?$_REQUEST['group_own_data']:0,







									 "add" => isset($_REQUEST['group_add'])?$_REQUEST['group_add']:0,







									"edit"=>isset($_REQUEST['group_edit'])?$_REQUEST['group_edit']:0,







									"view"=>isset($_REQUEST['group_view'])?$_REQUEST['group_view']:0,







									"delete"=>isset($_REQUEST['group_delete'])?$_REQUEST['group_delete']:0







						  ],







									  







							  "member"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/member.png'),







							            "menu_title"=>'Member',







										"page_link"=>'member',







										"own_data" => isset($_REQUEST['member_own_data'])?$_REQUEST['member_own_data']:0,







										 "add" => isset($_REQUEST['member_add'])?$_REQUEST['member_add']:0,







										 "edit"=>isset($_REQUEST['member_edit'])?$_REQUEST['member_edit']:0,







										"view"=>isset($_REQUEST['member_view'])?$_REQUEST['member_view']:1,







										"delete"=>isset($_REQUEST['member_delete'])?$_REQUEST['member_delete']:0







							  ],







							  







							  "activity"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/activity.png'),







							             "menu_title"=>'Activity',







										 "page_link"=>'activity',







										 "own_data" => isset($_REQUEST['activity_own_data'])?$_REQUEST['activity_own_data']:0,







										 "add" => isset($_REQUEST['activity_add'])?$_REQUEST['activity_add']:0,







										"edit"=>isset($_REQUEST['activity_edit'])?$_REQUEST['activity_edit']:0,







										"view"=>isset($_REQUEST['activity_view'])?$_REQUEST['activity_view']:0,







										"delete"=>isset($_REQUEST['activity_delete'])?$_REQUEST['activity_delete']:0







							  ],







							  "class-schedule"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/class-schedule.png'),







							               "menu_title"=>'Class schedule',







										   "page_link"=>'class-schedule',







										 "own_data" => isset($_REQUEST['class_schedule_own_data'])?$_REQUEST['class_schedule_own_data']:0,







										 "add" => isset($_REQUEST['class_schedule_add'])?$_REQUEST['class_schedule_add']:0,







										"edit"=>isset($_REQUEST['class_schedule_edit'])?$_REQUEST['class_schedule_edit']:0,







										"view"=>isset($_REQUEST['class_schedule_view'])?$_REQUEST['class_schedule_view']:0,







										"delete"=>isset($_REQUEST['class_schedule_delete'])?$_REQUEST['class_schedule_delete']:0







							  ],







							  "virtual_class"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/class-schedule.png'),							       







										 "menu_title"=>'Virtual class schedule',







										 "page_link"=>'virtual_class',







										 "own_data" => isset($_REQUEST['virtual_class_own_data'])?$_REQUEST['virtual_class_own_data']:0,







										 "add" => isset($_REQUEST['virtual_class_add'])?$_REQUEST['virtual_class_add']:0,







										"edit"=>isset($_REQUEST['virtual_class_edit'])?$_REQUEST['virtual_class_edit']:0,







										"view"=>isset($_REQUEST['virtual_class_view'])?$_REQUEST['virtual_class_view']:1,







										"delete"=>isset($_REQUEST['virtual_class_delete'])?$_REQUEST['virtual_class_delete']:0







							  ],







							  







							    "attendence"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/attandance.png'),







								         "menu_title"=>'Attendence',







										 "page_link"=>'attendence',







										 "own_data" => isset($_REQUEST['attendence_own_data'])?$_REQUEST['attendence_own_data']:0,







										 "add" => isset($_REQUEST['attendence_add'])?$_REQUEST['attendence_add']:0,







										"edit"=>isset($_REQUEST['attendence_edit'])?$_REQUEST['attendence_edit']:0,







										"view"=>isset($_REQUEST['attendence_view'])?$_REQUEST['attendence_view']:0,







										"delete"=>isset($_REQUEST['attendence_delete'])?$_REQUEST['attendence_delete']:0







							  ],						  







							  







							  







							    "assign-workout"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/assigne-workout.png'),







								         "menu_title"=>'Assigned Workouts',







										 "page_link"=>'assign-workout',







										 "own_data" => isset($_REQUEST['assign_workout_own_data'])?$_REQUEST['assign_workout_own_data']:0,







										 "add" => isset($_REQUEST['assign_workout_add'])?$_REQUEST['assign_workout_add']:0,







										"edit"=>isset($_REQUEST['assign_workout_edit'])?$_REQUEST['assign_workout_edit']:0,







										"view"=>isset($_REQUEST['assign_workout_view'])?$_REQUEST['assign_workout_view']:0,







										"delete"=>isset($_REQUEST['assign_workout_delete'])?$_REQUEST['assign_workout_delete']:0







							  ],







							  "nutrition"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/nutrition-schedule.png'),







							            "menu_title"=>'Nutrition Schedule',







										"page_link"=>'nutrition',







										 "own_data" => isset($_REQUEST['nutrition_own_data'])?$_REQUEST['nutrition_own_data']:0,







										 "add" => isset($_REQUEST['nutrition_add'])?$_REQUEST['nutrition_add']:0,







										"edit"=>isset($_REQUEST['nutrition_edit'])?$_REQUEST['nutrition_edit']:0,







										"view"=>isset($_REQUEST['nutrition_view'])?$_REQUEST['nutrition_view']:0,







										"delete"=>isset($_REQUEST['nutrition_delete'])?$_REQUEST['nutrition_delete']:0







							  ],







							    "workouts"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/workout.png'),







								         "menu_title"=>'Workouts',







										 "page_link"=>'workouts',







										 "own_data" => isset($_REQUEST['workouts_own_data'])?$_REQUEST['workouts_own_data']:0,







										 "add" => isset($_REQUEST['workouts_add'])?$_REQUEST['workouts_add']:0,







										"edit"=>isset($_REQUEST['workouts_edit'])?$_REQUEST['workouts_edit']:0,







										"view"=>isset($_REQUEST['workouts_view'])?$_REQUEST['workouts_view']:0,







										"delete"=>isset($_REQUEST['workouts_delete'])?$_REQUEST['workouts_delete']:0







							  ],







							    "accountant"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/accountant.png'),







								          "menu_title"=>'Accountant',







										  "page_link"=>'accountant',







										 "own_data" => isset($_REQUEST['accountant_own_data'])?$_REQUEST['accountant_own_data']:0,







										 "add" => isset($_REQUEST['accountant_add'])?$_REQUEST['accountant_add']:0,







										"edit"=>isset($_REQUEST['accountant_edit'])?$_REQUEST['accountant_edit']:0,







										"view"=>isset($_REQUEST['accountant_view'])?$_REQUEST['accountant_view']:1,







										"delete"=>isset($_REQUEST['accountant_delete'])?$_REQUEST['accountant_delete']:0







							  ],







							  







							  "membership_payment"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/fee.png'),







							             "menu_title"=>'Fee Payment',







										 "page_link"=>'membership_payment',







										 "own_data" => isset($_REQUEST['membership_payment_own_data'])?$_REQUEST['membership_payment_own_data']:0,







										 "add" => isset($_REQUEST['membership_payment_add'])?$_REQUEST['membership_payment_add']:0,







										"edit"=>isset($_REQUEST['membership_payment_edit'])?$_REQUEST['membership_payment_edit']:0,







										"view"=>isset($_REQUEST['membership_payment_view'])?$_REQUEST['membership_payment_view']:1,







										"delete"=>isset($_REQUEST['membership_payment_delete'])?$_REQUEST['membership_payment_delete']:0







							  ],







							  







							  "payment"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/payment.png'),







							             "menu_title"=>'Payment',







										 "page_link"=>'payment',







										 "own_data" => isset($_REQUEST['payment_own_data'])?$_REQUEST['payment_own_data']:0,







										 "add" => isset($_REQUEST['payment_add'])?$_REQUEST['payment_add']:1,







										"edit"=>isset($_REQUEST['payment_edit'])?$_REQUEST['payment_edit']:1,







										"view"=>isset($_REQUEST['payment_view'])?$_REQUEST['payment_view']:1,







										"delete"=>isset($_REQUEST['payment_delete'])?$_REQUEST['payment_delete']:1







							  ],







							  "product"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/products.png'),







							           "menu_title"=>'Product',







									   "page_link"=>'product',







										 "own_data" => isset($_REQUEST['product_own_data'])?$_REQUEST['product_own_data']:0,







										 "add" => isset($_REQUEST['product_add'])?$_REQUEST['product_add']:1,







										"edit"=>isset($_REQUEST['product_edit'])?$_REQUEST['product_edit']:1,







										"view"=>isset($_REQUEST['product_view'])?$_REQUEST['product_view']:1,







										"delete"=>isset($_REQUEST['product_delete'])?$_REQUEST['product_delete']:1







							  ],







							  "store"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/store.png'),







							              "menu_title"=>'Store',







										  "page_link"=>'store',







										 "own_data" => isset($_REQUEST['store_own_data'])?$_REQUEST['store_own_data']:0,







										 "add" => isset($_REQUEST['store_add'])?$_REQUEST['store_add']:1,







										"edit"=>isset($_REQUEST['store_edit'])?$_REQUEST['store_edit']:0,







										"view"=>isset($_REQUEST['store_view'])?$_REQUEST['store_view']:1,







										"delete"=>isset($_REQUEST['store_delete'])?$_REQUEST['store_delete']:0







							  ],







							  "news_letter"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/newsletter.png'),







							            "menu_title"=>'Newsletter',







										"page_link"=>'news_letter',







										 "own_data" => isset($_REQUEST['news_letter_own_data'])?$_REQUEST['news_letter_own_data']:0,







										 "add" => isset($_REQUEST['news_letter_add'])?$_REQUEST['news_letter_add']:0,







										"edit"=>isset($_REQUEST['news_letter_edit'])?$_REQUEST['news_letter_edit']:0,







										"view"=>isset($_REQUEST['news_letter_view'])?$_REQUEST['news_letter_view']:0,







										"delete"=>isset($_REQUEST['news_letter_delete'])?$_REQUEST['news_letter_delete']:0







							  ],







							  "message"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/message.png'),







							             "menu_title"=>'Message',







										 "page_link"=>'message',







										 "own_data" => isset($_REQUEST['message_own_data'])?$_REQUEST['message_own_data']:1,







										 "add" => isset($_REQUEST['message_add'])?$_REQUEST['message_add']:1,







										"edit"=>isset($_REQUEST['message_edit'])?$_REQUEST['message_edit']:0,







										"view"=>isset($_REQUEST['message_view'])?$_REQUEST['message_view']:1,







										"delete"=>isset($_REQUEST['message_delete'])?$_REQUEST['message_delete']:1







							  ],







							  







							   "notice"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/notice.png'),







							           "menu_title"=>'Notice',







									   "page_link"=>'notice',







										 "own_data" => isset($_REQUEST['notice_own_data'])?$_REQUEST['notice_own_data']:1,







										 "add" => isset($_REQUEST['notice_add'])?$_REQUEST['notice_add']:0,







										"edit"=>isset($_REQUEST['notice_edit'])?$_REQUEST['notice_edit']:0,







										"view"=>isset($_REQUEST['notice_view'])?$_REQUEST['notice_view']:1,







										"delete"=>isset($_REQUEST['notice_delete'])?$_REQUEST['notice_delete']:0







							  ],







							  







							   "reservation"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/reservation.png'),							       







								         "menu_title"=>'Reservation',







										 "page_link"=>'reservation',







										 "own_data" => isset($_REQUEST['reservation_own_data'])?$_REQUEST['reservation_own_data']:0,







										 "add" => isset($_REQUEST['reservation_add'])?$_REQUEST['reservation_add']:0,







										"edit"=>isset($_REQUEST['reservation_edit'])?$_REQUEST['reservation_edit']:0,







										"view"=>isset($_REQUEST['reservation_view'])?$_REQUEST['reservation_view']:0,







										"delete"=>isset($_REQUEST['reservation_delete'])?$_REQUEST['reservation_delete']:0







							  ],







							  







							  "report"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/reports.png'),							       







										"menu_title"=>'Report',







										"page_link"=>'report',







										"own_data" => isset($_REQUEST['report_own_data'])?esc_attr($_REQUEST['report_own_data']):0,







										"add" => isset($_REQUEST['report_add'])?esc_attr($_REQUEST['report_add']):0,







										"edit"=>isset($_REQUEST['report_edit'])?esc_attr($_REQUEST['report_edit']):0,







										"view"=>isset($_REQUEST['report_view'])?esc_attr($_REQUEST['report_view']):1,







										"delete"=>isset($_REQUEST['report_delete'])?esc_attr($_REQUEST['report_delete']):0







								],







							  







							   "account"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/account.png'),







							              "menu_title"=>'Account',







										  "page_link"=>'account',







										 "own_data" => isset($_REQUEST['account_own_data'])?$_REQUEST['account_own_data']:0,







										 "add" => isset($_REQUEST['account_add'])?$_REQUEST['account_add']:0,







										"edit"=>isset($_REQUEST['account_edit'])?$_REQUEST['account_edit']:1,







										"view"=>isset($_REQUEST['account_view'])?$_REQUEST['account_view']:1,







										"delete"=>isset($_REQUEST['account_delete'])?$_REQUEST['account_delete']:0







							  ],







							   "subscription_history"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/subscription_history.png'),







							             "menu_title"=>'Membership History',







										 "page_link"=>'subscription_history',







										 "own_data" => isset($_REQUEST['subscription_history_own_data'])?$_REQUEST['subscription_history_own_data']:0,







										 "add" => isset($_REQUEST['subscription_history_add'])?$_REQUEST['subscription_history_add']:0,







										"edit"=>isset($_REQUEST['subscription_history_edit'])?$_REQUEST['subscription_history_edit']:0,







										"view"=>isset($_REQUEST['subscription_history_view'])?$_REQUEST['subscription_history_view']:1,







										"delete"=>isset($_REQUEST['subscription_history_delete'])?$_REQUEST['subscription_history_delete']:0







							  ]







			];	







			$access_right_management = array();







		    $access_right_management['management'] = [







							"staff_member"=>["menu_icone"=>plugins_url('gym-management/assets/images/icon/staff-member.png'),







							           "menu_title"=>'Staff Members',







							           "page_link"=>'staff_member',







									   "own_data" =>isset($_REQUEST['staff_member_own_data'])?$_REQUEST['staff_member_own_data']:0,







									   "add" =>isset($_REQUEST['staff_member_add'])?$_REQUEST['staff_member_add']:1,







										"edit"=>isset($_REQUEST['staff_member_edit'])?$_REQUEST['staff_member_edit']:1,







										"view"=>isset($_REQUEST['staff_member_view'])?$_REQUEST['staff_member_view']:1,







										"delete"=>isset($_REQUEST['staff_member_delete'])?$_REQUEST['staff_member_delete']:1







										],







										







										







												







						   "membership"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/membership-type.png'),







						              "menu_title"=>'Membership Type',







						              "page_link"=>'membership',







									 "own_data" => isset($_REQUEST['membership_own_data'])?$_REQUEST['membership_own_data']:0,







									 "add" => isset($_REQUEST['membership_add'])?$_REQUEST['membership_add']:1,







									 "edit"=>isset($_REQUEST['membership_edit'])?$_REQUEST['membership_edit']:1,







									 "view"=>isset($_REQUEST['membership_view'])?$_REQUEST['membership_view']:1,







									 "delete"=>isset($_REQUEST['membership_delete'])?$_REQUEST['membership_delete']:1







						  ],







									  







							"group"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/group.png'),







							        "menu_title"=>'Group',







									"page_link"=>'group',







									 "own_data" => isset($_REQUEST['group_own_data'])?$_REQUEST['group_own_data']:0,







									 "add" => isset($_REQUEST['group_add'])?$_REQUEST['group_add']:1,







									"edit"=>isset($_REQUEST['group_edit'])?$_REQUEST['group_edit']:1,







									"view"=>isset($_REQUEST['group_view'])?$_REQUEST['group_view']:1,







									"delete"=>isset($_REQUEST['group_delete'])?$_REQUEST['group_delete']:1







						  ],







									  







							  "member"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/member.png'),







							            "menu_title"=>'Member',







										"page_link"=>'member',







										"own_data" => isset($_REQUEST['member_own_data'])?$_REQUEST['member_own_data']:0,







										 "add" => isset($_REQUEST['member_add'])?$_REQUEST['member_add']:0,







										 "edit"=>isset($_REQUEST['member_edit'])?$_REQUEST['member_edit']:0,







										"view"=>isset($_REQUEST['member_view'])?$_REQUEST['member_view']:1,







										"delete"=>isset($_REQUEST['member_delete'])?$_REQUEST['member_delete']:0







							  ],







							  







							  "activity"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/activity.png'),







							             "menu_title"=>'Activity',







										 "page_link"=>'activity',







										 "own_data" => isset($_REQUEST['activity_own_data'])?$_REQUEST['activity_own_data']:0,







										 "add" => isset($_REQUEST['activity_add'])?$_REQUEST['activity_add']:1,







										"edit"=>isset($_REQUEST['activity_edit'])?$_REQUEST['activity_edit']:1,







										"view"=>isset($_REQUEST['activity_view'])?$_REQUEST['activity_view']:1,







										"delete"=>isset($_REQUEST['activity_delete'])?$_REQUEST['activity_delete']:1







							  ],







							  "class-schedule"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/class-schedule.png'),







							               "menu_title"=>'Class schedule',







										   "page_link"=>'class-schedule',







										 "own_data" => isset($_REQUEST['class_schedule_own_data'])?$_REQUEST['class_schedule_own_data']:0,







										 "add" => isset($_REQUEST['class_schedule_add'])?$_REQUEST['class_schedule_add']:1,







										"edit"=>isset($_REQUEST['class_schedule_edit'])?$_REQUEST['class_schedule_edit']:1,







										"view"=>isset($_REQUEST['class_schedule_view'])?$_REQUEST['class_schedule_view']:1,







										"delete"=>isset($_REQUEST['class_schedule_delete'])?$_REQUEST['class_schedule_delete']:1







							  ],







							  







							  "virtual_class"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/class-schedule.png'),							       







												 "menu_title"=>'Virtual class schedule',







												 "page_link"=>'virtual_class',







												 "own_data" => isset($_REQUEST['virtual_class_own_data'])?$_REQUEST['virtual_class_own_data']:0,







												 "add" => isset($_REQUEST['virtual_class_add'])?$_REQUEST['virtual_class_add']:1,







												"edit"=>isset($_REQUEST['virtual_class_edit'])?$_REQUEST['virtual_class_edit']:1,







												"view"=>isset($_REQUEST['virtual_class_view'])?$_REQUEST['virtual_class_view']:1,







												"delete"=>isset($_REQUEST['virtual_class_delete'])?$_REQUEST['virtual_class_delete']:1







									  ],















							    "attendence"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/attandance.png'),







								         "menu_title"=>'Attendence',







										 "page_link"=>'attendence',







										 "own_data" => isset($_REQUEST['attendence_own_data'])?$_REQUEST['attendence_own_data']:0,







										 "add" => isset($_REQUEST['attendence_add'])?$_REQUEST['attendence_add']:1,







										"edit"=>isset($_REQUEST['attendence_edit'])?$_REQUEST['attendence_edit']:1,







										"view"=>isset($_REQUEST['attendence_view'])?$_REQUEST['attendence_view']:1,







										"delete"=>isset($_REQUEST['attendence_delete'])?$_REQUEST['attendence_delete']:0







							  ],						  







							  







							    "assign-workout"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/assigne-workout.png'),







								         "menu_title"=>'Assigned Workouts',







										 "page_link"=>'assign-workout',







										 "own_data" => isset($_REQUEST['assign_workout_own_data'])?$_REQUEST['assign_workout_own_data']:0,







										 "add" => isset($_REQUEST['assign_workout_add'])?$_REQUEST['assign_workout_add']:1,







										"edit"=>isset($_REQUEST['assign_workout_edit'])?$_REQUEST['assign_workout_edit']:1,







										"view"=>isset($_REQUEST['assign_workout_view'])?$_REQUEST['assign_workout_view']:1,







										"delete"=>isset($_REQUEST['assign_workout_delete'])?$_REQUEST['assign_workout_delete']:1







							  ],







							   "nutrition"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/nutrition-schedule.png'),







							            "menu_title"=>'Nutrition Schedule',







										"page_link"=>'nutrition',







										 "own_data" => isset($_REQUEST['nutrition_own_data'])?$_REQUEST['nutrition_own_data']:0,







										 "add" => isset($_REQUEST['nutrition_add'])?$_REQUEST['nutrition_add']:1,







										"edit"=>isset($_REQUEST['nutrition_edit'])?$_REQUEST['nutrition_edit']:0,







										"view"=>isset($_REQUEST['nutrition_view'])?$_REQUEST['nutrition_view']:1,







										"delete"=>isset($_REQUEST['nutrition_delete'])?$_REQUEST['nutrition_delete']:1







							  ],







							    "workouts"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/workout.png'),







								         "menu_title"=>'Workouts',







										 "page_link"=>'workouts',







										 "own_data" => isset($_REQUEST['workouts_own_data'])?$_REQUEST['workouts_own_data']:0,







										 "add" => isset($_REQUEST['workouts_add'])?$_REQUEST['workouts_add']:1,







										"edit"=>isset($_REQUEST['workouts_edit'])?$_REQUEST['workouts_edit']:0,







										"view"=>isset($_REQUEST['workouts_view'])?$_REQUEST['workouts_view']:1,







										"delete"=>isset($_REQUEST['workouts_delete'])?$_REQUEST['workouts_delete']:0







							  ],







							    "accountant"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/accountant.png'),







								          "menu_title"=>'Accountant',







										  "page_link"=>'accountant',







										 "own_data" => isset($_REQUEST['accountant_own_data'])?$_REQUEST['accountant_own_data']:0,







										 "add" => isset($_REQUEST['accountant_add'])?$_REQUEST['accountant_add']:0,







										"edit"=>isset($_REQUEST['accountant_edit'])?$_REQUEST['accountant_edit']:0,







										"view"=>isset($_REQUEST['accountant_view'])?$_REQUEST['accountant_view']:1,







										"delete"=>isset($_REQUEST['accountant_delete'])?$_REQUEST['accountant_delete']:0







							  ],







							  







							  "membership_payment"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/fee.png'),







							             "menu_title"=>'Fee Payment',







										 "page_link"=>'membership_payment',







										 "own_data" => isset($_REQUEST['membership_payment_own_data'])?$_REQUEST['membership_payment_own_data']:0,







										 "add" => isset($_REQUEST['membership_payment_add'])?$_REQUEST['membership_payment_add']:0,







										"edit"=>isset($_REQUEST['membership_payment_edit'])?$_REQUEST['membership_payment_edit']:0,







										"view"=>isset($_REQUEST['membership_payment_view'])?$_REQUEST['membership_payment_view']:0,







										"delete"=>isset($_REQUEST['membership_payment_delete'])?$_REQUEST['membership_payment_delete']:0







							  ],







							  







							  "payment"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/payment.png'),







							             "menu_title"=>'Payment',







										 "page_link"=>'payment',







										 "own_data" => isset($_REQUEST['payment_own_data'])?$_REQUEST['payment_own_data']:0,







										 "add" => isset($_REQUEST['payment_add'])?$_REQUEST['payment_add']:0,







										"edit"=>isset($_REQUEST['payment_edit'])?$_REQUEST['payment_edit']:0,







										"view"=>isset($_REQUEST['payment_view'])?$_REQUEST['payment_view']:0,







										"delete"=>isset($_REQUEST['payment_delete'])?$_REQUEST['payment_delete']:0







							  ],







							  "product"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/products.png'),







							           "menu_title"=>'Product',







									   "page_link"=>'product',







										 "own_data" => isset($_REQUEST['product_own_data'])?$_REQUEST['product_own_data']:0,







										 "add" => isset($_REQUEST['product_add'])?$_REQUEST['product_add']:1,







										"edit"=>isset($_REQUEST['product_edit'])?$_REQUEST['product_edit']:1,







										"view"=>isset($_REQUEST['product_view'])?$_REQUEST['product_view']:1,







										"delete"=>isset($_REQUEST['product_delete'])?$_REQUEST['product_delete']:1







							  ],







							  "store"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/store.png'),







							              "menu_title"=>'Store',







										  "page_link"=>'store',







										 "own_data" => isset($_REQUEST['store_own_data'])?$_REQUEST['store_own_data']:0,







										 "add" => isset($_REQUEST['store_add'])?$_REQUEST['store_add']:1,







										"edit"=>isset($_REQUEST['store_edit'])?$_REQUEST['store_edit']:0,







										"view"=>isset($_REQUEST['store_view'])?$_REQUEST['store_view']:1,







										"delete"=>isset($_REQUEST['store_delete'])?$_REQUEST['store_delete']:0







							  ],







							  "news_letter"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/newsletter.png'),







							            "menu_title"=>'Newsletter',







										"page_link"=>'news_letter',







										 "own_data" => isset($_REQUEST['news_letter_own_data'])?$_REQUEST['news_letter_own_data']:0,







										 "add" => isset($_REQUEST['news_letter_add'])?$_REQUEST['news_letter_add']:0,







										"edit"=>isset($_REQUEST['news_letter_edit'])?$_REQUEST['news_letter_edit']:0,







										"view"=>isset($_REQUEST['news_letter_view'])?$_REQUEST['news_letter_view']:1,







										"delete"=>isset($_REQUEST['news_letter_delete'])?$_REQUEST['news_letter_delete']:0







							  ],







							  "message"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/message.png'),







							             "menu_title"=>'Message',







										 "page_link"=>'message',







										 "own_data" => isset($_REQUEST['message_own_data'])?$_REQUEST['message_own_data']:1,







										 "add" => isset($_REQUEST['message_add'])?$_REQUEST['message_add']:1,







										"edit"=>isset($_REQUEST['message_edit'])?$_REQUEST['message_edit']:0,







										"view"=>isset($_REQUEST['message_view'])?$_REQUEST['message_view']:1,







										"delete"=>isset($_REQUEST['message_delete'])?$_REQUEST['message_delete']:1







							  ],







							  







							   "notice"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/notice.png'),







							           "menu_title"=>'Notice',







									   "page_link"=>'notice',







										 "own_data" => isset($_REQUEST['notice_own_data'])?$_REQUEST['notice_own_data']:1,







										 "add" => isset($_REQUEST['notice_add'])?$_REQUEST['notice_add']:0,







										"edit"=>isset($_REQUEST['notice_edit'])?$_REQUEST['notice_edit']:0,







										"view"=>isset($_REQUEST['notice_view'])?$_REQUEST['notice_view']:1,







										"delete"=>isset($_REQUEST['notice_delete'])?$_REQUEST['notice_delete']:0







							  ],







							  							  







							   "reservation"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/reservation.png'),							       







								         "menu_title"=>'Reservation',







										 "page_link"=>'reservation',







										 "own_data" => isset($_REQUEST['reservation_own_data'])?$_REQUEST['reservation_own_data']:0,







										 "add" => isset($_REQUEST['reservation_add'])?$_REQUEST['reservation_add']:1,







										"edit"=>isset($_REQUEST['reservation_edit'])?$_REQUEST['reservation_edit']:1,







										"view"=>isset($_REQUEST['reservation_view'])?$_REQUEST['reservation_view']:1,







										"delete"=>isset($_REQUEST['reservation_delete'])?$_REQUEST['reservation_delete']:1







							  ],







							  







							  "report"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/reports.png'),							       







										"menu_title"=>'Report',







										"page_link"=>'report',







										"own_data" => isset($_REQUEST['report_own_data'])?esc_attr($_REQUEST['report_own_data']):0,







										"add" => isset($_REQUEST['report_add'])?esc_attr($_REQUEST['report_add']):0,







										"edit"=>isset($_REQUEST['report_edit'])?esc_attr($_REQUEST['report_edit']):0,







										"view"=>isset($_REQUEST['report_view'])?esc_attr($_REQUEST['report_view']):1,







										"delete"=>isset($_REQUEST['report_delete'])?esc_attr($_REQUEST['report_delete']):0







								],







								







							   "account"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/account.png'),







							              "menu_title"=>'Account',







										  "page_link"=>'account',







										 "own_data" => isset($_REQUEST['account_own_data'])?$_REQUEST['account_own_data']:0,







										 "add" => isset($_REQUEST['account_add'])?$_REQUEST['account_add']:0,







										"edit"=>isset($_REQUEST['account_edit'])?$_REQUEST['account_edit']:1,







										"view"=>isset($_REQUEST['account_view'])?$_REQUEST['account_view']:1,







										"delete"=>isset($_REQUEST['account_delete'])?$_REQUEST['account_delete']:0







							  ],







							  "tax"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/setting.png'),							       







											"menu_title"=>'Tax',







											"page_link"=>'tax',







											"own_data" => isset($_REQUEST['tax_own_data'])?esc_attr($_REQUEST['tax_own_data']):0,







											"add" => isset($_REQUEST['tax_add'])?esc_attr($_REQUEST['tax_add']):1,







											"edit"=>isset($_REQUEST['tax_edit'])?esc_attr($_REQUEST['tax_edit']):1,







											"view"=>isset($_REQUEST['tax_view'])?esc_attr($_REQUEST['tax_view']):1,







											"delete"=>isset($_REQUEST['tax_delete'])?esc_attr($_REQUEST['tax_delete']):1







								],







							  "sms_setting"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/sms_setting.png'),							       







										"menu_title"=>'SMS Setting',







										"page_link"=>'sms_setting',







										"own_data" => isset($_REQUEST['sms_setting_own_data'])?esc_attr($_REQUEST['sms_setting_own_data']):0,







										"add" => isset($_REQUEST['sms_setting_add'])?esc_attr($_REQUEST['sms_setting_add']):0,







										"edit"=>isset($_REQUEST['sms_setting_edit'])?esc_attr($_REQUEST['sms_setting_edit']):0,







										"view"=>isset($_REQUEST['sms_setting_view'])?esc_attr($_REQUEST['sms_setting_view']):1,







										"delete"=>isset($_REQUEST['sms_setting_delete'])?esc_attr($_REQUEST['sms_setting_delete']):0







								],















							   "subscription_history"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/subscription_history.png'),







							             "menu_title"=>'Membership History',







										 "page_link"=>'subscription_history',







										 "own_data" => isset($_REQUEST['subscription_history_own_data'])?$_REQUEST['subscription_history_own_data']:0,







										 "add" => isset($_REQUEST['subscription_history_add'])?$_REQUEST['subscription_history_add']:0,







										"edit"=>isset($_REQUEST['subscription_history_edit'])?$_REQUEST['subscription_history_edit']:0,







										"view"=>isset($_REQUEST['subscription_history_view'])?$_REQUEST['subscription_history_view']:1,







										"delete"=>isset($_REQUEST['subscription_history_delete'])?$_REQUEST['subscription_history_delete']:0







							],















							"mail_template"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/mail_template.png'),							       







												"menu_title"=>'Mail Template',







												"page_link"=>'mail_template',







												"own_data" => isset($_REQUEST['mail_template_own_data'])?esc_attr($_REQUEST['mail_template_own_data']):0,







												"add" => isset($_REQUEST['mail_template_add'])?esc_attr($_REQUEST['mail_template_add']):0,







												"edit"=>isset($_REQUEST['mail_template_edit'])?esc_attr($_REQUEST['mail_template_edit']):0,







												"view"=>isset($_REQUEST['mail_template_view'])?esc_attr($_REQUEST['mail_template_view']):1,







												"delete"=>isset($_REQUEST['mail_template_delete'])?esc_attr($_REQUEST['mail_template_delete']):0







										]







			];	







		$dashboard_card_access_for_member = array();



		$dashboard_card_access_for_member = [



				"gmgt_accountant" => isset($_REQUEST['account_card'])?esc_attr($_REQUEST['account_card']):"yes",



				"gmgt_staff" => isset($_REQUEST['staff_card'])?esc_attr($_REQUEST['staff_card']):"yes",



				"gmgt_notices" => isset($_REQUEST['notice_card'])?esc_attr($_REQUEST['notice_card']):"yes",



				"gmgt_messages" => isset($_REQUEST['message_card'])?esc_attr($_REQUEST['message_card']):"yes",



				"gmgt_member_status_chart" => isset($_REQUEST['member_status_enable'])?esc_attr($_REQUEST['member_status_enable']):"yes",



				"gmgt_invoice_chart" => isset($_REQUEST['invoice_enable'])?esc_attr($_REQUEST['invoice_enable']):"yes",



			];







		$dashboard_card_access_for_staffmember = array();



		$dashboard_card_access_for_staffmember = [



				"gmgt_accountant" => isset($_REQUEST['account_card_staff'])?esc_attr($_REQUEST['account_card_staff']):"yes",



				"gmgt_staff" => isset($_REQUEST['staff_card_staff'])?esc_attr($_REQUEST['staff_card_staff']):"yes",



				"gmgt_notices" => isset($_REQUEST['notice_card_staff'])?esc_attr($_REQUEST['notice_card_staff']):"yes",



				"gmgt_messages" => isset($_REQUEST['message_card_staff'])?esc_attr($_REQUEST['message_card_staff']):"yes",



				"gmgt_member_status_chart" => isset($_REQUEST['member_status_enable_staff'])?esc_attr($_REQUEST['member_status_enable_staff']):"yes",



				"gmgt_invoice_chart" => isset($_REQUEST['invoice_enable_staff'])?esc_attr($_REQUEST['invoice_enable_staff']):"yes",



			];







		$dashboard_card_access_for_accountant = array();



		$dashboard_card_access_for_accountant = [



				"gmgt_accountant" => isset($_REQUEST['account_card_accountant'])?esc_attr($_REQUEST['account_card_accountant']):"yes",



				"gmgt_staff" => isset($_REQUEST['staff_card_accountant'])?esc_attr($_REQUEST['staff_card_accountant']):"yes",



				"gmgt_notices" => isset($_REQUEST['notice_card_accountant'])?esc_attr($_REQUEST['notice_card_accountant']):"yes",



				"gmgt_messages" => isset($_REQUEST['message_card_accountant'])?esc_attr($_REQUEST['message_card_accountant']):"yes",



				"gmgt_member_status_chart" => isset($_REQUEST['member_status_enable_accountant'])?esc_attr($_REQUEST['member_status_enable_accountant']):"yes",



				"gmgt_invoice_chart" => isset($_REQUEST['invoice_enable_accountant'])?esc_attr($_REQUEST['invoice_enable_accountant']):"yes",



			];







			/* SETUP WIZARD OPTIONS */



			$gmgt_setup_wizard_step = array(



				"step1_system_setting" => "no",



				"step2_membership" => "no",



				"step3_staff" => "no",



				"step4_activity" => "no",



				"step5_class" => "no",



				"step6_member" => "no");







				/* SETUP WIZARD STEPS */



				$wizard_option = get_option('gmgt_setup_wizard_step');



				if(empty($wizard_option)){



					$wizard_option = add_option('gmgt_setup_wizard_step',$gmgt_setup_wizard_step);



				}



				/* SETUP WIZARD STATUS */



				$gmgt_setup_wizard_status = 'no';







		$options=array("gmgt_system_name"=> esc_html__( 'Gym Management System' ,'gym_mgt'),







					"gmgt_staring_year"=>"2023",







					"gmgt_gym_address"=>"A 206, Shapath Hexa, S G Road",







					"gmgt_contact_number"=>"9999999999",







					"gmgt_alternate_contact_number"=>"8888888888",







					"gmgt_contry"=>"India",







					"gmgt_email"=>get_option('admin_email'),







					"gmgt_datepicker_format"=>'yy/mm/dd',







					// "gmgt_system_logo"=>plugins_url( 'gym-management/assets/images/dashboard_icon/Thumbnail-img.png' ),







					"gmgt_system_logo"=>plugins_url( 'gym-management/assets/images/app_logo.png' ),







					







					"gmgt_group_logo"=>plugins_url( 'gym-management/assets/images/thumb_icon/gym-Group.png' ),







					"gmgt_member_logo"=>plugins_url( 'gym-management/assets/images/thumb_icon/gym-Member.png' ),







					"gmgt_Staffmember_logo"=>plugins_url( 'gym-management/assets/images/thumb_icon/gym-Staffmember.png' ),







					"gmgt_Account_logo"=>plugins_url( 'gym-management/assets/images/thumb_icon/gym-Account.png' ),







					"gmgt_Membership_logo"=>plugins_url( 'gym-management/assets/images/thumb_icon/gym-Membership.png' ),







					"gmgt_Product_logo"=>plugins_url( 'gym-management/assets/images/thumb_icon/gym-Product.png' ),















					"biglogo"=>plugins_url( 'gym-management/assets/images/WP_gym_logo.png' ),







					"gmgt_gym_background_image"=>plugins_url('gym-management/assets/images/gym-background.png' ),







					"gmgt_gym_other_data_logo"=>plugins_url('gym-management/assets/images/thumb_icon/invoice_thumb.png' ),







					"gmgt_instructor_thumb"=>plugins_url( 'gym-management/assets/images/useriamge/instructor.png' ),







					"gmgt_member_thumb"=>plugins_url( 'gym-management/assets/images/useriamge/member.png' ),







					







					"gmgt_invoice_thumb"=>plugins_url( 'gym-management/assets/images/thumb_icon/invoice_thumb.png' ),



					"gmgt_workout_image_thumb"=>plugins_url( 'gym-management/assets/images/thumb_icon/GYM_LOGO.png' ),







					"gmgt_assistant_thumb"=>plugins_url( 'gym-management/assets/images/useriamge/assistant.png' ),







					







					"gmgt_accountant_thumb"=>plugins_url( 'gym-management/assets/images/useriamge/accountant.png' ),







					"gmgt_no_data_img"=>plugins_url( 'gym-management/assets/images/thumb_icon/Plus-icon.png' ),







					







					"gmgt_assign_workout_thumb"=>plugins_url( 'gym-management/assets/images/thumb_icon/assign_workout.png' ),







					"gmgt_measurement_thumb"=>plugins_url( 'gym-management/assets/images/thumb_icon/measurement.png' ),







					"gmgt_nutrition_thumb"=>plugins_url( 'gym-management/assets/images/thumb_icon/nutrition.png' ),







					







					"gmgt_mailchimp_api"=>"",







					"gmgt_sms_service"=>"",







					"gmgt_sms_service_enable"=> 0,					







					"gmgt_clickatell_sms_service"=>array(),







					"gmgt_twillo_sms_service"=>array(),







					"gmgt_weight_unit"=>'KG',







					"gmgt_height_unit"=>'Centimeter',







					"gmgt_chest_unit"=>'Inches',







					"gmgt_waist_unit"=>'Inches',







					"gmgt_thigh_unit"=>'Inches',







					"gmgt_arms_unit"=>'Inches',







					"gmgt_fat_unit"=>'Percentage',







					"gmgt_paypal_email"=>'',







					"gym_enable_sandbox"=>'yes',







					"pm_payment_method"=>'paypal',







					"gmgt_currency_code" => 'USD',







					"gym_enable_membership_alert_message" => 'yes',







					"gym_enable_membership_expired_message" => 'yes',







					"gmgt_reminder_before_days" => '20',







					"gmgt_bank_holder_name"=>"",







					"gmgt_bank_name"=>"",







					"gmgt_bank_acount_number"=>"",







					"gmgt_bank_ifsc_code"=>"",







					"gmgt_mailchimp_api"=>"",







					"gym_enable_past_attendance"=>"no",







					"gym_enable_Registration_Without_Payment"=>"no",







					"gym_enable_datepicker_privious_date"=>"no",







					"gym_frontend_class_booking"=>"yes",







					"gym_class_cancel_booking"=>"yes",







					"gmgt_member_approve"=>"no",







					"gym_cancel_before_time"=>"1",







					"gmgt_one_time_payment_setting"=>"0",







					"gmgt_virtual_classschedule_client_id"=>"",







					"gmgt_virtual_classschedule_client_secret_id"=>"",







					"gmgt_virtual_classschedule_access_token"=>"",







					"gmgt_enable_virtual_class_reminder"=>"yes",







					"gmgt_virtual_class_reminder_before_time"=>"30",







					"gym_recurring_invoice_enable"=>"",







					"gmgt_stripe_secret_key"=>"",







					"gmgt_stripe_publishable_key"=>"",







					"gmgt_stripe_product_id"=>"",







					"gmgt_stripe_webhook_create"=>"",







					"gmgt_footer_description" => "Copyright ©2023 Mojoomla. All rights reserved.",







					"gmgt_access_right_member"=>$access_right_member,				







					"gmgt_access_right_staff_member"=>$access_right_staff_member,				







					"gmgt_access_right_accountant"=>$access_right_accountant,		







					"gmgt_access_right_management"=>$access_right_management,	



                    "gmgt_expired_due_day"=>15,					



                    "gmgt_heder_enable"=>'yes',					



					"gmgt_dashboard_card_for_member" => $dashboard_card_access_for_member,	



					"gmgt_dashboard_card_for_staffmember" => $dashboard_card_access_for_staffmember,	



					"dashboard_card_access_for_accountant" => $dashboard_card_access_for_accountant,



					"gmgt_setup_wizard_status" => $gmgt_setup_wizard_status,



					"gmgt_heder_enable"=> "no",	







		/* GYM REMAINDER MESSAGE */



		"gym_reminder_message" => 'Hello [GMGT_MEMBERNAME],







 Your [GMGT_MEMBERSHIP]  started at [GMGT_STARTDATE] and it will be expire on [GMGT_ENDDATE] .







Regard



[GMGT_GYM_NAME]',







	  "gmgt_reminder_subject" => 'Membership expire reminder at [GMGT_GYM_NAME]',







	  /* GYM EXPIRE MESSAGE */



	  "gym_expire_message" => 'Hello [GMGT_MEMBERNAME],







 Your [GMGT_MEMBERSHIP]  started at [GMGT_STARTDATE] and it has been expired on [GMGT_ENDDATE] .







Regard



[GMGT_GYM_NAME]',







	  "gmgt_expire_subject" => 'Membership expired at [GMGT_GYM_NAME]',







		/* MEMBER REGISTRATION TEMPLATE */



		'registration_title'=>'You are successfully registered at [GMGT_GYM_NAME]',







		'registration_mailtemplate'=>'Dear [GMGT_MEMBERNAME] ,

        You are successfully registered at [GMGT_GYM_NAME] .Your member id is [GMGT_MEMBERID] .Your  Membership name is [GMGT_MEMBERSHIP] .Your Membership start date is [GMGT_STARTDATE] .Your Membership end date is [GMGT_ENDDATE] .You can access your account after admin approval. [BARCODE_URL]
		<img src="[BARCODE_URL]" height="200" width="200">

Email Id : [EMAIL_ID]
Password : [PASSWORD]

Regards From [GMGT_GYM_NAME].',


		/* MEMBER APPROVED TEMPLATE */



		'Member_Approved_Template_Subject'=>'You profile has been approved by admin at [GMGT_GYM_NAME]',







		'Member_Approved_Template'=>'Dear [GMGT_MEMBERNAME],







         You are successfully registered at [GMGT_GYM_NAME].You profile has been approved by admin and you can sign in using this link. [GMGT_LOGIN_LINK] . <img src="[BARCODE_URL]" height="200" width="200">







Regards From [GMGT_GYM_NAME].',











		/* ADD OTHER USER IN SYSTEM TEMPLATE */



		'Add_Other_User_in_System_Subject'=>'Your have been assigned role of [GMGT_ROLE_NAME] in [GMGT_GYM_NAME] ',







		'Add_Other_User_in_System_Template'=>'Dear [GMGT_USERNAME],







         You are Added by admin of [GMGT_GYM_NAME].Your have been assigned role of [GMGT_ROLE_NAME] in [GMGT_GYM_NAME]. You can access system using your username and password.  You can signin using this link.[GMGT_LOGIN_LINK] 


<img src="[BARCODE_URL]" height="200" width="200">




Email Id : [GMGT_Username].







Password : [GMGT_PASSWORD].







Regards From [GMGT_GYM_NAME].',











		/* ADD NOTICE TEMPLATE */



		'Add_Notice_Subject'=>'New Notice from [GMGT_USERNAME] at [GMGT_GYM_NAME] ',







		'Add_Notice_Template'=>'Dear [GMGT_USERNAME] ,







         Here is the new Notice from  [GMGT_MEMBERNAME].







Title : [GMGT_NOTICE_TITLE].







Notice For: [GMGT_NOTICE_FOR].







Notice Start Date : Notice [GMGT_STARTDATE].







Notice End Date : Notice [GMGT_ENDDATE].







Description : Notice [GMGT_COMMENT].







View Notice Click [GMGT_NOTICE_LINK]







Regards From [GMGT_GYM_NAME] .',











		/* MEMBER ADDED IN GROUP TEMPLATE */



		'Member_Added_In_Group_subject'=>'You are added in [GMGT_GROUPNAME] at [GMGT_GYM_NAME] ',







		'Member_Added_In_Group_Template'=>'Dear [GMGT_USERNAME],







         You are added in [GMGT_GROUPNAME] . 







Regards From [GMGT_GYM_NAME] .',











		/* ASSIGN WORKOUTS TEMPLATE */



		'Assign_Workouts_Subject'=>'New workouts assigned to you at [GMGT_GYM_NAME] ',







		'Assign_Workouts_Template'=>'Dear [GMGT_MEMBERNAME],







         You have assigned new workouts for [GMGT_STARTDATE] To [GMGT_ENDDATE] .We have also attached your schedule.For View  Workout  [GMGT_PAGE_LINK]







Regards From [GMGT_GYM_NAME] .',











		/* ADD RESERVATION TEMPLATE */



		'Add_Reservation_Subject'=>' [GMGT_EVENT_PLACE] have been Successfully reserved for you for [GMGT_EVENT_NAME] on [GMGT_EVENT_DATE] And [GMGT_START_TIME] ',







		'Add_Reservation_Template'=>'Dear [GMGT_STAFF_MEMBERNAME],







		[GMGT_EVENT_PLACE] has been successfully booked for you. This place booked for [GMGT_EVENT_NAME] on [GMGT_EVENT_DATE] And [GMGT_START_TIME] . 







Event Name: [GMGT_EVENT_NAME].







Event Date : [GMGT_EVENT_DATE].







Event Place: [GMGT_EVENT_PLACE].







Event Start Time: [GMGT_START_TIME]. 







Event EndTime: [GMGT_END_TIME].







[GMGT_PAGE_LINK] 







Regards From [GMGT_GYM_NAME] .',











		/* ASSIGN NUTRITION SCHEDULE TEMPLATE */



		'Assign_Nutrition_Schedule_Subject'=>'New Nutrition Schedule assigned to you at [GMGT_GYM_NAME] ',







		'Assign_Nutrition_Schedule_Template'=>'Dear [GMGT_MEMBERNAME],







        You have assigned new nutrition schedule for [GMGT_STARTDATE] To [GMGT_ENDDATE]. We have also attached your schedule.For View Nutrition  [GMGT_PAGE_LINK]







Regards From [GMGT_GYM_NAME].',











		/* SUBMIT WORKOUT TEMPLATE */



		'Submit_Workouts_Subject'=>'Complete Workout Detail',







		'Submit_Workouts_Template'=>'Dear [GMGT_STAFF_MEMBERNAME] ,







		[GMGT_USERNAME] has completed my workout of [GMGT_DAY_NAME] on [GMGT_DATE] . Attached details of workouts. 







Regards From [GMGT_GYM_NAME].',



		/* SUBMIT WORKOUT TEMPLATE FOR MEMBER */

		'Submit_Workouts_Subject_for_member'=>'Complete Workout Detail',

		'Submit_Workouts_Template_for_member'=>'Dear [GMGT_USERNAME] ,

		You have completed workout of [GMGT_DAY_NAME] on [GMGT_DATE] . Attached details of workouts. 
 
 Regards From [GMGT_GYM_NAME].',

		/* SELL PRODUCT TEMPLATE */



		'sell_product_subject'=>'You have purchased new product from  [GMGT_GYM_NAME]',







		'sell_product_template'=>'Dear [GMGT_USERNAME], 







		Your have purchased products.  You can check the product  Invoice attached here. 







Regards From [GMGT_GYM_NAME] .',











		/* GENERATE INVOICE TEMPLATE */



		'generate_invoice_subject'=>'You have a new invoice from [GMGT_GYM_NAME]',







		'generate_invoice_template'=>'Dear [GMGT_USERNAME],







        Your have a new Fees invoice. You can check the invoice attached here. For payment click [GMGT_PAYMENT_LINK]







Regards From [GMGT_GYM_NAME].',











		/* ADD INVOICE TEMPLATE */



		'add_income_subject'=>'You have a new Payment Invoice raised by [GMGT_ROLE_NAME] at [GMGT_GYM_NAME]',







		'add_income_template'=>'Dear [GMGT_USERNAME],







        You have a new Payment Invoice raised by Admin. You can check the Invoice attached here.







Regards From [GMGT_GYM_NAME].',











		/* PAYMENT RECEIVED AGAINST INVOICE TEMPLATE */



		'payment_received_against_invoice_subject'=>'Your have successfully paid your invoice at [GMGT_GYM_NAME]',







		'payment_received_against_invoice_template'=>'Dear [GMGT_USERNAME],







        You have successfully paid your invoice.  You can check the invoice attached here.







Regards From [GMGT_GYM_NAME].',











		/* MESSAGE RECEIVED TEMPLATE */



		'message_received_subject'=>'You have received new message from [GMGT_SENDER_NAME]  at [GMGT_GYM_NAME]',







		'message_received_template'=>'Dear [GMGT_RECEIVER_NAME],







         You have received new message from [GMGT_SENDER_NAME]. [GMGT_MESSAGE_CONTENT].







Regards From [GMGT_GYM_NAME].',







//-----------------  Payment Reminder Mail ---------------------//







'payment_reminder_subject'=>'Membership Payment Reminder',







'payment_reminder_template'=>'







Dear {{GMGT_RECEIVER_NAME}},







We just wanted to send you a reminder that the membership payment has not been paid. the total amount is {{GMGT_TOTOAL_AMOUNT}} and the due amount is {{GMGT_DUE_AMOUNT}}.







Regards From 



{{GMGT_GYM_NAME}}',











//-----------------  Payment Reminder Mail ---------------------//







// -------------------- Invoice Payment Reminder Mail --------------------//















'invoice_payment_reminder_subject'=>'Invoice Payment Reminder',







'invoice_payment_reminder_template'=>'







Dear {{GMGT_RECEIVER_NAME}},







We just wanted to send you a reminder that the Invoice payment has not been paid. the total amount is {{GMGT_TOTOAL_AMOUNT}} and the due amount is {{GMGT_DUE_AMOUNT}}.







Regards From 



{{GMGT_GYM_NAME}}',















// -------------------- Invoice Payment Reminder Mail --------------------//











//----------------------- VIRTUAL CLASSROOM TEACHER INVITE MAIL ------//







'virtual_class_invite_staff_mail_subject'=>'Inviting you to a scheduled Zoom meeting',







'virtual_class_invite_staff_mail_content'=>'Inviting you to a scheduled Zoom meeting







	Class Name : {{class_name}}







	Time : {{time}}







	Virtual Class ID : {{virtual_class_id}}







	Password : {{password}}







	Join Zoom Virtual Class : {{join_zoom_virtual_class}}







	Start Zoom Virtual Class : {{start_zoom_virtual_class}}







	Regards From {{GMGT_GYM_NAME}}







',















//----------------------- VIRTUAL CLASSROOM STAFF REMINDER MAIL ------//







'virtual_class_staff_reminder_mail_subject'=>'Your virtual class just start',







'virtual_class_staff_reminder_mail_content'=>'Dear {{staff_name}}







	Your virtual class just start







	Class Name : {{class_name}}







	Date : {{date}}







	Time : {{time}}







	Virtual Class ID : {{virtual_class_id}}







	Password : {{password}}







	{{start_zoom_virtual_class}}







	Regards From {{GMGT_GYM_NAME}}







',







//----------------------- VIRTUAL CLASSROOM MEMBER REMINDER MAIL ------//







'virtual_class_member_reminder_mail_subject'=>'Your virtual class just start',







'virtual_class_member_reminder_mail_content'=>'Dear {{member_name}}







	Your virtual class just start







	Class Name : {{class_name}}







	Staff Name : {{staff_name}}







	Date : {{date}}







	Time : {{time}}







	Virtual Class ID : {{virtual_class_id}}







	Password : {{password}}







	{{join_zoom_virtual_class}}







	Regards From {{GMGT_GYM_NAME}}







',















		);







		return $options;







}







add_action('admin_init','MJ_gmgt_general_setting');	







//ADD GENERAL SETTINGS OPTION FUNCTION







function MJ_gmgt_general_setting()







{







	$options=MJ_gmgt_option();







	foreach($options as $key=>$val)







	{







		add_option($key,$val); 







		







	}







}











//GET ALL SCRIPT PAGE IN ADMIN SIDE FUNCTION







function MJ_gmgt_call_script_page()







{







	$page_array = array('gmgt_system','gmgt_membership_type','gmgt_group','gmgt_staff','gmgt_accountant','gmgt_class','gmgt_member',







			'gmgt_product','gmgt_reservation','gmgt_attendence','MJ_gmgt_gmgt_taxes','MJ_gmgt_fees_payment','gmgt_coupon','MJ_gmgt_subscription','gmgt_payment','Gmgt_message','gmgt_newsletter','gmgt_activity',







			'gmgt_notice','gmgt_workouttype','gmgt_workout','gmgt_store','gmgt_nutrition','gmgt_report','gmgt_mail_template','gmgt_gnrl_settings','gmgt_access_right','gmgt_alumni','gmgt_prospect','gmgt_setup','gmgt_sms_setting','gmgt_virtual_class');







	return  $page_array;







}















//ADMIN SIDE CSS AND JS ADD FUNCTION







function MJ_gmgt_change_adminbar_css($hook)







{	







	$current_page = $_REQUEST['page'];







	$page_array = MJ_gmgt_call_script_page();







	if(in_array($current_page,$page_array))







    {	















		wp_enqueue_script('jquery-ui-datepicker');	







    	wp_enqueue_script('MJgmgt-popper-js', plugins_url( '/assets/js/popper.min.js', __FILE__ ) );







    				







		wp_register_script( 'MJ_gmgt_jquery-3-6-0', plugins_url( '/assets/js/jquery-3-6-0.js', __FILE__), array( 'jquery' ) );







		wp_enqueue_script( 'MJ_gmgt_jquery-3-6-0' );







		







		wp_enqueue_style( 'MJ_gmgt_accordian-jquery-ui-css', plugins_url( '/assets/accordian/jquery-ui.css', __FILE__) );		







		







		wp_enqueue_script('MJ_gmgt_accordian-jquery-ui', plugins_url( '/assets/accordian/jquery-ui.js',__FILE__ ));







		wp_enqueue_script('MJ_gmgt_jquery-ui-lan', plugins_url( '/assets/js/jquery-ui-lan.min.js',__FILE__ ));



		wp_enqueue_script('workout_activity', plugins_url( '/assets/js/workout_activity.js',__FILE__ ));











		wp_enqueue_style( 'MJgmgt-calender-css', plugins_url( '/assets/css/fullcalendar.css', __FILE__) );







		wp_enqueue_style( 'MJgmgt-datatable-css', plugins_url( '/assets/css/dataTables.css', __FILE__) );







		wp_enqueue_style( 'MJgmgt-dataTables.responsive-css', plugins_url( '/assets/css/dataTables_responsive.css', __FILE__) );







		







		wp_enqueue_style( 'MJgmgt-style-css', plugins_url( '/assets/css/style.css', __FILE__) );







		wp_enqueue_style( 'MJgmgt-dashboard-css', plugins_url( '/assets/css/dashboard.css', __FILE__) );















		//-- new design css  --//







		wp_enqueue_style( 'MJgmgt-new_style-css', plugins_url( '/assets/css/new_style.css', __FILE__) );







		wp_enqueue_style( 'MJgmgt-responsive_new_style-css', plugins_url( '/assets/css/responsive_new_design.css', __FILE__) );







		//-- new design css End  --//







		//metrial design css & js start --//







			wp_enqueue_style( 'MJgmgt-bootstrap-inputs', plugins_url( '/assets/css/material/bootstrap-inputs.css', __FILE__) );







			// wp_enqueue_script('MJ_gmgt_material-min-js', plugins_url( '/assets/js/material/material.min.js',__FILE__ ));







		//End metrial design js End --//















		// poppins font family css 







		wp_enqueue_style( 'MJgmgt-poppins-fontfamily-css', plugins_url( '/assets/css/popping_font.css', __FILE__) );	







		// End  poppins font family css 















		wp_enqueue_style( 'MJgmgt-popup-css', plugins_url( '/assets/css/popup.css', __FILE__) );







		wp_enqueue_style( 'MJgmgt-custom-css', plugins_url( '/assets/css/custom.css', __FILE__) );







		wp_enqueue_style( 'MJgmgt-select2-css', plugins_url( '/lib/select2-3.5.3/select2.css', __FILE__) );







		







		wp_enqueue_script('MJgmgt-select2', plugins_url( '/lib/select2-3.5.3/select2_min.js', __FILE__ ));







		







		wp_enqueue_script('MJgmgt-calender_moment', plugins_url( '/assets/js/moment_min.js', __FILE__ ));







		wp_enqueue_script('MJgmgt-calender', plugins_url( '/assets/js/fullcalendar_min.js', __FILE__ ));







		wp_enqueue_script('MJgmgt-datatable', plugins_url( '/assets/js/jquery_dataTables_min.js',__FILE__ ));







		$lancode=get_locale();







		$code=substr($lancode,0,2);







		wp_enqueue_script('MJgmgt-calender-'.$code.'', plugins_url( '/assets/js/calendar-lang/'.$code.'.js', __FILE__ ));







		wp_enqueue_script('MJgmgt-datatable-tools', plugins_url( '/assets/js/dataTables_tableTools_min.js',__FILE__ ));







		wp_enqueue_script('MJgmgt-datatable-editor', plugins_url( '/assets/js/dataTables_editor_min.js',__FILE__ ));	







		wp_enqueue_script('MJgmgt-dataTables.responsive-js', plugins_url( '/assets/js/dataTables_responsive.js',__FILE__ ));	







		wp_enqueue_script('MJgmgt-customjs', plugins_url( '/assets/js/gmgt_custom.js', __FILE__ ));







		wp_enqueue_script('MJgmgt-popup', plugins_url( '/assets/js/popup.js', __FILE__ ));















		//Print pdf and column visible start







		wp_enqueue_script('gmgt-dataTables-buttons-min', plugins_url( '/assets/js/gmgt-dataTables-buttons-min.js', __FILE__ ), array( 'jquery' ), '4.1.1', true );







		wp_enqueue_style( 'gmgt-buttons-dataTables-min-css', plugins_url( '/assets/css/buttons.dataTables.min.css', __FILE__) );







		







	    wp_enqueue_script('jszip.min', plugins_url( '/assets/js/jszip.min.js', __FILE__ ), array( 'jquery' ), '3.1.3', true );







	







		wp_enqueue_script('dataTables.fixedColumns.min', plugins_url( '/assets/js/dataTables.fixedColumns.min.js', __FILE__ ), array( 'jquery' ), '3.3.2', true );







		wp_enqueue_script('gmgt-buttons-html5', plugins_url( '/assets/js/buttons.html5.min.js', __FILE__ ), array( 'jquery' ), '1.6.5', true );







		wp_enqueue_script('gmgt-buttons-colVis-min', plugins_url( '/assets/js/buttons.colVis.min.js', __FILE__ ), array( 'jquery' ), '1.7.0', true );







		//Print pdf and column visible end















			//--------- Print and PDF ------------------//







			wp_enqueue_script('gmgt-dataTables-buttons-min', plugins_url( '/assets/js/dataTables-buttons-min.js', __FILE__ ), array( 'jquery' ), '4.1.1', true );







			wp_enqueue_script('gmgt-buttons-print-min', plugins_url( '/assets/js/gmgt-buttons-print-min.js', __FILE__ ), array( 'jquery' ), '4.1.1', true );















			wp_enqueue_script('pdfmake-min', plugins_url( '/assets/js/pdfmake-min.js', __FILE__ ) );







			wp_enqueue_script('vfs_fonts', plugins_url( '/assets/js/vfs_fonts.js', __FILE__ ) );







			//--------- Print and PDF ------------------//















		







		//popup file alert msg languages translation//				







		wp_localize_script('MJgmgt-popup', 'language_translate', array(







				'product_out_of_stock_alert' => esc_html__( 'Product out of stock', 'gym_mgt' ),







				'select_one_membership_alert' => esc_html__( 'please select at least one member type', 'gym_mgt' ),







				'select_one_member_alert' => esc_html__( 'please select member.', 'gym_mgt' ),







				'select_one_day_alert' => esc_html__( 'Please Select Atleast One Day.', 'gym_mgt' ),







				'membership_member_limit_alert' => esc_html__( 'Membership member limit is full', 'gym_mgt' ),







				'sets_lable' => esc_html__( 'Sets', 'gym_mgt' ),







				'reps_lable' => esc_html__( 'Reps', 'gym_mgt' ),







				'kg_lable' => esc_html__( 'KG', 'gym_mgt' ),







				'rest_time_lable' => esc_html__( 'Rest Time', 'gym_mgt' ),







				'min_lable' => esc_html__( 'Min', 'gym_mgt' ),







				'assigned_workout_lable' => esc_html__( 'Assign Workout', 'gym_mgt' ),







				'days_lable' => esc_html__( 'Days', 'gym_mgt' ),







				'sunday_days' => esc_html__( 'Sunday', 'gym_mgt' ),







				'monday_days' => esc_html__( 'Monday', 'gym_mgt' ),







				'Tuesday_days' => esc_html__( 'Tuesday', 'gym_mgt' ),







				'Wednesday_days' => esc_html__( 'Wednesday', 'gym_mgt' ),







				'Thursday_days' => esc_html__( 'Thursday', 'gym_mgt' ),







				'Friday_days' => esc_html__( 'Friday', 'gym_mgt' ),







				'Saturday_days' => esc_html__( 'Saturday', 'gym_mgt' ),







				'nutrition_schedule_details_lable' => esc_html__( 'Nutrition Schedule Details', 'gym_mgt' ),







				'dinner_lable' => esc_html__( 'Dinner Nutrition', 'gym_mgt' ),







				'breakfast_lable' => esc_html__( 'Break Fast Nutrition', 'gym_mgt' ),







				'afternoon_snack_lable' => esc_html__( 'Afternoon Snacks', 'gym_mgt' ),







				'midmorning_snack_lable' => esc_html__( 'Mid Morning Snacks', 'gym_mgt' ),







				'lunch_lable' => esc_html__( 'Lunch Nutrition', 'gym_mgt' ),







				'membership_category_delete_record_alert' => esc_html__( 'Are you sure want to delete this record?', 'gym_mgt' ),







				'removenutrition_delete_record_alert' => esc_html__( 'Are you sure you want to delete this?', 'gym_mgt' ),







				'daily_workout_exercise_delete_alert' => esc_html__( 'Are you sure you want to delete this?', 'gym_mgt' ),







				'measurement_workout_delete_record_alert' => esc_html__( 'Are you sure you want to delete this record?', 'gym_mgt' ),







				'successfully_inserted_membership' => esc_html__( 'Successfully inserted!', 'gym_mgt' ),	







				'successfully_add_activity_membership' => esc_html__( 'Do you Want to Add New Activity?', 'gym_mgt' ),	







				'confirm_yes_activity_membership' => esc_html__( 'Yes', 'gym_mgt' ),	







				'confirm_no_activity_membership' => esc_html__( 'No', 'gym_mgt' ),







				'please_select_atleat_one_record' => esc_html__( 'Please select at least one record', 'gym_mgt' ),







				'already_selected_this_product' => esc_html__( 'You have already selected this product.', 'gym_mgt' )		















			)







		);







		//add page in ajax that use localize ajax page







		wp_localize_script( 'MJgmgt-popup', 'gmgt', array( 'ajax' => admin_url( 'admin-ajax.php' ) ) );







	 	wp_enqueue_script('jquery');







	 	wp_enqueue_media();







       	wp_enqueue_script('thickbox');







       	wp_enqueue_style('thickbox');







 







	 	wp_enqueue_script('MJgmgt-image-upload', plugins_url( '/assets/js/image-upload.js', __FILE__ ), array( 'jquery' ), '4.1.1', true );







	 







		//image upload file alert msg languages translation				







		wp_localize_script('MJgmgt-image-upload', 'language_translate1', array(







				'allow_file_alert' => esc_html__( 'Only (JPEG,JPG,GIF,PNG,BMP) File is allowed', 'gym_mgt' )						







			)







		);







		







		wp_enqueue_style( 'MJgmgt-bootstrap-css', plugins_url( '/assets/css/bootstrap_min.css', __FILE__) );







		wp_enqueue_style( 'MJgmgt-bootstrap-multiselect-css', plugins_url( '/assets/css/bootstrap-multiselect.css', __FILE__) );







	







	 	wp_enqueue_style( 'MJgmgt-font-awesome-css', plugins_url( '/assets/css/font-awesome_min.css', __FILE__) );







	 	wp_enqueue_style( 'MJgmgt-white-css', plugins_url( '/assets/css/white.css', __FILE__) );







	 	wp_enqueue_style( 'MJgmgt-gymmgt-min-css', plugins_url( '/assets/css/gymmgt_min.css', __FILE__) );







	 	wp_enqueue_style( 'MJgmgt-sweetalert-css', plugins_url( '/assets/css/sweetalert.css', __FILE__) );







		if (is_rtl())







		{







			wp_enqueue_style( 'MJgmgt-rtl-style-css', plugins_url( '/assets/css/new_design_rtl.css', __FILE__) );







			wp_enqueue_style( 'MJgmgt-bootstrap-rtl-css', plugins_url( '/assets/css/bootstrap-rtl_min.css', __FILE__) ); 







			//validation lib//







			wp_enqueue_style( 'MJgmgt-validate-css', plugins_url( '/lib/validationEngine/css/validationEngine_jquery.css', __FILE__) );	 	







			wp_register_script( 'MJgmgt-jquery-validationEngine-'.$code.'', plugins_url( '/lib/validationEngine/js/languages/jquery.validationEngine-'.$code.'.js', __FILE__), array( 'jquery' ) );







			wp_enqueue_script( 'MJgmgt-jquery-validationEngine-'.$code.'' );







			wp_register_script( 'MJgmgt-jquery-validationEngine', plugins_url( '/lib/validationEngine/js/jquery_validationEngine.js', __FILE__), array( 'jquery' ) );







			wp_enqueue_script( 'MJgmgt-jquery-validationEngine' );







			wp_enqueue_style( 'MJgmgt-custom-rtl-css', plugins_url( '/assets/css/custom_rtl.css', __FILE__) );







		}







		wp_enqueue_style( 'MJgmgt-gym-responsive-css', plugins_url( '/assets/css/gym-responsive.css', __FILE__) );







	 	wp_enqueue_script('MJgmgt-bootstrap-js', plugins_url( '/assets/js/bootstrap_min.js', __FILE__ ) );







	 	wp_enqueue_script('MJgmgt-bootstrap-multiselect-js', plugins_url( '/assets/js/bootstrap-multiselect.js', __FILE__ ) );







	 	







	 	wp_enqueue_script('MJgmgt-gym-js', plugins_url( '/assets/js/gymjs.js', __FILE__ ) );







		wp_enqueue_script('MJgmgt-slider-js', plugins_url( '/assets/js/jssor_slider_mini.js', __FILE__ ) );







		wp_enqueue_script('MJgmgt-sweetalert-dev-js', plugins_url( '/assets/js/sweetalert-dev.js', __FILE__ ) );







	 	//Validation style And Script







		//sweetalert2 CSS &JS//







		wp_enqueue_style( 'MJgmgt-sweetalert2-css', plugins_url( '/assets/css/sweetalert2.css', __FILE__) );



		wp_enqueue_script('MJgmgt-sweetalert2-js', plugins_url( '/assets/js/sweetalert2.js', __FILE__ ) );







	 	//validation lib//







		wp_enqueue_style( 'MJgmgt-validate-css', plugins_url( '/lib/validationEngine/css/validationEngine_jquery.css', __FILE__) );







	 	wp_register_script( 'MJgmgt-jquery-validationEngine-'.$code.'', plugins_url( '/lib/validationEngine/js/languages/jquery.validationEngine-'.$code.'.js', __FILE__), array( 'jquery' ) );







	 	wp_enqueue_script( 'MJgmgt-jquery-validationEngine-'.$code.'' );







	 	wp_register_script( 'MJgmgt-jquery-validationEngine', plugins_url( '/lib/validationEngine/js/jquery_validationEngine.js', __FILE__), array( 'jquery' ) );







	 	wp_enqueue_script( 'MJgmgt-jquery-validationEngine' );







	    wp_enqueue_script('MJgmgt-gmgt_custom_confilict_obj-js', plugins_url( '/assets/js/gmgt_custom_confilict_obj.js', __FILE__ ) );















	}







		







}







	if(isset($_REQUEST['page']))







	add_action( 'admin_enqueue_scripts', 'MJ_gmgt_change_adminbar_css' );







}

//FRONTEN SIDE GET USER DASHBOARD REQUEST FUNCTION

function MJ_gmgt_user_dashboard()
{

	if(isset($_REQUEST['dashboard']))
	{
		if (! is_user_logged_in ())
		{
			$page_id = get_option ( 'gmgt_login_page' );
			wp_redirect ( home_url () . "?page_id=" . $page_id );
		}
		else
		{
		   require_once GMS_PLUGIN_DIR. '/fronted_template.php';
		   exit;
		}
	}

}
//DOMAIN NAME LOAD FUNCTION
function MJ_gmgt_domain_load()







{







	load_plugin_textdomain( 'gym_mgt', false, dirname( plugin_basename( __FILE__ ) ). '/languages/' );







}















//LOAD SCRIPT FUNCTION







add_action('wp_enqueue_scripts','MJ_gmgt_load_script1');















function MJ_gmgt_load_script1()







{



	if(isset($_REQUEST['dashboard']) && $_REQUEST['dashboard'] == 'user')



	{



		wp_enqueue_style('dashboard-css',  plugins_url('/assets/css/dashboard.css', __FILE__), array(), rand(111,9999) );



		wp_register_script('MJgmgt-popup-front', plugins_url( 'assets/js/popup.js', __FILE__ ), array( 'jquery' ));



		wp_enqueue_script('MJgmgt-popup-front');



		//popup file alert msg languages translation//				



		 wp_localize_script('MJgmgt-popup-front', 'language_translate', array(



				'product_out_of_stock_alert' => esc_html__( 'Product out of stock', 'gym_mgt' ),



				'select_one_membership_alert' => esc_html__( 'please select at least one member type', 'gym_mgt' ),



				'select_one_member_alert' => esc_html__( 'please select member.', 'gym_mgt' ),



				'select_one_member_alert_new' => esc_html__( 'Please select at least one member', 'gym_mgt' ),



				'membership_member_limit_alert' => esc_html__( 'Membership member limit is full', 'gym_mgt' ),



				'sets_lable' => esc_html__( 'Sets', 'gym_mgt' ),



				'reps_lable' => esc_html__( 'Reps', 'gym_mgt' ),



				'kg_lable' => esc_html__( 'KG', 'gym_mgt' ),



				'rest_time_lable' => esc_html__( 'Rest Time', 'gym_mgt' ),



				'min_lable' => esc_html__( 'Min', 'gym_mgt' ),



				'assigned_workout_lable' => esc_html__( 'Assign Workout', 'gym_mgt' ),



				'days_lable' => esc_html__( 'Days', 'gym_mgt' ),



				'nutrition_schedule_details_lable' => esc_html__( 'Nutrition Schedule Details', 'gym_mgt' ),



				'dinner_lable' => esc_html__( 'Dinner Nutrition', 'gym_mgt' ),



				'breakfast_lable' => esc_html__('Break Fast Nutrition', 'gym_mgt' ),



				'afternoon_snack_lable' => esc_html__( 'Afternoon Snacks', 'gym_mgt' ),



				'midmorning_snack_lable' => esc_html__( 'Mid Morning Snacks', 'gym_mgt' ),



				'lunch_lable' => esc_html__( 'Lunch Nutrition', 'gym_mgt' ),



				'sunday_days' => esc_html__( 'Sunday', 'gym_mgt' ),



				'monday_days' => esc_html__( 'Monday', 'gym_mgt' ),



				'Tuesday_days' => esc_html__( 'Tuesday', 'gym_mgt' ),



				'Wednesday_days' => esc_html__( 'Wednesday', 'gym_mgt' ),



				'Thursday_days' => esc_html__( 'Thursday', 'gym_mgt' ),



				'Friday_days' => esc_html__( 'Friday', 'gym_mgt' ),



				'Saturday_days' => esc_html__( 'Saturday', 'gym_mgt' ),



				'measurement_workout_delete_record_alert' => esc_html__( 'Are you sure you want to delete this record?', 'gym_mgt' ),



				'daily_workout_exercise_delete_alert' => esc_html__( 'Are you sure you want to delete this?', 'gym_mgt' ),



				'membership_category_delete_record_alert' => esc_html__( 'Are you sure want to delete this record?', 'gym_mgt' ),						



			));



		wp_localize_script( 'MJgmgt-popup-front', 'gmgt  ', array( 'ajax' => admin_url( 'admin-ajax.php' ) ) );



		wp_enqueue_script('jquery');	



		wp_enqueue_style( 'MJgmgt-style-css', plugins_url( '/assets/css/style.css', __FILE__) );



		wp_enqueue_style('MJgmgt-dataTables-css', plugins_url('/assets/css/dataTables.css', __FILE__ )); 



		wp_enqueue_style('MJgmgt-dataTables_editor_min-css', plugins_url('/assets/css/dataTables_editor_min.css', __FILE__ )); 



		wp_enqueue_style('MJgmgt-dataTables_tableTools-css', plugins_url('/assets/css/dataTables_tableTools.css', __FILE__ )); 



		wp_enqueue_style('MJgmgt-dataTables_responsive-css', plugins_url('/assets/css/dataTables_responsive.css', __FILE__ )); 



		wp_enqueue_style('MJgmgt-jquery-ui-css', plugins_url('/assets/css/jquery-ui.css', __FILE__ )); 



		wp_enqueue_style('MJgmgt-font-awesome_min-css', plugins_url('/assets/css/font-awesome_min.css', __FILE__ )); 



		wp_enqueue_style('MJgmgt-popup-css', plugins_url('/assets/css/popup.css', __FILE__ )); 



		wp_enqueue_style('MJgmgt-custom-css', plugins_url('/assets/css/custom.css', __FILE__ )); 



		wp_enqueue_style('MJgmgt-fullcalendar-css', plugins_url('/assets/css/fullcalendar.css', __FILE__ )); 



		wp_enqueue_style('MJgmgt-bootstrap_min-css', plugins_url('/assets/css/bootstrap_min.css', __FILE__ )); 



		wp_enqueue_style('MJgmgt-datepicker_min-css', plugins_url('/assets/css/datepicker_min.css', __FILE__ )); 



		wp_enqueue_style('MJgmgt-bootstrap-multiselect-css', plugins_url('/assets/css/bootstrap-multiselect.css', __FILE__ )); 



		wp_enqueue_style('MJgmgt-white-css', plugins_url('/assets/css/white.css', __FILE__ )); 



		wp_enqueue_style('MJgmgt-gymmgt_min-css', plugins_url('/assets/css/gymmgt_min.css', __FILE__ )); 



		wp_enqueue_style('MJgmgt-gym-responsive-css', plugins_url('/assets/css/gym-responsive.css', __FILE__ )); 



		



		if (is_rtl())



		{



			wp_enqueue_style( 'MJgmgt-rtl-style-css', plugins_url( '/assets/css/new_design_rtl.css', __FILE__) );



			wp_enqueue_style('MJgmgt-bootstrap-rtl_min-css', plugins_url('/assets/css/bootstrap-rtl_min.css', __FILE__ )); 



			wp_enqueue_style('MJgmgt-custom_rtl-css', plugins_url('/assets/css/custom_rtl.css', __FILE__ )); 



		}







		//-------------- NEW DESIGN CSS  ---------------//



		wp_enqueue_style( 'MJgmgt-new_style-css', plugins_url( '/assets/css/new_style.css', __FILE__) );



		wp_enqueue_style( 'MJgmgt-responsive_new_style-css', plugins_url( '/assets/css/responsive_new_design.css', __FILE__) );



		//------------- NEW DESIGN CSS END -----------------//







		//-------------------- METERIAL DESIGN AND JS ------------------//



		wp_enqueue_style( 'MJgmgt-bootstrap-inputs', plugins_url( '/assets/css/material/bootstrap-inputs.css', __FILE__) );



		wp_enqueue_script('MJ_gmgt_material-min-js', plugins_url( '/assets/js/material/material.min.js',__FILE__ ));



		//-------------------- METERIAL DESIGN AND JS END ------------------//







		//---------------- POPPINS FONT FAMILY -----------------//



		wp_enqueue_style( 'MJgmgt-poppins-fontfamily-css', plugins_url( '/assets/css/popping_font.css', __FILE__) );	



		//---------------- POPPINS FONT FAMILY -----------------//







		wp_enqueue_script('jquery-ui-datepicker');	



		wp_enqueue_style('MJgmgt-validationEngine_jquery-css', plugins_url('/lib/validationEngine/css/validationEngine_jquery.css', __FILE__ )); 



		wp_enqueue_style('MJgmgt-select2-css', plugins_url('/lib/select2-3.5.3/select2.css', __FILE__ )); 



		wp_register_script( 'MJ_gmgt_jquery-3-6-0', plugins_url( '/assets/js/jquery-3-6-0.js', __FILE__), array( 'jquery' ) );



		wp_enqueue_script( 'MJ_gmgt_jquery-3-6-0' );



		wp_enqueue_script('MJ_gmgt-jquery-ui', plugins_url( '/assets/js/jquery-ui.js',__FILE__ ));



		wp_enqueue_script('MJ_gmgt_jquery-ui-lan', plugins_url( '/assets/js/jquery-ui-lan.min.js',__FILE__ ));



		wp_enqueue_script('MJ_gmgt-moment_min', plugins_url( '/assets/js/moment_min.js',__FILE__ ));



		wp_enqueue_script('MJ_gmgt-fullcalendar_min', plugins_url( '/assets/js/fullcalendar_min.js',__FILE__ ));



		wp_enqueue_script('MJ_gmgt-popper-min', plugins_url( '/assets/js/popper.min.js',__FILE__ ));







		$lancode=get_locale();



		$code=substr($lancode,0,2);







		wp_enqueue_script('MJ_gmgt-calendar-lang', plugins_url( '/assets/js/calendar-lang/'.$code.'.js',__FILE__ ));



		wp_enqueue_script('MJ_gmgt-select2_min', plugins_url( '/lib/select2-3.5.3/select2_min.js',__FILE__ ));



		wp_enqueue_script('MJ_gmgt-jquery_dataTables_min', plugins_url( '/assets/js/jquery_dataTables_min.js',__FILE__ ));



		wp_enqueue_script('MJ_gmgt-dataTables_tableTools_min', plugins_url( '/assets/js/dataTables_tableTools_min.js',__FILE__ ));



		wp_enqueue_script('MJ_gmgt-dataTables_editor_min', plugins_url( '/assets/js/dataTables_editor_min.js',__FILE__ ));



		wp_enqueue_script('MJ_gmgt-dataTables_responsive', plugins_url( '/assets/js/dataTables_responsive.js',__FILE__ ));



		wp_enqueue_script('MJ_gmgt-bootstrap_min', plugins_url( '/assets/js/bootstrap_min.js',__FILE__ ));



		wp_enqueue_script('MJ_gmgt-bootstrap-multiselect', plugins_url( '/assets/js/bootstrap-multiselect.js',__FILE__ ));



		wp_enqueue_script('MJ_gmgt-responsive-tabs', plugins_url( '/assets/js/responsive-tabs.js',__FILE__ ));



		//wp_enqueue_script('MJ_gmgt-responsive-tabs', plugins_url( '/lib/validationEngine/js/languages/jquery.validationEngine-'.$code.'.js',__FILE__ ));



		wp_register_script( 'MJgmgt-jquery-validationEngine-'.$code.'', plugins_url( '/lib/validationEngine/js/languages/jquery.validationEngine-'.$code.'.js', __FILE__), array( 'jquery' ) );



	 	wp_enqueue_script( 'MJgmgt-jquery-validationEngine-'.$code.'' );



		 wp_register_script( 'MJgmgt-jquery-validationEngine', plugins_url( '/lib/validationEngine/js/jquery_validationEngine.js', __FILE__), array( 'jquery' ) );



	 	wp_enqueue_script( 'MJgmgt-jquery-validationEngine' );



		 wp_enqueue_script('MJgmgt-slider-js', plugins_url( '/assets/js/jssor_slider_mini.js', __FILE__ ) );







		 	//Print pdf and column visible start



	//	wp_enqueue_script('gmgt-dataTables-buttons-min', plugins_url( '/assets/js/gmgt-dataTables-buttons-min.js', __FILE__ ) );



		/* wp_enqueue_style( 'gmgt-buttons-dataTables-min-css', plugins_url( '/assets/css/buttons.dataTables.min.css', __FILE__) );



		



	    wp_enqueue_script('jszip.min', plugins_url( '/assets/js/jszip.min.js', __FILE__ ), array( 'jquery' ), '3.1.3', true );



	



		wp_enqueue_script('dataTables.fixedColumns.min', plugins_url( '/assets/js/dataTables.fixedColumns.min.js', __FILE__ ), array( 'jquery' ), '3.3.2', true );



		wp_enqueue_script('gmgt-buttons-html5', plugins_url( '/assets/js/buttons.html5.min.js', __FILE__ ), array( 'jquery' ), '1.6.5', true );



		wp_enqueue_script('gmgt-buttons-colVis-min', plugins_url( '/assets/js/buttons.colVis.min.js', __FILE__ ), array( 'jquery' ), '1.7.0', true ); */



		//Print pdf and column visible end







			//--------- Print and PDF ------------------//



			wp_enqueue_script('gmgt-dataTables-buttons-min', plugins_url( '/assets/js/dataTables-buttons-min.js', __FILE__ ));



			wp_enqueue_style( 'gmgt-buttons-dataTables-min-css', plugins_url( '/assets/css/buttons.dataTables.min.css', __FILE__) );



			wp_enqueue_script('gmgt-buttons-print-min', plugins_url( '/assets/js/gmgt-buttons-print-min.js', __FILE__ ));







			wp_enqueue_script('pdfmake-min', plugins_url( '/assets/js/pdfmake-min.js', __FILE__ ) );



			wp_enqueue_script('vfs_fonts', plugins_url( '/assets/js/vfs_fonts.js', __FILE__ ) );



			wp_enqueue_script('gmgt-buttons-html5', plugins_url( '/assets/js/buttons.html5.min.js', __FILE__ ) );



			//--------- Print and PDF ------------------//







		



	}



}















/* 







//REMOVE OL STYLE IN THEMAE FUNCTION







function MJ_gmgt_remove_all_theme_styles()







{







	global $wp_styles;







	$wp_styles->queue = array();







}







//FRONTEND SIDE CHECK USER DASHBORD FUNCTION







if(isset($_REQUEST['dashboard']) && $_REQUEST['dashboard'] == 'user')







{







	add_action('wp_print_styles', 'MJ_gmgt_remove_all_theme_styles', 100);







} */















function wpse_340767_dequeue_theme_assets() 







{







    $wp_scripts = wp_scripts();







    $wp_styles  = wp_styles();







    $themes_uri = get_theme_root_uri();















    foreach ( $wp_scripts->registered as $wp_script ) 







	{







        if ( strpos( $wp_script->src, $themes_uri ) !== false ) 







		{







            wp_deregister_script( $wp_script->handle );







        }







    }















    foreach ( $wp_styles->registered as $wp_style ) 







	{







        if ( strpos( $wp_style->src, $themes_uri ) !== false ) 







		{







            wp_deregister_style( $wp_style->handle );







        }







    }







}







if(isset($_REQUEST['dashboard']) && sanitize_text_field($_REQUEST['dashboard']) == 'user')







{







	add_action( 'wp_enqueue_scripts', 'wpse_340767_dequeue_theme_assets', 999 );







}















//INSTALL LOGIN PAGE







function MJ_gmgt_install_login_page()







{







	if ( !get_option('gmgt_login_page') )







	{







		$curr_page = array(







				'post_title' => esc_html__('Gym Management Login Page', 'gym_mgt'),







				'post_content' => '[gmgt_login]',







				'post_status' => 'publish',







				'post_type' => 'page',







				'comment_status' => 'closed',







				'ping_status' => 'closed',







				'post_category' => array(1),







				'post_parent' => 0 );		















			$curr_created = wp_insert_post( $curr_page );







			update_option( 'gmgt_login_page', $curr_created );







	}







	







}















//GET USER CHOICE PAGE INSERT FUNCTION







function MJ_gmgt_user_choice_page() 







{







	if ( !get_option('MJ_gmgt_user_choice_page') ) 







	{







		$curr_page = array(







			'post_title' => esc_html__('Member Registration or Login', 'gym_mgt'),







			'post_content' => '[gmgt_memberregistration]',







			'post_status' => 'publish',







			'post_type' => 'page',







			'comment_status' => 'closed',







			'ping_status' => 'closed',







			'post_category' => array(1),







			'post_parent' => 0 );



		



			$curr_created = wp_insert_post( $curr_page );







			update_option( 'MJ_gmgt_user_choice_page', $curr_created );







			







	}







}







// GET MEMBERSHP LIST PAGE INSERT FUNCTION WITH MEMBERSHP CODE //







function MJ_gmgt_membership_list_page()







{







	if ( !get_option('gmgt_membershiplist_page') )







	{







		$curr_page = array(







			'post_title' => esc_html__('Membership List Page', 'gym_mgt'),







			'post_content' => '[MembershipCode id=1]',







			'post_status' => 'publish',







			'post_type' => 'page',







			'comment_status' => 'closed',







			'ping_status' => 'closed',







			'post_category' => array(1),







			'post_parent' => 0 );







			$curr_created = wp_insert_post( $curr_page );



		



			update_option( 'gmgt_membershiplist_page', $curr_created );







	}



	



}







//GET MEMBRSHIP LINK







function MJ_gmgt_membershipcode_link($atts)







{







	if(isset($_POST['buy_membership']))







	{







		$obj_membership=new MJ_gmgt_membership;







		$retrieved_data=$obj_membership->MJ_gmgt_get_single_membership($_POST['membership_id']);	







		if($retrieved_data->membership_amount > 0)







		{ 







			$obj_member=new MJ_gmgt_member;		







			$page_id = get_option ( 'MJ_gmgt_user_choice_page' );			







			$referrer_ipn = array(				







				'page_id' => $page_id,







				'action' => 'fronted_membership',







				'membership_id'=>$_POST['membership_id']







			);				







			$referrer_ipn = add_query_arg( $referrer_ipn, home_url() );	







			







			wp_redirect ($referrer_ipn);	







			exit;







	    }







		else







		{







			if (is_user_logged_in ()) 







			{







				//Free Membership process







				$membership_id = $_POST['membership_id'];







				$amount = 0;







				$member_id = get_current_user_id();







				$trasaction_id ='';







				$payment_method='-';







				$result=MJ_gmgt_frontend_side_membership_payment_function($membership_id,$coupon_id,$member_id,$amount,$trasaction_id,$payment_method);







				







				$page_id = get_option ('gmgt_login_page');			







				$referrer_ipn = array(				







					'page_id' => $page_id,







					'action'=>'success_membership'







				);				







				$referrer_ipn = add_query_arg( $referrer_ipn, home_url() );	







				wp_redirect ($referrer_ipn);	







				exit;







			}







			else







			{







				$obj_member=new MJ_gmgt_member;		







				$page_id = get_option ( 'MJ_gmgt_user_choice_page' );			







				$referrer_ipn = array(				







					'page_id' => $page_id,







					'membership_id'=>$_POST['membership_id']







				);				







				$referrer_ipn = add_query_arg( $referrer_ipn, home_url() );	







				







				wp_redirect ($referrer_ipn);	







				exit;







			}           			







		}	 







	}







	$obj_activity=new MJ_gmgt_activity;







	$obj_membership=new MJ_gmgt_membership;







	$atts = shortcode_atts( array(







	'id' => $atts['id'],







	'buttontxt' => esc_html__('Buy Now','gym_mgt')







	), $atts, 'MJ_gmgt_user_choice_page' );







	$retrieved_data=$obj_membership->MJ_gmgt_get_single_membership($atts['id']);







	







	//$current_theme_1 = get_current_theme();



	$current_theme_1 = wp_get_theme();







	if($current_theme_1 == 'Avada')







	{







		?>







		<style>







			.membership_list_page_main_div 







			{







				width: 50%;







   				margin: auto;







				







			}







			.membership_list_page_main_div .wpgym-detail-box







			{







				border: 1px solid;







    			padding: 10px;







				margin-bottom: 10px;







			}







			.wpgym-border-box table







			{







				width: 100%;







    			border: 1px solid;







			}







			.wpgym-border-box table tr







			{







				border-bottom: 1px solid;







			}







		</style>







		<?php







	}







	elseif($current_theme_1 == 'Twenty Twenty-One')







	{







		?>







		<style>







			@media (max-width: 768px)



			{



				.membership_list_page_main_div



				{



					margin: 0 5% !important;



					width: 90% !important;



					top: 25% !important;



				}



				.wpgym-detail-box table



				{



					width: 100% !important;



				}



			}



			@media (min-width: 1020px) and (max-width: 1100px)



			{



				.membership_list_page_main_div



				{



					margin: 0 5% !important;



					width: 90% !important;



					top: 25% !important;



				}



				.wpgym-detail-box table



				{



					width: 100% !important;



				}



			}



			.membership_list_page_main_div







			{







				border: 1px solid black;







			}







			.membership_list_page_main_div .wpgym-detail-box







			{







				padding: 15px;







			}







			







			.background_color_for_card







			{







				background: #8dbca99e;







			}







		</style>







		<?php







	}







	elseif($current_theme_1 == 'Twenty Twenty')







	{







		?>







		<style>







			.membership_list_page_main_div







			{







				border: 1px solid black;







			}







			.membership_list_page_main_div .wpgym-detail-box







			{







				padding: 15px;







			}







			







			.background_color_for_card







			{







				background: #ead49d;







			}







		</style>







		<?php







	}







	elseif($current_theme_1 == 'Twenty Twenty-Two' || $current_theme_1 == 'Twenty Twenty-Three')







	{







		?>







		<style>







			.membership_list_page_main_div







			{







				border: 1px solid black;







			}







			.membership_list_page_main_div .wpgym-detail-box







			{







				padding: 15px;







			}







			







			.background_color_for_card







			{







				background: #ead49d;







			}







			footer







			{







				display: none !important;







			}







			.secound_class_id2







			{







				top: 83% !important;







			}



		







		</style>







		<?php







	}



	elseif($current_theme_1 == 'Twenty Twenty-One Child')



	{



		?>



		<style>



			.membership_list_page_main_div{



				background-color: #ffff;



			}



			.membership_list_page_main_div .wpgym-detail-box{



				padding: 10px 14px;



			}



			.membership_list_page_main_div .fronted_payment_button input {



					border-radius: 0;



			}



			



		</style>



		<?php



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



	elseif($current_theme_1 == "Kallyas"){



		?>



		<style>



			.membership_list_page_main_div{



				position: absolute !important;



				top: 235px !important;



				left: 340px !important;



				width: 50%;



    			margin: auto;



				border: 1px solid black;



    			padding: 14px;



			}



			.col-sm-8.col-md-9.col-sm-8.col-sm-9.znColumnElement{



				top: 81px !important;



    			/* position: absolute !important; */



			}



			.col-sm-4.col-md-3.col-sm-4.col-sm-3.znColumnElement{



				top: 950px !important;



				position: absolute !important;



			}



			.col-sm-8.col-md-9.col-sm-8.col-sm-9.znColumnElement h3{



				font-size: 4.75rem !important;



   				color: #c6c6c6 !important;



			}



			.site-footer{



				margin-top: 105% !important;



			}



		</style>



		<?php



	}



	else



	{



		?>



		<style>



			.membership_list_page_main_div 



			{



				width: 50%;



    			margin: auto;



				border: 1px solid black;



    			padding: 10px;



			}



			.background_color_for_card



			{



				background: #ba170b;



    			color: #fff;



			}



		</style>



		<?php



	}



	



	?>







	<div class="membership_list_page_main_div secound_class_id<?php echo $atts['id']; ?>">



	



		<?php



		



		if(!empty($retrieved_data))







		{



			$type = '';



			$result = MJ_gmgt_get_membership_class($retrieved_data->membership_id);







			$tax_amount=MJ_gmgt_get_membership_tax_amount($retrieved_data->membership_id,$type);



		



			if(!empty($result))







			{







					$fake="";







					if($result->classis_limit=='limited')







					{ 







						$fake=1;						







					}						







			}?>







			<div class="wpgym-detail-box col-md-12">







				<div class="wpgym-border-box">







				<?php







				//$current_theme_1 = get_current_theme();



				$current_theme_1 = wp_get_theme();



				if($current_theme_1 == 'Twenty Twenty-Two' || $current_theme_1 == 'Twenty Twenty-Three')







				{







					?>







					<style>







						.wpgym-course-lession-list







						{







							padding:0 !important;







						}







						footer







						{







							margin-top: 10% !important;







						}







						.membership_list_page_main_div{







							position: absolute;







							margin: 0 15%;







							width: 70%;







							top: 55%;







						}







					







					</style>







					<?php					







				}







				if($current_theme_1 == 'Twenty Twenty-One')







				{







					?>







					<style>







						/* .membership_list_page_main_div .wpgym-detail-box{







							padding-bottom: 0px;







						} */







					</style>







					<?php					







				}







				?>







				<style>







					.fronted_payment_button .save_btn







					{







						color: #fff !important;







						background-color: #ba170b !important;







					}







					.fronted_payment_button{







						margin-top:20px;







					}	







					







					table tr td







					{







						text-align: left;







					}







					.footer-top-visible table







					{







						margin-top: 2%;







					}







					.wpgym-box-title .wpgym-membershiptitle{







						font-size: 30px !important;







						font-weight: 700 !important;







						color: #28303d !important







					}







					.wpgym-border-box .wpgym-course-lession-list{







						color: #333333;







						overflow: auto;







						padding: 0px 0px 10px 0px;







						max-height: 100px;







						margin-bottom: 15px;







						font-size: 15px;







						line-height: 22px;







					}







					*::-webkit-scrollbar {







						width: 10px;







						border-radius: 10px;







					}







					*::-webkit-scrollbar-thumb {







						background-color: #888;







						border-radius: 10px;







					}







					*::-webkit-scrollbar-track {







						background: #f1f1f1;







						border-radius: 10px;







						/* color of the tracking area */







					}







					.fronted_payment_button .wpgym-btn-buynow







					{







						font-weight: 700;







					}







					.fronted_payment_button input{







						border-radius: 28px;







						padding: 5px 20px;







						/* background-color: #014D67; */







						border: 0px;







						/* color: #ffffff; */







						font-size: 20px;







						text-transform: uppercase;







					}







					.membership_list_page_main_divloginform{







						position: absolute;







						width: 100%;







						top: 40%;







					}







					.wp-block-group .alignwide{







						padding-bottom: 0 !important;







						padding-top: 0 !important;







					}







					.wp-block-group h1{







						margin-bottom: 0 !important;







					}







				</style>







				<form name="membership" method="post" action="">







					<div class="wpgym-box-title">







						<span class="wpgym-membershiptitle">







							<?php echo stripslashes($retrieved_data->membership_label);?>







						</span>







					</div>







					<div class="wpgym-course-lession-list">







					<?php echo stripslashes($retrieved_data->membership_description);?>







					</div>







					<table>







					<thead>







						<tr class="background_color_for_card">







							<td><?php echo esc_html_e('Membership Amount','gym_mgt');?></td>







							<td><?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ))."".$retrieved_data->membership_amount;?></td>







						</tr>







					</thead>







					<tbody>







					<tr>







						<td><?php echo esc_html_e('Signup Fee','gym_mgt');?></td>







						<td>+&nbsp;<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ))."".$retrieved_data->signup_fee;?></td>







					</tr>



					<!-- <tr>







						<td><?php echo esc_html_e('Tax Amount','gym_mgt');?></td>







						<td>+&nbsp;<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ))."".$tax_amount;?></td>







					</tr> -->







					</tbody>







					</table>







					<?php







					$singup=($retrieved_data->signup_fee);







					$amount_member=($retrieved_data->membership_amount);







					$totel_Amount= $singup +$amount_member;







					?>







					<div class="fronted_payment_button">



					<input type="submit" name="buy_membership" class="save_btn" value="<?php if(isset($atts['buttontxt'])) echo $atts['buttontxt'];?>">						







					<span class="wpgym-btn-buynow">







					<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ))."".$totel_Amount;?>







						<input type="hidden" name="amount" value="<?php echo $totel_Amount;?>">







						<input type="hidden" name="member_id" value="<?php echo get_current_user_id();?>">







						<input type="hidden" name="membership_id" value="<?php echo $retrieved_data->membership_id;?>">







					</span>					







					







					</div>		







					</form>







				</div>	







			</div>







			<?php 







		}







		?>







	</div>



	<?php 



	if($current_theme_1 == 'Twenty Twenty-One Child')



	{



		?>



		<footer class="gmgt_footer">



			<nav aria-label="Secondary menu" class="footer-navigation">



				<ul class="footer-navigation-wrapper">



					<li id="menu-item" class="menu-item "><a href="<?php echo wp_logout_url(home_url()); ?>"><span><?php echo esc_html_e( "Login", 'gym_mgt' ); ?></span></a></li>



					<li id="menu-item" class="menu-item "><a href="<?php echo wp_logout_url(home_url('class-booking')); ?>"><span><?php echo esc_html_e( "Class Booking", 'gym_mgt' ); ?></span></a></li>



					<li id="menu-item" class="menu-item "><a href="<?php echo wp_logout_url(home_url('member-registration-or-login')); ?>"><span><?php echo esc_html_e( "Member Registration", 'gym_mgt' ); ?></span></a></li>



					<!-- <li id="menu-item" class="menu-item "><a href="<?php echo wp_logout_url(home_url('membership-list-page')); ?>"><span><?php echo esc_html_e( "Membership List", 'gym_mgt' ); ?></span></a></li> -->



				</ul>



			</nav>



		</footer>



		<?php 



	}	



}



//MEMBERSHI PAYPAL PAYMENT PROCES FUNCTION//



function MJ_gmgt_pay_membership_amount()



{	



	



	//MEMBERSHI PPAYMENT PROCES FUNCTION



	if(isset($_POST['payer_status']) && $_POST['payer_status'] == 'VERIFIED' && (isset($_POST['payment_status'])) && $_POST['payment_status']=='Completed' && isset($_REQUEST['fullpay'] ) && $_REQUEST['fullpay']=='yes')



	{	



		if(!empty($_POST))



		{



		



			$obj_membership_payment=new MJ_gmgt_membership_payment;



			$obj_membership=new MJ_gmgt_membership;	



			$obj_member=new MJ_gmgt_member;



			$trasaction_id  = $_POST["txn_id"];



			$custom_array = explode("_",$_POST['custom']);







            $customer_id=$custom_array[0];



			$action='front_end';



			$payment_method='Paypal';



			$pay_id=$custom_array[1];



			$amount=$_POST['mc_gross_1'];



			$coupon_id = $custom_array[2];



		



			$result=MJ_gmgt_generate_membership_end_income_invoice_with_payment_online_payment($customer_id,$pay_id,$amount,$payment_type,$action,$payment_method,$coupon_id,'');



			if($result)



			{



				wp_redirect(home_url() .'/member-registration-or-login/?action=success');



				exit;



			}



		}



		//check book class after membership paymen//



	}



}



function MJ_gmgt_membership_pay_link()



{







	require_once GMS_PLUGIN_DIR. '/template/membership_details.php';







}







function MJ_gmgt_frontend_class_booking_link()







{	







	require_once GMS_PLUGIN_DIR. '/template/frontend_class_booking.php';







}







//INSTAL MEMBERSHIP PAY PAGE







function MJ_gmgt_install_membership_pay_page()







{







	if ( !get_option('gmgt_membership_pay_page') ) 







	{







		$curr_page = array(







				'post_title' => esc_html__('Membership Payment', 'gym_mgt'),







				'post_content' => '[membership_pay_shortcode]',







				'post_status' => 'publish',







				'post_type' => 'page',







				'comment_status' => 'closed',







				'ping_status' => 'closed',







				'post_category' => array(1),







				'post_parent' => 0 );







		$curr_created = wp_insert_post( $curr_page );







		update_option( 'gmgt_membership_pay_page', $curr_created );







	}







}







//INSTAL CLASS BOOKING PAGE







function MJ_gmgt_install_class_booking_page()







{







	if ( !get_option('gmgt_class_booking_page') ) 







	{







		$curr_page = array(







				'post_title' => esc_html__('Class Booking', 'gym_mgt'),







				'post_content' => '[frontend_class_booking]',







				'post_status' => 'publish',







				'post_type' => 'page',







				'comment_status' => 'closed',







				'ping_status' => 'closed',







				'post_category' => array(1),







				'post_parent' => 0 );







		$curr_created = wp_insert_post( $curr_page );







		update_option( 'gmgt_class_booking_page', $curr_created );







	}







}







add_action( 'plugins_loaded', 'MJ_gmgt_domain_load' );















add_action('init','MJ_gmgt_install_login_page');







add_action('init','MJ_gmgt_membership_list_page');







add_shortcode( 'gmgt_login','MJ_gmgt_login_link_for_plugin_theme');







add_action('init','MJ_gmgt_user_choice_page');







add_shortcode( 'MembershipCode','MJ_gmgt_membershipcode_link' );







add_shortcode('membership_pay_shortcode','MJ_gmgt_membership_pay_link');







add_shortcode('frontend_class_booking','MJ_gmgt_frontend_class_booking_link');







add_action('init','MJ_gmgt_install_membership_pay_page');







add_action('init','MJ_gmgt_install_class_booking_page');







add_action('wp_head','MJ_gmgt_user_dashboard');







add_action( 'init', 'MJ_gmgt_pay_membership_amount');







add_action( 'init', 'MJ_gmgt_pay_membership_amount_frontend_side');







add_shortcode( 'gmgt_memberregistration', 'MJ_gmgt_member_choice' );







add_shortcode( 'gmgt_member_registration', 'MJ_gmgt_memberregistration_link' );







add_action('init','MJ_gmgt_output_ob_start');















//MEMBER CHOICE FUNCTION FOR LOGIN OR EXTING USER







function MJ_gmgt_member_choice($attr)







{







	//$current_theme = get_current_theme();



	$current_theme = wp_get_theme();







	if($current_theme == 'Twenty Twenty Child')







	{







		?>







		<style>







			.user-choice-block 







			{







				float: left;







				width: 50% !important;







			}







			 .user-choice-area{







				padding-bottom: 30px;







			}







			#loginform .login-username{







				margin-bottom: 20px;







			}







			#loginform .login-remember{







				margin-bottom: 20px;







			}







			#loginform .login-password{







				margin-bottom: 20px;







			}







			#loginform .login-password label{







				padding-right: 147px;







			}







		</style>







		<?php







	}







	if($current_theme == 'Twenty Twenty-Two' || $current_theme == 'Twenty Twenty-Three')







	{







		?>







		<style>







			.user-choice-area







			{







				position: relative !important;







			}



			



		</style>







		<?php







	}



	if($current_theme == 'Twenty Twenty-One Child')



	{



		?>



		<style>



			.content-area .entry-header{



				display: none;



			}



			/* body



			{



				background-color: #ba170b !important;



			} */



			.site{



				background-color: #ba170b !important;



			}



			.student_registraion_form{



				width: 85%;



				margin-left: auto;



				margin-right: auto;



			}



			.user-choice-area {



				/* width: 80%; */



				margin-left: auto;



				width: 85%!important;



				margin-right: auto;



			}



			.gmgt_child_login_reg .custom-logo-link {



				display: none!important;



			}



			.gmgt_child_login_reg .site-footer{



				display: none;



			}



			.gmgt_child_login_reg .gmgt_chile_theme_forgot_pass {



				top: 93%!important;



			}



			#loginform p {



				padding-right: 10%;



				padding-left: 10%;



			}



			.student_registraion_form {



   				 width: 90%;



			}



			.gmgt_child_login_reg{



				max-width: 80% !important;



			}



		</style>



		<?php



	}







	if($current_theme == 'Twenty Nineteen')



	{



		?>







		<style>



			.image-filters-enabled #user_pass



			{



						



				margin-left: 0px !important;



				



			}



			h1:not(.site-title):before, h2:before {



				background: #767676;



				content: unset;



			}



		</style>







		<?php



	}







	if($current_theme == 'Twenty Seventeen')



	{



		?>







		<style>



			/* .image-filters-enabled #user_pass



			{



						



				margin-left: 0px !important;



				



			}



			h1:not(.site-title):before, h2:before {



				background: #767676;



				content: unset;



			} */







			.user-choice-block{



				float: left !important;



    			width: 50% !important;



			}



			#loginform .login-submit input#wp-submit {



				padding: 8px 35px !important;



				width: auto;



			}



			.gym_registration_according {



				float: left;



				width: 197% !important;



			}



			.gmgt_child_theme_reg_btn{



				width: 68% !important;



			}



			#loginform .login-submit input







			{



				width: auto !important;



			}



		</style>







		<?php



	}







	if($current_theme == 'Twenty Twenty-One')



	{



		?>



		<style>



			.user-choice-area



			{



				height: 30px !important;



			}



			.login-username



			{



				width: 100%;



			}



			.login-password label



			{



				width: auto !important;



			}



		</style>



		<?php



	}



	 ?>







	<style>



	/* #loginform .login-submit input







	{



		width: auto !important;



		border-radius: 28px ;







		padding: 8px 60px !important;







		background-color: #014D67 ;







		border: 0px !important;







		color: #ffffff !important;







		font-size: 20px !important;







		text-transform: uppercase !important;







		text-decoration: none !important;







		



	} */







	.user-choice-area {







	  width: 100%;







	}







	.user-choice-block {







	  float: left;







	  width: 30%;







	}







	.user_login_choice







	{







		margin-right: 8px;







		margin-bottom: -5px !important;







	}







	.registration_after_show_word_success







	{







		margin-top: 10px;







		float: left;







		width:100%;







		margin-bottom: 10px;







		text-align: center;







	}







	.image-filters-enabled #user_pass







	{







		margin-left: 18px;







	}







	.image-filters-enabled .header







	{







		float:left;







		width:100%;







	}







	.student_reg_error







	{







		float:left;







	}







	@media only screen and (max-width : 768px) {







		.wp-embed-responsive .user-choice-area .user-choice-block {







			float: left;







			width: 50% !important;







		}







		.wp-embed-responsive .login-username,.wp-embed-responsive .login-password {







			width: 235px !important;







		}







		.wp-embed-responsive .user-choice-area {







			margin-left: 7% !important;







		}







		.et_divi_theme #searchform







		{







			float: left;







			width: 100%;







		}







		.et_divi_theme #sidebar







		{







			float: left !important;







		}







	}







	</style>	 







	<script type="text/javascript" src="<?php echo GMS_PLUGIN_URL.'/assets/js/jquery-3-6-0.js';?>"></script>







	<script type="text/javascript">







	jQuery(document).ready(function() 







	{




		







		jQuery('.student_login_form').show();







		jQuery('.student_registraion_form').hide();







		<?php



		if(!empty($_REQUEST['action']))



		{



			if($_REQUEST['action'] == 'frontend_class_book_with_membership_id')







			{ 







				?>







				jQuery('.student_registraion_form').show();







				$('.user_new_frontend').prop('checked', true);







				jQuery('.student_login_form').hide();







			<?php







			}



		}







		if(isset($_REQUEST['bookedclass_membershipid']) && $_REQUEST['action']=='frontend_book')







		{ ?>







				jQuery('.user-choice-area').hide();







				$('.user_login_choice_membership').prop('checked', true);







				jQuery('.user_new_frontend').prop("disabled", true);







				jQuery('.student_registraion_form').hide(); 







				jQuery('.student_login_form').show();







		<?php







		} 







		?>







		<?php







		if(isset($_REQUEST['membership_id']) && isset($_REQUEST['class_id']) && $_REQUEST['action']=='fronted_membership')







		{ ?>







				jQuery('.user-choice-area').hide();







				$('.user_login_choice_frontend').prop('checked', true);







				jQuery('.user_login_frontend').prop("disabled", true);







				jQuery('.student_registraion_form').show(); 







				jQuery('.student_login_form').hide();







			<?php







		} 







		?>







		jQuery("body").on("change",".user_login_choice",function()







		{







			var choice="";







			if(jQuery('.user_login_choice').is(':checked')) 







			{ 







				 choice=jQuery(this).val();







				if(choice=='new_user')







				{







						jQuery('.student_registraion_form').show();







						jQuery('.student_login_form').hide();







				}







				else







				{







						jQuery('.student_login_form').show();







						jQuery('.student_registraion_form').hide();







				}







				}







		});







	});







	</script>	 







	<?php







	if (is_user_logged_in ()) 







	{	







		$obj_membership=new MJ_gmgt_membership;







		if(isset($_REQUEST['membership_id']))







		{







			$retrieved_data=$obj_membership->MJ_gmgt_get_single_membership($_REQUEST['membership_id']);		







			if($retrieved_data->membership_amount > 0)







			{







				$page_id = get_option ( 'gmgt_membership_pay_page' );







				$referrer_ipn = array(				







					'page_id' => $page_id,







					'membership_id'=>$_REQUEST['membership_id']







				);







				$referrer_ipn = add_query_arg( $referrer_ipn, home_url() );







				wp_redirect ($referrer_ipn);	







				exit;







			}	







		}	







	}







	else 







	{ 







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



			?>



			<?php



		}



		?>







		<div class="registration_form_custom_div gmgt_child_login_reg">



			<?php 



			if($current_theme == 'Twenty Twenty-One Child')



			{



				?>



				<h4 class="gmgt_Child_theme_heder"><?php echo esc_html_e( "Member Registration or Login", 'gym_mgt' ); ?></h4>



				<?php



			}



			?>







			<div class="user-choice-area">







				<div class="user-choice-block">







					<input class="user_login_choice user_login_frontend user_login_choice_membership" checked="true" type="radio" value="existing_user"  name="user_choice"><?php esc_html_e('Existing User Login','gym_mgt');?>







				</div>







				<div class="user-choice-block">					







					<input class="user_login_choice user_login_choice_frontend user_new_frontend" type="radio" value="new_user"  name="user_choice"><?php esc_html_e('New User Registration','gym_mgt');?>







				</div>







			</div>















			<div class="student_login_form"><?php echo do_shortcode('[gmgt_login]'); ?></div>	







			<div class="student_registraion_form"><?php echo do_shortcode('[gmgt_member_registration]'); ?></div>		







		</div>







		<?php 



		if($current_theme == 'Twenty Twenty-One Child')



		{



			?>



			<footer class="gmgt_footer">



				<nav aria-label="Secondary menu" class="footer-navigation">



					<ul class="footer-navigation-wrapper">



						<li id="menu-item" class="menu-item "><a href="<?php echo wp_logout_url(home_url()); ?>"><span><?php echo esc_html_e( "Login", 'gym_mgt' ); ?></span></a></li>



						<li id="menu-item" class="menu-item "><a href="<?php echo wp_logout_url(home_url('class-booking')); ?>"><span><?php echo esc_html_e( "Class Booking", 'gym_mgt' ); ?></span></a></li>



						<li id="menu-item" class="menu-item "><a href="<?php echo wp_logout_url(home_url('membership-list-page')); ?>"><span><?php echo esc_html_e( "Membership List", 'gym_mgt' ); ?></span></a></li>



					</ul>



				</nav>



			</footer>



			<?php 



		}



	}







}







//MEMBER RAGISTATION LINK FUNCTION







function MJ_gmgt_memberregistration_link()







{







	ob_start();







    MJ_gmgt_member_registration_function();







    return ob_get_clean();	







}















//MEMBER RAGIDSTAION FORM FUNCTION IN FRONTEND SIDE







function MJ_gmgt_registration_form( $class_name,$first_name,$member_type,$last_name,$gender,$birth_date,$address,$city_name,$state_name,$zip_code,$mobile_number,$phone,$email,$password,$gmgt_user_avatar,$member_id,$weight,$Height,$chest,$waist,$thigh,$arms,$fat,$intrest_area,$member_convert,$source,$reference_id,$inqiury_date,$membership_id,$begin_date,$end_date,$first_payment_date) 







{	



		$current_theme = wp_get_theme();



		error_reporting(0);



 		$lancode=get_locale();



		$code=substr($lancode,0,2);







		//metrial design css & js start --//



		wp_enqueue_style( 'MJgmgt-bootstrap-inputs', plugins_url( '/assets/css/material/bootstrap-inputs.css', __FILE__) );



		wp_enqueue_script('MJ_gmgt_material-min-js', plugins_url( '/assets/js/material/material.min.js',__FILE__ ));



		//End metrial design js End --//







	 	wp_enqueue_style( 'MJgmgt-validate-css', plugins_url( '/lib/validationEngine/css/validationEngine_jquery.css', __FILE__) );



	 	wp_register_script( 'MJgmgt-jquery-validationEngine-'.$code.'', plugins_url( '/lib/validationEngine/js/languages/jquery.validationEngine-'.$code.'.js', __FILE__), array( 'jquery' ) ,false, false);



	 	wp_enqueue_script( 'MJgmgt-jquery-validationEngine-'.$code.'' );







		// wp_register_script( 'MJ_gmgt_jquery-3-6-0', plugins_url( '/assets/js/jquery-3-6-0.js', __FILE__), array( 'jquery' ) );



		// wp_enqueue_script( 'MJ_gmgt_jquery-3-6-0' );



		// wp_enqueue_style('MJgmgt-select2-css', plugins_url('/lib/select2-3.5.3/select2.css', __FILE__ )); 



		// wp_enqueue_script('MJgmgt-select2', plugins_url( '/lib/select2-3.5.3/select2_min.js', __FILE__ ));



		



		wp_register_script( 'MJgmgt-jquery-validationEngine', plugins_url( '/lib/validationEngine/js/jquery_validationEngine.js', __FILE__), array( 'jquery' ) );



	 	wp_enqueue_script( 'MJgmgt-jquery-validationEngine' ); 



		wp_enqueue_script('jquery-ui-datepicker');		



		wp_enqueue_script('MJgmgt-bootstrap-multiselect-js', plugins_url( '/assets/js/bootstrap-multiselect.js', __FILE__ ) );











		wp_enqueue_style( 'MJgmgt-bootstrap-css', plugins_url( '/assets/css/bootstrap_min.css', __FILE__) );



		wp_enqueue_style( 'MJ_gmgt_accordian-jquery-ui-css', plugins_url( '/assets/accordian/jquery-ui.css', __FILE__) );



		wp_enqueue_style( 'MJgmgt-bootstrap-multiselect-css', plugins_url( '/assets/css/bootstrap-multiselect.css', __FILE__) );



		wp_register_script('MJgmgt-popup-front', plugins_url( 'assets/js/popup.js', __FILE__ ), array( 'jquery' ));



	    wp_enqueue_script('MJgmgt-popup-front');



	    wp_localize_script( 'MJgmgt-popup-front', 'gmgt', array( 'ajax' => admin_url( 'admin-ajax.php' ) ) );



	    wp_enqueue_script('jquery');



	   //RTL Add



	   if (is_rtl())



		{



			wp_enqueue_style( 'MJgmgt-bootstrap-rtl-css', plugins_url( '/assets/css/bootstrap-rtl_min.css', __FILE__) ); 



			//validation lib//



			wp_enqueue_style( 'MJgmgt-validate-css', plugins_url( '/lib/validationEngine/css/validationEngine_jquery.css', __FILE__) );	 	



			wp_register_script( 'MJgmgt-jquery-validationEngine-'.$code.'', plugins_url( '/lib/validationEngine/js/languages/jquery.validationEngine-'.$code.'.js', __FILE__), array( 'jquery' ) );



			wp_enqueue_script( 'MJgmgt-jquery-validationEngine-'.$code.'' );



			wp_register_script( 'MJgmgt-jquery-validationEngine', plugins_url( '/lib/validationEngine/js/jquery_validationEngine.js', __FILE__), array( 'jquery' ) );



			wp_enqueue_script( 'MJgmgt-jquery-validationEngine' );



			wp_enqueue_style( 'MJgmgt-custom-rtl-css', plugins_url( '/assets/css/custom_rtl.css', __FILE__) );



		}



		wp_enqueue_style( 'MJgmgt-new_style-css', plugins_url( '/assets/css/new_style.css', __FILE__) );



		wp_enqueue_script('MJ_gmgt-popper-min', plugins_url( '/assets/js/popper.min.js',__FILE__ ));



		wp_enqueue_script('MJgmgt-bootstrap-js', plugins_url( '/assets/js/bootstrap_min.js', __FILE__ ) );



		//wp_enqueue_script('MJgmgt-jquery-ui-js', plugins_url( '/assets/js/jquery-ui.js', __FILE__ ) );



		wp_enqueue_script('MJ_gmgt_jquery-ui-lan', plugins_url( '/assets/js/jquery-ui-lan.min.js',__FILE__ ));



	?>







	<script type="text/javascript"	src="<?php echo GMS_PLUGIN_URL.'/assets/js/popper.min.js'; ?>"></script> 



	<link rel="stylesheet"	href="<?php echo GMS_PLUGIN_URL.'/assets/css/fronted_user_registration.css'; ?>">	



	<link rel="stylesheet"	href="<?php echo GMS_PLUGIN_URL.'/assets/css/bootstrap_min.css'; ?>">	



	<link rel="stylesheet"	href="<?php echo GMS_PLUGIN_URL.'/assets/css/bootstrap-multiselect.css'; ?>">	



	<script type="text/javascript"	src="<?php echo GMS_PLUGIN_URL.'/assets/js/bootstrap_min.js'; ?>"></script> 







	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>



	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>



	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js" integrity="sha512-FHZVRMUW9FsXobt+ONiix6Z0tIkxvQfxtCSirkKc5Sb4TKHmqq1dZa8DphF0XqKb3ldLu/wgMa8mT6uXiLlRlw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>



	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">



	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css" integrity="sha512-mR/b5Y7FRsKqrYZou7uysnOdCIJib/7r5QeJMFvLNHNhtye3xJp1TdJVPLtetkukFn227nKpXD9OjUc09lx97Q==" crossorigin="anonymous">



	



	<script type="text/javascript"	src="<?php echo GMS_PLUGIN_URL.'/assets/js/bootstrap-multiselect.js'; ?>"></script> 



	<!-- <script type="text/javascript" src="<?php echo GMS_PLUGIN_URL.'/assets/js/jquery_3.6.0.js';?>">



	</script> -->



	<script type="text/javascript" src="<?php echo GMS_PLUGIN_URL.'/assets/js/jquery-ui-1.12.1.min.js';?>">



	</script>



	<!--- Changes Add script add child theme	--->



	<script type="text/javascript" src="<?php echo esc_url( plugins_url() . '/gym-management/assets/accordian/jquery-ui.js' ); ?>"></script> 



	<script type="text/javascript"	src="<?php echo GMS_PLUGIN_URL.'/lib/validationEngine/js/languages/jquery.validationEngine-'.$code.'.js'; ?>"></script> 



	<script type="text/javascript"	src="<?php echo GMS_PLUGIN_URL.'/lib/validationEngine/js/jquery_validationEngine.js'; ?>"></script>  



	<!-- Changes Code add child theme -->



	<script type="text/javascript">



		jQuery(document).ready(function() 



		{



			jQuery('.student_login_form').show();







			jQuery('.student_registraion_form').hide();







			<?php



			if(!empty($_REQUEST['action']))



			{



				if($_REQUEST['action'] == 'frontend_class_book_with_membership_id')







				{ 







					?>







					jQuery('.student_registraion_form').show();







					$('.user_new_frontend').prop('checked', true);







					jQuery('.student_login_form').hide();







				<?php







				}



			}







			if(isset($_REQUEST['bookedclass_membershipid']) && $_REQUEST['action']=='frontend_book')







			{ ?>







					jQuery('.user-choice-area').hide();







					$('.user_login_choice_membership').prop('checked', true);







					jQuery('.user_new_frontend').prop("disabled", true);







					jQuery('.student_registraion_form').hide(); 







					jQuery('.student_login_form').show();







			<?php







			} 







			?>







			<?php







			if(isset($_REQUEST['membership_id']) && isset($_REQUEST['class_id']) && $_REQUEST['action']=='fronted_membership')







			{ ?>







					jQuery('.user-choice-area').hide();







					$('.user_login_choice_frontend').prop('checked', true);







					jQuery('.user_login_frontend').prop("disabled", true);







					jQuery('.student_registraion_form').show(); 







					jQuery('.student_login_form').hide();







			<?php







			} 







			?>







			jQuery("body").on("change",".user_login_choice",function()







			{







				var choice="";







				if(jQuery('.user_login_choice').is(':checked')) 







				{ 







					choice=jQuery(this).val();







					if(choice=='new_user')







					{







							jQuery('.student_registraion_form').show();







							jQuery('.student_login_form').hide();







					}







					else







					{







							jQuery('.student_login_form').show();







							jQuery('.student_registraion_form').hide();







					}







					}







			});







		});







	</script>	



   	<script type="text/javascript">







		jQuery(document).ready(function()







		{







			"use strict";







			var test = "<?php echo MJ_gmgt_get_current_lan_code(); ?>";







			jQuery('#registration_form').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});	







			jQuery.datepicker.setDefaults($.datepicker.regional['en']);







			//console.log(test);







			jQuery('#birth_date').datepicker({







				dateFormat: '<?php echo get_option('gmgt_datepicker_format');?>',







				maxDate : 0,







				changeMonth: true,







				changeYear: true,







				yearRange:'-65:+25'







						







			});		







			jQuery('#inqiury_date').datepicker({







					dateFormat: '<?php echo get_option('gmgt_datepicker_format');?>',







					minDate:'today',







					changeMonth: true,







					changeYear: true,







					yearRange:'-65:+25'







				});		







				jQuery('#triel_date').datepicker({







					dateFormat: '<?php echo get_option('gmgt_datepicker_format');?>',







					minDate:'today',







					changeMonth: true,







					changeYear: true,







					yearRange:'-65:+25'







				});		







				jQuery('#first_payment_date').datepicker({







					dateFormat: '<?php echo get_option('gmgt_datepicker_format');?>',







					minDate:'today',







					changeMonth: true,







					changeYear: true,







					yearRange:'-65:+25'







				});		







			jQuery('#begin_date').datepicker({







					dateFormat: '<?php echo get_option('gmgt_datepicker_format');?>',







					minDate:'today',







					changeMonth: true,







					changeYear: true,







					yearRange:'-65:+25'







				});		







				jQuery('#end_date').datepicker({







					dateFormat: '<?php echo get_option('gmgt_datepicker_format');?>',







					changeMonth: true,







					changeYear: true,







					yearRange:'-65:+25'







				});		







				$('#group_id').multiselect(







				{







					nonSelectedText :'<?php esc_html_e('Select Group','gym_mgt');?>',







					includeSelectAllOption: true,







					allSelectedText :'<?php esc_html_e('All Selected','gym_mgt'); ?>',







					selectAllText : '<?php esc_html_e('Select all','gym_mgt'); ?>',







					templates: {







							button: '<button class="multiselect btn btn-default dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><span class="multiselect-selected-text"></span><b class="caret"></b></button>',







						},







					buttonContainer: '<div class="dropdown" />'







				});	







			$('#classis_id').multiselect(







			{







				nonSelectedText :'<?php esc_html_e('Select Class','gym_mgt');?>',







				includeSelectAllOption: true,







				selectAllText : '<?php esc_html_e('Select all','gym_mgt'); ?>',







				templates: {







						button: '<button class="multiselect btn btn-default dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><span class="multiselect-selected-text"></span><b class="caret"></b></button>',







					},







				buttonContainer: '<div class="dropdown" />'







			});	







		});







	</script>







	







	<script type="text/javascript">







		function MJ_gmgt_fileCheck(obj) 







		{







			var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'bmp',''];







			if ($.inArray($(obj).val().split('.').pop().toLowerCase(), fileExtension) == -1)







			{







				alert("<?php esc_html_e("Only .jpeg, .jpg, .png, .gif, .bmp formats are allowed.",'gym_mgt');?>");		







				$(obj).val('');







			}







					







		}







	</script>







	<?php







	//$current_theme = get_current_theme();



	$current_theme = wp_get_theme();



	if($current_theme == 'Twenty Twenty-Three')



	{



		?>



		<style>



		footer



		{



			display: none;



		}



		.registration_form_custom_div {



			top: 50%;



		}



		</style>



		<?php



	}



	if($current_theme == 'Avada')







	{







		?>







		<style>







			.collapse







			{







				display: block ;







			}







			







			/* .gym_registration_according







			{







				width: 50% !important;







			} */







			/* .avada_width_100_per .save_btn







			{







				width: 25% !important;







			} */







			.avada_width_100_per







			{







				width: 100% !important;







				padding-left: 0px !important;







				padding-right: 0px !important;







			}







			#loginform input







			{







				/* width: 50% !important; */







				border: 1px solid;







				/* margin-left: 20px; */







			}







			.login-password label







			{







				width: 160px !important;







			}







			.avada-responsive p.login-submit







			{







				width: 50%;







			}







		</style>







		<?php







	}







	if($current_theme == 'Twenty Twenty-Two' || $current_theme == 'Twenty Twenty-Three')







	{







		?>







		<style>







			.student_registraion_form{







				margin-top: 15px;







			}







			.gym_registration_according







			{







				float: left;







				width: 60% !important;







				margin-top: 20px;







				margin: 0 22% !important;







			}







			.save_btn_line_height_14px 







			{







				margin: 0 44% !important;







			}



			



			#group_id123{



				height: 50px;



			}



			



			



			@media (max-width: 768px)



			{



				.save_btn_line_height_14px 







				{







					margin: 0 !important;







				}



			}



		</style>







		<?php







	}







	if($current_theme == 'Twenty Twenty')







	{







		?>







		<style>







			.singular .entry-header







			{







				padding: 0 !important;







			}







			.accordion-item:first-of-type .accordion-button







			{







				text-decoration: none;







				







			}







			.accordion-button







			{







				font-size: 16px !important;







			}







			a







			{







				text-decoration: none;







			}







			.post-inner







			{







				padding-top: 4rem !important;







			}







			.entry-content h2







			{







				margin: 0 !important;







			}







		</style>







		<?php







	}



	if($current_theme == 'Twenty Twenty-One')



	{



		?>



		<style>



		.ui-datepicker-title select {



			border: 1px solid #c5c5c5;



		}



		</style>



		<?php



	}







	if($current_theme == 'Twenty Twenty-One Child')



	{



		?>



		<style>



			.gmgt_child_theme_reg_btn{



				padding-bottom: 5%;



			}



			.gmgt_child_reg_gender {



				width: 100%;



			}







		</style>



		<?php



	}







	if($current_theme == "Kallyas")



	{



		?>



		<style>



			.registration_form_custom_div.gmgt_child_login_reg{



				/* padding-top : 170px !important; */



				position: absolute;



				top: 15%;



				left: 340px;



			}



			.gmgt_child_login_reg .user-choice-block{



				font-size: 18px !important;



			}



			.gmgt_chile_theme_forgot_pass{



				font-size: 12px !important;



			}



			.zn_section{



				padding-top: 0px !important;



			}



			.site-footer{



				margin-top: 105% !important;



			}



			.col-sm-8.col-md-9.col-sm-8.col-sm-9.znColumnElement{



				top: 180px !important;



    			/* position: absolute !important; */



			}



			.col-sm-8.col-md-9.col-sm-8.col-sm-9.znColumnElement h3{



				font-size: 4.75rem !important;



   				color: #c6c6c6 !important;



			}



			



			.col-sm-4.col-md-3.col-sm-4.col-sm-3.znColumnElement{



				top: 950px !important;



				position: absolute !important;



			}



			.user_form .col-md-12.form-control {



				height: 40px !important;



			}



			#registration_form input{



				border : unset !important;



				box-shadow : unset !important;



			}



			select{



				height: 40px !important;



			}



			.csspointerevents {



				scroll-behavior: unset !important;



			}



		</style>



		<?php



	}



	?>







	<style>



		.discount_display{

		display: none;

		}



		button.multiselect.dropdown-toggle.btn.btn-default {







			width: 100%;







			margin-top: 0px;







			height: 45px !important;







		}



		.dropdown-item







		{







			width: 225px;







		}







		.accordion-button







		{







			font-size: 16px !important;







		}







		a







		{







			text-decoration: none;







		}







		#registration_form .frontend_button_regsiter{







			border-radius: 28px !important;







			padding: 8px 60px !important;







			background-color: #014D67 !important;







			border: 0px !important;







			color: #ffffff !important;







			font-size: 20px !important;







			text-transform: uppercase !important;







			text-decoration: none !important;







		}







		.header







		{







			float: left;







			width: 100%;







		}







		.min_width_375_px







		{







			min-width: 375px;







		}







		@media only screen and (max-width : 768px) {







			.min_width_375_px







			{







				min-width: 300px;







			}







		}







		.line_height_28







		{







			line-height: 28px !important;







		}







		.et_divi_theme .header







		{







			margin-bottom: 2%;







			margin-top: 2%;







			text-align: center;







		}







		.et_divi_theme .student_registraion_form input {







			line-height: 40px;







			border: 1px solid #bbb;







			margin-bottom: 10px;







		}







		.gym_registration_according



		{







			float: left;







			width: 100%;







			margin-top: 20px;







		}



		.height_53px{



			height: 43px !important;



		}



		@media (max-width: 768px)



		{



			.gym_registration_according



			{



				width: 100% !important;



				margin: 0% !important;



			}

			div.res_padding_10px {

				padding: 0 12px !important;

			}

			.wp-embed-responsive #loginform



			{



				text-align: initial;



			}



		}







	</style>







	<?php 







	$obj_class=new MJ_gmgt_classschedule; 







	$obj_member=new MJ_gmgt_member; 







	$obj_group=new MJ_gmgt_group;







	$obj_membership=new MJ_gmgt_membership;







	$edit = 0; 







	$role="member";







	$lastmember_id=MJ_gmgt_get_lastmember_id($role);







	$nodate=substr($lastmember_id,0,-4);







	$memberno=substr($nodate,1);







	$test=(int)$memberno+1;







	$newmember='SVC000';
	$user_query = get_users( array ( 'orderby' => 'ID', 'order' => 'DESC', 'number' => 1 ) );
	foreach ( $user_query as $user ) {
		$id = (int)$user->ID + 1;
		$newmember = $newmember . $id;
		// break;
	}
	$primaryId = "";
	if ( isset($_GET['check_id'] )) {
		$check_id_user = reset(
			get_users(
				array(
					'meta_key' => 'member_id',
					'meta_value' => $_GET['check_id'],
					'number' => 1,
				)
			)
		);

		if ( !empty( $check_id_user )) {
			
			$getId = get_user_meta( $check_id_user->ID, 'total_dependent',1);
			$primaryId =$_GET['check_id'];
			if ( $getId) {
				$getId = (int)$getId + 1;
				$newmember = $primaryId .'D'. $getId;
			} else {
				$newmember = $primaryId . 'D1';
			}
		} else {
			echo "Invalid Primary Id";
		}




	}

	

	?>		



	<script type="text/javascript">



		jQuery(document).ready(function($) 



		{



			$("button.multiselect").on("click", function () 



			{



				var opened = $(this).parent().hasClass("open");



				if (! opened) {



					$('.btn-group').addClass('open');



					$("button.multiselect").attr('aria-expanded', 'true');



				} else {



					$('.btn-group').removeClass('open');



					$("button.multiselect").attr('aria-expanded', 'false');



				}



			});



		});



	</script>



	<div class="student_registraion_form"><!-- MEMBER REGISTRATION DIV START-->







		<form id="registration_form" action="<?php echo $_SERVER['REQUEST_URI'];?>" method="post" enctype="multipart/form-data"><!-- MEMBER REGISTRATION FORM START-->







			<input type="hidden" name="role" value=""  />







			<input type="hidden" name="user_id" value=""  />







			<input type="hidden" class="user_coupon" name="coupon_id" value="" />







			<div class="accordion gym_registration_according" id="myAccordion">







				<div class="accordion-item class_border_div">







					<h2 class="accordion-header accordion_header_custom_css" id="headingOne" >







						<button type="button" class="accordion-button class_route_list frontend_div" data-bs-toggle="collapse" data-bs-target="#collapseOne" style="font-weight:800;"><?php esc_attr_e('Personal Information','gym_mgt');?> (<?php esc_attr_e('Required Section.','gym_mgt');?>)</button>									







					</h2>







					<div id="collapseOne" class="accordion-collapse collapse theme_page_addmission_form_padding show" data-bs-parent="#myAccordion">







						<div class="card-body_1">







							<div class="form-body user_form"> <!-- user_form Strat-->   


							
								<div class="row"><!--Row Div Strat-->
									<div class="col-md-12" id="primary-member-data">
										
									</div>
								</div>



								<div class="row"><!--Row Div Strat--> 







									<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">







										<div class="form-group input">







											<div class="col-md-12 form-control">







												<input id="member_id" class="form-control validate[required]" type="text" value="<?php if($edit){ echo $user_info->member_id;}else echo $newmember;?>"  readonly name="member_id">







												<label class="" for="member_id"><?php esc_html_e('Member Id','gym_mgt');?><span class="require-field">*</span></label>







											</div>







										</div>







									</div>



									<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">







										<div class="form-group input">







											<div class="col-md-12 form-control">






												<label class="ml-1 custom-top-label top" for="refered member_id"><?php esc_html_e('Member Type','gym_mgt');?><span class="require-field">*</span></label>


												<!-- <input id="member_type" class="form-control validate[custom[onlyLetter_specialcharacter]]" maxlength="50" type="text"  value="" name="member_type" placeholder="Primary / Dependent"> -->
												<select id="member_type" class="form-control" name="member_type" onchange="toggleDependentFields()">
												<option value="Select">Select Member Type</option>	
												<option value="Primary">Primary</option>
												<option value="Dependent" <?php echo !empty($primaryId) ? "selected": "";?>>Dependent</option>
												</select>		
												<input type="hidden" id="check_id_user" name="check_id_user" value="<?php echo !empty($primaryId) ?  $check_id_user->ID: "";?>"/>
												<div id="primary_id_div">
													<?php if( !empty( $primaryId) ) { ?>
													<br/>
													<span class="" for="primary_id"><?php esc_html_e('Primary Id','gym_mgt');?><span class="require-field">*</span></span>
													<input id="primary_id" class="form-control validate[required,custom[onlyLetter_specialcharacter]] text-input" maxlength="50" type="text" value="<?php echo esc_attr($primaryId);?>" name="primary_id">
					

													<?php } ?>
												</div>

											</div>







										</div>







									</div>



									<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">







										<div class="form-group input">







											<div class="col-md-12 form-control">







												<input id="first_name" class="form-control validate[required,custom[onlyLetter_specialcharacter]] text-input" maxlength="50" type="text" value="" name="first_name" required>







												<label class="" for="member_id"><?php esc_html_e('Full Name','gym_mgt');?><span class="require-field">*</span></label>







											</div>







										</div>







									</div>







									<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 res_margin_bottom_20px">







										<div class="form-group">







											<div class="col-md-12 form-control">







												<div class="row">







													<div class="input-group">







														<label class="custom-top-label" for="gender"><?php esc_html_e('Gender','gym_mgt');?><span class="require-field">*</span></label>







														<div class="d-inline-block gmgt_child_reg_gender gender_line_height_24px">







															<?php $genderval = "male"; if($edit){ $genderval=$user_info->gender; }elseif(isset($_POST['gender'])) {$genderval=$_POST['gender'];}?>







															<label class="radio-inline custom_radio">







																<input type="radio" value="male" class="tog" name="gender"  <?php  checked( 'male', $genderval);  ?>/><span class="ml_5"><?php esc_html_e('Male','gym_mgt');?></span>







															</label>







															<label class="radio-inline custom_radio">







																<input type="radio" value="female" class="tog" name="gender"  <?php  checked( 'female', $genderval);  ?>/><span class="ml_5"><?php esc_html_e('Female','gym_mgt');?> </span>







															</label>







														</div>







													</div>







												</div>		







											</div>







										</div>







									</div>







									<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">







										<div class="form-group input">







											<div class="col-md-12 form-control">







												<input id="email" class="form-control validate[required,custom[email]] text-input" maxlength="100" type="text"  name="email" value="" placeholder="Enter your mail-id" required>







												<label class="" for="member_id"><?php esc_html_e('Email','gym_mgt');?><span class="require-field">*</span></label>







											</div>







										</div>







									</div>







									<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">







										<div class="form-group input">







											<div class="col-md-12 form-control">







												<input id="password" class="form-control <?php if(!$edit) echo 'validate[required]';?>" type="password" minlength="8" maxlength="50"  name="password" value="" placeholder="Minimum 8 Character" required>







												<label class="" for="member_id"><?php esc_html_e('Password','gym_mgt');?><span class="require-field">*</span></label>







											</div>







										</div>







									</div>

									<div id="dependentFields">


									<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">







										<div class="form-group input">







											<div class="col-md-12 form-control" style="width:97%">







												<input id="last_name" class="form-control text-input" maxlength="50" type="text"  value="" name="last_name">







												<label class="" for="member_id"><?php esc_html_e('Rank','gym_mgt');?></label>







											</div>







										</div>







									</div>








									<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6" style="display: inline-block;">







										<div class="form-group input">







											<div class="col-md-12 form-control" style="margin-left: 3%;width: 97%;">







												<input id="unit_id" class="form-control text-input" maxlength="50" type="text"  value="">




												<label class="" for="member_id"><?php esc_html_e('Unit Number','gym_mgt');?></label>






											</div>







										</div>







									</div>







									<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">







										<div class="form-group input">







											<div class="col-md-12 form-control" style="width:97%">







												<input id="city_name" class="form-control" maxlength="50" type="text"  name="city_name" value="">







												<label class="" for="city_name"><?php esc_html_e('Unit Address','gym_mgt');?></label>







											</div>







										</div>







									</div>






									</div>







								</div>







							</div>







						</div>







					</div>







				</div>







				



					<div class="accordion-item class_border_div">







						<h2 class="accordion-header" id="headingThree">







							<button type="button" class="accordion-button class_route_list frontend_div collapsed" style="font-weight:800;" data-bs-toggle="collapse" data-bs-target="#collapseTwo"><?php esc_attr_e('Membership Information', 'gym_mgt'); ?> (<?php esc_attr_e('Required Section.','gym_mgt');?>)</a></button>                     







						</h2>







						<div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#myAccordion">







							<div class="card-body_1">







								<div class="form-body user_form"> <!-- user_form Strat-->   







									<div class="row"><!--Row Div Strat--> 







										<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 input">







											<label class="ml-1 custom-top-label top" for="refered"><?php esc_html_e('Membership','gym_mgt');?><span class="require-field">*</span></label>







											<?php 	







											$membershipdata=$obj_membership->MJ_gmgt_get_all_membership();?>







											<select name="membership_id" class="form-control coupon_membership_id validate[required] " id="membership_id">







											<?php


 



											if(isset($_REQUEST['membership_id']))







											{







												$membership_id=$_REQUEST['membership_id'];







												?>







												<option value="<?php echo $membership_id; ?>"><?php echo MJ_gmgt_get_membership_name($membership_id);?></option>







												<?php 







											}







											elseif(isset($_REQUEST['bookedclass_membershipid']))







											{







												$membership_id=$_REQUEST['bookedclass_membershipid'];







												







												if(!empty($membershipdata))







												{







													foreach ($membershipdata as $membership)







													{						







														echo '<option value='.esc_attr($membership->membership_id).' '.selected(esc_attr($membership_id),esc_attr($membership->membership_id)).'>'.esc_html($membership->membership_label).'</option>';







													}







												}







											}







											else







											{







												?>







												<option value=""><?php  esc_html_e('Select Membership ','gym_mgt');?></option>







												<?php 







												if(!empty($membershipdata))







												{







													foreach ($membershipdata as $membership)







													{						







														echo '<option value='.$membership->membership_id.' '.selected($staff_data,$membership->membership_id).'>'.$membership->membership_label.'</option>';







													}







												}







											}







											?>







											</select>







										</div>



										<?php 



											if($_REQUEST['save_member_front'] == "Registration" || empty(isset($_REQUEST['bookedclass_membershipid']) || isset($_REQUEST['membership_id'])))



											{



										?>



										<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 input_color res_margin_bottom_20px multiselect_validation_member smgt_multiple_select">







											<select id="classis_id_front" class="form-control validate[required] classis_ids height_53px" name="class_id[]" multiple="multiple">



											<option class="select_class" value="<?php echo $value->class_id; ?>"><?php echo esc_attr_e('Select Facilty','gym_mgt'); ?></option>



												<?php







												if(isset($_REQUEST['membership_id']))







												{







													global $wpdb;	







													$tbl_gmgt_membership_class = $wpdb->prefix."gmgt_membership_class";	







													$retrive_data = $wpdb->get_results("SELECT * FROM $tbl_gmgt_membership_class WHERE membership_id=".$_REQUEST['membership_id']);







													







													if(!empty($retrive_data))







													{







														foreach($retrive_data as $key=>$value)







														{







															?>







															<option value="<?php echo $value->class_id; ?>"><?php echo MJ_gmgt_get_class_name($value->class_id); ?></option>







															







															<?php







														}







													}						







												}







												elseif(isset($_REQUEST['bookedclass_membershipid']))







												{







													global $wpdb;	







													$tbl_gmgt_membership_class = $wpdb->prefix."gmgt_membership_class";	







													$retrive_data = $wpdb->get_results("SELECT * FROM $tbl_gmgt_membership_class WHERE membership_id=".$_REQUEST['bookedclass_membershipid']);







													if(!empty($retrive_data))







													{







														foreach($retrive_data as $key=>$value)







														{







															?>







															<option value="<?php echo $value->class_id; ?>" selected><?php echo MJ_gmgt_get_class_name($value->class_id); ?></option>







															<input type="hidden" name="membership_id" class="membership_hidden" value="<?php  echo $value->class_id;; ?>">







															<?php







														}







													}						







												}







												?>					







											</select>







										</div>







										<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">







											<div class="form-group input">







												<div class="col-md-12 form-control date_div">







													<input id="begin_date" class="form-control validate[required] begin_date date_picker date_class" type="text"  name="begin_date" value="" readonly>







													<label class="date_label" for="member_id"><?php esc_html_e('Membership Valid From','gym_mgt');?><span class="require-field">*</span></label>







												</div>







											</div>







										</div>







										<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">







											<div class="form-group input">







												<div class="col-md-12 form-control date_div">







													<input id="end_date" class="form-control validate[required] date_picker date_class" type="text" name="end_date" value="">







													<label class="date_label" for="member_id"><?php esc_html_e('Membership Valid To','gym_mgt');?></label>







												</div>







											</div>







										</div>



										<?php







										}







										?>



										<!-- <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 ">







											<div class="form-group input">







												<div class="col-md-12 form-control">







													<input id="coupon_code" class="form-control coupon_code" type="text" value="" name="coupon_code" >







													<label class="" for=""><?php esc_html_e('Add Coupon Code','gym_mgt');?></label>



													



												</div>



												



											</div>



										</div> -->



										



										<!-- <div class="col-sm-12 col-md-2 col-lg-2 col-xl-2 p-0 mb-3 res_padding_10px rtl_margin_top_15px">	







											<button id="" type="new_member" class="btn add_btn apply_coupon" ><?php esc_html_e('Apply','gym_mgt');?></button>



											



										</div> -->



										



										<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 discount_display">







											<div class="form-group input">







												<div class="col-md-12 form-control">







													<input id="coupon_discount" class="form-control" type="text" value="" name="discount" readonly>







													<label class="" for=""><?php esc_html_e('Discount','gym_mgt');?></label>







												</div>







											</div>







										</div>



										<span class="coupon_span"></span>







									</div>







								</div>







							</div>







						</div>







					</div>







					







				<div class="accordion-item class_border_div">







					<h2 class="accordion-header accordion_header_custom_css" id="headingOne" >







						<button type="button" class="accordion-button class_route_list frontend_div collapsed" data-bs-toggle="collapse" data-bs-target="#collapseThree" style="font-weight:800;"><?php esc_attr_e('Contact Information','gym_mgt');?></button>									







					</h2>







					<div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#myAccordion">







						<div class="card-body_1">







							<div class="form-body user_form"> <!-- user_form Strat-->   







								<div class="row"><!--Row Div Strat--> 







									<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">







										<div class="form-group input">







											<div class="col-md-12 form-control">







												<input id="address" class="form-control" maxlength="150" type="text"  name="address" value="">







												<label class="" for="address"><?php esc_html_e('Home Address','gym_mgt');?></label>







											</div>







										</div>







									</div>











									<!-- <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">







										<div class="form-group input">







											<div class="col-md-12 form-control">







												<input id="state_name" class="form-control validate[custom[city_state_country_validation]]" maxlength="50" type="text"  name="state_name" value="">







												<label class="" for="state_name"><?php esc_html_e('State','gym_mgt');?></label>







											</div>







										</div>







									</div> -->







									<!-- <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">







										<div class="form-group input">







											<div class="col-md-12 form-control">







												<input id="zip_code" class="form-control validate[custom[number]]" maxlength="15" type="text"  name="zip_code" value="">







												<label class="" for="member_id"><?php esc_html_e('Zip Code','gym_mgt');?></label>







											</div>







										</div>







									</div> -->







									<div class="col-md-6">







										<div class="row">







											<div class="col-md-4">







												<div class="form-group input margin_bottom_0">







													<div class="col-md-12 form-control">







														<input type="text" readonly value="+ <?php echo MJ_gmgt_get_countery_phonecode(get_option( 'gmgt_contry' ));?>"  class="form-control" name="phonecode">







														<label for="phonecode" class="pl-2"><?php esc_html_e('Code','gym_mgt');?></label>







													</div>											







												</div>







											</div>







											<div class="col-md-8">







												<div class="form-group input margin_bottom_0">







													<div class="col-md-12 form-control">







														<input id="mobile" class="form-control validate[required,custom[phone_number]] text-input" type="text"  name="mobile" minlength="6" maxlength="15"value="">







														<label class="" for="mobile"><?php esc_html_e('Mobile Number','gym_mgt');?><span class="require-field">*</span></label>







													</div>







												</div>







											</div>







										</div>







									</div>
									<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">







										<div class="form-group input">







											<div class="col-md-12 upload-profile-image-patient image_padding_0px">







												<div class="col-md-12 form-control upload-profile-image-frontend">	







													<label class="custom-control-label custom-top-label ml-2" for="photo"><?php esc_html_e('Profile Image','gym_mgt');?></label>







													<div class="col-sm-12 image_padding_0px">







														<input type="file" class="form-control margin_top_10 image_upload_line_height_24px" onchange="MJ_gmgt_fileCheck(this);" name="gmgt_user_avatar">







													</div>







												</div>







											</div>	







											<div class="clearfix"></div>







										</div>







									</div>







									<!-- <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">







										<div class="form-group input">







											<div class="col-md-12 form-control">







												<input id="phone" class="form-control validate[custom[phone_number]] text-input" type="text"  name="phone" minlength="6" maxlength="15" value="">







												<label class="" for="phone"><?php esc_html_e('Phone','gym_mgt');?></label>







											</div>







										</div>







									</div> -->







								</div>







							</div>







						</div>







					</div>







				</div>







				<!-- <div class="accordion-item class_border_div">







					<h2 class="accordion-header accordion_header_custom_css" id="headingOne" >







						<button type="button" class="accordion-button class_route_list frontend_div collapsed" data-bs-toggle="collapse" data-bs-target="#collapseFour" style="font-weight:800;"><?php esc_attr_e('Bank Account Details','gym_mgt');?></button>									







					</h2>







					<div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#myAccordion">







						<div class="card-body_1">







							<div class="form-body user_form"> 
								user_form Strat   







								<div class="row">
									Row Div Strat 







									<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">







										<div class="form-group input">







											<div class="col-md-12 form-control">







												<input id="weight" class="form-control registration_height_32px text-input" type="text" min="0"  onkeypress="if(this.value.length==100) return false;" step="0.01" value="" 	name="Name of Bank" >







												<label class="" for="address"><?php esc_html_e('Name of Bank','gym_mgt');?></label>







											</div>







										</div>







									</div>







									<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">







										<div class="form-group input">







											<div class="col-md-12 form-control">







												<input id="height" class="form-control registration_height_32px text-input" type="text" min="0"  onkeypress="if(this.value.length==100) return false;" step="0.01" value="" name="Name of Acc Holder">







												<label class="" for="city_name"><?php esc_html_e('Name of Acc Holder','gym_mgt');?></label>







											</div>







										</div>







									</div>







									<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">







										<div class="form-group input">







											<div class="col-md-12 form-control">







												<input id="Chest" class="form-control registration_height_32px text-input" type="text" min="0"  onkeypress="if(this.value.length==100) return false;" step="0.01" value="" name="Account No" >







												<label class="" for="state_name"><?php esc_html_e('Account No','gym_mgt');?></label>







											</div>







										</div>







									</div>







									<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">







										<div class="form-group input">







											<div class="col-md-12 form-control">







												<input id="waist" class="form-control registration_height_32px text-input" type="text" min="0"  onkeypress="if(this.value.length==100) return false;" step="0.01" value="" name="Name of Branch" >







												<label class="" for="zip_code"><?php esc_html_e('Name of Branch','gym_mgt');?></label>







											</div>







										</div>







									</div>







									<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">







										<div class="form-group input">







											<div class="col-md-12 form-control">







												<input id="thigh" class="form-control registration_height_32px text-input" type="text" min="0"  onkeypress="if(this.value.length==100) return false;" step="0.01" value="" name="IFSC Code" >







												<label class="" for="phone"><?php esc_html_e('IFSC Code','gym_mgt');?></label>







											</div>







										</div>







									</div>







									<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">







										<div class="form-group input">







											<div class="col-md-12 form-control">







												<input id="arms" class="form-control registration_height_32px text-input" type="number" min="0"  onkeypress="if(this.value.length==6) return false;" step="0.01" value="" name="arms" >







												<label class="" for="phone"><?php esc_html_e('Arms','gym_mgt');?></label>







											</div>







										</div>







									</div>







									<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">







										<div class="form-group input">







											<div class="col-md-12 form-control">







												<input id="fat" class="form-control registration_height_32px text-input" type="number" min="0" max="100"  onkeypress="if(this.value.length==6) return false;" step="0.01"value="">







												<label class="" for="phone"><?php esc_html_e('Fat','gym_mgt');?></label>







											</div>







										</div>







									</div>







								</div>







							</div>







						</div>







					</div>







				</div> -->







				<!-- <div class="accordion-item class_border_div">







					<h2 class="accordion-header accordion_header_custom_css" id="headingOne" >







						<button type="button" class="accordion-button class_route_list frontend_div collapsed" data-bs-toggle="collapse" data-bs-target="#collapseFive" style="font-weight:800;">
							<?php esc_attr_e('Family Members for whom want membership','gym_mgt');?>
						</button>									







					</h2>







					<div id="collapseFive" class="accordion-collapse collapse" data-bs-parent="#myAccordion">







						<div class="card-body_1">







							<div class="form-body user_form"> 
								user_form Strat   







								<div class="row">
									Row Div Strat 			







									<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 input">







										
										<input id="refered" class="form-control text-input" maxlength="50" type="text" value="" name="refered">




										<label class="" for="refered">
											<?php esc_html_e('Person 1 Name/Age','gym_mgt');?>
										</label>




									</div>







									<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 input">







										<input id="reference_id" class="form-control text-input" maxlength="50" type="text" value="" name="reference_id">




										<label class="" for="refered"><?php esc_html_e('Person 2 Name/Age','gym_mgt');?></label>








									</div>







									<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">







										<div class="form-group input">







											<div class="col-md-12 form-control">







												<input id="inqiury_date" class="form-control date_picker" type="text"  name="inqiury_date" value="" readonly>







												<label class="date_label" for="city_name"><?php esc_html_e('Inquiry Date','gym_mgt');?></label>







											</div>







										</div>







									</div>







									<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">







										<div class="form-group input">







											<div class="col-md-12 form-control">







												<input id="triel_date" class="form-control date_picker" type="text"  name="triel_date"  value="" readonly>







												<label class="date_label" for="state_name"><?php esc_html_e('Trial End Date','gym_mgt');?></label>







											</div>







										</div>







									</div>







									<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">







										<div class="form-group input">







											<div class="col-md-12 form-control">







												<input id="first_payment_date" class="form-control date_picker" type="text"  name="first_payment_date" value="" readonly>







												<label class="date_label" for="zip_code"><?php esc_html_e('First Payment Date','gym_mgt');?></label>







											</div>







										</div>







									</div>






									<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">







										<div class="form-group input">







											<div class="col-md-12 upload-profile-image-patient image_padding_0px">







												<div class="col-md-12 form-control upload-profile-image-frontend">	







													<label class="custom-control-label custom-top-label ml-2" for="photo"><?php esc_html_e('Profile Image','gym_mgt');?></label>







													<div class="col-sm-12 image_padding_0px">







														<input type="file" class="form-control margin_top_10 image_upload_line_height_24px" onchange="MJ_gmgt_fileCheck(this);" name="gmgt_user_avatar">







													</div>







												</div>







											</div>	







											<div class="clearfix"></div>







										</div>







									</div>	







								</div>







							</div>







						</div>







					</div>







				</div> -->







			</div>

			<script>
				let member_type = document.querySelector('#member_type');
				if (member_type) {
					function checkId(id){
						jQuery.ajax({
							type: 'POST',
							url:"<?php echo admin_url( 'admin-ajax.php' );?>",
							data: {
							"action": "gms_get_user_ajax",
							"check_id" : id
							},
							success: function (data) {
								let wrapper = document.querySelector('#primary-member-data');
								if( data?.error ) {
									alert(data.error);
									if ( wrapper ) {
										wrapper.innerHTML = "";
									}
								} else {
									let member_id = document.querySelector('#member_id');
									let htmlData = '<div>'
									if ( member_id) {
										member_id.value = data?.new_member_id;
									}
									let check_id_user = document.querySelector( '#check_id_user');
									if ( check_id_user) {
										check_id_user.value = data?.primary_user_id
										htmlData += "<div><strong>Primary Member Id: </strong><span>" + data?.primary_user_id + "</span></div>";
									}
									htmlData += "<div><strong>Primary Member name: </strong><span>" + data?.name + "</span></div>";
									htmlData += "<div><strong>Member Ship: </strong><span>" + data?.get_membership_type?.[0] + "</span></div>";
									htmlData += "<div><strong>Email: </strong><span>" + data?.email + "</span></div>";
									if ( wrapper ) {
										wrapper.innerHTML = htmlData + "<br/></div>"
									}
									let membership_id = document.querySelector('#membership_id');
									if (membership_id && data?.get_membership_type?.[1] ) {
										membership_id.value= data?.get_membership_type?.[1];
										membership_id.dispatchEvent(new Event('click'));
										membership_id.dispatchEvent(new Event('change', {bubbles:true}));
									}
									let begin_date = document.querySelector('#begin_date');
									if (begin_date && data?.begin_date ) {
										begin_date.value= data?.begin_date;
										membership_id.dispatchEvent(new Event('change', {bubbles:true}));
									}
									let end_date = document.querySelector('#end_date');
									if (end_date && data?.end_date ) {
										end_date.value= data?.end_date;
										membership_id.dispatchEvent(new Event('change', {bubbles:true}));
									}
								}
							}
						});
					}
					let primary_id_div = document.querySelector('#primary_id_div');
					member_type.addEventListener('change', (e) => {
						let member_id = document.querySelector('#member_id');
						if ( e.target.value === "Dependent") {
							member_id.value = member_id.value + "D1";
							primary_id_div.innerHTML = `<br/><span class="" for="primary_id">Enter Primary Id<span class="require-field">*</span></span><input id="primary_id" class="form-control text-input" maxlength="50" type="text" value="" name="primary_id"><br/><a href="javascript:void(0);" class="btn save_btn" style="margin-top:5px; display:inline-block;" id="check_primary_id">Check</a> <br/><br/> 
							<div><span class="" for="primary_id">Relation<span class="require-field">*</span><input id="relation" class="form-control validate[custom[city_state_country_validation]]" required type="text" name="relation" value=""></div>`;
							
						} else {
							member_id.value = member_id.value.replace("D1", "")
							primary_id_div.innerHTML = ""
						}
					});

					primary_id_div.addEventListener("click", (e)=> {
						let primary_id = document.querySelector('#primary_id');
						if( e.target.id === "check_primary_id") {
							if ( primary_id.value.length ) {
								checkId(primary_id.value);
								// let url = new URL(window.location.href);
								// url.searchParams.set("check_id",primary_id.value)
								// window.location.href =url.href;
							} else {
								alert("Please Enter Primary Id")
							}
						}
					})
				}
				function toggleDependentFields() {
					var memberType = document.getElementById("member_type").value;
					var dependentFields = document.getElementById("dependentFields");

					if (memberType === "Dependent") {
					dependentFields.style.display = "none";
					} else {
					dependentFields.style.display = "block";
					}
				}
			</script>






			<?php







			if(isset($_REQUEST['bookedclass_membershipid']) && $_REQUEST['action'] == 'frontend_book')







			{







				global $wpdb;	







				$tbl_gmgt_membership_class = $wpdb->prefix."gmgt_membership_class";	







				$retrive_data = $wpdb->get_results("SELECT * FROM $tbl_gmgt_membership_class WHERE membership_id=".$_REQUEST['bookedclass_membershipid']);







				if(!empty($retrive_data))







				{







					foreach($retrive_data as $key=>$value)







					{







						?>







						<input type="hidden" name="class_id_hidden[]" class="membership_hidden" value="<?php  echo $value->class_id; ?>">







						<?php







					}







				}						







				$joiningdate=date("Y-m-d");







				$membership_id = $_REQUEST['bookedclass_membershipid'];







				$obj_membership=new MJ_gmgt_membership;	







				$membership=$obj_membership->MJ_gmgt_get_single_membership($membership_id);







				$validity=$membership->membership_length_id;







				$expiredate= date(MJ_gmgt_get_phpdateformat(get_option('gmgt_datepicker_format')), strtotime($joiningdate. ' + '.$validity.' days'));







				?>







				<input type="hidden" name="start_date_hidden" value="<?php  echo date(MJ_gmgt_get_phpdateformat(get_option('gmgt_datepicker_format'))); ?>">







				<input type="hidden" name="end_date_hidden" value="<?php  echo $expiredate; ?>">







				<input type="hidden" name="membership_id_hidden" value="<?php  echo $membership_id; ?>">







				<?php







			}







			if(isset($_REQUEST['class_id']) && isset($_REQUEST['membership_id']) && $_REQUEST['action'] == 'frontend_class_book_with_membership_id')







			{







				?>







				<input type="hidden" name="class_id_hidden[]" class="membership_hidden" value="<?php  echo $_REQUEST['class_id']; ?>">







				<?php







				$joiningdate=date("Y-m-d");







				$membership_id = $_REQUEST['membership_id'];







				$class_id1 = $_REQUEST['class_id'];







				$obj_membership=new MJ_gmgt_membership;	







				$membership=$obj_membership->MJ_gmgt_get_single_membership($membership_id);







				$validity=$membership->membership_length_id;







				$expiredate= date(MJ_gmgt_get_phpdateformat(get_option('gmgt_datepicker_format')), strtotime($joiningdate. ' + '.$validity.' days'));







				?>







				<input type="hidden" name="startTime_1" value="<?php  echo $_REQUEST['startTime_1']; ?>">







				<input type="hidden" name="class_date" value="<?php  echo $_REQUEST['class_date']; ?>">







				<input type="hidden" name="day_id1" value="<?php  echo $_REQUEST['day_id1']; ?>">







				<input type="hidden" name="bookedclass_membershipid" value="<?php  echo $_REQUEST['bookedclass_membershipid']; ?>">







				<input type="hidden" name="Remaining_Member_limit_1" value="<?php  echo $_REQUEST['Remaining_Member_limit_1']; ?>">







				<input type="hidden" name="start_date_hidden" value="<?php  echo date(MJ_gmgt_get_phpdateformat(get_option('gmgt_datepicker_format'))); ?>">







				<input type="hidden" name="end_date_hidden" value="<?php  echo $expiredate; ?>">







				<input type="hidden" name="membership_id_hidden" value="<?php  echo $membership_id; ?>">







				<input type="hidden" name="class_id1" value="<?php  echo $class_id1; ?>">







			<?php







			}







			if(isset($_REQUEST['membership_id']) && isset($_REQUEST['class_id']) && isset($_REQUEST['action']) && $_REQUEST['action'] == 'fronted_membership')







			{ ?>







				<input type="hidden" name="class_id_hidden[]" class="membership_hidden" value="<?php  echo $_REQUEST['class_id']; ?> ">







						<?php







			}







			if(isset($_REQUEST['membership_id']) && isset($_REQUEST['action']) && $_REQUEST['action'] == 'fronted_membership')







			{







				global $wpdb;	







				$tbl_gmgt_membership_class = $wpdb->prefix."gmgt_membership_class";	







				$retrive_data = $wpdb->get_results("SELECT * FROM $tbl_gmgt_membership_class WHERE membership_id=".$_REQUEST['membership_id']);







				if(!empty($retrive_data))







				{







					foreach($retrive_data as $key=>$value)







					{







						?>







						<input type="hidden" name="class_id_hidden[]" class="membership_hidden" value="<?php  echo $value->class_id;; ?>">







						<?php







					}







				}						







				$joiningdate=date("Y-m-d");







				$membership_id = $_REQUEST['membership_id'];







				$obj_membership=new MJ_gmgt_membership;	







				$membership=$obj_membership->MJ_gmgt_get_single_membership($membership_id);







				$validity=$membership->membership_length_id;







				$expiredate= date(MJ_gmgt_get_phpdateformat(get_option('gmgt_datepicker_format')), strtotime($joiningdate. ' + '.$validity.' days'));







				?>







				<input type="hidden" name="start_date_hidden" value="<?php  echo date(MJ_gmgt_get_phpdateformat(get_option('gmgt_datepicker_format'))); ?>">







				<input type="hidden" name="end_date_hidden" value="<?php  echo $expiredate; ?>">







				<input type="hidden" name="membership_id_hidden" value="<?php  echo $membership_id; ?>">







				<?php







  			}



 



			?> 







			<div class="col-sm-6 avada_width_100_per gmgt_child_theme_reg_btn"> 







				<input type="submit" value="<?php esc_html_e('Registration','gym_mgt');?>" name="save_member_front" class="btn save_btn_line_height_14px save_btn"/>







			</div>







		</form><!-- MEMBER REGISTRATION FORM END-->







	</div><!-- MEMBER REGISTRATION DIV END-->







	<?php







}







//MEMBER RAGISTATION FUNCTION 







function MJ_gmgt_member_registration_function() 







{







	error_reporting(0);







	global $class_name,$first_name,$member_type,$last_name,$gender,$birth_date,$address,$city_name,$state_name,$zip_code,$mobile_number,$alternet_mobile_number,$phone,$email,$username,$password,$gmgt_user_avatar,$member_id,$weight,$height,$chest,$waist,$thigh,$arms,$fat,$intrest_area,$member_convert,$source,$reference_id,$inqiury_date,$membership_id,$begin_date,$end_date,$first_payment_date,$group_id,$staff_id;







	$class_name = isset($_POST['class_id'])?$_POST['class_id']:'';







	  //SAVE FRONTED MEMBER DATA 







    if ( isset($_POST['save_member_front'] ) )



	{		



		



		if(isset($_POST['class_id']))







        {







			$class_id= $_POST['class_id'];







		}







		else







		{







			$class_id= $_POST['class_id_hidden'];







		}







		if(isset($_POST['membership_id']))







        {







			$membership_id= $_POST['membership_id'];







		}







		else







		{







			$membership_id= $_POST['membership_id_hidden'];







		}



		



		if(isset($_POST['begin_date']))







        {







			$begin_date= $_POST['begin_date'];







		}







		else







		{







			$begin_date= $_POST['start_date_hidden'];







		}







		if(isset($_POST['end_date']))







        {







			$end_date= $_POST['end_date'];







		}







		else







		{







			$end_date= $_POST['end_date_hidden'];







		}



		







		







		MJ_gmgt_registration_validation(







		







		







		$class_id,







		$_POST['first_name'],







		$_POST['last_name'],







		$_POST['gender'],







		$_POST['email'],







        $_POST['password'],        







		$membership_id,







		$begin_date,







		$end_date







		







		 );







		 







        // sanitize user form input//







        global $class_name,$first_name,$member_type,$last_name,$gender,$birth_date,$address,$city_name,$state_name,$zip_code,$mobile_number,$coupon_id,$alternet_mobile_number,$phone,$email,$username,$password,$gmgt_user_avatar,$member_id,$weight,$height,$chest,$waist,$thigh,$arms,$fat,$intrest_area,$member_convert,$source,$reference_id,$inqiury_date,$membership_id,$begin_date,$end_date,$first_payment_date,$group_id;







		







        if(isset($_POST['class_id']))







		{ 







			$class_name =$_POST['class_id']; 







		} 







		elseif(isset($_POST['class_id_hidden']))







		{







			$class_name =$_POST['class_id_hidden']; 







		}







		else







		{ 







			echo $class_name =""; 







		} 







		







		$first_name =    MJ_gmgt_strip_tags_and_stripslashes($_POST['first_name']) ;







		$member_type =   MJ_gmgt_strip_tags_and_stripslashes($_POST['member_type']) ;







		$last_name =  MJ_gmgt_strip_tags_and_stripslashes($_POST['last_name']);







		$gender =   $_POST['gender'] ;







		if(isset($_POST['birth_date']))







		{







			$birth_date =   $_POST['birth_date'] ;







		}







		if(isset($_POST['address']))







		{







			$address =   MJ_gmgt_strip_tags_and_stripslashes($_POST['address']);







		}







		if(isset($_POST['city_name']))







		{







			$city_name =    MJ_gmgt_strip_tags_and_stripslashes($_POST['city_name']);







		}







		if(isset($_POST['state_name']))







		{







			$state_name =   MJ_gmgt_strip_tags_and_stripslashes($_POST['state_name']);







		}







		if(isset($_POST['zip_code']))







		{







			$zip_code =   MJ_gmgt_strip_tags_and_stripslashes($_POST['zip_code']);







		}







		if(isset($_POST['mobile']))







		{







			$mobile_number =   $_POST['mobile'] ;







		}







		// FOR DISCOUNT



		if(isset($_POST['coupon_id']))



		{



			$coupon_id = $_POST['coupon_id'];



		}



		



		



		if(!empty($_POST['group_id']))







			$group_id =   $_POST['group_id'] ;







		else







			$group_id=array();







		







		$phone =   $_POST['phone'] ;		







	







        $password   =    MJ_gmgt_password_validation($_POST['password']);







        $email      =    MJ_gmgt_strip_tags_and_stripslashes($_POST['email']);







        $gmgt_user_avatar      = $_FILES['gmgt_user_avatar'] ;







        $member_id      =    $_POST['member_id'] ;







        $weight      =    $_POST['weight'] ;







        $height      =    $_POST['height'] ;







        $chest      =    $_POST['chest'] ;







        $waist      =    $_POST['waist'] ;







        $thigh      =    $_POST['thigh'] ;







        $arms      =    $_POST['arms'] ;







		if(isset($_POST['fat']))







		{







			$fat      =    $_POST['fat'] ;







        }







		$intrest_area      =    $_POST['intrest_area'] ;







		







        







        $source      =    $_POST['source'] ;







        $reference_id      =    $_POST['reference_id'] ;







        $inqiury_date      =    $_POST['inqiury_date'] ;







		







		if(isset($_POST['membership_id']))







		{







			$membership_id      =    $_POST['membership_id'] ;







		}







		else







		{







			$membership_id   =   $_POST['membership_id_hidden'] ;







		}







		







		if(isset($_POST['begin_date']))







		{







			$begin_date      =    $_POST['begin_date'] ;







		}







		else







		{







			$begin_date   =   $_POST['start_date_hidden'] ;







		}







		







		if(isset($_POST['end_date']))







		{







			$end_date =  $_POST['end_date'] ;







		}







		else







		{







			$end_date =  $_POST['end_date_hidden'] ;







		}







		







		







      







		if(isset($_POST['first_payment_date']))







		{







			$first_payment_date      =    $_POST['first_payment_date'] ;







		}







        



       







        // call @function complete_registration to create the user







        // only when no WP_error is found



		



        $result = MJ_gmgt_complete_registration(







        $class_name,$first_name,$member_type,$last_name,$gender,$birth_date,$address,$city_name,$state_name,$zip_code,$mobile_number,$coupon_id,$alternet_mobile_number,$phone,$email,$username,$password,$gmgt_user_avatar,$member_id,$weight,$height,$chest,$waist,$thigh,$arms,$fat,$intrest_area,$source,$reference_id,$inqiury_date,$membership_id,$begin_date,$end_date,$first_payment_date,$group_id







        );







	 }







	MJ_gmgt_registration_form(







       $class_name,$first_name,$member_type,$last_name,$gender,$birth_date,$address,$city_name,$state_name,$zip_code,$mobile_number,$coupon_id,$alternet_mobile_number,$phone,$email,$password,$gmgt_user_avatar,$member_id,$weight,$height,$chest,$waist,$thigh,$arms,$fat,$intrest_area,$source,$reference_id,$inqiury_date,$membership_id,$begin_date,$end_date,$first_payment_date,$group_id);















}



//REGISTRATION Completed FUNCTION



function MJ_gmgt_complete_registration($class_name,$first_name,$member_type,$last_name,$gender,$birth_date,$address,$city_name,$state_name,$zip_code,$mobile_number,$coupon_id,$alternet_mobile_number,$phone,$email,$password,$gmgt_user_avatar,$member_id,$weight,$height,$chest,$waist,$thigh,$arms,$fat,$intrest_area,$source,$reference_id,$inqiury_date,$membership_id,$begin_date,$end_date,$first_payment_date,$group_id)



{



	



	



	 $obj_member=new MJ_gmgt_member;    







	 global $reg_errors;







	 global $wpdb;







	 global $class_name,$first_name,$member_type,$last_name,$gender,$birth_date,$address,$city_name,$state_name,$zip_code,$mobile_number,$coupon_id,$alternet_mobile_number,$phone,$email,$password,$gmgt_user_avatar,$member_id,$weight,$height,$chest,$waist,$thigh,$arms,$fat,$intrest_area,$source,$reference_id,$inqiury_date,$membership_id,$begin_date,$end_date,$first_payment_date,$group_id,$staff_id;







	 $smgt_avatar = '';	







    if ( 1 > count( $reg_errors->get_error_messages() ) ) 







	{







        $userdata = array(







        'user_login'    =>   $email,







        'user_email'    =>   $email,







        'user_pass'     =>   $password,







        'user_url'      =>   NULL,







        'first_name'    =>   $first_name,







        'last_name'     =>   $last_name,







        'nickname'      =>   NULL







        );







        







		$user_id = wp_insert_user( $userdata );







	







 		$user = new WP_User($user_id);







		$user->set_role('member');







		$smgt_avatar = '';







		$table_gmgt_groupmember = $wpdb->prefix.'gmgt_groupmember';







		if($_FILES['gmgt_user_avatar']['size'] > 0)







		{







			$gmgt_avatar_image = MJ_gmgt_user_avatar_image_upload('gmgt_user_avatar');







			$gmgt_avatar = content_url().'/uploads/gym_assets/'.$gmgt_avatar_image;







		}







		else







		{







			$gmgt_avatar = '';







		}







	





		$extra = $member_type === "Dependent" ? "D1":"";
		$getId = 1;
		$newmember = "";
		if ( !empty($_POST['check_id_user']) && $member_type === "Dependent" ) {
			$check_id_user = $_POST['check_id_user'];
			$getId = get_user_meta( $check_id_user, 'total_dependent',1);
			$primaryId =$_POST['primary_id'];
			if ( $getId) {
				$getId = (int)$getId + 1;
				$newmember = $primaryId .'D'. $getId;
			} else {
				$getId = 1;
				$newmember = $primaryId . 'D1';
			}
			update_user_Meta( $check_id_user, 'total_dependent', $getId );
			
			if ( ! empty( $_POST['relation'] ) ) {
				update_user_Meta( $user_id, 'relation', $_POST['relation'] );
			}
		}
		$user_id_add = $member_type === "Dependent" ? $newmember : "SVC000".$user_id;
		$usermetadata=array(					







			'member_type'=>$member_type,







			'gender'=>$gender,







			'birth_date'=>$birth_date,







			'address'=>$address,







			'city_name'=>$city_name,







			'state_name'=>$state_name,







			'zip_code'=>$zip_code,			







			'phone'=>$phone,







			'mobile'=>$mobile_number,







			'gmgt_user_avatar'=>$gmgt_avatar,







			'member_id'=> $user_id_add,







			'member_type'=>'Member',







			'height'=>$height,







			'weight'=>$weight,







			'chest'=>$chest,







			'waist'=>$waist,







			'thigh'=>$thigh,







			'arms'=>$arms,







			'fat'=>$fat,







			







			'intrest_area'=>$intrest_area,







			'source'=>$source,







			'reference_id'=>$reference_id,







			'inqiury_date'=>$inqiury_date,







			'membership_id'=>$membership_id,







			'begin_date'=>$begin_date,







			'end_date'=>$end_date,







			'first_payment_date'=>$first_payment_date);







		







		foreach($usermetadata as $key=>$val)







		{		







			update_user_meta( $user_id, $key,$val );	







		}	

		






		







		global $wpdb;







		$table_gmgt_member_class = $wpdb->prefix. 'gmgt_member_class';







		$memclss['member_id']=$user_id;







		







		foreach($class_name as $key=>$class)







		{







			$memclss['class_id']=$class;







			$result = $wpdb->insert($table_gmgt_member_class,$memclss);			







		} 







		







		if(!empty($group_id))







		{







			if($obj_member->MJ_gmgt_member_exist_ingrouptable($user_id))







				$obj_member->MJ_gmgt_delete_member_from_grouptable($user_id);







			foreach($group_id as $id)







			{







				$group_data['group_id']=$id;







				$group_data['member_id']=$user_id;







				$group_data['created_date']=date("Y-m-d");







				$group_data['created_by']=$user_id;







				$wpdb->insert( $table_gmgt_groupmember, $group_data );







			}







		}







		// Member Approves option //







		if(get_option('gmgt_member_approve') == 'yes')







		{				  







		  $hash = md5( rand(0,1000) );







		  update_user_meta( $user_id, 'gmgt_hash', $hash );







		} 







       // End Member Approve option //		


		  $user_info = get_userdata($user_id);


			if(!empty($user_id))


			{

				$gymname=get_option( 'gmgt_system_name' );

				$to = $user_info->user_email;         

				$subject = get_option('registration_title'); 

				$sub_arr['[GMGT_GYM_NAME]']=$gymname;

				$subject = MJ_gmgt_subject_string_replacemnet($sub_arr,$subject);

				$search=array('[GMGT_MEMBERNAME]','[GMGT_MEMBERID]','[GMGT_STARTDATE]','[GMGT_ENDDATE]','[GMGT_MEMBERSHIP]','[EMAIL_ID]','[PASSWORD]','[GMGT_GYM_NAME]', '[BARCODE_URL]');

				$membership_name=MJ_gmgt_get_membership_name($membership_id);

				$url = site_url() . "/customer-details/?accountant_id=" . $user_id;

				$url = "https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=".urlencode( $url)."&choe=UTF-8";

				$replace = array($user_info->display_name,$user_info->member_id,$begin_date,$end_date,$membership_name,$user_info->user_email,$password,get_option( 'gmgt_system_name' ), $url );

				$message_replacement = str_replace($search, $replace,get_option('registration_mailtemplate'));

				MJ_gmgt_send_mail($to,$subject,$message_replacement);	

			}

		//------------- SMS SEND -------------//

		$gymname=get_option( 'gmgt_system_name' );		

		$message_content ="You are successfully registered at ".$gymname;

		$mobile_number_new=array(); 

		$mobile_number_new[] = "+".MJ_gmgt_get_countery_phonecode(get_option( 'gmgt_contry' )).$mobile_number;

		$user_info = get_userdata($user_id);	 

			$current_sms_service 	= 	get_option( 'gmgt_sms_service');

			include_once(ABSPATH.'wp-admin/includes/plugin.php');

			if(is_plugin_active('sms-pack/sms-pack.php'))

			{

				$args = array();

				$args['mobile']=$mobile_number_new;



				$args['message_from']="notice";



				$args['message']=$message_content;		







				if($current_sms_service=='telerivet' || $current_sms_service ="MSG91" || $current_sms_service=='bulksmsgateway.in' || $current_sms_service=='textlocal.in' || $current_sms_service=='bulksmsnigeria' || $current_sms_service=='africastalking' || $current_sms_service == 'clickatell')







				{				







					$send = send_sms($args);							







				}







			}







			else







			{							







				$reciever_number = $user_info->mobile;		







				$message_content ="You are successfully registered at ".$gymname;







				if($current_sms_service == 'clickatell')







				{







					$clickatell=get_option('gmgt_clickatell_sms_service');







					$to = $reciever_number;







					$message = str_replace(" ","%20",$message_content);







					$username = $clickatell['username']; //clickatell username







					$password = $clickatell['password']; // clickatell password







					$api_key = $clickatell['api_key'];//clickatell apikey







					$baseurl ="http://api.clickatell.com";									







					$url = "$baseurl/http/auth?user=$username&password=$password&api_id=$api_key";									







					$ret = file($url);									







					$sess = explode(":",$ret[0]);







					if ($sess[0] == "OK")







					{







						$sess_id = trim($sess[1]); // remove any whitespace







						$url = "$baseurl/http/sendmsg?session_id=$sess_id&to=$to&text=$message";									







						$ret = file($url);







						$send = explode(":",$ret[0]);										







					}				







				}







				if($current_sms_service == 'msg91')







				{







					//MSG91







					$mobile_number= $user_info->mobile;







					$country_code="+".MJ_gmgt_get_countery_phonecode(get_option( 'gmgt_contry' ));



					



					$message = $message_content; // Message Text







					gmgt_msg91_send_mail_function($mobile_number,$message,$country_code);







				}								







			}







		







	    if(get_option('gmgt_member_approve')=='yes')







	    {







			echo '<p class="registration_after_show_word_success">'.esc_html__("Registration Complete. You can login after admin Approves.","gym_mgt").'</p>'; 







		







	   }







	   else







	   {







		echo '<p class="registration_after_show_word_success">'.esc_html__("Registration Complete.","gym_mgt").'</p>';







       	   







	   }







		$enable_payment=get_option('gym_enable_Registration_Without_Payment');







		







		if($user_id)







		{







			$obj_membership=new MJ_gmgt_membership;



			



			$retrieved_data=$obj_membership->MJ_gmgt_get_single_membership($membership_id);	



			if($enable_payment == 'yes')







			{







				if($retrieved_data->membership_amount > 0)







				{







					if((isset($_REQUEST['action'])&& $_REQUEST['action']=='frontend_book'))







					{



						



						$page_id = get_option ('gmgt_membership_pay_page');







						$referrer_ipn = array(				







							'page_id' => $page_id,







							'user_id' => $user_id,







							'coupon_id' => $coupon_id,







							'membership_id'=>$membership_id,







							'action'=>$_REQUEST['action'],







							'class_id1'=>$_REQUEST['class_id1'],







							'startTime_1'=>$_REQUEST['startTime_1'],







							'class_date'=>$_REQUEST['class_date'],







							'day_id1'=>$_REQUEST['day_id1'],







							'bookedclass_membershipid'=>$_REQUEST['bookedclass_membershipid'],







							'Remaining_Member_limit_1'=>$_REQUEST['Remaining_Member_limit_1'],







							'action_frontend'=>'frontend_book');







						$referrer_ipn = add_query_arg( $referrer_ipn, home_url() );



						



						wp_redirect ($referrer_ipn);	







						exit;







					}







					elseif((isset($_REQUEST['action'])&& $_REQUEST['action']=='frontend_class_book_with_membership_id'))







					{



						



						//--------------- frontend_class_book_with_membership_id ---------------//







						$page_id = get_option ('gmgt_membership_pay_page');







						$referrer_ipn = array(				







							'page_id' => $page_id,







							'user_id' => $user_id,







							'coupon_id' => $coupon_id,







							'membership_id'=>$membership_id,







							'action'=>"frontend_book",







							'class_id1'=>$_REQUEST['class_id1'],







							'startTime_1'=>$_REQUEST['startTime_1'],







							'class_date'=>$_REQUEST['class_date'],







							'day_id1'=>$_REQUEST['day_id1'],







							'bookedclass_membershipid'=>$_REQUEST['bookedclass_membershipid'],







							'Remaining_Member_limit_1'=>$_REQUEST['Remaining_Member_limit_1']







							);



						$referrer_ipn = add_query_arg( $referrer_ipn, home_url() );



						



						wp_redirect ($referrer_ipn);	







						exit;







					}







					else







					{







						$page_id = get_option ('gmgt_membership_pay_page');







						$referrer_ipn = array(				







							'page_id' => $page_id,







							'user_id' => $user_id,







							'coupon_id' => $coupon_id,







							'membership_id'=>$membership_id);







						$referrer_ipn = add_query_arg( $referrer_ipn, home_url() );







						wp_redirect ($referrer_ipn);	







						exit;







					}







				}	







				elseif((isset($_REQUEST['action'])&& $_REQUEST['action']=='frontend_book'))







				{







					$page_id = get_option ('gmgt_membership_pay_page');







					$referrer_ipn = array(				







						'page_id' => $page_id,







						'user_id' => $user_id,







						'coupon_id' => $coupon_id,







						'membership_id'=>$membership_id,







						'action'=>$_REQUEST['action'],







						'class_id1'=>$_REQUEST['class_id1'],







						'startTime_1'=>$_REQUEST['startTime_1'],







						'class_date'=>$_REQUEST['class_date'],







						'day_id1'=>$_REQUEST['day_id1'],







						'bookedclass_membershipid'=>$_REQUEST['bookedclass_membershipid'],







						'Remaining_Member_limit_1'=>$_REQUEST['Remaining_Member_limit_1'],







						'action_frontend'=>'frontend_book'







						);







					$referrer_ipn = add_query_arg( $referrer_ipn, home_url() );



						



					wp_redirect ($referrer_ipn);	







					exit;







				}







				else







				{







					//Free Membership process







					$membership_id = $membership_id;







					$amount = 0;







					$coupon_id = $coupon_id;



					



					$member_id = $user_id;







					$trasaction_id ='';







					$payment_method='-';







					$result=MJ_gmgt_frontend_side_membership_payment_function($membership_id,$coupon_id,$member_id,$amount,$trasaction_id,$payment_method);







				}				







			}







			else







			{



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







					$membership_status = 'continue';







					$payment_data = array();







					$payment_data['invoice_no']=$invoice_no;







					$payment_data['member_id'] = $user_id;







					$payment_data['membership_id'] = $membership_id;







					$payment_data['membership_fees_amount'] = MJ_gmgt_get_membership_price($membership_id);







					$payment_data['membership_signup_amount'] = MJ_gmgt_get_membership_signup_amount($membership_id);


					// Apply Counpon or not



					if(!empty($coupon_id))



					{



						$payment_data['coupon_id'] = $coupon_id;



						$tax_amount = MJ_gmgt_after_discount_tax_amount_by_membership_id($membership_id,$coupon_id,'');



						$payment_data['discount_amount'] = get_discount_amount_by_membership_id($membership_id,$coupon_id,'');



					}



					else{



						$payment_data['coupon_id'] = '';



						$payment_data['discount_amount'] = '';



						 $tax_amount = MJ_gmgt_get_membership_tax_amount($membership_id,'');



					}


					$payment_data['tax_amount'] = number_format($tax_amount,2);




					$membership_amount= (int)$payment_data['membership_fees_amount'] + (int)$payment_data['membership_signup_amount'] - (float)$payment_data['discount_amount'] + $payment_data['tax_amount'];







					$payment_data['membership_amount'] = $membership_amount;







					$payment_data['start_date'] = MJ_gmgt_get_format_for_db($begin_date);







					$payment_data['end_date'] = MJ_gmgt_get_format_for_db($end_date);







					$payment_data['membership_status'] = $membership_status;







					$payment_data['payment_status']='Unpaid';







					$payment_data['created_date'] = date("Y-m-d");







					$payment_data['created_by'] = get_current_user_id();







					$payment_data['coupon_usage_id'] = '';



					



					$payment_data['tax_id'] = MJ_gmgt_get_membership_tax($membership_id);







					$plan_id=MJ_gmgt_add_membership_payment_details($payment_data);







					// ADD DATA TO COUPON USAGE



					$obj_coupon=new MJ_gmgt_coupon;



					$coupon_data = $obj_coupon->MJ_gmgt_get_single_coupondata($coupon_id);



					$couponusage_data = array();



					$couponusage_data['member_id'] = $user_id;



					$couponusage_data['mp_id'] = $plan_id;



					$couponusage_data['membership_id'] = sanitize_text_field($membership_id);



					$couponusage_data['coupon_id'] = sanitize_text_field($coupon_id);



					$couponusage_data['coupon_usage'] = '';



					$couponusage_data['discount_type'] = $coupon_data->discount_type;



					$couponusage_data['discount_amount'] = $coupon_data->discount;



					$couponusage_id = MJ_gmgt_add_coupon_usage_details($couponusage_data);











					// =================Send Invoice ==============







					$insert_id=$plan_id;



					



					



					$paymentlink=home_url().'?dashboard=user&page=membership_payment';







					$gymname=get_option( 'gmgt_system_name' );



					







					$userdata=get_userdata(sanitize_text_field($user_id));



				



					



					$arr['[GMGT_USERNAME]']=$userdata->display_name;	







					$arr['[GMGT_GYM_NAME]']=$gymname;







					$arr['[GMGT_PAYMENT_LINK]']=$paymentlink;



					







					$subject =get_option('generate_invoice_subject');







					$sub_arr['[GMGT_GYM_NAME]']=$gymname;







					$subject = MJ_gmgt_subject_string_replacemnet($sub_arr,$subject);



					







					$message = get_option('generate_invoice_template');	







					$message_replacement = MJ_gmgt_string_replacemnet($arr,$message);



					



					$to=$userdata->user_email;







					$type='membership_invoice';



					



					if(get_option("gym_enable_notifications") == "yes")



					{



						$send_mail = MJ_gmgt_send_invoice_generate_mail($to,$subject,$message_replacement,$insert_id,$type);



                        



					}











					// ===============End Send Invoice===========







					//save membership payment data into income table			







					$table_income=$wpdb->prefix.'gmgt_income_expense';







					$membership_name=MJ_gmgt_get_membership_name($membership_id);







					$entry_array[]=array('entry'=>$membership_name,'amount'=>MJ_gmgt_get_membership_price($membership_id));	







					$entry_array1[]=array('entry'=>esc_html__("Membership Signup Fee","gym_mgt"),'amount'=>MJ_gmgt_get_membership_signup_amount($membership_id));	







					$entry_array_merge=array_merge($entry_array,$entry_array1);







					$incomedata['entry']=json_encode($entry_array_merge);	







					







					$incomedata['invoice_type']='income';







					$incomedata['invoice_label']=esc_html__("Fees Payment","gym_mgt");







					$incomedata['supplier_name']=$user_id;







					$incomedata['invoice_date']=date('Y-m-d');







					$incomedata['receiver_id']=get_current_user_id();					







					$incomedata['amount']=MJ_gmgt_get_membership_price($membership_id) + MJ_gmgt_get_membership_signup_amount($membership_id);					



					$incomedata['total_amount'] = $membership_amount;



					// APPLY COUPON CODE



					if(!empty($coupon_id)){



						$incomedata['tax'] = MJ_gmgt_after_discount_tax_amount_by_membership_id($membership_id,$coupon_id,'');



						$incomedata['discount'] = get_discount_amount_by_membership_id($membership_id,$coupon_id,'');



					}







					else{



						$incomedata['discount'] = '';



						$incomedata['tax'] = MJ_gmgt_get_membership_tax_amount($membership_id,'');



					}







					$incomedata['invoice_no']=$invoice_no;







					$incomedata['tax_id']=MJ_gmgt_get_membership_tax($membership_id);







					$incomedata['paid_amount']=0;







					$incomedata['payment_status']='Unpaid';



			



					$result_income=$wpdb->insert( $table_income,$incomedata); 







					// UPDATE MEMBERSHIP PAYMENT			



					$payment_data = array();



					$payment_data['coupon_usage_id'] = $couponusage_id;



					$invoice['mp_id'] = $plan_id;



					$membership_payment_id = MJ_gmgt_update_membership_payment_detail_after_discount($payment_data,$invoice);



					



					wp_redirect(home_url() .'/member-registration-or-login/?action=success1&id=' . $user_id);



					exit;



			}







		}	







	}	







}











function MJ_gmgt_add_membership_payment_details($data)







{







	global $wpdb;







	$table_gmgt_membership_payment = $wpdb->prefix. 'Gmgt_membership_payment';







	$result = $wpdb->insert($table_gmgt_membership_payment,$data);







	$lastid = $wpdb->insert_id;







	return $lastid;







}







function MJ_gmgt_add_coupon_usage_details($data)



{



		global $wpdb;







		$table_gmgt_coupon_usage = $wpdb->prefix. 'gmgt_coupon_usage';







		$result = $wpdb->insert($table_gmgt_coupon_usage,$data);







		$lastid = $wpdb->insert_id;







		return $lastid;



}







	function MJ_gmgt_update_membership_payment_detail_after_discount($data,$plan_id)



	{



		global $wpdb;







		$table_gmgt_membership_payment = $wpdb->prefix. 'Gmgt_membership_payment';







		$result = $wpdb->update($table_gmgt_membership_payment,$data,$plan_id);







		return $result;







	}



//MEMBER RAGISTATION FORM VALIDATION FUNCTION//







function MJ_gmgt_registration_validation($class_name,$first_name,$gender,$email,$password,$membership_id)  







{







	







	global $reg_errors;







	$reg_errors = new WP_Error;







	







	if ( empty( $class_name )  || empty( $first_name )  ||  empty( $email )  || empty( $password ) || empty( $membership_id ) ) 







	{







    $reg_errors->add('field', __('Required form field is missing','gym_mgt'));







	}







	







	// if ( !is_email( $email ) ) {







    // $reg_errors->add( 'email_invalid',  __('Email is not valid','gym_mgt'));







	// }







	if ( email_exists( $email ) ) {







    $reg_errors->add( 'email', __('Email Already in use','gym_mgt') );







	}







	







	if ( is_wp_error( $reg_errors ) ) 







	{ 







		foreach ( $reg_errors->get_error_messages() as $error )







		{







			echo '<div class="student_reg_error">';







			echo '<strong>'.__('ERROR','gym_mgt').'</strong> : ';







			echo '<span class="error"> '.$error . ' </span><br/>';







			echo '</div>';         







		} 







		?>







		<script type="text/javascript">







		jQuery(document).ready(function() 







		{







			jQuery('.student_registraion_form').show();







			jQuery('.student_login_form').hide();







		});







		</script>







		<?php







	}







}







//OUTPUT OB START FUNCTION







function MJ_gmgt_output_ob_start()







{







	ob_start();







}







///INSTALL TABLE PLUGIN ACTIVATE DEAVTIVATE TIME







function MJ_gmgt_install_tables()







{







	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');







	global $wpdb;















	$table_gmgt_member_subscriptions_details = $wpdb->prefix . 'gmgt_member_subscriptions_details';







		$sql = "CREATE TABLE IF NOT EXISTS ".$table_gmgt_member_subscriptions_details ." (







				  `id` int(11) NOT NULL AUTO_INCREMENT,







				  `member_id` int(11) NOT NULL,







				  `membership_id` int(11) NOT NULL,







				  `payment_method` varchar(200) NOT NULL,







				  `stripe_subscription_id` varchar(200) NOT NULL,







				  `stripe_customer_id` varchar(200) NOT NULL,







				  `stripe_plan_id` varchar(200) NOT NULL,







				  `payer_email` varchar(200) NOT NULL,







				  `subscription_status` varchar(200) NOT NULL,







				  `membership_status` varchar(200) NOT NULL,







				  `plan_amount_currency` varchar(200) NOT NULL,







				  `plan_amount` double NOT NULL,







				  `plan_period_start` datetime NOT NULL,







				  `plan_period_end` datetime NOT NULL,







				  `created_date` datetime NOT NULL,







				  `updated_date` datetime NOT NULL,







				  PRIMARY KEY (`id`)







				) DEFAULT CHARSET=utf8";







	







		$wpdb->query($sql);















	$table_gmgt_activity = $wpdb->prefix . 'gmgt_activity';







		$sql = "CREATE TABLE IF NOT EXISTS ".$table_gmgt_activity ." (







				  `activity_id` int(11) NOT NULL AUTO_INCREMENT,







				  `activity_cat_id` int(11) NOT NULL,







				  `activity_title` varchar(200) NOT NULL,







				  `activity_assigned_to` int(11) NOT NULL,







				  `activity_added_by` int(11) NOT NULL,







				  `activity_added_date` date NOT NULL,







				  PRIMARY KEY (`activity_id`)







				) DEFAULT CHARSET=utf8";







	







		$wpdb->query($sql);







		







		$table_gmgt_assign_workout = $wpdb->prefix . 'gmgt_assign_workout';







		$sql = "CREATE TABLE IF NOT EXISTS ".$table_gmgt_assign_workout." (







				  `workout_id` bigint(20) NOT NULL AUTO_INCREMENT,







				  `user_id` bigint(20) NOT NULL,







				  `start_date` date NOT NULL,







				  `end_date` date NOT NULL,







				  `level_id` int(11) NOT NULL,







				  `description` text NOT NULL,







				  `created_date` datetime NOT NULL,







				  `created_by` bigint(20) NOT NULL,







				  PRIMARY KEY (`workout_id`)







				) DEFAULT CHARSET=utf8";







	







		$wpdb->query($sql);







		







		$table_gmgt_attendence = $wpdb->prefix . 'gmgt_attendence';







		$sql = "CREATE TABLE IF NOT EXISTS ".$table_gmgt_attendence." (







				 `attendence_id` int(11) NOT NULL AUTO_INCREMENT,







				  `user_id` int(11) NOT NULL,







				  `class_id` int(11) NOT NULL,







				  `attendence_date` date NOT NULL,







				  `status` varchar(50) NOT NULL,







				  `attendence_by` int(11) NOT NULL,







				  `role_name` varchar(50) NOT NULL,







				  PRIMARY KEY (`attendence_id`)







				) DEFAULT CHARSET=utf8";







	







		$wpdb->query($sql);







		$attendance_type = 'attendance_type';







		if (!in_array($attendance_type, $wpdb->get_col( "DESC " . $table_gmgt_attendence, 0 ) )){  















			$result= $wpdb->query("ALTER   TABLE $table_gmgt_attendence  ADD   $attendance_type  varchar(20)");



	



	



	



		}







		







		$table_gmgt_class_schedule = $wpdb->prefix . 'gmgt_class_schedule';







		$sql = "CREATE TABLE IF NOT EXISTS ".$table_gmgt_class_schedule." (







				 `class_id` int(11) NOT NULL AUTO_INCREMENT,







				  `class_name` varchar(100) NOT NULL,







				  `day` text NOT NULL,







				  `staff_id` int(11) NOT NULL,







				  `asst_staff_id` int(11) NOT NULL,







				  `start_time` varchar(20) NOT NULL,







				  `end_time` varchar(20) NOT NULL,







				  `class_created_id` int(11) NOT NULL,







				  `class_creat_date` date NOT NULL,







				  PRIMARY KEY (`class_id`)







				) DEFAULT CHARSET=utf8";







	







		$wpdb->query($sql);







		







		







		$table_gmgt_daily_workouts = $wpdb->prefix . 'gmgt_daily_workouts';







		$sql = "CREATE TABLE IF NOT EXISTS ".$table_gmgt_daily_workouts." (







				  `id` int(11) NOT NULL AUTO_INCREMENT,







				  `workout_id` int(11) NOT NULL,







				  `member_id` int(11) NOT NULL,







				  `record_date` date NOT NULL,







				  `result_measurment` varchar(50) NOT NULL,







				  `result` varchar(100) NOT NULL,







				  `duration` varchar(100) NOT NULL,







				  `assigned_by` int(11) NOT NULL,







				  `due_date` date NOT NULL,







				  `time_of_workout` varchar(50) NOT NULL,







				  `status` varchar(100) NOT NULL,







				  `note` text NOT NULL,







				  `created_by` int(11) NOT NULL,







				  `created_date` date NOT NULL,







				  PRIMARY KEY (`id`)







				)  DEFAULT CHARSET=utf8";







	







		$wpdb->query($sql);







		







		







		$table_gmgt_groups = $wpdb->prefix . 'gmgt_groups';







		$sql = "CREATE TABLE IF NOT EXISTS ".$table_gmgt_groups." (







				  `id` int(11) NOT NULL AUTO_INCREMENT,







				  `group_name` varchar(100) NOT NULL,







				  `gmgt_groupimage` varchar(255) NOT NULL,







				  `created_by` int(11) NOT NULL,







				  `created_date` date NOT NULL,







				  PRIMARY KEY (`id`)







				) DEFAULT CHARSET=utf8";







	







		$wpdb->query($sql);







		







		$table_gmgt_groupmember = $wpdb->prefix . 'gmgt_groupmember';







		$sql = "CREATE TABLE IF NOT EXISTS ".$table_gmgt_groupmember." (







				  `id` bigint(20) NOT NULL AUTO_INCREMENT,







				  `group_id` int(11) NOT NULL,







				  `member_id` int(11) NOT NULL,







				  `created_by` int(11) NOT NULL,







				  `created_date` datetime NOT NULL,







				  PRIMARY KEY (`id`)







				) DEFAULT CHARSET=utf8";







	







		$wpdb->query($sql);







		







		$table_gmgt_income_expense = $wpdb->prefix . 'gmgt_income_expense';







		$sql = "CREATE TABLE IF NOT EXISTS ".$table_gmgt_income_expense." (







				  `invoice_id` int(11) NOT NULL AUTO_INCREMENT,







				  `invoice_type` varchar(100) NOT NULL,







				  `invoice_label` varchar(100) NOT NULL,







				  `supplier_name` varchar(100) NOT NULL,







				  `entry` text NOT NULL,







				  `payment_status` varchar(50) NOT NULL,







				  `receiver_id` int(11) NOT NULL,







				  `invoice_date` date NOT NULL,







				  `invoice_no` varchar(100) NOT NULL,







				  `discount` double NOT NULL,







				  `total_amount` double NOT NULL,







				  `paid_amount` double NOT NULL,







				  `tax` double NOT NULL,







				  `due_amount` double NOT NULL,







				  `create_by` int(11) NOT NULL,







				  PRIMARY KEY (`invoice_id`)







				)  DEFAULT CHARSET=utf8";







	







		$wpdb->query($sql);







		



		$table_gmgt_coupon = $wpdb->prefix . 'gmgt_coupon';







		$sql = "CREATE TABLE IF NOT EXISTS ".$table_gmgt_coupon." (







				  `id` int(11) NOT NULL AUTO_INCREMENT,







				  `code` varchar(50) NOT NULL,







				  `coupon_type` varchar(20) NOT NULL,







				  `member_id` int(11) NOT NULL,







				  `recurring_type` varchar(20) NOT NULL,







				  `membership` varchar(20) NOT NULL,







				  `discount` varchar(20) NOT NULL,







				  `discount_type` varchar(10) NOT NULL,







				  `time` int(11) NOT NULL,







				  `time_used` int(11) NOT NULL,







				  `from_date` varchar(10) NOT NULL,







				  `end_date` varchar(10) NOT NULL,



				  



				  `published` varchar(20) NOT NULL,







				  PRIMARY KEY (`id`)







				)  DEFAULT CHARSET=utf8";







		$wpdb->query($sql);



		







		$table_coupon_usage = $wpdb->prefix . 'gmgt_coupon_usage';







		$sql = "CREATE TABLE IF NOT EXISTS ".$table_coupon_usage." (







					  `id` int(11) NOT NULL AUTO_INCREMENT,







					  `member_id` int(11) NOT NULL,







					  `mp_id` int(11) NOT NULL,







					  `membership_id` int(11) NOT NULL,







					  `coupon_id` int(11) NOT NULL,







					  `coupon_usage` int(11) NOT NULL,







					  `discount_type` varchar(10) NOT NULL,







					  `discount_amount` varchar(20) NOT NULL,







					   PRIMARY KEY (`id`)







					)  DEFAULT CHARSET=utf8";







			$wpdb->query($sql);











		$table_gmgt_membershiptype= $wpdb->prefix . 'gmgt_membershiptype';







		$sql = "CREATE TABLE IF NOT EXISTS ".$table_gmgt_membershiptype." (







				  `membership_id` int(11) NOT NULL AUTO_INCREMENT,







				  `membership_label` varchar(100) NOT NULL,







				  `membership_cat_id` int(11) NOT NULL,







				  `membership_length_id` int(11) NOT NULL,







				  `membership_class_limit` varchar(20) NOT NULL,







				  `install_plan_id` int(11) NOT NULL,







				  `membership_amount` double NOT NULL,







				  `installment_amount` double NOT NULL,







				  `signup_fee` double NOT NULL,







				  `gmgt_membershipimage` varchar(255) NOT NULL,







				  `created_date` date NOT NULL,







				  `created_by_id` int(11) NOT NULL,







				  PRIMARY KEY (`membership_id`)







				)  DEFAULT CHARSET=utf8";







		$wpdb->query($sql);







		







		$table_gmgt_nutrition = $wpdb->prefix . 'gmgt_nutrition';







		$sql = "CREATE TABLE IF NOT EXISTS ".$table_gmgt_nutrition." (







				  `id` int(11) NOT NULL AUTO_INCREMENT,







				  `user_id` int(11) NOT NULL,







				  `day` varchar(50) NOT NULL,







				  `breakfast` text NOT NULL,







				  `midmorning_snack` text NOT NULL,







				  `lunch` text NOT NULL,







				  `afternoon_snack` text NOT NULL,







				  `dinner` text NOT NULL,







				  `afterdinner_snack` text NOT NULL,







				  `start_date` varchar(20) NOT NULL,







				  `expire_date` varchar(20) NOT NULL,







				  `created_by` int(11) NOT NULL,







				  `created_date` date NOT NULL,







				  PRIMARY KEY (`id`)







				)DEFAULT CHARSET=utf8";







	







		$wpdb->query($sql);







		







		$table_gmgt_payment = $wpdb->prefix . 'gmgt_payment';







		$sql = "CREATE TABLE IF NOT EXISTS ".$table_gmgt_payment." (







				 `payment_id` int(11) NOT NULL AUTO_INCREMENT,







				  `title` varchar(100) NOT NULL,







				  `member_id` int(11) NOT NULL,







				  `due_date` date NOT NULL,







				  `unit_price` double NOT NULL,







				  `discount` double NOT NULL,







				  `total_amount` double NOT NULL,







				  `amount` double NOT NULL,







				  `payment_status` varchar(50) NOT NULL,







				  `payment_date` date NOT NULL,







				  `receiver_id` int(11) NOT NULL,







				  `description` text NOT NULL,







				  PRIMARY KEY (`payment_id`)







				)DEFAULT CHARSET=utf8";







					







		$wpdb->query($sql);







		







		







		$table_gmgt_product = $wpdb->prefix . 'gmgt_product';







		$sql = "CREATE TABLE IF NOT EXISTS ".$table_gmgt_product." (







				 `id` int(11) NOT NULL AUTO_INCREMENT,







				  `product_name` varchar(100) NOT NULL,







				  `price` double NOT NULL,







				  `quentity` int(11) NOT NULL,







				  `created_by` int(11) NOT NULL,







				  `created_date` date NOT NULL,







				  PRIMARY KEY (`id`)







				)DEFAULT CHARSET=utf8";







	







		$wpdb->query($sql);







		







		







		$table_gmgt_reservation = $wpdb->prefix . 'gmgt_reservation';







		$sql = "CREATE TABLE IF NOT EXISTS ".$table_gmgt_reservation." (







				  `id` int(11) NOT NULL AUTO_INCREMENT,







				  `event_name` varchar(100) NOT NULL,







				  `event_date` date NOT NULL,







				  `start_time` varchar(20) NOT NULL,







				  `end_time` varchar(20) NOT NULL,







				  `place_id` int(11) NOT NULL,







				  `created_by` int(11) NOT NULL,







				  `created_date` date NOT NULL,







				  PRIMARY KEY (`id`)







				)DEFAULT CHARSET=utf8";







	







		$wpdb->query($sql);		







	 







		$table_gmgt_store = $wpdb->prefix . 'gmgt_store';







		$sql = "CREATE TABLE IF NOT EXISTS ".$table_gmgt_store."(







				  `id` int(11) NOT NULL AUTO_INCREMENT,				 







				  `invoice_no` varchar(50) NOT NULL,	







					`member_id` int(11) NOT NULL,				  







				  `entry` text NOT NULL,		  				  







				  `tax` double NOT NULL,







				  `discount` double NOT NULL,







				  `amount` double NOT NULL,







				  `total_amount` double NOT NULL,







				  `paid_amount` double NOT NULL,







				  `payment_status` varchar(50) NOT NULL,







				  `sell_by` int(11) NOT NULL,







				  `sell_date` date NOT NULL,







				  `created_date` date NOT NULL,







				  PRIMARY KEY (`id`)







				) DEFAULT CHARSET=utf8";







					







		$wpdb->query($sql);







		







		$table_gmgt_message= $wpdb->prefix . 'Gmgt_message';







		$sql = "CREATE TABLE IF NOT EXISTS ".$table_gmgt_message." (







			  `message_id` int(11) NOT NULL AUTO_INCREMENT,







			  `sender` int(11) NOT NULL,







			  `receiver` int(11) NOT NULL,







			  `date` datetime NOT NULL,







			  `subject` varchar(150) NOT NULL,







			  `message_body` text NOT NULL,







			  `status` int(11) NOT NULL,







			  PRIMARY KEY (`message_id`)







			)DEFAULT CHARSET=utf8";







	







		$wpdb->query($sql);







		







		$table_gmgt_workout_data= $wpdb->prefix . 'gmgt_workout_data';







		$sql = "CREATE TABLE IF NOT EXISTS ".$table_gmgt_workout_data." (







			  `id` bigint(20) NOT NULL AUTO_INCREMENT,







			  `day_name` varchar(15) NOT NULL,







			  `workout_name` varchar(100) NOT NULL,







			  `sets` int(11) NOT NULL,







			  `reps` int(11) NOT NULL,







			  `kg` float NOT NULL,







			  `time` int(11) NOT NULL,







			  `workout_id` bigint(20) NOT NULL,







			  `created_date` datetime NOT NULL,







			  `create_by` bigint(20) NOT NULL,







			  PRIMARY KEY (`id`)







			)DEFAULT CHARSET=utf8";







	







		$wpdb->query($sql);







		







		$table_gmgt_measurment= $wpdb->prefix . 'gmgt_measurment';







		$sql = "CREATE TABLE IF NOT EXISTS ".$table_gmgt_measurment." (







			  `measurment_id` int(11) NOT NULL AUTO_INCREMENT,







			  `result_measurment` varchar(100) NOT NULL,







			  `result` int(11) NOT NULL,







			  `user_id` int(11) NOT NULL,







			  `result_date` date NOT NULL,







			  `created_by` int(11) NOT NULL,







			  `created_date` date NOT NULL,







			  PRIMARY KEY (`measurment_id`)







			)DEFAULT CHARSET=utf8";







				







		$wpdb->query($sql);







		







		$table_gmgt_user_workouts= $wpdb->prefix . 'gmgt_user_workouts';







		$sql = "CREATE TABLE IF NOT EXISTS ".$table_gmgt_user_workouts." (







			  `id` int(11) NOT NULL AUTO_INCREMENT,







			  `user_workout_id` int(11) NOT NULL,







			  `workout_name` varchar(200) NOT NULL,







			  `sets` int(11) NOT NULL,







			  `reps` int(11) NOT NULL,







			  `kg` float NOT NULL,







			  `rest_time` int(11) NOT NULL,







			  PRIMARY KEY (`id`)







			)DEFAULT CHARSET=utf8";







				







		$wpdb->query($sql);







		







		$table_gmgt_nutrition_data= $wpdb->prefix . 'gmgt_nutrition_data';







		$sql = "CREATE TABLE IF NOT EXISTS ".$table_gmgt_nutrition_data." (







				  `id` int(11) NOT NULL AUTO_INCREMENT,







				  `day_name` varchar(30) NOT NULL,







				  `nutrition_time` varchar(30) NOT NULL,







				  `nutrition_value` text NOT NULL,







				  `nutrition_id` int(11) NOT NULL,







				  `created_date` date NOT NULL,







				  `create_by` int(11) NOT NULL,







				  PRIMARY KEY (`id`)







				)DEFAULT CHARSET=utf8";







				







		$wpdb->query($sql);







		







		$table_gmgt_membership_payment= $wpdb->prefix . 'Gmgt_membership_payment';







		$sql = "CREATE TABLE IF NOT EXISTS ".$table_gmgt_membership_payment." (







				  `mp_id` int(11) NOT NULL AUTO_INCREMENT,







				  `member_id` int(11) NOT NULL,







				  `membership_id` int(11) NOT NULL,







				  `invoice_no` 	varchar(10) NOT NULL,







				  `membership_amount` double NOT NULL,







				  `paid_amount` double NOT NULL,







				  `start_date` date NOT NULL,







				  `end_date` date NOT NULL,







				  `membership_status` varchar(50) NOT NULL,







				  `payment_status` varchar(20) NOT NULL,







				  `created_date` date NOT NULL,







				  `created_by` int(11) NOT NULL,







				  PRIMARY KEY (`mp_id`)







				)DEFAULT CHARSET=utf8";







				







		$wpdb->query($sql);



		



		$table_gmgt_membership_payment = $wpdb->prefix . 'Gmgt_membership_payment';		



		$discount =  'discount_amount';



		$user_coupon = 'coupon_id';



		$coupon_usage_id = 'coupon_usage_id';



		$tax_id = 'tax_id';



		if (!in_array($discount, $wpdb->get_col( "DESC " . $table_gmgt_membership_payment, 0 ) ))



		{  $result= $wpdb->query(



				"ALTER TABLE $table_gmgt_membership_payment ADD $discount varchar(20)");



		}



		if (!in_array($user_coupon, $wpdb->get_col( "DESC " . $table_gmgt_membership_payment, 0 ) ))



		{  $result= $wpdb->query(



				"ALTER TABLE $table_gmgt_membership_payment ADD $user_coupon int(11)");



		}



		if (!in_array($coupon_usage_id, $wpdb->get_col( "DESC " . $table_gmgt_membership_payment, 0 ) ))



		{  $result= $wpdb->query(



				"ALTER TABLE $table_gmgt_membership_payment ADD $coupon_usage_id int(11)");



		}



		if (!in_array($tax_id, $wpdb->get_col( "DESC " . $table_gmgt_membership_payment, 0 ) ))



		{  $result= $wpdb->query(



				"ALTER TABLE $table_gmgt_membership_payment ADD $tax_id varchar(100)");



		}







		







		$table_gmgt_membership_payment_history = $wpdb->prefix . 'gmgt_membership_payment_history';







		$sql = "CREATE TABLE IF NOT EXISTS ".$table_gmgt_membership_payment_history." (







				  `payment_history_id` bigint(20) NOT NULL AUTO_INCREMENT,







				  `mp_id` int(11) NOT NULL,







				  `amount` int(11) NOT NULL,







				  `payment_method` varchar(50) NOT NULL,







				  `paid_by_date` date NOT NULL,







				  `created_by` int(11) NOT NULL,







				  `trasaction_id` varchar(255) NOT NULL,







				  PRIMARY KEY (`payment_history_id`)







				)DEFAULT CHARSET=utf8";







				







		$wpdb->query($sql);







		







		$table_gmgt_alert_mail_log = $wpdb->prefix . 'gmgt_alert_mail_log';







		$sql = "CREATE TABLE IF NOT EXISTS ".$table_gmgt_alert_mail_log." (







				  `id` int(11) NOT NULL AUTO_INCREMENT,







				  `member_id` int(11) NOT NULL,







				  `membership_id` int(11) NOT NULL,







				  `start_date` varchar(20) NOT NULL,







				  `end_date` varchar(20) NOT NULL,







				  `alert_date` int(11) NOT NULL,







				  PRIMARY KEY (`id`)







				)DEFAULT CHARSET=utf8";







				







		$wpdb->query($sql);







		







		   $table_gmgt_message_replies = $wpdb->prefix . 'gmgt_message_replies';







		   $sql = "CREATE TABLE IF NOT EXISTS ".$table_gmgt_message_replies." (







			  `id` int(20) NOT NULL AUTO_INCREMENT,







			  `message_id` int(20) NOT NULL,







			  `sender_id` int(20) NOT NULL,







			  `receiver_id` int(20) NOT NULL,







			  `message_comment` text NOT NULL,







			  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,







			  PRIMARY KEY (`id`)







			) DEFAULT CHARSET=utf8";







	







		$wpdb->query($sql);	







		







		







		$table_gmgt_membership_activities = $wpdb->prefix . 'gmgt_membership_activities';







		$sql = "CREATE TABLE IF NOT EXISTS ".$table_gmgt_membership_activities." (







		  `id` bigint(11) NOT NULL AUTO_INCREMENT,







		  `activity_id` int(11) NOT NULL,







		  `membership_id` int(11) NOT NULL,







		  `created_by` int(11) NOT NULL,







		  `created_date` date NOT NULL,







		  PRIMARY KEY (`id`)







		)DEFAULT CHARSET=utf8";		







		$wpdb->query($sql);







		

		// EXTEND MEMBERSHIP TABLE

		$table_gmgt_extend_membership = $wpdb->prefix . 'gmgt_extend_membership';



		$sql = "CREATE TABLE IF NOT EXISTS ".$table_gmgt_extend_membership." (



		  `id` bigint(11) NOT NULL AUTO_INCREMENT,

			

		  `member_id` int(11) NOT NULL,



		  `membership_id` int(11) NOT NULL,



		  `begin_date` varchar(20) NOT NULL,



		  `end_date` varchar(20) NOT NULL,



		  `extend_day` int(11) NOT NULL,



		  `new_end_date` varchar(20) NOT NULL,



		  PRIMARY KEY (`id`)



		)DEFAULT CHARSET=utf8";		



		$wpdb->query($sql);



		







		$table_gmgt_member_class = $wpdb->prefix . 'gmgt_member_class';







		$sql = "CREATE TABLE IF NOT EXISTS ".$table_gmgt_member_class." (







		  `id` int(20) NOT NULL AUTO_INCREMENT,







		  `member_id` int(20) NOT NULL,







		  `class_id` int(20) NOT NULL,







		   PRIMARY KEY (`id`)







		)DEFAULT CHARSET=utf8";		







		$wpdb->query($sql);







		$table_gmgt_user_log = $wpdb->prefix .'gmgt_user_log';//register transport table



		$sql = "CREATE TABLE IF NOT EXISTS ".$table_gmgt_user_log." (



				`id` int(11) NOT NULL AUTO_INCREMENT,



				`user_login` text NOT NULL,



				`role` text NOT NULL,



				`ip_address` text NOT NULL,



				`created_at` date NOT NULL,



				`date_time` datetime NOT NULL,



				`deleted_status` boolean NOT NULL,



				PRIMARY KEY (`id`)



		) DEFAULT CHARSET=utf8";



		$wpdb->query($sql);







		$table_gmgt_audit_log = $wpdb->prefix .'gmgt_audit_log';//register transport table



		$sql = "CREATE TABLE IF NOT EXISTS ".$table_gmgt_audit_log." (



				`id` int(11) NOT NULL AUTO_INCREMENT,



				`audit_action` text NOT NULL,



				`user_id` int(11) NULL,



				`action` text NOT NULL,



				`ip_address` text NOT NULL,



				`created_by` int(11) NOT NULL,



				`created_at` date NOT NULL,



				`date_time` datetime NOT NULL,



				`deleted_status` boolean NOT NULL,



				`updated_by` 	int(11) NULL,



				`updated_date` datetime NULL,



				PRIMARY KEY (`id`)



		) DEFAULT CHARSET=utf8";



		dbDelta($sql);







		$table_gmgt_audit_log = $wpdb->prefix . 'gmgt_audit_log';		



		$module =  'module';



		if (!in_array($module, $wpdb->get_col( "DESC " . $table_gmgt_audit_log, 0 ) ))



		{  $result= $wpdb->query(



				"ALTER TABLE $table_gmgt_audit_log ADD $module text");



		}	







		$teacher_class = $wpdb->get_results("SELECT *from $table_gmgt_member_class");	







		if(empty($teacher_class))







		{







			$memberlist = get_users(array('role'=>'member'));







		







			if(!empty($memberlist))







			{







				foreach($memberlist as $retrieve_data)







				{				







					$created_by = get_current_user_id();







					$created_date = date('Y-m-d H:i:s');







					$class_id = get_user_meta($retrieve_data->ID,'class_id',true);				







					$success = $wpdb->insert($table_gmgt_member_class,array('member_id'=>$retrieve_data->ID,







						'class_id'=>$class_id,







						));







				}







			}		







		}







	







	$table_gmgt_booking_class = $wpdb->prefix . 'gmgt_booking_class';







		$sql = "CREATE TABLE IF NOT EXISTS ".$table_gmgt_booking_class." (







		  `id` int(20) NOT NULL AUTO_INCREMENT,







		  `member_id` int(20) NOT NULL,







		  `class_id` int(20) NOT NULL,		







		   `booking_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,







		  `membership_id` int(10) NOT NULL,







		  `booking_day` varchar(255) NOT NULL,







		  `class_booking_date` date NOT NULL,







		  PRIMARY KEY (`id`)







		)DEFAULT CHARSET=utf8";		







		$wpdb->query($sql);







		







		$table_gmgt_membership_class = $wpdb->prefix . 'gmgt_membership_class';







		$sql = "CREATE TABLE IF NOT EXISTS ".$table_gmgt_membership_class." (







		 `id` int(20) NOT NULL AUTO_INCREMENT,







		  `class_id` int(20) NOT NULL,







		  `membership_id` int(20) NOT NULL,







		  `booking_day` varchar(255) NOT NULL,







		  PRIMARY KEY (`id`)







		)DEFAULT CHARSET=utf8";		







		$wpdb->query($sql);







		







		







		$table_gmgt_sales_payment_history = $wpdb->prefix . 'gmgt_sales_payment_history';







		$sql = "CREATE TABLE IF NOT EXISTS ".$table_gmgt_sales_payment_history." (







				  `payment_history_id` bigint(20) NOT NULL AUTO_INCREMENT,







				  `sell_id` int(11) NOT NULL,







				  `member_id` int(11) NOT NULL,







				  `amount` int(11) NOT NULL,







				  `payment_method` varchar(50) NOT NULL,







				  `paid_by_date` date NOT NULL,







				  `created_by` int(11) NOT NULL,







				  `trasaction_id` varchar(255) NOT NULL,







				  PRIMARY KEY (`payment_history_id`)







				)DEFAULT CHARSET=utf8";







				







		$wpdb->query($sql);







		







		$table_gmgt_income_payment_history = $wpdb->prefix . 'gmgt_income_payment_history';







		$sql = "CREATE TABLE IF NOT EXISTS ".$table_gmgt_income_payment_history." (







				  `payment_history_id` bigint(20) NOT NULL AUTO_INCREMENT,







				  `invoice_id` int(11) NOT NULL,







				  `member_id` int(11) NOT NULL,







				  `amount` int(11) NOT NULL,







				  `payment_method` varchar(50) NOT NULL,







				  `paid_by_date` date NOT NULL,







				  `created_by` int(11) NOT NULL,







				  `trasaction_id` varchar(255) NOT NULL,







				  PRIMARY KEY (`payment_history_id`)







				)DEFAULT CHARSET=utf8";







				







		$wpdb->query($sql);		







		







		$table_gmgt_taxes = $wpdb->prefix . 'MJ_gmgt_gmgt_taxes';







		$sql = "CREATE TABLE IF NOT EXISTS ".$table_gmgt_taxes." (







				  `tax_id` int(11) NOT NULL AUTO_INCREMENT,







				  `tax_title` varchar(255) NOT NULL,







				  `tax_value` double NOT NULL,







				   `created_date` date NOT NULL,	 







				  PRIMARY KEY (`tax_id`)







				) DEFAULT CHARSET=utf8";







		$wpdb->query($sql);		







		







		$table_gmgt_leads = $wpdb->prefix . 'gmgt_leads';







		$sql = "CREATE TABLE IF NOT EXISTS ".$table_gmgt_leads." (







				  `lead_id` int(11) NOT NULL AUTO_INCREMENT,







				  `first_name` varchar(100) NOT NULL,







				  `last_name` varchar(100) NOT NULL,







				  `phone_number` varchar(25) NOT NULL,







				  `email` varchar(100) NOT NULL,







				   `created_date` date NOT NULL,	 







				   PRIMARY KEY (`lead_id`)







				)  DEFAULT CHARSET=utf8";







		$wpdb->query($sql);		







		







		$table_gmgt_guest_booking = $wpdb->prefix . 'gmgt_guest_booking';







		$sql = "CREATE TABLE IF NOT EXISTS ".$table_gmgt_guest_booking." (







				  `guest_id` int(11) NOT NULL AUTO_INCREMENT,







				  `first_name` varchar(255) NOT NULL,







				  `last_name` varchar(255) NOT NULL,







				  `email_id` varchar(255) NOT NULL,







				  `phone_number` varchar(50) NOT NULL,







				   `created_date` date NOT NULL,	 







				  PRIMARY KEY (`guest_id`)







				) DEFAULT CHARSET=utf8";







		$wpdb->query($sql);















		//Add and delete class limit table//







		$table_gmgt_member_class_limit = $wpdb->prefix . 'gmgt_member_class_limit';







		$sql = "CREATE TABLE IF NOT EXISTS ".$table_gmgt_member_class_limit." (







		 `id` int(20) NOT NULL AUTO_INCREMENT,







		  `member_id` int(20) NOT NULL,







		  `membership_id` int(20) NOT NULL,







		  `class_limit` int(20) NOT NULL,







		  PRIMARY KEY (`id`)







		)DEFAULT CHARSET=utf8";		







		$wpdb->query($sql);	























		/*Zoom Meeting*/







		$gmgt_zoom_meeting = $wpdb->prefix . 'gmgt_zoom_meeting';







		$sql = "CREATE TABLE IF NOT EXISTS ".$gmgt_zoom_meeting ." (







				  `meeting_id` int(11) NOT NULL AUTO_INCREMENT,







				  `title` varchar(255) NOT NULL,		







				  `class_id` int(11) NOT NULL,







				  `zoom_meeting_id` varchar(50) NOT NULL,







				  `uuid` varchar(100) NOT NULL,







			      `staff_id` int(11) NOT NULL,







				  `weekdays` varchar(255) NOT NULL,







				  `password` varchar(50) NULL,







				  `agenda` varchar(2000) NULL,







				  `start_date` date NOT NULL,







				  `end_date` date NOT NULL,







				  `start_time` varchar(255) NOT NULL,







				  `end_time` varchar(255) NOT NULL,







				  `meeting_join_link` varchar(1000) NOT NULL,







				  `meeting_start_link` varchar(1000) NOT NULL,







				  `created_by` 	int(11),







				  `created_date` datetime NOT NULL,







				  `updated_by` 	int(11),







				  `updated_date` datetime NULL,







				  PRIMARY KEY (`meeting_id`)







				) DEFAULT CHARSET=utf8";	







		dbDelta($sql);















		$table_gmgt_reminder_zoom_meeting_mail_log = $wpdb->prefix . 'gmgt_reminder_zoom_meeting_mail_log';







		$sql = "CREATE TABLE IF NOT EXISTS ".$table_gmgt_reminder_zoom_meeting_mail_log." (







			  `id` int(11) NOT NULL AUTO_INCREMENT,







			  `user_id` int(11) NOT NULL,







			  `meeting_id` int(11) NOT NULL,







			  `class_id` varchar(20) NOT NULL,







			  `alert_date` date NOT NULL,







			  PRIMARY KEY (`id`)







			)DEFAULT CHARSET=utf8";







			







	$wpdb->query($sql);			























	$table_gmgt_activity= $wpdb->prefix . 'gmgt_activity';







	$video_entry='video_entry';







	if (!in_array($video_entry, $wpdb->get_col( "DESC " . $table_gmgt_activity, 0 ) )){  







		$result= $wpdb->query("ALTER TABLE $table_gmgt_activity  ADD   $video_entry  text");







	}























	$table_gmgt_message_replies= $wpdb->prefix . 'gmgt_message_replies';







	$created_date='created_date';







	$result= $wpdb->query("ALTER TABLE $table_gmgt_message_replies MODIFY COLUMN $created_date DATETIME");







		







	$table_gmgt_measurment= $wpdb->prefix . 'gmgt_measurment';







	$results='result';







	$result= $wpdb->query("ALTER TABLE $table_gmgt_measurment MODIFY COLUMN $results FLOAT");







	







	







	$table_gmgt_workout_data= $wpdb->prefix . 'gmgt_workout_data';







	$results='time';







	$result= $wpdb->query("ALTER TABLE $table_gmgt_workout_data MODIFY COLUMN $results FLOAT");







	







	$table_gmgt_membership_payment_history = $wpdb->prefix . 'gmgt_membership_payment_history';







	$trasaction_id='trasaction_id';







	$result= $wpdb->query("ALTER TABLE $table_gmgt_membership_payment_history MODIFY COLUMN $trasaction_id varchar(255)");







	







	$table_gmgt_membership_payment_history = $wpdb->prefix . 'gmgt_membership_payment_history';







	$amount='amount';







	$result= $wpdb->query("ALTER TABLE $table_gmgt_membership_payment_history MODIFY COLUMN $amount double NOT NULL");







	







	$table_gmgt_membershiptype= $wpdb->prefix . 'gmgt_membershiptype';







	$gmgt_membership_recurring='gmgt_membership_recurring';







	if (!in_array($gmgt_membership_recurring, $wpdb->get_col( "DESC " . $table_gmgt_membershiptype, 0 ) )){  







		$result= $wpdb->query("ALTER   TABLE $table_gmgt_membershiptype  ADD   $gmgt_membership_recurring  varchar(255) NULL");







	}















	$table_gmgt_membershiptype= $wpdb->prefix . 'gmgt_membershiptype';







	$comment_field='membership_description';







	if (!in_array($comment_field, $wpdb->get_col( "DESC " . $table_gmgt_membershiptype, 0 ) )){  







		$result= $wpdb->query("ALTER   TABLE $table_gmgt_membershiptype  ADD   $comment_field  text");







	}







	







	$table_gmgt_membershiptype= $wpdb->prefix . 'gmgt_membershiptype';







	$gmgt_membership_class_book_approve='gmgt_membership_class_book_approve';







	if (!in_array($gmgt_membership_class_book_approve, $wpdb->get_col( "DESC " . $table_gmgt_membershiptype, 0 ) )){  







		$result= $wpdb->query("ALTER   TABLE $table_gmgt_membershiptype  ADD   $gmgt_membership_class_book_approve varchar(255) ");







	}















	$stripe_plan_id='stripe_plan_id';







	if (!in_array($stripe_plan_id, $wpdb->get_col( "DESC " . $table_gmgt_membershiptype, 0 ) )){  







		$result= $wpdb->query("ALTER   TABLE $table_gmgt_membershiptype  ADD   $stripe_plan_id varchar(255) NULL");







	}















	$stripe_product_id='stripe_product_id';







	if (!in_array($stripe_product_id, $wpdb->get_col( "DESC " . $table_gmgt_membershiptype, 0 ) )){  







		$result= $wpdb->query("ALTER   TABLE $table_gmgt_membershiptype  ADD   $stripe_product_id varchar(255) NULL");







	}







	







	$table_gmgt_membership_class = $wpdb->prefix . 'gmgt_class_schedule';







	$gmgt_class_book_approve='gmgt_class_book_approve';







	if (!in_array($gmgt_class_book_approve, $wpdb->get_col( "DESC " . $table_gmgt_membership_class, 0 ) ))







	{  







		$result= $wpdb->query("ALTER TABLE $table_gmgt_membership_class ADD $gmgt_class_book_approve varchar(255) ");







	}







	







	$table_gmgt_measurment= $wpdb->prefix . 'gmgt_measurment';







	$progress_image='gmgt_progress_image';







	if (!in_array($progress_image, $wpdb->get_col( "DESC " . $table_gmgt_measurment, 0 ) ))







	{  







		$result= $wpdb->query("ALTER     TABLE $table_gmgt_measurment  ADD   $progress_image  text");







	}







	







	$table_gmgt_booking_class= $wpdb->prefix . 'gmgt_booking_class';







	$guest_booking='guest_booking';







	if (!in_array($guest_booking, $wpdb->get_col( "DESC " . $table_gmgt_booking_class, 0 ) ))







	{  







		$result= $wpdb->query("ALTER TABLE $table_gmgt_booking_class ADD   $guest_booking  int(20)");







	}







	







	$table_gmgt_booking_class= $wpdb->prefix . 'gmgt_booking_class';







	$booking_status='booking_status';







	if (!in_array($booking_status, $wpdb->get_col( "DESC " . $table_gmgt_booking_class, 0 ) ))







	{  







		$result= $wpdb->query("ALTER TABLE $table_gmgt_booking_class ADD   $booking_status  varchar(50)");







	}







	







	







	$tbl_message = $wpdb->prefix . 'Gmgt_message';







	$post_id='post_id';







	if (!in_array($post_id, $wpdb->get_col( "DESC " . $tbl_message, 0 ) )){  







		$result= $wpdb->query("ALTER     TABLE $tbl_message  ADD   $post_id  int(30)");







	}







	$gmgt_message_replies = $wpdb->prefix . 'gmgt_message_replies';







	$message_attachment='message_attachment';







	if (!in_array($message_attachment, $wpdb->get_col( "DESC " . $gmgt_message_replies, 0 ) )){  







		$result= $wpdb->query("ALTER     TABLE $gmgt_message_replies  ADD   $message_attachment  text");







	}







	







	$tbl_gmgt_membershiptype = $wpdb->prefix . 'gmgt_membershiptype';







	$on_of_member='on_of_member';







	$classis_limit='classis_limit';







	$on_of_classis='on_of_classis';







	if (!in_array($on_of_member, $wpdb->get_col( "DESC " . $tbl_gmgt_membershiptype, 0 ) )){  







		$result= $wpdb->query("ALTER     TABLE $tbl_gmgt_membershiptype  ADD   $on_of_member  int(20)");







	}







	if (!in_array($classis_limit, $wpdb->get_col( "DESC " . $tbl_gmgt_membershiptype, 0 ) )){  







		$result= $wpdb->query("ALTER     TABLE $tbl_gmgt_membershiptype  ADD   $classis_limit  varchar(200)");







	}







	







	if (!in_array($on_of_classis, $wpdb->get_col( "DESC " . $tbl_gmgt_membershiptype, 0 ) )){  







		$result= $wpdb->query("ALTER     TABLE $tbl_gmgt_membershiptype  ADD   $on_of_classis  int(20)");







	}







	







	$gmgt_reservation = $wpdb->prefix . 'gmgt_reservation';







	$staff_id='staff_id';







	if (!in_array($staff_id, $wpdb->get_col( "DESC " . $gmgt_reservation, 0 ) )){  







		$result= $wpdb->query("ALTER     TABLE $gmgt_reservation  ADD   $staff_id  int(11)");







	}







	







	$table_gmgt_membership_payment = $wpdb->prefix . 'Gmgt_membership_payment';







	$invoice_no='invoice_no';







	if (!in_array($invoice_no, $wpdb->get_col( "DESC " . $table_gmgt_membership_payment, 0 ) )){  







		$result= $wpdb->query("ALTER     TABLE $table_gmgt_membership_payment  ADD   $invoice_no  varchar(10) NOT NULL");







	}















	  $table_gmgt_store = $wpdb->prefix . 'gmgt_store';







	  $member_id='member_id';







	  $entry='entry';







	  $tax_entry='tax';







	  $discount='discount';







	  $amount='amount';







	  $total_amount='total_amount';







	  $paid_amount='paid_amount';







	  $payment_status='payment_status';







	  $invoice_no='invoice_no';







	  $created_date='created_date';







	  $sell_date='sell_date';







	  $tax_id1='tax_id';	  







	  







		if (!in_array($member_id, $wpdb->get_col( "DESC " . $table_gmgt_store, 0 ) ))







		{  







		   $result= $wpdb->query("ALTER     TABLE $table_gmgt_store  ADD   $member_id  int(11) NOT NULL");







		}







		







		if (!in_array($entry, $wpdb->get_col( "DESC " . $table_gmgt_store, 0 ) ))







		{  







		   $result= $wpdb->query("ALTER     TABLE $table_gmgt_store  ADD   $entry  text NOT NULL");







		}







		







		if (!in_array($tax_entry, $wpdb->get_col( "DESC " . $table_gmgt_store, 0 ) ))







		{  







		   $result= $wpdb->query("ALTER     TABLE $table_gmgt_store  ADD   $tax_entry  double NOT NULL");







		}







		







		if (!in_array($discount, $wpdb->get_col( "DESC " . $table_gmgt_store, 0 ) ))







		{  







		   $result= $wpdb->query("ALTER     TABLE $table_gmgt_store  ADD   $discount  double NOT NULL");







		}







		







		if (!in_array($amount, $wpdb->get_col( "DESC " . $table_gmgt_store, 0 ) ))







		{  







		   $result= $wpdb->query("ALTER     TABLE $table_gmgt_store  ADD   $amount  double NOT NULL");







		}







		







		if (!in_array($total_amount, $wpdb->get_col( "DESC " . $table_gmgt_store, 0 ) ))







		{  







		   $result= $wpdb->query("ALTER     TABLE $table_gmgt_store  ADD   $total_amount  double NOT NULL");







		}







		







		if (!in_array($paid_amount, $wpdb->get_col( "DESC " . $table_gmgt_store, 0 ) ))







		{  







		   $result= $wpdb->query("ALTER     TABLE $table_gmgt_store  ADD   $paid_amount  double NOT NULL");







		}







		







		if (!in_array($payment_status, $wpdb->get_col( "DESC " . $table_gmgt_store, 0 ) ))







		{  







		   $result= $wpdb->query("ALTER     TABLE $table_gmgt_store  ADD   $payment_status  varchar(20) NOT NULL");







		}







		







		if (!in_array($invoice_no, $wpdb->get_col( "DESC " . $table_gmgt_store, 0 ) ))







		{  







		   $result= $wpdb->query("ALTER     TABLE $table_gmgt_store  ADD   $invoice_no  varchar(50) NOT NULL");







		}







		







		if (!in_array($created_date, $wpdb->get_col( "DESC " . $table_gmgt_store, 0 ) ))







		{  







		   $result= $wpdb->query("ALTER     TABLE $table_gmgt_store  ADD   $created_date  date NOT NULL");







		}







		







		if (!in_array($sell_date, $wpdb->get_col( "DESC " . $table_gmgt_store, 0 ) ))







		{  







		   $result= $wpdb->query("ALTER     TABLE $table_gmgt_store  ADD   $sell_date  date NOT NULL");







		}







		if (!in_array($tax_id1, $wpdb->get_col( "DESC " . $table_gmgt_store, 0 ) ))







		{  







		   $result= $wpdb->query("ALTER TABLE $table_gmgt_store  ADD  $tax_id1  varchar(100)");







		}







		  $table_gmgt_income_expense = $wpdb->prefix . 'gmgt_income_expense';







		  $invoice_no='invoice_no';







		  $discount='discount';







		  $total_amount='total_amount';







		  $amount='amount';







		  $paid_amount='paid_amount';







		  $tax='tax';







		  $create_by='create_by';	  







		  $tax_id='tax_id';	  







	  







	   if (!in_array($create_by, $wpdb->get_col( "DESC " . $table_gmgt_income_expense, 0 ) ))







		{  







		   $result= $wpdb->query("ALTER  TABLE $table_gmgt_income_expense  ADD   $create_by  int(11) NOT NULL");







		}







	  







	    if (!in_array($invoice_no, $wpdb->get_col( "DESC " . $table_gmgt_income_expense, 0 ) ))







		{  







		   $result= $wpdb->query("ALTER     TABLE $table_gmgt_income_expense  ADD   $invoice_no  varchar(50) NOT NULL");







		}







		







	    if (!in_array($discount, $wpdb->get_col( "DESC " . $table_gmgt_income_expense, 0 ) ))







		{  







		   $result= $wpdb->query("ALTER     TABLE $table_gmgt_income_expense  ADD   $discount  double NOT NULL");







		}







		







		if (!in_array($total_amount, $wpdb->get_col( "DESC " . $table_gmgt_income_expense, 0 ) ))







		{  







		   $result= $wpdb->query("ALTER     TABLE $table_gmgt_income_expense  ADD   $total_amount  double NOT NULL");







		}







		







		if (!in_array($amount, $wpdb->get_col( "DESC " . $table_gmgt_income_expense, 0 ) ))







		{  







		   $result= $wpdb->query("ALTER     TABLE $table_gmgt_income_expense  ADD   $amount  double NOT NULL");







		}







		







		if (!in_array($paid_amount, $wpdb->get_col( "DESC " . $table_gmgt_income_expense, 0 ) ))







		{  







		   $result= $wpdb->query("ALTER     TABLE $table_gmgt_income_expense  ADD   $paid_amount  double NOT NULL");







		}







		







		if (!in_array($tax, $wpdb->get_col( "DESC " . $table_gmgt_income_expense, 0 ) ))







		{  







		   $result= $wpdb->query("ALTER     TABLE $table_gmgt_income_expense  ADD   $tax  double NOT NULL");







		}







		if (!in_array($tax_id, $wpdb->get_col( "DESC " . $table_gmgt_income_expense, 0 ) ))







		{  







		   $result= $wpdb->query("ALTER TABLE $table_gmgt_income_expense  ADD  $tax_id  varchar(100)");







		}







		$table_gmgt_product = $wpdb->prefix . 'gmgt_product';







		$sku_number='sku_number';







		$product_cat_id='product_cat_id';







		$manufacture_company_name='manufacture_company_name';







		$manufacture_date='manufacture_date';







		$product_description='product_description';







		$product_specification='product_specification';







		$product_image='product_image';







		







		if (!in_array($sku_number, $wpdb->get_col( "DESC " . $table_gmgt_product, 0 ) ))







		{  







		   $result= $wpdb->query("ALTER  TABLE $table_gmgt_product  ADD   $sku_number varchar(50) NOT NULL");







		}







		







		if (!in_array($product_cat_id, $wpdb->get_col( "DESC " . $table_gmgt_product, 0 ) ))







		{  







		   $result= $wpdb->query("ALTER  TABLE $table_gmgt_product  ADD   $product_cat_id  int(11) NOT NULL");







		}







		







		if (!in_array($manufacture_company_name, $wpdb->get_col( "DESC " . $table_gmgt_product, 0 ) ))







		{  







		   $result= $wpdb->query("ALTER  TABLE $table_gmgt_product  ADD   $manufacture_company_name  varchar(50) NOT NULL");







		}







		







		if (!in_array($manufacture_date, $wpdb->get_col( "DESC " . $table_gmgt_product, 0 ) ))







		{  







		   $result= $wpdb->query("ALTER  TABLE $table_gmgt_product  ADD   $manufacture_date  date");







		}







		







		if (!in_array($product_description, $wpdb->get_col( "DESC " . $table_gmgt_product, 0 ) ))







		{  







		   $result= $wpdb->query("ALTER  TABLE $table_gmgt_product  ADD   $product_description  text NOT NULL");







		}







		if (!in_array($product_specification, $wpdb->get_col( "DESC " . $table_gmgt_product, 0 ) ))







		{  







		   $result= $wpdb->query("ALTER  TABLE $table_gmgt_product  ADD   $product_specification  text NOT NULL");







		}







		if (!in_array($product_image, $wpdb->get_col( "DESC " . $table_gmgt_product, 0 ) ))







		{  







		   $result= $wpdb->query("ALTER  TABLE $table_gmgt_product  ADD   $product_image  varchar(255) NOT NULL");







		}







		







		$table_gmgt_membership_payment = $wpdb->prefix . 'Gmgt_membership_payment';







		$membership_fees_amount='membership_fees_amount';







		$membership_signup_amount='membership_signup_amount';







		$tax_amount='tax_amount';







		







		if (!in_array($membership_fees_amount, $wpdb->get_col( "DESC " . $table_gmgt_membership_payment, 0 ) ))







		{  







		   $result= $wpdb->query("ALTER     TABLE $table_gmgt_membership_payment  ADD   $membership_fees_amount  double NOT NULL");







		}







		







		if (!in_array($membership_signup_amount, $wpdb->get_col( "DESC " . $table_gmgt_membership_payment, 0 ) ))







		{  







		   $result= $wpdb->query("ALTER     TABLE $table_gmgt_membership_payment  ADD   $membership_signup_amount  double NOT NULL");







		}







		if (!in_array($tax_amount, $wpdb->get_col( "DESC " . $table_gmgt_membership_payment, 0 ) ))







		{  







		   $result= $wpdb->query("ALTER  TABLE $table_gmgt_membership_payment  ADD   $tax_amount  double NOT NULL");







		}







	$table_gmgt_groups = $wpdb->prefix . 'gmgt_groups';	







	$group_description='group_description';







	if (!in_array($group_description, $wpdb->get_col( "DESC " . $table_gmgt_groups, 0 ) ))







	{  







	   $result= $wpdb->query("ALTER  TABLE $table_gmgt_groups  ADD  $group_description text NOT NULL");







	}	







	$table_gmgt_membershiptype= $wpdb->prefix . 'gmgt_membershiptype';







	$tax='tax';







	$activity_cat_id='activity_cat_id';







	$activity_cat_status='activity_cat_status';







	if (!in_array($activity_cat_id, $wpdb->get_col( "DESC " . $table_gmgt_membershiptype, 0 ) ))







	{ 	  







	   $result= $wpdb->query("ALTER  TABLE $table_gmgt_membershiptype  ADD  $activity_cat_id  varchar(100)");







	}







	if (!in_array($activity_cat_status, $wpdb->get_col( "DESC " . $table_gmgt_membershiptype, 0 ) ))







	{ 	  







	   $result= $wpdb->query("ALTER  TABLE $table_gmgt_membershiptype  ADD  $activity_cat_status  int(11)");







	}







	if (!in_array($tax, $wpdb->get_col( "DESC " . $table_gmgt_membershiptype, 0 ) ))







	{ 	  







	   $result= $wpdb->query("ALTER  TABLE $table_gmgt_membershiptype  ADD  $tax  varchar(100)");







	}







	







	$table_gmgt_sales_payment_history = $wpdb->prefix . 'gmgt_sales_payment_history';







	$table_gmgt_membership_payment_history = $wpdb->prefix .'gmgt_membership_payment_history';







	$table_gmgt_income_payment_history=$wpdb->prefix.'gmgt_income_payment_history';







	







	$payment_description='payment_description';







	







	if (!in_array($payment_description, $wpdb->get_col( "DESC " . $table_gmgt_sales_payment_history, 0 ) ))







	{ 	  







	   $result= $wpdb->query("ALTER  TABLE $table_gmgt_sales_payment_history  ADD  $payment_description text");







	}







	if (!in_array($payment_description, $wpdb->get_col( "DESC " . $table_gmgt_membership_payment_history, 0 ) ))







	{ 	  







	   $result= $wpdb->query("ALTER  TABLE $table_gmgt_membership_payment_history  ADD  $payment_description text");







	}







	if (!in_array($payment_description, $wpdb->get_col( "DESC " . $table_gmgt_income_payment_history, 0 ) ))







	{ 	  







	   $result= $wpdb->query("ALTER  TABLE $table_gmgt_income_payment_history  ADD  $payment_description text");







	}







	







	$start_date='start_date';







	$end_date='end_date';







	$color='color';







	$member_limit='member_limit';







	if (!in_array($start_date, $wpdb->get_col( "DESC " . $table_gmgt_class_schedule, 0 ) ))







	{  







	   $result= $wpdb->query("ALTER     TABLE $table_gmgt_class_schedule  ADD   $start_date  date NOT NULL");







	}







	







	if (!in_array($end_date, $wpdb->get_col( "DESC " . $table_gmgt_class_schedule, 0 ) ))







	{  







	   $result= $wpdb->query("ALTER     TABLE $table_gmgt_class_schedule  ADD   $end_date  date NOT NULL");







	}







	







	if (!in_array($color, $wpdb->get_col( "DESC " . $table_gmgt_class_schedule, 0 ) ))







	{  







	   $result= $wpdb->query("ALTER     TABLE $table_gmgt_class_schedule  ADD   $color  varchar(50) NOT NULL");







	}







	







	if (!in_array($member_limit, $wpdb->get_col( "DESC " . $table_gmgt_class_schedule, 0 ) ))







	{  







	   $result= $wpdb->query("ALTER     TABLE $table_gmgt_class_schedule  ADD   $member_limit  int(11) NOT NULL");







	}







 	$table_gmgt_booking_class = $wpdb->prefix . 'gmgt_booking_class';







	$class_booking_date='class_booking_date';







	if (!in_array($class_booking_date, $wpdb->get_col( "DESC " . $table_gmgt_booking_class, 0 ) ))







	{  







	   $result= $wpdb->query("ALTER TABLE $table_gmgt_booking_class  ADD   $class_booking_date date NOT NULL");







	}







	$table_gmgt_message_replies = $wpdb->prefix . 'gmgt_message_replies';







	$status='status';







	if (!in_array($status, $wpdb->get_col( "DESC " . $table_gmgt_message_replies, 0 ) )){  







		$result= $wpdb->query("ALTER     TABLE $table_gmgt_message_replies  ADD   $status   tinyint(4) NOT NULL");







	}







	







	$gmgt_sales_payment_history = $wpdb->prefix . 'gmgt_sales_payment_history';







	$amount_alter='amount';







	$result= $wpdb->query("ALTER TABLE $gmgt_sales_payment_history MODIFY COLUMN $amount_alter double NOT NULL");







	







	// ADD MEMBERSHIP ADDED BY DEFAULT PLUGIN ACTIVATE TIME //







	$table_membership = $wpdb->prefix. 'gmgt_membershiptype';







	$membership_result = $wpdb->get_results("SELECT * FROM $table_membership where membership_label='Golden Membership'");







	if(empty($membership_result))







	{







		$table_membership = $wpdb->prefix. 'gmgt_membershiptype';







		$member_image_url=get_option( 'gmgt_system_logo' );







		$membershipdata['membership_label']=MJ_gmgt_strip_tags_and_stripslashes('Golden Membership');







		$membershipdata['membership_length_id']='30';		







		$membershipdata['membership_class_limit']='unlimited';







		$membershipdata['classis_limit']='unlimited';	







		$membershipdata['on_of_member']=0;







		$membershipdata['on_of_classis']=0;







		$membershipdata['membership_amount']=0;







		$membershipdata['installment_amount']=0;







		$membershipdata['signup_fee']=0;







		$membershipdata['membership_description']='This is free membership';







		$membershipdata['gmgt_membershipimage']=$member_image_url;







		$membershipdata['created_date']=date("Y-m-d");







		$membershipdata['created_by_id']=get_current_user_id();







		$result=$wpdb->insert( $table_membership, $membershipdata );







	}







   // END CODE MEMBERSHIP ADDED BY DEFAULT PLUGIN ACTIVATE TIME //







   







   //OLD MEMBERSHIP DATA ALL ACTIVITY CATEGORY ADDED //







    global $wpdb;







    $obj_membership=new MJ_gmgt_membership;







    $membershipdata=$obj_membership->MJ_gmgt_get_all_membership();







	







    $activity_category=MJ_gmgt_get_all_category('activity_category');







	







	$activity_cat_id_array=array();







	if(!empty($activity_category))







	{







		foreach ($activity_category as $retrive_data)







		{







			$activity_cat_id_array[]=$retrive_data->ID;







		}







	}







	else







    {







		$activity_cat_id_array='';







	}















	if(!empty($activity_cat_id_array))







	{







		$activity_category_value=implode(",",$activity_cat_id_array);		







	}







	else







	{







		$activity_category_value=null;		







	}







	







	if(!empty($membershipdata))







    {







		foreach ($membershipdata as $retrieved_data)







		{







			if($retrieved_data->activity_cat_status != 1)







			{







				$membershipid['membership_id']=$retrieved_data->membership_id;







				$membership_data['activity_cat_id']=$activity_category_value;







				$membership_data['activity_cat_status']=1;	







				$result=$wpdb->update( $table_membership, $membership_data ,$membershipid);				







			}			







		}







    }	







   //END OLD MEMBERSHIP DATA ALL ACTIVITY CATEGORY ADDED //







} 







/**







 * Authenticate a user, confirming the username and password are valid.







 *







 * @since 2.8.0







 *







 * @param WP_User|WP_Error|null $user     WP_User or WP_Error object from a previous callback. Default null.







 * @param string                $username Username for authentication.







 * @param string                $password Password for authentication.







 * @return WP_User|WP_Error WP_User on success, WP_Error on failure.







 */







add_filter( 'authenticate', 'MJ_gmgt_authenticate_username_password_new', 20, 3 );















function MJ_gmgt_authenticate_username_password_new( $user, $username, $password )







{







	if ( $user instanceof WP_User ) {







		return $user;







	}















	if ( empty( $username ) || empty( $password ) ) {







		if ( is_wp_error( $user ) ) {







			return $user;







		}















		$error = new WP_Error();















		if ( empty( $username ) ) {







			$error->add( 'empty_username', esc_html__( '<strong>ERROR</strong>: The username field is empty.' ) );







		}















		if ( empty( $password ) ) {







			$error->add( 'empty_password', esc_html__( '<strong>ERROR</strong>: The password field is empty.' ) );







		}















		return $error;







	}















	$user = get_user_by( 'login', $username );















	if ( ! $user ) {







		return new WP_Error(







			'invalid_username',







			esc_html__( '<strong>ERROR</strong>: Invalid username.' ) .







			' <a href="' . wp_lostpassword_url() . '">' .







			esc_html__( 'Lost your password?' ) .







			'</a>'







		);







	}















	/**







	 * Filters whether the given user can be authenticated with the provided $password.







	 *







	 * @since 2.5.0







	 *







	 * @param WP_User|WP_Error $user     WP_User or WP_Error object if a previous







	 *                                   callback failed authentication.







	 * @param string           $password Password to check against the user.







	 */







	$user = apply_filters( 'wpgmgt_authenticate_user', $user, $password );







	if ( is_wp_error( $user ) ) {







		return $user;







	}















	if ( ! wp_check_password( $password, $user->user_pass, $user->ID ) ) {







		return new WP_Error(







			'incorrect_password',







			sprintf(







				/* translators: %s: user name */







				esc_html__( '<strong>ERROR</strong>: No such username or password.' ),







				'<strong>' . $username . '</strong>'







			) .







			' <a href="' . wp_lostpassword_url() . '">' .







			esc_html__( 'Lost your password?' ) .







			'</a>'







		);







	}















	return $user;







}















add_filter( 'auth_cookie_expiration', 'MJ_gmgt_keep_me_logged_in_60_minutes' );







function MJ_gmgt_keep_me_logged_in_60_minutes( $expirein ) {







    return 3600*24; // 1 hours







}















//Auto Fill Feature is Enabled  wp login page//







add_action('login_form', function($args) {







  $login = ob_get_contents();







  ob_clean();







  $login = str_replace('id="user_pass"', 'id="user_pass" autocomplete="off"', $login);







  $login = str_replace('id="user_login"', 'id="user_login" autocomplete="off"', $login);







  echo $login; 







}, 9999);











// Wordpress User Information Dislclosure//



//remove_action( 'rest_api_init', 'create_initial_rest_routes', 99 );



////X-Frame-Options Header Not Set﻿//







function MJ_gmgt_block_frames() 



{ 



header( 'X-FRAME-OPTIONS: SAMEORIGIN' );







}



//add_action( 'send_headers', 'MJ_gmgt_block_frames', 10 );



add_action( 'send_headers', 'send_frame_options_header', 10, 0 );







if (!empty($_SERVER['HTTPS'])) {







	function MJ_gmgt_add_hsts_header($headers) {







		$headers['strict-transport-security'] = 'max-age=31536000; includeSubDomains';







		return $headers;







	}







	add_filter('wp_headers', 'MJ_gmgt_add_hsts_header');







}







//add user authenticate filter







add_filter('wp_authenticate_user', function($user)







{







$havemeta = get_user_meta($user->ID, 'gmgt_hash', true);







if($havemeta)







{







	$WP_Error = new WP_Error();







	







	$referrer = $_SERVER['HTTP_REFERER'];







	$curr_args = array(







			'page_id' => get_option('gmgt_login_page'),







			'gmgt_activate' => 'gmgt_activate'







	);







	







	$referrer_faild = add_query_arg( $curr_args, get_permalink( get_option('gmgt_login_page') ) );







	







	wp_redirect( $referrer_faild );







	exit();















}







return $user;







}, 10, 2);







add_action( "init", "MJ_gmgt_stripe_webhook_create");







function MJ_gmgt_stripe_webhook_create()







{







	$gym_recurring_enable=get_option("gym_recurring_enable");







	$gmgt_stripe_secret_key=get_option("gmgt_stripe_secret_key");







	if($gym_recurring_enable == "yes" && !empty($gmgt_stripe_secret_key))







	{	







		require_once GMS_PLUGIN_DIR . '/lib/stripe/init.php';	







		$webhook_created=get_option("gmgt_stripe_webhook_create");







		// Set your secret key. Remember to switch to your live secret key in production.







		// See your keys here: https://dashboard.stripe.com/apikeys







		if(empty($webhook_created))







		{







			$home_url=get_home_url();







			\Stripe\Stripe::setApiKey($gmgt_stripe_secret_key);















			$endpoint = \Stripe\WebhookEndpoint::create([







			'url' => $home_url.'/?page=webhooks',







			'enabled_events' => [







				'payment_intent.succeeded',







				'invoice.payment_succeeded',







			],







			]);







			$subsData = $endpoint->jsonSerialize();







			update_option( "gmgt_stripe_webhook_create", $subsData);







		}







	}







} 







add_action( "init", "MJ_gmgt_frontend_payment_success_message" );







function MJ_gmgt_frontend_payment_success_message()







{







	if(isset($_REQUEST['action']) && $_REQUEST['action'] == "payment_success_message")







	{







		?>







		







		<div id="message" class="" style="margin-top: 20px !important;border-left-color: #00a32a !important;background: #fff;border: 1px solid #c3c4c7;border-left-width: 4px;box-shadow: 0 1px 1px rgb(0 0 0 / 4%);margin: 5px 15px 2px;padding: 1px 12px;">







			<p><?php esc_html_e('Payment Successfull','gym_mgt');?></p>







		</div>







		<?php







	}







}







add_filter('document_title_parts', 'my_custom_title'); 







function my_custom_title( $title ) 







{ 







   if(isset($_REQUEST['page']))







   {







	if($_REQUEST['page'] == "group")







	{







		$title['title'] =__("Group","gym_mgt");







	}







	elseif($_REQUEST['page'] == "staff_member")







	{







		$title['title'] =__("Staff Member","gym_mgt");







	}







	elseif($_REQUEST['page'] == "membership")







	{







		$title['title'] =__("Membership","gym_mgt");







	}







	elseif($_REQUEST['page'] == "member")







	{







		$title['title'] =__("Member","gym_mgt");







	}







	elseif($_REQUEST['page'] == "activity")







	{







		$title['title'] =__("Activity","gym_mgt");







	}







	elseif($_REQUEST['page'] == "class-schedule")







	{







		$title['title'] =__("Class Schedule","gym_mgt");







	}







	elseif($_REQUEST['page'] == "assign-workout")







	{







		$title['title'] =__("Assign Workout","gym_mgt");







	}







	elseif($_REQUEST['page'] == "nutrition")







	{







		$title['title'] =__("Nutrition","gym_mgt");







	}







	elseif($_REQUEST['page'] == "workouts")







	{







		$title['title'] =__("Workouts","gym_mgt");







	}







	elseif($_REQUEST['page'] == "accountant")







	{







		$title['title'] =__("Accountant","gym_mgt");







	}







	elseif($_REQUEST['page'] == "membership_payment")







	{







		$title['title'] =__("Membership Payment","gym_mgt");







	}







	elseif($_REQUEST['page'] == "payment")







	{







		$title['title'] =__("Payment","gym_mgt");







	}







	elseif($_REQUEST['page'] == "product")







	{







		$title['title'] =__("Product","gym_mgt");







	}







	elseif($_REQUEST['page'] == "store")







	{







		$title['title'] =__("Store","gym_mgt");







	}







	elseif($_REQUEST['page'] == "message")







	{







		$title['title'] =__("Message","gym_mgt");







	}







	elseif($_REQUEST['page'] == "notice")







	{







		$title['title'] =__("Notice","gym_mgt");







	}







	elseif($_REQUEST['page'] == "reservation")







	{







		$title['title'] =__("Reservation","gym_mgt");







	}







	elseif($_REQUEST['page'] == "account")







	{







		$title['title'] =__("Account","gym_mgt");







	}







	elseif($_REQUEST['page'] == "subscription_history")







	{







		$title['title'] =__("Membership History","gym_mgt");







	}







	elseif($_REQUEST['page'] == "subscription")







	{







		$title['title'] =__("Subscription","gym_mgt");







	}







	elseif($_REQUEST['page'] == "virtual_class")







	{







		$title['title'] =__("Virtual Class","gym_mgt");







	}







	if (is_singular('post')) 







	{ 







		$title['title'] = get_option('gmgt_system_name','gym_mgt').' '. $title['title']; 







	}







   }







	return $title; 







}







//For Managment User Role //







function remove_menus()







{







$author = wp_get_current_user();







if(isset($author->roles[0]))







{ 







    $current_role = $author->roles[0];







}







else







{







    $current_role = 'management';







}







if($current_role == 'management')







{







  add_action('admin_bar_menu', 'shapeSpace_remove_toolbar_nodes', 999);







  add_action( 'admin_menu', 'remove_menus1', 999 );







  remove_menu_page( 'index.php' );                  //Dashboard







  remove_menu_page( 'jetpack' );   







}







}







add_action( 'admin_menu', 'remove_menus' );







function remove_menus1()







{







	if ( ! current_user_can( 'administrator' ) ) 







	{







	   remove_menu_page( 'jetpack' );







	}







}







function shapeSpace_remove_toolbar_nodes($wp_admin_bar) 







{







	$wp_admin_bar->remove_node('wp-logo');







	$wp_admin_bar->remove_node('site-name');







}















//End Management user role //



add_action("init","MJ_hmgt_payment_intent_res_get_and_add_data");



function MJ_hmgt_payment_intent_res_get_and_add_data()



{



	require_once GMS_PLUGIN_DIR. '/lib/vendor/autoload.php'; 



	



	// Google passes a parameter 'code' in the Redirect Url



	if(isset($_REQUEST['payment_intent']) && isset($_REQUEST['payment_intent_client_secret'])) 



	{



		$payment_intent_id=$_REQUEST['payment_intent'];



		try {



			



			$payment_type =  $_REQUEST['payment_type'];	



	



			$amount =  $_REQUEST['amount'];	







			$pay_id = $_REQUEST['pay_id'];







			$stripe_plan_id = $_REQUEST['stripe_plan_id'];







			$customer_id = $_REQUEST['customer_id'];







			$currency = get_option("gmgt_currency_code");







			$coupon_id = $_REQUEST['coupon_id'];



			



				require_once GMS_PLUGIN_DIR . '/lib/stripe/init.php';



				require_once  GMS_PLUGIN_DIR .'/lib/stripe/lib/Stripe.php';







				$gmgt_stripe_secret_key=get_option("gmgt_stripe_secret_key");







				$stripe = new \Stripe\StripeClient(



					$gmgt_stripe_secret_key



				);



				$confirm_payment=$stripe->paymentIntents->retrieve(



					$payment_intent_id



				);



			



				if($confirm_payment->status =="succeeded")



				{ 



					//for gym plug in// 







					if(is_plugin_active('gym-management/gym-management.php'))







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



										exit;



									}







								}



								else{



									wp_redirect(home_url() .'/member-registration-or-login/?action=success');



									exit;



								}







								







							







						}







						else







						{







							if($_REQUEST['payment_type'] == 'Sales_Payment')







							{



								echo '';



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



									exit;			







								}







								else







								{







									wp_redirect ( home_url() . '?dashboard=user&page=store&action=cancle');	



									exit;								







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



				else



				{



					wp_redirect ( home_url() . '?dashboard=user&page=membership_payment&action=cancle');		



					die;



				}



			}



			catch(Exception $e) {



			echo $e->getMessage();



			exit();



		}



	}



}



add_filter( 'cron_schedules', 'create_cron_for_check_unpaid_invoices' );



function create_cron_for_check_unpaid_invoices( $schedules ) 



{



    $schedules['every_minute'] = array(



            'interval'  => 60,



            'display'   => esc_html__('Every minute', 'textdomain' )



    );



    return $schedules;



} 



if ( ! wp_next_scheduled( 'create_cron_for_check_unpaid_invoices' ) )



{



    wp_schedule_event( time(), 'every_minute', 'create_cron_for_check_unpaid_invoices' );



}



add_action( 'create_cron_for_check_unpaid_invoices', 'MJ_gmgt_check_unpaid_invoices' );







function MJ_gmgt_check_unpaid_invoices()



{



	$expired_due_day=get_option( 'gmgt_expired_due_day' );



	$date = date('Y-m-d');



	$start_date= date('Y-m-d', strtotime($date. ' - '.$expired_due_day.' days'));



	$obj_membership_payment=new MJ_gmgt_membership_payment;



	$paymentdata=$obj_membership_payment->MJ_gmgt_get_all_membership_payment_cronjob($start_date);



	if(!empty($paymentdata))



	{



		foreach($paymentdata as $payment )



		{



			$member_id=$payment->member_id;



			$returnans=update_user_meta( $member_id, 'unpaid_membership_status','Expired');



		}



	}



}



add_action('init','mj_gmgt_generate_pdf');



function mj_gmgt_generate_pdf()



{



	if (is_user_logged_in ()) 



	{



		if(isset($_REQUEST['pdf']) && $_REQUEST['pdf'] == 'pdf')



		{







			//error_reporting(0);



			mj_gmgt_generate_invoice_pdf($_REQUEST['invoice_id'],$_REQUEST['invoice_type']);



			$out_put = ob_get_contents();



			ob_clean();



			header('Content-type: application/pdf');



			header('Content-Disposition: inline; filename="result"');



			header('Content-Transfer-Encoding: binary');



			header('Accept-Ranges: bytes');



			



			require_once GMS_PLUGIN_DIR . '/lib/mpdf/vendor/autoload.php';



			$mpdf = new Mpdf\Mpdf;



			$mpdf->SetTitle('Payment');



			$mpdf->showImageErrors = true;



			$mpdf->autoScriptToLang = true;



			$mpdf->autoLangToFont = true;



			



			if (is_rtl())



			{



				$mpdf->autoScriptToLang = true;



				$mpdf->autoLangToFont = true;



				$mpdf->SetDirectionality('rtl');



			}   



			



			$mpdf->WriteHTML($out_put);



			$mpdf->Output();



			unset( $out_put );



			unset( $mpdf );



			exit;



		}



	}



}



add_action('wp_login', 'mj_gmgt_member_login', 10, 2);



function mj_gmgt_member_login($user_login, $user)



{



	$role = $user->roles;



	$role_name = $role[0];



	gym_append_user_log($user_login,$role_name);



}

?>