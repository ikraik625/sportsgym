<?php 

$obj_class=new MJ_gmgt_classschedule;

$obj_notice=new MJ_gmgt_notice;

$active_tab = isset($_GET['tab'])?$_GET['tab']:'noticelist';

$role=MJ_gmgt_get_roles(get_current_user_id());

if($role == 'administrator')

{

	$user_access_add=1;

	$user_access_edit=1;

	$user_access_delete=1;

	$user_access_view=1;

}

else

{

	$user_access=MJ_gmgt_get_userrole_wise_manually_page_access_right_array_for_management('notice');

	$user_access_add=$user_access['add'];

	$user_access_edit=$user_access['edit'];

	$user_access_delete=$user_access['delete'];

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

			if ('notice' == $user_access['page_link'] && ($_REQUEST['action']=='edit'))

			{

				if($user_access_edit=='0')

				{	

					MJ_gmgt_access_right_page_not_access_message_for_management();

					die;

				}			

			}

			if ('notice' == $user_access['page_link'] && ($_REQUEST['action']=='delete'))

			{

				if($user_access_delete=='0')

				{	

					MJ_gmgt_access_right_page_not_access_message_for_management();

					die;

				}	

			}

			if ('notice' == $user_access['page_link'] && ($_REQUEST['action']=='insert'))

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

?>

<!-- POP up code -->

<div class="popup-bg">

    <div class="overlay-content">

		<div class="modal-content">

			<div class="category_list"></div>     

		</div>

    </div>    

</div>

<!-- End POP-UP Code -->

<div class="page-inner min_height_1631"><!--PAGE INNER DIV STRAT-->

	<div class="gms_main_list"><!-- MAIN_LIST_MARGING_15px START -->

		<?php 

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

						wp_redirect ( admin_url().'admin.php?page=gmgt_notice&tab=noticelist&message=2');

					}

				}

				else

				{		

					$result=$obj_notice->MJ_gmgt_add_notice($_POST,$file_name);

				

					//$result=$obj_notice->MJ_gmgt_add_notice($_POST,$_POST['notice_document']);

					if($result)

					{

						wp_redirect ( admin_url().'admin.php?page=gmgt_notice&tab=noticelist&message=1');

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

				wp_redirect ( admin_url().'admin.php?page=gmgt_notice&tab=noticelist&message=3');

			}

		}

		//Delete SELECTED NOTICE DATA	

		if(isset($_REQUEST['delete_selected']))

		{		

			if(!empty($_REQUEST['selected_id']))

			{

				foreach($_REQUEST['selected_id'] as $id)

				{

					$delete_notice=$obj_notice->MJ_gmgt_delete_notice($id);

				}

				if($delete_notice)

				{

					wp_redirect ( admin_url().'admin.php?page=gmgt_notice&tab=noticelist&message=3');

				}

			}

			else

			{

				echo '<script language="javascript">';

				echo 'alert("'.esc_html__('Please select at least one record.','gym_mgt').'")';

				echo '</script>';

			}

		}

		if(isset($_REQUEST['message']))

		{

			$message =esc_attr($_REQUEST['message']);

			if($message == 1)

			{?>

				<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">

					<p><?php esc_html_e('Notice added successfully.','gym_mgt');?></p>

					<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>

				</div>

			<?php

			}

			elseif($message == 2)

			{?>

				<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">

					<p><?php esc_html_e("Notice updated successfully.",'gym_mgt');?></p>

					<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>

				</div>

			<?php 

			}

			elseif($message == 3) 

			{?>

				<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">

					<p><?php esc_html_e('Notice deleted successfully.','gym_mgt');?></p>

					<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>

				</div>

			<?php	

			}

		}

		?>

		<div class="row"><!--ROW DIV START-->

			<div class="col-md-12 padding_0"><!--COL 12 DIV START-->

				<div class="panel-body"><!--PANEL BODY DIV START-->

					<?php

					if($active_tab == 'noticelist')

					{

						$args['post_type'] = 'gmgt_notice';

						$args['posts_per_page'] = -1;

						$args['post_status'] = 'public';

						$q = new WP_Query();

						$noticedata = $q->query( $args );

						if(!empty($noticedata))

						{

							?>	

							<script type="text/javascript">

								$(document).ready(function() 

								{

									"use strict";

									jQuery('#product_list').DataTable({

										// "responsive": true,

										"order": [[ 1, "asc" ]],

										dom: 'lifrtp',

										buttons: [

											'colvis'

										], 

										"aoColumns":[

													{"bSortable": false},

													{"bSortable": false},

													{"bSortable": true},

													{"bSortable": true},

													{"bSortable": true},

													{"bSortable": true},

													{"bSortable": true},

													{"bSortable": true},

													{"bSortable": false}],

										language:<?php echo MJ_gmgt_datatable_multi_language();?>		  

									});

									$('.dataTables_filter input').attr("placeholder", "<?php esc_html_e('Search...', 'gym_mgt') ?>");

									$('.select_all').on('click', function(e)

									{

											if($(this).is(':checked',true))  

											{

											$(".sub_chk").prop('checked', true);  

											}  

											else  

											{  

											$(".sub_chk").prop('checked',false);  

											} 

									});

									$("body").on("change",".sub_chk",function()

									{

										if(false == $(this).prop("checked"))

										{ 

											$(".select_all").prop('checked', false); 

										}

										if ($('.sub_chk:checked').length == $('.sub_chk').length )

										{

											$(".select_all").prop('checked', true);

										}

									});

									$(".delete_selected").on('click', function()

									{	

										if ($('.sub_chk:checked').length == 0 )

										{

											alert("<?php esc_html_e('Please select at least one record','gym_mgt');?>");

											return false;

										}

										else{

											var proceed = confirm("<?php esc_html_e('Are you sure you want to delete this record?','gym_mgt');?>");

											if (proceed) {

												  return true;

											} else {

												return false;

											}

										}

									});

								});

							</script>

							<form name="wcwm_report" action="" method="post"><!--NOTICE LIST FORM START-->

								<div class="panel-body padding_0"><!--PANEL BODY DIV START-->

									<div class="table-responsive"><!--TABLE RESPONSIVE DIV START-->

										<table id="product_list" class="display" cellspacing="0" width="100%"><!--NOTICE LIST FORM START-->

											<thead class="<?php echo MJ_gmgt_datatable_heder(); ?>">

												<tr>
													<th class="padding_0"><input type="checkbox" class="select_all"></th>

													<th><?php esc_html_e('Photo','gym_mgt');?></th>

													<th><?php esc_html_e('Notice Title','gym_mgt');?></th>

													<th><?php esc_html_e('Notice Comment','gym_mgt');?></th>

													<th><?php esc_html_e('Notice For','gym_mgt');?></th>

													<th><?php esc_html_e('Class','gym_mgt');?></th>

													<th><?php esc_html_e('Start Date','gym_mgt');?></th>

													<th><?php esc_html_e('End Date','gym_mgt');?></th>

													<th class="text_align_end"><?php esc_html_e('Action','gym_mgt');?></th>

												</tr>

											</thead>

											<tbody>

												<?php 

												//GET NOTICE DATA

												// $args['post_type'] = 'gmgt_notice';

												// $args['posts_per_page'] = -1;

												// $args['post_status'] = 'public';

												// $q = new WP_Query();

												// $noticedata = $q->query( $args );

												

												if(!empty($noticedata))

												{

													$i=0;

													foreach ($noticedata as $retrieved_data)

													{

														//var_dump($retrieved_data);

														// die;

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

															<td class="checkbox_width_10px">

																<input type="checkbox" name="selected_id[]" class="smgt_sub_chk sub_chk" value="<?php echo esc_attr($retrieved_data->ID); ?>">

															</td>

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

																$get_class_name = MJ_gmgt_get_class_name(get_post_meta(esc_html($retrieved_data->class_id), 'gmgt_class_id',true));

																$get_class_id = get_post_meta( $retrieved_data->ID, 'gmgt_class_id',true);

																

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



																// if(get_post_meta( $retrieved_data->ID, 'gmgt_class_id',true) !="")

																// {

																// 	echo esc_html__(MJ_gmgt_get_class_name(get_post_meta(esc_html($retrieved_data->ID), 'gmgt_class_id',true)),"gym_mgt");

																// }

																// else

																// {

																// 	echo "N/A";

																// }

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

																					<a href="#" class="view_details_popup float_left_width_100" id="<?php echo esc_attr($retrieved_data->ID)?>" type="<?php echo 'view_notice';?>"><i class="fa fa-eye"> </i><?php esc_html_e('View', 'gym_mgt' ) ;?> </a>

																				</li>

																				<?php if($user_access_edit == '1')

																				{ ?>	

																					<li class="float_left_width_100 border_bottom_item">

																						<a href="?page=gmgt_notice&tab=addnotice&action=edit&notice_id=<?php echo esc_attr($retrieved_data->ID)?>" class="float_left_width_100"><i class="fa fa-edit"></i> <?php esc_html_e('Edit', 'gym_mgt' ) ;?></a>

																					</li>

																					<?php 

																				}

																				if($user_access_delete =='1')

																				{ ?>

																					<li class="float_left_width_100">

																						<a href="?page=gmgt_notice&tab=noticelist&action=delete&notice_id=<?php echo esc_attr($retrieved_data->ID);?>" class="float_left_width_100 list_delete_btn" onclick="return confirm('<?php esc_html_e('Are you sure you want to delete this record?','gym_mgt');?>');"><i class="fa fa-trash"></i> <?php esc_html_e( 'Delete', 'gym_mgt' ) ;?> </a>

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

										</table><!--NOTICE LIST FORM END-->

										<!-------- Delete And Select All Button ----------->

										<div class="print-button pull-left">

											<button class="btn btn-success btn-sms-color">

												<input type="checkbox" name="id[]" class="select_all" value="<?php echo esc_attr($retrieved_data->ID); ?>" style="margin-top: 0px;">

												<label for="checkbox" class="margin_right_5px"><?php esc_html_e( 'Select All', 'gym_mgt' ) ;?></label>

											</button>

											<?php 

											if($user_access_delete =='1')

											{ ?>

												<button data-toggle="tooltip"  id="delete_selected" title="<?php esc_html_e('Delete Selected','gym_mgt');?>" name="delete_selected" class="delete_selected" ><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Delete.png" ?>" alt=""></button>

												<?php 

											} 

											?>

										</div>

										<!-------- Delete And Select All Button ----------->

									</div><!--TABLE RESPONSIVE DIV END-->

								</div><!--PANEL BODY DIV END-->

							</form><!--NOTICE LIST FORM END-->

							<?php 

						}

						else

						{
							if($user_access_add == 1)
							{
								?>

								<div class="no_data_list_div"> 

									<a href="<?php echo admin_url().'admin.php?page=gmgt_notice&tab=addnotice';?>">

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

						require_once GMS_PLUGIN_DIR. '/admin/notice/add_notice.php';

					}

					?>

				</div><!--PANEL BODY DIV END-->

			</div><!--COL 12 DIV END-->

		</div><!--ROW DIV END-->

	</div><!-- MAIN_LIST_MARGING_15px END -->

</div><!--PAGE INNER DIV END-->