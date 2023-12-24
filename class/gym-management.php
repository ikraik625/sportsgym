<?php 
//GYM MANAGEMENT CLASS START  
class MJ_gmgt_Gym_management
{
	public $member;
	public $staff_member;
	public $role;
	public $notice;
	function __construct($user_id = NULL)
	{		
		if($user_id)
		{			
			$this->role=$this->MJ_gmgt_get_current_user_role();
			$this->notice = $this->MJ_gmgt_notice_board($this->MJ_gmgt_get_current_user_role());
		}
	}
	//get current user role
	private function MJ_gmgt_get_current_user_role ()
	{
		global $current_user;
		$user_roles = $current_user->roles;
		$user_role = array_shift($user_roles);
		return $user_role;
	}
	//get weight report
	public function MJ_gmgt_get_weight_report($report_type,$user_id)
	{
		$report_type_array = array();
		global $wpdb;
		$table_name = $wpdb->prefix."gmgt_measurment";
		$q="SELECT * From $table_name where user_id=".$user_id;
		
		$result=$wpdb->get_results($q);
		
		foreach($result as $retrive)
		{		
			$all_data[$retrive->result_measurment][]=array('result'=>$retrive->result,'date'=>$retrive->result_date);
		}
		
		if($report_type == 'Weight')
		{
			$report_type_array = array();
			$report_type_array[] = array('date','weight	');
			if(isset($all_data['Weight']) && !empty($all_data['Weight']))
			foreach($all_data['Weight'] as $r)
			{
				$report_type_array[]=array($r['date'],(float)$r['result']);
			}
		}
		if($report_type == 'Thigh')
		{			
			$report_type_array = array();
			$report_type_array[] = array('Date','Thigh');
			if(isset($all_data['Thigh']) && !empty($all_data['Thigh']))
			foreach($all_data['Thigh'] as $r)
			{
				$report_type_array[]=array($r['date'],(float)$r['result']);				
			
			}
		}
		if($report_type == 'Height')
		{
			$report_type_array = array();
			$report_type_array[] = array('Date','Height');
			if(isset($all_data['Height']) && !empty($all_data['Height']))
			foreach($all_data['Height'] as $r)
			{
				$report_type_array[]=array($r['date'],(float)$r['result']);
			}
		}
		if($report_type == 'Chest')
		{
			$report_type_array = array();
			$report_type_array[] = array('Date','Chest');
			if(isset($all_data['Chest']) && !empty($all_data['Chest']))
			foreach($all_data['Chest'] as $r)
			{
				$report_type_array[]=array($r['date'],(float)$r['result']);
			}
		}
		if($report_type == 'Waist')
		{
			$report_type_array = array();
			$report_type_array[] = array('Date','Waist');
			if(isset($all_data['Waist']) && !empty($all_data['Waist']))
			foreach($all_data['Waist'] as $r)
			{
				$report_type_array[]=array($r['date'],(float)$r['result']);
			}
		}
		if($report_type == 'Arms')
		{
			$report_type_array = array();
			$report_type_array[] = array('Date','Arms');
			if(isset($all_data['Arms']) && !empty($all_data['Arms']))
			foreach($all_data['Arms'] as $r)
			{
				$report_type_array[]=array($r['date'],(float)$r['result']);
			}
		}
		if($report_type == 'Fat')
		{
			$report_type_array = array();
			$report_type_array[] = array('Date','Fat');
			if(isset($all_data['Fat']) && !empty($all_data['Fat']))
			foreach($all_data['Fat'] as $r)
			{
				$report_type_array[]=array($r['date'],(int)$r['result']);
			}
		}		
		return $report_type_array;
	}
	//get weight report
	public function MJ_gmgt_get_dashvoard_report($report_type,$user_id)
	{
		$report_type_array = array();
		global $wpdb;
		$table_name = $wpdb->prefix."gmgt_measurment";
		$q="SELECT * From $table_name where user_id=".$user_id;
		
		$result=$wpdb->get_results($q);
		
		foreach($result as $retrive)
		{		
			$all_data[$retrive->result_measurment][]=array('result'=>$retrive->result,'date'=>$retrive->result_date);
		}
		if($report_type == 'Weight')
		{
			$report_type_array = array();
			$report_type_array[] = array('date','weight	');
			if(isset($all_data['Weight']) && !empty($all_data['Weight']))
			foreach($all_data['Weight'] as $r)
			{
				$report_type_array[]=array('date'=>$r['date'],'result'=>(float)$r['result']);
			}
		}
		if($report_type == 'Thigh')
		{			
			$report_type_array = array();
			$report_type_array[] = array('Date','Thigh');
			if(isset($all_data['Thigh']) && !empty($all_data['Thigh']))
			foreach($all_data['Thigh'] as $r)
			{
				$report_type_array[]=array('date'=>$r['date'],'result'=>(float)$r['result']);
			}
		}
		if($report_type == 'Height')
		{
			$report_type_array = array();
			$report_type_array[] = array('Date','Height');
			if(isset($all_data['Height']) && !empty($all_data['Height']))
			foreach($all_data['Height'] as $r)
			{
				$report_type_array[]=array('date'=>$r['date'],'result'=>(float)$r['result']);
			}
		}
		if($report_type == 'Chest')
		{
			$report_type_array = array();
			$report_type_array[] = array('Date','Chest');
			if(isset($all_data['Chest']) && !empty($all_data['Chest']))
			foreach($all_data['Chest'] as $r)
			{
				$report_type_array[]=array('date'=>$r['date'],'result'=>(float)$r['result']);
			}
		}
		if($report_type == 'Waist')
		{
			$report_type_array = array();
			$report_type_array[] = array('Date','Waist');
			if(isset($all_data['Waist']) && !empty($all_data['Waist']))
			foreach($all_data['Waist'] as $r)
			{
				$report_type_array[]=array('date'=>$r['date'],'result'=>(float)$r['result']);
			}
		}
		if($report_type == 'Arms')
		{
			$report_type_array = array();
			$report_type_array[] = array('Date','Arms');
			if(isset($all_data['Arms']) && !empty($all_data['Arms']))
			foreach($all_data['Arms'] as $r)
			{
				$report_type_array[]=array('date'=>$r['date'],'result'=>(float)$r['result']);
			}
		}
		if($report_type == 'Fat')
		{
			$report_type_array = array();
			$report_type_array[] = array('Date','Fat');
			if(isset($all_data['Fat']) && !empty($all_data['Fat']))
			foreach($all_data['Fat'] as $r)
			{
				$report_type_array[]=array('date'=>$r['date'],'result'=>(float)$r['result']);
			}
		}		
		return $report_type_array;
	}
	//GET Report OPTION
	public function MJ_gmgt_report_option($report_type)
	{
		$report_title = '';
		$htitle = "";
		$ytitle = "";
		if($report_type == 'Weight')
		{
			$report_title = esc_html__('Weight Report','gym_mgt');
			$htitle = esc_html__('Day','gym_mgt');
			$vtitle = esc_html__(get_option( 'gmgt_weight_unit' ),'gym_mgt');

		}
		if($report_type == 'Thigh')
		{
			$report_title = esc_html__('Thigh Report','gym_mgt');
			$htitle = esc_html__('Day','gym_mgt');
			//$vtitle = get_option( 'gmgt_thigh_unit' );
			$vtitle = esc_html__(get_option( 'gmgt_thigh_unit' ),'gym_mgt');
		}
		if($report_type == 'Height')
		{
			$report_title = esc_html__('Height Report','gym_mgt');
			$htitle = esc_html__('Day','gym_mgt');
			//$vtitle = get_option( 'gmgt_height_unit' );
			$vtitle = esc_html__(get_option( 'gmgt_height_unit' ),'gym_mgt');
		}
		if($report_type == 'Chest')
		{
			$report_title = esc_html__('Chest Report','gym_mgt');
			$htitle = esc_html__('Day','gym_mgt');
			//$vtitle = get_option( 'gmgt_chest_unit' );
			$vtitle = esc_html__(get_option( 'gmgt_chest_unit' ),'gym_mgt');
		}
		if($report_type == 'Waist')
		{
			$report_title = esc_html__('Waist Report','gym_mgt');
			$htitle = esc_html__('Day','gym_mgt');
		//	$vtitle = get_option( 'gmgt_waist_unit' );
			$vtitle = esc_html__(get_option( 'gmgt_waist_unit' ),'gym_mgt');
		}
		if($report_type == 'Arms')
		{
			$report_title = esc_html__('Arms Report','gym_mgt');
			$htitle = esc_html__('Day','gym_mgt');
			//$vtitle = get_option( 'gmgt_arms_unit' );
			$vtitle = esc_html__(get_option( 'gmgt_arms_unit' ),'gym_mgt');
		}
		if($report_type == 'Fat')
		{
			$report_title = esc_html__('Fat Report','gym_mgt');
			$htitle = esc_html__('Day','gym_mgt');
			//$vtitle = get_option( 'gmgt_fat_unit' );
			$vtitle = esc_html__(get_option( 'gmgt_fat_unit' ),'gym_mgt');
		}
		$options = Array(
				'title' => $report_title,
				'titleTextStyle' => Array('color' => '#4e5e6a','fontSize' => 16,'bold'=>false,'italic'=>false,'fontName' =>'-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif;'),
				'legend' =>Array('position' => 'right',
						'textStyle'=> Array('color' => '#4e5e6a','fontSize' => 13,'bold'=>false,'italic'=>false,'fontName' =>'-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif;')),
		
				'hAxis' => Array(
						'title' => $htitle,
						'titleTextStyle' => Array('color' => '#4e5e6a','fontSize' => 14,'bold'=>false,'italic'=>false,'fontName' =>'-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif;'),
						'textStyle' => Array('color' => '#4e5e6a','fontSize' => 11,'bold'=>false,'italic'=>false,'fontName' =>'-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif;'),
						'maxAlternation' => 2
				),
				'vAxis' => Array(
						'title' => $vtitle,
						'minValue' => 0,
						'maxValue' => 4,
						'format' => '#',
						'titleTextStyle' => Array('color' => '#4e5e6a','fontSize' => 14,'bold'=>false,'italic'=>false,'fontName' =>'-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif;'),
						'textStyle' => Array('color' => '#4e5e6a','fontSize' => 11)
				),
				'colors' => array('#E14444')
			);
		return $options;
	}
	//notice board
	public function MJ_gmgt_notice_board($role,$limit = -1)
	{
		$args['post_type'] = 'gmgt_notice';
		$args['posts_per_page'] = $limit;
		$args['post_status'] = 'public';
		$args['orderby'] = 'date';
		$args['order'] = 'DESC';
		$args['meta_query'] = array(
									'relation' => 'OR',
							        array(
							            'key' => 'notice_for',
							            'value' =>"all",						           
							        ),
									array(
											'key' => 'notice_for',
											'value' =>"$role",
									)
							   );
		$q = new WP_Query();
		
		$retrieve_notice = $q->query( $args );
		return $retrieve_notice;		
	}
	//get today workout
	public function MJ_gmgt_get_today_workout($user_id)
	{
		global $wpdb;
		$table_name = $wpdb->prefix."gmgt_assign_workout";
		$table_gmgt_workout_data = $wpdb->prefix."gmgt_workout_data";
		$date = date('Y-m-d');
		
		$day_name = date('l', strtotime($date));
		
		$sql = "Select * From $table_name as workout,$table_gmgt_workout_data as workoutdata where  workout.user_id = $user_id 
		AND  workout.workout_id = workoutdata.workout_id 
		AND workoutdata.day_name = '$day_name'
		AND CURDATE() between workout.Start_date and workout.End_date ";
		
		$result = $wpdb->get_results($sql);
		return $result;
	}
	//get today workout
	public function MJ_gmgt_get_today_nutrition($user_id)
	{
		global $wpdb;
		$table_gmgt_nutrition = $wpdb->prefix."gmgt_nutrition";
		$table_gmgt_nutrition_data = $wpdb->prefix."gmgt_nutrition_data";
		$date = date('Y-m-d');
		
		$day_name = date('l', strtotime($date));
		
		$sql = "Select * From $table_gmgt_nutrition as nutrition,$table_gmgt_nutrition_data as nutrition_data where  nutrition.user_id = $user_id 
		AND  nutrition.id = nutrition_data.nutrition_id 
		AND nutrition_data.day_name = '$day_name'
		AND CURDATE() between nutrition.start_date and nutrition.expire_date ";
		
		$result = $wpdb->get_results($sql);
		return $result;
	}
	
	public function MJ_gmgt_get_dashboard_report_api($report_type,$user_id)

	{

		$report_type_array = array();

		global $wpdb;

		$table_name = $wpdb->prefix."gmgt_measurment";

		$q="SELECT * From $table_name where user_id=".$user_id;

		

		$result=$wpdb->get_results($q);

		foreach($result as $retrive)
		{		
			$all_data[$retrive->result_measurment][]=array('result'=>$retrive->result,'date'=>$retrive->result_date);
		}
	
		if($report_type == 'Weight')
		{
			if(isset($all_data['Weight']) && !empty($all_data['Weight']))
			foreach($all_data['Weight'] as $r)
			{
				$report_type_date_array[]=MJ_gmgt_getdate_in_input_box($r['date']);
				$report_type_value_array[]=(float)$r['result'];
			}
			//$report_type_array['date'] = implode(',',$report_type_date_array);

			$report_type_array['date'] = $report_type_date_array;

			//$report_type_array['value'] = implode(',',$report_type_value_array);

			$report_type_array['value'] = $report_type_value_array;

			$report_type_array['name'] =esc_html__("Weight Progress Report",'gym_mgt');

			$report_type_array['measurment_unit']=esc_html__(get_option('gmgt_weight_unit'),"gym_mgt");

		}

		if($report_type == 'Thigh')

		{			

			$report_type_array = array();

			

			if(isset($all_data['Thigh']) && !empty($all_data['Thigh']))

			foreach($all_data['Thigh'] as $r)

			{

				$report_type_date_array[]=MJ_gmgt_getdate_in_input_box($r['date']);

				$report_type_value_array[]=(float)$r['result'];

			}

			//$report_type_array['date'] = implode(',',$report_type_date_array);

			//$report_type_array['value'] = implode(',',$report_type_value_array);

			$report_type_array['date'] = $report_type_date_array;

			$report_type_array['value'] = $report_type_value_array;

			$report_type_array['name'] =esc_html__("Thigh Progress Report",'gym_mgt');

			$report_type_array['measurment_unit']=esc_html__(get_option('gmgt_thigh_unit'),"gym_mgt");

		}

		if($report_type == 'Height')

		{

			$report_type_array = array();

		

			if(isset($all_data['Height']) && !empty($all_data['Height']))

			foreach($all_data['Height'] as $r)

			{

				$report_type_date_array[]=MJ_gmgt_getdate_in_input_box($r['date']);

				$report_type_value_array[]=(float)$r['result'];

			}

			//$report_type_array['date'] = implode(',',$report_type_date_array);
			//$report_type_array['value'] = implode(',',$report_type_value_array);

			$report_type_array['date'] = $report_type_date_array;
			$report_type_array['value'] = $report_type_value_array;

			$report_type_array['name'] =esc_html__("Height Progress Report",'gym_mgt');

			$report_type_array['measurment_unit']=esc_html__(get_option('gmgt_height_unit'),"gym_mgt");

		}

		if($report_type == 'Chest')

		{

			$report_type_array = array();

			

			if(isset($all_data['Chest']) && !empty($all_data['Chest']))

			foreach($all_data['Chest'] as $r)

			{

				$report_type_date_array[]= MJ_gmgt_getdate_in_input_box($r['date']);

				$report_type_value_array[]=(float)$r['result'];

			}

			//$report_type_array['date'] = implode(',',$report_type_date_array);

			//$report_type_array['value'] = implode(',',$report_type_value_array);

			$report_type_array['date'] = $report_type_date_array;

			$report_type_array['value'] = $report_type_value_array;

			$report_type_array['name'] =esc_html__("Chest Progress Report",'gym_mgt');

			$report_type_array['measurment_unit']=esc_html__(get_option('gmgt_chest_unit'),"gym_mgt");

		}

		if($report_type == 'Waist')

		{

			$report_type_array = array();

		

			if(isset($all_data['Waist']) && !empty($all_data['Waist']))

			foreach($all_data['Waist'] as $r)

			{

				$report_type_date_array[]= MJ_gmgt_getdate_in_input_box($r['date']);

				$report_type_value_array[]=(float)$r['result'];

			}

			//$report_type_array['date'] = implode(',',$report_type_date_array);

			//$report_type_array['value'] = implode(',',$report_type_value_array);

			$report_type_array['date'] = $report_type_date_array;

			$report_type_array['value'] = $report_type_value_array;

			$report_type_array['name'] =esc_html__("Waist Progress Report",'gym_mgt');

			$report_type_array['measurment_unit']=esc_html__(get_option('gmgt_waist_unit'),"gym_mgt");

		}

		if($report_type == 'Arms')

		{

			$report_type_array = array();

		

			if(isset($all_data['Arms']) && !empty($all_data['Arms']))

			foreach($all_data['Arms'] as $r)

			{

				$report_type_date_array[]= MJ_gmgt_getdate_in_input_box($r['date']);

				$report_type_value_array[]=(float)$r['result'];

			}

			//$report_type_array['date'] = implode(',',$report_type_date_array);

			//$report_type_array['value'] = implode(',',$report_type_value_array);

			$report_type_array['date'] = $report_type_date_array;

			$report_type_array['value'] = $report_type_value_array;

			$report_type_array['name'] =esc_html__("Arms Progress Report",'gym_mgt');

			$report_type_array['measurment_unit']=esc_html__(get_option('gmgt_arms_unit'),"gym_mgt");

		}

		if($report_type == 'Fat')

		{

			$report_type_array = array();

		

			if(isset($all_data['Fat']) && !empty($all_data['Fat']))

			foreach($all_data['Fat'] as $r)

			{

				$report_type_date_array[]= MJ_gmgt_getdate_in_input_box($r['date']);

				$report_type_value_array[]=(float)$r['result'];

			}

			//$report_type_array['date'] = implode(',',$report_type_date_array);

			//$report_type_array['value'] = implode(',',$report_type_value_array);

			$report_type_array['date'] = $report_type_date_array;

			$report_type_array['value'] = $report_type_value_array;

			$report_type_array['name'] =esc_html__("Fat Progress Report",'gym_mgt');

			$report_type_array['measurment_unit']=esc_html__(get_option('gmgt_fat_unit'),"gym_mgt");

		}

		if($report_type == 'member_attendance')
		{
		
			$report_type_array = array();
			$table_attendance = $wpdb->prefix .'gmgt_attendence';
			$table_class = $wpdb->prefix .'gmgt_class_schedule';
			$chart_array_Absent = array();
			$chart_array_Present = array();
			$report_2 =$wpdb->get_results("SELECT  at.class_id,
					SUM(case when `status` ='Present' then 1 else 0 end) as Present
					from $table_attendance as at,$table_class as cl where at.attendence_date >  DATE_SUB(NOW(), INTERVAL 1 WEEK) AND at.class_id = cl.class_id  AND at.role_name = 'member' GROUP BY at.class_id") ;
			$report_1 =$wpdb->get_results("SELECT  at.class_id,
					SUM(case when `status` ='Absent' then 1 else 0 end) as Absent
					from $table_attendance as at,$table_class as cl where at.attendence_date >  DATE_SUB(NOW(), INTERVAL 1 WEEK) AND at.class_id = cl.class_id  AND at.role_name = 'member' GROUP BY at.class_id") ;
	
			if(!empty($report_2))
			{
				foreach($report_2 as $result)
				{
					$class_id =MJ_gmgt_get_class_name($result->class_id);
					$chart_array_Present[] = array('x'=>"$class_id",'y'=>(int)$result->Present);
				}
				$chart_array_Present_color[]=array('color'=>"#F1C40E");
			}
			if(!empty($report_1))
			{
				foreach($report_1 as $result)
				{
					$class_id =MJ_gmgt_get_class_name($result->class_id);
					$chart_array_Absent[] = array('x'=>"$class_id",'y'=>(int)$result->Absent);
					//$chart_array_Absent="#535935";
				}
				$chart_array_Absent_color[]=array('color'=>"#535935");
			}
			if(!empty($chart_array_Present) && !empty($chart_array_Absent))
			{
				$report_type_array123[]['data'] = $chart_array_Present;
				$chart_array_Present_color1=call_user_func_array('array_merge', $chart_array_Present_color);
				$report_type_array[]=array_merge($report_type_array123[0],$chart_array_Present_color1);

				$report_type_array235[]['data'] = $chart_array_Absent;
				$chart_array_Absent_color1=call_user_func_array('array_merge', $chart_array_Absent_color);
				$report_type_array[]=array_merge($report_type_array235[0],$chart_array_Absent_color1);
			}
		}

		if($report_type == 'staff_attendance')
		{
		
			$report_type_array = array();
			$table_attendance = $wpdb->prefix .'gmgt_attendence';
			$table_class = $wpdb->prefix .'gmgt_class_schedule';
			$chart_array_Absent = array();
			$chart_array_Present = array();
			$report_2 =$wpdb->get_results("SELECT  at.user_id,SUM(case when `status` ='Present' then 1 else 0 end) as Present from $table_attendance as at where at.attendence_date >  DATE_SUB(NOW(), INTERVAL 1 WEEK)  AND at.role_name = 'staff_member' GROUP BY at.user_id") ;
			$report_1 =$wpdb->get_results("SELECT  at.user_id,SUM(case when `status` ='Absent' then 1 else 0 end) as Absent from $table_attendance as at where at.attendence_date >  DATE_SUB(NOW(), INTERVAL 1 WEEK)  AND at.role_name = 'staff_member' GROUP BY at.user_id") ;
			
			if(!empty($report_2))
			{
				foreach($report_2 as $result)
				{
					$user_name = MJ_gmgt_get_display_name($result->user_id);
					$chart_array_Present[] = array('x'=>"$user_name",'y'=>(int)$result->Present);
				}
				$chart_array_Present_color[]=array('color'=>"#F1C40E");
			}
			if(!empty($report_1))
			{
				foreach($report_1 as $result)
				{
					$user_name = MJ_gmgt_get_display_name($result->user_id);
					$chart_array_Absent[] = array('x'=>"$user_name",'y'=>(int)$result->Absent);
					//$chart_array_Absent="#535935";
				}
				$chart_array_Absent_color[]=array('color'=>"#535935");
			}
			if(!empty($chart_array_Present) && !empty($chart_array_Absent))
			{
				$report_type_array123[]['data'] = $chart_array_Present;
				$chart_array_Present_color1=call_user_func_array('array_merge', $chart_array_Present_color);
				$report_type_array[]=array_merge($report_type_array123[0],$chart_array_Present_color1);

				$report_type_array235[]['data'] = $chart_array_Absent;
				$chart_array_Absent_color1=call_user_func_array('array_merge', $chart_array_Absent_color);
				$report_type_array[]=array_merge($report_type_array235[0],$chart_array_Absent_color1);
			}
			
		}

		if($report_type == 'fees_payment_report')
		{
			$month =array('1'=>esc_html__('January','gym_mgt'),'2'=>esc_html__('February','gym_mgt'),'3'=>esc_html__('March','gym_mgt'),'4'=>esc_html__('April','gym_mgt'),'5'=>esc_html__('May','gym_mgt'),'6'=>esc_html__('June','gym_mgt'),'7'=>esc_html__('July','gym_mgt'),'8'=>esc_html__('August','gym_mgt'),'9'=>esc_html__('September','gym_mgt'),'10'=>esc_html__('October','gym_mgt'),'11'=>esc_html__('November','gym_mgt'),'12'=>esc_html__('December','gym_mgt'),);
			$year =isset($_POST['year'])?sanitize_text_field($_POST['year']):date('Y');

			$report_type_array = array();
			$table_name = $wpdb->prefix."gmgt_membership_payment_history";
			$chart_array_Absent = array();
			$chart_array_Present = array();
			$report_2 =$wpdb->get_results("SELECT EXTRACT(MONTH FROM paid_by_date) as date,sum(amount) as count FROM ".$table_name." WHERE YEAR(paid_by_date) =".$year." group by month(paid_by_date) ORDER BY paid_by_date ASC") ;
			
			if(!empty($report_2))
			{
				foreach($report_2 as $result)
				{
					$month_name = $month[$result->date];
					$chart_array_report[] = array('x'=>"$month_name",'y'=>(int)$result->count);
				}
				$chart_array_report_color[]=array('color'=>"#F1C40E");
			}
			
			$report_type_array123[]['data'] = $chart_array_report;
			$chart_array_report_color1=call_user_func_array('array_merge', $chart_array_report_color);
			$report_type_array[]=array_merge($report_type_array123[0],$chart_array_report_color1);

		}

		if($report_type == 'income_payment_report')
		{
			$month =array('1'=>esc_html__('January','gym_mgt'),'2'=>esc_html__('February','gym_mgt'),'3'=>esc_html__('March','gym_mgt'),'4'=>esc_html__('April','gym_mgt'),'5'=>esc_html__('May','gym_mgt'),'6'=>esc_html__('June','gym_mgt'),'7'=>esc_html__('July','gym_mgt'),'8'=>esc_html__('August','gym_mgt'),'9'=>esc_html__('September','gym_mgt'),'10'=>esc_html__('October','gym_mgt'),'11'=>esc_html__('November','gym_mgt'),'12'=>esc_html__('December','gym_mgt'),);
			$year =isset($_POST['year'])?sanitize_text_field($_POST['year']):date('Y');

			$report_type_array = array();
			$table_name = $wpdb->prefix."gmgt_income_payment_history";
			$table_name1 = $wpdb->prefix."gmgt_sales_payment_history";
			$chart_array_Absent = array();
			$chart_array_Present = array();
			$q="SELECT EXTRACT(MONTH FROM paid_by_date) as date,sum(amount) as count FROM ".$table_name." WHERE YEAR(paid_by_date) =".$year." group by month(paid_by_date) ORDER BY paid_by_date ASC";
			$q1="SELECT EXTRACT(MONTH FROM paid_by_date) as date,sum(amount) as count FROM ".$table_name1." WHERE YEAR(paid_by_date) =".$year." group by month(paid_by_date) ORDER BY paid_by_date ASC";

			$result_report=$wpdb->get_results($q);
			$result1=$wpdb->get_results($q1);
			$result_merge_array=array_merge($result,$result1);
			$sumArray = array(); 
			
			foreach ($result_merge_array as $value) 
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
			if(!empty($sumArray))
			{
				foreach($sumArray as $month_value=>$count)
				{
					$month_name = $month[$month_value];
					$chart_array_report_income[] = array('x'=>"$month_name",'y'=>(int)$count);
				}
				$chart_array_report_income_color[]=array('color'=>"#F1C40E");
			}
			
			$report_type_array3[]['data'] = $chart_array_report_income;
			$chart_array_report_income_color1=call_user_func_array('array_merge', $chart_array_report_income_color);
			$report_type_array[]=array_merge($report_type_array3[0],$chart_array_report_income_color1);

		}

		if($report_type == 'sell_product_report')
		{
			$month =array('1'=>esc_html__('January','gym_mgt'),'2'=>esc_html__('February','gym_mgt'),'3'=>esc_html__('March','gym_mgt'),'4'=>esc_html__('April','gym_mgt'),'5'=>esc_html__('May','gym_mgt'),'6'=>esc_html__('June','gym_mgt'),'7'=>esc_html__('July','gym_mgt'),'8'=>esc_html__('August','gym_mgt'),'9'=>esc_html__('September','gym_mgt'),'10'=>esc_html__('October','gym_mgt'),'11'=>esc_html__('November','gym_mgt'),'12'=>esc_html__('December','gym_mgt'),);
			$year =isset($_POST['year'])?sanitize_text_field($_POST['year']):date('Y');

			$report_type_array = array();
			$table_name = $wpdb->prefix."gmgt_store";
			$q1="SELECT * FROM ".$table_name." WHERE YEAR(sell_date) =".$year." AND payment_status='Fully Paid' ORDER BY sell_date ASC";
			$result_sell=$wpdb->get_results($q1);
			$month_wise_count=array();
			$chart_array_report_sell = array(); 
			$chart_array_report_sell_color = array(); 
			foreach($result_sell as $key=>$value)
			{
				$total_quantity=0;
				$all_entry=json_decode($value->entry);
				foreach($all_entry as $entry)
				{
					$total_quantity+=$entry->quentity;
				}	
				$sell_date = date_parse_from_format("Y-m-d",$value->sell_date);
				
				$month_wise_count[]=array('sell_date'=>$sell_date["month"],'quentity'=>$total_quantity);
			}
			$sumArray = array(); 
			foreach ($month_wise_count as $value1) 
			{ 
				$value2=(object)$value1;
				if(isset($sumArray[$value2->sell_date]))
				{
					$sumArray[$value2->sell_date] = $sumArray[$value2->sell_date] + (int)$value2->quentity;
				}
				else
				{
					$sumArray[$value2->sell_date] = (int)$value2->quentity; 
				}		
			}
			if(!empty($sumArray))
			{
				foreach($sumArray as $month_value=>$quentity)
				{
					$month_name = $month[$month_value];
					$chart_array_report_sell[] = array('x'=>"$month_name",'y'=>(int)$quentity);
				}
				$chart_array_report_sell_color[]=array('color'=>"#F1C40E");
			}
			
			$report_type_array3[]['data'] = $chart_array_report_sell;
			$chart_array_report_sell_color1=call_user_func_array('array_merge', $chart_array_report_sell_color);
			$report_type_array[]=array_merge($report_type_array3[0],$chart_array_report_sell_color1);

		}

		if($report_type == 'membership_report')
		{
			global $wpdb;
			$table_name = $wpdb->prefix."gmgt_membershiptype";
			$q="SELECT * From $table_name";
			$member_ship_array = array();
			$chart_array_report_membership = array();
			$chart_array_report_membership_color = array();
			$result_membership=$wpdb->get_results($q);
			foreach($result_membership as $retrive)
			{
				$membership_id = $retrive->membership_id;		
				$member_ship_count =  count(get_users(array('role'=>'member','meta_key' => 'membership_id', 'meta_value' => $retrive->membership_id)));
				$member_ship_array[] = array('member_ship_id'=>$membership_id,
											 'member_ship_count'=>	$member_ship_count
											);
			}
			if(!empty($member_ship_array))
			{
				foreach($member_ship_array as $r)
				{
					
					$membership_name =  MJ_gmgt_get_membership_name($r['member_ship_id']);
					$chart_array_report_membership[] = array('x'=>"$membership_name",'y'=>(int)$r['member_ship_count']);
				}
				$chart_array_report_membership_color[]=array('color'=>"#F1C40E");
			}
			
			$report_type_array3[]['data'] = $chart_array_report_membership;
			$chart_array_report_membership_color1=call_user_func_array('array_merge', $chart_array_report_membership_color);
			$report_type_array[]=array_merge($report_type_array3[0],$chart_array_report_membership_color1);

		}
	
		return $report_type_array;

	}
}
//GYM MANAGEMENT CLASS END
?>