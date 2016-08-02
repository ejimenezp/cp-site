<?php

namespace App\Http\Controllers\Legacy;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class LegacyController extends Controller
{
    //
    private $_REQUEST;

    private function get_param( $val, $default = "")
	{
		$var = isset( $this->_REQUEST[$val] ) ? $this->_REQUEST[$val] : $default;
		return $var;
	}

	public function cp_bookings_plugin(Request $request, $hash ='', $tpvresult='')
	{
		
		 $this->_REQUEST = $request;

		 // $hash = $this->get_param('hash');
	 	if (!empty($hash))
	 	{
	 		$reserva = LegacyModel::retrieve_booking($hash);
	 		if (empty($reserva)) // esta reserva no está en la base de datos 
	 		{
	 			$nuevaReserva = $this->get_param('r');
	 			if (!empty($nuevaReserva)) //  sí vienen datos en el post
	 			{
					$nuevaReserva['hash'] = $hash;
					if (empty($nuevaReserva['price']))
					{
						$nuevaReserva['price'] = $nuevaReserva['numAdults'] * 70 + $nuevaReserva['numChildren'] * 35;
					}

					$storingFailure = !LegacyModel::store_booking($nuevaReserva); // nueva reserva
	 				if ($storingFailure) 
	 				{
	 					// echo 'ERROR: database error storing booking. Please try later or contact info@cookingpoint.es';
			 			return view('legacy.filledform')->with('reserva', null)->with('status', 'ERROR');

	 				}
	 				else // ya se ha guardado, ahora mostrar como gift o clase regular
	 				{
	 						
	 						LegacyMail::mail_to_user($nuevaReserva, ($nuevaReserva['status'] == 'PE' ? "legacy/status_PE" : "legacy/status_CR"));
	 						$admin_mail_subject = "{$nuevaReserva['activity']} on {$nuevaReserva['activityDate']} for {$nuevaReserva['numAdults']}+{$nuevaReserva['numChildren']}";
	 						LegacyMail::mail_to_admin($nuevaReserva, 'New inquiry', 'info@cookingpoint.es', $admin_mail_subject, "legacy/admin_notice_CR.html");
	 						// show_booking_details($nuevaReserva);
	 						// show_booking_status($nuevaReserva);
	 						return view('legacy.filledform')->with('reserva', $nuevaReserva)->with('status', 'NEW');
	 				}
	 			}
	 			else 
	 			{
	 				// echo 'ERROR: it seems that booking Id is not valid. Please contact info@cookingpoint.es';
	 				return view('legacy.filledform')->with('reserva', null)->with('status', 'WRONG_ID');

	 			}
	 		}
	 		else // caso normal, reserva ya almacenada y solo consultar estado
	 		{
				// echo '<h1>Bookings</h1>';
				// $tpvResult = $this->get_param('tpv');
	 			// switch ($tpvResult) {
	 				// case 'OK' :
	 				// 	echo '<div class="box" style="background-color:YellowGreen;color:White">Payment received. Thank you!</div>';
	 				// 	break;
	 				// case 'KO' :
	 				// 	echo '<div class="box" style="background-color:Salmon;color:White">Sorry, it seems you couldn\'t pay. Please, try it again</div>';
	 				// 	break;
	 				// case 'PAID' :
	 				// 	echo '<div class="box" style="background-color:Orange;color:White">Thank you, but this booking is already paid</div>';
	 				// 	break;
	 				// }
	 							
	 			// show_booking_details($reserva);
	 			// show_booking_status($reserva);
					return view('legacy.filledform')->with('reserva', $reserva)->with('status', $tpvresult);
	 			
	 		}
	  	}
	 	else // acabamos de llegar, no hash no form todavía
	 	{
	 		$post = $this->get_param('r'); 
	 		if (!empty($post)) //  sí vienen datos en el post
	 		{
	 			// echo 'ERROR: please, reload the page';
	 			return view('legacy.filledform')->with('reserva', null)->with('status', 'ERROR');
	 		}
	 		else
	 		{
		 		return view('legacy.emptyform');
	 		}
	 	}
	 	
	}

}
