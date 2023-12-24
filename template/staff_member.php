<?php



$active_tab=isset($_REQUEST['tab'])?$_REQUEST['tab']:'staff_member_list';



//access right



$user_access=MJ_gmgt_get_userrole_wise_page_access_right_array();



if (isset ( $_REQUEST ['page'] ))



{	



	if($user_access['view']=='0')



	{	



		MJ_gmgt_access_right_page_not_access_message();



		die;



	}



}



?>







<div class="panel-body panel-white float_left_width_100 padding_0"><!--PANEL BODY DIV START -->



	<?php



	if($active_tab == 'staff_member_list')



	{



		?>



		<div class="gms_main_list"><!-- MAIN_LIST_MARGING_15px START -->



			<?php



			if($obj_gym->role == 'member')



			{	



				if($user_access['own_data']=='1')



				{



					$user_id=get_current_user_id();



					$staff_id = get_user_meta( $user_id,'staff_id', true ); 



					$staffdata=array();



					$staffdata[] = get_userdata($staff_id);	



				}



				else



				{



					$get_staff = array('role' => 'Staff_member');



					$staffdata=get_users($get_staff);



				}	



			}



			elseif($obj_gym->role == 'staff_member')



			{

				

				if($user_access['own_data']=='1')



				{



					$staff_id=get_current_user_id();



					$staffdata=array();



					$staffdata[] = get_userdata($staff_id);



				}



				else



				{



					$get_staff = array('role' => 'Staff_member');



					$staffdata=get_users($get_staff);



				}



			}	



			else



			{



				$get_staff = array('role' => 'Staff_member');



				$staffdata=get_users($get_staff);



			}



			if(!empty($staffdata))



			{



				?>



				<div class="tab-content padding_0"><!--TAB CONTENT DIV START -->



					<script type="text/javascript">



						$(document).ready(function() 



						{



							"use strict";



							jQuery('#staffmember_list').DataTable({



								// "responsive": true,



								"order": [[ 1, "asc" ]],



								dom: 'lifrtp',



								"aoColumns":[



											{"bSortable": false},



											{"bSortable": true},



											// {"bSortable": true},



											{"bSortable": true},



											{"bSortable": true},



											{"bSortable": true},



											{"bSortable": false}],



											language:<?php echo MJ_gmgt_datatable_multi_language();?>	  



								});



								$('.dataTables_filter input').attr("placeholder", "<?php esc_html_e('Search...', 'gym_mgt') ?>");



						} );



					</script>



					<div class="panel-body padding_0"><!--PANEL BODY DIV START -->



						<div class="table-responsive"><!--TABLE RESPONSIVE DIV START -->



							<table id="staffmember_list" class="display" cellspacing="0" width="100%"><!--Staff MEMBER LIST TABLE START -->



							<thead class="<?php echo MJ_gmgt_datatable_heder(); ?>">

								<tr>

								<th><?php esc_html_e('Photo','gym_mgt');?></th>

									<th><?php esc_html_e( 'Staff Member Name & Email', 'gym_mgt' ) ;?></th>

									<th><?php esc_html_e( 'Assign Role', 'gym_mgt' ) ;?></th>

									<th><?php esc_html_e( 'Mobile No.', 'gym_mgt' ) ;?></th>

									<th><?php esc_html_e( 'Specialization', 'gym_mgt' ) ;?></th>

									<th class="text_align_end"><?php esc_html_e( 'Action', 'gym_mgt' ) ;?></th>

								</tr>

							</thead>

							

								<tbody>



									<?php



									if(!empty($staffdata))



									{



										foreach ($staffdata as $retrieved_data)



										{



											?>



											<tr>



												<td class="user_image width_50px padding_left_0">



													<?php 



													$uid=$retrieved_data->ID;



													$userimage=get_user_meta($uid, 'gmgt_user_avatar', true);



													if(empty($userimage))



													{



														echo '<img src='.get_option( 'gmgt_Staffmember_logo' ).' id="width_50" class="height_50 img-circle" />';

													}



													else



														echo '<img src='.$userimage.' height="50px" width="50px" class="img-circle"/>';



												?>



												</td>

												

												<td class="name">



													<a class="color_black" href="<?php if(isset($_REQUEST['staff_member_app']) && isset($_REQUEST['staff_member_app'])== 'staff_lsit_app'){ echo "?dashboard=user&page=staff_member&tab=view_staffmember&action=view&staff_member_id=".$retrieved_data->ID."&page_action=web_view_hide "; } else { echo "?dashboard=user&page=staff_member&tab=view_staffmember&action=view&staff_member_id=".$retrieved_data->ID; } ?>">



														<?php echo esc_html(MJ_gmgt_get_user_full_display_name($retrieved_data->ID));?>



													</a><br>



													<label class="list_page_email"><?php echo $retrieved_data->user_email;?></label>



												</td>



												<td class="department">



													<?php 



													$postdata=array();



													if($retrieved_data->role_type!="")



														$postdata=get_post($retrieved_data->role_type);



													if(!empty($postdata))



														echo esc_html($postdata->post_title);



													?> 	<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Assign Role','gym_mgt');?>" ></i>



												</td>



												<td class="mobile">



													+<?php echo MJ_gmgt_get_countery_phonecode(get_option( 'gmgt_contry' ));?><?php echo esc_html($retrieved_data->mobile);?>



													<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Mobile No.','gym_mgt');?>" ></i>



												</td>



												<?php



												$specilization_array=explode(',',$retrieved_data->activity_category);



												$specilization_name_array=array();



												



												if(!empty($specilization_array))



												{



													foreach ($specilization_array as $data)



													{



														$specilization_name_array[]=get_the_title($data);



													}	



												}



												?>



												<td class="">



													<?php echo implode(',',$specilization_name_array); ?>



													<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Specialization','gym_mgt');?>" ></i>



												</td>



												<td class="action"> 



													<div class="gmgt-user-dropdown">



														<ul class="" style="margin-bottom: 0px !important;">



															<li class="">



																<a class="" href="#" data-bs-toggle="dropdown" aria-expanded="false">



																	<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/More.png"?>" >



																</a>



																<ul class="dropdown-menu heder-dropdown-menu action_dropdawn" aria-labelledby="dropdownMenuLink">



													



																	<?php



																	if(isset($_REQUEST['staff_member_app']) && isset($_REQUEST['staff_member_app'])== 'staff_lsit_app')



																	{



																		?>		



																		<li class="float_left_width_100">						



																			<a href="?dashboard=user&page=staff_member&tab=view_staffmember&action=view&staff_member_id=<?php echo esc_attr($retrieved_data->ID)?>&page_action=web_view_hide" class="float_left_width_100"><i class="fa fa-eye"></i> <?php esc_html_e('View', 'gym_mgt' ) ;?></a>	



																		</li>



																		<?php



																	}



																	else



																	{



																		?>



																		<li class="float_left_width_100">



																			<a href="?dashboard=user&page=staff_member&tab=view_staffmember&action=view&staff_member_id=<?php echo esc_attr($retrieved_data->ID)?>" class="float_left_width_100"><i class="fa fa-eye"></i> <?php esc_html_e('View', 'gym_mgt' ) ;?></a>



																		</li>



																		<?php



																	}



																	?>	







																</ul>



															</li>



														</ul>



													</div>	



												</td>



											</tr>



											<?php 



										}



									}



									?>



								</tbody>



							</table><!--Staff MEMBER LIST TABLE END -->



						</div><!--TABLE RESPONSIVE DIV END -->



					</div><!--PANEL BODY DIV END -->



				</div><!--TAB CONTENT DIV END -->



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



		</div><!--MAIN_LIST_MARGING_15px END  -->



		<?php



	}



	if($active_tab == 'view_staffmember')



	{



		$active_tab1 = isset($_REQUEST['tab1'])?$_REQUEST['tab1']:'general';



		$obj_gyme = new MJ_gmgt_Gym_management(); 



		$obj_activity = new MJ_gmgt_activity(); 



		$obj_class=new MJ_gmgt_classschedule;



		$staff_member_id=0;



		if(isset($_REQUEST['staff_member_id']))



			$staff_member_id=esc_attr($_REQUEST['staff_member_id']);



			$edit=0;	



			$edit=1;



			$user_info = get_userdata($staff_member_id);		



			



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



										<img class="user_view_profile_image" alt="" src="<?php echo get_option( 'gmgt_Staffmember_logo' ); ?>">



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



													<?php echo chunk_split(MJ_gmgt_get_user_full_display_name($_REQUEST['staff_member_id']),24,"<BR>");?>



												</label>



												<!-- <div class="view_user_edit_btn">



													<a class="color_white margin_left_2px" href="?dashboard=user&page=staff_member&tab=add_staffmember&action=edit&staff_member_id=<?php echo $_REQUEST['staff_member_id'] ?>">



													<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/edit.png"?>">



													</a>



												</div> -->



											</div>



											<div class="col-xl-12 col-md-12 col-sm-12 float_left_width_100">



												<div class="view_user_phone float_left_width_100">



													<img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/phone_figma.png"?>">&nbsp;+<?php echo MJ_gmgt_get_countery_phonecode(get_option( 'gmgt_contry' ));?>&nbsp;&nbsp;<lable class="color_white_rs"><?php echo esc_html($user_info->mobile);?></label>



												</div>



											</div>



										</div>



									</div>



									<div class="gmgt_address_row row">



										<div class="col-xl-12 col-md-12 col-sm-12">



											<div class="gmgt_res_view_top view_top2">



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



							<div class="col-xl-2 col-lg-3 col-md-3 col-sm-2">



								<div class="group_thumbs">



									<img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Group.png"?>">



								</div>



							</div>



						</div>



					</div>



				</section>







				<!-- Detail Page Tabing Start -->



				<section id="body_area" class="">



					<div class="row">



						<div class="col-xl-12 col-md-12 col-sm-12">



							<ul class="nav nav-tabs panel_tabs margin_left_1per" role="tablist">

								<?php

								if(isset($_REQUEST['page_action'])== 'web_view_hide')

								{

									?>

									<li class="<?php if($active_tab1=='general'){?>active<?php }?>">			



										<a href="?dashboard=user&page=staff_member&tab=view_staffmember&page_action=web_view_hide&action=view&staff_member_id=<?php echo $_REQUEST['staff_member_id'];?>" class="padding_left_0 tab <?php echo $active_tab1 == 'general' ? 'active' : ''; ?>">



										<?php esc_html_e('GENERAL', 'gym_mgt'); ?></a> 



									</li>

									<li class="<?php if($active_tab1=='Class_Schedule'){?>active<?php }?>">



										<a href="?dashboard=user&page=staff_member&tab=view_staffmember&action=view&tab1=Class_Schedule&page_action=web_view_hide&staff_member_id=<?php echo $_REQUEST['staff_member_id'];?>" class="padding_left_0 tab <?php echo $active_tab1 == 'Class_Schedule' ? 'active' : ''; ?>">



										<?php esc_html_e('Class Schedule', 'gym_mgt'); ?></a> 



									</li>  

									<?php

								}

								else

								{

									?>

									<li class="<?php if($active_tab1=='general'){?>active<?php }?>">			



										<a href="?dashboard=user&page=staff_member&tab=view_staffmember&action=view&staff_member_id=<?php echo $_REQUEST['staff_member_id'];?>" class="padding_left_0 tab <?php echo $active_tab1 == 'general' ? 'active' : ''; ?>">



										<?php esc_html_e('GENERAL', 'gym_mgt'); ?></a> 



									</li>

									<li class="<?php if($active_tab1=='Class_Schedule'){?>active<?php }?>">



										<a href="?dashboard=user&page=staff_member&tab=view_staffmember&action=view&tab1=Class_Schedule&staff_member_id=<?php echo $_REQUEST['staff_member_id'];?>" class="padding_left_0 tab <?php echo $active_tab1 == 'Class_Schedule' ? 'active' : ''; ?>">



										<?php esc_html_e('Class Schedule', 'gym_mgt'); ?></a> 



									</li>  

									<?php

								}

								?>



								



							</ul>



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



									<label class="view_page_header_labels"> <?php esc_html_e('Email ID', 'gym_mgt'); ?> </label><br/>



									<label class="view_page_content_labels view_page_email_label"><?php echo chunk_split(esc_html($user_info->user_email),32,"<BR>");?></label>



								</div>



								<div class="col-xl-3 col-md-3 col-sm-12 margin_bottom_10_ress">



									<label class="view_page_header_labels"> <?php esc_html_e('Gender', 'gym_mgt'); ?> </label><br/>



									<label class="view_page_content_labels"> <?php echo esc_html_e(ucfirst($user_info->gender),'gym_mgt'); ?></label>	



								</div>



								<div class="col-xl-3 col-md-3 col-sm-12 margin_bottom_10_res">



									<label class="view_page_header_labels"> <?php esc_html_e('Date of Birth', 'gym_mgt'); ?> </label><br/>



									<label class="view_page_content_labels"><?php echo MJ_gmgt_getdate_in_input_box($user_info->birth_date); ?></label>	



								</div>



								<div class="col-xl-3 col-md-3 col-sm-12 margin_bottom_10_res">



									<label class="view_page_header_labels"> <?php esc_html_e('Assign Role', 'gym_mgt'); ?> </label><br>



									<label class="view_page_content_labels">



										<?php



										if(!empty($user_info->role_type))



										{ 



											echo chunk_split(get_the_title(esc_html($user_info->role_type)),25,"<BR>");  



										}



										else



										{ 



											echo "N/A"; 



										} 



										//echo chunk_split(get_the_title(esc_html($user_info->role_type)),25,"<BR>");



										?>



									</label>



								</div>



							</div>







							<!--All Information div start  -->



							<div class="row margin_top_20px">



								<div class="col-xl-12 col-md-12 col-sm-12">



									<!-- Specialization Information div start  -->



									<div class="col-xl-12 col-md-12 col-sm-12 margin_top_20px">



										<div class="guardian_div">


member_type
											<label class="view_page_label_heading"> <?php esc_html_e('Specialization Information', 'gym_mgt'); ?> </label>



											<div class="row">



												<div class="col-xl-12 col-md-12 col-sm-12 margin_top_15px">



													<label class="guardian_labels view_page_header_labels"> <?php esc_html_e('Specialization', 'gym_mgt'); ?> </label><br>



													<label class="view_page_content_labels">



														<?php 



															$specilization_array=explode(',',$user_info->activity_category);



															



															$specilization_name_array=array();



															if(!empty($user_info->activity_category))



															{



																foreach ($specilization_array as $data)



																{



																	$specilization_name_array[]=get_the_title($data);



																}



																echo implode(', ',$specilization_name_array); 



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



									<!--Specialization Information div End  -->







									<!-- Contact Information div start  -->



									<div class="col-xl-12 col-md-12 col-sm-12 margin_top_20px res_margin_top_15px">



										<div class="guardian_div">



											<label class="view_page_label_heading"> <?php esc_html_e('Contact Information', 'gym_mgt'); ?> </label>



											<div class="row">



												<div class="col-xl-3 col-md-3 col-sm-12 margin_top_15px">



													<label class="guardian_labels view_page_header_labels"> <?php esc_html_e('City', 'gym_mgt'); ?> </label><br>



													<label class="view_page_content_labels">



														<?php 



														if(!empty($user_info->city_name))



														{ 



															echo $user_info->city_name; 



														}



														else



														{ 



															echo "N/A"; 



														} 



														?>



													</label>



												</div>



												<div class="col-xl-3 col-md-3 col-sm-12 margin_top_15px">



													<label class="guardian_labels view_page_header_labels"> <?php esc_html_e('State', 'gym_mgt'); ?> </label><br>



													<label class="view_page_content_labels">



														<?php 



														if(!empty($user_info->state_name))



														{ 



															echo $user_info->state_name; 



														}



														else



														{ 



															echo "N/A"; 



														} ?>



													</label>



												</div>



												



												<div class="col-xl-3 col-md-3 col-sm-12 address_rs_css margin_top_15px">



													<label class="guardian_labels view_page_header_labels"> <?php esc_html_e('Zip code', 'gym_mgt'); ?> </label><br>



													<label class="view_page_content_labels">



														<?php



														if(!empty($user_info->zip_code))



														{ 



															echo $user_info->zip_code;  



														}



														else



														{ 



															echo "N/A"; 



														} 



														?>



													</label>



												</div>



												<div class="col-xl-3 col-md-3 col-sm-12 margin_top_15px">



													<label class="guardian_labels view_page_header_labels"> <?php esc_html_e('Phone', 'gym_mgt'); ?> </label><br>



													<label class="ftext_style_capitalization view_page_content_labels"><?php if(!empty($user_info->phone)){ echo $user_info->phone; }else{ echo "N/A"; } ?></label>



												</div>



												



											</div>



										</div>	



									</div>



									<!--Contact Information div End  -->



								</div>



								



							</div>



							<!-- All Information div End  -->







							<?php



						}



						



						// Class Schedule tab start 



						elseif($active_tab1 == "Class_Schedule")



						{



							$staff_member_id = esc_attr($_REQUEST['staff_member_id']);



							$class_data=$obj_class->MJ_gmgt_get_all_classes_by_staffmember($staff_member_id);	



							if(!empty($class_data))



							{



								?>



								<!-- POP up code -->



								<div class="popup-bg z_index_100000">



									<div class="overlay-content">



										<div class="modal-content">



										<div class="category_list"></div>



										</div>



									</div> 



								</div>







								<!-- End POP-UP Code -->



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



																<p class="remainder_title_pr Bold prescription_tag <?php echo $color_class; ?> margin_left_12px">	



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



																		//$days_string[]=substr($day,0,3);



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



								$class_schedule='class-schedule';



								$class_schedule=MJ_gmgt_get_userrole_wise_manually_page_access_right_array($class_schedule);



								if($class_schedule['add'] == 1)



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



						



						?>



					</div><!-- END PANEL BODY DIV-->



				</section>



				<!-- Detail Page Body Content Section End -->







			</div><!-- End PANEL BODY DIV-->



		</div><!--PANEL BODY DIV END-->











			



		<!-- <div class="panel-body float_left_width_100">



			<div class="member_view_row1">



				<div class="col-md-8 col-sm-12 membr_left float_left">



					<div class="col-md-3 col-sm-12 left_side float_left">



					<?php 



					if($user_info->gmgt_user_avatar == "") { ?>



						<img alt="" src="<?php echo get_option( 'gmgt_system_logo' ); ?>">



					<?php } 



					else { ?>



						<img class="width_100" src="<?php if($edit)echo esc_url( $user_info->gmgt_user_avatar ); ?>" />



					<?php }	?>



					</div>



					<div class="col-md-9 col-sm-12 float_left">



						<div class="table_row">



							<div class="col-md-5 col-sm-12 table_td float_left">



								<i class="fa fa-user"></i> 



								<?php esc_html_e('Name','gym_mgt'); ?>	



							</div>



							<div class="col-md-7 col-sm-12 table_td float_left">



								<span class="txt_color">



									<?php echo chunk_split(esc_html($user_info->first_name)." ".esc_html($user_info->middle_name)." ".esc_html($user_info->last_name),24,"<BR>");?> 



								</span>



							</div>



						</div>



						<div class="table_row">



							<div class="col-md-5 col-sm-12 table_td float_left">



								<i class="fa fa-envelope"></i> 



								<?php esc_html_e('Email','gym_mgt');?> 	



							</div>



							<div class="col-md-7 col-sm-12 table_td float_left">



								<span class="txt_color"><?php echo chunk_split($user_info->user_email,24,"<BR>");?></span>



							</div>



						</div>



						<div class="table_row">



							<div class="col-md-5 col-sm-12 table_td float_left">



							<i class="fa fa-phone"></i>



							<?php esc_html_e('Mobile No','gym_mgt');?> 



							</div>



							<div class="col-md-7 col-sm-12 table_td float_left">



								<span class="txt_color">



									<span class="txt_color"><?php echo esc_html($user_info->mobile);?> </span>



								</span>



							</div>



						</div>



						<div class="table_row">



							<div class="col-md-5 col-sm-12 table_td float_left">



								<i class="fa fa-calendar"></i>



								<?php esc_html_e('Date Of Birth','gym_mgt');?>	



							</div>



							<div class="col-md-7 col-sm-12 table_td float_left">



								<span class="txt_color"><?php echo MJ_gmgt_getdate_in_input_box(esc_html($user_info->birth_date));?></span>



							</div>



						</div>



						<div class="table_row">



							<div class="col-md-5 col-sm-12 table_td float_left">



								<i class="fa fa-mars"></i>



								<?php esc_html_e('Gender','gym_mgt');?> 



							</div>



							<div class="col-md-7 col-sm-12 table_td float_left">



								<span class="txt_color"><?php 



								



								if($user_info->gender == "male")



								{



									echo esc_html_e('Male','gym_mgt');



								}



								else



								{



									echo esc_html_e('Female','gym_mgt');



								}



								



								?></span>



							</div>



						</div>



						<div class="table_row">



							<div class="col-md-5 col-sm-12 table_td float_left">



								<i class="fa fa-user"></i>



								<?php esc_html_e('User Name','gym_mgt');?>



							</div>



							<div class="col-md-7 col-sm-12 table_td float_left">



								<span class="txt_color"><?php echo chunk_split(esc_html($user_info->user_login),25,"<BR>");?> </span>



							</div>



						</div>	



					</div>



				</div>



				<div class="col-md-4 col-sm-12 member_right float_left">	



					<span class="report_title">



						<span class="fa-stack cutomcircle">



							<i class="fa fa-align-left fa-stack-1x"></i>



						</span> 



						<span class="shiptitle"><?php esc_html_e('More Info','gym_mgt');?></span>		



					</span>



					<div class="table_row">



						<div class="col-md-6 col-sm-12 table_td float_left">



							<i class="fa fa-map-marker padding_right_15"></i>						



							<?php esc_html_e('Address','gym_mgt');?>



						</div>



						<div class="col-md-6 col-sm-12 table_td float_left">



							<span class="txt_color"><?php 



								 if($user_info->address != '')



								 {



									echo chunk_split(esc_html($user_info->address).",</br>",15);



								 }



								 



								if($user_info->city_name != '')



								{



									echo chunk_split(esc_html($user_info->city_name)."</br>",15);



								}



								?>



							</span>



						</div>



					</div>



					<div class="table_row">



						<div class="col-md-6 col-sm-12 table_td float_left">



							<i class="fa fa-map-marker padding_right_15"></i>



							<?php esc_html_e('Activity','gym_mgt');?>



						</div>



						<div class="col-md-6 col-sm-12 table_td float_left">



							<span class="txt_color">



							<?php 



								$activity_array=$obj_activity->MJ_gmgt_get_activity_staffmemberwise($user_info->ID);



								$class_name="-";



								$class_name_string="";



								if($activity_array)



								{												



									foreach($activity_array as $key=>$activity_id)



									{



									  echo chunk_split(esc_html($activity_id),24,"<BR>");



									}



								}						



								else



								{



									echo chunk_split(esc_html($class_name),20,"<BR>");



								}



							?>



							</span>



						</div>



					</div>



						



					<div class="table_row">



						<div class="col-md-6 col-sm-12 table_td float_left">



							<i class="fa fa-map-marker padding_right_15"></i>



							<?php esc_html_e('Assign Role','gym_mgt');?>



						</div>



						



						<div class="col-md-6 col-sm-12 table_td float_left">



							<span class="txt_color"><?php echo chunk_split(get_the_title(esc_html($user_info->role_type)),25,"<BR>");?> </span>



						</div>



					</div>



				</div>



			</div>



		</div> -->



		<?php	



	}



	?>	



</div><!--PANEL BODY DIV END -->