<?php



$active_tab = isset($_GET['tab'])?$_GET['tab']:'couponlist';

$obj_coupon=new MJ_gmgt_coupon;

if($role == 'administrator')



	{



		$user_access_add=1;



		$user_access_edit=1;



		$user_access_delete=1;



		$user_access_view=1;



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

	// SAVE COUPONDATA

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

				

				wp_redirect ( admin_url().'admin.php?page=gmgt_coupon&tab=couponlist&message=2');

				

			}

			else{

				$coupondata=$obj_coupon->MJ_gmgt_get_coupon_by_code($_POST['coupon_code']);

				if(empty($coupondata)){

					$result=$obj_coupon->MJ_gmgt_add_coupon($_POST);

					if($result)

					{

						wp_redirect ( admin_url().'admin.php?page=gmgt_coupon&tab=couponlist&message=1');

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

				<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">

					<p><?php esc_html_e('End Date should be greater than From Date','gym_mgt');?></p>

					<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>

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

			wp_redirect ( admin_url().'admin.php?page=gmgt_coupon&tab=couponlist&message=3');

		}

	}

	

	//DELETE SELECTED COUPON DATA



	if(isset($_REQUEST['delete_selected']))

	{		

		if(!empty($_REQUEST['selected_id']))

		{

			foreach($_REQUEST['selected_id'] as $id)

			{

				$delete_coupondata=$obj_coupon->MJ_gmgt_delete_coupon($id);

				

				if($delete_coupondata)

				{

					wp_redirect ( admin_url().'admin.php?page=gmgt_coupon&tab=couponlist&message=3');

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

	

	if(isset($_REQUEST['message']))

	{

		$message =esc_attr($_REQUEST['message']);



		if($message == 1)



		{ 



			?>



			<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">



				<p><?php esc_html_e('Coupon Inserted successfully.','gym_mgt');?></p>



				<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>



			</div>



			<?php



		}



		elseif($message == 2)



		{?>



			<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">



				<p><?php esc_html_e("Coupon updated successfully.",'gym_mgt');?></p>



				<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>



			</div>



		<?php	



		}

		elseif($message == 3) 



		{?>



			<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">



				<p><?php esc_html_e('Coupon deleted successfully.','gym_mgt');?></p>



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

				if($active_tab == 'couponlist')

				{

					$coupondata=$obj_coupon->MJ_gmgt_get_all_coupondata();

					if (!empty($coupondata)) 

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

												{"bSortable": true},

												{"bSortable": true},

												{"bSortable": false}],



											language:<?php echo MJ_gmgt_datatable_multi_language();?>	



								});

								$('.dataTables_filter input').attr("placeholder", "<?php esc_html_e('Search...', 'gym_mgt') ?>");

								

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

							});

						</script>

						<form name="coupon_list" id="coupon_list" action="" method="post"><!--MEMBERSHIP LIST FORM START-->



							<div class="panel-body padding_0"><!--PANEL BODY DIV START-->



								<div class="table-responsive"><!--TABLE RESPONSIVE DIV START-->



									<table id="membership_list" class="display" cellspacing="0" width="100%"><!--MEMBERSHIP LIST TABLE START-->



										<thead class="<?php echo MJ_gmgt_datatable_heder(); ?>">



											<tr>

												

												<th class="padding_0"><input type="checkbox" class="select_all"></th>

												

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

														<td class="checkbox_width_10px">

															<input type="checkbox" name="selected_id[]" class="smgt_sub_chk sub_chk select-checkbox" value="<?php echo esc_attr($retrieved_data->id); ?>">

														</td>

														<td class="user_image width_50px padding_left_0">

															<img height="50px" width="50px" class="img-circle view_details_popup" id="<?php echo esc_attr($retrieved_data->id)?>" type="<?php echo 'view_coupon';?>" src="<?php echo GMS_PLUGIN_URL."/assets/images/Coupon.png"?>">

														</td>

														<td>

															<?php echo $retrieved_data->code; ?>&nbsp;<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Code','gym_mgt');?>" ></i>

														</td>

														<td class="coupon_text">
																
															<?php if($retrieved_data->coupon_type == "all_member"){echo esc_html_e('All Member','gym_mgt');}else{ echo esc_html_e($retrieved_data->coupon_type,'gym_mgt');} ?>&nbsp;<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Coupon For','gym_mgt');?>" ></i>

														</td>

														<td class="coupon_text">

															<?php if(!empty($retrieved_data->member_id)){ echo MJ_gmgt_get_member_full_display_name_with_memberid($retrieved_data->member_id);}else{ esc_html_e('All Member','gym_mgt');} ?>&nbsp;

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

															<?php esc_html_e($retrieved_data->published,'gym_mgt');?>&nbsp;<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Published','gym_mgt');?>" ></i>

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



																			if($user_access_edit == '1')



																			{ ?>

																				<li class="float_left_width_100 border_bottom_item">											



																					<a href="?page=gmgt_coupon&tab=add_coupon&action=edit&id=<?php echo esc_attr($retrieved_data->id)?>" class="float_left_width_100"><i class="fa fa-edit"></i> <?php esc_html_e('Edit', 'gym_mgt' ) ;?></a>



																				</li>

																			<?php 

																			}

																			if($user_access_delete =='1')

																			{

																			?>

																				<li class="float_left_width_100 border_bottom_item">											



																					<a href="?page=gmgt_coupon&tab=couponlist&action=delete&id=<?php echo esc_attr($retrieved_data->id)?>"" class="float_left_width_100 list_delete_btn" onclick="return confirm('<?php esc_html_e('Are you sure you want to delete this record?','gym_mgt');?>');"><i class="fa fa-trash"></i> <?php esc_html_e( 'Delete', 'gym_mgt' ) ;?> </a>



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

									

									<!-------- Delete And Select All Button ----------->



										<div class="print-button pull-left">



											<button class="btn btn-success btn-sms-color">



												<input type="checkbox" name="id[]" class="select_all" value="<?php echo esc_attr($retrieved_data->id); ?>" style="margin-top: 0px;">



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



								<a href="<?php echo admin_url().'admin.php?page=gmgt_coupon&tab=add_coupon';?>">



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

				if($active_tab == 'add_coupon')

				{

					require_once GMS_PLUGIN_DIR. '/admin/coupon/add_coupon.php';

				}

				?>

				</div><!--PANEL BODY DIV END-->



			</div><!--COL 12 DIV END-->



		</div><!--ROW DIV END-->



	</div>



</div>