jQuery(document).ready(function($) {
	
	var form_changed = false;

	$( "#form_activity :input" )
	  .change(function () {
	    form_changed = true;});

// check if window is a show details or a list of items

	var activity_id = $("#form_activity input[name='id']").val()

	if (activity_id != 0 && typeof activity_id !== "undefined") {
		// populate from database only if is show datails
		var cp_json_url = "/admin/json/activity/" + activity_id;
		
		$.getJSON(cp_json_url)
			.success(function( json ) {
					$("input[name='shortcode']").val(json.shortcode);
					$("input[name='atype']").val(json.atype);
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
			$('#modal_activity_close').modal('show');
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

			var formdata = JSON.stringify($("#form_activity").serializeJSON());
			var url, method;
			if (activity_id == 0) {
				method = 'post' 
				url = "/admin/json/activity"
			} else {
				method ='patch'
				url = "/admin/json/activity/"+ activity_id 
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
			        window.location.href = '/admin/activity';
			        
			        }
				});	
	    }
	});

	$(".button_delete").click(function() {
		activity_id = $(this).data('activity_id')
		$(".modal-footer #activity_id").val( activity_id )
	});

	$("#modal_button_delete").click(function() {
		if (activity_id == null) {
			activity_id = $(this).val('activity_id')
		}

		$.ajax({
		    type: 'delete', 
		    url: "/admin/json/activity/"+ activity_id,
		   	accepts: {
		        xml: 'text/xml',
		        text: 'text/plain'
		    },
		    async: true,
		    success: function(msg){
		        alert(msg);
		        window.location.href = '/admin/activity';
		        }
			});	
	});

});
