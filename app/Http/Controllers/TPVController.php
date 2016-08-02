<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class TPVController extends Controller
{

	public function pay($hash)
	{

	 	if (!empty($hash))
	 	{
	 		$reserva = Legacy\LegacyModel::retrieve_booking($hash);
	 		if (empty($reserva)) { 	
	 			// esta reserva no está en la base de datos
	 			return view('legacy.filledform')->with('reserva', null)->with('status', 'WRONG_ID');
	 		
	 		} elseif ($reserva['status'] == 'PA') {

	 			return view('legacy.filledform')->with('reserva', $reserva)->with('status', 'PAID');

	 		} else {

	 			return view('tpv.pay')->with('reserva', $reserva);
	 		}
	 	}
	 	else {

	 		return view('legacy.filledform')->with('reserva', null)->with('status', 'WRONG_ID');
	 	}

    }

    public function callback(Request $request)
    {
    	$version = $request->input('Ds_SignatureVersion');
    	$params = $request->input('Ds_MerchantParameters');
    	$signatureRecibida = $request->input('Ds_Signature');
    	return view('tpv.callback')->with('version', $version)->with('params', $params)->with('signatureRecibida', $signatureRecibida);
    }
}
