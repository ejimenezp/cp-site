@extends('adminmasterlayout') 

 
@section('content')

<h2>
@if ($id != 0) 
    {{ $activity->atype }}
@else
    New Activity
@endif
</h2>

<div class="container">
    <form id="form_activity" class="form-horizontal" role="form" onsubmit="return false;">
@if ($id != 0) 
        <input type="hidden" name="id" value="{{ $id }}">
@endif
        
        <div class="form-group">
            <label class="control-label col-sm-2" for="activity_shortcode">Shortcode:</label>
            <div class="col-sm-8" >
                <input type="text" class="form-control" id="activity_shortcode" name="shortcode">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="activity_atype">Description:</label>
            <div class="col-sm-8" >
                <input type="text" class="form-control" id="activity_atype" name="atype">
            </div>
        </div>

        <button id="button_close" id="button_close" class="btn btn-primary">Close</button>
        <button type="submit" id="button_save" class="btn btn-primary">Save</button>
    </form>
</div>
@stop

@section('modals')
@include('activity.modals')
@stop

@section('js')
<script async type='text/javascript' src="/js/admin-activity.js"></script>
@stop