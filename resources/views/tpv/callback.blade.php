<!DOCTYPE html> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
</head>


<body>

<?php

use App\Http\Controllers\RedsysAPI;
use App\Http\Controllers\Legacy\LegacyModel;

$Secret = config('cookingpoint.redsys.firma');


// new for HMAC SHA256 migration
$myObj = new RedsysAPI;
// $version = $_POST ['Ds_SignatureVersion'];
// $params = $_POST ['Ds_MerchantParameters'];
// $signatureRecibida = $_POST ['Ds_Signature'];
$expected_signature = $myObj->createMerchantSignatureNotif($Secret, $params);
$decodec = $myObj->decodeMerchantParameters($params);

$Ds_Date = $myObj->getParameter('Ds_Date');
$Ds_Hour = $myObj->getParameter('Ds_Hour');
$Ds_Amount = $myObj->getParameter('Ds_Amount');
$Ds_Currency = $myObj->getParameter('Ds_Currency');
$Ds_Order = $myObj->getParameter('Ds_Order');
$Ds_MerchantCode = $myObj->getParameter('Ds_MerchantCode');
$Ds_Terminal = $myObj->getParameter('Ds_Terminal');
$Ds_Response = $myObj->getParameter('Ds_Response');
$Ds_TransactionType = $myObj->getParameter('Ds_TransactionType');
$Ds_SecurePayment = $myObj->getParameter('Ds_SecurePayment');
$Ds_MerchantData = $myObj->getParameter('Ds_MerchantData');
$Ds_Card_Country = $myObj->getParameter('Ds_Card_Country');
$Ds_AuthorisationCode = $myObj->getParameter('Ds_AuthorisationCode');
$Ds_ConsumerLanguage = $myObj->getParameter('Ds_ConsumerLanguage');
$Ds_Card_Type = $myObj->getParameter('Ds_Card_Type');



if ($expected_signature != $signatureRecibida) {
	error_log ( "Signature not valid (hash: $Ds_MerchantData" );
	exit();
}

// to the log

$a = "$Ds_Date $Ds_Hour";
//error_log("la fecha y hora es: $a");
$madridTz = new DateTimeZone("Europe/Madrid");
$tpvDate = DateTime::createFromFormat("d/m/Y H:i", $a, $madridTz);

LegacyModel::to_tpv_log ( $Ds_Order, '', $Ds_MerchantData, $Ds_Amount, $Ds_Response, $Ds_AuthorisationCode, $tpvDate );


if ($Ds_Response < 100) 
{
	// update bookings table
	LegacyModel::update_booking_after_tpv($Ds_MerchantData, $Ds_Order, $Ds_Response, $tpvDate);
	$reserva = retrieve_booking($Ds_MerchantData);
	LegacyMail::mail_to_user($reserva, "legacy/status_PA");
 	$admin_mail_subject = "$reserva[activity] on $reserva[activityDate] for $reserva[numAdults]+$reserva[numChildren]";
 	LegacyMail::mail_to_admin($reserva, 'Payment', 'eduardo@cookingpoint.es', $admin_mail_subject, "legacy/admin_notice_PA.html");
	}
?>


</body>
</html>
