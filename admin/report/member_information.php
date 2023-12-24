<?php

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

<script>

	// jQuery(document).ready(function($)

	// {

    //     jQuery(".save_status").click(function(){

    //         var membership_status=$('#membership_status').val();

    //         // $('#membership_status option:selected').append(membership_status);

    //         $('.view_status').append(membership_status);

    //     });

    //     var view_status=$('.view_status').val();

    //     $('#membership_status option:selected').text(view_status);

    // });

</script>

<div class="panel-body padding_0 mt-3">



    <form method="post" id="attendance_list" class="attendance_list report">  

        <div class="form-body user_form margin_top_15px responsive_margin_30px">

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

                    <input type="hidden" name="view_status" Value="" class="btn btn-info save_btn view_status"/>

                    <input type="submit" name="view_member" Value="<?php esc_attr_e('Go','gym_mgt');?>"  class="btn btn-info save_btn save_status"/>

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

            jQuery(document).ready(function($){

                var table = jQuery('#memberinfo').DataTable({

                    "responsive": true,

                    "order": [[ 2, "Desc" ]],

                    "dom": 'lifrtp',

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

                            text:'<?php esc_html_e('Print', 'gym_mgt')?>',

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



                    language:<?php echo mj_gmgt_datatable_multi_language();?>

                });

                $('.btn-place').html(table.buttons().container()); 

                $('.dataTables_filter input').attr("placeholder", "<?php esc_html_e('Search...', 'gym_mgt') ?>");

            });

        </script>



        <div class="table-responsive"><!--TABLE RESPONSIVE DIV START-->

            <div class="btn-place"></div>



            <form name="wcwm_report" action="" method="post"><!--EXPENSE LIST FORM START-->



                <table id="memberinfo" class="display" cellspacing="0" width="100%"><!--EXPENSE LIST TABLE START-->



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