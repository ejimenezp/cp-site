@extends('tienda.masterlayout') 
 
@section('content')

<div class="container">

<h2>Today Sales</h2>

<table id="table_tickets" class="table table-hover ">
	<thead>
		<tr>
			<th>#</th>
			<th>Date</th>
			<th>Total</th>
			<th>Payment</th>
			<th>Item 1</th>
			<th>Item 2</th>
			<th>Item 3</th>
			<th>Item 4</th>
			<th>More?</th>
		</tr>
	</thead>
		<tbody>
			@foreach ($tickets as $ticket)
			<tr>
				<td>{{ $ticket->id }}</td>
				<td>{{ $ticket->fecha }}</td>
				<td>{{ $ticket->total }}</td>
				<td>{{ $ticket->pago }}</td>
				<td>{{ $ticket->linea0 ? $ticket->desc0->nombre :"" }}</td>
				<td>{{ $ticket->linea1 ? $ticket->desc1->nombre :"" }}</td>
				<td>{{ $ticket->linea2 ? $ticket->desc2->nombre :"" }}</td>
				<td>{{ $ticket->linea3 ? $ticket->desc3->nombre :"" }}</td>
				<td>{{ $ticket->linea4 ? "(more items)" :"" }}</td>

				<td><button type="button" class="btn btn-primary btn-xs" onclick="location.href='/tienda/deleteticket/{{ $ticket->id }}';">Delete</button></td>
			</tr> 
	        @endforeach 
		</tbody>
</table>
<p></p>

<button type="button" class="btn btn-primary" onclick="location.href='/tienda'">Back</button>

</div>
@stop

