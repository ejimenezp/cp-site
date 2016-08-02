<!DOCTYPE html> 
<html xmlns="http://www.w3.org/1999/xhtml"> 

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">    
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
	<meta http-equiv="expires" content="-1">
	<meta http-equiv="Pragma" content="no-cache" />
	<meta http-equiv="Cache-Control" content="no-cache,must-revalidate" />
</head>

<body>

<?php

	function random_order()
	{
		$characters = '0123456789';
		$result = '';
		$charactersLength = strlen($characters);
		for ($i = 0; $i < 12; $i++)
		{
		    $result .= $characters[rand(0, $charactersLength - 1)];
		}
		return $result;
	}


	use App\Http\Controllers\RedsysAPI;
	use App\Http\Controllers\Legacy\LegacyModel;

	$Secret = config('cookingpoint.redsys.firma');

	$Ds_Merchant_ProductDescription = LegacyModel::activity_by_shortcode ( $reserva ['activity'] ) . " on {$reserva['activityDate']} for {$reserva['numAdults']} adults";
	if ($reserva ['numChildren'] > 0) {
		$Ds_Merchant_ProductDescription .= " + {$reserva['numChildren']} children";
	}
	$Ds_Merchant_ProductDescription .= " under {$reserva['name']}";

	$Ds_Merchant_Amount = $reserva['price'] * 100;
	$Ds_Merchant_Currency = '978';
	$Ds_Merchant_Order = random_order();
	$Ds_Merchant_MerchantURL = config('cookingpoint.redsys.merchanturl');
	$Ds_Merchant_UrlOK = env('APP_URL' ,'http://cookingpoint.es'). "/bookings/" . $reserva ['hash'] . '/OK';
	$Ds_Merchant_UrlKO = env('APP_URL' ,'http://cookingpoint.es'). "/bookings/" . $reserva ['hash'] . '/KO';
	$Ds_Merchant_MerchantName = config('cookingpoint.redsys.nombrecomercio');
	$Ds_Merchant_ConsumerLanguage = '002';
	$Ds_Merchant_MerchantCode = config('cookingpoint.redsys.fuc');;
	$Ds_Merchant_Terminal = '001';
	$Ds_Merchant_MerchantData = $reserva['hash'];
	$Ds_Merchant_TransactionType = '0';
	$Ds_Merchant_AuthorisationCode = '';


	// new for HMAC SHA256 migration
	$myObj = new RedsysAPI;
	unset($myObj->middleware);
	unset($myObj->validatesRequestErrorBag);

	$myObj->setParameter("DS_MERCHANT_AMOUNT", $Ds_Merchant_Amount);
	$myObj->setParameter("DS_MERCHANT_ORDER", $Ds_Merchant_Order);
	$myObj->setParameter("DS_MERCHANT_PRODUCTDESCRIPTION", $Ds_Merchant_ProductDescription);
	$myObj->setParameter("DS_MERCHANT_MERCHANTCODE", $Ds_Merchant_MerchantCode);
	$myObj->setParameter("DS_MERCHANT_CURRENCY", $Ds_Merchant_Currency);
	$myObj->setParameter("DS_MERCHANT_TRANSACTIONTYPE", $Ds_Merchant_TransactionType);
	$myObj->setParameter("DS_MERCHANT_TERMINAL", $Ds_Merchant_Terminal);
	$myObj->setParameter("DS_MERCHANT_MERCHANTURL", $Ds_Merchant_MerchantURL);
	$myObj->setParameter("DS_MERCHANT_URLOK", $Ds_Merchant_UrlOK);
	$myObj->setParameter("DS_MERCHANT_URLKO", $Ds_Merchant_UrlKO);
	$myObj->setParameter("DS_MERCHANT_MERCHANTNAME", $Ds_Merchant_MerchantName);
	$myObj->setParameter("DS_MERCHANT_CONSUMERLANGUAGE", $Ds_Merchant_ConsumerLanguage);
	$myObj->setParameter("DS_MERCHANT_MERCHANTDATA", $Ds_Merchant_MerchantData);
	$myObj->setParameter("DS_MERCHANT_AUTHORISATIONCODE", $Ds_Merchant_AuthorisationCode);


	$params = $myObj->createMerchantParameters();
	$signature = $myObj->createMerchantSignature($Secret);

	// to the log
	LegacyModel::to_tpv_log($Ds_Merchant_Order, $Ds_Merchant_ProductDescription, $Ds_Merchant_MerchantData, $Ds_Merchant_Amount);

	// end php
	?>  


	<form name="TPVFORM" method="post" action=" {{ config('cookingpoint.redsys.url') }}">

		<input type="hidden" name="Ds_SignatureVersion" value="HMAC_SHA256_V1" />
		<input type="hidden" name="Ds_MerchantParameters" value="{{ $params }}" />
		<input type="hidden" name="Ds_Signature" value="{{ $signature }}" />
		<input type="submit" value="Pay" />
		
	</form>
</body>

<script>
   document.TPVFORM.submit();
</script>

</html>
