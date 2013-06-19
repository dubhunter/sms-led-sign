<?php
class Tweets extends TSController {

	const SMS_TIMEOUT = 60;

	protected function init() {
		$this->noRender();
	}

	public function doDefault() {
		if (time() - strtotime(LastAction::getLastSms()) > self::SMS_TIMEOUT) {
			$response = self::getTwitterClient()->get('search/tweets', array(
				'q' => 'twilio',
				'count' => '1',
				'lang' => 'en',
				'since_id' => LastAction::getLastTweet(),
			));

			dbdLog($response);

//			$data = json_decode($response->text, true);

//			if (count($data['results']) > 0) {
//				LastAction::logTweet($data['results'][0]['id']);
//				self::getNotifyrClient()->publish(self::NOTIFYR_CHANNEL, '@' . $data['results'][0]['from_user'] . ': ' .$data['results'][0]['text']);
//			}
		}
	}
}
