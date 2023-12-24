<?php 

$obj_tax=new MJ_gmgt_tax;

$active_tab = isset($_GET['tab'])?$_GET['tab']:'taxlist';

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

	$user_access=MJ_gmgt_get_userrole_wise_manually_page_access_right_array_for_management('tax');

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

			if ('tax' == $user_access['page_link'] && ($_REQUEST['action']=='edit'))

			{

				if($user_access_edit=='0')

				{	

					MJ_gmgt_access_right_page_not_access_message_for_management();

					die;

				}			

			}

			if ('tax' == $user_access['page_link'] && ($_REQUEST['action']=='delete'))

			{

				if($user_access_delete=='0')

				{	

					MJ_gmgt_access_right_page_not_access_message_for_management();

					die;

				}	

			}

			if ('tax' == $user_access['page_link'] && ($_REQUEST['action']=='insert'))

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

<div class="page-inner min_height_1631"><!--PAGE INNER DIV START-->	

	<?php 

	//SAVE TAX DATA

	if(isset($_POST['save_tax']))

	{

		$nonce = $_POST['_wpnonce'];

		if (wp_verify_nonce( $nonce, 'save_tax_nonce' ) )

		{

			if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit')

			{				

				$result=$obj_tax->MJ_gmgt_add_taxes($_POST);

				if($result)

				{

					wp_redirect ( admin_url().'admin.php?page=MJ_gmgt_gmgt_taxes&tab=taxlist&message=2');

				}			

			}

			else

			{		

				$result=$obj_tax->MJ_gmgt_add_taxes($_POST);

				if($result)

				{

					wp_redirect ( admin_url().'admin.php?page=MJ_gmgt_gmgt_taxes&tab=taxlist&message=1');

				}			

			}

		}

	}

	//DELETE TAX DATA

	if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')

	{

		$result=$obj_tax->MJ_gmgt_delete_taxes($_REQUEST['tax_id']);

		if($result)

		{

			wp_redirect ( admin_url().'admin.php?page=MJ_gmgt_gmgt_taxes&tab=taxlist&message=3');

		}

	}

	//DELETE SELECTED TAX DATA

	if(isset($_REQUEST['delete_selected']))

    {		

		if(!empty($_REQUEST['selected_id']))

		{

			foreach($_REQUEST['selected_id'] as $id)

			{

				$delete_tax=$obj_tax->MJ_gmgt_delete_taxes($id);

			}

			if($delete_tax)

			{

				wp_redirect ( admin_url().'admin.php?page=MJ_gmgt_gmgt_taxes&tab=taxlist&message=3');

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

				<p><?php esc_html_e('Tax added successfully.','gym_mgt');?></p>

				<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>

			</div>

		<?php 

		}

		elseif($message == 2)

		{?>

			<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">

				<p><?php esc_html_e("Tax updated successfully.",'gym_mgt');?></p>

				<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>

			</div>

		<?php 

		}

		elseif($message == 3) 

		{?>

			<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">

				<p><?php esc_html_e('Tax deleted successfully.','gym_mgt');?></p>

				<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>

			</div>

		<?php		

		}

	}

	?>

	<div id="" class="gms_main_list"><!--MAIN WRAPPER DIV START-->	

		<div class="row"><!--ROW DIV START-->	

			<div class="col-md-12"><!--COL 12 DIV START-->	

				<div class=""><!--PANEL WHITE DIV START-->	

					<div class="panel-body padding_0"><!--PANEL BODY DIV START-->	

						

						<?php 

						if($active_tab == 'taxlist')

						{ 

							$taxdata=$obj_tax->MJ_gmgt_get_all_taxes();

							if(!empty($taxdata))

							{

								?>	

								<script type="text/javascript">

								$(document).ready(function() 

								{

									"use strict";

									jQuery('#tax_list').DataTable({

										// "responsive": true,

										"order": [[ 1, "asc" ]],

										dom: 'lifrtp',

									

										"aoColumns":[											  

													{"bSortable": false},

													{"bSortable": false},

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

										$("body").on("change",".sub_chk",function(){

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

								} );

								</script>

								<form name="wcwm_report" action="" method="post"><!--TAX LIST FORM START-->	

									<div class="panel-body padding_0"><!--PANEL BODY DIV START-->	

										<div class="table-responsive"><!--TABLE RESPONSIVE DIV START-->	

											<table id="tax_list" class="display" cellspacing="0" width="100%"><!--TAX LIST TABLE START-->	
												<thead class="<?php echo MJ_gmgt_datatable_heder(); ?>">
													<tr>
														<th class="padding_0"><input type="checkbox" class="select_all"></th>
														<th><?php esc_html_e('Photo','gym_mgt');?></th>
														<th><?php esc_html_e('Tax Title','gym_mgt');?></th>
														<th><?php esc_html_e('Tax Value','gym_mgt');?> (%)</th>
														<th  class="text_align_end"><?php esc_html_e('Action','gym_mgt');?></th>
													</tr>
												</thead>
												<tbody>

													<?php 

													//$taxdata=$obj_tax->MJ_gmgt_get_all_taxes();

													if(!empty($taxdata))

													{

														$i=0;

														foreach ($taxdata as $retrieved_data)

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

																<td class="checkbox_width_10px title"><input type="checkbox" name="selected_id[]" class="smgt_sub_chk sub_chk" value="<?php echo esc_attr($retrieved_data->tax_id); ?>"></td>

																<td class="user_image width_50px profile_image_prescription padding_left_0">	

																	<p class="prescription_tag padding_15px margin_bottom_0px <?php echo $color_class; ?>">	

																		<img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/White_Icons/GYM-Tax.png"?>" alt="" class="massage_image center image_icon_height_25px margin_top_3px">

																	</p>

																</td>

																<td class=""><?php echo esc_html($retrieved_data->tax_title); ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Tax Title','gym_mgt');?>" ></td>

																<td class=""><?php echo esc_html($retrieved_data->tax_value); ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Tax Value','gym_mgt');?>(%)" ></td>							

																<td class="action"> 

																	<div class="gmgt-user-dropdown">

																		<ul class="" style="margin-bottom: 0px !important;">

																			<li class="">

																				<a class="" href="#" data-bs-toggle="dropdown" aria-expanded="false">

																					<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/More.png"?>" >

																				</a>

																				<ul class="dropdown-menu heder-dropdown-menu action_dropdawn" aria-labelledby="dropdownMenuLink">

																					<?php 

																					if($user_access_edit == '1')

																					{ 

																						?>

																						<li class="float_left_width_100 border_bottom_item">

																							<a href="?page=MJ_gmgt_gmgt_taxes&tab=addtax&action=edit&tax_id=<?php echo esc_attr($retrieved_data->tax_id); ?>" class="float_left_width_100"><i class="fa fa-edit"></i> <?php esc_html_e('Edit', 'gym_mgt' ) ;?></a>

																						</li>

																						<?php 

																						

																					}

																					if($user_access_delete =='1')

																					{ 

																						?>

																						<li class="float_left_width_100">

																							<a href="?page=MJ_gmgt_gmgt_taxes&tab=taxlist&action=delete&tax_id=<?php echo esc_attr($retrieved_data->tax_id);?>" class="float_left_width_100 list_delete_btn" onclick="return confirm('<?php esc_html_e('Are you sure you want to delete this record?','gym_mgt');?>');"><i class="fa fa-trash"></i> <?php esc_html_e( 'Delete', 'gym_mgt' ) ;?> </a>

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

															$i++;

														} 

													}

													?>

												</tbody>

											</table><!--TAX LIST TABLE END-->	

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

										</div><!--TABLE RESPONSIVE DIV END-->	

									</div><!--PANEL BODY DIV END-->	

								</form><!--TAX LIST FORM END-->	

							 	<?php 

							}

							else

							{
								if($user_access_add == 1)
								{
									?>

									<div class="no_data_list_div"> 

										<a href="<?php echo admin_url().'admin.php?page=MJ_gmgt_gmgt_taxes&tab=addtax';?>">

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

						if($active_tab == 'addtax')

						{

							require_once GMS_PLUGIN_DIR. '/admin/tax/add_tax.php';

						}						

						?>

					</div><!--PANEL BODY DIV END-->	

	            </div><!--PANEL WHITE DIV END-->	

	        </div><!--COL 12 DIV END-->	

        </div><!--ROW DIV END-->	

    </div><!--MAIN WRAPPER DIV END-->	

</div><!--PAGE INNER DIV END-->	