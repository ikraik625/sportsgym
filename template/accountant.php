<?php



$active_tab=isset($_REQUEST['tab'])?$_REQUEST['tab']:'accountant_list';



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







<div class="panel-body panel-white float_left_width_100 padding_0"><!--PANEL WHITE DIV START-->



	<?php 



	if(isset($_REQUEST['accountant_list_app']) && $_REQUEST['accountant_list_app'] == 'accountantlist_app' || isset($_REQUEST['page_action']) && $_REQUEST['page_action'] == 'web_view_hide')



	{



		?>



		<!-- <ul class="nav nav-tabs panel_tabs" role="tablist">



			<li class="<?php if($active_tab == 'accountant_list') echo "active";?>">



				<a href="?dashboard=user&page=accountant&tab=accountant_list&page_action=web_view_hide&accountant_list_app=accountantlist_app" >



					<i class="fa fa-align-justify"></i> <?php esc_html_e('Accountant List', 'gym_mgt'); ?></a>



				</a>



			</li>		  



			<?php 



			if(isset($_REQUEST['action']) && $_REQUEST['action'] =='view')



			{ ?>



				<li class="<?php if($active_tab == 'view_accountant') echo "active";?>">



					<a href="?dashboard=user&page=accountant&tab=view_accountant&action=view&page_action=web_view_hide&accountant_list_app=accountantlist_app&accountant_id=<?php echo esc_attr($_REQUEST['accountant_id']);?>">



					<i class="fa fa-align-justify"></i> <?php		



					esc_html_e('View Accountant', 'gym_mgt'); 		



					?></a> 



				</li>



				<?php 



			}



			?>		



			</li>



	    </ul> -->



	    <?php



	}



	else



	{



		?>



	  	<!-- <ul class="nav nav-tabs panel_tabs" role="tablist">



			<li class="<?php if($active_tab == 'accountant_list') echo "active";?>">



	          <a href="?dashboard=user&page=accountant&tab=accountant_list">



	             <i class="fa fa-align-justify"></i> <?php esc_html_e('Accountant List', 'gym_mgt'); ?></a>



			</li>



			<?php 



			if(isset($_REQUEST['action']) && $_REQUEST['action'] =='view')



			{ ?>



				<li class="<?php if($active_tab == 'view_accountant') echo "active";?>">



					<a href="?dashboard=user&page=accountant&tab=view_accountant&action=view&accountant_id=<?php echo esc_attr($_REQUEST['accountant_id']);?>">



					<i class="fa fa-align-justify"></i> <?php		



					esc_html_e('View Accountant', 'gym_mgt'); 		



					?></a> 



				</li>



				<?php 



			}



			?>		



	    </ul> -->



		<?php



	}



	if($active_tab == 'accountant_list')



	{



		$get_staff = array('role' => 'accountant');



		$staffdata=get_users($get_staff);



		?>	



		<div class="gms_main_list"><!-- MAIN_LIST_MARGING_15px START -->







			<?php 



			if(!empty($staffdata))



			{ ?>



				<div class="tab-content padding_0"><!--TAB CONTENT DIV START-->



					<script type="text/javascript">



						$(document).ready(function() 



						{



							"use strict";



							jQuery('#accountant_list').DataTable({



								// "responsive": true,



								"order": [[ 1, "asc" ]],



								dom: 'lifrtp',



								"aoColumns":[



										{"bSortable": false},



										{"bSortable": true},



										{"bSortable": true},



										{"bSortable": true},



										{"bSortable": false}],



								language:<?php echo MJ_gmgt_datatable_multi_language();?>		  



							});



							$('.dataTables_filter input').attr("placeholder", "<?php esc_html_e('Search...', 'gym_mgt') ?>");



						} );



					</script>



					<div class="panel-bodypadding_0"><!--PANEL BODY DIV START-->



						<div class="table-responsive"><!--TABLE RESPONSIVE DIV START-->



							<table id="accountant_list" class="display" cellspacing="0" width="100%"><!--Accountant LIST TABLE START-->



								<thead class="<?php echo MJ_gmgt_datatable_heder(); ?>">



									<tr id="height_50">



										<th><?php esc_html_e('Photo','gym_mgt');?></th>



										<th><?php esc_html_e( 'Accountant Name & Email', 'gym_mgt' ) ;?></th>



										<th class="date_of_birth_label"><?php esc_html_e('Date of Birth','gym_mgt');?></th>



										<th> <?php esc_html_e( 'Mobile No.', 'gym_mgt' ) ;?></th>



										<th class="text_align_end"><?php  esc_html_e( 'Action', 'gym_mgt' ) ;?></th>



									</tr>



								</thead>



								<tbody>



									<?php 



									if(!empty($staffdata))



									{



										foreach ($staffdata as $retrieved_data)



										{



											$display_name=MJ_gmgt_get_user_full_display_name($retrieved_data->ID);



											?>



											<tr>



												<td class="user_image width_50px padding_left_0">



													<?php 



														$uid=$retrieved_data->ID;



														$userimage=get_user_meta($uid, 'gmgt_user_avatar', true);



														if(empty($userimage))



														{



															echo '<img src='.get_option( 'gmgt_Account_logo' ).' height="50px" width="50px" class="img-circle" />';



														}



														else



														{



															echo '<img src='.$userimage.' height="50px" width="50px" class="img-circle"/>';



														}	



													?>



												</td>



												<td class="name">



													<a class="color_black" href="?dashboard=user&page=accountant&tab=view_accountant&action=view&accountant_id=<?php echo esc_attr($retrieved_data->ID)?>">



														<?php echo esc_html($display_name);?>



													</a>



													<br>



													<label class="list_page_email">



														<?php echo $retrieved_data->user_email;?>



													</label>



												</td>



												<td class="birth_date">



													<?php echo MJ_gmgt_getdate_in_input_box($retrieved_data->birth_date); ?>



													<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Date of Birth','gym_mgt');?>" ></i>



												</td>



												



												<td class="mobile">



													+<?php echo MJ_gmgt_get_countery_phonecode(get_option( 'gmgt_contry' ));?>



													<?php echo esc_html($retrieved_data->mobile);?>



													<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Mobile No.','gym_mgt');?>" ></i>



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



																	if(isset($_REQUEST['accountant_list_app']) && $_REQUEST['accountant_list_app'] == 'accountantlist_app')



																	{



																		?>



																		<li class="float_left_width_100">



																			<a href="?dashboard=user&page=accountant&tab=view_accountant&action=view&accountant_id=<?php echo esc_attr($retrieved_data->ID)?>&page_action=web_view_hide&accountant_list_app=accountantlist_app"  class="float_left_width_100"><i class="fa fa-eye"></i><?php esc_html_e('View','gym_mgt');?></a>



																		</li>



																	<?php



																	}



																	else



																	{



																		?>



																		<li class="float_left_width_100">



																			<a href="?dashboard=user&page=accountant&tab=view_accountant&action=view&accountant_id=<?php echo esc_attr($retrieved_data->ID)?>"  class="float_left_width_100"><i class="fa fa-eye"></i><?php esc_html_e('View','gym_mgt');?></a>



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



									}?>



								</tbody>



							</table><!--Accountant LIST TABLE END-->



						</div><!--TABLE RESPONSIVE DIV END-->



					</div><!--PANEL BODY DIV END-->



				</div><!--TAB CONTENT DIV END-->



				<?php 



			}



			elsemember_type



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



	if($active_tab == 'view_accountant')



	{



		$active_tab1 = isset($_REQUEST['tab1'])?$_REQUEST['tab1']:'general';



		$obj_gyme = new MJ_gmgt_Gym_management(); 



		$accountant_id=0;



		if(isset($_REQUEST['accountant_id']))



			$accountant_id=esc_attr($_REQUEST['accountant_id']);



			$edit=0;					



			$edit=1;



			$user_info = get_userdata($accountant_id);		



			



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



													<?php echo chunk_split(esc_html($user_info->first_name)." ".esc_html($user_info->last_name),24,"<BR>");?> 



													</label>



													<!-- <div class="view_user_edit_btn">



														<a class="color_white margin_left_2px" href="admin.php?page=gmgt_accountant&tab=add_accountant&action=edit&accountant_id=<?php echo $_REQUEST['accountant_id'] ?>">



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



		



		



		<!-- <div class="panel-body float_left_width_100">



			<div class="member_view_row1">



				<div class="col-md-8 col-sm-12 membr_left float_left">



					<div class="col-md-3 col-sm-12 left_side float_left">



					<?php 



					if($user_info->gmgt_user_avatar == "") { ?>



						<img alt="" src="<?php echo get_option( 'gmgt_system_logo' ); ?>">



					<?php } 



					else { ?>



						<img class="max_width_100" src="<?php if($edit)echo esc_url( $user_info->gmgt_user_avatar ); ?>" />



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



								<span class="txt_color"><?php echo chunk_split(esc_html($user_info->user_email),24,"<BR>");?></span>



							</div>



						</div>



						<div class="table_row">



							<div class="col-md-5 col-sm-12 table_td float_left">



							<i class="fa fa-phone"></i>



							<?php esc_html_e('Mobile No','gym_mgt');?> 



							</div>



							<div class="col-md-7 col-sm-12 table_td float_left">



								<span class="txt_color">



									<span class="txt_color"><?php echo esc_html(esc_html($user_info->mobile));?> </span>



								</span>



							</div>



						</div>



						<div class="table_row">



							<div class="col-md-5 col-sm-12 table_td float_left">



								<i class="fa fa-calendar"></i>



								<?php esc_html_e('Date Of Birth','gym_mgt');?>	



							</div>



							<div class="col-md-7 col-sm-12 table_td float_left">



								<span class="txt_color"><?php echo esc_html(MJ_gmgt_getdate_in_input_box($user_info->birth_date));?></span>



							</div>



						</div>



						<div class="table_row">



							<div class="col-md-5 col-sm-12 table_td float_left">



								<i class="fa fa-mars"></i>



								<?php esc_html_e('Gender','gym_mgt');?> 



							</div>



							<div class="col-md-7 col-sm-12 table_td float_left">



								<span class="txt_color"><?php echo esc_html__(ucfirst($user_info->gender),"gym_mgt");?></span>



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



							<span class="txt_color padding_right_5"><?php 



								 if($user_info->address != '')



								 {



									echo chunk_split(esc_html($user_info->address).",<BR>",15);



								 }



								 



								if($user_info->city_name != '')



								{



									echo chunk_split(esc_html($user_info->city_name).",<BR>",15);



								}



								 ?>



							</span>



						</div>



					</div>



				</div>



			</div>



		</div> -->



		<?php



	}



	?>	



</div>