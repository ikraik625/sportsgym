<script type="text/javascript">

$(document).ready(function()

{

	"use strict";

	jQuery('#measurement_list').DataTable({

		"order": [[ 0, "asc" ]],

		"aoColumns":[

	                  {"bSortable": true},

	                  {"bSortable": true},

	                  {"bSortable": true},

	                  {"bSortable": true},	                 

	                  {"bSortable": false}],

				language:<?php echo MJ_gmgt_datatable_multi_language();?>		  

		});

} );

</script>

<div class="panel-body"><!--PANEL BODY DIV STRAT-->

    <div class="table-responsive"><!--TABLE RESPONSIVE  DIV STRAT-->

        <table id="measurement_list" class="display" cellspacing="0" width="100%"><!--Measurement LIST TABLE STRAT-->

        	<thead>

				<tr>

					<th><?php esc_html_e('Member Name','gym_mgt');?></th>

					<th><?php esc_html_e('Measurement','gym_mgt');?></th>

					<th><?php esc_html_e('Result','gym_mgt');?></th>			

					<th><?php esc_html_e('Record Date','gym_mgt');?></th>			

					<th><?php esc_html_e('Action','gym_mgt');?></th>

				</tr>

			</thead> 

			<tfoot>

				<tr>

					<th><?php esc_html_e('Member Name','gym_mgt');?></th>

					<th><?php esc_html_e('Measurement','gym_mgt');?></th>

					<th><?php esc_html_e('Result','gym_mgt');?></th>			

					<th><?php esc_html_e('Record Date','gym_mgt');?></th>			

					<th><?php esc_html_e('Action','gym_mgt');?></th>

				</tr>

			</tfoot>			

			<tbody>

			<?php 

			//GET ALL Measurement DATA

			$measurement_data=$obj_workout->MJ_gmgt_get_all_measurement();

			if(!empty($measurement_data))

			{

				foreach ($measurement_data as $retrieved_data)

				{

					?>

					<tr>

						<td class="workoutname">

						<?php $user=get_userdata($retrieved_data->user_id);

						$display_label = MJ_gmgt_get_member_full_display_name_with_memberid(esc_html($retrieved_data->user_id));

						$memberid=get_user_meta($retrieved_data->user_id,'member_id',true);

							if($display_label)
							{


								echo esc_html($display_label);

							}

							?>

						</td>

						<td class="recorddate"><?php echo esc_html($retrieved_data->result_measurment);?></td>

						<td class="duration"><?php echo esc_html($retrieved_data->result);?></td>

						<td class="result"><?php echo esc_html($retrieved_data->result_date);?></td>

						<td class="action">

							<a href="?page=gmgt_workout&tab=addmeasurement&action=edit&measurment_id=<?php echo esc_attr($retrieved_data->measurment_id)?>" class="btn btn-info"> <?php esc_html_e('Edit','gym_mgt');?></a>

							<a href="?page=gmgt_workout&tab=measurement_list&action=delete&measurment_id=<?php echo esc_attr($retrieved_data->measurment_id);?>" class="btn btn-danger" onclick="return confirm('<?php esc_html_e('Are you sure you want to delete this record?','gym_mgt');?>');"><?php esc_html_e('Delete','gym_mgt');?> </a>

						</td>

					</tr>

					<?php 

				}

			}

			?>

			</tbody>

        </table><!--Measurement LIST TABLE END-->

    </div><!--TABLE RESPONSIVE DIV END-->

</div><!--PANEL BODY DIV END-->