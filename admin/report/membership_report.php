<?php 



$active_tab = isset($_GET['tab'])?$_GET['tab1']:'membership_report';

?>

<h3>



	<ul id="myTab" class="sub_menu_css line case_nav nav nav-tabs panel_tabs margin_left_1per" role="tablist">



		<li role="presentation" class="<?php echo $active_tab == 'membership_report' ? 'active' : ''; ?> menucss">



			<a href="?page=gmgt_report&tab=membership_report&tab1=membership_report" class="padding_left_0 tab">



				<?php echo esc_html__('Membership Graph', 'gym_mgt'); ?>



			</a>



		</li>



		<li role="presentation" class="<?php echo $active_tab == 'membership_datatable' ? 'active' : ''; ?> menucss">



			<a href="?page=gmgt_report&tab=membership_report&tab1=membership_datatable" class="padding_left_0 tab">



				<?php echo esc_html__('Membership Datatable', 'gym_mgt'); ?>



			</a>



		</li>



		<li role="presentation" class="<?php echo $active_tab == 'membership_status' ? 'active' : ''; ?> menucss">



			<a href="?page=gmgt_report&tab=membership_report&tab1=membership_status" class="padding_left_0 tab">



				<?php echo esc_html__('Membership Status', 'gym_mgt'); ?>



			</a>



		</li>



	</ul>	



</h3>



<?php



if($active_tab == "membership_report")

{



	global $wpdb;



	$table_name = $wpdb->prefix."gmgt_membershiptype";



	$q="SELECT * From $table_name";



	$member_ship_array = array();



	$result=$wpdb->get_results($q); 



	$chart_array = array();

   

	array_push($chart_array, array(esc_html__('Membership','gym_mgt'),esc_html__('Members','gym_mgt')));

	$sumArray = array(); 

	foreach($result as $value)

	{

		$membership_name = $value->membership_label;



		$member_ship_count =  count(get_users(array('role'=>'member','meta_key' => 'membership_id', 'meta_value' => $value->membership_id)));

		

		array_push($chart_array, array($membership_name,$member_ship_count));

		

	}

	$new_array = json_encode($chart_array);



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

				

			};

		

			var chart = new google.charts.Bar(document.getElementById('barchart_material'));



			chart.draw(data, google.charts.Bar.convertOptions(options));

		}

	</script>

	<div id="barchart_material" style="width:100%;height: 430px; padding:20px;"></div>



		

	<?php

}

if($active_tab == "membership_datatable")

{

	$obj_membership=new MJ_gmgt_membership;

	if(isset($_REQUEST['view_member']))



	{

		$membership_id = $_REQUEST['membership_id'];

		$membership_status = $_REQUEST['membership_status'];



		$get_members = MJ_gmgt_get_member_for_member_info_report($membership_id,$membership_status);

	}

	else

	{

		$membership_id = "all_membership";

		$membership_status = "all_membership_status";

		

		$get_members = MJ_gmgt_get_member_for_member_info_report($membership_id,$membership_status);

	}

	$members_data=get_users($get_members);

	?>



	<form method="post" id="attendance_list" class="attendance_list">  

        <div class="form-body user_form margin_top_15px">

            <div class="row">

                <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3 input">



                    <label class="ml-1 custom-top-label top" for="membership"><?php esc_html_e('Membership','gym_mgt');?><span class="require-field">*</span></label>					



                    <input type="hidden" name="membership_hidden" class="membership_hidden" value="<?php if($edit){ if(!empty($user_info->membership_id)) { echo esc_attr($user_info->membership_id); }else{ echo '0'; } }else{ echo '0';}?>">



                    <?php $membershipdata=$obj_membership->MJ_gmgt_get_all_membership(); ?>



                    <select name="membership_id" class="form-control validate[required] max_width_100" id="membership_id" >	



                        <option value="all_membership"><?php esc_html_e('All Membership','gym_mgt');?></option>



                            <?php 





                            if(!empty($membershipdata))



                            {



                                foreach ($membershipdata as $membership)



                                {						



                                    echo '<option value='.esc_attr($membership->membership_id).'>'.esc_html($membership->membership_label).'</option>';



                                }



                            }



                            ?>



                    </select>



                </div>



                <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3 input">



                    <label class="ml-1 custom-top-label top" for="membership"><?php esc_html_e('Membership Status','gym_mgt');?></label>					

                   

                    <select id="membership_status" class="form-control display-members" name="membership_status">



                        <option value="all_membership_status"><?php esc_html_e('All Status','gym_mgt');?></option>

                        <option value="Continue"><?php esc_html_e('Continue','gym_mgt');?></option>

                        <option value="Expired"><?php esc_html_e('Expired','gym_mgt');?></option>

                        <option value="Dropped"><?php esc_html_e('Dropped','gym_mgt');?></option>



                    </select>



                </div>



                <div id="date_type_div" class="date_type_div_none row col-md-6 mb-2"></div>	

                <div class="col-md-3 mb-2">

                    <input type="submit" name="view_member" Value="<?php esc_attr_e('Go','gym_mgt');?>"  class="btn btn-info save_btn"/>

                </div>

            </div>

        </div>

    </form>

	<div class="row"><!--ROW DIV START-->



		<div class="col-md-12 padding_0"><!--COL 12 DIV START-->



			<div class="panel-body"><!--PANEL BODY DIV START-->



				<?php

				global $wpdb;



				$obj_membership=new MJ_gmgt_membership;



				$membershipdata=$obj_membership->MJ_gmgt_get_all_membership();

				

				$user = get_users(array('role' => 'member'));

				// var_dump($user);



				if(!empty($members_data))



				{



					?>	



					<script type="text/javascript">



						$(document).ready(function() 



						{



							"use strict";



							var table = jQuery('#membership_list').DataTable({



								// "responsive": true,



								"order": [[ 1, "asc" ]],



								dom: 'lifrtp',



								buttons:[

									{

										extend: 'csv',

										text:'<?php esc_html_e('CSV', 'gym_mgt') ?>',

										title: '<?php _e('Membership Report','gym_mgt');?>',

										exportOptions: {

											columns: [1, 2, 3,4,5], // Only name, email and role

										},

										charset: 'UTF-8',

										bom: true,

									},

									{

										extend: 'print',

										text:'<?php esc_html_e('Print', 'gym_mgt') ?>',

										title: '<?php _e('Membership Report','gym_mgt');?>',

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



											{"bSortable": true}],



								language:<?php echo MJ_gmgt_datatable_multi_language();?>		  



							});

							$('.btn-place').html(table.buttons().container()); 

							$('.dataTables_filter input').attr("placeholder", "<?php esc_html_e('Search...', 'gym_mgt') ?>");





						});



					</script>



					<form name="wcwm_report" action="" method="post"><!--NOTICE LIST FORM START-->



						<div class="panel-body padding_0"><!--PANEL BODY DIV START-->



							<div class="table-responsive"><!--TABLE RESPONSIVE DIV START-->

								<div class="btn-place"></div>

								<table id="membership_list" class="display" cellspacing="0" width="100%"><!--NOTICE LIST FORM START-->



									<thead class="<?php echo MJ_gmgt_datatable_heder(); ?>">



										<tr>

											<th><?php esc_html_e('Photo','gym_mgt');?></th>



											<th><?php esc_html_e('Membership Name','gym_mgt');?></th>



											<th><?php esc_html_e('Member Name','gym_mgt');?></th>



											<th><?php esc_html_e('Start Date','gym_mgt');?></th>



											<th><?php esc_html_e('End Date','gym_mgt');?></th>



											<th><?php esc_html_e('Status','gym_mgt');?></th>

										</tr>



									</thead>



									<tbody>



										<?php 



										if(!empty($members_data))



										{



											$i=0;



											foreach ($members_data as $retrieved_data)



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



															<img src="<?php echo GMS_PLUGIN_URL."/assets/images/thumb_icon/gym-Membership.png"?>" height="50px" width="50px" alt="" class="massage_image center image_icon_height_25px margin_top_3px">



														</p>



													</td>



													<td class="noticetitle">



														<a href="#" class="view_details_popup" id="<?php echo esc_attr(MJ_gmgt_get_membership_name($retrieved_data->membership_id))?>" type="<?php echo 'view_notice';?>"><?php

															$membership_name=MJ_gmgt_get_membership_name($retrieved_data->membership_id);

															if($retrieved_data->membership_id){

																echo esc_html($membership_name);

															}else{

																echo "N/A";

															}

														

														?></a>



														<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Membership Name','gym_mgt');?>" ></i>



													</td>



													<td class="noticecontent">



														<?php 

														$display_label = MJ_gmgt_get_member_full_display_name_with_memberid(esc_html($retrieved_data->ID));



														if(!empty($display_label))



														{

															echo $display_label;

														}



														else



														{



															echo "N/A";



														}



														?>



														<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Member Name','gym_mgt');?>" ></i>



													</td>



													<td class="productquentity">



														<?php echo esc_attr($retrieved_data->begin_date);?>



														<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Start Date','gym_mgt');?>" ></i>



													</td>

													<td class="productquentity">



														<?php echo esc_attr($retrieved_data->end_date);?>



														<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('End Date','gym_mgt');?>" ></i>



													</td>

													<td class="productquentity">

														<?php esc_html_e($retrieved_data->membership_status,'gym_mgt');?>

														

														<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Status','gym_mgt');?>" ></i>



													</td>

												</tr>



												<?php 



												$i++;

												



											}



										}



										?>



									</tbody>



								</table><!--NOTICE LIST FORM END-->



							</div><!--TABLE RESPONSIVE DIV END-->



						</div><!--PANEL BODY DIV END-->



					</form><!--NOTICE LIST FORM END-->



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



		</div><!--COL 12 DIV END-->



	</div><!--ROW DIV END-->

	<?php

}

if($active_tab == "membership_status")

{



	$mebmer = get_users(array('role'=>'member'));



	global $wpdb;



	$table_name = $wpdb->prefix."gmgt_membershiptype";



	$q="SELECT * From $table_name";



	$member_ship_array = array();



	$result=$wpdb->get_results($q);



	$membership_status = array('Continue','Expired','Dropped');



	$membership_status1 =  array(esc_html__('Continue','gym_mgt'),esc_html__('Expired','gym_mgt'),esc_html__('Dropped','gym_mgt'));



	foreach($membership_status as $key=>$retrive)



	{



		$member_ship_count =  count(get_users(array('role'=>'member','meta_key' => 'membership_status', 'meta_value' => $retrive)));



		$member_ship_array[] = array('member_ship_id'=> $membership_status1[$key],



									'member_ship_count'=>	$member_ship_count



									);



	}

	?>

	<script src="https://github.com/chartjs/Chart.js/releases/download/v2.9.3/Chart.min.js"></script>



	<link rel="stylesheet" href="https://github.com/chartjs/Chart.js/releases/download/v2.9.3/Chart.min.css">



	<div class="gmgt-member-chart">



		<div class="outer">



			<canvas id="chartJSContainer" width="300" height="250" style="margin-top:18px;"></canvas>



			

			<?php



			$member_ship_Continue =  count(get_users(array('role'=>'member','meta_key' => 'membership_status', 'meta_value' => 'Continue')));

			$member_ship_Expired =  count(get_users(array('role'=>'member','meta_key' => 'membership_status', 'meta_value' => 'Expired')));



			?>

			<p class="percent membership_val_chart">



				<?php echo $member_ship_Continue+$member_ship_Expired;?><br>



			</p>

				 

			<p class="percent1 membership_label_chart">

				<?php esc_html_e('Membership','gym_mgt');?>



			</p>



		</div>



		<script>



			var options1 = {



				type: 'doughnut',



				data: {



					labels: ["<?php esc_html_e('Continue','gym_mgt');?>", "<?php esc_html_e('Expired','gym_mgt');?>"],



					datasets: [



						{



							label: '# of Votes',



							data: [<?php echo $member_ship_Continue; ?>,<?php echo $member_ship_Expired?>],



							backgroundColor: [



								'#00BA0C',



								'#BA170B',



							],



							borderColor: [



								'rgba(255, 255, 255 ,1)',



								'rgba(255, 255, 255 ,1)',



							],



							borderWidth: 5,



						}



					]



				},



				options: {



					rotation: 1 * Math.PI,



					circumference: 2 * Math.PI,



					legend: {



						display: false



					},



					tooltip: {



						enabled: false



					},

					cutoutPercentage: 75



				}



			}







			var ctx1 = document.getElementById('chartJSContainer').getContext('2d');



			new Chart(ctx1, options1);







			var options2 = {



				type: 'doughnut',



				data: {



					labels: ["", "Purple", ""],



					datasets: [



						{



							data: [88.5, 1],



							backgroundColor: [



								"rgba(0,0,0,0)",



								"rgba(255,255,255,1)",



								



							],



							borderColor: [



								'rgba(0, 0, 0 ,0)',



								'rgba(46, 204, 113, 1)',



								



							],



							borderWidth: 5



								



						}



					]



				},



				options: {



					cutoutPercentage: 95,



					rotation: 1 * Math.PI,



					circumference: 1 * Math.PI,



					legend: {



						display: false



					},



					tooltips: {



						enabled: false



					}



				}



			}



			var ctx2 = document.getElementById('secondContainer').getContext('2d');



			new Chart(ctx2, options2);



		</script>



	</div>

	<div class="row hmgt-line-chat member_chart_top">



		<div class="col line-chart-checkcolor-center color_dot_div_left chart_div_1">



			<p class="line-chart-checkcolor-RegularMember member_chart_con con_color" style="margin-right: 70px;"></p>



		</div>



		<!-- <div  class="col-md-2 chart_div_3"></div> -->



		<div class="col line-chart-checkcolor-center color_dot_div_right chart_div_1 padding_0">

 

			<p class="line-chart-checkcolor-VolunteerMember member_chart_con exp_color" style="margin-left: 70px;"></p>



		</div>



	</div>



	<div class="row d-flex align-items-center justify-content-center gmgt_das_chat mem_status">



		<div class="col-sm-5 col-md-5 col-lg-5 col-xl-5 col-xs-5 responsive_div_dasboard chart_div_1 gmgt_chart_div_1" id="gmgt-line-chat-right-border">



			<p class="count_patient">



				<?php



					$member_ship_Continue = str_pad($member_ship_Continue, 2, '0', STR_PAD_LEFT); 



					echo $member_ship_Continue;



				?>



			</p>



			<p class="name_patient">



				<?php esc_html_e('Continue Membership','gym_mgt');?>



			</p>



		</div>



		<div class="col-sm-2 col-md-2 col-lg-2 col-xl-2 col-xs-2 chart_div_3">



			<p class="between_border"></p>



		</div>



		<div class="col-sm-5 col-md-5 col-lg-5 col-xl-5 col-xs-5 responsive_div_dasboard chart_div_1 gmgt_chart_div_2 inpatient_div">



			<p class="count_patient">



				<?php



					$member_ship_Expired= str_pad($member_ship_Expired, 2, '0', STR_PAD_LEFT); 



					echo $member_ship_Expired;



				?>



			</p>



			<p class="name_patient">



				<?php esc_html_e('Expired Membership','gym_mgt');?>



			</p>



		</div>



	</div>

	<?php

}



