<div class="mailbox-content"><!--MAILBOX CONTENT DIV START-->   
	<div class="table-responsive"><!--TABLE RESPONSIVE DIV START-->  
		<table class="table"><!--INBOX TABLE START-->  
			<thead>
				<tr> 				
					<th class="text-right" colspan="5">
					   <?php 
					   $message = MJ_gmgt_count_inbox_item(get_current_user_id());             
						$max = 10;
						if(isset($_GET['pg']))
						{
							$p = $_GET['pg'];
						}else
						{
							$p = 1;
						} 
						$limit = ($p - 1) * $max;
						$prev = $p - 1;
						$next = $p + 1;
						$limits = (int)($p - 1) * $max;
						$totlal_message =count($message);
						$totlal_message = ceil($totlal_message / $max);
						$lpm1 = $totlal_message - 1;
						$offest_value = ($p-1) * $max;
						echo MJ_gmgt_inbox_pagination($totlal_message,$p,$lpm1,$prev,$next);
						?>
					</th>
				</tr>
			</thead>
			<tbody>
			<tr> 			
				<th class="hidden-xs">
					<span><?php esc_html_e('Message For','gym_mgt');?></span>
				</th>
				<th><?php esc_html_e('Subject','gym_mgt');?></th>
				<th>
					  <?php esc_html_e('Description','gym_mgt');?>
				</th>
			</tr>
			<?php
			//GET INBOX MESSAGE
			$message = MJ_gmgt_get_inbox_message(get_current_user_id(),$limit,$max);
			foreach($message as $msg)
			{
				?>
				<tr> 			
					<td><?php echo esc_html(MJ_gmgt_get_display_name($msg->sender));?></td>
					<td> 					    <?php						   						  //$url='?dashboard=user&page=message&tab=view_message&from=inbox&id='.esc_attr($msg->message_id).'';						  $url = wp_nonce_url( '?dashboard=user&page=message&tab=view_message&from=inbox&id='.esc_attr($msg->message_id),'wp_url_senitize');						  ?>						  
						 <a href="<?php echo esc_url($url);?>"> <?php echo esc_html($msg->subject);?></a>
					</td>
					<td><?php echo esc_html($msg->message_body);?>
					</td>
					<td>
						<?php echo mysql2date('d M',esc_html($msg->date));?>
					</td>
				</tr>
				<?php 
			}
			?>
			</tbody>
		</table><!--INBOX TABLE END-->  
 	</div><!--TABLE RESPONSIVE DIV END-->  
</div><!--MAILBOX CONTENT DIV END-->  