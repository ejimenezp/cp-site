<?php

require_once dirname( __FILE__ ) .'/model.php';
require_once dirname( __FILE__ ) .'/cp-mail.php';

function get_param( $val, $default = "")
{
	$var = isset( $_REQUEST[$val] ) ? $_REQUEST[$val] : $default;
	return $var;
}


/*
 * ALL_BOOKINGS
 */

function retrieve_all_bookings()
{
	global $db;
	$localDateTime = (new DateTime(null, new DateTimeZone('Europe/Madrid')))->format('Y-m-d');
	
	$sqlString = "SELECT
			creationDate,
			name,
			email,
			activity,
			activityDate,
			numAdults,
			numChildren,
			price,
			status,
			paymentDate,
			foodRestrictions,
			comments,
			hash
			FROM legacy_bookings WHERE type='REGULAR_CLASS' AND activityDate >= '$localDateTime' AND status <>'DE' ORDER BY creationDate DESC";
	
	if(!$result = $db->query($sqlString))
	{
		log_and_die($sqlString);
	}

	if($result->num_rows == 0 ) {
		$result->free();
		return NULL;
	}
	return $result;
}
	

/*
 * BOOKING_LOG
 */
function booking_log($hash)
{
	global $db;
	$sqlString = "SELECT
			date,
			action,
			details
		FROM legacy_bookings_log WHERE hash='$hash' ORDER BY date ASC";

	if(!$result = $db->query($sqlString))
	{
		log_and_die($sqlString);
	}

	if($result->num_rows == 0 ) {
		$result->free();
		return NULL;
	}
	return $result;
}

/*
 * BOOKING_LOG
 */
function tpv_log($hash)
{
	global $db;
	$sqlString = "SELECT
				ds_order,
				ds_description,
				ds_data,
				ds_amount,
				ds_response,
				ds_authorization,
				ds_last_update
		FROM legacy_tpv_log WHERE ds_data='$hash' ORDER BY ds_last_update ASC";

	if(!$result = $db->query($sqlString))
	{
		log_and_die($sqlString);
	}

	if($result->num_rows == 0 ) {
		$result->free();
		return NULL;
	}
	return $result;
}

/*
 * UPDATE_BOOKING (sin usar)
 */

function update_booking_json($hash, $form)
{
	if (!empty($hash))
	{
		$reserva = retrieve_booking($hash);
		if (empty($reserva)) // esta reserva no está en la base de datos
		{
			if (!empty($form)) // sí vienen datos en el post. Hay que crear
			{
				$form[hash] = $hash;
				if (empty($form[price]))
				{
					$form[price] = $form[numAdults] * 70 + $form[numChildren] * 35;
				}
	
				$storingFailure = !store_booking($form, "admin");
				if ($storingFailure)
				{
					return 'ERROR: database error storing booking. Please try later or contact info@cookingpoint.es';
				}
				else // ya se ha guardado, enviar correo y volver a ediciï¿½n
				{
					// CP_mail_to_user($nuevaReserva, dirname( __FILE__ ) . ($nuevaReserva[status] == 'PE' ? "/status_PE.html" : "/status_CR.html"));
					return "New booking created";
				}
			}
			else  // reserva en la base de datos pero sin datos en el post
			{
				return "Error no data to store";
					
			}
		}
		else // la reserva ya está en la base de datos, actualizar
		{
			if (!empty($form)) //  sí vienen datos en el post
			{
				$form[hash] = $hash;
				if (empty($form[price]))
				{
					$form[price] = $form[numAdults] * 70 + $form[numChildren] * 35;
				}
	
				$storingFailure = !update_admin_booking($form);
				if ($storingFailure)
				{
					return "Error storing data";
				}
				else // ya se ha actualizado, enviar correo y volver a ediciï¿½n
				{
					// CP_mail_to_user($nuevosDatos, dirname( __FILE__ ) . ($nuevosDatos[status] == 'PE' ? "/status_PE.html" : "/status_CR.html"));
					return "Updated Successfully";
				}
			}
			else // error, no hay datos para actualizar
			{
				return "No data to update";
			}
		}
	}
}


function deal_with_webhook($booking)
{
	global $db;
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST') 
	{
		if(isset($_POST['timestamp']) && isset($_POST['token']) && isset($_POST['signature']) && hash_hmac('sha256', $_POST['timestamp'] . $_POST['token'], $key) === $_POST['signature'])
		{
			switch ($_POST['event'])
			{
				case 'dropped':
					
					break;
				case 'accepted':
					
					break;
				default:
			}
		}
		$localDateTime = (new DateTime(null, new DateTimeZone('Europe/Madrid')))->format('Y-m-d H:i:s');
		$sqlString = "INSERT INTO bookings_log (
		date,
		hash,
		action,
		details)
		VALUES
		('$localDateTime',
		'$booking',
		'EMAIL',
		'Recipient: {$_POST['recipient']}. Status: {$_POST['event']}')";
		
		// error_log ("EMAIL: Recipient: {$_POST['recipient']}. Status: {$_POST['event']}");
		
		if(!$result = $db->query($sqlString))
		{
		log_and_die($sqlString);
		}
		
	}
}

/*
 * MAIN SWITCH
 */


switch (get_param('query'))
{
	case "ALL_BOOKINGS":
		$result = retrieve_all_bookings();
		$myArray = array();
		while($row = $result->fetch_array(MYSQL_ASSOC)) {
			$myArray[] = $row;
		}
		echo '{"data":'.json_encode($myArray).'}';
		$result->close();
		break;
		
	case "ABOOKING":
		$result = retrieve_booking(get_param('booking'));
		$result[booking_in_db] = ($result != null);
		echo json_encode($result);
		break;
		
	case "BOOKING_LOG":
		$result = booking_log(get_param('booking'));
		$myArray = array();
		while($row = $result->fetch_array(MYSQL_ASSOC)) {
			$myArray[] = $row;
		}
		echo '{"data":'.json_encode($myArray).'}';
		$result->close();
		break;

	case "TPV_LOG":
		$result = tpv_log(get_param('booking'));
		$myArray = array();
		while($row = $result->fetch_array(MYSQL_ASSOC)) {
			$myArray[] = $row;
		}
		echo '{"data":'.json_encode($myArray).'}';
		$result->close();
		break;
		
	case "NEW_BOOKING":
		$details = json_decode(get_param('form'), true);
		if (store_booking($details[r], "admin"))
		{
			echo "New booking created successfully";
		}
		else
		{
			echo "Booking creation failed";
		}
		break;
		
	case "UPDATE_BOOKING":
		$details = json_decode(get_param('form'), true);
		if (update_admin_booking($details[r]))
		{
			echo "Updated successful";
		}
		else
		{
			echo "Updated failed";
		}
		break;
		
	case "SEND_MAIL":
		$result = retrieve_booking(get_param('booking'));
		$result[emailText] = get_param('emailText');
		switch ($result[status]) {
			case 'CR':
			case 'NE':
				$template = "/status_CR";
				break;
			case 'PE':
				$template = "/status_PE";
				break;
			case 'PA':
				$template = "/status_PA";
				break;
		}	
		// error_log('json_interface: send_mail: el host en config es '. config('env.app_url'));

 		CP_mail_to_user($result, $template);
 		echo "Sent";
		break;

	case "MAILGUN_WEBHOOK":
		$booking = $_POST['booking'];
		if ($booking != "")
		{	
			deal_with_webhook($booking);
		}
		header('X-PHP-Response-Code: 200', true, 200);		
		break;
		
	default: 
		$result = null;
		break;
}


$db->close();

?>
