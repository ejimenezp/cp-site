<!DOCTYPE html>
<html>
    <head>
        <title>@yield('title')</title>
        <meta name="description" content="@yield('description')" >
        
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="favicon-test.ico">
        <link rel="canonical" href="{{ url()->current() }}">
        <style type="text/css">
            ul {
                  list-style-type: none;
                  margin: 0;
                  padding: 0;
                }
        </style>  
        <link href="{{ elixir('css/app.css') }}" rel="stylesheet" type="text/css">     
        <script type='text/javascript' src='/js/app.js'></script>

    </head>
    
    <body>
	<div class="container">
    <div class="row no-gutter">   
        <div class="col-sm-1">
          <a href="/"><img alt="cooking point logo" src="images/cookingpoint_logox113.png" href="../" /></a>
        </div> 
        <div class="col-sm-11">
              <ul class="vertical-center nav navbar-nav">
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
              </ul> 
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
         			<div class="col-sm-9">
        			     @yield('content') 
        			     @yield('footer')
            		</div>   		
            		<div class="col-sm-3">
                         @include('sidebar')
            		</div>
                </div>
            		
            </div>
        @endif
    </body>
</html>
