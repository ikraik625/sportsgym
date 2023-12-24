<?php 	

if($active_tab == 'view-activity')

{        	

	$membership_id=0;

	if(isset($_REQUEST['membership_id']))

	$membership_id=esc_attr($_REQUEST['membership_id']);

	$activity_result = $obj_membership->MJ_gmgt_get_membership_activities($membership_id);

	if(!empty($activity_result))

	{	

		?>	

		<script type="text/javascript">

			$(document).ready(function() 

			{

				"use strict";

				$('#activity_id').multiselect();

				$('#acitivity_form').validationEngine({{promptPosition : "bottomLeft",maxErrorsPerField: 1});	

			} );

		</script>	
		<script type="text/javascript">

			$(document).ready(function()

			{

				"use strict";

				jQuery('#activity_list_123').DataTable(

				{

					// "responsive": true,

					"order": [[ 1, "asc" ]],

					dom: 'lifrtp',

					"aoColumns":[

								{"bSortable": false},

								{"bSortable": true},

								{"bSortable": true},
								{"bSortable": true},

								{"bSortable": true},

								{"bSortable": false}],

						language:<?php echo MJ_gmgt_datatable_multi_language();?>			  

				});

				$('.dataTables_filter input').attr("placeholder", "<?php esc_html_e('Search...', 'gym_mgt') ?>");

			} );

		</script>
		<form name="wcwm_report" action="" method="post">   <!--ACTIVITY LIST FORM START--> 

			<div class="panel-body padding_0"><!--PANEL BODY DIV START-->

				<div class="table-responsive"><!--TABLE RESPONSIVE DIV START-->

					<table id="activity_list_123" class="display" cellspacing="0" width="100%"><!--ACTIVITY LIST TABLE START-->

						<thead>

							<tr>

								<th><?php esc_html_e('Photo','gym_mgt');?></th>

								<th><?php esc_html_e('Activity Name','gym_mgt');?></th>

								<th><?php esc_html_e('Activity Category','gym_mgt');?></th>

								<th><?php esc_html_e('Activity Trainer','gym_mgt');?></th>

								<th><?php esc_html_e('Membership Name','gym_mgt');?></th>

								<th><?php esc_html_e('Action','gym_mgt');?></th>

							</tr>

						</thead>			 

						<tfoot>

							<tr>

								<th><?php esc_html_e('Photo','gym_mgt');?></th>

								<th><?php esc_html_e('Activity Name','gym_mgt');?></th>

								<th><?php esc_html_e('Activity Category','gym_mgt');?></th>

								<th><?php esc_html_e('Activity Trainer','gym_mgt');?></th>

								<th><?php esc_html_e('Membership Name','gym_mgt');?></th>

								<th><?php esc_html_e('Action','gym_mgt');?></th>

							</tr>

						</tfoot>			 

						<tbody>

							<?php 

							if(!empty($activity_result))

							{		

								$i=0;					 

								foreach ($activity_result as $activities)

								{ 	

									if(!empty($retrieved_data->video_entry))
									{
										$video_data=json_decode($retrieved_data->video_entry);
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

									$retrieved_data=$obj_activity->MJ_gmgt_get_single_activity($activities->activity_id);?>

									<tr>

										<td class="user_image width_50px profile_image_prescription padding_left_0">	

											<p class="prescription_tag padding_15px margin_bottom_0px <?php echo $color_class; ?>">	

												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/Activity.png"?>" alt="" class="massage_image center image_icon_height_25px margin_top_3px">

											</p>

										</td>

										<td class="activityname">

											<a href="?page=gmgt_activity&tab=addactivity&action=edit&activity_id=<?php echo esc_attr($retrieved_data->activity_id);?>"><?php echo esc_html($retrieved_data->activity_title);?></a>

											<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Activity Name','gym_mgt');?>" ></i>

										</td>

										<td class="category">

											<?php echo get_the_title(esc_html($retrieved_data->activity_cat_id));?>

											<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Activity Category','gym_mgt');?>" ></i>

										</td>

										<td class="productquentity">

											<?php $user=get_userdata(($retrieved_data->activity_assigned_to)); 

												if(isset($user->display_name))

												{

													echo esc_html($user->display_name);

												}

												else

												{

													echo "N/A";

												}	

											?>

											<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Activity Trainer','gym_mgt');?>" ></i>

										</td>

										<td class="membership">

											<?php echo MJ_gmgt_get_membership_name(esc_html($activities->membership_id));?>

											<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Membership Name','gym_mgt');?>" ></i>

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

																<a href="?page=gmgt_membership_type&tab=membershiplist&action=delete-activity&membership_id=<?php echo esc_attr($membership_id);?>&assign_id=<?php echo esc_attr($activities->id);?>"  class="float_left_width_100 list_delete_btn" onclick="return confirm('<?php esc_html_e('Are you sure you want to delete this record?','gym_mgt');?>');">

																<i class="fa fa-trash"></i> <?php esc_html_e( 'Delete', 'gym_mgt' ) ;?>

																</a>

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

							}

							?>			 

						</tbody>        

					</table><!--ACTIVITY LIST TABLE END-->

				</div><!--TABLE RESPONSIVE DIV END-->

			</div><!--PANEL BODY DIV END-->       

		</form>  <!--ACTIVITY LIST FORM END -->   

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

?>