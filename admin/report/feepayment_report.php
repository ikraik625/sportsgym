<?php

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

			<a href="?page=gmgt_report&tab=feepayment_report&tab1=report_graph">

				<?php echo esc_html__('Membership Payment Graph', 'gym_mgt'); ?>

			</a>

        </li>

        <li role="presentation" class="<?php echo $active_tab == 'data_report' ? 'active' : ''; ?> menucss">

			<a href="?page=gmgt_report&tab=feepayment_report&tab1=data_report">

				<?php echo esc_html__('Membership Payment Datatable', 'gym_mgt'); ?>

			</a>

        </li>

    </ul>	

</h3>



<?php

if($active_tab == 'report_graph')

{  

	$month =array('1'=>esc_html__('January','gym_mgt'),'2'=>esc_html__('February','gym_mgt'),'3'=>esc_html__('March','gym_mgt'),'4'=>esc_html__('April','gym_mgt'),'5'=>esc_html__('May','gym_mgt'),'6'=>esc_html__('June','gym_mgt'),'7'=>esc_html__('July','gym_mgt'),'8'=>esc_html__('August','gym_mgt'),'9'=>esc_html__('September','gym_mgt'),'10'=>esc_html__('October','gym_mgt'),'11'=>esc_html__('November','gym_mgt'),'12'=>esc_html__('December','gym_mgt'),);

	$year =isset($_POST['year'])?$_POST['year']:date('Y');

	global $wpdb;

	$table_name = $wpdb->prefix."gmgt_membership_payment_history";

	$q="SELECT EXTRACT(MONTH FROM paid_by_date) as date,sum(amount) as count FROM ".$table_name." WHERE YEAR(paid_by_date) =".$year." group by month(paid_by_date) ORDER BY paid_by_date ASC";

	$result=$wpdb->get_results($q);

	$chart_array = array();

	// $chart_array[] = array(esc_html__('Month','gym_mgt'),esc_html__('Fee Payment','gym_mgt'));

	array_push($chart_array, array(esc_html__('Month','gym_mgt'),esc_html__('Membership Payment','gym_mgt')));

	foreach($result as $r)

	{
		// $chart_array[]=array( $month[$r->date],(int)$r->count);
		
		array_push($chart_array, array($month[$r->date],(int)$r->count));

	}

	$new_array = json_encode($chart_array);

	if(!empty($r->count))
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
					colors: ['#BA170B'],
					title: '<?php _e('Membership Payment Report','gym_mgt');?>',
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

	// $options = Array(

	// 			'title' => esc_html__('Fee Payment Report By Month','gym_mgt'),

	// 			'titleTextStyle' => Array('color' => '#66707e'),

	// 			'legend' =>Array('position' => 'right',

	// 						'textStyle'=> Array('color' => '#66707e')),

	// 			'hAxis' => Array(

	// 				'title' => esc_html__('Month','gym_mgt'),

	// 				'format' => '#',

	// 				'titleTextStyle' => Array('color' => '#66707e','fontSize' => 16,'bold'=>true,'italic'=>false,'fontName' =>'sans-serif'),

	// 				'textStyle'=> Array('color' => '#66707e','fontSize' => 16,'bold'=>true,'italic'=>false,'fontName' =>'sans-serif'),

	// 				'maxAlternation' => 2

	// 				),

	// 			'vAxis' => Array(

	// 				'title' => esc_html__('Fee Payment','gym_mgt'),

	// 				'minValue' => 0,

	// 				'maxValue' => 6,

	// 				'format' => '#',

	// 				'titleTextStyle' => Array('color' => '#66707e','fontSize' => 16,'bold'=>true,'italic'=>false,'fontName' =>'sans-serif'),

	// 				'textStyle'=> Array('color' => '#66707e','fontSize' => 16,'bold'=>true,'italic'=>false,'fontName' =>'sans-serif')

	// 				),

	// 		'colors' => array('#ba170b')

	// 			);

	// require_once GMS_PLUGIN_DIR. '/lib/chart/GoogleCharts.class.php';

	// $GoogleCharts = new GoogleCharts;

	// $chart = $GoogleCharts->load( 'column' , 'chart_div' )->get( $chart_array , $options );

	?>

	<!-- <script type="text/javascript">

	$(document).ready(function() 

	{

		"use strict";

		$.datepicker.setDefaults($.datepicker.regional['<?php echo MJ_gmgt_get_current_lan_code(); ?>']);

		$('.sdate').datepicker({dateFormat: "yy-mm-dd"}); 

		$('.edate').datepicker({dateFormat: "yy-mm-dd"}); 

	} );

	</script>

	<div id="chart_div" class="chart_div"> -->

	<!-- <?php 

	if(empty($result)) 

	{?>

		<div class="clear col-md-12"><h3><?php esc_html_e("There is not enough data to generate report.",'gym_mgt');?> </h3></div>

	<?php 

	} ?> -->

	</div>

	<!-- Javascript --> 

	<!-- <script type="text/javascript" src="https://www.google.com/jsapi"></script> 

	<script type="text/javascript">

		<?php 

		if(!empty($result))

		{

			echo $chart;

		}

		?>

	</script> -->

	<?php

}

if($active_tab == 'data_report')
{

   
	if(isset($_REQUEST['view_attendance']))
    {
		$date_type = $_POST['date_type'];
		
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
		
		}
	}
    else
	{
		$start_date = date('Y-m-d',strtotime('first day of this month'));

        $end_date = date('Y-m-d',strtotime('last day of this month'));
	}

	$feespayment_report_data=MJ_gmgt_get_all_feespayment_report_beetween_start_date_to_enddate($start_date,$end_date);	

	?>

	<div class="panel-body padding_0 mt-3">

	 	<form method="post" id="attendance_list"  class="attendance_list">  
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

	</div>

	<div class="panel-body padding_0 mt-3"><!--PANEL BODY DIV START-->

		<?php 

		if(!empty($feespayment_report_data))

		{

			?>

			<script type="text/javascript">

				$(document).ready(function() 

				{

					"use strict";

					jQuery('#tblexpence').DataTable({

						// "responsive": true,

						"order": [[ 2, "Desc" ]],

						dom: 'lifrtp',

						// buttons: [

						// 	{

						// 	extend: '<?php echo esc_html_e('print', 'gym_mgt'); ?>',

						// 	title: '<?php echo esc_html_e('Fees payment List', 'gym_mgt'); ?>',

						// 	},

						// 	'pdf',

						// 	'csv'				

						// 	], 

						"aoColumns":[

								{"bSortable": false},

								{"bSortable": true},

								{"bSortable": true},

								{"bSortable": true},

								{"bSortable": true}

							],

						language:<?php echo MJ_gmgt_datatable_multi_language();?>		   

					});

					$('.dataTables_filter input').attr("placeholder", "<?php esc_html_e('Search...', 'gym_mgt') ?>");

				} );

			</script>

			<div class="table-responsive"><!--TABLE RESPONSIVE DIV START-->

				<form name="wcwm_report" action="" method="post"><!--EXPENSE LIST FORM START-->

					<table id="tblexpence" class="display" cellspacing="0" width="100%"><!--EXPENSE LIST TABLE START-->

						<thead class="<?php echo MJ_gmgt_datatable_heder(); ?>">

							<tr>

								<th><?php esc_html_e('Photo','gym_mgt');?></th>

								<th><?php esc_html_e('Membership Name','gym_mgt');?></th>

								<th><?php esc_html_e('Amount','gym_mgt');?></th>

								<th><?php esc_html_e('Date','gym_mgt');?></th>

								<th><?php esc_html_e('Payment Method','gym_mgt');?></th>

							</tr>

						</thead>

						<tbody>

							<?php 

							if(!empty($feespayment_report_data))

							{

								$i=0;

								foreach ($feespayment_report_data as $retrieved_data)

								{ 
									$membership_id = MJ_gmgt_membership_id($retrieved_data->mp_id);
								
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

										<td class="party_name">

											<?php

											if(!empty($membership_id))

											{

												echo MJ_gmgt_get_membership_name($membership_id);

											}

											else 

											{

												

												echo "N/A";

											}

											?>

											<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Membership Name','gym_mgt');?>" ></i>

										</td>

										<td class="income_amount">

											<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?> 

											<?php 

												if(!empty($retrieved_data->amount))

												{

													echo number_format(esc_html($retrieved_data->amount),2);

												}

												else {

													echo "N/A";

												}

											?>

											<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Amount','gym_mgt');?>" ></i>

										</td>

										<td class="status">

											<?php

											if(!empty($retrieved_data->paid_by_date))

											{

												echo MJ_gmgt_getdate_in_input_box(esc_html($retrieved_data->paid_by_date));

											}

											else {

												echo "N/A";

											}

											?>

											<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Date','gym_mgt');?>" ></i>

										</td>

										<td class="party_name">

											<?php

											if(!empty($retrieved_data->payment_method))	

											{

												echo esc_html__($retrieved_data->payment_method,"gym_mgt");

											}

											else {

												echo "N/A";

											}

											?>

											<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Payment Method','gym_mgt');?>" ></i>

										</td>

									</tr>

									<?php

									$i++;

								}

							} ?>

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

 