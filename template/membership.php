<?php 

$obj_membership=new MJ_gmgt_membership;

$obj_activity=new MJ_gmgt_activity;

$active_tab = isset($_REQUEST['tab'])?$_REQUEST['tab']:'membershiplist';

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

//SAVE MEMBERSHIP DATA

if(isset($_POST['save_membership']))

{

	$nonce = $_POST['_wpnonce'];

	if (wp_verify_nonce( $nonce, 'save_membership_nonce' ) )

	{

		if(isset($_FILES['gmgt_membershipimage']) && !empty($_FILES['gmgt_membershipimage']) && $_FILES['gmgt_membershipimage']['size'] !=0)

		{

			if($_FILES['gmgt_membershipimage']['size'] > 0)

			{

				$member_image=MJ_gmgt_load_documets($_FILES['gmgt_membershipimage'],'gmgt_membershipimage','pimg');

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

				$result=$obj_membership->MJ_gmgt_add_membership($_POST,$member_image_url);

				if($result)

				{

					if(isset($_REQUEST['page_action']) && isset($_REQUEST['page_action']) == 'web_view_hide')

					{

						wp_redirect ( home_url().'?dashboard=user&page=membership&tab=membershiplist&page_action=web_view_hide&membership_app_view=membershiplist_app_view&message=2');

					}

					else

					{

						wp_redirect ( home_url().'?dashboard=user&page=membership&tab=membershiplist&message=2');

					}

				}

			}

			else

			{

				$result=$obj_membership->MJ_gmgt_add_membership($_POST,$member_image_url);

				if($result)

				{

					if(isset($_REQUEST['page_action']) && isset($_REQUEST['page_action']) == 'web_view_hide')

					{

						wp_redirect ( home_url().'?dashboard=user&page=membership&tab=membershiplist&page_action=web_view_hide&membership_app_view=membershiplist_app_view&message=1');

					}

					else

					{

						wp_redirect ( home_url().'?dashboard=user&page=membership&tab=membershiplist&message=1');

					}

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

//Delete MEMBERSHIP DATA

if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')

{	

	$result=$obj_membership->MJ_gmgt_delete_membership($_REQUEST['membership_id']);

	if($result)

	{

		if(isset($_REQUEST['page_action']) &&isset($_REQUEST['page_action']) == 'web_view_hide')

		{

			wp_redirect ( home_url().'?dashboard=user&page=membership&tab=membershiplist&page_action=web_view_hide&membership_app_view=membershiplist_app_view&message=3');

		}

		else

		{

			wp_redirect ( home_url().'?dashboard=user&page=membership&tab=membershiplist&message=3');

		}

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

			<p><?php esc_html_e('Membership added successfully.','gym_mgt');?></p>

		</div>

	<?php 	

	}

	elseif($message == 2)

	{?>

		<div id="message" class="alert_msg alert alert-success alert-dismissible " role="alert">

			<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span>

			</button>

			<p><?php esc_html_e("Membership updated successfully.",'gym_mgt');?></p>

		</div>

	<?php	

	}

	elseif($message == 3) 

	{?>

		<div id="message" class="alert_msg alert alert-success alert-dismissible " role="alert">

			<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span>

			</button>

			<p><?php esc_html_e('Membership deleted successfully.','gym_mgt');?></p>

		</div>

	<?php		

	}

}?>

<script type="text/javascript">

	$(document).ready(function() 

	{

		"use strict";

		$('#membership_form').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});		

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



	<div class="tab-content padding_0"><!--TAB CONTENT DIV  START--> 

	

    	<?php 

		if($active_tab == 'membershiplist')

		{ 

			if($obj_gym->role == 'member')

			{	

				if($user_access['own_data']=='1')

				{

					$user_id=get_current_user_id();

					$membership_id = get_user_meta( $user_id,'membership_id', true ); 

					$membershipdata=$obj_membership->MJ_gmgt_get_member_own_membership($membership_id);			

				}

				else

				{

					$membershipdata=$obj_membership->MJ_gmgt_get_all_membership();

				}	

			}

			elseif($obj_gym->role == 'staff_member' || $obj_gym->role == 'accountant')

			{

				if($user_access['own_data'] == '1')

				{

					$user_id=get_current_user_id();							

					$membershipdata=$obj_membership->MJ_gmgt_get_membership_by_created_by($user_id);

					

					

				}

				else

				{

					$membershipdata=$obj_membership->MJ_gmgt_get_all_membership();

				}

			}

			?>

			<div class="gms_main_list"><!-- MAIN_LIST_MARGING_15px START -->

				<?php

				if(!empty($membershipdata))

				{

					?>

					<script type="text/javascript">

						$(document).ready(function() 

						{

							"use strict";

							jQuery('#membership_list').DataTable({

								// "responsive": true,

								dom: 'lifrtp',

								// "order": [[ 1, "asc" ]],

								"aoColumns":[

											{"bSortable": false},

											{"bSortable": true},

											{"bSortable": true},

											{"bSortable": true},

											{"bSortable": true},

											{"bSortable": true},

											{"bSortable": true},	

											{"bSortable": false}

											],

										language:<?php echo MJ_gmgt_datatable_multi_language();?>		  

								});

								$('.dataTables_filter input').attr("placeholder", "<?php esc_html_e('Search...', 'gym_mgt') ?>");

						} );

					</script>

					<div class="panel-body padding_0"><!--PANEL BODY DIV START--> 

						<div class="table-responsive"><!--TABLE RESPONSIVE DIV START--> 

							<table id="membership_list" class="display dataTable " cellspacing="0" width="100%"><!--MEMBERSHIP LIST TABLE START--> 

								<thead class="<?php echo MJ_gmgt_datatable_heder(); ?>">

									<tr id="height_50">

									<th><?php esc_html_e('Photo','gym_mgt');?></th>

										<th><?php  esc_html_e( 'Membership Name', 'gym_mgt' ) ;?></th>

										<th><?php esc_html_e( 'Membership Period (Days)', 'gym_mgt' ) ;?></th>

										<th><?php esc_html_e( 'Membership Amount', 'gym_mgt' ) ;?>(<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?>)</th>

										<th> <?php esc_html_e( 'Installment Plan', 'gym_mgt' ) ;?>(<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?>)</th>

										<th> <?php esc_html_e( 'Signup Fee', 'gym_mgt' ) ;?>(<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?>)</th>

										<th> <?php esc_html_e( 'Tax', 'gym_mgt' ) ;?>(%)</th>												

										<th class="text_align_end"><?php  esc_html_e( 'Action', 'gym_mgt' ) ;?></th>						

									</tr>

								</thead>

								<tbody>

									<?php

									if($obj_gym->role == 'member')

									{	

										if($user_access['own_data']=='1')

										{

											$user_id=get_current_user_id();

											$membership_id = get_user_meta( $user_id,'membership_id', true ); 

											$membershipdata=$obj_membership->MJ_gmgt_get_member_own_membership($membership_id);			

										}

										else

										{

											$membershipdata=$obj_membership->MJ_gmgt_get_all_membership();

										}	

									}

									elseif($obj_gym->role == 'staff_member' || $obj_gym->role == 'accountant')

									{

										if($user_access['own_data'] == '1')

										{

											$user_id=get_current_user_id();							

											$membershipdata=$obj_membership->MJ_gmgt_get_membership_by_created_by($user_id);

											

											

										}

										else

										{

											$membershipdata=$obj_membership->MJ_gmgt_get_all_membership();

										}

									}

									if(!empty($membershipdata))

									{

										foreach ($membershipdata as $retrieved_data)

										{

						

											if($retrieved_data->install_plan_id == 0)

											{

												$plan_id="";

											}

											else

											{

												$plan_id=get_the_title( $retrieved_data->install_plan_id );

											}

											?>

											<tr>

												<td class="user_image width_50px padding_left_0 list_img">

													<?php 

													$userimage=$retrieved_data->gmgt_membershipimage;

													if(empty($userimage))

													{

														echo '<img src='.get_option( 'gmgt_Membership_logo' ).'  id="width_50" class="height_50 img-circle" />';

													}

													else

													{

														echo '<img src='.$userimage.'  id="width_50" class="height_50 img-circle"/>';

													}

													?>

												</td>

												<td class="membershipname">

													<?php 

													if(isset($_REQUEST['membership_app_view']) && $_REQUEST['membership_app_view'] == 'membershiplist_app_view' || isset($_REQUEST['page_action']) && $_REQUEST['page_action'] == 'web_view_hide')

													{

														echo esc_html($retrieved_data->membership_label);

													}	

													elseif($obj_gym->role == 'staff_member' || $obj_gym->role == 'accountant')

													{ ?>

														<a href="?dashboard=user&page=membership&tab=addmembership&action=edit&membership_id=<?php echo $retrieved_data->membership_id;?>"><?php echo esc_html($retrieved_data->membership_label);?></a>

															<?php

													}

													else

													{?>

														<?php echo esc_html($retrieved_data->membership_label);?>

														<?php 

													}?>

													<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Membership Name','gym_mgt');?>" ></i>

												</td>

												<td class="membershiperiod">

													<?php echo esc_html($retrieved_data->membership_length_id);?>

													<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Membership Period','gym_mgt');?> (<?php _e('Days','gym_mgt');?>)" ></i>

												</td>

												<td class="">

													<?php echo esc_html($retrieved_data->membership_amount);?>

													<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Membership Amount','gym_mgt');?> (<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ));?>)" ></i>

												</td>

												<td class="installmentplan">

													<?php echo esc_html($retrieved_data->installment_amount)." ".esc_html($plan_id);?>

													<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Installment Plan','gym_mgt');?> (<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ));?>)" ></i>

												</td>

												<td class="signup_fee">

													<?php echo esc_html($retrieved_data->signup_fee);?>

													<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Signup Fee','gym_mgt');?> (<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ));?>)" ></i>

												</td>

												<td class="">

													<?php 

													if(!empty($retrieved_data->tax)) 

													{ 

														echo MJ_gmgt_tax_name_by_tax_id_array(esc_html($retrieved_data->tax)); 

													}

													else

													{ 

														echo 'N/A'; 

													} ?>

													<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php esc_html_e( 'Tax', 'gym_mgt' ) ;?>(%)" ></i>

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

																		<a href="#" class="view_details_popup float_left_width_100" id="<?php echo esc_attr($retrieved_data->membership_id)?>" type="<?php echo 'view_membership';?>"><i class="fa fa-eye"></i> <?php esc_html_e('View', 'gym_mgt' ) ;?> </a>

																	</li>

																	<?php

																	if(isset($_REQUEST['membership_app_view']) && $_REQUEST['membership_app_view'] == 'membershiplist_app_view')

																	{

																		?>

																			<li class="float_left_width_100">	

																				<a href="?dashboard=user&page=membership&tab=view-activity&membership_id=<?php echo $retrieved_data->membership_id?>&membership_app_view=membershiplist_app_view&page_action=web_view_hide" class="float_left_width_100"><i class="fa fa-eye"></i> <?php esc_html_e('View Activities', 'gym_mgt' );?></a>

																			</li>

																		<?php

																	}

																	else

																	{

																		?>

																		<li class="float_left_width_100">	

																			<a href="?dashboard=user&page=membership&tab=view-activity&membership_id=<?php echo $retrieved_data->membership_id?>" class="float_left_width_100"><i class="fa fa-eye"></i> <?php esc_html_e('View Activities', 'gym_mgt' );?></a>

																		</li>

																		<?php	

																	}?>	

																	<?php

																	if($user_access['edit']=='1')

																	{

																		if(isset($_REQUEST['membership_app_view']) && $_REQUEST['membership_app_view'] == 'membershiplist_app_view')

																			{

																				?>

																				<li class="float_left_width_100 border_bottom_item">	

																					<a href="?dashboard=user&page=membership&tab=addmembership&action=edit&membership_app_view=membershiplist_app_view&page_action=web_view_hide&membership_id=<?php echo esc_attr($retrieved_data->membership_id)?>" class="float_left_width_100"><i class="fa fa-edit"></i> <?php esc_html_e('Edit', 'gym_mgt' ) ;?></a>

																					</li>

																				<?php

																			}

																			else

																			{

																				?>

																				<li class="float_left_width_100 border_bottom_item">	

																					<a href="?dashboard=user&page=membership&tab=addmembership&action=edit&membership_id=<?php echo esc_attr($retrieved_data->membership_id)?>" class="float_left_width_100"><i class="fa fa-edit"></i> <?php esc_html_e('Edit', 'gym_mgt' ) ;?></a>

																				</li>

																				<?php

																			}

																	}

																	if($user_access['delete']=='1')

																	{

																		if(isset($_REQUEST['membership_app_view']) && $_REQUEST['membership_app_view'] == 'membershiplist_app_view')

																		{

																			?>	

																			<li class="float_left_width_100">		

																				<a href="?dashboard=user&page=membership&tab=membershiplist&action=delete&membership_app_view=membershiplist_app_view&page_action=web_view_hide&membership_id=<?php echo esc_attr($retrieved_data->membership_id);?>" class="float_left_width_100 list_delete_btn" onclick="return confirm('<?php esc_html_e('Are you sure you want to delete this record?','gym_mgt');?>');"><i class="fa fa-trash"></i> <?php esc_html_e( 'Delete', 'gym_mgt' ) ;?> </a>

																			</li>

																				<?php

																		}

																		else

																		{

																			?>

																			<li class="float_left_width_100">		

																				<a href="?dashboard=user&page=membership&tab=membershiplist&action=delete&membership_id=<?php echo esc_attr($retrieved_data->membership_id);?>" class="float_left_width_100 list_delete_btn" onclick="return confirm('<?php esc_html_e('Are you sure you want to delete this record?','gym_mgt');?>');"><i class="fa fa-trash"></i> <?php esc_html_e( 'Delete', 'gym_mgt' ) ;?> </a>

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

							</table><!--MEMBERSHIP LIST TABLE END-->

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

							<a href="<?php echo home_url().'?dashboard=user&page=membership&tab=addmembership&&action=insert';?>">

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

				?>

			</div><!--MAIN_LIST_MARGING_15px END  -->

			<?php

		}

		if($active_tab == 'addmembership')

		{  ?>

			<script type="text/javascript">

				$(document).ready(function()

				{

					"use strict";

					var member_limit='';

					$('#membership_form').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});

					$('#activity_id').multiselect(

					{

						nonSelectedText :'<?php esc_html_e('Select Activity','gym_mgt');?>',

						includeSelectAllOption: true,

						allSelectedText :'<?php esc_html_e('All Selected','gym_mgt'); ?>',

						selectAllText : '<?php esc_html_e('Select all','gym_mgt'); ?>',

						templates: {

								button: '<button class="multiselect btn btn-default dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><span class="multiselect-selected-text"></span><b class="caret"></b></button>',

							},

						buttonContainer: '<div class="dropdown" />'

					});	

					

					$('#activity_category').multiselect(

					{

						nonSelectedText :'<?php esc_html_e('Select Activity Category','gym_mgt');?>',

						includeSelectAllOption: true,

						allSelectedText :'<?php esc_html_e('All Selected','gym_mgt'); ?>',

						selectAllText : '<?php esc_html_e('Select all','gym_mgt'); ?>',

						templates: {

								button: '<button class="multiselect btn btn-default dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><span class="multiselect-selected-text"></span><b class="caret"></b></button>',

							},

						buttonContainer: '<div class="dropdown" />'

					});	

					

					$('.tax_charge').multiselect(

					{

						nonSelectedText :'<?php esc_html_e('Select Tax','gym_mgt');?>',

						includeSelectAllOption: true,

						allSelectedText :'<?php esc_html_e('All Selected','gym_mgt'); ?>',

						selectAllText : '<?php esc_html_e('Select all','gym_mgt'); ?>',

						templates: {

								button: '<button class="multiselect btn btn-default dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><span class="multiselect-selected-text"></span><b class="caret"></b></button>',

							},

						buttonContainer: '<div class="dropdown" />'

					});

				});

			</script>

			<?php 

			$obj_membership=new MJ_gmgt_membership;

			$obj_activity=new MJ_gmgt_activity;

			$membership_id=0;

			$edit=0;

			if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')

			{

				$edit=1;

				$membership_id=esc_attr($_REQUEST['membership_id']);

				$result = $obj_membership->MJ_gmgt_get_single_membership($membership_id);

			}?>

			<div class="panel-body padding_0"><!-- PANEL BODY DIV START -->

				<form name="membership_form" action="" method="post" class="form-horizontal" id="membership_form" enctype="multipart/form-data"><!--MEMBERSHIP FORM START-->

				 <?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>

				<input type="hidden" name="action" value="<?php echo esc_attr($action);?>">

				<input type="hidden" name="membership_id" class="membership_id_activity" value="<?php echo esc_attr($membership_id);?>"  />

				

				<div class="header">	

					<h3 class="first_hed"><?php esc_html_e('Membership Information','gym_mgt');?></h3>

				</div>

				<div class="form-body user_form"> <!-- user_form Strat-->   

					<div class="row"><!--Row Div Strat--> 



						<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">

							<div class="form-group input">

								<div class="col-md-12 form-control">

									<input id="membership_name" class="form-control validate[required,custom[onlyLetter_specialcharacter]] text-input"  maxlength="50" type="text" value="<?php if($edit){ echo esc_attr($result->membership_label);}elseif(isset($_POST['membership_name'])) echo esc_attr($_POST['membership_name']);?>" name="membership_name">

									<label class="" for="membership_name"><?php esc_html_e('Membership Name','gym_mgt');?><span class="require-field">*</span></label>

								</div>

							</div>

						</div>

						<!--nonce-->

						<?php wp_nonce_field( 'save_membership_nonce' ); ?>

						<!--nonce-->

						<div class="col-sm-12 col-md-5 col-lg-5 col-xl-5 input">

							<label class="ml-1 custom-top-label top" for="membership_category"><?php esc_html_e('Membership Category','gym_mgt');?><span class="require-field">*</span></label>									

							<select class="form-control validate[required]  selectpicker span3 max_width_100" name="membership_category" id="membership_category">

								<option value=""><?php esc_html_e('Select Membership Category','gym_mgt');?></option>

								<?php 				

								if(isset($_REQUEST['membership_category']))

								{

									$category =esc_attr($_REQUEST['membership_category']);  

								}

								elseif($edit)

								{

									$category =$result->membership_cat_id;

								}

								else

								{

									$category = "";

								}

								$mambership_category=MJ_gmgt_get_all_category('membership_category');

								if(!empty($mambership_category))

								{

									foreach ($mambership_category as $retrive_data)

									{

										echo '<option value="'.esc_attr($retrive_data->ID).'" '.selected(esc_attr($category),esc_attr($retrive_data->ID)).'>'.esc_html($retrive_data->post_title) .'</option>';

									}

								}

								?>				

							</select>

						</div>

						<div class="col-sm-12 col-md-1 col-lg-1 col-xl-1 mb-3 rtl_margin_top_15px">		

							<button  id="addremove" class="btn add_btn " model="membership_category"><?php esc_html_e('Add','gym_mgt');?></button>

						</div>





						<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">

							<div class="form-group input">

								<div class="col-md-12 form-control">

									<input id="membership_period" class="form-control validate[required,custom[number]] text-input" min="0" type="number" onKeyPress="if(this.value.length==3) return false;" value="<?php if($edit){ echo esc_attr($result->membership_length_id);}elseif(isset($_POST['membership_period'])) echo esc_attr($_POST['membership_period']);?>" name="membership_period" placeholder="<?php esc_html_e('Enter Total Number of Days','gym_mgt');?>">

									<label class="" for="membership_period"><?php esc_html_e('Membership Period(Days)','gym_mgt');?><span class="require-field">*</span></label>

								</div>

							</div>

						</div>

						

						<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">

							<div class="form-group input">

								<div class="col-md-12 form-control">

									<input id="membership_amount" class="form-control text-input validate[required]" type="number" min="0" onkeypress="if(this.value.length==8) return false;" step="0.01" value="<?php if($edit){ echo esc_attr($result->membership_amount);}elseif(isset($_POST['membership_amount'])) echo esc_attr($_POST['membership_amount']);?>" name="membership_amount" placeholder="<?php esc_html_e('Amount','gym_mgt');?>">

									<label class="" for="installment_amount"><?php esc_html_e('Membership Amount','gym_mgt');?>(<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?>)<span class="require-field">*</span></label>

								</div>

							</div>

						</div>

					</div><!--Row Div End--> 

				</div> <!-- user_form End-->  		



			<div class="form-body user_form"> <!-- user_form Strat-->   

				<div class="row"><!--Row Div Strat--> 

					

					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 res_margin_bottom_15px rtl_margin_top_15px">

						<div class="form-group">

							<div class="col-md-12 form-control">

								<div class="row padding_radio">

									<div class="input-group">

										<label class="custom-top-label" for="member_limit"><?php esc_html_e('Members Limit','gym_mgt');?></label>

										<div class="d-inline-block gender_line_height_24px">

											<?php $limitval = "unlimited"; if($edit){ $limitval=$result->membership_class_limit; }elseif(isset($_POST['gender'])) {$limitval=sanitize_text_field($_POST['gender']);}?>

											<label class="radio-inline custom_radio">

												<input type="radio" value="limited" class="tog" name="member_limit" <?php checked('limited',esc_html($limitval)); ?>/> <?php esc_html_e('limited','gym_mgt');?>

											</label>&nbsp;&nbsp;

											<label class="radio-inline custom_radio">

												<input type="radio" value="unlimited" class="tog" name="member_limit" <?php checked('unlimited',esc_html($limitval)); ?>/> <?php esc_html_e('unlimited','gym_mgt');?> 

											</label>

										</div>

									</div>

								</div>		

							</div>

						</div>

					</div>

					

					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 res_margin_bottom_15px rtl_margin_top_15px">

						<div class="form-group">

							<div class="col-md-12 form-control">

								<div class="row padding_radio">

									<div class="input-group">

										<label class="custom-top-label" for="classis_limit"><?php esc_html_e('Class Limit','gym_mgt');?></label>

										<div class="d-inline-block gender_line_height_24px">

											<?php $limitvals = "unlimited"; if($edit){ $limitvals=$result->classis_limit; }elseif(isset($_POST['gender'])) {$limitvals=sanitize_text_field($_POST['gender']);}?>

											<label class="radio-inline">

												<input type="radio" value="limited" class="classis_limit tog" name="classis_limit" <?php checked('limited',esc_html($limitvals)); ?>/> <?php esc_html_e('limited','gym_mgt');?>

											</label>&nbsp;&nbsp;

											<label class="radio-inline">

												<input type="radio" value="unlimited" class="classis_limit tog validate[required]" name="classis_limit" <?php checked('unlimited',esc_html($limitvals)); ?>/> <?php esc_html_e('unlimited','gym_mgt');?> 

											</label>

										</div>

									</div>

								</div>

							</div>		

						</div>

					</div>



					<div  class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">

						<div id="member_limit" class=""></div>

						<?php 

						if($edit)

						{

							if($result->membership_class_limit!='unlimited')

							{ 

							?>

								<div id="on_of_member_box" class="form-group input">

									<div class="col-md-12 form-control">

										<input id="on_of_member" class="form-control text-input" type="number" min="0" onkeypress="if(this.value.length==4) return false;" value="<?php print esc_attr($result->on_of_member) ?>" name="on_of_member">

										<label class="active" for="on_of_member"><?php esc_html_e('No Of Member','gym_mgt');?></label>

									</div>

								</div>

								

							<?php } ?>

						<?php	

						}

						?>

					</div>



					<div  class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">

						<div id="classis_limit" class=""></div>

						<?php

						if($edit)

						{

							if($result->classis_limit!='unlimited')

							{ 

							?>

								<div id="on_of_classis_box" class="form-group input">

									<div class="col-md-12 form-control">

										<input id="on_of_classis" class="form-control  text-input" type="number" min="0" onkeypress="if(this.value.length==4) return false;" value="<?php print esc_attr($result->on_of_classis) ?>" name="on_of_classis">

										<label class="active radio_class_member" for="on_of_classis"><?php esc_html_e('No Of Class','gym_mgt');?></label>

									</div>

								</div>

							<?php

							} 

						} 

						?>

					</div>

				</div><!--Row Div End--> 

			</div> <!-- user_form End-->  



			<div class="form-body user_form"> <!-- user_form Strat-->   

				<div class="row"><!--Row Div Strat--> 	



					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">

						<div class="form-group input">

							<div class="col-md-12 form-control">

								<input id="installment_amount" class="form-control text-input" min="0" onkeypress="if(this.value.length==8) return false;" step="0.01" type="number" value="<?php if($edit){ echo esc_attr($result->installment_amount);}elseif(isset($_POST['installment_amount'])) echo esc_attr($_POST['installment_amount']);?>" name="installment_amount" placeholder="<?php esc_html_e('Amount','gym_mgt');?>">

								<label class="" for="installment_plan"><?php esc_html_e('Installment Amount','gym_mgt');?>(<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?>)</label>

							</div>

						</div>

					</div>

					<div class="col-sm-12 col-md-5 col-lg-5 col-xl-5 input ">

						<label class="ml-1 custom-top-label top" for="staff_name"><?php esc_html_e('Select Installment Plan','gym_mgt');?></label>

						<select class="form-control form-label max_width_100" name="installment_plan" id="installment_plan">

							<option value=""><?php esc_html_e('Select Installment Plan','gym_mgt');?></option>

							<?php

							if(isset($_REQUEST['installment_plan']))

							{

								$category =esc_attr($_REQUEST['installment_plan']);  

							}

							elseif($edit)

							{

								$category =$result->install_plan_id;

							}

							else

							{	

								$category = "";

							}

							$installment_plan=MJ_gmgt_get_all_category('installment_plan');

							if(!empty($installment_plan))

							{

								foreach ($installment_plan as $retrive_data)

								{

									echo '<option value="'.esc_attr($retrive_data->ID).'" '.selected(esc_attr($category),esc_attr($retrive_data->ID)).'>'.esc_html($retrive_data->post_title).'</option>';

								}

							}

							?>

						</select>

					</div>

					<div class="col-sm-12 col-md-1 col-lg-1 col-xl-1 mb-3 rtl_margin_top_15px">		

						<button id="addremove"  class="btn add_btn " model="installment_plan"><?php esc_html_e('Add','gym_mgt');?></button>

					</div>

						

					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">

						<div class="form-group input">

							<div class="col-md-12 form-control">

								<input id="signup_fee" class="form-control text-input" min="0"  onkeypress="if(this.value.length==8) return false;" step="0.01" type="number" value="<?php if($edit){ echo esc_attr($result->signup_fee);}elseif(isset($_POST['membership_name'])) echo esc_attr($_POST['membership_name']);?>" name="signup_fee" placeholder="<?php esc_html_e('Amount','gym_mgt');?>" >

								<label class="" for="signup_fee"><?php esc_html_e('Signup Fee','gym_mgt');?>(<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?>)</label>

							</div>

						</div>

					</div>



					<div class="rtl_margin_top_15px col-sm-6 col-md-6 col-lg-6 col-xl-6 res_margin_bottom_20px multiselect_validation_member smgt_multiple_select">

						<!-- <label class="col-sm-2 control-label form-label" for=""><?php esc_html_e('Tax','gym_mgt');?>(%)</label> -->

						<select  class="form-control tax_charge" name="tax[]" multiple="multiple">

							<?php

							if($edit)

							{

								$tax_id=explode(',',$result->tax);

							}

							else

							{

								$tax_id[]='';

							}

							$obj_tax=new MJ_gmgt_tax;

							$gmgt_taxs=$obj_tax->MJ_gmgt_get_all_taxes();

							if(!empty($gmgt_taxs))

							{

								foreach($gmgt_taxs as $data)

								{

									$selected = "";

									if(in_array($data->tax_id,$tax_id))

										$selected = "selected";

									?>

									<option value="<?php echo esc_attr($data->tax_id); ?>" <?php echo esc_html($selected); ?> ><?php echo esc_html($data->tax_title);?> - <?php echo esc_html($data->tax_value);?></option>

								<?php

								}

							}

							?>

						</select>

					</div>



					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 res_margin_bottom_20px multiselect_validation_member smgt_multiple_select">

						<!-- <label class="col-sm-2 control-label form-label" for="activity_category"><?php esc_html_e('Select Activity Category','gym_mgt');?></label> -->

						<?php

						if($edit)

						{

						?>

							<input type="hidden" class="action_membership" value="edit_membership">

						<?php

						}

						else

						{

						?>

							<input type="hidden" class="action_membership" value="add_membership">

						<?php

						}

						?>

						<select class="form-control activity_category_list activity_width_title" name="activity_cat_id[]" multiple="multiple" id="activity_category"><?php 

							$activity_category=MJ_gmgt_get_all_category('activity_category');

							if($edit)

							{

								$activity_category_array=explode(',',$result->activity_cat_id);

							}

							else

							{	

								$activity_category_array[]='';

							}

							

							if(!empty($activity_category))

							{

								foreach ($activity_category as $retrive_data)

								{		

									$selected = "";

									if(in_array($retrive_data->ID,$activity_category_array))

										$selected = "selected";

									?>

										<option value="<?php echo esc_attr($retrive_data->ID);?>" <?php echo esc_html($selected); ?>><?php echo esc_html($retrive_data->post_title);?></option>

									<?php

								}

							}

							?>

						</select>

					</div>

							
				
					<div class="rtl_margin_top_15px col-sm-6 col-md-6 col-lg-6 col-xl-6 res_margin_bottom_20px multiselect_validation_member smgt_multiple_select">

						<!-- <label class="col-sm-2 control-label form-label" for="signup_fee"><?php esc_html_e('Select Activity','gym_mgt');?></label> -->

						<?php 
						if($edit)
						{
							$activitydata=$obj_activity->MJ_gmgt_get_all_activity_by_activity_category($activity_category_array); ?>

							<select name="activity_id[]" id="activity_id" multiple="multiple" class="activity_list_from_category_type">		 <?php 

								$activity_array = $obj_activity->MJ_gmgt_get_membership_activity($membership_id);

								if(!empty($activitydata))

								{

									foreach($activitydata as $activity)

									{

										?>

										<option value="<?php echo esc_attr($activity->activity_id);?>" <?php if(in_array($activity->activity_id,$activity_array)) echo "selected";?>><?php echo esc_html($activity->activity_title);?></option>

									<?php

									}

								}

								?>

							</select>
							<?php
						} ?>

					</div>



					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

						<div class="form-group input">

							<div class="upload-profile-image-patient">

								<div class="col-md-12 form-control upload-profile-image-frontend">	

									<label class="custom-control-label custom-top-label ml-2" for="photo"><?php esc_html_e('Membership Image','gym_mgt');?></label>

									<div class="col-sm-12">

										<input type="text" id="display_none" id="gmgt_user_avatar_url" class="form-control" name="gmgt_membershipimage"  readonly value="<?php if($edit)echo esc_url( $result->gmgt_membershipimage );elseif(isset($_POST['gmgt_membershipimage'])) echo esc_url($_POST['gmgt_membershipimage']); ?>" />

								

										<input type="hidden" name="hidden_upload_user_avatar_image" value="<?php if($edit){ echo esc_url($result->gmgt_membershipimage);}elseif(isset($_POST['gmgt_membershipimage'])) echo esc_url($_POST['gmgt_membershipimage']);?>">

										<input id="upload_user_avatar_image" name="gmgt_membershipimage" onchange="MJ_gmgt_fileCheck(this);" type="file" class="form-control file " value="<?php esc_html_e( 'Upload image', 'gym_mgt' ); ?>" />

									</div>

								</div>

								<div class="clearfix"></div>

									<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">

										<div id="upload_user_avatar_preview" >

											<?php

											if($edit) 

											{

												if($result->gmgt_membershipimage == "")

												{?>

													<img class="image_preview_css" src="<?php echo esc_url(get_option( 'gmgt_Membership_logo' )); ?>">

												<?php

												}

												else 

												{

												?>

													<img class="image_preview_css" src="<?php if($edit)echo esc_url(esc_url( $result->gmgt_membershipimage )); ?>" />

												<?php 

												}

											}

											else 

											{

											?>

												<img class="image_preview_css" src="<?php echo esc_url(get_option( 'gmgt_Membership_logo' )); ?>">

											<?php

											}

											?>

										</div>

									</div>

								</div>

							</div>

						</div>

					</div>

					

					

				</div><!--Row Div End--> 

			</div><!-- user_form End-->

					

			<div class="form-body user_form"> <!-- user_form Strat-->   

				<div class="row"><!--Row Div Strat-->



					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 rtl_margin_top_15px ">

						<div class="form-group">

							<div class="col-md-12 form-control">

								<div class="row padding_radio">

									<div class="">

										<label class="custom-top-label" for="gmgt_membershipimage"><?php esc_html_e('Frontend Membership Booking','gym_mgt');?></label>

										<input type="checkbox" class="check_box_input_margin" name="gmgt_membership_class_book_approve" value="yes" <?php if($edit){ if($result->gmgt_membership_class_book_approve == 'yes') { echo 'checked'; } }?> /> <?php esc_html_e('Enable','gym_mgt'); ?>

									</div>												

								</div>

							</div>

						</div>

					</div>



					<?php

					$gym_recurring_enable=get_option("gym_recurring_enable");

					if($gym_recurring_enable == "yes" || $gym_recurring_invoice_enable == "yes")

					{

						?>

						<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 rtl_margin_top_15px">

							<div class="form-group">

								<div class="col-md-12 form-control">

									<div class="row padding_radio">

										<div class="">

											<label class="custom-top-label" for="gmgt_membership_recurring"><?php esc_html_e('Membership Recurring Invoices','gym_mgt');?></label>

											<input type="checkbox" class="check_box_input_margin" name="gmgt_membership_recurring" value="yes" <?php if($edit){ if($result->gmgt_membership_recurring == 'yes') { echo 'checked'; } }?> /> <?php esc_html_e('Enable','gym_mgt'); ?>

										</div>											

									</div>

								</div>

							</div>

						</div>

						<?php

					}

					?>

				</div><!--Row Div End--> 

			</div><!-- user_form End--> 

			<div class="form-body user_form">

				<div class="row">

					<div class="col-md-6 col-sm-6 col-xs-12 mt-3"><!--save btn--> 

						<input type="submit" value="<?php if($edit){ esc_html_e('Save Membership','gym_mgt'); }else{ esc_html_e('Add Membership','gym_mgt');}?>" name="save_membership" class="btn save_btn"/>

					</div>

				</div><!--Row Div End--> 

			</div><!-- user_form End--> 

	        </form><!--MEMBERSHIP FORM END-->

			</div><!-- PANEL BODY DIV END -->

		<?php 

		}

		if($active_tab == 'view-activity')

		{

			?>

			<div class="gms_main_list"><!-- MAIN_LIST_MARGING_15px START -->

				<script type="text/javascript">

					$(document).ready(function() 

					{

						"use strict";

						$('#activity_id').multiselect();

						$('#acitivity_form').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});	
					
					} );

				</script>
				<script type="text/javascript">

					$(document).ready(function()

					{

						"use strict";

						jQuery('#activity_list_123').DataTable(

						{

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
				<?php

				$membership_id=0;

				if(isset($_REQUEST['membership_id']))

					$membership_id=esc_attr($_REQUEST['membership_id']);

				$activity_result = $obj_membership->MJ_gmgt_get_membership_activities($membership_id); 
				if(!empty($activity_result))

				{	
					?>

					<form name="wcwm_report" action="" method="post">    <!-- ACTIVITY LIST FORM START -->

						<div class="panel-body padding_0"><!-- PANEL BODY DIV START -->

							<div class="table-responsive"><!-- TABLE RESPONSIVE DIV START -->

								<table id="activity_list_123" class="display" cellspacing="0" width="100%"><!-- TABLE ACTIVITY LIST START -->

									<thead>

										<tr>

											<th><?php  esc_html_e( 'Photo', 'gym_mgt' ) ;?></th>

											<th><?php  esc_html_e( 'Activity Name', 'gym_mgt' ) ;?></th>

											<th><?php  esc_html_e( 'Activity Category', 'gym_mgt' ) ;?></th>

											<th><?php  esc_html_e( 'Activity Trainer', 'gym_mgt' ) ;?></th>

											<th><?php  esc_html_e( 'Membership Name', 'gym_mgt' ) ;?></th>

										</tr>

									</thead>

									<tfoot>

										<tr>

											<th><?php  esc_html_e( 'Photo', 'gym_mgt' ) ;?></th>

											<th><?php  esc_html_e( 'Activity Name', 'gym_mgt' ) ;?></th>

											<th><?php  esc_html_e( 'Activity Category', 'gym_mgt' ) ;?></th>

											<th><?php  esc_html_e( 'Activity Trainer', 'gym_mgt' ) ;?></th>

											<th><?php  esc_html_e( 'Membership Name', 'gym_mgt' ) ;?></th>	

										</tr>

									</tfoot>

									<tbody>

									<?php 				

									if(!empty($activity_result))

									{		

										$i=0;			 

										foreach ($activity_result as $activities)

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

											$retrieved_data=$obj_activity->MJ_gmgt_get_single_activity($activities->activity_id);

											?>

											<tr>

												<td class="user_image width_50px profile_image_prescription padding_left_0">	

													<p class="prescription_tag padding_15px margin_bottom_0px <?php echo $color_class; ?>">	

														<img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/Activity.png"?>" alt="" class="massage_image center image_icon_height_25px margin_top_3px">

													</p>

												</td>

												<td class="activityname">

													<a href="#"><?php echo esc_html($retrieved_data->activity_title);?></a>

													<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Activity Name','gym_mgt');?>" ></i>

												</td>

												<td class="category">

													<?php echo get_the_title(esc_html($retrieved_data->activity_cat_id));?>

													<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Activity Category','gym_mgt');?>" ></i>

												</td>

												<td class="productquentity">

													<?php 

													$user=get_userdata($retrieved_data->activity_assigned_to); 

													if(!empty($user->display_name))

													{	

														echo esc_html($user->display_name);

													}

													else

													{

														echo "N/A";

													}

													?>

													<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Activity Trainer','gym_mgt');?>" ></i>

												</td>

												<td class="membership">

													<?php echo esc_html(MJ_gmgt_get_membership_name($activities->membership_id));?>

													<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Membership Name','gym_mgt');?>" ></i>

												</td>

											</tr>

											<?php

											$i++;

										} 									

									} ?>						 

									</tbody>				

								</table><!-- TABLE ACTIVITY LIST END -->

							</div><!-- TABLE RESPONSIVE DIV END -->

						</div> <!-- PANEL BODY DIV END -->   

					</form><!-- FORM ACTIVITY LIST END -->

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

		?>

	</div>

</div>

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