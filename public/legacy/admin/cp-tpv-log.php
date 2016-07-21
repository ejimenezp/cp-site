<!DOCTYPE html>
<html>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

<!-- JQUERY -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>


<!-- DATATABLES -->

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/r/bs-3.3.5/jq-2.1.4,dt-1.10.9,b-1.0.3,b-colvis-1.0.3,cr-1.2.0,r-1.0.7,sc-1.3.0,se-1.0.1/datatables.min.css"/>
 
<script type="text/javascript" src="https://cdn.datatables.net/r/bs-3.3.5/jq-2.1.4,dt-1.10.9,b-1.0.3,b-colvis-1.0.3,cr-1.2.0,r-1.0.7,sc-1.3.0,se-1.0.1/datatables.min.js"></script>


<!-- BOOTSTRAP -->

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>


<!-- DATEPICKER JQUERY UI -->

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>


<!--  COOKING-POINT INCLUDES -->

<script src="date.format.js"></script>
<script src="jquery.serializejson.js"></script>
<link rel="icon" href="favicon-admin.ico">


<title>Booking Edit</title>

</head>
<body>

<script type="text/javascript" class="init">

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
	

$(document).ready(function() {

	var booking_param = getQueryVariable("booking");

	$('#tpvlog').dataTable( {
		"ajax": 'cp-json-interface.php?query=TPV_LOG&booking=' + booking_param,
        "columns": [
                    { "data": "ds_order" },
                    { "data": "ds_description" },
                    { "data": "ds_data" },
                    { "data": "ds_amount" },
                    { "data": "ds_response" },
                    { "data": "ds_authorization" },
                    { "data": "ds_last_update" }],
        "order": [[ 6, "asc" ]],
        "columnDefs": [ {"targets": 3, "render": function ( data ) { var x = data / 100; return x;} }]
					 });
} );
	
</script>

<title>CP TVP log</title>

</head>
<body>
   
    				<table id="tpvlog" class="table table-bordered responsive" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>order</th>
							<th>description</th>
							<th>booking</th>
							<th>amount</th>
							<th>response</th>
							<th>auth</th>
							<th>updated</th>
						</tr>
					</thead>
			</table>
</body>
</html>

