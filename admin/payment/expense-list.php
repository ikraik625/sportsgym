<?php 

$obj_payment= new MJ_gmgt_payment();



if($active_tab == 'expenselist')



{



	$expense_data=$obj_payment->MJ_gmgt_get_all_expense_data();



	if(!empty($expense_data))



	{



		?>



		<script type="text/javascript">



			$(document).ready(function() 



			{



				"use strict";



				jQuery('#tblexpence').DataTable({



					// "responsive": true,



					"order": [[ 3, "desc" ]],



					dom: 'lifrtp',



					"aoColumns":[



								{"bSortable": false},



								{"bSortable": false},



								{"bSortable": true},



								{"bSortable": true},



								{"bSortable": true},                                   



								{"bSortable": false}



							],



						language:<?php echo MJ_gmgt_datatable_multi_language();?>		   



					});



					$('.dataTables_filter input').attr("placeholder", "<?php esc_html_e('Search...', 'gym_mgt') ?>");



					// check unchecked all check box //



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



				// check unchecked all check box //



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



		<div class="panel-body padding_0"><!--PANEL BODY DIV START-->



			<div class="table-responsive"><!--TABLE RESPONSIVE DIV START-->



				<form name="wcwm_report" action="" method="post"><!--EXPENSE LIST FORM START-->



					<table id="tblexpence" class="display" cellspacing="0" width="100%"><!--EXPENSE LIST TABLE START-->

						<thead class="<?php echo MJ_gmgt_datatable_heder(); ?>">

							<tr>

								<th class="padding_0"><input type="checkbox" class="select_all"></th>

								<th><?php esc_html_e('Photo','gym_mgt');?></th>

								<th><?php esc_html_e('Supplier Name','gym_mgt');?></th>

								<th><?php esc_html_e('Total Amount','gym_mgt');?></th>

								<th><?php esc_html_e('Date','gym_mgt');?></th>

								<th class="text_align_end"><?php esc_html_e('Action','gym_mgt');?></th>

							</tr>

						</thead>

						<tbody>



							<?php 



							$i=0;



							foreach ($expense_data as $retrieved_data)



							{ 



								$all_entry=json_decode($retrieved_data->entry);



								$total_amount=0;



								foreach($all_entry as $entry)



								{



									$total_amount += $entry->amount;



								}



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



									<td class="title checkbox_width_10px"><input type="checkbox" name="selected_id[]" class="smgt_sub_chk sub_chk" value="<?php echo esc_attr($retrieved_data->invoice_id); ?>"></td>



									<td class="user_image width_50px profile_image_prescription padding_left_0">	



										<p class="prescription_tag padding_15px margin_bottom_0px <?php echo $color_class; ?>">	



											<img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/Payment.png"?>" alt="" class="massage_image center image_icon_height_25px margin_top_3px">



										</p>



									</td>



									<td class="party_name"><?php echo esc_html($retrieved_data->supplier_name);?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Supplier Name','gym_mgt');?>" ></td>



									<td class="income_amount"><?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?> <?php echo number_format(esc_html($total_amount),2);?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Total Amount','gym_mgt');?>" ></td>



									<td class="status"><?php echo MJ_gmgt_getdate_in_input_box(esc_html($retrieved_data->invoice_date));?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Date','gym_mgt');?>" ></td>



									<td class="action"> 



										<div class="gmgt-user-dropdown">



											<ul class="" style="margin-bottom: 0px !important;">



												<li class="">



													<a class="" href="#" data-bs-toggle="dropdown" aria-expanded="false">



														<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/More.png"?>" >



													</a>



													<ul class="dropdown-menu heder-dropdown-menu action_dropdawn" aria-labelledby="dropdownMenuLink">



														<li class="float_left_width_100">



															<a href="?page=gmgt_payment&tab=view_invoice&idtest=<?php echo $retrieved_data->invoice_id; ?>&invoice_type=expense" class="float_left_width_100"><i class="fa fa-eye" aria-hidden="true"></i> <?php esc_html_e('View Invoice', 'gym_mgt' ) ;?></a>



														</li>



														<?php 



														if($user_access_edit == '1')



														{ 



															?>



															<li class="float_left_width_100 border_bottom_item">



																<a href="?page=gmgt_payment&tab=addexpense&action=edit&expense_id=<?php echo esc_attr($retrieved_data->invoice_id);?>" class="float_left_width_100"><i class="fa fa-edit"></i> <?php esc_html_e('Edit', 'gym_mgt' ) ;?>



																</a>



															</li>



															<?php 



														}



														if($user_access_delete =='1')



														{ 



															?>



															<li class="float_left_width_100">



																<a href="?page=gmgt_payment&tab=expenselist&action=delete&expense_id=<?php echo esc_attr($retrieved_data->invoice_id);?>" class="float_left_width_100 list_delete_btn" onclick="return confirm('<?php esc_html_e('Are you sure you want to delete this record?','gym_mgt');?>');"><i class="fa fa-trash"></i> <?php esc_html_e( 'Delete', 'gym_mgt' ) ;?> </a>



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



						?>



						</tbody>



					</table><!--EXPENSE LIST TABLE END-->



					<div class="print-button pull-left">



						<button class="btn btn-success btn-sms-color">



							<input type="checkbox" name="id[]" class="select_all" value="<?php echo esc_attr($retrieved_data->invoice_id); ?>" style="margin-top: 0px;">



							<label for="checkbox" class="margin_right_5px"><?php esc_html_e( 'Select All', 'gym_mgt' ) ;?></label>



						</button>



						<?php 



						if($user_access_delete =='1')



						{ ?>



							<button data-toggle="tooltip"  id="delete_selected" title="<?php esc_html_e('Delete Selected','gym_mgt');?>" name="delete_selected_expense" class="delete_selected" ><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Delete.png" ?>" alt=""></button>



							<?php 



						} 



						?>



					</div>



				</form><!--EXPENSE LIST FORM END-->



			</div><!--TABLE RESPONSIVE DIV END-->



		</div><!--PANEL BODY DIV END-->



		<?php



	}



	else



	{

		if($user_access_add == 1)

		{

			?>



			<div class="no_data_list_div"> 



				<a href="<?php echo admin_url().'admin.php?page=gmgt_payment&tab=addexpense';?>">



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



	} ?>



	<?php  



} 



?>