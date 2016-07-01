<!DOCTYPE html>
<html>
    <head>
        <title>Shop</title>
        <meta name="description" content="Cooking Point Shop Front-end" >
        
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
      
        <link href="{{ elixir('css/app.css') }}" rel="stylesheet" type="text/css">     
    </head>
    
    <body>

        @yield('content') 

        <!-- javascripts  -->
        <script type='text/javascript' src='/js/tienda.js'></script>           

    </body>
</html>


