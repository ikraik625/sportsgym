<?php 

error_reporting(0);

$active_tab = isset($_GET['tab'])?$_GET['tab1']:'report_graph';

?>

<script type="text/javascript">

$(document).ready(function() 

{

	"use strict";

	$.datepicker.setDefaults($.datepicker.regional['<?php echo MJ_gmgt_get_current_lan_code(); ?>']);

	$('.sdate1').datepicker({dateFormat: '<?php echo get_option('gmgt_datepicker_format');?>',

			maxDate : 0,

	}); 

	$('.edate1').datepicker({dateFormat: '<?php echo get_option('gmgt_datepicker_format');?>',

			maxDate : 0,

	}); 

} );

</script>

<h3>

    <ul id="myTab" class="sub_menu_css line case_nav nav nav-tabs panel_tabs margin_left_1per" role="tablist">

        <li role="presentation" class="<?php echo $active_tab == 'report_graph' ? 'active' : ''; ?> menucss">

			<a href="?page=gmgt_report&tab=attendance_report&tab1=report_graph" class="padding_left_0 tab">

				<?php echo esc_html__('Attendance Graph', 'gym_mgt'); ?>

			</a>

        </li>

        <li role="presentation" class="<?php echo $active_tab == 'data_report' ? 'active' : ''; ?> menucss">

			<a href="?page=gmgt_report&tab=attendance_report&tab1=data_report" class="padding_left_0 tab">

				<?php echo esc_html__('Attendance Datatable', 'gym_mgt'); ?>

			</a>

        </li>

		<li role="presentation" class="<?php echo $active_tab == 'data_report_staffmember' ? 'active' : ''; ?> menucss">

			<a href="?page=gmgt_report&tab=attendance_report&tab1=data_report_staffmember" class="padding_left_0 tab">

				<?php echo esc_html__('Staff Member Attendance Datatable', 'gym_mgt'); ?>

			</a>

        </li>

    </ul>	

</h3>

<?php 

if($active_tab == 'report_graph')

{

	global $wpdb;

	$table_attendance = $wpdb->prefix .'gmgt_attendence';

	$table_class = $wpdb->prefix .'gmgt_class_schedule';

	if(isset($_REQUEST['view_attendance']))

    {
		
		// $sdate =MJ_gmgt_get_format_for_db(esc_attr($_REQUEST['sdate']));

		// $edate = MJ_gmgt_get_format_for_db(esc_attr($_REQUEST['edate']));

		$date_type = $_POST['date_type'];
		
		if($date_type=="period")
		{
			$sdate = $_REQUEST['start_date'];
			$edate = $_REQUEST['end_date'];
			
		}
		else
		{
			$result =  mj_gmgt_all_date_type_value($date_type);
	
			$response =  json_decode($result);
			$sdate = $response[0];
			$edate = $response[1];
		
		}

	}

    else

	{

		$edate =date("Y-m-d");

	    $sdate=date("Y-m-d", strtotime("-1 week"));

	}

	$report_2 =$wpdb->get_results("SELECT  at.class_id, 

	SUM(case when `status` ='Present' then 1 else 0 end) as Present, 

	SUM(case when `status` ='Absent' then 1 else 0 end) as Absent 

	from $table_attendance as at,$table_class as cl where `attendence_date` BETWEEN '$sdate' AND '$edate' AND at.class_id = cl.class_id AND at.role_name = 'member' GROUP BY at.class_id") ;
	$chart_array = array();
	// $chart_array[] = array(esc_html__('Class','gym_mgt'),esc_html__('Present','gym_mgt'),esc_html__('Absent','gym_mgt'));
	array_push($chart_array, array(esc_html__('Class','gym_mgt'),esc_html__('Present','gym_mgt'),esc_html__('Absent','gym_mgt')));

	   if(!empty($report_2))

		foreach($report_2 as $result)

		{

			$class_id =MJ_gmgt_get_class_name($result->class_id);

			// $chart_array[] = array("$class_id",(int)$result->Present,(int)$result->Absent);

			array_push($chart_array, array("$class_id",(int)$result->Present,(int)$result->Absent));
		}
		$new_array = json_encode($chart_array);
		?>
		<div class="panel-body padding_0 mt-3">

	<form method="post" id="attendance_list"  class="attendance_list report">  
		<div class="form-body user_form margin_top_15px">
			<div class="row">
				<div class="col-md-3 mb-3 input">
					<label class="ml-1 custom-top-label top" for="class_id"><?php esc_attr_e('Date','gym_mgt');?><span class="require-field">*</span></label>			
						<select class="line_height_30px form-control date_type validate[required]" name="date_type" autocomplete="off">
							<option value=""><?php esc_attr_e('Select','gym_mgt');?></option>
							<option value="today"><?php esc_attr_e('Today','gym_mgt');?></option>
							<option value="this_week"><?php esc_attr_e('This Week','gym_mgt');?></option>
							<option value="last_week"><?php esc_attr_e('Last Week','gym_mgt');?></option>
							<option value="this_month" selected><?php esc_attr_e('This Month','gym_mgt');?></option>
							<option value="last_month"><?php esc_attr_e('Last Month','gym_mgt');?></option>
							<option value="last_3_month"><?php esc_attr_e('Last 3 Months','gym_mgt');?></option>
							<option value="last_6_month"><?php esc_attr_e('Last 6 Months','gym_mgt');?></option>
							<option value="last_12_month"><?php esc_attr_e('Last 12 Months','gym_mgt');?></option>
							<option value="this_year"><?php esc_attr_e('This Year','gym_mgt');?></option>
							<option value="last_year"><?php esc_attr_e('Last Year','gym_mgt');?></option>
							<option value="period"><?php esc_attr_e('Period','gym_mgt');?></option>
						</select>
				</div>

				<div id="date_type_div" class="date_type_div_none row col-md-6 mb-2" ></div>	

				<div class="col-md-3 mb-2">
					<input type="submit" name="view_attendance" Value="<?php esc_attr_e('Go','gym_mgt');?>"  class="btn btn-info save_btn"/>
				</div>
			</div>
		</div>
	</form>

	
	<?php
	// var_dump($new_array);
	if(!empty($result->Present) || !empty($result->Absent))
	{
		?>
		<script type="text/javascript" src="<?php echo GMS_PLUGIN_URL.'/assets/js/chart_loder.js'; ?>"></script>
		<script type="text/javascript">
			google.charts.load('current', {'packages':['bar']});
			google.charts.setOnLoadCallback(drawChart);

			function drawChart() {
				var data = google.visualization.arrayToDataTable(<?php echo $new_array; ?>);

				var options = {
				
					bars: 'vertical', // Required for Material Bar Charts.
					colors: ['#BA170B','#22BAA0'],
					title: '<?php _e('Member Attendance Report','gym_mgt');?>',
					fontName:'sans-serif',
					titleTextStyle: 
					{
						color: '#66707e'
					},
					
				};
			
				var chart = new google.charts.Bar(document.getElementById('barchart_material'));

				chart.draw(data, google.charts.Bar.convertOptions(options));
			}
		</script>
		<div id="barchart_material" style="width:100%;height: 430px; padding:20px;"></div>
		<?php
	}else{
		?>
			<div class="calendar-event-new"> 

				<img class="no_data_img" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/no_data_img.png"?>" >

			</div>
		<?php
	}

}

if($active_tab == 'data_report')
{ 

    if(isset($_REQUEST['view_attendance']))

    {

		$date_type = $_POST['date_type'];

		$type='member';

		if($date_type=="period")
		{
			$start_date = $_REQUEST['start_date'];
			$end_date = $_REQUEST['end_date'];
			
		}
		else
		{
			$result =  mj_gmgt_all_date_type_value($date_type);
	
			$response =  json_decode($result);
			$start_date = $response[0];
			$end_date = $response[1];

			if(!empty($_REQUEST['member_id']) && $_REQUEST['member_id'] != "all_member")
			{
				$member_id = $_REQUEST['member_id'];
				$attendence_data=MJ_gmgt_get_member_attendence_beetween_satrt_date_to_enddate_for_admin($start_date,$end_date,$member_id);
			}else{
				$attendence_data=MJ_gmgt_get_all_member_attendence_beetween_satrt_date_to_enddate($start_date,$end_date,$type);
			}
			
		}
		
	}

    else

	{

		$start_date = date('Y-m-d',strtotime('first day of this month'));

		$end_date = date('Y-m-d',strtotime('last day of this month'));

		$type='member';
		$attendence_data = MJ_gmgt_get_all_member_attendence_beetween_satrt_date_to_enddate($start_date,$end_date,$type);

	}

   

	?>

	<div class="panel-body padding_0 mt-3">

	   	<form method="post" id="attendance_list" class="attendance_list report">  
			<div class="form-body user_form margin_top_15px">
				<div class="row">
					<div class="col-md-3 mb-3 input">
						<label class="ml-1 custom-top-label top" for="class_id"><?php esc_attr_e('Date','gym_mgt');?><span class="require-field">*</span></label>			
							<select class="line_height_30px form-control date_type validate[required]" name="date_type" autocomplete="off">
								<!-- <option value=""><?php esc_attr_e('Select','gym_mgt');?></option> -->
								<option value="today"><?php esc_attr_e('Today','gym_mgt');?></option>
								<option value="this_week"><?php esc_attr_e('This Week','gym_mgt');?></option>
								<option value="last_week"><?php esc_attr_e('Last Week','gym_mgt');?></option>
								<option value="this_month" 	selected><?php esc_attr_e('This Month','gym_mgt');?></option>
								<option value="last_month"><?php esc_attr_e('Last Month','gym_mgt');?></option>
								<option value="last_3_month"><?php esc_attr_e('Last 3 Months','gym_mgt');?></option>
								<option value="last_6_month"><?php esc_attr_e('Last 6 Months','gym_mgt');?></option>
								<option value="last_12_month"><?php esc_attr_e('Last 12 Months','gym_mgt');?></option>
								<option value="this_year"><?php esc_attr_e('This Year','gym_mgt');?></option>
								<option value="last_year"><?php esc_attr_e('Last Year','gym_mgt');?></option>
								<option value="period"><?php esc_attr_e('Period','gym_mgt');?></option>
							</select>
					</div>

					<div class="col-sm-12 col-md-3 col-lg-3 col-xl-3 input">

						<!-- <label class="ml-1 custom-top-label top" for="staff_name"><?php //esc_html_e('Member','gym_mgt');?><span class="require-field">*</span></label> -->

						<!-- <?php if($edit){ $member_id=$result->member_id; }elseif(isset($_REQUEST['member_id'])){$member_id=sanitize_text_field($_REQUEST['member_id']);}else{$member_id='';}?> -->

						<select id="member_list" class="form-control display-members" name="member_id">

							<option value="all_member"><?php esc_html_e('All Member','gym_mgt');?></option>

								<?php $get_members = array('role' => 'member');

								$membersdata=get_users($get_members);

								if(!empty($membersdata))
								{
									foreach ($membersdata as $member)
									{
										if( $member->membership_status == "Continue"  && $member->member_type == "Member")
										{		
											?>
											<option value="<?php echo esc_attr($member->ID);?>" <?php selected(esc_attr($member_id),esc_attr($member->ID));?>><?php echo esc_html(MJ_gmgt_get_member_full_display_name_with_memberid(esc_html($member->ID))); ?> </option>
											<?php		
										}
									}
								}?>
						</select>

					</div>
					<div id="date_type_div" class="date_type_div_none row col-md-6 mb-2"></div>	
					<div class="col-md-3 mb-2">
						<input type="submit" name="view_attendance" Value="<?php esc_attr_e('Go','gym_mgt');?>"  class="btn btn-info save_btn"/>
					</div>
				</div>
			</div>
		</form>

	</div>

	<div class="panel-body padding_0 "><!--PANEL BODY DIV START-->

		<?php

		if(!empty($attendence_data))

		{ 

			?>

			<script type="text/javascript">

				$(document).ready(function() 

				{

					"use strict";

					var table = jQuery('#tblattadence').DataTable({

						// "responsive": true,

						"order": [[ 2, "Desc" ]],

						dom: 'lifrtp',

						buttons:[
							{
								extend: 'csv',
								text:'<?php esc_html_e('CSV', 'gym_mgt') ?>',
								title: '<?php _e('Attendance Report','gym_mgt');?>',
								exportOptions: {
									columns: [1, 2, 3,4,5,6,7], // Only name, email and role
								},
								charset: 'UTF-8',
								bom: true,
							},
							{
								extend: 'print',	
								text:'<?php esc_html_e('Print', 'gym_mgt') ?>',
								title: '<?php _e('Attendance Report','gym_mgt');?>',
								exportOptions: {
									columns: [1, 2, 3,4,5,6,7], // Only name, email and role
								}
							},
						],

						"aoColumns":[

								{"bSortable": false},

								{"bSortable": true},

								{"bSortable": true},

								{"bSortable": true},

								{"bSortable": true},

								{"bSortable": true},

								{"bSortable": true},

								{"bSortable": true}

							],

						language:<?php echo MJ_gmgt_datatable_multi_language();?>		   

					});
					$('.btn-place').html(table.buttons().container()); 
					$('.dataTables_filter input').attr("placeholder", "<?php esc_html_e('Search...', 'gym_mgt') ?>");

				} );

			</script>

			<div class="table-responsive"><!--TABLE RESPONSIVE DIV START-->
				<div class="btn-place"></div>

				<form name="wcwm_report" action="" method="post"><!--EXPENSE LIST FORM START-->

					<table id="tblattadence" class="display" cellspacing="0" width="100%"><!--EXPENSE LIST TABLE START-->

						<thead class="<?php echo MJ_gmgt_datatable_heder(); ?>">

							<tr>

								<th><?php esc_html_e('Photo','gym_mgt');?></th>

								<th><?php esc_html_e('Member Name','gym_mgt');?></th>

								<th><?php esc_html_e('Class Name','gym_mgt');?></th>

								<th><?php esc_html_e('Date','gym_mgt');?></th>

								<th><?php esc_html_e('Day','gym_mgt');?></th>

								<th><?php esc_html_e('Attendance','gym_mgt');?></th>

								<th><?php esc_html_e('Attendance By','gym_mgt');?></th>

								<th><?php esc_html_e('Attendance With QR','gym_mgt');?></th>

								

							</tr>

						</thead>

						<tbody>

							<?php

							if(!empty($attendence_data))

							{ 

								$i=0;

								foreach ($attendence_data as $retrieved_data)

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

										<td class="user_image width_50px profile_image_prescription padding_left_0">	

											<p class="prescription_tag padding_15px margin_bottom_0px <?php echo $color_class; ?>">	

												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/Attendance.png"?>" alt="" class="massage_image center image_icon_height_25px margin_top_3px">

											</p>

										</td>

										<td class="name">

											<?php 

											// $member_name=MJ_gmgt_get_user_display_name($retrieved_data->user_id);

											// var_dump($member_name);

											// if(!empty($retrieved_data->user_id))

											// {

											// 	echo MJ_gmgt_get_user_display_name($retrieved_data->user_id);

											// }

											// else

											// {

											// 	echo "N/A";

											// }

											echo MJ_gmgt_get_member_full_display_name_with_memberid(esc_html($retrieved_data->user_id));

											?>

											<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Member Name','gym_mgt');?>" ></i>

										</td>

										<td class="name">

											<?php echo MJ_gmgt_get_class_name($retrieved_data->class_id); ?>

											<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Class Name','gym_mgt');?>" ></i>

										</td>

										<td class="name">

											<?php  echo MJ_gmgt_getdate_in_input_box($retrieved_data->attendence_date); ?>

											<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Date','gym_mgt');?>" ></i>

										</td>

										<td class="name">

											<?php 

												$day=date("D", strtotime($retrieved_data->attendence_date));

												echo esc_html__($day,"gym_mgt");

											?>

											<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Day Name','gym_mgt');?>" ></i>

										</td>

										<td class="name">

											<?php  echo esc_html__($retrieved_data->status,"gym_mgt"); ?>

											<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Attendance Status','gym_mgt');?>" ></i>

										</td>

										<td class="name">

											<?php echo MJ_gmgt_get_user_display_name($retrieved_data->attendence_by) ?>

											<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Attendance By','gym_mgt');?>" ></i>

										</td>

										<td class="name">

											<?php if($retrieved_data->attendance_type == 'QR') { echo _e('Yes','gym_mgt');}elseif($retrieved_data->attendance_type == 'web' || $retrieved_data->attendance_type == NULL){ echo esc_html__('No',"gym_mgt"); }?>

											<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Attendance With QR','gym_mgt');?>" ></i>

										</td>

									</tr>

									<?php 

									$i++;

								}

							}

							?>

						</tbody>

					</table><!--EXPENSE LIST TABLE END-->

				</form><!--EXPENSE LIST FORM END-->

			</div><!--TABLE RESPONSIVE DIV END-->

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

			?>

	</div><!--PANEL BODY DIV END-->

	<?php 

}

if($active_tab == 'data_report_staffmember')

{ 


	if(isset($_REQUEST['view_attendance']))

    {

		$date_type = $_POST['date_type'];

		$type='staff_member';

		if($date_type=="period")
		{
			$start_date = $_REQUEST['start_date'];
			$end_date = $_REQUEST['end_date'];
			
		}
		else
		{
			$result =  mj_gmgt_all_date_type_value($date_type);
	
			$response =  json_decode($result);
			$start_date = $response[0];
			$end_date = $response[1];

			if(!empty($_REQUEST['staff_id']) && $_REQUEST['staff_id'] != "all_member")
			{
				$staff_id = $_REQUEST['staff_id'];
				$attendence_data=MJ_gmgt_get_member_attendence_beetween_satrt_date_to_enddate_for_admin($start_date,$end_date,$staff_id);
			}else{
				$attendence_data=MJ_gmgt_get_all_member_attendence_beetween_satrt_date_to_enddate($start_date,$end_date,$type);
			}
			
		}
		
	}

    else

	{

		$start_date = date('Y-m-d',strtotime('first day of this month'));

		$end_date = date('Y-m-d',strtotime('last day of this month'));

		$type='staff_member';
		$attendence_data = MJ_gmgt_get_all_member_attendence_beetween_satrt_date_to_enddate($start_date,$end_date,$type);

	}

   	// $attendence_data = MJ_gmgt_get_all_member_attendence_beetween_satrt_date_to_enddate($start_date,$end_date,$type);

	?>

	<div class="panel-body padding_0 mt-3">

	   	<form method="post" id="attendance_list" class="attendance_list report">  
			<div class="form-body user_form margin_top_15px">
				<div class="row">
					<div class="col-md-3 mb-3 input">
						<label class="ml-1 custom-top-label top" for="class_id"><?php esc_attr_e('Date','gym_mgt');?><span class="require-field">*</span></label>			
							<select class="line_height_30px form-control date_type validate[required]" name="date_type" autocomplete="off">
								<!-- <option value=""><?php esc_attr_e('Select','gym_mgt');?></option> -->
								<option value="today"><?php esc_attr_e('Today','gym_mgt');?></option>
								<option value="this_week"><?php esc_attr_e('This Week','gym_mgt');?></option>
								<option value="last_week"><?php esc_attr_e('Last Week','gym_mgt');?></option>
								<option value="this_month" selected	><?php esc_attr_e('This Month','gym_mgt');?></option>
								<option value="last_month"><?php esc_attr_e('Last Month','gym_mgt');?></option>
								<option value="last_3_month"><?php esc_attr_e('Last 3 Months','gym_mgt');?></option>
								<option value="last_6_month"><?php esc_attr_e('Last 6 Months','gym_mgt');?></option>
								<option value="last_12_month"><?php esc_attr_e('Last 12 Months','gym_mgt');?></option>
								<option value="this_year"><?php esc_attr_e('This Year','gym_mgt');?></option>
								<option value="last_year"><?php esc_attr_e('Last Year','gym_mgt');?></option>
								<option value="period"><?php esc_attr_e('Period','gym_mgt');?></option>
							</select>
					</div>

					<div class="col-sm-12 col-md-3 col-lg-3 col-xl-3 input">

						
						<select id="member_list" class="form-control display-members" name="staff_id">

							<option value="all_staff_member"><?php  esc_html_e('All Staff Member','gym_mgt');?></option>

							<?php $get_staff = array('role' => 'Staff_member');

							$staffdata=get_users($get_staff);

							

							if($edit)

							{

								$staff_data=$user_info->staff_id;

							}

							elseif(isset($_POST['staff_id']))

							{

								$staff_data=sanitize_text_field($_POST['staff_id']);

							}

							else

							{

								$staff_data="";

							}

							if(!empty($staffdata))

							{

								foreach($staffdata as $staff)

								{

									

									echo '<option value='.esc_attr($staff->ID).' '.selected(esc_html($staff_data),$staff->ID).'>'.esc_html($staff->display_name).'</option>';

								}

							}

							?>
						</select>

					</div>
					<div id="date_type_div" class="date_type_div_none row col-md-6 mb-2"></div>	
					<div class="col-md-3 mb-2">
						<input type="submit" name="view_attendance" Value="<?php esc_attr_e('Go','gym_mgt');?>"  class="btn btn-info save_btn"/>
					</div>
				</div>
			</div>
		</form>  

	</div>

	<div class="panel-body padding_0 "><!--PANEL BODY DIV START-->

		<?php

		if(!empty($attendence_data))

		{ 

			?>

			<script type="text/javascript">

				$(document).ready(function() 

				{

					"use strict";

						var table = jQuery('#tblattadence_staff').DataTable({

						// "responsive": true,

						"order": [[ 2, "Desc" ]],

						dom: 'lifrtp',

						// buttons: [

						// 	{

						// 	extend: '<?php echo esc_html_e('print', 'gym_mgt'); ?>',

						// 	title: '<?php echo esc_html_e('Attendance Report', 'gym_mgt'); ?>',

						// 	},

						// 	'pdf',

						// 	'csv'				

						// 	], 
						buttons:[
							{
								extend: 'csv',
								text:'<?php esc_html_e('CSV', 'gym_mgt') ?>',
								title: '<?php _e('Attendance Report','gym_mgt');?>',
								exportOptions: {
									columns: [1, 2, 3,4,5], // Only name, email and role
								},
								charset: 'UTF-8',
								bom: true,
							},
							{
								extend: 'print',	
								text:'<?php esc_html_e('Print', 'gym_mgt') ?>',
								title: '<?php _e('Attendance Report','gym_mgt');?>',
								exportOptions: {
									columns: [1, 2, 3,4,5], // Only name, email and role
								}
							},
						],
						"aoColumns":[

								{"bSortable": false},

								{"bSortable": true},

								{"bSortable": true},

								{"bSortable": true},

								{"bSortable": true},

								{"bSortable": true}

							],

						language:<?php echo MJ_gmgt_datatable_multi_language();?>		   

					});
					$('.btn-place').html(table.buttons().container()); 
					$('.dataTables_filter input').attr("placeholder", "<?php esc_html_e('Search...', 'gym_mgt') ?>");

				} );

			</script>

			<div class="table-responsive"><!--TABLE RESPONSIVE DIV START-->

			<form name="wcwm_report" action="" method="post"><!--EXPENSE LIST FORM START-->

				<table id="tblattadence_staff" class="display" cellspacing="0" width="100%"><!--EXPENSE LIST TABLE START-->
					<div class="btn-place"></div>
					<thead class="<?php echo MJ_gmgt_datatable_heder(); ?>">

						<tr>

							<th><?php esc_html_e('Photo','gym_mgt');?></th>

							<th><?php esc_html_e('Staff Member Name','gym_mgt');?></th>

							<th><?php esc_html_e('Date','gym_mgt');?></th>

							<th><?php esc_html_e('Day','gym_mgt');?></th>

							<th><?php esc_html_e('Attendance','gym_mgt');?></th>

							<th><?php esc_html_e('Attendance By','gym_mgt');?></th>

							

						</tr>

					</thead>

					<tbody>

					<?php

					if(!empty($attendence_data))

					{

						$i=0;

						foreach ($attendence_data as $retrieved_data)

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

								<td class="user_image width_50px profile_image_prescription padding_left_0">	

									<p class="prescription_tag padding_15px margin_bottom_0px <?php echo $color_class; ?>">	

										<img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/Attendance.png"?>" alt="" class="massage_image center image_icon_height_25px margin_top_3px">

									</p>

								</td>

								<td class="name">

									<?php 

										echo MJ_gmgt_get_user_full_display_name($retrieved_data->user_id)

									?>

								   	<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Staff Member Name','gym_mgt');?>" ></i>

								</td>

								<td class="name">

									<?php echo MJ_gmgt_getdate_in_input_box($retrieved_data->attendence_date); ?>

									<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Date','gym_mgt');?>" ></i>

								</td>

								<td class="name">

									<?php 

										$day=date("D", strtotime($retrieved_data->attendence_date));

										echo esc_html__($day,"gym_mgt");

									?>

									<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Day','gym_mgt');?>" ></i>

								</td>

								<td class="name">

									<?php echo esc_html__($retrieved_data->status,"gym_mgt"); ?>

									<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Attendance Status','gym_mgt');?>" ></i>

								</td>

								<td class="name">

									<?php echo MJ_gmgt_get_user_display_name($retrieved_data->attendence_by) ?>

									<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Attendance By','gym_mgt');?>" ></i>

								</td>

							</tr>

							<?php 

							$i++;

						}

					}

					?>

				</tbody>

				</table><!--EXPENSE LIST TABLE END-->

				</form><!--EXPENSE LIST FORM END-->

			</div><!--TABLE RESPONSIVE DIV END-->

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

			?>

	</div><!--PANEL BODY DIV END-->

	<?php 

}

?>

