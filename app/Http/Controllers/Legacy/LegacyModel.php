<?php

// error logging

// ini_set ( 'display_errors', 1 );
// ini_set("error_log", dirname ( __FILE__ ) . '/cp_error.log');

// error_reporting ( E_ALL ^ E_NOTICE );

namespace App\Http\Controllers\Legacy;

use App\Legacy;
use Illuminate\Support\Facades\Storage;
use Log;
use \DB;
use \DateTime;
use \DateTimeZone;


class LegacyModel {

	private static function log_and_die($s)
	{
		Log::error('There was an error running the query'. $s);
		exit();
	}

	/* comprobar la conexión */
	// if ($db->connect_errno > 0)
	// {
	// 		self::log_and_die($sqlString);
	// }


	static function retrieve_booking($hash)
	{
		
		$sqlString = "SELECT * FROM legacy_bookings WHERE hash='$hash' ORDER BY creationDate DESC LIMIT 1";
			
		if(!$result = DB::select($sqlString))
		{
			return NULL;
		}
		$row = get_object_vars($result[0]);	

		return $row;
	}


	static function set_booking_data($r, $filename)
	{
		$activityDate = new DateTime($r['activityDate']);
		$legibleDate = $activityDate->format('l, d F Y');
		
		$arr = explode(' ',trim($r['name']));
		
		switch ($r['status']) {
			case 'CR':
			case 'NE':
				$status = "Checking Availability";
				break;
			case 'PE':
				$status = "Payment Required";
				break;
			case 'PA':
				$status = "Paid";
				break;
			case 'DE':
				$status = "Cancelled";
				break;
			default:
				$status = "Contact Us";
			}
				
		// build html from template
		$html = Storage::get($filename);
		
		// $html = str_replace('CP_EMAILTEXT', nl2br(stripslashes($r['emailText'])), $html); // only for PE
		$html = str_replace('CP_HASH', $r['hash'], $html);
		$html = str_replace('CP_NAME', stripslashes($r['name']), $html);
		$html = str_replace('CP_FIRSTNAME', stripslashes($arr[0]), $html);
		$html = str_replace('CP_EMAIL', $r['email'], $html);
		$html = str_replace('CP_PHONE', $r['phone'], $html);
		$html = str_replace('CP_ACTIVITY', self::activity_by_shortcode($r['activity']), $html);
		$html = str_replace('CP_ACTDATE', $legibleDate, $html);
		$html = str_replace('CP_NUMADULTS', $r['numAdults'], $html);
		$html = str_replace('CP_NUMCHILDREN', $r['numChildren'], $html);
		$html = str_replace('CP_PRICE', $r['price'], $html);
		$html = str_replace('CP_STATUS', $status, $html);
		$html = str_replace('CP_FOODRESTRICTIONS', nl2br(stripslashes($r['foodRestrictions'])), $html);
		$html = str_replace('CP_COMMENTS', nl2br(stripslashes($r['comments'])), $html);
		$html = str_replace('CP_RANDOM', rand(), $html);
		$html = str_replace('APP_URL', config('cookingpoint.env.app_url'), $html);
		
		return $html;
		
	}

	static function to_bookings_log($hash, $action, $details)
	{
		
		$localDateTime = (new DateTime(null, new DateTimeZone('Europe/Madrid')))->format('Y-m-d H:i:s');

		$localdetails = strtr($details,"'\"","  ");
		
		$sqlString = "INSERT INTO legacy_bookings_log (
		date,
		hash,
		action,
		details)
		VALUES
		('$localDateTime',
		'$hash',
		'$action',
		'$localdetails')";

		if(!$result = DB::statement($sqlString))
		{
			self::log_and_die($sqlString);
		}

	}

	static function store_booking($b, $by = "enduser")
	{

		
		$localDateTime = (new DateTime(null, new DateTimeZone('Europe/Madrid')))->format('Y-m-d H:i:s');

		
		$sqlString = "INSERT INTO legacy_bookings (
				creationDate,
				hash,
				type,
				name,
				email,
				phone,
				activity,
				activityDate,
				numAdults,
				numChildren,
				foodRestrictions,
				comments,
				price,
				status,
				lastUpdate)
			VALUES
				('$localDateTime',
				'{$b['hash']}',
				'{$b['type']}',
				'{$b['name']}',
				'{$b['email']}',
				'{$b['phone']}',
				'{$b['activity']}',
				'{$b['activityDate']}',
				{$b['numAdults']},
				{$b['numChildren']},
				'{$b['foodRestrictions']}',
				'{$b['comments']}',
				{$b['price']},
				'{$b['status']}',
				'$localDateTime')";		
					
		if(!$result = DB::statement($sqlString))
		{
			self::log_and_die($sqlString);
		}
			
		// add entry to bookings_log			
		self::to_bookings_log($b['hash'], 'CREATE','By '. $by);
				
		return TRUE;
	}


	static function update_booking_after_tpv($hash, $order, $response, DateTime $timeStamp)
	{
		
		$status = ($response < 100 ? 'PA' : 'PE');
		$sqlString = "UPDATE legacy_bookings SET
			paymentOrder = '$order',
			status = '$status',
			paymentDate = '{$timeStamp->format('Y-m-d H:i:s')}',
			lastUpdate = '{$timeStamp->format('Y-m-d H:i:s')}'
			WHERE
		hash = '$hash'";
			
		if(!$result = DB::statement($sqlString))
		{
			self::log_and_die($sqlString);
		}
		
		// add entry to bookings_log, if needed
		
		if ($status == 'PA')
		{
			self::to_bookings_log($hash, 'PAID','');
		}
	}


	static function update_admin_booking($b)
	{

		$localDateTime = (new DateTime(null, new DateTimeZone('Europe/Madrid')))->format('Y-m-d H:i:s');
		
		$prev_booking = retrieve_booking($b['hash']);
		
		$log_details = "";
		$log_details = $log_details . ($prev_booking['name'] != $b['name'] ? "name = {$b['name']}, " : "");
		$log_details = $log_details . ($prev_booking['email'] != $b['email'] ? "email = {$b['email']}, " : "");
		$log_details = $log_details . ($prev_booking['phone'] != $b['phone'] ? "phone = {$b['phone']}, " : "");
		$log_details = $log_details . ($prev_booking['activity'] != $b['activity'] ? "activity = {$b['activity']}, " : "");
		$log_details = $log_details . ($prev_booking['activityDate'] != $b['activityDate'] ? "activityDate = {$b['activityDate']}, " : "");
		$log_details = $log_details . ($prev_booking['numAdults'] != $b['numAdults'] ? "numAdults = {$b['numAdults']}, " : "");
		$log_details = $log_details . ($prev_booking['numChildren'] != $b['numChildren'] ? "numChildren = {$b['numChildren']}, " : "");
		$log_details = $log_details . ($prev_booking['foodRestrictions'] != $b['foodRestrictions'] ? "foodRestrictions = {$b['foodRestrictions']}, " : "");
		$log_details = $log_details . ($prev_booking['comments'] != $b['comments'] ? "comments = {$b['comments']}, " : "");
		$log_details = $log_details . ($prev_booking['price'] != $b['price'] ? "price = {$b['price']}, " : "");
		$log_details = $log_details . ($prev_booking['status'] != $b['status'] ? "status = {$b['status']}, " : "");
		
		if ($log_details != "")
		{
			$sqlString = "UPDATE legacy_bookings SET
					name = '{$b['name']}',
					email = '{$b['email']}',
					phone = '{$b['phone']}',
					activity = '{$b['activity']}',
					activityDate = '{$b['activityDate']}',
					numAdults = {$b['numAdults']},
					numChildren = {$b['numChildren']},
					foodRestrictions = '{$b['foodRestrictions']}',
					comments = '{$b['comments']}',
					price = {$b['price']},
					status = '{$b['status']}',
					lastUpdate = '$localDateTime'
				WHERE
					hash = '{$b['hash']}'";

			if(!$result = DB::statement($sqlString))
			{
				self::log_and_die($sqlString);
			}
			
			// add entry to bookings_log, if needed
			
			self::to_bookings_log($b['hash'], 'UPDATE', $log_details);
		}
				
		return true;
	}



	static function retrieve_activities($admin_user = FALSE)
	{
		
		if ($admin_user)
		{
			$sqlString = "SELECT * FROM activities";
		}
		else 
		{
			$sqlString = "SELECT * FROM legacy_activities WHERE visible = TRUE";
		}
			
		if(!$result = DB::select($sqlString))
			self::log_and_die($sqlString);
		
		return $result;
	}

	static function activity_by_shortcode($shortcode)
	{
		
		$sqlString = "SELECT activity FROM legacy_activities WHERE shortcode='$shortcode' LIMIT 1";
		
		if(!$result = DB::select($sqlString)) self::log_and_die($sqlString);
		

		$row = get_object_vars($result[0]);	

		return $row['activity'];
		
	}


	static function to_tpv_log($order, $description, $data, $amount, $response = '', $authCode = '', DateTime $timeStamp = null)
	{
		
		$sqlString = "SELECT ds_description FROM legacy_tpv_log WHERE ds_order='$order' LIMIT 1";
		
		if(!$selectResult = DB::select($sqlString))
		{
			// create entry
			$localDateTime = (new DateTime(null, new DateTimeZone('Europe/Madrid')))->format('Y-m-d H:i:s');
			$localdescription = strtr($description,"'\"","  ");
			
			$sqlString = "INSERT INTO legacy_tpv_log (
					ds_order,
					ds_description,
					ds_data,
					ds_amount,
					ds_response,
					ds_authorization,
					ds_last_update)
				VALUES (	
					'$order',
					'$localdescription',
					'$data',
					$amount,
					'request',
					'',
					'$localDateTime')";
			if(!$result = DB::statement($sqlString)) self::log_and_die($sqlString);				
		}
		else
		{
			// response from tpv
			
			$sqlString = "INSERT INTO legacy_tpv_log (
			ds_order,
			ds_description,
			ds_data,
			ds_amount,
			ds_response,
			ds_authorization,
			ds_last_update)
			VALUES (
			'$order',
			'{$selectResult[0]->ds_description}',
			'$data',
			$amount,
			'$response',
			'$authCode',
			'{$timeStamp->format('Y-m-d H:i:s')}')";
			
			// error_log($sqlString);
			if(!$result = DB::statement($sqlString)) self::log_and_die($sqlString);
		}
	}

	// static function tpv_configuration()
	// {
		
	// 	$sqlString = "SELECT * FROM legacy_tpv_configuration";
		
	// 	if(!$result = DB::select($sqlString)) self::log_and_die($sqlString);
		
	// 	$row = get_object_vars($result[0]);	
	// 	$row['url'] = ($row[mode] == 'PROD' ? $row['prodUrl'] : $row['testUrl']);
		
	// 	return $row;
		
	// }

}