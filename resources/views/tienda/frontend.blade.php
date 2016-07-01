@extends('tienda.masterlayout') 
 
@section('content')

	<div class="container">
        <h2>SHOP </h2>
        <small><form>
            <label>
                Date: <input style="display:inline-block;" name="ticket_date" value="{{ date('Y-m-d') }}" id="jqueryuidatepicker">
            </label>
        </form></small>
    </div>
	<div class="container">
        <div class="row">
         	<div class="col-sm-6">
                <h1>Articles</h1>
<?php
        $seccion = "";
        foreach ($articulos as $articulo) {
            if ($articulo['seccion'] != $seccion) {
                $seccion = $articulo['seccion'];
                echo '<h1>'. $seccion . '</h1>';                
            }
            echo '<div class="btn btn-lg btn-primary boton-articulo" data-id="'. $articulo['id'] .
            '" data-nombre="'. htmlspecialchars($articulo['nombre']) .
            '" data-pvp="'. $articulo['pvp'] .
            '" data-iva="'. $articulo['iva'] . '">'. 
            $articulo['nombre'] . '</div>';
        }
?>

    		</div>
  			<div class="col-sm-6">
                <h1>Ticket   <div class="btn btn-danger" id="boton-limpiar">Clean Ticket</div></h1>
                <div class="ticket">
                    <p>Cooking Point, S.L.<br/>
                    C/ Moratín, 11<br/>
                    28014 Madrid (SPAIN)<br/>
                    NIF: B86615143<br/>
                    ticket #: <span id="ticket_id">--</span> &nbsp Date: <span id="ticket_date"></span> 
                    <br/>
                    <br/>
                    Product                 Price<br/>
                    -----------------------------</p>
                    <div id=articles></div>
                    <p>
                    -----------------------------<br/>
                    Total €<span id=total>0</span></p>
                    <p><br/>Value Added Tax (IVA)</p>
                    <p>Base &nbsp Rate &nbsp Tax<br/>
                    <span id="impuestos"></span></p>
                    <p>Paid: <span id="forma_pago"></span></p>
                </div>
                <div class="btn btn-lg btn-danger boton-pagar" data-pago="efectivo">Pay Cash</div>
                <div class="btn btn-lg btn-danger boton-pagar" data-pago="tarjeta">Pay Card</div>
                <button type="button" class="btn btn-xs btn-secondary" onclick="location.href='/tienda/tickets';">Anular Ticket</button>

    		</div>   		
        </div>
    		
    </div>

@stop


