<?php

// require_once dirname( __FILE__ ) . '/vendor/autoload.php';

/**
 * Returns an authorized API client.
 * @return Google_Client the authorized client object
 */

namespace App\Http\Controllers\Legacy;

use Log;

class LegacyMail {

	function getClient() {
		$client = new Google_Client();
		$client->setApplicationName('Sends offline mail');
		$client->setScopes("https://www.googleapis.com/auth/gmail.send");
		$client->setAuthConfigFile(__DIR__ . '/client_secret.json');
		$client->setAccessType('offline');

		// Load previously authorized credentials from a file.
		$credentialsPath = '/home/cookingpoint/.credentials/gmail-php-client.json';
		if (file_exists($credentialsPath))
		{
			$accessToken = file_get_contents($credentialsPath);
		}
		else
		{
			// Request authorization from the user.
			$authUrl = $client->createAuthUrl();
			printf("Open the following link in your browser:\n%s\n", $authUrl);
			print 'Enter verification code: ';
			$authCode = trim(fgets(STDIN));

			// Exchange authorization code for an access token.
			$accessToken = $client->authenticate($authCode);

			// Store the credentials to disk.
			if(!file_exists(dirname($credentialsPath)))
			{
				mkdir(dirname($credentialsPath), 0700, true);
			}
			file_put_contents($credentialsPath, $accessToken);
			printf("Credentials saved to %s\n", $credentialsPath);
		}
		$client->setAccessToken($accessToken);

		// Refresh the token if it's expired.
		if ($client->isAccessTokenExpired())
		{
			$client->refreshToken($client->getRefreshToken());
			file_put_contents($credentialsPath, $client->getAccessToken());
		}
		return $client;
	}



	static function mail_to_user($r, $mail_template)
	{

		switch ($r['status']) {
			case 'CR':
			case 'NE':
				$common_subject = "Inquiry Received";
				break;
			case 'PE':
				$common_subject = "Your seat/s have been pre-booked";
				break;
			case 'PA':
				$common_subject = "Payment received, your booking is now confirmed";
				break;
		}
		
		
		$html_body = LegacyModel::set_booking_data($r, $mail_template . ".html");
		$txt_body = LegacyModel::set_booking_data($r, $mail_template . ".txt");
		
		// localhost version
		// error_log("mail sent to $r[email]. Text:");
		// error_log($mail_body);
		// return;
		
		// building mime message
		$envelope["from"]= 'Cooking Point <info@cookingpoint.es>';
		$envelope["to"]  = $r['email'];
		$envelope["subject"]  = $common_subject;
		
		$part1["type"] = TYPEMULTIPART;
		$part1["subtype"] = "alternative";
		
		$part2["type"] = TYPETEXT;
		$part2["subtype"] = "plain";
		$part2["description"] = "Cooking Point Booking Details";
		$part2["charset"] ="utf-8";
		$part2["contents.data"] = $txt_body;
		
		$part3["type"] = TYPETEXT;
		$part3["subtype"] = "html";
		$part3["description"] = "Cooking Point Booking Details";
		$part3["charset"] ="utf-8";
		$part3["contents.data"] = $html_body;
		
		$body[1] = $part1;
		$body[2] = $part2;
		$body[3] = $part3;
		
		$mime_message = imap_mail_compose($envelope, $body);
		
		// Make the call to the gmail API
		
		try
		{
			// $client = self::getClient();
			// $service = new Google_Service_Gmail($client);

			// $encoded = rtrim(strtr(base64_encode($mime_message), '+/', '-_'), '=');
			// $userId = 'me';
			// $message = new Google_Service_Gmail_Message();
			// $message->setRaw($encoded);
			// $result = $service->users_messages->send($userId, $message);
			Log::info($mime_message);
			if ($r['status'] == 'PE')
			{
				$details = 'emailText = '. $r[emailText];
			}
			else
			{
				$details = '';
			}
			LegacyModel::to_bookings_log($r['hash'],'EMAIL', $details);
							
		} 
		catch (Exception $e) 
		{
			error_log('An error occurred: ' . $e->getMessage());
		}
		

	}


	static function mail_to_admin($r, $from_string, $to_string, $subject_string, $mail_template)
	{

		$mail_body = LegacyModel::set_booking_data($r, $mail_template);

		// localhost version
		//error_log("mail sent to $r[email]. Text:");
		//error_log($mail_body);
		//return;

		// building mime message
		$envelope["from"]= $from_string . '<info@cookingpoint.es>';
		$envelope["to"]  = $to_string;
		$envelope["subject"]  = $subject_string;

		$part1["type"] = TYPEMULTIPART;
		$part1["subtype"] = "mixed";

		$part2["type"] = TYPETEXT;
		$part2["subtype"] = "html";
		$part2["description"] = "Payment Notice";
		$part2["charset"] ="utf-8";
		$part2["contents.data"] = $mail_body;

		$body[1] = $part1;
		$body[2] = $part2;

		$mime_message = imap_mail_compose($envelope, $body);


		try
		{
			// $client = self::getClient();
			// $service = new Google_Service_Gmail($client);

			// $encoded = rtrim(strtr(base64_encode($mime_message), '+/', '-_'), '=');
			// $userId = 'me';
			// $message = new Google_Service_Gmail_Message();
			// $message->setRaw($encoded);
			// $result = $service->users_messages->send($userId, $message);
			Log::info($mime_message);
							
		} 
		catch (Exception $e) 
		{
			error_log('An error occurred: ' . $e->getMessage());
		}
	}	
}