@extends('adminmasterlayout') 
 
@section('content')

<h2>Activities <button type="button" class="btn btn-primary" onclick="location.href='/admin/activity/new';">New</button></h2>

<table id="table_activity" class="table table-striped table-hover ">
	<thead>
		<tr>
			<th>Shortcode</th>
			<th>Visible</th>
			<th>Actions</th>
		</tr>
	</thead>
		<tbody>

		@foreach ($activities as $activity)
		<tr><td>{{ $activity->shortcode }}</td><td>{{ $activity->atype }}</td><td><button type="button" class="btn btn-primary btn-xs" onclick="location.href='/admin/activity/{{ $activity->id }}';">Details</button>
		<button type="button" class="btn btn-danger btn-xs button_delete" data-toggle="modal" data-target="#modal_activity_delete" data-activity_id="{{ $activity->id }}">Delete</button></td></tr> 
        @endforeach 

		</tbody>
</table>

@stop

@section('modals')
	@include('activity.modals')
@stop

@section('js')
	<script async src="/js/admin-activity.js"></script>
@stop
