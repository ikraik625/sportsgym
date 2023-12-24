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

			<a href="?page=gmgt_report&tab=expense_report&tab1=report_graph">

				<?php echo esc_html__('Expense Report Graph', 'gym_mgt'); ?>

			</a>

        </li>

        <li role="presentation" class="<?php echo $active_tab == 'data_report' ? 'active' : ''; ?> menucss">

			<a href="?page=gmgt_report&tab=expense_report&tab1=data_report">

				<?php echo esc_html__('Expense Report Datatable', 'gym_mgt'); ?>

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

	$table_name = $wpdb->prefix."gmgt_income_expense";

	$report_6 = $wpdb->get_results("SELECT * FROM $table_name where invoice_type='expense'");

	if(!empty($report_6))
	{
	
		foreach($report_6 as $result)
		{
		
			$all_entry=json_decode($result->entry);
	
			$total_amount=0;
	
			foreach($all_entry as $entry)
	
			{
	
				$total_amount += $entry->amount;
	
				$q="SELECT EXTRACT(MONTH FROM invoice_date) as date, sum($total_amount) as count FROM ".$table_name." WHERE YEAR(invoice_date) =".$year." AND invoice_type='expense' group by month(invoice_date) ORDER BY invoice_date ASC";
	
				
	
			}
	
		}
		$result=$wpdb->get_results($q);	
	}
	

	$sumArray = array(); 

	if(!empty($result))

	{

		foreach ($result as $value) 

		{ 

			if(isset($sumArray[$value->date]))

			{

				$sumArray[$value->date] = $sumArray[$value->date] + (int)$value->count;

			}

			else

			{

				$sumArray[$value->date] = (int)$value->count; 

			}		

		}

	}

	

	$chart_array = array();

	$chart_array[] = array(esc_html__('Month','gym_mgt'),esc_html__('Expense Payment','gym_mgt'));

	$i=1;

	if(!empty($sumArray))
	{
		foreach($sumArray as $month_value=>$count)
		{
			$chart_array[]=array( $month[$month_value],(int)$count);
	
		}
	}
	
	

	$options = Array(

				'title' => esc_html__('Expense Payment Report By Month','gym_mgt'),

				'titleTextStyle' => Array('color' => '#66707e'),

				'legend' =>Array('position' => 'right',

				'textStyle'=> Array('color' => '#66707e')),

				'hAxis' => Array(

					'title' => esc_html__('Month','gym_mgt'),

					'format' => '#',

					'titleTextStyle' => Array('color' => '#66707e','fontSize' => 16,'bold'=>true,'italic'=>false,'fontName' =>'sans-serif'),

					'textStyle'=> Array('color' => '#66707e','fontSize' => 16,'bold'=>true,'italic'=>false,'fontName' =>'sans-serif'),

					'maxAlternation' => 2

					),

				'vAxis' => Array(

					'title' => esc_html__('Expense Payment','gym_mgt'),

					'minValue' => 0,

					'maxValue' => 6,

					'format' => '#',

					'titleTextStyle' => Array('color' => '#66707e','fontSize' => 16,'bold'=>true,'italic'=>false,'fontName' =>'sans-serif'),

					'textStyle'=> Array('color' => '#66707e','fontSize' => 16,'bold'=>true,'italic'=>false,'fontName' =>'sans-serif')

					),

			'colors' => array('#ba170b')

				);

	require_once GMS_PLUGIN_DIR. '/lib/chart/GoogleCharts.class.php';

	$GoogleCharts = new GoogleCharts;

	$chart = $GoogleCharts->load('column','chart_div')->get( $chart_array , $options );

	?>

	<script type="text/javascript">

		$(document).ready(function() 

		{

			"use strict";

			$.datepicker.setDefaults($.datepicker.regional['<?php echo MJ_gmgt_get_current_lan_code(); ?>']);

			$('.sdate').datepicker({dateFormat: "yy-mm-dd"}); 

			$('.edate').datepicker({dateFormat: "yy-mm-dd"}); 

		} );

	</script>

	<div id="chart_div" class="chart_div">

		<?php 

		if(empty($report_6)) 

		{ ?>

			<div class="clear col-md-12"><h3><?php esc_html_e("There is not enough data to generate report.",'gym_mgt');?> </h3></div>

			<?php 

		} ?>

	</div>

	<!-- Javascript --> 

	<script type="text/javascript" src="https://www.google.com/jsapi"></script> 

	<script type="text/javascript">

			<?php if(!empty($report_6))

			{

				echo $chart;

			}

			?>

	</script>

  

 	<?php

}

if($active_tab == 'data_report')

{

	if(isset($_REQUEST['expense_report_datatable']))

    {

		$start_date =MJ_gmgt_get_format_for_db(esc_attr($_REQUEST['sdate']));

		$end_date = MJ_gmgt_get_format_for_db(esc_attr($_REQUEST['edate']));

	}

    else

	{

		$start_date = date('Y-m-d',strtotime('first day of this month'));

        $end_date = date('Y-m-d',strtotime('last day of this month'));

	}

	$expense_report_data=MJ_gmgt_get_all_expense_report_beetween_satrt_date_to_enddate($start_date,$end_date);

    $obj_payment= new MJ_gmgt_payment();

	?>

	<div class="panel-body padding_0 mt-3">

	    <form method="post">  

			<div class="form-body user_form">

                <div class="row"> 

					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ipad_res">

						<div class="form-group input">

							<div class="col-md-12 form-control">

								<input type="text"  class="form-control sdate1" name="sdate" value="<?php if(isset($_REQUEST['sdate'])) echo esc_attr($_REQUEST['sdate']);else echo esc_attr(MJ_gmgt_getdate_in_input_box(date('Y-m-d')));?>" readonly>

								<label for="exam_id"><?php esc_html_e('Start Date','gym_mgt');?></label>	

							</div>

						</div>

					</div>

					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">

						<div class="form-group input">

							<div class="col-md-12 form-control">

								<input type="text"  class="form-control edate1"  name="edate" value="<?php if(isset($_REQUEST['edate'])) echo esc_attr($_REQUEST['edate']);else echo esc_attr(MJ_gmgt_getdate_in_input_box(date('Y-m-d')));?>" readonly>

								<label for="exam_id"><?php esc_html_e('End Date','gym_mgt');?></label>

							</div>

						</div>

					</div>

				</div><!--Row Div End--> 

			</div><!-- user_form End--> 

			<!------------   save btn  -------------->  

			<div class="form-body user_form"> <!-- user_form Strat-->   

				<div class="row"><!--Row Div Strat--> 

					<div class="col-md-6 col-sm-6 col-xs-12"><!--save btn--> 	

						<input type="submit" name="expense_report_datatable" Value="<?php esc_html_e('Go','gym_mgt');?>"  class="btn save_btn"/>

					</div>

				</div><!--Row Div End--> 

			</div><!-- user_form End--> 

		</form>

	</div>

	

	<div class="panel-body padding_0 mt-3"><!--PANEL BODY DIV START-->

		<?php

		if(!empty($expense_report_data))

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

						// 	title: '<?php echo esc_html_e('Expense List', 'gym_mgt'); ?>',

						// 	},

						// 	'pdf',

						// 	'csv'

						// 	], 

						"aoColumns":[

							{"bSortable": false},

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

								<th><?php esc_html_e('Supplier Name','gym_mgt');?></th>

								<th><?php esc_html_e('Amount','gym_mgt');?></th>

								<th><?php esc_html_e('Date','gym_mgt');?></th>

								

							</tr>

						</thead>

						<tbody>

							<?php

							if(!empty($expense_report_data))

							{		

								$i=0;			   

								foreach($expense_report_data as $retrieved_data)

								{ 

									$all_entry=json_decode($retrieved_data->entry);

									$total_amount=0;

									foreach($all_entry as $entry)

									{

										$total_amount+=$entry->amount;

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

									?>

									<tr>

										<td class="user_image width_50px profile_image_prescription padding_left_0">	

											<p class="prescription_tag padding_15px margin_bottom_0px <?php echo $color_class; ?>">	

												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/Attendance.png"?>" alt="" class="massage_image center image_icon_height_25px margin_top_3px">

											</p>

										</td>

										<td class="party_name">

											<?php echo esc_html($retrieved_data->supplier_name);?>

											<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Supplier Name','gym_mgt');?>" ></i>

										</td>

										<td class="income_amount">

											<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?> <?php echo number_format(esc_html($total_amount),2);?>

											<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Amount','gym_mgt');?>" ></i>

										</td>

										<td class="status">

											<?php echo MJ_gmgt_getdate_in_input_box(esc_html($retrieved_data->invoice_date));?>

											<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Date','gym_mgt');?>" ></i>

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