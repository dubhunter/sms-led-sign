<?php
class Godzilla extends TSController {

	public function doDefault() {
		$twilio	= self::getTwilioClient();
		$numbers = array(
			TWILIO_NUMBER_SIGN,
			TWILIO_NUMBER_HEADSUP,
		);
		foreach ($numbers as $number) {
			$sms = array(
				'From' => TWILIO_NUMBER_WILL,
				'To' => $number,
				'Body' => 'GODZILLA!!!',
			);
			$response = $twilio->request('/' . TWILIO_VERSION . '/Accounts/' . TWILIO_ACCOUNT_SID . '/SMS/Messages.json', 'POST', $sms);
			echo json_encode(json_decode($response->ResponseText), JSON_PRETTY_PRINT);
		}
	}
}
