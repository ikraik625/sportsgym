<?php 

$obj_product=new MJ_gmgt_product;

$active_tab = isset($_GET['tab'])?$_GET['tab']:'productlist';

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

	$user_access=MJ_gmgt_get_userrole_wise_manually_page_access_right_array_for_management('product');

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

			if ('product' == $user_access['page_link'] && ($_REQUEST['action']=='edit'))

			{

				if($user_access_edit=='0')

				{	

					MJ_gmgt_access_right_page_not_access_message_for_management();

					die;

				}			

			}

			if ('product' == $user_access['page_link'] && ($_REQUEST['action']=='delete'))

			{

				if($user_access_delete=='0')

				{	

					MJ_gmgt_access_right_page_not_access_message_for_management();

					die;

				}	

			}

			if ('product' == $user_access['page_link'] && ($_REQUEST['action']=='insert'))

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

			<div class="category_list"></div>     

		</div>

    </div>    

</div>

<!-- End POP-UP Code -->

<div class="page-inner min_height_1631"><!--PAGE INNER DIV STRAT-->

	<?php 

	//SAVE PRODUCT DATA

	if(isset($_POST['save_product']))

	{

		$nonce = $_POST['_wpnonce'];

		if (wp_verify_nonce( $nonce, 'save_product_nonce' ) )

		{

		$txturl=esc_url_raw($_POST['product_image']);

		$ext=MJ_gmgt_check_valid_extension($txturl);

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

						$result=$obj_product->MJ_gmgt_add_product($_POST,$_POST['product_image']);

						if($result)

						{

							wp_redirect ( admin_url().'admin.php?page=gmgt_product&tab=productlist&message=2');

						}								

					}
				}
					

			}

			else

			{				

				$data=$obj_product->MJ_gmgt_get_all_product_by_name(sanitize_text_field($_POST['product_name']));

				$data1=$obj_product->MJ_gmgt_get_all_product_by_sku_number(sanitize_text_field($_POST['sku_number']));

				$data2=$obj_product->MJ_gmgt_get_all_product_by_name_and_sku_number(sanitize_text_field($_POST['product_name']),sanitize_text_field($_POST['sku_number']));

				if(empty($data2))

				{
					if(empty($data) && empty($data1))

					{
						$result=$obj_product->MJ_gmgt_add_product($_POST,$_POST['product_image']);

						if($result)

						{

							wp_redirect ( admin_url().'admin.php?page=gmgt_product&tab=productlist&message=1');

						}
					}
				}

			}

		}			

		else

		{ ?>

			<div id="message" class="updated below-h2 ">

			<p>

				<?php esc_html_e('Sorry, only JPG, JPEG, PNG & GIF And BMP files are allowed.','gym_mgt');?>

			</p></div>				 

			<?php 

		}	

	}

	}

	//DELETE Product DATA

	if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')

	{

		$result=$obj_product->MJ_gmgt_delete_product(esc_attr($_REQUEST['product_id']));

		if($result)

		{

			wp_redirect ( admin_url().'admin.php?page=gmgt_product&tab=productlist&message=3');

		}

	}

	//DELETE SELECTED Product DATA

	if(isset($_REQUEST['delete_selected']))

	{		

		if(!empty($_REQUEST['selected_id']))

		{

			foreach($_REQUEST['selected_id'] as $id)

			{

				$delete_product=$obj_product->MJ_gmgt_delete_product($id);

			}

			if($delete_product)

			{

				wp_redirect ( admin_url().'admin.php?page=gmgt_product&tab=productlist&message=3');

			}

		}

		else

		{

			echo '<script language="javascript">';

			echo 'alert("'.esc_html__('Please select at least one record.','gym_mgt').'")';

			echo '</script>';

		}

	}



	//export Member in csv

	if(isset($_POST['export_csv']))

	{	

		foreach($_POST['selected_id'] as $p_id)

		{

			$productdata[]=$obj_product->MJ_gmgt_get_single_product($p_id);

		}

		

		/*  var_dump($member_list);

		die; */ 

		

		if(!empty($productdata))

		{

			$header = array();			

			$header[] = 'product_name';

			$header[] = 'sku_number';

			$header[] = 'product_cat';

			$header[] = 'price';

			$header[] = 'quantity';

			$header[] = 'manufacture_company_name';			

			$header[] = 'manufacture_date';

			$header[] = 'product_description';				

			$header[] = 'product_specification';

			

			$document_dir = WP_CONTENT_DIR;

			$document_dir .= '/uploads/export/';

			$document_path = $document_dir;

			if (!file_exists($document_path))

			{

				mkdir($document_path, 0777, true);		

			}

			

			$filename=$document_path.'productlist.csv';

			$fh = fopen($filename, 'w') or die("can't open file");

			fputcsv($fh, $header);

			foreach($productdata as $retrive_data)

			{



				$row = array();

				

				$row[] = $retrive_data->product_name;

				$row[] = $retrive_data->sku_number;			

				$row[] = get_the_title($retrive_data->product_cat_id);	

				$row[] = $retrive_data->price;

				$row[] = $retrive_data->quentity;

				$row[] = $retrive_data->manufacture_company_name;

				$row[] = $retrive_data->manufacture_date;

				$row[] = $retrive_data->product_description;

				$row[] = $retrive_data->product_specification;



							

								

				fputcsv($fh, $row);	

			}

			fclose($fh);

			//download csv file.

			ob_clean();

			$file=$document_path.'productlist.csv';//file location

			

			$mime = 'text/plain';

			header('Content-Type:application/force-download');

			header('Pragma: public');       // required

			header('Expires: 0');           // no cache

			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');

			header('Last-Modified: '.gmdate ('D, d M Y H:i:s', filemtime ($file)).' GMT');

			header('Cache-Control: private',false);

			header('Content-Type: '.$mime);

			header('Content-Disposition: attachment; filename="'.basename($file).'"');

			header('Content-Transfer-Encoding: binary');			

			header('Connection: close');

			readfile($file);		

			exit;				

		}

		else

		{

			?>

			<div class="alert_msg alert alert-danger alert-dismissible fade in" role="alert">

				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>

				</button>

				<?php esc_html_e('Records not found.','gym_mgt');?>

			</div>

			<?php	

		}		

	}





	//upload booklist csv	

	if(isset($_REQUEST['upload_csv_file']))

	{		

		if(isset($_FILES['csv_file']))

		{				

			$errors= array();

			$file_name = $_FILES['csv_file']['name'];

			$file_size =$_FILES['csv_file']['size'];

			$file_tmp =$_FILES['csv_file']['tmp_name'];

			$file_type=$_FILES['csv_file']['type'];			

			$value = explode(".", $_FILES['csv_file']['name']);

			$file_ext = strtolower(array_pop($value));

			$extensions = array("csv");

			$upload_dir = wp_upload_dir();

			if(in_array($file_ext,$extensions )=== false)

			{

				$errors[]="this file not allowed, please choose a CSV file.";

				wp_redirect ( admin_url().'admin.php?page=gmgt_product&tab=productlist&message=10');

			}

			if($file_size > 2097152)

			{

				$errors[]='File size limit 2 MB';

				wp_redirect ( admin_url().'admin.php?page=gmgt_product&tab=productlist&message=11');

			}			

			if(empty($errors)==true)

			{	

				$rows = array_map('str_getcsv', file($file_tmp));		

				$header = array_map('strtolower',array_shift($rows));

				

				$csv = array();

				foreach ($rows as $row) 

				{

					$csv = array_combine($header, $row);

					

					if(isset($csv['product_name']))

						$productdata['product_name']=$csv['product_name'];

					if(isset($csv['price']))

						$productdata['price']=$csv['price'];

					if(isset($csv['quantity']))

						$productdata['quentity']=$csv['quantity'];

					if(isset($csv['sku_number']))

						$productdata['sku_number']=$csv['sku_number'];

				

					$productdata['manufacture_company_name']=$csv['manufacture_company_name'];							

				

					$productdata['manufacture_date']=$csv['manufacture_date'];							

					

					$productdata['product_description']=$csv['product_description'];

					$productdata['created_by']=get_current_user_id();

					$productdata['created_date']=date('Y-m-d');

					

					if(isset($csv['product_cat']))

					{

						global $wpdb;

						$posttitle=$csv['product_cat'];

						$model='product_category';

						$post = $wpdb->get_row( "SELECT * FROM $wpdb->posts WHERE post_title = '".$posttitle."' AND  post_type ='". $model."'" );

						if(isset($post) && $postname=$post->post_title)

						{

							$productdata['product_cat_id']=$post->ID;

						}

						else 

						{

							global $wpdb;

							$result = wp_insert_post( array(



									'post_status' => 'publish',



									'post_type' => 'product_category',



									'post_title' => MJ_gmgt_strip_tags_and_stripslashes($csv['product_cat']) ));



							$id = $wpdb->insert_id;



							$productdata['product_cat_id']=$id;

						}

					}

					

					



					global $wpdb;

					$table_gmgt_product = $wpdb->prefix. 'gmgt_product';

					$all_prodocut = $wpdb->get_results("SELECT * FROM $table_gmgt_product");	

					$product_name=array();

					$product_isbn=array();

					

					foreach ($all_prodocut as $product_data) 

					{

						$product_name[]=$product_data->product_name;

						$product_sku_number[]=$product_data->sku_number;

					}

					

					if (in_array($productdata['product_name'], $product_name) && in_array($productdata['sku_number'], $product_sku_number))

					{

						$import_product_name=$productdata['product_name'];

						$import_sku_number=$productdata['sku_number'];

						

						$existing_product_data = $wpdb->get_row("SELECT id FROM $table_gmgt_product where product_name='$import_product_name' AND sku_number='$import_sku_number'");



						$id['id']=$existing_product_data->id;

												

						$wpdb->update( $table_gmgt_product, $productdata,$id);	

						

						$success = 1;	

					}

					else

					{ 	

						$result=$wpdb->insert( $table_gmgt_product, $productdata );	

						

						$success = 1;	

					}	

				}

			}

			else

			{

				foreach($errors as &$error) echo $error;

			}

			

			if(isset($success))

			{			

				wp_redirect ( admin_url().'admin.php?page=gmgt_product&tab=productlist&message=12');

			} 

		}

	}





	if(isset($_REQUEST['message']))

	{

		$message =esc_attr($_REQUEST['message']);

		if($message == 1)

		{?>

			<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">

				<p><?php esc_html_e('Product added successfully.','gym_mgt');?></p>

				<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>

			</div>

		<?php	

		}

		elseif($message == 2)

		{?>

			<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">

				<p><?php esc_html_e("Product updated successfully.",'gym_mgt');?></p>

				<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>

			</div>

		<?php	

		}

		elseif($message == 3) 

		{?>

			<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">

					<p><?php esc_html_e('Product deleted successfully.','gym_mgt');?></p>

				<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>

			</div>

		<?php		

		}

		elseif($message == 10) 

		{ ?>

			<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">

					<p><?php esc_html_e('Only CSV file are allow.','gym_mgt');?></p>

				<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>

			</div>

		<?php

		}

		elseif($message == 11) 

		{?>

			<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">

					<p><?php esc_html_e('File size limit 2 MB allow.','gym_mgt');?></p>

				<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>

			</div>

		<?php

		}

		elseif($message == 12) 

		{?>

			<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">

					<p><?php esc_html_e('Product Imported Successfully.','gym_mgt');?></p>

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

						if($active_tab == 'productlist')

						{ 

							$productdata=$obj_product->MJ_gmgt_get_all_product();

							if(!empty($productdata))

							{

								?>	

								<script type="text/javascript">

									$(document).ready(function() 

									{

										"use strict";

										jQuery('#product_list').DataTable({

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

									} );

								</script>

								<form name="wcwm_report" action="" method="post"><!--PRODUCT LIST FORM START-->

									<div class="panel-body padding_0"><!--PANEL BODY DIV START-->		

										<div class="table-responsive"><!--TABLE RESPONSIVE START-->		

											<table id="product_list" class="display" cellspacing="0" width="100%"><!--PRODUCT LIST  TABLE START-->	
												<thead class="<?php echo MJ_gmgt_datatable_heder(); ?>">
													<tr>
														<th class="padding_0"><input type="checkbox" class="select_all"></th>
														<th><?php esc_html_e('Photo','gym_mgt');?></th>
														<th><?php esc_html_e('Product Name','gym_mgt');?></th>
														<th><?php esc_html_e('SKU Number','gym_mgt');?></th>
														<th><?php esc_html_e('Product Category','gym_mgt');?></th>
														<th><?php esc_html_e('Product Price','gym_mgt');?></th>
														<th><?php esc_html_e('Product Quantity','gym_mgt');?></th>
														<th class="text_align_end"><?php esc_html_e('Action','gym_mgt');?></th>
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

																<td class="title checkbox_width_10px "><input type="checkbox" name="selected_id[]" class="smgt_sub_chk sub_chk select-checkbox" value="<?php echo esc_attr($retrieved_data->id); ?>"></td>

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

																<td class="productname"><a href="?page=gmgt_product&tab=addproduct&action=edit&product_id=<?php echo esc_attr($retrieved_data->id);?>"><?php echo esc_html($retrieved_data->product_name);?></a> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Product Name','gym_mgt');?>" ></i></td>

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

																					if($user_access_edit == '1')

																					{

																						?>	

																						<li class="float_left_width_100 border_bottom_item">

																							<a href="?page=gmgt_product&tab=addproduct&action=edit&product_id=<?php echo esc_attr($retrieved_data->id)?>" class="float_left_width_100"><i class="fa fa-edit"></i> <?php esc_html_e('Edit', 'gym_mgt' ) ;?></a>

																						</li>

																						<?php

																					}															

																					if($user_access_delete =='1')

																					{ 

																						?>

																						<li class="float_left_width_100">

																							<a href="?page=gmgt_product&tab=productlist&action=delete&product_id=<?php echo esc_attr($retrieved_data->id);?>" class="float_left_width_100 list_delete_btn" onclick="return confirm('<?php esc_html_e('Are you sure you want to delete this record?','gym_mgt');?>');"><i class="fa fa-trash"></i><?php esc_html_e( 'Delete', 'gym_mgt' ) ;?> </a>

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

													}

													?>

												</tbody>

											</table><!--PRODUCT LIST  TABLE END-->

											<!-------- Delete And Select All Button ----------->

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

												<button data-toggle="tooltip" type="submit"  title="<?php esc_html_e('Export CSV','gym_mgt');?>" name="export_csv" type="button" class="member_csv_export_alert view_csv_popup export_import_csv_btn padding_0"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/export_csv.png" ?>" alt=""></button>

												<button data-toggle="tooltip"  title="<?php esc_html_e('Import CSV','gym_mgt');?>" name="import_csv" type="button" class="importdata export_import_csv_btn padding_0"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/import_csv.png" ?>" alt=""></button>

											

											</div>

											<!-------- Delete And Select All Button ----------->

										</div><!--TABLE RESPONSIVE DIV END-->

									</div><!--PANEL BODY DIV END-->

								</form><!--PRODUCT LIST FORM END-->

								<?php 

							}

							else

							{
								if($user_access_add == 1)
								{
									?>

										<div class="no_data_list_div row"> 

											<div class="offset-md-2 col-md-4">

												<a href="<?php echo admin_url().'admin.php?page=gmgt_product&tab=addproduct';?>">

													<img class="width_100px" src="<?php echo get_option( 'gmgt_no_data_img' ) ?>" >

												</a>

												<div class="col-md-12 dashboard_btn margin_top_20px">

													<label class="no_data_list_label"><?php esc_html_e('Tap on above icon to add your first Record.','gym_mgt'); ?> </label>

												</div> 

											</div>
									
											<div class="col-md-4">

												<a data-toggle="tooltip"  name="import_csv" type="button" class="importdata">
													
													<img src="<?php echo GMS_PLUGIN_URL."/assets/images/thumb_icon/Import_list.png" ?>" alt="">
												
												</a>

												<div class="col-md-12 dashboard_btn margin_top_20px">

													<label class="no_data_list_label"><?php esc_html_e('Tap on above icon to import CSV.','gym_mgt'); ?> </label>
												
												</div> 
												
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

						if($active_tab == 'addproduct')

						{

							require_once GMS_PLUGIN_DIR. '/admin/product/add_product.php';

						}

						?>

					</div><!--PANEL BODY DIV END-->							

				</div><!--PANEL WHITE DIV END-->

			</div><!--COL 12 DIV END-->

		</div><!--ROW DIV END-->

	</div><!--MAIN WRAPPER DIV END-->

</div><!--PAGE INNER DIV END-->