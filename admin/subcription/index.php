<?php 

$obj_membership_payment=new MJ_gmgt_membership_payment;

$active_tab = isset($_GET['tab'])?$_GET['tab']:'subscription_list';

$result=0;

?>

<!-- POP up code -->

<div class="popup-bg">

    <div class="overlay-content">

		<div class="modal-content">

			<div class="invoice_data"></div>

		</div>

    </div> 

</div>

<!-- End POP-UP Code -->

<div class="page-inner min_height_1631"><!--PAGE INNER DIV STRAT-->

    <div class="page-title">

		<h3><img src="<?php echo esc_url(get_option( 'gmgt_system_logo', 'gym_mgt')); ?>" class="img-circle head_logo" width="40" height="40" /><?php echo esc_html(get_option('gmgt_system_name','gym_mgt'));?></h3>

	</div>

	<?php 

	//ADD FEES PAYMENT DATA

	if(isset($_POST['add_fee_payment']))

	{

		//POP up data save in payment history

		$result=$obj_membership_payment->MJ_gmgt_add_feespayment_history($_POST);			

		if($result)

		{

			wp_redirect (admin_url().'admin.php?page=MJ_gmgt_fees_payment&tab=subscription_list&message=4');

		}

	}

	//SAVE MEMBERSHIP PAYMENT DATA

	if(isset($_POST['save_membership_payment']))

	{

		$nonce = $_POST['_wpnonce'];

		if (wp_verify_nonce( $nonce, 'save_membership_payment_nonce' ) )

		{

			if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit')

			{

				$result=$obj_membership_payment->MJ_gmgt_add_membership_payment($_POST);

				if($result)

				{

					wp_redirect ( admin_url().'admin.php?page=MJ_gmgt_fees_payment&tab=subscription_list&message=2');

				}	

			}

			else

			{

				$result=$obj_membership_payment->MJ_gmgt_add_membership_payment($_POST);	

				if($result)

				{

					$user_info=get_userdata($_POST['member_id']);

					$to = $user_info->user_email;           

					$subject = get_option('subscription_template_title'); 

					$search=array('[GMGT_MEMBERNAME]','[GMGT_MEMBERID]','[GMGT_STARTDATE]','[GMGT_ENDDATE]','[GMGT_MEMBERSHIP]','[GMGT_MEMBERSHIP_AMOUNT]');

					$membership_name=MJ_gmgt_get_membership_name($_POST['membership_id']);

					$replace = array(MJ_gmgt_get_user_full_display_name($_POST['member_id']),$user_info->member_id,$_POST['start_date'],$_POST['end_date'],$membership_name,$_POST['membership_amount']);

					$message = str_replace($search, $replace,get_option('subcription_mailcontent'));	

					$test=wp_mail($to, $subject, $message);

					wp_redirect ( admin_url().'admin.php?page=MJ_gmgt_fees_payment&tab=subscription_list&message=1');

				}

			}

		}

	}

	//DELETE PAYMENT DATA

	if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')

	{

		if(isset($_REQUEST['mp_id']))

		{

			$result=$obj_membership_payment->MJ_gmgt_delete_payment($_REQUEST['mp_id']);

			if($result)

			{

				wp_redirect ( admin_url().'admin.php?page=MJ_gmgt_fees_payment&tab=subscription_list&message=3');

			}

		}

	}

	//Delete Selected PAYMENT DATA

	if(isset($_REQUEST['delete_selected']))

    {		

		if(!empty($_REQUEST['selected_id']))

		{

			foreach($_REQUEST['selected_id'] as $id)

			{

				$delete_membership_payment=$obj_membership_payment->MJ_gmgt_delete_payment($id);

			}

			if($delete_membership_payment)

			{

				wp_redirect ( admin_url().'admin.php?page=MJ_gmgt_fees_payment&tab=subscription_list&message=3');

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

	if(isset($_REQUEST['action']) && $_REQUEST['action']=='reminder' && isset($_REQUEST['mp_id']))

	{

		$paymentdata=$obj_membership_payment->MJ_gmgt_get_membership_payments_by_mpid($_REQUEST['mp_id']);

		if(!empty($paymentdata))

		{

			$due_amount=$paymentdata->membership_amount - $paymentdata->paid_amount;

			$user=get_userdata($paymentdata->member_id);

			$subject	= 	get_option('payment_reminder_subject'); 

			$Seach['{{GMGT_RECEIVER_NAME}}']	     =	 MJ_gmgt_get_user_full_display_name($paymentdata->member_id);

			$Seach['{{GMGT_INVOICE_NUMBER}}']		 =	 $paymentdata->invoice_no;

			$Seach['{{GMGT_TOTOAL_AMOUNT}}']	 	 =	 $paymentdata->membership_amount;

			$Seach['{{GMGT_DUE_AMOUNT}}']		     =	 $due_amount;

			$Seach['{{GMGT_MEMBERSHIP_NAME}}']		 =	 MJ_gmgt_get_membership_name($paymentdata->membership_id);

			$Seach['{{GMGT_GYM_NAME}}']	     =	 get_option( 'gmgt_system_logo' );			

			$MsgContent = MJ_gmgt_string_replacemnet($Seach,get_option('payment_reminder_template'));

			$to[]= $user->user_email;

			$send=MJ_gmgt_send_mail($to,$subject,$MsgContent);	

			if($send)

			{

				wp_redirect ( admin_url() . 'admin.php?page=MJ_gmgt_fees_payment&tab=paymentlist&message=5');

			}

			else {

				wp_redirect ( admin_url() . 'admin.php?page=MJ_gmgt_fees_payment&tab=paymentlist');

			}	

		}

		else {

			wp_redirect ( admin_url() . 'admin.php?page=MJ_gmgt_fees_payment&tab=paymentlist');

		}	

	}



	if(isset($_REQUEST['message']))

	{

		$message =$_REQUEST['message'];

		if($message == 1)

		{?>

			<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">

				<p><?php esc_html_e('Membership Payment Invoice added successfully.','gym_mgt');?></p>

				<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>

			</div>

		<?php 

		}

		elseif($message == 2)

		{?>

			<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">

				<p><?php esc_html_e("Membership Payment Invoice updated successfully.",'gym_mgt');?></p>

				<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>

			</div>

		<?php 

		}

		elseif($message == 3) 

		{?>

			<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">

				<p><?php esc_html_e('Membership Payment Invoice deleted  successfully.','gym_mgt');?></p>

				<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>

			</div>

		<?php

		}

		elseif($message == 4) 

		{?>

			<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">

				<p><?php esc_html_e('Payment Successful','gym_mgt');?></p>

				<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>

			</div>

		<?php

		}

		elseif($message == 5) 

		{?>

			<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">

				<p><?php esc_html_e('Payment reminder sent successfully','gym_mgt');?></p>

				<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>

			</div>

		<?php

		}

	}

	?>

	<div id="main-wrapper"><!--MAIN WRAPPER DIV STRAT-->

		<div class="row"><!--ROW DIV STRAT-->

			<div class="col-md-12"><!--COL 12 DIV STRAT-->

				<div class="panel panel-white"><!--PANEL WHITE DIV STRAT-->

					<div class="panel-body"><!--PANEL BODY DIV STRAT-->

						<h2 class="nav-tab-wrapper"><!--NAV TAB WRAPPER MENU STRAT-->

							<a href="?page=MJ_gmgt_subscription&tab=subscription_list" class="nav-tab payement_list_res <?php echo $active_tab == 'subscription_list' ? 'nav-tab-active' : ''; ?>"><?php echo '<span class="dashicons dashicons-menu"></span> '.esc_html__('Subscription List','gym_mgt'); ?>

							</a>

						</h2><!--NAV TAB WRAPPER MENU END-->

						<?php 						

						if($active_tab == 'subscription_list')

						{ 

						?>	

							<script type="text/javascript">

								$(document).ready(function()

								{

									"use strict";

									jQuery('#payment_list').DataTable({

										// "responsive": true,

										"order": [[ 1, "asc" ]],

										dom: 'Bfrtip',

										buttons: [

											'colvis',

											{

										extend: '<?php esc_html_e( 'print', 'gym_mgt' ) ;?>',

										title: '<?php esc_html_e( 'Subscription List', 'gym_mgt' ) ;?>',

									/* 	exportOptions: {

												columns: [ 0, 1, 2,3, 4 ,5,6,7,8,9]

											}, */

										},

										'pdfHtml5'										

										],

										"aoColumns":[

													  {"bSortable": false},

													  {"bSortable": true},

													  {"bSortable": true},

													  {"bSortable": true},

													  {"bSortable": true},

													  {"bSortable": true},

													  {"bSortable": true},

													  {"bSortable": false}],

											language:<?php echo MJ_gmgt_datatable_multi_language();?>

										});

										/* $('.select_all').on('click', function(e)

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

									  	}); */

										 /*  $(".delete_selected").on('click', function()

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

											}); */

								});

							</script>

							<form name="wcwm_report" action="" method="post"><!--PAYMENT LIST FORM START-->

								<div class="panel-body"><!--PANEL BODY DIV START-->

									<div class="table-responsive"><!--TABLE RESPONSIVE DIV START-->

										<table id="payment_list" class="display" cellspacing="0" width="100%"><!--PAYMENT LIST TABLE START-->

											<thead>

												<tr>

													<!-- <th><input type="checkbox" class="select_all"></th> -->

													<th><?php esc_html_e('Subcription ID','gym_mgt');?></th>

													<th><?php esc_html_e('Member Name','gym_mgt');?></th>

													<th><?php esc_html_e('Membership Name','gym_mgt');?></th>

													<th><?php esc_html_e('Amount','gym_mgt');?></th>

													<th><?php esc_html_e('Subcription start date','gym_mgt');?></th>

													<th><?php esc_html_e('Subcription end date','gym_mgt');?></th>

													<th><?php esc_html_e('Subcription Status','gym_mgt');?></th>

													<th><?php esc_html_e('Payment Status','gym_mgt');?></th>

													<!-- <th><?php esc_html_e('Action','gym_mgt');?></th> -->

												</tr>

											</thead>

											<tfoot>

												<tr>

												<!-- 	<th></th> -->

													<th><?php esc_html_e('Subcription ID','gym_mgt');?></th>

													<th><?php esc_html_e('Member Name','gym_mgt');?></th>

													<th><?php esc_html_e('Membership Name','gym_mgt');?></th>

													<th><?php esc_html_e('Amount','gym_mgt');?></th>

													<th><?php esc_html_e('Subcription start date','gym_mgt');?></th>

													<th><?php esc_html_e('Subcription end date','gym_mgt');?></th>

													<th><?php esc_html_e('Subcription Status','gym_mgt');?></th>

													<th><?php esc_html_e('Payment Status','gym_mgt');?></th>

													<!-- <th><?php esc_html_e('Action','gym_mgt');?></th> -->

												</tr>

											</tfoot>

											<tbody>

											<?php 

											$subscription_data=$obj_membership_payment->MJ_gmgt_get_all_subscription();

											if(!empty($subscription_data))

											{

												foreach ($subscription_data as $retrieved_data)

												{

													?>

												<tr>

													<td class="productname">

													<?php

													echo esc_html($retrieved_data->stripe_subscription_id);

													?> 

													</td>

													<td class="paymentby"><?php 

													$user=get_userdata($retrieved_data->member_id);

													$memberid=get_user_meta($retrieved_data->member_id,'member_id',true); 

													if(!empty($user->display_name))

													{

														$display_label=MJ_gmgt_get_user_full_display_name($retrieved_data->member_id); 

													}

													else

													{

														$display_label="-";

													}

													if($memberid)

													{

														$display_label.=" (".$memberid.")";

													}

													echo esc_html($display_label); 

													?>

													</td>

													<td class="productname"><?php echo MJ_gmgt_get_membership_name(esc_html($retrieved_data->membership_id));?>

													</td>

													<td class="totalamount"><?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?> <?php echo esc_html($retrieved_data->plan_amount);?>

													</td>

													<td class="paymentdate"><?php echo MJ_gmgt_getdate_in_input_box(esc_html($retrieved_data->plan_period_start));?>

													</td>

													<td class="paymentdate"><?php echo MJ_gmgt_getdate_in_input_box(esc_html($retrieved_data->plan_period_end));?>

													</td>

													<td class="productname"><?php echo esc_html($retrieved_data->subscription_status);?>

													<td class="paymentdate"><?php echo "<span class='btn btn-success btn-xs'>";echo esc_html__(MJ_gmgt_get_membership_paymentstatus($retrieved_data->mp_id), 'gym_mgt' );echo "</span>"; ?>

													</td>

												</tr>

												<?php 

												}

											}?>

											</tbody>

										</table><!--PAYMENT LIST TABLE END-->

							

									</div><!--TABLE RESPONSIVE DIV END-->

								</div><!--PANEL BODY END-->

							</form><!--PAYMENT LIST FORM END-->

						<?php 

					    }

					?>

                    </div><!--PANEL BODY DIV END-->

	            </div><!--PANEL WHITE DIV END-->

	        </div><!--COL 12 DIV END-->

        </div><!--ROW DIV END-->

    </div><!--MAIN WRAPPER DIV END-->

</div><!--PAGE INNNER DIV END-->