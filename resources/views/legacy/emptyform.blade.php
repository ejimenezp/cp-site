@extends('masterlayout')

@section('title', 'Booking Form for Cooking School Madrid, Spain: Spanish cuisine courses')
@section('description', 'Cooking courses school schedules and contact form: cooking classes calendar in madrid, Spain. Plan your cooking school vacations.')

@section('content')

<div class="row">
	<div class="col-sm-12">
		<h1>Legacy Bookings</h1>

		<p>Please, fill in the form to inquire about a class.   <small>(<span style="color:red">*</span> = mandatory)</small></p>

		<form method="post" name="rclass_form" id="rclass_form" class="cp-full-width" >
			<input name="r[type]" type="hidden" value="REGULAR_CLASS" > 
			<input name="r[status]" type="hidden" value="CR">
			<input name="r[activityDate]" id="actDateName" type="hidden" value="1970-01-01"> 
			<input name="r[hash]" type="hidden" value="" > 
			<input name="user" type="hidden" value="enduser">
			<input type="hidden" name="_token" value="{{csrf_token()}}"/>

			<table class="cp-full-width">
						<tr>
						<td class="cp-td-third"><strong>Name<span class="mandatory">*</span>:</strong><br />
							<input name="r[name]" type="text" value="" style="width:100%"></td>
						<td class="cp-td-third"><strong>Email<span class="mandatory">*</span>:</strong><br />
							<input id="cp-email" name="r[email]" type="text" value="" style="width:100%"></td>
						<td class="cp-td-third"><strong>Phone:</strong><br />
							<input name="r[phone]" type="text" value="" style="width:100%"></td>
					</tr>
			</table>
			<table class="cp-full-width">
					<tr>
						<td class="cp-td-half"><strong>Activity:</strong><br />
							<select id="bookingactivity" name="r[activity]" class="cp-full-width" >
		<?php	
			$acts = App\Http\Controllers\Legacy\LegacyModel::retrieve_activities(FALSE);
			foreach ( $acts as $a ) {
				echo '<option value="' . get_object_vars($a) ['shortcode'] . '">' . get_object_vars($a) ['activity'] . '</option>';
			}
		?>
							</select></td>
						<td class="cp-td-half"><strong>Date<span class="mandatory">*</span>:</strong><br />
						<input type="text" id="example1" name="dummy" class="cp-full-width" readonly ></td>				
						</tr>
			</table>
			<table class="cp-full-width">
					<tr>
						<td class="cp-td-third"><strong>Adults:</strong><br />
							<select id="bookingnumadults" name="r[numAdults]" style="width:50%;" >
		<?php
			for($x = 1; $x <= 10; $x ++) {

					echo '<option value="' . $x . '">' . $x . '</option>';
			}
		?>
										</select></td>
						<td class="cp-td-third"><strong>Children </strong><small>(5-12 years)</small>:<br />
							<select id="bookingnumchildren" name="r[numChildren]" style="width:50%;" >
		<?php
			for($x = 0; $x <= 10; $x ++) {
				echo '<option value="' . $x . '">' . $x . '</option>';
			}
		?>
							</select></td>
						<td class="cp-td-third"><strong>Price (EUR):</strong><br />
							<p id="rclass_cost" style="padding-top: 7px;margin:auto;">70</p></td>
					</tr>
				</table>

				<table class="cp-full-width" >
					<tr>
						<td class="cp-td-half"><strong>Food restrictions:</strong><br />
							<textarea id="bookingfoodrestrictions" name="r[foodRestrictions]" class="cp-full-width"></textarea>	 </td>   
						<td class="cp-td-half"><strong>Comments</strong> <small>(if possible, provide alternative dates)</small>:<br />
							<textarea id="bookingcomments" name="r[comments]" class="cp-full-width"></textarea></td>   
					</tr>
				</table>
				<div class="text-center">
					<button class="btn btn-primary" id="send_button" type="submit">Send</button>
				</div>
		</form>

	</div>
</div>


@stop

@section('js')
	<script async src="/js/cp-scripts.js"></script>
@stop