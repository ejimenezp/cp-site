function goBack() {
    window.history.back();
}

jQuery(document).ready(function($) {

// tooltips

    $( document ).tooltip({
      show: {
        effect: "explode",
        delay: 0 }
  	});



	// datepickers stuff
	$( "#from" ).datepicker({
        dateFormat: "DD, d MM yy" ,
		altFormat: "yy-mm-dd",
		altField: "#star_date",
	  	firstDay: 1,
 	  	language: 'en',
 	  	onClose: function( selectedDate ) { $( "#to" ).datepicker( "option", "minDate", selectedDate );
      }

	});
	
	$( "#to" ).datepicker({
        dateFormat: "DD, d MM yy" ,
		altFormat: "yy-mm-dd",
		altField: "#end_date",
	  	firstDay: 1,
 	  	language: 'en',
 	  	onClose: function( selectedDate ) { $( "#from" ).datepicker( "option", "maxDate", selectedDate );
      }

	});
	var form_changed = false;

	$( "#form_calendarevent :input" )
	  .change(function () {
	    form_changed = true;});

// check if window is a show details or a list of items

	var id = $("#form_calendarevent input[name='id']").val()

	if (id != 0 && typeof id !== "undefined") {
		// populate from database only if is show datails
		var cp_json_url = "/admin/json/calendarevent/" + id;
		
		$.getJSON(cp_json_url)
			.success(function( json ) {
					$("input[name='id']").val(json.id);
					$("input[name='start_date']").val(json.start_date);
					$("input[name='start_time']").val(json.start_time);
					$("input[name='start_shift']").val(json.start_shift);
					$("input[name='end_date']").val(json.end_date);
					$("input[name='end_time']").val(json.end_time);
					$("input[name='end_shift']").val(json.end_shift);
					$("input[name='activity_id']").val(json.activity_id);
					$("input[name='status'][value="+json.status+"]").prop("checked", true);
					$("input[name='comments']").val(json.comments);
					$("input[name='registered']").val(json.registered);
				})
			.fail(function( jqxhr, textStatus, error ) {
				var err = textStatus + ", " + error;
				console.log( "Request Failed: " + err );
			});	
	}


	// buttons 

	$("#button_close").click(function() {
		if (form_changed)
		{
			$('#modal_calendarevent_close').modal('show');
		}
		else
		{
			history.back();
		}
	});

	$("#button_save, #modal_button_save").click(function() {
		if (form_changed) {
			// if (!validate_admin_edit())
			// {
			// 	return false;
			// }

			var formdata = JSON.stringify($("#form_calendarevent").serializeJSON());
			var url, method;
			if (id == 0 || typeof id === "undefined") {
				method = 'post' 
				url = "/admin/json/calendarevent"
			} else {
				method ='patch'
				url = "/admin/json/calendarevent/"+ id 
			}
			$.ajax({
			    type: method, 
			    url: url,
			   	data: {form: formdata},
			   	accepts: {
			        xml: 'text/xml',
			        text: 'text/plain'
			    },
			    async: true,
			    success: function(msg){
			        alert(msg);
			        window.location.href = '/admin/calendar/'+ $("input[name='start_date']").val();
			        
			        }
				});	
	    }
	});

	$(".button_delete").click(function() {
		ce_id = $(this).data('ce_id')
		start_date = $(this).data('start_date')
		$(".modal-footer #ce_id").val( ce_id )
		$(".modal-footer #start_date").val( start_date )
	});

	$("#modal_button_delete").click(function() {
		if (ce_id == null) {
			ce_id = $(this).val('ce_id')
			start_date = $(this).val('start_date')
		}

		$.ajax({
		    type: 'delete', 
		    url: "/admin/json/calendarevent/"+ ce_id,
		   	accepts: {
		        xml: 'text/xml',
		        text: 'text/plain'
		    },
		    async: true,
		    success: function(msg){
		        alert(msg)
		        window.location.href = '/admin/calendar/' + start_date
		        }
			});	
	});

});
