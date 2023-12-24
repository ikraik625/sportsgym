<?php 



 $active_tab1 = isset($_REQUEST['tab1'])?$_REQUEST['tab1']:'general';



$obj_gyme = new MJ_gmgt_Gym_management(); 



$accountant_id=0;



$edit=0;	



if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'view')



{	



	$accountant_id=esc_attr($_REQUEST['accountant_id']);			



	$edit=1;



	$user_info = get_userdata($accountant_id);



}



?>	



<div class="panel-body padding_0 view_page_main"><!-- START PANEL BODY DIV-->



	<div class="content-body"><!-- START CONTENT-BODY-->



		<section id="user_information" class="">



			<div class="view_page_header_bg">



				<div class="row">



					<div class="col-xl-10 col-md-9 col-sm-10">



						<div class="user_profile_header_left float_left_width_100">



							<?php 



							if($user_info->gmgt_user_avatar == "") 



							{ ?>



								<img class="user_view_profile_image" alt="" src="<?php echo get_option( 'gmgt_Account_logo' ); ?>">



								<?php 



							} 



							else 



							{ ?>



								<img class="user_view_profile_image" src="<?php if($edit)echo esc_url( $user_info->gmgt_user_avatar ); ?>" />



								<?php 



							}?>



							<div class="row profile_user_name">



								<div class="float_left view_top1">



									<div class="col-xl-12 col-md-12 col-sm-12 float_left_width_100">



										<label class="view_user_name_label">



										<?php echo chunk_split(esc_html(MJ_gmgt_get_user_full_display_name($_REQUEST['accountant_id'])));?> 



										</label>



										<?php



										if($user_access_edit =='1')



										{



											?>



											<div class="view_user_edit_btn">



												<a class="color_white margin_left_2px" href="admin.php?page=gmgt_accountant&tab=add_accountant&action=edit&accountant_id=<?php echo $_REQUEST['accountant_id'] ?>">



												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/edit.png"?>">



												</a>



											</div>



											<?php



										}



										?>



									</div>



									<div class="col-xl-12 col-md-12 col-sm-12 float_left_width_100">



										<div class="view_user_phone float_left_width_100">



											<img class="tele-icon" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/phone_figma.png"?>">&nbsp;+<?php echo MJ_gmgt_get_countery_phonecode(get_option( 'gmgt_contry' ));?>&nbsp;&nbsp;<lable class="color_white_rs"><?php echo esc_html($user_info->mobile);?></label>



										</div>



									</div>



								</div>



							</div>



							<div class="gmgt_address_row row">



								<div class="col-xl-12 col-md-12 col-sm-12">



									<div class="view_top2">



										<div class="gmgt_address_row row view_user_doctor_label">



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



					<div class="col-xl-2 col-lg-3 col-md-3 col-sm-2">



						<div class="group_thumbs">



							<img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Group.png"?>">



						</div>



					</div>



				</div>



			</div>



		</section>







		<!-- Detail Page Body Content Section  -->



		<section id="body_area" class="">



			<div class="panel-body"><!-- START PANEL BODY DIV-->



				<?php 



				// general tab start 



				if($active_tab1 == "general")



				{



					?>



					<div class="row margin_top_15px">



						<div class="col-xl-4 col-md-4 col-sm-12 margin_bottom_10_res">



							<label class="view_page_header_labels"> <?php esc_html_e('Email ID', 'gym_mgt'); ?> </label><br/>



							<label class="view_page_content_labels view_page_email_label"><?php echo chunk_split(esc_html($user_info->user_email),32,"<BR>");?></label>



						</div>



						<div class="col-xl-3 col-md-3 col-sm-12 margin_bottom_10_ress">



							<label class="view_page_header_labels"> <?php esc_html_e('Gender', 'gym_mgt'); ?> </label><br/>



							<label class="view_page_content_labels"> <?php echo esc_html_e(ucfirst($user_info->gender),'gym_mgt'); ?></label>	



						</div>



						<div class="col-xl-3 col-md-3 col-sm-12 margin_bottom_10_res">



							<label class="view_page_header_labels date_of_birth_label"> <?php esc_html_e('Date of Birth', 'gym_mgt'); ?> </label><br/>



							<label class="view_page_content_labels"><?php echo MJ_gmgt_getdate_in_input_box($user_info->birth_date); ?></label>	



						</div>



					</div>



					<!--Contact Information div start -->



					<div class="row margin_top_20px">



						<div class="col-xl-12 col-md-12 col-sm-12">



							<div class="col-xl-12 col-md-12 col-sm-12 margin_top_20px margin_top_15px_rs">



								<div class="guardian_div">



									<label class="view_page_label_heading"> <?php esc_html_e('Contact Information', 'gym_mgt'); ?> </label>



									<div class="row">



										<div class="col-xl-3 col-md-3 col-sm-12 margin_top_15px">



											<label class="guardian_labels view_page_header_labels"> <?php esc_html_e('City', 'gym_mgt'); ?> </label><br>



											<label class="view_page_content_labels"><?php if(!empty($user_info->city_name)){ echo $user_info->city_name; }else{ echo "N/A"; } ?></label>



										</div>



										<div class="col-xl-3 col-md-3 col-sm-12 margin_top_15px">



											<label class="guardian_labels view_page_header_labels"> <?php esc_html_e('Phone', 'gym_mgt'); ?> </label><br>



											<label class="view_page_content_labels"><?php if(!empty($user_info->phone)){ echo $user_info->phone; }else{ echo "N/A"; } ?></label>



										</div>



										<div class="col-xl-6 col-md-6 col-sm-12 margin_top_15px">



											<label class="guardian_labels view_page_header_labels"> <?php esc_html_e('Address', 'gym_mgt'); ?> </label><br>



											<label class="view_page_content_labels">



												<?php



												if($user_info->address != '')



												{



													echo chunk_split(esc_html($user_info->address));



												} 



												else



												{



													echo "N/A";



												}



												?>



											</label>



										</div>



									</div>



								</div>	



							</div>



							



						</div>



					</div>



					<!--Contact Information div End -->



					<?php



				}  ?>



			</div><!-- END PANEL BODY DIV-->



		</section>



		<!-- Detail Page Body Content Section End -->







	</div><!-- End PANEL BODY DIV-->



</div><!--PANEL BODY DIV END-->