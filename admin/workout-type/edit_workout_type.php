<script type="text/javascript">

jQuery(document).ready(function($) 

{

	"use strict";

	// $(".display-members").select2();

	$('#edit_workout_form').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});

	

});

</script>

<?php

$workoutmember_id=esc_attr($_REQUEST['workoutmember_id']);				

$workout_logdata=MJ_gmgt_get_userworkout($workoutmember_id);

$all_logdata=MJ_gmgt_get_workoutdata($_REQUEST['workoutmember_id']);

$workout_data = $obj_workouttype->MJ_gmgt_get_singal_assignworkout($_REQUEST['workoutmember_id']);

$arranged_workout=MJ_gmgt_set_workoutarray_new($all_logdata);

							  						 

if(!empty($all_logdata))

{ 

    foreach($workout_logdata as $row)

    {

        ?>

        <div class="workout_<?php echo esc_attr($row->workout_id);?> workout-block">

            <!--WORKOUT BLOCK DIV START-->

            <div class="panel-heading height_auto">

                <div class="panel-heading">

                    <h3 class="panel-title"><i class="fa fa-calendar"></i>

                    <?php 

                    esc_html_e('Start From ','gym_mgt');

                    echo "<span class='work_date'>".MJ_gmgt_getdate_in_input_box($row->start_date)."</span>";

                    esc_html_e(' To ','gym_mgt');

                    echo "<span class='work_date'>".MJ_gmgt_getdate_in_input_box($row->end_date)."</span>&nbsp;";

                    if(!empty($row->description))

                    {

                        esc_html_e('Description : ','gym_mgt');

                        echo "<span class='work_date'>".$row->description."</span>";

                    }

                    ?> 

                    </h3>							

                </div>

            </div>

        </div>

            <?php

    }

    ?>

    <div class="">

        <!--PANEL WHITE DIV START-->

        <form name="edit_workout_form" action="" method="post" class="edit_workout_form" id="edit_workout_form">

            <!-- ACTIVITY FORM START-->

            <?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'edit';?>

            <input type="hidden" name="action" value="<?php echo esc_attr($action);?>">

            <input type="hidden" name="workout_id" value="<?php echo esc_attr($_REQUEST['workoutmember_id']);?>">

            <div class="table-responsive">

            <table class="table workour_edit_table" width="100%">

                <thead>

                    <tr class="assign_workout_table_header_tr">

                        <th class="assign_workout_table_header assign_workout_right_border" scope="col"><?php esc_html_e('Day Name','gym_mgt');?></th>

                        <th class="assign_workout_table_header assign_workout_right_border" scope="col"><?php esc_html_e('Activity','gym_mgt');?></th>

                        <th class="assign_workout_table_header assign_workout_right_border" scope="col"><?php esc_html_e('Sets','gym_mgt');?></th>

                        <th class="assign_workout_table_header assign_workout_right_border" scope="col"><?php esc_html_e('Reps','gym_mgt');?></th>

                        <th class="assign_workout_table_header assign_workout_right_border" scope="col"><?php esc_html_e('KG','gym_mgt');?></th>

                        <th class="assign_workout_table_header assign_workout_border" scope="col"><?php esc_html_e('Rest Time','gym_mgt');?></th>

                        

                    </tr>

                </thead>

                <tbody>



                    <?php 

                    

                    foreach($arranged_workout as $key=>$rowdata)

                    {

                    $i=1;										

                    foreach($rowdata as $row)

                    { 

                    ?>

                    <input type="hidden" value="<?php echo $row['id']; ?>" name="id[]"/>

                    <tr class="assign_workout_table_body_tr">

                        <?php if($i == 1)

                        { ?>

                        <th class="assign_workout_table_body table_body_border_right" scope="row"><?php 

                        if($key =='Sunday')

                        {

                            echo esc_html_e('Sunday','gym_mgt');

                        } 	

                        elseif($key =='Monday')

                        {

                            echo esc_html_e('Monday','gym_mgt');

                        } 	

                        elseif($key =='Tuesday')

                        {

                            echo esc_html_e('Tuesday','gym_mgt');

                        } 	

                        elseif($key =='Wednesday')

                        {

                            echo esc_html_e('Wednesday','gym_mgt');

                        } 	

                        elseif($key =='Thursday')

                        {

                            echo esc_html_e('Thursday','gym_mgt');

                        } 	

                        elseif($key =='Friday')

                        {

                            echo esc_html_e('Friday','gym_mgt');

                        } 	

                        elseif($key =='Saturday')

                        {

                            echo esc_html_e('Saturday','gym_mgt');

                        } 	  

                        ?></th>

                        <?php

                        }

                        else

                        { ?>

                        <th class="assign_workout_table_body table_body_border_right" scope="row"></th>

                        <?php 

                        }

                        ?>

                      

                            <td class="width_200 assign_workout_table_body table_body_border_right"><span><?php echo $row['workout_name']; ?></span></td>

                            <td class="assign_workout_table_body table_body_border_right">

                                <input type="number" class="validate[required] date_border_css form-control text-input style_width_admin" min="0"

                                    onkeypress="if(this.value.length==3) return false;" name="sets[]"

                                    <?php if($row['sets'] == '-') { ?> value="<?php echo "-";?>" readonly="readonly"

                                    <?php } else{  ?> value="<?php echo $row['sets']; ?>" <?php } ?>></td>

                            <td class="assign_workout_table_body table_body_border_right">

                                <input type="number" class="validate[required] date_border_css form-control text-input workout_validate style_width_admin" min="0"

                                    onkeypress="if(this.value.length==3) return false;" name="reps[]"

                                    <?php if($row['reps'] == '-') { ?> value="<?php echo "-";?>" readonly="readonly"

                                    <?php } else{  ?> value="<?php echo $row['reps']; ?>" <?php } ?>></td>

                            <td class="assign_workout_table_body table_body_border_right">

                                <input type="number" class="validate[required] date_border_css form-control text-input workout_validate style_width_admin" min="0"

                                    onkeypress="if(this.value.length==6) return false;" name="kg[]"

                                    <?php if($row['kg'] == '-') { ?> value="<?php echo "-";?>" readonly="readonly"

                                    <?php } else{  ?>value="<?php echo $row['kg']; ?>" <?php } ?>></td>

                            <td class="assign_workout_table_body">

                                <input type="number" class="validate[required] date_border_css form-control text-input workout_validate  style_width_admin" min="0"

                                    onkeypress="if(this.value.length==3) return false;" name="time[]"

                                    <?php if($row['time'] == '-') { ?> value="<?php echo "-";?>" readonly="readonly"

                                    <?php } else{  ?>value="<?php echo $row['time']; ?>" <?php } ?>>

                            </td>

                        <?php 

                        $i++;

                        }   

                        ?>

                    </tr>

                    <?php

                    } 

                    ?>

                </tbody>

            </table>

            <div>

            <div class="col-md-3 edit_workout_padding_bottom">

                <input type="submit" value="<?php esc_html_e('Save Workout','gym_mgt'); ?>" name="save_workoutlog" class="btn save_btn custom_save_button"/>

            </div>

        </form>

    </div>

    <!--PANEL WHITE DIV END-->

</div>

<!--WORKOUT BLOCK DIV END-->

<?php

 	}

?>