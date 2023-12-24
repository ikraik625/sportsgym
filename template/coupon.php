<?php

$obj_coupon=new MJ_gmgt_coupon;

$active_tab = isset($_GET['tab'])?$_GET['tab']:'couponlist';



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

if(isset($_POST['save_coupon']))

{



	$start_date=MJ_gmgt_get_format_for_db($_POST['from_date']);



	$end_date=MJ_gmgt_get_format_for_db($_POST['end_date']);



	if($end_date>=$start_date)

	{	

		// EDIT COUPONDATA

		if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit')

		{

			$result=$obj_coupon->MJ_gmgt_add_coupon($_POST);

			

			wp_redirect ( home_url().'?dashboard=user&page=coupon&tab=couponlist&message=2');

			

		}

		else{

			$coupondata=$obj_coupon->MJ_gmgt_get_coupon_by_code($_POST['coupon_code']);

			if(empty($coupondata)){

				$result=$obj_coupon->MJ_gmgt_add_coupon($_POST);

				if($result)

				{

					wp_redirect ( home_url().'?dashboard=user&page=coupon&tab=couponlist&message=1');

				}

			}else{

				?>

				<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">



					<p><?php esc_html_e('Coupon Code already exists.','gym_mgt');?></p>



					<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>



				</div>

				<?php

			}

		}

		

	}

	else

	{

		?>

			<div id="message" class="alert_msg alert alert-success alert-dismissible " role="alert">

				<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span>

				</button>

				<p><?php esc_html_e('End Date should be greater than From Date','gym_mgt');?></p>

			</div> 

		<?php

	}

}



// DELETE COUPON RECORD

if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')

{

	$result = $obj_coupon->MJ_gmgt_delete_coupon(esc_attr($_REQUEST['id']));

	if($result)

	{

		wp_redirect ( home_url().'?dashboard=user&page=coupon&tab=couponlist&message=3');

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



			<p><?php esc_html_e('Coupon added successfully.','gym_mgt');?></p>



		</div>



	<?php 	



	}



	elseif($message == 2)



	{?>



		<div id="message" class="alert_msg alert alert-success alert-dismissible " role="alert">



			<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span>



			</button>



			<p><?php esc_html_e("Coupon updated successfully.",'gym_mgt');?></p>



		</div>



	<?php	



	}



	elseif($message == 3) 



	{?>



		<div id="message" class="alert_msg alert alert-success alert-dismissible " role="alert">



			<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span>



			</button>



			<p><?php esc_html_e('Coupon deleted successfully.','gym_mgt');?></p>



		</div>



	<?php		



	}



}?>



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

			if($active_tab == 'couponlist')

			{ 

				if($obj_gym->role == 'staff_member'){

					

					$coupondata=$obj_coupon->MJ_gmgt_get_all_coupondata();

					

				}

				if($obj_gym->role == 'member'){



					$user_id = get_current_user_id();

					$coupondata = $obj_coupon->MJ_gmgt_get_coupondata_by_user_id($user_id);

				}

				?>

				<div class="gms_main_list"><!-- MAIN_LIST_MARGING_15px START -->

					<?php

					if (!empty($coupondata)) 

					{

						?>

						<script type="text/javascript">

							jQuery(document).ready(function() 

							{

								"use strict";



								jQuery('#coupon_data').DataTable({

									// "responsive": true,

									dom: 'lifrtp',

									buttons: [

										'colvis',

									], 

									"aoColumns":[

												{"bSortable": false},

												{"bSortable": true},

												{"bSortable": true},

												{"bSortable": true},

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

								

							});

						</script>

						<form name="coupon_list" id="coupon_list" action="" method="post"><!--MEMBERSHIP LIST FORM START-->



							<div class="panel-body padding_0"><!--PANEL BODY DIV START-->



								<div class="table-responsive"><!--TABLE RESPONSIVE DIV START-->



									<table id="coupon_data" class="display" cellspacing="0" width="100%"><!--MEMBERSHIP LIST TABLE START-->



										<thead class="<?php echo MJ_gmgt_datatable_heder(); ?>">



											<tr>

												

												<th><?php esc_html_e('Photo','gym_mgt');?></th>



												<th><?php esc_html_e('Code','gym_mgt');?></th>



												<th><?php esc_html_e('Coupon For','gym_mgt');?></th>



												<th><?php esc_html_e('Member Name','gym_mgt');?></th> 



												<th><?php esc_html_e('Recurring Type','gym_mgt');?></th>



												<th><?php esc_html_e('Membership','gym_mgt');?></th>



												<th><?php esc_html_e('Discount','gym_mgt');?></th>



												<th><?php esc_html_e('From Date','gym_mgt');?></th>



												<th><?php esc_html_e('End Date','gym_mgt');?></th>



												<th><?php esc_html_e('Published','gym_mgt');?></th>



												<th  class="text_align_end"><?php esc_html_e('Action','gym_mgt');?></th>



											</tr>



										</thead>



										<tbody>

											<?php

												foreach ($coupondata as $retrieved_data)

												{

													?>

													<tr>

														<td class="user_image width_50px padding_left_0 list_img">

															<img class="img-circle view_details_popup image_height_width" id="<?php echo esc_attr($retrieved_data->id)?>" type="<?php echo 'view_coupon';?>" src="<?php echo GMS_PLUGIN_URL."/assets/images/Coupon.png"?>">

														</td>

														<td>

															<?php echo $retrieved_data->code; ?>&nbsp;<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Code','gym_mgt');?>" ></i>

														</td>

														<td class="coupon_text">

															<?php if($retrieved_data->coupon_type == "all_member"){echo esc_html_e('All Member','gym_mgt');}else{ echo esc_html_e($retrieved_data->coupon_type,'gym_mgt');} ?>&nbsp;<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Coupon For','gym_mgt');?>" ></i>

														</td>

														<td class="coupon_text">

															<?php if(!empty($retrieved_data->member_id)){ echo MJ_gmgt_get_member_full_display_name_with_memberid($retrieved_data->member_id);}else{ echo esc_html_e('All Member','gym_mgt');} ?>&nbsp;

															<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Member Name','gym_mgt');?>" ></i>

														</td>

														<td class="coupon_text">

															<?php esc_html_e($retrieved_data->recurring_type,'gym_mgt'); ?>&nbsp;<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Recurring Type','gym_mgt');?>" ></i>

														</td>

														<td class="coupon_text">

															<?php if($retrieved_data->membership == "all_membership"){echo esc_html_e('All Membership','gym_mgt');}else{ echo MJ_gmgt_get_membership_name($retrieved_data->membership);} ?>&nbsp;<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Membership','gym_mgt');?>" ></i>

														</td>

														<td class="coupon_text">

															<?php

															if($retrieved_data->discount_type =="amount"){

																echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )).''.$retrieved_data->discount;

															}

															else{

																echo $retrieved_data->discount.''.$retrieved_data->discount_type;

															}

															  ?>&nbsp;<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Discount','gym_mgt');?>" ></i>

														</td>

														<td>

															<?php echo MJ_gmgt_getdate_in_input_box($retrieved_data->from_date); ?>&nbsp;<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('From Date','gym_mgt');?>" ></i>

														</td>

														<td>

															<?php echo MJ_gmgt_getdate_in_input_box($retrieved_data->end_date); ?>&nbsp;<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('End Date','gym_mgt');?>" ></i>

														</td>

														<td class="coupon_text">

															<?php esc_html_e($retrieved_data->published,'gym_mgt'); ?>&nbsp;<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Published','gym_mgt');?>" ></i>

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



																				<a href="#" class="view_details_popup float_left_width_100" id="<?php echo esc_attr($retrieved_data->id)?>" type="<?php echo 'view_coupon';?>"><i class="fa fa-eye"></i> <?php esc_html_e('View', 'gym_mgt' ) ;?> </a>



																			</li>

																			<?php 



																			if($user_access['edit']=='1')



																			{ ?>

																				<li class="float_left_width_100 border_bottom_item">											



																					<a href="?dashboard=user&page=coupon&tab=add_coupon&action=edit&id=<?php echo esc_attr($retrieved_data->id)?>" class="float_left_width_100"><i class="fa fa-edit"></i> <?php esc_html_e('Edit', 'gym_mgt' ) ;?></a>



																				</li>

																			<?php 

																			}

																			if($user_access['delete']=='1')

																			{

																			?>

																				<li class="float_left_width_100 border_bottom_item">											



																					<a href="?dashboard=user&page=coupon&tab=couponlist&action=delete&id=<?php echo esc_attr($retrieved_data->id)?>"" class="float_left_width_100 list_delete_btn" onclick="return confirm('<?php esc_html_e('Are you sure you want to delete this record?','gym_mgt');?>');"><i class="fa fa-trash"></i> <?php esc_html_e( 'Delete', 'gym_mgt' ) ;?> </a>



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

											?>

										</tbody>



									</table>

								

								</div><!--TABLE RESPONSIVE DIV END-->



							</div><!--PANEL BODY DIV END-->



						</form><!--MEMBERSHIP LIST FORM END-->





						<?php

					}

					else



					{

						if($user_access['add']=='1')

						{

							?>



							<div class="no_data_list_div"> 



								<a href="<?php echo home_url().'?dashboard=user&page=coupon';?>">



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

				</div>

				<?php



			}

			// ADD COUPON FORM START

			if($active_tab == 'add_coupon')

			{

				$edit=0;

				if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')

				{

					$coupon_id=esc_attr($_REQUEST['id']);

					$edit=1;

					$result = $obj_coupon->MJ_gmgt_get_single_coupondata($coupon_id);

				}

				?>

				<script>

					$(document).ready(function() 

					{



						"use strict";



						$('#coupon_form').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});



						$.datepicker.setDefaults($.datepicker.regional['<?php echo MJ_gmgt_get_current_lan_code(); ?>']);



						var date = new Date();



						date.setDate(date.getDate()-0);



						$('.from_date').datepicker({



							<?php



							if(get_option('gym_enable_datepicker_privious_date')=='no')

							{

							?>

								minDate:'today',



								startDate: date,

							<?php

							}

							?>

						dateFormat: '<?php echo get_option('gmgt_datepicker_format');?>',



						autoclose: true



						});

						$(".display-members").select2();

						<?php

						if($edit && $result->coupon_type == "individual"){

						?>

							$(".coupon_member").css("display", "block");

						<?php

						}

						?>



					});

				</script>

				<div class="panel-body padding_0"><!-- PANEL BODY DIV START -->



					<form name="membership_form" action="" method="post" class="form-horizontal" id="coupon_form" enctype="multipart/form-data"><!--MEMBERSHIP FORM START-->



						<?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>



						<input type="hidden" name="action" value="<?php echo esc_attr($action);?>">



						<input type="hidden" name="coupon_id" class="" value="<?php echo esc_attr($coupon_id);?>"  />



						<div class="header">	



							<h3 class="first_hed"><?php esc_html_e('Coupon Information','gym_mgt');?></h3>



						</div>

						

						<div class="form-body user_form">

						

							<div class="row">

							

								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 res_margin_bottom_20px rtl_margin_top_15px">



									<div class="form-group">



										<div class="col-md-12 form-control">



											<div class="row padding_radio">



												<div class="input-group">



													<label class="custom-top-label" for="coupon_type"><?php esc_html_e('Coupon For','gym_mgt');?><span class="require-field">*</span></label>



													<div class="d-inline-block gender_line_height_24px">

														

														<?php $limitval = "all_member"; if($edit){ $limitval=$result->coupon_type; }elseif(isset($_POST['coupon_for'])) {$limitval=sanitize_text_field($_POST['coupon_for']);}?>



														<label class="radio-inline custom_radio">



															<input type="radio" id="all_member" value="all_member" class="tog coupon_type" name="coupon_for" <?php checked('all_member',esc_html($limitval)); ?>/><?php esc_html_e('All Member','gym_mgt');?>



														</label>



														<label class="radio-inline custom_radio margin_right_5px">



															<input type="radio" id="individual" value="individual" class="tog coupon_type" name="coupon_for" <?php checked('individual',esc_html($limitval)); ?>/><?php esc_html_e('Individual','gym_mgt');?>



														</label>



													</div>



												</div>



											</div>		



										</div>



									</div>



								</div>

								

								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 coupon_member">

								

									<select id="coupon_member_list" class="display-members form-control member-select2" name="member_id">



										<option value=""><?php esc_html_e('Select Member','gym_mgt');?></option>



											<?php $get_members = array('role' => 'member');



											$membersdata=get_users($get_members);

											if($edit){

												$member_id = $result->member_id;

											}

											else{

												$member_id = '';

											}

											if(!empty($membersdata))



											{



												foreach ($membersdata as $member)



												{?>



													<option value="<?php echo esc_attr($member->ID);?>" <?php selected($member_id,$member->ID);?>><?php echo esc_html(MJ_gmgt_get_member_full_display_name_with_memberid(esc_html($member->ID))); ?> </option>



												<?php



												}



											}?>



									</select>



								</div>

									

								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">

									

									<div class="form-group input">



										<div class="col-md-12 form-control">



											<input id="coupon_code" class="form-control validate[required] text-input"  maxlength="50" type="text" value="<?php if($edit){ echo $result->code;} ?>" name="coupon_code" placeholder="Eg. SALE50OFF">



											<label class="" for="coupon_code"><?php esc_html_e('Coupon Code','gym_mgt');?><span class="require-field">*</span></label>



										</div>



									</div>

									

								</div>

								

								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 res_margin_bottom_20px rtl_margin_top_15px">



									<div class="form-group">



										<div class="col-md-12 form-control">



											<div class="row padding_radio">



												<div class="input-group">



													<label class="custom-top-label" for="publish"><?php esc_html_e('Recurring Type','gym_mgt');?><span class="require-field">*</span></label>



													<div class="d-inline-block gender_line_height_24px">

														

														<?php $limitval = "onetime"; if($edit){ $limitval=$result->recurring_type; }elseif(isset($_POST['recurring_type'])) {$limitval=sanitize_text_field($_POST['recurring_type']);}?>



														<label class="radio-inline custom_radio">



															<input type="radio" value="onetime" class="tog" name="recurring_type" <?php checked('onetime',esc_html($limitval)); ?>/><?php esc_html_e('Onetime','gym_mgt');?>



														</label>



														<label class="radio-inline custom_radio margin_right_5px">



															<input type="radio" value="recurring" class="tog" name="recurring_type" <?php checked('recurring',esc_html($limitval)); ?>/><?php esc_html_e('Recurring','gym_mgt');?>



														</label>



													</div>



												</div>



											</div>		



										</div>



									</div>



								</div>

								

								<div class="rtl_margin_top_15px col-sm-6 col-md-6 col-lg-6 col-xl-6 res_margin_bottom_20px multiselect_validation_member smgt_multiple_select">



										<!--<label class="col-sm-2 control-label form-label" for=""><?php esc_html_e('Membership','gym_mgt');?></label> -->



										<select  class="form-control validate[required]" name="membership">

											<option value="all_membership"><?php echo 'All Membership';?></option>

											<?php





											$obj_membership=new MJ_gmgt_membership;



										$membershipdata=$obj_membership->MJ_gmgt_get_all_membership();

										

											if(!empty($membershipdata))



											{



												foreach ($membershipdata as $membership)



												{

													

													echo '<option value='.esc_attr($membership->membership_id).' '.selected(esc_attr($result->membership),esc_attr($membership->membership_id)).'>'.esc_html($membership->membership_label).'</option>';

												

												}



											}



											?>



										</select>



									</div>

								

								<div class="col-sm-12 col-md-3 col-lg-3 col-xl-3">

									

									<div class="form-group input">



										<div class="col-md-12 form-control">



											<input id="discount" class="form-control text-input validate[required]" type="number" min="0" onkeypress="if(this.value.length==8) return false;" step="0.01" value="<?php if($edit){echo $result->discount;} ?>" name="discount" placeholder="">



											<label class="" for="discount"><?php esc_html_e('Discount','gym_mgt');?><span class="require-field">*</span></label>



										</div>



									</div>

									

								</div>

								

								<div class="col-sm-12 col-md-3 col-lg-3 col-xl-3">



									<select class="form-control max_width_100" name="discount_type" id="discount_type">



										<option value="%" <?php  if($edit) if(isset($result->discount_type)) selected(esc_attr($result->discount_type),'%'); ?>>%</option>	

										

										<option value="amount" <?php  if($edit) if(isset($result->discount_type)) selected(esc_html($result->discount_type),'amount'); ?>><?php echo esc_html__('Amount','gym_mgt').'('.MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )).')';?></option>

									</select>

									

								</div>

								

								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">

									

									<div class="form-group input">



										<div class="col-md-12 form-control">



											<input id="times" class="form-control validate[required] text-input"  maxlength="50" type="text" value="<?php if($edit){ echo $result->time;}else{ echo'1';}?>" name="time" >



											<label class="" for="times"><?php esc_html_e('Times','gym_mgt');?><span class="require-field">*</span></label>



										</div>



									</div>

									

								</div>

								

								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



									<div class="form-group input">



										<div class="col-md-12 form-control">



											<input id="from_date"  class="form-control from_date validate[required] date_picker" type="text" value="<?php if($edit){ echo MJ_gmgt_getdate_in_input_box($result->from_date);}else{echo MJ_gmgt_getdate_in_input_box(date("Y-m-d"));} ?>" name="from_date">



											<label class="date_label" for="from_date"><?php esc_html_e('Valid From Date','gym_mgt');?><span class="require-field">*</span></label>                                  



										</div>



									</div>



								</div>

								

								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



									<div class="form-group input">



										<div class="col-md-12 form-control">



											<input id="end_date" class="form-control from_date validate[required] date_picker" type="text" value="<?php if($edit){ echo MJ_gmgt_getdate_in_input_box($result->end_date);}else{echo MJ_gmgt_getdate_in_input_box(date("Y-m-d"));} ?>" name="end_date">



											<label class="date_label" for="end_date"><?php esc_html_e('Valid To Date','gym_mgt');?><span class="require-field">*</span></label>                                  



										</div>



									</div>



								</div>

								

								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 res_margin_bottom_20px rtl_margin_top_15px">



									<div class="form-group">



										<div class="col-md-12 form-control">



											<div class="row padding_radio">



												<div class="input-group">



													<label class="custom-top-label" for="publish"><?php esc_html_e('Publish','gym_mgt');?><span class="require-field">*</span></label>



													<div class="d-inline-block gender_line_height_24px">

														

														<?php $limitval = "yes"; if($edit){ $limitval=$result->published; }elseif(isset($_POST['publish'])) {$limitval=sanitize_text_field($_POST['publish']);}?>



														<label class="radio-inline custom_radio">



															<input type="radio" value="yes" class="tog" name="publish" <?php checked('yes',esc_html($limitval)); ?>/><?php esc_html_e('Yes','gym_mgt');?>



														</label>



														<label class="radio-inline custom_radio margin_right_5px">



															<input type="radio" value="no" class="tog" name="publish" <?php checked('no',esc_html($limitval)); ?>/><?php esc_html_e('No','gym_mgt');?>



														</label>



													</div>



												</div>



											</div>		



										</div>



									</div>



								</div>

							

							</div>

							

						</div>

						<div class="form-body user_form">



							<div class="row">



								<div class="col-md-6 col-sm-6 col-xs-12"><!--save btn--> 



									<input type="submit" value="<?php if($edit){ esc_html_e('Save Coupon','gym_mgt'); }else{ esc_html_e('Add Coupon','gym_mgt');}?>" name="save_coupon" class="btn save_btn"/>



								</div>



							</div><!--Row Div End--> 



						</div>



					</form>



				</div>



				<?php

			}

		?>



	</div><!--TAB CONTENT DIV END--> 
</div><!--PANEL WHITE DIV END--> 