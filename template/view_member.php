<?php 

$member_id=0;

$active_tab1 = isset($_REQUEST['tab1'])?$_REQUEST['tab1']:'general';



$obj_membership_payment=new MJ_gmgt_membership_payment;



$obj_class=new MJ_gmgt_classschedule;



$member_data=get_userdata($_REQUEST['member_id']);



$member_id = $_REQUEST['member_id'];



$groupdata=$obj_group->MJ_gmgt_get_all_groups($_REQUEST['member_id']);



	$obj_gyme = new MJ_gmgt_Gym_management();



	require_once GMS_PLUGIN_DIR. '/lib/phpqrcode-master/qrlib.php';



	



?>



<script type="text/javascript">



	$(document).ready(function() 



	{



		"use strict";



		$('#member_form').validationEngine({{promptPosition : "bottomLeft",maxErrorsPerField: 1});	



		$.datepicker.setDefaults($.datepicker.regional['<?php echo MJ_gmgt_get_current_lan_code(); ?>']);



		$('#birth_date').datepicker(



		{



			changeMonth: true,



				changeYear: true,



				yearRange:'-65:+0',



				onChangeMonthYear: function(year, month, inst) {



					$(this).val(month + "/" + year);



				}        



		}); 



		var qr_code_urlnew ='<?php echo $_REQUEST['member_id'];?>';



		// var url = 'https://api.qrserver.com/v1/create-qr-code/?data=' + qr_code_urlnew + '&amp;size=50x50';

			var url = <?php echo site_url() . "/customer-details/?accountant_id=" . $_REQUEST['member_id'];?>;

			url = "https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=" + encodeURIComponent( url) + "&choe=UTF-8";


		$('#barcode').attr('src', url);



	} );



</script>



<?php	



	$member_id=0;



	if(isset($_REQUEST['member_id']))



		$member_id=esc_attr($_REQUEST['member_id']);



		$edit=0;					



		$edit=1;



		$user_info = get_userdata($member_id);		



?>	



<style>



	.right_side



	{



		min-height: 355px !important;



	}



</style>











<div class="panel-body padding_0 view_page_main gms_main_list"><!-- START PANEL BODY DIV-->



	<div class="content-body"><!-- START CONTENT-BODY-->



		<section id="user_information" class="">



			<div class="view_page_header_bg">



				<div class="row">



					<div class="col-xl-10 col-md-9 col-sm-10">



						<div class="user_profile_header_left float_left_width_100">



								<?php 



								if($user_info->gmgt_user_avatar == "") 



								{



								?>



									<img class="user_view_profile_image" alt="" src="<?php echo esc_url(get_option( 'gmgt_member_logo' )); ?>">



								<?php 



								} 



								else 



								{ 



								?>



									<img class="user_view_profile_image" src="<?php if($edit)echo esc_url( $user_info->gmgt_user_avatar ); ?>" />



								<?php 



								}



								?>



							<div class="row profile_user_name">



								<div class="float_left view_top1">



									<div class="col-xl-12 col-md-12 col-sm-12 float_left_width_100">



										<label class="view_user_name_label"><?php echo chunk_split(MJ_gmgt_get_user_full_display_name($_REQUEST['member_id']),24,"<BR>");?></label>



										<!-- <label class="view_user_name_label"><?php echo esc_html($member_data->display_name);?></label> -->



										<?php 



										if($user_access['edit']=='1')



										{ 



											?>



											<div class="view_user_edit_btn">



												<a class="color_white margin_left_2px" href="?dashboard=user&page=member&tab=addmember&action=edit&member_id=<?php echo $_REQUEST['member_id'] ?>">



												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/edit.png"?>">



												</a>



											</div>



											<?php



										} ?>



									</div>



									<div class="col-xl-12 col-md-12 col-sm-12 float_left_width_100">



										<div class="view_user_phone float_left_width_100 ">



											<img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/phone_figma.png"?>">&nbsp;+<?php echo MJ_gmgt_get_countery_phonecode(get_option( 'gmgt_contry' ));?>&nbsp;&nbsp;<lable class="color_white_rs"><?php echo esc_html($user_info->mobile);?></label>



										</div>



									</div>



								</div>



							</div>



							<div class="gmgt_address_row row">



								<div class="col-xl-12 col-md-12 col-sm-12">



									<div class="view_top2">



										<div class="row view_user_doctor_label">



											<div class="col-md-12 address_student_div">



												<?php



												if(!empty($user_info->address))



												{



													?>



													<img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/location.png"?>" alt="">&nbsp;&nbsp;



													<lable class="address_detail_page">



														<?php



														if($user_info->address != '')



														{



															echo chunk_split(esc_html($user_info->address).",");



														} 



														if($user_info->city_name != '')



														{



															echo chunk_split(esc_html($user_info->city_name));



														}



														?>



													</label>



													<?php



												}



												?>



											</div>		



										</div>



									</div>



								</div>



							</div>



						</div>



					</div>



				</div>



			</div>



		</section>



		<!-- Detail Page Tabing Start -->



		<section id="body_area" class="">



			<div class="row">



				<div class="col-xl-12 col-md-12 col-sm-12">

					<?php

					if(isset($_REQUEST['page_action'])== 'web_view_hide')

					{

						?>

						<ul class="nav nav-tabs panel_tabs margin_left_1per" role="tablist">



							<li class="<?php if($active_tab1=='general'){?>active<?php }?>">			



								<a href="?dashboard=user&page=member&tab=viewmember&page_action=web_view_hide&action=view&member_id=<?php echo $_REQUEST['member_id'];?>" class="padding_left_0 tab <?php echo $active_tab1 == 'general' ? 'active' : ''; ?>">



								<?php esc_html_e('GENERAL', 'gym_mgt'); ?></a> 



							</li>



							<li class="<?php if($active_tab1=='Membership_payment'){?>active<?php }?>">



								<a href="?dashboard=user&page=member&tab=viewmember&page_action=web_view_hide&action=view&tab1=Membership_payment&member_id=<?php echo $_REQUEST['member_id'];?>" class="padding_left_0 tab <?php echo $active_tab1 == 'Membership_payment' ? 'active' : ''; ?>">



								<?php esc_html_e('Membership Payment', 'gym_mgt'); ?></a> 



							</li>  



							<li class="<?php if($active_tab1=='Class_Schedule'){?>active<?php }?>">



								<a href="?dashboard=user&page=member&tab=viewmember&page_action=web_view_hide&action=view&tab1=Class_Schedule&member_id=<?php echo $_REQUEST['member_id'];?>" class="padding_left_0 tab <?php echo $active_tab1 == 'Class_Schedule' ? 'active' : ''; ?>">



								<?php esc_html_e('Class Schedule', 'gym_mgt'); ?></a> 



							</li>  



							<li class="<?php if($active_tab1=='Booking'){?>active<?php }?>">



								<a href="?dashboard=user&page=member&tab=viewmember&page_action=web_view_hide&action=view&tab1=Booking&member_id=<?php echo $_REQUEST['member_id'];?>" class="padding_left_0 tab <?php echo $active_tab1 == 'Booking' ? 'active' : ''; ?>">



								<?php esc_html_e('Booking List', 'gym_mgt'); ?></a> 



							</li>  



							<li class="<?php if($active_tab1=='Attendance'){?>active<?php }?>">



								<a href="?dashboard=user&page=member&tab=viewmember&page_action=web_view_hide&tab1=Attendance&member_id=<?php echo $_REQUEST['member_id'];?>" class="padding_left_0 tab <?php echo $active_tab1 == 'Attendance' ? 'active' : ''; ?>">



								<?php esc_html_e('Attendance', 'gym_mgt'); ?></a> 



							</li>  



							<li class="<?php if($active_tab1=='Member_Reports'){?>active<?php }?>">



								<a href="?dashboard=user&page=member&tab=viewmember&tab1=Member_Reports&page_action=web_view_hide&member_id=<?php echo $_REQUEST['member_id'];?>" class="padding_left_0 tab <?php echo $active_tab1 == 'Member_Reports' ? 'active' : ''; ?>">



								<?php esc_html_e('Member Reports', 'gym_mgt'); ?></a> 



							</li>  



							<li class="<?php if($active_tab1=='Subscription'){?>active<?php }?>">



								<a href="?dashboard=user&page=member&tab=viewmember&action=view&page_action=web_view_hide&tab1=Subscription&member_id=<?php echo $_REQUEST['member_id'];?>" class="padding_left_0 tab <?php echo $active_tab1 == 'Subscription' ? 'active' : ''; ?>">



								<?php esc_html_e('Membership History', 'gym_mgt'); ?></a> 



							</li>  



						</ul>

						<?php

					}

					else

					{

						?>

						<ul class="nav nav-tabs panel_tabs margin_left_1per" role="tablist">



							<li class="<?php if($active_tab1=='general'){?>active<?php }?>">			



								<a href="?dashboard=user&page=member&tab=viewmember&action=view&member_id=<?php echo $_REQUEST['member_id'];?>" class="padding_left_0 tab <?php echo $active_tab1 == 'general' ? 'active' : ''; ?>">



								<?php esc_html_e('GENERAL', 'gym_mgt'); ?></a> 



							</li>



							<li class="<?php if($active_tab1=='Membership_payment'){?>active<?php }?>">



								<a href="?dashboard=user&page=member&tab=viewmember&action=view&tab1=Membership_payment&member_id=<?php echo $_REQUEST['member_id'];?>" class="padding_left_0 tab <?php echo $active_tab1 == 'Membership_payment' ? 'active' : ''; ?>">



								<?php esc_html_e('Membership Payment', 'gym_mgt'); ?></a> 



							</li>  



							<li class="<?php if($active_tab1=='Class_Schedule'){?>active<?php }?>">



								<a href="?dashboard=user&page=member&tab=viewmember&action=view&tab1=Class_Schedule&member_id=<?php echo $_REQUEST['member_id'];?>" class="padding_left_0 tab <?php echo $active_tab1 == 'Class_Schedule' ? 'active' : ''; ?>">



								<?php esc_html_e('Class Schedule', 'gym_mgt'); ?></a> 



							</li>  



							<li class="<?php if($active_tab1=='Booking'){?>active<?php }?>">



								<a href="?dashboard=user&page=member&tab=viewmember&action=view&tab1=Booking&member_id=<?php echo $_REQUEST['member_id'];?>" class="padding_left_0 tab <?php echo $active_tab1 == 'Booking' ? 'active' : ''; ?>">



								<?php esc_html_e('Booking List', 'gym_mgt'); ?></a> 



							</li>  



							<li class="<?php if($active_tab1=='Attendance'){?>active<?php }?>">



								<a href="?dashboard=user&page=member&tab=viewmember&tab1=Attendance&member_id=<?php echo $_REQUEST['member_id'];?>" class="padding_left_0 tab <?php echo $active_tab1 == 'Attendance' ? 'active' : ''; ?>">



								<?php esc_html_e('Attendance', 'gym_mgt'); ?></a> 



							</li>  



							<li class="<?php if($active_tab1=='Member_Reports'){?>active<?php }?>">



								<a href="?dashboard=user&page=member&tab=viewmember&tab1=Member_Reports&member_id=<?php echo $_REQUEST['member_id'];?>" class="padding_left_0 tab <?php echo $active_tab1 == 'Member_Reports' ? 'active' : ''; ?>">



								<?php esc_html_e('Member Reports', 'gym_mgt'); ?></a> 



							</li>  



							<li class="<?php if($active_tab1=='Subscription'){?>active<?php }?>">



								<a href="?dashboard=user&page=member&tab=viewmember&action=view&tab1=Subscription&member_id=<?php echo $_REQUEST['member_id'];?>" class="padding_left_0 tab <?php echo $active_tab1 == 'Subscription' ? 'active' : ''; ?>">



								<?php esc_html_e('Membership History', 'gym_mgt'); ?></a> 



							</li>  



							



						</ul>

						<?php

					}

					?>



				</div>



			</div>



		</section>



		<!-- Detail Page Tabing End -->







		<!-- Detail Page Body Content Section  -->



		<section id="body_content_area" class="">



			<div class="panel-body padding_0"><!-- START PANEL BODY DIV-->



				<?php 



				// general tab start 



				if($active_tab1 == "general")



				{



					?>



					<div class="popup-bg">



						<div class="overlay-content content_width">



							<div class="modal-content d-modal-style">



								<div class="task_event_list">



								</div>



							</div>



						</div>



					</div>



					<div class="row margin_top_15px">



						<div class="col-xl-3 col-md-3 col-sm-12 margin_bottom_10_res">



							<label class="view_page_header_labels"> <?php esc_html_e('Member Id', 'gym_mgt'); ?> </label><br/>



							<label class="view_page_content_labels"> <?php echo $user_info->member_id; ?> </label>



						</div>



						<div class="col-xl-4 col-md-3 col-sm-12 margin_bottom_10_res">



							<label class="view_page_header_labels"> <?php esc_html_e('Email ID', 'gym_mgt'); ?> </label><br/>



							<label class="view_page_content_labels"> <?php echo $user_info->user_email; ?> </label>



						</div>



						<div class="col-xl-2 col-md-2 col-sm-12 margin_bottom_10_res">



							<label class="view_page_header_labels"> <?php esc_html_e('Gender', 'gym_mgt'); ?> </label><br/>



							<label class="view_page_content_labels"> <?php echo esc_html_e(ucfirst($user_info->gender),'gym_mgt'); ?></label>	



						</div>



						<div class="col-xl-2 col-md-3 col-sm-12 margin_bottom_10_res">



							<label class="view_page_header_labels date_of_birth_label"> <?php esc_html_e('Date of Birth', 'gym_mgt'); ?> </label><br/>



							<label class="view_page_content_labels"><?php echo MJ_gmgt_getdate_in_input_box($user_info->birth_date); ?></label>	



						</div>



					</div>







					<!--All Information div start  -->



					<div class="row margin_top_20px">



						<div class="col-xl-8 col-md-8 col-sm-12">



							<!-- Membership Information div start  -->



							<div class="col-xl-12 col-md-12 col-sm-12 margin_top_20px">



								<div class="guardian_div">



									<label class="view_page_label_heading"> <?php esc_html_e('Membership Information', 'gym_mgt'); ?> </label>



									<div class="row">



										<div class="col-xl-4 col-md-4 col-sm-12 margin_top_15px">



											<label class="guardian_labels view_page_header_labels"> <?php esc_html_e('Membership Name', 'gym_mgt'); ?> </label> <br>



											<label class="view_page_content_labels">



												<?php 



													$membership_name=MJ_gmgt_get_membership_name($user_info->membership_id); 



													if(!empty($membership_name))



													{



														echo chunk_split(esc_html($membership_name),18,"<BR>");



													}



													else



													{



														echo "N/A";



													}?>



												 	



											</label>



										</div>



										<div class="col-xl-4 col-md-4 col-sm-12 address_rs_css margin_top_15px">



											<label class="guardian_labels view_page_header_labels"> <?php esc_html_e('Joining Date', 'gym_mgt'); ?> </label><br>



											<label class="view_page_content_labels">



												<?php 



												if(!empty($user_info->begin_date)) 



												{ 



													echo esc_html(MJ_gmgt_getdate_in_input_box($user_info->begin_date));



												}



												else



												{ 



													echo "N/A"; 



												}



												//echo esc_html(MJ_gmgt_getdate_in_input_box($user_info->begin_date)); 



												?>



												



											</label>



										</div>



										<div class="col-xl-4 col-md-4 col-sm-12 address_rs_css margin_top_15px">



											<label class="guardian_labels view_page_header_labels"> <?php esc_html_e('Expiry Date', 'gym_mgt'); ?> </label><br>



											<label class="view_page_content_labels">



												<?php 



												if(!empty($user_info->end_date)) 



												{ 



													echo esc_html(MJ_gmgt_getdate_in_input_box($user_info->end_date));



												}



												else



												{ 



													echo "N/A"; 



												}



												//echo esc_html(MJ_gmgt_getdate_in_input_box($user_info->end_date)); 



												?>



											</label>



										</div>



										<div class="col-xl-4 col-md-4 col-sm-12 margin_top_15px">



											<label class="guardian_labels view_page_header_labels"> <?php esc_html_e('Membership Status', 'gym_mgt'); ?> </label><br>



											<label class="ftext_style_capitalization view_page_content_labels">



												 <?php 



												if(!empty($user_info->membership_status)) 



												{ 



													esc_html_e($user_info->membership_status, 'gym_mgt');



												}



												else



												{ 



													echo "N/A"; 



												}



												 ?>



											</label>



										</div>



										<div class="col-xl-4 col-md-4 col-sm-12 margin_top_15px">



											<label class="guardian_labels view_page_header_labels"> <?php esc_html_e('Staff Member', 'gym_mgt'); ?> </label> <br>



											<label class="view_page_content_labels">



												<?php $staff_member=MJ_gmgt_get_display_name($user_info->staff_id);  ?>



												<?php 



													if(!empty($staff_member))



													{



														echo chunk_split(esc_html($staff_member),18,"<BR>");



													}



													else{



														echo "N/A";



													}	



												?>



											</label>



										</div>



										<div class="col-xl-4 col-md-4 col-sm-12 margin_top_15px">



											<label class="guardian_labels view_page_header_labels"> <?php esc_html_e('Member type', 'gym_mgt'); ?> </label><br>



											<label class="ftext_style_capitalization view_page_content_labels">



												<?php 



												$membertype_array=MJ_gmgt_member_type_array();



												if(!empty($user_info->member_type))



												{



													// esc_html_e($user_info->member_type);  



													echo esc_html($membertype_array[$user_info->member_type]);  



												}



												else{



													echo "N/A";



												}	



												?>



											</label>



										</div>



										<div class="col-xl-12 col-md-12 col-sm-12 margin_top_15px">



											<label class="guardian_labels view_page_header_labels"> <?php esc_html_e('Class Name', 'gym_mgt'); ?> </label> <br>



											<label class="view_page_content_labels">



												<?php 



													$ClassArr=MJ_gmgt_get_current_user_classis($user_info->ID);



													$class_name="N/A";



													$class_name_string="";



													if($ClassArr)



													{												



														foreach($ClassArr as $key=>$class_id)



														{							



															$class_name_string.=MJ_gmgt_get_class_name($class_id).", ";



															



														}



														$class=rtrim($class_name_string,", ");



														echo esc_html($class);



													}						



													else



													{



														echo esc_html($class_name);



													}



												?>



											</label>



										</div>



									</div>



								</div>	



							</div>



							<!--Member Information div End  -->







							<!-- Contact Information div start  -->



							<div class="col-xl-12 col-md-12 col-sm-12 margin_top_20px margin_top_15px_rs">



								<div class="guardian_div">



									<label class="view_page_label_heading"> <?php esc_html_e('Contact Information', 'gym_mgt'); ?> </label>



									<div class="row">



										<div class="col-xl-3 col-md-3 col-sm-12 margin_top_15px">



											<label class="guardian_labels view_page_header_labels"> <?php esc_html_e('City', 'gym_mgt'); ?> </label><br>



											<label class="view_page_content_labels">



												<?php 



												if($user_info->city_name)



												{



													echo $user_info->city_name; 



												}



												else{



													echo "N/A";



												}	



												?>



											</label>



										</div>



										<div class="col-xl-3 col-md-3 col-sm-12 margin_top_15px">



											<label class="guardian_labels view_page_header_labels"> <?php esc_html_e('State', 'gym_mgt'); ?> </label><br>



											<label class="view_page_content_labels">



												<?php if(!empty($user_info->state_name)){ echo $user_info->state_name; }else{ echo "N/A"; } ?></label>



										</div>



										



										<div class="col-xl-3 col-md-3 col-sm-12 address_rs_css margin_top_15px">



											<label class="guardian_labels view_page_header_labels"> <?php esc_html_e('Zipcode', 'gym_mgt'); ?> </label><br>



											<label class="view_page_content_labels">



												<?php



												if($user_info->zip_code)



												{



													echo $user_info->zip_code; 



												}



												else{



													echo "N/A";



												}	



												 ?></label>



										</div>



										<div class="col-xl-3 col-md-3 col-sm-12 margin_top_15px">



											<label class="guardian_labels view_page_header_labels"> <?php esc_html_e('Phone', 'gym_mgt'); ?> </label><br>



											<label class="ftext_style_capitalization view_page_content_labels"><?php if(!empty($user_info->phone)){ echo $user_info->phone; }else{ echo "N/A"; } ?></label>



										</div>



									</div>



								</div>	



							</div>



							<!--Contact Information div End  -->







							<!-- More Information div start  -->



							<div class="col-xl-12 col-md-12 col-sm-12 margin_top_20px margin_top_15px_rs">



								<div class="guardian_div">



									<label class="view_page_label_heading"> <?php esc_html_e('Other Information', 'gym_mgt'); ?> </label>



									<div class="row">



										<div class="col-xl-4 col-md-4 col-sm-12 margin_top_15px">



											<label class="guardian_labels view_page_header_labels"> <?php esc_html_e('Interest Area', 'gym_mgt'); ?> </label><br>



											<label class="ftext_style_capitalization view_page_content_labels">



												<?php $intrest_area=get_the_title($user_info->intrest_area);   ?>



												<?php 



												if($user_info->intrest_area!="")



												{ 



													echo chunk_split(esc_html($intrest_area),18,"<BR>"); 



												}



												else



												{ 



													echo "N/A"; 



												}?>



											</label>



										</div>



										<div class="col-xl-4 col-md-4 col-sm-12 margin_top_15px">



											<label class="guardian_labels view_page_header_labels"> <?php esc_html_e('Referral Source', 'gym_mgt'); ?> </label><br>



											<label class="ftext_style_capitalization view_page_content_labels">



												<?php $source=get_the_title($user_info->source);   ?>



												<?php 



												if($user_info->source!="")



												{ 



													echo chunk_split(esc_html($source),18,"<BR>"); 



												}



												else



												{ 



													echo "N/A"; 



												}?>



											</label>



										</div>



										<div class="col-xl-4 col-md-4 col-sm-12 margin_top_15px">



											<label class="guardian_labels view_page_header_labels"> <?php esc_html_e('Referred By', 'gym_mgt'); ?> </label><br>



											<label class="ftext_style_capitalization view_page_content_labels">



												<?php 



												$staff_data=$user_info->reference_id;



												?>



												<?php 



												if($staff_data!="")



												{ 



													echo MJ_gmgt_get_display_name($staff_data); 



												}



												else



												{ 



													echo "N/A"; 



												}?>



												



											</label>



										</div>



										<div class="col-xl-4 col-md-4 col-sm-12 margin_top_15px">



											<label class="guardian_labels view_page_header_labels"> <?php esc_html_e('Inquiry Date', 'gym_mgt'); ?> </label><br>



											<label class=" view_page_content_labels">



												<?php if($user_info->inqiury_date!=""){ echo MJ_gmgt_getdate_in_input_box($user_info->inqiury_date); }else{ echo "N/A"; }?>



											</label>



										</div>



										<div class="col-xl-4 col-md-4 col-sm-12 margin_top_15px">



											<label class="guardian_labels view_page_header_labels"> <?php esc_html_e('Trial End Date', 'gym_mgt'); ?> </label><br>



											<label class=" view_page_content_labels">



												<?php if($user_info->triel_date!=""){ echo MJ_gmgt_getdate_in_input_box($user_info->triel_date); }else{ echo "N/A"; }?>



											</label>



										</div>



										<div class="col-xl-4 col-md-4 col-sm-12 margin_top_15px">



											<label class="guardian_labels view_page_header_labels"> <?php esc_html_e('First Payment Date', 'gym_mgt'); ?> </label><br>



											<label class=" view_page_content_labels">



												<?php if($user_info->triel_date!=""){ echo MJ_gmgt_getdate_in_input_box($user_info->first_payment_date); }else{ echo "N/A"; }?>



											</label>



										</div>







										<div class="col-xl-12 col-md-12 col-sm-12 margin_top_15px">



											<label class="guardian_labels view_page_header_labels"> <?php esc_html_e('Group Name', 'gym_mgt'); ?> </label><br>



											<label class=" view_page_content_labels">



												<?php



													$obj_group=new MJ_gmgt_group;

													

													$groupdata=$obj_group->MJ_gmgt_get_member_all_groups_name($member_id);

													

													if($groupdata != NULL)

													{

														if(!empty($groupdata))

														{

															foreach($groupdata as $retrieved_data)

															{		

																$group_name=$retrieved_data->group_name;



																$string .= ", $group_name";	

															}

														}

														if(!empty($string))

														{

															$string1 = substr($string, 1);

														}

														else

														{

															$string1='';

														}

														

														if(!empty($string1))

														{

															echo $string1;

														}

														else

														{

															echo "N/A";

														}	

													}else

													{

														echo "N/A";

													}

												?>



											</label>



										</div>







									</div>



								</div>	



							</div>



							<!-- More Information div End  -->



						</div>



						<!-- SCAN CODE START  -->

						<script type="text/javascript">



						$(document).ready(function()

						{

							"use strict";

							var qr_code_urlnew ='WP_GYM,<?php echo $_REQUEST['member_id'];?>';

							// var url = 'https://api.qrserver.com/v1/create-qr-code/?data=' + qr_code_urlnew + '&amp;size=50x50';
							
							var url = <?php echo site_url() . "/customer-details/?accountant_id=" . $_REQUEST['member_id'];?>;

							url = "https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=" + encodeURIComponent( url) + "&choe=UTF-8";


							$('#barcode').attr('src', url);



						});



						</script>



						<div class="col-xl-4 col-md-4 col-sm-12 margin_top_20px margin_top_15px_rs">



							<div class="col-xl-12 col-md-12 col-sm-12">



								<div class="view_card detail_page_card">



									<div class="card_heading">



										<label class="card_heading_label"><?php esc_html_e('QR code For attendance', 'gym_mgt'); ?> </label>



									</div>



									<div class="qr_main_div">



										<h3><?php echo esc_html_e('SCAN ME','gym_mgt'); ?></h3>



										<div class="qr_image_div">



											<img class="" id='barcode' src=''>



										</div>



									</div>	



								</div>	



							</div> 



						</div> 



						<!-- SCAN CODE END  -->



						



					</div>



					<!-- All Information div End  -->







					<?php



				}



				// feespayment tab start 



				elseif($active_tab1 == "Membership_payment")



				{



					?>



						<div class="popup-bg z_index_100000">



							<div class="overlay-content">



								<div class="modal-content">



									<div class="invoice_data"></div>     



								</div>



							</div>     



						</div>



					<?php



					$paymentdata=$obj_membership_payment->MJ_gmgt_get_all_membership_payment_byuserid($member_id);



					if(!empty($paymentdata))



					{



						?>



						<script type="text/javascript">



							jQuery(document).ready(function($) 



							{



								"use strict";



								$('#feespayment_list_detailpage').DataTable({



									// "responsive": true,



									"aoColumns":[



													{"bSortable": false},



													{"bSortable": false},



													{"bSortable": true},



													{"bSortable": true},



													{"bSortable": true},



													{"bSortable": true},



													{"bSortable": true},



													{"bSortable": true},



													{"bSortable": true},



													{"bSortable": false}],



										dom: '<"float-right"f>rt<"row"<"col-sm-1"l><"col-sm-8"i><"col-sm-3"p>>',



										language:<?php echo MJ_gmgt_datatable_multi_language();?>



								});



								$('.dataTables_filter input').attr("placeholder", "<?php esc_html_e('Search...', 'gym_mgt') ?>");



								$('.dataTables_filter').addClass('search_btn_view_page');



							} );



						</script>



						<div class="table-div"><!-- PANEL BODY DIV START -->



							<div class="table-responsive"><!-- TABLE RESPONSIVE DIV START -->



								<table id="feespayment_list_detailpage" class="display" cellspacing="0" width="100%">

									<thead class="<?php echo MJ_gmgt_datatable_heder(); ?>">

										<tr>

											<th><?php esc_html_e('Photo','gym_mgt');?></th>

											<th><?php esc_html_e('Invoice No.','gym_mgt');?></th>

											<th><?php esc_html_e('Membership Name','gym_mgt');?></th>

											<th><?php esc_html_e('Member Name','gym_mgt');?></th>

											<th><?php esc_html_e('Total Amount','gym_mgt');?></th>

											<th><?php esc_html_e('Paid Amount','gym_mgt');?></th>

											<th><?php esc_html_e('Due Amount','gym_mgt');?></th>

											<th><?php esc_html_e('Start To End Date ','gym_mgt');?></th>

											<th><?php esc_html_e('Payment Status','gym_mgt');?></th>

											<th class="text_align_end"><?php esc_html_e('Action','gym_mgt');?></th>

										</tr>

									</thead>

									

									<tbody>



										<?php



										$i=0;	



								



										if(!empty($paymentdata))



										{



											foreach ($paymentdata as $retrieved_data)



											{	



												if($i == 10)



												{



													$i=0;



												}



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



												elseif($i == 5)



												{



													$color_class='smgt_class_color5';







												}



												elseif($i == 6)



												{



													$color_class='smgt_class_color6';







												}



												elseif($i == 7)



												{



													$color_class='smgt_class_color7';







												}



												elseif($i == 8)



												{



													$color_class='smgt_class_color8';







												}



												elseif($i == 9)



												{



													$color_class='smgt_class_color9';







												}



												?>



												<tr>



													<td class="cursor_pointer user_image width_50px profile_image_prescription padding_left_0">



														<p class="remainder_title_pr Bold prescription_tag <?php echo $color_class; ?>">	



															<img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/Payment.png"?>" alt="" class="massage_image center">



														</p>



													</td>







													<td class="productname">



														<?php



														if(!empty($retrieved_data->invoice_no))



														{



															echo esc_html($retrieved_data->invoice_no);



														}



														else



														{



															echo 'N/A';



														}		



														?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Invoice Number','gym_mgt');?>" ></i>



													</td>



														



													<td class="productname">



														<?php echo MJ_gmgt_get_membership_name(esc_html($retrieved_data->membership_id));?>



														 <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Membership Title','gym_mgt');?>" ></i>



													</td>







													<td class="paymentby">



														<?php 



														$user=get_userdata($retrieved_data->member_id);



														$memberid=get_user_meta($retrieved_data->member_id,'member_id',true); 



														$display_label = MJ_gmgt_get_member_full_display_name_with_memberid(esc_html($user->ID));



														// if(!empty($user->display_name))



														// {



														// 	$display_label=$user->display_name; 



														// }



														// else



														// {



														// 	$display_label="N/A";



														// }



														// if($memberid)



														// {



														// 	$display_label.=" (".$memberid.")";



														// }



														echo esc_html($display_label); 



														?> 



														<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Member Name','gym_mgt');?>" ></i>



													</td>







													<td class="totalamount">



														<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?> <?php echo esc_html($retrieved_data->membership_amount);?>



														<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Total Amount','gym_mgt');?>" ></i>



													</td>







													<td class="paid_amount">



														<?php echo MJ_gmgt_get_currency_symbol(get_option('gmgt_currency_code')); ?> <?php echo esc_html($retrieved_data->paid_amount);?>



														<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Paid Amount','gym_mgt');?>" ></i>



													</td>







													<td class="totalamount">



														<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?> <?php echo esc_html($retrieved_data->membership_amount)-esc_html($retrieved_data->paid_amount);?>



														<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Due Amount','gym_mgt');?>" ></i>



													</td>







													<td class="paymentdate">



														<?php if($retrieved_data->start_date == "0000-00-00"){ echo "0000-00-00"; }else{echo MJ_gmgt_getdate_in_input_box($retrieved_data->start_date); } ?>



														<?php _e('To','gym_mgt');?>



														<?php if($retrieved_data->end_date == "0000-00-00"){ echo "0000-00-00"; }else{ echo MJ_gmgt_getdate_in_input_box($retrieved_data->end_date); } ?>



														<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Start To End Date ','gym_mgt');?>" ></i>



													</td>







													<td class="paymentdate tab_view_membership">



														<?php



															$memberhsip_status=MJ_gmgt_get_membership_paymentstatus($retrieved_data->mp_id);	



															



															if($memberhsip_status == 'Unpaid')



															{



																echo "<span class='gmgt_unpaid btn-xs'>";



															}elseif($memberhsip_status == 'Partially Paid')



															{



																echo "<span class='gmgt_Partially btn-xs'>";



															}



															else



															{



																echo "<span class='gmgt_paid btn-xs'>";



															}													 



																echo esc_html__($memberhsip_status,'gym_mgt' );



															echo "</span>"; 



														?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Payment Status','gym_mgt');?>" ></i>



													</td>







													<?php 



													if(MJ_gmgt_get_membership_paymentstatus($retrieved_data->mp_id) =='Fully Paid')



													{



														?>



														<td class="action"> 



															<div class="gmgt-user-dropdown">



																<ul class="" style="margin-bottom: 0px !important;">



													 				<li class="">



																		<a class="" href="#" data-bs-toggle="dropdown" aria-expanded="false">



																			<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/More.png"?>" >



																		</a>



																		<ul class="dropdown-menu heder-dropdown-menu action_dropdawn" aria-labelledby="dropdownMenuLink">				  



																			<li class="float_left_width_100">



																				<!-- <a href="#" class="show-invoice-popup float_left_width_100" idtest="<?php echo esc_attr($retrieved_data->mp_id); ?>"  invoice_type="membership_invoice" ><i class="fa fa-eye"></i> <?php esc_html_e('View Invoice', 'gym_mgt');?></a> -->



																				<a href="?dashboard=user&page=membership_payment&tab=view_invoice&idtest=<?php echo $retrieved_data->mp_id; ?>&invoice_type=membership_invoice" class="float_left_width_100" ><i class="fa fa-eye"></i> <?php esc_html_e('View Invoice', 'gym_mgt' ) ;?></a>



																			</li>



																		</ul>



																	</li>

																	

																</ul>



															</div>	



														</td>



														<?php 



													}			



													else



													{



														$due_amount=$retrieved_data->membership_amount-$retrieved_data->paid_amount;



														?>



														<td class="action"> 



															<div class="gmgt-user-dropdown">



																<ul class="" style="margin-bottom: 0px !important;">



													 				<li class="">



																		<a class="" href="#" data-bs-toggle="dropdown" aria-expanded="false">



																			<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/More.png"?>" >



																		</a>



																		<ul class="dropdown-menu heder-dropdown-menu action_dropdawn" aria-labelledby="dropdownMenuLink">				  



																				<?php

																					if(isset($_REQUEST['page_action'])== 'web_view_hide')

																					{

																						?>

																						<li class="float_left_width_100">



																							<!-- <a href="#" class="show-invoice-popup float_left_width_100" idtest="<?php echo esc_attr($retrieved_data->mp_id); ?>" invoice_type="membership_invoice" ><i class="fa fa-eye"></i> <?php esc_html_e('View Invoice', 'gym_mgt');?></a> -->



																							<a href="?dashboard=user&page_action=web_view_hide&page=membership_payment&tab=view_invoice&idtest=<?php echo $retrieved_data->mp_id; ?>&invoice_type=membership_invoice" class="float_left_width_100" ><i class="fa fa-eye"></i> <?php esc_html_e('View Invoice', 'gym_mgt' ) ;?></a>



																						</li>

																						<?php

																					}else{



																						?>



																						<li class="float_left_width_100">



																							<!-- <a href="#" class="show-invoice-popup float_left_width_100" idtest="<?php echo esc_attr($retrieved_data->mp_id); ?>" invoice_type="membership_invoice" ><i class="fa fa-eye"></i> <?php esc_html_e('View Invoice', 'gym_mgt');?></a> -->



																							<a href="?dashboard=user&page=membership_payment&tab=view_invoice&idtest=<?php echo $retrieved_data->mp_id; ?>&invoice_type=membership_invoice" class="float_left_width_100" ><i class="fa fa-eye"></i> <?php esc_html_e('View Invoice', 'gym_mgt' ) ;?></a>



																						</li>

																						<?php

																					} ?>







																			<!-- <li class="float_left_width_100">



																				<a href="#" class="show-payment-popup float_left_width_100" idtest="<?php// echo $retrieved_data->mp_id; ?>" due_amount="<?php echo $due_amount; ?>"  view_type="payment" ><i class="fa fa-credit-card" aria-hidden="true"></i>&nbsp;&nbsp;<?php esc_html_e('Pay', 'gym_mgt' ) ;?></a>



																			</li> -->



																			<?php



																			if($user_access['edit']=='1')



																			{



																				if(isset($_REQUEST['product_list_app_view']) && $_REQUEST['product_list_app_view'] == 'productlist_app')



																				{



																					?>



																					<li class="float_left_width_100 border_bottom_item">



																						<a href="?dashboard=user&page=membership_payment&tab=addpayment&action=edit&product_list_app_view=productlist_app&page_action=web_view_hide&product_id=<?php echo esc_attr($retrieved_data->id)?>" class="float_left_width_100"><i class="fa fa-edit"></i> <?php esc_html_e('Edit', 'gym_mgt' ) ;?></a>



																					</li>



																					<?php



																				}



																				else



																				{



																					?>



																					<li class="float_left_width_100 border_bottom_item">



																						<a href="?dashboard=user&page=membership_payment&tab=addpayment&action=edit&product_id=<?php echo esc_attr($retrieved_data->id)?>" class="float_left_width_100"><i class="fa fa-edit"></i> <?php esc_html_e('Edit', 'gym_mgt' ) ;?></a>



																					</li>



																					<?php



																				}



																			}



																			if($user_access['delete']=='1')



																			{



																				if(isset($_REQUEST['product_list_app_view']) && $_REQUEST['product_list_app_view'] == 'productlist_app')



																				{



																					?>		



																					<li class="float_left_width_100">



																						<a href="?dashboard=user&page=membership_payment&tab=paymentlist&action=delete&product_list_app_view=productlist_app&page_action=web_view_hide&mp_id=<?php echo esc_attr($retrieved_data->id);?>" class="float_left_width_100 list_delete_btn" onclick="return confirm('<?php esc_html_e('Are you sure you want to delete this record?','gym_mgt');?>');"><i class="fa fa-trash"></i> <?php esc_html_e( 'Delete', 'gym_mgt' ) ;?> </a>



																					</li>



																					<?php



																				}



																				else



																				{



																					?>



																					<li class="float_left_width_100">		



																						<a href="?dashboard=user&page=membership_payment&tab=paymentlist&action=delete&mp_id=<?php echo esc_attr($retrieved_data->id);?>" class="float_left_width_100 list_delete_btn" onclick="return confirm('<?php esc_html_e('Are you sure you want to delete this record?','gym_mgt');?>');"><i class="fa fa-trash"></i> <?php esc_html_e( 'Delete', 'gym_mgt' ) ;?> </a>



																					</li>



																					<?php



																				}



																			}



																			?>



																			



																		</ul>



																	</li>



																</ul>



															</div>	



														</td>



														<?php 



													}



													?>



												</tr>



												<?php 



												$i++;	



											}	 



										}



										?>



									</tbody>



								</table>



							</div><!-- TABLE RESPONSIVE DIV END -->



						</div>



						<?php



					}



					else



					{



						if($user_access['add']=='1')



						{



							?>



							<div class="no_data_list_div"> 



								<a href="<?php echo home_url().'?dashboard=user&page=membership_payment&tab=addpayment&&action=insert';?>">



									<img class="width_100px" src="<?php echo get_option( 'gmgt_no_data_img' ) ?>" >



								</a>



								<div class="col-md-12 dashboard_btn margin_top_20px">



									<label class="no_data_list_label"><?php esc_html_e('Tap on above icon to add your first Record.','gym_mgt'); ?> </label>



								</div> 



							</div>		



							<?php



						}



						else



						{



							?>



							<div class="calendar-event-new"> 



								<img class="no_data_img" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/no_data_img.png"?>" >



							</div>



							<?php



						}



					}



				}







				// Class Schedule tab start 



				elseif($active_tab1 == "Class_Schedule")



				{



					$class_id=MJ_gmgt_get_current_user_classis($member_id);



					



					$class_data=$obj_class->MJ_gmgt_get_all_classes_by_member($class_id);



					if(!empty($class_data))



					{



						?>



						<script type="text/javascript">



							jQuery(document).ready(function($) 



							{



								"use strict";



								$('#class_list').DataTable({



									// "responsive": true,



									"aoColumns":[



													{"bSortable": false},



													{"bSortable": true},



													{"bSortable": true},



													{"bSortable": true},



													{"bSortable": true},



													{"bSortable": true},



													{"bSortable": false}],



										dom: '<"float-right"f>rt<"row"<"col-sm-1"l><"col-sm-8"i><"col-sm-3"p>>',



										language:<?php echo MJ_gmgt_datatable_multi_language();?>



								});



								$('.dataTables_filter input').attr("placeholder", "<?php esc_html_e('Search...', 'gym_mgt') ?>");



								$('.dataTables_filter').addClass('search_btn_view_page');



							} );



						</script>



						<div class="table-div"><!-- PANEL BODY DIV START -->



							<div class="table-responsive"><!-- TABLE RESPONSIVE DIV START -->



								<table id="class_list" class="display" cellspacing="0" width="100%">



									<thead class="<?php echo MJ_gmgt_datatable_heder(); ?>">



										<tr>

											<th><?php esc_html_e('Photo','gym_mgt');?></th>



											<th><?php esc_html_e('Class Name','gym_mgt');?></th>



											<th><?php esc_html_e('Staff Name','gym_mgt');?></th>



											<th><?php esc_html_e('Start Time','gym_mgt');?></th>



											<th><?php esc_html_e('End Time','gym_mgt');?></th>



											<th><?php esc_html_e('Day','gym_mgt');?></th>



											<th class="text_align_end"><?php esc_html_e('Action','gym_mgt');?></th>



										</tr>



									</thead>

									<tbody>



										<?php



										$i=0;	



								



										if(!empty($class_data))



										{



											foreach ($class_data as $retrieved_data)



											{	



												if($i == 10)



												{



													$i=0;



												}



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



												elseif($i == 5)



												{



													$color_class='smgt_class_color5';







												}



												elseif($i == 6)



												{



													$color_class='smgt_class_color6';







												}



												elseif($i == 7)



												{



													$color_class='smgt_class_color7';







												}



												elseif($i == 8)



												{



													$color_class='smgt_class_color8';







												}



												elseif($i == 9)



												{



													$color_class='smgt_class_color9';







												}



												?>



												<tr>



													<td class="cursor_pointer user_image width_50px profile_image_prescription padding_left_0">



														<p class="remainder_title_pr Bold prescription_tag <?php echo $color_class; ?>">	



															<img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/Class Schedule.png"?>" alt="" class="massage_image center">



														</p>



													</td>







													



													<td class="classname">	



														<a href="#"><?php echo esc_html($retrieved_data->class_name);?></a>



														<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Class Name','gym_mgt');?>" ></i>



													</td>



													



													<td class="staff">



														<?php $userdata=get_userdata( $retrieved_data->staff_id);echo esc_html($userdata->display_name);?>



														<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Staff Name','gym_mgt');?>" ></i>



													</td>



													



													<td class="starttime">



														<?php echo MJ_gmgt_timeremovecolonbefoream_pm(esc_html($retrieved_data->start_time));?>



														<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Start Time','gym_mgt');?>" ></i>



													</td>



													



													<td class="endtime">



														<?php echo MJ_gmgt_timeremovecolonbefoream_pm(esc_html($retrieved_data->end_time));?>



														<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('End Time','gym_mgt');?>" ></i>



													</td>



													



													<td class="day">



														<?php $days_array=json_decode($retrieved_data->day);



														$days_string=array();



														if(!empty($days_array))



														{



															foreach($days_array as $day)



															{



																$days_class_schedule=substr($day,0,3);



																$days_string[]=__($days_class_schedule,'gym_mgt');



															}



														}



														echo implode(", ",$days_string);



														?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Day','gym_mgt');?>" ></i>



													</td>



													<td class="action"> 



														<div class="gmgt-user-dropdown">



															<ul class="" style="margin-bottom: 0px !important;">



																<li class="">



																	<a class="" href="#" data-bs-toggle="dropdown" aria-expanded="false">



																		<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/More.png"?>" >



																	</a>



																	<ul class="dropdown-menu heder-dropdown-menu action_dropdawn" aria-labelledby="dropdownMenuLink">



																		<li class="float_left_width_100">



																			<a href="#" class="view_details_popup float_left_width_100" id="<?php echo esc_attr($retrieved_data->class_id)?>" type="<?php echo 'view_class';?>"><i class="fa fa-eye"> </i><?php esc_html_e('View', 'gym_mgt' ) ;?> </a>	



																		</li>



																		<?php 



																		if($user_access['edit']=='1')



																		{



																			if(isset($_REQUEST['class_list_app']) && $_REQUEST['class_list_app'] == 'classlist_app')



																			{



																				?>



																				<li class="float_left_width_100 border_bottom_item">



																					<a href="?dashboard=user&page=class-schedule&tab=addclass&action=edit&class_list_app=classlist_app&page_action=web_view_hide&class_id=<?php echo esc_attr	($retrieved_data->class_id) ?>" class="float_left_width_100"><i class="fa fa-edit"></i> <?php esc_html_e('Edit', 'gym_mgt' ) ;?></a>



																				</li>



																				<?php



																			}



																			else



																			{



																				?>



																				<li class="float_left_width_100 border_bottom_item">



																					<a href="?dashboard=user&page=class-schedule&tab=addclass&action=edit&class_id=<?php echo esc_attr	($retrieved_data->class_id) ?>" class="float_left_width_100"><i class="fa fa-edit"></i> <?php esc_html_e('Edit', 'gym_mgt' ) ;?></a>



																				</li>



																				<?php



																			}



																		}



																		if($user_access['delete']=='1')



																		{



																			if(isset($_REQUEST['class_list_app']) && $_REQUEST['class_list_app'] == 'classlist_app')



																			{



																				?>		



																				<li class="float_left_width_100">



																					<a href="?dashboard=user&page=class-schedule&tab=classlist&action=delete&class_list_app=classlist_app&page_action=web_view_hide&class_id=<?php echo esc_attr($retrieved_data->class_id);?>" class="float_left_width_100 list_delete_btn" onclick="return confirm('<?php esc_html_e('Are you sure you want to delete this record?','gym_mgt');?>');"><i class="fa fa-trash"></i> <?php esc_html_e( 'Delete', 'gym_mgt' ) ;?> </a>



																				<?php



																			}



																			else



																			{



																				?>		



																				<li class="float_left_width_100">



																					<a href="?dashboard=user&page=class-schedule&tab=classlist&action=delete&class_id=<?php echo esc_attr($retrieved_data->class_id);?>" class="float_left_width_100 list_delete_btn" onclick="return confirm('<?php esc_html_e('Are you sure you want to delete this record?','gym_mgt');?>');"><i class="fa fa-trash"></i> <?php esc_html_e( 'Delete', 'gym_mgt' ) ;?> </a>



																				</li>



																				<?php



																			}



																		} ?>



																	</ul>



																</li>



															</ul>



														</div>	



													</td>



												</tr>



												<?php 



												$i++;	



											}	 



										}



										?>



									</tbody>



								</table>



							</div><!-- TABLE RESPONSIVE DIV END -->



						</div>



						<?php



					}



					else



					{



						if($user_access['add']=='1')



						{



							?>



							<div class="no_data_list_div"> 



								<a href="<?php echo home_url().'?dashboard=user&page=class-schedule&tab=addclass&&action=insert';?>">



									<img class="width_100px" src="<?php echo get_option( 'gmgt_no_data_img' ) ?>" >



								</a>



								<div class="col-md-12 dashboard_btn margin_top_20px">



									<label class="no_data_list_label"><?php esc_html_e('Tap on above icon to add your first Record.','gym_mgt'); ?> </label>



								</div> 



							</div>		



							<?php



						}



						else



						{



							?>



							<div class="calendar-event-new"> 



								<img class="no_data_img" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/no_data_img.png"?>" >



							</div>



							<?php



						}



					}



				}







				// Booking-List tab start 



				elseif($active_tab1 == "Booking")



				{

					$bookingdata=$obj_class->MJ_gmgt_get_member_book_class($member_id);



					if(!empty($bookingdata))



					{



						?>



					



						<script type="text/javascript">



							jQuery(document).ready(function($) 



							{



								"use strict";



								$('#booking_list').DataTable({



									// "responsive": true,



									"aoColumns":[



													{"bSortable": false},



													{"bSortable": true},



													{"bSortable": true},



													{"bSortable": true},



													{"bSortable": true},



													{"bSortable": true},



													{"bSortable": true},



													{"bSortable": false}],



										dom: '<"float-right"f>rt<"row"<"col-sm-1"l><"col-sm-8"i><"col-sm-3"p>>',



										language:<?php echo MJ_gmgt_datatable_multi_language();?>



								});



								$('.dataTables_filter input').attr("placeholder", "<?php esc_html_e('Search...', 'gym_mgt') ?>");



								$('.dataTables_filter').addClass('search_btn_view_page');



							} );



						</script>



						<div class="table-div"><!-- PANEL BODY DIV START -->



							<div class="table-responsive"><!-- TABLE RESPONSIVE DIV START -->



								<table id="booking_list" class="display" cellspacing="0" width="100%">

								

								   <thead class="<?php echo MJ_gmgt_datatable_heder(); ?>">



										<tr>



											<th><?php esc_html_e('Photo','gym_mgt');?></th>



											<th><?php esc_html_e('Member Name', 'gym_mgt' ) ;?></th>



											<th><?php esc_html_e('Class Name', 'gym_mgt' ) ;?></th>



											<th><?php esc_html_e('Class Date', 'gym_mgt' ) ;?></th>



											<th><?php esc_html_e('Booking Date', 'gym_mgt' ) ;?></th>



											<th><?php esc_html_e('Day', 'gym_mgt' ) ;?></th>



											<th><?php esc_html_e('Start Time', 'gym_mgt' ) ;?></th>



											<th><?php esc_html_e('End Time', 'gym_mgt' ) ;?></th>            



										</tr>



										</thead>



									<tbody>



										<?php



										$i=0;	



								



										if(!empty($bookingdata))



										{



											foreach ($bookingdata as $retrieved_data)



											{	



												if($i == 10)



												{



													$i=0;



												}



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



												elseif($i == 5)



												{



													$color_class='smgt_class_color5';







												}



												elseif($i == 6)



												{



													$color_class='smgt_class_color6';







												}



												elseif($i == 7)



												{



													$color_class='smgt_class_color7';







												}



												elseif($i == 8)



												{



													$color_class='smgt_class_color8';







												}



												elseif($i == 9)



												{



													$color_class='smgt_class_color9';







												}



												?>



												<tr>



													<td class="cursor_pointer user_image width_50px profile_image_prescription padding_left_0">



														<p class="remainder_title_pr Bold prescription_tag <?php echo $color_class; ?>">	



															<img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/Class Schedule.png"?>" alt="" class="massage_image center">



														</p>



													</td>







													<td class="membername">



														<?php echo MJ_gmgt_get_member_full_display_name_with_memberid(esc_html($retrieved_data->member_id));?>



														<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Member Name','gym_mgt');?>" ></i>



													</td> 



													<td class="class_name">



														<?php echo $obj_class->MJ_gmgt_get_class_name(esc_html($retrieved_data->class_id));?>



														<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Class Name','gym_mgt');?>" ></i>



													</td> 



													<td class="class_name">



														<?php echo MJ_gmgt_getdate_in_input_box($retrieved_data->class_booking_date);?>



														<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Class Date','gym_mgt');?>" ></i>



													</td>



													<td class="class_name">



														<?php echo MJ_gmgt_getdate_in_input_box($retrieved_data->booking_date);?>



														<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Booking Date','gym_mgt');?>" ></i>



													</td>



													<td class="starttime">



														<?php 



															if($retrieved_data->booking_day == "Sunday")



															{



																$booking_day=esc_html__('Sunday','gym_mgt');



															}



															elseif($retrieved_data->booking_day == "Monday")



															{



																$booking_day=esc_html__('Monday','gym_mgt');



															}



															elseif($retrieved_data->booking_day == "Tuesday")



															{



																$booking_day=esc_html__('Tuesday','gym_mgt');



															}



															elseif($retrieved_data->booking_day == "Wednesday")



															{



																$booking_day=esc_html__('Wednesday','gym_mgt');



															}



															elseif($retrieved_data->booking_day == "Thursday")



															{



																$booking_day=esc_html__('Thursday','gym_mgt');



															}



															elseif($retrieved_data->booking_day == "Friday")



															{



																$booking_day=esc_html__('Friday','gym_mgt');



															}



															elseif($retrieved_data->booking_day == "Saturday")



															{



																$booking_day=esc_html__('Saturday','gym_mgt');



															}



															echo $booking_day;



														?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Day','gym_mgt');?>" ></i>



													</td>



													<?php $class_data = $obj_class->MJ_gmgt_get_single_class($retrieved_data->class_id); ?>



													<td class="starttime">



														<?php echo MJ_gmgt_timeremovecolonbefoream_pm(esc_html($class_data->start_time));?>



														<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Start Time','gym_mgt');?>" ></i>



													</td>



													<td class="endtime">



														<?php echo MJ_gmgt_timeremovecolonbefoream_pm(esc_html($class_data->end_time));?>



														<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('End Time','gym_mgt');?>" ></i>									



													</td>



												</tr>



												<?php 



												$i++;	



											}	 



										}



										?>



									</tbody>



								</table>



							</div><!-- TABLE RESPONSIVE DIV END -->



						</div>



						<?php



					}



					else



					{



						?>



						 <div class="calendar-event-new"> 



							<img class="no_data_img" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/no_data_img.png"?>" >



						</div>



						<?php



					}



				}







				// Attendance tab start 



				elseif($active_tab1 == "Attendance")



				{



					?>



					<script type="text/javascript">



						$(document).ready(function() 



						{



							"use strict";	



							$('.sdate').datepicker({maxDate : 0,dateFormat: '<?php echo get_option('gmgt_datepicker_format');?>'}); 



							$('.edate').datepicker({maxDate : 0,dateFormat: '<?php echo get_option('gmgt_datepicker_format');?>'}); 



						} );



					</script>



					



					<form method="post" id="attendance_list"  class="attendance_list">  

						<div class="form-body user_form margin_top_15px">

							<div class="row">

								<div class="col-md-3 mb-3 input">

									<label class="ml-1 custom-top-label top" for="class_id"><?php esc_attr_e('Date','gym_mgt');?><span class="require-field">*</span></label>			

										<select class="line_height_30px form-control date_type validate[required]" name="date_type" autocomplete="off">

								

											<option value="today"><?php esc_attr_e('Today','gym_mgt');?></option>

											<option value="this_week"><?php esc_attr_e('This Week','gym_mgt');?></option>

											<option value="last_week"><?php esc_attr_e('Last Week','gym_mgt');?></option>

											<option value="this_month" selected><?php esc_attr_e('This Month','gym_mgt');?></option>

											<option value="last_month"><?php esc_attr_e('Last Month','gym_mgt');?></option>

											<option value="last_3_month"><?php esc_attr_e('Last 3 Months','gym_mgt');?></option>

											<option value="last_6_month"><?php esc_attr_e('Last 6 Months','gym_mgt');?></option>

											<option value="last_12_month"><?php esc_attr_e('Last 12 Months','gym_mgt');?></option>

											<option value="this_year"><?php esc_attr_e('This Year','gym_mgt');?></option>

											<option value="last_year"><?php esc_attr_e('Last Year','gym_mgt');?></option>

											<option value="period"><?php esc_attr_e('Period','gym_mgt');?></option>

										</select>

								</div>



								<div id="date_type_div" class="date_type_div_none row col-md-6 mb-2"></div>	



								<div class="col-md-3 mb-2">

									<input type="submit" name="view_attendance" Value="<?php esc_attr_e('Go','gym_mgt');?>"  class="btn btn-info save_btn"/>

								</div>

							</div>

						</div>

					</form>



					<div class="clearfix"></div>



					<?php



					//  DATA



						



					if(isset($_REQUEST['view_attendance']))



					{



						$date_type = $_POST['date_type'];



						$member_id = $_REQUEST['member_id'];



						if($date_type=="period")

						{

							$start_date = $_REQUEST['start_date'];

							$end_date = $_REQUEST['end_date'];

							

						}

						else

						{

							$result =  mj_gmgt_all_date_type_value($date_type);

					

							$response =  json_decode($result);

							$start_date = $response[0];

							$end_date = $response[1];

							

						}

					}else{

						$start_date = date('Y-m-d',strtotime('first day of this month'));



						$end_date = date('Y-m-d',strtotime('last day of this month'));



						

					}

					$attendence_data = MJ_gmgt_get_all_member_attendence_beetween_satrt_date_to_enddate_user_id($start_date,$end_date,$member_id);





					if($start_date > $end_date )



					{



						echo '<script type="text/javascript">alert("'.esc_html__('End Date should be greater than the Start Date','gym_mgt').'");</script>';



					}



					if(!empty($attendence_data))



					{



						?>



						<script type="text/javascript">



							jQuery(document).ready(function($) 



							{



								"use strict";



								var table = $('#tax_list').DataTable({



									// "responsive": true,



									buttons:[

										{

											extend: 'csv',

											text:'<?php esc_html_e('CSV', 'gym_mgt') ?>',

											title: 'Attendance Report',

											exportOptions: {

												columns: [1, 2, 3,4,5,6,7], // Only name, email and role

											},

											charset: 'UTF-8',

											bom: true,

										},

										{

											extend: 'print',

											text:'<?php esc_html_e('Print', 'gym_mgt') ?>',

											title: 'Attendance Report',

											exportOptions: {

												columns: [1, 2, 3,4,5,6,7], // Only name, email and role

											}

										},

									],



									"aoColumns":[



													{"bSortable": false},



													{"bSortable": true},



													{"bSortable": true},



													{"bSortable": true},



													{"bSortable": true},



													{"bSortable": false}],



										// dom: '<"float-right"f>rt<"row"<"col-sm-1"l><"col-sm-8"i><"col-sm-3"p>>',



										dom: 'lifrtp',



										language:<?php echo MJ_gmgt_datatable_multi_language();?>



								});

								$('.btn-place').html(table.buttons().container());

								$('.dataTables_filter input').attr("placeholder", "<?php esc_html_e('Search...', 'gym_mgt') ?>");



								// $('.dataTables_filter').addClass('search_btn_view_page');



							} );



						</script>



						



						<div class="table-div"><!-- PANEL BODY DIV START -->



							<div class="table-responsive"><!-- TABLE RESPONSIVE DIV START -->

							<div class="btn-place"></div>

								<table id="tax_list" class="display" cellspacing="0" width="100%">

									<thead class="<?php echo MJ_gmgt_datatable_heder(); ?>">

										<tr>

											<th><?php esc_html_e('Photo','gym_mgt');?></th>

											<th><?php esc_html_e('Class Name','gym_mgt');?></th>

											<th><?php esc_html_e('Date','gym_mgt');?></th>

											<th><?php esc_html_e('Day','gym_mgt');?></th>

											<th><?php esc_html_e('Attendance Status','gym_mgt');?></th>

											<th><?php esc_html_e('Attendance With QR','gym_mgt');?></th>	

										</tr>

									</thead>

									<tbody>



										<?php



										$i=0;	



										if(!empty($attendence_data))



										{



											foreach ($attendence_data as $retrieved_data)



											{



												$member_data = get_userdata($retrieved_data->user_id);



												if($i == 10)



												{



													$i=0;



												}



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



												elseif($i == 5)



												{



													$color_class='smgt_class_color5';







												}



												elseif($i == 6)



												{



													$color_class='smgt_class_color6';







												}



												elseif($i == 7)



												{



													$color_class='smgt_class_color7';







												}



												elseif($i == 8)



												{



													$color_class='smgt_class_color8';







												}



												elseif($i == 9)



												{



													$color_class='smgt_class_color9';







												}



												?>



												<tr>



													<td class="cursor_pointer user_image width_50px profile_image_prescription padding_left_0">



														<p class="remainder_title_pr Bold prescription_tag <?php echo $color_class; ?>">	



															<img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/Attendance.png"?>" alt="" class="massage_image center">



														</p>



													</td>



													<td class="name">



														<?php echo MJ_gmgt_get_class_name($retrieved_data->class_id); ?>



														<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Class Name','gym_mgt');?>" ></i>



													</td>



													<td class="name">



														<?php echo MJ_gmgt_getdate_in_input_box($retrieved_data->attendence_date); ?>



														<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Date','gym_mgt');?>" ></i>



													</td>



													<td class="name">



														<?php 



															$day=date("D", strtotime($retrieved_data->attendence_date));



															echo esc_html__($day,"gym_mgt");



														?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Day','gym_mgt');?>" ></i>



													</td>



													<td class="name">



														<?php echo esc_html__($retrieved_data->status,"gym_mgt"); ?>



														<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Attendance Status','gym_mgt');?>" ></i>



													</td>

													<td class="name">



														<?php if($retrieved_data->attendance_type == 'QR') { echo _e('Yes','gym_mgt');}elseif($retrieved_data->attendance_type == 'web' || $retrieved_data->attendance_type == NULL){ echo esc_html__('No',"gym_mgt"); }?>



														<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Attendance With QR','gym_mgt');?>" ></i>



													</td>



												</tr>



												<?php 



												$i++;



											}



										}



										?>



									</tbody>



								</table>



							</div><!-- TABLE RESPONSIVE DIV END -->



						</div>



						<?php



					}



					else



					{



						?>



						<div class="calendar-event-new"> 



							<img class="no_data_img" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/no_data_img.png"?>" >



						</div>



						<?php



					}



					



					?>







					<?php



				}







				// Member Reports  tab start 



				elseif($active_tab1 == "Member_Reports")



				{



					?>



					<div class="panel-body padding_0 float_left_width_100 reports_design"><!-- PANEL BODY DIV START-->



						<div class="clear"></div>



						<div class="col-md-6 col-sm-6 col-xs-12 border float_left float_left_width_100_ipad">



							<span class="report_title">



								<span class="fa-stack cutomcircle">



									<i class="fa fa-line-chart fa-stack-1x"></i>



								</span> 



								<span class="shiptitle"><?php esc_html_e('Weight','gym_mgt');?></span>	







								<?php 



								if(isset($_REQUEST['page_action']) && $_REQUEST['page_action'] == 'web_view_hide')



								{



								?>



									<a href="?dashboard=user&page=workouts&tab=addmeasurement&&action=insert&&page_action=web_view_hide&workout_list_app_view=workoutlist_app&user_id=<?php echo esc_attr($_REQUEST['member_id']);?>&result_measurment=Weight" 



									class="btn btn-danger right"> <?php esc_html_e('Add Weight','gym_mgt');?></a>



								<?php



								}



								else



								{



									?>



									<a href="?dashboard=user&page=workouts&tab=addmeasurement&&action=insert&&user_id=<?php echo esc_attr($_REQUEST['member_id']);?>&result_measurment=Weight" 



									class="btn btn-danger right"> <?php esc_html_e('Add Weight','gym_mgt');?></a>



									<?php



								}



								?>



								<!-- <a href="?dashboard=user&page=workouts&tab=addmeasurement&&action=insert&&user_id=<?php echo esc_attr($_REQUEST['member_id']);?>&result_measurment=Weight" 



								class="btn btn-danger right"> <?php esc_html_e('Add Weight','gym_mgt');?></a>	 -->



							</span>



							<?php 



							$weight_data = $obj_gyme->MJ_gmgt_get_weight_report('Weight',$_REQUEST['member_id']);



							$option =  $obj_gyme->MJ_gmgt_report_option('Weight');



							require_once GMS_PLUGIN_DIR. '/lib/chart/GoogleCharts.class.php';



							$GoogleCharts = new GoogleCharts;		



							$wait_chart = $GoogleCharts->load( 'LineChart' , 'weight_report' )->get( $weight_data , $option );		



							?>



							<div id="weight_report" class="width_100 height_250">



								<?php 



									if(empty($weight_data) || count($weight_data) == 1)



									esc_html_e('There is not enough data to generate report','gym_mgt')



								?>



							</div>   



							<script type="text/javascript" src="https://www.google.com/jsapi"></script> 



							<script type="text/javascript">



								<?php 



								if(!empty($weight_data) && count($weight_data) > 1)



								echo $wait_chart;?>



							</script>



						</div>



						<div class="col-md-6  col-sm-6  col-xs-12 border borderleft float_left">



							<span class="report_title">



								<span class="fa-stack cutomcircle">



									<i class="fa fa-line-chart fa-stack-1x"></i>



								</span> 



								<span class="shiptitle"><?php esc_html_e('Waist Report','gym_mgt');?></span>



										



								<?php 



								if(isset($_REQUEST['page_action']) && $_REQUEST['page_action'] == 'web_view_hide')



								{



								?>



									<a href="?dashboard=user&page=workouts&tab=addmeasurement&&action=insert&&page_action=web_view_hide&workout_list_app_view=workoutlist_app&user_id=<?php echo esc_attr($_REQUEST['member_id']);?>&result_measurment=Waist" 



									class="btn btn-danger right"> <?php esc_html_e('Add Waist','gym_mgt');?></a>



								<?php



								}



								else



								{



									?>



									<a href="?dashboard=user&page=workouts&tab=addmeasurement&&action=insert&&user_id=<?php echo esc_attr($_REQUEST['member_id']);?>&result_measurment=Waist" 



									class="btn btn-danger right"> <?php esc_html_e('Add Waist','gym_mgt');?></a>



									<?php



								}



								?>







							</span>



							<?php 



							$waist_chart = $obj_gyme->MJ_gmgt_get_weight_report('Waist',$_REQUEST['member_id']);



							$option =  $obj_gyme->MJ_gmgt_report_option('Waist');



							$GoogleCharts = new GoogleCharts;		



							$waist_chartreport = $GoogleCharts->load( 'LineChart' , 'waist_report' )->get( $waist_chart , $option );



							?>



							<div id="waist_report" class="width_100 height_250">



							<?php 



							if(empty($waist_chart) || count($waist_chart) == 1)



							esc_html_e('There is not enough data to generate report','gym_mgt')?>



							</div>   



							<script type="text/javascript">



								<?php 



								if(!empty($waist_chart) && count($waist_chart) > 1)



								echo $waist_chartreport;?>



							</script>



						</div>



						<div class="col-md-6  col-sm-6  col-xs-12 border float_left float_left_width_100_ipad">



							<span class="report_title">



								<span class="fa-stack cutomcircle">



									<i class="fa fa-line-chart fa-stack-1x"></i>



								</span> 



								<span class="shiptitle"><?php esc_html_e('Height Report','gym_mgt');?></span>	



								<?php 



								if(isset($_REQUEST['page_action']) && $_REQUEST['page_action'] == 'web_view_hide')



								{



								?>



									<a href="?dashboard=user&page=workouts&tab=addmeasurement&&action=insert&&page_action=web_view_hide&workout_list_app_view=workoutlist_app&user_id=<?php echo esc_attr($_REQUEST['member_id']);?>&result_measurment=Height" 



									class="btn btn-danger right"> <?php esc_html_e('Add Height','gym_mgt');?></a>



								<?php



								}



								else



								{



									?>



									<a href="?dashboard=user&page=workouts&tab=addmeasurement&&action=insert&&user_id=<?php echo esc_attr($_REQUEST['member_id']);?>&result_measurment=Height" 



									class="btn btn-danger right"> <?php esc_html_e('Add Height','gym_mgt');?></a>



									<?php



								}



								?>



								<!-- <a href="?dashboard=user&page=workouts&tab=addmeasurement&&action=insert&&user_id=<?php echo esc_attr($_REQUEST['member_id']);?>&result_measurment=Height" 



								class="btn btn-danger right"> <?php esc_html_e('Add Height','gym_mgt');?></a>	 -->



							</span>



							<?php 



							$height_data = $obj_gyme->MJ_gmgt_get_weight_report('Height',$_REQUEST['member_id']);



							$option =  $obj_gyme->MJ_gmgt_report_option('Height');



							$GoogleCharts = new GoogleCharts;		



							$height_chart = $GoogleCharts->load( 'LineChart' , 'height_reort' )->get( $height_data , $option );		



							?>



							<div id="height_reort" class="width_100 height_250">



							<?php if(empty($height_data) || count($height_data) == 1)



							esc_html_e('There is not enough data to generate report','gym_mgt')?>



							</div>   



							<script type="text/javascript" src="https://www.google.com/jsapi"></script> 



							<script type="text/javascript">



								<?php 



								if(!empty($height_data) && count($height_data) > 1)



								echo $height_chart;?>



							</script>



						</div>



						<div class="col-md-6  col-sm-6  col-xs-12 border borderleft float_left">



							<span class="report_title">



								<span class="fa-stack cutomcircle">



									<i class="fa fa-line-chart fa-stack-1x"></i>



								</span> 



								<span class="shiptitle"><?php esc_html_e('Chest Report','gym_mgt');?></span>	



								<!-- <a href="?dashboard=user&page=workouts&tab=addmeasurement&&action=insert&&user_id=<?php echo esc_attr($_REQUEST['member_id']);?>&result_measurment=Chest" 



								class="btn btn-danger right"> <?php esc_html_e('Add Chest','gym_mgt');?></a>	 -->



								<?php 



								if(isset($_REQUEST['page_action']) && $_REQUEST['page_action'] == 'web_view_hide')



								{



								?>



									<a href="?dashboard=user&page=workouts&tab=addmeasurement&&action=insert&&page_action=web_view_hide&workout_list_app_view=workoutlist_app&user_id=<?php echo esc_attr($_REQUEST['member_id']);?>&result_measurment=Chest" 



									class="btn btn-danger right"> <?php esc_html_e('Add Chest','gym_mgt');?></a>



								<?php



								}



								else



								{



									?>



									<a href="?dashboard=user&page=workouts&tab=addmeasurement&&action=insert&&user_id=<?php echo esc_attr($_REQUEST['member_id']);?>&result_measurment=Weight" 



									class="btn btn-danger right"> <?php esc_html_e('Add Weight','gym_mgt');?></a>



									<?php



								}



								?>



							</span>



							<?php 



							$chest_data = $obj_gyme->MJ_gmgt_get_weight_report('Chest',$_REQUEST['member_id']);



							$option =  $obj_gyme->MJ_gmgt_report_option('Chest');



							require_once GMS_PLUGIN_DIR. '/lib/chart/GoogleCharts.class.php';



							$GoogleCharts = new GoogleCharts;		



							$chest_chart = $GoogleCharts->load( 'LineChart' , 'chest_reort' )->get( $chest_data , $option );



							?>



							<div id="chest_reort" class="width_100 height_250">



							<?php if(empty($chest_data) || count($chest_data) == 1)



							esc_html_e('There is not enough data to generate report','gym_mgt')?>



							</div>   



							<script type="text/javascript" src="https://www.google.com/jsapi"></script> 



							<script type="text/javascript">



								<?php 



								if(!empty($chest_data) && count($chest_data) > 1)



								echo $chest_chart;?>



							</script>



						</div>



						<div class="col-md-6  col-sm-6  col-xs-12 border float_left float_left_width_100_ipad">



							<span class="report_title">



								<span class="fa-stack cutomcircle">



									<i class="fa fa-line-chart fa-stack-1x"></i>



								</span> 



								<span class="shiptitle"><?php esc_html_e('Thigh Report','gym_mgt');?></span>	



								<!-- <a href="?dashboard=user&page=workouts&tab=addmeasurement&&action=insert&user_id=<?php echo esc_attr($_REQUEST['member_id']);?>&result_measurment=Thigh" 



								class="btn btn-danger right"> <?php esc_html_e('Add Thigh','gym_mgt');?></a>	 -->



								<?php 



								if(isset($_REQUEST['page_action']) && $_REQUEST['page_action'] == 'web_view_hide')



								{



								?>



									<a href="?dashboard=user&page=workouts&tab=addmeasurement&&action=insert&&page_action=web_view_hide&workout_list_app_view=workoutlist_app&user_id=<?php echo esc_attr($_REQUEST['member_id']);?>&result_measurment=Thigh" 



									class="btn btn-danger right"> <?php esc_html_e('Add Thigh','gym_mgt');?></a>



								<?php



								}



								else



								{



									?>



									<a href="?dashboard=user&page=workouts&tab=addmeasurement&&action=insert&&user_id=<?php echo esc_attr($_REQUEST['member_id']);?>&result_measurment=Thigh" 



									class="btn btn-danger right"> <?php esc_html_e('Add Thigh','gym_mgt');?></a>



									<?php



								}



								?>



							</span>



							<?php 



							$thigh_data = $obj_gyme->MJ_gmgt_get_weight_report('Thigh',$_REQUEST['member_id']);



							$option =  $obj_gyme->MJ_gmgt_report_option('Thigh');



							require_once GMS_PLUGIN_DIR. '/lib/chart/GoogleCharts.class.php';



							$GoogleCharts = new GoogleCharts;		



							$thigh_chart = $GoogleCharts->load( 'LineChart' , 'thigh_reort' )->get( $thigh_data , $option );



							?>



							<div id="thigh_reort" class="width_100 height_250">



							<?php if(empty($thigh_data) || count($thigh_data) == 1)



							esc_html_e('There is not enough data to generate report','gym_mgt')?>



							</div>   



							<script type="text/javascript" src="https://www.google.com/jsapi"></script> 



							<script type="text/javascript">



								<?php 



								if(!empty($thigh_data) && count($thigh_data) > 1)



								echo $thigh_chart;?>



							</script>



						</div>



						<div class="col-md-6  col-sm-6  col-xs-12 border borderleft float_left">



							<span class="report_title">



								<span class="fa-stack cutomcircle">



									<i class="fa fa-line-chart fa-stack-1x"></i>



								</span> 



								<span class="shiptitle"><?php esc_html_e('Arms Report','gym_mgt');?></span>	



								<!-- <a href="?dashboard=user&page=workouts&tab=addmeasurement&&action=insert&user_id=<?php echo esc_attr($_REQUEST['member_id']);?>&result_measurment=Arms" 



								class="btn btn-danger right"> <?php esc_html_e('Add Arms','gym_mgt');?></a>	 -->



								<?php 



								if(isset($_REQUEST['page_action']) && $_REQUEST['page_action'] == 'web_view_hide')



								{



								?>



									<a href="?dashboard=user&page=workouts&tab=addmeasurement&&action=insert&&page_action=web_view_hide&workout_list_app_view=workoutlist_app&user_id=<?php echo esc_attr($_REQUEST['member_id']);?>&result_measurment=Arms" 



									class="btn btn-danger right"> <?php esc_html_e('Add Arms','gym_mgt');?></a>



								<?php



								}



								else



								{



									?>



									<a href="?dashboard=user&page=workouts&tab=addmeasurement&&action=insert&&user_id=<?php echo esc_attr($_REQUEST['member_id']);?>&result_measurment=Arms" 



									class="btn btn-danger right"> <?php esc_html_e('Add Arms','gym_mgt');?></a>



									<?php



								}



								?>



							</span>



							<?php 



							$arm_data = $obj_gyme->MJ_gmgt_get_weight_report('Arms',$_REQUEST['member_id']);



							$option =  $obj_gyme->MJ_gmgt_report_option('Arms');



							require_once GMS_PLUGIN_DIR. '/lib/chart/GoogleCharts.class.php';



							$GoogleCharts = new GoogleCharts;		



							$arm_chart = $GoogleCharts->load( 'LineChart' , 'arm_reort' )->get( $arm_data , $option );		



							?>



							<div id="arm_reort" class="width_100 height_250">



							<?php if(empty($arm_data) || count($arm_data) == 1)



							esc_html_e('There is not enough data to generate report','gym_mgt')?>



							</div>   



							<script type="text/javascript" src="https://www.google.com/jsapi"></script> 



							<script type="text/javascript">



								<?php 



								if(!empty($arm_data) && count($arm_data) > 1)



								echo $arm_chart;?>



							</script>



						</div>



						<div class="col-md-6  col-sm-6  col-xs-12 border float_left float_left_width_100_ipad">



							<span class="report_title">



								<span class="fa-stack cutomcircle">



									<i class="fa fa-line-chart fa-stack-1x"></i>



								</span> 



								<span class="shiptitle"><?php esc_html_e('Fat Report','gym_mgt');?></span>	



								<!-- <a href="?dashboard=user&page=workouts&tab=addmeasurement&&action=insert&user_id=<?php echo esc_attr($_REQUEST['member_id']);?>&result_measurment=Fat" 



								class="btn btn-danger right"> <?php esc_html_e('Add Fat','gym_mgt');?></a>	 -->



								<?php 



								if(isset($_REQUEST['page_action']) && $_REQUEST['page_action'] == 'web_view_hide')



								{



								?>



									<a href="?dashboard=user&page=workouts&tab=addmeasurement&&action=insert&&page_action=web_view_hide&workout_list_app_view=workoutlist_app&user_id=<?php echo esc_attr($_REQUEST['member_id']);?>&result_measurment=Fat" 



									class="btn btn-danger right"> <?php esc_html_e('Add Fat','gym_mgt');?></a>



								<?php



								}



								else



								{



									?>



									<a href="?dashboard=user&page=workouts&tab=addmeasurement&&action=insert&&user_id=<?php echo esc_attr($_REQUEST['member_id']);?>&result_measurment=Fat" 



									class="btn btn-danger right"> <?php esc_html_e('Add Fat','gym_mgt');?></a>



									<?php



								}



								?>



							</span>



							<?php 



							$fat_data = $obj_gyme->MJ_gmgt_get_weight_report('Fat',$_REQUEST['member_id']);



							$option =  $obj_gyme->MJ_gmgt_report_option('Fat');



							require_once GMS_PLUGIN_DIR. '/lib/chart/GoogleCharts.class.php';



							$GoogleCharts = new GoogleCharts;		



							$fat_chart = $GoogleCharts->load( 'LineChart' , 'fat_reort' )->get( $fat_data , $option );		



							?>



							<div id="fat_reort" class="width_100 height_250">



							<?php if(empty($fat_data) || count($fat_data) == 1)



							esc_html_e('There is not enough data to generate report','gym_mgt')?>



							</div>   



							



							<script type="text/javascript">



								<?php 



								if(!empty($fat_data) && count($fat_data) > 1)



								echo $fat_chart;?>



							</script>



						</div>



						<div class="col-md-6  col-sm-6  col-xs-12 border borderleft viewmember_image_height float_left" >



							<span class="report_title">



								<span class="fa-stack cutomcircle">



									<i class="fa fa-line-chart fa-stack-1x"></i>



								</span> 



								<span class="shiptitle"><?php esc_html_e('My Photos','gym_mgt');?></span>	



								<!-- <a href="?dashboard=user&page=workouts&tab=addmeasurement&&action=insert&user_id=<?php echo esc_attr($_REQUEST['member_id']);?>&result_measurment=Fat" 



								class="btn btn-danger right"> <?php esc_html_e('Add Photo','gym_mgt');?></a> -->



								<?php 



								if(isset($_REQUEST['page_action']) && $_REQUEST['page_action'] == 'web_view_hide')



								{



								?>



									<a href="?dashboard=user&page=workouts&tab=addmeasurement&&action=insert&&page_action=web_view_hide&workout_list_app_view=workoutlist_app&user_id=<?php echo esc_attr($_REQUEST['member_id']);?>&result_measurment=Fat" 



									class="btn btn-danger right"> <?php esc_html_e('Add Photo','gym_mgt');?></a>



								<?php



								}



								else



								{



									?>



									<a href="?dashboard=user&page=workouts&tab=addmeasurement&&action=insert&&user_id=<?php echo esc_attr($_REQUEST['member_id']);?>&result_measurment=Fat" 



									class="btn btn-danger right"> <?php esc_html_e('Add Photo','gym_mgt');?></a>



									<?php



								}



								?>



								<div id="slider1_container" class="my_photo_slider">



								<!-- Loading Screen -->



								<div u="loading" class="my_photo_slider_loding">



									<div class="my_photo_slider_loding_div">



									</div>



								</div>



								<!-- Slides Container -->



								<div u="slides" class="slides">



								<?php $obj_workout = new MJ_gmgt_workout();



								$user_id=$_REQUEST['member_id'];



								$measurement_data = $obj_workout->MJ_gmgt_get_all_measurement_by_userid($user_id);



								if(!empty($measurement_data))



								{



									foreach ($measurement_data as $retrieved_data)



									{ 



										$userimage=$retrieved_data->gmgt_progress_image;



										if($userimage!=""){ ?>	



										<div>



												<img u="image" src="<?php echo $retrieved_data->gmgt_progress_image;?>"/>



											</div>



										<?php } 



									} 



								} ?>



								</div>



								<!-- bullet navigator container -->



								<div u="navigator" class="jssorb05 bottom_16 right_6">



									<!-- bullet navigator item prototype -->



									<div u="prototype"></div>



								</div>



								<!--#endregion Bullet Navigator Skin End -->



								<!-- Arrow Left -->



								<span u="arrowleft" class="jssora11l top_123 left_8">



								</span>



								<!-- Arrow Right -->



								<span u="arrowright" class="jssora11r top_123 right_8">



								</span>



								<!--#endregion Arrow Navigator Skin End -->



								</div>



							</span>



							<?php ?>



						</div>



					</div><!-- PANEL BODY DIV END-->



					<script>



						jQuery(document).ready(function ($) 



						{



							"use strict";



							var options = {



								$AutoPlay: true,                                    //[Optional] Whether to auto play, to enable slideshow, this option must be set to true, default value is false



								$AutoPlaySteps: 1,                                  //[Optional] Steps to go for each navigation request (this options applys only when slideshow disabled), the default value is 1



								$Idle: 2000,                            //[Optional] Interval (in milliseconds) to go for next slide since the previous stopped if the slider is auto playing, default value is 3000



								$PauseOnHover: 1,                                   //[Optional] Whether to pause when mouse over if a slider is auto playing, 0 no pause, 1 pause for desktop, 2 pause for touch device, 3 pause for desktop and touch device, 4 freeze for desktop, 8 freeze for touch device, 12 freeze for desktop and touch device, default value is 1



								$ArrowKeyNavigation: true,   			            //[Optional] Allows keyboard (arrow key) navigation or not, default value is false



								$SlideEasing: $JssorEasing$.$EaseOutQuint,          //[Optional] Specifies easing for right to left animation, default value is $JssorEasing$.$EaseOutQuad



								$SlideDuration: 800,                                //[Optional] Specifies default duration (swipe) for slide in milliseconds, default value is 500



								$MinDragOffsetToSlide: 20,                          //[Optional] Minimum drag offset to trigger slide , default value is 20



								$SlideSpacing: 0, 					                //[Optional] Space between each slide in pixels, default value is 0



								$Cols: 1,                                  //[Optional] Number of pieces to display (the slideshow would be disabled if the value is set to greater than 1), the default value is 1



								$ParkingPosition: 0,                                //[Optional] The offset position to park slide (this options applys only when slideshow disabled), default value is 0.



								$UISearchMode: 1,                                   //[Optional] The way (0 parellel, 1 recursive, default value is 1) to search UI components (slides container, loading screen, navigator container, arrow navigator container, thumbnail navigator container etc).



								$PlayOrientation: 1,                                //[Optional] Orientation to play slide (for auto play, navigation), 1 horizental, 2 vertical, 5 horizental reverse, 6 vertical reverse, default value is 1



								$DragOrientation: 1,                                //[Optional] Orientation to drag slide, 0 no drag, 1 horizental, 2 vertical, 3 either, default value is 1 (Note that the $DragOrientation should be the same as $PlayOrientation when $Cols is greater than 1, or parking position is not 0)



								$ArrowNavigatorOptions: {                           //[Optional] Options to specify and enable arrow navigator or not



									$Class: $JssorArrowNavigator$,                  //[Requried] Class to create arrow navigator instance



									$ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always



									$AutoCenter: 2,                                 //[Optional] Auto center arrows in parent container, 0 No, 1 Horizontal, 2 Vertical, 3 Both, default value is 0



									$Steps: 1,                                      //[Optional] Steps to go for each navigation request, default value is 1



									$Scale: false                                   //Scales bullets navigator or not while slider scale



								},



								$BulletNavigatorOptions: {                                //[Optional] Options to specify and enable navigator or not



									$Class: $JssorBulletNavigator$,                       //[Required] Class to create navigator instance



									$ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always



									$AutoCenter: 1,                                 //[Optional] Auto center navigator in parent container, 0 None, 1 Horizontal, 2 Vertical, 3 Both, default value is 0



									$Steps: 1,                                      //[Optional] Steps to go for each navigation request, default value is 1



									$Rows: 1,                                      //[Optional] Specify lanes to arrange items, default value is 1



									$SpacingX: 12,                                   //[Optional] Horizontal space between each item in pixel, default value is 0



									$SpacingY: 4,                                   //[Optional] Vertical space between each item in pixel, default value is 0



									$Orientation: 1,                                //[Optional] The orientation of the navigator, 1 horizontal, 2 vertical, default value is 1



									$Scale: false                                   //Scales bullets navigator or not while slider scale



								}



							};



							var jssor_slider1 = new $JssorSlider$("slider1_container", options);



							//responsive code begin



							//you can remove responsive code if you don't want the slider scales while window resizing



							function ScaleSlider() {



								var parentWidth = jssor_slider1.$Elmt.parentNode.clientWidth;



								if (parentWidth) {



									jssor_slider1.$ScaleWidth(parentWidth - 30);



								}



								else



									window.setTimeout(ScaleSlider, 30);



							}



							ScaleSlider();



							$(window).bind("load", ScaleSlider);



							$(window).bind("resize", ScaleSlider);



							$(window).bind("orientationchange", ScaleSlider);



							//responsive code end



						});



					</script>	



					<?php



				}



				



				// Membership History tab start 



				elseif($active_tab1 == "Subscription")



				{



					$obj_membership_payment=new MJ_gmgt_membership_payment;



					$paymentdata=$obj_membership_payment->MJ_gmgt_get_member_subscription_history($member_id);



					



					if(!empty($paymentdata))



					{



						?>



					



						<script type="text/javascript">



							jQuery(document).ready(function($) 



							{



								"use strict";



								$('#feespayment_list_detailpage').DataTable({



									// "responsive": true,



									"aoColumns":[



													{"bSortable": false},



													{"bSortable": true},



													{"bSortable": true},



													{"bSortable": true},



													{"bSortable": true},



													{"bSortable": true},



													{"bSortable": true},



													{"bSortable": false}],



										dom: '<"float-right"f>rt<"row"<"col-sm-1"l><"col-sm-8"i><"col-sm-3"p>>',



										language:<?php echo MJ_gmgt_datatable_multi_language();?>



								});



								$('.dataTables_filter input').attr("placeholder", "<?php esc_html_e('Search...', 'gym_mgt') ?>");



								$('.dataTables_filter').addClass('search_btn_view_page');



							} );



						</script>



						<div class="table-div"><!-- PANEL BODY DIV START -->



							<div class="table-responsive"><!-- TABLE RESPONSIVE DIV START -->



								<table id="feespayment_list_detailpage" class="display" cellspacing="0" width="100%">

								

									<thead class="<?php echo MJ_gmgt_datatable_heder(); ?>">

										<tr>

											<th><?php esc_html_e('Photo','gym_mgt');?></th>

											<th><?php esc_html_e('Membership Title','gym_mgt');?></th>

											<th><?php esc_html_e('Total Amount','gym_mgt');?></th>

											<th><?php esc_html_e('Paid Amount','gym_mgt');?></th>

											<th><?php esc_html_e('Due Amount','gym_mgt');?></th>

											<th><?php esc_html_e('Membership start date','gym_mgt');?></th>

											<th><?php esc_html_e('Membership End Date','gym_mgt');?></th>

											<th><?php esc_html_e('Payment Status','gym_mgt');?></th>

										</tr>

									</thead>



									<tbody>



										<?php



										$i=0;	



								



										if(!empty($paymentdata))



										{



										   foreach ($paymentdata as $retrieved_data)



										   {	



												if($i == 10)



												{



													$i=0;



												}



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



												elseif($i == 5)



												{



													$color_class='smgt_class_color5';







												}



												elseif($i == 6)



												{



													$color_class='smgt_class_color6';







												}



												elseif($i == 7)



												{



													$color_class='smgt_class_color7';







												}



												elseif($i == 8)



												{



													$color_class='smgt_class_color8';







												}



												elseif($i == 9)



												{



													$color_class='smgt_class_color9';







												}



												?>



												<tr>



													<td class="cursor_pointer user_image width_50px profile_image_prescription padding_left_0">



														<p class="remainder_title_pr Bold prescription_tag <?php echo $color_class; ?>">	



															<img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/Payment.png"?>" alt="" class="massage_image center">



														</p>



													</td>







													<td class="productname">



														<?php echo MJ_gmgt_get_membership_name(esc_html($retrieved_data->membership_id));?>



														<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Membership Title','gym_mgt');?>" ></i>



													</td>



													<td class="totalamount">



														<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?> <?php echo esc_html($retrieved_data->membership_amount);?>



														<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Total Amount','gym_mgt');?>" ></i>



													</td>



													<td class="paid_amount">



														<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?> <?php echo esc_html($retrieved_data->paid_amount);?>



														<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Paid Amount','gym_mgt');?>" ></i>



													</td>



													<td class="totalamount">



														<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?> <?php echo esc_html($retrieved_data->membership_amount-$retrieved_data->paid_amount);?>



														<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Due Amount','gym_mgt');?>" ></i>



													</td>



													<td class="paymentdate">



														<?php echo MJ_gmgt_getdate_in_input_box($retrieved_data->start_date);?>



														<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Membership Start Date','gym_mgt');?>" ></i>



													</td>



													<td class="paymentdate">



														<?php echo MJ_gmgt_getdate_in_input_box($retrieved_data->end_date);?>



														<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Membership End Date','gym_mgt');?>" ></i>



													</td>



													<td class="paymentdate tab_view_membership ">



														<?php 



															// echo "<span class='btn gmgt_unpaid btn-xs'>";								



															// esc_html_e(MJ_gmgt_get_membership_paymentstatus($retrieved_data->mp_id), 'gym_mgt' );



															// echo "</span>";



															$memberhsip_status=MJ_gmgt_get_membership_paymentstatus($retrieved_data->mp_id);	



															



															if($memberhsip_status == 'Unpaid')



															{



																echo "<span class='gmgt_unpaid btn-xs'>";



															}elseif($memberhsip_status == 'Partially Paid')



															{



																echo "<span class='gmgt_Partially btn-xs'>";



															}



															else



															{



																echo "<span class='gmgt_paid btn-xs'>";



															}													 



																echo esc_html__($memberhsip_status,'gym_mgt' );



															echo "</span>"; 



														?>



														<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Payment Status','gym_mgt');?>" ></i>



													</td>							



												</tr>



												<?php 



												$i++;	



											}	 



										}



										?>



									</tbody>



								</table>



							</div><!-- TABLE RESPONSIVE DIV END -->



						</div>



						<?php



					}



					else



					{



						if($user_access['add']=='1')



						{



							?>



							<div class="no_data_list_div"> 



								<a href="<?php echo home_url().'?dashboard=user&page=membership_payment&tab=addpayment&&action=insert';?>">



									<img class="width_100px" src="<?php echo get_option( 'gmgt_no_data_img' ) ?>" >



								</a>



								<div class="col-md-12 dashboard_btn margin_top_20px">



									<label class="no_data_list_label"><?php esc_html_e('Tap on above icon to add your first Record.','gym_mgt'); ?> </label>



								</div> 



							</div>		



							<?php



						}



						else



						{



							?>



							<div class="calendar-event-new"> 



								<img class="no_data_img" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/no_data_img.png"?>" >



							</div>



							<?php



						}



					}



				}



				?>



			</div><!-- END PANEL BODY DIV-->



		</section>



		<!-- Detail Page Body Content Section End -->



	</div><!-- End PANEL BODY DIV-->

	

</div><!-- END CONTENT-BODY-->