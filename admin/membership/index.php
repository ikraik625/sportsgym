<?php 

	$obj_membership=new MJ_gmgt_membership;

	$obj_activity=new MJ_gmgt_activity;

	$active_tab = isset($_GET['tab'])?$_GET['tab']:'membershiplist';

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

		$user_access=MJ_gmgt_get_userrole_wise_manually_page_access_right_array_for_management('membership');

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

				if ('membership' == $user_access['page_link'] && ($_REQUEST['action']=='edit'))

				{

					if($user_access_edit=='0')

					{	

						MJ_gmgt_access_right_page_not_access_message_for_management();

						die;

					}			

				}

				if ('membership' == $user_access['page_link'] && ($_REQUEST['action']=='delete'))

				{

					if($user_access_delete=='0')

					{	

						MJ_gmgt_access_right_page_not_access_message_for_management();

						die;

					}	

				}

				if ('membership' == $user_access['page_link'] && ($_REQUEST['action']=='insert'))

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

<div class="page-inner min_height_1631"><!--PAGE INNNER DIV START-->

	<div class="gms_main_list"><!-- MAIN_LIST_MARGING_15px START -->

		<?php 	

		//SAVE MEMBERSHIP DATA

		if(isset($_POST['save_membership']))

		{	

			$nonce = $_POST['_wpnonce'];
			

			if (wp_verify_nonce( $nonce, 'save_membership_nonce' ) )

			{

				if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit')

				{

					$txturl=esc_url_raw($_POST['gmgt_membershipimage']);

					$ext=MJ_gmgt_check_valid_extension($txturl);

					if(!$ext == 0)

					{	

						$result=$obj_membership->MJ_gmgt_add_membership($_POST,$_POST['gmgt_membershipimage']);

						if($result)

						{

							wp_redirect ( admin_url().'admin.php?page=gmgt_membership_type&tab=membershiplist&message=2');

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

					$txturl=esc_url_raw($_POST['gmgt_membershipimage']);

					$ext=MJ_gmgt_check_valid_extension($txturl);

					if(!$ext == 0)

					{

						$result=$obj_membership->MJ_gmgt_add_membership($_POST,esc_url_raw($_POST['gmgt_membershipimage']));

						if($result)

						{

							$wizard = MJ_gmgt_setup_wizard_steps_updates('step2_membership');

							wp_redirect ( admin_url().'admin.php?page=gmgt_membership_type&tab=membershiplist&message=1&membershipid='.$result);

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

			} 

		}

		//DELETE SELECTED MEMBERSHIP DATA

		if(isset($_REQUEST['delete_selected']))

		{		

			if(!empty($_REQUEST['selected_id']))

			{

				foreach($_REQUEST['selected_id'] as $id)

				{

					$delete_membership=$obj_membership->MJ_gmgt_delete_membership($id);

					if($delete_membership)

					{

						wp_redirect ( admin_url().'admin.php?page=gmgt_membership_type&tab=membershiplist&message=3');

					}

				}

			}

			else

			{

				echo '<script language="javascript">';

				echo 'alert("'.esc_html__('Please select at least one record.','gym_mgt').'")';

				echo '</script>';

			}

		}

		//ADD Activity DATA

		if(isset($_POST['add_activities']))

		{

			$membershipid='&tab=membershiplist&message=1';

			if(isset($_POST['membership_id']))

			{

				$membershipid="&tab=view-activity&membership_id=".sanitize_text_field($_POST['membership_id'])."&message=1";

			}

			$result=$obj_activity->MJ_gmgt_add_membership_activities($_POST);	

			if($result)

			{

				wp_redirect ( admin_url().'admin.php?page=gmgt_membership_type'.$membershipid);

			}

		}

		//DELETE MEMBERSHIP DATA	

		if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')

		{

			$result=$obj_membership->MJ_gmgt_delete_membership(esc_attr($_REQUEST['membership_id']));

			if($result)

			{

				wp_redirect ( admin_url().'admin.php?page=gmgt_membership_type&tab=membershiplist&message=3');

			}

		}

		//Delete Activity DATA

		if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete-activity')

		{

			$membershipid='&tab=membershiplist&message=3';

			if(isset($_REQUEST['membership_id']))

			{

				$membershipid="&tab=view-activity&membership_id=".esc_attr($_REQUEST['membership_id'])."&message=3";

			}

			$result=$obj_activity->MJ_gmgt_delete_membership_activity(esc_attr($_REQUEST['assign_id']));

			if($result)

			{

				wp_redirect ( admin_url().'admin.php?page=gmgt_membership_type'.$membershipid);

			}

		}	

		$valtemp=0;

		$newmembershipid=0;

		if(isset($_REQUEST['message']))

		{

			$message =esc_attr($_REQUEST['message']);

			if($message == 1)

			{ 

				$valtemp=$_REQUEST['message'];

				$newmembershipid=isset($_REQUEST['membershipid'])?$_REQUEST['membershipid']:0;

				?>

				<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">

					<p><?php esc_html_e('Membership inserted successfully.','gym_mgt');?></p>

					<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>

				</div>

				<?php

			}

			elseif($message == 2)

			{?>

				<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">

					<p><?php esc_html_e("Membership updated successfully.",'gym_mgt');?></p>

					<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>

				</div>

			<?php	

			}

			elseif($message == 3) 

			{?>

				<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">

					<p><?php esc_html_e('Membership deleted successfully.','gym_mgt');?></p>

					<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>

				</div>

			<?php		

			}

		}

		?>

		<div class="row"><!--ROW DIV START-->

			<div class="col-md-12 padding_0"><!--COL 12 DIV START-->

				<div class="panel-body"><!--PANEL BODY DIV START-->

					<!-- <h2 class="nav-tab-wrapper">

						<a href="?page=gmgt_membership_type&tab=membershiplist" class="nav-tab <?php echo $active_tab == 'membershiplist' ? 'nav-tab-active' : ''; ?>"><?php echo '<span class="dashicons dashicons-menu"></span> '.esc_html__('Membership List', 'gym_mgt'); ?></a>

						<?php  if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')

						{

						?>

							<a href="?page=gmgt_membership_type&tab=addmembership&&action=edit&membership_id=<?php echo esc_attr($_REQUEST['membership_id']);?>" class="nav-tab <?php echo $active_tab == 'addmembership' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e('Edit Membership', 'gym_mgt'); ?></a> 

						<?php

						}

						else

						{

							if($user_access_add == '1')

							{

						?>

							<a href="?page=gmgt_membership_type&tab=addmembership" class="nav-tab <?php echo $active_tab == 'addmembership' ? 'nav-tab-active' : ''; ?>"><?php echo '<span class="dashicons dashicons-plus-alt"></span> '.esc_html__('Add Membership', 'gym_mgt'); ?></a> 

						<?php 

							}

						}

						if(isset($_REQUEST['tab']) && $_REQUEST['tab'] == 'view-activity')

						{ ?>

							<a href="?page=gmgt_membership_type&tab=view-activity&membership_id=<?php echo esc_attr($_REQUEST['membership_id']);?>" class="nav-tab <?php echo $active_tab == 'view-activity' ? 'nav-tab-active' : ''; ?>"><?php echo '<span class="dashicons dashicons-menu"></span> '.esc_html__('View Activity', 'gym_mgt'); ?></a>

						<?php } ?>

					</h2> -->

					<?php 

					//Membership List//

					if($active_tab == 'membershiplist')

					{ 

						$membershipdata=$obj_membership->MJ_gmgt_get_all_membership();

						if(!empty($membershipdata))

						{

							?>	

							<script type="text/javascript">

								jQuery(document).ready(function() 

								{

									"use strict";

									jQuery('#membership_list').DataTable({

										// "responsive": true,

										dom: 'lifrtp',

										buttons: [

											'colvis',

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

													{"bSortable": true},

													//  {"bSortable": true},

													{"bSortable": false}],

												language:<?php echo MJ_gmgt_datatable_multi_language();?>	

										});

										$('.dataTables_filter input').attr("placeholder", "<?php esc_html_e('Search...', 'gym_mgt') ?>");

										//-- add activity pop up --- //

										var tempval=<?php echo esc_html($valtemp);?>;

										if(tempval==1){

											swal(
												{
													title: language_translate.successfully_inserted_membership,

													text: language_translate.successfully_add_activity_membership,

													type: "success",

													showCancelButton: true,

													confirmButtonColor: '#ba170b',

													confirmButtonText: language_translate.confirm_yes_activity_membership,

													cancelButtonText: language_translate.confirm_no_activity_membership,

													closeOnConfirm: false,

													closeOnCancel: true
											})
											.then((isConfirm) => {
												if (isConfirm)
												{
													
													window.location.href = "<?php echo admin_url().'admin.php?page=gmgt_activity&tab=addactivity&membership_id='.$newmembershipid; ?>";

												} 
												else 
												{

													tempval=0;

													window.location.href = "<?php echo admin_url().'admin.php?page=gmgt_membership_type&tab=membershiplist';?>";

												}
											});

										}

										jQuery('.select_all').on('click', function(e)

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

										$("body").on("change",".sub_chk",function(){

											"use strict";

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

							<form name="memership_list" id="memership_list" action="" method="post"><!--MEMBERSHIP LIST FORM START-->

								<div class="panel-body padding_0"><!--PANEL BODY DIV START-->

									<div class="table-responsive"><!--TABLE RESPONSIVE DIV START-->

										<table id="membership_list" class="display" cellspacing="0" width="100%"><!--MEMBERSHIP LIST TABLE START-->

											<thead class="<?php echo MJ_gmgt_datatable_heder(); ?>">

												<tr>		

													<th class="padding_0"><input type="checkbox" class="select_all"></th>

													<th><?php esc_html_e('Photo','gym_mgt');?></th>

													<th><?php esc_html_e('Membership Name','gym_mgt');?></th>

													<th><?php esc_html_e('Membership Short Code','gym_mgt');?></th>

													<th><?php esc_html_e('Membership Type','gym_mgt');?></th> 

													<th><?php esc_html_e('Membership Period (Days)','gym_mgt');?></th>

													<th><?php esc_html_e('Membership Amount','gym_mgt');?>(<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ));?>)</th>

													<th><?php esc_html_e('Installment Plan','gym_mgt');?>(<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code'));?>)</th>

													<th><?php esc_html_e('Signup Fee','gym_mgt');?>(<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code'));?>)</th>

													<th  class="text_align_end"><?php esc_html_e('Action','gym_mgt');?></th>

												</tr>

											</thead>

											<tbody>

												<?php 

												//$membershipdata=$obj_membership->MJ_gmgt_get_all_membership();

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

															<td class="checkbox_width_10px">

																<input type="checkbox" name="selected_id[]" class="smgt_sub_chk sub_chk select-checkbox" value="<?php echo esc_attr($retrieved_data->membership_id); ?>">

															</td>

															<td class="user_image width_50px padding_left_0">

																<?php $userimage=$retrieved_data->gmgt_membershipimage;
																?>

																<?php 

																	$userimage=$retrieved_data->gmgt_membershipimage;

																	if(empty($userimage))

																	{

																			echo '<img src='.get_option( 'gmgt_Membership_logo' ).' height="50px" width="50px" class="img-circle" />';

																	}

																	else

																	{

																		echo '<img src='.$userimage.' height="50px" width="50px" class="img-circle"/>';

																	}

																?>

															</td>

															<td class="membershipname">

																<a href="#" class="view_details_popup float_left_width_100" id="<?php echo esc_attr($retrieved_data->membership_id)?>" type="<?php echo 'view_membership';?>">

																	<?php echo esc_html($retrieved_data->membership_label);?>

																</a>

																<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Membership Name','gym_mgt');?>" ></i>

															</td>

															<td class="membershipshortcode">

																<?php echo esc_html_e('[MembershipCode id=', 'gym_mgt').esc_html($retrieved_data->membership_id)."]";?>

																<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Membership Short Code','gym_mgt');?>" ></i>

															</td>

															<?php

																if($retrieved_data->gmgt_membership_recurring == "yes")

																{

																	$membership_type=esc_html__("Recurring","gym_mgt");

																}
																else

																{

																	$membership_type=esc_html__("One Time","gym_mgt");

																}

															?>

															<td class="membershiperiod">

																<?php echo esc_html($membership_type);?>

																<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Membership Type','gym_mgt');?>" ></i>

															</td>
															<td class="membershiperiod">

																<?php echo esc_html($retrieved_data->membership_length_id);?>

																<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Membership Period','gym_mgt');?> (<?php _e('Days','gym_mgt');?>)" ></i>

															</td>

															<td class="">

																<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?><?php echo esc_html($retrieved_data->membership_amount);?>

																<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Membership Amount','gym_mgt');?> (<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ));?>)" ></i>

															</td>

															<td class="installmentplan">

																<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?><?php echo esc_html($retrieved_data->installment_amount)." ".esc_html($plan_id);?>

																<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Installment Plan','gym_mgt');?> (<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ));?>)" ></i>

															</td>
															<td class="signup_fee">

																<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?><?php echo esc_html($retrieved_data->signup_fee);?>

																<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Signup Fee','gym_mgt');?> (<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ));?>)" ></i>

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

																				<li class="float_left_width_100">		

																					<a href="?page=gmgt_membership_type&tab=view-activity&membership_id=<?php echo esc_attr($retrieved_data->membership_id)?>" class="float_left_width_100"><i class="fa fa-eye"></i> <?php esc_html_e('View Activities', 'gym_mgt' );?></a>

																				</li>

																				<?php 

																				if($user_access_edit == '1')

																				{ ?>	

																					<li class="float_left_width_100 border_bottom_item">											

																						<a href="?page=gmgt_membership_type&tab=addmembership&action=edit&membership_id=<?php echo esc_attr($retrieved_data->membership_id)?>" class="float_left_width_100"><i class="fa fa-edit"></i> <?php esc_html_e('Edit', 'gym_mgt' ) ;?></a>

																					</li>

																					<?php 

																				}

																				if($user_access_delete =='1')

																				{

																					?>

																					<li class="float_left_width_100">		

																						<a href="?page=gmgt_membership_type&tab=membershiplist&action=delete&membership_id=<?php echo esc_attr($retrieved_data->membership_id);?>" class="float_left_width_100 list_delete_btn" onclick="return confirm('<?php esc_html_e('Are you sure you want to delete this record?','gym_mgt');?>');"><i class="fa fa-trash"></i> <?php esc_html_e( 'Delete', 'gym_mgt' ) ;?> </a>

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

													} 

												}?>

											</tbody>

										</table><!--MEMBERSHIP LIST TABLE END-->

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

							</form><!--MEMBERSHIP LIST FORM END-->

							<?php 

						}

						else

						{

							if($user_access_add == 1)

							{

								?>

								<div class="no_data_list_div"> 

									<a href="<?php echo admin_url().'admin.php?page=gmgt_membership_type&tab=addmembership';?>">

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

					if($active_tab == 'addmembership')

					{

						require_once GMS_PLUGIN_DIR. '/admin/membership/add_membership.php';

					}

					if($active_tab == 'view-activity')

					{

					require_once GMS_PLUGIN_DIR. '/admin/membership/view-activity.php';

					} 

					?>

				</div><!--PANEL BODY DIV END-->

			</div><!--COL 12 DIV END-->

		</div><!--ROW DIV END-->

	</div><!-- MAIN_LIST_MARGING_15px END -->

</div><!--PAGE INNER DIV END-->