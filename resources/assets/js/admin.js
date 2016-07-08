/**
 * 
 */
window.$ = window.jQuery = require('jquery');

require('bootstrap-sass');
require('jquery-serializejson');

require('jquery-ui/datepicker');

$( document ).ready(function() {

    $("#calendar_button").click(function(){
        $("#cp-calendar").toggleClass("hidden");
    });


	
// 	if( $("#activity-type option:selected").attr("shift")=='any') {
// 	    $("#special-calendar-event-data").removeClass('hidden')
// //		var valor = $("#activity-end-shift").attr("shift");
// //		$("#activity-end-shift [shift="+valor+"]").addClass('active');
// 	//		    	$("[value="+valor+"]").prop("checked", true);
// 	}
// 	else {		 
// 	    $("#special-calendar-event-data").addClass('hidden');
// 	}
//    });


});
