<?php 



$user = wp_get_current_user ();



$obj_member=new MJ_gmgt_member;



$user_data =get_userdata( $user->ID);



require_once ABSPATH . 'wp-includes/class-phpass.php';



$user_data =get_userdata( $user->ID);	



$first_name = get_user_meta($user_data->ID,'first_name',true);



$last_name = get_user_meta($user_data->ID,'last_name',true);	



$wp_hasher = new PasswordHash( 8, true );



//SAVE USER DATA







//access right //



$user_access=MJ_gmgt_get_userrole_wise_page_access_right_array();



if (isset ( $_REQUEST ['page'] ))



{	



	if($user_access['view']=='0')



	{	



		MJ_gmgt_access_right_page_not_access_message();



		die;



	}



	if(!empty($_REQUEST['action']))member_type



	{



		if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == $user_access['page_link'] && ($_REQUEST['action']=='edit'))



		{



			if($user_access['edit']=='0')



			{	



				MJ_gmgt_access_right_page_not_access_message();



				die;



			}			



		}



	}



}



if(isset($_POST['save_change']))



{



	$nonce = $_POST['_wpnonce'];



	if (wp_verify_nonce( $nonce, 'save_change_nonce' ) )



	{



		$referrer = $_SERVER['HTTP_REFERER'];


		if ( ! empty( $_POST['relation'] ) && ! empty( $_POST['member_id'])) {
				update_user_Meta( $_POST['member_id'], 'relation', $_POST['relation'] );
		}



		$success=0;



		//ADD USER DATA



		if(isset($_POST['first_name']) AND isset($_POST['middle_name']) AND isset($_POST['last_name']) )



		{



			$result=$obj_member->MJ_gmgt_gmgt_add_user($_POST);



			if($result)



			{



				if(isset($_REQUEST['page_action']) &&isset($_REQUEST['page_action']) == 'web_view_hide')



				{



					wp_safe_redirect(home_url()."?dashboard=user&page=account&page_action=web_view_hide&action=edit&message=2" );



				}



				else



				{



					wp_safe_redirect(home_url()."?dashboard=user&page=account&action=edit&message=2" );



				}



			}



		}



		if($wp_hasher->CheckPassword($_REQUEST['current_pass'],$user_data->user_pass))



		{



			if(esc_attr($_REQUEST['new_pass']) == esc_attr($_REQUEST['conform_pass']))



			{



				wp_set_password( esc_attr($_REQUEST['new_pass']), $user->ID);



				$success=1;



			}



			else



			{



				if(isset($_REQUEST['page_action']) &&isset($_REQUEST['page_action']) == 'web_view_hide')



				{



					wp_redirect($referrer.'&page_action=web_view_hide&sucess=2');



				}



				else



				{



					wp_redirect($referrer.'&sucess=2');



				}



				



			}



		}



		else



		{



			if(isset($_REQUEST['page_action']) &&isset($_REQUEST['page_action']) == 'web_view_hide')



			{



				wp_redirect($referrer.'&page_action=web_view_hide&sucess=3');



			}



			else



			{



				wp_redirect($referrer.'&sucess=3');



			}



		}



		if($success==1)



		{



			wp_cache_delete($user->ID,'users');



			wp_cache_delete($user_data->user_email,'user_email');



			wp_logout();



			if(wp_signon(array('user_email'=>$user_data->user_email,'user_password'=>$_REQUEST['new_pass']),false)):



			{



				$referrer = $_SERVER['HTTP_REFERER'];



				if(isset($_REQUEST['page_action']) &&isset($_REQUEST['page_action']) == 'web_view_hide')



				{



					wp_redirect($referrer.'&page_action=web_view_hide&sucess=1');



				}



				else



				{



					wp_redirect($referrer.'&sucess=1');



				}



			}



			endif;



			{



				ob_start();



			}



		}



		else



		{



			wp_set_auth_cookie($user->ID, true);



		}



	}



}



?>



<?php 



	$edit=1;



	$coverimage=get_option( 'gmgt_gym_background_image' );



	if($coverimage!="")



	{?>



		<style>



			.profile-cover



			{



				background: url("<?php echo get_option( 'gmgt_gym_background_image' );?>") repeat scroll 0 0 / cover rgba(0, 0, 0, 0);



			}



			::i-block-chrome, .profile-cover



			{



				background: url("<?php echo get_option( 'gmgt_gym_background_image' );?>") !important;



			}



		</style>	



<?php



	}



	?>



<script type="text/javascript">



$(document).ready(function() 



{



	jQuery("body").on("click", ".save_upload_profile_btn", function ()



	{ 



		"use strict";



		var value = $(".profile_file").val();



		if(!value)



		{



			alert("<?php echo esc_html__('Please Select Atleast One Image.','gym_mgt') ?>")



			return false;



		}



	});	



	"use strict";



	$('#doctor_form').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});	



	$.datepicker.setDefaults($.datepicker.regional['<?php echo MJ_gmgt_get_current_lan_code(); ?>']);



   	jQuery('#birth_date').datepicker({



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



} );



</script>



<script type="text/javascript">



	function MJ_gmgt_fileCheck(obj) 



	{



		var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'bmp',''];



		if ($.inArray($(obj).val().split('.').pop().toLowerCase(), fileExtension) == -1)



		{



			alert("<?php esc_html_e("Only .jpeg .jpg .png .gif .bmp formats are allowed.","gym_mgt");?>");	



			$(obj).val('');



		}			



	}



</script>



<!-- POP up code -->



<div class="popup-bg">



	<div class="overlay-content">



		<div class="modal-content"></div>

		<div class="profile_picture"></div>

   </div>



</div>



<!-- End POP-UP Code -->



<div>



	<div class="profile-cover"><!-- PROFILE COVER DIV START -->



		<div class="row">



			<div class="col-md-3 profile-image">



				<div class="profile-image-container">



					<?php $umetadata=get_user_meta($user->ID, 'gmgt_user_avatar', true);



					if(empty($umetadata)){



						echo '<img src='.get_option( 'gmgt_member_logo' ).' height="150px" width="150px" class="img-circle" />';



					}



					else



						echo '<img src='.$umetadata.' height="150px" width="150px" class="img-circle" />';



	                ?>



	                <div class="col-md-1 update_dp margin_bottom_10px">



						<button class="btn save_btn btn-file" type="file" name="profile_change" id="profile_change"><?php esc_html_e('Update Profile','gym_mgt');?></button>



					</div>



				</div>



			</div>



		</div>



	</div><!-- PROFILE COVER DIV END -->



	<div id="main-wrapper" class="account_page_main_div"> <!-- MAIN WRAPPER DIV START -->



		<div class="row"><!--ROW DIV START -->



			<div class="col-md-3 user-profile rtl_padding_left_60px">



				<h3 class="text-center">



					<?php 



						echo esc_html($user_data->display_name);



					?>



				</h3>				



				<hr>



				<ul class="list-unstyled text-center">



					<li>



						<?php 



						if(!empty($user_data->address) && !empty($user_data->city))


member_typemember_typemember_type
						{



							?><p><i class="fa fa-map-marker m-r-xs"></i><?php



							echo esc_html($user_data->address).",".esc_html($user_data->city);



						}



						elseif(!empty($user_data->address))



						{



							?><p><i class="fa fa-map-marker m-r-xs"></i><?php



							echo esc_html($user_data->address);



						}



						elseif(!empty($user_data->city))



						{



							?><p><i class="fa fa-map-marker m-r-xs"></i><?php



							echo esc_html($user_data->city);



						}



						?></p>



					</li>



					<li>



						<p><i class="fa fa-envelope m-r-xs"></i><div><?php echo esc_html($user_data->user_email);?></div></p>



					</li>



				</ul>



				<?php



				if($obj_gym->role == "staff_member")



				{



				?>



				<h3 class="text-center">



					<?php echo esc_html__('My Activity','gym_mgt');?>



				</h3>



				<ul class="list-unstyled activity_list">



				<?php 



					$activity_list = MJ_gmgt_get_activity_by_staffmember(get_current_user_id());



					if(!empty($activity_list))



					{



						foreach($activity_list as $retrive)



						{



							echo "<li><i class='fa fa-arrow-right'></i> ".esc_html($retrive->activity_title)."</li>";



						}



					}



				?>	



				</ul>			



				<hr>



				<?php



				}



				?>



			</div>			



			



			<?php 			



			$user_info=get_userdata(get_current_user_id());



			?> 



			<div class="col-md-8 m-t-lg">



				<?php 



				if(isset($_REQUEST['message']))



				{



					$message =esc_attr($_REQUEST['message']);



					if($message == 2)



					{



						?>



						<div id="message" class="alert_msg alert alert-success alert-dismissible " role="alert">



							<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span>



							</button>



							<?php esc_html_e('User Profile updated successfully.','gym_mgt');?>



						</div>



						<?php 



					}



					if($message == 3 )



					{ 



						?>



						<div id="message" class="alert_msg alert alert-success alert-dismissible " role="alert">



							<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span>



							</button>



							<?php esc_html_e('User profile image updated successfully.','gym_mgt');?>



						</div>



						<?php 



					}



				}



				if(isset($_REQUEST['sucess']))



				{



					$sucess =esc_attr($_REQUEST['sucess']);



					if($sucess == 2)



					{ 



						?>



						<div id="message" class="alert_msg alert alert-success alert-dismissible " role="alert">



							<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span>



							</button>



							<?php esc_html_e('Confirm Password Not Match with New Password.','gym_mgt');?>



						</div>



						<?php 



					}



					elseif($sucess == 3)



					{



						?>



						<div id="message" class="alert_msg alert alert-success alert-dismissible " role="alert">



							<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span>



							</button>



							<?php esc_html_e('Please enter the correct current password.','gym_mgt');?>



						</div>



						<?php



					}



				}



				?>



				<div class="panel panel-white">



					<div class="panel-heading">



						<div class="panel-title"><?php esc_html_e('Account Settings ','gym_mgt');?>	</div>



					</div>



					<div class="panel-body">



						<form class="form-horizontal" action="#" method="post">



							<input type="hidden" value="edit" name="action">



							<input type="hidden" value="<?php echo esc_attr($obj_gym->role);?>" name="role">



							<input type="hidden" value="<?php echo get_current_user_id();?>" name="user_id">







							<?php 



							if(isset($_REQUEST['account_app_view']) == 'account_app')



							{



							?>



								<input type="hidden" value="web_view_hide" name="page_action">



							<?php 



							}



							?>



							<div class="form-group">



								<div class="col-xs-10">	



									<p>



										<h4 class="bg-danger"><?php 



										if(isset($_REQUEST['sucess']))



										{ 



											if($_REQUEST['sucess']==1)



											{



												wp_safe_redirect(home_url()."?dashboard=user&page=account&action=edit&message=2" );



											}



										}?></h4>



									</p>



								</div>



							</div>



							<div class="form-body user_form"> <!-- user_form Strat-->   



								<div class="row rtl_width_100_per"><!--Row Div Strat-->



									



									<div class="col-md-6 col-lg-6 col-sm-12 col-xl-6">



										<div class="form-group input">



											<div class="col-md-12 form-control">



												<input type="text" class="form-control space_validation" maxlength="50" id="name" placeholder="" value="<?php echo esc_attr($user->user_email); ?>" readonly>



												<label class="" for="date"><?php esc_html_e('Email ID','gym_mgt');?></label>



											</div>



										</div>



									</div>



									<div class="col-md-6 col-lg-6 col-sm-12 col-xl-6">



										<div class="form-group input">



											<div class="col-md-12 form-control">



												<input type="password" class="form-control space_validation" min_length="8" maxlength="12" id="inputPassword" placeholder="<?php esc_html_e('Current Password','gym_mgt');?>"  name="current_pass">



												<label class="" for="date"><?php esc_html_e('Current Password','gym_mgt');?></label>



											</div>



										</div>



									</div>



									<div class="col-md-6 col-lg-6 col-sm-12 col-xl-6">



										<div class="form-group input">



											<div class="col-md-12 form-control">



												<input type="password" class="validate[required] form-control space_validation" id="new_pass" min_length="8" maxlength="12" id="inputPassword" placeholder="<?php esc_html_e('New Password','gym_mgt');?>" name="new_pass">



												<label class="" for="date"><?php esc_html_e('New Password','gym_mgt');?></label>



											</div>



										</div>



									</div>



									<div class="col-md-6 col-lg-6 col-sm-12 col-xl-6">



										<div class="form-group input">



											<div class="col-md-12 form-control">



												<input type="password" class="validate[required,equals[new_pass]] form-control space_validation" id="inputPassword"  min_length="8" maxlength="12" placeholder="<?php esc_html_e('Confirm Password','gym_mgt');?>" name="conform_pass">



												<label class="" for="date"><?php esc_html_e('Confirm Password','gym_mgt');?></label>



											</div>



										</div>



									</div>



							



									<!--nonce-->



									<?php wp_nonce_field( 'save_change_nonce' ); ?>



									<!--nonce-->



									<?php 



									if($user_access['edit']=='1')



									{ 



										?>





												<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">



													<button type="submit" class="btn save_btn" name="save_change"><?php esc_html_e('Save','gym_mgt');?></button>



												</div>



										<?php 



									} ?>	



									</div>



								</div>



						</form>



					</div>		   



				</div>



				<div class="panel panel-white">



					<div class="panel-heading">



						<div class="panel-title"><?php esc_html_e('Other Information','gym_mgt');?></div>



					</div>



					<div class="panel-body">



						<form class="form-horizontal" action="#" method="post" id="doctor_form">



							<input type="hidden" value="edit" name="action">



							<input type="hidden" value="<?php echo esc_attr($obj_gym->role);?>" name="role">



							<input type="hidden" value="<?php echo get_current_user_id();?>" name="user_id">



							<input type="hidden" value="<?php print esc_attr($first_name) ?>" name="first_name" >



							<input type="hidden" value="<?php print esc_attr($last_name) ?>" name="last_name" >



							<?php 



							if(isset($_REQUEST['account_app_view']) == 'account_app')



							{



							?>



								<input type="hidden" value="web_view_hide" name="page_action">



							<?php 



							}



							?>



							<div class="form-body user_form"> <!-- user_form Strat-->   



								<div class="row"><!--Row Div Strat-->



									<div class="col-md-6 col-lg-6 col-sm-12 col-xl-6">



										<div class="form-group input">



											<div class="col-md-12 form-control">



												<input id="first_name" class="form-control validate[required,custom[onlyLetter_specialcharacter]] text-input" maxlength="50" type="text" value="<?php if($edit){ echo esc_attr($user_info->first_name);} ?>" name="first_name">



												<label class="" for="date"><?php esc_html_e('First Name','gym_mgt');?><span class="require-field">*</span></label>



											</div>



										</div>



									</div>



									<div class="col-md-6 col-lg-6 col-sm-12 col-xl-6">



										<div class="form-group input">



											<div class="col-md-12 form-control">



												<input id="middle_name" class="form-control validate[custom[onlyLetter_specialcharacter] " type="text" maxlength="50"  value="<?php if($edit){ echo esc_attr($user_info->middle_name);} ?>" name="middle_name">



												<label class="" for="date"><?php esc_html_e('Member Type','gym_mgt');?></label>



											</div>



										</div>



									</div>



									<div class="col-md-6 col-lg-6 col-sm-12 col-xl-6">



										<div class="form-group input">



											<div class="col-md-12 form-control">



												<input id="last_name" class="form-control validate[required,custom[onlyLetter_specialcharacter]] text-input" maxlength="50" type="text" value="<?php if($edit){ echo esc_attr($user_info->last_name);} ?>" name="last_name">



												<label class="" for="date"><?php esc_html_e('Last Name','gym_mgt');?><span class="require-field">*</span></label>



											</div>



										</div>



									</div>



									<div class="col-md-6 col-lg-6 col-sm-12 col-xl-6">



										<div class="form-group input">



											<div class="col-md-12 form-control">



												<input id="birth_date" class="form-control validate[required]" type="text"  name="birth_date" value="<?php if($edit){ echo esc_attr(MJ_gmgt_getdate_in_input_box($user_info->birth_date));}elseif(isset($_POST['birth_date'])) echo $_POST['birth_date'];?>" readonly>



												<label class="date_of_birth_label" for="date"><?php esc_html_e('Date of Birth','gym_mgt');?><span class="require-field">*</span></label>



											</div>



										</div>



									</div>

									

									<div class="col-md-6 col-lg-6 col-sm-12 col-xl-6">



										<div class="form-group input">



											<div class="col-md-12 form-control">



												<input id="phone" class="form-control text-input validate[custom[phone_number]]" type="text" minlength="6" maxlength="15"  name="phone" value="<?php if($edit){ echo esc_attr($user_info->phone);}?>">



												<label class="" for="date"><?php esc_html_e('Phone','gym_mgt');?></label>



											</div>



										</div>



									</div>



									<div class="col-md-6 col-lg-6 col-sm-12 col-xl-6">



										<div class="form-group input">



											<div class="col-md-12 form-control">



												<input id="email" class="form-control validate[required,custom[email]] text-input" maxlength="100" type="text"  name="email" value="<?php if($edit){ echo esc_attr($user_info->user_email);}?>">



												<label class="" for="date"><?php esc_html_e('Email','gym_mgt');?><span class="require-field">*</span></label>



											</div>



										</div>



									</div>

									

									



									<div class="col-md-6 col-lg-6 col-sm-12 col-xl-6">



										<div class="form-group input">



											<div class="col-md-12 form-control">



												<input id="address" class="form-control validate[custom[address_description_validation]]" maxlength="150" type="text"  name="address" value="<?php if($edit){ echo esc_attr($user_info->address);}?>">



												<label class="" for="date"><?php esc_html_e('Home Town Address','gym_mgt');?></label>



											</div>



										</div>



									</div>



									<div class="col-md-6 col-lg-6 col-sm-12 col-xl-6">



										<div class="form-group input">



											<div class="col-md-12 form-control">



												<input id="city_name" class="form-control validate[custom[city_state_country_validation]]" maxlength="50" type="text"  name="city_name" value="<?php if($edit){ echo esc_attr($user_info->city_name);}?>">



												<label class="" for="date"><?php esc_html_e('City','gym_mgt');?></label>



											</div>



										</div>



									</div>



									



								</div>



							</div>



							<?php 



							if($user_access['edit']=='1')



							{ 



								?>



								<div class="form-body user_form"> <!-- user_form Strat-->   



									<div class="row"><!--Row Div Strat-->



										<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">



											<button type="submit" class="btn save_btn" name="profile_save_change"><?php esc_html_e('Save','gym_mgt');?></button>



										</div>



									</div>



								</div>



								<?php 



							} ?>



						</form>



					</div>



				</div>				



			</div>					



		</div><!-- ROW DIV END -->



 	</div><!-- MAIN WRAPPER DIV END -->



</div>



<?php 



//ADD USER DATA



if(isset($_POST['profile_save_change']))

{



	$result=$obj_member->MJ_gmgt_gmgt_add_user($_POST);



	if($result)



	{ 



		if(isset($_REQUEST['page_action']) &&isset($_REQUEST['page_action']) == 'web_view_hide')



		{



			wp_safe_redirect(home_url()."?dashboard=user&page=account&page_action=web_view_hide&action=edit&message=2" );



		}



		else



		{



			wp_safe_redirect(home_url()."?dashboard=user&page=account&action=edit&message=2" );



		}



	}



}



//SAVE PROFILE PICTURE



if(isset($_POST['save_profile_pic']))



{



	$referrer = $_SERVER['HTTP_REFERER'];



	if($_FILES['profile']['size'] > 0)



	{



		$user_image=MJ_gmgt_load_documets($_FILES['profile'],'profile','pimg');



		$photo_image_url=content_url().'/uploads/gym_assets/'.$user_image;



	}



 	$returnans=update_user_meta($user->ID,'gmgt_user_avatar',$photo_image_url);



	if($returnans)



	{



		wp_redirect($referrer.'&message=3');



	}   



}



?>