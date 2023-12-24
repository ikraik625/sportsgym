<?php 



$obj_class=new MJ_gmgt_classschedule;



$obj_payment=new MJ_gmgt_payment;



$obj_membership_payment=new MJ_gmgt_membership_payment;



global $wpdb;



$active_tab = isset($_GET['tab'])?$_GET['tab']:'incomelist';



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



	$user_access=MJ_gmgt_get_userrole_wise_manually_page_access_right_array_for_management('payment');



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



			if ('payment' == $user_access['page_link'] && ($_REQUEST['action']=='edit'))



			{



				if($user_access_edit=='0')



				{	



					MJ_gmgt_access_right_page_not_access_message_for_management();



					die;



				}			



			}



			if ('payment' == $user_access['page_link'] && ($_REQUEST['action']=='delete'))



			{



				if($user_access_delete=='0')



				{	



					MJ_gmgt_access_right_page_not_access_message_for_management();



					die;



				}	



			}



			if ('payment' == $user_access['page_link'] && ($_REQUEST['action']=='insert'))



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



		   <div class="invoice_data"> </div>



        </div>



    </div> 



</div>



<!-- End POP-UP Code -->



<div class="page-inner min_height_1631"><!--PAGE INNER DIV START-->	



	<?php 



	//SAVE PAYMENT DATA



	if(isset($_POST['save_product']))



	{



		$nonce = $_POST['_wpnonce'];



		if (wp_verify_nonce( $nonce, 'save_product_nonce' ) )



		{



			if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit')



			{



				$result=$obj_payment->MJ_gmgt_add_payment($_POST);



				if($result)



				{



					wp_redirect ( admin_url().'admin.php?page=gmgt_payment&tab=paymentlist&message=2');



				}



			}



			else



			{



				$result=$obj_payment->MJ_gmgt_add_payment($_POST);



				if($result)



				{



					wp_redirect ( admin_url().'admin.php?page=gmgt_payment&tab=paymentlist&message=1');



				}



			}



		}



	}



	//DELETE PAYMENT,INCOME AND EXPENSE DATA



	if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')



	{



		if(isset($_REQUEST['payment_id']))



		{



			$result=$obj_payment->MJ_gmgt_delete_payment($_REQUEST['payment_id']);



			if($result)



			{



				wp_redirect ( admin_url().'admin.php?page=gmgt_payment&tab=paymentlist&message=3');



			}



		}



		if(isset($_REQUEST['income_id']))



		{



			$result=$obj_payment->MJ_gmgt_delete_income($_REQUEST['income_id']);



			if($result)



			{



				wp_redirect ( admin_url() . 'admin.php?page=gmgt_payment&tab=incomelist&message=3');



			}



		}



		if(isset($_REQUEST['expense_id'])){



			$result=$obj_payment->MJ_gmgt_delete_expense($_REQUEST['expense_id']);



			if($result)



			{



				wp_redirect ( admin_url() . 'admin.php?page=gmgt_payment&tab=expenselist&message=7');



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



				$member_reminder=$obj_membership_payment->MJ_gmgt_get_all_membership_payments_by_mpid($id);



				foreach($member_reminder as $member_id)



				{



					if(MJ_gmgt_get_membership_paymentstatus($member_id->mp_id) != 'Fully Paid')



					{



						$due_amount=$member_id->membership_amount - $member_id->paid_amount;



						$user=get_userdata($member_id->member_id);



						$subject	= 	get_option('invoice_payment_reminder_subject'); 



						$currency_symbol  =   MJ_gmgt_strip_tags_and_stripslashes(MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )));



						$Seach['{{GMGT_RECEIVER_NAME}}']	     =	 MJ_gmgt_get_user_full_display_name($user->ID);



						$Seach['{{GMGT_INVOICE_NUMBER}}']		 =	 $member_id->invoice_no;



						$Seach['{{GMGT_TOTOAL_AMOUNT}}']	 	 =	 $currency_symbol.' '.$member_id->membership_amount;



						$Seach['{{GMGT_DUE_AMOUNT}}']		     =	 $currency_symbol.' '.$due_amount;



						$Seach['{{GMGT_MEMBERSHIP_NAME}}']		 =	 MJ_gmgt_get_membership_name($member_id->membership_id);



						$Seach['{{GMGT_GYM_NAME}}']	     =	 get_option( 'gmgt_system_name' );			



						$MsgContent = MJ_gmgt_string_replacemnet($Seach,get_option('invoice_payment_reminder_template'));



						$to[]= $user->user_email;



						$send=MJ_gmgt_send_mail($to,$subject,$MsgContent);	



					}



				}



			}



			if($send)



			{



				wp_redirect ( admin_url() . 'admin.php?page=gmgt_payment&tab=incomelist&message=8');



			}



			else 



			{



				wp_redirect ( admin_url() . 'admin.php?page=gmgt_payment&tab=incomelist&message=9');



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



	if(isset($_REQUEST['action']) && $_REQUEST['action']=='reminder' && isset($_REQUEST['invoice_id']))



	{	







		$paymentdata=$obj_membership_payment->MJ_gmgt_get_invoice_payments_by_mpid($_REQUEST['invoice_id']);







		if(!empty($paymentdata))



		{



	



			$due_amount=$paymentdata->total_amount - $paymentdata->paid_amount;



			$membership_id=get_user_meta($paymentdata->supplier_name,'membership_id',true);



			$user=get_userdata($paymentdata->supplier_name);



			$subject	= 	get_option('invoice_payment_reminder_subject'); 



			$currency_symbol  =   MJ_gmgt_strip_tags_and_stripslashes(MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )));



			$Seach['{{GMGT_RECEIVER_NAME}}']	     =	 MJ_gmgt_get_user_full_display_name($user->ID);



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



				wp_redirect ( admin_url() . 'admin.php?page=gmgt_payment&message=8');



			}



			else 



			{



				wp_redirect ( admin_url() . 'admin.php?page=gmgt_payment&message=9');



			}	



		}



		else 



		{



			wp_redirect ( admin_url() . 'admin.php?page=gmgt_payment&message=9');



		}	



	}



	//Multi select delete income data//



	if(isset($_REQUEST['delete_selected_income']))



    {		



		if(!empty($_REQUEST['selected_id']))



		{



			foreach($_REQUEST['selected_id'] as $id)



			{



				$delete_income=$obj_payment->MJ_gmgt_delete_income($id);



			}



			if($delete_income)



			{



				wp_redirect ( admin_url().'admin.php?page=gmgt_payment&tab=incomelist&message=3');



			}



		}



        else



		{







			echo '<script language="javascript">';



            echo 'alert("'.esc_html__('Please select at least one record.','gym_mgt').'")';



            echo '</script>';



		}



	}



	// multi select delete expanse data //



	if(isset($_REQUEST['delete_selected_expense']))



    {		



		if(!empty($_REQUEST['selected_id']))



		{



			foreach($_REQUEST['selected_id'] as $id)



			{



				$delete_expense=$obj_payment->MJ_gmgt_delete_expense($id);



				



			}



			if($delete_expense)



			{



				wp_redirect ( admin_url().'admin.php?page=gmgt_payment&tab=expenselist&message=7');



			}



		}



        else



		{







			echo '<script language="javascript">';



            echo 'alert("'.esc_html__('Please select at least one record.','gym_mgt').'")';



            echo '</script>';



		}



	}



	//--------save income-------------



	if(isset($_POST['save_income']))



	{	



		$nonce = $_POST['_wpnonce'];



		if (wp_verify_nonce( $nonce, 'save_income_nonce' ) )



		{



			if($_REQUEST['action']=='edit')



			{				



				$result=$obj_payment->MJ_gmgt_add_income($_POST);



				if($result)



				{



					wp_redirect ( admin_url() . 'admin.php?page=gmgt_payment&tab=incomelist&message=2');



				}



			}



			else



			{



				



				$result=$obj_payment->MJ_gmgt_add_income($_POST);



				if($result)



				{



					wp_redirect ( admin_url() . 'admin.php?page=gmgt_payment&tab=incomelist&message=1');



				}



			}



		}		



	}		



	//--------save Expense-------------



	if(isset($_POST['save_expense']))



	{	



		$nonce = $_POST['_wpnonce'];



		if (wp_verify_nonce( $nonce, 'save_expense_nonce' ) )



		{		



			if($_REQUEST['action']=='edit')



			{	



				$result=$obj_payment->MJ_gmgt_add_expense($_POST);



				if($result)



				{



					wp_redirect ( admin_url() . 'admin.php?page=gmgt_payment&tab=expenselist&message=6');



				}



			}



			else



			{



				$result=$obj_payment->MJ_gmgt_add_expense($_POST);



				if($result)



				{



					wp_redirect ( admin_url() . 'admin.php?page=gmgt_payment&tab=expenselist&message=5');



				}



			}



		}		



	}



	//ADD INCOME PAYMENT DATA



	if(isset($_POST['add_fee_payment']))



	{			



		$result=$obj_payment->MJ_gmgt_add_income_payment($_POST);



			



		wp_redirect ( admin_url() . 'admin.php?page=gmgt_payment&tab=incomelist&message=4');			



	}



	if(isset($_REQUEST['message']))



	{



		$message =esc_attr($_REQUEST['message']);



		if($message == 1)



		{?>



			<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">



				<p><?php esc_html_e('Invoice added successfully.','gym_mgt');?></p>



				<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>



			</div>	



		<?php



		}



		elseif($message == 2)



		{?>



			<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">



				<p><?php esc_html_e("Invoice updated successfully.",'gym_mgt');?></p>



				<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>



			</div>	



		<?php	



		}



		elseif($message == 3) 



		{?>



			<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">



				<p><?php esc_html_e('Invoice deleted successfully.','gym_mgt');?></p>



				<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>



			</div>



		<?php		



		}



		elseif($message == 4) 



		{?>



			<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">



				<p><?php esc_html_e('Payment successfully.','gym_mgt');?></p>



				<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>



			</div>



		<?php		



		}



		if($message == 5)



		{?>



			<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">



				<p><?php esc_html_e('Expense added successfully.','gym_mgt');?></p>



				<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>



			</div>



		<?php	



		}



		elseif($message == 6)



		{?>



			<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">



				<p><?php esc_html_e("Expense updated successfully.",'gym_mgt');?></p>



				<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>



			</div>



		<?php	



		}



		elseif($message == 7) 



		{?>



			<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">



				<p><?php esc_html_e('Expense deleted successfully.','gym_mgt');?></p>



				<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>



			</div>



		<?php		



		}



		elseif($message == 8) 



		{?>



			<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">



				<p><?php esc_html_e('Payment Reminder Mail Sent successfully.','gym_mgt');?></p>



				<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>



			</div>



		<?php		



		}



		elseif($message == 9) 



		{?>



			<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">



				<p><?php esc_html_e('Unable to send reminder emails.','gym_mgt');?></p>



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



						if($active_tab != "view_invoice")



						{



							?>



							<ul class="nav nav-tabs panel_tabs margin_left_1per mb-3" role="tablist"><!-- NAV TAB WRAPPER MENU START-->



								<li class="<?php if($active_tab=='incomelist'){?>active<?php }?>">



									<a href="?page=gmgt_payment&tab=incomelist" class="padding_left_0 tab <?php echo $active_tab == 'incomelist' ? 'nav-tab-active' : ''; ?>">



									<?php echo esc_html__('Invoice List', 'gym_mgt'); ?></a>



								</li>



								<?php



								if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit' && isset($_REQUEST['income_id']))



								{



									?>



									<li class="<?php if($active_tab=='addincome'){?>active<?php }?>">



										<a href="?page=gmgt_payment&tab=addincome&action=edit&income_id=<?php echo esc_attr($_REQUEST['income_id']);?>" class="padding_left_0 tab <?php echo $active_tab == 'addincome' ? 'nav-tab-active' : ''; ?>">



										<?php echo esc_html__('Edit Invoice', 'gym_mgt'); ?></a>



									</li>



									<?php



								}



								else



								{



									if($user_access_add == '1' && $active_tab=='addincome')



									{



										?>



										<li class="<?php if($active_tab=='addincome'){?>active<?php }?>">



											<a href="?page=gmgt_payment&tab=addincome" class="padding_left_0 tab <?php echo $active_tab == 'addincome' ? 'nav-tab-active' : ''; ?>">



											<?php echo esc_html__('Add Invoice', 'gym_mgt'); ?></a>



										</li>



										<?php



									}



								}



								?>



								<li class="<?php if($active_tab=='expenselist'){?>active<?php }?>">



									<a href="?page=gmgt_payment&tab=expenselist" class="padding_left_0 tab <?php echo $active_tab == 'expenselist' ? 'nav-tab-active' : ''; ?>">



									<?php echo esc_html__('Expense List', 'gym_mgt'); ?></a>



								</li>



								<?php



								if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit' && isset($_REQUEST['expense_id']))



								{



									?>



									<li class="<?php if($active_tab=='addexpense'){?>active<?php }?>">



										<a href="?page=gmgt_payment&tab=addexpense&action=edit&expense_id=<?php echo esc_attr($_REQUEST['expense_id']);?>" class="padding_left_0 tab <?php echo $active_tab == 'addexpense' ? 'nav-tab-active' : ''; ?>">



										<?php echo esc_html__('Edit Expense', 'gym_mgt'); ?></a>



									</li>



									<?php



								}



								else



								{



									if($user_access_add == '1' && $active_tab=='addexpense')



									{



										?>



										<li class="<?php if($active_tab=='addexpense'){?>active<?php }?>">



											<a href="?page=gmgt_payment&tab=addexpense" class="padding_left_0 tab <?php echo $active_tab == 'addexpense' ? 'nav-tab-active' : ''; ?>">



											<?php echo esc_html__('Add Expense', 'gym_mgt'); ?></a>



										</li>



										<?php



									}



								}



								?>



							</ul><!-- NAV TAB WRAPPER MENU END-->



							<?php 		



						}				



						if($active_tab == 'paymentlist')



						{



							?>



							<script type="text/javascript">



							$(document).ready(function() 



							{



								"use strict";



								jQuery('#payment_list').DataTable(



								{



									// "responsive": true,



									"order": [[ 0, "asc" ]],



									dom: 'lifrtp',



									"aoColumns":[



												  {"bSortable": true},



												  {"bSortable": true},



												  {"bSortable": true},



												  {"bSortable": true},



												  {"bSortable": true},



												  {"bSortable": false}],



										language:<?php echo MJ_gmgt_datatable_multi_language();?>			  



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



							});



							</script>



							<form name="wcwm_report" action="" method="post"><!--PAYMENT LIST FORM START-->	



								<div class="panel-body"><!--PANEL BODY DIV START-->	



									<div class="table-responsive"><!--TABLE RESPONSIVE DIV START-->	



										<table id="payment_list" class="display" cellspacing="0" width="100%"><!--PAYMENT LIST TABLE START-->	



											<tbody>



											 <?php 



												$paymentdata=$obj_payment->MJ_gmgt_get_all_payment();



												if(!empty($paymentdata))



												{



													foreach ($paymentdata as $retrieved_data)



													{



														?>



														<tr>



															<td class="productname"><a href="?page=gmgt_payment&tab=addpayment&action=edit&payment_id=<?php echo esc_attr($retrieved_data->payment_id);?>"><?php echo esc_html($retrieved_data->title);?></a></td>



															<td class="paymentby"><?php $user=get_userdata($retrieved_data->member_id); $display_label = MJ_gmgt_get_member_full_display_name_with_memberid(esc_html($retrieved_data->member_id)); echo esc_html($display_label); ?></td>



															<td class="totalamount"><?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?> <?php echo esc_html($retrieved_data->total_amount);?></td>



															<td class="paymentdate"><?php echo MJ_gmgt_getdate_in_input_box(esc_html($retrieved_data->payment_date));?></td>



															<td class="action">



																<a  href="#" class="show-invoice-popup btn btn-default" idtest="<?php echo esc_attr($retrieved_data->payment_id); ?>" invoice_type="invoice"><i class="fa fa-eye"></i> <?php esc_html_e('View Invoice', 'gym_mgt');?></a>



																<?php if($user_access_edit == '1')



                                                                {?>	



																<a href="?page=gmgt_payment&tab=addpayment&action=edit&payment_id=<?php echo esc_attr($retrieved_data->payment_id)?>" class="btn btn-info"> <?php esc_html_e('Edit', 'gym_mgt' ) ;?></a>



																<?php



                                                                }																



																if($user_access_delete =='1')



																{ ?>



																<a href="?page=gmgt_payment&tab=paymentlist&action=delete&payment_id=<?php echo esc_attr($retrieved_data->payment_id);?>" class="btn btn-danger" onclick="return confirm('<?php esc_html_e('Are you sure you want to delete this record?','gym_mgt');?>');"><?php esc_html_e( 'Delete', 'gym_mgt' ) ;?> </a>



																<?php 



																} ?>



															</td>



														</tr>



														<?php 



													} 													



												}



												?>										 



											</tbody>										



										</table><!--PAYMENT LIST TABLE END-->



									</div><!--TABLE RESPONSIVE DIV END-->



								</div><!--PANEL BODY DIV END-->



							</form><!--PAYMENT LIST FORM END-->



							<?php 



						}



						if($active_tab == 'addpayment')



						{



							require_once GMS_PLUGIN_DIR. '/admin/payment/add_payment.php';



						}



						if($active_tab == 'incomelist')



						{



							require_once GMS_PLUGIN_DIR. '/admin/payment/income-list.php';



						}



						if($active_tab == 'addincome')



						{



							require_once GMS_PLUGIN_DIR. '/admin/payment/add_income.php';



						}



						if($active_tab == 'expenselist')



						{



							require_once GMS_PLUGIN_DIR. '/admin/payment/expense-list.php';



						}



						if($active_tab == 'addexpense')



						{



							require_once GMS_PLUGIN_DIR. '/admin/payment/add_expense.php';



						}



						if($active_tab == 'view_invoice')



						{



							require_once GMS_PLUGIN_DIR. '/admin/payment/view_invoice.php';



						}



						?>



					</div><!--PANEL BODY DIV END-->	



				</div><!--PANEL WHITE DIV END-->	



		    </div><!--COL 12 DIV END-->	



		</div><!--ROW DIV END-->	



	</div><!--MAIN WRAPPER DIV END-->	



</div><!--PAGE INNER DIV END-->	