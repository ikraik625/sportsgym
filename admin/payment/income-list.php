<?php



$obj_payment= new MJ_gmgt_payment();



if($active_tab == 'incomelist')



{



	$invoice_id=0;



	$edit=0;



	if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')



	{



		$edit=1;



		$invoice_id=$_REQUEST['income_id'];



		$result = $obj_payment->hmgt_get_invoice_data($invoice_id);



	}



	?>



	



    <div class="panel-body padding_0"><!--PANEL BODY DIV START-->



		<?php



		$paymentdata=$obj_payment->MJ_gmgt_get_all_income_data();



		if(!empty($paymentdata))



		{







			?>



			<div class="table-responsive"><!--TABLE RESPONSIVE DIV START-->



				<script type="text/javascript">



					$(document).ready(function() 



					{



						"use strict";



						jQuery('#tblincome').DataTable({



							// "responsive": true,



							"order": [[ 3, "asc" ]],



							dom: 'lifrtp',



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



										{"bSortable": false}



									],



									language:<?php echo MJ_gmgt_datatable_multi_language();?>	   



						});



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



						$(".payment_reminder").on('click', function()



						{	



							if ($('.sub_chk:checked').length == 0 )



							{



								alert("<?php esc_html_e('Please select at least one record','gym_mgt');?>");



								return false;



							}



							else{



								return true;



							}



						});



						$('.dataTables_filter input').attr("placeholder", "<?php esc_html_e('Search...', 'gym_mgt') ?>");



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



					});



				</script>



				<form name="wcwm_report" action="" method="post"><!--INCOME LIST FORM START-->



					<table id="tblincome" class="display" cellspacing="0" width="100%"><!--INCOME LIST TABLE START-->

						<thead class="<?php echo MJ_gmgt_datatable_heder(); ?>">

							<tr>

								<th class="padding_0"><input type="checkbox" class="select_all"></th>

								<th><?php esc_html_e('Photo','gym_mgt');?></th>

								<th><?php esc_html_e('Member Name','gym_mgt');?></th>

								<th ><?php esc_html_e('Income Name', 'gym_mgt');?></th>

								<th><?php esc_html_e('Invoice No.','gym_mgt');?></th>

								<th><?php esc_html_e('Total Amount','gym_mgt');?></th>

								<th><?php esc_html_e('Paid Amount','gym_mgt');?></th>

								<th ><?php esc_html_e('Due Amount','gym_mgt');?></th>

								<th><?php esc_html_e('Payment Date','gym_mgt');?></th>

								<th><?php esc_html_e('Payment Status','gym_mgt');?></th>

								<th class="text_align_end"><?php esc_html_e('Action','gym_mgt');?></th>

							</tr>

						</thead>

						

						<tbody>



							<?php 



							//GET ALL INCOME DATA



							$i=0;



							foreach ($paymentdata as $retrieved_data)



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



								if(empty($retrieved_data->invoice_no))



								{



									$invoice_no='-';



									if($retrieved_data->invoice_label=='Sell Product')



									{	



										$entry=json_decode($retrieved_data->entry);



										if(!empty($entry))



										{



											foreach($entry as $data)



											{



												$amount=$data->amount;



											}



										}



										$total_amount=$amount;



										$paid_amount=$amount;



										$due_amount='0';



									}



									else



									{



										$entry=json_decode($retrieved_data->entry);



										$amount_value='0';



										if(!empty($entry))



										{



											foreach($entry as $data)



											{



												$amount_value+=$data->amount;	 



											}



										}



										if($retrieved_data->payment_status=='Paid')



										{



											$total_amount=$amount_value;



											$paid_amount=$amount_value;



											$due_amount='0';



										}



										else



										{



											$total_amount=$amount_value;



											$paid_amount='0';



											$due_amount=$amount_value;



										}



									}



								}



								else



								{								



									$invoice_no=$retrieved_data->invoice_no;



									$total_amount=$retrieved_data->total_amount;



									$paid_amount=$retrieved_data->paid_amount;



									$due_amount=abs($total_amount-$paid_amount);



								}



								if($retrieved_data->total_amount == '0')



								{



									$status='Fully Paid';



								}



								else



								{



									$status=$retrieved_data->payment_status;



								}



								?>



								<tr>



									<td class="checkbox_width_10px">

										<input type="checkbox" name="selected_id[]" class="smgt_sub_chk sub_chk" value="<?php echo esc_attr($retrieved_data->invoice_id); ?>">

									</td>



									<td class="user_image width_50px profile_image_prescription padding_left_0">	



										<p class="prescription_tag padding_15px margin_bottom_0px <?php echo $color_class; ?>">	



											<img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/Payment.png"?>" alt="" class="massage_image center image_icon_height_25px margin_top_3px">



										</p>



									</td>



									<td class="member_name"><?php $user=get_userdata($retrieved_data->supplier_name);



										$memberid=get_user_meta($retrieved_data->supplier_name,'member_id',true);



										// $display_label=$user->display_name;



										$display_label = MJ_gmgt_get_member_full_display_name_with_memberid(esc_html($user->ID));

										if($display_label)

										{

											echo esc_html($display_label);

										}

										else

										{

											echo "N/A";

										}



										?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Member Name','gym_mgt');?>" >



									</td>



									<td class="income_amount"><?php echo _e($retrieved_data->invoice_label,"gym_mgt");?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Income Name','gym_mgt');?>" ></td>



									<td class="income_amount">							



										<?php



										echo esc_html($invoice_no);	



										?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Invoice No.','gym_mgt');?>" >



									</td>



									<td class="income_amount"><?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?> <?php echo number_format(esc_html($total_amount),2);?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Total Amount','gym_mgt');?>" ></td>



									<td class="income_amount"><?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?> <?php echo number_format(esc_html($paid_amount),2);?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Paid Amount','gym_mgt');?>" ></td>



									<td class="income_amount"><?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?> <?php echo number_format(esc_html($due_amount),2);?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Due Amount','gym_mgt');?>" ></td>



									



									<td class="status"><?php if($retrieved_data->invoice_date == "0000-00-00"){ echo "0000-00-00"; }else{ echo MJ_gmgt_getdate_in_input_box(esc_html($retrieved_data->invoice_date)); } ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Payment Date','gym_mgt');?>" ></td>



									<td class="paymentdate">



										<?php



										if($status == 'Unpaid')



										{



										echo "<span class='Unpaid_status_color'>";



										}



										elseif($status == 'Partially Paid')



										{



											echo "<span style='color:blue;'>";



										}



										else



										{



										echo "<span class='fullpaid_status_color'>";



										}



										echo esc_html__("$status","gym_mgt");



										echo "</span>";



										?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Payment Status','gym_mgt');?>" >



									</td>								



									<?php



									if (($retrieved_data->total_amount > '0' ) && ($retrieved_data->payment_status == 'Unpaid' || $retrieved_data->payment_status == 'Partially Paid' || $retrieved_data->payment_status == 'Part Paid' || $retrieved_data->payment_status == 'Not Paid') )



									{



										?>



										<td class="action"> 



											<div class="gmgt-user-dropdown">



												<ul class="" style="margin-bottom: 0px !important;">



													<li class="">



														<a class="" href="#" data-bs-toggle="dropdown" aria-expanded="false">



															<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/More.png"?>" >



														</a>



														<ul class="dropdown-menu heder-dropdown-menu action_dropdawn" aria-labelledby="dropdownMenuLink">



															<li class="float_left_width_100">



																<a href="?page=gmgt_payment&tab=view_invoice&idtest=<?php echo $retrieved_data->invoice_id; ?>&invoice_type=income" class="float_left_width_100" 



																><i class="fa fa-eye" aria-hidden="true"></i> <?php esc_html_e('View Invoice', 'gym_mgt' ) ;?></a>



															</li>



															<li class="float_left_width_100">



																<a href="?page=gmgt_payment&action=reminder&invoice_id=<?php echo $retrieved_data->invoice_id; ?>" name="fees_reminder" class="float_left_width_100"><i class="fa fa-bell" aria-hidden="true"></i> <?php esc_html_e('Payment Reminder', 'gym_mgt' ) ;?></a>



															</li>



															<li class="float_left_width_100">



																<a href="#" name="fees_reminder" class="show-payment-popup float_left_width_100" idtest="<?php echo esc_attr($retrieved_data->invoice_id); ?>" member_id="<?php echo esc_attr($retrieved_data->supplier_name); ?>" due_amount="<?php echo str_replace(",","",number_format($due_amount,2)); ?>"view_type="income_payment" ><i class="fa fa-credit-card" aria-hidden="true"></i> <?php esc_html_e('Pay', 'gym_mgt' ) ;?></a>



															</li>



															



															<?php 



															if($user_access_edit == '1')



															{ 



																if(!empty($retrieved_data->invoice_no))



																{



																	if(!($retrieved_data->invoice_label=='Fees Payment' || $retrieved_data->invoice_label=='Sell Product'))



																	{



																		?>



																		<li class="float_left_width_100 border_bottom_item">



																			<a href="?page=gmgt_payment&tab=addincome&action=edit&income_id=<?php echo esc_attr($retrieved_data->invoice_id)?>" class="float_left_width_100"><i class="fa fa-edit"></i> <?php esc_html_e('Edit', 'gym_mgt' ) ;?>



																			</a>



																		</li>



																		<?php 



																	}



																}



															}



															if($user_access_delete =='1')



															{ 



																?>



																<li class="float_left_width_100 border_top_item">



																	<a href="?page=gmgt_payment&tab=incomelist&action=delete&income_id=<?php echo esc_attr($retrieved_data->invoice_id);?>" class="float_left_width_100 list_delete_btn" onclick="return confirm('<?php esc_html_e('Are you sure you want to delete this record?','gym_mgt');?>');"><i class="fa fa-trash"></i> <?php esc_html_e( 'Delete', 'gym_mgt' ) ;?> </a>



																</li>



																<?php 



															} 



															?>



														</ul>



													</li>



												</ul>



											</div>	



										</td>



										<?php 



									}  



									if ($retrieved_data->total_amount == '0' || $retrieved_data->payment_status == 'Fully Paid' || $retrieved_data->payment_status == 'Paid') 



									{



										?>



										<td class="action"> 



											<div class="gmgt-user-dropdown">



												<ul class="" style="margin-bottom: 0px !important;">



													<li class="">



														<a class="" href="#" data-bs-toggle="dropdown" aria-expanded="false">



															<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/More.png"?>" >



														</a>



														<ul class="dropdown-menu heder-dropdown-menu action_dropdawn" aria-labelledby="dropdownMenuLink">



															<li class="float_left_width_100">



																<a href="?page=gmgt_payment&tab=view_invoice&idtest=<?php echo $retrieved_data->invoice_id; ?>&invoice_type=income" class="float_left_width_100" ><i class="fa fa-eye" aria-hidden="true"></i> <?php esc_html_e('View Invoice', 'gym_mgt' ) ;?></a>



															</li>



															<?php 



															if($user_access_edit == '1')



															{ 



																if(!empty($retrieved_data->invoice_no))



																{



																	if(!($retrieved_data->invoice_label=='Fees Payment' || $retrieved_data->invoice_label=='Sell Product'))



																	{



																		?>



																		<li class="float_left_width_100 border_bottom_item">



																			<a href="?page=gmgt_payment&tab=addincome&action=edit&income_id=<?php echo esc_attr($retrieved_data->invoice_id);?>" class="float_left_width_100"><i class="fa fa-edit"></i> <?php esc_html_e('Edit', 'gym_mgt' ) ;?>



																			</a>



																		</li>



																		<?php 



																	}



																}



															}



															if($user_access_delete =='1')



															{ 



																?>



																<li class="float_left_width_100 border_top_item">



																	<a href="?page=gmgt_payment&tab=incomelist&action=delete&income_id=<?php echo esc_attr($retrieved_data->invoice_id);?>" class="float_left_width_100 list_delete_btn" onclick="return confirm('<?php esc_html_e('Are you sure you want to delete this record?','gym_mgt');?>');"><i class="fa fa-trash"></i> <?php esc_html_e( 'Delete', 'gym_mgt' ) ;?> </a>



																</li>



																<?php 



															} 



															?>



														</ul>



													</li>



												</ul>



											</div>	



										</td>



										<?php



									}



									?>



								</tr>



								<?php



								$i++;



							}



							?>



						</tbody>        



					</table><!--INCOME LIST TABLE END-->



					<div class="print-button pull-left">



						<button class="btn btn-success btn-sms-color">



							<input type="checkbox" name="id[]" class="select_all" value="<?php echo esc_attr($retrieved_data->invoice_id); ?>" style="margin-top: 0px;">



							<label for="checkbox" class="margin_right_5px"><?php esc_html_e( 'Select All', 'gym_mgt' ) ;?></label>



						</button>



						<?php 



						if($user_access_delete =='1')



						{ ?>



							<button data-toggle="tooltip"  id="delete_selected" title="<?php esc_html_e('Delete Selected','gym_mgt');?>" name="delete_selected_income" class="delete_selected" ><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Delete.png" ?>" alt=""></button>



							<?php 



						} 



						?>



						<button data-toggle="tooltip"  id="payment_reminder" title="<?php esc_html_e('Payment Reminder','gym_mgt');?>" name="payment_reminder" class="payment_reminder" ><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/payment_reminder.png" ?>" alt=""></button>



					</div>



				</form><!--INCOME LIST FORM END-->



			</div><!--TABLE RESPONSIVE DIV END-->



			<?php



		}



		else



		{

			if($user_access_add == 1)

			{

				?>



				<div class="no_data_list_div"> 



					<a href="<?php echo admin_url().'admin.php?page=gmgt_payment&tab=addincome';?>">



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



	</div><!--PANEL BODY DIV END-->



	<?php 



} 



?>