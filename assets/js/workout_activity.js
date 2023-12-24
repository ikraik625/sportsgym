jQuery(document).ready(function() 

{
    $("body").on("click", ".activity_input_value", function()
	{
        var id = $(this).data('value');
        
        var activity_id = $(".activity_id_"+id+"").val();

        var curr_data = {

            action: 'activity_controlar',

            activity_id: activity_id,

            dataType: 'json'

        };	 

        $.post(gmgt.ajax, curr_data, function(response) { 	

            var json_obj = JSON.parse(response);

            $(".activity_cat_id_"+id+"").autocomplete({

                source: json_obj,

                minLength: 0,

                scroll: true,

                open: function( event, ui ) {

                    $(".ui-autocomplete li").attr('data-value', id);

                }

            }).focus(function() {

                $(this).autocomplete("search", "");

                $(".ui-autocomplete li").addClass('activity_category_name');

                $(".ui-autocomplete").addClass('activity_category_name_ui');

                $(".ui-autocomplete li").attr('data-value', id);

            });


            return false;

        });	

    });	

    $("body").on("click", ".activity_category_name", function()

	{
        var search_value = $(this).text();

		var vall_a= $(".activity_id_hidden").text().includes(search_value);
       
        if(vall_a == false)

		{

			$(".activity_id_hidden").append(search_value.concat(','));

		}

        
		if(vall_a == false)

		{
            var id = $(this).data('value');

            var activity_value = $(".activity_cat_id_"+id+"").val();

            var curr_data = {

                action: 'append_activity_name_by_auto_suggest',

                activity_value: activity_value,

                dataType: 'json'

            };	 

            $.post(gmgt.ajax, curr_data, function(response) { 

                $(".activity_data_list_"+id+"").append(response);

                return false; 	
            });	
        }
        else{

			alert("You have already selected this Activity.");

		}
        

	});

});