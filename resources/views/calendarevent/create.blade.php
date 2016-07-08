@extends('adminmasterlayout') 
 
@section('content')


<h2><div id="event-type"></div></h2>

<form method="POST" action='/admin/calendarevent/{{ $datetime->format("Y-m-d") }}'>

    <input name="start_shift" value="{{ $shift }}" type="hidden">
    <input name="end_shift" value="{{ $shift }}" type="hidden">
    
    <select id="activity-type" name="activity_id" class="form-control">
        @foreach ($activities as $activity)
            <option value="{{$activity->id}}" shift="{{$activity->shift}}">{{ $activity->type }} </option>
        @endforeach
     </select>
 
    
<div id="special-calendar-event-data" class="hidden">
    <div class="form-group">
        <label for="datepicker">From</label>
            <input name="start_date" date='{{$datetime->format("Y-m-d")}}' value='{{$datetime->format("Y-m-d")}}' id="jqueryuidatepicker">
        <div id="activity-end-shift" class="btn-group" data-toggle="buttons" shift="{{$shift}}">
          <label shift="am" class="btn btn-primary">
            <input name="end_shift" type="radio" value="am" autocomplete="off">AM
          </label>
          <label shift="pm" class="btn btn-primary">
            <input name="end_shift" type="radio" value="pm" autocomplete="off">PM
          </label>
        </div>
        <select id="start_time" name="start_time" class="form-control">
            @if ($shift == "am")
                <option value="9:00:00">9:00</option>
                <option value="9:30:00">9:30</option>
                <option value="10:00:00">10:00</option>
                <option value="10:30:00">10:30</option>
                <option value="11:00:00">11:00</option>
                <option value="11:30:00">11:30</option>
                <option value="12:00:00">12:00</option>
            @else
                <option value="14:00:00">14:00</option>
                <option value="14:30:00">14:30</option>
                <option value="15:00:00">15:00</option>
            @endif
        </select>
    </div>

    <div class="form-group">
        <label for="datepicker">Until</label>
            <input name="end_date" date='{{$datetime->format("Y-m-d")}}' value='{{$datetime->format("Y-m-d")}}' id="jqueryuidatepicker">
        <div id="activity-end-shift" class="btn-group" data-toggle="buttons" shift="{{$shift}}">
          <label shift="am" class="btn btn-primary">
            <input name="end_shift" type="radio" value="am" autocomplete="off">AM
          </label>
          <label shift="pm" class="btn btn-primary">
            <input name="end_shift" type="radio" value="pm" autocomplete="off">PM
          </label>
        </div>
    </div>
   <div class="form-group">
        <label for="exampleInputPassword1">Details</label>
        <input class="form-control" name="details" id="exampleInputPassword1">
    </div>
    <div class="btn-group"  data-toggle="buttons">
      <label class="btn btn-primary active">
        <input name="status" type="radio" value="NOT_CONFIRMED" autocomplete="off" checked>Not Confirmed
      </label>
      <label class="btn btn-primary">
        <input name="status" type="radio" value="CONFIRMED" autocomplete="off">Confirmed
      </label>
    </div>
        
</div>
 
<button type="submit" class="btn btn-default">Submit</button>

</form>

@stop