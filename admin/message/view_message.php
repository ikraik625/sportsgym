<script type="text/javascript">

	jQuery(document).ready(function($) 

	{

		"use strict";

		$('#message-replay').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});



	});

</script>

<?php 

$obj_message= new MJ_gmgt_message; 

//DELETE SENDBOX DATA

if($_REQUEST['from']=='sendbox')

{

	$message = get_post($_REQUEST['id']);

	MJ_gmgt_change_read_status_reply($_REQUEST['id']);

	$author = $message->post_author;

	$box='sendbox';

	if(isset($_REQUEST['delete']))

	{

		echo esc_attr($_REQUEST['delete']);

		wp_delete_post($_REQUEST['id']);

		wp_safe_redirect(admin_url()."admin.php?page=Gmgt_message&tab=sentbox" );

		exit();

	}

}

//Delete INBOX DATA

if($_REQUEST['from']=='inbox')

{

	$message = MJ_gmgt_get_message_by_id($_REQUEST['id']);

	

	$message1 = get_post($message->post_id);



	$author = $message1->post_author;	

	

	MJ_gmgt_change_read_status($_REQUEST['id']);

	MJ_gmgt_change_read_status_reply($message1->ID);

	$box='inbox';

	if(isset($_REQUEST['delete']))

	{

		echo esc_attr($_REQUEST['delete']);

		$obj_message->MJ_gmgt_delete_message($_REQUEST['id']);

		wp_safe_redirect(admin_url()."admin.php?page=Gmgt_message&tab=inbox" );

		exit();

	}

}



//SAVE Reply MESSAGE DATA

if(isset($_POST['replay_message']))

{

	$message_id=esc_attr($_REQUEST['id']);

	$message_from=esc_attr($_REQUEST['from']);

	$result=$obj_message->MJ_gmgt_send_replay_message($_POST);

	if($result)

	{

		wp_safe_redirect(admin_url()."admin.php?page=Gmgt_message&tab=view_message&from=".$message_from."&id=$message_id&message=1" );

	}

}

//Delete REPLY MESSAGE DATA

if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete-reply' && isset($_REQUEST['reply_id']))

{

	$message_id=esc_attr($_REQUEST['id']);

	$message_from=esc_attr($_REQUEST['from']);

	$result=$obj_message->MJ_gmgt_delete_reply($_REQUEST['reply_id']);

	if($result)

	{

		wp_redirect (admin_url().'admin.php?page=Gmgt_message&tab=view_message&action=delete-reply&from='.$message_from.'&id='.$message_id.'&message=2');

	}

}

?>

<div class="mailbox-content"><!--MAILBOX CONTENT DIV STRAT-->

 	<div class="message-header">

		<h3><span><?php esc_html_e('Subject','gym_mgt')?> :</span> <?php if($box=='sendbox'){ echo esc_html($message->post_title); } else{ echo esc_html($message->subject); } ?></h3>

        <p class="message-date"><?php  if($message->date != '') echo MJ_gmgt_getdate_in_input_box(esc_html($message->date));?></p>

	</div>

	<div class="message-sender">                                

    	<p><?php if($box=='sendbox'){ echo MJ_gmgt_get_display_name(esc_html($message->post_author)); } else{ echo MJ_gmgt_get_display_name(esc_html($message->sender)); } ?> <span>&lt;<?php if($box=='sendbox'){ echo MJ_gmgt_get_emailid_byuser_id(esc_html($message->post_author)); } else{ echo MJ_gmgt_get_emailid_byuser_id(esc_html($message->sender)); } ?>&gt;</span></p>

    </div>

	<div class="message-content"><!--MESSAGE CONTENT DIV STRAT-->

    	<p>

		<?php

		if($box=='sendbox')

		{

			$message_for=get_post_meta($_REQUEST['id'],'message_for',true);

			echo esc_html_e('From :','gym_mgt')." ".MJ_gmgt_get_display_name($message->post_author)."<span>&lt;".MJ_gmgt_get_emailid_byuser_id($message->post_author)."&gt;</span><br>";

			if($message_for == 'user'){

			echo esc_html_e('To :','gym_mgt')." ".MJ_gmgt_get_display_name(get_post_meta($_REQUEST['id'],'message_for_userid',true))."<span>&lt;".MJ_gmgt_get_emailid_byuser_id(get_post_meta($_REQUEST['id'],'message_for_userid',true))."&gt;</span><br>";}

			else{

			echo esc_html_e('To :','gym_mgt')." ".esc_html__('Group','gym_mgt');}?>

			<?php 

		} 

		else

		{ 

			echo esc_html_e('From :','gym_mgt')." ".MJ_gmgt_get_display_name($message->sender)."<span>&lt;".MJ_gmgt_get_emailid_byuser_id($message->sender)."&gt;</span><br>";

			echo esc_html_e('To :','gym_mgt')." ".MJ_gmgt_get_display_name($message->receiver); ?>"<span>&lt;<?php echo MJ_gmgt_get_emailid_byuser_id($message->receiver);?>&gt;</span>

			<?php 

		}?>

		

		</p>

	    <div class="message-content"><!--MESSAGE CONTENT---->

			<p>

				<?php $receiver_id=0;

				if($box=='sendbox')

				{ 

					echo wordwrap($message->post_content,120,"<br>\n",TRUE);

					$receiver_id=(get_post_meta($_REQUEST['id'],'message_for_userid',true));} else{ echo wordwrap($message->message_body,120,"<br>\n",TRUE);

					$receiver_id=$message->sender;

				}

				?>

			</p>

			<?php 

			if($user_access_delete == '1')

			{ ?>

				<div class="message-options pull-right">

					<a class="btn btn-default save_btn msg_delete_btn " href="?page=Gmgt_message&tab=view_message&id=<?php echo $_REQUEST['id'];?>&from=<?php echo $box;?>&delete=1" onclick="return confirm('<?php esc_html_e('Are you sure you want to delete this record?','gym_mgt');?>');"><i class="fa fa-trash m-r-xs"></i><?php esc_html_e('Delete','gym_mgt')?></a> 

				</div>

				<?php 

			} ?>

		</div>

   	</div><!--MESSAGE CONTENT DIV END-->

    <?php 

	//GET MESSAGE ALL REPLY DATA

	if(isset($_REQUEST['from']) && $_REQUEST['from']=='inbox')

	{

		$allreply_data=$obj_message->MJ_gmgt_get_all_replies($message->post_id);

	}

	else

	{

		$allreply_data=$obj_message->MJ_gmgt_get_all_replies($_REQUEST['id']);

	}

	if(!empty($allreply_data))

	{		

		foreach($allreply_data as $reply)

		{

			$receiver_name=MJ_gmgt_get_receiver_name_array($reply->message_id,$reply->sender_id,$reply->created_date,$reply->message_comment);

			?>

			<div class="message-content"><!--MESSAGE CONTENT DIV STRAT-->

				<p><?php echo esc_html($reply->message_comment);?><br>

					<h5>

						<?php

						esc_html_e('Reply By : ','gym_mgt'); 

						echo MJ_gmgt_get_display_name($reply->sender_id); 

						esc_html_e(' || ','gym_mgt'); 	

						esc_html_e('Reply To : ','gym_mgt'); 

						echo esc_html($receiver_name); 

						esc_html_e(' || ','gym_mgt'); 	

						?>

					<span class="timeago" title="<?php echo MJ_gmgt_gmgtConvertTime($reply->created_date);?>"></span>

					<span class="comment-delete">

					<a href="admin.php?page=Gmgt_message&tab=view_message&action=delete-reply&from=<?php echo $_REQUEST['from'];?>&id=<?php echo esc_attr($_REQUEST['id']);?>&reply_id=<?php echo esc_attr($reply->id);?>"><?php esc_html_e('Delete','gym_mgt');?></a></span>

					</h5> 

				</p>

			</div><!--MESSAGE CONTENT DIV END-->

		<?php

		}

	}

	?>

		<script type="text/javascript">

			$(document).ready(function() 

			{

				"use strict";

				$('#selected_users').multiselect(

				{

					nonSelectedText :'<?php esc_html_e('Select users to reply','gym_mgt');?>',

					includeSelectAllOption: true,

					allSelectedText :'<?php esc_html_e('All Selected','gym_mgt'); ?>',

					selectAllText : '<?php esc_html_e('Select all','gym_mgt'); ?>',

					templates: {

							button: '<button class="multiselect btn btn-default dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><span class="multiselect-selected-text"></span><b class="caret"></b></button>',

						},

					buttonContainer: '<div class="dropdown" />'

				});	

				$("body").on("click","#check_reply_user",function()

				{

					var checked = $(".dropdown-menu input:checked").length;



					if(!checked)

					{

						alert("<?php esc_html_e('Please select atleast one users to reply','gym_mgt');?>");

						return false;

					}		

				}); 

				$("body").on("click","#replay_message_btn",function()

				{

					$(".replay_message_div").show();	

					$( ".replay_message_div" ).removeClass( "display_none" );

					$(".replay_message_btn").hide();	

				});   

			});

		</script>



	</form><!--MESSAGE REPLY FORM END-->

	<form name="message-replay" method="post" id="message-replay"><!--MESSAGE REPLAY FORM---->

		<input type="hidden" name="message_id" value="<?php if($_REQUEST['from']=='sendbox') echo esc_attr($_REQUEST['id']); else echo esc_attr($message->post_id);?>">

		<input type="hidden" name="user_id" value="<?php echo get_current_user_id();?>">

			

			<?php

			global $wpdb;

			$tbl_name = $wpdb->prefix .'Gmgt_message';

			$current_user_id=get_current_user_id();

			if((string)$current_user_id == $author)

			{		

				if($_REQUEST['from']=='sendbox')

				{

					$msg_id=$_REQUEST['id']; 

					$msg_id_integer=(int)$msg_id;

					$reply_to_users =$wpdb->get_results("SELECT *  FROM $tbl_name where post_id = $msg_id_integer");			

				}

				else

				{

					$msg_id=$message->post_id;			

					$msg_id_integer=(int)$msg_id;

					$reply_to_users =$wpdb->get_results("SELECT *  FROM $tbl_name where post_id = $msg_id_integer");			

				}		

			}

			else

			{

				$reply_to_users=array();

				$reply_to_users[]=(object)array('receiver'=>$author);

			}

			?>

			

			<div class="message-options pull-right">

				<button type="button" name="replay_message_btn" class="btn btn-default save_btn replay_message_btn" id="replay_message_btn"><i class="fa fa-reply m-r-xs"></i><?php esc_html_e('Reply','gym_mgt')?></button>

		 	</div>



			<div class="message-content float_left_width_100 replay_message_div display_none">

				<div class="form-body user_form"> <!-- user_form Strat-->   

					<div class="row"><!--Row Div Strat--> 



						<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 res_margin_bottom_20px rtl_margin_top_15px">

							<!-- <label class="col-sm-3 control-label form-label" ><?php esc_html_e('Select users to reply','gym_mgt');?><span class="require-field">*</span></label> -->

												

							<select name="receiver_id[]" class="form-control" id="selected_users" multiple="true" data-mdb-filter="true">

								<?php						

								foreach($reply_to_users as $reply_to_user)

								{  	

									$user_data=get_userdata($reply_to_user->receiver);

									if(!empty($user_data))

									{								

										if($reply_to_user->receiver != get_current_user_id())

										{

											?>

											<option  value="<?php echo esc_attr($reply_to_user->receiver);?>" ><?php echo MJ_gmgt_get_display_name($reply_to_user->receiver); ?></option>

											<?php

										}

									}							

								} 

								?>

							</select>

						</div>



						<div class="col-md-6 note_text_notice">

							<div class="form-group input">

								<div class="col-md-12 note_border margin_bottom_15px_res">

									<div class="form-field">

										<textarea name="replay_message_body" maxlength="150" id="replay_message_body" class="textarea_height_47px validate[required] form-control text-input"></textarea>

										<span class="txt-title-label"></span>

										<label class="text-area address active" for="photo"><?php esc_html_e('Message Comment','gym_mgt');?><span class="require-field">*</span></label>

									</div>

								</div>

							</div>

						</div>	



					</div><!--Row Div End--> 

				</div><!-- user_form End-->

				<?php 

				if($user_access_add == '1')

				{ ?>

					<!------------   save btn  -------------->  

					<div class="form-body user_form"> <!-- user_form Strat-->   

						<div class="row"><!--Row Div Strat--> 

							<div class="col-md-6 col-sm-6 col-xs-12 message-options reply-message-btn"><!--save btn-->  

								<button type="submit" name="replay_message" class="btn save_btn" id="check_reply_user"><?php esc_html_e('Send Message','gym_mgt')?></button>

							</div>

						</div><!--Row Div End--> 

					</div><!-- user_form End-->

					<?php 

				} ?>

			</div>

		</form>

</div><!--MAILBOX CONTENT DIV END-->