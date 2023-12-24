<?php ?>

<script type="text/javascript">

$(document).ready(function() 
{promptPosition : "bottomLeft"
{

	"use strict";

	$('#group_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});

});

</script>

<?php

if($active_tab == 'schedulelist')

{

$obj_virtual_classroom = new MJ_gmgt_virtual_classroom;

?>

<div class="popup-bg z_index_100000">

    <div class="overlay-content">

		<div class="modal-content">

		   <div class="create_meeting_popup"></div>

		</div>

    </div> 

</div>



	<div class="panel-body padding_0 class_border_div gmgt_schedule_table rtl_margin_top_15px"><!-- PANEL BODY DIV START-->

		<table class="table table-bordered"><!-- TABLE CLASS SCHEDULE START-->

			<?php		   

			foreach(MJ_gmgt_days_array() as $daykey => $dayname)

			{

				?>

				<tr>

					<th width="100"><?php echo esc_html($dayname);?></th>

					<td>

						 <?php

							$period = $obj_class->MJ_gmgt_get_schedule_byday($daykey);

							if(!empty($period))

							{

								foreach($period as $period_data)

								{

									if(!empty($period_data))

									{

										echo '<div class="btn-group m-b-sm dropdownschedulelist_new">';

										echo '<button id="dropdownschedulelist" data-toggle="dropdown"  class="btn btn-primary class_list_button dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" ><span class="period_box" id='.esc_attr($period_data['class_id']).'>'.MJ_gmgt_get_single_class_name($period_data['class_id']);

										echo '<span class="time"> ('.MJ_gmgt_timeremovecolonbefoream_pm($period_data['start_time']).' - '.MJ_gmgt_timeremovecolonbefoream_pm($period_data['end_time']).') </span>';

										echo '</span></span><span class="caret"></span></button>';

										echo '<ul role="menu" class="dropdown-menu" aria-labelledby="dropdownschedulelist">

											<li><a href="?page=gmgt_class&tab=addclass&action=edit&class_id='.$period_data['class_id'].'">'.esc_html__('Edit','gym_mgt').'</a></li>

											<li><a href="?page=gmgt_class&tab=schedulelist&action=delete&class_id='.$period_data['class_id'].'&daykey='.$daykey.'" onclick="return confirm(\''.esc_html__( 'Are you sure, you want to delete this time slot?', 'gym_mgt' ).'\');">'.esc_html__('Delete','gym_mgt').'</a></li>';

												if (get_option('gmgt_enable_virtual_classschedule') == 'yes')

												{

													// echo '<li><a href="#" id="'.$period_data['class_id'].'" class="show-popup">'.__('Create Virtual Class','gym_mgt').'</a></li>';

												 	$meeting_data = $obj_virtual_classroom->MJ_gmgt_get_singal_meeting_by_class_data_in_zoom($period_data['class_id']);

													if(empty($meeting_data))

													{

														echo '<li><a href="#" id="'.$period_data['class_id'].'" class="show-popup">'.esc_html__('Create Virtual Class','gym_mgt').'</a></li>';

													}

													else

													{

														$create_meeting = '';

													}



													if(!empty($meeting_data))

													{

														echo  '<li><a href="admin.php?page=gmgt_virtual_class&tab=edit_meeting&action=edit&meeting_id='.$meeting_data->meeting_id.'">'.esc_html__('Edit Virtual Class','gym_mgt').'</a></li>';

														echo '<li><a href="admin.php?page=gmgt_virtual_class&tab=meeting_list&action=delete&meeting_id='.$meeting_data->meeting_id.'" onclick="return confirm(\''.esc_html__( 'Are you sure you want to delete this record?', 'gym_mgt' ).'\');">'.esc_html__('Delete Virtual Class','gym_mgt').'</a></li>';

														echo '<li><a href="'.$meeting_data->meeting_start_link.'" target="_blank">'.esc_html__('Virtual Class Start','gym_mgt').'</a></li>';

													}

													else

													{

														$update_meeting = '';

														$delete_meeting = '';

														$meeting_statrt_link = '';

													}	

												}

										'</ul>';

										echo '</div>';

									}	

								}

							}

						 ?>

					</td>

				</tr>

			<?php	

			}

			?>

        </table><!-- TABLE CLASS SCHEDULE END-->

    </div><!-- PANEL BODY DIV END-->

<?php 

}

?>