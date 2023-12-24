<?php

//Selected CLASS DATA Delete

$obj_guest_booking = new MJ_gmgt_guest_booking;

if(isset($_REQUEST['delete_selected_booking_list']))

{

	if(!empty(esc_attr($_REQUEST['selected_id'])))

	{

		foreach($_REQUEST['selected_id'] as $id)

		{

			$delete_class=$obj_guest_booking->MJ_gmgt_delete_guest_booking($id);

			if($delete_class)

			{

				wp_redirect ( admin_url().'admin.php?page=gmgt_class&tab=guest_list&message=5');

			}

		}

	}

	else

	{

		echo '<script language="javascript">';

		echo 'alert("'.esc_html__('Please select at least one record.','gym_mgt').'")';

		echo '</script>';

	}

}

if($active_tab == 'guest_list')

{

	$obj_guest_booking = new MJ_gmgt_guest_booking;

	$bookingdata=$obj_class->MJ_gmgt_get_all_booked_class();

	$guestbookingdata=$obj_guest_booking->MJ_gmgt_get_all_guest_booking();

	if(!empty($guestbookingdata))

	{

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

		<script type="text/javascript">

			$(document).ready(function() 

			{

				"use strict";

				jQuery('.booking_list').DataTable({

					// "responsive": true,

					//"order": [[ 2, "desc" ]],

					dom: 'lifrtp',

					// buttons: [

					// 	'colvis',

					// 	{

					// extend: 'print',

					// title: '<?php esc_html_e( 'Guest Booking List', 'gym_mgt' ) ;?>',

					// exportOptions: {

					// 		columns: [ 0, 1, 2,3, 4]

					// 	},

					// },

					// 	{

					// extend: 'pdfHtml5',

					// title: '<?php esc_html_e( 'Guest Booking List', 'gym_mgt' ) ;?>',

					// exportOptions: {

					// 		columns: [ 0, 1, 2,3, 4]

					// 	},

					// }

					// ],

					"aoColumns":[

								{"bSortable": false},

								{"bSortable": false},

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

				$(".delete_selected_booking_list").on('click', function()

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

		<form name="wcwm_report" action="" method="post">

			<div class="panel-body padding_0"> <!-- PANEL BODY DIV START-->

				<div class="table-responsive"> <!-- TABLE RESPONSIVE DIV START-->

					<table id="booking_list113" class="display booking_list" cellspacing="0" width="100%"> <!-- Booking LIST TABEL START-->

						<thead class="<?php echo MJ_gmgt_datatable_heder(); ?>">

							<tr>

								<th class="padding_0"><input type="checkbox" class="select_all"></th>

								<th><?php esc_html_e('Photo','gym_mgt');?></th>

								<th><?php esc_html_e('Guest Name','gym_mgt');?></th>

								<th><?php esc_html_e('Email ID','gym_mgt');?></th>

								<th><?php esc_html_e('Phone','gym_mgt');?></th>

								<th><?php esc_html_e('Booking Date','gym_mgt');?></th>

								<th class="text_align_end"><?php esc_html_e('Action','gym_mgt');?></th>            

							</tr>

						</thead>

						<tbody>

							<?php 

							// $obj_guest_booking = new MJ_gmgt_guest_booking;

							// $bookingdata=$obj_class->MJ_gmgt_get_all_booked_class();

							// $guestbookingdata=$obj_guest_booking->MJ_gmgt_get_all_guest_booking();

							if(!empty($guestbookingdata))

							{

								$i=0;

								foreach ($guestbookingdata as $retrieved_data)

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

										<td class="checkbox_width_10px">

											<input type="checkbox" name="selected_id[]" class="smgt_sub_chk sub_chk select-checkbox" value="<?php echo esc_attr($retrieved_data->guest_id); ?>">

										</td>

										<td class="user_image width_50px profile_image_prescription padding_left_0">	

											<p class="prescription_tag padding_15px margin_bottom_0px <?php echo $color_class; ?>">	

												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/Class Schedule.png"?>" alt="" class="massage_image center image_icon_height_25px margin_top_3px">

											</p>

										</td>

										<td class="membername">

											<a href="#"><?php echo esc_html($retrieved_data->first_name).' '.esc_html($retrieved_data->last_name);?></a>

											<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Guest Name','gym_mgt');?>" ></i>

										</td>

										<td class="emailid">

											<?php echo esc_html($retrieved_data->email_id);  ?>

											<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Email Id','gym_mgt');?>" ></i>

										</td>

										<td class="phonenumber">

											<?php echo esc_html($retrieved_data->phone_number); ?>

											<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Phone','gym_mgt');?>" ></i>

										</td>

										<td class="date">

											<?php echo esc_html(MJ_gmgt_getdate_in_input_box($retrieved_data->created_date)); ?>

											<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Booking Date','gym_mgt');?>" ></i>

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

																<a href="?page=gmgt_class&tab=guest_list&action=delete&guest_id=<?php echo esc_attr($retrieved_data->guest_id);?>" class="float_left_width_100 list_delete_btn" onclick="return confirm('<?php esc_html_e('Are you sure you want to delete this record?','gym_mgt');?>');"><i class="fa fa-trash"></i> <?php esc_html_e('Delete','gym_mgt');?> 

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

							}?>     

						</tbody>        

					</table><!-- Booking LIST TABEL END-->

					<!-------- Delete And Select All Button ----------->

					<div class="print-button pull-left">

						<button class="btn btn-success btn-sms-color">

							<input type="checkbox" name="id[]" class="select_all" value="<?php echo esc_attr($retrieved_data->ID); ?>" style="margin-top: 0px;">

							<label for="checkbox" class="margin_right_5px"><?php esc_html_e( 'Select All', 'gym_mgt' ) ;?></label>

						</button>

						<?php 

						if($user_access_delete =='1')

						{ ?>

							<button data-toggle="tooltip"  id="delete_selected" title="<?php esc_html_e('Delete Selected','gym_mgt');?>" name="delete_selected_booking_list" class="delete_selected delete_selected_booking_list" ><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Delete.png" ?>" alt=""></button>

							<?php 

						} 

						?>

					</div>

					<!-------- Delete And Select All Button ----------->

				</div><!-- TABLE RESPONSIVE DIV END-->

			</div><!-- PANEL BODY DIV END-->

		</form><!-- CLASS LIST FORM END-->

		<?php 

	}

	else

	{

		?>

		<div class="calendar-event-new"> 

			<img class="no_data_img" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/no_data_img.png"?>" >

		</div>

		<!-- <div class="no_data_list_div"> 

			<a href="<?php echo admin_url().'admin.php?page=gmgt_class&tab=addclass';?>">

				<img class="width_100px" src="<?php echo get_option( 'gmgt_no_data_img' ) ?>" >

			</a>

			<div class="col-md-12 dashboard_btn margin_top_20px">

				<label class="no_data_list_label"><?php esc_html_e('Tap on above icon to add your first Record.','gym_mgt'); ?> </label>

			</div> 

		</div>  -->

		<?php

	}

}

?>