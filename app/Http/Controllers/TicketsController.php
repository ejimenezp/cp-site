<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// use App\Http\Requests;

use App\TiendaArticulo;
use App\TiendaVentas;
use Log;

class TicketsController extends Controller
{
    public function front()
    {
    	$articulos = TiendaArticulo::where('visible', true)->get();
    	return view('tienda.frontend')->with('articulos', $articulos);
    }

    public function index ()
    {
    	$today = TiendaVentas::where('created_at', date('Y-m-d'))->where('anulado', false)->get();
    	return view('tienda.index')->with('tickets', $today);
    }

    public function deleteticket ($id)
    {
    	TiendaVentas::where('id', $id)->update(['anulado' => true]);
    	return redirect('tienda/tickets');
    }

    public function addticket (Request $request)
    {

    	$h = new TiendaVentas;

    	$h->fecha = $request->date;
    	$h->total = $request->total;
    	if (isset($request->bases[10])) {
	    	$h->base10 = $request->bases[10];
	    	$h->iva10 = $request->ivas[10];
    	}  
    	if (isset($request->bases[21])) {
	    	$h->base21 = $request->bases[21];
	    	$h->iva21 = $request->ivas[21];
    	}  
    	$h->pago = $request->pago;
    	$h->anulado = false;

    	$i = 0;
    	while (isset($request->articulos[$i])) {
    		$h->{"linea".$i} = $request->articulos[$i];
    		$i++;
    	}

    	$h->save();

    	return $h->id;
    }
}
