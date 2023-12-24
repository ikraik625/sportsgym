<?php 

$role=MJ_gmgt_get_roles(get_current_user_id());

if($role == 'administrator')

{

	$user_access_view=1;

}

else

{

	$user_access=MJ_gmgt_get_userrole_wise_manually_page_access_right_array_for_management('report');

	$user_access_view=$user_access['view'];

	if (isset ( $_REQUEST ['page'] ))

	{	

		if($user_access_view=='0')

		{	

			MJ_gmgt_access_right_page_not_access_message_for_management();

			die;

		}

	}

}

$active_tab=isset($_REQUEST['tab'])?$_REQUEST['tab']:'membership_report';

?>

<script type="text/javascript">

$(document).ready(function() 

{

	"use strict";

	$.datepicker.setDefaults($.datepicker.regional['<?php echo MJ_gmgt_get_current_lan_code(); ?>']);

	$('.sdate').datepicker({dateFormat: '<?php echo get_option('gmgt_datepicker_format');?>'});

	$('.edate').datepicker({dateFormat: '<?php echo get_option('gmgt_datepicker_format');?>'});

} );

</script>

<div class="page-inner min_height_1631"><!--PAGE INNER DIV START-->

	<div class="gms_main_list"><!-- MAIN_LIST_MARGING_15px START -->

	

		<div class="row"><!--ROW DIV START-->

			<div class="col-md-12 padding_0"><!--COL 12 DIV START-->

				<div class="panel-body"><!--PANEL BODY DIV START-->
					<?php 
					if($active_tab !='membership_report' && $active_tab !='attendance_report' && $active_tab !='member_information' && $active_tab !='user_log'  && $active_tab !='audit_trail')
					{
						?>
						<ul class="nav nav-tabs panel_tabs margin_left_1per" role="tablist"><!-- NAV TAB WRAPPER MENU START-->
							<?php 
							if($active_tab=='member_information')
							{
								?>
								<li class="<?php if($active_tab=='member_information'){?>active<?php }?>">

									<a href="?page=gmgt_report&tab=member_information" class="padding_left_0 tab <?php echo $active_tab == 'member_information' ? 'nav-tab-active' : ''?>">

									<?php echo esc_html__('Member Information', 'gym_mgt'); ?></a>

								</li>
								<?php
							} ?>
							<?php 
							if($active_tab=='membership_report')
							{
								?>
								<li class="<?php if($active_tab=='membership_report'){?>active<?php }?>">

									<a href="?page=gmgt_report&tab=membership_report&tab1=membership_report" class="padding_left_0 tab <?php echo $active_tab == 'membership_report' ? 'nav-tab-active' : ''?>">

									<?php echo esc_html__('Membership', 'gym_mgt'); ?></a>

								</li>
								<?php
							} ?>
							<?php 
							if($active_tab=='attendance_report')
							{
								?>
								<li class="<?php if($active_tab=='attendance_report'){?>active<?php }?>">

									<a href="?page=gmgt_report&tab=attendance_report&tab1=report_graph" class="padding_left_0 tab <?php echo $active_tab == 'attendance_report' ? 'nav-tab-active' : ''?>">

									<?php echo esc_html__('Attendance', 'gym_mgt'); ?></a>

								</li>
								<?php
							} ?>
							
							<!-- <li class="<?php if($active_tab=='member_status_report'){?>active<?php }?>">

								<a href="?page=gmgt_report&tab=member_status_report" class="padding_left_0 tab <?php echo $active_tab == 'member_status_report' ? 'nav-tab-active' : ''?>">

								<?php echo esc_html__('Membership Status', 'gym_mgt'); ?></a>

							</li> -->
							<?php 
							if($active_tab=='payment_report' || $active_tab=='feepayment_report')
							{
								?>
								<li class="<?php if($active_tab=='payment_report'){?>active<?php }?>">

									<a href="?page=gmgt_report&tab=payment_report&tab1=report_graph" class="padding_left_0 tab <?php echo $active_tab == 'payment_report' ? 'nav-tab-active' : ''?>">

									<?php echo esc_html__('Income & Expense Payment', 'gym_mgt'); ?></a>

								</li>
								<?php
							} ?>
							<?php 
							if($active_tab=='payment_report' || $active_tab=='feepayment_report')
							{
								?>
								<li class="<?php if($active_tab=='feepayment_report'){?>active<?php }?>">

									<a href="?page=gmgt_report&tab=feepayment_report&tab1=report_graph" class="padding_left_0 margin_top_ipad_10 <?php echo $active_tab == 'feepayment_report' ? 'nav-tab-active' : ''?>">

									<?php echo esc_html__('Membership Payment', 'gym_mgt'); ?></a>

								</li>
								<?php
							} ?>
							<?php 
							if($active_tab=='sell_product_report')
							{
								?>
								<li class="<?php if($active_tab=='sell_product_report'){?>active<?php }?>">

									<a href="?page=gmgt_report&tab=sell_product_report&tab1=report_graph" class="padding_left_0 margin_top_ipad_10 <?php echo $active_tab == 'sell_product_report' ? 'nav-tab-active' : ''?>">

									<?php echo esc_html__('Sale Product', 'gym_mgt'); ?></a>

								</li>
								<?php
							} ?>
						</ul><!-- NAV TAB WRAPPER MENU END-->
						<?php
					} ?>

					<div class="clearfix"></div>

					<?php 

					if($active_tab == 'membership_report')

						require_once GMS_PLUGIN_DIR. '/admin/report/membership_report.php';

					if($active_tab == 'attendance_report')

						require_once GMS_PLUGIN_DIR. '/admin/report/attendance_report.php';

					// if($active_tab == 'member_status_report')

					// 	require_once GMS_PLUGIN_DIR. '/admin/report/membership_status_report.php';

					if($active_tab == 'payment_report')

						require_once GMS_PLUGIN_DIR. '/admin/report/income_report.php';

					if($active_tab == 'feepayment_report')

						require_once GMS_PLUGIN_DIR. '/admin/report/feepayment_report.php';

					if($active_tab == 'sell_product_report')

						require_once GMS_PLUGIN_DIR. '/admin/report/sell_product_report.php';

					if($active_tab == 'expense_report')

						require_once GMS_PLUGIN_DIR. '/admin/report/expense_report.php';						

					if($active_tab == 'member_information')

						require_once GMS_PLUGIN_DIR. '/admin/report/member_information.php';
						
					if($active_tab == 'user_log')

						require_once GMS_PLUGIN_DIR. '/admin/report/user_log.php';		
						
					if($active_tab == 'audit_trail')

						require_once GMS_PLUGIN_DIR. '/admin/report/audit_trail.php';		


					?>

				</div><!--PANEL BODY DIV END-->

			</div><!--COL 12 DIV END-->

		</div><!--ROW DIV END-->

    </div><!--MAIN WRAPPER DIV END-->

</div><!--PAGE INNER DIV END-->