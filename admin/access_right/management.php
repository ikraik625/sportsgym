<?php 	

$result=get_option('gmgt_access_right_management');

//SAVE STAFF MEMBER ACCESS RIGHT DATA

if(isset($_POST['save_access_right_managment']))

{

	$role_access_right = array();

	$result=get_option('gmgt_access_right_management');

	$role_access_right['management'] = [

						   "membership"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/membership-type.png'),

						              "menu_title"=>'Membership Type',

						              "page_link"=>'membership',

									 "own_data" => isset($_REQUEST['membership_own_data'])?esc_attr($_REQUEST['membership_own_data']):0,

									 "add" => isset($_REQUEST['membership_add'])?esc_attr($_REQUEST['membership_add']):0,

									 "edit"=>isset($_REQUEST['membership_edit'])?esc_attr($_REQUEST['membership_edit']):0,

									 "view"=>isset($_REQUEST['membership_view'])?esc_attr($_REQUEST['membership_view']):0,

									 "delete"=>isset($_REQUEST['membership_delete'])?esc_attr($_REQUEST['membership_delete']):0

						  ],

						   

							"group"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/group.png'),

							        "menu_title"=>'Group',

									"page_link"=>'group',

									 "own_data" => isset($_REQUEST['group_own_data'])?esc_attr($_REQUEST['group_own_data']):0,

									 "add" => isset($_REQUEST['group_add'])?esc_attr($_REQUEST['group_add']):0,

									"edit"=>isset($_REQUEST['group_edit'])?esc_attr($_REQUEST['group_edit']):0,

									"view"=>isset($_REQUEST['group_view'])?esc_attr($_REQUEST['group_view']):0,

									"delete"=>isset($_REQUEST['group_delete'])?esc_attr($_REQUEST['group_delete']):0

						  ],

						  "staff_member"=>["menu_icone"=>plugins_url('gym-management/assets/images/icon/staff-member.png'),

							           "menu_title"=>'Staff Members',

							           "page_link"=>'staff_member',

									   "own_data" =>isset($_REQUEST['staff_member_own_data'])?esc_attr($_REQUEST['staff_member_own_data']):0,

									   "add" =>isset($_REQUEST['staff_member_add'])?esc_attr($_REQUEST['staff_member_add']):0,

										"edit"=>isset($_REQUEST['staff_member_edit'])?esc_attr($_REQUEST['staff_member_edit']):0,

										"view"=>isset($_REQUEST['staff_member_view'])?esc_attr($_REQUEST['staff_member_view']):0,

										"delete"=>isset($_REQUEST['staff_member_delete'])?esc_attr($_REQUEST['staff_member_delete']):0

							],

							

							  "class-schedule"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/class-schedule.png'),

							               "menu_title"=>'Class schedule',

										   "page_link"=>'class-schedule',

										 "own_data" => isset($_REQUEST['class_schedule_own_data'])?esc_attr($_REQUEST['class_schedule_own_data']):0,

										 "add" => isset($_REQUEST['class_schedule_add'])?esc_attr($_REQUEST['class_schedule_add']):0,

										"edit"=>isset($_REQUEST['class_schedule_edit'])?esc_attr($_REQUEST['class_schedule_edit']):0,

										"view"=>isset($_REQUEST['class_schedule_view'])?esc_attr($_REQUEST['class_schedule_view']):0,

										"delete"=>isset($_REQUEST['class_schedule_delete'])?esc_attr($_REQUEST['class_schedule_delete']):0

							  ],

							  "member"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/member.png'),

							            "menu_title"=>'Member',

										"page_link"=>'member',

										"own_data" => isset($_REQUEST['member_own_data'])?esc_attr($_REQUEST['member_own_data']):0,

										 "add" => isset($_REQUEST['member_add'])?esc_attr($_REQUEST['member_add']):0,

										 "edit"=>isset($_REQUEST['member_edit'])?esc_attr($_REQUEST['member_edit']):0,

										"view"=>isset($_REQUEST['member_view'])?esc_attr($_REQUEST['member_view']):0,

										"delete"=>isset($_REQUEST['member_delete'])?esc_attr($_REQUEST['member_delete']):0

							  ],

							  "activity"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/activity.png'),

							             "menu_title"=>'Activity',

										 "page_link"=>'activity',

										 "own_data" => isset($_REQUEST['activity_own_data'])?$_REQUEST['activity_own_data']:0,

										 "add" => isset($_REQUEST['activity_add'])?esc_attr($_REQUEST['activity_add']):0,

										"edit"=>isset($_REQUEST['activity_edit'])?esc_attr($_REQUEST['activity_edit']):0,

										"view"=>isset($_REQUEST['activity_view'])?esc_attr($_REQUEST['activity_view']):0,

										"delete"=>isset($_REQUEST['activity_delete'])?esc_attr($_REQUEST['activity_delete']):0

							  ],

							  

							  "assign-workout"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/assigne-workout.png'),

								         "menu_title"=>'Assigned Workouts',

										 "page_link"=>'assign-workout',

										 "own_data" => isset($_REQUEST['assign_workout_own_data'])?esc_attr($_REQUEST['assign_workout_own_data']):0,

										 "add" => isset($_REQUEST['assign_workout_add'])?esc_attr($_REQUEST['assign_workout_add']):0,

										"edit"=>isset($_REQUEST['assign_workout_edit'])?esc_attr($_REQUEST['assign_workout_edit']):0,

										"view"=>isset($_REQUEST['assign_workout_view'])?esc_attr($_REQUEST['assign_workout_view']):0,

										"delete"=>isset($_REQUEST['assign_workout_delete'])?esc_attr($_REQUEST['assign_workout_delete']):0

							  ],



							   "nutrition"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/nutrition-schedule.png'),

							            "menu_title"=>'Nutrition Schedule',

										"page_link"=>'nutrition',

										 "own_data" => isset($_REQUEST['nutrition_own_data'])?esc_attr($_REQUEST['nutrition_own_data']):0,

										 "add" => isset($_REQUEST['nutrition_add'])?esc_attr($_REQUEST['nutrition_add']):0,

										"edit"=>isset($_REQUEST['nutrition_edit'])?esc_attr($_REQUEST['nutrition_edit']):0,

										"view"=>isset($_REQUEST['nutrition_view'])?esc_attr($_REQUEST['nutrition_view']):0,

										"delete"=>isset($_REQUEST['nutrition_delete'])?esc_attr($_REQUEST['nutrition_delete']):0

							  ],



							    "workouts"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/workout.png'),

								         "menu_title"=>'Workouts',

										 "page_link"=>'workouts',

										 "own_data" => isset($_REQUEST['workouts_own_data'])?esc_attr($_REQUEST['workouts_own_data']):0,

										 "add" => isset($_REQUEST['workouts_add'])?esc_attr($_REQUEST['workouts_add']):0,

										"edit"=>isset($_REQUEST['workouts_edit'])?esc_attr($_REQUEST['workouts_edit']):0,

										"view"=>isset($_REQUEST['workouts_view'])?esc_attr($_REQUEST['workouts_view']):0,

										"delete"=>isset($_REQUEST['workouts_delete'])?esc_attr($_REQUEST['workouts_delete']):0

							  ],

							  "product"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/products.png'),

							           "menu_title"=>'Product',

									   "page_link"=>'product',

										 "own_data" => isset($_REQUEST['product_own_data'])?esc_attr($_REQUEST['product_own_data']):0,

										 "add" => isset($_REQUEST['product_add'])?esc_attr($_REQUEST['product_add']):0,

										"edit"=>isset($_REQUEST['product_edit'])?esc_attr($_REQUEST['product_edit']):0,

										"view"=>isset($_REQUEST['product_view'])?esc_attr($_REQUEST['product_view']):0,

										"delete"=>isset($_REQUEST['product_delete'])?esc_attr($_REQUEST['product_delete']):0

							  ],



							  "store"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/store.png'),

							              "menu_title"=>'Store',

										  "page_link"=>'store',

										 "own_data" => isset($_REQUEST['store_own_data'])?esc_attr($_REQUEST['store_own_data']):0,

										 "add" => isset($_REQUEST['store_add'])?esc_attr($_REQUEST['store_add']):0,

										"edit"=>isset($_REQUEST['store_edit'])?esc_attr($_REQUEST['store_edit']):0,

										"view"=>isset($_REQUEST['store_view'])?esc_attr($_REQUEST['store_view']):0,

										"delete"=>isset($_REQUEST['store_delete'])?esc_attr($_REQUEST['store_delete']):0

							  ],

							  "reservation"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/reservation.png'),							       

								         "menu_title"=>'Reservation',

										 "page_link"=>'reservation',

										 "own_data" => isset($_REQUEST['reservation_own_data'])?esc_attr($_REQUEST['reservation_own_data']):0,

										 "add" => isset($_REQUEST['reservation_add'])?esc_attr($_REQUEST['reservation_add']):0,

										"edit"=>isset($_REQUEST['reservation_edit'])?esc_attr($_REQUEST['reservation_edit']):0,

										"view"=>isset($_REQUEST['reservation_view'])?esc_attr($_REQUEST['reservation_view']):0,

										"delete"=>isset($_REQUEST['reservation_delete'])?esc_attr($_REQUEST['reservation_delete']):0

							  ],

							

							    "attendence"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/attandance.png'),

								         "menu_title"=>'Attendence',

										 "page_link"=>'attendence',

										 "own_data" => isset($_REQUEST['attendence_own_data'])?esc_attr($_REQUEST['attendence_own_data']):0,

										 "add" => isset($_REQUEST['attendence_add'])?esc_attr($_REQUEST['attendence_add']):0,

										"edit"=>isset($_REQUEST['attendence_edit'])?esc_attr($_REQUEST['attendence_edit']):0,

										"view"=>isset($_REQUEST['attendence_view'])?esc_attr($_REQUEST['attendence_view']):0,

										"delete"=>isset($_REQUEST['attendence_delete'])?esc_attr($_REQUEST['attendence_delete']):0

							  ],	



							    "accountant"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/accountant.png'),

								          "menu_title"=>'Accountant',

										  "page_link"=>'accountant',

										 "own_data" => isset($_REQUEST['accountant_own_data'])?esc_attr($_REQUEST['accountant_own_data']):0,

										 "add" => isset($_REQUEST['accountant_add'])?esc_attr($_REQUEST['accountant_add']):0,

										"edit"=>isset($_REQUEST['accountant_edit'])?esc_attr($_REQUEST['accountant_edit']):0,

										"view"=>isset($_REQUEST['accountant_view'])?esc_attr($_REQUEST['accountant_view']):0,

										"delete"=>isset($_REQUEST['accountant_delete'])?esc_attr($_REQUEST['accountant_delete']):0

							  ],

							  

							   "tax"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/setting.png'),							       

											"menu_title"=>'Tax',

											"page_link"=>'tax',

											"own_data" => isset($_REQUEST['tax_own_data'])?esc_attr($_REQUEST['tax_own_data']):0,

											"add" => isset($_REQUEST['tax_add'])?esc_attr($_REQUEST['tax_add']):0,

											"edit"=>isset($_REQUEST['tax_edit'])?esc_attr($_REQUEST['tax_edit']):0,

											"view"=>isset($_REQUEST['tax_view'])?esc_attr($_REQUEST['tax_view']):0,

											"delete"=>isset($_REQUEST['tax_delete'])?esc_attr($_REQUEST['tax_delete']):0

								],

							  

							  

							  

							  "membership_payment"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/fee.png'),

							             "menu_title"=>'Membership Payment',

										 "page_link"=>'membership_payment',

										 "own_data" => isset($_REQUEST['membership_payment_own_data'])?($_REQUEST['membership_payment_own_data']):0,

										 "add" => isset($_REQUEST['membership_payment_add'])?esc_attr($_REQUEST['membership_payment_add']):0,

										"edit"=>isset($_REQUEST['membership_payment_edit'])?esc_attr($_REQUEST['membership_payment_edit']):0,

										"view"=>isset($_REQUEST['membership_payment_view'])?esc_attr($_REQUEST['membership_payment_view']):0,

										"delete"=>isset($_REQUEST['membership_payment_delete'])?esc_attr($_REQUEST['membership_payment_delete']):0

							  ],

							  

							  "payment"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/payment.png'),

							            "menu_title"=>'Payment',

										"page_link"=>'payment',

										"own_data" => isset($_REQUEST['payment_own_data'])?esc_attr($_REQUEST['payment_own_data']):0,

										"add" => isset($_REQUEST['payment_add'])?esc_attr($_REQUEST['payment_add']):0,

										"edit"=>isset($_REQUEST['payment_edit'])?esc_attr($_REQUEST['payment_edit']):0,

										"view"=>isset($_REQUEST['payment_view'])?esc_attr($_REQUEST['payment_view']):0,

										"delete"=>isset($_REQUEST['payment_delete'])?esc_attr($_REQUEST['payment_delete']):0

							  ],

							  "message"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/message.png'),

							            "menu_title"=>'Message',

										"page_link"=>'message',

										"own_data" => isset($_REQUEST['message_own_data'])?esc_attr($_REQUEST['message_own_data']):0,

										"add" => isset($_REQUEST['message_add'])?esc_attr($_REQUEST['message_add']):0,

										"edit"=>isset($_REQUEST['message_edit'])?esc_attr($_REQUEST['message_edit']):0,

										"view"=>isset($_REQUEST['message_view'])?esc_attr($_REQUEST['message_view']):0,

										"delete"=>isset($_REQUEST['message_delete'])?esc_attr($_REQUEST['message_delete']):0

							  ],

							  

							  "news_letter"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/newsletter.png'),

							            "menu_title"=>'Newsletter',

										"page_link"=>'news_letter',

										 "own_data" => isset($_REQUEST['news_letter_own_data'])?esc_attr($_REQUEST['news_letter_own_data']):0,

										 "add" => isset($_REQUEST['news_letter_add'])?esc_attr($_REQUEST['news_letter_add']):0,

										"edit"=>isset($_REQUEST['news_letter_edit'])?esc_attr($_REQUEST['news_letter_edit']):0,

										"view"=>isset($_REQUEST['news_letter_view'])?esc_attr($_REQUEST['news_letter_view']):0,

										"delete"=>isset($_REQUEST['news_letter_delete'])?esc_attr($_REQUEST['news_letter_delete']):0

							  ],

							  

							   "notice"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/notice.png'),

							           "menu_title"=>'Notice',

									   "page_link"=>'notice',

										 "own_data" => isset($_REQUEST['notice_own_data'])?esc_attr($_REQUEST['notice_own_data']):0,

										 "add" => isset($_REQUEST['notice_add'])?esc_attr($_REQUEST['notice_add']):0,

										"edit"=>isset($_REQUEST['notice_edit'])?esc_attr($_REQUEST['notice_edit']):0,

										"view"=>isset($_REQUEST['notice_view'])?esc_attr($_REQUEST['notice_view']):0,

										"delete"=>isset($_REQUEST['notice_delete'])?esc_attr($_REQUEST['notice_delete']):0

							  ],

							  

							   

							  

							  "report"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/reports.png'),							       

											"menu_title"=>'Report',

											"page_link"=>'report',

											"own_data" => isset($_REQUEST['report_own_data'])?esc_attr($_REQUEST['report_own_data']):0,

											"add" => isset($_REQUEST['report_add'])?esc_attr($_REQUEST['report_add']):0,

											"edit"=>isset($_REQUEST['report_edit'])?esc_attr($_REQUEST['report_edit']):0,

											"view"=>isset($_REQUEST['report_view'])?esc_attr($_REQUEST['report_view']):0,

											"delete"=>isset($_REQUEST['report_delete'])?esc_attr($_REQUEST['report_delete']):0

								],

								

							  "sms_setting"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/sms_setting.png'),							       

										"menu_title"=>'SMS Setting',

										"page_link"=>'sms_setting',

										"own_data" => isset($_REQUEST['sms_setting_own_data'])?esc_attr($_REQUEST['sms_setting_own_data']):0,

										"add" => isset($_REQUEST['sms_setting_add'])?esc_attr($_REQUEST['sms_setting_add']):0,

										"edit"=>isset($_REQUEST['sms_setting_edit'])?esc_attr($_REQUEST['sms_setting_edit']):0,

										"view"=>isset($_REQUEST['sms_setting_view'])?esc_attr($_REQUEST['sms_setting_view']):0,

										"delete"=>isset($_REQUEST['sms_setting_delete'])?esc_attr($_REQUEST['sms_setting_delete']):0

								],



							"mail_template"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/mail_template.png'),							       

											"menu_title"=>'Mail Template',

											"page_link"=>'mail_template',

											"own_data" => isset($_REQUEST['mail_template_own_data'])?esc_attr($_REQUEST['mail_template_own_data']):0,

											"add" => isset($_REQUEST['mail_template_add'])?esc_attr($_REQUEST['mail_template_add']):0,

											"edit"=>isset($_REQUEST['mail_template_edit'])?esc_attr($_REQUEST['mail_template_edit']):0,

											"view"=>isset($_REQUEST['mail_template_view'])?esc_attr($_REQUEST['mail_template_view']):0,

											"delete"=>isset($_REQUEST['mail_template_delete'])?esc_attr($_REQUEST['mail_template_delete']):0

							],

							"general_settings"=>["menu_icone"=>plugins_url( 'gym-management/assets/images/icon/mail_template.png'),

											   "menu_title"=>'General Settings',

											   "page_link"=>'general_settings',

											   "own_data" =>isset($_REQUEST['general_settings_own_data'])?$_REQUEST['general_settings_own_data']:0,

											   "add" =>isset($_REQUEST['general_settings_add'])?$_REQUEST['general_settings_add']:0,

												"edit"=>isset($_REQUEST['general_settings_edit'])?$_REQUEST['general_settings_edit']:0,

												"view"=>isset($_REQUEST['general_settings_view'])?$_REQUEST['general_settings_view']:0,

												"delete"=>isset($_REQUEST['general_settings_delete'])?$_REQUEST['general_settings_delete']:0

												]

						];
					
						
						$result=update_option( 'gmgt_access_right_management',$role_access_right);

						wp_redirect ( admin_url() . 'admin.php?page=gmgt_access_right&tab=management&message=1');

}

$access_right=get_option('gmgt_access_right_management');



if(isset($_REQUEST['message']))

{

	$message =esc_attr($_REQUEST['message']);

	if($message == 1)

	{?>

		<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">

				<p><?php esc_html_e('Management Access Right Updated Successfully.','gym_mgt');?></p>

				<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>

		</div>

	<?php 		

	}

}

?>

<div class=""><!--- PANEL WHITE DIV START -->

	<div class="header">	

		<h3 class="first_hed"><?php echo esc_html__( 'Management Access Right', 'gym_mgt'); ?></h3>

	</div>		

	<div class="panel-body"><!---  PANEL BODY DIV START-->

		<form name="student_form" action="" method="post" class="form-horizontal" id="access_right_form"><!--- STAFF MEMBER Access RIGHT FORM START-->

			<div class="row access_right_hed">

				<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min"><?php esc_html_e('Menu','gym_mgt');?></div>

				<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min"><?php esc_html_e('Own Data','gym_mgt');?></div>

				<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min padding_left_22"><?php esc_html_e('View','gym_mgt');?></div>

				<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min padding_left_18"><?php esc_html_e('Add','gym_mgt');?></div>

				<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min padding_left_18"><?php esc_html_e('Edit','gym_mgt');?></div>

				<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min padding_left_12"><?php esc_html_e('Delete ','gym_mgt');?></div>

			</div>	

			<div class="access_right_menucroll row"><!---  Access RIGHT ROW DIV START-->	

				

				<!-- Membership Type module code  -->

				

				<div class="row">

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_min_5_res">

						<span class="menu-label">

							<?php esc_html_e('Membership Type','gym_mgt');?>

						</span>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_20_res">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['membership']['own_data'],1);?> value="1" disabled name="membership_own_data">	              

							</label>

						</div>

					</div>

					

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['membership']['view'],1);?> value="1" name="membership_view">	              

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['membership']['add'],1);?> value="1" name="membership_add" >	              

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['membership']['edit'],1);?> value="1" name="membership_edit" >	              

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_15_min margin_left_20_min">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['membership']['delete'],1);?> value="1" name="membership_delete" >	              

							</label>

						</div>

					</div>

				</div>

				

				<!-- Membership Type module code  -->

				

				<div class="row">

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_min_5_res">

						<span class="menu-label">

							<?php esc_html_e('Group','gym_mgt');?>

						</span>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_20_res">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['group']['own_data'],1);?> value="1" name="group_own_data" disabled>	              

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['group']['view'],1);?> value="1" name="group_view">	              

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['group']['add'],1);?> value="1" name="group_add" >	              

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['group']['edit'],1);?> value="1" name="group_edit" >	              

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_15_min margin_left_20_min">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['group']['delete'],1);?> value="1" name="group_delete" >	              

							</label>

						</div>

					</div>						

				</div>

				

				<!-- staff_member module code  -->

			

				<div class="row">

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_min_5_res">

						<span class="menu-label">

							<?php esc_html_e('Staff Members','gym_mgt');?>

						</span>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_20_res">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['staff_member']['own_data'],1);?> value="1" name="staff_member_own_data" disabled>	              

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['staff_member']['view'],1);?> value="1" name="staff_member_view">	              

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['staff_member']['add'],1);?> value="1" name="staff_member_add">	              

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['staff_member']['edit'],1);?> value="1" name="staff_member_edit">	              

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_15_min margin_left_20_min">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['staff_member']['delete'],1);?> value="1" name="staff_member_delete">	              

							</label>

						</div>

					</div>

				</div>

				

				<!-- staff_member module code end -->

				

				<!-- Member module code  -->

				

				<div class="row">

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_min_5_res">

						<span class="menu-label">

							<?php esc_html_e('Member','gym_mgt');?>

						</span>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_20_res">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['member']['own_data'],1);?> value="1"  name="member_own_data" disabled>

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['member']['view'],1);?> value="1" name="member_view">	              

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['member']['add'],1);?> value="1" name="member_add">	              

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['member']['edit'],1);?> value="1" name="member_edit">	              

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_15_min margin_left_20_min">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['member']['delete'],1);?> value="1" name="member_delete">	              

							</label>

						</div>

					</div>

				</div>

				

				<!-- Activity module code  -->

				

				<div class="row">

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_min_5_res">

						<span class="menu-label">

							<?php esc_html_e('Activity','gym_mgt');?>

						</span>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_20_res">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['activity']['own_data'],1);?> value="1"  name="activity_own_data" disabled>

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['activity']['view'],1);?> value="1" name="activity_view">	              

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['activity']['add'],1);?> value="1" name="activity_add" >	              

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['activity']['edit'],1);?> value="1" name="activity_edit" >	              

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_15_min margin_left_20_min">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['activity']['delete'],1);?> value="1" name="activity_delete" >	              

							</label>

						</div>

					</div>

				</div>

				

				<!--Class schedule module code  -->

				

				<div class="row">

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_min_5_res">

						<span class="menu-label">

							<?php esc_html_e('Class schedule','gym_mgt');?>

						</span>

					</div>	

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_20_res">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['class-schedule']['own_data'],1);?> value="1"  name="class_schedule_own_data" disabled>

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['class-schedule']['view'],1);?> value="1" name="class_schedule_view">	              

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['class-schedule']['add'],1);?> value="1" name="class_schedule_add" >	              

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['class-schedule']['edit'],1);?> value="1" name="class_schedule_edit" >	              

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_15_min margin_left_20_min">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['class-schedule']['delete'],1);?> value="1" name="class_schedule_delete" >	              

							</label>

						</div>

					</div>							

				</div>					

				

				<!-- attendance module code  -->

				

				<div class="row">

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_min_5_res">

						<span class="menu-label">

							<?php esc_html_e('Member Attendance','gym_mgt');?>

						</span>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_20_res">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['attendence']['own_data'],1);?> value="1"  name="attendence_own_data" disabled>

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['attendence']['view'],1);?> value="1" name="attendence_view">	              

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['attendence']['add'],1);?> value="1" name="attendence_add">	              

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['attendence']['edit'],1);?> value="1" name="attendence_edit">	              

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_15_min margin_left_20_min">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['attendence']['delete'],1);?> value="1" name="attendence_delete" disabled>	              

							</label>

						</div>

					</div>							

				</div>						

				

				<!-- Assigned Workouts module code  -->

				

				<div class="row">

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_min_5_res">

						<span class="menu-label">

							<?php esc_html_e('Assigned Workouts','gym_mgt');?>

						</span>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_20_res">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['assign-workout']['own_data'],1);?> value="1"  name="assign_workout_own_data" disabled>

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['assign-workout']['view'],1);?> value="1" name="assign_workout_view">	              

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['assign-workout']['add'],1);?> value="1" name="assign_workout_add" >	              

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['assign-workout']['edit'],1);?> value="1" name="assign_workout_edit">	              

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_15_min margin_left_20_min">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['assign-workout']['delete'],1);?> value="1" name="assign_workout_delete" >	              

							</label>

						</div>

					</div>

				</div>



				<!-- Nutrition Schedule module code  -->

				

				<div class="row">

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_min_5_res">

						<span class="menu-label">

							<?php esc_html_e('Nutrition Schedule','gym_mgt');?>

						</span>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_20_res">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['nutrition']['own_data'],1);?> value="1" name="nutrition_own_data" disabled>

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['nutrition']['view'],1);?> value="1" name="nutrition_view">	              

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['nutrition']['add'],1);?> value="1" name="nutrition_add" >	              

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['nutrition']['edit'],1);?> value="1" name="nutrition_edit" disabled>	              

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_15_min margin_left_20_min">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['nutrition']['delete'],1);?> value="1" name="nutrition_delete" >	              

							</label>

						</div>

					</div>

				</div>

				

				<!-- workouts module code  -->

				

				<div class="row">

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_min_5_res">

						<span class="menu-label">

							<?php esc_html_e('Workouts','gym_mgt');?>

						</span>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_20_res">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['workouts']['own_data'],1);?> value="1" name="workouts_own_data" disabled>

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['workouts']['view'],1);?> value="1" name="workouts_view">	              

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['workouts']['add'],1);?> value="1" name="workouts_add" >	              

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['workouts']['edit'],1);?> value="1" name="workouts_edit" disabled >	              

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_15_min margin_left_20_min">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['workouts']['delete'],1);?> value="1" name="workouts_delete" >	              

							</label>

						</div>

					</div>

				</div>

				

				<!-- Accountant module code  -->

				

				<div class="row">

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_min_5_res">

						<span class="menu-label">

							<?php esc_html_e('Accountant','gym_mgt');?>

						</span>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_20_res">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['accountant']['own_data'],1);?> value="1" name="accountant_own_data" disabled>

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['accountant']['view'],1);?> value="1" name="accountant_view">	              

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['accountant']['add'],1);?> value="1" name="accountant_add">	              

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['accountant']['edit'],1);?> value="1" name="accountant_edit">	              

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_15_min margin_left_20_min">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['accountant']['delete'],1);?> value="1" name="accountant_delete">	              

							</label>

						</div>

					</div>

				</div>

				

				<!-- Fee Payment module code  -->

				

				<div class="row">

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_min_5_res">

						<span class="menu-label">

							<?php esc_html_e('Membership Payment','gym_mgt');?>

						</span>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_20_res">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['membership_payment']['own_data'],1);?> value="1" name="membership_payment_own_data" disabled>

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['membership_payment']['view'],1);?> value="1" name="membership_payment_view" >	              

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['membership_payment']['add'],1);?> value="1" name="membership_payment_add" >              

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['membership_payment']['edit'],1);?> value="1" name="membership_payment_edit">

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_15_min margin_left_20_min">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['membership_payment']['delete'],1);?> value="1" name="membership_payment_delete">

							</label>

						</div>

					</div>

				</div>

					

				<!--  Subscription module code  -->

				<?php

				$gym_recurring_enable=get_option("gym_recurring_enable");

				if($gym_recurring_enable == "yes")

				{

					?>

				<div class="row">

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_min_5_res">

						<span class="menu-label">

							<?php esc_html_e('Subscription','gym_mgt');?>

						</span>

					</div>

					

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_20_res">

						<div class="checkbox">

								<label>

									<input type="checkbox" <?php echo checked($access_right['management']['subscription']['own_data'],1);?> value="1" name="subscription_own_data" disabled >

								</label>

						</div>

					</div>

					

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['subscription']['view'],1);?> value="1" name="subscription_view" >	              

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['subscription']['add'],1);?> value="1" name="subscription_add" disabled>	              

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['subscription']['edit'],1);?> value="1" name="subscription_edit" disabled>	              

							</label>

						</div>

					</div>

					

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_15_min margin_left_20_min">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['subscription']['delete'],1);?> value="1" name="subscription_delete" disabled>	              

							</label>

						</div>

					</div>

				</div>

				

				<?php

				}

				?>



				<!-- Payment module code  -->

				

				<div class="row">

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_min_5_res">

						<span class="menu-label">

							<?php esc_html_e('Payment','gym_mgt');?>

						</span>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_20_res">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['payment']['own_data'],1);?> value="1" name="payment_own_data" disabled>

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['payment']['view'],1);?> value="1" name="payment_view">	              

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['payment']['add'],1);?> value="1" name="payment_add" >	              

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['payment']['edit'],1);?> value="1" name="payment_edit" >	              

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_15_min margin_left_20_min">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['payment']['delete'],1);?> value="1" name="payment_delete" >	              

							</label>

						</div>

					</div>

				</div>

				

				<!-- Tax module code  -->

				

				<div class="row">

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_min_5_res">

						<span class="menu-label">

							<?php esc_html_e('Tax','gym_mgt');?>

						</span>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_20_res">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['tax']['own_data'],1);?> value="1" name="tax_own_data" disabled>

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['tax']['view'],1);?> value="1" name="tax_view">	              

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['tax']['add'],1);?> value="1" name="tax_add">	              

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['tax']['edit'],1);?> value="1" name="tax_edit">	              

							</label>

						</div>

					</div>							

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_15_min margin_left_20_min">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['tax']['delete'],1);?> value="1" name="tax_delete">	              

							</label>

						</div>

					</div>							

				</div>	



				<!-- product module code  -->

				

				<div class="row">

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_min_5_res">

						<span class="menu-label">

							<?php esc_html_e('Product','gym_mgt');?>

						</span>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_20_res">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['product']['own_data'],1);?> value="1" name="product_own_data" disabled>

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['product']['view'],1);?> value="1" name="product_view">	              

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['product']['add'],1);?> value="1" name="product_add" >	              

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['product']['edit'],1);?> value="1" name="product_edit" >	              

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_15_min margin_left_20_min">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['product']['delete'],1);?> value="1" name="product_delete" >	              

							</label>

						</div>

					</div>

				</div>

				

				<!-- store module code  -->

				

				<div class="row">

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_min_5_res">

						<span class="menu-label">

							<?php esc_html_e('Store','gym_mgt');?>

						</span>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_20_res">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['store']['own_data'],1);?> value="1" name="store_own_data" disabled>

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['store']['view'],1);?> value="1" name="store_view">	              

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['store']['add'],1);?> value="1" name="store_add" >	              

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['store']['edit'],1);?> value="1" name="store_edit" >	              

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_15_min margin_left_20_min">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['store']['delete'],1);?> value="1" name="store_delete" >	              

							</label>

						</div>

					</div>

				</div>

				

				<!-- Newsletter module code  -->

				

				<div class="row">

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_min_5_res">

						<span class="menu-label">

							<?php esc_html_e('Newsletter','gym_mgt');?>

						</span>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_20_res">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['news_letter']['own_data'],1);?> value="1" name="news_letter_own_data" disabled>

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['news_letter']['view'],1);?> value="1" name="news_letter_view">	              

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['news_letter']['add'],1);?> value="1" name="news_letter_add">	              

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['news_letter']['edit'],1);?> value="1" name="news_letter_edit">	              

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_15_min margin_left_20_min">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['news_letter']['delete'],1);?> value="1" name="news_letter_delete" disabled>	              

							</label>

						</div>

					</div>

				</div>

				

				<!-- Message module code  -->

				

				<div class="row">

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_min_5_res">

						<span class="menu-label">

							<?php esc_html_e('Message','gym_mgt');?>

						</span>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_20_res">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['message']['own_data'],1);?> value="1" name="message_own_data" disabled>

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['message']['view'],1);?> value="1" name="message_view">	              

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['message']['add'],1);?> value="1" name="message_add" >	              

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['message']['edit'],1);?> value="1" name="message_edit" disabled>	              

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_15_min margin_left_20_min">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['message']['delete'],1);?> value="1" name="message_delete">	              

							</label>

						</div>

					</div>							

				</div>

				

				<!-- Notice module code  -->

				

				<div class="row">

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_min_5_res">

						<span class="menu-label">

							<?php esc_html_e('Notice','gym_mgt');?>

						</span>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_20_res">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['notice']['own_data'],1);?> value="1" name="notice_own_data" disabled>

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['notice']['view'],1);?> value="1" name="notice_view">	              

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['notice']['add'],1);?> value="1" name="notice_add">	              

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['notice']['edit'],1);?> value="1" name="notice_edit">	              

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_15_min margin_left_20_min">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['notice']['delete'],1);?> value="1" name="notice_delete">	              

							</label>

						</div>

					</div>							

				</div>

				

				<!-- reservation module code  -->

				

				<div class="row">

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_min_5_res">

						<span class="menu-label">

							<?php esc_html_e('Reservation','gym_mgt');?>

						</span>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_20_res">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['reservation']['own_data'],1);?> value="1" name="reservation_own_data" disabled >

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['reservation']['view'],1);?> value="1" name="reservation_view">	              

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['reservation']['add'],1);?> value="1" name="reservation_add" >	              

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['reservation']['edit'],1);?> value="1" name="reservation_edit" >	              

							</label>

						</div>

					</div>							

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_15_min margin_left_20_min">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['reservation']['delete'],1);?> value="1" name="reservation_delete" >	              

							</label>

						</div>

					</div>							

				</div>						

				

				<!-- Report module code  -->

				

				<div class="row">

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_min_5_res">

						<span class="menu-label">

							<?php esc_html_e('Report','gym_mgt');?>

						</span>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_20_res">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['report']['own_data'],1);?> value="1" name="report_own_data" disabled>

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['report']['view'],1);?> value="1" name="report_view">	              

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['report']['add'],1);?> value="1" name="report_add" disabled>	              

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['report']['edit'],1);?> value="1" name="report_edit" disabled>	              

							</label>

						</div>

					</div>							

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_15_min margin_left_20_min">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['report']['delete'],1);?> value="1" name="report_delete" disabled>	              

							</label>

						</div>

					</div>							

				</div>	

				

				<!-- SMS Setting module code  -->

				

				<div class="row">

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_min_5_res">

						<span class="menu-label">

							<?php esc_html_e('SMS Setting','gym_mgt');?>

						</span>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_20_res">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['sms_setting']['own_data'],1);?> value="1" name="sms_setting_own_data" disabled>

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['sms_setting']['view'],1);?> value="1" name="sms_setting_view">	              

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['sms_setting']['add'],1);?> value="1" name="sms_setting_add">	              

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['sms_setting']['edit'],1);?> value="1" name="sms_setting_edit">	              

							</label>

						</div>

					</div>							

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_15_min margin_left_20_min">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['sms_setting']['delete'],1);?> value="1" name="sms_setting_delete" disabled>	              

							</label>

						</div>

					</div>							

				</div>	



				

				<!-- Mail Template module code  -->

				<div class="row">

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_min_5_res">

						<span class="menu-label">

							<?php esc_html_e('Mail Template','gym_mgt');?>

						</span>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_20_res">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['mail_template']['own_data'],1);?> value="1" name="mail_template_own_data" disabled>

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['mail_template']['view'],1);?> value="1" name="mail_template_view">	              

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['mail_template']['add'],1);?> value="1" name="mail_template_add">	              

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['mail_template']['edit'],1);?> value="1" name="mail_template_edit">	              

							</label>

						</div>

					</div>							

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_15_min margin_left_20_min">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php echo checked($access_right['management']['mail_template']['delete'],1);?> value="1" name="mail_template_delete" disabled>	              

							</label>

						</div>

					</div>							

				</div>	

				

				<!-- General Settings module code  -->

				<div class="row">

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_min_5_res">

						<span class="menu-label">

							<?php esc_html_e('General Settings','gym_mgt');?>

						</span>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_20_res">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php if(!empty($access_right['management']['general_settings'])){ echo checked($access_right['management']['general_settings']['own_data'],1); }?> value="1" name="general_settings_own_data" disabled>

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php if(!empty($access_right['management']['general_settings'])){ echo checked($access_right['management']['general_settings']['view'],1); }?> value="1" name="general_settings_view">	              

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php if(!empty($access_right['management']['general_settings'])){ echo checked($access_right['management']['general_settings']['add'],1); }?> value="1" name="general_settings_add">	              

							</label>

						</div>

					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php if(!empty($access_right['management']['general_settings'])){ echo checked($access_right['management']['general_settings']['edit'],1); }?> value="1" name="general_settings_edit">	              

							</label>

						</div>

					</div>							

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_15_min margin_left_20_min">

						<div class="checkbox">

							<label>

								<input type="checkbox" <?php if(!empty($access_right['management']['general_settings'])){ echo checked($access_right['management']['general_settings']['delete'],1); }?> value="1" name="general_settings_delete" disabled>	              

							</label>

						</div>

					</div>							

				</div>	

			</div>	

			<!---  Access RIGHT ROW DIV END-->			

			<div class="col-md-6 col-sm-6 col-xs-12 mt-3"><!--save btn--> 					

				<input type="submit" value="<?php esc_html_e('Save', 'gym_mgt' ); ?>" name="save_access_right_managment" class="btn save_btn"/>

			</div>

		</form><!--- Staff MEMBER ACCESS RIGHT FORM END-->			

	</div><!--- END PANEL BODY DIV  -->

</div><!--- END MAIN INNER DIV -->