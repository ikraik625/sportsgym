<?php

require_once GMS_PLUGIN_DIR. '/lib/vendor/autoload.php';

class MJ_gmgt_virtual_classroom

{

	// CREATE MEETING IN ZOOM

	public function MJ_gmgt_create_meeting_in_zoom($data)

	{

		

		global $wpdb;

		$staff_all_data = get_userdata($data['staff_id']);

		if(empty($data['password']))

		{

			$password = wp_generate_password( 10, true, true );

		}

		else

		{

			$password = $data['password'];

		}

		

		$clasname = $data['class_name'];

		$client = new GuzzleHttp\Client(['base_uri' => 'https://api.zoom.us']);

	    $arr_token = get_option('gmgt_virtual_classschedule_access_token');

    	$token_decode = json_decode($arr_token);

	    $accessToken = $token_decode->access_token;

	    $topic = $data['agenda'];

	    $start_time=$data['start_time'];

	    $end_time=$data['end_time'];

	    $weekday=$data['days'];

	

	    try 

	    {

	    	if ($data['action']=='edit')

			{

				$meetingId = $data['zoom_meeting_id'];

				$response = $client->request('PATCH', "/v2/meetings/{$meetingId}", [

		            "headers" => [

		                "Authorization" => "Bearer $accessToken"

		            ],

		            "Query" => [

		                "occurrence_id" => "u+56LsDKSTmVXefuuMG8ug=="

		            ],

		            'json' => [

		                "topic" => $clasname,

		                "type" => 8,

		                "start_time" => $start_time,

		                "password" => $password,

		                "agenda" => $data['agenda'],

		                "recurrence" => [

						"type" => 2,

						"weekly_days" => $weekday,

						"end_date_time" => $end_time,

						]

		            ],

		        ]);

			}

			else

			{

				$response = $client->request('POST', '/v2/users/me/meetings', [

	            "headers" => [

	                "Authorization" => "Bearer $accessToken"

	            ],

	            'json' => [

	                "topic" => $clasname,

	                "type" => 8,

	                "start_time" => $start_time,

	                "password" => $password,

	                "agenda" => $data['agenda'],

	                "recurrence" => [

					"type" => 2,

					"weekly_days" => $weekday,

					"end_date_time" => $end_time,

					]

		            ],

		        ]);

	

		        $meeting_response = json_decode($response->getBody());

				

			}

        	$table_zoom_meeting= $wpdb->prefix. 'gmgt_zoom_meeting';

        	$meeting_data['title'] = $clasname;

           	$meeting_data['class_id'] = (int)$data['class_id'];

        	$meeting_data['staff_id'] = (int)$data['staff_id'];

        	$meeting_data['agenda'] = $data['agenda'];

        	$meeting_data['start_date'] = $data['start_date'];

        	$meeting_data['end_date'] = $data['end_date'];

        	$meeting_data['start_time'] = $data['start_time'];

        	$meeting_data['end_time'] = $data['end_time'];

        	$meeting_data['weekdays'] = $weekday;

        	// $meeting_data['duration'] = (int)$data['duration'];

        	$meeting_data['password'] = $password;

        	if($data['action']=='edit')

			{

				$meeting_data['zoom_meeting_id'] = $data['zoom_meeting_id'];

        		$meeting_data['uuid'] = $data['uuid'];

				$meeting_data['meeting_join_link'] = $data['meeting_join_link'];

        		$meeting_data['meeting_start_link'] = $data['meeting_start_link'];

				$meetingid['meeting_id']=sanitize_text_field($data['meeting_id']);

				$meeting_data['updated_date']=date("Y-m-d h:i:sa");

			    $meeting_data['updated_by']=get_current_user_id();

				$result=$wpdb->update( $table_zoom_meeting, $meeting_data ,$meetingid);



			}

			else

			{

				if($meeting_response)

				{

				$meeting_data['zoom_meeting_id'] = $meeting_response->id;

        		$meeting_data['uuid'] = $meeting_response->uuid;

				$meeting_data['meeting_join_link'] = $meeting_response->join_url;

        		$meeting_data['meeting_start_link'] = $meeting_response->start_url;

				$meeting_data['created_by'] = get_current_user_id();

        		$meeting_data['created_date'] = date("Y-m-d h:i:sa");

				$result=$wpdb->insert( $table_zoom_meeting, $meeting_data );



				}

			}

			if($result)

			{

				// var_dump($meeting_response->occurrences);

				//---------- ADMISSION REQUEST MAIL ---------//

				if (!empty($meeting_response->occurrences))

				{

					$time = array();

					foreach ($meeting_response->occurrences as $data)

					{

						$timestamp = strtotime($data->start_time);

						$time[] = date('F j, Y H:i A', $timestamp);

					}

				}

				$string = array();

				$string['{{class_name}}']   = $clasname;

				$string['{{time}}'] = implode(PHP_EOL,$time);

				$string['{{virtual_class_id}}']   =  $meeting_response->id;

				$string['{{password}}']   =  $password;

				$string['{{join_zoom_virtual_class}}']   =  $meeting_response->join_url;

				$string['{{start_zoom_virtual_class}}']   =  $meeting_response->start_url;

				$string['{{GMGT_GYM_NAME}}'] =  get_option('gmgt_system_name');

				$MsgContent = get_option('virtual_class_invite_staff_mail_content');

				$MsgSubject	= get_option('virtual_class_invite_staff_mail_subject');

				$message = MJ_gmgt_string_replacemnet($string,$MsgContent);

				$MsgSubject = MJ_gmgt_string_replacemnet($string,$MsgSubject);

				$email= $staff_all_data->user_email;

				MJ_gmgt_send_mail($email,$MsgSubject,$message); 

				//MJgmgt_send_mail($to,$subject,$message_replacement); 

			}

			return $result;

		}

		catch(Exception $e) 

		{

			if(401 == $e->getCode())

			{

				MJ_gmgt_generate_access_token();

			}

			else

			{

				wp_redirect ( admin_url().'admin.php?page=gmgt_virtual_class&tab=meeting_list&message=5');

			}

		// }

		}

	}

	// GET ALL MEETING DATA IN ZOOM

	public function MJ_gmgt_get_all_meeting_data_in_zoom()

	{

		global $wpdb;

		$table_zoom_meeting= $wpdb->prefix. 'gmgt_zoom_meeting';

		$result = $wpdb->get_results("SELECT * FROM $table_zoom_meeting ORDER BY start_date DESC");

		return $result;

	}

	// GET MEETING BY CLASS ID DATA IN ZOOM

	public function MJ_gmgt_get_meeting_by_class_id_data_in_zoom($class_id)

	{

		global $wpdb;

		$table_zoom_meeting= $wpdb->prefix. 'gmgt_zoom_meeting';

		$result = $wpdb->get_results("SELECT * FROM $table_zoom_meeting WHERE class_id=$class_id");

		return $result;

	}

	// GET SINGAL MEETING DATA IN ZOOM

	public function MJ_gmgt_get_singal_meeting_data_in_zoom($meeting_id)

	{

		global $wpdb;

		$table_zoom_meeting= $wpdb->prefix. 'gmgt_zoom_meeting';

		$result = $wpdb->get_row("SELECT * FROM $table_zoom_meeting WHERE meeting_id=$meeting_id");

		return $result;

	}

	// GET SINGAL MEETING DATA BY ROUTE IN ZOOM

	public function MJ_gmgt_get_singal_meeting_by_class_data_in_zoom($class_id)

	{

		global $wpdb;

		$table_zoom_meeting= $wpdb->prefix. 'gmgt_zoom_meeting';

		$result = $wpdb->get_row("SELECT * FROM $table_zoom_meeting WHERE class_id=$class_id");

		return $result;

	}

	// DELETE MEETING

	public function MJ_gmgt_delete_meeting_in_zoom($meeting_id)

	{

		global $wpdb;

		// generate_access_token();

		$meeting_data = $this->MJ_gmgt_get_singal_meeting_data_in_zoom($meeting_id);

		try

		{

			if(!empty($meeting_data))

			{

				$client = new GuzzleHttp\Client(['base_uri' => 'https://api.zoom.us']);

				$arr_token = get_option('gmgt_virtual_classschedule_access_token');

		    	$token_decode = json_decode($arr_token);

			    $accessToken = $token_decode->access_token;

			    $zoom_meeting_id = $meeting_data->zoom_meeting_id;

			    $response = $client->request('DELETE', "/v2/meetings/{$zoom_meeting_id}", [

			    "headers" => [

			        "Authorization" => "Bearer $accessToken"

			    ]

			    ]);

			}

			$table_zoom_meeting= $wpdb->prefix. 'gmgt_zoom_meeting';

			$result = $wpdb->query("DELETE FROM $table_zoom_meeting WHERE meeting_id=$meeting_id");

		}catch(Exception $e){

	    	if(401 == $e->getCode())

			{

				MJ_gmgt_generate_access_token();

			}

			else

			{

				wp_redirect ( admin_url().'admin.php?page=gmgt_virtual_class&tab=meeting_list&message=5');

			}

	    }

		return $result;

	}

	// PAST PARTICIPEL LIST

	public function MJ_gmgt_view_past_participle_list_in_zoom($meeting_uuid)

	{

		// generate_access_token();

		$client = new GuzzleHttp\Client(['base_uri' => 'https://api.zoom.us']);

		$arr_token = get_option('gmgt_virtual_classschedule_access_token');

    	$token_decode = json_decode($arr_token);

	    $accessToken = $token_decode->access_token;

	    try

	    {

			$response = $client->request('GET', "v2/past_meetings/{$meeting_uuid}/participants", [

	            "headers" => [

	                "Authorization" => "Bearer $accessToken"

	            ],

	            "Query" =>[

	                "type" => 'past',

	                "page_size" => 30,

	                "include_fields" => 'device',

	            ]

	        ]);

	        $result = json_decode($response->getBody());

	    }catch(Exception $e)

	    {

	    	if(401 == $e->getCode())

			{

				MJ_gmgt_generate_access_token();

			}

			// elseif (404== $e->getCode()) 

			// {

			// 	wp_redirect ( admin_url().'admin.php?page=smgt_virtual_classroom&tab=meeting_list&message=6');

			// }

			// else

			// {

			// 	wp_redirect ( admin_url().'admin.php?page=smgt_virtual_classroom&tab=meeting_list&message=5');

			// }

	    }

	    return $result;

	}

	// GET SINGAL MEETING DATA BY ROUTE IN ZOOM

	public function MJ_gmgt_get_singal_meeting_join_link__class_id_in_zoom($class_id)

	{

		global $wpdb;

		$table_zoom_meeting= $wpdb->prefix. 'gmgt_zoom_meeting';

		$result = $wpdb->get_row("SELECT meeting_join_link FROM $table_zoom_meeting WHERE class_id=$class_id");

		if(!empty($result))

		{

			return $result->meeting_join_link;

		}

		

	}

}

?>