
<!-- Modals -->

<div class="modal fade" id="deleteevent" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Are you sure?</h4>
        </div>
        <div class="modal-body">
          <p>Please, confirm</p>
        </div>
        <div class="modal-footer">
            <form method="post" action="/admin/calendarevent/{{ $event_to_show->start_date }}/{{ $event_to_show->id }}">
                {{ method_field('DELETE') }}
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-danger" >Delete</button>
            </form>
       </div>
      </div>

</div>
</div>

<!-- End of Modals -->


<h2>{{ $event_to_show->activity->atype }}   <button type="button" class="btn btn-primary" onclick="location.href='/admin/calendarevent/';">Edit</button>
    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteevent">Delete</button>
</h2>


<p><strong>Start: </strong>{{ $event_to_show->start_date }} {{ $event_to_show->start_time }}</p>
<p><strong>End: </strong>{{ $event_to_show->end_date }} {{ $event_to_show->end_time }}</p>

<p><strong>Status: </strong>{{ $event_to_show->status }}</p>
<p><strong>Occupancy: </strong>{{ $event_to_show->occupancy }}</p>


<h1>Bookings</h1>

@foreach ($event_to_show->bookings as $booking)
<p><strong>Name: </strong> {{ $booking->name }} </p>
@endforeach
<button type="button" class="btn btn-primary">Add Booking</button>

