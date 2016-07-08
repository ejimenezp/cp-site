<!DOCTYPE html>
<html>
    <head>
        <title>@yield('title')</title>
        <meta name="description" content="@yield('description')" >
        
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="{{ elixir('css/app.css') }}" rel="stylesheet" type="text/css">     
        <script type='text/javascript' src='/js/app.js'></script>           
    </head>
    
    <body>
	<div class="container">
    <div class="row">   
        <div class="col-md-12
        ">
<!--         </div> -->
<!--         <div class="col-md-11"> -->
                  <ul class="nav navbar-nav">
                    <li>
                         <img alt="cooking point logo" src="images/cookingpoint_logox113.png" href="../" />
                  </li>
                  <li>
                      <a href="/">Home</a>
                    </li>
                  <li class="dropdown">
                      <a class="dropdown-toggle" data-toggle="dropdown" href="classes" id="themes">Classes <span class="caret"></span></a>
                      <ul class="dropdown-menu" aria-labelledby="themes">
                        <li><a href="../default/">Paella Cooking Class</a></li>
                        <li><a href="../cerulean/">Wine Tasting</a></li>
                        <li><a href="../cosmo/">Tapas Cooking Class</a></li>
                      </ul>
                  </li>
                  <li>
                    <a href="private-cooking-events-madrid-spain">Events</a>
                  </li>
                  <li>
                    <a href="events">The School</a>
                  </li>
                                    <li>
                    <a href="events">Gallery</a>
                  </li>
                                    <li>
                    <a href="events">Bookings</a>
                  </li>
                                    <li>
                    <a href="events">Contact</a>
                  </li>
                                    <li>
                    <a href="events">FAQ</a>
                  </li>
                  
                </div>
              </div>
        </div>
        </div>
        </div> 

        @if (isset($page) && $page == 'home')
			<div class="container">
			     @yield('content') 
			     @yield('footer')
		    </div>
        @else
			<div class="container">
                <div class="row">
         			<div class="col-md-9">
        			     @yield('content') 
        			     @yield('footer')
            		</div>   		
            		<div class="col-md-3">
                         @include('sidebar')
            		</div>
                </div>
            		
            </div>
        @endif
    </body>
</html>
