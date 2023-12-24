<?php

$obj_group=new MJ_gmgt_group;

$active_tab = isset($_GET['tab'])?$_GET['tab']:'grouplist';

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

	$user_access=MJ_gmgt_get_userrole_wise_manually_page_access_right_array_for_management('group');

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

			if ('group' == $user_access['page_link'] && ($_REQUEST['action']=='edit'))

			{

				if($user_access_edit=='0')

				{	

					MJ_gmgt_access_right_page_not_access_message_for_management();

					die;

				}			

			}

			if ('group' == $user_access['page_link'] && ($_REQUEST['action']=='delete'))

			{

				if($user_access_delete=='0')

				{	

					MJ_gmgt_access_right_page_not_access_message_for_management();

					die;

				}	

			}

			if ('group' == $user_access['page_link'] && ($_REQUEST['action']=='insert'))

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

<div class="page-inner min_height_1631"><!-- PAGE INNNER DIV START-->

	<div class="gms_main_list"><!-- MAIN_LIST_MARGING_15px START -->

		<?php 

		//SAVE GROUP DATA

		if(isset($_POST['save_group']))

		{

			$nonce = $_POST['_wpnonce'];

			if (wp_verify_nonce( $nonce, 'save_group_nonce' ) )

			{

				if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit')

				{

					$txturl=$_POST['gmgt_groupimage'];

					$ext=MJ_gmgt_check_valid_extension($txturl);

					if(!$ext == 0)

					{	

						$result=$obj_group->MJ_gmgt_add_group($_POST,$_POST['gmgt_groupimage']);

						if($result)

						{

							wp_redirect ( admin_url().'admin.php?page=gmgt_group&tab=grouplist&message=2');

						}

					}			

					else

					{ ?>

						<div id="message" class="updated below-h2 ">

						<p>

							<?php esc_html_e('Sorry, only JPG, JPEG, PNG & GIF And BMP files are allowed.','gym_mgt');?>

						</p></div>	 

						<?php

					}

				}

				else

				{

					$txturl=$_POST['gmgt_groupimage'];

					$ext=MJ_gmgt_check_valid_extension($txturl);

					if(!$ext == 0)

					{

						$result=$obj_group->MJ_gmgt_add_group($_POST,$_POST['gmgt_groupimage']);

						if($result)

						{

							wp_redirect ( admin_url().'admin.php?page=gmgt_group&tab=grouplist&message=1');

						}

					}			

					else

					{ ?>

						<div id="message" class="updated below-h2 ">

							<p><?php esc_html_e('Sorry, only JPG, JPEG, PNG & GIF And BMP files are allowed.','gym_mgt');?></p>

						</div>				 

						<?php 

					}

				}

			}

		}

		//DELETE GROUP DATA

		if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')
		{

			$result=$obj_group->MJ_gmgt_delete_group($_REQUEST['group_id']);

			if($result)

			{

				wp_redirect ( admin_url().'admin.php?page=gmgt_group&tab=grouplist&message=3');

			}

		}

		//DELETE SELECTED GROUP DATA

		if(isset($_REQUEST['delete_selected']))

		{

			if(!empty($_REQUEST['selected_id']))

			{

				foreach($_REQUEST['selected_id'] as $id)

				{

					$delete_group=$obj_group->MJ_gmgt_delete_group($id);

				}

				if($delete_group)

				{

					wp_redirect ( admin_url().'admin.php?page=gmgt_group&tab=grouplist&message=3');

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

			{

			?>

				<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">

					<p><?php esc_html_e('Group added successfully.','gym_mgt');?></p>

					<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>

				</div>

			<?php 

			}

			elseif($message == 2)

			{

			?>

				<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">

					<p><?php esc_html_e("Group updated successfully.",'gym_mgt');?></p>

					<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>

				</div>

			<?php 

			}

			elseif($message == 3) 

			{

			?>

				<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">

					<p><?php esc_html_e("Group deleted successfully.",'gym_mgt');?></p>

					<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>

				</div>

			<?php	

			}

		}

		?>

		<div class="row"><!-- ROW DIV START-->

			<div class="col-md-12 padding_0"><!-- COL 12 DIV START-->

				<div class="panel-body "><!-- PANEL BODY DIV START-->

					<!-- <h2 class="nav-tab-wrapper">

						<a href="?page=gmgt_group&tab=grouplist" class="nav-tab <?php echo $active_tab == 'grouplist' ? 'nav-tab-active' : ''; ?>">

						<?php echo '<span class="dashicons dashicons-menu"></span> '.esc_html__('Group List','gym_mgt');?>

						</a>

						<?php if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')

						{?>

							<a href="?page=gmgt_group&tab=addgroup&&action=edit&group_id=<?php echo esc_attr($_REQUEST['group_id']);?>" class="nav-tab <?php echo $active_tab == 'addgroup' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e('Edit Group', 'gym_mgt'); ?></a>

						<?php

						}

						else

						{

							if($user_access_add == '1')

							{

							?>

							<a href="?page=gmgt_group&tab=addgroup" class="nav-tab <?php echo $active_tab == 'addgroup' ? 'nav-tab-active' : ''; ?>"><?php echo '<span class="dashicons dashicons-plus-alt"></span> '.esc_html__('Add Group', 'gym_mgt'); ?></a>

						<?php

							}

						}?>

					</h2> -->

					<?php 						

					if($active_tab == 'grouplist')

					{

						$groupdata=$obj_group->MJ_gmgt_get_all_groups();

						if(!empty($groupdata))

						{

							?>	

							<script type="text/javascript">

								jQuery(document).ready(function($) 

								{

									"use strict";

									$('#group_list').DataTable({

										// "responsive": true,

										dom: 'lifrtp',

										// buttons: [

										// 	'colvis'

										// ], 



										"aoColumns":[

														{"bSortable": false},

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

									$('.sub_chk').on('change',function()

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

											if ($('.select-checkbox:checked').length == 0 )

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

								} );

							</script>

							<form name="wcwm_report" action="" method="post"><!-- GROUP LIST FORM START-->

								<div class="panel-body padding_0"><!-- PANEL BODY DIV START-->

									<div class="table-responsive"><!-- TABLE RESPONSIVE DIV START-->

										<table id="group_list" class="display" cellspacing="0" width="100%"><!-- GROUP LIST TABLE START-->

											<thead class="<?php echo MJ_gmgt_datatable_heder(); ?>">

												<tr>

													<th class="padding_0"><input type="checkbox" class="select_all"></th>

													<th><?php esc_html_e('Photo','gym_mgt');?></th>

													<th><?php esc_html_e('Group Name','gym_mgt');?></th>

													<th><?php esc_html_e('Description','gym_mgt');?></th>

													<th><?php esc_html_e('Total Group Members','gym_mgt');?></th>

													<th class="text_align_end"><?php esc_html_e('Action','gym_mgt');?></th>

												</tr>

											</thead>

											<tbody>

												<?php 

												if(!empty($groupdata))

												{

													foreach ($groupdata as $retrieved_data)

													{

													?>

														<tr>

															<td class="checkbox_width_10px">

																<input type="checkbox" class="smgt_sub_chk sub_chk select-checkbox" name="selected_id[]" value="<?php echo esc_attr($retrieved_data->id); ?>">

															</td>

															<td class="user_image width_50px padding_left_0">

															<?php 

															if($retrieved_data->gmgt_groupimage == '')

															{

																echo '<img src='.get_option('gmgt_group_logo' ).'  height="50px" width="50px" class="img-circle" />';

															}

															else

															{

																echo '<img src='.esc_url($retrieved_data->gmgt_groupimage).' height="50px" width="50px" class="img-circle"/>';

															}

															?>

															</td>	

															<td class="membershipname">

																<a href="#" class="view_details_popup" id="<?php echo esc_attr($retrieved_data->id)?>" type="<?php echo 'view_group';?>" > <?php echo esc_html__($retrieved_data->group_name);?></a>

																<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Group Name','gym_mgt');?>" ></i>

															</td>

															<td class="">

																<?php 

																	if(!empty($retrieved_data->group_description)) 
																	{
																		$strlength= strlen($retrieved_data->group_description);

																		if($strlength > 80)
																		{
																			echo substr(esc_html($retrieved_data->group_description), 0,80).'...';
																		}
																		else
																		{
																			echo $retrieved_data->group_description;
																		}
																	}
																	else
																	{ 
																		echo 'N/A'; 
																	} 
																?>

																<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Description','gym_mgt');?>" ></i>

															</td>

															

															<td class="allmembers">

																<?php echo esc_html__($obj_group->MJ_gmgt_count_group_members($retrieved_data->id));?>

																<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Total Group Members','gym_mgt');?>" ></i>

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

																					<a href="#" class="float_left_width_100 view_details_popup" id="<?php echo esc_attr($retrieved_data->id)?>" type="<?php echo 'view_group';?>" ><i class="fa fa-eye"> </i> <?php esc_html_e('View', 'gym_mgt' ) ;?></a>

																				</li>

																				<?php if($user_access_edit == '1')

																				{ ?>	

																					<li class="float_left_width_100 border_bottom_item">

																						<a href="?page=gmgt_group&tab=addgroup&action=edit&group_id=<?php echo esc_attr($retrieved_data->id)?>" class="float_left_width_100"><i class="fa fa-edit"></i> <?php esc_html_e('Edit', 'gym_mgt' ) ;?></a>

																					</li>

																					<?php

																				}																

																				if($user_access_delete =='1')

																				{ ?>

																					<li class="float_left_width_100 ">

																						<a href="?page=gmgt_group&tab=grouplist&action=delete&group_id=<?php echo esc_attr($retrieved_data->id);?>" class="float_left_width_100 list_delete_btn" onclick="return confirm('<?php esc_html_e('Are you sure you want to delete this record?','gym_mgt');?>');"><i class="fa fa-trash"></i> <?php esc_html_e( 'Delete', 'gym_mgt' ) ;?> </a>

																					</li>

																					<?php 

																				}?>

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

										</table><!-- GROUP TABLE END-->

										<div class="print-button pull-left">

											<button class="btn btn-success btn-sms-color">

												<input type="checkbox" name="id[]" class="select_all" value="<?php echo esc_attr($retrieved_data->ID); ?>" style="margin-top: 0px;">

												<label for="checkbox" class="margin_right_5px"><?php esc_html_e( 'Select All', 'gym_mgt' ) ;?></label>

											</button>

											<?php 

											if($user_access_delete =='1')

											{ ?>

												<!-- <input  type="submit" value="<?php esc_html_e('Delete Selected','gym_mgt');?>" name="delete_selected" class="btn btn-danger delete_selected "/> -->

												<button id="delete_selected" data-toggle="tooltip" title="<?php esc_html_e('Delete Selected','gym_mgt');?>" name="delete_selected" class="delete_selected" ><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Delete.png" ?>" alt=""></button>

												<?php 

											} ?>

										</div>

									</div><!-- TABLE RESPONSIVE DIV END-->

								</div><!-- PANEL BODY DIV END-->

							</form><!-- GROUP LIST FORM END-->

							<?php 

						}

						else

						{
							if($user_access_add == 1)
							{
								?>

								<div class="no_data_list_div"> 

									<a href="<?php echo admin_url().'admin.php?page=gmgt_group&tab=addgroup	';?>">

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

					if($active_tab == 'addgroup')

					{

						require_once GMS_PLUGIN_DIR. '/admin/group/add_group.php';

					}						

					?>

				</div><!-- PANEL BODY DIV END-->

	        </div><!-- COL 12 DIV END-->

        </div><!-- ROW DIV END-->

	</div><!--MAIN_LIST_MARGING_15px END  -->

</div><!-- PAGE INNNER DIV END-->