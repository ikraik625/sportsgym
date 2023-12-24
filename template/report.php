<?php 



$active_tab=isset($_REQUEST['tab'])?$_REQUEST['tab']:'membership_report';



?>



<script type="text/javascript">



$(document).ready(function() 



{



	"use strict";



	$.datepicker.setDefaults($.datepicker.regional['<?php echo MJ_gmgt_get_current_lan_code(); ?>']);



	$('.sdate').datepicker({dateFormat: '<?php echo get_option('gmgt_datepicker_format');?>'});



	$('.edate').datepicker({dateFormat: '<?php echo get_option('gmgt_datepicker_format');?>'});



} );



</script>







<div class="panel-white padding_0 gms_main_list"><!--PANEL WHITE DIV START-->

    <?php 

    if($active_tab !='membership_report' && $active_tab !='attendance_report' && $active_tab !='member_information' && $active_tab !='user_log'  && $active_tab !='audit_trail')

    {

        ?>

        <ul class="nav nav-tabs panel_tabs margin_left_1per mb-3" role="tablist"><!-- NAV TAB WRAPPER MENU START-->

            <?php 

            if($active_tab=='member_information')

            {

                ?>

                <li class="<?php if($active_tab=='membership_report'){?>active<?php }?>">



                    <a href="?dashboard=user&page=report&tab=membership_report&tab1=membership_report" class="padding_left_0 tab <?php echo $active_tab == 'membership_report' ? 'nav-tab-active' : ''; ?>">



                    <?php echo esc_html__('Membership', 'gym_mgt'); ?></a>



                </li>

                <?php

            } 

            if($active_tab=='attendance_report')

            {

                ?>

                <li class="<?php if($active_tab=='attendance_report'){?>active<?php }?>">



                    <a href="?dashboard=user&page=report&tab=attendance_report" class="padding_left_0 tab <?php echo $active_tab == 'attendance_report' ? 'nav-tab-active' : ''; ?>">



                    <?php echo esc_html__('Attendance', 'gym_mgt'); ?></a>



                </li>

                <?php

            } ?>

            <!-- <li class="<?php if($active_tab=='member_status_report'){?>active<?php }?>">



                <a href="?dashboard=user&page=report&tab=member_status_report" class="padding_left_0 tab <?php echo $active_tab == 'member_status_report' ? 'nav-tab-active' : ''; ?>">



                <?php echo esc_html__('Membership Status', 'gym_mgt'); ?></a>



            </li> -->



            <li class="<?php if($active_tab=='payment_report'){?>active<?php }?>">



                <a href="?dashboard=user&page=report&tab=payment_report" class="padding_left_0 tab <?php echo $active_tab == 'payment_report' ? 'nav-tab-active' : ''; ?>">



                <?php echo esc_html__('Income & Expense Payment', 'gym_mgt'); ?></a>



            </li>



            <li class="<?php if($active_tab=='feepayment_report'){?>active<?php }?>">



                <a href="?dashboard=user&page=report&tab=feepayment_report" class="padding_left_0 tab <?php echo $active_tab == 'feepayment_report' ? 'nav-tab-active' : ''; ?>">



                <?php echo esc_html__('Membership Payment', 'gym_mgt'); ?></a>



            </li>

            <?php 

            if($active_tab=='sell_product_report')

            {

                ?>

                <li class="<?php if($active_tab=='sell_product_report'){?>active<?php }?>">



                    <a href="?dashboard=user&page=report&tab=sell_product_report" class="padding_left_0 tab <?php echo $active_tab == 'sell_product_report' ? 'nav-tab-active' : ''; ?>">



                    <?php echo esc_html__('Sale Product', 'gym_mgt'); ?></a>



                </li>

                <?php

            } ?>

        </ul>

        <?php

    } ?>



    <div class="panel-body padding_0 report_main_penal_body_div"><!--PANEL BODY DIV START-->



        <div class="clearfix"></div>



        <?php 



        if($active_tab == 'member_information')

        {

            $obj_membership=new MJ_gmgt_membership;

            

            if(isset($_REQUEST['view_member']))

            {

                $membership_id = "all_membership";

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

            

            <div class="panel-body padding_0 mt-3">

            

                <form method="post" id="attendance_list" class="attendance_list report">  

                    <div class="form-body user_form margin_top_15px res-margin-top-250px">

                        <div class="row">

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

            

            </div>

            

            <div class="panel-body padding_0 "><!--PANEL BODY DIV START-->

            

                <?php

            

                if(!empty($members_data))

            

                { 

            

                    ?>

            

                    <script type="text/javascript">

            

                         jQuery(document).ready(function($)

            

                        {

            

                            "use strict";

            

                            var table = jQuery('#memberinfof').DataTable({

            

                                // "responsive": true,

            

                                "order": [[ 1, "asc" ]],

            

                                dom: 'lifrtp',

            

                                buttons:[

                                    {

                                        extend: 'csv',

                                        text:'<?php esc_html_e('CSV', 'gym_mgt') ?>',

                                        title: '<?php _e('Member Information Report','gym_mgt');?>',

                                        exportOptions: {

                                            columns: [1, 2, 3,4,5], // Only name, email and role

                                        }

                                    

                                    },

                                    {

                                        extend: 'print',	

                                        text:'<?php esc_html_e('Print', 'gym_mgt') ?>',

                                        title: '<?php _e('Member Information Report','gym_mgt');?>',

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

            

                                        {"bSortable": true}

            

                                    ],

            

                                language:<?php echo MJ_gmgt_datatable_multi_language();?>		   

            

                            });

                            $('.btn-place').html(table.buttons().container()); 

                            $('.dataTables_filter input').attr("placeholder", "<?php esc_html_e('Search...', 'gym_mgt') ?>");

            

                        } );

            

                    </script>

            

                    <div class="table-responsive"><!--TABLE RESPONSIVE DIV START-->

                        <div class="btn-place"></div>

            

                        <form name="wcwm_report" action="" method="post"><!--EXPENSE LIST FORM START-->

            

                            <table id="memberinfof" class="display" cellspacing="0" width="100%"><!--EXPENSE LIST TABLE START-->

            

                                <thead class="<?php echo MJ_gmgt_datatable_heder(); ?>">

            

                                    <tr>

            

                                        <th><?php esc_html_e('Photo','gym_mgt');?></th>

            

                                        <th><?php esc_html_e('Member Name & Email','gym_mgt');?></th>

            

                                        <th><?php esc_html_e('Membership','gym_mgt');?></th>

            

                                        <th><?php esc_html_e('Joining Date','gym_mgt');?></th>

            

                                        <th><?php esc_html_e('Expiry Date','gym_mgt');?></th>

            

                                        <th><?php esc_html_e('Membership Status','gym_mgt');?></th>

            

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

            

                                                        <img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/Attendance.png"?>" alt="" class="massage_image center image_icon_height_25px margin_top_3px">

            

                                                    </p>

            

                                                </td>

            

                                                <td class="name"> 

            

                                                    <a class="color_black" href="?page=gmgt_member&tab=viewmember&action=view&member_id=<?php echo esc_attr($retrieved_data->ID)?>">

            

                                                        <?php $display_name=get_user_meta($retrieved_data->ID,"display_name",true);

                                                         $display_label = MJ_gmgt_get_member_full_display_name_with_memberid(esc_html($retrieved_data->ID));

                                                        // if(!empty($display_name))

                                                        // {

                                                        //     $display_name1=$display_name;

                                                        // }

                                                        // else

                                                        // {

                                                        //     $display_name1=$retrieved_data->display_name;

                                                        // }

            

                                                        echo esc_html($display_label);?>

            

                                                    </a><br>

                                                    <label class="list_page_email"><?php echo $retrieved_data->user_email;?></label>

                                                    

            

                                                    <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Member Name & Email','gym_mgt');?>" ></i>

            

                                                </td>

            

                                                <td class="name">

            

                                                    <?php $membership_name=MJ_gmgt_get_membership_name($retrieved_data->membership_id);

                                                        if($retrieved_data->membership_id){

                                                            echo esc_html($membership_name);

                                                        }else{

                                                            echo "N/A";

                                                        }

                                                     

                                                    ?>

            

                                                    <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Membership','gym_mgt');?>" ></i>

            

                                                </td>

            

                                                <td class="name">

            

                                                    <?php  

                                                    if(!empty($retrieved_data->begin_date))

            

                                                    {

            

                                                        echo MJ_gmgt_getdate_in_input_box($retrieved_data->begin_date); 

            

                                                    }

            

                                                    else

            

                                                    { 

            

                                                        echo "N/A";

            

                                                    } 

                                                    ?>

            

                                                    <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Joining Date','gym_mgt');?>" ></i>

            

                                                </td>

                                                <td class="joining date">

            

                                                    <?php 

            

                                                    if(!empty($retrieved_data->begin_date)) 

            

                                                    { 

            

                                                        echo MJ_gmgt_getdate_in_input_box(MJ_gmgt_check_membership($retrieved_data->ID)); 

            

                                                    }

            

                                                    else

            

                                                    { 

            

                                                        echo "N/A"; 

            

                                                    } ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Expiry Date','gym_mgt');?>" ></i>

            

                                                </td>

            

            

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

            

                                                    } 

            

                                                    ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Membership Status','gym_mgt');?>" ></i>

            

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

        if($active_tab == 'membership_report')

        {

            $active_tab = isset($_GET['tab'])?$_GET['tab1']:'membership_report';



            ?>

            <h3>



                <ul id="myTab" class="sub_menu_css line case_nav nav nav-tabs panel_tabs margin_left_1per" role="tablist">



                    <li role="presentation" class="<?php echo $active_tab == 'membership_report' ? 'active' : ''; ?> menucss">



                        <a href="?dashboard=user&page=report&tab=membership_report&tab1=membership_report" class="padding_left_0 tab">



                            <?php echo esc_html__('Membership Graph', 'gym_mgt'); ?>



                        </a>



                    </li>



                    <li role="presentation" class="<?php echo $active_tab == 'membership_datatable' ? 'active' : ''; ?> menucss">



                        <a href="?dashboard=user&page=report&tab=membership_report&tab1=membership_datatable" class="padding_left_0 tab">



                            <?php echo esc_html__('Membership Datatable', 'gym_mgt'); ?>



                        </a>



                    </li>



                    <li role="presentation" class="<?php echo $active_tab == 'membership_status' ? 'active' : ''; ?> menucss">



                        <a href="?dashboard=user&page=report&tab=membership_report&tab1=membership_status" class="padding_left_0 tab">



                            <?php echo esc_html__('Membership Status', 'gym_mgt'); ?>



                        </a>



                    </li>



                </ul>	



            </h3>



            <?php

            



        }

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



            <form method="post" id="attendance_list" class="attendance_list report">  

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



                                jQuery(document).ready(function($){



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

                                                }

                                               

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

        elseif($active_tab == 'attendance_report')

        {



            error_reporting(0);



            $active_tab = isset($_GET['tab1'])?$_GET['tab1']:'report_graph';



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



            <ul class="nav nav-tabs panel_tabs margin_left_1per mb-3" role="tablist"><!-- NAV TAB WRAPPER MENU START-->



                <li class="<?php if($active_tab=='report_graph'){?>active<?php }?>">



                    <a href="?dashboard=user&page=report&tab=attendance_report&tab1=report_graph" class="padding_left_0 tab <?php echo $active_tab == 'report_graph' ? 'nav-tab-active' : ''; ?>">



                    <?php echo esc_html__('Attendance Graph', 'gym_mgt'); ?>



                </a>



                </li>



                <li class="<?php if($active_tab=='data_report'){?>active<?php }?>">



                    <a href="?dashboard=user&page=report&tab=attendance_report&tab1=data_report" class="padding_left_0 tab <?php echo $active_tab == 'data_report' ? 'nav-tab-active' : ''; ?>">



                    <?php echo esc_html__('Attendance Datatable', 'gym_mgt'); ?>



                </a>



                </li>



                <li class="<?php if($active_tab=='data_report_staffmember'){?>active<?php }?>">



                    <a href="?dashboard=user&page=report&tab=attendance_report&tab1=data_report_staffmember" class="padding_left_0 tab <?php echo $active_tab == 'data_report_staffmember' ? 'nav-tab-active' : ''; ?>">



                    <?php echo esc_html__('Staff Attendance Datatable', 'gym_mgt'); ?>



                </a>



                </li>



            </ul>



            <?php 



            if($active_tab == 'report_graph')

            {



                global $wpdb;



                $table_attendance = $wpdb->prefix .'gmgt_attendence';



                $table_class = $wpdb->prefix .'gmgt_class_schedule';



                if(isset($_REQUEST['view_attendance']))



                {

                    

                    // $sdate =MJ_gmgt_get_format_for_db(esc_attr($_REQUEST['sdate']));



                    // $edate = MJ_gmgt_get_format_for_db(esc_attr($_REQUEST['edate']));



                    $date_type = $_POST['date_type'];

                    

                    if($date_type=="period")

                    {

                        $sdate = $_REQUEST['start_date'];

                        $edate = $_REQUEST['end_date'];

                        

                    }

                    else

                    {

                        $result =  mj_gmgt_all_date_type_value($date_type);

                

                        $response =  json_decode($result);

                        $sdate = $response[0];

                        $edate = $response[1];

                    

                    }



                }



                else



                {



                    $edate =date("Y-m-d");



                    $sdate=date("Y-m-d", strtotime("-1 week"));



                }



                $report_2 =$wpdb->get_results("SELECT  at.class_id, 



                SUM(case when `status` ='Present' then 1 else 0 end) as Present, 



                SUM(case when `status` ='Absent' then 1 else 0 end) as Absent 



                from $table_attendance as at,$table_class as cl where `attendence_date` BETWEEN '$sdate' AND '$edate' AND at.class_id = cl.class_id AND at.role_name = 'member' GROUP BY at.class_id") ;

                $chart_array = array();

                // $chart_array[] = array(esc_html__('Class','gym_mgt'),esc_html__('Present','gym_mgt'),esc_html__('Absent','gym_mgt'));

                array_push($chart_array, array(esc_html__('Class','gym_mgt'),esc_html__('Present','gym_mgt'),esc_html__('Absent','gym_mgt')));



                if(!empty($report_2))



                    foreach($report_2 as $result)



                    {



                        $class_id =MJ_gmgt_get_class_name($result->class_id);



                        // $chart_array[] = array("$class_id",(int)$result->Present,(int)$result->Absent);



                        array_push($chart_array, array("$class_id",(int)$result->Present,(int)$result->Absent));

                    }

                    $new_array = json_encode($chart_array);

                    ?>

                    <div class="panel-body padding_0 mt-3">



                <form method="post" id="attendance_list"  class="attendance_list report">  

                    <div class="form-body user_form margin_top_15px">

                        <div class="row">

                            <div class="col-md-3 mb-3 input">

                                <label class="ml-1 custom-top-label top" for="class_id"><?php esc_attr_e('Date','gym_mgt');?><span class="require-field">*</span></label>			

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



                            <div id="date_type_div" class="date_type_div_none row col-md-6 mb-2" ></div>	



                            <div class="col-md-3 mb-2">

                                <input type="submit" name="view_attendance" Value="<?php esc_attr_e('Go','gym_mgt');?>"  class="btn btn-info save_btn"/>

                            </div>

                        </div>

                    </div>

                </form>



                

                <?php

                // var_dump($new_array);

                if(!empty($result->Present) || !empty($result->Absent))

                {

                    ?>

                    <script type="text/javascript" src="<?php echo GMS_PLUGIN_URL.'/assets/js/chart_loder.js'; ?>"></script>

                    <script type="text/javascript">

                        google.charts.load('current', {'packages':['bar']});

                        google.charts.setOnLoadCallback(drawChart);



                        function drawChart() {

                            var data = google.visualization.arrayToDataTable(<?php echo $new_array; ?>);



                            var options = {

                            

                                bars: 'vertical', // Required for Material Bar Charts.

                                colors: ['#BA170B','#22BAA0'],

                                title: '<?php esc_html_e('Member Attendance Report', 'gym_mgt') ?>',

                                fontName:'sans-serif',

                                titleTextStyle: 

                                {

                                    color: '#66707e'

                                },

                                

                            };

                        

                            var chart = new google.charts.Bar(document.getElementById('barchart_material'));



                            chart.draw(data, google.charts.Bar.convertOptions(options));

                        }

                    </script>

                    <div id="barchart_material" style="width:100%;height: 430px; padding:20px;"></div>

                    <?php

                }else{

                    ?>

                        <div class="calendar-event-new"> 



                            <img class="no_data_img" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/no_data_img.png"?>" >



                        </div>

                    <?php

                }



            }



            if($active_tab == 'data_report')

            { 



                if(isset($_REQUEST['view_attendance']))



                {



                    $date_type = $_POST['date_type'];



                    $type='member';



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



                        if(!empty($_REQUEST['member_id']) && $_REQUEST['member_id'] != "all_member")

                        {

                            $member_id = $_REQUEST['member_id'];

                            $attendence_data=MJ_gmgt_get_member_attendence_beetween_satrt_date_to_enddate_for_admin($start_date,$end_date,$member_id);

                        }else{

                            $attendence_data=MJ_gmgt_get_all_member_attendence_beetween_satrt_date_to_enddate($start_date,$end_date,$type);

                        }

                        

                    }

                    

                }



                else



                {



                    $start_date = date('Y-m-d',strtotime('first day of this month'));



                    $end_date = date('Y-m-d',strtotime('last day of this month'));



                    $type='member';

                    $attendence_data = MJ_gmgt_get_all_member_attendence_beetween_satrt_date_to_enddate($start_date,$end_date,$type);



                }



            



                ?>



                <div class="panel-body padding_0 mt-3">



                    <form method="post" id="attendance_list" class="attendance_list report">  

                        <div class="form-body user_form margin_top_15px">

                            <div class="row">

                                <div class="col-md-3 mb-3 input">

                                    <label class="ml-1 custom-top-label top" for="class_id"><?php esc_attr_e('Date','gym_mgt');?><span class="require-field">*</span></label>			

                                        <select class="line_height_30px form-control date_type validate[required]" name="date_type" autocomplete="off">

                                            <!-- <option value=""><?php esc_attr_e('Select','gym_mgt');?></option> -->

                                            <option value="today"><?php esc_attr_e('Today','gym_mgt');?></option>

                                            <option value="this_week"><?php esc_attr_e('This Week','gym_mgt');?></option>

                                            <option value="last_week"><?php esc_attr_e('Last Week','gym_mgt');?></option>

                                            <option value="this_month" 	selected><?php esc_attr_e('This Month','gym_mgt');?></option>

                                            <option value="last_month"><?php esc_attr_e('Last Month','gym_mgt');?></option>

                                            <option value="last_3_month"><?php esc_attr_e('Last 3 Months','gym_mgt');?></option>

                                            <option value="last_6_month"><?php esc_attr_e('Last 6 Months','gym_mgt');?></option>

                                            <option value="last_12_month"><?php esc_attr_e('Last 12 Months','gym_mgt');?></option>

                                            <option value="this_year"><?php esc_attr_e('This Year','gym_mgt');?></option>

                                            <option value="last_year"><?php esc_attr_e('Last Year','gym_mgt');?></option>

                                            <option value="period"><?php esc_attr_e('Period','gym_mgt');?></option>

                                        </select>

                                </div>



                                <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3 input">



                                    <!-- <label class="ml-1 custom-top-label top" for="staff_name"><?php //esc_html_e('Member','gym_mgt');?><span class="require-field">*</span></label> -->



                                    <!-- <?php if($edit){ $member_id=$result->member_id; }elseif(isset($_REQUEST['member_id'])){$member_id=sanitize_text_field($_REQUEST['member_id']);}else{$member_id='';}?> -->



                                    <select id="member_list" class="form-control display-members" name="member_id">



                                        <option value="all_member"><?php esc_html_e('All Member','gym_mgt');?></option>



                                            <?php $get_members = array('role' => 'member');



                                            $membersdata=get_users($get_members);



                                            if(!empty($membersdata))

                                            {

                                                foreach ($membersdata as $member)

                                                {

                                                    if( $member->membership_status == "Continue"  && $member->member_type == "Member")

                                                    {		

                                                        ?>

                                                        <option value="<?php echo esc_attr($member->ID);?>" <?php selected(esc_attr($member_id),esc_attr($member->ID));?>><?php echo esc_html(MJ_gmgt_get_member_full_display_name_with_memberid(esc_html($member->ID))); ?> </option>

                                                        <?php		

                                                    }

                                                }

                                            }?>

                                    </select>



                                </div>

                                <div id="date_type_div" class="date_type_div_none row col-md-6 mb-2"></div>	

                                <div class="col-md-3 mb-2">

                                    <input type="submit" name="view_attendance" Value="<?php esc_attr_e('Go','gym_mgt');?>"  class="btn btn-info save_btn"/>

                                </div>

                            </div>

                        </div>

                    </form>



                </div>



                <div class="panel-body padding_0 "><!--PANEL BODY DIV START-->



                    <?php



                    if(!empty($attendence_data))



                    { 



                        ?>



                        <script type="text/javascript">



                            $(document).ready(function() 



                            {



                                "use strict";



                                var table = jQuery('#tblattadence').DataTable({



                                    // "responsive": true,



                                    "order": [[ 2, "Desc" ]],



                                    dom: 'lifrtp',



                                    buttons:[

                                        {

                                            extend: 'csv',

                                            text:'<?php esc_html_e('CSV', 'gym_mgt') ?>',

                                            title: '<?php esc_html_e('Attendance Report', 'gym_mgt') ?>',

                                            exportOptions: {

                                                columns: [1, 2, 3,4,5,6,7], // Only name, email and role

                                            },

                                            charset: 'UTF-8',

                                            bom: true,

                                        },

                                        {

                                            extend: 'print',	

                                            text:'<?php esc_html_e('Print', 'gym_mgt') ?>',

                                            title: '<?php esc_html_e('Attendance Report', 'gym_mgt') ?>',

                                            exportOptions: {

                                                columns: [1, 2, 3,4,5,6,7], // Only name, email and role

                                            }

                                        },

                                    ],



                                    "aoColumns":[



                                            {"bSortable": false},



                                            {"bSortable": true},



                                            {"bSortable": true},



                                            {"bSortable": true},



                                            {"bSortable": true},



                                            {"bSortable": true},



                                            {"bSortable": true},



                                            {"bSortable": true}



                                        ],



                                    language:<?php echo MJ_gmgt_datatable_multi_language();?>		   



                                });

                                $('.btn-place').html(table.buttons().container()); 

                                $('.dataTables_filter input').attr("placeholder", "<?php esc_html_e('Search...', 'gym_mgt') ?>");



                            } );



                        </script>



                        <div class="table-responsive"><!--TABLE RESPONSIVE DIV START-->

                            <div class="btn-place"></div>



                            <form name="wcwm_report" action="" method="post"><!--EXPENSE LIST FORM START-->



                                <table id="tblattadence" class="display" cellspacing="0" width="100%"><!--EXPENSE LIST TABLE START-->



                                    <thead class="<?php echo MJ_gmgt_datatable_heder(); ?>">



                                        <tr>



                                            <th><?php esc_html_e('Photo','gym_mgt');?></th>



                                            <th><?php esc_html_e('Member Name','gym_mgt');?></th>



                                            <th><?php esc_html_e('Class Name','gym_mgt');?></th>



                                            <th><?php esc_html_e('Date','gym_mgt');?></th>



                                            <th><?php esc_html_e('Day','gym_mgt');?></th>



                                            <th><?php esc_html_e('Attendance','gym_mgt');?></th>



                                            <th><?php esc_html_e('Attendance By','gym_mgt');?></th>



                                            <th><?php esc_html_e('Attendance With QR','gym_mgt');?></th>



                                            



                                        </tr>



                                    </thead>



                                    <tbody>



                                        <?php



                                        if(!empty($attendence_data))



                                        { 



                                            $i=0;



                                            foreach ($attendence_data as $retrieved_data)



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



                                                            <img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/Attendance.png"?>" alt="" class="massage_image center image_icon_height_25px margin_top_3px">



                                                        </p>



                                                    </td>



                                                    <td class="name">



                                                        <?php 



                                                        echo MJ_gmgt_get_member_full_display_name_with_memberid($retrieved_data->user_id);



                                                        ?>



                                                        <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Member Name','gym_mgt');?>" ></i>



                                                    </td>



                                                    <td class="name">



                                                        <?php echo MJ_gmgt_get_class_name($retrieved_data->class_id); ?>



                                                        <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Class Name','gym_mgt');?>" ></i>



                                                    </td>



                                                    <td class="name">



                                                        <?php  echo MJ_gmgt_getdate_in_input_box($retrieved_data->attendence_date); ?>



                                                        <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Date','gym_mgt');?>" ></i>



                                                    </td>



                                                    <td class="name">



                                                        <?php 



                                                            $day=date("D", strtotime($retrieved_data->attendence_date));



                                                            echo esc_html__($day,"gym_mgt");



                                                        ?>



                                                        <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Day Name','gym_mgt');?>" ></i>



                                                    </td>



                                                    <td class="name">



                                                        <?php  echo esc_html__($retrieved_data->status,"gym_mgt"); ?>



                                                        <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Attendance Status','gym_mgt');?>" ></i>



                                                    </td>



                                                    <td class="name">



                                                        <?php echo MJ_gmgt_get_user_display_name($retrieved_data->attendence_by) ?>



                                                        <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Attendance By','gym_mgt');?>" ></i>



                                                    </td>



                                                    <td class="name">



                                                        <?php if($retrieved_data->attendance_type == 'QR') { echo _e('Yes','gym_mgt');}elseif($retrieved_data->attendance_type == 'web' || $retrieved_data->attendance_type == NULL){ echo esc_html__('No',"gym_mgt"); }?>



                                                        <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Attendance With QR','gym_mgt');?>" ></i>



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



            if($active_tab == 'data_report_staffmember')

            { 

            

            

                if(isset($_REQUEST['view_attendance']))

            

                {

            

                    $date_type = $_POST['date_type'];

            

                    $type='staff_member';

            

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

            

                        if(!empty($_REQUEST['staff_id']) && $_REQUEST['staff_id'] != "all_member")

                        {

                            $staff_id = $_REQUEST['staff_id'];

                            $attendence_data=MJ_gmgt_get_member_attendence_beetween_satrt_date_to_enddate_for_admin($start_date,$end_date,$staff_id);

                        }else{

                            $attendence_data=MJ_gmgt_get_all_member_attendence_beetween_satrt_date_to_enddate($start_date,$end_date,$type);

                        }

                        

                    }

                    

                }

            

                else

            

                {

            

                    $start_date = date('Y-m-d',strtotime('first day of this month'));

            

                    $end_date = date('Y-m-d',strtotime('last day of this month'));

            

                    $type='staff_member';

                    $attendence_data = MJ_gmgt_get_all_member_attendence_beetween_satrt_date_to_enddate($start_date,$end_date,$type);

            

                }

            

                   // $attendence_data = MJ_gmgt_get_all_member_attendence_beetween_satrt_date_to_enddate($start_date,$end_date,$type);

            

                ?>

            

                <div class="panel-body padding_0 mt-3">

            

                    <form method="post" id="attendance_list" class="attendance_list report">  

                        <div class="form-body user_form margin_top_15px">

                            <div class="row">

                                <div class="col-md-3 mb-3 input">

                                    <label class="ml-1 custom-top-label top" for="class_id"><?php esc_attr_e('Date','gym_mgt');?><span class="require-field">*</span></label>			

                                        <select class="line_height_30px form-control date_type validate[required]" name="date_type" autocomplete="off">

                                            <!-- <option value=""><?php esc_attr_e('Select','gym_mgt');?></option> -->

                                            <option value="today"><?php esc_attr_e('Today','gym_mgt');?></option>

                                            <option value="this_week"><?php esc_attr_e('This Week','gym_mgt');?></option>

                                            <option value="last_week"><?php esc_attr_e('Last Week','gym_mgt');?></option>

                                            <option value="this_month" selected	><?php esc_attr_e('This Month','gym_mgt');?></option>

                                            <option value="last_month"><?php esc_attr_e('Last Month','gym_mgt');?></option>

                                            <option value="last_3_month"><?php esc_attr_e('Last 3 Months','gym_mgt');?></option>

                                            <option value="last_6_month"><?php esc_attr_e('Last 6 Months','gym_mgt');?></option>

                                            <option value="last_12_month"><?php esc_attr_e('Last 12 Months','gym_mgt');?></option>

                                            <option value="this_year"><?php esc_attr_e('This Year','gym_mgt');?></option>

                                            <option value="last_year"><?php esc_attr_e('Last Year','gym_mgt');?></option>

                                            <option value="period"><?php esc_attr_e('Period','gym_mgt');?></option>

                                        </select>

                                </div>

            

                                <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3 input">

            

                                    

                                    <select id="member_list" class="form-control display-members" name="staff_id">

            

                                        <option value="all_staff_member"><?php  esc_html_e('All Staff Member','gym_mgt');?></option>

            

                                        <?php $get_staff = array('role' => 'Staff_member');

            

                                        $staffdata=get_users($get_staff);

            

                                        

            

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

            

                                            $staff_data="";

            

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

                                <div id="date_type_div" class="date_type_div_none row col-md-6 mb-2"></div>	

                                <div class="col-md-3 mb-2">

                                    <input type="submit" name="view_attendance" Value="<?php esc_attr_e('Go','gym_mgt');?>"  class="btn btn-info save_btn"/>

                                </div>

                            </div>

                        </div>

                    </form>  

            

                </div>

            

                <div class="panel-body padding_0 "><!--PANEL BODY DIV START-->

            

                    <?php

            

                    if(!empty($attendence_data))

            

                    { 

            

                        ?>

            

                        <script type="text/javascript">



                            $(document).ready(function() 



                            {



                                "use strict";



                                    var table = jQuery('#tblattadence_staff').DataTable({



                                    // "responsive": true,



                                    "order": [[ 2, "Desc" ]],



                                    dom: 'lifrtp',



                                    // buttons: [



                                    // 	{



                                    // 	extend: '<?php echo esc_html_e('print', 'gym_mgt'); ?>',



                                    // 	title: '<?php echo esc_html_e('Attendance Report', 'gym_mgt'); ?>',



                                    // 	},



                                    // 	'pdf',



                                    // 	'csv'				



                                    // 	], 

                                    buttons:[

                                        {

                                            extend: 'csv',

                                            text:'<?php esc_html_e('CSV', 'gym_mgt') ?>',

                                            title: '<?php esc_html_e('Attendance Report', 'gym_mgt') ?>',

                                            exportOptions: {

                                                columns: [1, 2, 3,4,5,6,7], // Only name, email and role

                                            },

                                            charset: 'UTF-8',

                                            bom: true,

                                        },

                                        {

                                            extend: 'print',	

                                            text:'<?php esc_html_e('Print', 'gym_mgt') ?>',

                                            title: '<?php esc_html_e('Attendance Report', 'gym_mgt') ?>',

                                            exportOptions: {

                                                columns: [1, 2, 3,4,5,6,7], // Only name, email and role

                                            }

                                        },

                                    ],

                                    "aoColumns":[



                                            {"bSortable": false},



                                            {"bSortable": true},



                                            {"bSortable": true},



                                            {"bSortable": true},



                                            {"bSortable": true},



                                            {"bSortable": true}



                                        ],



                                    language:<?php echo MJ_gmgt_datatable_multi_language();?>		   



                                });

                                $('.btn-place').html(table.buttons().container()); 

                                $('.dataTables_filter input').attr("placeholder", "<?php esc_html_e('Search...', 'gym_mgt') ?>");



                            } );



                        </script>

            

                        <div class="table-responsive"><!--TABLE RESPONSIVE DIV START-->

            

                        <form name="wcwm_report" action="" method="post"><!--EXPENSE LIST FORM START-->

            

                            <table id="tblattadence_staff" class="display" cellspacing="0" width="100%"><!--EXPENSE LIST TABLE START-->

                                <div class="btn-place"></div>

                                <thead class="<?php echo MJ_gmgt_datatable_heder(); ?>">

            

                                    <tr>

            

                                        <th><?php esc_html_e('Photo','gym_mgt');?></th>

            

                                        <th><?php esc_html_e('Staff Member Name','gym_mgt');?></th>

            

                                        <th><?php esc_html_e('Date','gym_mgt');?></th>

            

                                        <th><?php esc_html_e('Day','gym_mgt');?></th>

            

                                        <th><?php esc_html_e('Attendance','gym_mgt');?></th>

            

                                        <th><?php esc_html_e('Attendance By','gym_mgt');?></th>

            

                                        

            

                                    </tr>

            

                                </thead>

            

                                <tbody>

            

                                <?php

            

                                if(!empty($attendence_data))

            

                                {

            

                                    $i=0;

            

                                    foreach ($attendence_data as $retrieved_data)

            

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

            

                                                    <img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/Attendance.png"?>" alt="" class="massage_image center image_icon_height_25px margin_top_3px">

            

                                                </p>

            

                                            </td>

            

                                            <td class="name">

            

                                                <?php 

            

                                                    echo MJ_gmgt_get_user_full_display_name($retrieved_data->user_id)

            

                                                ?>

            

                                                   <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Staff Member Name','gym_mgt');?>" ></i>

            

                                            </td>

            

                                            <td class="name">

            

                                                <?php echo MJ_gmgt_getdate_in_input_box($retrieved_data->attendence_date); ?>

            

                                                <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Date','gym_mgt');?>" ></i>

            

                                            </td>

            

                                            <td class="name">

            

                                                <?php 

            

                                                    $day=date("D", strtotime($retrieved_data->attendence_date));

            

                                                    echo esc_html__($day,"gym_mgt");

            

                                                ?>

            

                                                <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Day','gym_mgt');?>" ></i>

            

                                            </td>

            

                                            <td class="name">

            

                                                <?php echo esc_html__($retrieved_data->status,"gym_mgt"); ?>

            

                                                <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Attendance Status','gym_mgt');?>" ></i>

            

                                            </td>

            

                                            <td class="name">

            

                                                <?php echo MJ_gmgt_get_user_display_name($retrieved_data->attendence_by) ?>

            

                                                <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Attendance By','gym_mgt');?>" ></i>

            

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







        }



        elseif($active_tab == 'member_status_report')



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



            $chart_array = array();



            $chart_array[] = array(esc_html__('Membership','gym_mgt'),esc_html__('Number Of Member','gym_mgt'));	



            foreach($member_ship_array as $r)



            {



                $chart_array[]=array( $r['member_ship_id'],$r['member_ship_count']);



            }



            $options = Array(



                            'title' => esc_html__('Membership by status','gym_mgt'),



                            'colors' => array('#22BAA0','#F25656','#12AFCB')



                            );



            require_once GMS_PLUGIN_DIR. '/lib/chart/GoogleCharts.class.php';



            $GoogleCharts = new GoogleCharts;



            $chart = $GoogleCharts->load( 'PieChart' , 'chart_div' )->get( $chart_array , $options );



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



            <div id="chart_div" class="chart_div"></div>



            <!-- Javascript --> 



            <script type="text/javascript" src="https://www.google.com/jsapi"></script> 



            <script type="text/javascript">



                    <?php echo $chart;?>



            </script>



            <?php



        }



        elseif($active_tab == 'payment_report')

        {



            $active_tab = isset($_GET['tab1'])?$_GET['tab1']:'report_graph';



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



            <ul class="nav nav-tabs panel_tabs margin_left_1per mb-3" role="tablist"><!-- NAV TAB WRAPPER MENU START-->



                <li class="<?php if($active_tab=='report_graph'){?>active<?php }?>">



                    <a href="?dashboard=user&page=report&tab=payment_report&tab1=report_graph" class="padding_left_0 tab <?php echo $active_tab == 'report_graph' ? 'nav-tab-active' : ''; ?>">



                    <?php echo esc_html__('Graph Report Yearly' , 'gym_mgt'); ?></a>



                </li>



                 <li class="<?php if($active_tab=='report_graph_monthly'){?>active<?php }?>">



                    <a href="?dashboard=user&page=report&tab=payment_report&tab1=report_graph_monthly" class="padding_left_0 tab <?php echo $active_tab == 'report_graph_monthly' ? 'nav-tab-active' : ''; ?>">



                    <?php echo esc_html__('Graph Report Monthly' , 'gym_mgt'); ?></a>



                </li>



                <li class="<?php if($active_tab=='data_report'){?>active<?php }?>">



                    <a href="?dashboard=user&page=report&tab=payment_report&tab1=data_report" class="padding_left_0 tab <?php echo $active_tab == 'data_report' ? 'nav-tab-active' : ''; ?>">



                    <?php echo esc_html__('Income Datatable', 'gym_mgt'); ?></a>



                </li>

                <li class="<?php if($active_tab=='data_report_1'){?>active<?php }?>">



                    <a href="?dashboard=user&page=report&tab=payment_report&tab1=data_report_1" class="padding_left_0 tab <?php echo $active_tab == 'data_report_1' ? 'nav-tab-active' : ''; ?>">



                    <?php echo esc_html__('Expense Datatable', 'gym_mgt'); ?></a>



                </li>

            </ul>



            <?php



            $obj_payment=new MJ_gmgt_payment;

            if($active_tab == 'report_graph')

            {

                ?>

                <form method="post" id="attendance_list"  class="attendance_list report">  

                    <div class="form-body user_form margin_top_15px">

                        <div class="row">

                            <div class="col-md-3 mb-3 input">

                                <label class="ml-1 custom-top-label top" for="hmgt_contry"><?php esc_html_e('Year','gym_mgt');?><span class="require-field">*</span></label>

                                <select name="year" class="line_height_30px form-control validate[required]">

                                    <!-- <option ><?php esc_attr_e('Selecte year','gym_mgt');?></option> -->

                                        <?php

                                        $current_year = date('Y');

                                        $min_year = $current_year - 10;

                                        

                                        for($i = $min_year; $i <= $current_year; $i++){

                                            $year_array[$i] = $i;

                                            $selected = ($current_year == $i ? ' selected' : '');

                                            echo '<option value="'.$i.'"'.$selected.'>'.$i.'</option>'."\n";

                                        }

                                        ?>

                                </select>       

                            </div>



                            <div class="col-md-3 mb-2">

                                <input type="submit" name="view_attendance" Value="<?php esc_attr_e('Go','gym_mgt');?>"  class="btn btn-info save_btn"/>

                            </div>

                        </div>

                    </div>

                </form>

                <?php

                $invoice_data= $obj_payment->MJ_gmgt_get_all_income_expense();



                foreach($invoice_data as $retrieved_data)

                {



                    $datetime = DateTime::createFromFormat('Y-m-d',$retrieved_data->invoice_date);

                    $year_new = $datetime->format('Y');



                    if(isset($_REQUEST['view_attendance']))

                    {

                        $year = $_REQUEST['year'];

                    }

                    else

                    {

                        $year =isset($year_new)?$year_new:date('Y');

                    }

                    // $year =isset($year_new)?$year_new:date('Y');

                }

                $current_year = Date("Y");

                $month =array('1'=>esc_html__('January','gym_mgt'),'2'=>esc_html__('February','gym_mgt'),'3'=>esc_html__('March','gym_mgt'),'4'=>esc_html__('April','gym_mgt'),'5'=>esc_html__('May','gym_mgt'),'6'=>esc_html__('June','gym_mgt'),'7'=>esc_html__('July','gym_mgt'),'8'=>esc_html__('August','gym_mgt'),'9'=>esc_html__('September','gym_mgt'),'10'=>esc_html__('October','gym_mgt'),'11'=>esc_html__('November','gym_mgt'),'12'=>esc_html__('December','gym_mgt'),);

                $result = array();

                $dataPoints_2 = array();

                array_push($dataPoints_2, array(esc_html__('Month','gym_mgt'),esc_html__('Income','gym_mgt'),esc_html__('Expense','gym_mgt')));

                $dataPoints_1 = array();

                $expense_array = array();

                $currency_symbol = MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ));

                foreach($month as $key=>$value)

                {

                    

                    global $wpdb;

                    $table_name = $wpdb->prefix."gmgt_income_expense";



                    $q = "SELECT SUM(total_amount) as amount FROM $table_name WHERE YEAR(invoice_date) = $year AND MONTH(invoice_date) = $key and invoice_type='income'";



                    $q1 = "SELECT * FROM $table_name WHERE YEAR(invoice_date) = $year AND MONTH(invoice_date) = $key and invoice_type='expense'";



                    $result=$wpdb->get_results($q);

                    $result1=$wpdb->get_results($q1);

                    $expense_yearly_amount = 0;

                    foreach($result1 as $expense_entry)

                    {

                    

                    $all_entry=json_decode($expense_entry->entry);

                    $amount=0;

                    foreach($all_entry as $entry)

                    {

                        $amount+=$entry->amount;

                    }



                    $expense_yearly_amount += $amount;

                    

                    }

                    if($expense_yearly_amount == 0)

                    {

                        $expense_amount = null;

                    }

                    else

                    {

                        $expense_amount = "$expense_yearly_amount";

                    }

                    $expense_array[] = $expense_amount;

                    $income_amount = "SELECT SUM(total_amount) as amount FROM $table_name WHERE YEAR(invoice_date) = $year";

                    $result_income=$wpdb->get_results($income_amount);



                    array_push($dataPoints_2, array($value,$result[0]->amount,$expense_amount));

                    

                }



                $new_array = json_encode($dataPoints_2);



                if(!empty($result_income))

                {

                    $new_currency_symbol = html_entity_decode($currency_symbol);

                

                    ?>

                    

                    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

                    <script type="text/javascript">

                        google.charts.load('current', {'packages':['bar']});

                        google.charts.setOnLoadCallback(drawChart);



                        function drawChart() {

                            var data = google.visualization.arrayToDataTable(<?php echo $new_array; ?>);



                            var options = {

                            

                                bars: 'vertical', // Required for Material Bar Charts.

                                colors: ['#104B73', '#FF9054'],

                                

                            };

                        

                            var chart = new google.charts.Bar(document.getElementById('barchart_material'));



                            chart.draw(data, google.charts.Bar.convertOptions(options));

                        }

                    </script>

                    <div id="barchart_material" style="width:100%;height: 430px; padding:20px;"></div>

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

            if($active_tab == 'report_graph_monthly')

            {

                ?>

                <form method="post" id="attendance_list"  class="attendance_list report">  

                    <div class="form-body user_form margin_top_15px">

                        <div class="row">

                            <div class="col-md-3 mb-3 input">

                                <label class="ml-1 custom-top-label top" for="hmgt_contry"><?php esc_html_e('Months','gym_mgt');?><span class="require-field">*</span></label>

                                <select id="month" name="month" class="line_height_30px form-control class_id_exam validate[required]">

                                    <!-- <option ><?php esc_attr_e('Selecte Month','school-mgt');?></option> -->

                                    <?php

                                    $month =array('1'=>esc_html__('January','gym_mgt'),'2'=>esc_html__('February','gym_mgt'),'3'=>esc_html__('March','gym_mgt'),'4'=>esc_html__('April','gym_mgt'),'5'=>esc_html__('May','gym_mgt'),'6'=>esc_html__('June','gym_mgt'),'7'=>esc_html__('July','gym_mgt'),'8'=>esc_html__('August','gym_mgt'),'9'=>esc_html__('September','gym_mgt'),'10'=>esc_html__('October','gym_mgt'),'11'=>esc_html__('November','gym_mgt'),'12'=>esc_html__('December','gym_mgt'),);

                                    foreach($month as $key=>$value)

                                    {

                                        $selected = (date('m') == $key ? ' selected' : '');

                                        echo '<option value="'.$key.'"'.$selected.'>'. $value.'</option>'."\n";

                                    }

                                        ?>

                                </select>       

                            </div>

            

                            <div class="col-md-3 mb-2">

                                <input type="submit" name="view_attendance" Value="<?php esc_attr_e('Go','gym_mgt');?>"  class="btn btn-info save_btn"/>

                            </div>

                        </div>

                    </div>

                </form>

                <?php

            

                

                $invoice_data= $obj_payment->MJ_gmgt_get_all_income_expense();

            

                foreach($invoice_data as $retrieved_data)

                {

            

                    $datetime = DateTime::createFromFormat('Y-m-d',$retrieved_data->invoice_date);

                    $year_new = $datetime->format('Y');

                    $year =isset($year_new)?$year_new:date('Y');

                }

                

                $current_year = Date("Y");

                $day =array('1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31');

                // $day =array('1'=>esc_html__('Jan','gym_mgt'),'2'=>esc_html__('Feb','gym_mgt'),'3'=>esc_html__('Mar','gym_mgt'),'4'=>esc_html__('Apr','gym_mgt'),'5'=>esc_html__('May','gym_mgt'),'6'=>esc_html__('Jun','gym_mgt'),'7'=>esc_html__('Jul','gym_mgt'),'8'=>esc_html__('Aug','gym_mgt'),'9'=>esc_html__('Sep','gym_mgt'),'10'=>esc_html__('Oct','gym_mgt'),'11'=>esc_html__('Nov','gym_mgt'),'12'=>esc_html__('Dec','gym_mgt'),);

                $result = array();

                $dataPoints_2 = array();

                array_push($dataPoints_2, array(esc_html__('Month','gym_mgt'),esc_html__('Income','gym_mgt'),esc_html__('Expense','gym_mgt')));

                $dataPoints_1 = array();

                $expense_array = array();

                $currency_symbol = MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ));

            

                if(isset($_REQUEST['view_attendance']))

                {

                    $month = $_REQUEST['month'];

                }

                else

                {

                    $month =Date('m');

                }

                foreach($day as $value)

                {

                    

                    

                    global $wpdb;	

                    $table_name = $wpdb->prefix."gmgt_income_expense";

            

                    $q = "SELECT SUM(total_amount) as amount FROM $table_name WHERE YEAR(invoice_date) = $current_year  AND MONTH(invoice_date) = $month  AND DAY(invoice_date) = $value and invoice_type='income'";

                    // $q = "SELECT SUM(total_amount) as amount FROM $table_name WHERE YEAR(invoice_date) = $year AND MONTH(invoice_date) = $value and invoice_type='income'";

            

                    $q1 = "SELECT * FROM $table_name WHERE YEAR(invoice_date) = $current_year AND MONTH(invoice_date) = $month  AND DAY(invoice_date) = $value and invoice_type='expense'";

            

                    $result=$wpdb->get_results($q);

                    $result1=$wpdb->get_results($q1);

                    $expense_yearly_amount = 0;

                    foreach($result1 as $expense_entry)

                    {

                    

                        $all_entry=json_decode($expense_entry->entry);

                        $amount=0;

                        foreach($all_entry as $entry)

                        {

                            $amount+=$entry->amount;

                        }

            

                        $expense_yearly_amount += $amount;

                    

                    }

                    if($expense_yearly_amount == 0)

                    {

                        $expense_amount = null;

                    }

                    else

                    {

                        $expense_amount = "$expense_yearly_amount";

                    }

                    $expense_array[] = $expense_amount;

                    $income_amount = "SELECT SUM(total_amount) as amount FROM $table_name WHERE YEAR(invoice_date) = $year";

                    $result_income=$wpdb->get_results($income_amount);

                    

                    array_push($dataPoints_2, array($value,$result[0]->amount,$expense_amount));

                    

                }

            

                $new_array = json_encode($dataPoints_2);

                

                if(!empty($result_income))

                {

                    $new_currency_symbol = html_entity_decode($currency_symbol);

                

                    ?>

                    

                    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

                    <script type="text/javascript">

                        google.charts.load('current', {'packages':['bar']});

                        google.charts.setOnLoadCallback(drawChart);

            

                        function drawChart() {

                            var data = google.visualization.arrayToDataTable(<?php echo $new_array; ?>);

            

                            var options = {

                            

                                bars: 'vertical', // Required for Material Bar Charts.

                                colors: ['#104B73', '#FF9054'],

                                

                            };

                        

                            var chart = new google.charts.Bar(document.getElementById('barchart_material'));

            

                            chart.draw(data, google.charts.Bar.convertOptions(options));

                        }

                    </script>

                    <div id="barchart_material" style="width:100%;height: 430px; padding:20px;"></div>

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

            if($active_tab == 'data_report')

            {

            

                if(isset($_REQUEST['view_attendance']))

                {

                    $date_type = $_POST['date_type'];

            

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

            

                    $start_date = date('Y-m-d',strtotime('first day of this month'));

            

                    $end_date = date('Y-m-d',strtotime('last day of this month'));

            

                }

            

                $result_merge_array=MJ_gmgt_get_all_income_report_beetween_satrt_date_to_enddate($start_date,$end_date);

            

                ?>

            

                <div class="panel-body padding_0 mt-3">

            

                    <form method="post" id="attendance_list" class="attendance_list report">  

                        <div class="form-body user_form margin_top_15px">

                            <div class="row">

                                <div class="col-md-3 mb-3 input">

                                    <label class="ml-1 custom-top-label top" for="class_id"><?php esc_attr_e('Date','gym_mgt');?><span class="require-field">*</span></label>			

                                        <select class="line_height_30px form-control date_type validate[required]" name="date_type" autocomplete="off">

                                            <!-- <option value=""><?php esc_attr_e('Select','gym_mgt');?></option> -->

                                            <option value="today"><?php esc_attr_e('Today','gym_mgt');?></option>

                                            <option value="this_week"><?php esc_attr_e('This Week','gym_mgt');?></option>

                                            <option value="last_week"><?php esc_attr_e('Last Week','gym_mgt');?></option>

                                            <option value="this_month" 	selected><?php esc_attr_e('This Month','gym_mgt');?></option>

                                            <option value="last_month"><?php esc_attr_e('Last Month','gym_mgt');?></option>

                                            <option value="last_3_month"><?php esc_attr_e('Last 3 Months','gym_mgt');?></option>

                                            <option value="last_6_month"><?php esc_attr_e('Last 6 Months','gym_mgt');?></option>

                                            <option value="last_12_month"><?php esc_attr_e('Last 12 Months','gym_mgt');?></option>

                                            <option value="this_year"><?php esc_attr_e('This Year','gym_mgt');?></option>

                                            <option value="last_year"><?php esc_attr_e('Last Year','gym_mgt');?></option>

                                            <option value="period"><?php esc_attr_e('Period','gym_mgt');?></option>

                                        </select>

                                </div>

            

                                <div id="date_type_div" class="date_type_div_none row col-md-6 mb-2"></div>

            

                                <div class="col-md-3 mb-2">

                                    <input type="submit" name="view_attendance" Value="<?php esc_attr_e('Go','gym_mgt');?>"  class="btn btn-info save_btn"/>

                                </div>

                            </div>

                        </div>

                    </form>

            

                </div>

            

                <div class="panel-body padding_0 "><!--PANEL BODY DIV START-->

            

                    <?php

            

                    if(!empty($result_merge_array))

            

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

            

                                    //   buttons: [

            

                                    //     {

            

                                    // 	extend: '<?php echo esc_html_e('print', 'gym_mgt'); ?>',

            

                                    //     title: '<?php echo esc_html_e('Income List', 'gym_mgt'); ?>',

            

                                    //     },

            

                                    // 	'pdf',

            

                                    //     'csv'				

            

                                    // 	], 

            

                                    "aoColumns":[

            

                                            {"bSortable": false},

            

                                            {"bSortable": true},

            

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

            

                                            <th><?php esc_html_e('Member Name','gym_mgt');?></th>

            

                                            <th><?php esc_html_e('Amount','gym_mgt');?></th>

            

                                            <th><?php esc_html_e('Date','gym_mgt');?></th>

            

                                            <th><?php esc_html_e('Payment Description','gym_mgt');?></th>

            

                                            

            

                                        </tr>

            

                                    </thead>

                                    <tbody>

            

                                    <?php 

            

                                        if(!empty($result_merge_array))

            

                                        {

            

                                            $i=0;

            

                                            foreach ($result_merge_array as $retrieved_data)

            

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

            

                                                            <img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/Attendance.png"?>" alt="" class="massage_image center image_icon_height_25px margin_top_3px">

            

                                                        </p>

            

                                                    </td>

            

                                                    <td class="party_name">

            

                                                        <?php

            

                                                        $user=get_userdata($retrieved_data->member_id);

            

                                                        $memberid=get_user_meta($retrieved_data->member_id,'member_id',true);

            

                                                        $display_label = MJ_gmgt_get_member_full_display_name_with_memberid(esc_html($retrieved_data->member_id));



                                                        if($display_label)

                                                        {

                                                            echo esc_html($display_label);

                                                        }

                                                        else {

                                                            echo "N/A";

                                                        }

            

            

                                                        ?>

            

                                                        <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Member Name','gym_mgt');?>" ></i>

            

                                                    </td>

            

                                                    <td class="income_amount">

            

                                                        <?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?> <?php echo number_format(esc_html($retrieved_data->amount),2);?>

            

                                                        <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Amount','gym_mgt');?>" ></i>

            

                                                    </td>

            

                                                    <td class="status">

            

                                                        <?php

            

                                                        if(!empty($retrieved_data->paid_by_date))

            

                                                        {

            

                                                            echo MJ_gmgt_getdate_in_input_box(esc_html($retrieved_data->paid_by_date));

            

                                                        }

            

                                                        else {

            

                                                            echo "N/A";

            

                                                        }

            

                                                        ?>

            

                                                        <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Date','gym_mgt');?>" ></i>

            

                                                    </td>

            

                                                    <td class="party_name">

            

                                                        <?php

            

                                                        if(!empty($retrieved_data->payment_description))	

            

                                                        {

            

                                                            echo esc_html($retrieved_data->payment_description);

            

                                                        }

            

                                                        else 

            

                                                        {

            

                                                            echo "N/A";

            

                                                        }

            

                                                        ?>

            

                                                        <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Payment Description','gym_mgt');?>" ></i>

            

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

            

                    } ?>

            

                </div><!--PANEL BODY DIV END-->

            

                <?php    

            

            }



            if($active_tab == 'data_report_1')

            {

            

                if(isset($_REQUEST['view_attendance']))

                {

                    $date_type = $_POST['date_type'];

            

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

            

                    $start_date = date('Y-m-d',strtotime('first day of this month'));

            

                    $end_date = date('Y-m-d',strtotime('last day of this month'));

            

                }

            

                $expense_report_data=MJ_gmgt_get_all_expense_report_beetween_satrt_date_to_enddate($start_date,$end_date);

            

                $obj_payment= new MJ_gmgt_payment();

            

                ?>

            

                <div class="panel-body padding_0 mt-3">

            

                    <form method="post" id="attendance_list" class="attendance_list report">  

                        <div class="form-body user_form margin_top_15px">

                            <div class="row">

                                <div class="col-md-3 mb-3 input">

                                    <label class="ml-1 custom-top-label top" for="class_id"><?php esc_attr_e('Date','gym_mgt');?><span class="require-field">*</span></label>			

                                        <select class="line_height_30px form-control date_type validate[required]" name="date_type" autocomplete="off">

                                            <!-- <option value=""><?php esc_attr_e('Select','gym_mgt');?></option> -->

                                            <option value="today"><?php esc_attr_e('Today','gym_mgt');?></option>

                                            <option value="this_week"><?php esc_attr_e('This Week','gym_mgt');?></option>

                                            <option value="last_week"><?php esc_attr_e('Last Week','gym_mgt');?></option>

                                            <option value="this_month" 	selected><?php esc_attr_e('This Month','gym_mgt');?></option>

                                            <option value="last_month"><?php esc_attr_e('Last Month','gym_mgt');?></option>

                                            <option value="last_3_month"><?php esc_attr_e('Last 3 Months','gym_mgt');?></option>

                                            <option value="last_6_month"><?php esc_attr_e('Last 6 Months','gym_mgt');?></option>

                                            <option value="last_12_month"><?php esc_attr_e('Last 12 Months','gym_mgt');?></option>

                                            <option value="this_year"><?php esc_attr_e('This Year','gym_mgt');?></option>

                                            <option value="last_year"><?php esc_attr_e('Last Year','gym_mgt');?></option>

                                            <option value="period"><?php esc_attr_e('Period','gym_mgt');?></option>

                                        </select>

                                </div>

            

                                <div id="date_type_div" class="date_type_div_none row col-md-6 mb-2"></div>

            

                                <div class="col-md-3 mb-2">

                                    <input type="submit" name="view_attendance" Value="<?php esc_attr_e('Go','gym_mgt');?>"  class="btn btn-info save_btn"/>

                                </div>

                            </div>

                        </div>

                    </form>

            

                </div>

            

                

            

                <div class="panel-body padding_0 "><!--PANEL BODY DIV START-->

            

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

        }



        elseif($active_tab == 'expense_report')



        {



            $active_tab = isset($_GET['tab1'])?$_GET['tab1']:'report_graph';



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



            <ul class="nav nav-tabs panel_tabs margin_left_1per mb-3" role="tablist"><!-- NAV TAB WRAPPER MENU START-->



                <li class="<?php if($active_tab=='report_graph'){?>active<?php }?>">



                    <a href="?dashboard=user&page=report&tab=expense_report&tab1=report_graph" class="padding_left_0 tab <?php echo $active_tab == 'report_graph' ? 'nav-tab-active' : ''; ?>">



                    <?php echo esc_html__('Expense Report Graph', 'gym_mgt'); ?></a>



                </li>



                <li class="<?php if($active_tab=='data_report'){?>active<?php }?>">



                    <a href="?dashboard=user&page=report&tab=expense_report&tab1=data_report" class="padding_left_0 tab <?php echo $active_tab == 'data_report' ? 'nav-tab-active' : ''; ?>">



                    <?php echo esc_html__('Expense Report Datatable', 'gym_mgt'); ?></a>



                </li>



            </ul>



            <?php



            if($active_tab == 'report_graph')



            { 	



                $month =array('1'=>esc_html__('January','gym_mgt'),'2'=>esc_html__('February','gym_mgt'),'3'=>esc_html__('March','gym_mgt'),'4'=>esc_html__('April','gym_mgt'),'5'=>esc_html__('May','gym_mgt'),'6'=>esc_html__('June','gym_mgt'),'7'=>esc_html__('July','gym_mgt'),'8'=>esc_html__('August','gym_mgt'),'9'=>esc_html__('September','gym_mgt'),'10'=>esc_html__('October','gym_mgt'),'11'=>esc_html__('November','gym_mgt'),'12'=>esc_html__('December','gym_mgt'),);	



                $year =isset($_POST['year'])?$_POST['year']:date('Y');











                global $wpdb;



                $table_name = $wpdb->prefix."gmgt_income_expense";



                $report_6 = $wpdb->get_results("SELECT * FROM $table_name where invoice_type='expense'");







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



                foreach($sumArray as $month_value=>$count)



                {



                    $chart_array[]=array( $month[$month_value],(int)$count);



                }



                $options = Array(



                            'title' => esc_html__('Expense Payment Report By Month','gym_mgt'),



                            'titleTextStyle' => Array('color' => '#66707e'),



                            'legend' =>Array('position' => 'right',



                            'textStyle'=> Array('color' => '#66707e')),



                            'hAxis' => Array(



                                'title' => esc_html__('Month','gym_mgt'),



                                'format' => '#',



                                'titleTextStyle' => Array('color' => '#66707e','fontSize' => 16,'bold'=>true,'italic'=>false,'fontName' =>'poppins'),



                                'textStyle'=> Array('color' => '#66707e','fontSize' => 16,'bold'=>true,'italic'=>false,'fontName' =>'poppins'),



                                'maxAlternation' => 2



                                ),



                            'vAxis' => Array(



                                'title' => esc_html__('Expense Payment','gym_mgt'),



                                'minValue' => 0,



                                'maxValue' => 6,



                                'format' => '#',



                                'titleTextStyle' => Array('color' => '#66707e','fontSize' => 16,'bold'=>true,'italic'=>false,'fontName' =>'poppins'),



                                'textStyle'=> Array('color' => '#66707e','fontSize' => 16,'bold'=>true,'italic'=>false,'fontName' =>'poppins')



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



                    {



                        ?>



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



                <script type="text/javascript">



                $(document).ready(function() 



                {



                    "use strict";



                    jQuery('#tblexpence').DataTable({



                        // "responsive": true,



                        "order": [[ 1, "Desc" ]],



                        dom: 'lifrtp',



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



                



                <div class="panel-body padding_0">



                    <form method="post"> 



                        <div class="form-body user_form">



                            <div class="row"> 



                                <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5 ipad_res">



                                    <div class="form-group input">



                                        <div class="col-md-12 form-control">



                                            <input type="text"  class="form-control sdate1" name="sdate" value="<?php if(isset($_REQUEST['sdate'])) echo esc_attr($_REQUEST['sdate']);else echo esc_attr(MJ_gmgt_getdate_in_input_box(date('Y-m-d')));?>" readonly>



                                            <label for="exam_id"><?php esc_html_e('Start Date','gym_mgt');?></label>	



                                        </div>



                                    </div>



                                </div>



                                <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5 ">



                                    <div class="form-group input">



                                        <div class="col-md-12 form-control">



                                            <input type="text"  class="form-control edate1"  name="edate" value="<?php if(isset($_REQUEST['edate'])) echo esc_attr($_REQUEST['edate']);else echo esc_attr(MJ_gmgt_getdate_in_input_box(date('Y-m-d')));?>" readonly>



                                            <label for="exam_id"><?php esc_html_e('End Date','gym_mgt');?></label>



                                        </div>



                                    </div>



                                </div>



                                <div class="col-md-2 col-sm-2 col-xs-2"><!--save btn--> 



                                    <input type="submit" name="expense_report_datatable" Value="<?php esc_html_e('Go','gym_mgt');?>"  class="btn save_btn"/>



                                </div>



                            </div><!--Row Div End--> 



                        </div><!-- user_form End-->  



                    </form>



                </div>



                <?php



                if(!empty($expense_report_data))



                {



                    ?>



                    <div class="panel-body"><!--PANEL BODY DIV START-->



                        <div class="table-responsive"><!--TABLE RESPONSIVE DIV START-->



                            <form name="wcwm_report" action="" method="post"><!--EXPENSE LIST FORM START-->



                                <table id="tblexpence" class="display" cellspacing="0" width="100%"><!--EXPENSE LIST TABLE START-->

                                    <thead class="<?php echo MJ_gmgt_datatable_heder(); ?>">

                                        <tr>



                                            <th><?php  esc_html_e( 'Photo', 'gym_mgt' ) ;?></th>



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



                                            $all_entry=json_decode($retrieved_data->entry);



                                            $total_amount=0;



                                            foreach($all_entry as $entry)



                                            {



                                                $total_amount+=$entry->amount;



                                            }



                                            ?>



                                            <tr>



                                                <td class="user_image width_50px profile_image_prescription padding_left_0">	



                                                    <p class="prescription_tag padding_15px margin_bottom_0px <?php echo $color_class; ?>">	



                                                        <img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/Payment.png"?>" alt="" class="massage_image center image_icon_height_25px margin_top_3px">



                                                    </p>



                                                </td>



                                                <td class="party_name"><?php echo esc_html($retrieved_data->supplier_name);?>	<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Supplier Name','gym_mgt');?>" ></i></td>



                                                <td class="income_amount"><?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?> <?php echo number_format(esc_html($total_amount),2);?>	<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Total Amount','gym_mgt');?>" ></i></td>



                                                <td class="status"><?php echo MJ_gmgt_getdate_in_input_box(esc_html($retrieved_data->invoice_date));?>	<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Date','gym_mgt');?>" ></i></td>



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



                    </div><!--PANEL BODY DIV END-->



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



        elseif($active_tab == 'feepayment_report')



        {



            $active_tab = isset($_GET['tab1'])?$_GET['tab1']:'report_graph';



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



             <ul class="nav nav-tabs panel_tabs margin_left_1per mb-3" role="tablist"><!-- NAV TAB WRAPPER MENU START-->



                <li class="<?php if($active_tab=='report_graph'){?>active<?php }?>">



                    <a href="?dashboard=user&page=report&tab=feepayment_report&tab1=report_graph" class="padding_left_0 tab <?php echo $active_tab == 'report_graph' ? 'nav-tab-active' : ''; ?>">



                    <?php echo esc_html__('Membership Payment Graph', 'gym_mgt'); ?></a>



                </li>



                <li class="<?php if($active_tab=='data_report'){?>active<?php }?>">



                    <a href="?dashboard=user&page=report&tab=feepayment_report&tab1=data_report" class="padding_left_0 tab <?php echo $active_tab == 'data_report' ? 'nav-tab-active' : ''; ?>">



                    <?php echo esc_html__('Membership Payment Datatable', 'gym_mgt'); ?></a>



                </li>



            </ul>



            <?php



            if($active_tab == 'report_graph')

            {  



                $month =array('1'=>esc_html__('January','gym_mgt'),'2'=>esc_html__('February','gym_mgt'),'3'=>esc_html__('March','gym_mgt'),'4'=>esc_html__('April','gym_mgt'),'5'=>esc_html__('May','gym_mgt'),'6'=>esc_html__('June','gym_mgt'),'7'=>esc_html__('July','gym_mgt'),'8'=>esc_html__('August','gym_mgt'),'9'=>esc_html__('September','gym_mgt'),'10'=>esc_html__('October','gym_mgt'),'11'=>esc_html__('November','gym_mgt'),'12'=>esc_html__('December','gym_mgt'),);



                $year =isset($_POST['year'])?$_POST['year']:date('Y');



                global $wpdb;



                $table_name = $wpdb->prefix."gmgt_membership_payment_history";



                $q="SELECT EXTRACT(MONTH FROM paid_by_date) as date,sum(amount) as count FROM ".$table_name." WHERE YEAR(paid_by_date) =".$year." group by month(paid_by_date) ORDER BY paid_by_date ASC";



                $result=$wpdb->get_results($q);



                $chart_array = array();



                // $chart_array[] = array(esc_html__('Month','gym_mgt'),esc_html__('Fee Payment','gym_mgt'));



                array_push($chart_array, array(esc_html__('Month','gym_mgt'),esc_html__('Membership Payment','gym_mgt')));



                foreach($result as $r)



                {

                    // $chart_array[]=array( $month[$r->date],(int)$r->count);

                    

                    array_push($chart_array, array($month[$r->date],(int)$r->count));



                }



                $new_array = json_encode($chart_array);



                if(!empty($r->count))

                {

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

                                title: '<?php _e('Membership Payment Report','gym_mgt');?>',

                                fontName:'sans-serif',

                                titleTextStyle: 

                                {

                                    color: '#66707e'

                                },

                                

                            };

                        

                            var chart = new google.charts.Bar(document.getElementById('barchart_material'));



                            chart.draw(data, google.charts.Bar.convertOptions(options));

                        }

                    </script>

                    <div id="barchart_material" style="width:100%;height: 430px; padding:20px;"></div>

                    <?php

                }else{

                    ?>

                    <div class="calendar-event-new"> 



                        <img class="no_data_img" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/no_data_img.png"?>" >



                    </div>

                <?php

                }



            }



            if($active_tab == 'data_report')

            {



            

                if(isset($_REQUEST['view_attendance']))

                {

                    $date_type = $_POST['date_type'];

                    

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

                    $start_date = date('Y-m-d',strtotime('first day of this month'));



                    $end_date = date('Y-m-d',strtotime('last day of this month'));

                }



                $feespayment_report_data=MJ_gmgt_get_all_feespayment_report_beetween_start_date_to_enddate($start_date,$end_date);	



                ?>



                <div class="panel-body padding_0 mt-3">



                    <form method="post" id="attendance_list"  class="attendance_list report">  

                        <div class="form-body user_form margin_top_15px">

                            <div class="row">

                                <div class="col-md-3 mb-3 input">

                                    <label class="ml-1 custom-top-label top" for="class_id"><?php esc_attr_e('Date','gym_mgt');?><span class="require-field">*</span></label>			

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



                                <div id="date_type_div" class="date_type_div_none row col-md-6 mb-2" ></div>	



                                <div class="col-md-3 mb-2">

                                    <input type="submit" name="view_attendance" Value="<?php esc_attr_e('Go','gym_mgt');?>"  class="btn btn-info save_btn"/>

                                </div>

                            </div>

                        </div>

                    </form>



                </div>



                <div class="panel-body padding_0 "><!--PANEL BODY DIV START-->



                    <?php 



                    if(!empty($feespayment_report_data))



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



                                    // 	title: '<?php echo esc_html_e('Fees payment List', 'gym_mgt'); ?>',



                                    // 	},



                                    // 	'pdf',



                                    // 	'csv'				



                                    // 	], 



                                    "aoColumns":[



                                            {"bSortable": false},



                                            {"bSortable": true},



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



                                            <th><?php esc_html_e('Membership Name','gym_mgt');?></th>



                                            <th><?php esc_html_e('Amount','gym_mgt');?></th>



                                            <th><?php esc_html_e('Date','gym_mgt');?></th>



                                            <th><?php esc_html_e('Payment Method','gym_mgt');?></th>



                                        </tr>



                                    </thead>



                                    <tbody>



                                        <?php 



                                        if(!empty($feespayment_report_data))



                                        {



                                            $i=0;



                                            foreach ($feespayment_report_data as $retrieved_data)



                                            { 



                                                $membership_id = MJ_gmgt_membership_id($retrieved_data->mp_id);







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



                                                        <?php



                                                        if(!empty($membership_id))



                                                        {



                                                            echo MJ_gmgt_get_membership_name($membership_id);



                                                        }



                                                        else 



                                                        {



                                                            



                                                            echo "N/A";



                                                        }



                                                        ?>



                                                        <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Membership Name','gym_mgt');?>" ></i>



                                                    </td>



                                                    <td class="income_amount">



                                                        <?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?> 



                                                        <?php 



                                                            if(!empty($retrieved_data->amount))



                                                            {



                                                                echo number_format(esc_html($retrieved_data->amount),2);



                                                            }



                                                            else {



                                                                echo "N/A";



                                                            }



                                                        ?>



                                                        <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Amount','gym_mgt');?>" ></i>



                                                    </td>



                                                    <td class="status">



                                                        <?php



                                                        if(!empty($retrieved_data->paid_by_date))



                                                        {



                                                            echo MJ_gmgt_getdate_in_input_box(esc_html($retrieved_data->paid_by_date));



                                                        }



                                                        else {



                                                            echo "N/A";



                                                        }



                                                        ?>



                                                        <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Date','gym_mgt');?>" ></i>



                                                    </td>



                                                    <td class="party_name">



                                                        <?php



                                                        if(!empty($retrieved_data->payment_method))	



                                                        {



                                                            echo esc_html__($retrieved_data->payment_method,"gym_mgt");



                                                        }



                                                        else {



                                                            echo "N/A";



                                                        }



                                                        ?>



                                                        <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Payment Method','gym_mgt');?>" ></i>



                                                    </td>



                                                </tr>



                                                <?php



                                                $i++;



                                            }



                                        } ?>



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



        }

        elseif($active_tab == 'user_log')

        {

            ?>

            <div class=" clearfix  padding_top_15px_res"> <!------  penal body  -------->

           

                <form method="post" id="attendance_list" class="attendance_list report">  

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

                                        title: '<?php esc_html_e('User Log Report', 'gym_mgt') ?>',

                                    },

                                    {

                                        extend: 'print',

                                        text:'<?php esc_html_e('Print', 'gym_mgt') ?>',

                                        title: '<?php esc_html_e('User Log Report', 'gym_mgt') ?>',

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

            <?php

        }

        elseif($active_tab == 'audit_trail')

        {

            ?>

            <div class=" clearfix  padding_top_15px_res"> <!------  penal body  -------->

 

                <form method="post" id="attendance_list" class="attendance_list report">  

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

                                <select class="line_height_30px form-control" name="date_action" autocomplete="off">

                                    <option value="all"><?php esc_attr_e('All Action','gym_mgt');?></option>

                                    <option value="edit"><?php esc_attr_e('Edit Action','gym_mgt');?></option>	

                                    <option value="insert"><?php esc_attr_e('Insert Action','gym_mgt');?></option>	

                                    <option value="delete"><?php esc_attr_e('Delete Action','gym_mgt');?></option>	

                                </select>

                            </div>

                            <div id="date_type_div" class="date_type_div_none row col-md-6 mb-2"></div>	

                            <div class="col-md-3 mb-2">

                                <input type="submit" name="audit_report" Value="<?php esc_attr_e('Go','gym_mgt');?>"  class="btn btn-info save_btn"/>

                            </div>

                        </div>

                    </div>

                </form>



                <?php

                if(isset($_REQUEST['audit_report']))

                {

                    $date_type = $_POST['date_type'];

                    $date_action = $_POST['date_action'];

                

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

                    $date_action = "all";

                    $start_date = date('Y-m-d');

                    $end_date= date('Y-m-d');

                }



                if($date_action == "all" || $date_action == "")

                {

                    global $wpdb;

                    $table_audit_log=$wpdb->prefix.'gmgt_audit_log';

                    $report_6 = $wpdb->get_results("SELECT * FROM $table_audit_log where created_at BETWEEN '$start_date' AND '$end_date'");

                }

                else

                {

                    global $wpdb;

                    $table_audit_log=$wpdb->prefix.'gmgt_audit_log';

                    $report_6 = $wpdb->get_results("SELECT * FROM $table_audit_log where action='$date_action' AND created_at BETWEEN '$start_date' AND '$end_date'");

                }



                if(isset($_REQUEST['delete_selected_audit_log']))

                {		

                    if(!empty($_REQUEST['id']))

                    foreach($_REQUEST['id'] as $id)

                    {

                            $result = mj_gmgt_delete_audit_log($id);

                    }

                

                    if($result)

                    { 

                        ?>

                        <div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible">

                            <p><?php esc_attr_e('Record Deleted Successfully.','gym_mgt'); ?></p>

                            <button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span class="screen-reader-text"><?php esc_html_e( 'Dismiss this notice.', 'gym_mgt' ); ?></span></button>

                        </div>

                        <?php 

                    }

                }





                if(!empty($report_6))

                {

                    ?>

                    <script type="text/javascript">

                        jQuery(document).ready(function($){

                            var table = jQuery('#tble_audit_log_').DataTable({

                                "responsive": true,

                                "order": [[ 2, "Desc" ]],

                                "dom": 'lifrtp',

                                buttons:[

                                    {

                                        extend: 'csv',

                                        text:'<?php esc_html_e('CSV', 'gym_mgt') ?>',

                                        title: '<?php esc_html_e('Audit Trail Report', 'gym_mgt') ?>',

                                    },

                                    {

                                        extend: 'print',

                                        text:'<?php esc_html_e('Print', 'gym_mgt') ?>',

                                        title: '<?php esc_html_e('Audit Trail Report', 'gym_mgt') ?>',

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



                            $("#delete_selected").on('click', function()

                                {	

                                    if ($('.select-checkbox:checked').length == 0 )

                                    {

                                        alert(language_translate2.one_record_select_alert);

                                        return false;

                                    }

                                    else

                                    {

                                            var alert_msg=confirm("<?php esc_html_e('Are you sure you want to delete this record?', 'gym_mgt') ?>");

                                            if(alert_msg == false)

                                            {

                                                return false;

                                            }

                                            else

                                            {

                                                return true;

                                            }

                                    }

                                });

                                $('.select_all').on('click', function(e)

                                {

                                    if($(this).is(':checked',true))  

                                    {

                                        $(".gmgt_sub_chk").prop('checked', true);  

                                    }  

                                    else  

                                    {  

                                        $(".gmgt_sub_chk").prop('checked',false);  

                                    } 

                                });

                                $('.gmgt_sub_chk').on('change',function()

                                { 

                                    if(false == $(this).prop("checked"))

                                    { 

                                        $(".select_all").prop('checked', false); 

                                    }

                                    if ($('.gmgt_sub_chk:checked').length == $('.gmgt_sub_chk').length )

                                    {

                                        $(".select_all").prop('checked', true);

                                    }

                                });

                                jQuery('#checkbox-select-all').on('click', function(){     

                                    var rows = table.rows({ 'search': 'applied' }).nodes();

                                    jQuery('input[type="checkbox"]', rows).prop('checked', this.checked);

                                }); 

                        });

                    </script>

                    <div class="panel-body padding_top_15px_res"> <!------  penal body  -------->

                        <div class="table-responsive"> <!------  table Responsive  -------->

                            <div class="btn-place"></div>

                            <form id="frm-example" name="frm-example" method="post">

                                <table id="tble_audit_log_" class="display" cellspacing="0" width="100%">

                                    <thead class="<?php echo MJ_gmgt_datatable_heder() ?>">

                                        <tr>

                                            <th class="padding_0"><input type="checkbox" class=" multiple_select select_all" id="select_all"></th>

                                            <th> <?php esc_attr_e( 'Message', 'gym_mgt' ) ;?></th>

                                            <th> <?php esc_attr_e( 'IP Address', 'gym_mgt' ) ;?></th>

                                            <th> <?php esc_attr_e( 'Date & Time', 'gym_mgt' ) ;?></th>

                                        </tr>

                                    </thead>

                                    <tbody>

                                        <?php 

                                        foreach($report_6 as $result)

                                        {	

                                            // var_dump($result);

                                            ?>

                                            <tr>

                                                <td class="checkbox_width_10px"><input type="checkbox" class="gmgt_sub_chk select-checkbox" name="id[]" value="<?php echo $result->id;?>"></td>

                                                <td class="patient"><?php if(!empty($result->audit_action)){ echo $result->audit_action.' by '.mj_gmgt_get_display_name($result->created_by); }else{ echo "N/A"; } ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Message','gym_mgt');?>"></i></td>

                                                <!-- <td class="patient_name"><?php if(!empty($result->user_id)){ echo mj_gmgt_get_display_name($result->user_id); }else{ echo "N/A"; } ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('User Name','gym_mgt');?>"></i></td> -->

                                                <td class="income_amount"><?php if(!empty($result->ip_address)){ echo $result->ip_address; }else{ echo "N/A"; } ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('IP Address','gym_mgt');?>"></i></td>

                                                <!-- <td class="status text_transform_capitalize"><?php if(!empty($result->action)){ echo $result->action; }else{ echo "N/A"; } ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Action','gym_mgt');?>"></i></td> -->

                                                <td class="status"><?php if(!empty($result->date_time)){ echo $result->date_time; }else{ echo "N/A"; } ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Date & Time','gym_mgt');?>"></i></td>

                                            </tr>

                                            <?php 

                                        } 

                                        ?>     

                                    </tbody>        

                                </table>

                                <div class="print-button pull-left">

                                    <button class="btn-sms-color">

                                        <input type="checkbox" name="id[]" class=" select_all" value="<?php echo esc_attr($result->id); ?>" style="margin-top: 0px;">

                                        <label for="checkbox" class="margin_right_5px"><?php esc_html_e( 'Select All', 'gym_mgt' ) ;?></label>

                                    </button>

                                        <button data-toggle="tooltip" id="delete_selected" title="<?php esc_html_e('Delete Selected','gym_mgt');?>" name="delete_selected_audit_log" class="delete_selected" ><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Delete.png" ?>" alt=""></button>

                                </div>

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

            <?php

        }

        elseif($active_tab == 'sell_product_report')



        {



            $active_tab = isset($_GET['tab1'])?$_GET['tab1']:'report_graph';



            ?>



            <ul class="nav nav-tabs panel_tabs margin_left_1per mb-3" role="tablist"><!-- NAV TAB WRAPPER MENU START-->



                <li class="<?php if($active_tab=='report_graph'){?>active<?php }?>">



                    <a href="?dashboard=user&page=report&tab=sell_product_report&tab1=report_graph" class="padding_left_0 tab <?php echo $active_tab == 'report_graph' ? 'nav-tab-active' : ''; ?>">



                    <?php echo esc_html__('Sale Product Report Graph', 'gym_mgt'); ?></a>



                </li>



                <li class="<?php if($active_tab=='data_report'){?>active<?php }?>">



                    <a href="?dashboard=user&page=report&tab=sell_product_report&tab1=data_report" class="padding_left_0 tab <?php echo $active_tab == 'data_report' ? 'nav-tab-active' : ''; ?>">



                    <?php echo esc_html__('Sale Product Report Datatable', 'gym_mgt'); ?></a>



                </li>



            </ul>



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



            <?php



            if($active_tab == 'report_graph')



            {   



                $month =array('1'=>esc_html__('January','gym_mgt'),'2'=>esc_html__('February','gym_mgt'),'3'=>esc_html__('March','gym_mgt'),'4'=>esc_html__('April','gym_mgt'),'5'=>esc_html__('May','gym_mgt'),'6'=>esc_html__('June','gym_mgt'),'7'=>esc_html__('July','gym_mgt'),'8'=>esc_html__('August','gym_mgt'),'9'=>esc_html__('September','gym_mgt'),'10'=>esc_html__('October','gym_mgt'),'11'=>esc_html__('November','gym_mgt'),'12'=>esc_html__('December','gym_mgt'),);



                $year =isset($_POST['year'])?$_POST['year']:date('Y');



                global $wpdb;



                $table_name = $wpdb->prefix."gmgt_store";



                $q="SELECT * FROM ".$table_name." WHERE YEAR(sell_date) =".$year." ORDER BY sell_date ASC";



                $result=$wpdb->get_results($q);



                $month_wise_count=array();



                foreach($result as $key=>$value)



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



                $chart_array = array();



                //$chart_array[] = array('Month','Sale Product');



                $chart_array[] = array(esc_html__('Month','gym_mgt'),esc_html__('Sale Product','gym_mgt'));



                foreach($sumArray as $month_value=>$quentity)



                {



                    $chart_array[]=array( $month[$month_value],(int)$quentity);



                }



                $options = Array(



                            'title' => esc_html__('Sale Product Report By Month','gym_mgt'),



                            'titleTextStyle' => Array('color' => '#66707e'),



                            'legend' =>Array('position' => 'right',



                                        'textStyle'=> Array('color' => '#66707e')),



                            'hAxis' => Array(



                                'title' => esc_html__('Month','gym_mgt'),



                                'format' => '#',



                                'titleTextStyle' => Array('color' => '#66707e','fontSize' => 16,'bold'=>true,'italic'=>false,'fontName' =>'poppins'),



                                'textStyle'=> Array('color' => '#66707e','fontSize' => 16,'bold'=>true,'italic'=>false,'fontName' =>'poppins'),



                                'maxAlternation' => 2				



                                ),



                            'vAxis' => Array(



                                'title' => esc_html__('Sale Product','gym_mgt'),



                                'minValue' => 0,



                                'maxValue' => 6,



                                'format' => '#',



                                'titleTextStyle' => Array('color' => '#66707e','fontSize' => 16,'bold'=>true,'italic'=>false,'fontName' =>'poppins'),



                                'textStyle'=> Array('color' => '#66707e','fontSize' => 16,'bold'=>true,'italic'=>false,'fontName' =>'poppins')



                                ),



                        'colors' => array('#ba170b')



                            );



                require_once GMS_PLUGIN_DIR. '/lib/chart/GoogleCharts.class.php';



                $GoogleCharts = new GoogleCharts;



                $chart = $GoogleCharts->load( 'column' , 'chart_div' )->get( $chart_array , $options );



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



                    if(empty($result)) 



                    {?>



                        <div class="clear col-md-12"><h3><?php esc_html_e("There is not enough data to generate report.",'gym_mgt');?> </h3></div>



                    <?php 



                    } ?>



                </div>



                <div id="chart_div" class="chart_div"></div>



                <!-- Javascript --> 



                <script type="text/javascript" src="https://www.google.com/jsapi"></script> 



                <script type="text/javascript">



                    <?php 



                    if(!empty($result))



                    {



                        echo $chart;



                    }



                    ?>



                </script>



                <?php



            }



            if($active_tab == 'data_report')



            { 



                $obj_class=new MJ_gmgt_classschedule;



                $obj_product=new MJ_gmgt_product;



                $obj_store=new MJ_gmgt_store;



            



                if(isset($_REQUEST['sell_report_datatable']))



                {



                    $start_date =MJ_gmgt_get_format_for_db(esc_attr($_REQUEST['sdate']));



                    $end_date = MJ_gmgt_get_format_for_db(esc_attr($_REQUEST['edate']));



                }



                else



                {



                    $start_date = date('Y-m-d',strtotime('first day of this month'));



                    $end_date = date('Y-m-d',strtotime('last day of this month'));



                }



                $storedata=MJ_gmgt_get_all_sell_report_beetween_start_date_to_enddate($start_date,$end_date);



            



                ?>



                <script type="text/javascript">



                    $(document).ready(function() 



                    {



                        "use strict";



                        $('#selling_list').DataTable({



                        // "responsive": true,



                        "order": [[ 1, "asc" ]],



                        dom: 'lifrtp',



                        "aoColumns":[



                                        {"bSortable": false},



                                        {"bSortable": true},



                                        {"bSortable": true},



                                        {"bSortable": true},



                                        {"bSortable": true},



                                        {"bSortable": true},



                                        {"bSortable": true},



                                        {"bSortable": true},



                                        ],



                                language:<?php echo MJ_gmgt_datatable_multi_language();?>		  



                        });



                        $('.dataTables_filter input').attr("placeholder", "<?php esc_html_e('Search...', 'gym_mgt') ?>");



                    } );



                </script>



                <div class="panel-body padding_0">



                    <form method="post">



                        <div class="form-body user_form">



                            <div class="row"> 



                                <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5 ipad_res">



                                    <div class="form-group input">



                                        <div class="col-md-12 form-control">



                                            <input type="text"  class="form-control sdate1" name="sdate" value="<?php if(isset($_REQUEST['sdate'])) echo esc_attr($_REQUEST['sdate']);else echo esc_attr(MJ_gmgt_getdate_in_input_box(date('Y-m-d')));?>" readonly>



                                            <label for="exam_id"><?php esc_html_e('Start Date','gym_mgt');?></label>	



                                        </div>



                                    </div>



                                </div>



                                <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5 ">



                                    <div class="form-group input">



                                        <div class="col-md-12 form-control">



                                            <input type="text"  class="form-control edate1"  name="edate" value="<?php if(isset($_REQUEST['edate'])) echo esc_attr($_REQUEST['edate']);else echo esc_attr(MJ_gmgt_getdate_in_input_box(date('Y-m-d')));?>" readonly>



                                            <label for="exam_id"><?php esc_html_e('End Date','gym_mgt');?></label>



                                        </div>



                                    </div>



                                </div>



                                <div class="col-md-2 col-sm-2 col-xs-2"><!--save btn--> 



                                    <input type="submit" name="sell_report_datatable" Value="<?php esc_html_e('Go','gym_mgt');?>"  class="btn save_btn"/>



                                </div>



                            </div><!--Row Div End--> 



                        </div><!-- user_form End--> 



                    </form>



                </div>



                <?php



                if(!empty($storedata))



                {



                    ?>



                    <form name="wcwm_report" action="" method="post"><!--SELL Product LIST FORM START-->	



                        <div class="panel-body padding_0"><!--PANEL BODY DIV START-->



                            <div class="table-responsive"><!--TABLE RESPONSIVE DIV START-->



                                <table id="selling_list" class="display" cellspacing="0" width="100%"><!--SELL Product LIST TABLE START-->

                                    <thead class="<?php echo MJ_gmgt_datatable_heder(); ?>">



                                        <tr>



                                        <th><?php  esc_html_e( 'Photo', 'gym_mgt' ) ;?></th>



                                            <th><?php esc_html_e('Invoice No.','gym_mgt');?></th>



                                            <th><?php esc_html_e('Member Name','gym_mgt');?></th>



                                            <th><?php esc_html_e('Product Name=>Product Quantity','gym_mgt');?></th>



                                            <th><?php esc_html_e('Total Amount','gym_mgt');?></th>



                                            <th><?php esc_html_e('Paid Amount','gym_mgt');?></th>



                                            <th><?php esc_html_e('Due Amount','gym_mgt');?></th>



                                            <th><?php esc_html_e('Payment Status','gym_mgt');?></th>



                                        </tr>



                                    </thead>

                                    <tbody>



                                        <?php 	



                                        if(!empty($storedata))



                                        {



                                            $i=0;



                                            foreach ($storedata as $retrieved_data)



                                            {



                                                if(empty($retrieved_data->invoice_no))



                                                {



                                                    $obj_product=new MJ_gmgt_product;



                                                    $product = $obj_product->MJ_gmgt_get_single_product($retrieved_data->product_id);



                                                    $price=$product->price;	



                                                    $quentity=$retrieved_data->quentity;



                                                    $invoice_no='-';					



                                                    $total_amount=$price*$quentity;



                                                    $paid_amount=$price*$quentity;



                                                    $due_amount='0';



                                                }



                                                else



                                                {



                                                    $invoice_no=$retrieved_data->invoice_no;



                                                    $total_amount=$retrieved_data->total_amount;



                                                    $paid_amount=$retrieved_data->paid_amount;



                                                    $due_amount=$total_amount-$paid_amount;



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



                                                            <img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/Payment.png"?>" alt="" class="massage_image center image_icon_height_25px margin_top_3px">



                                                        </p>



                                                    </td>



                                                    <td class="productquentity"><?php echo esc_html($invoice_no); ?>	<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Invoice No.','gym_mgt');?>" ></i></td>	



                                                    <td class="membername"><?php $userdata=get_userdata(($retrieved_data->member_id)); echo esc_html($userdata->display_name);?>	<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Member Name','gym_mgt');?>" ></i></td>



                                                    <td class="productname">



                                                        <?php 



                                                        $entry_valuea=json_decode($retrieved_data->entry);



                                                        



                                                        if(!empty($entry_valuea))



                                                        {



                                                            foreach($entry_valuea as $entry_valueb)



                                                            {



                                                                $product = $obj_product->MJ_gmgt_get_single_product($entry_valueb->entry);



                                                                if(!empty($product))



                                                                {



                                                                $product_name=$product->product_name;



                                                                $quentity=$entry_valueb->quentity;



                                                                $product_quantity=$product_name . " => " . $quentity . ",";



                                                                echo rtrim(esc_html($product_quantity),',');



                                                                }



                                                                else {



                                                                    echo "N/A";



                                                                }



                                                                ?>



                                                                <br>



                                                            <?php



                                                            }



                                                        }



                                                        else



                                                        {



                                                            $obj_product=new MJ_gmgt_product;



                                                            $product = $obj_product->MJ_gmgt_get_single_product($retrieved_data->product_id);



                                                            $product_name=$product->product_name;



                                                            $quentity=$retrieved_data->quentity;	



                                                            echo  esc_html($product_name). " => " .esc_html($quentity);



                                                        }



                                                        ?>	<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Product Name=>Product Quantity','gym_mgt');?>" ></i>



                                                    </td>		



                                                    <td class="productquentity"><?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?> <?php echo number_format(esc_html($total_amount),2); ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Total Amount','gym_mgt');?>" ></i></td>



                                                    <td class="productquentity"><?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?> <?php echo number_format(esc_html($paid_amount),2); ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Paid Amount','gym_mgt');?>" ></i></td>



                                                    <td class="totalamount"><?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?> <?php echo number_format(esc_html($due_amount),2); ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Due Amount','gym_mgt');?>" ></i></td>



                                                    <td class="paymentdate">



                                                        <?php



                                                        if($retrieved_data->payment_status == 'Unpaid')



                                                        {



                                                            echo "<span class='Unpaid_status_color'>";



                                                        }



                                                        if($retrieved_data->payment_status == 'Partially Paid')



                                                        {



                                                            echo "<span class='paid_status_color'>";



                                                        }



                                                        else



                                                        {



                                                            echo "<span class='fullpaid_status_color'>";



                                                        }															



                                                        echo  esc_html__("$retrieved_data->payment_status","gym_mgt");



                                                        echo "</span>";



                                                        ?>	<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Payment Status','gym_mgt');?>" ></i>



                                                    </td>



                                                </tr>



                                                <?php  



                                                $i++;



                                            }



                                        }



                                        ?>



                                    </tbody>



                                </table><!--SELL Product LIST TABLE END-->	



                            </div><!--TABLE RESPONSIVE DIV END-->	



                        </div>	<!--PANEL BODY END-->			   



                    </form><!--SELL Product LIST FORM END-->



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



        ?>



    </div><!--PANEL BODY DIV END-->



</div><!--PANEL WHITE DIV END-->