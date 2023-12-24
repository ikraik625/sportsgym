<?php ?>

<div class="mailbox-content padding_0"><!--MAILBOX CONTENT DIV STRAT-->

	<?php 

		$message = MJ_gmgt_get_inbox_message(get_current_user_id());

		$max = 10;

		if(isset($_GET['pg']))

		{

			$p = $_GET['pg'];

		}

		else

		{

			$p = 1;

		}

		$limit = ($p - 1) * $max;

		$prev = $p - 1;

		$next = $p + 1;

		$limits = (int)($p - 1) * $max;

		$totlal_message =count($message);

		$totlal_message = ceil($totlal_message / $max);

		$lpm1 = $totlal_message - 1;

		$offest_value = ($p-1) * $max;

		echo MJ_gmgt_admininbox_pagination($totlal_message,$p,$lpm1,$prev,$next);



		$message = MJ_gmgt_get_inbox_message(get_current_user_id(),$limit,$max);

		if(!empty($message))

		{

			?>

			<script type="text/javascript">

				jQuery(document).ready(function($) 

				{

					"use strict";

					$('#inbox_list').DataTable({

						responsive: true,

						"dom": 'lifrtp',

						"order": [[ 2, "asc" ]],

						"sSearch": "<i class='fa fa-search'></i>",

						"aoColumns":[		                  

							{"bSortable": false},	                 

							{"bSortable": true},

							{"bSortable": true},

							{"bSortable": true},

							// {"bSortable": true},

							{"bSortable": true},	                  

							{"bSortable": false}],

							language:<?php echo MJ_gmgt_datatable_multi_language();?>

					});

					$('.dataTables_filter input').attr("placeholder", "<?php esc_html_e('Search...', 'gym_mgt') ?>");

				} );

			</script>

			<form name="wcwm_report" action="" method="post"><!-- form-div -->

				<div class="table-responsive" id="sentbox_table"><!-- table-responsive  -->	



					<table id="inbox_list" class="display" cellspacing="0" width="100%" ><!--INBOX TABLE STRAT-->
						<thead class="<?php echo MJ_gmgt_datatable_heder(); ?>">
							<tr> 
								<th><?php esc_html_e('Photo','gym_mgt');?></th>		
								<th><span><?php esc_html_e('Message From','gym_mgt');?></span></th>
								<th><?php esc_html_e('Subject','gym_mgt');?></th>
								<th><?php esc_html_e('Description','gym_mgt');?></th>
								<th><?php esc_html_e('Attachment','gym_mgt');?></th>
								<th><?php esc_html_e('Date','gym_mgt');?></th>
							</tr>
						</thead>
						<tbody>

							<?php

							//GET INBOX MESSAGE

							// $message = MJ_gmgt_get_inbox_message(get_current_user_id(),$limit,$max);

						

							if(!empty($message))

							{

								$i=0;	

								foreach($message as $msg)

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

									$attchment = get_post_meta( $msg->post_id, 'message_attachment',true);

									?>

									<tr> 			

										<td class="user_image width_50px profile_image_prescription padding_left_0">	

											<p class="prescription_tag padding_15px margin_bottom_0px <?php echo $color_class; ?>">	

												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/inbox_icon.png"?>" alt="" class="massage_image center image_icon_height_25px margin_top_3px">

											</p>

										</td>

										<td class="">

											<?php echo MJ_gmgt_get_display_name(esc_html($msg->sender));?>

											<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Message From','gym_mgt');?>" ></i>

										</td>

										<td class="">

											<a href="?page=Gmgt_message&tab=inbox&tab=view_message&from=inbox&id=<?php echo esc_attr($msg->message_id);?>" class="gmgt_inbox_tab"> 

												<?php 

												$subject_char=strlen($msg->subject);

												if($subject_char <= 25)

												{

													echo esc_html($msg->subject);

												}

												else

												{

													$char_limit = 25;

													$subject_body= substr(strip_tags($msg->subject), 0, $char_limit)."...";

													echo esc_html($subject_body);

												}

												

												if(MJ_gmgt_count_reply_item($msg->post_id)>=1)

												{

													?><span class="gmgt_inbox_count_number badge badge-success pull-right">

														<?php echo MJ_gmgt_count_reply_item($msg->post_id);?>

													</span><?php

												} ?>

											</a>

											<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Subject','gym_mgt');?>" ></i>

										</td>

										<td class="">			

											<?php 

											$body_char=strlen($msg->message_body);

											if($body_char <= 60)

											{

												echo esc_html($msg->message_body);

											}

											else

											{

												$char_limit = 60;

												$msg_body= substr(strip_tags($msg->message_body), 0, $char_limit)."...";

												echo esc_html($msg_body);

											}

											?>

											<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Description','gym_mgt');?>" ></i>

										</td>

										<td>

											<?php			

											if(!empty($attchment))

											{

												$attchment_array=explode(',',$attchment);

												foreach($attchment_array as $attchment_data)

												{

													?>

													<a target="blank" href="<?php echo content_url().'/uploads/gym_assets/'.$attchment_data; ?>" ><i class="fa fa-eye"></i><?php esc_html_e('View Attachment','gym_mgt');?></a>

													<?php

												}

											}

											else

											{

												?>

												<a href="#">N/A</a>

												<?php

											}

											?>

											<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Attachment','gym_mgt');?>" ></i>

										</td>

										<td class="date_mess">

											<?php  echo  MJ_gmgt_getdate_in_input_box($msg->date);?>

											<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Date','gym_mgt');?>" ></i>

										</td>

									</tr>

									<?php 

									$i++;

								}

							}

							?> 		

						</tbody>

					</table><!--INBOX TABLE END-->



				</div><!-- table-responsive  -->	

			</form><!-- form-div -->

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

		?>

 </div><!--MAILBOX CONTENT DIV END-->

 <?php ?>