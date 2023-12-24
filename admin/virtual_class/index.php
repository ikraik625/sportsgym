<?php

require_once GMS_PLUGIN_DIR. '/lib/vendor/autoload.php';

$obj_virtual_classroom = new MJ_gmgt_virtual_classroom;

$active_tab = isset($_GET['tab'])?$_GET['tab']:'meeting_list';

// EDIT MEETING IN ZOOM

if(isset($_POST['edit_meeting']))

{

	$nonce = $_POST['_wpnonce'];

	if ( wp_verify_nonce( $nonce, 'edit_meeting_admin_nonce' ) )

	{

		$result = $obj_virtual_classroom->MJ_gmgt_create_meeting_in_zoom($_POST);

		if($result)

		{

			wp_redirect ( admin_url().'admin.php?page=gmgt_virtual_class&tab=meeting_list&message=2');

		}		

	}

}

// DELETE STUDENT IN ZOOM

if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')

{

	$result= $obj_virtual_classroom->MJ_gmgt_delete_meeting_in_zoom($_REQUEST['meeting_id']);

	if($result)

	{

		wp_redirect ( admin_url().'admin.php?page=gmgt_virtual_class&tab=meeting_list&message=3');

	}

}

/*Delete selected Subject*/

if(isset($_REQUEST['delete_selected']))

{		

	if(!empty($_REQUEST['id']))

	{

		foreach($_REQUEST['id'] as $meeting_id)

		{

			$result= $obj_virtual_classroom->MJ_gmgt_delete_meeting_in_zoom($meeting_id);

		}

	}

	if($result)

	{

		wp_redirect ( admin_url().'admin.php?page=gmgt_virtual_class&tab=meeting_list&message=3');

	}

}

?>

<!-- POP up code -->

<div class="popup-bg">

    <div class="overlay-content">

	    <div class="modal-content">

		    <div class="view_meeting_detail_popup">

		    </div>

		</div>

	</div>

</div>

<script type="text/javascript">

$(document).ready(function() {

	var table =  jQuery('#meeting_list').DataTable(

	{

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

						{"bSortable": false}],

		language:<?php echo MJ_gmgt_datatable_multi_language();?>	

	});	

	$('.dataTables_filter input').attr("placeholder", "<?php esc_html_e('Search...', 'gym_mgt') ?>");

    $('#checkbox-select-all').on('click', function(){

     

    var rows = table.rows({ 'search': 'applied' }).nodes();

      $('input[type="checkbox"]', rows).prop('checked', this.checked);

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

	 $("#delete_selected").on('click', function()

	{	

		if ($('.select-checkbox:checked').length == 0 )

		{

			alert("<?php esc_html_e('Please select atleast one record','gym_mgt');?>");

			return false;

		}

		else{

			var alert_msg=confirm("<?php esc_html_e('Are you sure you want to delete this record?','gym_mgt');?>");

			if(alert_msg == false)

			{

				return false;

			}

			else

			{

				return true;

			}

		}

	});



   });  

</script>

<!-- End POP-UP Code -->

<div class="page-inner min_height_1631"><!--PAGE INNER DIV STRAT-->

	<div  id="" class="class_list gms_main_list" >

		<?php

		$message = isset($_REQUEST['message'])?$_REQUEST['message']:'0';

		switch($message)

		{

			case '1':

				$message_string = esc_html__('Virtual Class Added Successfully.','gym_mgt');

				break;

			case '2':

				$message_string = esc_html__('Virtual Class Updated Successfully.','gym_mgt');

				break;

			case '3':

				$message_string = esc_html__('Virtual Class Deleted Successfully.','gym_mgt');

				break;

			case '4':

				$message_string = esc_html__('Your Access Token Is Updated.','gym_mgt');

				break;

			case '5':

				$message_string = esc_html__('Something Wrong.','gym_mgt');

				break;

			case '6':

				$message_string = esc_html__('First Start Your Virtual Class.','gym_mgt');

				break;

		}

		

		if($message)

		{ 

			?>

			<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">

				<p><?php echo $message_string;?></p>

				<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>

			</div>

			<?php 

		} 

		?>

		

		<div class="panel-body padding_0">		

			<?php

			if($active_tab == 'meeting_list')

			{	

				$meeting_list_data = $obj_virtual_classroom->MJ_gmgt_get_all_meeting_data_in_zoom();

				if(!empty($meeting_list_data))

				{

					?>	

					<div class="panel-body padding_0">

						<form name="wcwm_report" action="" method="post"><!--SELL Product LIST FORM START-->

							<div class="table-responsive">

								<table id="meeting_list" class="display" cellspacing="0" width="100%">

									<thead class="<?php echo MJ_gmgt_datatable_heder(); ?>">
										<tr>
											<th><input name="select_all" value="all" id="checkbox-select-all" type="checkbox" /></th>
											<th><?php esc_html_e('Photo','gym_mgt');?></th>
											<th><?php esc_html_e('Class Name','gym_mgt');?></th>
											<th><?php esc_html_e('Staff Member','gym_mgt');?></th>
											<th><?php esc_html_e('Day','gym_mgt');?></th>
											<th><?php esc_html_e('Start To End Date','gym_mgt');?></th>
											<th><?php esc_html_e('Start Time To End Time','gym_mgt');?></th>
											<th><?php esc_html_e('Topic','gym_mgt');?></th>
											<th class="text_align_end"><?php esc_html_e('Action','gym_mgt');?></th>
										</tr>
									</thead>
									<tbody>

										<?php 

										$i=0;

										foreach ($meeting_list_data as $retrieved_data)

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

												<td class="title"><input type="checkbox" class="smgt_sub_chk sub_chk select-checkbox" name="id[]" value="<?php echo $retrieved_data->meeting_id;?>"></td>

												<td class="user_image width_50px profile_image_prescription padding_left_0">	

													<p class="prescription_tag padding_15px margin_bottom_0px <?php echo $color_class; ?>">	

														<img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/White_Icons/Virtual_class.png"?>" alt="" class="massage_image center image_icon_height_25px margin_top_3px">

													</p>

												</td>

												<td><?php echo $retrieved_data->title;?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Class Name','gym_mgt');?>" ></td>

												<td><?php echo  MJ_gmgt_get_display_name($retrieved_data->staff_id); ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Staff Member','gym_mgt');?>" ></td>

												<td style="width: 10%;">

													<?php 

													echo $retrieved_data->weekdays; 

													?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Day','gym_mgt');?>" >
												</td>

												<td><?php echo MJ_gmgt_getdate_in_input_box($retrieved_data->start_date); ?> <?php echo _e("To","gym_mgt") ?> <?php echo MJ_gmgt_getdate_in_input_box($retrieved_data->end_date); ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Start To End Date','gym_mgt');?>" ></td>

												<td><?php echo $retrieved_data->start_time; ?> <?php echo _e("To","gym_mgt") ?> <?php echo $retrieved_data->end_time; ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Start Time To End Time','gym_mgt');?>" ></td>

												<td>

													<?php

													if(!empty($retrieved_data->agenda))

													{

														$strlength= strlen($retrieved_data->agenda);

														if($strlength > 50)

															echo substr($retrieved_data->agenda, 0,30).'...';

														else

															echo $retrieved_data->agenda;

													}

													else

													{

														echo "N/A";

													}

													?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Topic','gym_mgt');?>" >

												</td>

												<td class="action"> 

													<div class="gmgt-user-dropdown">

														<ul class="" style="margin-bottom: 0px !important;">

															<li class="">

																<a class="" href="#" data-bs-toggle="dropdown" aria-expanded="false">

																	<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/More.png"?>" >

																</a>

																<ul class="dropdown-menu heder-dropdown-menu action_dropdawn" aria-labelledby="dropdownMenuLink">

																	<li class="float_left_width_100">

																		<a href="#" class="show-popup float_left_width_100" meeting_id="<?php echo $retrieved_data->meeting_id; ?>"><i class="fa fa-eye" aria-hidden="true"></i> <?php esc_html_e('View', 'gym_mgt' ) ;?></a>

																	</li>

																	<?php

																	$date=date("Y-m-d");										

																	if($retrieved_data->end_date >= $date)

																	{

																		?>

																		<li class="float_left_width_100">

																			<a href="<?php echo $retrieved_data->meeting_start_link;?>" class="float_left_width_100" target="_blank"><i class="fa fa-video-camera" aria-hidden="true"></i> <?php esc_html_e('Start Virtual Class', 'gym_mgt' ) ;?></a>

																		</li>

																		<?php

																	}

																	?>

																	<li class="float_left_width_100">

																		<a href="?page=gmgt_virtual_class&tab=view_past_participle_list&action=view&meeting_uuid=<?php echo $retrieved_data->uuid;?>" class="float_left_width_100"><i class="fa fa-eye" aria-hidden="true"></i> <?php esc_html_e('View Past Participle', 'gym_mgt' ) ;?></a>

																	</li>

																	<li class="float_left_width_100 border_bottom_item">

																		<a href="?page=gmgt_virtual_class&tab=edit_meeting&action=edit&meeting_id=<?php echo $retrieved_data->meeting_id;?>" class=" float_left_width_100"><i class="fa fa-edit" aria-hidden="true"></i> <?php esc_html_e('Edit', 'gym_mgt' ) ;?></a>

																	</li>

																	<li class="float_left_width_100">

																		<a href="?page=gmgt_virtual_class&tab=meeting_list&action=delete&meeting_id=<?php echo $retrieved_data->meeting_id;?>" class="float_left_width_100 list_delete_btn" onclick="return confirm('<?php esc_html_e('Are you sure you want to delete this record?','gym_mgt');?>');"><i class="fa fa-trash"></i> <?php esc_html_e( 'Delete', 'gym_mgt' ) ;?> </a>

																	</li>

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

								</table>

								<div class="print-button pull-left">

									<button class="btn btn-success btn-sms-color">

										<input type="checkbox" name="id[]" class="select_all" value="<?php echo esc_attr($retrieved_data->ID); ?>" style="margin-top: 0px;">

										<label for="checkbox" class="margin_right_5px"><?php esc_html_e( 'Select All', 'gym_mgt' ) ;?></label>

									</button>

									<button data-toggle="tooltip"  id="delete_selected" title="<?php esc_html_e('Delete Selected','gym_mgt');?>" name="delete_selected" class="delete_selected" ><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Delete.png" ?>" alt=""></button>

								</div>

							</div>

						</form>

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

			if($active_tab == 'edit_meeting')

			{

				require_once GMS_PLUGIN_DIR. '/admin/virtual_class/edit_meeting.php';

			}

			elseif($active_tab == 'view_past_participle_list')

			{

				require_once GMS_PLUGIN_DIR. '/admin/virtual_class/view_past_participle_list.php';

			}

			?>

		</div>

		

	</div>

</div>