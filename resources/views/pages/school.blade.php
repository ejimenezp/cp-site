@extends('masterlayout')

@section('title', 'Cooking School in Madrid, Spain')
@section('description', 'Cooking School located in Barrio de Huertas, Madrid, Spain. Plan your cooking school vacation in Madrid and learn how to make paella and tapas')

@section('content')

<div class="row">
    <div class="cp-slideshow">
            <div style="display: inline-block;"><img src="/images/slider-school-01.jpg" ></div>
            <div><img src="/images/slider-school-03.jpg" ></div>
            <div><img src="/images/slider-school-02.jpg" ></div>
            <div><img src="/images/slider-school-05.jpg" ></div>
            <div><img src="/images/slider-school-06.jpg" ></div>
            <div><img src="/images/slider-school-04.jpg" ></div>
	</div>
</div>


<div class="row">
	<div class="col-sm-12">
		<h1>The School</h1>
	</div>
</div>

<div class="row">
	<div class="col-sm-6">
		<p>Cooking Point is located in the Barrio de Huertas (or Barrio de las Letras, Literary Quarter). An important place in history especially during the 16th-century Golden Age of Spanish Literature, Miguel de Cervantes and Lope de Vega both lived here. It is also the place to be and it comes to life at night with Madrid’s most popular bars. It’s perfect for the post-Cooking Point drink.</p>

		<p>Inside Cooking Point, we have designed our large kitchen to feel like home. The state-of-the-art appliances will ensure nothing can go wrong while all the tools are exactly as you would have in your own kitchen. There is no reason why you won’t be able to take this new-found skill home with you.</p>
	</div>

	<div class="col-sm-6">
		<p>A unique feature of our school is the size, we can host a group of up to 24 people. Large enough for a great atmosphere, small enough to get the right guidance and support from the chef. All cooking is done in pairs, each couple has their own stove to work on.</p>

		<p>The tasting room downstairs, that works also as dining-room, can also host 24 people. The wine cellars ensure the temperature is consistent and cool and provide perfect storage for our wines. It also keeps the tasting area cool and comfortable no matter what season.</p>
	</div>

	<div class="divider"></div>

</div>

<div class="row call-to-action">
	<div class="col-xs-12 col-sm-1 text-center">
 		<i class="brand-red fa fa-4x fa-info-circle"></i><br/>
	</div>
	<div class="col-xs-3 col-sm-2 what">
		Location:<br/>
		Capacity:<br/>
		Usage:<br/><br/>
	</div>
	<div class="col-xs-9">
		Barrio de Huertas, In the heart of Madrid<br/>
		24 people<br/>
		Cooking classes, private events, TV set,...<br/><br/>
	</div>
</div>

<div class="row text-center call-to-action">
	<a href="http://tour.cookingpoint.es/CP_tour.html" class="btn btn-primary" target="_blank">Virtual Tour</a>
</div>


@stop