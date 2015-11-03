<?php
class Godzilla extends TSController {

	const FIRE_HOUR = 12;

	public function doDefault() {
		if (date('H') != self::FIRE_HOUR) {
			return false;
		}

		$twilio	= self::getTwilioClient();
		$numbers = array(
			TWILIO_NUMBER_SIGN,
			TWILIO_NUMBER_HEADSUP,
		);
		foreach ($numbers as $number) {
			$sms = array(
				'From' => TWILIO_NUMBER_GODZILLA,
				'To' => $number,
				'Body' => 'GODZILLA!!!',
			);
			$response = $twilio->request('/' . TWILIO_VERSION . '/Accounts/' . TWILIO_ACCOUNT_SID . '/Messages', 'POST', $sms);
			echo json_encode($response->ResponseXml, JSON_PRETTY_PRINT) . PHP_EOL;
		}
	}
}
