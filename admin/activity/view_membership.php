<script type="text/javascript">

$(document).ready(function() 

{	

	"use strict";

	jQuery('#membership_list').DataTable({

		// "responsive": true,

		dom: 'lifrtp',

		"order": [[ 2, "asc" ]],

		"aoColumns":[

	                  {"bSortable": false},

	                  {"bSortable": true},

	                  {"bSortable": true},

	                  {"bSortable": true},

	                  {"bSortable": true},

	                  {"bSortable": true}],

			language:<?php echo MJ_gmgt_datatable_multi_language();?>			  

		});

		$('.dataTables_filter input').attr("placeholder", "<?php esc_html_e('Search...', 'gym_mgt') ?>");

});

</script>

<form name="wcwm_report" action="" method="post"> <!-- MEMBERSHIP LIST FORM START-->   

    <div class="panel-body padding_0"><!-- PANEL BODY DIV START-->   

        <div class="table-responsive"><!-- TABLE RESPONSIVE DIV START-->   

			<table id="membership_list" class="display" cellspacing="0" width="100%"><!-- TABLE MEMBERSHIP START-->   

				<thead>

					<tr id="height_50">

						<th id="width_50"><?php esc_html_e('Photo','gym_mgt');?></th>

						<th><?php esc_html_e('Membership Name','gym_mgt');?></th>

						<th><?php esc_html_e('Membership Amount','gym_mgt');?></th>

					  	<th><?php esc_html_e('Membership Period (Days)','gym_mgt');?></th>

					  	<th><?php esc_html_e('Installment Plan','gym_mgt');?></th>

						<th><?php esc_html_e('Signup Fee','gym_mgt');?></th>

					</tr>

				</thead>

				<tfoot>

					<tr>

						<th><?php esc_html_e('Photo','gym_mgt');?></th>

						<th><?php esc_html_e('Membership Name','gym_mgt');?></th>

						<th><?php esc_html_e('Membership Amount','gym_mgt');?></th>

					  	<th><?php esc_html_e('Membership Period (Days)','gym_mgt');?></th>

					  	<th><?php esc_html_e('Installment Plan','gym_mgt');?></th>

						<th><?php esc_html_e('Signup Fee','gym_mgt');?></th>              

					</tr>

				</tfoot>

				<tbody>

				 	<?php 

				 	if(isset($_REQUEST['activity_id']))

					$activity_id=esc_attr($_REQUEST['activity_id']);

					$activity_membership_list = $obj_activity->MJ_gmgt_get_activity_membership($activity_id);

				 	if(!empty($activity_membership_list))

				 	{

						foreach ($activity_membership_list as $retrieved_data)

						{

							$obj_membership=new MJ_gmgt_membership;

							$membership_data = $obj_membership->MJ_gmgt_get_single_membership($retrieved_data);

							if(!empty($membership_data))

							{

								?>

								<tr>

									<td class="user_image width_50px padding_left_0">

										<?php 

										$userimage=$membership_data->gmgt_membershipimage;

										if(empty($userimage))

										{

											echo '<img src='.get_option('gmgt_Membership_logo').' height="50px" width="50px" class="img-circle" />';

										}

										else

										{

											echo '<img src='.$userimage.' height="50px" width="50px" class="img-circle"/>';

										}

										?>

									</td>

									<td class="membershipname">

										<a href="?page=gmgt_membership_type&tab=addmembership&action=edit&membership_id=<?php echo esc_attr($membership_data->membership_id);?>"><?php echo esc_html($membership_data->membership_label);?></a>

										<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Membership Name','gym_mgt');?>" ></i>

									</td>

									<td class="">

										<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?> <?php echo $membership_data->membership_amount; ?>

										<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Membership Amount','gym_mgt');?>" ></i>

									</td>

									<td class="membershiperiod">

										<?php echo esc_html($membership_data->membership_length_id);?>

										<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Membership Period (Days)','gym_mgt');?>" ></i>

									</td>

									<td class="installmentplan">

										<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?> <?php echo esc_html($membership_data->installment_amount)." ".get_the_title( $membership_data->install_plan_id );?>

										<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Installment Plan','gym_mgt');?>" ></i>

									</td>

									<td class="signup_fee">

										<?php echo MJ_gmgt_get_currency_symbol(get_option('gmgt_currency_code')); ?><?php echo esc_html($membership_data->signup_fee);?>

										<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Signup Fee','gym_mgt');?>" ></i>

									</td>

								</tr>

								<?php 

							}

					

						}

					}

				?>  

				</tbody>        

			</table><!-- TABLE MEMBERSHIP END-->   

        </div><!-- TABLE RESPONSIVE DIV END-->   

	</div><!-- PANEL BODY DIV END-->   

</form><!-- MEMBERSHIP LIST FORM END-->   