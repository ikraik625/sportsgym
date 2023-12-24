<?php 



$curr_user_id=get_current_user_id();



$obj_gym=new MJ_gmgt_Gym_management($curr_user_id);



$obj_membership=new MJ_gmgt_membership;



$obj_class=new MJ_gmgt_classschedule;



$obj_group=new MJ_gmgt_group;



$obj_member=new MJ_gmgt_member;



$role="member";



$active_tab = isset($_GET['tab'])?$_GET['tab']:'memberlist';



//access right



$user_access=MJ_gmgt_get_userrole_wise_page_access_right_array();



if (isset ( $_REQUEST ['page'] ))



{	



	if($user_access['view']=='0')



	{	



		MJ_gmgt_access_right_page_not_access_message();



		die;



	}



}



	//SAVE MEMBER DATA



	if(isset($_POST['save_member']))		



	{



		$nonce = $_POST['_wpnonce'];



		if (wp_verify_nonce( $nonce, 'save_member_nonce' ) )



		{



			if(isset($_FILES['upload_user_avatar_image']) && !empty($_FILES['upload_user_avatar_image']) && $_FILES['upload_user_avatar_image']['size'] !=0)



			{	



				if($_FILES['upload_user_avatar_image']['size'] > 0)



				{



				$member_image=MJ_gmgt_load_documets(esc_url($_FILES['upload_user_avatar_image']),'upload_user_avatar_image','pimg');



							$member_image_url=content_url().'/uploads/gym_assets/'.$member_image;



				}



			}



			else



			{



				if(isset($_REQUEST['hidden_upload_user_avatar_image']))



				{



					$member_image=esc_url($_REQUEST['hidden_upload_user_avatar_image']);



					$member_image_url=$member_image;



				}



			}



			if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit')



			{



				$result=$obj_member->MJ_gmgt_gmgt_add_user($_POST);	



					$returnans=update_user_meta( $result,'gmgt_user_avatar',$member_image_url);



				if($result)



				{



					if(isset($_REQUEST['page_action']) && $_REQUEST['page_action'] == 'web_view_hide')



					{



						wp_redirect ( home_url().'?dashboard=user&page=member&tab=memberlist&page_action=web_view_hide&member_list_app=memberlist_app&message=2');



					}



					else



					{



						wp_redirect ( home_url().'?dashboard=user&page=member&tab=memberlist&message=2');



					}



					



				}	



			}



			else



			{



				if( !email_exists( $_POST['email'] )) 



				{	



					$result=$obj_member->MJ_gmgt_gmgt_add_user($_POST);



						$returnans=update_user_meta( $result,'gmgt_user_avatar',$member_image_url);



					if($result>0)



					{



						if(isset($_REQUEST['member_list_app']) && $_REQUEST['member_list_app'] == 'memberlist_app')



						{



							wp_redirect ( home_url().'?dashboard=user&page=member&tab=memberlist&page_action=web_view_hide&member_list_app=memberlist_app&message=1');



						}



						else



						{



							wp_redirect ( home_url().'?dashboard=user&page=member&tab=memberlist&message=1');



						}



						//wp_redirect ( home_url() . '?dashboard=user&page=member&tab=memberlist&message=1');



					}



				}



				else



				{?>



					<div id="message" class="alert_msg alert alert-success alert-dismissible " role="alert">



						<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span>



						</button>



						<p><?php esc_html_e('Username Or Email id exists already.','gym_mgt');?></p>



					</div>



		<?php }



			}



		}



	}



	//DELETE MEMBER DATA



	if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')



	{



		$result=$obj_member->MJ_gmgt_delete_usedata($_REQUEST['member_id']);



		if($result)



		{



			if(isset($_REQUEST['page_action']) && $_REQUEST['page_action'] == 'web_view_hide')



			{



				wp_redirect ( home_url().'?dashboard=user&page=member&tab=memberlist&page_action=web_view_hide&member_list_app=memberlist_app&message=3');



			}



			else



			{



				wp_redirect ( home_url().'?dashboard=user&page=member&tab=memberlist&message=3');



			}



			//wp_redirect ( home_url().'?dashboard=user&page=member&tab=memberlist&message=3');



		}



	}



	if(isset($_REQUEST['message']))



	{



		$message =esc_attr($_REQUEST['message']);



		if($message == 1)



		{  



		?>



			<div id="message" class="alert_msg alert alert-success alert-dismissible " role="alert">



				<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span>



				</button>



				<p><?php esc_html_e('Member added successfully.','gym_mgt');?></p>



			</div>



		<?php 



		}



		elseif($message == 2)



		{ ?>



			<div id="message" class="alert_msg alert alert-success alert-dismissible " role="alert">



				<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span>



				</button>



				<p><?php esc_html_e("Member updated successfully.",'gym_mgt');?></p>



			</div>



		<?php 



		}



		elseif($message == 3) 



		{ ?>



			<div id="message" class="alert_msg alert alert-success alert-dismissible " role="alert">



				<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span>



				</button>



				<p><?php esc_html_e('Member deleted successfully.','gym_mgt');?></p>



			</div>



		<?php		



		}



	}



	?>



	<script type="text/javascript">



		$(document).ready(function() 



		{



			"use strict";



			$('#member_form').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});	



			$('#add_staff_form').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1}); 



			$('#membership_form').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});	 



			$('#class_form').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});		 



			$("#group_form").validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});



			$('#group_id').multiselect(



			{



				nonSelectedText :'<?php esc_html_e('Select Group','gym_mgt');?>',



				includeSelectAllOption: true,



				allSelectedText :'<?php esc_html_e('All Selected','gym_mgt'); ?>',



				selectAllText : '<?php esc_html_e('Select all','gym_mgt'); ?>',



				templates: {



						button: '<button class="multiselect btn btn-default dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><span class="multiselect-selected-text"></span><b class="caret"></b></button>',



					},



				buttonContainer: '<div class="dropdown" />'



			});	



			



			$('.classis_ids').multiselect(



			{



				nonSelectedText :'<?php esc_html_e('Select Class','gym_mgt');?>',



				includeSelectAllOption: true,



				allSelectedText :'<?php esc_html_e('All Selected','gym_mgt'); ?>',



				selectAllText : '<?php esc_html_e('Select all','gym_mgt'); ?>',



				templates: {



						button: '<button class="multiselect btn btn-default dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><span class="multiselect-selected-text"></span><b class="caret"></b></button>',



					},



				buttonContainer: '<div class="dropdown" />'



			});	



			



			$('#specialization').multiselect(



			{



				nonSelectedText :'<?php esc_html_e('Select Specialization','gym_mgt');?>',



				includeSelectAllOption: true,



				allSelectedText :'<?php esc_html_e('All Selected','gym_mgt'); ?>',



				selectAllText : '<?php esc_html_e('Select all','gym_mgt'); ?>',



				templates: {



						button: '<button class="multiselect btn btn-default dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><span class="multiselect-selected-text"></span><b class="caret"></b></button>',



					},



				buttonContainer: '<div class="dropdown" />'



			});	



			



			$('#day').multiselect(



			{



				nonSelectedText :'<?php esc_html_e('Select Day','gym_mgt');?>',



				includeSelectAllOption: true,



				allSelectedText :'<?php esc_html_e('All Selected','gym_mgt'); ?>',



				selectAllText : '<?php esc_html_e('Select all','gym_mgt'); ?>',



				templates: {



						button: '<button class="multiselect btn btn-default dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><span class="multiselect-selected-text"></span><b class="caret"></b></button>',



					},



				buttonContainer: '<div class="dropdown" />'



			});	



			



			$('#class_membership_id').multiselect(



			{



				nonSelectedText :'<?php esc_html_e('Select Membership','gym_mgt');?>',



				includeSelectAllOption: true,



				allSelectedText :'<?php esc_html_e('All Selected','gym_mgt'); ?>',



				selectAllText : '<?php esc_html_e('Select all','gym_mgt'); ?>',



				templates: {



						button: '<button class="multiselect btn btn-default dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><span class="multiselect-selected-text"></span><b class="caret"></b></button>',



					},



				buttonContainer: '<div class="dropdown" />'



			});	



			$("body").on("click",".specialization_submit",function(){



				checked = $(".multiselect_validation_staff .dropdown-menu input:checked").length;



				if(!checked)



				{



					alert("<?php esc_html_e('Please select atleast one specialization','gym_mgt');?>");



					return false;



				}	



			});



			$("body").on("click",".class_submit",function(){



				checked = $(".multiselect_validation_member .dropdown-menu input:checked").length;



				if(!checked)



				{



					alert("<?php esc_html_e('Please select atleast one class','gym_mgt');?>");



					return false;



				}	



			});

			$(".class_submit").on('click',function()



			{



				var checked = $(".multiselect_validation_member .dropdown-menu input:checked").length;



				if(!checked)



				{



					var Member_type_val = $('.Member_type_val').val();



					if(Member_type_val != 'Prospect')



					{



						alert("<?php esc_html_e('Please select atleast one class','gym_mgt');?>");



						return false;



					}



					



				}



			}); 



			$("body").on("click",".day_validation_submit",function(){



				checked = $(".day_validation_member .dropdown-menu input:checked").length;



				if(!checked)



				{



					alert("<?php esc_html_e('Please select atleast One Day','gym_mgt');?>");



					return false;



				}	  



			}); 



			$.datepicker.setDefaults($.datepicker.regional['<?php echo MJ_gmgt_get_current_lan_code(); ?>']);



			jQuery('.birth_date').datepicker(



			{



				dateFormat: '<?php echo get_option('gmgt_datepicker_format');?>',



				maxDate : 0,



				changeMonth: true,



				changeYear: true,



				yearRange:'-65:+25',



				beforeShow: function (textbox, instance) 



				{



					instance.dpDiv.css({



						marginTop: (-textbox.offsetHeight) + 'px'                   



					});



				},    



				onChangeMonthYear: function(year, month, inst) {



					jQuery(this).val(month + "/" + year);



				}                    



			}); 



			var date = new Date();



			date.setDate(date.getDate()-0);



			$('#inqiury_date').datepicker(



			{	



				<?php



				if(get_option('gym_enable_datepicker_privious_date')=='no')



				{



				?>



					minDate:'today',



					startDate: date,



				<?php



				}



				?>



				dateFormat:'<?php echo get_option('gmgt_datepicker_format');?>',		



				autoclose: true



			});



			var date = new Date();



			date.setDate(date.getDate()-0);



			$('#triel_date').datepicker({



				<?php



				if(get_option('gym_enable_datepicker_privious_date')=='no')



				{



				?>



					minDate:'today',



					startDate: date,



				<?php



				}



				?>	



				dateFormat:'<?php echo get_option('gmgt_datepicker_format');?>',		



				autoclose: true



			});	   



			var date = new Date();



			date.setDate(date.getDate()-0);



			$('#begin_date').datepicker(



			{



				dateFormat:'<?php echo get_option('gmgt_datepicker_format');?>',



				<?php



				if(get_option('gym_enable_datepicker_privious_date')=='no')



				{



				?>



					minDate:'today',



					startDate: date,



				<?php



				}



				?>	



				autoclose: true



			});



			var date = new Date();



			date.setDate(date.getDate()-0);



			$('#first_payment_date').datepicker(



			{



				dateFormat:'<?php echo get_option('gmgt_datepicker_format');?>',



				<?php



				if(get_option('gym_enable_datepicker_privious_date')=='no')



				{



				?>



					minDate:'today',



					startDate: date,



				<?php



				}



				?>	



				autoclose: true



			});



			//------ADD GROUP AJAX----------	



			$('#group_form').on('submit', function(e)



			{



				e.preventDefault();



				var form = $(this).serialize();



				var valid = $("#group_form").validationEngine('validate');



				if (valid == true)



				{



					$('.modal').modal('hide');



				}



				var categCheck_group = $('#group_id').multiselect();	



				$.ajax(



				{



					type:"POST",



					url: $(this).attr('action'),



					data:form,



					success: function(data){



						if(data!=""){ 



							$('#group_form').trigger("reset");



							$('#group_id').append(data);



							categCheck_group.multiselect('rebuild');	



						}



					},



					error: function(data){



					}



				})



			});



			//------ADD CLASS AJAX----------



			$('#class_form').on('submit', function(e) {



				e.preventDefault(); 



				var form = $(this).serialize();



				



				var categCheck_class = $('#classis_id').multiselect();	



				var categCheck_day = $('#day').multiselect();	



				var categCheck_class_membership = $('#class_membership_id').multiselect();	



				var valid = $('#class_form').validationEngine('validate');



				if (valid == true)



				{



					$('.modal').modal('hide');



				}



				$.ajax({



					type:"POST",



					url: $(this).attr('action'),



					data:form,



					success: function(data){



						if(data!=""){ 



							



							$('#class_form').trigger("reset");



							$('#classis_id').append(data);



							categCheck_class.multiselect('rebuild');	



							categCheck_day.multiselect('rebuild');	



							categCheck_class_membership.multiselect('rebuild');	



						}



					},



						error: function(data){



					}



				})



			});



		} );



	</script>



<!-- POP up code -->



<div class="popup-bg">



    <div class="overlay-content">



		<div class="modal-content">



			<div class="category_list"> </div>		 



		</div>



    </div>     



</div>



<!-- End POP-UP Code -->



	<div class="tab-content padding_0"><!--TAB CONTENT DIV START-->   



		<?php 



		if($active_tab == 'memberlist')



		{



			?>



			<div class="gms_main_list"><!-- MAIN_LIST_MARGING_15px START -->



				<div class="tab-pane <?php if($active_tab == 'memberlist') echo "fade active in";?>" ><!--TAB pane DIV START-->   



					



					<form method="post">  



						<!-- <div class="mb-3 row" <?php if(isset($_REQUEST['page_action']) && $_REQUEST['page_action'] == 'web_view_hide') { ?> style="display: none;" <?php }?>>



							<div class="form-group col-md-3 padding_right_0">



								<label class=""><?php esc_html_e('Member type','gym_mgt');?></label>



								<select name="member_type" class="form-control validate[required]" id="member_type">



									<option value=""><?php  esc_html_e('Select Member Type','gym_mgt');?></option>



									<?php



									if(isset($_POST['member_type']))



									{



										$mtype=sanitize_text_field($_POST['member_type']);



									}



									else



									{



										$mtype="";



									}



									$membertype_array=MJ_gmgt_member_type_array();	



									if(!empty($membertype_array))



									{



										foreach($membertype_array as $key=>$type)



										{							



											echo '<option value='.esc_attr($key).' '.selected(esc_attr($mtype),esc_attr($type)).'>'.esc_html($type).'</option>';



										}



									}



									?>



								</select>



							</div>



							<div class="form-group col-md-3 button-possition padding_left_0">



								<label for="subject_id">&nbsp;</label>



								<input type="submit" value="<?php esc_html_e('Go','gym_mgt');?>" name="filter_membertype"  class="btn btn-info"/>



							</div>



						</div> -->



						<?php 



						if(isset($_REQUEST['filter_membertype']))



						{



						



							if(isset($_REQUEST['member_type']) && $_REQUEST['member_type'] != "")



							{



								$member_type= esc_attr($_REQUEST['member_type']);



								if($obj_gym->role == 'member')



								{



									if($user_access['own_data']=='1')



									{



										$user_id=get_current_user_id();



										$user_membershiptype= get_user_meta( $user_id, 'member_type',true ); 



										if($user_membershiptype==$member_type)



										{



											$membersdata=array();



											$membersdata[] = get_userdata($user_id);		



										}



									}



									else



									{



										$membersdata = get_users(array('meta_key' => 'member_type', 'meta_value' =>$member_type,'role'=>'member'));



									}



								}



								elseif($obj_gym->role == 'staff_member')



								{



									if($user_access['own_data']=='1')



									{



										$membersdata = get_users(array('meta_key' => 'member_type', 'meta_value' =>$member_type,'meta_query'=> array(array('key' => 'staff_id','value' =>$curr_user_id ,'compare' => '=')),'role'=>'member'));	



									}



									else



									{



										$membersdata = get_users(array('meta_key' => 'member_type', 'meta_value' =>$member_type,'role'=>'member'));



									}



								}



								else



								{



									$membersdata = get_users(array('meta_key' => 'member_type', 'meta_value' =>$member_type,'role'=>'member'));



								}



							}



							else



							{



								if($obj_gym->role == 'member')



								{	



									if($user_access['own_data']=='1')



									{



										$user_id=get_current_user_id();



										$membersdata=array();



										$membersdata[] = get_userdata($user_id);			



									}



									else



									{



										$membersdata =get_users( array('role' => 'member'));



									}	



									//die;



								}



								elseif($obj_gym->role == 'staff_member')



								{



									if($user_access['own_data']=='1')



									{



										$membersdata = get_users(array('meta_key' => 'staff_id', 'meta_value' =>$curr_user_id ,'role'=>'member'));



									}



									else



									{



										$membersdata =get_users( array('role' => 'member'));



									}



								}



								else



								{



									$membersdata =get_users( array('role' => 'member'));



								}	



							}



						}	



						else 



						{



							if($obj_gym->role == 'member')



							{	



								if($user_access['own_data']=='1')



								{



									$user_id=get_current_user_id();



									$membersdata=array();



									$membersdata[] = get_userdata($user_id);			



								}



								else



								{



									$membersdata =get_users( array('role' => 'member'));



								}	



								



								//die;



							}



							elseif($obj_gym->role == 'staff_member')



							{



								if($user_access['own_data']=='1')



								{



									$membersdata = get_users(array('meta_key' => 'staff_id', 'meta_value' =>$curr_user_id ,'role'=>'member'));



								}



								else



								{



									$membersdata =get_users( array('role' => 'member'));



								}



							}



							else



							{



								$membersdata =get_users( array('role' => 'member'));



							}				



						}



						?>				   



					</form>



					<?php



					if(!empty($membersdata))



					{



						?>



						<script type="text/javascript">



							$(document).ready(function() 



							{   



								jQuery('#members_list').DataTable({



								// "responsive": true,



								"order": [[ 1, "asc" ]],



								dom: 'lifrtp',



								"aoColumns":[



											{"bSortable": false},



											// {"bSortable": false},



											// {"bSortable": true},



											{"bSortable": true},



											{"bSortable": true},



											{"bSortable": true},



											{"bSortable": true},



											{"bSortable": true},



											{"bSortable": true},



											{"bSortable": false}],



										language:<?php echo MJ_gmgt_datatable_multi_language();?>		  



								});	



								$('.dataTables_filter input').attr("placeholder", "<?php esc_html_e('Search...', 'gym_mgt') ?>");



								



							} );



						</script>







						<div class="panel-body padding_0"><!--PANEL BODY DIV START-->   



							<div class="table-responsive"><!--TABLE RESPONSIVE DIV START-->   



								<table id="members_list" class="display" cellspacing="0" width="100%"><!--MEMBERSHIP LIST TABLE START-->   



									<thead class="<?php echo MJ_gmgt_datatable_heder(); ?>">



										<tr id="height_50">



										<th><?php esc_html_e('Photo','gym_mgt');?></th>



											<th><?php esc_html_e( 'Member Name & Email', 'gym_mgt' ) ;?></th>



											<th><?php esc_html_e( 'Member Id', 'gym_mgt' ) ;?></th>



											<th><?php esc_html_e( 'Member Type', 'gym_mgt' ) ;?></th>



											<th><?php esc_html_e( 'Joining Date', 'gym_mgt' ) ;?></th>



											<th><?php esc_html_e( 'Expiry Date', 'gym_mgt' ) ;?></th>



											<th id="width_50"><?php esc_html_e( 'Membership Status', 'gym_mgt' ) ;?></th>



											<th  class="text_align_end"><?php  esc_html_e( 'Action', 'gym_mgt' ) ;?></th>							



										</tr>



									</thead>						 



									<tbody>



										<?php 		



										if(!empty($membersdata))



										{



											foreach ($membersdata as $retrieved_data)



											{	



												if($obj_gym->role == 'member')



												{					



													?>



														<tr>



															<td class="user_image width_50px padding_left_0">



																<?php 



																$uid=$retrieved_data->ID;



																$userimage=get_user_meta($uid, 'gmgt_user_avatar', true);



																if(empty($userimage))



																{



																	echo '<img src='.get_option( 'gmgt_member_logo' ).' id="width_50" class="height_50 img-circle" />';



																}



																else



																	echo '<img src='.$userimage.' id="width_50" class="height_50 img-circle"/>';



																?>



															</td>



															<td class="name">



																<?php 



																	if($obj_gym->role == 'staff_member' || ($obj_gym->role == 'member' && $retrieved_data->ID==$curr_user_id))



																	{



																		?>



																		<a class="color_black" href="?dashboard=user&page=member&tab=viewmember&action=view&member_id=<?php echo esc_attr($retrieved_data->ID);?>">



																			<?php echo esc_html(MJ_gmgt_get_user_full_display_name($retrieved_data->ID));?>



																		</a><br>



																		<label class="list_page_email"><?php echo $retrieved_data->user_email;?></label>



																		<?php



																	}



																	else



																	{



																		?>



																		<a class="color_black" href="#">



																			<?php echo esc_html(MJ_gmgt_get_user_full_display_name($retrieved_data->ID));?>



																		</a><br>



																		<label class="list_page_email"><?php echo $retrieved_data->user_email;?></label>



																		<?php



																	}



																?>



															</td>



															<td class="memberid">



																<?php echo esc_html($retrieved_data->member_id);?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Member Id','gym_mgt');?>" ></i>



															</td>



															<td class="memberid"><?php if(isset($retrieved_data->member_type)) { echo esc_html($membertype_array[$retrieved_data->member_type]);  }else{ echo esc_html__('Not Selected','gym_mgt');}?>  <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Member Type','gym_mgt');?>" ></i></td>



															<td class="joining date">
															<?php if(!empty($retrieved_data->begin_date))
															{
																echo MJ_gmgt_getdate_in_input_box($retrieved_data->begin_date);
															}
															else
															{ 
																echo "N/A";
															} ?>  <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Joining Date','gym_mgt');?>" ></i></td>



															<td class="joining date"><?php if(!empty($retrieved_data->begin_date)) 
															{ 
																echo MJ_gmgt_getdate_in_input_box(MJ_gmgt_check_membership($retrieved_data->ID)); 
															}
															else
															{ 
																echo "N/A"; 
															}?>  <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Expiry Date','gym_mgt');?>" ></i></td>



															<td class="status"><?php if($retrieved_data->membership_status == "")
															{ 
																echo "N/A";
															}
															elseif($retrieved_data->member_type != 'Prospect')
															{
																esc_html_e($retrieved_data->membership_status,'gym_mgt');
															}
															else
															{ 
																esc_html_e('Prospect','gym_mgt'); 
															} ?>  <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Membership Status','gym_mgt');?>" ></i></td>



															<td class="action"> 



																<div class="gmgt-user-dropdown">



																	<ul class="" style="margin-bottom: 0px !important;">



																		<li class="">



																			<a class="" href="#" data-bs-toggle="dropdown" aria-expanded="false">



																				<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/More.png"?>" >



																			</a>



																			<ul class="dropdown-menu heder-dropdown-menu action_dropdawn" aria-labelledby="dropdownMenuLink">



																				<?php 



																				if($obj_gym->role == 'staff_member' || ($obj_gym->role == 'member' && $retrieved_data->ID==$curr_user_id))



																				{



																					?>



																					<li class="float_left_width_100">



																						<a href="?dashboard=user&page=member&tab=viewmember&action=view&member_id=<?php echo esc_attr($retrieved_data->ID);?>"  class="float_left_width_100"><i class="fa fa-eye"></i><?php esc_html_e('View','gym_mgt');?></a>



																					</li>

																					<?php

																					if($user_access['delete']=='1'){

																					?>

																					<li class="float_left_width_100">



																

																						<a href="?dashboard=user&page=member&action=delete&member_id=<?php echo esc_attr($retrieved_data->ID);?>" class="float_left_width_100 list_delete_btn" onclick="return confirm('<?php esc_html_e('Are you sure you want to delete this record?','gym_mgt');?>');"><i class="fa fa-trash"></i><?php esc_html_e( 'Delete', 'gym_mgt' ) ;?> </a>





																					</li>

																					<?php

																					}

																					?>



																					<!-- <li class="float_left_width_100">



																						<a href="?dashboard=user&page=member&tab=add_attendence&member_id=<?php echo esc_attr($retrieved_data->ID);?>&attendance=1" class="float_left_width_100" idtest="<?php echo esc_attr($retrieved_data->ID); ?>"><i class="fa fa-eye"></i> <?php esc_html_e('View Attendance','gym_mgt');?> </a>



																					</li> -->



																					<?php 



																				}?>



																			</ul>



																		</li>



																	</ul>



																</div>	



															</td>



														</tr>



													<?php



												}



												elseif($obj_gym->role == 'staff_member')



												{					



													$havemeta = get_user_meta($retrieved_data->ID, 'gmgt_hash', true);



													



													if(!$havemeta) 



													{ ?>



														<tr>



															<td class="user_image width_50px padding_left_0">



																<?php $uid=$retrieved_data->ID;



																$userimage=get_user_meta($uid, 'gmgt_user_avatar', true);



																if(empty($userimage))



																{



																	echo '<img src='.get_option( 'gmgt_member_logo').' id="width_50" class="height_50 img-circle" />';



																}



																else



																	echo '<img src='.$userimage.' id="width_50" class="height_50 img-circle"/>';



																?>



															</td>



															<td class="name">



																<a class="color_black" href="

																<?php

																if(isset($_REQUEST['member_list_app']) && $_REQUEST['member_list_app'] == 'memberlist_app')

																{

																	echo "?dashboard=user&page=member&tab=viewmember&action=view&page_action=web_view_hide&member_id=".$retrieved_data->ID;

																}

																else

																{

																	echo "?dashboard=user&page=member&tab=viewmember&action=view&member_id=".$retrieved_data->ID;

																}

																?>

																">



																	<?php echo esc_html(MJ_gmgt_get_user_full_display_name($retrieved_data->ID));?>



																</a><br>



																<label class="list_page_email"><?php echo $retrieved_data->user_email;?></label>



															</td>



															<td class="memberid">



																<?php echo esc_html($retrieved_data->member_id);?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Member Id','gym_mgt');?>" ></i>



															</td>



															<td class="membertype"><?php if(isset($retrieved_data->member_type))



{ 



	 echo esc_html($membertype_array[$retrieved_data->member_type]);  



}



else



{ 



	echo esc_html__('Not Selected','gym_mgt');



}?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Member Type','gym_mgt');?>" ></i></td>



															<td class="joining date">



																<?php 
																	if(!empty($retrieved_data->begin_date))
																	{
																		echo MJ_gmgt_getdate_in_input_box($retrieved_data->begin_date); 
																	}
																	else
																	{ 
																		echo "N/A";
																	} ?>
																<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Joining Date','gym_mgt');?>" ></i>
															</td>



															<td class="joining date">
															<?php if(!empty($retrieved_data->begin_date)) 
															{ 
																echo MJ_gmgt_getdate_in_input_box(MJ_gmgt_check_membership($retrieved_data->ID));
															}
															else
															{ 
																echo "N/A"; 
															}?>  <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Expiry Date','gym_mgt');?>" ></i></td>



															<td class="status">
																<?php if($retrieved_data->membership_status == "")
																{ 
																	echo "N/A";
																}
																elseif($retrieved_data->member_type != 'Prospect')
																{
																	esc_html_e($retrieved_data->membership_status,'gym_mgt');
																}
																else
																{ 
																	esc_html_e('Prospect','gym_mgt'); 
																} ?>  <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Membership Status','gym_mgt');?>" ></i></td>



															<td class="action"> 



																<div class="gmgt-user-dropdown">



																	<ul class="" style="margin-bottom: 0px !important;">



																		<li class="">



																			<a class="" href="#" data-bs-toggle="dropdown" aria-expanded="false">



																				<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/More.png"?>" >



																			</a>



																			<ul class="dropdown-menu heder-dropdown-menu action_dropdawn" aria-labelledby="dropdownMenuLink">







																				<?php 



																				if(isset($_REQUEST['member_list_app']) && $_REQUEST['member_list_app'] == 'memberlist_app')



																				{



																					?>



																					<li class="float_left_width_100">



																						<a href="?dashboard=user&page=member&tab=viewmember&action=view&page_action=web_view_hide&member_id=<?php echo esc_attr($retrieved_data->ID);?>" class="float_left_width_100"><i class="fa fa-eye"></i><?php esc_html_e('View', 'gym_mgt' ) ;?></a>



																					</li>	



																					<!-- <li class="float_left_width_100">



																						<a href="?dashboard=user&page=member&tab=add_attendence&page_action=web_view_hide&member_id=<?php echo esc_attr($retrieved_data->ID);?>&attendance=1" class="btn btn-default"  idtest="<?php echo esc_attr($retrieved_data->ID); ?>"><i class="fa fa-eye"></i> <?php esc_html_e('View Attendance','gym_mgt');?> </a>



																					</li>	 -->



																					<?php



																				}



																				else



																				{



																					?>



																					<li class="float_left_width_100">



																						<a href="?dashboard=user&page=member&tab=viewmember&action=view&member_id=<?php echo esc_attr($retrieved_data->ID);?>" class="float_left_width_100"><i class="fa fa-eye"></i><?php esc_html_e('View', 'gym_mgt' ) ;?></a>



																					</li>	



																					<!-- <li class="float_left_width_100">



																						<a href="?dashboard=user&page=member&tab=add_attendence&member_id=<?php echo esc_attr($retrieved_data->ID);?>&attendance=1" class="float_left_width_100"  idtest="<?php echo esc_attr($retrieved_data->ID); ?>"><i class="fa fa-eye"></i> <?php esc_html_e('View Attendance','gym_mgt');?> </a>



																					</li>	 -->



																					<?php



																				}







																				if($user_access['edit']=='1')



																				{ 



																					if(isset($_REQUEST['member_list_app']) && $_REQUEST['member_list_app'] == 'memberlist_app')



																					{



																						?>



																						<li class="float_left_width_100 border_bottom_item">



																							<a href="?dashboard=user&page=member&tab=addmember&action=edit&page_action=web_view_hide&member_list_app=memberlist_app&member_id=<?php echo esc_attr($retrieved_data->ID)?>" class="float_left_width_100"><i class="fa fa-edit"></i> <?php esc_html_e('Edit', 'gym_mgt' ) ;?></a>



																						</li>	



																						<?php 



																					}



																					else



																					{



																					?>



																						<li class="float_left_width_100 border_bottom_item">



																							<a href="?dashboard=user&page=member&tab=addmember&action=edit&member_id=<?php echo esc_attr($retrieved_data->ID)?>" class="float_left_width_100"><i class="fa fa-edit"></i> <?php esc_html_e('Edit', 'gym_mgt' ) ;?></a>



																						</li>	



																						<?php 



																					} 



																				}	?>



																				<?php



																				if($user_access['delete']=='1')



																				{ 



																					if(isset($_REQUEST['member_list_app']) && $_REQUEST['member_list_app'] == 'memberlist_app')



																					{



																						?>



																							<li class="float_left_width_100">



																								<a href="?dashboard=user&page=member&tab=memberlist&action=delete&page_action=web_view_hide&member_list_app=memberlist_app&member_id=<?php echo esc_attr($retrieved_data->ID);?>" class="float_left_width_100 list_delete_btn" onclick="return confirm('<?php esc_html_e('Are you sure you want to delete this record?','gym_mgt');?>');"><i class="fa fa-trash"></i><?php esc_html_e( 'Delete', 'gym_mgt' ) ;?></a>



																							</li>	



																						<?php



																					}



																					else



																					{



																						?>



																							<li class="float_left_width_100">



																								<a href="?dashboard=user&page=member&tab=memberlist&action=delete&member_id=<?php echo esc_attr($retrieved_data->ID);?>" class="float_left_width_100 list_delete_btn" onclick="return confirm('<?php esc_html_e('Are you sure you want to delete this record?','gym_mgt');?>');"><i class="fa fa-trash"></i><?php esc_html_e( 'Delete', 'gym_mgt' ) ;?></a>



																							</li>	



																						<?php



																					}







																				}







																				



																				?>



																			</ul>



																		</li>



																	</ul>



																</div>	



															</td>



														</tr>



													<?php 



													}



												}



												else



												{



													$havemeta = get_user_meta($retrieved_data->ID, 'gmgt_hash', true);



													if(!$havemeta) 



													{ 



													?>



														<tr>



															<td class="user_image width_50px padding_left_0">



																<?php 



																$uid=$retrieved_data->ID;



																$userimage=get_user_meta($uid, 'gmgt_user_avatar', true);



																if(empty($userimage))



																{



																	echo '<img src='.get_option( 'gmgt_member_logo' ).' id="width_50" class="height_50 img-circle" />';



																}



																else



																	echo '<img src='.$userimage.' id="width_50" class="height_50 img-circle"/>';



																?>



															</td>



															<td class="name">



																<?php 



																if($obj_gym->role == 'staff_member')



																{



																	?>



																	<a class="color_black" href="#">



																		<?php echo esc_html($retrieved_data->display_name); ?>



																	</a><br>



																	<label class="list_page_email"><?php echo $retrieved_data->user_email;?></label>



																	<?php



																}



																else



																{ ?>



																	<a class="color_black" href="?dashboard=user&page=member&tab=viewmember&action=view&member_id=<?php echo esc_attr($retrieved_data->ID);?>">



																		<?php echo esc_html($retrieved_data->display_name);?>



																	</a><br>



																	<label class="list_page_email"><?php echo $retrieved_data->user_email;?></label>



																	<?php 



																} ?>



															</td>



															



															<td class="memberid">



																<?php echo esc_html($retrieved_data->member_id);?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Member Id','gym_mgt');?>" ></i>



															</td>



															<td class="memberid">



																<?php if(isset($retrieved_data->member_type)){  echo esc_html($membertype_array[$retrieved_data->member_type]); } else{ echo esc_html__('Not Selected','gym_mgt'); }?>  <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Member Type','gym_mgt');?>" ></i>



															</td>



															<td class="joining date"><?php if($retrieved_data->member_type!='Prospect'){ echo esc_html(MJ_gmgt_getdate_in_input_box($retrieved_data->begin_date)); }else{ echo "N/A"; }?>  <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Joining Date','gym_mgt');?>" ></i></td>



															<td class="joining date"><?php if($retrieved_data->member_type!='Prospect'){ echo esc_html(MJ_gmgt_getdate_in_input_box(MJ_gmgt_check_membership($retrieved_data->ID))); }else{ echo "N/A"; }?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Expiry Date','gym_mgt');?>" ></i></td>



															<td class="status">



																<?php 



																if($retrieved_data->membership_status == "")



																{ 



																	echo "N/A";



																}



																elseif($retrieved_data->member_type != 'Prospect')



																{



																	esc_html_e($retrieved_data->membership_status,'gym_mgt');



																}



																else



																{ 



																	esc_html_e('Prospect','gym_mgt'); 



																} ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Membership Status','gym_mgt');?>" ></i>



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



																					<a  href="?dashboard=user&page=member&tab=viewmember&action=view&member_id=<?php echo esc_attr($retrieved_data->ID);?>" class="float_left_width_100"><i class="fa fa-eye"></i><?php esc_html_e('View', 'gym_mgt' ) ;?></a>



																				</li>	



																				<?php 



																				if($obj_gym->role == 'staff_member' || ($obj_gym->role == 'member' && $retrieved_data->ID==$curr_user_id))



																				{ ?>



																					<li class="float_left_width_100">



																						<a href="?dashboard=user&page=member&tab=add_attendence&member_id=<?php echo esc_attr($retrieved_data->ID);?>&attendance=1" class="float_left_width_100"  idtest="<?php echo esc_attr($retrieved_data->ID); ?>"><i class="fa fa-eye"></i> <?php esc_html_e('View Attendance','gym_mgt');?> </a>



																					</li>	



																					<?php



																				}



																				



																				if($user_access['edit']=='1')



																				{ ?>



																					<li class="float_left_width_100 border_bottom_item">



																						<a href="?dashboard=user&page=member&tab=addmember&action=edit&member_id=<?php echo esc_attr($retrieved_data->ID)?>" class="float_left_width_100"><i class="fa fa-edit"></i> <?php esc_html_e('Edit', 'gym_mgt' ) ;?></a>



																					</li>	



																					<?php 



																				}	



																				if($user_access['delete']=='1')



																				{ ?>



																					<li class="float_left_width_100">



																						<a href="?dashboard=user&page=member&tab=memberlist&action=delete&member_id=<?php echo esc_attr($retrieved_data->ID);?>" class="float_left_width_100 list_delete_btn" onclick="return confirm('<?php esc_html_e('Are you sure you want to delete this record?','gym_mgt');?>');"><i class="fa fa-trash"></i><?php esc_html_e( 'Delete', 'gym_mgt' ) ;?>



																						</a>



																					</li>	



																					<?php 



																				} ?>







																			</ul>



																		</li>



																	</ul>



																</div>	



															</td>



														</tr>



													<?php 



													}



												}



											}			



										} ?>     



									</tbody>



								</table><!--MEMBERSHIP LIST TABLE END--> 



							</div><!--TABLE RESPONSIVE DIV END--> 



						</div><!--PANEL BODY DIV END--> 



						<?php 



					}



					else



					{



						if($user_access['add']=='1')



						{



							?>



							<div class="no_data_list_div"> 



								<a href="<?php echo home_url().'?dashboard=user&page=member&tab=addmember&&action=insert';?>">



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



					?>



				</div>	<!--TAB PANE DIV END--> 



				<!--Member Step one information-->



			</div><!--MAIN_LIST_MARGING_15px END  -->



			<?php 



		}



		if($active_tab == 'addmember')



		{
			$last_id = "";

			foreach ( $user_query as $user ) {
				$last_id = (int)$user->ID + 1;
				break;
			}



			$member_id=0;



			$edit=0;



			if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')



			{



				$edit=1;



				$member_id=esc_attr($_REQUEST['member_id']);



				$user_info = get_userdata($member_id);



				if($user_info->gmgt_hash)



				{



					$lastmember_id=MJ_gmgt_get_lastmember_id($role);



					$nodate=substr($lastmember_id,0,-4);



					$memberno=substr($nodate,1);



					$memberno+=1;



					$newmember='SVC000'. $last_id;



				}



			}



			else



			{



				$lastmember_id=MJ_gmgt_get_lastmember_id($role);



				$nodate=substr($lastmember_id,0,-4);



				$memberno=substr($nodate,1);



				$memberno+=1;



				$newmember='SVC000'. $last_id;



			}



			?>



			<div class="tab-pane <?php if($active_tab == 'addmember') echo "fade active in";?>" ><!--TAB PANE START--> 



				<div class="panel-body padding_0"><!--PANEL BODY START--> 



					<form name="member_form" action="" method="post" class="form-horizontal" id="member_form"><!--MEMBER FORM START--> 



						<?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>



						<input type="hidden" name="action" value="<?php echo esc_attr($action);?>">



						<input type="hidden" name="role" value="<?php echo esc_attr($role);?>"  />



						<input type="hidden" name="user_id" value="<?php  echo esc_attr($member_id);?>"  />



						<input type="hidden" name="gmgt_hash" value="<?php if($edit){ if($user_info->gmgt_hash){ echo esc_attr($user_info->gmgt_hash);}}?>" />



						<input type="hidden" class="user_coupon" name="coupon_id" value="" />

						



						<div class="header">



							<h3 class="first_hed"><?php esc_html_e('Personal Information','gym_mgt');?></h3>



						</div>



						<div class="form-body user_form"> <!-- user_form Strat-->   



							<div class="row"><!--Row Div Strat--> 



								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">



									<div class="form-group input">



										<div class="col-md-12 form-control">



											<input id="member_id" class="form-control" type="text" value="<?php if($edit){  echo esc_attr($user_info->member_id);}else echo esc_attr($newmember);?>"  readonly name="member_id" >



											<label class="" for="member_id"><?php esc_html_e('Member Id','gym_mgt');?></label>



										</div>



									</div>



								</div>



								<!--nonce-->	



								<?php wp_nonce_field( 'save_member_nonce' ); ?>



								<!--nonce-->



								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



									<div class="form-group input">



										<div class="col-md-12 form-control">



											<input id="first_name" class="form-control validate[required,custom[onlyLetter_specialcharacter]] text-input" maxlength="50" type="text" value="<?php if($edit){ echo esc_attr($user_info->first_name);}elseif(isset($_POST['first_name'])) echo esc_attr($_POST['first_name']);?>" name="first_name">



											<label class="" for="first_name"><?php esc_html_e('First Name','gym_mgt');?><span class="require-field">*</span></label>



										</div>



									</div>



								</div>



								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



									<div class="form-group input">



										<div class="col-md-12 form-control">



											<input id="member_type" class="form-control validate[custom[onlyLetter_specialcharacter] " type="text" maxlength="50"  value="<?php if($edit){ echo esc_attr($user_info->member_type);}elseif(isset($_POST['member_type'])) echo esc_attr($_POST['member_type']);?>" name="member_type"  >



											<label class="" for="member_type"><?php esc_html_e('Member Type','gym_mgt');?></label>



										</div>



									</div>



								</div>



								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



									<div class="form-group input">



										<div class="col-md-12 form-control">



											<input id="last_name" class="form-control validate[required,custom[onlyLetter_specialcharacter]] text-input" maxlength="50" type="text" value="<?php if($edit){ echo esc_attr($user_info->last_name);}elseif(isset($_POST['last_name'])) echo esc_attr($_POST['last_name']);?>" name="last_name" >



											<label class="" for="last_name"><?php esc_html_e('Last Name','gym_mgt');?><span class="require-field">*</span></label>



										</div>



									</div>



								</div>



								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



									<div class="form-group input">



										<div class="col-md-12 form-control">



											<input id="birth_date" class="form-control validate[required] birth_date date_picker" type="text"  name="birth_date" value="<?php if($edit){ echo esc_attr(MJ_gmgt_getdate_in_input_box($user_info->birth_date));}elseif(isset($_POST['birth_date'])){ echo esc_attr(MJ_gmgt_getdate_in_input_box($_POST['birth_date']));}else{ echo MJ_gmgt_getdate_in_input_box(date("Y-m-d")); }?>" readonly  >



											<label class="date_of_birth_label date_label" for="birth_date"><?php esc_html_e('Date of Birth','gym_mgt');?><span class="require-field">*</span></label>



										</div>



									</div>



								</div>



								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 res_margin_bottom_20px rtl_margin_top_15px">



									<div class="form-group">



										<div class="col-md-12 form-control">



											<div class="row padding_radio">



												<div class="input-group">



													<label class="custom-top-label" for="gender"><?php esc_html_e('Gender','gym_mgt');?><span class="require-field">*</span></label>



													<div class="d-inline-block gender_line_height_24px">



														<?php $genderval = "male"; if($edit){ $genderval=$user_info->gender; }elseif(isset($_POST['gender'])) {$genderval=sanitize_text_field($_POST['gender']);}?>



														<label class="radio-inline custom_radio margin_right_5px">



															<input type="radio" value="male" class="tog" name="gender"  <?php checked('male',$genderval); ?>  /><?php esc_html_e('Male','gym_mgt');?>



														</label>



														<label class="radio-inline custom_radio">



															<input type="radio" value="female" class="tog" name="gender" <?php checked('female',$genderval); ?>/><?php esc_html_e('Female','gym_mgt');?>



														</label>



													</div>



												</div>



											</div>		



										</div>



									</div>



								</div>



							</div><!--Row Div End--> 



						</div><!-- user_form End-->   



						



						<div class="header">	



							<h3 class="first_hed"><?php esc_html_e('Login Information','gym_mgt');?></h3>



						</div>



						<div class="form-body user_form"> <!-- user_form Strat-->   



							<div class="row"><!--Row Div Strat--> 



								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



									<div class="form-group input">



										<div class="col-md-12 form-control">



											<input type="hidden" name="hidden_email" value="<?php if($edit){ echo esc_attr($user_info->user_email); } ?>">



											<input id="email" class="form-control validate[required,custom[email]] text-input" maxlength="100" type="text" name="email" value="<?php if($edit){ echo esc_attr($user_info->user_email);}elseif(isset($_POST['email'])) echo esc_attr($_POST['email']);?>" >



											<label class="" for="email"><?php esc_html_e('Email','gym_mgt');?><span class="require-field">*</span></label>



										</div>



									</div>



								</div>



								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



									<div class="form-group input">



										<div class="col-md-12 form-control">



											<input id="password" class="form-control space_validation <?php if(!$edit) echo esc_attr('validate[required]');?>" minlength="8" maxlength="12" type="password"  name="password" value="" >



											<label class="" for="password"><?php esc_html_e('Password','gym_mgt');?><?php if(!$edit) {?><span class="require-field">*</span><?php }?></label>



										</div>



									</div>



								</div>



								<div class="col-md-6">



									<div class="row">



										<div class="col-md-4">



											<div class="form-group input margin_bottom_0">



												<div class="col-md-12 form-control">



													<input type="text" readonly value="+<?php echo MJ_gmgt_get_countery_phonecode(get_option( 'gmgt_contry' ));?>"  class="form-control" name="phonecode">



													<label for="phonecode" class="pl-2"><?php esc_html_e('Country Code','gym_mgt');?><span class="required red">*</span></label>



												</div>											



											</div>



										</div>



										<div class="col-md-8">



											<div class="form-group input margin_bottom_0">



												<div class="col-md-12 form-control">



													<input id="mobile" class="form-control margin_top_10_res validate[required,custom[phone_number]] text-input phone_validation" type="text" minlength="6" name="mobile" maxlength="15" 



													value="<?php if($edit){ echo esc_attr($user_info->mobile);}elseif(isset($_POST['mobile'])) echo esc_attr($_POST['mobile']);?>" >



													<label class="" for="mobile"><?php esc_html_e('Mobile Number','gym_mgt');?><span class="require-field">*</span></label>



												</div>



											</div>



										</div>



									</div>



								</div> 



							</div><!--Row Div End--> 



						</div><!-- user_form End--> 



						



						<div class="header">	



							<h3 class="first_hed"><?php esc_html_e('Membership Information','gym_mgt');?></h3>



						</div>



						<div class="form-body user_form"> <!-- user_form Strat-->



							<div class="row"><!--Row Div Strat--> 



								<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 input">



									<label class="ml-1 custom-top-label top" for="refered"><?php esc_html_e('Member type','gym_mgt');?><span class="require-field">*</span></label>



									<select name="member_type" class="form-control validate[required] Member_type_val max_width_100" id="member_type" >



										<option value=""><?php esc_html_e('Select Member Type','gym_mgt');?></option>



										<?php 



										if($edit)



										{



											$mtype=$user_info->member_type;



										}



										elseif(isset($_POST['member_type']))



										{



											$mtype=sanitize_text_field($_POST['member_type']);



										}



										else



										{



											$mtype="";



										}



										$membertype_array=MJ_gmgt_member_type_array();



										if(!empty($membertype_array))



										{



											foreach($membertype_array as $key=>$type)



											{



												echo '<option value='.esc_attr($key).' '.selected(esc_attr($mtype),esc_attr($key)).'>'.esc_html($type).'</option>';



											}



										} ?>



									</select>



								</div>







								<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 input">



									<label class="ml-1 custom-top-label top" for="staff_name"><?php esc_html_e('Select Staff Member','gym_mgt');?><span class="require-field">*</span></label>



									<?php $get_staff = array('role' => 'Staff_member');



										$staffdata=get_users($get_staff);



									?>



									<select name="staff_id" class="form-control validate[required] max_width_100" id="staff_id" >



										<option value=""><?php  esc_html_e('Select Staff Member','gym_mgt');?></option>



										<?php 



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



											$staff_data=get_current_user_id();



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







								<?php 



								if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')



								{



								?>	



									<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 mb-3 rtl_margin_top_15px">



										<div class="form-group">



											<div class="col-md-12 form-control">



												<div class="row padding_radio">



													<div class="">



														<label class="custom-top-label" for="member_convert"><?php esc_html_e(' Convert into Staff Member','gym_mgt');?></label>



														<input type="checkbox" class="member_convert check_box_input_margin" name="member_convert" value="staff_member"><label class="margin_left_8px"><?php esc_attr_e('Convert into Staff Member','gym_mgt');?><label>



													</div>												



												</div>



											</div>



										</div>



									</div>







								<?php 



								}



								?>







								<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 input ">



									<label class="ml-1 custom-top-label top" for="membership"><?php esc_html_e('Membership','gym_mgt');?><span class="require-field">*</span></label>					



									<input type="hidden" name="membership_hidden" class="membership_hidden" value="<?php if($edit){ if(!empty($user_info->membership_id)) { echo esc_attr($user_info->membership_id); }else{ echo '0'; } }else{ echo '0';}?>">



									<?php $membershipdata=$obj_membership->MJ_gmgt_get_all_membership(); ?>



									<select name="membership_id" class="form-control coupon_membership_id payment_membership_detail validate[required] max_width_100" id="membership_id" >	



										<option value=""><?php esc_html_e('Select Membership','gym_mgt');?></option>



											<?php 



											$staff_data=$user_info->membership_id;



											if(!empty($membershipdata))



											{



												foreach ($membershipdata as $membership)



												{						



													echo '<option value='.esc_attr($membership->membership_id).' '.selected(esc_attr($staff_data),esc_attr($membership->membership_id)).'>'.esc_html($membership->membership_label).'</option>';



												}



											}



											?>



									</select>



								</div>







								<div class="rtl_margin_top_15px col-sm-5 col-md-6 col-lg-6 col-xl-6 res_margin_bottom_20px multiselect_validation_member smgt_multiple_select">



									<select id="classis_id" class="form-control classis_ids" multiple="multiple" name="class_id[]" >



										<?php 



										if($edit)					



										{	



											$obj_class=new MJ_gmgt_classschedule;



											$MemberShipClass = MJ_gmgt_get_class_id_by_membership_id($user_info->membership_id);



											$userclass  = MJ_gmgt_get_current_user_classis($member_id);



											foreach($MemberShipClass as $key=>$class_id)



											{



												$class_data=$obj_class->MJ_gmgt_get_single_class($class_id);



											?>



												<option value="<?php echo esc_attr($class_id);?>" <?php if (is_array($userclass)){ if(in_array($class_id,$userclass)){ print "Selected"; } } ?>><?php echo MJ_gmgt_get_class_name(esc_html($class_id)); ?> ( <?php echo MJ_gmgt_timeremovecolonbefoream_pm(esc_html($class_data->start_time)).' - '.MJ_gmgt_timeremovecolonbefoream_pm(esc_html($class_data->end_time));?>)</option>



											<?php



											}



										}



										?>



									</select>



								</div>



								<?php 



								if($edit)



								{



									?>	



									<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 res_margin_bottom_20px rtl_margin_top_15px">



										<div class="form-group">



											<div class="col-md-12 form-control">



												<div class="row padding_radio">



													<div class="input-group">



														<label class="custom-top-label" for="membership_status"><?php esc_html_e('Membership Status','gym_mgt');?><span class="require-field">*</span></label>



														<div class="d-inline-block gender_line_height_24px">



															<?php $membership_statusval = "Continue"; if($edit){ $membership_statusval=$user_info->membership_status; }elseif(isset($_POST['membership_status'])) {$membership_statusval=sanitize_text_field($_POST['membership_status']);}?>



															<label class="radio-inline custom_radio">



																<input type="radio" value="Continue" class="tog" name="membership_status" <?php checked( 'Continue', $membership_statusval); ?>/><?php esc_html_e('Continue','gym_mgt');?>



															</label>



															<label class="radio-inline custom_radio">



																<input type="radio" value="Expired" class="tog" name="membership_status" <?php  checked( 'Expired', $membership_statusval);  ?>/><?php esc_html_e('Expired','gym_mgt');?>



															</label>



															<label class="radio-inline custom_radio">



																<input type="radio" value="Dropped" class="tog" name="membership_status" <?php checked( 'Dropped', $membership_statusval); ?>/><?php esc_html_e('Dropped','gym_mgt');?> 



															</label>



														</div>



													</div>



												</div>



											</div>



										</div>



										<input type="hidden" name="auto_renew" value="No">		



									</div>		



									<?php 



								} ?>







								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



									<div class="form-group input">



										<div class="col-md-12 form-control">



											<input id="begin_date" class="form-control validate[required] begin_date date_picker" type="text" name="begin_date" value="<?php if($edit){ if($user_info->begin_date!=""){ echo esc_attr(MJ_gmgt_getdate_in_input_box($user_info->begin_date)); } }elseif(isset($_POST['begin_date'])) echo esc_attr($_POST['begin_date']);?>"  readonly>



											<label class="date_label" for="begin_date"><?php esc_html_e('Membership Valid From','gym_mgt');?><span class="require-field">*</span></label>	



										</div>							



									</div>



								</div>



								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">



									<div class="form-group input">



										<div class="col-md-12 form-control">



											<input id="end_date" class="form-control validate[required] date_picker" type="text" name="end_date" value="<?php if($edit){ if($user_info->end_date!=""){ echo MJ_gmgt_getdate_in_input_box($user_info->end_date); }} elseif(isset($_POST['end_date'])) echo esc_attr($_POST['end_date']);?>" readonly>



											<label class="date_label" for="begin_date"><?php esc_html_e('Membership Valid to','gym_mgt');?><span class="require-field">*</span></label>



										</div>



									</div>



								</div>

								<?php 

								if($edit == 0){

								?>

								<div class="col-sm-5 col-md-5 col-lg-5 col-xl-5 ">



									<div class="form-group input">



										<div class="col-md-12 form-control">



											<input id="coupon_code" class="form-control coupon_code" type="text" value="" name="coupon_code" >



											<label class="" for=""><?php esc_html_e('Add Coupon Code','gym_mgt');?></label>

											

										</div>

										<span class="coupon_span"></span>

									</div>

								</div>



								<div class="col-sm-12 col-md-1 col-lg-1 col-xl-1 mb-3 rtl_margin_top_15px">	



									<button id="" type="new_member" class="btn add_btn apply_coupon" ><?php esc_html_e('Apply','gym_mgt');?></button>



								</div>



								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



									<div class="form-group input">



										<div class="col-md-12 form-control">



											<input id="total_amount" class="form-control validate[required,custom[number]]" type="text" value="<?php if($edit){ echo esc_attr($user_info->membership_amount);}?>" name="membership_amount" readonly>



											<label class="" for="triel_date"><?php esc_html_e('Membership Amount','gym_mgt');?>(<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?>)<span class="require-field">*</span></label>



										</div>



									</div>



								</div>



								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 discount_display">



									<div class="form-group input">



										<div class="col-md-12 form-control">



											<input id="coupon_discount" class="form-control" type="text" value="" name="discount" readonly>



											<label class="" for=""><?php esc_html_e('Discount','gym_mgt');?></label>



										</div>



									</div>



								</div>

						<?php

						}

						?>

							</div><!--Row Div End--> 



						</div><!-- user_form End-->







						<div class="header">	



							<h3 class="first_hed"><?php esc_html_e('Contact Information','gym_mgt');?></h3>



						</div>



						<div class="form-body user_form"> <!-- user_form Strat-->   



							<div class="row"><!--Row Div Strat--> 



								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">



									<div class="form-group input">



										<div class="col-md-12 form-control">



											<input id="address" class="form-control" maxlength="150" type="text"  name="address" value="<?php if($edit){ echo esc_attr($user_info->address);}elseif(isset($_POST['address'])) echo esc_attr($_POST['address']);?>" >



											<label class="" for="address"><?php esc_html_e('Address','gym_mgt');?></label>



										</div>



									</div>



								</div>



								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



									<div class="form-group input">



										<div class="col-md-12 form-control">



											<input id="city_name" class="form-control " maxlength="50" type="text"  name="city_name" value="<?php if($edit){ echo esc_attr($user_info->city_name);}elseif(isset($_POST['city_name'])) echo esc_attr($_POST['city_name']);?>" >



											<label class="" for="city_name"><?php esc_html_e('City','gym_mgt');?></label>



										</div>



									</div>



								</div>



								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



									<div class="form-group input">



										<div class="col-md-12 form-control">



											<input id="state_name" class="form-control validate[custom[city_state_country_validation]]" maxlength="50" type="text" name="state_name" value="<?php if($edit){ echo esc_attr($user_info->state_name);}elseif(isset($_POST['state_name'])) echo esc_attr($_POST['state_name']);?>" >



											<label class="" for="state_name"><?php esc_html_e('State','gym_mgt');?></label>



										</div>



									</div>



								</div>



								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



									<div class="form-group input">



										<div class="col-md-12 form-control">



											<input id="zip_code" class="form-control" maxlength="15" type="text" name="zip_code" value="<?php if($edit){ echo esc_attr($user_info->zip_code);}elseif(isset($_POST['zip_code'])) echo esc_attr($_POST['zip_code']);?>" >



											<label class="" for="zip_code"><?php esc_html_e('Zip Code','gym_mgt');?></label>



										</div>



									</div>



								</div>



								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">



									<div class="form-group input">



										<div class="col-md-12 form-control">



											<input id="phone" class="form-control text-input phone_validation validate[custom[phone_number]]" type="text" minlength="6" maxlength="15" name="phone" value="<?php if($edit){ echo esc_attr($user_info->phone);}elseif(isset($_POST['phone'])) echo esc_attr($_POST['phone']);?>" >



											<label class="" for="phone"><?php esc_html_e('Phone','gym_mgt');?></label>



										</div>



									</div>



								</div>



							</div><!--Row Div End--> 



						</div><!-- user_form End-->  







						<div class="header">	



							<h3 class="first_hed"><?php esc_html_e('Physical Information','gym_mgt');?></h3>



						</div>



						<div class="form-body user_form"> <!-- user_form Strat-->   



							<div class="row"><!--Row Div Strat--> 



								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



									<div class="form-group input">



										<div class="col-md-12 form-control">



											<input id="weight" class="form-control text-input decimal_number" type="number" min="0" onkeypress="if(this.value.length==6) return false;" step="0.01" value="<?php if($edit){ echo esc_attr($user_info->weight);}elseif(isset($_POST['weight'])) echo esc_attr($_POST['weight']);?>" name="weight" placeholder="<?php echo  esc_html__(get_option( 'gmgt_weight_unit' ),'gym_mgt');?>" >		



											<label class="" for="weight"><?php esc_html_e('Weight','gym_mgt');?></label>



										</div>



									</div>



								</div>



								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



									<div class="form-group input">



										<div class="col-md-12 form-control">



											<input id="height" class="form-control text-input decimal_number"type="number" min="0" onkeypress="if(this.value.length==6) return false;" step="0.01" value="<?php if($edit){ echo esc_attr($user_info->height);}elseif(isset($_POST['height'])) echo esc_attr($_POST['height']);?>" name="height" placeholder="<?php echo esc_html__(get_option( 'gmgt_height_unit' ),'gym_mgt');?>" >



											<label class="" for="height"><?php esc_html_e('Height','gym_mgt');?></label>



										</div>



									</div>



								</div>



								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



									<div class="form-group input">



										<div class="col-md-12 form-control">



											<input id="Chest" class="form-control text-input decimal_number" type="number" min="0" onkeypress="if(this.value.length==6) return false;" step="0.01" value="<?php if($edit){ echo esc_attr($user_info->chest);}elseif(isset($_POST['chest'])) echo esc_attr($_POST['chest']);?>" name="chest" placeholder="<?php echo  esc_html__(get_option( 'gmgt_chest_unit' ),'gym_mgt');?>" >



											<label class="" for="Chest"><?php esc_html_e('Chest','gym_mgt');?></label>



										</div>



									</div>



								</div>



								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



									<div class="form-group input">



										<div class="col-md-12 form-control">



											<input id="waist" class="form-control text-input decimal_number" type="number" min="0" onkeypress="if(this.value.length==6) return false;" step="0.01" value="<?php if($edit){ echo esc_attr($user_info->waist);}elseif(isset($_POST['waist'])) echo esc_attr($_POST['waist']);?>" name="waist" placeholder="<?php echo  esc_html__(get_option( 'gmgt_waist_unit' ),'gym_mgt');?>" >



											<label class="" for="Waist"><?php esc_html_e('Waist','gym_mgt');?></label>



										</div>



									</div>



								</div>



								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



									<div class="form-group input">



										<div class="col-md-12 form-control">



											<input id="thigh" class="form-control text-input decimal_number" type="number" min="0" onkeypress="if(this.value.length==6) return false;" step="0.01" value="<?php if($edit){ echo esc_attr($user_info->thigh);}elseif(isset($_POST['thigh'])) echo esc_attr($_POST['thigh']);?>" name="thigh" placeholder="<?php echo esc_html__(get_option( 'gmgt_thigh_unit' ),'gym_mgt');?>" >



											<label class="" for="thigh"><?php esc_html_e('Thigh','gym_mgt');?></label>



										</div>



									</div>



								</div>



								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



									<div class="form-group input">



										<div class="col-md-12 form-control">



											<input id="arms" class="form-control text-input decimal_number" type="number" min="0" onkeypress="if(this.value.length==6) return false;" step="0.01" value="<?php if($edit){ echo esc_attr($user_info->arms);}elseif(isset($_POST['arms'])) echo esc_attr($_POST['arms']);?>" name="arms" placeholder="<?php echo  esc_html__(get_option( 'gmgt_arms_unit' ),'gym_mgt'); ?>" >



											<label class="" for="arms"><?php esc_html_e('Arms','gym_mgt');?></label>



										</div>



									</div>



								</div>



								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



									<div class="form-group input">



										<div class="col-md-12 form-control">



											<input id="fat" class="form-control text-input decimal_number" type="number" min="0" max="100" onkeypress="if(this.value.length==6) return false;" step="0.01" value="<?php if($edit){ echo esc_attr($user_info->fat);}elseif(isset($_POST['fat'])) echo esc_attr($_POST['fat']);?>" name="fat" placeholder="<?php echo esc_html__(get_option( 'gmgt_fat_unit' ),'gym_mgt');?>" >



											<label class="" for="fat"><?php esc_html_e('Fat','gym_mgt');?></label>



										</div>



									</div>



								</div>



							</div><!--Row Div End--> 



						</div><!-- user_form End-->  







						<div class="header">	



							<h3 class="first_hed"><?php esc_html_e('Other Information','gym_mgt');?></h3>



						</div>



						<div class="form-body user_form"> <!-- user_form Strat-->   



							<div class="row"><!--Row Div Strat--> 



							



								<div class="col-sm-12 col-md-5 col-lg-5 col-xl-5 input">



									<label class="ml-1 custom-top-label top" for="intrest"><?php esc_html_e('Interest Area','gym_mgt');?></label>



									<select class="form-control max_width_100" name="intrest_area" id="intrest_area" >



										<option value=""><?php esc_html_e('Select Interest','gym_mgt');?></option>



										<?php



										if(isset($_REQUEST['intrest']))



										{



											$category =esc_attr($_REQUEST['intrest']);  



										}



										elseif($edit)



										{



											$category =$user_info->intrest_area;



										}



										else



										{ 



											$category = "";



										}



										$role_type=MJ_gmgt_get_all_category('intrest_area');



										if(!empty($role_type))



										{



											foreach ($role_type as $retrive_data)



											{



												echo '<option value="'.esc_attr($retrive_data->ID).'" '.selected(esc_attr($category),esc_attr($retrive_data->ID)).'>'.esc_html($retrive_data->post_title).'</option>';



											}



										}



									?>



									</select>



								</div>



								<div class="col-sm-12 col-md-1 col-lg-1 col-xl-1 mb-3 rtl_margin_top_15px">



									<button id="addremove" model="intrest_area" class="btn add_btn " ><?php esc_html_e('Add','gym_mgt');?></button>



								</div>







								<div class="col-sm-12 col-md-5 col-lg-5 col-xl-5 input">



									<label class="ml-1 custom-top-label top" for="Source"><?php esc_html_e('Referral Source','gym_mgt');?></label>



									<select class="form-control reffer_source_font max_width_100" name="source" id="source" >



										<option value=""><?php esc_html_e('Select Referral Source','gym_mgt');?></option>



										<?php 								



										if(isset($_REQUEST['source']))



										{



											$category =esc_attr($_REQUEST['source']);  



										}



										elseif($edit)



										{



											$category =$user_info->source;



										}



										else



										{



											$category = "";



										}



										$role_type=MJ_gmgt_get_all_category('source');



										if(!empty($role_type))



										{



											foreach ($role_type as $retrive_data)



											{



												echo '<option value="'.esc_attr($retrive_data->ID).'" '.selected(esc_attr($category),esc_attr($retrive_data->ID)).'>'.esc_attr($retrive_data->post_title).'</option>';



											}



										}



										?>



									</select>



								</div>



								<div class="col-sm-12 col-md-1 col-lg-1 col-xl-1 mb-3 rtl_margin_top_15px">



									<button id="addremove"  class="btn add_btn " model="source" ><?php esc_html_e('Add','gym_mgt');?></button>



								</div>



										



								<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 input">



									<label class="ml-1 custom-top-label top" for="refered"><?php esc_html_e('Referred By','gym_mgt');?></label>



									<?php 



										$staffdata=get_users([ 'role__in' => ['Staff_member', 'member']]);



									?>



									<select name="reference_id" class="form-control max_width_100" id="reference_id" >



										<option value=""><?php esc_html_e('Select Referred Member','gym_mgt');?></option>



										<?php 



										if($edit)



										{



											$staff_data=$user_info->reference_id;



										}



										elseif(isset($_POST['reference_id']))



										{



											$staff_data=sanitize_text_field($_POST['reference_id']);



										}



										else



										{



											$staff_data="";					



										}



										if(!empty($staffdata))



										{



											foreach($staffdata as $staff)



											{						



												echo '<option value='.esc_attr($staff->ID).' '.selected(esc_attr($staff_data),esc_attr($staff->ID)).'>'.esc_html($staff->display_name).'</option>';



											}



										}



										?>



									</select>



								</div>







								<div class="rtl_margin_top_15px col-sm-6 col-md-6 col-lg-6 col-xl-6 res_margin_bottom_20px multiselect_validation_class smgt_multiple_select">



									<?php 



										$joingroup_list = $obj_member->MJ_gmgt_get_all_joingroup($member_id);



										$groups_array = $obj_member->MJ_gmgt_convert_grouparray($joingroup_list);



									?>



									<?php if($edit){ $group_id=$user_info->group_id; }elseif(isset($_POST['group_id'])){$group_id=sanitize_text_field($_POST['group_id']);}else{$group_id='';}?>



									<select id="group_id"  name="group_id[]" multiple="multiple" >



										<?php $groupdata=$obj_group->MJ_gmgt_get_all_groups();



										if(!empty($groupdata))



										{



											foreach ($groupdata as $group){?>



												<option value="<?php echo esc_attr($group->id);?>" <?php if(in_array($group->id,$groups_array)) echo 'selected';  ?>><?php echo esc_html($group->group_name); ?></option>



										<?php } } ?>



									</select>



								</div>



								



								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



									<div class="form-group input">



										<div class="col-md-12 form-control">



											<input id="inqiury_date" class="form-control date_picker" type="text"  name="inqiury_date" value="<?php if($edit){ if($user_info->inqiury_date!=""){ echo esc_attr(MJ_gmgt_getdate_in_input_box($user_info->inqiury_date)); } }elseif(isset($_POST['inqiury_date'])) echo esc_attr($_POST['inqiury_date']);?>"  readonly>



																															



											<label class="date_label" for="inqiury_date"><?php esc_html_e('Inquiry Date','gym_mgt');?></label>



											



										</div>



									</div>



								</div>







								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



									<div class="form-group input">



										<div class="col-md-12 form-control">



											<input id="triel_date" class="form-control date_picker" type="text"  name="triel_date" value="<?php if($edit){ if($user_info->triel_date!=""){ echo esc_attr(MJ_gmgt_getdate_in_input_box($user_info->triel_date)); } }elseif(isset($_POST['triel_date'])) echo esc_attr($_POST['triel_date']);?>" readonly>



											<label class="date_label" for="triel_date"><?php esc_html_e('Trial End Date','gym_mgt');?></label>



										</div>



									</div>



								</div>











								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">



									<div class="form-group input">



										<div class="upload-profile-image-patient">



											<div class="col-md-12 form-control upload-profile-image-frontend">	



												<label class="custom-control-label custom-top-label ml-2" for="photo"><?php esc_html_e('Image','gym_mgt');?></label>



												<div class="col-sm-12">



													<input type="text" id="display_none" id="gmgt_user_avatar_url" class="form-control" name="gmgt_user_avatar"  readonly value="<?php if($edit)echo esc_url( $user_info->gmgt_user_avatar );elseif(isset($_POST['gmgt_user_avatar'])) echo esc_url($_POST['gmgt_user_avatar']); ?>" />



												



													<input type="hidden" name="hidden_upload_user_avatar_image" value="<?php if($edit){ echo esc_url($user_info->gmgt_user_avatar);}elseif(isset($_POST['upload_user_avatar_image'])) echo esc_url($_POST['upload_user_avatar_image']);?>">



													<input id="upload_user_avatar_image" name="upload_user_avatar_image" type="file" class="form-control file" value="<?php esc_html_e( 'Upload image', 'gym_mgt' ); ?>"  onchange="MJ_gmgt_fileCheck(this);"/>



												</div>



											</div>



										</div>	



										<div class="clearfix"></div>



										<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">



											<div id="upload_user_avatar_preview" >



												<?php if($edit) 



												{



													if($user_info->gmgt_user_avatar == "")



													{?>



													<img class="image_preview_css" src="<?php echo esc_url(get_option( 'gmgt_member_logo' )); ?>">



													<?php 



													}



													else 



													{



													?>



													<img class="image_preview_css" src="<?php if($edit)echo esc_url( $user_info->gmgt_user_avatar ); ?>" />



													<?php 



													}



												}



												else 



												{



												?>



													<img class="image_preview_css" src="<?php echo esc_url(get_option( 'gmgt_member_logo' )); ?>">



												<?php 



												}?>



											</div>



										</div>



									</div>



								</div>



								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



									<div class="form-group input">



										<div class="col-md-12 form-control">



											<input id="first_payment_date" class="form-control" type="text"  name="first_payment_date" value="<?php if($edit){ if($user_info->first_payment_date!=""){ echo esc_attr(MJ_gmgt_getdate_in_input_box($user_info->first_payment_date)); } }elseif(isset($_POST['first_payment_date'])) echo esc_attr($_POST['first_payment_date']);?>"  readonly>



																																		



											<label class="" for="first_payment_date"><?php esc_html_e('First Payment Date','gym_mgt');?></label>



										</div>



									</div>



								</div>



								<div id="no_of_class"></div>



							</div><!--Row Div End--> 



						</div><!-- user_form End-->







						<!----------   save btn    --------------> 



						<div class="form-body user_form"> <!-- user_form Strat-->   



							<div class="row"><!--Row Div Strat--> 



								<div class="col-md-6 col-sm-6 col-xs-12"> 	



									<input type="submit" value="<?php if($edit){ esc_html_e('Save','gym_mgt'); }else{ esc_html_e('Save Member','gym_mgt');}?>" name="save_member" class="btn save_btn class_submit "  />



								</div>



							</div><!--Row Div End--> 



						</div><!-- user_form End--> 







					</form><!--MEMBER FORM END--> 



				</div><!--PANEL BODY DIV END--> 



			</div><!--TAB PANE DIV END--> 



			<?php 



		} ?>



		<!--Member Step two information-->



		<?php if($active_tab == 'viewmember')



		{ ?>



			<div class="tab-pane <?php if($active_tab == 'viewmember') echo "fade active in";?>" >



				<?php require_once GMS_PLUGIN_DIR. '/template/view_member.php';?>



			</div>



			<?php 



		}



		?>



	</div><!--TAB CONTENT DIV END-->   



 



<script type="text/javascript">



function MJ_gmgt_fileCheck(obj) 



{



	var fileExtension = ['jpeg', 'jpg', 'png', 'bmp',''];



	if ($.inArray($(obj).val().split('.').pop().toLowerCase(), fileExtension) == -1)



	{



		alert("<?php esc_html_e("Only .jpeg, .jpg, .png, .bmp formats are allowed.",'gym_mgt');?>");



		$(obj).val('');



	}		



}



</script>