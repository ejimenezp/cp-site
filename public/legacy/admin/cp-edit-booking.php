<?php include(dirname( __FILE__ ) . '/password_protect.php'); ?>

<!DOCTYPE html>
<html>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport"
	content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

<!-- JQUERY -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<!-- DATATABLES -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/r/bs-3.3.5/jqc-1.11.3,dt-1.10.9,b-1.0.3,b-colvis-1.0.3,b-html5-1.0.3,b-print-1.0.3,r-1.0.7,rr-1.0.0,sc-1.3.0,se-1.0.1/datatables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/r/bs-3.3.5/jqc-1.11.3,dt-1.10.9,b-1.0.3,b-colvis-1.0.3,b-html5-1.0.3,b-print-1.0.3,r-1.0.7,rr-1.0.0,sc-1.3.0,se-1.0.1/datatables.min.js"></script>

<!-- BOOTSTRAP 	-->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

<!-- DATEPICKER JQUERY UI -->
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

<!--  COOKING-POINT INCLUDES -->
<script src="date.format.js"></script>
<script src="jquery.serializejson.js"></script>
<script src="cp-admin-scripts.js"></script>
<link rel="stylesheet" href="cp-admin.css">

<link rel="icon" href="favicon-admin.ico">


<title>One Booking Edit</title>

</head>
<body>

<?php 

function get_param( $val, $default = "")
{
	$var = isset( $_REQUEST[$val] ) ? $_REQUEST[$val] : $default;
	return $var;
}

?>
<div class="container-fluid">

<h3>One Booking Edit</h3>

<p><strong>Email text:</strong> (only for bookings with status PENDING)</p>
	<textarea name="r[emailText]" id="emailText" class="cp-full-width" rows="4" >
Thank you for your confidence. We have availability for the class detailed below. Please, proceed with the payment to secure your seat/s.

</textarea>

	
<form method="post" id="rclass_form" class="cp-admin cp-full-width" >
	<input name="r[type]" type="hidden" value="REGULAR_CLASS" > 
	<input name="r[activityDate]" id="actDateName" type="hidden" value="1970-01-01"> 
	<input name="r[hash]" type="hidden" value=<?php echo get_param('booking'); ?> > 
	<input name="user" type="hidden" value="admin">
	
<table id="" class="cp-full-width">
				<tr>
				<td class="cp-td-third"><strong>Name:</strong><br />
					<input name="r[name]" type="text" value="" onchange="splitName()" style="width:100%"></td>
				<td class="cp-td-third"><strong>Email:</strong><br />
					<input name="r[email]" type="text" value="" style="width:100%"></td>
				<td class="cp-td-third"><strong>Phone:</strong><br />
					<input name="r[phone]" type="text" value="" style="width:100%"></td>
			</tr>

			<tr>
				<td class="cp-td-third"><strong>Activity:</strong><br />
					<select id="bookingactivity" name="r[activity]" class="cp-full-width" >
<?php
	require_once dirname( __FILE__ ) .'/model.php';
	
	$acts = retrieve_activities(TRUE);
	foreach ( $acts as $a ) {
		echo '<option value="' . $a [shortcode] . '">' . $a [activity] . '</option>';
	}
?>
					</select></td>
				<td class="cp-td-third"><strong>Date:</strong><br />
				<input type="text" id="example1" name="dummy" class="cp-full-width"></td>				
				<td class="cp-td-third"><strong>Status:</strong><br />
				<select id="bookingstatus" name="r[status]">
					<option value="CR">CR</option>
					<option value="NE">NE</option>
					<option value="PE">PE</option>
					<option value="PA">PA</option>
					<option value="DE">DE</option>
				</select></td>				
				</tr>
			<tr>
				<td class="cp-td-third"><strong>Adults:</strong><br />
					<select id="bookingnumadults" name="r[numAdults]" onclick="totalRClass()" >
<?php
	for($x = 1; $x <= 30; $x ++) {

			echo '<option value="' . $x . '">' . $x . '</option>';
	}
?>
								</select></td>
				<td class="cp-td-third"><strong>Children:</strong><br />
					<select id="bookingnumchildren" name="r[numChildren]" onclick="totalRClass()">
<?php
	for($x = 0; $x <= 10; $x ++) {
		echo '<option value="' . $x . '">' . $x . '</option>';
	}
?>
					</select></td>
				<td class="cp-td-third"><strong>Price (EUR):</strong><br />
					<input name="r[price]" type="text" id="rclass_cost" value="70" ></td>
			</tr>
		</table>

		<table class="cp-full-width" >
			<tr>
				<td class="cp-td-half"><strong>Food restrictions:</strong><br />
					<textarea id="bookingfoodrestrictions" name="r[foodRestrictions]" class="cp-full-width"></textarea>	 </td>   
				<td class="cp-td-half"><strong>Comments:</strong><br />
					<textarea id="bookingcomments" name="r[comments]" class="cp-full-width"></textarea></td>   
			</tr>
		</table>
</form>
		<table id="admin_form_button" class="cp-full-width"><tr>
			 <td style="margin:auto"><button class="myButton" id="confirm_button">Confirm</button></td>
			 <td style="margin:auto"><button class="myButton" id="update_button">Update</button></td>
			 <td style="margin:auto"><button class="myButton" id="email_button">Email</button></td>
			 <td style="margin:auto"><button class="myButton" onclick="location.href='cp-tpv-log.php?booking=<?php echo get_param('booking'); ?>'">TPV Log</button></td>
			 </tr>
		</table>

   <h3>History</h3>
   
      
<table id="history" class="table table-bordered" >
<thead><tr>
	<th>DateTime</th>
	<th>Action</th>
	<th>Details</th>
</tr></thead>
</table>
   
</div>
</body>
</html>


