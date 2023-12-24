<?php 

$obj_tax=new MJ_gmgt_tax;

$active_tab = isset($_GET['tab'])?$_GET['tab']:'taxlist';

?>	

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

				wp_redirect ( home_url().'?dashboard=user&page=tax&tab=taxlist&message=2');

			}			

		}

		else

		{		

			$result=$obj_tax->MJ_gmgt_add_taxes($_POST);

			if($result)

			{

				wp_redirect ( home_url().'?dashboard=user&page=tax&tab=taxlist&message=1');

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

		wp_redirect ( home_url().'?dashboard=user&page=tax&tab=taxlist&message=3');

	}

}



if(isset($_REQUEST['message']))

{

	$message =esc_attr($_REQUEST['message']);

	if($message == 1)

	{

		?>

		<div id="message" class="alert_msg alert alert-success alert-dismissible " role="alert">

			<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span>

			</button>

			<?php esc_html_e('Tax added successfully.','gym_mgt');?>

		</div>

		<?php 

	}

	elseif($message == 2)

	{

		?>

		<div id="message" class="alert_msg alert alert-success alert-dismissible " role="alert">

			<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span>

			</button>

			<?php esc_html_e('Tax updated successfully.','gym_mgt');?>

		</div>

		<?php 

	}

	elseif($message == 3) 

	{

		?>

		<div id="message" class="alert_msg alert alert-success alert-dismissible " role="alert">

			<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span>

			</button>

			<?php esc_html_e('Tax deleted successfully.','gym_mgt');?>

		</div>

		<?php		

	}

}

$role_access_right = array();

$role_access_right=get_option('gmgt_access_right_staff_member');

$access_right = $role_access_right['staff_member']['tax'];



?>



<div class="panel-white padding_0 gms_main_list"><!--PANEL WHITE DIV START-->	

	<div class="panel-body padding_0"><!--PANEL BODY DIV START-->	

		<?php 

		if($active_tab == 'taxlist')

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

							alert("<?php esc_html_e('Please select atleast one record','gym_mgt');?>");

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

			<?php

			$taxdata=$obj_tax->MJ_gmgt_get_all_taxes();

			if(!empty($taxdata))

			{

				?>

				<form name="wcwm_report" action="" method="post"><!--TAX LIST FORM START-->	

					<div class="panel-body padding_0"><!--PANEL BODY DIV START-->	

						<div class="table-responsive"><!--TABLE RESPONSIVE DIV START-->	

							<table id="tax_list" class="display" cellspacing="0" width="100%"><!--TAX LIST TABLE START-->	
								<thead class="<?php echo MJ_gmgt_datatable_heder(); ?>">
									<tr>
									<th><?php esc_html_e('Photo','gym_mgt');?></th>
										<th><?php esc_html_e('Tax Title','gym_mgt');?></th>
										<th><?php esc_html_e('Tax Value','gym_mgt');?> (%)</th>
										<th class="text_align_end"><?php esc_html_e('Action','gym_mgt');?></th>
									</tr>
								</thead>
								<tbody>

									<?php 

									$taxdata=$obj_tax->MJ_gmgt_get_all_taxes();

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

												<td class="user_image width_50px profile_image_prescription padding_left_0">	

													<p class="prescription_tag padding_15px margin_bottom_0px <?php echo $color_class; ?>">	

														<img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/White_Icons/GYM-Tax.png"?>" alt="" class="massage_image center image_icon_height_25px margin_top_3px">

													</p>

												</td>

												<td class=""><?php echo esc_html($retrieved_data->tax_title); ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Tax Title','gym_mgt');?>" ></td>

												<td class=""><?php echo esc_html($retrieved_data->tax_value); ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Tax Value','gym_mgt');?>" ></td>

												<td class="action"> 

													<div class="gmgt-user-dropdown">

														<ul class="" style="margin-bottom: 0px !important;">

															<li class="">

																<a class="" href="#" data-bs-toggle="dropdown" aria-expanded="false">

																	<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/More.png"?>" >

																</a>

																<ul class="dropdown-menu heder-dropdown-menu action_dropdawn" aria-labelledby="dropdownMenuLink">

																	<?php 

																	if($access_right['edit'] == 1 )

																	{ 

																		?>

																		<li class="float_left_width_100 border_bottom_item">

																			<a href="?dashboard=user&page=tax&tab=addtax&action=edit&tax_id=<?php echo esc_attr($retrieved_data->tax_id);?>" class="float_left_width_100"><i class="fa fa-edit"></i> <?php esc_html_e('Edit', 'gym_mgt' ) ;?></a>

																		</li>

																		<?php 

																		

																	}

																	if($access_right['delete'] == 1)

																	{ 

																		?>

																		<li class="float_left_width_100">

																			<a href="?dashboard=user&page=tax&tab=taxlist&action=delete&tax_id=<?php echo esc_attr($retrieved_data->tax_id);?>" class="float_left_width_100 list_delete_btn" onclick="return confirm('<?php esc_html_e('Are you sure you want to delete this record?','gym_mgt');?>');"><i class="fa fa-trash"></i> <?php esc_html_e( 'Delete', 'gym_mgt' ) ;?> </a>

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

						</div><!--TABLE RESPONSIVE DIV END-->	

					</div><!--PANEL BODY DIV END-->	

				</form><!--TAX LIST FORM END-->	

				<?php 

			}

			else

			{

				if($user_access['add']=='1')

				{

					?>

					<div class="no_data_list_div"> 

						<a href="<?php echo home_url().'?dashboard=user&page=tax&tab=addtax';?>">

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

			?>

			<script type="text/javascript">

			$(document).ready(function() 

			{

				"use strict";

				$('#tax_form').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});	

			} );

			</script>

			<?php 	

			if($active_tab == 'addtax')

			{

				$tax_id=0;

				$edit=0;

				if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')

				{

					$edit=1;

					$tax_id=esc_attr($_REQUEST['tax_id']);

					$result = $obj_tax->MJ_gmgt_get_single_tax_data($tax_id);

				}?>

				<div class="panel-body padding_0"><!--PANEL BODY DIV START-->	

					<form name="tax_form"  action="" method="post" class="form-horizontal" id="tax_form"><!--TAX FORM START-->	

						<?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>

						<input type="hidden" name="action" value="<?php echo esc_attr($action);?>">

						<input type="hidden" name="tax_id" value="<?php echo esc_attr($tax_id);?>"  />

						<div class="header">	

							<h3 class="first_hed"><?php esc_html_e('Tax Information','gym_mgt');?></h3>

						</div>

						<div class="form-body user_form"> <!-- user_form Strat-->   

							<div class="row"><!--Row Div Strat-->

								<div class="col-md-6 col-lg-6 col-sm-12 col-xl-6">

									<div class="form-group input">

										<div class="col-md-12 form-control">

											<input id="" maxlength="30" class="form-control validate[required,custom[address_description_validation]] text-input" type="text" value="<?php if($edit){ echo esc_attr($result->tax_title);}elseif(isset($_POST['tax_title'])) echo esc_attr($_POST['tax_title']);?>" name="tax_title">

											<label class="" for="date"><?php esc_html_e('Tax Name','gym_mgt');?><span class="require-field">*</span></label>

										</div>

									</div>

								</div>

								<div class="col-md-6 col-lg-6 col-sm-12 col-xl-6">

									<div class="form-group input">

										<div class="col-md-12 form-control">

											<input id="tax" class="form-control validate[required,custom[number]] text-input" onkeypress="if(this.value.length==6) return false;" step="0.01" type="number" value="<?php if($edit){ echo esc_attr($result->tax_value);}elseif(isset($_POST['tax_value'])) echo esc_attr($_POST['tax_value']);?>" name="tax_value" min="0" max="100">

											<label class="" for="date"><?php esc_html_e('Tax Value','gym_mgt');?>(%)<span class="require-field">*</span></label>

										</div>

									</div>

								</div>

								<?php wp_nonce_field( 'save_tax_nonce' ); ?>

							</div>

						</div>

						<div class="form-body user_form"> <!-- user_form Strat-->   

							<div class="row"><!--Row Div Strat-->

								<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

									<input type="submit" value="<?php if($edit){ esc_html_e('Save','gym_mgt'); }else{ esc_html_e('Save','gym_mgt');}?>" name="save_tax" class="btn save_btn"/>

								</div>

							</div>

						</div>

					</form><!--TAX FORM END-->	

				</div><!--PANEL BODY DIV END-->	

			<?php 

			}

		}						

		?>

	</div><!--PANEL BODY DIV END-->	

</div><!--PANEL WHITE DIV END-->	

