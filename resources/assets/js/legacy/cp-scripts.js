/**
 * 
 */
window.$ = window.jQuery = require('jquery')
require('jquery-ui/datepicker');

jQuery(document).ready(function($) {

	$( "#example1" ).datepicker({ 
		dateFormat: "DD, d MM yy" ,
		minDate: 0,
		altFormat: "yy-mm-dd",
		altField: "#actDateName",
		// beforeShowDay: function(date) {
		// 	var day = date.getDay();
		// 	// If day == 0 then it is Sunday
		// 	if (day == 0) { return [false,"", 'No class on Sundays'] ; } 
	 //        }
	 });

	jQuery.extend(jQuery.datepicker,{_checkOffset: function(inst, offset, isFixed){offset.top = offset.top+10; return offset;}});

	$("#send_button").click(function() {

		if (!validate_rclass())
		{
			return false;
		}
	});

	$("#bookingnumchildren, #bookingnumadults").click(function() {

		var adults = $("#bookingnumadults").val();
		var children = $("#bookingnumchildren").val();
		var total = 70 * adults + 35 * children;

		$("#rclass_cost").html(total);
	
	});

});  // end jQuery

// function DisableSundays(date)
// {
// 	  var day = date.getDay();
// 	 // If day == 0 then it is Sunday
// 	 if (day == 0)
// 	 {
// 		 return [false] ; 
// 	 } 
// 	 else
// 	 {  
// 		 return [true] ;
// 	 }
// }


  
function randomString() {
    var chars = '0123456789abcdefghijklmnopqrstuvwxyz';
	var result = '';
    for (var i = 32; i > 0; --i) result += chars[Math.round(Math.random() * (chars.length - 1))];
    return result;
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


function validate_rclass ()
{
	
	/* Check  PRICE */

	  var adults = document.forms["rclass_form"]["r[numAdults]"].value;
	  var children = document.forms["rclass_form"]["r[numChildren]"].value;

	if (!$("input[name='user']").val())
	{
	  $("input[name='r[price]']").val(70 * adults + 35 * children);
	}

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
	$("#bookingfoodrestrictions").val(addslashes($("#bookingfoodrestrictions").val()));
	$("#bookingcomments").val(addslashes($("#bookingcomments").val()));

	var hash = randomString();
	$("input[name='r[hash]']").val(hash);

	var new_url = window.location.href.split("bookings")[0] + "bookings/" + hash;
	document.rclass_form.action = new_url;
	document.rclass_form.submit();

};
