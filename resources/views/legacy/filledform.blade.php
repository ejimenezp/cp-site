@extends('masterlayout')

@section('title', 'Booking Form for Cooking School Madrid, Spain: Spanish cuisine courses')
@section('description', 'Cooking courses school schedules and contact form: cooking classes calendar in madrid, Spain. Plan your cooking school vacations.')

@section('content')

<div class="row">
	<div class="col-sm-12">

@if ($status == 'ERROR')
	<h1>Bookings</h1>
	<div class="alert alert-danger">Unexpected Error: Please try later or contact info@cookingpoint.es</div>

@elseif ($status == 'WRONG_ID')
	<h1>Your Booking</h1>
	<div class="alert alert-danger">Wrong booking ID: it does not correspond to any booking</div>

@elseif ($status == 'OK')
	<h1>Your Booking</h1>
	<div class="alert alert-success">Payment received. Thank you!</div>

@elseif ($status == 'KO')
	<h1>Your Booking</h1>
	<div class="alert alert-danger">Sorry, it seems payment process did not finished properly. Please, try it again</div>

@elseif ($status == 'PAID')
	<h1>Your Booking</h1>
	<div class="alert alert-warning">Thank you, this booking was already paid</div>

@elseif ($status == 'NEW')
	<h1>Your Booking</h1>
	<div class="alert alert-success">Your inqury has been received. Thank you!</div>
	<p>We'll get back to you as soon as we check the availabily. Please, check your email now to confirm you have received an automated email from us. If you can't see any, please check your spam/junk folder or write us to <a href="mailto:info@cookingpoint.es">info@cookingpoint.es</a> </p>

@elseif ($status == '')
	<h1>Your Booking</h1>
@endif

<?php

use App\Http\Controllers\Legacy\LegacyModel;

if (isset($reserva)) {
	$details = LegacyModel::set_booking_data ( $reserva, '/legacy/booking_details.html' );
	echo $details;	

		switch ($reserva ['status']) {
		case 'CR' :
		case 'NE' :
?>
			<p>Should you have any questions or changes, please reply to our email.</p>
<?php
			break;
		case 'PE' :
?>
			<p>Please, proceed with the payment to get your seat/s confirmed. Should you have any question, please let us know.</p>
			
			<div class="text-center">
				<a class="btn btn-primary" href="/pay/{{ $reserva['hash'] }}">Pay Now</a>
			</div>

			<p><small><br/>Cancellation policy: Full refund until 48 hours before the event.</small></p>			
<?php
			break;
		case 'PA' :
?>

<hr/>

 <p><strong>Meeting point:</strong><br/>
Cooking Point<br/>
Calle de Moratin, 11 28014 Madrid<br/>
tel. +34910115154</p>
 
<style>
    .google-maps {
        position: relative;
        padding-bottom: 33%; // This is the aspect ratio
        height: 0;
        overflow: hidden;
    }
    .google-maps iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100% !important;
        height: 100% !important;
    }
</style>
<div class="google-maps">
<iframe style="border: 0;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3037.840368337607!2d-3.6974950000000173!3d40.412387!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd422629f0ad9215%3A0xbfa70f0e9ca1618!2sCooking+Point!5e0!3m2!1ses!2ses!4v1399652339472" height="305" width="960" frameborder="0"></iframe>
</div>
<p><br />We have sent you this information by email.</p>
		

<?php
			
			break;
	}

}

?>


	</div>
</div>


@stop