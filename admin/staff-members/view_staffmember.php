<?php 



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



<style>



	.right_side {



 		min-height: auto; 



	}



</style>



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



											<?php echo MJ_gmgt_get_user_full_display_name($_REQUEST['staff_member_id']);?>



										</label>



										<?php



										if($user_access_edit =='1')



										{



											?>



											<div class="view_user_edit_btn">



												<a class="color_white margin_left_2px" href="admin.php?page=gmgt_staff&tab=add_staffmember&action=edit&staff_member_id=<?php echo $_REQUEST['staff_member_id'] ?>">



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




		<!-- Detail Page Tabing Start -->



		<section id="body_area" class="">



			<div class="row">



				<div class="col-xl-12 col-md-12 col-sm-12">



					<ul class="nav nav-tabs panel_tabs margin_left_1per" role="tablist">



						<li class="<?php if($active_tab1=='general'){?>active<?php }?>">			



							<a href="admin.php?page=gmgt_staff&tab=view_staffmember&action=view&staff_member_id=<?php echo $_REQUEST['staff_member_id'];?>" class="padding_left_0 tab <?php echo $active_tab1 == 'general' ? 'active' : ''; ?>">



							<?php esc_html_e('GENERAL', 'gym_mgt'); ?></a> 



						</li>



						<li class="<?php if($active_tab1=='Class_Schedule'){?>active<?php }?>">



							<a href="admin.php?page=gmgt_staff&tab=view_staffmember&action=view&tab1=Class_Schedule&staff_member_id=<?php echo $_REQUEST['staff_member_id'];?>" class="padding_left_0 tab <?php echo $active_tab1 == 'Class_Schedule' ? 'active' : ''; ?>">



							<?php esc_html_e('Class Schedule', 'gym_mgt'); ?></a> 



						</li>  



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



					<!-- <div class="popup-bg">



						<div class="overlay-content content_width">



							<div class="modal-content d-modal-style">



								<div class="task_event_list">



								</div>



							</div>



						</div>



					</div> -->



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



							<label class="view_page_header_labels date_of_birth_label"> <?php esc_html_e('Date of Birth', 'gym_mgt'); ?> </label><br/>



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



							<div class="col-xl-12 col-md-12 col-sm-12 responsive_margin_20px">



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



					$staff_member_id = $_REQUEST['staff_member_id'];


					// $user_id = (int)$staff_member_id;



					$class_data=$obj_class->MJ_gmgt_get_all_classes_by_staffmember($staff_member_id);	

				
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



														<a href="?page=gmgt_class&tab=addclass&action=edit&class_id=<?php echo esc_attr($retrieved_data->class_id);?>"><?php echo esc_html($retrieved_data->class_name);?></a>



														<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Class Name','gym_mgt');?>" ></i>



													</td>



													



													<td class="staff">



														<?php $display_name=MJ_gmgt_get_user_full_display_name($retrieved_data->staff_id);echo esc_html($display_name);?>



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



																			<a href="#" class="view_details_popup float_left_width_100" id="<?php echo esc_attr($retrieved_data->class_id)?>" type="<?php echo 'view_class';?>"> <i class="fa fa-eye"></i><?php esc_html_e('View','gym_mgt');?> 



																			</a>



																		</li>



																		<?php if($user_access_edit == '1')



																		{ ?>	



																			<li class="float_left_width_100 border_bottom_item">



																				<a href="?page=gmgt_class&tab=addclass&action=edit&class_id=<?php echo esc_attr($retrieved_data->class_id)?>" class="float_left_width_100"><i class="fa fa-edit"></i> <?php esc_html_e('Edit', 'gym_mgt' ) ;?>



																				</a>



																			</li>



																			<?php



																		}



																		if($user_access_delete =='1')



																		{ ?>



																			<li class="float_left_width_100">



																				<a href="?page=gmgt_class&tab=classlist&action=delete&class_id=<?php echo esc_attr($retrieved_data->class_id);?>" class="float_left_width_100 list_delete_btn" onclick="return confirm('<?php esc_html_e('Are you sure you want to delete this record?','gym_mgt');?>');"><i class="fa fa-trash"></i> <?php esc_html_e( 'Delete', 'gym_mgt' ) ;?> </a>



																			</li>



																			<?php 



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



						?>



						<div class="no_data_list_div"> 



							<a href="<?php echo admin_url().'admin.php?page=gmgt_class&tab=addclass';?>">



								<img class="width_100px" src="<?php echo get_option( 'gmgt_no_data_img' ) ?>" >



							</a>



							<div class="col-md-12 dashboard_btn margin_top_20px">



								<label class="no_data_list_label"><?php esc_html_e('Tap on above icon to add your first Record.','gym_mgt'); ?> </label>



							</div> 



						</div>		



						<?php



					}



				}



				



				?>



			</div><!-- END PANEL BODY DIV-->



		</section>



		<!-- Detail Page Body Content Section End -->







	</div><!-- End PANEL BODY DIV-->



</div><!--PANEL BODY DIV END-->