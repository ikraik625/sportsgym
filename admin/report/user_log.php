<div class=" clearfix  padding_top_15px_res"> <!------  penal body  -------->



    <form method="post" id="attendance_list" class="attendance_list">  

        <div class="form-body user_form margin_top_15px">

            <div class="row">

                <div class="col-md-6 mb-6 input">

                    <label class="ml-1 custom-top-label top" for="class_id"><?php esc_attr_e('Date Type','gym_mgt');?><span class="require-field">*</span></label>			

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

                <div class="col-md-6 mb-6 input">

                    <label class="ml-1 custom-top-label top" for="class_id"><?php esc_attr_e('Action','gym_mgt');?></label>			

                    <select class="line_height_30px form-control" name="role_type" autocomplete="off">

                        <option value="all"><?php esc_attr_e('All Users','gym_mgt');?></option>

                        <option value="member"><?php esc_attr_e('Member','gym_mgt');?></option>	

                        <option value="staff_member"><?php esc_attr_e('Staff Member','gym_mgt');?></option>	

                        <option value="accountant"><?php esc_attr_e('Accountant','gym_mgt');?></option>	

                    </select>

                </div>

                <div id="date_type_div" class="date_type_div_none row col-md-6 mb-2"></div>	

                <div class="col-md-3 mb-2">

                    <input type="submit" name="user_log_report" Value="<?php esc_attr_e('Go','gym_mgt');?>"  class="btn btn-info save_btn"/>

                </div>

            </div>

        </div>

    </form> 

   



    <?php

    if(isset($_REQUEST['user_log_report']))

    {

        $date_type = $_POST['date_type'];

        $role_type = $_POST['role_type'];

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

        $role_type = "all";

        $start_date = date('Y-m-d');

        $end_date= date('Y-m-d');

    }



    if($role_type == "all" || $role_type == "")

    {

        global $wpdb;

        $table_user_log=$wpdb->prefix.'gmgt_user_log';

        $report_6 = $wpdb->get_results("SELECT * FROM $table_user_log where created_at BETWEEN '$start_date' AND '$end_date'");

    }

    else

    {

        global $wpdb;

        $table_user_log=$wpdb->prefix.'gmgt_user_log';

        $report_6 = $wpdb->get_results("SELECT * FROM $table_user_log where role='$role_type' AND  created_at BETWEEN '$start_date' AND '$end_date'");

    }

   

    if(!empty($report_6))

    {

        ?>

         <script type="text/javascript">

            jQuery(document).ready(function($){

                var table = jQuery('#tble_login_log').DataTable({

                    "order": [[ 2, "Desc" ]],

                    "dom": 'lifrtp',

                    buttons:[

                        {

                            extend: 'csv',

                            text:'<?php esc_html_e('CSV', 'gym_mgt') ?>',

                            title: '<?php _e('User Log Report','gym_mgt');?>',

                        },

                        {

                            extend: 'print',

                            text:'<?php esc_html_e('Print', 'gym_mgt')?>',

                            title: '<?php _e('User Log Report','gym_mgt');?>',

                        },

                    ],

                    "aoColumns":[

                        {"bSortable": false},

                        {"bSortable": true},

                        {"bSortable": true},

                        {"bSortable": true}

                    ],

                    language:<?php echo mj_gmgt_datatable_multi_language();?>

                });

                $('.btn-place').html(table.buttons().container()); 

                $('.dataTables_filter input').attr("placeholder", "<?php esc_html_e('Search...', 'gym_mgt') ?>");

            });

        </script>

        <div class="panel-body padding_top_15px_res"> <!------  penal body  -------->

            

            <div class="table-responsive"> <!------  table Responsive  -------->

            <div class="btn-place"></div>

                <form id="frm-example" name="frm-example" method="post">

                    <table id="tble_login_log" class="display" cellspacing="0" width="100%">

                        <thead class="<?php echo MJ_gmgt_datatable_heder() ?>">

                            <tr>

                                <th> <?php esc_attr_e( 'User Name', 'gym_mgt' ) ;?></th>

                                <th> <?php esc_attr_e( 'User Role', 'gym_mgt' ) ;?></th>

                                <th> <?php esc_attr_e( 'IP Address', 'gym_mgt' ) ;?></th>

                                <th> <?php esc_attr_e( 'Login Time', 'gym_mgt' ) ;?></th>

                            </tr>

                        </thead>

                        <tbody>

                            <?php 

                            foreach($report_6 as $result)

                            {	

                                $user_object = get_user_by( "login", $result->user_login );

                               

                                ?>

                                <tr>

                                    <td class="patient"><?php if(!empty($result->user_login)){ echo $user_object->display_name; }else{ echo "N/A"; } ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('User Name','gym_mgt');?>"></i></td>

                                    <td class="patient_name text_transform_capitalize"><?php if(!empty($result->role)){ echo $result->role; }else{ echo "N/A"; } ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('User Role','gym_mgt');?>"></i></td>

                                    <td class="income_amount"><?php echo getHostByName(getHostName()); ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('IP Address','gym_mgt');?>"></i></td>

                                    <td class="status"><?php if(!empty($result->date_time)){ echo $result->date_time; }else{ echo "N/A"; } ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Login Time','gym_mgt');?>"></i></td>

                                </tr>

                                <?php 

                            } 

                            ?>     

                        </tbody>        

                    </table>

                </form>

            </div> <!------  table responsive  -------->

        </div> <!------  penal body  -------->

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

</div> <!------  penal body  -------->