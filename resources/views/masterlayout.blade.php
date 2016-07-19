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
      <script src="https://use.fontawesome.com/c502308363.js"></script>
  </head>
    
  <body>
	<div class="container">

    <div class="visible-xs">
      <div class="row ">   
          <div class="col-xs-3">
            <a href="/"><img alt="cooking point logo" src="/images/cookingpoint_logox75.png" /></a>
          </div> 
          <div class="col-xs-9">
            <div class="text-right" data-toggle="collapse" data-target="#navbar">
              <h1>Menu <i class="fa fa-bars" aria-hidden="true"></i></h1>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
              <ul class="nav navbar-nav">
                  <li>
                      <a href="/">Home</a>
                    </li>
                  <li class="dropdown">
                      <a class="dropdown-toggle" data-toggle="dropdown" id="themes">Classes <span class="caret"></span></a>
                      <ul class="dropdown-menu" aria-labelledby="themes">
                        <li><a href="/classes-paella-cooking-madrid-spain">Paella Cooking Class</a></li>
                        <li><a href="/wine-tasting-madrid-spain">Wine Tasting</a></li>
                        <li><a href="/classes-spanish-tapas-madrid-spain">Tapas Cooking Class</a></li>
                      </ul>
                  </li>
                  <li>
                    <a href="/private-cooking-events-madrid-spain">Events</a>
                  </li>
                  <li>
                    <a href="/school-madrid-spain">The School</a>
                  </li>
                                    <li>
                    <a href="/gallery">Gallery</a>
                  </li>
                                    <li>
                    <a href="/bookings">Bookings</a>
                  </li>
                                    <li>
                    <a href="/contact">Contact</a>
                  </li>
                                    <li>
                    <a href="/faq">FAQ</a>
                  </li>
              </ul> 
            </div>
          </div>
      </div>       
    </div>

    <div class="visible-sm visible-md visible-lg">
      <div class="row no-gutter">   
          <div class="col-sm-1">
            <a href="/"><img alt="cooking point logo" src="/images/cookingpoint_logox113.png" /></a>
          </div> 
          <div class="col-sm-11">
            <ul class="vertical-center nav navbar-nav">
                <li>
                    <a href="/">Home</a>
                  </li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" id="themes">Classes <span class="caret"></span></a>
                    <ul class="dropdown-menu" aria-labelledby="themes">
                      <li><a href="/classes-paella-cooking-madrid-spain">Paella Cooking Class</a></li>
                      <li><a href="/wine-tasting-madrid-spain">Wine Tasting</a></li>
                      <li><a href="/classes-spanish-tapas-madrid-spain">Tapas Cooking Class</a></li>
                    </ul>
                </li>
                <li>
                  <a href="/private-cooking-events-madrid-spain">Events</a>
                </li>
                <li>
                  <a href="/school-madrid-spain">The School</a>
                </li>
                                  <li>
                  <a href="/gallery">Gallery</a>
                </li>
                                  <li>
                  <a href="/bookings">Bookings</a>
                </li>
                                  <li>
                  <a href="/contact">Contact</a>
                </li>
                                  <li>
                  <a href="/faq">FAQ</a>
                </li>
            </ul> 
          </div>
      </div>      
    </div>

  </div>
        
@if (isset($page) && ($page == 'home' || $page == 'contact'))
  <div class="container">
      <div class="divider"></div>
      @yield('content') 
      @yield('footer')
  </div>
@else
	<div class="container">
    <div class="row">
        <div class="divider"></div>
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

<!-- footer -->
  <div class="container">

    <div class="divider"></div>

    <div class="primary-color">
      <div class="pull-left" style="padding-top:1.6em;">© Cooking Point, SL</div>
      <div class="pull-right">Follow us in:
        <a href="https://www.facebook.com/CookingPointSpain" title="facebook" target="_blank"><i class="fa fa-3x fa-facebook-official"></i></a>
        &nbsp;
        <a href="https://google.com/+CookingPointMadrid" title="google plus" target="_blank"><i class="fa fa-3x fa-google-plus-square"></i></a>
        &nbsp;
        <a href="https://www.instagram.com/cookingpoint/" title="instagram" target="_blank"><i class="fa fa-3x fa-instagram"></i></a>        
      </div>      
    </div>

  </div>

<!-- modals specific for this page  -->
@yield('modals')

<!-- javascripts specific for this page  -->
@yield('js')

</body>

</html>
