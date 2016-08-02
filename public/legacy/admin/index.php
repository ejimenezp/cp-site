<?php include(dirname( __FILE__ ) . '/password_protect.php'); ?>

<!DOCTYPE html>
<html>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

<!-- JQUERY -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>


<!-- DATATABLES -->

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/r/bs-3.3.5/jqc-1.11.3,dt-1.10.9,b-1.0.3,b-colvis-1.0.3,b-html5-1.0.3,b-print-1.0.3,r-1.0.7,rr-1.0.0,sc-1.3.0,se-1.0.1/datatables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/r/bs-3.3.5/jqc-1.11.3,dt-1.10.9,b-1.0.3,b-colvis-1.0.3,b-html5-1.0.3,b-print-1.0.3,r-1.0.7,rr-1.0.0,sc-1.3.0,se-1.0.1/datatables.min.js"></script>

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
<script src="cp-admin-scripts.js"></script>
<script src="jquery.dataTables.columnFilter.js"></script>
<link rel="stylesheet" href="cp-admin.css">

<link rel="icon" href="favicon-admin.ico">




<script type="text/javascript" class="init">


$(document).ready(function() {
	
		$('#example').dataTable( {
		"responsive": true,
		"autoWidth": false,
		"ajax": 'cp-json-interface.php?query=ALL_BOOKINGS',		
		"columns": [
                    { "data": "creationDate", width:"15%" },
                    { "data": "name", width:"30%"  },
                    { "data": "email" , "className":"none" },
                    { "data": "activity", width:"10%" },
                    { "data": "activityDate", width:"15%"},
                    { "data": "status", width:"5%" },
                    { "data": "numAdults", width:"5%" },
                    { "data": "numChildren", width:"5%" },
                    { "data": "price", width:"5%" },
                    { "data": "paymentDate", width:"15%" },
                    { "data": "foodRestrictions", "className":"none"  },
                    { "data": "comments", "className":"none"  },
                    { "data": "hash", "className":"none" }],
        "order": [[ 0, "desc" ]],
        "columnDefs": [
					{"targets": 0, "render": function ( data, type, row ) { var d = new Date(data.split(" ")[0]+'T'+data.split(" ")[1]); if (type === 'display') return d.format("dd mmm - H:MM"); else return data;} },
					{"targets": 9, "render": function ( data, type, row ) {   
																			if (data != null) 
																			{
																				var str = data.split(" ")[0]+'T'+data.split(" ")[1];
																				var d = new Date(str); 
																				return d.format("dd mmm H:MM");
																			} 
																			else 
																			{ 
																				return "-";	
																			}
																		} },
					{"targets": [1, 5], "render": function ( data, type, row ) { return '<a target="cp-edit-booking" href="cp-edit-booking.php?booking=' + row['hash'] + '">'+data+'</a>' ;} },
           			{"targets": 4, "render": function ( data, type, row ) { var d = new Date(data); if (type === 'display') return d.format("dd mmm -- ddd"); else return data;} }]
		 })
        .columnFilter({
	        sPlaceHolder: "head:before",
	        aoColumns: [ 
	                    null,
	                    null,
	                    null,
	                    null,
	                    null,
	                    { type: "select", values: [ 'CR', 'NE', 'PE', 'PA', 'CA']},
	                    null,
	                    null,
	                    null,
	                    null,
	                    null,
	                    null,
	                    null ]});

		
} );

</script>

<title>CP Bookings Admin Page</title>

</head>
<body>

<h3>Bookings Admin</h3>

		<table id="admin_form_button" class="cp-full-width"><tr>
			 <td style="margin:auto"><button class="myButton" onclick="location.href='/legacy/admin/cp-edit-booking.php'">New Booking</button></td>


    				<table id="example" class="table table-bordered dt-responsive" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>Creation</th>
							<th>Name</th>
							<th>Email</th>
							<th>Act</th>
							<th>Date</th>
							<th>Status</th>
							<th>Adults</th>
							<th>Child</th>
							<th>Price</th>
							<th>PayDate</th>
							<th>Food</th>
							<th>Comments</th>
							<th>Hash</th>
							</tr>
					</thead>

				</table>
</body>
</html>


