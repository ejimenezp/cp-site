@extends('adminmasterlayout') 
 

@section('content')

<h2>Calendar Events <button type="button" class="btn btn-primary" onclick="location.href='/admin/calendarevent/new/{{ $datetime->format("Y-m-d") }}/any';">New</button></h2>

@include ('calendar.weeksnippet')

<!-- show calendar event details only if clicked on one -->
@if (!is_null($event_to_show))


	<h4>{{ $event_to_show->activity->atype }}   <button type="button" class="btn btn-primary btn-xs" onclick="location.href='/admin/calendarevent/details/{{ $datetime->format("Y-m-d") }}/{{ $event_to_show->id }}';">Details</button>
		<button type="button" class="btn btn-danger btn-xs button_delete" data-toggle="modal" data-target="#modal_calendarevent_delete" data-ce_id="{{ $event_to_show->id }}" data-start_date="{{$event_to_show->start_date }}">Delete</button>
	</h4>


	<p><strong>Start: </strong>{{ $event_to_show->start_date }} {{ $event_to_show->start_time }}</p>
	<p><strong>End: </strong>{{ $event_to_show->end_date }} {{ $event_to_show->end_time }}</p>

	<p><strong>Status: </strong>{{ $event_to_show->status }}</p>
	<p><strong>Occupancy: </strong>{{ $event_to_show->occupancy }}</p>


	<h1>Bookings</h1>

	@foreach ($event_to_show->bookings as $booking)
	<p><strong>Name: </strong> {{ $booking->name }} </p>
	@endforeach
	<button type="button" class="btn btn-primary">Add Booking</button>

@endif

@stop

@section('modals')
@include('calendarevent.modals')
@include('booking.modals')
@stop

@section('js')
<script async src="/js/admin-calendarevent.js"></script>
@stop