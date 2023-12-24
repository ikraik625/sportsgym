<?php



$obj_class=new MJ_gmgt_classschedule;



$obj_product=new MJ_gmgt_product;



$obj_store=new MJ_gmgt_store;



$obj_membership_payment=new MJ_gmgt_membership_payment;



$active_tab = isset($_GET['tab'])?$_GET['tab']:'store';



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



	$user_access=MJ_gmgt_get_userrole_wise_manually_page_access_right_array_for_management('store');



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



			if ('store' == $user_access['page_link'] && ($_REQUEST['action']=='edit'))



			{



				if($user_access_edit=='0')



				{	



					MJ_gmgt_access_right_page_not_access_message_for_management();



					die;



				}			



			}



			if ('store' == $user_access['page_link'] && ($_REQUEST['action']=='delete'))



			{



				if($user_access_delete=='0')



				{	



					MJ_gmgt_access_right_page_not_access_message_for_management();



					die;



				}	



			}



			if ('store' == $user_access['page_link'] && ($_REQUEST['action']=='insert'))



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



		    <div class="invoice_data">



		    </div>



	    </div>



    </div>



</div>



<!-- End POP-UP Code -->



<div class="page-inner min_height_1631"><!--PAGE INNER DIV STRAT-->



	<?php	



	//ADD SELL Payment DATA



	if(isset($_POST['add_fee_payment']))



	{



		$result=$obj_store->MJ_gmgt_sell_payment($_POST);



		if($result)



		{



			wp_redirect ( admin_url().'admin.php?page=gmgt_store&tab=store&message=5');



		}	



	}



	//SAVE SELL PRODUCT DATA



	if(isset($_POST['save_selling']))



	{



		$nonce = $_POST['_wpnonce'];



		if (wp_verify_nonce( $nonce, 'save_selling_nonce' ) )



		{



			if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit')



			{		



				$result=$obj_store->MJ_gmgt_sell_product($_POST);



				if($result=='3')



				{



				?>



				



					<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">



						<p><?php esc_html_e('Discount Amount Must Be Less Than Product Total Amount','gym_mgt');?></p>



						<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>



					</div>



				<?php 



				}



				else



				{



					wp_redirect ( admin_url().'admin.php?page=gmgt_store&tab=store&message=2');



				}



			}



			else



			{		



				



				$result=$obj_store->MJ_gmgt_sell_product($_POST);



				



				if($result=='3')



				{



				?>



					<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">



						<p><?php esc_html_e('Discount Amount Must Be Less Than Product Total Amount','gym_mgt');?></p>



						<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>



					</div>				 



				<?php 



				}



				else



				{	



					wp_redirect ( admin_url().'admin.php?page=gmgt_store&tab=store&message=1');



				}



			}		



		}



	}



	// select all member payment reminder 



	if(isset($_REQUEST['payment_reminder']))



    {



		if(!empty($_REQUEST['selected_id']))



		{



			foreach($_REQUEST['selected_id'] as $id)



			{



				$member_reminder=$obj_membership_payment->MJ_gmgt_get_all_store_payments_by_mpid($id);



		



				foreach($member_reminder as $member_id)



				{



					if(MJ_gmgt_get_store_paymentstatus($member_id->id) != 'Fully Paid')



					{



						$due_amount=$member_id->total_amount - $member_id->paid_amount;



						$user=get_userdata($member_id->member_id);



						$membership_id=get_user_meta($paymentdata->member_id,'membership_id',true);



						$subject	= 	get_option('invoice_payment_reminder_subject'); 



						$currency_symbol  =   MJ_gmgt_strip_tags_and_stripslashes(MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )));



						$Seach['{{GMGT_RECEIVER_NAME}}']	     =	 MJ_gmgt_get_user_full_display_name($member_id->member_id);



						$Seach['{{GMGT_INVOICE_NUMBER}}']		 =	 $member_id->invoice_no;



						$Seach['{{GMGT_TOTOAL_AMOUNT}}']	 	 =	 $currency_symbol.' '.$member_id->total_amount;



						$Seach['{{GMGT_DUE_AMOUNT}}']		     =	 $currency_symbol.' '.$due_amount;



						$Seach['{{GMGT_MEMBERSHIP_NAME}}']		 =	 MJ_gmgt_get_membership_name($membership_id);



						$Seach['{{GMGT_GYM_NAME}}']	     =	 get_option( 'gmgt_system_name' );			



						$MsgContent = MJ_gmgt_string_replacemnet($Seach,get_option('invoice_payment_reminder_template'));



						$to[]= $user->user_email;



						$send=MJ_gmgt_send_mail($to,$subject,$MsgContent);	



					}



				}



			}



			if($send)



			{



				wp_redirect ( admin_url() . 'admin.php?page=gmgt_store&tab=store&message=6');



			}



			else 



			{



				wp_redirect ( admin_url() . 'admin.php?page=gmgt_store&tab=store&message=7');



			}



		}



		else



		{



			echo '<script language="javascript">';



            echo 'alert("'.esc_html__('Please select at least one record.','gym_mgt').'")';



            echo '</script>';



		}



		



	}



	/* Payment Reminder */



	if(isset($_REQUEST['action']) && $_REQUEST['action']=='reminder' && isset($_REQUEST['member_id']))



	{



		$paymentdata=$obj_membership_payment->MJ_gmgt_get_store_payments_by_mpid($_REQUEST['member_id']);



		if(!empty($paymentdata))



		{



			$due_amount=$paymentdata->total_amount - $paymentdata->paid_amount;



			$user=get_userdata($paymentdata->member_id);



			$membership_id=get_user_meta($paymentdata->member_id,'membership_id',true);



			$subject	= 	get_option('invoice_payment_reminder_subject'); 



			$currency_symbol  =   MJ_gmgt_strip_tags_and_stripslashes(MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )));



			$Seach['{{GMGT_RECEIVER_NAME}}']	     =	 MJ_gmgt_get_user_full_display_name($paymentdata->member_id);



			$Seach['{{GMGT_INVOICE_NUMBER}}']		 =	 $paymentdata->invoice_no;



			$Seach['{{GMGT_TOTOAL_AMOUNT}}']	 	 =	 $currency_symbol.' '.$paymentdata->total_amount;



			$Seach['{{GMGT_DUE_AMOUNT}}']		     =	 $currency_symbol.' '.$due_amount;



			$Seach['{{GMGT_MEMBERSHIP_NAME}}']		 =	 MJ_gmgt_get_membership_name($membership_id);



			$Seach['{{GMGT_GYM_NAME}}']	     =	 get_option( 'gmgt_system_name' );			



			$MsgContent = MJ_gmgt_string_replacemnet($Seach,get_option('invoice_payment_reminder_template'));



			$to[]= $user->user_email;



			$send=MJ_gmgt_send_mail($to,$subject,$MsgContent);	



			if($send)



			{



				wp_redirect ( admin_url() . 'admin.php?page=gmgt_store&tab=store&message=6');



			}



			else 



			{



				wp_redirect ( admin_url() . 'admin.php?page=gmgt_store&tab=store&message=7');



			}	



		}



		else 



		{



			wp_redirect ( admin_url() . 'admin.php?page=gmgt_store&tab=store&message=7');



		}	



	}



	//Delete SELL Product DATA



	if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')



	{	



		$result=$obj_store->MJ_gmgt_delete_selling(esc_attr($_REQUEST['sell_id']));



		if($result)



		{



			wp_redirect ( admin_url().'admin.php?page=gmgt_store&tab=store&message=3');



		}



	}



	//Delete Selected SELL Product DATA



	if(isset($_REQUEST['delete_selected']))



    {



		if(!empty($_REQUEST['selected_id']))



		{



			foreach($_REQUEST['selected_id'] as $id)



			{



				$delete_store=$obj_store->MJ_gmgt_delete_selling($id);



			}



			if($delete_store)



			{



				wp_redirect ( admin_url().'admin.php?page=gmgt_store&tab=store&message=3');



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



				<p><?php esc_html_e('Sale Product Record Insert Successfully.','gym_mgt');?></p>



				<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>



			</div>



		<?php	



		}



		elseif($message == 2)



		{?>



			<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">



				<p><?php esc_html_e("Sale Product Record Updated Successfully.",'gym_mgt');?></p>



				<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>



			</div>



		<?php	



		}



		elseif($message == 3) 



		{?>	



			<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">



				<p><?php esc_html_e('Sale Product Record Deleted Successfully.','gym_mgt');?></p>



				<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>



			</div>



		<?php



		}



		elseif($message == 4) 



		{?>



			<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">



				<p><?php esc_html_e('Out of Stock product.','gym_mgt');?></p>



				<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>



			</div>



		<?php	



		}



		elseif($message == 5) 



		{?>



			<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">



				<p><?php esc_html_e('Payment successfully.','gym_mgt');?></p>



				<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>



			</div>



		<?php	



		}



		elseif($message == 6) 



		{?>



			<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">



				<p><?php esc_html_e('Payment Reminder Mail Sent successfully.','gym_mgt');?></p>



				<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>



			</div>



		<?php	



		}



		elseif($message == 7) 



		{?>



			<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">



				<p><?php esc_html_e('Unable to send reminder emails.','gym_mgt');?></p>



				<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>



			</div>



		<?php	



		}



	}



	?>



	<div id="" class="gms_main_list"><!--MAIN WRAPPER DIV STRAT-->



		<div class="row"><!--ROW DIV STRAT-->



			<div class="col-md-12"><!--COL 12 DIV STRAT-->



				<div class=""><!--PANEL WHITE DIV STRAT-->



					<div class="panel-body padding_0"><!--PANEL BODY DIV STRAT-->



						



						<?php 	



						if($active_tab == 'store')



						{ 	



							$storedata=$obj_store->MJ_gmgt_get_all_selling();



							if(!empty($storedata))



							{					



								?>	



								<script type="text/javascript">



									$(document).ready(function() 



									{



										"use strict";



										$('#selling_list').DataTable({



										// "responsive": true,



										"order": [[ 1, "asc" ]],



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



													{"bSortable": false}],



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



										$(".payment_reminder").on('click', function()



										{	



											if ($('.sub_chk:checked').length == 0 )



											{



												alert("<?php esc_html_e('Please select atleast one record','gym_mgt');?>");



												return false;



											}



											else{



												return true;



											}



										});



										$('.dataTables_filter input').attr("placeholder", "<?php esc_html_e('Search...', 'gym_mgt') ?>");



									} );



								</script>



								<form name="wcwm_report" action="" method="post"><!--SELL Product LIST FORM START-->	



									<div class="panel-body padding_0"><!--PANEL BODY DIV START-->



										<div class="table-responsive"><!--TABLE RESPONSIVE DIV START-->



											<table id="selling_list" class="display" cellspacing="0" width="100%"><!--SELL Product LIST TABLE START-->

												<thead class="<?php echo MJ_gmgt_datatable_heder(); ?>">

													<tr>

														<th class="padding_0"><input type="checkbox" class="select_all"></th>

														<th><?php esc_html_e('Photo','gym_mgt');?></th>

														<th><?php esc_html_e('Invoice No.','gym_mgt');?></th>

														<th><?php esc_html_e('Member Name','gym_mgt');?></th>

														<th><?php esc_html_e('Product Name=>Product Quantity','gym_mgt');?></th>

														<th><?php esc_html_e('Total Amount','gym_mgt');?></th>

														<th><?php esc_html_e('Paid Amount','gym_mgt');?></th>

														<th><?php esc_html_e('Due Amount','gym_mgt');?></th>

														<th><?php esc_html_e('Payment Status','gym_mgt');?></th>

														<th class="text_align_end"><?php esc_html_e('Action','gym_mgt');?></th>

													</tr>

												</thead>

												<tbody>



													<?php 		



													//GET SELL PRODUCT DATA



													if(!empty($storedata))



													{



														$i=0;



														foreach ($storedata as $retrieved_data)



														{



															if(empty($retrieved_data->invoice_no))



															{



																$obj_product=new MJ_gmgt_product;



																$product = $obj_product->MJ_gmgt_get_single_product($retrieved_data->product_id);



																$price=$product->price;	



																$quentity=$retrieved_data->quentity;



																$invoice_no='-';					



																$total_amount=$price*$quentity;



																$paid_amount=$price*$quentity;



																$due_amount='0';



															}



															else



															{



																$invoice_no=$retrieved_data->invoice_no;



																$total_amount=$retrieved_data->total_amount;



																$paid_amount=$retrieved_data->paid_amount;



																$due_amount=$total_amount-$paid_amount;



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



																<td class="checkbox_width_10px">

																	<input type="checkbox" name="selected_id[]" class="smgt_sub_chk sub_chk" value="<?php echo esc_attr($retrieved_data->id); ?>">

																</td>



																<td class="user_image width_50px profile_image_prescription padding_left_0">	



																	<p class="prescription_tag padding_15px margin_bottom_0px <?php echo $color_class; ?>">	



																		<img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/Store.png"?>" alt="" class="massage_image center image_icon_height_25px margin_top_3px">



																	</p>



																</td>



																<td class="productquentity"><?php echo esc_html($invoice_no); ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Invoice No.','gym_mgt');?>" ></td>	



																<td class="membername"><?php echo MJ_gmgt_get_member_full_display_name_with_memberid(esc_html($retrieved_data->member_id)); ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Member Name','gym_mgt');?>" ></td>



																<td class="productname">



																<?php 



																$entry_valuea=json_decode($retrieved_data->entry);



																



																if(!empty($entry_valuea))



																{



																	foreach($entry_valuea as $entry_valueb)



																	{



																		$product = $obj_product->MJ_gmgt_get_single_product($entry_valueb->entry);



																		if(!empty($product))



																		{



																		$product_name=$product->product_name;



																		$quentity=$entry_valueb->quentity;



																		$product_quantity=$product_name . " => " . $quentity . ",";



																		echo rtrim(esc_html($product_quantity),',');



																		}



																		else {



																			echo "N/A";



																		}



																		?>



																		<br>



																		<?php



																	}



																}



																else



																{



																	$obj_product=new MJ_gmgt_product;



																	$product = $obj_product->MJ_gmgt_get_single_product($retrieved_data->product_id);



																	$product_name=$product->product_name;



																	$quentity=$retrieved_data->quentity;	



																	echo  esc_html($product_name). " => " .esc_html($quentity);



																}



																?>



																<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Product Name=>Product Quantity','gym_mgt');?>" >



																</td>		



																<td class="productquentity"><?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?> <?php echo MJ_gmgt_get_floting_value($total_amount); ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Total Amount','gym_mgt');?>" ></td>



																<td class="productquentity"><?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?> <?php echo MJ_gmgt_get_floting_value($paid_amount); ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Paid Amount','gym_mgt');?>" ></td>



																<td class="totalamount"><?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?> <?php echo MJ_gmgt_get_floting_value($due_amount); ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Due Amount','gym_mgt');?>" ></td>



																<td class="paymentdate">



																	<?php



																	if(!empty($retrieved_data->payment_status))



																	{



																		



																		if($retrieved_data->payment_status == 'Unpaid')



																		{



																			echo "<span class='Unpaid_status_color'>";



																		}



																		elseif($retrieved_data->payment_status == 'Partially Paid')



																		{



																			echo "<span style='color:blue;'>";



																		}



																		else



																		{



																			echo "<span class='fullpaid_status_color'>";



																		}															



																		echo  esc_html__("$retrieved_data->payment_status","gym_mgt");



																		echo "</span>";



																	}



																	else



																	{



																		echo "<span class='fullpaid_status_color'>";	



																		echo  esc_html__("Fully Paid","gym_mgt");



																		echo "</span>";



																	}	



																	?>



																	<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Payment Status','gym_mgt');?>" >



																</td>



																<?php 



																if ($retrieved_data->payment_status == 'Unpaid' || $retrieved_data->payment_status == 'Partially Paid')



																{



																	$due_amount=$retrieved_data->total_amount-$retrieved_data->paid_amount;



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



																							<a href="?page=gmgt_store&tab=view_invoice&idtest=<?php echo $retrieved_data->id; ?>&invoice_type=sell_invoice" class=" float_left_width_100"><i class="fa fa-eye" aria-hidden="true"></i> <?php esc_html_e('View Invoice', 'gym_mgt' ) ;?></a>



																						</li>



																						<li class="float_left_width_100">



																							<a href="?page=gmgt_store&tab=store&action=reminder&member_id=<?php echo $retrieved_data->member_id; ?>" name="fees_reminder" class="float_left_width_100"><i class="fa fa-bell" aria-hidden="true"></i> <?php esc_html_e('Payment Reminder', 'gym_mgt' ) ;?></a>



																						</li>



																						<li class="float_left_width_100">



																							<a href="#" name="fees_reminder" class="show-payment-popup float_left_width_100" idtest="<?php echo esc_attr($retrieved_data->id); ?>" member_id="<?php echo esc_attr($retrieved_data->member_id); ?>" due_amount="<?php echo str_replace(",","",number_format(esc_attr($due_amount),2)); ?>" view_type="sale_payment"><i class="fa fa-credit-card" aria-hidden="true"></i> <?php esc_html_e('Pay', 'gym_mgt' ) ;?></a>



																						</li>



																						



																						<?php 



																						if($user_access_edit == '1')



																						{ 



																							if(!empty($retrieved_data->invoice_no))



																							{



																								?>



																								<li class="float_left_width_100 border_bottom_item">



																									<a href="?page=gmgt_store&tab=sellproduct&action=edit&sell_id=<?php echo esc_attr($retrieved_data->id)?>" class="float_left_width_100"><i class="fa fa-edit"></i> <?php esc_html_e('Edit', 'gym_mgt' ) ;?>



																									</a>



																								</li>



																								<?php 



																							}



																						}



																						if($user_access_delete =='1')



																						{ 



																							?>



																							<li class="float_left_width_100">



																								<a href="?page=gmgt_store&tab=store&action=delete&sell_id=<?php echo esc_attr($retrieved_data->id);?>" class="float_left_width_100 list_delete_btn" onclick="return confirm('<?php esc_html_e('Are you sure you want to delete this record?','gym_mgt');?>');"><i class="fa fa-trash"></i> <?php esc_html_e( 'Delete', 'gym_mgt' ) ;?> </a>



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



																if ($retrieved_data->payment_status == 'Fully Paid'  || $retrieved_data->payment_status == '' ) 



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



																							<a href="?page=gmgt_store&tab=view_invoice&idtest=<?php echo $retrieved_data->id; ?>&invoice_type=sell_invoice" class="float_left_width_100"><i class="fa fa-eye" aria-hidden="true"></i> <?php esc_html_e('View Invoice', 'gym_mgt' ) ;?></a>



																						</li>



																						<?php 



																						if($user_access_edit == '1')



																						{ 



																							if(!empty($retrieved_data->invoice_no))



																							{



																								?>



																								<li class="float_left_width_100 border_bottom_item">



																									<a href="?page=gmgt_store&tab=sellproduct&action=edit&sell_id=<?php echo esc_attr($retrieved_data->id)?>" class="float_left_width_100"><i class="fa fa-edit"></i> <?php esc_html_e('Edit', 'gym_mgt' ) ;?>



																									</a>



																								</li>



																								<?php 



																							}



																						}



																						if($user_access_delete =='1')



																						{ 



																							?>



																							<li class="float_left_width_100">



																								<a href="?page=gmgt_store&tab=store&action=delete&sell_id=<?php echo esc_attr($retrieved_data->id);?>" class="float_left_width_100 list_delete_btn" onclick="return confirm('<?php esc_html_e('Are you sure you want to delete this record?','gym_mgt');?>');"><i class="fa fa-trash"></i> <?php esc_html_e( 'Delete', 'gym_mgt' ) ;?> </a>



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



													}



													?>



												</tbody>



											</table><!--SELL Product LIST TABLE END-->	



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



												<button data-toggle="tooltip"  id="payment_reminder" title="<?php esc_html_e('Payment Reminder','gym_mgt');?>" name="payment_reminder" class="payment_reminder" ><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/payment_reminder.png" ?>" alt=""></button>



											</div>



										</div><!--TABLE RESPONSIVE DIV END-->	



									</div>	<!--PANEL BODY END-->			   



								</form><!--SELL Product LIST FORM END-->



								 <?php 



							}



							else



							{

								if($user_access_add == 1)

								{

									?>



									<div class="no_data_list_div"> 



										<a href="<?php echo admin_url().'admin.php?page=gmgt_store&tab=sellproduct';?>">



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



						if($active_tab == 'sellproduct')



						{



							require_once GMS_PLUGIN_DIR. '/admin/store/sell_product.php';



						}



						if($active_tab == 'view_invoice')



						{



							require_once GMS_PLUGIN_DIR. '/admin/view_invoice.php';



						}			



						?>



					</div><!--PANEL BODY DIV END-->					



				</div><!--PANEL WHITE DIV END-->



			</div><!--COL 12 DIV END-->



		</div><!--ROW DIV END-->



	</div><!--MAIN WRAPPER DIV END-->



</div><!--PAGE INNER DIV END-->