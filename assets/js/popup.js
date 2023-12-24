jQuery(document).ready(function($) {

	

"use strict";	



//----------- Sidebar dropdown in Responsive -----------//



jQuery('#sidebarCollapse').on('click', function () {



	jQuery('#sidebar').toggleClass('active');



	jQuery(this).toggleClass('active');



});



jQuery('.has-submenu').on('click', function () {



	jQuery('.submenu',this).toggleClass('active');



	jQuery(this).toggleClass('active');



});



$('.dropdown-toggle').dropdown();



//----------- Sidebar dropdown in Responsive -----------//







//Category Add and Remove



  $("body").on("click", "#addremove", function(event)



   {



	   



	  event.preventDefault(); // disable normal link function so that it doesn't refresh the page



	  var docHeight = $(document).height(); //grab the height of the page



	  var scrollTop = $(window).scrollTop();



	  var model  = $(this).attr('model') ;



	  jQuery("#myModal_add_staff_member").css({"display": "none"});



	  jQuery("#myModal_add_membership").css({"display": "none"});



	  jQuery("#myModal_add_staff_member123").css({"display": "none"});



	   var curr_data = {



	 					action: 'MJ_gmgt_add_or_remove_category',



	 					model : model,



	 					dataType: 'json'



	 					};	



										



	 					$.post(gmgt.ajax, curr_data, function(response) { 



						



							$('.popup-bg').show().css({'height' : docHeight});



							$('.category_list').html(response);	



							return true; 					



	 					});	



	



  });







   $("body").on("click", ".close-btn", function(){	



		$( ".category_list" ).empty();



		$('.popup-bg').hide(); // hide the overlay



		



		}); 



	



		$("body").on("click", ".close-btn.activity_category", function()



		{



			//$("#myModal_add_staff_member").css({"display": "block"}); 



			$("#myModal_add_staff_member12").css({"display": "block"}); 



            $( ".category_list" ).empty();



			$('.popup-bg').hide(); // hide the overlay







		});		



		$("body").on("click", ".close-btn.role_type", function()



		{		



			$("#myModal_add_staff_member").css({"display": "block"}); 



			$( ".category_list" ).empty();



			$('.popup-bg').hide(); // hide the overlay



		});



		



		$("body").on("click", ".close-btn.role_type", function()



		{		



		



			$("#myModal_add_staff_member").css({"display": "block"}); 



			$( ".category_list" ).empty();



			$('.popup-bg').hide(); // hide the overlay



		});



		



		$("body").on("click", ".close-btn.activity_category", function()



		{		



		



			$("#myModal_add_staff_member").css({"display": "block"}); 



			$( ".category_list" ).empty();



			$('.popup-bg').hide(); // hide the overlay



		});



		$("body").on("click", ".close-btn.activity_category_staff", function()



		{		



		



			$("#myModal_add_staff_member123").css({"display": "block"}); 



			$( ".category_list" ).empty();



			$('.popup-bg').hide(); // hide the overlay



		});

		$("body").on("click", ".close-btn.role_type", function()



		{		



		



			$("#myModal_add_staff_member123").css({"display": "block"}); 



			$( ".category_list" ).empty();



			$('.popup-bg').hide(); // hide the overlay



		});

		$("body").on("click", ".close-btn.membership_category,.close-btn.installment_plan", function(){		



			$("#myModal_add_membership").css({"display": "block"}); 







			$( ".category_list" ).empty();



			



			$('.popup-bg').hide(); // hide the overlay



		



		});	



		 $("body").on("click", "#add_membership_btn", function(){		



			$("#myModal_add_membership").css({"display": "block"});



			



		 });



		 $("body").on("click", "#add_staff_btn", function(){



			$("#myModal_add_staff_member").css({"display": "block"});			 



		



		 });



 



  



  jQuery("body").on("click", ".btn-delete-cat", function()



  {		



		var cat_id  = $(this).attr('id') ;	



		var model  = $(this).attr('model') ;



		if(confirm(language_translate.membership_category_delete_record_alert))



		{



			var curr_data = {



					action: 'MJ_gmgt_remove_category',



					model : model,



					cat_id:cat_id,			



					dataType: 'json'



					};



					



					$.post(gmgt.ajax, curr_data, function(response) 



					{						



						$('#cat-'+cat_id).hide();						



						$("#"+model).find('option[value='+cat_id+']').remove();		



						if(model == 'activity_category')



						{



							$('#specialization').find('option[value='+cat_id+']').remove();		



							$('#specialization').multiselect('rebuild');				



						}



						return true;				



					});			



		}



	});



	


	// $("body").on("click", "#save_extend_membership", function(){	
		
		
	// 	var member_id  = $('.member_id').val();
	// 	var membership_id  = $('.membership_id').val();
	// 	var begin_date  = $('.begin_date').val();
	// 	var membership_end_date  = $('.membership_end_date').val();
	// 	var extend_day  = $('.extend_day').val();
	// 	var new_end_date  = $('.new_end_date').val();
	// 	var valid = jQuery('#extend_membership').validationEngine('validate');
	// 	if (valid == true) 
	// 	{
	// 		var curr_data = {
	// 			action: 'MJ_gmgt_add_extend_data',
	// 			member_id : member_id,
	// 			membership_id : membership_id,
	// 			begin_date : begin_date,
	// 			membership_end_date : membership_end_date,
	// 			extend_day : extend_day,
	// 			new_end_date : new_end_date,
	// 			dataType: 'json'
	// 			};
	// 		$.post(gmgt.ajax, curr_data, function(response) {
	// 			alert(response);
	// 			dispatchEvent;
	// 			$('.extend_table').append(response);
	// 		});
	// 	}
	// 	return false;




	// });


  $("body").on("click", "#btn-add-cat", function(){	



        //  alert('111');



		// return false;



		var category_name  = $('#category_name').val() ;



		var model  = $(this).attr('model');



		// console.log(model);



		// return false;



		var valid = jQuery('#category_form').validationEngine('validate');



		if (valid == true) 



		{



			if(category_name != "")



			{		



				var curr_data = {



						action: 'MJ_gmgt_add_category',



						model : model,



						category_name: category_name,			



						dataType: 'json'



						};



											



						$.post(gmgt.ajax, curr_data, function(response) {



							



							var json_obj = $.parseJSON(response);//parse JSON	



							if(json_obj[2]=="1")

							{



								$('.category_listbox .div_new').append(json_obj[0]);



								$('#category_name').val("");



								$('#'+model).append(json_obj[1]);



								if(model == 'activity_category')

								{



									$('#specialization').append(json_obj[1]);



									$('#activity_select').append(json_obj[1]);



									$('#specialization').multiselect('rebuild');



								}							



							}

							else {



								



								alert(json_obj[3]);



							}



							return false;					



						});



			}



			else



			{



				alert(language_translate.please_enter_caegory_name_alert);



			}



		}		



	});



 



  //End category Add Remove 



  $("body").on("change","#class_id",function(){



		$('#member_list').html('');



		var selection = $("#class_id").val();



		var optionval = $(this);



			var curr_data = {



					action: 'MJ_gmgt_load_user',



					class_list: $("#class_id").val(),			



					dataType: 'json'



					};



					$.post(gmgt.ajax, curr_data, function(response) {						



					$('#member_list').append(response);	



					});



						



					



	});



//-----------load activity by category------------- //



	$("body").on("change","#act_cat_id",function(){



		$('#activity_list').html('');



		var selection = $("#act_cat_id").val();



		var optionval = $(this);



			var curr_data = {



					action: 'MJ_gmgt_load_activity',



					activity_list: selection,			



					dataType: 'json'



					};



					$.post(gmgt.ajax, curr_data, function(response) {



						



					$('#activity_list').append(response);	



					});



						



					



	});







  //----------view Invoice popup--------------------



	$("body").on("click", ".show-invoice-popup", function(event)



	{







	  event.preventDefault(); // disable normal link function so that it doesn't refresh the page



	  var docHeight = $(document).height(); //grab the height of the page



	  var scrollTop = $(window).scrollTop();



	  var idtest  = $(this).attr('idtest');



	  var invoice_type  = $(this).attr('invoice_type');



	  



		



	   var curr_data = {



	 					action: 'MJ_gmgt_invoice_view',



	 					idtest: idtest,



	 					invoice_type: invoice_type,



	 					dataType: 'json'



	 					};	 	



												



	 					$.post(gmgt.ajax, curr_data, function(response) { 	



	 							 



	 					$('.popup-bg').show().css({'height' : docHeight});							



						$('.invoice_data').html(response);	



						return true; 					



	 					});	



	



  });



  jQuery("body").on("click", ".view-nutrition", function(event)



  {



	  var nutrition_id = $(this).attr('id');



	  event.preventDefault(); // disable normal link function so that it doesn't refresh the page



	  var docHeight = $(document).height(); //grab the height of the page



	  var scrollTop = $(window).scrollTop();



	  



	   var curr_data = {



	 					action: 'MJ_gmgt_nutrition_schedule_view',



	 					nutrition_id: nutrition_id,			



	 					dataType: 'json'



	 					};



	 					



	 					$.post(gmgt.ajax, curr_data, function(response) {



	 						



	 						



	 						$('.popup-bg').show().css({'height' : docHeight});



							$('.category_list').html(response);	



	 						return true;



	 						



	 					



	 					



	 					});	



	});  



	//-----------Display measurement by workout-------------//



	$("body").on("change","#workout_id",function(){



		$('#workout_mesurement').html('');



		var selection = $("#workout_id").val();



		var optionval = $(this);



			var curr_data = {



					action: 'MJ_gmgt_load_workout_measurement',



					workout_id: selection,			



					dataType: 'json'



					};



					$.post(gmgt.ajax, curr_data, function(response) 



					{						



						$('#workout_mesurement').text(response);	



					});



	});







	jQuery("body").on("click", ".view_details_popup", function(event)



	{



		  var record_id = $(this).attr('id');



		  var type = $(this).attr('type');



		 



		  event.preventDefault(); // disable normal link function so that it doesn't refresh the page



		  var docHeight = $(document).height(); //grab the height of the page



		  var scrollTop = $(window).scrollTop();



		   var curr_data = {



		 					action: 'MJ_gmgt_view_details_popup',



		 					record_id: record_id,			



		 					type: type,			



		 					dataType: 'json'



		 					};







		 					$.post(gmgt.ajax, curr_data, function(response) {



							



		 						$('.popup-bg').show().css({'height' : docHeight});



								$('.category_list').html(response);	



		 						return true;



		 						



		 					});	



	}); 



	 



	jQuery("body").on("change", ".activity_check", function(event)

	{	

		var check_value = $(this).attr('id');
		if($("#"+check_value).is(":checked"))

		{			
			$("#reps_sets_"+check_value).css("display", "block");

		}
		else
		{			
			$("#reps_sets_"+check_value).css("display", "none");

		}

	 });



	 function add_day(day,id)



	 {



		 var string = '';



		  



		if(day == 'Sunday')



		{



			string = '<span id="'+id+'">'+language_translate.sunday_days+'</span>';



		}



		else if(day =='Monday')



		{



			string = '<span id="'+id+'">'+language_translate.monday_days+'</span>,';



		}



		else if(day =='Tuesday')



		{



			string = '<span id="'+id+'">'+language_translate.Tuesday_days+'</span>,';



		}



		else if(day =='Wednesday')



		{



			string = '<span id="'+id+'">'+language_translate.Wednesday_days+'</span>,';



		}



		else if(day =='Thursday')



		{



			string = '<span id="'+id+'">'+language_translate.Thursday_days+'</span>,';



		}



		else if(day =='Friday')



		{



			string = '<span id="'+id+'">'+language_translate.Friday_days+'</span>,';



		}



		else if(day =='Saturday')



		{



			string = '<span id="'+id+'">'+language_translate.Saturday_days+'</span>,';



		}



		 string += '<input type="hidden" name="day[day]['+day+']" value="'+day+'">';



		 return string;



	 }



	 function add_activity(activity,id)



	 {



		 var string = '';



		 var sets = '';



		 var reps = '';



		 var sets = $("#sets_"+id).val();



		 var reps = $("#reps_"+id).val();



		 var kg = $("#kg_"+id).val();



		 var time = $("#time_"+id).val();



		 



		 string += '<div class="form-group"><div class="row"><label class="col-md-4 control-label font_bold form-label">'+activity+' : </label>';



		 string += '<div class="col-md-8 padding_top_7"><span id="sets_'+id+'"> '+ language_translate.sets_lable +' '+sets+', </span>';



		 string += '<span id="reps_'+id+'"> '+ language_translate.reps_lable +' '+reps+', </span>';



		 string += '<span id="kg_'+id+'"> '+ language_translate.kg_lable +' '+kg+', </span>';



		 string += '<span id="time_'+id+'"> '+ language_translate.rest_time_lable +' '+time+'.</span></div></div></div>';



		 



		 string += '<input type="hidden" name="sets[]" value="'+sets+'">';



		 string += '<input type="hidden" name="reps[]" value="'+reps+'">';



		 string += '<input type="hidden" name="kg[]" value="'+kg+'">';



		 string += '<input type="hidden" name="time[]" value="'+time+'">';



		 string += '<input type="hidden" name="activity[]" value="'+activity+'">';



		



		 return string;



	 }



	function workout_list(day,activity,id,response)



	{



		var string = '';



		



		string += "<div class='activity nutrisition_activity_box col-md-12 padding_0' id='block_"+id+"'>";	



			string += "<div class='form-group nutrition_head float_left_res'>";



				string += "<div class='row'>";



					string += '<div class="col-md-9 font_bold margin_left_2"> '+ language_translate.assigned_workout_lable +' </div>';



					string += "<div id='"+id+"' class='removethis col-md-2 margin_left_2'><span class='badge badge-delete pull-right'>X</span></div>";



				string += '</div>';	



				string += "<div class='form-group'>";



					string += "<div class='row'>";



						string += '<label class="col-md-4 control-label font_bold form-label">'+ language_translate.days_lable +' :</label>';		



						string += '<div class="col-md-8 add_nut padding_top_7 ">'+day+'</div>';



					



					string += '</div>';



				string += '</div>';



			string += '</div>';



			string += "<div class='form-group padding_bottom_7'>";



					string += activity;



			string += '</div>';



			string += "<div class='form-group'>";



				string += '<div class="offset-sm-2 col-lg-8 col-md-8 col-sm-8 col-xs-12">'+ response+'</div>';



			string += '</div>';	



			



		string += "</div'>";  



		



		return string;



	}



	 jQuery("body").on("click", ".removethis", function(event){



		



		 var chkID = $(this).attr("id");



		 $("#block_"+chkID).remove();



	 });



	 jQuery("body").on("click", ".removeworkout", function(event){



			



			if(confirm(language_translate.daily_workout_exercise_delete_alert))



			{



				var chkID = $(this).attr("id");



			    var curr_data = {



						action: 'MJ_gmgt_delete_workout',



						workout_id: chkID,			



						dataType: 'json'



						};



						



						$.post(gmgt.ajax, curr_data, function(response) {						



							$(".workout_"+chkID).remove();



							//window.location.href = window.location.href + "&message=6";



							//return true;



						});	



			}



		 });



	 jQuery("body").on("click", "#add_workouttype", function(event)



	 {



		var valid = jQuery('#workouttype_form').validationEngine('validate');



		if (valid == true) 



		{



			var checkedday = $('input[name="day[]"]:checked').length;



			var checkedavtivity_id = $('input[name="avtivity_id[]"]:checked').length;



			



			if (checkedday>0 && checkedavtivity_id>0)



			{		



				 $("#display_rout_list").html('');



				 var count = $("#display_rout_list div").length;	



				



				 var day = '';



				 var activity = '';



				 var check_val = '';



				 var jsonObj1 = [];



				 var jsonObj2 = [];



				 var jsonObj = [];



				



				 $(":checkbox:checked").each(function(o){



					



					  var chkID = $(this).attr("id");



					  var check_val = $(this).attr("data-val");



					  



					  if(check_val == 'day')



					  {



						 



						  day += add_day(chkID,chkID);



						  var item = {}



							item ["day_name"] =chkID;



						   	



							jsonObj1.push(item);



							



					  }



					  if(check_val == 'activity')



					  {



						var activity_name = $(this).attr("activity_title");



						 var item = {};



						  var sets = $("#sets_"+chkID).val();



						  var reps = $("#reps_"+chkID).val();



						  var kg = $("#kg_"+chkID).val();



						  var time = $("#time_"+chkID).val();



						  



							item ["activity"] = {"activity":activity_name,"sets":$("#sets_"+chkID).val(),"reps":$("#reps_"+chkID).val(),"kg":$("#kg_"+chkID).val(),"time":$("#time_"+chkID).val()};



						  activity += add_activity(activity_name,chkID);



						 



							jsonObj2.push(item);



					  }



					



					  $(this).prop('checked', true);



					 



					  /* ... */



					  jsonObj = {"days":jsonObj1,"activity":jsonObj2};



					});



				



					



				 var curr_data = {



							action: 'MJ_gmgt_add_workout',



							data_array: jsonObj,			



							dataType: 'json'



							};



							



							$.post(gmgt.ajax, curr_data, function(response) {



								



								 var list_workout =  workout_list(day,activity,count,response);



									



									$("#display_rout_list").append(list_workout);



								 



								return false;



								



							});	



			}



		}



					



	}); 







	jQuery("body").on("click", "#add_workouttype", function(event)



	{



		



		var checkedavtivity_id = $('input[name="avtivity_id[]"]:checked').length;







			if(checkedavtivity_id == 1)



			{



				$(".workout_validation_div").css({"display": "none"});



			}



			else



			{



				$(".workout_validation_div").css({"display": "block"});



			}



				



    });











	 //Nutrition code



	 $("body").on("change",".nutrition_check",function(){



		var id = $(this).attr('id');					



			



		if($(this).is(":checked"))



		{			 



			



			var id = $(this).attr('id');



				



			var string = '';



			string += '<div class="nutrition_add "><textarea class="form-control validate[required,custom[address_description_validation]] description_details" maxlength="150" name="'+id+'" id="valtxt_'+id+'"></textarea></div>';



			$("#txt_"+id).html(string);



			 



		}



		 else



		{



		



			var id = $(this).attr('id');



			



			var string = '';



				$("#txt_"+id).html(string);



		}



	 });



	 function add_nutrition(activity,id)



	 {



		 var string = '';



		 var sets = '';



		 var reps = '';



		 var nutrition = '';



		 //comment this line for validation time issue.



		 nutrition = $("#valtxt_"+id).val();



		var result = ''; 



		while (nutrition.length > 0) 



		{ 



	       result += nutrition.substring(0, 60) + '\n'; 



		   nutrition = nutrition.substring(60); 



	    }



		 string += "<div class='form-group width_100_per_left_res'>";



				string += '<label id="'+id+'" class="col-md-2 nutrition_title  control-label width_45_per_res rtl_lebal_margin_top_7px font_bold">'+activity+'</label>';		



				string += '<div class="col-md-10 nutrition_value padding_top_7 width_55_per_res" id="value_'+id+'">'+result+'</div>';				



			string += '</div>';



		 



		 return string;



	 }



	function nutrition_list(day,activity,id,response)



	{



		var string = '';



		string += "<div class='activity nutrisition_activity_box col-md-12 ' id='block_"+id+"'>";	



			string += "<div class='form-group nutrition_head'>";



			string += "<div class='row'>";



				string += '<div class="col-md-10 width_90_per_res font_bold gmgt_nutrition_size"> '+ language_translate.nutrition_schedule_details_lable +'</div>';



				string += "<div id='"+id+"' class='removethis col-md-2 width_10_per_res'><span class='badge badge-delete pull-right'>X</span></div>";



			string += '</div>';	



			string += '</div>';	



			string += "<div class='form-group'>";



				string += "<div class='row'>";



					string += '<label class="col-md-2 col-sm-2 col-lg-2 col-xs-2 width_25_per_res control-label font_bold rtl_lebal_margin_top_7px">'+ language_translate.days_lable +' :</label>';		



					string += '<div class="col-md-10 col-sm-10 col-lg-10 col-xs-10 width_75_per_res padding_top_7 padding_left_opx nutrition_res_left_12px">'+day+'</div>';



				



				string += '</div>';



			string += '</div>';



			string += "<div class='form-group padding_bottom_7 nutrition_design_res'>";



			string += activity;



			string += '</div>';



			string += "<div class='form-group'>";



				string += '<div class="offset-sm-2 col-lg-8 col-md-8 col-sm-8 col-xs-12">'+ response+'</div>';



			string += '</div>';	



			



		string += "</div'>";  



		return string;



	}



	jQuery("body").on("click", "#add_nutrition", function(event)



	{



	/* 	alert("Aaa");



		return false; */



		var valid = jQuery('#nutrition_form').validationEngine('validate');



		if (valid == true) 



		{



			var checkedday = $('input[name="day[]"]:checked').length;

			

			var checkedavtivity_id = $('input[name="avtivity_id[]"]:checked').length;


			if(checkedday == 0){
				alert('Please Select Atleast One Day.');

				return false;
			}
			else if (checkedday>0 && checkedavtivity_id>0)
			{			



				var count = $("#display_nutrition_list div").length;	



				



				var day = '';



				var activity = '';



				var check_val = '';



				var jsonObj1 = [];



				var jsonObj2 = [];



				var jsonObj = [];



				



				$(":checkbox:checked").each(function(o)



				{			



					  var chkID = $(this).attr("id");

					
					  var check_val = $(this).attr("data-val");

					  

						



					  if(check_val == 'day')



					  {						 



						  day += add_day(chkID,chkID);



						 var item = {}



							item ["day_name"] =chkID;		       







							jsonObj1.push(item);							



					  }



					  if(check_val == 'nutrition_time')



					  {



						var  activity_name = $(this).attr("id");



						if(activity_name == 'dinner')



						{



							activity_name = ''+ language_translate.dinner_lable +' :';



						}



						if(activity_name == 'breakfast')



						{



							activity_name = ''+ language_translate.breakfast_lable +' :';



						}



						if(activity_name == 'lunch')



						{



							activity_name = ''+ language_translate.lunch_lable +' :';



						}



						if(activity_name == 'midmorning_snack')



						{



							activity_name = ''+ language_translate.midmorning_snack_lable +' :';



						}



						if(activity_name == 'afternoon_snack')



						{



							activity_name = ''+ language_translate.afternoon_snack_lable +' :';



						}



						  item = {};				  



							item ["activity"] = {"activity":activity_name,"value":$("#valtxt_"+chkID).val()};



						  activity += add_nutrition(activity_name,chkID);



						  



							jsonObj2.push(item);



							



					  }



					  $(this).prop('checked', false);					 



					 



					  /* ... */



					  jsonObj = {"days":jsonObj1,"activity":jsonObj2};



					});



				 



				 var curr_data = {



							action: 'MJ_gmgt_add_nutrition',



							data_array: jsonObj,			



							dataType: 'json'



							};					



							$.post(gmgt.ajax, curr_data, function(response) {



								



								 var list_workout =  nutrition_list(day,activity,count,response);						 

								

								 $("#display_nutrition_list").html('');						



								 $("#display_nutrition_list").append(list_workout);						



								 $('.description_details').val('');						 



								$(".description_details").css("display", "none");



								return false;


							});	

							return false;

			}
			
			
		}



	}); 



	

	 jQuery("body").on("click", ".removenutrition", function(event){



			//if(confirm("Are you sure you want to delete this?"))



			if(confirm(language_translate.removenutrition_delete_record_alert))



				{



			 var chkID = $(this).attr("id");



			



			 var curr_data = {



						action: 'MJ_gmgt_delete_nutrition',



						workout_id: chkID,			



						dataType: 'json'



						};



						



						$.post(gmgt.ajax, curr_data, function(response) {



							$(".workout_"+chkID).remove();



							



							return false;



							



						});	



				}



		 });



	//--------display today workouts---------------	



	 jQuery("body").on("change", "#member_list,#record_date", function(event){


		var selection = $("#record_date").val();

		var uid = $('#member_list').val();

	
			var curr_data = {



					action: 'MJ_gmgt_today_workouts',



					record_date: selection,			



					uid: uid,			



					dataType: 'json'



					};



					$.post(gmgt.ajax, curr_data, function(response) {

					$('.workout_area').html(response);	



					});						



					



	});



	 



	 $("body").on("click", ".view-measurement-popup", function(event){



			







		  event.preventDefault(); // disable normal link function so that it doesn't refresh the page



		  var docHeight = $(document).height(); //grab the height of the page



		  var scrollTop = $(window).scrollTop();



		  var user_id  = $(this).attr('data-val');



			var page_action  = $(this).attr('page_action');



		   var curr_data = {



		 					action: 'MJ_gmgt_measurement_view',



		 					user_id: user_id,		 	



		 					page_action: page_action,		 					



		 					dataType: 'json'



		 					};	 	



										



		 					$.post(gmgt.ajax, curr_data, function(response) { 	



		 						



		 					$('.popup-bg').show().css({'height' : docHeight});							



							$('.invoice_data').html(response);	



							return true; 					



		 					});	



		



	  });



	 



	 $("body").on("click", ".measurement_delete", function(event){



			







		  event.preventDefault(); // disable normal link function so that it doesn't refresh the page



		  var docHeight = $(document).height(); //grab the height of the page



		  var scrollTop = $(window).scrollTop();



		  var measurement_id  = $(this).attr('data-val');



		 



		  if(confirm(language_translate.measurement_workout_delete_record_alert))



			  {



		   var curr_data = {



		 					action: 'MJ_gmgt_measurement_delete',



		 					measurement_id: measurement_id,		 					



		 					dataType: 'json'



		 					};	 	



										



		 					$.post(gmgt.ajax, curr_data, function(response) 



							{ 	



		 					$("tr#row_"+measurement_id).remove();



							$("#measurement_div").addClass("display_block");



							$("#measurement_div").removeClass("display_none_m");



							return true; 					



		 					});



			  }



		



	  });	 



	 jQuery("body").on("change", "#begin_date", function(event)



	 {



		var start_date = $("#begin_date").val();



		 var membership_id = $('#membership_id').val();



		



		 $('#end_date').val("Loading....");



		



		var optionval = $(this);



		var curr_data = {



		action: 'MJ_gmgt_load_enddate',



		start_date: start_date,			



		membership_id: membership_id,			



		dataType: 'json'



		};



		$.post(gmgt.ajax, curr_data, function(response) {



			//alert(response);



			//return false;



		 var date = response.replace("z", '');



			$('#end_date').val(date);



			$('#end_date').attr('readonly', 'true');					



		});



	});



	/* RENEW & UPGRADE LOAD END DATE */

	jQuery("body").on("change", "#membership_id", function(event)



	 {



		var start_date = $("#start_date").val();



		 var membership_id = $('#membership_id').val();



		 $('#after_date').val("Loading....");



		var optionval = $(this);



		var curr_data = {



		action: 'MJ_gmgt_load_enddate_frontend',



		start_date: start_date,			



		membership_id: membership_id,			



		dataType: 'json'



		};



		$.post(gmgt.ajax, curr_data, function(response) {



			//alert(response);



			//return false;



		 var date = response.replace("z", '');



			$('#after_date').val(date);



			$('#after_date').attr('readonly', 'true');					



		});



	});



	$("body").on("change",".payment_membership_detail",function(){

		 var attributeValue = $(this).attr('type');
		 var membership_id = $(this).val();
		 $('#total_amount').val("Loading....");

			var optionval = $(this);

			var curr_data = {

			action: 'MJ_gmgt_paymentdetail_bymembership',

			type: attributeValue,
			
			membership_id: membership_id,			

			dataType: 'json'

			};
			$.post(gmgt.ajax, curr_data, function(response) 
			{
				var payment_data = $.parseJSON(response);		
				$("#begin_date").val('');
				$("#end_date").val('');
				$("#end_date").val('');
				$("#total_amount").val(payment_data.price);
				
				//For Renew Memberhsip Plan for member//
				$('.user_coupon').val('');
				$('#coupon_discount').val('');
				$('#coupon_code').val('');
				$(".coupon_span").css("display", "none");
				$(".payment_detail_span").css("display", "none");
				
				$(".tax_amount").val(payment_data.tax_amount);
				$(".final_amount").val(payment_data.total_amount);
				//End For Renew Memberhsip Plan for member//
				
			});
	});
	//Payment Module pop up
	 $("body").on("click", ".show-payment-popup", function(event)
	 {



			  event.preventDefault(); // disable normal link function so that it doesn't refresh the page



			  var docHeight = $(document).height(); //grab the height of the page



			  var scrollTop = $(window).scrollTop();



			  var idtest  = $(this).attr('idtest');



			  var view_type  = $(this).attr('view_type');



			  var due_amount  = $(this).attr('due_amount');	



			  var member_id  = $(this).attr('member_id');	


			



			   var curr_data = {



			 					action: 'MJ_gmgt_member_add_payment',



			 					idtest: idtest,



			 					view_type: view_type,



								due_amount: due_amount,



								member_id: member_id,



			 					dataType: 'json'



			 					};	 	



												



			 					$.post(gmgt.ajax, curr_data, function(response) { 	



			 							 



			 					$('.popup-bg').show().css({'height' : docHeight});							



								$('.invoice_data').html(response);	



								return true; 					



			 					});	



			



		  });



	$("body").on("click", ".show-view-payment-popup", function(event){



				







			  event.preventDefault(); // disable normal link function so that it doesn't refresh the page



			  var docHeight = $(document).height(); //grab the height of the page



			  var scrollTop = $(window).scrollTop();



			  var idtest  = $(this).attr('idtest');



			  var view_type  = $(this).attr('view_type');			  



			  		  



				  var curr_data = {



			 					action: 'MJ_gmgt_member_view_paymenthistory',



			 					idtest: idtest,



			 					view_type1: view_type,



			 					dataType: 'json'



			 					};	 	



													



			 					$.post(gmgt.ajax, curr_data, function(response) { 	



			 															



			 					$('.popup-bg').show().css({'height' : docHeight});							



								$('.invoice_data').html(response);	



								return true; 					



			 					});	



			



		  });



	var membertype=$("#member_type").val();	  



	if(membertype=='Prospect'){



			$('#non_prospect_area').hide();	



		}



		else



		{



			$('#non_prospect_area').show();	



		}



	$("body").on("change","#member_type", function(){



		var optionval = $(this).val();



		if(optionval=='Prospect'){



			$('#non_prospect_area').hide();	



		}



		else



		{



			$('#non_prospect_area').show();	



		}



	});



		  



	/*---------Verify licence key-----------------*/



	$("body").on("click", "#varify_key", function(event){



	$(".gmgt_ajax-img").show();



	$(".page-inner").css("opacity","0.5");



	  event.preventDefault(); // disable normal link function so that it doesn't refresh the page



		var res_json;



	  var licence_key = $('#licence_key').val();



	  var enter_email = $('#enter_email').val();



	



	   var curr_data = {



	 		action: 'MJ_gmgt_verify_pkey',



	 		licence_key : licence_key,



	 		enter_email : enter_email,



	 		dataType: 'json'



	 	};	



		



		$.post(gmgt.ajax, curr_data, function(response) { 						



	 		res_json = JSON.parse(response);



			$('#message').html(res_json.message);



				$("#message").css("display","block");



				$(".gmgt_ajax-img").hide();



				$(".page-inner").css("opacity","1");



				if(res_json.gmgt_verify == '0')



				{



					window.location.href = res_json.location_url;



				}



				return true; 					



	 		});		



	});







//for membership update







$("body").on("change", ".tog ", function(event){	



	event.preventDefault(); // disable normal link function so that it doesn't refresh the page



	var res_json;



	var timeperiod = $(this).val();



		



	if(timeperiod=='unlimited'){		



		$('#on_of_member_box').empty();		



		$('#member_limit').empty();		



	}



	else



	{		



		var curr_data = {



			action: 'MJ_gmgt_timeperiod_for_class_member',



			timeperiod : timeperiod,	 	



			dataType: 'json'



		 };	



											



		$.post(gmgt.ajax, curr_data, function(response) {		 	



			$('#member_limit').html(response);	



			return true; 					



		});	



	}



});























$("body").on("change", ".classis_limit ", function(event){	



	event.preventDefault(); // disable normal link function so that it doesn't refresh the page



	var res_json;



	var timeperiod = $(this).val();







	if(timeperiod=='unlimited'){



		$('#on_of_classis_box').empty();



		$('#classis_limit').empty();



	}



	else



	{



		var curr_data = {



			action: 'MJ_gmgt_timeperiod_for_class_number',



			timeperiod : timeperiod,	 	



			dataType: 'json'



		};	



										



		$.post(gmgt.ajax, curr_data, function(response) {		 	



			$('#classis_limit').html(response);			



			return true; 					



		});



	}



		



});















$("body").on("change", "#membership_id ", function(event){		



	event.preventDefault(); // disable normal link function so that it doesn't refresh the page



	var res_json;



	var membership_id = $(this).val();



	var membership_hidden = $('.membership_hidden').val();



	var categCheck = jQuery('#classis_id').multiselect();	



	if(membership_id!="")



	{		



		var curr_data = {



			action: 'MJ_gmgt_get_class_id_by_membership',



			membership_id : membership_id,	 	



			membership_hidden : membership_hidden,	 	



			dataType: 'json'



		};	



											



		$.post(gmgt.ajax, curr_data, function(response) 



		{			



			if(response == 1)



			{				



				alert(language_translate.membership_member_limit_alert);



				$('#membership_id').val('');	



				$('#classis_id').html('');		



				$('#classis_id_front').html('');	



				categCheck.multiselect('rebuild');						



			}



			else



			{					

			

				$('#classis_id').html('');	



				$('#classis_id').html(response);	



				$('#classis_id_front').html('');	



				$('#classis_id_front').html(response);	



					

				$('#classis_id_front').multiselect(

				{

					rebuild : 'rebuild',

					nonSelectedText :'Select Class',

					includeSelectAllOption: true,

					allSelectedText :'All Selected',

					selectAllText : 'Select all',

					templates: {

							button: '<button class="multiselect btn btn-default dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><span class="multiselect-selected-text"></span><b class="caret"></b></button>',

						},

					buttonContainer: '<div class="dropdown" />'

				}).multiselect('rebuild');

				// $('#classis_id_front').multiselect('rebuild');		

				categCheck.multiselect('rebuild');		



			}



			return true; 					



		});



	}



	else



	{



		$('#classis_id').html('');	



		categCheck.multiselect('rebuild');		



		return true; 



	}



});











$("body").on("change", "#membership_id ", function(event){		



	event.preventDefault(); // disable normal link function so that it doesn't refresh the page



	var res_json;



	var membership_id = $(this).val();	



	if(membership_id!=""){



	var curr_data = {



		action: 'MJ_gmgt_check_membership_limit_status',



		membership_id : membership_id,	 	



		dataType: 'json'



	};	



										



	$.post(gmgt.ajax, curr_data, function(response) {			



		$('#no_of_class').html(response);			



	});



	}



});







		



	$("#myModal_add_staff_member").scroll(function(){



		$('.dropdown-menu.datepicker').hide();



	});



	



 //count total in store product.



 $("body").on('focus','.total_amount', function (event) {	







	$( this ).blur();



	



		var curr_data = {



	 					action: 'MJ_gmgt_count_store_total',



	 					discount_amount: $('.discount_amount').val(),			



	 							



	 					quantity: $('.quantity').val(),			



	 					Product: $('.Product').val(),			



	 					tax : $('.Tax ').val(),			



	 					dataType: 'json'



	 					};



	 					$.post(gmgt.ajax, curr_data, function(response) {



						$('.total_amount').val(response);	



	 						return true;



					});	



		 



		 return false;



	});  



	



	$("body").on('blur', 'input.quantity', function(event) 	



	{



		$('.save_product').prop('disabled', true	);



		var row_no = $(this).attr('row');



		var product_id=$('.product_id'+row_no).val();



		var quantity=$('.quantity'+row_no).val();



		var myarray = [];	



		if(jQuery.inArray(product_id, myarray) != -1)



		{



			var total=0;



			for(var i=0; i<row_no; i++)



			{



				var new_row=row_no-1;



				if(new_row >= 1)



				{



					var new_quantity=$('.quantity'+new_row).val();



					var total= parseInt(new_quantity) + parseInt(quantity);



				}



			}



		}



		myarray.push(product_id);



		var curr_data = {



				action: 'MJ_gmgt_check_product_stock',		



				product_id:product_id,



				quantity:quantity,



				new_quantity:total,



				row_no:row_no,					



				dataType: 'json'



				};



				



				$.post(gmgt.ajax, curr_data, function(response)



				{



					if(response.trim() == '')



					{



						$('.save_product').prop('disabled', false);



						return true;	



					}



					else



					{



						



						var row_no = response.trim();



						$('.quantity'+row_no).val('');



						alert(language_translate.product_out_of_stock_alert);



						return false;



					}		



					return false;					



				});		 



	});







	$("body").on("change", "#product_id ", function(event)



	{



		var row_no = $(this).attr('row');



		$('.quantity'+row_no).val('');



		return false;			



	});



			



	$("body").on("change", ".notice_for ", function(event)



	{		



		var notice_for = $(this).val();



		if(notice_for == 'member')



		{



			$(".class_div").css("display", "block");



		}



		else



		{



			$(".class_div").css("display", "none");



		}



		return false;			



	});



	$("body").on("change", ".message_to ", function(event)



	{



		var message_to = $(this).val();



		



		if(message_to == 'member')



		{



			 $('#class_list').prop('selectedIndex',0);



			$(".display_class_css").css("display", "block");



		}



		else



		{



			 $('#class_list').prop('selectedIndex',0);



			$(".display_class_css").css("display", "none");



		}		



		return false;			



	});









	// member filter alert message



	$('body').on('click','.member_filter',function()



	{



		var membertype=$('#member_type').val();



		if(membertype == '')



		{



		



			alert(language_translate.select_one_membership_alert);



			return false;				



		}		



		



	});		



	//fronted side image upload then preview hide or show



	jQuery("body").on("change",".image_upload_change",function(){



		var image_preview_url=$(this).val();



		if(image_preview_url == '')



		{



			$(".image_preview_css").css("display", "block");



		}



		else



		{



			$(".image_preview_css").css("display", "none");



		}		



	});		



	$("body").on("change", "#payment_method ", function(event)



	{



		var payment_method = $(this).val();



		



		if(payment_method == 'Cheque' || payment_method == 'Bank Transfer')



		{



			$(".payment_description").css("display", "block");



		}



		else



		{



			$(".payment_description").css("display", "none");



		}		



		return false;			



	});



	//activity category list from activity category type in membership



	jQuery("body").on("change", ".activity_category_list", function(event)



	{ 		



		var action_membership=$('.action_membership').val();



		var membership_id_activity=$('.membership_id_activity').val();



		



		var selected_activity_category_list = [];



        $('.activity_category_list :selected').each(function(i, selected) 



		{ 



            selected_activity_category_list[i] = $(selected).val();



        });



			



		var curr_data = {



					action: 'MJ_gmgt_get_activity_from_category_type',



					selected_activity_category_list: selected_activity_category_list,					



					action_membership: action_membership,					



					membership_id_activity: membership_id_activity,					



					dataType: 'json'



					};	 	



										



					$.post(gmgt.ajax, curr_data, function(response)



					{ 							



						var json_obj = $.parseJSON(response);//parse JSON	



						$('.activity_list_from_category_type').html('');	



						$('.activity_list_from_category_type').append(json_obj);	







						jQuery('.activity_list_from_category_type').multiselect('rebuild');			 	



						



						return true; 					



			});	



				



	});



	// activity category onchange to  specialization staff member list in activity



	jQuery("body").on("change", ".activity_cat_to_staff", function(event)



	{ 



		var activity_category=$(this).val();



				



		var curr_data = {



					action: 'MJ_gmgt_get_staff_member_list_by_specilization_category_type',



					activity_category: activity_category,														



					dataType: 'json'



					};	 	



										



					$.post(gmgt.ajax, curr_data, function(response)



					{ 							



						var json_obj = $.parseJSON(response);//parse JSON	



						$('.category_to_staff_list').html('');	



						$('.category_to_staff_list').append(json_obj);	







						return true; 					



			});	



	});



	//Get member Current membership  Activity list  in Assign Workout//



	jQuery("body").on("change", ".assigned_workout_member_id", function(event)



	{ 



		var member_id=$(this).val();



			



		var curr_data = {



					action: 'MJ_gmgt_get_member_current_membership_activity_list',



					member_id: member_id,														



					dataType: 'json'



					};	 	



										



					$.post(gmgt.ajax, curr_data, function(response)



					{ 		



						var json_obj = $.parseJSON(response);//parse JSON	



						$('.member_workout_activity').html('');	



						$('.member_workout_activity').append(json_obj);	







						return true; 					



			});	



	});



	//Event And task display model



  $("body").on("click", ".show_task_event", function(event)



  {



	



	  event.preventDefault(); // disable normal link function so that it doesn't refresh the page



	  var docHeight = $(document).height(); //grab the height of the page



	  var scrollTop = $(window).scrollTop();



	  var id  = $(this).attr('id') ;



	  var model  = $(this).attr('model') ;



	



	   var curr_data = {



	 					action: 'MJ_gmgt_show_event_task',



	 					id : id,



	 					model : model,



	 					dataType: 'json'



	 					};	



										



	 					$.post(gmgt.ajax, curr_data, function(response) { 	



							



							$('.popup-bg').show().css({'height' : docHeight});



							$('.task_event_list').html(response);	



												



							return true; 					



						});		 



	});



	$("body").on("click", ".event_close-btn", function()



	{		



		$('.popup-bg').hide(); // hide the overlay



	}); 



	jQuery("body").on("change","#chk_sms_sent",function(){



		if($(this).is(":checked"))



		{



			$('#hmsg_message_sent').addClass('hms_message_block');



		}



		 else



		{



			$('#hmsg_message_sent').addClass('hmsg_message_none');



			$('#hmsg_message_sent').removeClass('hms_message_block');



		}



	});



	$("body").on("click","#profile_change",function() 



	{



		var docHeight = $(document).height(); //grab the height of the page



		var scrollTop = $(window).scrollTop();



		var curr_data = {



					action: 'MJ_gmgt_change_profile_photo',



					dataType: 'json'



					};



					$.post(gmgt.ajax, curr_data, function(response) 



					{



						$('.popup-bg').show().css({'height' : docHeight});



						$('.profile_picture').html(response);	



					});



	});



	



	//SMS Message



	jQuery("body").on("change","input[name=select_serveice]:radio",function(){



		var service = $(this).val();



		var curr_data = {



				   action: 'MJ_gmgt_sms_service_setting',



				   select_serveice: service,			



				   dataType: 'json'



				   };					



				   



				   $.post(gmgt.ajax, curr_data, function(response) {	



					   



					   



				   $('#sms_setting_block').html(response);



				   });



   });



	



   $("body").on("click",".importdata",function() 



	{



	var docHeight = $(document).height(); //grab the height of the page



	var scrollTop = $(window).scrollTop();



		var curr_data = {



				action: 'MJ_gmgt_import_data',



				dataType: 'json'



				};					



				



				$.post(gmgt.ajax, curr_data, function(response) {	



				$('.popup-bg').show().css({'height' : docHeight});



					$('.category_list').html(response);	



					$('.patient_data').html(response);	



				});



		});	



	$("body").on("click", ".show-popup", function(event)



	{



		var class_id = $(this).attr('id') ;		



		event.preventDefault(); // disable normal link function so that it doesn't refresh the page



		var docHeight = $(document).height(); //grab the height of the page



		var scrollTop = $(window).scrollTop(); //grab the px value from the top of the page to where you're scrolling



		var curr_data = {



			action: 'MJ_gmgt_create_meeting',



			class_id: class_id,			



			dataType: 'json'



		};



		



		$.post(gmgt.ajax, curr_data, function(response) {



			//alert(response);



			/* console.log(response);



			return false;  */



			$('.popup-bg').show().css({'height' : docHeight});



			$('.create_meeting_popup').html(response);	



		});	



	});







   $("body").on("click", ".show-popup", function(event)



	{



		/*  */



		var meeting_id = $(this).attr('meeting_id') ;	



		/* alert(meeting_id);



		return false; */	



		event.preventDefault(); // disable normal link function so that it doesn't refresh the page



		var docHeight = $(document).height(); //grab the height of the page



		var scrollTop = $(window).scrollTop(); //grab the px value from the top of the page to where you're scrolling



		var curr_data = {



			action: 'MJ_gmgt_view_meeting_detail',



			meeting_id: meeting_id,			



			dataType: 'json'



		};



		



		$.post(gmgt.ajax, curr_data, function(response) {



			//alert(response);



			/* console.log(response);



			return false;  */



			$('.popup-bg').show().css({'height' : docHeight});



			$('.view_meeting_detail_popup').html(response);	



		});	



	});



	







    $("body").on("click", ".show-popup", function(event)



	{



		var class_id = $(this).attr('id') ;		



		event.preventDefault(); // disable normal link function so that it doesn't refresh the page



		var docHeight = $(document).height(); //grab the height of the page



		var scrollTop = $(window).scrollTop(); //grab the px value from the top of the page to where you're scrolling



		var curr_data = {



			action: 'create_meeting',



			class_id: class_id,			



			dataType: 'json'



		};



		



		$.post(gmgt.ajax, curr_data, function(response) {



			//alert(response);



			/* console.log(response);



			return false;  */



			$('.popup-bg').show().css({'height' : docHeight});



			$('.create_meeting_popup').html(response);	



		});	



	});







   $("body").on("click", ".show-popup", function(event)



	{



		var meeting_id = $(this).attr('meeting_id') ;		



		event.preventDefault(); // disable normal link function so that it doesn't refresh the page



		var docHeight = $(document).height(); //grab the height of the page



		var scrollTop = $(window).scrollTop(); //grab the px value from the top of the page to where you're scrolling



		var curr_data = {



			action: 'view_meeting_detail',



			meeting_id: meeting_id,			



			dataType: 'json'



		};



		



		$.post(gmgt.ajax, curr_data, function(response) {



			//alert(response);



			/* console.log(response);



			return false;  */



			$('.popup-bg').show().css({'height' : docHeight});



			$('.view_meeting_detail_popup').html(response);	



		});	



	});



	//------------------ START NEW SUBSCRIPTION -------------------//



	$("body").on("click", ".new_subscription_start", function(event)



	{







	  event.preventDefault(); // disable normal link function so that it doesn't refresh the page



	  var docHeight = $(document).height(); //grab the height of the page



	  var scrollTop = $(window).scrollTop();



	  var member_id  = $(this).attr('member_id');



	  var stripe_plan_id  = $(this).attr('stripe_plan_id');



	  var membership_id  = $(this).attr('membership_id');



	  



		/* alert(member_id);



		alert(stripe_plan_id);



		alert(membership_id);



		return false; */



	   var curr_data = {



		action: 'MJ_gmgt_start_new_subcription',



		member_id: member_id,



		membership_id: membership_id,



		stripe_plan_id: stripe_plan_id,



		dataType: 'json'



		};	 	



								



		$.post(gmgt.ajax, curr_data, function(response) { 	



				 



		$('.popup-bg').show().css({'height' : docHeight});							



		$('.invoice_data').html(response);	



		return true; 					



		});	







	});







	$("body").on("change", ".product_value", function(event)



	{



		



		var product_value = $(this).val();



		var inputs = $(".total_sale_product");



		var class_name = ".product_id";



		



		for(var i = 1; i < inputs.length; i++)



		{



			var all_product_value = $(class_name+i).val();



			if(product_value == all_product_value && inputs.length > 1)



			{



				//alert("You have already selected this product.");



				alert(language_translate.already_selected_this_product);



				$(this).val("");



			}



		}



	});







	//------------------ Change SUBSCRIPTION -------------------//



	$("body").on("click", ".change_subscription", function(event)



	{







	  event.preventDefault(); // disable normal link function so that it doesn't refresh the page



	  var docHeight = $(document).height(); //grab the height of the page



	  var scrollTop = $(window).scrollTop();



	  var sub_id  = $(this).attr('sub_id');



	  var membership_id  = $(this).attr('membership_id');



	  var stripe_customer_id  = $(this).attr('stripe_customer_id');



	  var member_id  = $(this).attr('member_id');



	  var subscription_id  = $(this).attr('subscription_id');



	  var stripe_plan_id  = $(this).attr('stripe_plan_id');



	   var curr_data = {



		action: 'MJ_gmgt_change_subcription',



		member_id: member_id,



		membership_id: membership_id,



		stripe_plan_id: stripe_plan_id,



		stripe_customer_id: stripe_customer_id,



		sub_id: sub_id,



		subscription_id: subscription_id,



		dataType: 'json'



		};	 	



								



		$.post(gmgt.ajax, curr_data, function(response) { 	



				 



		$('.popup-bg').show().css({'height' : docHeight});							



		$('.invoice_data').html(response);	



		return true; 					



		});	







	});



//------------------ Admission Report - load start_date to end_date -----------------------//

   

	jQuery("body").on("change", ".date_type", function(event){	

		if($(this).find(":selected").val()) {

			var date_type = $('.date_type').val();

			

			if(date_type =="period"){

				$(".date_type_div_none").css("display","block");

				var curr_data = {

					action: 'mj_gmgt_admission_repot_load_date',

					date_type: date_type,

					dataType: 'json'

				};

				$.post(gmgt.ajax, curr_data, function(response) {		

					$('#date_type_div').html(response);				

				});

			}

			else{

				$(".date_type_div_none").css("display","none");

			}	

		}

	});



	//---------- FOR TOOLTIP INFORMATION ----------//



	jQuery('[data-toggle="tooltip"]').tooltip({



		"html": true,



		"delay": {"show": 20, "hide": 0},



	});



	$("body").on("change",'.image-preview-show',function(){



	



		filePreview(this);



	



	});



	$("body").on("click",".member_csv_export_alert",function()



	{



		if ($('.smgt_sub_chk:checked').length == 0 )



		{



			alert(language_translate.please_select_atleat_one_record);



			return false;



		}		



	}); 

	$("body").on("click","#product_save_btn",function()

	{

		var product_name = $("#product_name").val();

		var sku_number = $("#product_sku_number").val();

		var product_action = $("#product_action").val();

		var product_id = $("#product_id").val();



		var curr_data = {

			action: 'MJ_gmgt_product_validation',

			product_name: product_name,

			sku_number: sku_number,

			product_action: product_action,

			product_id: product_id,

			dataType: 'json'

		};	 	

	

									

	

		$.post(gmgt.ajax, curr_data, function(response) { 	

			if(response == "1")

			{

				alert("This product name and SKU Number already Use so please enter another product name and SKU Number.");

			}

			if(response == "2")

			{

				alert("This product name already store so please enter another product name.");

			}

			if(response == "3")

			{

				alert("This SKU Number already Use so please enter another SKU Number.");

			}

			return false;

		});	



	}); 

	//---------- FOR ADD FORM LABLE TOP SHOW ----------//



	$("label").addClass("active");







	var number = '';







	$("body").on("click", ".add_activity_category", function()

	{
		number++;


		// var search_value = $("#Activity_category_autocompalte").val();

		var search_value = $(this).text();

		var vall_a= $(".append_array").text().includes(search_value);

		if(vall_a == false)
		{

			$(".append_array").append(search_value.concat(','));

		}

		//var array_val = $(".append_array").text();

		if(vall_a == false)

		{

			var curr_data = {


				action: 'append_activity_by_auto_suggest',


				search_value: search_value,


				number: number,

				dataType: 'json'

			};	 

			$.post(gmgt.ajax, curr_data, function(response) { 


				

				$("#activity_list_append").append(response);

				return false; 	


			});	


		}else{

			alert("You have already selected this workout.");

		}

	});

	$("body").on("click", ".save_member_validate", function()

	{

		var member_name = $('.display-members option').filter(':selected').val();



		if(!member_name)

		{

			alert(language_translate.select_one_member_alert);

			return false;

		}

	});
	
	jQuery('.gmgt_currency_dropdown').on('change',function() 

	{

		

		var gmgt_currency_code = $(this).val();

		

		var curr_data = {

					action: 'MJ_gmgt_get_currency_symbols',

					gmgt_currency_code : gmgt_currency_code,

					dataType: 'json'

					};

					// alert(report_type_id);

					$.post(gmgt.ajax, curr_data, function(response) 

					{

					$('.gmgt_currency_code').html('');

					$(".gmgt_currency_code").append(response);	

				    return true;				

		            });	

	});



	// ===================FOR DASHBOARD MONTHLY INCOME EXPENSE REPORT===========

	

	jQuery('.dash_month_select').on('change',function() 

	{

		

      	var month_key = $(this).find('option:selected').text();

      	var month_value = $(this).find('option:selected').val();

	  

	  	var curr_data = {

						action: 'MJ_gmgt_get_monthly_income_expense',

						month_key : month_key,

						month_value : month_value,

						dataType: 'json'

					};

				

					$.post(gmgt.ajax, curr_data, function(response) 

					{

						$(".das_month_report_div").html(response);	

						$(".income_month_value").text(month_key);	

				    	return true;				

		            });	

	});



	// ===================FOR DASHBOARD YEARLY INCOME EXPENSE REPORT===========



	jQuery('.dash_year_select').on('change',function() 

	{

		

      	// var year_value = $(this).find('option:selected').text();

      	var year_value = $(this).find('option:selected').val();

	  

	  	var curr_data = {

						action: 'MJ_gmgt_get_yearly_income_expense',

						// year_key : year_key,

						year_value : year_value,

						dataType: 'json'

					};

					$.post(gmgt.ajax, curr_data, function(response) 

					{

						$(".das_year_report_div").html(response);	

						$(".income_year_value").text(year_value);	

				    	return true;				

		            });	

    });

	 

	//$(".duration").trigger("change");

	jQuery("body").on("click", ".renew_popup", function(event)



	{

		  event.preventDefault(); // disable normal link function so that it doesn't refresh the page

		  var docHeight = $(document).height(); //grab the height of the page

		  var scrollTop = $(window).scrollTop();

		   var curr_data = {

			action: 'MJ_Renew_popup_data',

			dataType: 'json'

			};

	

			$.post(gmgt.ajax, curr_data, function(response) {



				$('.popup-bg').show().css({'height' : docHeight});



				$('.task_event_list').html(response);	



				return true;

			

			});	

	}); 



	/* DATE LABEL ACTIVE CLASS */

	$(".date_label").addClass("active");

	jQuery("body").on("change", ".date_picker", function()

	{

		$(".date_label").addClass("active");

	});



	$(".coupon_member").css("display", "none");

	$("body").on("change", ".coupon_type ", function(event)



	{

		var coupon_type = $(this).val();



		if(coupon_type == 'individual')

		{

			//  $('#coupon_member_list').prop('selectedIndex',0);



			$(".coupon_member").css("display", "block");

		}



		else

		{



			//  $('#coupon_member_list').prop('selectedIndex',0);



			$(".coupon_member").css("display", "none");



		}		



		return false;			



	});

	

	// APPLY COUPON TO MEMBERSHP PAYMENT
	
	jQuery('.apply_coupon').on('click', function (event) 
	{
		event.preventDefault(); // disable normal link function so that it doesn't refresh the page

		var coupon_code = $('#coupon_code').val();
		var member_id = $('#member_list').val();
		var view_type = $('.view_type').val();
		var membership_id = $('.coupon_membership_id').val();
		var attributeValue = $('.apply_coupon').attr('type');
		var curr_data = {
			action: 'MJ_gmgt_coupon_apply',
			coupon_code:coupon_code,
			member_id:member_id,
			membership_id:membership_id,
			attributeValue: attributeValue,
			view_type: view_type,
			dataType: 'json'
		};
		$.post(gmgt.ajax, curr_data, function(response) 
		{
			var json_obj = $.parseJSON(response);
			if(json_obj[0] == 'error')
			{
				$(".coupon_span").css("display", "block");
				$(".coupon_span").css("color", "red");
				$(".coupon_span").html(json_obj[1]);
				$(".coupon_code").val('')
				$("#coupon_discount").val('');
				$(".payment_detail_span").css("display", "none");
				$(".discount_display").css("display", "none");
			}
			else
			{
				$(".coupon_span").css("display", "none");
				$(".user_coupon").val(json_obj[0]);
				$("#coupon_discount").val(json_obj[1]);
				$(".coupon_span").css("display", "block");
				$(".discount_display").css("display", "block");
				$(".coupon_span").html(json_obj[6]);
				$(".coupon_span").css("color", "green");
				$(".payment_detail_span").css("color", "green");
				$(".payment_detail_span").css("display", "block");
				$(".payment_detail_span").html(json_obj[5]);
				if(view_type == 'renew_upgrade_membership_plan')
				{
					$("#total_amount").val(json_obj[2]);
					$(".tax_amount").val(json_obj[3]);
					$(".final_amount").val(json_obj[4]);
				}
			}
			return true;
		});
	});

	// EXTEND MEMBERSHIP POPUP
	jQuery("body").on("click", ".extend_membership_popup", function(event)
	{
		var member_id = $(this).attr('id');
		event.preventDefault(); // disable normal link function so that it doesn't refresh the page
		var docHeight = $(document).height(); //grab the height of the page



		var scrollTop = $(window).scrollTop();
		var curr_data = {



			action: 'MJ_gmgt_extend_membership_popup',

			member_id: member_id,			


			dataType: 'json'

			};
			$.post(gmgt.ajax, curr_data, function(response) {
				$('.popup-bg').show().css({'height' : docHeight});
				$('.category_list').html(response);
			});	
	});

	// NEW EXTED MEMBERSHIP DATE

	jQuery("body").on("change", "#extend_day", function()
	{
		var days = $(this).val();
		var start_date = $(".membership_end_date").val();
		var end_date = new Date(start_date);
		end_date.setDate(end_date.getDate() + parseInt(days)); // Parse days as an integer
		var formattedEndDate = end_date.getFullYear() + '-' + ("0" + (end_date.getMonth() + 1)).slice(-2) + '-' + ("0" + end_date.getDate()).slice(-2);
		$("#new_end_date").val(formattedEndDate);
		return false;
	});

});

function filePreview(input) {



    if (input.files && input.files[0]) {



        var reader = new FileReader();



        reader.onload = function (e) {



           



            $('#upload_user_avatar_preview img').attr('src',e.target.result);



        };



        reader.readAsDataURL(input.files[0]);



    }



}