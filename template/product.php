<?php

$curr_user_id=get_current_user_id();

$obj_gym=new MJ_gmgt_Gym_management($curr_user_id);

$obj_product=new MJ_gmgt_product;

$active_tab = isset($_GET['tab'])?$_GET['tab']:'productlist';

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

//SAVE Product DATA

if(isset($_POST['save_product']))

{

	$nonce = $_POST['_wpnonce'];

	if (wp_verify_nonce( $nonce, 'save_product_nonce' ) )

	{

		if(isset($_FILES['product_image']) && !empty($_FILES['product_image']) && $_FILES['product_image']['size'] !=0)

		{

			if($_FILES['product_image']['size'] > 0)

			{

				 $product_image=MJ_gmgt_load_documets($_FILES['product_image'],'product_image','pimg');

				 $product_image_url=content_url().'/uploads/gym_assets/'.$product_image;

			}		

		}

		else

		{			

			if(isset($_REQUEST['hidden_upload_user_avatar_image']))

			{

				$product_image=esc_url($_REQUEST['hidden_upload_user_avatar_image']);

				$product_image_url=$product_image;

			}

		}

		$ext=MJ_gmgt_check_valid_extension($product_image_url);

		if(!$ext == 0)

		{

			if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit')

			{

				$data=$obj_product->MJ_gmgt_get_all_product_by_name_count(sanitize_text_field($_POST['product_name']),sanitize_text_field($_POST['product_id']));

				$data1=$obj_product->MJ_gmgt_get_all_product_by_sku_number_count(sanitize_text_field($_POST['sku_number']),sanitize_text_field($_POST['product_id']));

				$data2=$obj_product->MJ_gmgt_get_all_product_by_name_and_sku_number_Count(sanitize_text_field($_POST['product_name']),sanitize_text_field($_POST['sku_number']),sanitize_text_field($_POST['product_id']));

				if(empty($data2))

				{
					if(empty($data) && empty($data1))

					{

						$result=$obj_product->MJ_gmgt_add_product($_POST,$product_image_url);

						if($result)

						{

							if(isset($_REQUEST['product_list_app_view']) && $_REQUEST['product_list_app_view'] == 'productlist_app')

							{

								wp_redirect ( home_url().'?dashboard=user&page=product&tab=productlist&page_action=web_view_hide&product_list_app_view=productlist_app&message=2');

							}

							else

							{

								wp_redirect ( home_url().'?dashboard=user&page=product&tab=productlist&message=2');

							}

						}

					}

				}	

			}

			else

			{

				$data=$obj_product->MJ_gmgt_get_all_product_by_name($_POST['product_name']);

				$data1=$obj_product->MJ_gmgt_get_all_product_by_sku_number($_POST['sku_number']);

				$data2=$obj_product->MJ_gmgt_get_all_product_by_name_and_sku_number($_POST['product_name'],$_POST['sku_number']);

				if(empty($data2))

				{
					if(empty($data) && empty($data1))

					{

						$result=$obj_product->MJ_gmgt_add_product($_POST,$product_image_url);

						if($result)

						{

							if(isset($_REQUEST['product_list_app_view']) && $_REQUEST['product_list_app_view'] == 'productlist_app')

							{

								wp_redirect ( home_url().'?dashboard=user&page=product&tab=productlist&page_action=web_view_hide&product_list_app_view=productlist_app&message=1');

							}

							else

							{

								wp_redirect ( home_url().'?dashboard=user&page=product&tab=productlist&message=1');

							}

							
						}

					}

				}

			}

		}	

		else

		{ ?>

			<div id="message" class="updated below-h2 ">

				<p><?php esc_html_e('Sorry, only JPG, JPEG, PNG & GIF And BMP files are allowed.','gym_mgt');?></p>

			</div>				 

			<?php 

		}

	}

}

//Delete PRODUCT DATA

if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')

{

	$result=$obj_product->MJ_gmgt_delete_product($_REQUEST['product_id']);

	if($result)

	{

		if(isset($_REQUEST['product_list_app_view']) && $_REQUEST['product_list_app_view'] == 'productlist_app')

		{

			wp_redirect ( home_url().'?dashboard=user&page=product&tab=productlist&page_action=web_view_hide&product_list_app_view=productlist_app&message=3');

		}

		else

		{

			wp_redirect ( home_url().'?dashboard=user&page=product&tab=productlist&message=3');

		}

		//wp_redirect ( home_url().'?dashboard=user&page=product&tab=productlist&message=3');

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

			<?php esc_html_e('Product added successfully.','gym_mgt');?>

		</div>

		<?php	

	}

	elseif($message == 2)

	{

		?>

		<div id="message" class="alert_msg alert alert-success alert-dismissible " role="alert">

			<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span>

			</button>

			<?php esc_html_e('Product updated successfully.','gym_mgt');?>

		</div>

		<?php 

	}

	elseif($message == 3) 

	{

		?>

		<div id="message" class="alert_msg alert alert-success alert-dismissible " role="alert">

			<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span>

			</button>

			<?php esc_html_e('Product deleted successfully.','gym_mgt');?>

		</div>

		<?php

	}

}

?>

<script type="text/javascript">

$(document).ready(function() 

{

	"use strict";

	jQuery('#product_list').DataTable({

		// responsive: true,

		"order": [[ 1, "asc" ]],

		dom: 'lifrtp',

		"aoColumns":[

					{"bSortable": false},

	                {"bSortable": true},

	                {"bSortable": true},

	                {"bSortable": true},

	                {"bSortable": true},

	                {"bSortable": true},

					{"bSortable": false}],

				language:<?php echo MJ_gmgt_datatable_multi_language();?>	

		});

		$('.dataTables_filter input').attr("placeholder", "<?php esc_html_e('Search...', 'gym_mgt') ?>");

		$('#product_form').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});

		$.datepicker.setDefaults($.datepicker.regional['<?php echo MJ_gmgt_get_current_lan_code(); ?>']);

	$('.manufacture_date').datepicker(

	{

		dateFormat:'<?php echo get_option('gmgt_datepicker_format');?>',

		maxDate:'today',

		endDate: '+0d',

		autoclose: true

	}); 

} );

</script>

<!-- POP up code -->

<div class="popup-bg">

    <div class="overlay-content">

		<div class="modal-content">

			<div class="category_list notice"></div>     

		</div>

    </div>    

</div>

<!-- End POP-UP Code -->

<div class="panel-body panel-white padding_0 gms_main_list"><!-- PANEL BODY DIV START-->	

	<div class="tab-content padding_0"><!-- TAB CONTENT DIV START-->

		<?php 

		if($active_tab == 'productlist')

		{ 

			if($user_access['own_data']=='1')

			{

				$user_id=get_current_user_id();

				$productdata=$obj_product->MJ_gmgt_get_all_product_by_created_by($user_id);

			}

			else

			{

				$productdata=$obj_product->MJ_gmgt_get_all_product();

			}

			if(!empty($productdata))

			{

				?>	

				<div class="panel-body padding_0"><!--PANEL BODY DIV START-->

					<div class="table-responsive"><!--TABLE RESPONSIVE DIV START-->

						<table id="product_list" class="display" cellspacing="0" width="100%"><!--TABLE PRODUCT LIST START-->

							<thead class="<?php echo MJ_gmgt_datatable_heder(); ?>">
								<tr>
								<th><?php  esc_html_e( 'Photo', 'gym_mgt' ) ;?></th>
									<th><?php esc_html_e('Product Name','gym_mgt');?></th>
									<th><?php esc_html_e('SKU Number','gym_mgt');?></th>
									<th><?php esc_html_e('Product Category','gym_mgt');?></th>
									<th><?php esc_html_e('Product Price','gym_mgt');?></th>
									<th><?php esc_html_e('Product Quantity','gym_mgt');?></th>
									<th  class="text_align_end"><?php esc_html_e('Action','gym_mgt');?></th>
								</tr>
							</thead>
							<tbody>

							<?php 

							

							if(!empty($productdata))

							{

								foreach ($productdata as $retrieved_data)

								{

									?>

									<tr>

										<td class="user_image width_50px profile_image_prescription padding_left_0">

											<?php

											if(empty($retrieved_data->product_image))

											{

												echo '<img src='.get_option( 'gmgt_Product_logo' ).' height="50px" width="50px" class="image_icon_height_25px prescription_tag img-circle" />';

											}

											else

											{

												echo '<img src='.$retrieved_data->product_image.' height="50px" width="50px" class="image_icon_height_25px prescription_tag img-circle"/>';

											}

											?>

										</td>

										<?php

										if($obj_gym->role == 'staff_member' || $obj_gym->role == 'accountant')

										{

											?>

											<td class="productname">

												<?php

												if(isset($_REQUEST['product_list_app_view']) && $_REQUEST['product_list_app_view'] == 'productlist_app')

												{

													?>

													<?php echo esc_html($retrieved_data->product_name);?>

													<?php

												}

												else

												{

													?>

													<a href="#" class="view_details_popup" id="<?php echo esc_attr($retrieved_data->id)?>" type="<?php echo 'view_product';?>"><?php echo esc_html($retrieved_data->product_name);?></a>

													<?php

												}

												?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Product Name','gym_mgt');?>" ></i>

											</td>

										<?php 

										}

										else

										{

											?>

											<td class="productname"><?php echo esc_html($retrieved_data->product_name);?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Product Name','gym_mgt');?>" ></i></td>

										<?php 

										} 

										?>

										<td class="productname"><?php echo esc_html($retrieved_data->sku_number);?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('SKU Number','gym_mgt');?>" ></i></td>

										<td class="productname"><?php echo get_the_title(esc_html($retrieved_data->product_cat_id));?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Product Category','gym_mgt');?>" ></i></td>  

										<td class="productprice"><?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?> <?php echo esc_html($retrieved_data->price);?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Product Price','gym_mgt');?>" ></i></td>

										<td class="productquentity"><?php echo esc_html($retrieved_data->quentity);?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Product Quantity','gym_mgt');?>" ></i></td>

										<td class="action"> 

											<div class="gmgt-user-dropdown">

												<ul class="" style="margin-bottom: 0px !important;">

													<li class="">

														<a class="" href="#" data-bs-toggle="dropdown" aria-expanded="false">

															<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/More.png"?>" >

														</a>

														<ul class="dropdown-menu heder-dropdown-menu action_dropdawn" aria-labelledby="dropdownMenuLink">

															<li class="float_left_width_100">

																<a href="#" class="view_details_popup float_left_width_100" type="<?php echo 'view_product';?>" id="<?php echo esc_attr($retrieved_data->id)?>"><i class="fa fa-eye"></i><?php esc_html_e('View', 'gym_mgt' ) ;?></a>

															</li>	

															<?php

															if($user_access['edit']=='1')

															{

																if(isset($_REQUEST['product_list_app_view']) && $_REQUEST['product_list_app_view'] == 'productlist_app')

																{

																	?>	

																	<li class="float_left_width_100 border_bottom_item">

																		<a href="?dashboard=user&page=product&tab=addproduct&action=edit&product_list_app_view=productlist_app&page_action=web_view_hide&product_id=<?php echo esc_attr($retrieved_data->id)?>" class="float_left_width_100"><i class="fa fa-edit"></i> <?php esc_html_e('Edit', 'gym_mgt' ) ;?></a>

																	</li>

																	<?php

																}

																else

																{

																	?>	

																	<li class="float_left_width_100 border_bottom_item">

																		<a href="?dashboard=user&page=product&tab=addproduct&action=edit&product_id=<?php echo esc_attr($retrieved_data->id)?>" class="float_left_width_100"><i class="fa fa-edit"></i> <?php esc_html_e('Edit', 'gym_mgt' ) ;?></a>

																	</li>

																	<?php

																}

															}															

															if($user_access['delete']=='1')

															{ 

																if(isset($_REQUEST['product_list_app_view']) && $_REQUEST['product_list_app_view'] == 'productlist_app')

																{

																	?>

																	<li class="float_left_width_100">

																		<a href="?dashboard=user&page=product&tab=productlist&action=delete&product_list_app_view=productlist_app&page_action=web_view_hide&product_id=<?php echo esc_attr($retrieved_data->id);?>" class="float_left_width_100 list_delete_btn" onclick="return confirm('<?php esc_html_e('Are you sure you want to delete this record?','gym_mgt');?>');"><i class="fa fa-trash"></i><?php esc_html_e( 'Delete', 'gym_mgt' ) ;?> </a>

																	</li>

																	<?php 

																}

																else

																{

																	?>

																	<li class="float_left_width_100">

																		<a href="?dashboard=user&page=product&tab=productlist&action=delete&product_id=<?php echo esc_attr($retrieved_data->id);?>" class="float_left_width_100 list_delete_btn" onclick="return confirm('<?php esc_html_e('Are you sure you want to delete this record?','gym_mgt');?>');"><i class="fa fa-trash"></i><?php esc_html_e( 'Delete', 'gym_mgt' ) ;?> </a>

																	</li>

																	<?php 

																}

															} ?>

																

														</ul>

													</li>

												</ul>

											</div>	

										</td>				

									</tr>

									<?php						

								} 					

							}

							?>

							</tbody>

						</table><!--TABLE PRODUCT LIST END-->

					</div><!--TABLE RESPONSIVE DIV  END-->

				</div><!--PANEL BODY DIV END-->

				<?php 

			}

			else

			{

				if($user_access['add']=='1')

				{

					?>

					<div class="no_data_list_div"> 

						<a href="
						<?php 
						if(isset($_REQUEST['product_list_app_view']) && $_REQUEST['product_list_app_view'] == 'productlist_app' || isset($_REQUEST['page_action']) && $_REQUEST['page_action'] == 'web_view_hide')
						{
							echo "?dashboard=user&page=product&tab=addproduct&action=insert&page_action=web_view_hide&product_list_app_view=productlist_app";
						}
						else
						{
							echo home_url().'?dashboard=user&page=product&tab=addproduct';
						}
						?>">

							<img class="width_100px" src="<?php echo get_option( 'gmgt_no_data_img' ) ?>" >

						</a>

						<div class="col-md-12 dashboard_btn margin_top_20px margin_top_12p">

							<label class="no_data_list_label"><?php esc_html_e('Tap on above icon to add your first Record.','gym_mgt'); ?> </label>

						</div> 

					</div>      

					<?php

				}

				else

				{

					?>

					<div class="calendar-event-new margin_top_12p"> 

						<img class="no_data_img" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/no_data_img.png"?>" >

					</div>

					<?php

				}

			}

		}

		if($active_tab == 'addproduct')

		{

			$product_id=0;

			$edit=0;

			if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')

			{

				$edit=1;

				$product_id=$_REQUEST['product_id'];

				$result = $obj_product->MJ_gmgt_get_single_product($product_id);

			}

			?>

			<div class="panel-body padding_0"><!--PANEL BODY DIV START-->

				<form name="product_form" action="" method="post" class="form-horizontal" id="product_form" enctype="multipart/form-data"><!--PRODUCT FORM START-->

					<?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>

					<input type="hidden" name="action" id="product_action" value="<?php echo esc_html($action);?>">

					<input type="hidden" name="product_id" id="product_id" value="<?php echo esc_html($product_id);?>"  />

					<div class="header">	

						<h3 class="first_hed"><?php esc_html_e('Product Information','gym_mgt');?></h3>

					</div>

					<div class="form-body user_form"> <!-- user_form Strat-->   

						<div class="row"><!--Row Div Strat--> 

							<div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 input">

								<label class="ml-1 custom-top-label top" for="staff_name"><?php esc_html_e('Product Category','gym_mgt');?><span class="require-field">*</span></label>

								<select class="form-control validate[required] "  name="product_category" id="product_category">

									<option value=""><?php esc_html_e('Select Product Category','gym_mgt');?></option>

									<?php 				

									if(isset($_REQUEST['product_category']))

									{

										$category =esc_attr($_REQUEST['product_category']);  

									}

									elseif($edit)

									{

										$category =$result->product_cat_id;

									}

									else

									{ 

										$category = "";

									}

									$product_category=MJ_gmgt_get_all_category('product_category');

									if(!empty($product_category))

									{

										foreach ($product_category as $retrive_data)

										{

											echo '<option value="'.esc_attr($retrive_data->ID).'" '.selected(esc_attr($category),esc_attr($retrive_data->ID)).'>'.esc_html($retrive_data->post_title).'</option>';

										}

									}

									?>				

								</select>

							</div>

							<div class="col-sm-12 col-md-2 col-lg-2 col-xl-2 mb-3">				

								<button id="addremove" class="btn save_btn" model="product_category"><?php esc_html_e('Add','gym_mgt');?></button>

							</div>

							<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

								<div class="form-group input">

									<div class="col-md-12 form-control">

										<input id="product_name" class="form-control validate[required,custom[onlyLetter_specialcharacter]] text-input" maxlength="50" type="text" value="<?php if($edit){ echo esc_attr($result->product_name);}elseif(isset($_POST['product_name'])) echo esc_attr($_POST['product_name']);?>" name="product_name">

										<label class="" for="member_id"><?php esc_html_e('Product Name','gym_mgt');?><span class="require-field">*</span></label>

									</div>

								</div>

							</div>

							<?php wp_nonce_field( 'save_product_nonce' ); ?>

							<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

								<div class="form-group input">

									<div class="col-md-12 form-control">

										<input id="product_price" class="form-control validate[required] text-input"  min="0"  step="0.01" onkeypress="if(this.value.length==10) return false;" type="number" value="<?php if($edit){ echo esc_attr($result->price);}elseif(isset($_POST['product_price'])) echo esc_attr($_POST['product_price']);?>" name="product_price">

										<label class="" for="member_id"><?php esc_html_e('Product Price','gym_mgt');?>(<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?>)<span class="require-field">*</span></label>

									</div>

								</div>

							</div>

							<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

								<div class="form-group input">

									<div class="col-md-12 form-control">

										<input id="group_name" class="form-control validate[required,custom[onlyNumberSp]] text-input" min="0" onkeypress="if(this.value.length==4) return false;" type="number" value="<?php if($edit){ echo esc_attr($result->quentity);}elseif(isset($_POST['quentity'])) echo esc_attr($_POST['quentity']);?>" name="quentity">

										<label class="" for="member_id"><?php esc_html_e('Product Quantity','gym_mgt');?><span class="require-field">*</span></label>

									</div>

								</div>

							</div>

							<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

								<div class="form-group input">

									<div class="col-md-12 form-control">

										<input id="product_sku_number"  class="form-control validate[required,custom[popup_category_validation]] text-input" maxlength="20" type="text" value="<?php if($edit){ echo esc_attr($result->sku_number);}elseif(isset($_POST['sku_number'])) echo esc_attr($_POST['sku_number']);?>" name="sku_number">

										<label class="" for="member_id"><?php esc_html_e('SKU Number','gym_mgt');?><span class="require-field">*</span></label>

									</div>

								</div>

							</div>

							<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

								<div class="form-group input">

									<div class="col-md-12 form-control">

										<input class="form-control validate[custom[popup_category_validation]] text-input" maxlength="50" type="text" value="<?php if($edit){ echo esc_attr($result->manufacture_company_name);}elseif(isset($_POST['manufacture_company_name'])) echo esc_attr($_POST['manufacture_company_name']);?>" name="manufacture_company_name">

										<label class="" for="member_id"><?php esc_html_e('Manufacturer Company Name','gym_mgt');?></label>

									</div>

								</div>

							</div>

							<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

								<div class="form-group input">

									<div class="col-md-12 form-control">

										<input id="manufacture_date" class="form-control manufacture_date date_picker" type="text"  name="manufacture_date" value="<?php if($edit){  if($result->manufacture_date!='0000-00-00' || $result->manufacture_date == '1970-01-01') { echo esc_attr(MJ_gmgt_getdate_in_input_box($result->manufacture_date)); } }?>" readonly>

										<label class="date_label" for="member_id"><?php esc_html_e('Manufacturer Date','gym_mgt');?></label>

									</div>

								</div>

							</div>

							<div class="col-md-6 note_text_notice">

								<div class="form-group input">

									<div class="col-md-12 note_border margin_bottom_15px_res">

										<div class="form-field">

											<textarea name="product_description" class="textarea_height_47px form-control validate[custom[address_description_validation]]" maxlength="150"><?php if($edit){ echo trim(esc_textarea($result->product_description));}elseif(isset($_POST['product_description'])) echo esc_textarea($_POST['product_description']);?></textarea>

											<span class="txt-title-label"></span>

											<label class="text-area address active" for="notice_content"><?php esc_html_e('Product Description','gym_mgt');?></label>

										</div>

									</div>

								</div>

							</div>

							<div class="col-md-6 note_text_notice">

								<div class="form-group input">

									<div class="col-md-12 note_border margin_bottom_15px_res">

										<div class="form-field">

											<textarea name="product_specification" class="textarea_height_47px form-control validate[custom[address_description_validation]]" maxlength="150"><?php if($edit){ echo trim(esc_textarea($result->product_specification));}elseif(isset($_POST['product_specification'])) echo esc_textarea($_POST['product_specification']);?></textarea>

											<span class="txt-title-label"></span>

											<label class="text-area address active" for="notice_content"><?php esc_html_e('Product Specification','gym_mgt');?></label>

										</div>

									</div>

								</div>

							</div>

							<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

								<div class="form-group input">

									<div class="col-md-12 form-control upload-profile-image-frontend">	

										<label class="custom-control-label custom-top-label ml-2" for="photo"><?php esc_html_e('Image','gym_mgt');?></label>

										<div class="col-sm-12">

											<input type="text" id="gmgt_user_avatar_url" class="form-control display_none" class="form-control" name="product_image" readonly value="<?php if($edit)echo esc_url( $result->product_image );elseif(isset($_POST['product_image'])) echo esc_url($_POST['product_image']); ?>" />	

											<input type="hidden" name="hidden_upload_user_avatar_image" value="<?php if($edit){ echo esc_url($result->product_image);}elseif(isset($_POST['product_image'])) echo esc_url($_POST['product_image']);?>">	

											<input id="upload_user_avatar_image" class="image-preview-show" name="product_image" onchange="MJ_gmgt_fileCheck(this);" type="file" class="form-control file" value="<?php esc_html_e( 'Upload image', 'gym_mgt' ); ?>" />

										</div>

									</div>

									<div class="clearfix"></div>

									<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">

										<div id="upload_user_avatar_preview" >

											<?php 

											if($edit) 

											{

												if($result->product_image == "")

												{ ?>

													<img class="image_preview_css" src="<?php echo get_option( 'gmgt_Product_logo' ); ?>">

												<?php 

												}

												else

												{

												?>

													<img class="image_preview_css" src="<?php if($edit)echo esc_url( $result->product_image ); ?>" />

												<?php 

												}

											}

											else 

											{

												?>

												<img class="image_preview_css" src="<?php echo get_option( 'gmgt_Product_logo' ); ?>">

												<?php 

											}

											?>

										</div>

									</div>

								</div>

							</div>

						</div>

					</div>

					<div class="form-body user_form"> <!-- user_form Strat-->   

						<div class="row"><!--Row Div Strat--> 

							<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

								<input type="submit" id="product_save_btn" value="<?php if($edit){ esc_html_e('Save','gym_mgt'); }else{ esc_html_e('Save','gym_mgt');}?>" name="save_product" class="btn save_btn save_product"/>

							</div>

						</div>

					</div>

				</form><!--PRODUCT FORM END-->

			</div><!--PANEL BODY DIV END-->

			<?php 

		}

		?>

	</div><!-- TAB CONTENT DIV END-->

</div><!-- PANEL BODY DIV END-->

<script type="text/javascript">

function MJ_gmgt_fileCheck(obj)

{

	var fileExtension = ['jpeg', 'jpg', 'png', 'bmp',''];

	if ($.inArray($(obj).val().split('.').pop().toLowerCase(), fileExtension) == -1)

	{

		alert("<?php esc_html_e('Sorry, only JPG, JPEG, PNG & GIF And BMP files are allowed.','gym_mgt');?>");

		$(obj).val('');

	}	

}

</script>