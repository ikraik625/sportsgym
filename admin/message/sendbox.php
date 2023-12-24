<div class="mailbox-content padding_0"><!--MAILBOX CONTENT DIV STRAT-->

	<?php 

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

		$totlal_message = MJ_gmgt_count_send_item(get_current_user_id());

		$totlal_message = ceil($totlal_message / $max);

		$lpm1 = $totlal_message - 1;               	

		$offest_value = ($p-1) * $max;

		echo MJ_gmgt_pagination($totlal_message,$p,$lpm1,$prev,$next);



		//GET SENDBOX DATA

		$offset = 0;

		if(isset($_REQUEST['pg']))

		{

			$offset = esc_attr($_REQUEST['pg']);

		}

		$message = MJ_gmgt_get_send_message(get_current_user_id(),$max,$offset);

		if(!empty($message))

		{

			?>

			<script type="text/javascript">

				jQuery(document).ready(function($) 

				{

					"use strict";

					$('#sent_list').DataTable({

						// responsive: true,

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

				<div class="table-responsive" id="sentbox_table"><!-- table-responsive -->



					<table id="sent_list" class="display" cellspacing="0" width="100%" ><!--SENDBOX TABLE STRAT-->
						
						<thead class="<?php echo MJ_gmgt_datatable_heder(); ?>">
							<tr> 
								<th><?php esc_html_e('Photo','gym_mgt');?></th>
								<th><span><?php esc_html_e('Message For','gym_mgt');?></span></th>
								<th><span><?php esc_html_e('Class','gym_mgt');?></span></th>
								<th><?php esc_html_e('Subject','gym_mgt');?></th>
								<th><?php esc_html_e('Description','gym_mgt');?></th>
								<th><?php esc_html_e('Attachment','gym_mgt');?></th>
							</tr>
						</thead>
						<tbody>

							<?php 

							$i=0;	

							foreach($message as $msg_post)

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

								if($msg_post->post_author==get_current_user_id())

								{

									?>

									<tr>

										<td class="user_image width_50px profile_image_prescription padding_left_0">	

											<p class="prescription_tag padding_15px margin_bottom_0px <?php echo $color_class; ?>">	

												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/sendbox_icon.png"?>" alt="" class="massage_image center image_icon_height_25px margin_top_3px">

											</p>

										</td>

										<td class="">

											<?php 

											if(get_post_meta( $msg_post->ID, 'message_for',true) == 'user')

											{

												echo MJ_gmgt_get_user_full_display_name(get_post_meta( $msg_post->ID, 'message_gmgt_user_id',true));

											}

											else

											{							

												$rolename=get_post_meta( $msg_post->ID, 'message_for',true);

												echo MJ_gmgt_GetRoleName($rolename);

											}

											?>

											<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Message For','gym_mgt');?>" ></i>

										</td>

										<td class="">

											<?php

												if(get_post_meta( $msg_post->ID, 'gmgt_class_id',true) !="" && get_post_meta( $msg_post->ID, 'gmgt_class_id',true) == 'all')

												{

													esc_html_e('All','gym_mgt');

												}

												elseif(get_post_meta( $msg_post->ID, 'gmgt_class_id',true) !="")

												{

													echo MJ_gmgt_get_class_name(get_post_meta( $msg_post->ID, 'gmgt_class_id',true)); 

												}

												else

												{

													esc_html_e('N/A','gym_mgt');

												}

											?>

											<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Class','gym_mgt');?>" ></i>

										</td>

										

										<td>

											<a href="?page=Gmgt_message&tab=view_message&from=sendbox&id=<?php echo  esc_attr($msg_post->ID);?>" class="gmgt_inbox_tab">

												<?php

													$subject_char=strlen($msg_post->post_title);

													if($subject_char <= 25)

													{

														echo esc_html($msg_post->post_title);

													}

													else

													{

														$char_limit = 25;

														$subject_body= substr(strip_tags($msg_post->post_title), 0, $char_limit)."...";

														echo esc_html($subject_body);

													}

												?>

												<?php 

												if(MJ_gmgt_count_reply_item($msg_post->ID)>=1)

												{ ?>

													<span class="gmgt_inbox_count_number badge badge-success pull-right">

														<?php echo MJ_gmgt_count_reply_item($msg_post->ID);?>

													</span>

													<?php 

												} ?>

											</a>

											<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Subject','gym_mgt');?>" ></i>

										</td>

										<td>

											<?php 	

											$body_char=strlen($msg_post->post_content);

											if($body_char <= 60)

											{

												echo esc_html($msg_post->post_content);

											}

											else

											{

												$char_limit = 60;

												$msg_body= substr(strip_tags($msg_post->post_content), 0, $char_limit)."...";

												echo esc_html($msg_body);

											}				

											?>

											<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Description','gym_mgt');?>" ></i>

										</td>

										<td>

											<?php

											$attchment=get_post_meta($msg_post->ID,'message_attachment',true);

											if(!empty($attchment))

											{

												$attchment_array=explode(',',$attchment);

												foreach($attchment_array as $attchment_data)

												{

												?>

													<a target="blank" class="btn btn-defult border_gym" href="<?php echo content_url().'/uploads/gym_assets/'.$attchment_data; ?>" ><i class="fa fa-download"></i><?php esc_html_e('View Attachment','gym_mgt');?></a>

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

									</tr>

									<?php 

									$i++;

								}

							}

							?>			

						</tbody>

					</table><!--SENDBOX TABLE END-->

				</div><!-- table-responsive  -->	

			</form><!-- form-div -->

			<?php

		}

		else

		{

			?>

			<div class="no_data_list_div mt-3"> 

				<a href="<?php echo admin_url().'admin.php?page=Gmgt_message&tab=compose	';?>">

					<img class="width_100px" src="<?php echo get_option( 'gmgt_no_data_img' ) ?>" >

				</a>

				<div class="col-md-12 dashboard_btn margin_top_20px margin_top_12p">

					<label class="no_data_list_label"><?php esc_html_e('Tap on above icon to add your first Record.','gym_mgt'); ?> </label>

				</div> 

			</div>		

			<?php

		}

		?>

</div><!--MAILBOX CONTENT DIV END-->