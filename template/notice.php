<?php 



$curr_user_id=get_current_user_id();



$obj_gym=new MJ_gmgt_Gym_management($curr_user_id);



$obj_class=new MJ_gmgt_classschedule;



$obj_notice=new MJ_gmgt_notice;



$active_tab = isset($_GET['tab'])?$_GET['tab']:'noticelist';



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







//SAVE NOTICE DATA



if(isset($_POST['save_notice']))



{



	$nonce = $_POST['_wpnonce'];



	if (wp_verify_nonce( $nonce, 'save_notice_nonce' ) )



	{		



		if($_FILES['upload_document']['name'] != "" && $_FILES['upload_document']['size'] > 0)	



		{



			if($_FILES['upload_document']['size'] > 0)



			{



				$file_name=MJ_gmgt_load_documets($_FILES['upload_document'],'upload_file','notice');



			}



		}



		else



		{



			if(isset($_REQUEST['hidden_upload_document']))



			{



				$file_name=$_REQUEST['hidden_upload_document'];



			}



		}







		if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit')



		{		



			$result=$obj_notice->MJ_gmgt_add_notice($_POST,$file_name);		



			// $result=$obj_notice->MJ_gmgt_add_notice($_POST);



			if($result)



			{



				if(isset($_REQUEST['page_action']) &&isset($_REQUEST['page_action']) == 'web_view_hide')



				{



					wp_redirect ( home_url().'?dashboard=user&page=notice&tab=noticelist&page_action=web_view_hide&notice_list_app_view=noticelist_app&message=2');



				}



				else



				{



					wp_redirect ( home_url().'?dashboard=user&page=notice&tab=noticelist&message=2');



				}



				



			}



		}



		else



		{		



			$result=$obj_notice->MJ_gmgt_add_notice($_POST,$file_name);



		



			//$result=$obj_notice->MJ_gmgt_add_notice($_POST,$_POST['notice_document']);



			if($result)



			{



				if(isset($_REQUEST['page_action']) &&isset($_REQUEST['page_action']) == 'web_view_hide')



				{



					wp_redirect ( home_url().'?dashboard=user&page=notice&tab=noticelist&page_action=web_view_hide&notice_list_app_view=noticelist_app&message=1');



				}



				else



				{



					wp_redirect ( home_url().'?dashboard=user&page=notice&tab=noticelist&message=1');



				}



				



			}



		} 



	}



}



	



//DELETE NOTICE DATA



if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')



{



	$result=$obj_notice->MJ_gmgt_delete_notice($_REQUEST['notice_id']);



	if($result)



	{



		if(isset($_REQUEST['page_action']) &&isset($_REQUEST['page_action']) == 'web_view_hide')



		{



			wp_redirect ( home_url().'?dashboard=user&page=notice&tab=noticelist&page_action=web_view_hide&notice_list_app_view=noticelist_app&message=3');



		}



		else



		{



			wp_redirect ( home_url().'?dashboard=user&page=notice&tab=noticelist&message=3');



		}



	}



}



if(isset($_REQUEST['message']))



{



	$message =$_REQUEST['message'];



	if($message == 1)



	{?>



		<div id="message" class="alert_msg alert alert-success alert-dismissible " role="alert">



		<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span>



		</button>



			<p><?php esc_html_e('Notice added successfully.','gym_mgt');?></p>



		</div>



		<?php 



		



	}



	elseif($message == 2)



	{?>



		<div id="message" class="alert_msg alert alert-success alert-dismissible " role="alert">



			<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span>



			</button>



			<p><?php esc_html_e("Notice updated successfully.",'gym_mgt');?></p>



		</div>



		<?php 		



	}



	elseif($message == 3) 



	{?>



		<div id="message" class="alert_msg alert alert-success alert-dismissible " role="alert">



			<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span>



			</button>



			<p><?php esc_html_e('Notice deleted successfully.','gym_mgt');?></p>



		</div>



		<?php			



	}



}



?>



<script type="text/javascript">



$(document).ready(function()



{



	"use strict";



	$('#notice_form').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});	



} );



</script>



<!-- POP up code -->



<div class="popup-bg">



    <div class="overlay-content">



		<div class="modal-content">



			<div class="category_list notice"></div>     



		</div>



    </div>    



</div>



<!-- End POP-UP Code -->



<div class="panel-body panel-white padding_0 gms_main_list"><!--PANEL BODY DIV START -->



	



	<div class="tab-content padding_0"><!--TAB CONTENT START -->



		<?php 



		if($active_tab == 'noticelist')



		{ 



			if($user_access['own_data']=='1')



			{



				$noticedata =$obj_notice->MJ_gmgt_get_notice($obj_gym->role);



			}



			else	



			{



				$noticedata =$obj_notice->MJ_gmgt_get_all_notice();



			}	







			if(!empty($noticedata))



			{



				?>	



				<script type="text/javascript">



					$(document).ready(function()



					{



						"use strict";



						jQuery('#notice_list').DataTable({



							// "responsive": true,



							dom: 'lifrtp',



							language:<?php echo MJ_gmgt_datatable_multi_language();?>	



						});



						$('.dataTables_filter input').attr("placeholder", "<?php esc_html_e('Search...', 'gym_mgt') ?>");



					} );



				</script>



				<div class="panel-body padding_0"><!-- PANEL BODY DIV START -->



					<div class="table-responsive"><!-- TABLE RESPONSIVE DIV START -->



						<table id="notice_list" class="display" cellspacing="0" width="100%"><!-- TABLE NOTICE LIST START -->



							<thead class="<?php echo MJ_gmgt_datatable_heder(); ?>">



								<tr>



								<th><?php  esc_html_e( 'Photo', 'gym_mgt' ) ;?></th>



									<th><?php  esc_html_e( 'Notice Title', 'gym_mgt' ) ;?></th>



									<th><?php  esc_html_e( 'Notice Comment', 'gym_mgt' ) ;?></th>



									<th><?php  esc_html_e( 'Notice For', 'gym_mgt' ) ;?></th>



									<th><?php  esc_html_e( 'Class', 'gym_mgt' ) ;?></th>



									<th><?php  esc_html_e( 'Start Date', 'gym_mgt' ) ;?></th>



									<th><?php  esc_html_e( 'End Date', 'gym_mgt' ) ;?></th>



									<?php if($obj_gym->role == 'member' || $obj_gym->role == 'staff_member' || $obj_gym->role == 'accountant')



										{?>



									<th  class="text_align_end"><?php  esc_html_e( 'Action', 'gym_mgt' ) ;?></th>



									<?php }?>



								</tr>



							</thead>



							<tbody>



								<?php 



								if(!empty($noticedata))



								{



									$i=0;



									foreach ($noticedata as $retrieved_data)



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



										$class_id=get_post_meta( $retrieved_data->ID, 'gmgt_class_id',true);



										if($class_id!="")



										{



											$ClassArr=MJ_gmgt_get_current_user_classis($curr_user_id);



											$staff_classes=$obj_class->MJ_gmgt_getClassesByStaffmeber($curr_user_id);



											if($obj_gym->role=="member" && in_array($class_id,$ClassArr))



											{



												?>



												<tr>



													<td class="user_image width_50px profile_image_prescription padding_left_0">	



														<p class="prescription_tag padding_15px margin_bottom_0px <?php echo $color_class; ?>">	



															<img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/notice.png"?>" alt="" class="massage_image center image_icon_height_25px margin_top_3px">



														</p>



													</td>



													<td class="noticetitle">



														<?php echo esc_html($retrieved_data->post_title);?>



														<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Notice Title','gym_mgt');?>" ></i>



													</td>



													



													<td class="noticecontent">



														<?php 



														$strlength= strlen($retrieved_data->post_content);



														if(!empty($retrieved_data->post_content))



														{



															if($strlength > 40)



															{



																echo substr(esc_html($retrieved_data->post_content), 0,40).'...';



															}



															else



															{



																echo esc_html($retrieved_data->post_content);



															}



														}



														else



														{



															echo "N/A";



														}



														?>



														<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Notice Comment','gym_mgt');?>" ></i>



													</td>



													<td class="productquentity">



														<?php echo esc_html__(ucwords(str_replace("_"," ",get_post_meta( $retrieved_data->ID, 'notice_for',true))),"gym_mgt");?>



														<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Notice For','gym_mgt');?>" ></i>



													</td>



													<td>



														<?php 



														if(get_post_meta( $retrieved_data->ID, 'gmgt_class_id',true) !="" && get_post_meta( $retrieved_data->ID, 'gmgt_class_id',true) =="all")



														{



															esc_html_e('All','gym_mgt');



														}



														elseif(get_post_meta( $retrieved_data->ID, 'gmgt_class_id',true) !="")



														{



															echo esc_html__(MJ_gmgt_get_class_name(get_post_meta(esc_html($retrieved_data->ID), 'gmgt_class_id',true)),"gym_mgt");



														}



														else



														{



															echo 'N/A';



														}



														?>



														<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Class','gym_mgt');?>" ></i>



													</td>



													<td>



														<?php echo MJ_gmgt_getdate_in_input_box(get_post_meta(esc_html($retrieved_data->ID),'gmgt_start_date',true));?>



														<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Start Date','gym_mgt');?>" ></i>



													</td>



													<td>



														<?php echo MJ_gmgt_getdate_in_input_box(get_post_meta(esc_html($retrieved_data->ID),'gmgt_end_date',true));?>



														<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('End Date','gym_mgt');?>" ></i>



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



																			<a href="#" class="view_details_popup float_left_width_100" id="<?php echo esc_attr($retrieved_data->ID)?>" type="<?php echo 'view_notice';?>"><i class="fa fa-eye"></i> <?php esc_html_e('View', 'gym_mgt' ) ;?> </a>



																		</li>



																	</ul>



																</li>



															</ul>



														</div>	



													</td>



											<?php



											}	



											if($obj_gym->role=="staff_member" && !empty($staff_classes) && in_array($class_id,$staff_classes))



											{



												?>



												<tr>



													<td class="user_image width_50px profile_image_prescription padding_left_0">	



														<p class="prescription_tag padding_15px margin_bottom_0px <?php echo $color_class; ?>">	



															<img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/notice.png"?>" alt="" class="massage_image center image_icon_height_25px margin_top_3px">



														</p>



													</td>	



													<td class="noticetitle">



														<a href="#" class="view_details_popup" id="<?php echo esc_attr($retrieved_data->ID)?>" type="<?php echo 'view_notice';?>"><?php echo esc_html($retrieved_data->post_title);?></a>



														<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Notice Title','gym_mgt');?>" ></i>



													</td>



													<td class="noticecontent">



														<?php 



														$strlength= strlen($retrieved_data->post_content);



														if(!empty($retrieved_data->post_content))



														{



															if($strlength > 40)



															{



																echo substr(esc_html($retrieved_data->post_content), 0,40).'...';



															}



															else



															{



																echo esc_html($retrieved_data->post_content);



															}



														}



														else



														{



															echo "N/A";



														}



														?>



														<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Notice Comment','gym_mgt');?>" ></i>



													</td>



													<td class="productquentity">



														<?php echo esc_html__(ucwords(str_replace("_"," ",get_post_meta( $retrieved_data->ID, 'notice_for',true))),"gym_mgt");?>



														<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Notice For','gym_mgt');?>" ></i>



													</td>



													<td>



														<?php 



														if(get_post_meta( $retrieved_data->ID, 'gmgt_class_id',true) !="" && get_post_meta( $retrieved_data->ID, 'gmgt_class_id',true) =="all")



														{



															esc_html_e('All','gym_mgt');



														}



														elseif(get_post_meta( $retrieved_data->ID, 'gmgt_class_id',true) !="")



														{



															echo esc_html__(MJ_gmgt_get_class_name(get_post_meta(esc_html($retrieved_data->ID), 'gmgt_class_id',true)),"gym_mgt");



														}



														else



														{



															echo 'N/A';



														}



														?>



														<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Class','gym_mgt');?>" ></i>



													</td>



													<td>



														<?php echo MJ_gmgt_getdate_in_input_box(get_post_meta(esc_html($retrieved_data->ID),'gmgt_start_date',true));?>



														<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Start Date','gym_mgt');?>" ></i>



													</td>



													<td>



														<?php echo MJ_gmgt_getdate_in_input_box(get_post_meta(esc_html($retrieved_data->ID),'gmgt_end_date',true));?>



														<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('End Date','gym_mgt');?>" ></i>



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



																			<a href="#" class="view_details_popup float_left_width_100" id="<?php echo esc_attr($retrieved_data->ID)?>" type="<?php echo 'view_notice';?>"><i class="fa fa-eye"></i> <?php esc_html_e('View', 'gym_mgt' ) ;?> </a>



																		</li>



																	</ul>



																</li>



															</ul>



														</div>	



													</td>



												</tr>



												<?php 



											}	



										}



										else



										{



											?>



											<tr>



												<td class="user_image width_50px profile_image_prescription padding_left_0">	



													<p class="prescription_tag padding_15px margin_bottom_0px <?php echo $color_class; ?>">	



														<img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/notice.png"?>" alt="" class="massage_image center image_icon_height_25px margin_top_3px">



													</p>



												</td>	



												<td class="noticetitle">



													<a href="#" class="view_details_popup" id="<?php echo esc_attr($retrieved_data->ID)?>" type="<?php echo 'view_notice';?>"><?php echo esc_html($retrieved_data->post_title);?></a>



													<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Notice Title','gym_mgt');?>" ></i>



												</td>



												<td class="noticecontent">



													<?php 



													$strlength= strlen($retrieved_data->post_content);



													if(!empty($retrieved_data->post_content))



													{



														if($strlength > 40)



														{



															echo substr(esc_html($retrieved_data->post_content), 0,40).'...';



														}



														else



														{



															echo esc_html($retrieved_data->post_content);



														}



													}



													else



													{



														echo "N/A";



													}



													?>



													<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Notice Comment','gym_mgt');?>" ></i>



												</td>



												<td class="productquentity">



													<?php echo esc_html__(ucwords(str_replace("_"," ",get_post_meta( $retrieved_data->ID, 'notice_for',true))),"gym_mgt");?>



													<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Notice For','gym_mgt');?>" ></i>



												</td>



												<td>



													<?php 



													if(get_post_meta( $retrieved_data->ID, 'gmgt_class_id',true) !="" && get_post_meta( $retrieved_data->ID, 'gmgt_class_id',true) =="all")



													{



														esc_html_e('All','gym_mgt');



													}



													elseif(get_post_meta( $retrieved_data->ID, 'gmgt_class_id',true) !="")



													{



														echo esc_html__(MJ_gmgt_get_class_name(get_post_meta(esc_html($retrieved_data->ID), 'gmgt_class_id',true)),"gym_mgt");



													}



													else



													{



														echo 'N/A';



													}



													?>



													<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Class','gym_mgt');?>" ></i>



												</td>



												<td>



													<?php echo MJ_gmgt_getdate_in_input_box(get_post_meta(esc_html($retrieved_data->ID),'gmgt_start_date',true));?>



													<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Start Date','gym_mgt');?>" ></i>



												</td>



												<td>



													<?php echo MJ_gmgt_getdate_in_input_box(get_post_meta(esc_html($retrieved_data->ID),'gmgt_end_date',true));?>



													<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('End Date','gym_mgt');?>" ></i>



												</td>



												



												<?php 



												if($obj_gym->role == 'member' || $obj_gym->role == 'staff_member' || $obj_gym->role == 'accountant')



												{ ?>



													<td class="action"> 



														<div class="gmgt-user-dropdown">



															<ul class="" style="margin-bottom: 0px !important;">



																<li class="">



																	<a class="" href="#" data-bs-toggle="dropdown" aria-expanded="false">



																		<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/More.png"?>" >



																	</a>



																	<ul class="dropdown-menu heder-dropdown-menu action_dropdawn" aria-labelledby="dropdownMenuLink">



														



																		<li class="float_left_width_100">



																			<a href="#" class="view_details_popup float_left_width_100" id="<?php echo esc_attr($retrieved_data->ID)?>" type="<?php echo 'view_notice';?>"><i class="fa fa-eye"></i> <?php esc_html_e('View', 'gym_mgt' ) ;?> </a>



																		</li>



																		<?php



																		if($user_access['edit']=='1')



																		{



																			if(isset($_REQUEST['notice_list_app_view']) && $_REQUEST['notice_list_app_view'] == 'noticelist_app')



																			{



																				?>



																				<li class="float_left_width_100 border_bottom_item">



																					<a href="?dashboard=user&page=notice&tab=addnotice&action=edit&notice_list_app_view=noticelist_app&page_action=web_view_hide&notice_id=<?php echo esc_attr($retrieved_data->ID)?>" class="float_left_width_100"><i class="fa fa-edit"></i> <?php esc_html_e('Edit', 'gym_mgt' ) ;?></a>



																				</li>



																				<?php



																			}



																			else



																			{



																				?>



																				<li class="float_left_width_100 border_bottom_item">



																					<a href="?dashboard=user&page=notice&tab=addnotice&action=edit&notice_id=<?php echo esc_attr($retrieved_data->ID)?>" class="float_left_width_100"><i class="fa fa-edit"></i> <?php esc_html_e('Edit', 'gym_mgt' ) ;?></a>



																				</li>



																				<?php



																			}



																		}



																		if($user_access['delete']=='1')



																		{



																			if(isset($_REQUEST['notice_list_app_view']) && $_REQUEST['notice_list_app_view'] == 'noticelist_app')



																			{



																				?>	



																				<li class="float_left_width_100">	



																					<a href="?dashboard=user&page=notice&tab=noticelist&action=delete&notice_list_app_view=noticelist_app&page_action=web_view_hide&notice_id=<?php echo esc_attr($retrieved_data->ID);?>" class="float_left_width_100 list_delete_btn" onclick="return confirm('<?php esc_html_e('Are you sure you want to delete this record?','gym_mgt');?>');"><i class="fa fa-trash"></i> <?php esc_html_e( 'Delete', 'gym_mgt' ) ;?> </a>



																				</li>



																				<?php



																			}



																			else



																			{



																				?>	



																				<li class="float_left_width_100">	



																					<a href="?dashboard=user&page=notice&tab=noticelist&action=delete&notice_id=<?php echo esc_attr($retrieved_data->ID);?>" class="float_left_width_100 list_delete_btn" onclick="return confirm('<?php esc_html_e('Are you sure you want to delete this record?','gym_mgt');?>');"><i class="fa fa-trash"></i> <?php esc_html_e( 'Delete', 'gym_mgt' ) ;?> </a>



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



												} ?>



											</tr>



											<?php 



										}	



										$i++;



									}



								}?>



							</tbody>



						</table><!-- TABLE NOTICE LIST END -->



					</div><!--TABLE RESPONSIVE DIV END -->



				</div><!-- PANEL BODY DIV END -->



				<?php 



			}



			else



			{



				if($user_access['add']=='1')



				{



					?>



					<div class="no_data_list_div"> 



						<a href="

						<?php 

						if(isset($_REQUEST['notice_list_app_view']) && $_REQUEST['notice_list_app_view'] == 'noticelist_app' || isset($_REQUEST['page_action']) && $_REQUEST['page_action'] == 'web_view_hide')

						{

							echo "?dashboard=user&page=notice&tab=addnotice&page_action=web_view_hide&notice_list_app_view=noticelist_app&action=insert";

						}

						else

						{

							echo home_url().'?dashboard=user&page=notice&tab=addnotice&action=insert';

						}

						?>">



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



		if($active_tab == 'addnotice')



		{ 



			$notice_id=0;



			$edit=0;



			if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')



			{	



				$notice_id=esc_attr($_REQUEST['notice_id']);				



				$edit=1;



				$result = get_post($notice_id);



			}



			?>



			<script type="text/javascript">



				jQuery(document).ready(function($)



				{



					"use strict";



					$('#notice_form').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});



					$.datepicker.setDefaults($.datepicker.regional['<?php echo MJ_gmgt_get_current_lan_code(); ?>']);



					$(".start_date").datepicker({



						dateFormat: '<?php echo get_option('gmgt_datepicker_format');?>',



						minDate:0,



						onSelect: function (selected) {



							var dt = new Date(selected);



							dt.setDate(dt.getDate() + 0);



							$(".end_date").datepicker("option", "minDate", dt);



						}



					});



					$(".end_date").datepicker({



						dateFormat: '<?php echo get_option('gmgt_datepicker_format');?>',



						onSelect: function (selected) {



							var dt = new Date(selected);



							dt.setDate(dt.getDate() - 0);



							$(".start_date").datepicker("option", "maxDate", dt);



						}



					});	



					



				} );



			</script>



			<script type="text/javascript">



				function fileCheck(obj)



				{   //FILE VALIDATIONENGINE



					"use strict";



					var fileExtension = ['pdf','doc','jpg','jpeg','png'];



					if ($.inArray($(obj).val().split('.').pop().toLowerCase(), fileExtension) == -1)



					{



						alert("<?php esc_html_e('Sorry, only JPG, JPEG, PNG And GIF files are allowed.','gym_mgt');?>");



						$(obj).val('');



					}	



				}



			</script>



			<div class="panel-body padding_0"><!--PANEL BODY DIV START-->



				<form name="notice_form" action="" method="post" class="form-horizontal" id="notice_form" enctype="multipart/form-data"><!--NOTICE FORM START-->



					<?php 



					$action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>



					<input type="hidden" name="action" value="<?php echo esc_attr($action);?>">



					<input type="hidden" name="notice_id" value="<?php echo esc_attr($notice_id);?>"  />



					



					<div class="header">	



						<h3 class="first_hed"><?php esc_html_e('Notice Information','gym_mgt');?></h3>



					</div>



					<div class="form-body user_form"> <!-- user_form Strat-->   



						<div class="row"><!--Row Div Strat--> 







							<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



								<div class="form-group input">



									<div class="col-md-12 form-control">



										<input id="notice_title" class="form-control validate[required,custom[popup_category_validation]] text-input" maxlength="50" type="text" value="<?php if($edit){ echo esc_attr($result->post_title);}?>" name="notice_title">



										<!-- <input type="hidden" name="notice_id" value="<?php if($edit){ echo esc_attr($result->ID);}?>"/>  -->



										<label class="" for="notice_title"><?php esc_html_e('Notice Title','gym_mgt');?><span class="require-field">*</span></label>



									</div>



								</div>



							</div>



							<!--nonce-->



							<?php wp_nonce_field( 'save_notice_nonce' ); ?>



							<!--nonce-->







							<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 input">



								<label class="ml-1 custom-top-label top" for="notice_for"><?php esc_html_e('Notice For','gym_mgt');?></label>



								<select name="notice_for" id="notice_for" class="form-control notice_for">



									<option value = "all"><?php esc_html_e('All','gym_mgt');?></option>



									<option value="staff_member" <?php if($edit) echo selected(get_post_meta( $result->ID, 'notice_for',true),'staff_member');?>><?php esc_html_e('Staff Members','gym_mgt');?></option>



									<option value="member" <?php if($edit) echo selected(get_post_meta( $result->ID, 'notice_for',true),'member');?>><?php esc_html_e('Member','gym_mgt');?></option>



									<option value="accountant" <?php if($edit) echo selected(get_post_meta( $result->ID, 'notice_for',true),'accountant');?>><?php esc_html_e('Accountant','gym_mgt');?></option>



								</select>



							</div>







							<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 class_div input">



								<label class="ml-1 custom-top-label top" for="class_id"><?php esc_html_e('Class','gym_mgt');?></label>



								<?php 



								if($edit)



								{



									$class_id=get_post_meta($result->ID,'gmgt_class_id',true);



								}



								elseif(isset($_POST['class_id']))



								{



									$class_id=sanitize_text_field($_POST['class_id']);



								}



								else



								{



									$class_id='';



								}



								?>



								<select id="class_id" class="form-control" name="class_id">



									<option value=""><?php esc_html_e('Select Class','gym_mgt');?></option>



										<?php $classdata=$obj_class->MJ_gmgt_get_all_classes();



										if(!empty($classdata))



										{



											foreach ($classdata as $class)



											{?>



												<option value="<?php echo esc_attr($class->class_id);?>" <?php selected($class_id,$class->class_id);  ?>><?php echo esc_html($class->class_name); ?> </option>



												<?php 



											} 



										} ?>



								</select>



							</div>







							<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



								<div class="form-group input">



									<div class="col-md-12 form-control">



										<input id="notice_Start_date" class="start_date form-control validate[required] text-input"  type="text" value="<?php if($edit){ echo esc_attr(MJ_gmgt_getdate_in_input_box(get_post_meta($result->ID,'gmgt_start_date',true)));}else{ echo MJ_gmgt_getdate_in_input_box(date("Y-m-d"));}?>" name="start_date" readonly>



										<label class="" for="notice_content"><?php esc_html_e('Notice Start Date','gym_mgt');?><span class="require-field">*</span></label>



										



									</div>



								</div>



							</div>



							<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



								<div class="form-group input">



									<div class="col-md-12 form-control">



										<input id="notice_end_date" class="end_date form-control validate[required] text-input"  type="text" value="<?php if($edit){ echo esc_attr(MJ_gmgt_getdate_in_input_box(get_post_meta($result->ID,'gmgt_end_date',true)));}else{ echo MJ_gmgt_getdate_in_input_box(date("Y-m-d"));}?>" name="end_date" readonly>



										<label class="" for="notice_content"><?php esc_html_e('Notice End Date','gym_mgt');?><span class="require-field">*</span></label>



									</div>



								</div>



							</div>







							<div class="col-md-6 note_text_notice">



								<div class="form-group input">



									<div class="col-md-12 note_border margin_bottom_15px_res">



										<div class="form-field">



											<textarea name="notice_content" class="textarea_height_47px form-control validate[custom[address_description_validation]]" maxlength="500" id="notice_content"><?php if($edit){ echo esc_attr($result->post_content);}?></textarea>



											<span class="txt-title-label"></span>



											<label class="text-area address active" for="notice_content"><?php esc_html_e('Notice Comment','gym_mgt');?></label>



										</div>



									</div>



								</div>



							</div>



							



							



							<div class="col-md-6">



								<div class="form-group input cmgt_document_list">



									<div class="col-md-12 form-control">



										<label class="custom-control-label custom-top-label ml-2 margin_left_30px" for="Document"><?php esc_html_e('Document','gym_mgt');?></label>



										<!-- <div class="col-sm-2">



											<input type="text" readonly id="notice_document_url" class="form-control" name="notice_document"  



											value="<?php if($edit){ echo get_post_meta($result->ID,'gmgt_notice_document',true); } elseif(isset($_POST['notice_document'])){ echo $_POST['notice_document']; }?>" />



										</div>	 -->



										<div class="row">



											<div class="col-sm-8">



												<input type="hidden" name="hidden_upload_document" value="<?php if($edit){ echo get_post_meta($result->ID,'gmgt_notice_document',true); }elseif(isset($_POST['upload_document'])) echo $_POST['upload_document'];?>">



												<input id="upload_document" name="upload_document"  type="file" onchange="fileCheck(this);" class=""  />		



											</div>



											<div class="col-sm-3 col-md-3">



											<?php 



												if($edit)



												{



													if(!empty(get_post_meta($result->ID,'gmgt_notice_document',true)))



													{ ?>



														<a href="<?php echo content_url().'/uploads/gym_assets/'.$result->gmgt_notice_document;?>" class="btn btn-default" target="_blank"><i class="fa fa-download"></i> <?php esc_html_e('Download','gym_mgt');?></a>



														<?php 



													}



												}						



												?>



											</div>



										</div>



									</div>



								</div>



							</div>



							<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 mb-3 rtl_margin_top_15px">



								<div class="form-group">



									<div class="col-md-12 form-control">



										<div class="row padding_radio">



											<div class="">



												<label class="custom-top-label" for="enable"><?php esc_html_e('Send Mail','gym_mgt');?></label>



												<input id="chk_sms_sent_mail" type="checkbox" <?php $gym_enable_notifications = 0;if($gym_enable_notifications) echo "checked";?> value="1" name="gym_enable_notifications"> <?php esc_html_e('Enable','gym_mgt'); ?>



											</div>				 



										</div>



									</div>



								</div>



							</div>



							<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 mb-3 rtl_margin_top_15px">



								<div class="form-group">



									<div class="col-md-12 form-control">



										<div class="row padding_radio">



											<div class="">



												<label class="custom-top-label" for="enable"><?php esc_html_e('Send SMS','gym_mgt');?></label>



												<input id="chk_sms_sent" type="checkbox" <?php $gmgt_sms_service_enable = 0;if($gmgt_sms_service_enable) echo "checked";?> value="1" name="gmgt_sms_service_enable"> <?php esc_html_e('Enable','gym_mgt'); ?>



											</div>				 



										</div>



									</div>



								</div>



							</div>







							<div id="hmsg_message_sent" class="hmsg_message_none col-md-6 note_text_notice">



								<div class="form-group input">



									<div class="col-md-12 note_border margin_bottom_15px_res">



										<div class="form-field">



											<textarea name="sms_template" class="textarea_height_47px form-control validate[required]" maxlength="160"></textarea>



											<span class="txt-title-label"></span>



											<label class="text-area address active" for="sms_template"><?php esc_html_e('SMS Text','gym_mgt');?><span class="require-field">*</span></label>



										</div>



									</div>



									<label><?php esc_html_e('Max. 160 Character','gym_mgt');?></label>



								</div>



							</div>



						</div><!--Row Div End--> 



					</div><!-- user_form End--> 



					<!------------   save btn  -------------->  



					<div class="form-body user_form"> <!-- user_form Strat-->   



						<div class="row"><!--Row Div Strat--> 



							<div class="col-md-6 col-sm-6 col-xs-12"><!--save btn-->  	



								<input type="submit" value="<?php if($edit){ esc_html_e('Save Notice','gym_mgt'); }else{ esc_html_e('Save Notice','gym_mgt');}?>" name="save_notice" class="btn save_btn"/>



							</div>



						</div><!--Row Div End--> 



					</div><!-- user_form End-->







				</form><!--NOTICE FORM END-->



			</div><!--PANEL BODY DIV START-->



			<?php 



		}



		?>	



	</div><!-- TAB CONTENT DIV END -->



</div><!-- PANEL BODY DIV END -->