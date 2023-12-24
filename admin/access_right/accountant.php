<?php 	


$result=get_option('gmgt_access_right_accountant');


//SAVE ACCOUNTANT Access RIGHT DATA


if(isset($_POST['save_access_right']))


{


	$role_access_right = array();


	$result=get_option('gmgt_access_right_accountant');


	$role_access_right['accountant'] = [


							"staff_member"=>["menu_icone"=>plugins_url('gym-management/assets/images/icon/staff-member.png'),


							           "menu_title"=>'Staff Members',


							           "page_link"=>'staff_member',


									   "own_data" =>isset($_REQUEST['staff_member_own_data'])?esc_attr($_REQUEST['staff_member_own_data']):0,


									   "add" =>isset($_REQUEST['staff_member_add'])?esc_attr($_REQUEST['staff_member_add']):0,


										"edit"=>isset($_REQUEST['staff_member_edit'])?esc_attr($_REQUEST['staff_member_edit']):0,


										"view"=>isset($_REQUEST['staff_member_view'])?esc_attr($_REQUEST['staff_member_view']):0,


										"delete"=>isset($_REQUEST['staff_member_delete'])?esc_attr($_REQUEST['staff_member_delete']):0


										],


												


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


										 "own_data" => isset($_REQUEST['activity_own_data'])?esc_attr($_REQUEST['activity_own_data']):0,


										 "add" => isset($_REQUEST['activity_add'])?esc_attr($_REQUEST['activity_add']):0,


										"edit"=>isset($_REQUEST['activity_edit'])?esc_attr($_REQUEST['activity_edit']):0,


										"view"=>isset($_REQUEST['activity_view'])?esc_attr($_REQUEST['activity_view']):0,


										"delete"=>isset($_REQUEST['activity_delete'])?esc_attr($_REQUEST['activity_delete']):0


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


							  


							  "virtual_class"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/class-schedule.png'),							       


										 "menu_title"=>'Virtual class schedule',


										 "page_link"=>'virtual_class',


										 "own_data" => isset($_REQUEST['virtual_class_own_data'])?$_REQUEST['virtual_class_own_data']:0,


										 "add" => isset($_REQUEST['virtual_class_add'])?$_REQUEST['virtual_class_add']:0,


										"edit"=>isset($_REQUEST['virtual_class_edit'])?$_REQUEST['virtual_class_edit']:0,


										"view"=>isset($_REQUEST['virtual_class_view'])?$_REQUEST['virtual_class_view']:0,


										"delete"=>isset($_REQUEST['virtual_class_delete'])?$_REQUEST['virtual_class_delete']:0


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


										 "own_data" => isset($_REQUEST['nutrition_own_data'])?$_REQUEST['nutrition_own_data']:0,


										 "add" => isset($_REQUEST['nutrition_add'])?esc_attr($_REQUEST['nutrition_add']):0,


										"edit"=>isset($_REQUEST['nutrition_edit'])?esc_attr($_REQUEST['nutrition_edit']):0,


										"view"=>isset($_REQUEST['nutrition_view'])?esc_attr($_REQUEST['nutrition_view']):0,


										"delete"=>isset($_REQUEST['nutrition_delete'])?esc_attr($_REQUEST['nutrition_delete']):0


							  ],


							    "workouts"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/workout.png'),


								         "menu_title"=>'Workouts',


										 "page_link"=>'workouts',


										 "own_data" => isset($_REQUEST['workouts_own_data'])?$_REQUEST['workouts_own_data']:0,


										 "add" => isset($_REQUEST['workouts_add'])?esc_attr($_REQUEST['workouts_add']):0,


										"edit"=>isset($_REQUEST['workouts_edit'])?esc_attr($_REQUEST['workouts_edit']):0,


										"view"=>isset($_REQUEST['workouts_view'])?($_REQUEST['workouts_view']):0,


										"delete"=>isset($_REQUEST['workouts_delete'])?esc_attr($_REQUEST['workouts_delete']):0


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


							  


							  "membership_payment"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/fee.png'),


							             "menu_title"=>'Membership Payment',


										 "page_link"=>'membership_payment',


										 "own_data" => isset($_REQUEST['membership_payment_own_data'])?esc_attr($_REQUEST['membership_payment_own_data']):0,


										 "add" => isset($_REQUEST['membership_payment_add'])?esc_attr($_REQUEST['membership_payment_add']):0,


										"edit"=>isset($_REQUEST['membership_payment_edit'])?esc_attr($_REQUEST['membership_payment_edit']):0,


										"view"=>isset($_REQUEST['membership_payment_view'])?esc_attr($_REQUEST['membership_payment_view']):0,


										"delete"=>isset($_REQUEST['membership_payment_delete'])?esc_attr($_REQUEST['membership_payment_delete']):0


							  ],





							  "subscription"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/payment.png'),


								"menu_title"=>'subscription',


								"page_link"=>'subscription',


								"own_data" => isset($_REQUEST['subscription_own_data'])?($_REQUEST['subscription_own_data']):1,


								"add" => isset($_REQUEST['subscription_add'])?esc_attr($_REQUEST['subscription_add']):0,


								"edit"=>isset($_REQUEST['subscription_edit'])?esc_attr($_REQUEST['subscription_edit']):0,


								"view"=>isset($_REQUEST['subscription_view'])?esc_attr($_REQUEST['subscription_view']):0,


								"delete"=>isset($_REQUEST['subscription_delete'])?esc_attr($_REQUEST['subscription_delete']):0


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


							  "news_letter"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/newsletter.png'),


							            "menu_title"=>'Newsletter',


										"page_link"=>'news_letter',


										 "own_data" => isset($_REQUEST['news_letter_own_data'])?esc_attr($_REQUEST['news_letter_own_data']):0,


										 "add" => isset($_REQUEST['news_letter_add'])?esc_attr($_REQUEST['news_letter_add']):0,


										"edit"=>isset($_REQUEST['news_letter_edit'])?esc_attr($_REQUEST['news_letter_edit']):0,


										"view"=>isset($_REQUEST['news_letter_view'])?esc_attr($_REQUEST['news_letter_view']):0,


										"delete"=>isset($_REQUEST['news_letter_delete'])?esc_attr($_REQUEST['news_letter_delete']):0


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


							  


							   "notice"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/notice.png'),


							           "menu_title"=>'Notice',


									   "page_link"=>'notice',


										 "own_data" => isset($_REQUEST['notice_own_data'])?esc_attr($_REQUEST['notice_own_data']):0,


										 "add" => isset($_REQUEST['notice_add'])?esc_attr($_REQUEST['notice_add']):0,


										"edit"=>isset($_REQUEST['notice_edit'])?esc_attr($_REQUEST['notice_edit']):0,


										"view"=>isset($_REQUEST['notice_view'])?esc_attr($_REQUEST['notice_view']):0,


										"delete"=>isset($_REQUEST['notice_delete'])?esc_attr($_REQUEST['notice_delete']):0


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


							  


							  


							  "report"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/reports.png'),							       


											"menu_title"=>'Report',


											"page_link"=>'report',


											"own_data" => isset($_REQUEST['report_own_data'])?esc_attr($_REQUEST['report_own_data']):0,


											"add" => isset($_REQUEST['report_add'])?esc_attr($_REQUEST['report_add']):0,


											"edit"=>isset($_REQUEST['report_edit'])?esc_attr($_REQUEST['report_edit']):0,


											"view"=>isset($_REQUEST['report_view'])?esc_attr($_REQUEST['report_view']):0,


											"delete"=>isset($_REQUEST['report_delete'])?esc_attr($_REQUEST['report_delete']):0


								],


							  


							   "account"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/account.png'),


							              "menu_title"=>'Account',


										  "page_link"=>'account',


										 "own_data" => isset($_REQUEST['account_own_data'])?esc_attr($_REQUEST['account_own_data']):0,


										 "add" => isset($_REQUEST['account_add'])?($_REQUEST['account_add']):0,


										"edit"=>isset($_REQUEST['account_edit'])?esc_attr($_REQUEST['account_edit']):0,


										"view"=>isset($_REQUEST['account_view'])?esc_attr($_REQUEST['account_view']):0,


										"delete"=>isset($_REQUEST['account_delete'])?esc_attr($_REQUEST['account_delete']):0


							  ],


							   "subscription_history"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/subscription_history.png'),


							             "menu_title"=>'Membership History',


										 "page_link"=>'subscription_history',


										 "own_data" => isset($_REQUEST['subscription_history_own_data'])?esc_attr($_REQUEST['subscription_history_own_data']):0,


										 "add" => isset($_REQUEST['subscription_history_add'])?esc_attr($_REQUEST['subscription_history_add']):0,


										"edit"=>isset($_REQUEST['subscription_history_edit'])?esc_attr($_REQUEST['subscription_history_edit']):0,


										"view"=>isset($_REQUEST['subscription_history_view'])?esc_attr($_REQUEST['subscription_history_view']):0,


										"delete"=>isset($_REQUEST['subscription_history_delete'])?esc_attr($_REQUEST['subscription_history_delete']):0


							  ]							  


						];





						$result=update_option( 'gmgt_access_right_accountant',$role_access_right);


						wp_redirect ( admin_url() . 'admin.php?page=gmgt_access_right&tab=accountant&message=1');


}


$access_right=get_option('gmgt_access_right_accountant');





if(isset($_REQUEST['message']))


{


	$message =esc_attr($_REQUEST['message']);


	if($message == 1)


	{?>


		<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">


				<p><?php esc_html_e('Accountant Access Right Updated Successfully.','gym_mgt');?></p>


				<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>


		</div>


		<?php 


	}


}


?>


<div class=""><!--- PANEL WHITE DIV START -->


	<div class="header">	


		<h3 class="first_hed"><?php echo esc_html__( 'Accountant Access Right', 'gym_mgt'); ?></h3>


	</div>	


	<div class="panel-body"><!--- PANEL BODY DIV START -->


		<form name="student_form" action="" method="post" class="form-horizontal" id="access_right_form"><!--- ACCOUNTANT Access Right FORM START -->


			<div class="row access_right_hed">


				<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"><?php esc_html_e('Menu','gym_mgt');?></div>


				<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"><?php esc_html_e('Own Data','gym_mgt');?></div>


				<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 padding_left_22"><?php esc_html_e('View','gym_mgt');?></div>


				<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 padding_left_18"><?php esc_html_e('Add','gym_mgt');?></div>


				<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 padding_left_18"><?php esc_html_e('Edit','gym_mgt');?></div>


				<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 padding_left_12"><?php esc_html_e('Delete ','gym_mgt');?></div>


			</div>					


			<div class="access_right_menucroll row"><!--- Access RIGHT ROW DIV START -->	


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


								<input type="checkbox" <?php echo checked($access_right['accountant']['staff_member']['own_data'],1);?> value="1" name="staff_member_own_data" disabled>	              


							</label>


						</div>


					</div>


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['staff_member']['view'],1);?> value="1" name="staff_member_view">	              


							</label>


						</div>


					</div>


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['staff_member']['add'],1);?> value="1" name="staff_member_add" disabled>	              


							</label>


						</div>


					</div>


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['staff_member']['edit'],1);?> value="1" name="staff_member_edit" disabled>	              


							</label>


						</div>


					</div>


					


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_15_min margin_left_20_min">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['staff_member']['delete'],1);?> value="1" name="staff_member_delete" disabled>	              


							</label>


						</div>


					</div>


					


				</div>


				


				<!-- staff_member module code end -->


				


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


								<input type="checkbox" <?php echo checked($access_right['accountant']['membership']['own_data'],1);?> value="1" name="membership_own_data">	              


							</label>


						</div>


					</div>


					


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['membership']['view'],1);?> value="1" name="membership_view">	              


							</label>


						</div>


					</div>


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['membership']['add'],1);?> value="1" name="membership_add" >	              


							</label>


						</div>


					</div>


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['membership']['edit'],1);?> value="1" name="membership_edit" >	              


							</label>


						</div>


					</div>


					


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_15_min margin_left_20_min">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['membership']['delete'],1);?> value="1" name="membership_delete" >	              


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


								<input type="checkbox" <?php echo checked($access_right['accountant']['group']['own_data'],1);?> value="1" name="group_own_data">	              


							</label>


						</div>


					</div>


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['group']['view'],1);?> value="1" name="group_view">	              


							</label>


						</div>


					</div>


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['group']['add'],1);?> value="1" name="group_add" >	              


							</label>


						</div>


					</div>


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['group']['edit'],1);?> value="1" name="group_edit" >	              


							</label>


						</div>


					</div>


					


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_15_min margin_left_20_min">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['group']['delete'],1);?> value="1" name="group_delete" >	              


							</label>


						</div>


					</div>


					


				</div>


				


				


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


									<input type="checkbox" <?php echo checked($access_right['accountant']['member']['own_data'],1);?> value="1"  name="member_own_data" disabled>


								</label>


						</div>


					</div>


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['member']['view'],1);?> value="1" name="member_view">	              


							</label>


						</div>


					</div>


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['member']['add'],1);?> value="1" name="member_add">	              


							</label>


						</div>


					</div>


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['member']['edit'],1);?> value="1" name="member_edit">	              


							</label>


						</div>


					</div>


					


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_15_min margin_left_20_min">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['member']['delete'],1);?> value="1" name="member_delete">	              


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


									<input type="checkbox" <?php echo checked($access_right['accountant']['activity']['own_data'],1);?> value="1"  name="activity_own_data">


								</label>


						</div>


					</div>


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['activity']['view'],1);?> value="1" name="activity_view">	              


							</label>


						</div>


					</div>


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['activity']['add'],1);?> value="1" name="activity_add" >	              


							</label>


						</div>


					</div>


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['activity']['edit'],1);?> value="1" name="activity_edit" >	              


							</label>


						</div>


					</div>


					


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_15_min margin_left_20_min">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['activity']['delete'],1);?> value="1" name="activity_delete" >	              


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


									<input type="checkbox" <?php echo checked($access_right['accountant']['class-schedule']['own_data'],1);?> value="1"  name="class_schedule_own_data">


								</label>


						</div>


					</div>


					


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['class-schedule']['view'],1);?> value="1" name="class_schedule_view">	              


							</label>


						</div>


					</div>


					


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['class-schedule']['add'],1);?> value="1" name="class_schedule_add" >	              


							</label>


						</div>


					</div>


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['class-schedule']['edit'],1);?> value="1" name="class_schedule_edit" >	              


							</label>


						</div>


					</div>


					


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_15_min margin_left_20_min">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['class-schedule']['delete'],1);?> value="1" name="class_schedule_delete" >	              


							</label>


						</div>


					</div>							


				</div>	





					<!--Class schedule module code  -->


				<div class="row">


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_min_5_res">


						<span class="menu-label">


							<?php esc_html_e('Virtual class schedule','gym_mgt');?>


						</span>


					</div>	


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_20_res">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['virtual_class']['own_data'],1);?> value="1"  name="virtual_class_own_data" disabled>


							</label>


						</div>


					</div>


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['virtual_class']['view'],1);?> value="1" name="virtual_class_view">	              


							</label>


						</div>


					</div>


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['virtual_class']['add'],1);?> value="1" name="virtual_class_add" disabled >	              


							</label>


						</div>


					</div>


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['virtual_class']['edit'],1);?> value="1" name="virtual_class_edit" disabled >	              


							</label>


						</div>


					</div>


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_15_min margin_left_20_min">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['virtual_class']['delete'],1);?> value="1" name="virtual_class_delete" disabled >	              


							</label>


						</div>


					</div>							


				</div>								


				


				<!-- attendence module code  -->


				


					<div class="row">


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_min_5_res">


						<span class="menu-label">


							<?php esc_html_e('Attendence','gym_mgt');?>


						</span>


					</div>


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_20_res">


						<div class="checkbox">


								<label>


									<input type="checkbox" <?php echo checked($access_right['accountant']['attendence']['own_data'],1);?> value="1"  name="attendence_own_data" disabled>


								</label>


						</div>


					</div>


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['attendence']['view'],1);?> value="1" name="attendence_view">	              


							</label>


						</div>


					</div>


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['attendence']['add'],1);?> value="1" name="attendence_add" disabled>	              


							</label>


						</div>


					</div>


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['attendence']['edit'],1);?> value="1" name="attendence_edit" disabled>	              


							</label>


						</div>


					</div>


					


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_15_min margin_left_20_min">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['attendence']['delete'],1);?> value="1" name="attendence_delete" disabled>	              


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


									<input type="checkbox" <?php echo checked($access_right['accountant']['assign-workout']['own_data'],1);?> value="1"  name="assign_workout_own_data" disabled>


								</label>


						</div>


					</div>


					


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['assign-workout']['view'],1);?> value="1" name="assign_workout_view">	              


							</label>


						</div>


					</div>


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['assign-workout']['add'],1);?> value="1" name="assign_workout_add" >	              


							</label>


						</div>


					</div>


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['assign-workout']['edit'],1);?> value="1" name="assign_workout_edit" disabled>	              


							</label>


						</div>


					</div>


					


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_15_min margin_left_20_min">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['assign-workout']['delete'],1);?> value="1" name="assign_workout_delete" >	              


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


								<input type="checkbox" <?php echo checked($access_right['accountant']['nutrition']['own_data'],1);?> value="1" name="nutrition_own_data" disabled>


							</label>


						</div>


					</div>


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['nutrition']['view'],1);?> value="1" name="nutrition_view">	              


							</label>


						</div>


					</div>


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['nutrition']['add'],1);?> value="1" name="nutrition_add" >	              


							</label>


						</div>


					</div>


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['nutrition']['edit'],1);?> value="1" name="nutrition_edit" disabled>	              


							</label>


						</div>


					</div>


					


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_15_min margin_left_20_min">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['nutrition']['delete'],1);?> value="1" name="nutrition_delete" >	              


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


								<input type="checkbox" <?php echo checked($access_right['accountant']['workouts']['own_data'],1);?> value="1" name="workouts_own_data" disabled>


							</label>


						</div>


					</div>


					


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['workouts']['view'],1);?> value="1" name="workouts_view">	              


							</label>


						</div>


					</div>


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['workouts']['add'],1);?> value="1" name="workouts_add" >	              


							</label>


						</div>


					</div>


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['workouts']['edit'],1);?> value="1" name="workouts_edit" >	              


							</label>


						</div>


					</div>


					


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_15_min margin_left_20_min">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['workouts']['delete'],1);?> value="1" name="workouts_delete" >	              


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


									<input type="checkbox" <?php echo checked($access_right['accountant']['accountant']['own_data'],1);?> value="1" name="accountant_own_data" disabled>


								</label>


						</div>


					</div>


					


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['accountant']['view'],1);?> value="1" name="accountant_view">	              


							</label>


						</div>


					</div>


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['accountant']['add'],1);?> value="1" name="accountant_add" disabled>	              


							</label>


						</div>


					</div>


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['accountant']['edit'],1);?> value="1" name="accountant_edit" disabled>	              


							</label>


						</div>


					</div>


					


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_15_min margin_left_20_min">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['accountant']['delete'],1);?> value="1" name="accountant_delete" disabled>	              


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


									<input type="checkbox" <?php echo checked($access_right['accountant']['membership_payment']['own_data'],1);?> value="1" name="membership_payment_own_data" disabled>


								</label>


						</div>


					</div>


					


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['membership_payment']['view'],1);?> value="1" name="membership_payment_view">	              


							</label>


						</div>


					</div>


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['membership_payment']['add'],1);?> value="1" name="membership_payment_add">	              


							</label>


						</div>


					</div>


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['membership_payment']['edit'],1);?> value="1" name="membership_payment_edit">	              


							</label>


						</div>


					</div>


					


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_15_min margin_left_20_min">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['membership_payment']['delete'],1);?> value="1" name="membership_payment_delete">	              


							</label>


						</div>


					</div>


					


				</div>


				<?php


				$gym_recurring_enable=get_option("gym_recurring_enable");


				if($gym_recurring_enable == "yes")


				{


					?>


				<!--  Subscription module code  -->


				


				<div class="row">


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_min_5_res">


						<span class="menu-label">


							<?php esc_html_e('Subscription','gym_mgt');?>


						</span>


					</div>


					


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_20_res">


						<div class="checkbox">


								<label>


									<input type="checkbox" <?php echo checked($access_right['accountant']['subscription']['own_data'],1);?> value="1" name="subscription_own_data" >


								</label>


						</div>


					</div>


					


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['subscription']['view'],1);?> value="1" name="subscription_view" >	              


							</label>


						</div>


					</div>


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['subscription']['add'],1);?> value="1" name="subscription_add" disabled>	              


							</label>


						</div>


					</div>


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['subscription']['edit'],1);?> value="1" name="subscription_edit" disabled>	              


							</label>


						</div>


					</div>


					


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_15_min margin_left_20_min">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['subscription']['delete'],1);?> value="1" name="subscription_delete" disabled>	              


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


									<input type="checkbox" <?php echo checked($access_right['accountant']['payment']['own_data'],1);?> value="1" name="payment_own_data">


								</label>


						</div>


					</div>


					


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['payment']['view'],1);?> value="1" name="payment_view">	              


							</label>


						</div>


					</div>


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['payment']['add'],1);?> value="1" name="payment_add" >	              


							</label>


						</div>


					</div>


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['payment']['edit'],1);?> value="1" name="payment_edit" >	              


							</label>


						</div>


					</div>


					


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_15_min margin_left_20_min">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['payment']['delete'],1);?> value="1" name="payment_delete" >	              


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


								<input type="checkbox" <?php echo checked($access_right['accountant']['product']['own_data'],1);?> value="1" name="product_own_data">


							</label>


						</div>


					</div>


					


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['product']['view'],1);?> value="1" name="product_view">	              


							</label>


						</div>


					</div>


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['product']['add'],1);?> value="1" name="product_add" >	              


							</label>


						</div>


					</div>


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['product']['edit'],1);?> value="1" name="product_edit" >	              


							</label>


						</div>


					</div>


					


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_15_min margin_left_20_min">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['product']['delete'],1);?> value="1" name="product_delete" >	              


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


								<input type="checkbox" <?php echo checked($access_right['accountant']['store']['own_data'],1);?> value="1" name="store_own_data">


							</label>


						</div>


					</div>


					


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['store']['view'],1);?> value="1" name="store_view">	              


							</label>


						</div>


					</div>


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['store']['add'],1);?> value="1" name="store_add" >	              


							</label>


						</div>


					</div>


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['store']['edit'],1);?> value="1" name="store_edit" >	              


							</label>


						</div>


					</div>


					


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_15_min margin_left_20_min">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['store']['delete'],1);?> value="1" name="store_delete" >	              


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


								<input type="checkbox" <?php echo checked($access_right['accountant']['news_letter']['own_data'],1);?> value="1" name="news_letter_own_data" disabled>


							</label>


						</div>


					</div>


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['news_letter']['view'],1);?> value="1" name="news_letter_view">	              


							</label>


						</div>


					</div>


					


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['news_letter']['add'],1);?> value="1" name="news_letter_add" disabled>	              


							</label>


						</div>


					</div>


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['news_letter']['edit'],1);?> value="1" name="news_letter_edit" disabled>	              


							</label>


						</div>


					</div>


					


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_15_min margin_left_20_min">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['news_letter']['delete'],1);?> value="1" name="news_letter_delete" disabled>	              


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


								<input type="checkbox" <?php echo checked($access_right['accountant']['message']['own_data'],1);?> value="1" name="message_own_data" disabled>


							</label>


						</div>


					</div>


					


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['message']['view'],1);?> value="1" name="message_view">	              


							</label>


						</div>


					</div>


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['message']['add'],1);?> value="1" name="message_add" >	              


							</label>


						</div>


					</div>


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['message']['edit'],1);?> value="1" name="message_edit" disabled>	              


							</label>


						</div>


					</div>


					


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_15_min margin_left_20_min">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['message']['delete'],1);?> value="1" name="message_delete" >	              


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


								<input type="checkbox" <?php echo checked($access_right['accountant']['notice']['own_data'],1);?> value="1" name="notice_own_data">


							</label>


						</div>


					</div>


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['notice']['view'],1);?> value="1" name="notice_view">	              


							</label>


						</div>


					</div>


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['notice']['add'],1);?> value="1" name="notice_add" disabled>	              


							</label>


						</div>


					</div>


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['notice']['edit'],1);?> value="1" name="notice_edit" disabled>	              


							</label>


						</div>


					</div>


					


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_15_min margin_left_20_min">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['notice']['delete'],1);?> value="1" name="notice_delete" disabled>	              


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


								<input type="checkbox" <?php echo checked($access_right['accountant']['reservation']['own_data'],1);?> value="1" name="reservation_own_data" >


							</label>


						</div>


					</div>


					


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['reservation']['view'],1);?> value="1" name="reservation_view">	              


							</label>


						</div>


					</div>


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['reservation']['add'],1);?> value="1" name="reservation_add" >	              


							</label>


						</div>


					</div>


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['reservation']['edit'],1);?> value="1" name="reservation_edit" >	              


							</label>


						</div>


					</div>							


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_15_min margin_left_20_min">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['reservation']['delete'],1);?> value="1" name="reservation_delete" >	              


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


								<input type="checkbox" <?php echo checked($access_right['accountant']['report']['own_data'],1);?> value="1" name="report_own_data" disabled>


							</label>


						</div>


					</div>


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['report']['view'],1);?> value="1" name="report_view">	              


							</label>


						</div>


					</div>


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['report']['add'],1);?> value="1" name="report_add" disabled>	              


							</label>


						</div>


					</div>


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['report']['edit'],1);?> value="1" name="report_edit" disabled>	              


							</label>


						</div>


					</div>							


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_15_min margin_left_20_min">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['report']['delete'],1);?> value="1" name="report_delete" disabled>	              


							</label>


						</div>


					</div>							


				</div>								


				


				<!-- Account module code  -->


				


					<div class="row">


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_min_5_res">


						<span class="menu-label">


							<?php esc_html_e('Account','gym_mgt');?>


						</span>


					</div>


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_20_res">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['account']['own_data'],1);?> value="1" name="account_own_data" disabled>


							</label>


						</div>


					</div>


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['account']['view'],1);?> value="1" name="account_view">	              


							</label>


						</div>


					</div>


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['account']['add'],1);?> value="1" name="account_add" disabled>	              


							</label>


						</div>


					</div>


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['account']['edit'],1);?> value="1" name="account_edit">	              


							</label>


						</div>


					</div>


					


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_15_min margin_left_20_min">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['account']['delete'],1);?> value="1" name="account_delete" disabled>	              


							</label>


						</div>


					</div>


					


				</div>


				


				


				<!-- Membership History module code  -->


				


					<div class="row">


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_min_5_res">


						<span class="menu-label">


							<?php esc_html_e('Membership History','gym_mgt');?>


						</span>


					</div>


					


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_20_res">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['subscription_history']['own_data'],1);?> value="1" name="subscription_history_own_data" disabled>


							</label>


						</div>


					</div>


					


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['subscription_history']['view'],1);?> value="1" name="subscription_history_view">	              


							</label>


						</div>


					</div>


					


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['subscription_history']['add'],1);?> value="1" name="subscription_history_add" disabled>	              


							</label>


						</div>


					</div>


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_10_min">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['subscription_history']['edit'],1);?> value="1" name="subscription_history_edit" disabled>	              


							</label>


						</div>


					</div>								


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_15_min margin_left_20_min">


						<div class="checkbox">


							<label>


								<input type="checkbox" <?php echo checked($access_right['accountant']['subscription_history']['delete'],1);?> value="1" name="subscription_history_delete" disabled>	              


							</label>


						</div>


					</div>							


				</div>						


			</div><!--- Access RIGHT ROW DIV END -->							


			<div class="col-md-6 col-sm-6 col-xs-12 mt-3"><!--save btn--> 								


				<input type="submit" value="<?php esc_html_e('Save', 'gym_mgt' ); ?>" name="save_access_right" class="btn save_btn"/>


			</div>


		</form><!--- ACCOUNTANT Access RIGHT FORM END -->		


	</div><!--- END PANEL BODY DIV  -->


</div><!---PANEL WHITE DIV END -->