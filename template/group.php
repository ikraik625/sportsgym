<?php 

$curr_user_id=get_current_user_id();

$obj_gym=new MJ_gmgt_Gym_management($curr_user_id);

$obj_group=new MJ_gmgt_group;

$active_tab = isset($_GET['tab'])?$_GET['tab']:'grouplist';

//access right

$user_access=MJ_gmgt_get_userrole_wise_page_access_right_array();

if (isset ( $_REQUEST ['page'] ))

{	

	if($user_access['view']=='0')

	{	

		MJ_gmgt_access_right_page_not_access_message();

		die;

	}

	if(!empty($_REQUEST['action']))

	{

		if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == $user_access['page_link'] && ($_REQUEST['action']=='edit'))

		{

			if($user_access['edit']=='0')

			{	

				MJ_gmgt_access_right_page_not_access_message();

				die;

			}			

		}

		if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == $user_access['page_link'] && ($_REQUEST['action']=='delete'))

		{

			if($user_access['delete']=='0')

			{	

				MJ_gmgt_access_right_page_not_access_message();

				die;

			}	

		}

		if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == $user_access['page_link'] && ($_REQUEST['action']=='insert'))

		{

			if($user_access['add']=='0')

			{	

				MJ_gmgt_access_right_page_not_access_message();

				die;

			}	

		}

	}

}

//SAVE GROUP DATA

if(isset($_POST['save_group']))

{ 

    $nonce = $_POST['_wpnonce'];

	if (wp_verify_nonce( $nonce, 'save_group_nonce' ) )

	{

		if(isset($_FILES['gmgt_groupimage']) && !empty($_FILES['gmgt_groupimage']) && $_FILES['gmgt_groupimage']['size'] !=0)

		{

			if($_FILES['gmgt_groupimage']['size'] > 0)

			{

				 $member_image=MJ_gmgt_load_documets($_FILES['gmgt_groupimage'],'gmgt_groupimage','pimg');

				 $member_image_url=content_url().'/uploads/gym_assets/'.$member_image;

			}		

		}

		else

		{			

			if(isset($_REQUEST['hidden_upload_user_avatar_image']))

			{

				$member_image=$_REQUEST['hidden_upload_user_avatar_image'];

			    $member_image_url=$member_image;

			}

		}

		$ext=MJ_gmgt_check_valid_extension($member_image_url);

		if(!$ext == 0)

		{

			if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit')

			{

				$result=$obj_group->MJ_gmgt_add_group($_POST,'');

				$returnans=$obj_group->MJ_gmgt_update_groupimage( $_REQUEST['group_id'],$member_image_url);

				if($returnans)

				{

					if(isset($_REQUEST['page_action']) && $_REQUEST['page_action'] == 'web_view_hide')

					{

						wp_redirect ( home_url().'?dashboard=user&page=group&tab=grouplist&page_action=web_view_hide&group_app_view=grouplist_app_view&message=2');

					}

					else

					{

						wp_redirect ( home_url().'?dashboard=user&page=group&tab=grouplist&message=2');

					}

					

				}

				elseif($result)

				{

					if(isset($_REQUEST['page_action']) && $_REQUEST['page_action'] == 'web_view_hide')

					{

						wp_redirect ( home_url().'?dashboard=user&page=group&tab=grouplist&page_action=web_view_hide&group_app_view=grouplist_app_view&message=2');

					}

					else

					{

						wp_redirect ( home_url().'?dashboard=user&page=group&tab=grouplist&message=2');

					}

					//wp_redirect ( home_url().'?dashboard=user&page=group&tab=grouplist&message=2');

				}

					

			}

			else

			{

				$result=$obj_group->MJ_gmgt_add_group($_POST,$member_image_url);

				if($result)

				{

					if(isset($_REQUEST['page_action']) && $_REQUEST['page_action'] == 'web_view_hide')

					{

						wp_redirect ( home_url().'?dashboard=user&page=group&tab=grouplist&page_action=web_view_hide&group_app_view=grouplist_app_view&message=1');

					}

					else

					{

						wp_redirect ( home_url().'?dashboard=user&page=group&tab=grouplist&message=1');

					}

					//wp_redirect ( home_url().'?dashboard=user&page=group&tab=grouplist&message=1');

				}

			}

		}			

		else

		{

			?>

			<div id="message" class="alert_msg alert alert-success alert-dismissible " role="alert">

				<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span>

				</button>

				<p><?php esc_html_e('Sorry, only JPG, JPEG, PNG & GIF And BMP files are allowed.','gym_mgt');?></p>

			</div>				 

			<?php 

		}	

	}

}

//DELETE GROUP DATA

if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')

{	

	$result=$obj_group->MJ_gmgt_delete_group($_REQUEST['group_id']);

	if($result)

	{

		if(isset($_REQUEST['page_action']) && $_REQUEST['page_action'] == 'web_view_hide')

		{

			wp_redirect ( home_url().'?dashboard=user&page=group&tab=grouplist&page_action=web_view_hide&group_app_view=grouplist_app_view&message=3');

		}

		else

		{

			wp_redirect ( home_url().'?dashboard=user&page=group&tab=grouplist&message=3');

		}

		//wp_redirect ( home_url().'?dashboard=user&page=group&tab=grouplist&message=3');

	}

}

if(isset($_REQUEST['message']))

{

	$message =esc_attr($_REQUEST['message']);

	if($message == 1)

	{?>

		<div id="message" class="alert_msg alert alert-success alert-dismissible " role="alert">

			<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span>

			</button>

			<p><?php esc_html_e('Group inserted successfully.','gym_mgt');?></p>

		</div>

	<?php	

	}

	elseif($message == 2)

	{?>

		<div id="message" class="alert_msg alert alert-success alert-dismissible " role="alert">

			<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span>

			</button>

			<p><?php esc_html_e("Group updated successfully.",'gym_mgt');?></p>

		</div>

	<?php 	

	}

	elseif($message == 3) 

	{?>

		<div id="message" class="alert_msg alert alert-success alert-dismissible " role="alert">

			<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span>

			</button>

			<p><?php esc_html_e('Group deleted successfully.','gym_mgt');?></p>

		</div>

	<?php

	}

}

?>

<script type="text/javascript">

$(document).ready(function() 

{

	"use strict";

	$('#group_form').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});	

});

</script>

<!-- POP up code -->

<div class="popup-bg">

    <div class="overlay-content">

		<div class="modal-content">

			<div class="category_list"></div>	

        </div>

    </div> 

</div>

<!-- End POP-UP Code -->

<div class="panel-body panel-white padding_0"><!--PANEL WHITE DIV START-->  

	<div class="tab-content padding_0"><!--TAB CONTENT DIV START-->

		<?php 

		if($active_tab == 'grouplist')

		{ 

			if($obj_gym->role == 'member')

			{	

				if($user_access['own_data']=='1')

				{

					$user_id=get_current_user_id();

					$groupdata=$obj_group->MJ_gmgt_get_member_all_groups($user_id);

					

				}

				else

				{

					$groupdata=$obj_group->MJ_gmgt_get_all_groups();

				}	

			}

			elseif($obj_gym->role == 'staff_member' || $obj_gym->role == 'accountant')

			{

				if($user_access['own_data']=='1')

				{

					$user_id=get_current_user_id();							

					$groupdata=$obj_group->MJ_gmgt_get_all_groups_by_created_by($user_id);	

				}

				else

				{

					$groupdata=$obj_group->MJ_gmgt_get_all_groups();

				}

			}

			?>	

			<div class="gms_main_list"><!-- MAIN_LIST_MARGING_15px START -->

				<?php

				if(!empty($groupdata))

				{

					?>	

					<script type="text/javascript">

						$(document).ready(function() 

						{

							"use strict";

							jQuery('#group_list').DataTable({

								// "responsive": true,

								//"order": [[ 1, "asc" ]],

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

					<div class="panel-body padding_0"><!--PANEL BODY DIV START-->

						<div class="table-responsive"><!--TABLE RESPONSIVE START-->

							<table id="group_list" class="display" cellspacing="0" width="100%"><!--TABLE GROUP LIST START-->

								<thead class="<?php echo MJ_gmgt_datatable_heder(); ?>">

									<tr id="height_50">

										<th><?php esc_html_e('Photo','gym_mgt');?></th>

										<th><?php esc_html_e('Group Name', 'gym_mgt' ) ;?></th>

										<th><?php esc_html_e('Description', 'gym_mgt' ) ;?></th>

										<th><?php esc_html_e('Total Group Members', 'gym_mgt' ) ;?></th>

										<th class="text_align_end"><?php esc_html_e('Action', 'gym_mgt' ) ;?></th>

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

											<td class="user_image width_50px padding_left_0">

												<?php 

												$userimage=$retrieved_data->gmgt_groupimage;

												if(empty($userimage))

												{

													echo '<img src='.get_option( 'gmgt_group_logo' ).' height="25px" width="25px" class="img-circle" />';

												}

												else

													echo '<img src='.$userimage.' height="25px" width="25px" class="img-circle"/>';

												?>

											</td>

											<td class="membershipname">

												<?php 

												if($obj_gym->role == 'staff_member' || $obj_gym->role == 'accountant')

												{

													if(isset($_REQUEST['group_app_view']) && $_REQUEST['group_app_view'] == 'grouplist_app_view')

													{		

														echo esc_html($retrieved_data->group_name);

													}

													else

													{

														?>

														<!-- <a href="?dashboard=user&page=group&tab=addgroup&action=edit&group_id=<?php echo esc_attr($retrieved_data->id);?>"><?php echo esc_html($retrieved_data->group_name);?></a> -->

														<a href="#" class="view_details_popup" id="<?php echo esc_attr($retrieved_data->id)?>" type="view_group">

															<?php echo esc_html($retrieved_data->group_name);?>

														</a>

														

														<?php 

													}

												}

												else

												{ ?>

													<a href="#" class="view_details_popup" id="<?php echo esc_attr($retrieved_data->id)?>" type="view_group">

														<?php echo esc_html($retrieved_data->group_name);?>

													</a>

												<?php 

												} ?>

												<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Group Name','gym_mgt');?>" ></i>

											</td>

											<td class="">

												<?php 

												if(!empty($retrieved_data->group_description)) 

												{ 

													$strlength= strlen($retrieved_data->group_description);

													if($strlength > 80)

														echo substr($retrieved_data->group_description, 0,80).'...';

													else

														echo $retrieved_data->group_description;

													}

												else

												{ 

													echo 'N/A'; 

												} 

											?>

												<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Description','gym_mgt');?>" ></i>

											</td>

											<td class="allmembers">

												<?php echo esc_html($obj_group->MJ_gmgt_count_group_members($retrieved_data->id));?>

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

																	<a href="#" class="float_left_width_100 view_details_popup" id="<?php echo esc_attr($retrieved_data->id)?>" type="view_group"><i class="fa fa-eye"></i> <?php esc_html_e('View', 'gym_mgt' ) ;?></a>

																</li>

																

																<?php

																if($user_access['edit']=='1')

																{

																	if(isset($_REQUEST['group_app_view']) && $_REQUEST['group_app_view'] == 'grouplist_app_view')

																	{

																		?>		

																		<li class="float_left_width_100 border_bottom_item">						

																			<a href="?dashboard=user&page=group&tab=addgroup&action=edit&page_action=web_view_hide&group_id=<?php echo esc_attr($retrieved_data->id)?>" class="float_left_width_100"><i class="fa fa-edit"></i> <?php esc_html_e('Edit', 'gym_mgt' ) ;?></a>

																		</li>

																		<?php

																	}

																	else

																	{

																		?>	

																		<li class="float_left_width_100 border_bottom_item">							

																			<a href="?dashboard=user&page=group&tab=addgroup&action=edit&group_id=<?php echo esc_attr($retrieved_data->id)?>" class="float_left_width_100"><i class="fa fa-edit"></i> <?php esc_html_e('Edit', 'gym_mgt' ) ;?></a>

																		</li>

																		<?php

																	}

																}

																if($user_access['delete']=='1')

																{

																	if(isset($_REQUEST['group_app_view']) && $_REQUEST['group_app_view'] == 'grouplist_app_view')

																	{

																		?>	

																		<li class="float_left_width_100 ">

																			<a href="?dashboard=user&page=group&tab=grouplist&action=delete&page_action=web_view_hide&group_id=<?php echo esc_attr($retrieved_data->id);?>" class="float_left_width_100 list_delete_btn" onclick="return confirm('<?php esc_html_e('Are you sure you want to delete this record?','gym_mgt');?>');"><i class="fa fa-trash"></i> <?php esc_html_e( 'Delete', 'gym_mgt' ) ;?> </a>

																		</li>

																		<?php

																	}

																	else

																	{

																		?>

																		<li class="float_left_width_100 ">

																			<a href="?dashboard=user&page=group&tab=grouplist&action=delete&group_id=<?php echo esc_attr($retrieved_data->id);?>" class="float_left_width_100 list_delete_btn" onclick="return confirm('<?php esc_html_e('Are you sure you want to delete this record?','gym_mgt');?>');"><i class="fa fa-trash"></i> <?php esc_html_e( 'Delete', 'gym_mgt' ) ;?> </a>

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

										</tr>

										<?php

									} 

								}?>

								</tbody>

							</table><!--TABLE GROUP LIST END-->

						</div><!--TABLE RESPONSIVE DIV END-->

					</div><!--PANEL BODY DIV END-->

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
							if(isset($_REQUEST['group_app_view']) && $_REQUEST['group_app_view'] == 'grouplist_app_view' || isset($_REQUEST['page_action']) && $_REQUEST['page_action'] == 'web_view_hide')
							{
								echo "?dashboard=user&page=group&tab=addgroup&action=insert&group_app_view=grouplist_app_view&page_action=web_view_hide";
							}
							else
							{
								echo home_url().'?dashboard=user&page=group&tab=addgroup&&action=insert';
							}
							?>">

								<img class="width_100px" src="<?php echo get_option( 'gmgt_no_data_img' ) ?>" >

							</a>

							<div class="col-md-12 dashboard_btn margin_top_20px margin_top_12p">

								<label class="no_data_list_label"><?php esc_html_e('Tap on above icon to add your first Record.','gym_mgt'); ?> </label>

							</div> 

						</div>      

						<?php

					}

					else

					{

						?>

						<div class="calendar-event-new margin_top_12p"> 

							<img class="no_data_img" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/no_data_img.png"?>" >

						</div>

						<?php

					}

				}

				?>

			</div><!--MAIN_LIST_MARGING_15px END  -->

			<?php 

		}

		if($active_tab == 'addgroup')

		{

			$group_id=0;

			if(isset($_REQUEST['group_id']))

				$group_id=esc_attr($_REQUEST['group_id']);

				$edit=0;

				if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')

				{

					$edit=1;

					$result = $obj_group->MJ_gmgt_get_single_group($group_id);

				}

				?>

				<div class="panel-body padding_0"><!--PANEL BODY DIV START-->

					<form name="group_form" action="" method="post" class="form-horizontal" id="group_form" enctype="multipart/form-data"><!--GROUP FORM START-->

						<?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>

						<input type="hidden" name="action" value="<?php echo esc_attr($action);?>">

						<input type="hidden" name="group_id" value="<?php echo esc_attr($group_id);?>"  />

						<div class="header">	

							<h3 class="first_hed"><?php esc_html_e('Group Information','gym_mgt');?></h3>

						</div>

						<div class="form-body user_form"> <!--form-Body div Strat-->   

							<div class="row"><!--Row Div--> 

								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

									<div class="form-group input">

										<div class="col-md-12 form-control">

											<input id="group_name" class="form-control validate[required,custom[popup_category_validation]] text-input"  maxlength="50" type="text" value="<?php if($edit){ echo esc_attr($result->group_name);}elseif(isset($_POST['group_name'])) echo esc_attr($_POST['group_name']);?>" name="group_name">

											<label class="" for="group_name"><?php esc_html_e('Group Name','gym_mgt');?><span class="require-field">*</span></label>

										</div>

									</div>

								</div>



								<div class="col-md-6 note_text_notice">

									<div class="form-group input">

										<div class="col-md-12 note_border margin_bottom_15px_res">

											<div class="form-field">

												<textarea name="group_description" class="textarea_height_47px form-control validate[custom[address_description_validation]]" maxlength="500" ><?php if($edit){ echo esc_textarea($result->group_description);}?></textarea>

												<span class="txt-title-label"></span>

												<label class="text-area address active" for=""><?php esc_html_e('Group Description','gym_mgt');?></label>

											</div>

										</div>

									</div>

								</div>

								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

									<div class="form-group input">

										<div class="upload-profile-image-patient">

											<div class="col-md-12 form-control upload-profile-image-frontend">	

												<label class="custom-control-label custom-top-label ml-2" for="photo"><?php esc_html_e('Image','gym_mgt');?></label>

												<div class="col-sm-12">

													<input type="text" id="display_none" id="gmgt_user_avatar_url" class="form-control" name="gmgt_groupimage" readonly value="<?php if($edit)echo esc_url( $result->gmgt_groupimage );elseif(isset($_POST['gmgt_groupimage'])) echo esc_url($_POST['gmgt_groupimage']); ?>" />



													<input type="hidden" name="hidden_upload_user_avatar_image" value="<?php if($edit){ echo esc_attr($result->gmgt_groupimage);}elseif(isset($_POST['gmgt_groupimage'])) echo esc_attr($_POST['gmgt_groupimage']);?>">

													<input id="upload_user_avatar_image" name="gmgt_groupimage" onchange="MJ_gmgt_fileCheck(this);" type="file" class="form-control file" value="<?php esc_html_e( 'Upload image', 'gym_mgt' ); ?>" />

												</div>

											</div>

										</div>	

										<div class="clearfix"></div>

										<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">

											<div id="upload_user_avatar_preview" >

												<?php 

												if($edit) 

												{

													if($result->gmgt_groupimage == "")

													{?>

													<img class="image_preview_css" src="<?php echo get_option( 'gmgt_group_logo' ); ?>">

													<?php 

													}

													else 

													{

														?>

													<img class="image_preview_css" src="<?php if($edit)echo esc_url( $result->gmgt_groupimage ); ?>" />

													<?php 

													}

												}

												else 

												{

													?>

													<img class="image_preview_css" src="<?php echo get_option( 'gmgt_group_logo' ); ?>">

													<?php 

												}?>

											</div>

										</div>

									</div>

								</div>





								<!--nonce-->

									<?php wp_nonce_field( 'save_group_nonce' ); ?>

								<!--nonce-->

							</div>

						</div>

						<!------------   save btn  -------------->  

						<div class="form-body user_form"> <!-- user_form Strat-->   

							<div class="row"><!--Row Div Strat--> 

								<div class="col-md-6 col-sm-6 col-xs-12"><!--save btn--> 

									<input type="submit" value="<?php if($edit){ esc_html_e('Save','gym_mgt'); }else{ esc_html_e('Save','gym_mgt');}?>" name="save_group" class="btn save_btn"/>

								</div><!--save btn--> 

							</div>

						</div>

					</form><!--GROUP FORM END-->

				</div><!--PANEL BODY DIV END-->

			<?php 

		}

		?>

    </div><!--TAB CONTENT DIV END-->

</div><!--PANEL WHITE DIV END-->  

<script type="text/javascript">

	function MJ_gmgt_fileCheck(obj) 

	{

		var fileExtension = ['jpeg', 'jpg', 'png', 'bmp',''];

		if ($.inArray($(obj).val().split('.').pop().toLowerCase(), fileExtension) == -1)

		{

			alert("<?php esc_html_e("Only .jpeg, .jpg, .png, .bmp formats are allowed.",'gym_mgt');?>");

			$(obj).val('');

		}	

	}

</script>