<?php







$role=MJ_gmgt_get_roles(get_current_user_id());







if($role == 'administrator')







{







	$user_access_add=1;







	$user_access_edit=1;







	$user_access_view=1;







}







else







{







	$user_access=MJ_gmgt_get_userrole_wise_manually_page_access_right_array_for_management('mail_template');







	$user_access_add=$user_access['add'];







	$user_access_edit=$user_access['edit'];







	$user_access_view=$user_access['view'];







	if (isset ( $_REQUEST ['page'] ))







	{	







		if($user_access_view=='0')







		{	







			MJ_gmgt_access_right_page_not_access_message_for_management();







			die;







		}







		if(!empty($_REQUEST['action']))







		{







			if ('mail_template' == $user_access['page_link'] && ($_REQUEST['action']=='edit'))







			{







				if($user_access_edit=='0')







				{	







					MJ_gmgt_access_right_page_not_access_message_for_management();







					die;







				}			







			}







			if ('mail_template' == $user_access['page_link'] && ($_REQUEST['action']=='delete'))







			{







				if($user_access_delete=='0')







				{	







					MJ_gmgt_access_right_page_not_access_message_for_management();







					die;







				}	







			}







			if ('mail_template' == $user_access['page_link'] && ($_REQUEST['action']=='insert'))







			{







				if($user_access_add=='0')







				{	







					MJ_gmgt_access_right_page_not_access_message_for_management();







					die;







				}	







			} 







		}







	}







}







//UPDATE MAIL NOTIFICATION OPTION DATA







if(isset($_REQUEST['save_registration_template']))







{







	update_option('registration_title',$_REQUEST['registration_title']);







	update_option('registration_mailtemplate',$_REQUEST['registration_mailtemplate']);







} 







if(isset($_REQUEST['save_Member_Approved_Template'])){







	update_option('Member_Approved_Template_Subject',$_REQUEST['Member_Approved_Template_Subject']);







	update_option('Member_Approved_Template',$_REQUEST['Member_Approved_Template']);







} 







if(isset($_REQUEST['save_Other_User_in_system'])){







	update_option('Add_Other_User_in_System_Subject',$_REQUEST['Add_Other_User_in_System_Subject']);







	update_option('Add_Other_User_in_System_Template',$_REQUEST['Add_Other_User_in_System_Template']);







}







if(isset($_REQUEST['Save_Notice_Template'])){







	update_option('Add_Notice_Subject',$_REQUEST['Add_Notice_Subject']);







	update_option('Add_Notice_Template',$_REQUEST['Add_Notice_Template']);







}















if(isset($_REQUEST['Save_Member_Added_In_Group'])){







	update_option('Member_Added_In_Group_subject',$_REQUEST['Member_Added_In_Group_subject']);







	update_option('Member_Added_In_Group_Template',$_REQUEST['Member_Added_In_Group_Template']);







}







if(isset($_REQUEST['Save_Assign_Workouts'])){







	update_option('Assign_Workouts_Subject',$_REQUEST['Assign_Workouts_Subject']);







	update_option('Assign_Workouts_Template',$_REQUEST['Assign_Workouts_Template']);







}







if(isset($_REQUEST['save_sell_product'])){







	update_option('sell_product_subject',$_REQUEST['sell_product_subject']);







	update_option('sell_product_template',$_REQUEST['sell_product_template']);







}







if(isset($_REQUEST['Save_Reservation_Template'])){







	update_option('Add_Reservation_Subject',$_REQUEST['Add_Reservation_Subject']);







	update_option('Add_Reservation_Template',$_REQUEST['Add_Reservation_Template']);







}







if(isset($_REQUEST['save_generate_invoice'])){







	update_option('generate_invoice_subject',$_REQUEST['generate_invoice_subject']);







	update_option('generate_invoice_template',$_REQUEST['generate_invoice_template']);







}







if(isset($_REQUEST['Save_Assign_Nutrition_Schedule'])){







	update_option('Assign_Nutrition_Schedule_Subject',$_REQUEST['Assign_Nutrition_Schedule_Subject']);







	update_option('Assign_Nutrition_Schedule_Template',$_REQUEST['Assign_Nutrition_Schedule_Template']);







}







if(isset($_REQUEST['Save_Assign_Nutrition_Schedule'])){







	update_option('Assign_Nutrition_Schedule_Subject',$_REQUEST['Assign_Nutrition_Schedule_Subject']);







	update_option('Assign_Nutrition_Schedule_Template',$_REQUEST['Assign_Nutrition_Schedule_Template']);







}







if(isset($_REQUEST['save_add_income_template'])){







	update_option('add_income_subject',$_REQUEST['add_income_subject']);







	update_option('add_income_template',$_REQUEST['add_income_template']);







}







if(isset($_REQUEST['save_add_income_template'])){







	update_option('add_income_subject',$_REQUEST['add_income_subject']);







	update_option('add_income_template',$_REQUEST['add_income_template']);







}







if(isset($_REQUEST['savePaymentReceivedAgainstInvoiceTemplate'])){







	update_option('payment_received_against_invoice_subject',$_REQUEST['payment_received_against_invoice_subject']);







	update_option('payment_received_against_invoice_template',$_REQUEST['payment_received_against_invoice_template']);







}







if(isset($_REQUEST['saveMessageReceiveTemplate'])){







	update_option('message_received_subject',$_REQUEST['message_received_subject']);







	update_option('message_received_template',$_REQUEST['message_received_template']);







}















if(isset($_REQUEST['Submit_Workouts_Save'])){







	update_option('Submit_Workouts_Subject',$_REQUEST['Submit_Workouts_Subject']);






	update_option('Submit_Workouts_Template',$_REQUEST['Submit_Workouts_Template']);







}

if(isset($_REQUEST['Member_Submit_Workouts_Save'])){

	update_option('Submit_Workouts_Subject_for_member',$_REQUEST['Submit_Workouts_Subject_for_member']);

	update_option('Submit_Workouts_Template_for_member',$_REQUEST['Submit_Workouts_Template_for_member']);
}


if(isset($_REQUEST['save_payment_reminder_subject'])){







	update_option('payment_reminder_subject',$_REQUEST['payment_reminder_subject']);







	update_option('payment_reminder_template',$_REQUEST['payment_reminder_template']);







}







if(isset($_REQUEST['save_invoice_payment_reminder_subject'])){







	update_option('invoice_payment_reminder_subject',$_REQUEST['invoice_payment_reminder_subject']);







	update_option('invoice_payment_reminder_template',$_REQUEST['invoice_payment_reminder_template']);







}



if(isset($_REQUEST['save_membership_expire_reminder_subject'])){







	update_option('gmgt_reminder_subject',$_REQUEST['gmgt_reminder_subject']);







	update_option('gym_reminder_message',$_REQUEST['gym_reminder_message']);







}



if(isset($_REQUEST['save_membership_expire_subject'])){







	update_option('gmgt_expire_subject',$_REQUEST['gmgt_expire_subject']);







	update_option('gym_expire_message',$_REQUEST['gym_expire_message']);







}







?>







<style>







.collapse:not(.show)







{







  display: none !important;







}







</style>















<div class="page-inner min_height_1088"><!-- PAGE INNNER DIV START-->	







	<div class="gms_main_list"><!-- MAIN_LIST_MARGING_15px START -->















		<div class="row"><!--ROW DIV START-->







			<div class="col-md-12 padding_0"><!--COL 12 DIV START-->







				<div class="panel-body main_email_template"><!--PANEL BODY DIV START-->







					<div class="gmgt_accordion panel-group accordion" id="accordionExample"><!-- PANEL GROUP DIV START--> 







						<div class="panel-default accordion-item"> <!-- PANEL DEFAULT DIV START--> 







							<div class="panel-heading padding_0">







								<h4 class="accordion-header panel-title" id="headingOne">







									<button class="accordion-button accordion-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">







									<?php esc_html_e('Member Registration Template','gym_mgt'); ?>







								</button>







								</h4>







							</div>







							<!---------Member REGISTRATION MAIL Notification Template--------->







							<div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">







								<div class="accordion-body panel-body">







									<form id="registration_email_template_form" class="form-horizontal" method="post" action="" name="parent_form">







										<div class="row">







											<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">







												<div class="form-group input">







													<div class="col-md-12 form-control input_height_75px">







														<input class="form-control validate[required] line_height_2" type="text" name="registration_title" id="registration_title" placeholder="<?php esc_html_e('Enter email subject','gym_mgt');?>" value="<?php print esc_attr(get_option('registration_title')); ?>">







														<label for="first_name" class="col-sm-3 control-label"><?php esc_html_e('Email Subject','gym_mgt');?></label>







													</div>







												</div>







											</div>







											<div class="col-md-6">







												<div class="form-group input">







													<div class="col-md-12 form-control texarea_padding_15">







														<textarea name="registration_mailtemplate" class="min_height_200 form-control validate[required] h-200-px texarea_padding_0"><?php print esc_attr(get_option('registration_mailtemplate')); ?></textarea>







														<label for="first_name" class="textarea_label"><?php esc_html_e('Member Registration Template','gym_mgt'); ?> </label>







													</div>







												</div>







											</div>







										</div>







										<div class="form-group input">







											<div class="col-md-12">







												<label><?php esc_html_e('You can use following variables in the email template:','gym_mgt');?></label><br>







												<label><strong>[GMGT_MEMBERNAME] - </strong><?php esc_html_e('The member name','gym_mgt');?></label><br>







												<label><strong>[GMGT_MEMBERID] - </strong><?php esc_html_e('The member id','gym_mgt');?></label><br>







												<label><strong>[GMGT_MEMBERSHIP] - </strong><?php esc_html_e('Membership name','gym_mgt');?></label><br>







												<label><strong>[GMGT_STARTDATE] - </strong><?php esc_html_e('Membership start date','gym_mgt');?></label><br>







												<label><strong>[GMGT_ENDDATE] - </strong><?php esc_html_e('Membership end date','gym_mgt');?></label><br>







												<label><strong>[GMGT_GYM_NAME] - </strong><?php esc_html_e('Gym Name','gym_mgt');?></label><br>







											</div>







										</div>







										<?php 







										if($user_access_add == '1' OR  $user_access_edit == '1')







										{ ?>







											<!------------   save btn  -------------->  







											<div class="form-body user_form"> <!-- user_form Strat-->   







												<div class="row"><!--Row Div Strat--> 







													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">          	







														<input value="<?php esc_html_e('Save','gym_mgt')?>" name="save_registration_template" class="btn btn-success save_btn" type="submit">







													</div>







												</div>







											</div>







											<?php 







										} ?>







									</form>







								</div>







							</div>







						</div><!--PANEL DEFAULT DIV END-->







						<!---------Member Approved by admin MAIL Notification Template--------->







						<div class="accordion-item panel-default"><!-- PANEL DEFAULT DIV START--> 







							<div class="panel-heading padding_0">







								<h4 class="accordion-header" id="headingtwentythree">







									<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwentyThree" aria-expanded="false" aria-controls="collapseTwentyThree">







										<?php esc_html_e('Member Approved Template ','gym_mgt'); ?>







									</button>







								</h4>







							</div>







							<div id="collapseTwentyThree" class="accordion-collapse collapse" aria-labelledby="headingtwentythree" data-bs-parent="#accordionExample">







								<div class="accordion-body panel-body">







									<form id="email_template_form" class="form-horizontal" method="post" action="" name="parent_form">







										<div class="row">







											<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">







												<div class="form-group input">







													<div class="col-md-12 form-control input_height_75px">







														<input id="Member_Approved_Template_Subject" class="form-control validate[required] line_height_2" type="text" name="Member_Approved_Template_Subject" id="Member_Approved_Template_Subject" placeholder="<?php esc_html_e('Enter email subject','gym_mgt');?>" value="<?php echo esc_attr(get_option('Member_Approved_Template_Subject')); ?>">







														<label for="learner_complete_quiz_notification_title" class=""><?php esc_html_e('Email Subject','gym_mgt');?> <span class="require-field">*</span></label>







													</div>







												</div>







											</div>







											<div class="col-md-6">







												<div class="form-group input">







													<div class="col-md-12 form-control texarea_padding_15">







														<textarea id="Member_Approved_Template" name="Member_Approved_Template" class="form-control validate[required] min_height_200 texarea_padding_0"><?php echo get_option('Member_Approved_Template');?></textarea>







														<label for="learner_complete_quiz_notification_mailcontent" class="textarea_label"><?php esc_html_e('Member Approved Template','gym_mgt');?><span class="require-field">*</span></label>







													</div>







												</div>







											</div>







										</div>







										<div class="form-group input">







											<div class="col-md-12">







												<label><?php esc_html_e('You can use following variables in the email template:','gym_mgt');?></label><br>







												<label><strong>[GMGT_MEMBERNAME] - </strong><?php esc_html_e('The member name','gym_mgt');?></label><br>







												<label><strong>[GMGT_GYM_NAME] - </strong><?php esc_html_e('Gym Name','gym_mgt');?></label><br>







												<label><strong>[GMGT_LOGIN_LINK] - </strong><?php esc_html_e('Login Link','gym_mgt');?></label><br>







											</div>







										</div>







										<?php 







										if($user_access_add == '1' OR  $user_access_edit == '1')







										{ ?>







											<div class="form-body user_form"> <!-- user_form Strat-->   







												<div class="row"><!--Row Div Strat--> 







													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">      







														<input type="submit" value="<?php  esc_html_e('Save','gym_mgt')?>" name="save_Member_Approved_Template" class="btn btn-success save_btn"/>







													</div>







												</div>







											</div>







											<?php 







										} ?>







									</form>







								</div>







							</div>







						</div>  <!--PANEL DEFAULT DIV END-->					







						<!---------Add Other User in system MAIL Notification Template--------->







						<div class="accordion-item panel-default"><!-- PANEL DEFAULT DIV START--> 







							<div class="panel-heading padding_0">







								<h4 class="panel-title">







									<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsetwo" aria-expanded="false" aria-controls="collapsetwo">







									<?php esc_html_e('Add Other User in System Template','gym_mgt'); ?>







									</button>







								</h4>







							</div>







							<div id="collapsetwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">







								<div class="accordion-body panel-body">







									<form id="email_template_form" class="form-horizontal" method="post" action="" name="parent_form">







										<div class="row">







											<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">







												<div class="form-group input">







													<div class="col-md-12 form-control input_height_75px">







														<input id="Add_Other_User_in_System_Subject" class="form-control validate[required] line_height_2" type="text" name="Add_Other_User_in_System_Subject" id="Add_Other_User_in_System_Subject" placeholder="<?php esc_html_e('Enter email subject','gym_mgt');?>" value="<?php echo esc_attr(get_option('Add_Other_User_in_System_Subject')); ?>">







														<label for="learner_complete_quiz_notification_title" class=""><?php esc_html_e('Email Subject','gym_mgt');?> <span class="require-field">*</span></label>







													</div>







												</div>







											</div>







											<div class="col-md-6">







												<div class="form-group input">







													<div class="col-md-12 form-control texarea_padding_15">	







														<textarea id="Add_Other_User_in_System_Template" name="Add_Other_User_in_System_Template" class="form-control validate[required] min_height_200 texarea_padding_0"><?php echo get_option('Add_Other_User_in_System_Template');?></textarea>







														<label for="learner_complete_quiz_notification_mailcontent" class="textarea_label"><?php esc_html_e('Add Other User in System Template','gym_mgt');?><span class="require-field">*</span></label>







													</div>







												</div>







											</div>







										</div>







										<div class="form-group input">







											<div class="col-md-12">







												<label><?php esc_html_e('You can use following variables in the email template:','gym_mgt');?></label><br>				







												<label><strong>[GMGT_USERNAME] - </strong><?php esc_html_e('The User name','gym_mgt');?></label><br>







												<label><strong>[GMGT_GYM_NAME] - </strong><?php esc_html_e('Gym Name','gym_mgt');?></label><br>







												<label><strong>[GMGT_ROLE_NAME] - </strong><?php esc_html_e('Role Name','gym_mgt');?></label><br>







												<label><strong>[GMGT_Username] - </strong><?php esc_html_e('Email Id','gym_mgt');?></label><br>







												<label><strong>[GMGT_PASSWORD] - </strong><?php esc_html_e('Password','gym_mgt');?></label><br>







												<label><strong>[GMGT_LOGIN_LINK] - </strong><?php esc_html_e('Login Link','gym_mgt');?></label><br>







											</div>







										</div>







										<?php 







										if($user_access_add == '1' OR  $user_access_edit == '1')







										{ ?>







											<div class="form-body user_form"> <!-- user_form Strat-->   







												<div class="row"><!--Row Div Strat--> 







													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">  







														<input type="submit" value="<?php esc_html_e('Save','gym_mgt')?>" name="save_Other_User_in_system" class="btn btn-success save_btn"/>







													</div>







												</div>







											</div>







											<?php 







										} ?>







									</form>







								</div>







							</div>







						</div>    <!--PANEL DEFAULT DIV END-->		







						<!-----------Add Notice Template -->







						<div class="panel-default accordion-item"><!-- PANEL DEFAULT DIV START--> 







							<div class="panel-heading padding_0">







								<h4 class="panel-title">







									<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">







										<?php esc_html_e('Add Notice Template','gym_mgt'); ?>







									</button>







								</h4>







							</div>







							<div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">







								<div class="accordion-body panel-body">







									<form id="email_template_form" class="form-horizontal" method="post" action="" name="parent_form">







										<div class="row">







											<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">







												<div class="form-group input">







													<div class="col-md-12 form-control input_height_75px">







														<input class="form-control validate[required] line_height_2" type="text" name="Add_Notice_Subject" id="Add_Notice_Subject" placeholder="<?php esc_html_e('Enter email subject','gym_mgt');?>" value="<?php echo esc_attr(get_option('Add_Notice_Subject')); ?>">







														<label for="learner_complete_quiz_notification_title" class=""><?php esc_html_e('Email Subject','gym_mgt');?> <span class="require-field">*</span></label>







													</div>







												</div>







											</div>







											<div class="col-md-6">







												<div class="form-group input">







													<div class="col-md-12 form-control texarea_padding_15">	







														<textarea id="Add_Notice_Template" name="Add_Notice_Template" class="form-control validate[required] min_height_200 texarea_padding_0"><?php echo get_option('Add_Notice_Template');?></textarea>







														<label for="learner_complete_quiz_notification_mailcontent" class="textarea_label"><?php esc_html_e('Add Notice Template','gym_mgt');?><span class="require-field">*</span></label>







													</div>







												</div>







											</div>







										</div>







										<div class="form-group input">







											<div class="col-md-12">







												<label><?php esc_html_e('You can use following variables in the email template:','gym_mgt');?></label><br>







												<label><strong>[GMGT_USERNAME] - </strong><?php esc_html_e('The User name','gym_mgt');?></label><br>







												<label><strong>[GMGT_MEMBERNAME] - </strong><?php esc_html_e('The Member name','gym_mgt');?></label><br>







												<label><strong>[GMGT_NOTICE_TITLE] - </strong><?php esc_html_e('Notice Title','gym_mgt');?></label><br>







												<label><strong>[GMGT_NOTICE_FOR] - </strong><?php esc_html_e('Notice FOR ','gym_mgt');?></label><br>







												<label><strong>[GMGT_STARTDATE] - </strong><?php esc_html_e('Notice Start Date ','gym_mgt');?></label><br>







												<label><strong>[GMGT_ENDDATE] - </strong><?php esc_html_e('Notice End Date ','gym_mgt');?></label><br>







												<label><strong>[GMGT_COMMENT] - </strong><?php esc_html_e('Notice Description ','gym_mgt');?></label><br>







												<label><strong>[GMGT_NOTICE_LINK] - </strong><?php esc_html_e('Notice Link ','gym_mgt');?></label><br>







												<label><strong>[GMGT_GYM_NAME] - </strong><?php esc_html_e('Gym Name','gym_mgt');?></label><br>







											</div>







										</div>







										<?php 







										if($user_access_add == '1' OR  $user_access_edit == '1')







										{ ?>







											<div class="form-body user_form"> <!-- user_form Strat-->   







												<div class="row"><!--Row Div Strat--> 







													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">  







														<input type="submit" value="<?php esc_html_e('Save','gym_mgt')?>" name="Save_Notice_Template" class="btn btn-success save_btn"/>







													</div>







												</div>







											</div>







											<?php 







										} ?>







									</form>







								</div>







							</div>







						</div><!--PANEL DEFAULT DIV END-->		







						<!-----------Member Added In Group ----------->







						<div class=" panel-default accordion-item"><!-- PANEL DEFAULT DIV START--> 







							<div class="panel-heading padding_0">







								<h4 class="panel-title">







									<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">







										<?php esc_html_e('Member Added In Group Template','gym_mgt'); ?>







									</button>







								</h4>







							</div>







							<div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#accordionExample">







								<div class="accordion-body panel-body">







									<form id="email_template_form" class="form-horizontal" method="post" action="" name="parent_form">







										<div class="row">







											<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">







												<div class="form-group input">







													<div class="col-md-12 form-control input_height_75px">







														<input class="form-control validate[required] line_height_2" type="text" name="Member_Added_In_Group_subject" id="Member_Added_In_Group_subject" placeholder="<?php esc_html_e('Enter email subject','gym_mgt');?>" value="<?php echo get_option('Member_Added_In_Group_subject'); ?>">







														<label for="learner_complete_quiz_notification_title" class=""><?php esc_html_e('Email Subject','gym_mgt');?> <span class="require-field">*</span></label>







													</div>







												</div>







											</div>







											<div class="col-md-6">







												<div class="form-group input">







													<div class="col-md-12 form-control texarea_padding_15">	







														<textarea id="Member_Added_In_Group_Template" name="Member_Added_In_Group_Template" class="form-control validate[required] min_height_200 texarea_padding_0"><?php echo get_option('Member_Added_In_Group_Template');?></textarea>







														<label for="learner_complete_quiz_notification_mailcontent" class="textarea_label"><?php esc_html_e('Member Added In Group Template','gym_mgt');?><span class="require-field">*</span></label>







													</div>







												</div>







											</div>







										</div>







										<div class="form-group input">







											<div class="col-md-12">







												<label><?php esc_html_e('You can use following variables in the email template:','gym_mgt');?></label><br>







												<label><strong>[GMGT_USERNAME] - </strong><?php esc_html_e('The User name','gym_mgt');?></label><br>







												<label><strong>[GMGT_GROUPNAME] - </strong><?php esc_html_e('The Group name','gym_mgt');?></label><br>







												<label><strong>[GMGT_GYM_NAME] - </strong><?php esc_html_e('Gym Name','gym_mgt');?></label><br>







											</div>







										</div>







										<?php 







										if($user_access_add == '1' OR  $user_access_edit == '1')







										{ ?>







											<div class="form-body user_form"> <!-- user_form Strat-->   







												<div class="row"><!--Row Div Strat--> 







													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">  







														<input type="submit" value="<?php esc_html_e('Save','gym_mgt')?>" name="Save_Member_Added_In_Group" class="btn btn-success save_btn"/>







													</div>







												</div>







											</div>







											<?php 







										} ?>







									</form>







								</div>







							</div>







						</div> <!--PANEL DEFAULT DIV END-->							  







						<!---Assign Workouts -->







						<div class=" panel-default accordion-item"><!-- PANEL DEFAULT DIV START--> 







							<div class="panel-heading padding_0">







								<h4 class="panel-title">







									<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">







										<?php esc_html_e('Assign Workouts Template','gym_mgt'); ?>







									</button>







								</h4>







							</div>







							<div id="collapseFive" class="accordion-collapse collapse" data-bs-parent="#accordionExample">







								<div class="accordion-body panel-body">







									<form id="email_template_form" class="form-horizontal" method="post" action="" name="parent_form">







										<div class="row">







											<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">







												<div class="form-group input">







													<div class="col-md-12 form-control input_height_75px">







														<input class="form-control validate[required] line_height_2" type="text" name="Assign_Workouts_Subject" id="Assign_Workouts_Subject" placeholder="<?php esc_html_e('Enter email subject','gym_mgt');?>" value="<?php echo esc_attr(get_option('Assign_Workouts_Subject')); ?>">







														<label for="learner_complete_quiz_notification_title" class=""><?php esc_html_e('Email Subject','gym_mgt');?> <span class="require-field">*</span></label>







													</div>







												</div>







											</div>







											<div class="col-md-6">







												<div class="form-group input">







													<div class="col-md-12 form-control texarea_padding_15">	







														<textarea id="Assign_Workouts_Template" name="Assign_Workouts_Template" class="form-control validate[required] min_height_200 texarea_padding_0"><?php echo get_option('Assign_Workouts_Template');?></textarea>







														<label for="learner_complete_quiz_notification_mailcontent" class="textarea_label"><?php esc_html_e('Assign Workouts Template','gym_mgt');?><span class="require-field">*</span></label>







													</div>







												</div>







											</div>







										</div>







										<div class="form-group input">







											<div class="col-md-12">







												<label><?php esc_html_e('You can use following variables in the email template:','gym_mgt');?></label><br>







												<label><strong>[GMGT_MEMBERNAME] - </strong><?php esc_html_e('The Member Name','gym_mgt');?></label><br>







												<label><strong>[GMGT_STARTDATE] - </strong><?php esc_html_e('Workouts Start Date ','gym_mgt');?></label><br>







												<label><strong>[GMGT_ENDDATE] - </strong><?php esc_html_e('Workouts End Date ','gym_mgt');?></label><br>







												<label><strong>[GMGT_GYM_NAME] - </strong><?php esc_html_e('Gym Name','gym_mgt');?></label><br>







												<label><strong>[GMGT_PAGE_LINK] - </strong><?php esc_html_e('Page Link','gym_mgt');?></label><br>







											</div>







										</div>







										<?php 







										if($user_access_add == '1' OR  $user_access_edit == '1')







										{ ?>







											<div class="form-body user_form"> <!-- user_form Strat-->   







												<div class="row"><!--Row Div Strat--> 







													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">  







														<input type="submit" value="<?php esc_html_e('Save','gym_mgt')?>" name="Save_Assign_Workouts" class="btn btn-success save_btn"/>







													</div>







												</div>







											</div>







											<?php 







										} ?>







									</form>







								</div>







							</div>







						</div>   <!--PANEL DEFAULT DIV END-->







						<!-------Sell Product------>







						<div class=" panel-default accordion-item"><!-- PANEL DEFAULT DIV START--> 







							<div class="panel-heading padding_0">







								<h4 class="panel-title">







									<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">







										<?php esc_html_e('Sell Product','gym_mgt'); ?>







									</button>







								</h4>







							</div>







							<div id="collapseSix" class="accordion-collapse collapse" data-bs-parent="#accordionExample">







								<div class="accordion-body panel-body">







									<form id="email_template_form" class="form-horizontal" method="post" action="" name="parent_form">







										<div class="row">







											<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">







												<div class="form-group input">







													<div class="col-md-12 form-control input_height_75px">







														<input class="form-control validate[required] line_height_2" type="text" name="sell_product_subject" id="sell_product_subject" placeholder="<?php esc_html_e('Enter email subject','gym_mgt');?>" value="<?php echo esc_attr(get_option('sell_product_subject')); ?>">







														<label for="learner_complete_quiz_notification_title" class=""><?php esc_html_e('Email Subject','gym_mgt');?> <span class="require-field">*</span></label>







													</div>







												</div>







											</div>







											<div class="col-md-6">







												<div class="form-group input">







													<div class="col-md-12 form-control texarea_padding_15">	







														<textarea id="sell_product_template" name="sell_product_template" class="form-control validate[required] min_height_200 texarea_padding_0"><?php echo get_option('sell_product_template');?></textarea>







														<label for="learner_complete_quiz_notification_mailcontent" class="textarea_label"><?php esc_html_e('Sell Product Template','gym_mgt');?><span class="require-field">*</span></label>







													</div>







												</div>







											</div>







										</div>







										<div class="form-group input">







											<div class="col-md-12">







												<label><?php esc_html_e('You can use following variables in the email template:','gym_mgt');?></label><br>







												<label><strong>[GMGT_USERNAME] - </strong><?php esc_html_e('The User name','gym_mgt');?></label><br>







												<label><strong>[GMGT_PRODUCTNAME] - </strong><?php esc_html_e('The Product name','gym_mgt');?></label><br>







												<label><strong>[GMGT_GYM_NAME] - </strong><?php esc_html_e('Gym Name','gym_mgt');?></label><br>







											</div>







										</div>







										<?php 







										if($user_access_add == '1' OR  $user_access_edit == '1')







										{ ?>







											<div class="form-body user_form"> <!-- user_form Strat-->   







												<div class="row"><!--Row Div Strat--> 







													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">  







														<input type="submit" value="<?php esc_html_e('Save','gym_mgt')?>" name="save_sell_product" class="btn btn-success save_btn"/>







													</div>







												</div>







											</div>







											<?php 







										} ?>







									</form>







								</div>







							</div>







						</div>  <!--PANEL DEFAULT DIV END-->		







						<!------Generate Invoice----->







						<div class="panel-default accordion-item"><!-- PANEL DEFAULT DIV START--> 







							<div class="panel-heading padding_0">







								<h4 class="panel-title">







									<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">







										<?php esc_html_e('Generate Invoice','gym_mgt'); ?>







									</button>







								</h4>







							</div>







							<div id="collapseSeven" class="accordion-collapse collapse" data-bs-parent="#accordionExample">







								<div class="accordion-body panel-body">







									<form id="email_template_form" class="form-horizontal" method="post" action="" name="parent_form">







										<div class="row">







											<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">







												<div class="form-group input">







													<div class="col-md-12 form-control input_height_75px">







														<input class="form-control validate[required] line_height_2" type="text" name="generate_invoice_subject" id="generate_invoice_subject" placeholder="<?php esc_html_e('Enter email subject','gym_mgt');?>" value="<?php echo esc_attr(get_option('generate_invoice_subject')); ?>">







														<label for="learner_complete_quiz_notification_title" class=""><?php esc_html_e('Email Subject','gym_mgt');?> <span class="require-field">*</span></label>







													</div>







												</div>







											</div>







											<div class="col-md-6">







												<div class="form-group input">







													<div class="col-md-12 form-control texarea_padding_15">	







														<textarea id="generate_invoice_template" name="generate_invoice_template" class="form-control validate[required] min_height_200 texarea_padding_0"><?php echo get_option('generate_invoice_template');?></textarea>







														<label for="learner_complete_quiz_notification_mailcontent" class="textarea_label"><?php esc_html_e('Generate Invoice Template','gym_mgt');?><span class="require-field">*</span></label>







													</div>







												</div>







											</div>







										</div>







										<div class="form-group input">







											<div class="col-md-12">







												<label><?php esc_html_e('You can use following variables in the email template:','gym_mgt');?></label><br>	







												<label><strong>[GMGT_USERNAME] - </strong><?php esc_html_e('The User name','gym_mgt');?></label><br>







												<label><strong>[GMGT_GYM_NAME] - </strong><?php esc_html_e('Gym Name','gym_mgt');?></label><br>







												<label><strong>[GMGT_PAYMENT_LINK] - </strong><?php esc_html_e('Payment Link','gym_mgt');?></label><br>







											</div>







										</div>







										<?php 







										if($user_access_add == '1' OR  $user_access_edit == '1')







										{ ?>







											<div class="form-body user_form"> <!-- user_form Strat-->   







												<div class="row"><!--Row Div Strat--> 







													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">  







														<input type="submit" value="<?php esc_html_e('Save','gym_mgt')?>" name="save_generate_invoice" class="btn btn-success save_btn"/>







													</div>







												</div>







											</div>







											<?php 







										} ?>







									</form>







								</div>







							</div>







						</div>  <!--PANEL DEFAULT DIV END-->		







						<!------Add Income----->







						<div class="panel-default accordion-item"><!-- PANEL DEFAULT DIV START--> 







							<div class="panel-heading padding_0">







								<h4 class="panel-title">







									<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseeight" aria-expanded="false" aria-controls="collapseeight">







										<?php esc_html_e('Add Income ','gym_mgt'); ?>







									</button>







								</h4>







							</div>







							<div id="collapseeight" class="accordion-collapse collapse" data-bs-parent="#accordionExample">







								<div class="accordion-body panel-body">







									<form id="email_template_form" class="form-horizontal" method="post" action="" name="parent_form">







										<div class="row">







											<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">







												<div class="form-group input">







													<div class="col-md-12 form-control input_height_75px">







														<input class="form-control validate[required] line_height_2" type="text" name="add_income_subject" id="add_income_subject" placeholder="<?php esc_html_e('Enter email subject','gym_mgt');?>" value="<?php echo esc_attr(get_option('add_income_subject')); ?>">







														<label for="learner_complete_quiz_notification_title" class=""><?php esc_html_e('Email Subject','gym_mgt');?> <span class="require-field">*</span></label>







													</div>







												</div>







											</div>







											<div class="col-md-6">







												<div class="form-group input">







													<div class="col-md-12 form-control texarea_padding_15">	







														<textarea id="add_income_template" name="add_income_template" class="form-control validate[required] min_height_200 texarea_padding_0"><?php echo get_option('add_income_template');?></textarea>







														<label for="learner_complete_quiz_notification_mailcontent" class="textarea_label"><?php esc_html_e('Add Income Template','gym_mgt');?><span class="require-field">*</span></label>







													</div>







												</div>







											</div>







										</div>







										<div class="form-group input">







											<div class="col-md-12">







												<label><?php esc_html_e('You can use following variables in the email template:','gym_mgt');?></label><br>







												<label><strong>[GMGT_USERNAME] - </strong><?php esc_html_e('The User name','gym_mgt');?></label><br>







												<label><strong>[GMGT_GYM_NAME] - </strong><?php esc_html_e('Gym Name','gym_mgt');?></label><br>







												<label><strong>[GMGT_ROLE_NAME] - </strong><?php esc_html_e('Role Name','gym_mgt');?></label><br>







											</div>







										</div>







										<?php 







										if($user_access_add == '1' OR  $user_access_edit == '1')







										{ ?>







											<div class="form-body user_form"> <!-- user_form Strat-->   







												<div class="row"><!--Row Div Strat--> 







													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">  







														<input type="submit" value="<?php esc_html_e('Save','gym_mgt')?>" name="save_add_income_template" class="btn btn-success save_btn"/>







													</div>







												</div>







											</div>







											<?php 







										} ?>







									</form>







								</div>







							</div>







						</div>  <!--PANEL DEFAULT DIV END-->







						<!-----Assign Workouts -------->







						<div class="panel-default accordion-item"><!-- PANEL DEFAULT DIV START--> 







							<div class="panel-heading padding_0">







								<h4 class="panel-title">







									<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsenine" aria-expanded="false" aria-controls="collapsenine">







										<?php esc_html_e('Add Reservation Template','gym_mgt'); ?>







									</button>







								</h4>







							</div>







							<div id="collapsenine" class="accordion-collapse collapse" data-bs-parent="#accordionExample">







								<div class="accordion-body panel-body">







									<form id="email_template_form" class="form-horizontal" method="post" action="" name="parent_form">







										<div class="row">







											<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">







												<div class="form-group input">







													<div class="col-md-12 form-control input_height_75px">







														<input class="form-control validate[required] line_height_2" type="text" name="Add_Reservation_Subject" id="Add_Reservation_Subject" placeholder="<?php esc_html_e('Enter email subject','gym_mgt');?>" value="<?php echo esc_attr(get_option('Add_Reservation_Subject')); ?>">







														<label for="learner_complete_quiz_notification_title" class=""><?php esc_html_e('Email Subject','gym_mgt');?> <span class="require-field">*</span></label>







													</div>







												</div>







											</div>







											<div class="col-md-6">







												<div class="form-group input">







													<div class="col-md-12 form-control texarea_padding_15">	







														<textarea id="Add_Reservation_Template" name="Add_Reservation_Template" class="form-control validate[required] min_height_200 texarea_padding_0"><?php echo get_option('Add_Reservation_Template');?></textarea>







														<label for="learner_complete_quiz_notification_mailcontent" class="textarea_label"><?php esc_html_e('Add Reservation Template','gym_mgt');?><span class="require-field">*</span></label>







													</div>







												</div>







											</div>







										</div>







										<div class="form-group input">







											<div class="col-md-12">







												<label><?php esc_html_e('You can use following variables in the email template:','gym_mgt');?></label><br>				







												<label><strong>[GMGT_STAFF_MEMBERNAME] - </strong><?php esc_html_e('Staff member name','gym_mgt');?></label><br>







												<label><strong>[GMGT_EVENT_NAME] - </strong><?php esc_html_e('Event Name','gym_mgt');?></label><br>







												<label><strong>[GMGT_EVENT_DATE] - </strong><?php esc_html_e('Event Date','gym_mgt');?></label><br>







												<label><strong>[GMGT_EVENT_PLACE] - </strong><?php esc_html_e('Event Place','gym_mgt');?></label><br>







												<label><strong>[GMGT_START_TIME] - </strong><?php esc_html_e('Event Start Time','gym_mgt');?></label><br>







												<label><strong>[GMGT_END_TIME] - </strong><?php esc_html_e('Event End  Time','gym_mgt');?></label><br>







												<label><strong>[GMGT_GYM_NAME] - </strong><?php esc_html_e('Gym Name','gym_mgt');?></label><br>







												<label><strong>[GMGT_PAGE_LINK] - </strong><?php esc_html_e('Page Link','gym_mgt');?></label><br>







											</div>







										</div>







										<?php 







										if($user_access_add == '1' OR  $user_access_edit == '1')







										{ ?>







											<div class="form-body user_form"> <!-- user_form Strat-->   







												<div class="row"><!--Row Div Strat--> 







													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">  







														<input type="submit" value="<?php esc_html_e('Save','gym_mgt')?>" name="Save_Reservation_Template" class="btn btn-success save_btn"/>







													</div>







												</div>







											</div>







											<?php 







										} ?>







									</form>







								</div>







							</div>







						</div>   <!--PANEL DEFAULT DIV END-->	







						<!-----------Assign_Nutrition_Schedule_Subject -->







						<div class="panel-default accordion-item"><!-- PANEL DEFAULT DIV START--> 







							<div class="panel-heading padding_0">







								<h4 class="panel-title">







									<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTen" aria-expanded="false" aria-controls="collapseTen">







										<?php esc_html_e('Assign Nutrition Schedule Template','gym_mgt'); ?>







									</button>







								</h4>







							</div>







							<div id="collapseTen" class="accordion-collapse collapse" data-bs-parent="#accordionExample">







								<div class="accordion-body panel-body">







									<form id="email_template_form" class="form-horizontal" method="post" action="" name="parent_form">







										<div class="row">







											<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">







												<div class="form-group input">







													<div class="col-md-12 form-control input_height_75px">







														<input class="form-control validate[required] line_height_2" type="text" name="Assign_Nutrition_Schedule_Subject" id="Assign_Nutrition_Schedule_Subject" placeholder="<?php esc_html_e('Enter email subject','gym_mgt');?>" value="<?php echo esc_attr(get_option('Assign_Nutrition_Schedule_Subject')); ?>">







														<label for="learner_complete_quiz_notification_title" class=""><?php esc_html_e('Email Subject','gym_mgt');?> <span class="require-field">*</span></label>







													</div>







												</div>







											</div>







											<div class="col-md-6">







												<div class="form-group input">







													<div class="col-md-12 form-control texarea_padding_15">	







														<textarea id="Assign_Nutrition_Schedule_Template" name="Assign_Nutrition_Schedule_Template" class="form-control validate[required] min_height_200 texarea_padding_0"><?php echo get_option('Assign_Nutrition_Schedule_Template');?></textarea>







														<label for="learner_complete_quiz_notification_mailcontent" class="textarea_label"><?php esc_html_e('Assign Nutrition Schedule Template','gym_mgt');?><span class="require-field">*</span></label>







													</div>







												</div>







											</div>







										</div>







										<div class="form-group input">







											<div class="col-md-12">







												<label><?php esc_html_e('You can use following variables in the email template:','gym_mgt');?></label><br>







												<label><strong>[GMGT_MEMBERNAME] - </strong><?php esc_html_e('The Member Name','gym_mgt');?></label><br>







												<label><strong>[GMGT_STARTDATE] - </strong><?php esc_html_e('Nutrition Start Date ','gym_mgt');?></label><br>







												<label><strong>[GMGT_ENDDATE] - </strong><?php esc_html_e('Nutrition End Date ','gym_mgt');?></label><br>







												<label><strong>[GMGT_GYM_NAME] - </strong><?php esc_html_e('Gym Name','gym_mgt');?></label><br>







												<label><strong>[GMGT_PAGE_LINK] - </strong><?php esc_html_e('Page Link','gym_mgt');?></label><br>







											</div>







										</div>







										<?php 







										if($user_access_add == '1' OR  $user_access_edit == '1')







										{ ?>







											<div class="form-body user_form"> <!-- user_form Strat-->   







												<div class="row"><!--Row Div Strat--> 







													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">  







														<input type="submit" value="<?php esc_html_e('Save','gym_mgt')?>" name="Save_Assign_Nutrition_Schedule" class="btn btn-success save_btn"/>







													</div>







												</div>







											</div>







											<?php 







										} ?>







									</form>







								</div>







							</div>







						</div>   <!--PANEL DEFAULT DIV END-->







						<!-----------Submit Workouts Mail Notification -->







						<div class="panel-default accordion-item"><!-- PANEL DEFAULT DIV START--> 







							<div class="panel-heading padding_0">







								<h4 class="panel-title">







									<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseElevan" aria-expanded="false" aria-controls="collapseElevan">







										<?php esc_html_e('Submit Workouts Template','gym_mgt'); ?>







									</button>







								</h4>







							</div>







							<div id="collapseElevan" class="accordion-collapse collapse" data-bs-parent="#accordionExample">







								<div class="accordion-body panel-body">







									<form id="email_template_form" class="form-horizontal" method="post" action="" name="parent_form">







										<div class="row">







											<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">







												<div class="form-group input">







													<div class="col-md-12 form-control input_height_75px">







														<input class="form-control validate[required] line_height_2" type="text" name="Submit_Workouts_Subject" id="Submit_Workouts_Subject" placeholder="<?php esc_html_e('Enter email subject','gym_mgt');?>" value="<?php echo esc_attr(get_option('Submit_Workouts_Subject')); ?>">







														<label for="learner_complete_quiz_notification_title" class=""><?php esc_html_e('Email Subject','gym_mgt');?> <span class="require-field">*</span></label>







													</div>







												</div>







											</div>







											<div class="col-md-6">







												<div class="form-group input">







													<div class="col-md-12 form-control texarea_padding_15">	







														<textarea id="Submit_Workouts_Template" name="Submit_Workouts_Template" class="form-control validate[required] min_height_200 texarea_padding_0"><?php echo get_option('Submit_Workouts_Template');?></textarea>







														<label for="learner_complete_quiz_notification_mailcontent" class="textarea_label"><?php esc_html_e('Submit Workouts Template','gym_mgt');?><span class="require-field">*</span></label>







													</div>







												</div>







											</div>







										</div>







										<div class="form-group input">







											<div class="col-md-12">







												<label><?php esc_html_e('You can use following variables in the email template:','gym_mgt');?></label><br>







												<label><strong>[GMGT_STAFF_MEMBERNAME]  - </strong><?php esc_html_e(' Staff Member Name','gym_mgt');?></label><br>







												<label><strong>[GMGT_DAY_NAME] - </strong><?php esc_html_e('Workout Day Name ','gym_mgt');?></label><br>







												<label><strong>[GMGT_DATE] - </strong><?php esc_html_e('Workout Day','gym_mgt');?></label><br>







												<label><strong>[GMGT_GYM_NAME] - </strong><?php esc_html_e('Gym Name','gym_mgt');?></label><br>







											</div>







										</div>







										<?php 







										if($user_access_add == '1' OR  $user_access_edit == '1')







										{ ?>







											<div class="form-body user_form"> <!-- user_form Strat-->   







												<div class="row"><!--Row Div Strat--> 







													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">  







														<input type="submit" value="<?php esc_html_e('Save','gym_mgt')?>" name="Submit_Workouts_Save" class="btn btn-success save_btn"/>







													</div>







												</div>







											</div>







											<?php 







										} ?>







										







								</form>







								</div>







							</div>







						</div>   <!--PANEL DEFAULT DIV END-->		



						<div class="panel-default accordion-item"><!-- PANEL DEFAULT DIV START--> 


							<div class="panel-heading padding_0">


								<h4 class="panel-title">


									<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseninetin" aria-expanded="false" aria-controls="collapseninetin">

										<?php esc_html_e('Submit Workouts Template For Member','gym_mgt'); ?>

									</button>

								</h4>

							</div>

							<div id="collapseninetin" class="accordion-collapse collapse" data-bs-parent="#accordionExample">

								<div class="accordion-body panel-body">

									<form id="email_template_form" class="form-horizontal" method="post" action="" name="parent_form">

										<div class="row">

											<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">

												<div class="form-group input">

													<div class="col-md-12 form-control input_height_75px">

														<input class="form-control validate[required] line_height_2" type="text" name="Submit_Workouts_Subject_for_member" id="Submit_Workouts_Subject" placeholder="<?php esc_html_e('Enter email subject','gym_mgt');?>" value="<?php echo esc_attr(get_option('Submit_Workouts_Subject_for_member')); ?>">

														<label for="learner_complete_quiz_notification_title" class=""><?php esc_html_e('Email Subject','gym_mgt');?> <span class="require-field">*</span></label>

													</div>

												</div>

											</div>

											<div class="col-md-6">

												<div class="form-group input">

													<div class="col-md-12 form-control texarea_padding_15">	

														<textarea id="Submit_Workouts_Template" name="Submit_Workouts_Template_for_member" class="form-control validate[required] min_height_200 texarea_padding_0"><?php echo get_option('Submit_Workouts_Template_for_member');?></textarea>

														<label for="learner_complete_quiz_notification_mailcontent" class="textarea_label active"><?php esc_html_e('Submit Workouts Template For Member','gym_mgt');?><span class="require-field">*</span></label>

													</div>

												</div>

											</div>

										</div>

										<div class="form-group input">

											<div class="col-md-12">

												<label><?php esc_html_e('You can use following variables in the email template:','gym_mgt');?></label><br>

												<label><strong>[GMGT_DAY_NAME] - </strong><?php esc_html_e('Workout Day Name ','gym_mgt');?></label><br>

												<label><strong>[GMGT_DATE] - </strong><?php esc_html_e('Workout Day','gym_mgt');?></label><br>

												<label><strong>[GMGT_GYM_NAME] - </strong><?php esc_html_e('Gym Name','gym_mgt');?></label><br>

											</div>

										</div>

										<?php 

										if($user_access_add == '1' OR  $user_access_edit == '1')

										{ ?>


											<div class="form-body user_form"> <!-- user_form Strat-->   

												<div class="row"><!--Row Div Strat--> 

													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">  

														<input type="submit" value="<?php esc_html_e('Save','gym_mgt')?>" name="Member_Submit_Workouts_Save" class="btn btn-success save_btn"/>

													</div>

												</div>

											</div>

											<?php 

										} ?>

								</form>

								</div>

							</div>

						</div>   <!--PANEL DEFAULT DIV END-->



						<!------Payment Received against Invoice----->

						<div class="panel-default accordion-item"><!-- PANEL DEFAULT DIV START--> 







							<div class="panel-heading padding_0">







								<h4 class="panel-title">







									<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwelve" aria-expanded="false" aria-controls="collapseTwelve">







										<?php esc_html_e('Payment Received against Invoice','gym_mgt'); ?>







									</button>







								</h4>







							</div>







							<div id="collapseTwelve" class="accordion-collapse collapse" data-bs-parent="#accordionExample">







								<div class="accordion-body panel-body">







									<form id="email_template_form" class="form-horizontal" method="post" action="" name="parent_form">







										<div class="row">







											<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">







												<div class="form-group input">







													<div class="col-md-12 form-control input_height_75px">







														<input class="form-control validate[required] line_height_2" type="text" name="payment_received_against_invoice_subject" id="payment_received_against_invoice_subject" placeholder="<?php esc_html_e('Enter email subject','gym_mgt');?>" value="<?php echo esc_attr(get_option('payment_received_against_invoice_subject')); ?>">







														<label for="learner_complete_quiz_notification_title" class=""><?php esc_html_e('Email Subject','gym_mgt');?> <span class="require-field">*</span></label>







													</div>







												</div>







											</div>







											<div class="col-md-6">







												<div class="form-group input">







													<div class="col-md-12 form-control texarea_padding_15">	







														<textarea id="payment_received_against_invoice_template" name="payment_received_against_invoice_template" class="form-control validate[required] min_height_200 texarea_padding_0"><?php echo get_option('payment_received_against_invoice_template');?></textarea>







														<label for="learner_complete_quiz_notification_mailcontent" class="textarea_label"><?php esc_html_e('Add Income Template','gym_mgt');?><span class="require-field">*</span></label>







													</div>







												</div>







											</div>







										</div>







										<div class="form-group input">







											<div class="col-md-12">







												<label><?php esc_html_e('You can use following variables in the email template:','gym_mgt');?></label><br>	







												<label><strong>[GMGT_USERNAME] - </strong><?php esc_html_e('The User name','gym_mgt');?></label><br>







												<label><strong>[GMGT_GYM_NAME] - </strong><?php esc_html_e('Gym Name','gym_mgt');?></label><br>







											</div>







										</div>







										<?php 







										if($user_access_add == '1' OR  $user_access_edit == '1')







										{ ?>







											<div class="form-body user_form"> <!-- user_form Strat-->   







												<div class="row"><!--Row Div Strat--> 







													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">  







														<input type="submit" value="<?php esc_html_e('Save','gym_mgt')?>" name="savePaymentReceivedAgainstInvoiceTemplate" class="btn btn-success save_btn"/>







													</div>







												</div>







											</div>







											<?php 







										} ?>







									</form>







								</div>







							</div>







						</div><!--PANEL DEFAULT DIV END-->		







						<!------Message Received----->







						<div class="panel-default accordion-item"><!-- PANEL DEFAULT DIV START--> 







							<div class="panel-heading padding_0">







								<h4 class="panel-title">







									<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsethartin" aria-expanded="false" aria-controls="collapsethartin">







										<?php esc_html_e('Message Received','gym_mgt'); ?>







									</button>







								</h4>







							</div>







							<div id="collapsethartin" class="accordion-collapse collapse" data-bs-parent="#accordionExample">







								<div class="accordion-body panel-body">







									<form id="email_template_form" class="form-horizontal" method="post" action="" name="parent_form">







										<div class="row">







											<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">







												<div class="form-group input">







													<div class="col-md-12 form-control input_height_75px">







														<input class="form-control validate[required] line_height_2" type="text" name="message_received_subject" id="message_received_subject" placeholder="<?php esc_html_e('Enter email subject','gym_mgt');?>" value="<?php echo esc_attr(get_option('message_received_subject')); ?>">







														<label for="learner_complete_quiz_notification_title" class=""><?php esc_html_e('Email Subject','gym_mgt');?> <span class="require-field">*</span></label>







													</div>







												</div>







											</div>







											<div class="col-md-6">







												<div class="form-group input">







													<div class="col-md-12 form-control texarea_padding_15">	







														<textarea id="message_received_template" name="message_received_template" class="form-control validate[required] min_height_200 texarea_padding_0"><?php echo get_option('message_received_template');?></textarea>







														<label for="learner_complete_quiz_notification_mailcontent" class="textarea_label"><?php esc_html_e('Message Received Template','gym_mgt');?><span class="require-field">*</span></label>







													</div>







												</div>







											</div>







										</div>







										<div class="form-group input">







											<div class="col-md-12">







												<label><?php esc_html_e('You can use following variables in the email template:','gym_mgt');?></label><br>







												<label><strong>[GMGT_RECEIVER_NAME] - </strong><?php esc_html_e('The Receiver name','gym_mgt');?></label><br>







												<label><strong>[GMGT_GYM_NAME] - </strong><?php esc_html_e('Gym Name','gym_mgt');?></label><br>







												<label><strong>[GMGT_SENDER_NAME] - </strong><?php esc_html_e('Sender Name','gym_mgt');?></label><br>







												<label><strong>[GMGT_MESSAGE_CONTENT] - </strong><?php esc_html_e('Message Content','gym_mgt');?></label><br>







											</div>







										</div>







										<?php 







										if($user_access_add == '1' OR  $user_access_edit == '1')







										{ ?>







											<div class="form-body user_form"> <!-- user_form Strat-->   







												<div class="row"><!--Row Div Strat--> 







													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">  







														<input type="submit" value="<?php esc_html_e('Save','gym_mgt')?>" name="saveMessageReceiveTemplate" class="btn btn-success save_btn"/>







													</div>







												</div>







											</div>







											<?php 







										} ?>







									</form>







								</div>







							</div>







						</div>







						<div class="panel-default accordion-item"><!-- PANEL DEFAULT DIV START--> 







							<div class="panel-heading padding_0">







								<h4 class="panel-title">







									<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsefourtin" aria-expanded="false" aria-controls="collapsefourtin">







										<?php esc_html_e('Payment Reminder Template','gym_mgt'); ?>







									</button>







								</h4>







							</div>	







							<div id="collapsefourtin" class="accordion-collapse collapse" data-bs-parent="#accordionExample">







								<div class="accordion-body panel-body">







									<form id="email_template_form" class="form-horizontal" method="post" action="" name="parent_form">







										<div class="row">







											<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">







												<div class="form-group input">







													<div class="col-md-12 form-control input_height_75px">







														<input class="form-control validate[required] line_height_2" type="text" name="payment_reminder_subject" id="payment_reminder_subject" placeholder="<?php esc_html_e('Enter email subject','gym_mgt');?>" value="<?php echo esc_attr(get_option('payment_reminder_subject')); ?>">







														<label for="learner_complete_quiz_notification_title" class=""><?php esc_html_e('Email Subject','gym_mgt');?> <span class="require-field">*</span></label>







													</div>







												</div>







											</div>







											<div class="col-md-6">







												<div class="form-group input">







													<div class="col-md-12 form-control texarea_padding_15">	







														<textarea id="payment_reminder_template" name="payment_reminder_template" class="form-control validate[required] min_height_200 texarea_padding_0"><?php echo get_option('payment_reminder_template');?></textarea>







														<label for="learner_complete_quiz_notification_mailcontent" class="textarea_label"><?php esc_html_e('Payment Reminder Template','gym_mgt');?><span class="require-field">*</span></label>







													</div>







												</div>







											</div>







										</div>







										<div class="form-group input">







											<div class="col-md-12">







												<label><?php esc_html_e('You can use following variables in the email template:','gym_mgt');?></label><br>







												<label><strong>[GMGT_RECEIVER_NAME] - </strong><?php esc_html_e('The Receiver name','gym_mgt');?></label><br>







												<label><strong>[GMGT_GYM_NAME] - </strong><?php esc_html_e('Gym Name','gym_mgt');?></label><br>







												<label><strong>[GMGT_TOTOAL_AMOUNT] - </strong><?php esc_html_e('Total Amount','gym_mgt');?></label><br>







												<label><strong>[GMGT_DUE_AMOUNT] - </strong><?php esc_html_e('Due Amount','gym_mgt');?></label><br>







												<label><strong>[GMGT_INVOICE_NUMBER] - </strong><?php esc_html_e('Invoice Number','gym_mgt');?></label><br>







												<label><strong>[GMGT_MEMBERSHIP_NAME] - </strong><?php esc_html_e('Membership Name','gym_mgt');?></label><br>







											</div>







										</div>







										<?php 







										if($user_access_add == '1' OR  $user_access_edit == '1')







										{ ?>







											<div class="form-body user_form"> <!-- user_form Strat-->   







												<div class="row"><!--Row Div Strat--> 







													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">  







														<input type="submit" value="<?php esc_html_e('Save','gym_mgt')?>" name="save_payment_reminder_subject" class="btn btn-success save_btn"/>







													</div>







												</div>







											</div>







											<?php 







										} ?>







									</form>







								</div>







							</div>







						</div>







						<!-- Payment Reminder for Invoice  -->







						<div class="panel-default accordion-item"><!-- PANEL DEFAULT DIV START--> 







							<div class="panel-heading padding_0">







								<h4 class="panel-title">







									<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsesixthin" aria-expanded="false" aria-controls="collapsesixthin">







										<?php esc_html_e('Invoice Payment Reminder Template','gym_mgt'); ?>







									</button>







								</h4>







							</div>	







							<div id="collapsesixthin" class="accordion-collapse collapse" data-bs-parent="#accordionExample">







								<div class="accordion-body panel-body">







									<form id="email_template_form" class="form-horizontal" method="post" action="" name="parent_form">







										<div class="row">







											<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">







												<div class="form-group input">







													<div class="col-md-12 form-control input_height_75px">







														<input class="form-control validate[required] line_height_2" type="text" name="invoice_payment_reminder_subject" id="invoice_payment_reminder_subject" placeholder="<?php esc_html_e('Enter email subject','gym_mgt');?>" value="<?php echo esc_attr(get_option('invoice_payment_reminder_subject')); ?>">







														<label for="learner_complete_quiz_notification_title" class=""><?php esc_html_e('Email Subject','gym_mgt');?> <span class="require-field">*</span></label>







													</div>







												</div>







											</div>







											<div class="col-md-6">







												<div class="form-group input">







													<div class="col-md-12 form-control texarea_padding_15">	







														<textarea id="invoice_payment_reminder_template" name="invoice_payment_reminder_template" class="form-control validate[required] min_height_200 texarea_padding_0"><?php echo get_option('invoice_payment_reminder_template');?></textarea>







														<label for="learner_complete_quiz_notification_mailcontent" class="textarea_label"><?php esc_html_e('Sale Payment Reminder Template','gym_mgt');?><span class="require-field">*</span></label>







													</div>







												</div>







											</div>







										</div>







										<div class="form-group input">







											<div class="col-md-12">







												<label><?php esc_html_e('You can use following variables in the email template:','gym_mgt');?></label><br>







												<label><strong>[GMGT_RECEIVER_NAME] - </strong><?php esc_html_e('The Receiver name','gym_mgt');?></label><br>







												<label><strong>[GMGT_GYM_NAME] - </strong><?php esc_html_e('Gym Name','gym_mgt');?></label><br>







												<label><strong>[GMGT_TOTOAL_AMOUNT] - </strong><?php esc_html_e('Total Amount','gym_mgt');?></label><br>







												<label><strong>[GMGT_DUE_AMOUNT] - </strong><?php esc_html_e('Due Amount','gym_mgt');?></label><br>







												<label><strong>[GMGT_INVOICE_NUMBER] - </strong><?php esc_html_e('Invoice Number','gym_mgt');?></label><br>







												<label><strong>[GMGT_MEMBERSHIP_NAME] - </strong><?php esc_html_e('Membership Name','gym_mgt');?></label><br>







											</div>







										</div>







										<?php 







										if($user_access_add == '1' OR  $user_access_edit == '1')







										{ ?>







											<div class="form-body user_form"> <!-- user_form Strat-->   







												<div class="row"><!--Row Div Strat--> 







													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">  







														<input type="submit" value="<?php esc_html_e('Save','gym_mgt')?>" name="save_invoice_payment_reminder_subject" class="btn btn-success save_btn"/>







													</div>







												</div>







											</div>







											<?php 







										} ?>







									</form>







								</div>







							</div>







						</div>







						<div class="panel-default accordion-item"><!-- PANEL DEFAULT DIV START--> 







							<div class="panel-heading padding_0">







								<h4 class="panel-title">







									<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseseventin" aria-expanded="false" aria-controls="collapseseventin">







										<?php esc_html_e('Membership Expire Reminder Template','gym_mgt'); ?>







									</button>







								</h4>







							</div>	







							<div id="collapseseventin" class="accordion-collapse collapse" data-bs-parent="#accordionExample">







								<div class="accordion-body panel-body">







									<form id="email_template_form" class="form-horizontal" method="post" action="" name="parent_form">







										<div class="row">







											<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">







												<div class="form-group input">







													<div class="col-md-12 form-control input_height_75px">







														<input class="form-control validate[required] text-input onlyletter_number_space_validation" maxlength="100" value="<?php echo get_option( 'gmgt_reminder_subject' );?>" type="text" name="gmgt_reminder_subject">







														<label class="textarea_label" for="gmgt_paypal_email"><?php esc_html_e('Email Subject','gym_mgt');?><span class="require-field">*</span></label>







													</div>







												</div>







											</div>







											<div class="col-md-6">







												<div class="form-group input">







													<div class="col-md-12 form-control texarea_padding_15">	







														<textarea name="gym_reminder_message" class="form-control validate[required] min_height_200 texarea_padding_0"><?php echo get_option('gym_reminder_message');?></textarea>







														<label for="learner_complete_quiz_notification_mailcontent" class="textarea_label"><?php esc_html_e('Membership Expire Reminder Template','gym_mgt');?><span class="require-field">*</span></label>







													</div>







												</div>







											</div>







										</div>







										<div class="form-group input">







											<div class="col-md-12">







												<label><?php esc_html_e('You can use following variables in the email template:','gym_mgt');?></label><br>







												<label><strong>[GMGT_MEMBERNAME] - </strong><?php esc_html_e('Member Name','gym_mgt');?></label><br>







												<label><strong>[GMGT_STARTDATE] - </strong><?php esc_html_e('Membership Start Date','gym_mgt');?></label><br>







												<label><strong>[GMGT_ENDDATE] - </strong><?php esc_html_e('Membership Start Date','gym_mgt');?></label><br>







												<label><strong>[GMGT_MEMBERSHIP] - </strong><?php esc_html_e('Membership Name','gym_mgt');?></label><br>







												<label><strong>[GMGT_GYM_NAME] - </strong><?php esc_html_e('Gym Name','gym_mgt');?></label><br>







											</div>







										</div>







										<?php 







										if($user_access_add == '1' OR  $user_access_edit == '1')







										{ ?>







											<div class="form-body user_form"> <!-- user_form Strat-->   







												<div class="row"><!--Row Div Strat--> 







													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">  







														<input type="submit" value="<?php esc_html_e('Save','gym_mgt')?>" name="save_membership_expire_reminder_subject" class="btn btn-success save_btn"/>







													</div>







												</div>







											</div>







											<?php 







										} ?>







									</form>







								</div>







							</div>







						</div>







						<div class="panel-default accordion-item"><!-- PANEL DEFAULT DIV START--> 







							<div class="panel-heading padding_0">







								<h4 class="panel-title">







									<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseeighttin" aria-expanded="false" aria-controls="collapseeighttin">







										<?php esc_html_e('Membership Expire Template','gym_mgt'); ?>







									</button>







								</h4>







							</div>	







							<div id="collapseeighttin" class="accordion-collapse collapse" data-bs-parent="#accordionExample">







								<div class="accordion-body panel-body">







									<form id="email_template_form" class="form-horizontal" method="post" action="" name="parent_form">







										<div class="row">







											<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">







												<div class="form-group input">







													<div class="col-md-12 form-control input_height_75px">







														<input class="form-control validate[required] text-input onlyletter_number_space_validation" maxlength="100" value="<?php echo get_option( 'gmgt_expire_subject' );?>" type="text" name="gmgt_expire_subject">







														<label class="textarea_label" for="gmgt_paypal_email"><?php esc_html_e('Email Subject','gym_mgt');?><span class="require-field">*</span></label>







													</div>







												</div>







											</div>







											<div class="col-md-6">







												<div class="form-group input">







													<div class="col-md-12 form-control texarea_padding_15">	







														<textarea name="gym_expire_message" class="form-control validate[required] min_height_200 texarea_padding_0"><?php echo get_option('gym_expire_message');?></textarea>







														<label for="learner_complete_quiz_notification_mailcontent" class="textarea_label"><?php esc_html_e('Membership Expire Template','gym_mgt');?><span class="require-field">*</span></label>







													</div>







												</div>







											</div>







										</div>







										<div class="form-group input">







											<div class="col-md-12">







												<label><?php esc_html_e('You can use following variables in the email template:','gym_mgt');?></label><br>







												<label><strong>[GMGT_MEMBERNAME] - </strong><?php esc_html_e('Member Name','gym_mgt');?></label><br>







												<label><strong>[GMGT_STARTDATE] - </strong><?php esc_html_e('Membership Start Date','gym_mgt');?></label><br>







												<label><strong>[GMGT_ENDDATE] - </strong><?php esc_html_e('Membership Start Date','gym_mgt');?></label><br>







												<label><strong>[GMGT_MEMBERSHIP] - </strong><?php esc_html_e('Membership Name','gym_mgt');?></label><br>







												<label><strong>[GMGT_GYM_NAME] - </strong><?php esc_html_e('Gym Name','gym_mgt');?></label><br>







											</div>







										</div>







										<?php 







										if($user_access_add == '1' OR  $user_access_edit == '1')







										{ ?>







											<div class="form-body user_form"> <!-- user_form Strat-->   







												<div class="row"><!--Row Div Strat--> 







													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">  







														<input type="submit" value="<?php esc_html_e('Save','gym_mgt')?>" name="save_membership_expire_subject" class="btn btn-success save_btn"/>
													</div>

												</div>
											</div>

											<?php 

										} ?>

									</form>

								</div>

							</div>

						</div>

					</div><!--PANEL DEFAULT DIV END-->		

				</div><!--PANEL BODY DIV END-->


			</div><!--COL 12 DIV END-->


		</div><!--ROW DIV END-->


	</div><!-- MAIN_LIST_MARGING_15px END -->

</div><!-- MAIN WRAPPER DIV END-->	