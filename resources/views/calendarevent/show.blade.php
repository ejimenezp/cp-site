@extends('adminmasterlayout') 

 
@section('content')

<h2>
@if (!is_null($calendarevent)) 
    {{ $calendarevent->activity->atype }}
@else
    New Calendar Event
@endif
</h2>

    <form id="form_calendarevent" class="form-horizontal" role="form" onsubmit="return false;">

@if (!is_null($calendarevent)) 
    <input type="hidden" name="id" value="{{ $id }}">
@endif
    <input type="hidden" name="start_date" value="{{ $datetime->format('Y-m-d') }}">
    <input type="hidden" name="end_date" value="{{ $datetime->format('Y-m-d') }}">
    <input name="start_shift" id="start_shift" type="hidden" value="am"> 
    <input name="end_shift" id="end_shift" type="hidden" value="am"> 

    <div class="row">
        <div class="form-group">
            <label class="control-label col-sm-2" for="atype">Activity:</label>
            <div class="col-sm-8" >
                <select id="activity-type" name="activity_id" class="form-control ">
                    @foreach ($activities as $activity)
                        <option value="{{$activity->id}}" shift="{{$activity->shift}}">{{ $activity->atype }} </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

        <div class="row">
            <!-- starts at  -->
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="from">From</label>
                        <input name="formatted_start_date" value='{{$datetime->format("l, d F Y")}}' id="from">
                        <select name="start_time">
                            <option value="09:00:00">9:00am</option>
                            <option value="09:30:00">9:30am</option>
                            <option value="10:00:00">10:00am</option>
                            <option value="10:30:00">10:30am</option>
                            <option value="11:00:00">11:00am</option>
                            <option value="11:30:00">11:30am</option>
                            <option value="12:00:00">12:00pm</option>
                            <option value="12:30:00">11:30pm</option>
                            <option value="13:00:00">1:00pm</option>
                            <option value="13:30:00">1:30pm</option>
                            <option value="14:00:00">2:00pm</option>
                            <option value="14:30:00">2:30pm</option>
                            <option value="15:00:00">3:00pm</option>
                            <option value="15:30:00">3:30pm</option>
                            <option value="16:00:00">4:00pm</option>
                            <option value="16:30:00">4:30pm</option>
                            <option value="17:00:00">5:00pm</option>
                            <option value="17:30:00">5:30pm</option>
                            <option value="18:00:00">6:00pm</option>
                            <option value="18:30:00">6:30pm</option>
                            <option value="19:00:00">7:00pm</option>
                            <option value="19:30:00">7:30pm</option>
                            <option value="20:00:00">8:00pm</option>
                            <option value="20:30:00">8:30pm</option>
                            <option value="21:00:00">9:00pm</option>
                            <option value="21:30:00">9:30pm</option>
                            <option value="22:00:00">10:00pm</option>
                            <option value="22:30:00">10:30pm</option>
                            <option value="23:00:00">11:00pm</option>
                            <option value="23:30:00">11:30pm</option>
                        </select>
                </div>
            </div>
            <!-- ends at  -->
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="to">To</label>
                        <input name="formatted_end_date" value='{{$datetime->format("l, d F Y")}}' id="to">
                        <select name="end_time">
                            <option value="09:00:00">9:00am</option>
                            <option value="09:30:00">9:30am</option>
                            <option value="10:00:00">10:00am</option>
                            <option value="10:30:00">10:30am</option>
                            <option value="11:00:00">11:00am</option>
                            <option value="11:30:00">11:30am</option>
                            <option value="12:00:00">12:00pm</option>
                            <option value="12:30:00">11:30pm</option>
                            <option value="13:00:00">1:00pm</option>
                            <option value="13:30:00">1:30pm</option>
                            <option value="14:00:00">2:00pm</option>
                            <option value="14:30:00">2:30pm</option>
                            <option value="15:00:00">3:00pm</option>
                            <option value="15:30:00">3:30pm</option>
                            <option value="16:00:00">4:00pm</option>
                            <option value="16:30:00">4:30pm</option>
                            <option value="17:00:00">5:00pm</option>
                            <option value="17:30:00">5:30pm</option>
                            <option value="18:00:00">6:00pm</option>
                            <option value="18:30:00">6:30pm</option>
                            <option value="19:00:00">7:00pm</option>
                            <option value="19:30:00">7:30pm</option>
                            <option value="20:00:00">8:00pm</option>
                            <option value="20:30:00">8:30pm</option>
                            <option value="21:00:00">9:00pm</option>
                            <option value="21:30:00">9:30pm</option>
                            <option value="22:00:00">10:00pm</option>
                            <option value="22:30:00">10:30pm</option>
                            <option value="23:00:00">11:00pm</option>
                            <option value="23:30:00">11:30pm</option>
                        </select>
                </div>
            </div>
        </div>  

        <div class="form-group">
            <label class="control-label col-sm-2" for="comments">Comments:</label>
            <div class="col-sm-8" >
                <input type="text" class="form-control" id="calendarevent_comments" name="comments">
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-sm-2" for="registered">Occupancy:</label>
            <div class="col-sm-8" >
                <input type="text" class="form-control" id="calendarevent_registered" name="registered">
            </div>
        </div>

<!--         <div class="form-group">
            <label class="control-label col-sm-2" for="atype">Description:</label>
            <div class="col-sm-8" >
                <input type="text" class="form-control" id="activity_atype" name="activity_atype">
            </div>
        </div>
 -->
<div class="form-group">
    <label class="radio-inline"><input type="radio" name="status" value="CONFIRMED">Confirmed</label>
    <label class="radio-inline"><input type="radio" name="status" value="NOT_CONFIRMED" checked="checked" >Not Confirmed</label>    
        <label class="radio-inline"><input type="radio" name="status" value="CANCELLED">Cancelled</label>

</div>


        <button id="button_close" id="button_close" class="btn btn-primary">Close</button>
        <button type="submit" id="button_save" class="btn btn-primary">Save</button>
    </form>
</div>


@stop

@section('modals')
@include('calendarevent.modals')
@include('booking.modals')
@stop

@section('js')
<script async src="/js/admin-calendarevent.js"></script>
@stop