<?php 



$obj_nutrition=new MJ_gmgt_nutrition;



$active_tab = isset($_GET['tab'])?$_GET['tab']:'nutritionlist';



$role=MJ_gmgt_get_roles(get_current_user_id());



if($role == 'administrator')



{



	$user_access_add=1;



	$user_access_edit=1;



	$user_access_delete=1;



	$user_access_view=1;



}



else



{



	$user_access=MJ_gmgt_get_userrole_wise_manually_page_access_right_array_for_management('nutrition');



	$user_access_add=$user_access['add'];



	$user_access_edit=$user_access['edit'];



	$user_access_delete=$user_access['delete'];



	$user_access_view=$user_access['view'];



	if (isset ( $_REQUEST ['page'] ))



	{	



		if($user_access_view=='0')



		{	



			MJ_gmgt_access_right_page_not_access_message_for_management();



			die;



		}



		if(!empty($_REQUEST['action']))



		{



			if ('nutrition' == $user_access['page_link'] && ($_REQUEST['action']=='edit'))



			{



				if($user_access_edit=='0')



				{	



					MJ_gmgt_access_right_page_not_access_message_for_management();



					die;



				}			



			}



			if ('nutrition' == $user_access['page_link'] && ($_REQUEST['action']=='delete'))



			{



				if($user_access_delete=='0')



				{	



					MJ_gmgt_access_right_page_not_access_message_for_management();



					die;



				}	



			}



			if ('nutrition' == $user_access['page_link'] && ($_REQUEST['action']=='insert'))



			{



				if($user_access_add=='0')



				{	



					MJ_gmgt_access_right_page_not_access_message_for_management();



					die;



				}	



			} 



		}



	}



}



?>



<!-- POP up code -->



<div class="popup-bg">



    <div class="overlay-content">



		<div class="modal-content">



			<div class="category_list"></div>



		</div>



    </div> 



</div>



<!-- End POP-UP Code -->



<div class="page-inner min_height_1631"><!--PAGE INNER DIV START-->



	<?php 



	//SAVE Nutrition DATA



	if(isset($_POST['save_nutrition']))



	{



		$nonce = $_POST['_wpnonce'];



		if (wp_verify_nonce( $nonce, 'save_nutrition_nonce' ) )



		{



			if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit')



			{				



				$result=$obj_nutrition->MJ_gmgt_add_nutrition($_POST);



				if($result)



				{



					wp_redirect ( admin_url().'admin.php?page=gmgt_nutrition&tab=nutritionlist&message=2');



				}	



			}



			else



			{



				$result=$obj_nutrition->MJ_gmgt_add_nutrition($_POST);



				if($result)



				{



					wp_redirect ( admin_url().'admin.php?page=gmgt_nutrition&tab=nutritionlist&message=1');



				}



			}



		}



	}



	//DELETE Nutrition DATA



	if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')



	{



		$result=$obj_nutrition->MJ_gmgt_delete_nutrition($_REQUEST['nutrition_id']);



		if($result)



		{



			wp_redirect ( admin_url().'admin.php?page=gmgt_nutrition&tab=nutritionlist&message=3');



		}



	}



	if(isset($_REQUEST['message']))



	{



		$message =esc_attr($_REQUEST['message']);



		if($message == 1)



		{?>



			<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">



				<p><?php esc_html_e('Nutrition added successfully.','gym_mgt');?></p>



				<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>



			</div>



		<?php	



		}



		elseif($message == 2)



		{?>



			<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">



				<p><?php esc_html_e("Nutrition updated successfully.",'gym_mgt');?></p>



				<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>



			</div>



		<?php	



		}



		elseif($message == 3) 



		{?>



			<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">



				<p><?php esc_html_e('Nutrition deleted successfully.','gym_mgt');?></p>



				<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>



			</div>	



		<?php		



		}



	}



	?>



	<div id="" class="gms_main_list"><!--MAIN WRAPPER DIV START-->



		<div class="row"><!--ROW DIV START-->



			<div class="col-md-12"><!--COL 12 DIV START-->



				<div class="float_left_width_100"><!--PANEL WHITE DIV START-->



					<div class="panel-body padding_0"><!--PANEL BODY DIV START-->



						<?php 						



						if($active_tab == 'nutritionlist')



						{



							$get_members = array('role' => 'member');



							$membersdata=get_users($get_members);



							if(!empty($membersdata))



							{



								?>	



								<script type="text/javascript">



									$(document).ready(function()



									{



										"use strict";



										jQuery('#nutrition_list').DataTable(



										{



											// "responsive": true,



											"order": [[ 1, "asc" ]],



											dom: 'lifrtp',



											"aoColumns":[



														{"bSortable": false},



														{"bSortable": true},



														{"bSortable": true},



														{"bSortable": false}],



												language:<?php echo MJ_gmgt_datatable_multi_language();?>			  



										});



										$('.dataTables_filter input').attr("placeholder", "<?php esc_html_e('Search...', 'gym_mgt') ?>");



									} );



								</script>



								<form name="wcwm_report" action="" method="post"><!--Nutrition LIST FORM START-->



									<div class="panel-body padding_0"><!--PANEL WHITE DIV START-->



										<div class="table-responsive"><!--TABLE RESPONSIVE DIV START-->



											<table id="nutrition_list" class="display" cellspacing="0" width="100%"><!--Nutrition LIST TABLE START-->



												<thead class="<?php echo MJ_gmgt_datatable_heder(); ?>">

													<tr>

														<th><?php esc_html_e('Photo','gym_mgt');?></th>

														<th><?php esc_html_e('Member Name','gym_mgt');?></th>

														<th><?php esc_html_e('Member Goal','gym_mgt');?></th>

														<th  class="text_align_end"><?php esc_html_e('Action','gym_mgt');?></th>

													</tr>

												</thead>

												<tbody>



												<?php



												if(!empty($membersdata))



												{



													foreach ($membersdata as $retrieved_data)



													{



														if( $retrieved_data->member_type == "Member" && $retrieved_data->membership_status == "Continue")



														{



															?>



															<tr>



																<td class="user_image width_50px padding_left_0"><?php $uid=$retrieved_data->ID;



																	$userimage=get_user_meta($uid, 'gmgt_user_avatar', true);



																	if(empty($userimage))



																	{



																		echo '<img src='.get_option( 'gmgt_nutrition_thumb' ).' height="50px" width="50px" class="img-circle" />';



																	}



																	else



																		echo '<img src='.$userimage.' height="50px" width="50px" class="img-circle"/>';



																	?>



																</td>



																<td class="member">



																	<a href="?page=gmgt_nutrition&tab=addnutrition&action=view&workoutmember_id=<?php echo esc_attr($retrieved_data->ID);?>"><?php echo MJ_gmgt_get_member_full_display_name_with_memberid(esc_html($retrieved_data->ID));?></a>



																	<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Member Name','gym_mgt');?>" ></i>



																</td>



																<td class="member-goal">



																	<?php



																	$intrestid=get_user_meta($retrieved_data->ID,'intrest_area',true); 



																	//echo get_the_title(esc_html($intrestid));



																	if(!empty($intrestid))



																	{



																		echo get_the_title($intrestid);



																	}



																	else



																	{



																		echo "N/A";



																	}



																	?>



																	<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Member Goal','gym_mgt');?>" ></i>



																</td>



																<td class="action"> 



																	<div class="gmgt-user-dropdown">



																		<ul class="" style="margin-bottom: 0px !important;">



																			<li class="">



																				<a class="" href="#" data-bs-toggle="dropdown" aria-expanded="false">



																					<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/More.png"?>" >



																				</a>



																				<ul class="dropdown-menu heder-dropdown-menu action_dropdawn" aria-labelledby="dropdownMenuLink">



																					<li class="float_left_width_100">



																						<a href="?page=gmgt_nutrition&tab=addnutrition&action=view&workoutmember_id=<?php echo esc_attr($retrieved_data->ID);?>" class="float_left_width_100"><i class="fa fa-edit"></i><?php esc_html_e('Edit Nutrition', 'gym_mgt' ) ;?></a>



																					</li>	



																				</ul>



																			</li>



																		</ul>



																	</div>	



																</td>



															</tr>



															<?php



														}



													} 											



												}?>



												</tbody>              



											</table><!--Nutrition LIST TABLE END-->



										</div><!--TABLE RESPONSIVE DIV END-->



									</div>	<!--PANEL WHITE DIV END-->					   



								</form><!--Nutrition LIST FORM END-->



								<?php 



							}



							else



							{

								if($user_access_add == 1)

								{

									?>



									<div class="no_data_list_div"> 



										<a href="<?php echo admin_url().'admin.php?page=gmgt_nutrition&tab=addnutrition';?>">



											<img class="width_100px" src="<?php echo get_option( 'gmgt_no_data_img' ) ?>" >



										</a>



										<div class="col-md-12 dashboard_btn margin_top_20px">



											<label class="no_data_list_label"><?php esc_html_e('Tap on above icon to add your first Record.','gym_mgt'); ?> </label>



										</div> 



									</div>		



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



							}



						}



						if($active_tab == 'addnutrition')



						{



							require_once GMS_PLUGIN_DIR. '/admin/nutrition/add_nutrition.php';



						}



						?>



					</div><!--PANEL BODY DIV END-->



				</div><!--PANEL WHITE DIV END-->



			</div><!--COL 12 DIV END-->



		</div><!--ROW DIV END-->



	</div><!--MAIN WRAPPER DIV END-->



</div><!--PAGE INNER DIV END-->