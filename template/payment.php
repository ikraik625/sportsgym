<?php $curr_user_id=get_current_user_id();



$obj_class=new MJ_gmgt_classschedule;



$obj_gym=new MJ_gmgt_Gym_management($curr_user_id);



$obj_payment=new MJ_gmgt_payment;



global $wpdb;



$active_tab = isset($_GET['tab'])?$_GET['tab']:'incomelist';



//access right

$fees_detail_result = '';

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



if(isset($_REQUEST['action'])&& $_REQUEST['action']=='success')



{ 



	?>



	<div id="message" class="alert_msg alert alert-success alert-dismissible " role="alert">



		<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span>



		</button>



		<?php esc_html_e('Payment successfully.','gym_mgt');?>



	</div>



	<?php



}	



if(isset($_REQUEST['action'])&& $_REQUEST['action']=='cancel')	



{ 



	?>



	<div id="message" class="alert_msg alert alert-success alert-dismissible " role="alert">



		<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span>



		</button>



		<?php esc_html_e('Payment Cancel.','gym_mgt');?>



	</div>



	<?php



}	

if(isset($_POST['payer_status']) && $_POST['payer_status'] == 'VERIFIED' && (isset($_POST['payment_status'])) && $_POST['payment_status']=='Completed' && isset($_REQUEST['half']) && $_REQUEST['half']=='yes' )



{	



	$trasaction_id  = sanitize_text_field($_POST["txn_id"]);



	$incomedata['member_id']=get_current_user_id();



	$custom_array = explode("_",sanitize_text_field($_POST['custom']));



	$incomedata['income_id']=$custom_array[1];



	$incomedata['amount']=sanitize_text_field($_POST['mc_gross_1']);



	$incomedata['trasaction_id']=$trasaction_id ;



	$incomedata['payment_method']='paypal';



	$incomedata['created_by']=get_current_user_id();



	$result = $obj_payment->MJ_gmgt_add_income_payment_history($incomedata);



	if($result)



	{



	  wp_redirect ( home_url() . '?dashboard=user&page=payment&tab=incomelist&action=success');



	}



}



if(isset($_REQUEST['amount'])   && (isset($_REQUEST['pay_id'])) && isset($_REQUEST['payment_request_id']) )



{



    $trasaction_id  = esc_attr($_REQUEST['payment_request_id']);



	$incomedata['member_id']=get_current_user_id();



	$incomedata['income_id']=esc_attr($_REQUEST['pay_id']);



	$incomedata['amount']=esc_attr($_REQUEST['amount']);



	$incomedata['trasaction_id']=$trasaction_id ;



	$incomedata['payment_method']='Instamojo';



	$incomedata['created_by']=get_current_user_id();



	$result = $obj_payment->MJ_gmgt_add_income_payment_history($incomedata);



	if($result)



	{



	  	wp_redirect ( home_url() . '?dashboard=user&page=payment&tab=incomelist&action=success');



	}



}



if(isset($_REQUEST['skrill_mp_id']) && (isset($_REQUEST['amount'])))



{



	$incomedata['member_id']=get_current_user_id();



	$incomedata['income_id']=$_REQUEST['skrill_mp_id'];



	$incomedata['amount']=esc_attr($_REQUEST['amount']);



	$incomedata['trasaction_id']='';



	$incomedata['payment_method']='Skrill';



	$incomedata['created_by']=get_current_user_id();



	



	$result = $obj_payment->MJ_gmgt_add_income_payment_history($incomedata);



	if($result)



	{



	  	wp_redirect ( home_url() . '?dashboard=user&page=payment&tab=incomelist&action=success');



	}



}



if(isset($_REQUEST['action']) && $_REQUEST['action']=="ideal_payments" && $_REQUEST['page']=="payment" && isset($_REQUEST['ideal_pay_id']) && isset($_REQUEST['ideal_amt']))



{



	$incomedata['member_id']=get_current_user_id();



	$incomedata['income_id']=esc_attr($_REQUEST['ideal_pay_id']);



	$incomedata['amount']=esc_attr($_REQUEST['ideal_amt']);



	$incomedata['trasaction_id']='';



	$incomedata['payment_method']='PayUMoney';



	$incomedata['created_by']=get_current_user_id();



	$result = $obj_payment->MJ_gmgt_add_income_payment_history($incomedata);



	if($result)



	{



	  wp_redirect ( home_url() . '?dashboard=user&page=payment&tab=incomelist&action=success');



	}	



}



//------------PAYSTACK SUCCESS ----------------------//



$reference='';



$reference = isset($_GET['reference']) ? $_GET['reference'] : '';



if($reference)



{



      $paystack_secret_key=get_option('paystack_secret_key');



	  $curl = curl_init();



	  curl_setopt_array($curl, array(



	  CURLOPT_URL => "https://api.paystack.co/transaction/verify/" . rawurlencode($reference),



	  CURLOPT_RETURNTRANSFER => true,



	  CURLOPT_HTTPHEADER => [



		"accept: application/json",



		"authorization: Bearer $paystack_secret_key",



		"cache-control: no-cache"



	  ],



	));



	$response = curl_exec($curl);



	$err = curl_error($curl);



	if($err)



	{



		// there was an error contacting the Paystack API



	  	die('Curl returned error: ' . $err);



	}



	$tranx = json_decode($response);



	if(!$tranx->status)



	{



	  	// there was an error from the API



	  	die('API returned error: ' . $tranx->message);



	}



	if('success' == $tranx->data->status)



	{



		$trasaction_id  = $tranx->data->reference;



		$incomedata['member_id']=get_current_user_id();



		$incomedata['income_id']=$tranx->data->metadata->custom_fields->fees_pay_id;



		$incomedata['amount']=$tranx->data->amount / 100;



		$incomedata['trasaction_id']=$trasaction_id;



		$incomedata['payment_method']='Paystack';



		$incomedata['created_by']=get_current_user_id();



		$result = $obj_payment->MJ_gmgt_add_income_payment_history($incomedata);



		if($result)



		{



		  	wp_redirect ( home_url() . '?dashboard=user&page=payment&tab=incomelist&action=success');



		}	



	}



}

//ADD FEES PAYMENT DATA



if(isset($_POST['add_fee_payment']))



{



	//POP up data save in payment history//



	if($_POST['payment_method'] == 'Paypal')



	{



		require_once GMS_PLUGIN_DIR. '/lib/paypal/paypal_process.php';				



	}



	elseif($_POST['payment_method'] == 'stripe_gym')



	{				



		require_once GMS_PLUGIN_DIR. '/lib/stripe/index.php';				



	}



	elseif($_POST['payment_method'] == 'Stripe')



	{



		require_once PM_PLUGIN_DIR. '/lib/stripe/index.php';			



	}



	elseif($_POST['payment_method'] == 'Skrill')



	{			



		require_once PM_PLUGIN_DIR. '/lib/skrill/skrill.php';



	}



	elseif($_POST['payment_method'] == 'Instamojo')



	{			



		require_once PM_PLUGIN_DIR. '/lib/instamojo/instamojo.php';



	}



	elseif($_POST['payment_method'] == 'PayUMony')



	{



		require_once PM_PLUGIN_DIR. '/lib/OpenPayU/index.php';			



	}



	elseif($_REQUEST['payment_method'] == '2CheckOut')



	{				



		require_once PM_PLUGIN_DIR. '/lib/2checkout/index.php';



	}



	elseif($_POST['payment_method'] == 'iDeal')



	{		



		require_once PM_PLUGIN_DIR. '/lib/ideal/ideal.php';



	}



	elseif($_POST['payment_method'] == 'Paystack')



	{



		require_once PM_PLUGIN_DIR. '/lib/paystack/paystack.php';



	}



	elseif($_POST['payment_method'] == 'paytm')



	{



		require_once PM_PLUGIN_DIR. '/lib/PaytmKit/index.php';



	}



	elseif($_POST['payment_method'] == 'razorpay')



	{



		require_once PM_PLUGIN_DIR. '/lib/razorpay/index.php';



	}



	else



	{

	

		$result=$obj_payment->MJ_gmgt_add_income_payment($_POST);



			



		wp_redirect ( home_url() . '?dashboard=user&page=payment&tab=incomelist&action=success');



	}



}



//SAVE PAYMENT DATA



if(isset($_POST['save_product']))



{



	if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit')



	{



		$result=$obj_payment->MJ_gmgt_add_payment($_POST);



		if($result)



		{



			wp_redirect ( home_url() . '?dashboard=user&page=payment&tab=paymentlist&message=2');



		}			



	}



	else



	{



		$result=$obj_payment->MJ_gmgt_add_payment($_POST);



		if($result)



		{



			wp_redirect ( home_url() . '?dashboard=user&page=payment&tab=paymentlist&message=1');



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



			wp_redirect ( home_url() . '?dashboard=user&page=payment&tab=paymentlist&message=3');



		}



	}



	if(isset($_REQUEST['income_id']))



	{



		$result=$obj_payment->MJ_gmgt_delete_income($_REQUEST['income_id']);



		if($result)



		{



			wp_redirect ( home_url() . '?dashboard=user&page=payment&tab=incomelist&message=3');



		}



	}



	if(isset($_REQUEST['expense_id']))



	{



		$result=$obj_payment->MJ_gmgt_delete_expense($_REQUEST['expense_id']);



		if($result)



		{



			wp_redirect ( home_url() . '?dashboard=user&page=payment&tab=expenselist&message=6');



		}



	}



}



//--------save income DATA-------------



if(isset($_POST['save_income']))



{		



	if($_REQUEST['action']=='edit')



	{	



		$result=$obj_payment->MJ_gmgt_add_income($_POST);



		if($result)



		{



			wp_redirect (  home_url() . '?dashboard=user&page=payment&tab=incomelist&message=2');



		}



	}



	else



	{



		$result=$obj_payment->MJ_gmgt_add_income($_POST);



		if($result)



		{



			wp_redirect (  home_url() . '?dashboard=user&page=payment&tab=incomelist&message=1');



		}



	}



}		



//--------save Expense DATA-------------



if(isset($_POST['save_expense']))



{



	if($_REQUEST['action']=='edit')



	{



		$result=$obj_payment->MJ_gmgt_add_expense($_POST);



		if($result)



		{



			wp_redirect (  home_url() . '?dashboard=user&page=payment&tab=expenselist&message=5');



		}



	}



	else



	{



		$result=$obj_payment->MJ_gmgt_add_expense($_POST);



		if($result)



		{



			wp_redirect (  home_url() . '?dashboard=user&page=payment&tab=expenselist&message=4');



		}



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



			<?php esc_html_e('Invoice added successfully.','gym_mgt');?>



		</div>



		<?php 	



	}



	elseif($message == 2)



	{



		?>



		<div id="message" class="alert_msg alert alert-success alert-dismissible " role="alert">



			<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span>



			</button>



			<?php esc_html_e('Invoice updated successfully.','gym_mgt');?>



		</div>



		<?php 



	}



	elseif($message == 3) 



	{



		?>



		<div id="message" class="alert_msg alert alert-success alert-dismissible " role="alert">



			<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span>



			</button>



			<?php esc_html_e('Invoice deleted successfully.','gym_mgt');?>



		</div>



		<?php		



	}



	if($message == 4)



	{



		?>



		<div id="message" class="alert_msg alert alert-success alert-dismissible " role="alert">



			<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span>



			</button>



			<?php esc_html_e('Expense added successfully.','gym_mgt');?>



		</div>



		<?php



	}



	elseif($message == 5)



	{



		?>



		<div id="message" class="alert_msg alert alert-success alert-dismissible " role="alert">



			<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span>



			</button>



			<?php esc_html_e('Expense updated successfully.','gym_mgt');?>



		</div>



		<?php 



	}



	elseif($message == 6) 



	{



		?>



		<div id="message" class="alert_msg alert alert-success alert-dismissible " role="alert">



			<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span>



			</button>



			<?php esc_html_e('Expense deleted successfully.','gym_mgt');?>



		</div>



		<?php



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



<script type="text/javascript">



	$(document).ready(function() 



	{



		"use strict";



		$('.tax_charge').multiselect(



		{



			nonSelectedText :'<?php esc_html_e('Select Tax','gym_mgt');?>',



			includeSelectAllOption: true,



			allSelectedText :'<?php esc_html_e('All Selected','gym_mgt'); ?>',



			selectAllText : '<?php esc_html_e('Select all','gym_mgt'); ?>',



			templates: {



					button: '<button class="multiselect btn btn-default dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><span class="multiselect-selected-text"></span><b class="caret"></b></button>',



				},



			buttonContainer: '<div class="dropdown" />'



		});



		



		var date = new Date();



		$.datepicker.setDefaults($.datepicker.regional['<?php echo MJ_gmgt_get_current_lan_code(); ?>']);



		date.setDate(date.getDate()-0);



		$('.date_field').datepicker({



		dateFormat:'<?php  echo get_option('gmgt_datepicker_format'); ?>',



		<?php



		if(get_option('gym_enable_datepicker_privious_date')=='no')



		{



		?>



			minDate:'today',



			startDate: date,



		<?php



		}



		?>	



		autoclose: true



	}); 



		jQuery('#members_list').DataTable({



			// "responsive": true,



			"order": [[ 1, "asc" ]],



			dom: 'lifrtp',



			"aoColumns":[



						{"bSortable": false},



						{"bSortable": false},



						{"bSortable": true},



						{"bSortable": true},



						{"bSortable": true},



						{"bSortable": true}],



					language:<?php echo MJ_gmgt_datatable_multi_language();?>		  



			});



			$('.dataTables_filter input').attr("placeholder", "<?php esc_html_e('Search...', 'gym_mgt') ?>");



			$('#member_form').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});	



			$(".display-members").select2();



	} );



</script>



<div class="panel-body panel-white padding_0 gms_main_list"><!--PANEL WHITE DIV START-->



	<?php



	if($active_tab != "view_invoice")



	{



		?>



		<ul class="nav nav-tabs panel_tabs margin_left_1per mb-3" role="tablist"><!-- NAV TAB WRAPPER MENU START-->



			<li class="<?php if($active_tab=='incomelist'){?>active<?php }?>">



				<a href="?dashboard=user&page=payment&tab=incomelist" class="padding_left_0 tab <?php echo $active_tab == 'incomelist' ? 'nav-tab-active' : ''; ?>">



				<?php echo esc_html__('Invoice List', 'gym_mgt'); ?></a>



			</li>



			<?php



			if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit' && isset($_REQUEST['income_id']))



			{



				?>



				<li class="<?php if($active_tab=='addincome'){?>active<?php }?>">



					<a href="?dashboard=user&page=payment&tab=addincome&action=edit&income_id=<?php echo esc_attr($_REQUEST['income_id']);?>" class="padding_left_0 tab <?php echo $active_tab == 'addincome' ? 'nav-tab-active' : ''; ?>">



					<?php echo esc_html__('Edit Invoice', 'gym_mgt'); ?></a>



				</li>



				<?php



			}



			else



			{



				if($user_access['add']=='1' && $active_tab=='addincome')



				{



					?>



					<li class="<?php if($active_tab=='addincome'){?>active<?php }?>">



						<a href="?dashboard=user&page=payment&tab=addincome&&action=insert" class="padding_left_0 tab <?php echo $active_tab == 'addincome' ? 'nav-tab-active' : ''; ?>">



						<?php echo esc_html__('Add Invoice', 'gym_mgt'); ?></a>



					</li>



					<?php



				}



			}



			if($obj_gym->role=='staff_member' || $obj_gym->role=='accountant')



			{



				?>



				<li class="<?php if($active_tab=='expenselist'){?>active<?php }?>">



					<a href="?dashboard=user&page=payment&tab=expenselist" class="padding_left_0 tab <?php echo $active_tab == 'expenselist' ? 'nav-tab-active' : ''; ?>">



					<?php echo esc_html__('Expense List', 'gym_mgt'); ?></a>



				</li>



				<?php



				if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit' && isset($_REQUEST['expense_id']))



				{



					?>



					<li class="<?php if($active_tab=='addexpense'){?>active<?php }?>">



						<a href="?dashboard=user&page=payment&tab=addexpense&action=edit&expense_id=<?php echo esc_attr($_REQUEST['expense_id']);?>" class="padding_left_0 tab <?php echo $active_tab == 'addexpense' ? 'nav-tab-active' : ''; ?>">



						<?php echo esc_html__('Edit Expense', 'gym_mgt'); ?></a>



					</li>



					<?php



				}



				else



				{



					if($user_access['add']=='1' && $active_tab=='addexpense')



					{



						?>



						<li class="<?php if($active_tab=='addexpense'){?>active<?php }?>">



							<a href="?dashboard=user&page=payment&tab=addincome&&action=insert" class="padding_left_0 tab <?php echo $active_tab == 'addexpense' ? 'nav-tab-active' : ''; ?>">



							<?php echo esc_html__('Add Expense', 'gym_mgt'); ?></a>



						</li>



						<?php



					}



				}



			}



			?>



		</ul><!-- NAV TAB WRAPPER MENU END-->



		<?php 		



	}	



	?>



	<div class="tab-content padding_0"><!--TAB CONTENT DIV START-->



		<?php  	



		if($active_tab == 'incomelist')



		{



			?>



			<!--Income information-->



			<script type="text/javascript">



				$(document).ready(function() 



				{



					"use strict";



					jQuery('#tblincome').DataTable({



						// "responsive": true,



						"order": [[ 2, "asc" ]],



						dom: 'lifrtp',



						"aoColumns":[



									{"bSortable": true},



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



						$('.dataTables_filter input').attr("placeholder", "<?php esc_html_e('Search...', 'gym_mgt') ?>");



				} );



			</script>



			<?php



			if($obj_gym->role == 'member')



			{



				if($user_access['own_data']=='1')



				{



					$paymentdata=$obj_payment->MJ_gmgt_get_all_income_data_by_member();



				}



				else



				{



					$paymentdata=$obj_payment->MJ_gmgt_get_all_income_data();



				}							



			}



			else



			{



				if($user_access['own_data']=='1')



				{



					$user_id=get_current_user_id();



					$paymentdata=$obj_payment->MJ_gmgt_get_all_income_data_by_created_by($user_id);



				}



				else



				{



					$paymentdata=$obj_payment->MJ_gmgt_get_all_income_data();



				}							



			}	



			if(!empty($paymentdata))



			{



				?>



				<div class="panel-body padding_0"><!--PANEL BODY DIV START-->



					<div class="table-responsive"><!--TABLE RESPONSIVE DIV START-->



						<table id="tblincome" class="display" cellspacing="0" width="100%"><!--TABLE INCOME LIST START-->

							<thead class="<?php echo MJ_gmgt_datatable_heder(); ?>">

								<tr>

								<th><?php  esc_html_e( 'Photo', 'gym_mgt' ) ;?></th>

									<th><?php esc_html_e('Member Name','gym_mgt');?></th>

									<th ><?php esc_html_e('Income Name', 'gym_mgt');?></th>

									<th><?php esc_html_e('Invoice No.','gym_mgt');?></th>

									<th><?php esc_html_e('Total Amount','gym_mgt');?></th>

									<th ><?php esc_html_e('Paid Amount','gym_mgt');?></th>

									<th ><?php esc_html_e('Due Amount','gym_mgt');?></th>

									<th><?php esc_html_e('Payment Date','gym_mgt');?></th>

									<th><?php esc_html_e('Payment Status','gym_mgt');?></th>

									<th class="text_align_end"><?php esc_html_e('Action','gym_mgt');?></th>

								</tr>

							</thead>

							<tbody>



								<?php 



							



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



										<td class="user_image width_50px profile_image_prescription padding_left_0">	



											<p class="prescription_tag padding_15px margin_bottom_0px <?php echo $color_class; ?>">	



												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/Payment.png"?>" alt="" class="massage_image center image_icon_height_25px margin_top_3px">



											</p>



										</td>



										<td class="member_name"><?php $user=get_userdata($retrieved_data->supplier_name);



											$memberid=get_user_meta($retrieved_data->supplier_name,'member_id',true);



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



										<td class="income_amount">



											<?php esc_html_e($retrieved_data->invoice_label, 'gym_mgt'); ?> 



											<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Income Name','gym_mgt');?>" >



										</td>



										<td class="income_amount"><?php echo esc_html($invoice_no);	?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Invoice No.','gym_mgt');?>" ></td>



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



										if($obj_gym->role == 'member')



										{ 



											if (($retrieved_data->total_amount > '0' ) && ($retrieved_data->payment_status == 'Unpaid' || $retrieved_data->payment_status == 'Partially Paid' || $retrieved_data->payment_status == 'Part Paid' || $retrieved_data->payment_status == 'Not Paid'))



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



																		<a href="?dashboard=user&page=payment&tab=view_invoice&idtest=<?php echo $retrieved_data->invoice_id; ?>&invoice_type=income" class="float_left_width_100" 



																		><i class="fa fa-eye" aria-hidden="true"></i> <?php esc_html_e('View Invoice', 'gym_mgt' ) ;?></a>



																	</li>



																	<li class="float_left_width_100">



																		<a href="#" name="fees_reminder" class="show-payment-popup float_left_width_100" idtest="<?php echo esc_attr($retrieved_data->invoice_id); ?>" member_id="<?php echo esc_attr($retrieved_data->supplier_name); ?>"  view_type="income" due_amount="<?php echo str_replace(",","",number_format($due_amount,2)); ?>" view_type="income_payment"  ><i class="fa fa-credit-card" aria-hidden="true"></i> <?php esc_html_e('Pay', 'gym_mgt' ) ;?></a>



																	</li>



																	



																	<?php 



																	if($user_access['edit']=='1')



																	{



																		if(!empty($retrieved_data->invoice_no))



																		{



																			if(!($retrieved_data->invoice_label=='Fees Payment' || $retrieved_data->invoice_label=='Sell Product'))



																			{



																				?>



																				<li class="float_left_width_100 border_bottom_item">



																					<a href="?dashboard=user&page=payment&tab=addincome&action=edit&income_id=<?php echo esc_attr($retrieved_data->invoice_id)?>" class="float_left_width_100"><i class="fa fa-edit"></i> <?php esc_html_e('Edit', 'gym_mgt' ) ;?>



																					</a>



																				</li>



																				<?php 



																			}



																		}



																	}



																	if($user_access['delete']=='1')



																	{ 



																		?>



																		<li class="float_left_width_100">



																			<a href="?dashboard=user&page=payment&tab=incomelist&action=delete&income_id=<?php echo esc_attr($retrieved_data->invoice_id);?>" class="float_left_width_100 list_delete_btn" onclick="return confirm('<?php esc_html_e('Are you sure you want to delete this record?','gym_mgt');?>');"><i class="fa fa-trash"></i> <?php esc_html_e( 'Delete', 'gym_mgt' ) ;?> </a>



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



																		<a href="?dashboard=user&page=payment&tab=view_invoice&idtest=<?php echo $retrieved_data->invoice_id; ?>&invoice_type=income" class="float_left_width_100" 



																		><i class="fa fa-eye" aria-hidden="true"></i> <?php esc_html_e('View Invoice', 'gym_mgt' ) ;?></a>



																	</li>



																	<?php 



																	if($user_access['edit']=='1')



																	{	



																		if(!empty($retrieved_data->invoice_no))



																		{



																			if(!($retrieved_data->invoice_label=='Fees Payment' || $retrieved_data->invoice_label=='Sell Product'))



																			{



																				?>



																				<li class="float_left_width_100 border_bottom_item">



																					<a href="?dashboard=user&page=payment&tab=addincome&action=edit&income_id=<?php echo esc_attr($retrieved_data->invoice_id)?>" class="float_left_width_100"><i class="fa fa-edit"></i> <?php esc_html_e('Edit', 'gym_mgt' ) ;?>



																					</a>



																				</li>



																				<?php 



																			}



																		}



																	}



																	if($user_access['delete']=='1')



																	{ 



																		?>



																		<li class="float_left_width_100">



																			<a href="?dashboard=user&page=payment&tab=incomelist&action=delete&income_id=<?php echo esc_attr($retrieved_data->invoice_id);?>" class="float_left_width_100 list_delete_btn" onclick="return confirm('<?php esc_html_e('Are you sure you want to delete this record?','gym_mgt');?>');"><i class="fa fa-trash"></i> <?php esc_html_e( 'Delete', 'gym_mgt' ) ;?> </a>



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



										}



										if($obj_gym->role == 'accountant')				



										{ 



											if (($retrieved_data->total_amount > '0' ) && ($retrieved_data->payment_status == 'Unpaid' || $retrieved_data->payment_status == 'Partially Paid' || $retrieved_data->payment_status == 'Part Paid' || $retrieved_data->payment_status == 'Not Paid'))



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



																		<a href="?dashboard=user&page=payment&tab=view_invoice&idtest=<?php echo $retrieved_data->invoice_id; ?>&invoice_type=income" class="float_left_width_100" 



																		><i class="fa fa-eye" aria-hidden="true"></i> <?php esc_html_e('View Invoice', 'gym_mgt' ) ;?></a>



																	</li>



																	<li class="float_left_width_100">



																		<a href="#" class="show-payment-popup float_left_width_100"  idtest="<?php echo esc_attr($retrieved_data->invoice_id); ?>" member_id="<?php echo esc_attr($retrieved_data->supplier_name); ?>"  view_type="income" due_amount="<?php echo str_replace(",","",number_format($due_amount,2)); ?>" ><i class="fa fa-credit-card" aria-hidden="true"></i> <?php esc_html_e('Pay', 'gym_mgt' ) ;?></a>



																	</li>



																	



																	<?php 



																	if($user_access['edit']=='1')



																	{



																		if(!empty($retrieved_data->invoice_no))



																		{



																			if(!($retrieved_data->invoice_label=='Fees Payment' || $retrieved_data->invoice_label=='Sell Product'))



																			{



																				?>



																				<li class="float_left_width_100 border_bottom_item">



																					<a href="?dashboard=user&page=payment&tab=addincome&action=edit&income_id=<?php echo esc_attr($retrieved_data->invoice_id)?>" class="float_left_width_100"><i class="fa fa-edit"></i> <?php esc_html_e('Edit', 'gym_mgt' ) ;?>



																					</a>



																				</li>



																				<?php 



																			}



																		}



																	}



																	if($user_access['delete']=='1')



																	{ 



																		?>



																		<li class="float_left_width_100">



																			<a href="?dashboard=user&page=payment&tab=incomelist&action=delete&income_id=<?php echo esc_attr($retrieved_data->invoice_id);?>" class="float_left_width_100 list_delete_btn" onclick="return confirm('<?php esc_html_e('Are you sure you want to delete this record?','gym_mgt');?>');"><i class="fa fa-trash"></i> <?php esc_html_e( 'Delete', 'gym_mgt' ) ;?> </a>



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



											else



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



																		<a href="?dashboard=user&page=payment&tab=view_invoice&idtest=<?php echo $retrieved_data->invoice_id; ?>&invoice_type=income" class="float_left_width_100" 



																		><i class="fa fa-eye" aria-hidden="true"></i> <?php esc_html_e('View Invoice', 'gym_mgt' ) ;?></a>



																	</li>



																	



																	<?php 



																	if($user_access['edit']=='1')



																	{



																		if(!empty($retrieved_data->invoice_no))



																		{



																			if(!($retrieved_data->invoice_label=='Fees Payment' || $retrieved_data->invoice_label=='Sell Product'))



																			{



																				?>



																				<li class="float_left_width_100 border_bottom_item">



																					<a href="?dashboard=user&page=payment&tab=addincome&action=edit&income_id=<?php echo esc_attr($retrieved_data->invoice_id)?>" class="float_left_width_100"><i class="fa fa-edit"></i> <?php esc_html_e('Edit', 'gym_mgt' ) ;?>



																					</a>



																				</li>



																				<?php 



																			}



																		}



																	}



																	if($user_access['delete']=='1')



																	{ 



																		?>



																		<li class="float_left_width_100">



																			<a href="?dashboard=user&page=payment&tab=incomelist&action=delete&income_id=<?php echo esc_attr($retrieved_data->invoice_id);?>" class="float_left_width_100 list_delete_btn" onclick="return confirm('<?php esc_html_e('Are you sure you want to delete this record?','gym_mgt');?>');"><i class="fa fa-trash"></i> <?php esc_html_e( 'Delete', 'gym_mgt' ) ;?> </a>



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



										} 



										if($obj_gym->role == 'staff_member')				



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



																	<a href="?dashboard=user&page=payment&tab=view_invoice&idtest=<?php echo $retrieved_data->invoice_id; ?>&invoice_type=income" class="float_left_width_100" 



																	><i class="fa fa-eye" aria-hidden="true"></i> <?php esc_html_e('View Invoice', 'gym_mgt' ) ;?></a>



																</li>



																<li class="float_left_width_100">



																	<a href="#" class="show-payment-popup float_left_width_100"  idtest="<?php echo esc_attr($retrieved_data->invoice_id); ?>" member_id="<?php echo esc_attr($retrieved_data->supplier_name); ?>"  view_type="income" due_amount="<?php echo str_replace(",","",number_format($due_amount,2)); ?>" ><i class="fa fa-credit-card" aria-hidden="true"></i> <?php esc_html_e('Pay', 'gym_mgt' ) ;?></a>



																</li>



																



																<?php 



																if($user_access['edit']=='1')



																{



																	if(!empty($retrieved_data->invoice_no))



																	{



																		if(!($retrieved_data->invoice_label=='Fees Payment' || $retrieved_data->invoice_label=='Sell Product'))



																		{



																			?>



																			<li class="float_left_width_100 border_bottom_item">



																				<a href="?dashboard=user&page=payment&tab=addincome&action=edit&income_id=<?php echo esc_attr($retrieved_data->invoice_id)?>" class="float_left_width_100"><i class="fa fa-edit"></i> <?php esc_html_e('Edit', 'gym_mgt' ) ;?>



																				</a>



																			</li>



																			<?php 



																		}



																	}



																}



																if($user_access['delete']=='1')



																{ 



																	?>



																	<li class="float_left_width_100">



																		<a href="?dashboard=user&page=payment&tab=incomelist&action=delete&income_id=<?php echo esc_attr($retrieved_data->invoice_id);?>" class="float_left_width_100 list_delete_btn" onclick="return confirm('<?php esc_html_e('Are you sure you want to delete this record?','gym_mgt');?>');"><i class="fa fa-trash"></i> <?php esc_html_e( 'Delete', 'gym_mgt' ) ;?> </a>



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



						</table><!--TABLE INCOME LIST END-->



					</div><!--TABLE RESPONSIVE END-->



				</div><!--PANEL BODY DIV END-->



				<?php



			}



			else



			{



				if($user_access['add']=='1')



				{



					?>



					<div class="no_data_list_div"> 



						<a href="<?php echo home_url().'?dashboard=user&page=payment&tab=addincome';?>">



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



		if($active_tab == 'addincome')



		{



			?>



			<!--Add Income information-->



			<script type="text/javascript">



			$(document).ready(function() 



			{



				"use strict";



				$('#income_form').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});	



				  var date = new Date();



					date.setDate(date.getDate()-0);



					 $('#invoice_date').datepicker({



					 dateFormat:'<?php  echo get_option('gmgt_datepicker_format'); ?>',



					 <?php



					if(get_option('gym_enable_datepicker_privious_date')=='no')



					{



					?>



						minDate:'today',



						startDate: date,



					<?php



					}



					?>	



					 autoclose: true



				   }); 	



					



			} );



			</script>



			<?php 



			$income_id=0;



			$edit=0;



			if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')



			{



				$edit=1;



				$income_id=$_REQUEST['income_id'];



				$result = $obj_payment->MJ_gmgt_get_income_data($income_id);



			}?>



			<div class="panel-body padding_0"><!--PANEL BODY DIV END-->



				<form name="income_form" action="" method="post" class="form-horizontal" id="income_form"><!--INCOME FORM START-->



					<?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>



					<input type="hidden" name="action" value="<?php echo esc_attr($action);?>">



					<input type="hidden" name="income_id" value="<?php echo esc_attr($income_id);?>">



					<input type="hidden" name="invoice_type" value="income">



					<input type="hidden" name="invoice_no" value="<?php if($edit){ echo esc_attr($result->invoice_no); }?>">



					<input type="hidden" name="paid_amount" value="<?php if($edit){ echo esc_attr($result->paid_amount); } ?>">



					<div class="header">	



						<h3 class="first_hed"><?php esc_html_e('Income Information','gym_mgt');?></h3>



					</div>



					<div class="form-body user_form"> <!-- user_form Strat-->   



						<div class="row"><!--Row Div Strat--> 



							<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 input">



								<!-- <label class="ml-1 custom-top-label top" for="staff_name"><?php //esc_html_e('Member','gym_mgt');?><span class="require-field">*</span></label> -->



								<?php if($edit){ $member_id=$result->supplier_name; }elseif(isset($_POST['member_id'])){$member_id=sanitize_text_field($_POST['member_id']);}else{$member_id='';}?>



								<select id="member_list" class="form-control display-members" required="true" name="supplier_name">



									<option value=""><?php esc_html_e('Select Member','gym_mgt');?></option>



									<?php $get_members = array('role' => 'member');



									$membersdata=get_users($get_members);



									if(!empty($membersdata))



									{



										foreach ($membersdata as $member){?>



											<option value="<?php echo esc_attr($member->ID);?>" <?php selected(esc_attr($member_id),esc_attr($member->ID));?>><?php echo esc_html(MJ_gmgt_get_member_full_display_name_with_memberid(esc_html($member->ID))); ?> </option>



										<?php }



									}?>



								</select>



							</div>



							<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">



								<div class="form-group input">



									<div class="col-md-12 form-control">



										<input id="invoice_label" class="form-control validate[required,custom[popup_category_validation]] text-input" maxlength="50" type="text" value="<?php if($edit){ echo esc_attr($result->invoice_label);}elseif(isset($_POST['invoice_label'])) echo esc_attr($_POST['payment_title']);?>" name="invoice_label">



										<label class="" for="member_id"><?php esc_html_e('Income Title','gym_mgt');?><span class="require-field">*</span></label>



									</div>



								</div>



							</div>



							<?php wp_nonce_field( 'save_income_nonce' ); ?>



							<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">



								<div class="form-group input">



									<div class="col-md-12 form-control">



										<input id="invoice_date"  class="form-control " type="text" value="<?php if($edit){ echo esc_attr(MJ_gmgt_getdate_in_input_box($result->invoice_date));} elseif(isset($_POST['invoice_date'])){ echo esc_attr($_POST['invoice_date']);} else{ echo esc_attr(MJ_gmgt_getdate_in_input_box(date("Y-m-d")));}?>" name="invoice_date" readonly>



										<label class="" for="member_id"><?php esc_html_e('Date','gym_mgt');?><span class="require-field">*</span></label>



									</div>



								</div>



							</div>



							<div class="rtl_margin_top_15px col-sm-6 col-md-6 col-lg-6 col-xl-6 res_margin_bottom_20px multiselect_validation_member smgt_multiple_select">



								<select  class="form-control tax_charge" name="tax[]" multiple="multiple">



									<?php



									if($edit)



									{



										$tax_id=explode(',',$result->tax_id);



									}



									else



									{



										$tax_id[]='';



									}



									$obj_tax=new MJ_gmgt_tax;



									$gmgt_taxs=$obj_tax->MJ_gmgt_get_all_taxes();	



									if(!empty($gmgt_taxs))



									{



										foreach($gmgt_taxs as $data)



										{



											$selected = "";



											if(in_array($data->tax_id,$tax_id))



												$selected = "selected";



											?>



											<option value="<?php echo esc_attr($data->tax_id); ?>" <?php echo esc_html($selected); ?> ><?php echo esc_html($data->tax_title);?>-<?php echo esc_html($data->tax_value);?></option>



										<?php 



										}



									}



									?>



								</select>	



							</div>



						</div>



					</div>



					<hr>	



						<?php 					



						if($edit)



						{



							$all_income_entry=json_decode($result->entry);



						}

						if(!empty($all_income_entry))



						{



							$i=1;
						?>
						<div class="income_entry_div">
						<?php


							foreach($all_income_entry as $entry)



							{



								?>



								<div class="form-body user_form"> <!-- user_form Strat-->   



									<div class="row "><!--Row Div Strat--> 



										<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



											<div class="form-group input">



												<div class="col-md-12 form-control">



													<input id="income_amount" class="form-control validate[required] text-input" type="number" min="0" onkeypress="if(this.value.length==8) return false;" step="0.01" value="<?php echo esc_attr($entry->amount);?>" name="income_amount[]" placeholder="<?php esc_html_e('Income Amount','gym_mgt');?>(<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?>)">



													<label class="" for="membership_name"><?php esc_html_e('Income Amount','gym_mgt');?>(<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?>)<span class="require-field">*</span></label>



												</div>



											</div>



										</div>



										<div class="col-sm-5 col-md-5 col-lg-5 col-xl-5 ">



											<div class="form-group input">



												<div class="col-md-12 form-control">



													<input id="income_entry" class="form-control validate[required,custom[popup_category_validation]] text-input onlyletter_space_validation1" type="text" maxlength="50" value="<?php echo esc_attr($entry->entry);?>" name="income_entry[]">



													<label class="" for="membership_name"><?php esc_html_e('Income Entry Label','gym_mgt');?><span class="require-field">*</span></label>



												</div>



											</div>



										</div>

										<?php
									if($i == 1)
									{
									?>
										<div class="col-md-1 symptoms_deopdown_div mb-3 rtl_margin_top_15px">



										<img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Add_new_plus_btn.png"?>" onclick="add_entry()" alt="" name="add_new_entry" class="daye_name_onclickr" id="add_new_entry">



										</div>
										<?php
									}
									else{
										?>
										<div class="col-md-1 symptoms_deopdown_div mb-3 rtl_margin_top_15px">



											<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Delete.png"?>" onclick="deleteParentElement(this)" alt="">



										</div>
										<?php
									}
										?>


										



										



									</div>



								</div>



								<?php



								$i++;



							}
						?>
						</div>
						<?php


						}



						else



						{



							?>



							<div class="form-body user_form"> <!-- user_form Strat-->   



								<div class="row income_entry_div"><!--Row Div Strat--> 



									<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



										<div class="form-group input">



											<div class="col-md-12 form-control">



												<input id="income_amount" class="form-control validate[required] text-input" type="number" min="0" onkeypress="if(this.value.length==8) return false;" step="0.01" value="" name="income_amount[]" >



												<label class="active" for="membership_name"><?php esc_html_e('Income Amount','gym_mgt');?>(<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?>)<span class="require-field">*</span></label>



											</div>



										</div>



									</div>



									<div class="col-sm-5 col-md-5 col-lg-5 col-xl-5 ">



										<div class="form-group input">



											<div class="col-md-12 form-control">



												<input id="income_entry" class="form-control validate[required,custom[popup_category_validation]] text-input onlyletter_space_validation1"   maxlength="50" type="text" value="" name="income_entry[]">



												<label class="active" for="membership_name"><?php esc_html_e('Income Entry Label','gym_mgt');?><span class="require-field">*</span></label>



											</div>



										</div>



									</div>



									<div class="col-md-1 symptoms_deopdown_div mb-3 rtl_margin_top_15px">



										<img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Add_new_plus_btn.png"?>" onclick="add_entry()" alt="" name="add_new_entry" class="daye_name_onclickr" id="add_new_entry">



									</div>



								</div>



							</div>



							<?php



						}



						?>



					<hr>	



					<div class="form-body user_form"> <!-- user_form Strat-->   



						<div class="row "><!--Row Div Strat--> 



							<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">



								<div class="form-group input">



									<div class="col-md-12 form-control">



										<input id="group_name" class="form-control text-input decimal_number" step="0.01" type="number" onKeyPress="if(this.value.length==8) return false;"  min="0" value="<?php if($edit){ echo esc_attr($result->discount);}elseif(isset($_POST['discount'])) echo esc_attr($_POST['discount']);?>" name="discount">



										<label class="active" for="membership_name"><?php esc_html_e('Discount Amount','gym_mgt');?>(<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?>)</label>



									</div>



								</div>



							</div>



							<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 mb-3 rtl_margin_top_15px">



								<div class="form-group">



									<div class="col-md-12 form-control">



										<div class="row padding_radio">



											<div class="">



												<label class="custom-top-label" for="gmgt_membership_recurring"><?php esc_html_e('Send SMS To Member','gym_mgt');?></label>



												<input id="chk_sms_sent" type="checkbox"  value="1" name="gmgt_sms_service_enable"> <?php esc_html_e('Enable','gym_mgt'); ?>



											</div>												



										</div>



									</div>



								</div>



							</div>



						</div>



					</div>



					<div class="form-body user_form"> <!-- user_form Strat-->   



						<div class="row "><!--Row Div Strat--> 



							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">



								<input type="submit" value="<?php if($edit){ esc_html_e('Save Income','gym_mgt'); }else{ esc_html_e('Add Income','gym_mgt');}?>" name="save_income" class="save_member_validate btn save_btn"/>



							</div>



						</div>



					</div>



				</form><!--INCOME FORM END-->



			</div><!--PANEL BODY DIV END-->



			<script>



				// CREATING BLANK INVOICE ENTRY



				var value = 1;



				function add_entry()



				{



					"use strict";



					value++;



					$(".income_entry_div").append('<div class="form-body user_form"><div class="row"><div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 "><div class="form-group input"><div class="col-md-12 form-control"><input id="income_amount" class="form-control validate[required] text-input" type="number" min="0" onkeypress="if(this.value.length==8) return false;" step="0.01" value="" name="income_amount[]" ><label class="active" for="membership_name"><?php esc_html_e('Income Amount','gym_mgt');?>(<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?>)<span class="require-field">*</span></label></div></div></div><div class="col-sm-5 col-md-5 col-lg-5 col-xl-5 "><div class="form-group input"><div class="col-md-12 form-control"><input id="income_entry" class="form-control validate[required,custom[popup_category_validation]] text-input onlyletter_space_validation1"   maxlength="50" type="text" value="" name="income_entry[]" ><label class="active" for="membership_name"><?php esc_html_e('Income Entry Label','gym_mgt');?><span class="require-field">*</span></label></div></div></div><div class="col-md-1 symptoms_deopdown_div mb-3 rtl_margin_top_15px"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Delete.png"?>" onclick="deleteParentElement(this)" alt=""></div></div></div>');			



				}		



				// REMOVING INVOICE ENTRY



				function deleteParentElement(n)



				{



					alert("<?php esc_html_e('Do you really want to delete this record','gym_mgt');?>");



					n.parentNode.parentNode.parentNode.removeChild(n.parentNode.parentNode);



				}



			</script> 



			<?php 



		}



		if($active_tab == 'expenselist')



		{ ?>



			<script type="text/javascript">



			$(document).ready(function() 



			{



				"use strict";



				jQuery('#tblexpence').DataTable({



					// "responsive": true,



					 "order": [[ 2, "desc" ]],



					 dom: 'lifrtp',



					 "aoColumns":[



								{"bSortable": true},



								{"bSortable": true},



								{"bSortable": true},



								{"bSortable": true},



								{"bSortable": false} 



							   ],



							language:<?php echo MJ_gmgt_datatable_multi_language();?>	   



					});



					$('.dataTables_filter input').attr("placeholder", "<?php esc_html_e('Search...', 'gym_mgt') ?>");



			} );



			</script>



			<?php



			if($user_access['own_data']=='1')



			{



				$user_id=get_current_user_id();



				$expensedata=$obj_payment->MJ_gmgt_get_all_expense_data_by_created_by($user_id);		



			}



			else



			{



				$expensedata=$obj_payment->MJ_gmgt_get_all_expense_data();



			}



			if(!empty($expensedata))



			{



				?>



				<div class="panel-body padding_0"><!--PANEL BODY DIV START-->



					<div class="table-responsive"><!--TABLE RESPONSIVE DIV START-->



						<table id="tblexpence" class="display" cellspacing="0" width="100%"><!--TABLE EXPENSE DIV START-->

							<thead class="<?php echo MJ_gmgt_datatable_heder(); ?>">

								<tr>

								<th><?php  esc_html_e( 'Photo', 'gym_mgt' ) ;?></th>

									<th><?php esc_html_e('Supplier Name','gym_mgt');?></th>

									<th><?php esc_html_e('Total Amount','gym_mgt');?></th>

									<th><?php esc_html_e('Date','gym_mgt');?></th>

									<th class="text_align_end"><?php esc_html_e('Action','gym_mgt');?></th>

								</tr>

							</thead>

							<tbody>



								<?php 



								



								$i=0;



								foreach ($expensedata as $retrieved_data)



								{ 



									$all_entry=json_decode($retrieved_data->entry);



									$total_amount=0;



									foreach($all_entry as $entry)



									{



										$total_amount+=$entry->amount;



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



																<a href="?dashboard=user&page=payment&tab=view_invoice&idtest=<?php echo $retrieved_data->invoice_id; ?>&invoice_type=expense" class="float_left_width_100"><i class="fa fa-eye" aria-hidden="true"></i> <?php esc_html_e('View Invoice', 'gym_mgt' ) ;?></a>



															</li>



															<?php 



															if($user_access['edit']=='1')



															{ 



																?>



																<li class="float_left_width_100 border_bottom_item">



																	<a href="?dashboard=user&page=payment&tab=addexpense&action=edit&expense_id=<?php echo esc_attr($retrieved_data->invoice_id);?>" class="float_left_width_100"><i class="fa fa-edit"></i> <?php esc_html_e('Edit', 'gym_mgt' ) ;?>



																	</a>



																</li>



																<?php 



															}



															if($user_access['delete']=='1')



															{ 



																?>



																<li class="float_left_width_100">



																	<a href="?dashboard=user&page=payment&tab=expenselist&action=delete&expense_id=<?php echo esc_attr($retrieved_data->invoice_id);?>" class="float_left_width_100 list_delete_btn" onclick="return confirm('<?php esc_html_e('Are you sure you want to delete this record?','gym_mgt');?>');"><i class="fa fa-trash"></i> <?php esc_html_e( 'Delete', 'gym_mgt' ) ;?> </a>



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



						</table><!--TABLE Expense LIST END-->



					</div><!--TABLE RESPONSIVE END-->



				</div>	<!--PANEL BODY END-->



				<?php 



			}



			else



			{



				if($user_access['add']=='1')



				{



					?>



					<div class="no_data_list_div"> 



						<a href="<?php echo home_url().'?dashboard=user&page=payment&tab=addexpense';?>">



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



		if($active_tab == 'addexpense')



		{ 



			$obj_payment= new MJ_gmgt_payment();?>



			<script type="text/javascript">   



			$(document).ready(function() 



			{



				"use strict";



				$('#expense_form').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});	



				var date = new Date();



				date.setDate(date.getDate()-0);



				 $('#invoice_date').datepicker({



				 dateFormat:'<?php  echo get_option('gmgt_datepicker_format'); ?>',



				 minDate:'today',



				 startDate: date,



				 autoclose: true



			   });



			} );



			</script>



			<?php 	



			$expense_id=0;



			$edit=0;



			if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')



			{



				$edit=1;



				$expense_id=$_REQUEST['expense_id'];



				$result = $obj_payment->MJ_gmgt_get_income_data($expense_id);							



			}



			?>



			<div class="panel-body padding_0"><!--PANEL BODY DIV START-->



				<form name="expense_form" action="" method="post" class="form-horizontal" id="expense_form"><!--EXPENSE FORM  START-->



					<?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>



					<input type="hidden" name="action" value="<?php echo esc_attr($action);?>">



					<input type="hidden" name="expense_id" value="<?php echo esc_attr($expense_id);?>">



					<input type="hidden" name="invoice_type" value="expense">



					<div class="header">	



						<h3 class="first_hed"><?php esc_html_e('Expense Information','gym_mgt');?></h3>



					</div>



					<div class="form-body user_form"> <!-- user_form Strat-->   



						<div class="row"><!--Row Div Strat--> 



							<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">



								<div class="form-group input">



									<div class="col-md-12 form-control">



										<input id="supplier_name" class="form-control validate[required,custom[onlyLetter_specialcharacter]] text-input" maxlength="50" type="text" value="<?php if($edit){ echo esc_attr($result->supplier_name);}elseif(isset($_POST['supplier_name'])) echo esc_attr($_POST['supplier_name']);?>" name="supplier_name">



										<label class="" for="member_id"><?php esc_html_e('Supplier Name','gym_mgt');?><span class="require-field">*</span></label>



									</div>



								</div>



							</div>



							<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 input">



								<label class="ml-1 custom-top-label top" for="staff_name"><?php esc_html_e('Status','gym_mgt');?><span class="require-field">*</span></label>



								<select name="payment_status" id="payment_status" class="form-control validate[required]">



									<option value="<?php echo esc_html__('Paid','gym_mgt');?>"<?php if($edit)selected('Paid',$result->payment_status);?> ><?php esc_html_e('Paid','gym_mgt');?></option>



									<option value="<?php echo esc_html__('Part Paid','gym_mgt');?>"<?php if($edit)selected('Part Paid',$result->payment_status);?>><?php esc_html_e('Part Paid','gym_mgt');?></option>



									<option value="<?php echo esc_html__('Unpaid','gym_mgt');?>"<?php if($edit)selected('Unpaid',$result->payment_status);?>><?php esc_html_e('Unpaid','gym_mgt');?></option>



								</select>



							</div>



							<?php wp_nonce_field( 'save_expense_nonce' ); ?>



							<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">



								<div class="form-group input">



									<div class="col-md-12 form-control">



										<input id="invoice_date"  class="form-control validate[required]" type="text" value="<?php if($edit){ echo esc_attr(MJ_gmgt_getdate_in_input_box($result->invoice_date));} elseif(isset($_POST['invoice_date'])){ echo $_POST['invoice_date'];} else{ echo esc_attr(MJ_gmgt_getdate_in_input_box(date("Y-m-d")));}?>" name="invoice_date" readonly>



										<label class="" for="member_id"><?php esc_html_e('Date','gym_mgt');?><span class="require-field">*</span></label>



									</div>



								</div>



							</div>



						</div>



					</div>	



					<hr>



						<?php



						if($edit)



						{



							$all_entry=json_decode($result->entry);



						}

						if(!empty($all_entry))



						{

							$i=1;
							foreach($all_entry as $entry)



							{



								?>



								<div id="expense_entry">



									<div class="form-body user_form"> <!-- user_form Strat-->   



										<div class="row"><!--Row Div Strat--> 



											<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



												<div class="form-group input">



													<div class="col-md-12 form-control">



														<input id="income_amount" class="form-control validate[required] text-input" type="number" min="0" onkeypress="if(this.value.length==8) return false;" step="0.01" value="<?php echo esc_attr($entry->amount);?>" name="income_amount[]">



														<label class="" for="membership_name"><?php esc_html_e('Expense Amount','gym_mgt');?>(<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?>)<span class="require-field">*</span></label>



													</div>



												</div>



											</div>



											<div class="col-sm-5 col-md-5 col-lg-5 col-xl-5 ">



												<div class="form-group input">



													<div class="col-md-12 form-control">



														<input id="income_entry" class="form-control validate[required,custom[popup_category_validation]] text-input onlyletter_space_validation1" maxlength="50" type="text" value="<?php echo esc_attr($entry->entry);?>" name="income_entry[]">



														<label class="" for="membership_name"><?php esc_html_e('Expense Label','gym_mgt');?><span class="require-field">*</span></label>



													</div>



												</div>



											</div>

											<?php
										if($i == 1)
										{
											?>

											<div class="col-md-1 symptoms_deopdown_div mb-3 rtl_margin_top_15px">



												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Add_new_plus_btn.png"?>" onclick="add_entry()" alt="" name="add_new_entry" class="daye_name_onclickr" id="add_new_entry">



											</div>

											<?php
										}
										else{
											?>

											<div class="col-md-1 symptoms_deopdown_div mb-3 rtl_margin_top_15px">



												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Delete.png"?>" onclick="deleteParentElement(this)" alt="">



											</div>
											<?php
											}
												?>


										</div>



									</div>



								</div>



								<?php

								$i++;

							}



						}



						else



						{



							?>



							<div id="expense_entry">



								<div class="form-body user_form"> <!-- user_form Strat-->   



									<div class="row"><!--Row Div Strat--> 



										<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



											<div class="form-group input">



												<div class="col-md-12 form-control">



													<input id="income_amount" class="form-control validate[required] text-input" type="number" min="0" onkeypress="if(this.value.length==8) return false;" step="0.01" value="" name="income_amount[]">



													<label class="active" for="membership_name"><?php esc_html_e('Expense Amount','gym_mgt');?>(<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?>)<span class="require-field">*</span></label>



												</div>



											</div>



										</div>



										<div class="col-sm-5 col-md-5 col-lg-5 col-xl-5 ">



											<div class="form-group input">



												<div class="col-md-12 form-control">



													<input id="income_entry" class="form-control validate[required,custom[popup_category_validation]] text-input onlyletter_space_validation1" maxlength="50" type="text" value="" name="income_entry[]">



													<label class="active" for="membership_name"><?php esc_html_e('Expense Label','gym_mgt');?><span class="require-field">*</span></label>



												</div>



											</div>



										</div>



										<div class="col-md-1 symptoms_deopdown_div mb-3 rtl_margin_top_15px">



											<img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Add_new_plus_btn.png"?>" onclick="add_entry()" alt="" name="add_new_entry" class="daye_name_onclickr" id="add_new_entry">



										</div>



									</div>



								</div>



							</div>



							<?php



						}



						?>



					<hr>



					<div class="form-body user_form"> <!-- user_form Strat-->   



						<div class="row "><!--Row Div Strat--> 



							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">



								<input type="submit" value="<?php if($edit){ esc_html_e('Save Expense','gym_mgt'); }else{ esc_html_e('Add Expense','gym_mgt');}?>" name="save_expense" class="btn save_btn"/>



							</div>



						</div>



					</div>



				</form><!--EXPENSE FORM  END-->



			</div><!--PANEL BODY END-->



			<script>



				// CREATING BLANK INVOICE ENTRY



				var value = 1;



				function add_entry()



				{



					"use strict";



					value++;



					$("#expense_entry").append('<div class="form-body user_form"><div class="row"><div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 "><div class="form-group input"><div class="col-md-12 form-control"><input id="income_amount" class="form-control validate[required] text-input" type="number" min="0" onkeypress="if(this.value.length==8) return false;" step="0.01" value="" name="income_amount[]"><label class="active" for="membership_name"><?php esc_html_e('Expense Amount','gym_mgt');?>(<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?>)<span class="require-field">*</span></label></div></div></div><div class="col-sm-5 col-md-5 col-lg-5 col-xl-5 "><div class="form-group input"><div class="col-md-12 form-control"><input id="income_entry" class="form-control validate[required,custom[popup_category_validation]] text-input onlyletter_space_validation1" maxlength="50" type="text" value="" name="income_entry[]" ><label class="active" for="membership_name"><?php esc_html_e('Expense Label','gym_mgt');?><span class="require-field">*</span></label></div></div></div><div class="col-md-1 symptoms_deopdown_div mb-3 rtl_margin_top_15px"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Delete.png"?>" onclick="deleteParentElement(this)" alt=""></div></div></div>');			



				}



				// REMOVING INVOICE ENTRY



				function deleteParentElement(n)



				{



					 alert("<?php esc_html_e('Do you really want to delete this record','gym_mgt');?>");



					n.parentNode.parentNode.parentNode.removeChild(n.parentNode.parentNode);



				}



			</script> 



			<?php



		}



		if($active_tab == 'view_invoice')



		{



			$obj_payment= new MJ_gmgt_payment();







			if($_REQUEST['invoice_type']=='membership_invoice')



			{		



				$obj_membership_payment=new MJ_gmgt_membership_payment;	



				$membership_data=$obj_membership_payment->MJ_gmgt_get_single_membership_payment($_REQUEST['idtest']);



				$history_detail_result = MJ_gmgt_get_payment_history_by_mpid($_REQUEST['idtest']);



			}



			if($_REQUEST['invoice_type']=='income')



			{



				$income_data=$obj_payment->MJ_gmgt_get_income_data($_REQUEST['idtest']);



				$history_detail_result = MJ_gmgt_get_income_payment_history_by_mpid($_REQUEST['idtest']);



			}



			if($_REQUEST['invoice_type']=='expense')



			{



				$expense_data=$obj_payment->MJ_gmgt_get_income_data($_REQUEST['idtest']);



			}



			if($_REQUEST['invoice_type']=='sell_invoice')



			{



				$obj_store=new MJ_gmgt_store;



				$selling_data=$obj_store->MJ_gmgt_get_single_selling($_REQUEST['idtest']);



				$history_detail_result = MJ_gmgt_get_sell_payment_history_by_mpid($_REQUEST['idtest']);



			}



			?>



			<div class="penal-body" id="invoice_print"><!----- penal Body --------->



				<div class="modal-body border_invoice_page margin_top_15px_rs invoice_model_body float_left_width_100 height_600px"><!---- model body  ----->



					<img class="rtl_image_set_invoice invoiceimage float_left invoice_image_model"  src="<?php echo plugins_url('/gym-management/assets/images/invoice.png'); ?>" width="100%">



					<div class="main_div float_left_width_100 payment_invoice_popup_main_div">



						<div class="invoice_width_100 float_left_width_100" border="0">



							<h3 class="school_name_for_invoice_view"><?php echo get_option( 'gmgt_system_name' ) ?></h3>



							<div class="row margin_top_20px">



								<div class="col-md-1 col-sm-2 col-xs-3">



									<div class="width_1 rtl_width_80px">



										<img class="system_logo"  src="<?php echo esc_url(get_option( 'gmgt_gym_other_data_logo' )); ?>">



									</div>



								</div>	



								<div class="col-md-11 col-sm-10 col-xs-9 invoice_address invoice_address_css">	



									<div class="row">	



										<div class="col-md-12 col-sm-12 col-xs-12 invoice_padding_bottom_15px padding_right_0">	



											<label class="popup_label_heading"><?php esc_html_e('Address','gym_mgt'); ?>



											</label><br>



											<label for="" class="label_value word_break_all">	<?php



													echo chunk_split(get_option( 'gmgt_gym_address' ),100,"<BR>").""; 



												?></label>



										</div>



										<div class="row col-md-12 invoice_padding_bottom_15px">	



											<div class="col-md-6 col-sm-6 col-xs-6 address_css padding_right_0 email_width_auto">	



												<label class="popup_label_heading"><?php esc_html_e('Email','gym_mgt');?> </label><br>



												<label for="" class="label_value word_break_all"><?php echo get_option( 'gmgt_email' ),"<BR>";  ?></label>



											</div>



									



											<div class="col-md-6 col-sm-6 col-xs-6 address_css padding_right_0 padding_left_30px">



												<label class="popup_label_heading"><?php esc_html_e('Phone','gym_mgt');?> </label><br>



												<label for="" class="label_value"><?php echo get_option( 'gmgt_contact_number' )."<br>";  ?></label>



											</div>



										</div>	



										<div align="right" class="width_24"></div>									



									</div>				



								</div>



							</div>



							<div class="col-md-12 col-sm-12 col-xl-12 mozila_display_css margin_top_20px">



								<div class="row">



									<div class="width_50a1 float_left_width_100">



										<div class="col-md-8 col-sm-8 col-xs-5 padding_0 float_left display_grid display_inherit_res margin_bottom_20px rs_main_billed_to">



											<div class="billed_to float_left_width_100 display_flex invoice_address_heading rs_width_billed_to">				



												<?php



												$issue_date='DD-MM-YYYY';



												if(!empty($income_data))



												{



													$issue_date=$income_data->invoice_date;



													$payment_status=$income_data->payment_status;



													$invoice_no=$income_data->invoice_no;



												}



												if(!empty($membership_data))



												{



													$issue_date=$membership_data->created_date;



													if($membership_data->payment_status!='0')



													{	



														$payment_status=$membership_data->payment_status;



													}



													else



													{



														$payment_status='Unpaid';



													}		



													$invoice_no=$membership_data->invoice_no;



												}



												if(!empty($expense_data))



												{



													$issue_date=$expense_data->invoice_date;



													$payment_status=$expense_data->payment_status;



													$invoice_no=$expense_data->invoice_no;



												}



												if(!empty($selling_data))



												{



													$issue_date=$selling_data->sell_date;	



													if(!empty($selling_data->payment_status))



													{



														$payment_status=$selling_data->payment_status;



													}	



													else



													{



														$payment_status='Fully Paid';



													}		



													



													$invoice_no=$selling_data->invoice_no;



												}			



													



												?>



												<h3 class="billed_to_lable invoice_model_heading bill_to_width_12 rs_bill_to_width_40"><?php esc_html_e('Bill To','gym_mgt');?> : </h3>



												



												<?php



												if(!empty($expense_data))



												{



													$party_name=$expense_data->supplier_name; 



													echo "<h3 class='display_name invoice_width_100'>".chunk_split(ucwords($party_name),30,"<BR>"). "</h3>";



												}



												else{



													if(!empty($income_data))



														$member_id=$income_data->supplier_name;



													if(!empty($membership_data))



														$member_id=$membership_data->member_id;



													if(!empty($selling_data))



														$member_id=$selling_data->member_id;



													$patient=get_userdata($member_id);						



													echo "<h3 class='display_name invoice_width_100'>".chunk_split(MJ_gmgt_get_user_full_display_name(esc_html($member_id)),30,"<BR>"). "</h3>";







												}



												?>



											</div> 



											<div class="width_60b2 address_information_invoice">



												<?php 	



												if(!empty($expense_data))



												{



													// $party_name=$expense_data->supplier_name; 



													// echo "<h3 class='display_name invoice_width_100'>".chunk_split(ucwords($party_name),30,"<BR>"). "</h3>";



												}



												else



												{



													if(!empty($income_data))



														$member_id=$income_data->supplier_name;



													if(!empty($membership_data))



														$member_id=$membership_data->member_id;



													if(!empty($selling_data))



														$member_id=$selling_data->member_id;



													$patient=get_userdata($member_id);						



													// echo "<h3 class='display_name invoice_width_100'>".chunk_split(ucwords($patient->display_name),30,"<BR>"). "</h3>";



													$address=get_user_meta( $member_id,'address',true );



													$city_name = get_user_meta( $member_id,'city_name',true );



													$zip_code = get_user_meta( $member_id,'zip_code',true );



													echo chunk_split($address,30,"<BR>"); 



													if(!empty($zip_code))



													{



														



														echo get_user_meta( $member_id,'zip_code',true ).",<BR>"; 



													}



													if(!empty($city_name))



													{



														echo get_user_meta( $member_id,'city_name',true ).","."<BR>"; ; 



													}



												}		



												?>	



											</div>



										</div> 



										<div class="col-md-3 col-sm-4 col-xs-7 float_left">



											<div class="width_50a1112">



												<div class="width_20c" align="center">



													<?php



													if($_REQUEST['invoice_type']!='expense')



													{



														?>	



														<h3 class="invoice_lable"><?php echo esc_html__('INVOICE','gym_mgt')." #".$invoice_no;?></h3>								



														<?php



													}



													?>



													<h5 class="align_left"> <label class="popup_label_heading text-transfer-upercase"><?php   echo esc_html__('Date :','gym_mgt') ?> </label>&nbsp;  <label class="invoice_model_value"><?php echo MJ_gmgt_getdate_in_input_box(date("Y-m-d", strtotime($issue_date))); ?></label></h5>



													<h5 class="align_left"><label class="popup_label_heading text-transfer-upercase"><?php echo esc_html__('Status :','gym_mgt')?> </label>  &nbsp;<label class="invoice_model_value"><?php if($payment_status == 'Unpaid')
                                        {
                                            echo '<span style="color:red;">'.esc_html__($payment_status,'gym_mgt').'</span>';
                                        }
                                        elseif($payment_status == 'Partially Paid')
                                        {
                                            echo '<span style="color:blue;">'.esc_html__($payment_status,'gym_mgt').'</span>';
                                        }
                                        elseif($payment_status == 'Part Paid')
                                        {
                                            echo '<span style="color:blue;">'.esc_html__($payment_status,'gym_mgt').'</span>';
                                        }
                                        elseif($payment_status == 'Paid')
                                        {
                                            echo '<span style="color:green;">'.esc_html__($payment_status,'gym_mgt').'</span>';
                                        } 
                                        else
                                        {
                                            echo '<span style="color:green;">'.esc_html__($payment_status,'gym_mgt').'</span>';
                                        } ?></h5>	



												</div> 



											</div> 



										</div> 



									</div> 



								</div>  



							</div>



							<table class="width_100 margin_top_10px_res">	



								<tbody>		



									<tr>



										<td>



											<?php



											if($_REQUEST['invoice_type']=='membership_invoice')



											{ 



												?>



												<h3 class="display_name"><?php esc_attr_e('Membership Entries','gym_mgt');?></h3>



												<?php



											}



											elseif($_REQUEST['invoice_type']=='income')



											{ 



												?>



												<h3 class="display_name"><?php esc_attr_e('Income Entries','gym_mgt');?></h3>



												<?php



											}



											elseif($_REQUEST['invoice_type']=='sell_invoice')



											{ 



												?>



												<h3 class="display_name"><?php esc_attr_e('Sale Product','gym_mgt');?></h3>



												<?php



											}



											else



											{



												?>



												<h3 class="display_name"><?php esc_attr_e('Expense Entries','gym_mgt');?></h3>



												<?php



											}



											?>



											



										<td>	



									</tr>



								</tbody>



							</table>



							<div class="table-responsive table_max_height_180px rtl_padding-left_40px">



								<table class="table model_invoice_table">



									<thead class="entry_heading invoice_model_entry_heading">	



										<?php



										if($_REQUEST['invoice_type']=='membership_invoice')



										{



											?>				



											<tr>



												<th class="entry_table_heading align_center">#</th>



												<th class="entry_table_heading align_center"> <?php esc_attr_e('Date','gym_mgt');?></th>



												<th class="entry_table_heading align_center"><?php esc_attr_e('Fees Type','gym_mgt');?> </th>



												<th class="entry_table_heading align_center"><?php esc_attr_e('Amount','gym_mgt');?></th>



											</tr>



											<?php



										}



										elseif($_REQUEST['invoice_type']=='sell_invoice')



										{



											?>				



											<tr>



												<th class="entry_table_heading align_center">#</th>



												<th class="entry_table_heading align_center"> <?php esc_attr_e('Date','gym_mgt');?></th>



												<th class="entry_table_heading align_center"><?php esc_attr_e('Product Name','gym_mgt');?> </th>



												<th class="entry_table_heading align_center"><?php esc_attr_e('Quantity','gym_mgt');?></th>



												<th class="entry_table_heading align_center"><?php esc_attr_e('Price','gym_mgt');?> </th>



												<th class="entry_table_heading align_center"><?php esc_attr_e('Total','gym_mgt');?></th>



											</tr>



											<?php



										}



										else



										{



											?>				



											<tr>



												<th class="entry_table_heading align_center">#</th>



												<th class="entry_table_heading align_center"> <?php esc_attr_e('Date','gym_mgt');?></th>



												<th class="entry_table_heading align_center"><?php esc_attr_e('Entry','gym_mgt');?> </th>



												<th class="entry_table_heading align_center"><?php esc_attr_e('Amount','gym_mgt');?></th>



											</tr>



											<?php



										}



										?>						



									</thead>



									<tbody>



										<?php 



										$id=1;



										$i=1;



										$total_amount=0;



										if(!empty($income_data) || !empty($expense_data))



										{



											if(!empty($expense_data))



											{



												$income_data=$expense_data;



											}



											



											$member_income=$obj_payment->MJ_gmgt_get_oneparty_income_data_incomeid($income_data->invoice_id);



											



											foreach($member_income as $result_income)



											{



												$income_entries=json_decode($result_income->entry);



												$discount_amount=$result_income->discount;



												$paid_amount=$result_income->paid_amount;



												$total_discount_amount= $result_income->amount - $discount_amount;



												if($result_income->tax_id!='')



												{									



													$total_tax=0;



													$tax_array=explode(',',$result_income->tax_id);



													foreach($tax_array as $tax_id)



													{



														$tax_percentage=MJ_gmgt_tax_percentage_by_tax_id($tax_id);



																			



														$tax_amount=$total_discount_amount * $tax_percentage / 100;



														



														$total_tax=$total_tax + $tax_amount;				



													}



												}



												else



												{



													$total_tax=$total_discount_amount * $result_income->tax/100;



												}



												$due_amount=0;



												$due_amount=$result_income->total_amount - $result_income->paid_amount;



												$grand_total=$total_discount_amount + $total_tax;







												foreach($income_entries as $each_entry)



												{



													$total_amount+=$each_entry->amount;								



													?>



													<tr>



														<td class="align_center invoice_table_data"><?php echo $id;?></td>



														<td class="align_center invoice_table_data"><?php echo MJ_gmgt_getdate_in_input_box($result_income->invoice_date);?></td>



														<td class="align_center invoice_table_data"><?php echo $each_entry->entry; ?> </td>



														<td class="align_center invoice_table_data"><?php echo "<span>".MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ))."</span> ".number_format($each_entry->amount,2); ?></td>



													</tr>



													<?php 



													$id+=1;



													$i+=1;



												}



												if($grand_total=='0')									



												{	



													if($income_data->payment_status=='Paid')



													{



														



														$grand_total=$total_amount;



														$paid_amount=$total_amount;



														$due_amount=0;										



													}



													else



													{



														



														$grand_total=$total_amount;



														$paid_amount=0;



														$due_amount=$total_amount;															



													}



												}



											}



										}



										if(!empty($membership_data))



										{



											$membership_signup_amounts=$membership_data->membership_signup_amount;



											?>



											<tr>



												<td class="align_center invoice_table_data"><?php echo $i;?></td>



												<td class="align_center invoice_table_data"><?php echo MJ_gmgt_getdate_in_input_box($membership_data->created_date);?></td>



												<td class="align_center invoice_table_data"><?php echo MJ_gmgt_get_membership_name($membership_data->membership_id);?></td>



												<td class="align_center invoice_table_data"><?php echo "<span>".MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ))."</span> ".number_format($membership_data->membership_fees_amount,2); ?></td>



											</tr>



											<?php 



											if( $membership_signup_amounts  > 0) 



											{



												?>



												<tr class="">



													<td class="align_center invoice_table_data"><?php echo 2 ;?></td> 



													<td class="align_center invoice_table_data"><?php echo MJ_gmgt_getdate_in_input_box($membership_data->created_date);?></td> 



													<td class="align_center invoice_table_data"><?php esc_html_e('Membership Signup Fee','gym_mgt');?></td>								



													<td class="align_center invoice_table_data"><?php echo "<span>".MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ))."</span> ".number_format($membership_data->membership_signup_amount,2); ?></td>



												</tr>



												<?php



											}



										}



										if(!empty($selling_data))



										{



											$all_entry=json_decode($selling_data->entry);



											if(!empty($all_entry))



											{



												foreach($all_entry as $entry)



												{



													$obj_product=new MJ_gmgt_product;



													$product = $obj_product->MJ_gmgt_get_single_product($entry->entry);



												



													$product_name=$product->product_name;					



													$quentity=$entry->quentity;	



													$price=$product->price;	







													?>



													<tr class="">										



														<td class="align_center invoice_table_data"><?php echo $i;?></td> 



														<td class="align_center invoice_table_data"><?php echo MJ_gmgt_getdate_in_input_box($selling_data->sell_date);?></td>



														<td class="align_center invoice_table_data"><?php echo $product_name;?> </td>



														<td  class="align_center invoice_table_data"> <?php echo $quentity; ?></td>



														<td class="align_center invoice_table_data"><?php echo MJ_gmgt_get_floting_value($price); ?></td>



														<td class="align_center invoice_table_data"><?php echo "<span>".MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ))."</span> ".number_format($quentity * $price,2); ?></td>



													</tr>



													<?php



													$id+=1;



													$i+=1;



												}



											}



											else



											{



												$obj_product=new MJ_gmgt_product;



												$product = $obj_product->MJ_gmgt_get_single_product($selling_data->product_id); 



												



												$product_name=$product->product_name;					



												$quentity=$selling_data->quentity;	



												$price=$product->price;	



												?>



												<tr class="">										



													<td class="align_center invoice_table_data"><?php echo $i;?></td> 



													<td class="align_center invoice_table_data"><?php echo MJ_gmgt_getdate_in_input_box($selling_data->sell_date);?></td>



													<td class="align_center invoice_table_data"><?php echo $product_name;?> </td>



													<td  class="align_center invoice_table_data"> <?php echo $quentity; ?></td>



													<td class="align_center invoice_table_data"> <?php echo $price; ?></td>



													<td class="align_center invoice_table_data"> <?php echo "<span>".MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ))."</span> ".number_format($quentity * $price,2); ?></td>



												</tr>



												<?php



												$id+=1;



												$i+=1;



											}



										}



										?>



									</tbody>



								</table>



							</div>



							<div class="table-responsive rtl_padding-left_40px rtl_float_left_width_100px">



								<?php 



								if(!empty($membership_data))



								{



									$total_amount=$membership_data->membership_fees_amount+$membership_data->membership_signup_amount;



									$total_tax=$membership_data->tax_amount;							



									$paid_amount=$membership_data->paid_amount;



									$due_amount=abs($membership_data->membership_amount - $paid_amount);



									$grand_total=$membership_data->membership_amount;							



								}



								if(!empty($expense_data))



								{



									$grand_total=$total_amount;



								}



								if(!empty($selling_data))



								{



									$all_entry=json_decode($selling_data->entry);



									



									if(!empty($all_entry))



									{



										$total_amount=$selling_data->amount;



										$discount_amount=$selling_data->discount;



										$total_discount_amount=$total_amount-$discount_amount;



										



										if($selling_data->tax_id!='')



										{									



											$total_tax=0;



											$tax_array=explode(',',$selling_data->tax_id);



											foreach($tax_array as $tax_id)



											{



												$tax_percentage=MJ_gmgt_tax_percentage_by_tax_id($tax_id);



																	



												$tax_amount=$total_discount_amount * $tax_percentage / 100;



												



												$total_tax=$total_tax + $tax_amount;				



											}



										}



										else



										{



											$tax_per=$selling_data->tax;



											$total_tax=$total_discount_amount * $tax_per/100;



										}



										



										$paid_amount=$selling_data->paid_amount;



										$due_amount=abs($selling_data->total_amount - $paid_amount);



										$grand_total=$selling_data->total_amount;



									}



									else



									{	



										$obj_product=new MJ_gmgt_product;



										$product = $obj_product->MJ_gmgt_get_single_product($selling_data->product_id);



										$price=$product->price;	



										



										$total_amount=$price*$selling_data->quentity;



										$discount_amount=$selling_data->discount;



										$total_discount_amount=$total_amount-$discount_amount;



										



										if($selling_data->tax_id!='')



										{									



											$total_tax=0;



											$tax_array=explode(',',$selling_data->tax_id);



											foreach($tax_array as $tax_id)



											{



												$tax_percentage=MJ_gmgt_tax_percentage_by_tax_id($tax_id);



																	



												$tax_amount=$total_discount_amount * $tax_percentage / 100;



												



												$total_tax=$total_tax + $tax_amount;				



											}



										}



										else



										{



											$tax_per=$selling_data->tax;



											$total_tax=$total_discount_amount * $tax_per/100;



										}



																		



										$paid_amount=$total_amount;



										$due_amount='0';



										$grand_total=$total_amount;								



									}		



								}							



								?>



								<div class="row width_100 col-md-12 col-sm-12 col-lg-12">



									<div class="col-md-7 col-sm-7 col-lg-7 col-xs-12">



										<h3 class="display_name align_left"><?php esc_attr_e('Payment Method','gym_mgt');?></h3>



										<table width="100%" border="0">



											<tbody>							



												<tr style="">



													<td class="label_min_width_130px rtl_float_left_label padding_bottom_15px total_heading"><?php esc_attr_e('Bank Name','gym_mgt');?></td>



													<td class="rtl_width_15px padding_bottom_15px total_value">:&nbsp;&nbsp;<?php echo get_option( 'gmgt_bank_name' );?></td>



												</tr>



												<tr style="">



													<td  class="label_min_width_130px rtl_float_left_label padding_bottom_15px total_heading"><?php esc_attr_e('Account No.','gym_mgt');?></td>



													<td class="rtl_width_15px padding_bottom_15px total_value">:&nbsp;&nbsp;<?php echo get_option( 'gmgt_bank_acount_number' );?></td>



												</tr>



												<tr style="">



													<td  class="label_min_width_130px rtl_float_left_label padding_bottom_15px total_heading"><?php esc_attr_e('IFSC Code','gym_mgt');?></td>



													<td class="rtl_width_15px padding_bottom_15px total_value">:&nbsp;&nbsp;<?php echo get_option( 'gmgt_bank_ifsc_code' );?></td>



												</tr>



												<tr style="">



													<td  class="label_min_width_130px rtl_float_left_label padding_bottom_15px total_heading"><?php esc_attr_e('Paypal ID','gym_mgt');?></td>



													<td class="rtl_width_15px padding_bottom_15px total_value">:&nbsp;&nbsp;<?php echo get_option( 'gmgt_paypal_email' );?></td>



												</tr>



											</tbody>



										</table>



									</div>



									<div class="col-md-5 col-sm-5 col-lg-5 col-xs-12">



										<table width="100%" border="0">



											<tbody>							



												<tr style="">



													<td  align="right" class="rtl_float_left_label padding_bottom_15px total_heading"><?php esc_attr_e('Sub Total :','gym_mgt');?></td>



													<td align="left" class="rtl_width_15px padding_bottom_15px total_value"><?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ));?><?php echo number_format($total_amount,2);?></td>



												</tr>



												<?php



												if($_REQUEST['invoice_type']!='expense')



												{



													if($_REQUEST['invoice_type']!='membership_invoice')



													{



														?>



														<tr>



															<td width="85%" class="rtl_float_left_label padding_bottom_15px total_heading" align="right"><?php esc_attr_e('Discount Amount :','gym_mgt');?></td>



															<td align="left" class="rtl_width_15px padding_bottom_15px total_value"><?php  echo "-";echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ));?><?php echo number_format($discount_amount,2); ?></td>



														</tr>



														<?php



													}



													?>



													<tr>



														<td width="85%" class="rtl_float_left_label padding_bottom_15px total_heading" align="right"><?php esc_attr_e('Tax Amount :','gym_mgt');?></td>



														<td align="left" class="rtl_width_15px padding_bottom_15px total_value"><?php  echo "+";echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ));?><?php echo number_format($total_tax,2); ?></td>



													</tr>



													<tr>



														<td width="85%" class="rtl_float_left_label padding_bottom_15px total_heading" align="right"><?php esc_attr_e('Due Amount :','gym_mgt');?></td>



														<?php if(!empty($fees_detail_result->total_amount)){ $Due_amount = $fees_detail_result->total_amount - $fees_detail_result->fees_paid_amount; } ?>



														<td align="left" class="rtl_width_15px padding_bottom_15px total_value"><?php  echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ));?><?php echo number_format($due_amount,2); ?></td>



													</tr>



													<tr>



														<td width="85%" class="rtl_float_left_label padding_bottom_15px total_heading" align="right"><?php esc_attr_e('Paid Amount :','gym_mgt');?></td>



														<td align="left" class="rtl_width_15px padding_bottom_15px total_value"><?php  echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ));?><?php echo number_format($paid_amount,2); ?></td>



													</tr>	



													<?php



												}	



												?>		



											</tbody>



										</table>



									</div>



								</div>



							</div>



							<div class="rtl_float_left row margin_top_10px_res col-md-4 col-sm-4 col-xs-4 view_invoice_lable_css inovice_width_100px_rs float_left grand_total_div invoice_table_grand_total" style="float: right;margin-right:0px;">



								<div class="width_50_res align_right col-md-5 col-sm-5 col-xs-5 view_invoice_lable padding_11 padding_right_0_left_0 float_left grand_total_label_div invoice_model_height line_height_1_5 padding_left_0_px"><h3 style="float: right;" class="padding color_white margin invoice_total_label"><?php esc_html_e('Grand Total','gym_mgt');?> </h3></div>



								<div class="width_50_res align_right col-md-7 col-sm-7 col-xs-7 view_invoice_lable  padding_right_5_left_5 padding_11 float_left grand_total_amount_div"><h3 style="float: left;" class="padding margin text-right color_white invoice_total_value"><?php echo "<span>".MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ))."</span> ".number_format($grand_total,2); ?></h3></div>



							</div>



							<?php				



							if(!empty($history_detail_result))



							{



								?>



								<hr class="width_100 flot_left_invoice_history_hr">



								<table class="width_100">	



									<tbody>	



										<tr>



											<td>



												<h3  class="display_name"><?php esc_html_e('Payment History','gym_mgt');?></h3>



											</td>	



										</tr>	



									</tbody>



								</table>



								<div class="table-responsive rtl_padding-left_40px table_max_height_250px">



									<table class="table model_invoice_table">



										<thead class="entry_heading invoice_model_entry_heading">



											<tr>



												<th class="entry_table_heading align_left"><?php esc_attr_e('Date','gym_mgt');?></th>



												<th class="entry_table_heading align_left"> <?php esc_attr_e('Amount','gym_mgt');?></th>



												<th class="entry_table_heading align_left"><?php esc_attr_e('Method','gym_mgt');?> </th>



												<th class="entry_table_heading align_left"><?php esc_html_e('Payment Details','gym_mgt');?></th>



											</tr>



										</thead>



										<tbody>



											<?php 



											foreach($history_detail_result as  $retrive_data)



											{



												?>



												<tr>



													<td class="align_left invoice_table_data"><?php echo MJ_gmgt_getdate_in_input_box($retrive_data->paid_by_date);?></td>



													<td class="align_left invoice_table_data"><?php echo "<span>".MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ))."</span> ".MJ_gmgt_get_floting_value($retrive_data->amount); ?></td>



													<td class="align_left invoice_table_data"><?php echo  esc_html__($retrive_data->payment_method,"gym_mgt"); ?></td>



													<td class="align_left invoice_table_data"><?php if(!empty($retrive_data->payment_description)){ echo  $retrive_data->payment_description; }else{ echo 'N/A'; }?></td>



												</tr>



												<?php 



											} ?>



										</tbody>



									</table>



								</div>



								<?php



							}



							?>



							<div class="col-md-12 grand_total_main_div total_padding_15px rtl_float_none margin_top_15px">



								<div class="row margin_top_10px_res width_50_res col-md-6 col-sm-6 col-xs-6 print-button pull-left invoice_print_pdf_btn">



									<div class="col-md-2 print_btn_rs width_50_res">



										<a href="?page=invoice&print=print&invoice_id=<?php echo $_REQUEST['idtest'];?>&invoice_type=<?php echo $_REQUEST['invoice_type'];?>" target="_blank" class="btn btn save_btn invoice_btn_div"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/print.png" ?>" > </a>



									</div>



									<div class="col-md-3 pdf_btn_rs width_50_res">



										<a href="?page=invoice&pdf=pdf&invoice_id=<?php echo $_REQUEST['idtest'];?>&invoice_type=<?php echo $_REQUEST['invoice_type'];?>" target="_blank" class="btn color_white invoice_btn_div btn save_btn"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/pdf.png" ?>" ></a>



									</div>



								</div>



							</div>



						</div>



					</div><!---------- Main Div ---------------->



				</div><!--------- Model Body --------------->



			</div><!----- penal Body --------->



			<?php



		}



		?>



	</div><!--TAB CONTENT DIV END-->



</div><!--PANEL WHITE DIV END-->