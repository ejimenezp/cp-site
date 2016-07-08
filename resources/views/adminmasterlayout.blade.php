<!DOCTYPE html>
<html>
    <head>
        <title>Admin</title>
        <meta name="description" content="Cooking Point Admin Page" >
        
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
      
        <link href="{{ elixir('css/app.css') }}" rel="stylesheet" type="text/css">     
    </head>
    
    <body>
	<div class="container">
        <div class="row">   
            <ul class="nav navbar-nav">
                <li>
                    <a href="/admin/calendar">Calendar Events</a>
                </li>
                <li>
                    <a href="/admin/activity">Activities</a>
                </li>
                <li>
                    <button class="btn btn-primary" id="calendar_button">Hide/Show Calendar</button>
                </li>

            </ul>              
        </div>
    </div>
	<div class="container">
        <div class="row">
<!--     		<div class="col-sm-3">
    		</div>
 --> 			<div class="col-sm-9">
                 @include('adminsidebar')
			     @yield('content') 
    		</div>   		
        </div>
    		
    </div>

@yield('modals')

<!-- javascripts  -->
<script type='text/javascript' src='/js/admin.js'></script>           
@yield('js')

</body>
</html>


