/**
 * COOKING POINT ADMIN SCRIPTS
 */


function splitName()
{
	var field = document.forms["rclass_form"]["r[name]"].value;
	var justName = field.split("<")[0];
	if (justName != field)
		{
			var tail = field.split("<")[1];
			var email = tail.split(">")[0];
			document.forms["rclass_form"]["r[name]"].value = justName;
			document.forms["rclass_form"]["r[email]"].value = email;
		}
}
  
function getQueryVariable(variable)
{
       var query = window.location.search.substring(1);
       var vars = query.split("&");
       for (var i=0;i<vars.length;i++) {
               var pair = vars[i].split("=");
               if(pair[0] == variable){return pair[1];}
       }
       return(false);
}


function randomString() {
    var chars = '0123456789abcdefghijklmnopqrstuvwxyz';
	var result = '';
    for (var i = 32; i > 0; --i) result += chars[Math.round(Math.random() * (chars.length - 1))];
    return result;
}


function totalRClass()
{
  console.log('en totalRClass');
  var adults = document.forms["rclass_form"]["r[numAdults]"].value;
  var children = document.forms["rclass_form"]["r[numChildren]"].value;
  var total = 70 * adults + 35 * children;

  (function( $ ) {
	  $("input[name='r[price]']").val(total);
  })( jQuery );
  
  document.getElementById("rclass_cost").innerHTML = total;
}

function addslashes(string) {

    return string.replace(/\\/g, '').
      replace(/\u0008/g, '\\b').
       replace(/\t/g, '\\t').
        replace(/\n/g, '<br\/>').
        replace(/\f/g, '\\f').
        replace(/\r/g, '\\r').
      replace(/'/g, '\\\'').
       replace(/"/g, '\\"');
}

function validate_admin_edit ()
{
	
	/* Check  PRICE */

	  var adults = document.forms["rclass_form"]["r[numAdults]"].value;
	  var children = document.forms["rclass_form"]["r[numChildren]"].value;

	  (function( $ ) {
		  if (!$("input[name='user']").val())
		  {
			  $("input[name='r[price]']").val(70 * adults + 35 * children);
		  }
		  else
			  {
			  $("input[name='r[price]']").val($("input[name='r[price]']").val().replace(/,/g, '.'));
			  }
	  })( jQuery );

	  

	
	/* Check  NAME */
	var fname = document.forms["rclass_form"]["r[name]"];
	var fvalue = fname.value;
	if (fvalue == "" || fvalue == null) 
	{
		alert("Please, provide your name");
		fname.focus;
		return false;
	}

	/* Check  EMAIL */
	var fname = document.forms["rclass_form"]["r[email]"];
	var fvalue = fname.value;
	if (fvalue == "" || fvalue == null) 
	{
		alert("Please, provide your email address");
		fname.focus;
		return false;
	}
    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if (!filter.test(fvalue))
    {
    	alert('Please, provide a valid email address');
    	fname.focus;
    	return false;
    }

	/* Check  PHONE */
	var fname = document.forms["rclass_form"]["r[phone]"];
	var fvalue = fname.value;

    var filter = /^[0-9 \(\)\-\+]+$/ ; 
    if (fvalue != "" && !filter.test(fvalue))
    {
    	alert('Please, check phone number format');
    	fname.focus;
    	return false;
    }

	/* Check  DATE */
	var fname = document.forms["rclass_form"]["r[activityDate]"];
	var fvalue = fname.value;

    var filter = /^[0-9 \(\)\-\+]+$/ ; 
    if (fvalue == "1970-01-01")
    {
    	alert('Please, enter your preferred activity date');
    	fname.focus;
    	return false;
    }
        
	// add slashes to all text fields
	$("input[name='r[name]']").val(addslashes($("input[name='r[name]']").val()));
	$("#emailText").val(addslashes($("#emailText").val()));
	$("#bookingfoodrestrictions").val(addslashes($("#bookingfoodrestrictions").val()));
	$("#bookingcomments").val(addslashes($("#bookingcomments").val()));

    return true;

};

/*
 * CP SCRIPT MAIN BODY
 * To be executed after page is ready
 * 
 * 
 */		

jQuery(document).ready(function($) {
	
	var booking_param = getQueryVariable("booking");
	var form_changed = false;
	
	$( "#example1, hasDatepicker" ).datepicker({ 
                    dateFormat: "DD, d MM yy" ,
					altFormat: "yy-mm-dd",
					altField: "#actDateName"
						});

	if (!booking_param)
	{
		$("#history, h3").hide();
		$("#update_button").html("Create");
	}
	else
	{
		var booking_in_db = false;
		var booking_log;
		var cp_json_url = "cp-json-interface.php?query=ABOOKING&booking=" + booking_param;
		
		$.getJSON(cp_json_url)
			.done(function( json ) {
				booking_in_db = json.booking_in_db;
				if (booking_in_db)
				{
					$("input[name='r[hash]']").val(json.hash);
					$("input[name='r[name]']").val(json.name);
					$("input[name='r[email]']").val(json.email);
				 	$("input[name='r[phone]']").val(json.phone);
				 	$("input[name='r[activityDate]']").val(json.activityDate);
				 	$("#bookingactivity").val(json.activity);
					var aDate = new Date(json.activityDate);
					$("#example1").val(aDate.format("fullDate"));
					$("#bookingstatus").val(json.status);
					$("#bookingnumadults").val(json.numAdults);
					$("#bookingnumchildren").val(json.numChildren);
					$("input[name='r[price]']").val(json.price);
					$("#bookingfoodrestrictions").val(json.foodRestrictions);
					$("#bookingcomments").val(json.comments);
					booking_log = $('#history').DataTable( {
						"responsive": true,
						"ajax": "cp-json-interface.php?query=BOOKING_LOG&booking=" + booking_param,
					    "columns": [
					                { "data": "date", width:"15%" },
					                { "data": "action", width:"15%"},
					                { "data": "details", width:"70%" }]
					});
				}
				else
				{
					alert("Booking not found");
					return;
				}

			})
			.fail(function( jqxhr, textStatus, error ) {
				var err = textStatus + ", " + error;
				console.log( "Request Failed: " + err );
		
			 });
				
	}

	// event handling
	  
	$( "#rclass_form :input" )
	  .change(function () {
	    form_changed = true;});
	  
	$("#update_button").click(function() {
			if (form_changed)
			{
				if (!validate_admin_edit())
				{
					return false;
				}
				if (!booking_param) // new booking
				{
					booking_param = randomString();
					$("#rclass_form input[name='r[hash]']").val(booking_param);
		        	var formdata = JSON.stringify($("#rclass_form").serializeJSON());
		        	$.ajax({
		        	    type: "POST", 
		        	    url: "cp-json-interface.php?query=NEW_BOOKING",
		        	   	data: {form: formdata},
		        	   	accepts: {
		        	        xml: 'text/xml',
		        	        text: 'text/plain'
		        	    },
		        	    async: true,
		        	    success: function(msg){
		        	        alert(msg);
		        	        window.location.href = window.location.href + '?booking=' + booking_param;
		        	        }
		        	    });
	
				}
				else
				{	// update displayed booking
					
		        	var formdata = JSON.stringify($("#rclass_form").serializeJSON());
		        	$.ajax({
		        	    type: "POST", 
		        	    url: "cp-json-interface.php?query=UPDATE_BOOKING&booking=" + booking_param,
		        	   	data: {form: formdata},
		        	    accepts: {
		        	        xml: 'text/xml',
		        	        text: 'text/plain'
		        	    },
		        	    async: true,
		        	    success: function(msg){
		        	        alert(msg);
		    	        	form_changed = false;
		    		        booking_log.ajax.reload();
		        	    }
		        	});
		        }
			}
	});
	
	$("#email_button").click(function() {
		if (form_changed)
		{
			alert("Form changed. Update before emailing");	
		}
		else
		{
			if (!validate_admin_edit())
			{
				return false;
			}
			if (confirm("Send email to "+ $("input[name='r[email]']").val() + " ?"))
			{
				var email_text = $("#emailText").val();
	        	$.ajax({
	        	    type: "POST", 
	        	    url: "cp-json-interface.php?query=SEND_MAIL&booking=" + booking_param,
//	        	   	data: {emailText: $("input[name='r[emailText]']").val()},
	        	   	data: {emailText: email_text},
	        	    async: true,
	        	    success: function(msg){
	        	        alert(msg);
	    		        booking_log.ajax.reload();
	        	    }
	        	});
			}
		}
	});

	$("#confirm_button").click(function() {
		if (form_changed)
		{
			alert("Form changed. Update before confirming");	
		}
		else
		{
			if (!validate_admin_edit())
			{
				return false;
			}
			if ($("#bookingstatus").val() =='CR' && confirm("Send confirmation to "+ $("input[name='r[email]']").val() + " ?"))
			{
				$("#bookingstatus").val('PE');
				var formdata = JSON.stringify($("#rclass_form").serializeJSON());
	        	$.ajax({
	        	    type: "POST", 
	        	    url: "cp-json-interface.php?query=UPDATE_BOOKING&booking=" + booking_param,
	        	    async: false,
	        	   	data: {form: formdata}
	        	    });
	        	var email_text = $("#emailText").val();
	        	$.ajax({
	        	    type: "POST", 
	        	    url: "cp-json-interface.php?query=SEND_MAIL&booking=" + booking_param,
	        	   	data: {emailText: email_text},
	        	    success: function(msg){
	        	        alert(msg);
	    		        booking_log.ajax.reload();
	        	    }
	        	});
			}
		}
	});
	
	
}); // end of jQuery.ready block
	







