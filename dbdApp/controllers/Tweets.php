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

			if (count($response['statuses']) > 0) {
				$tweet = $response['statuses'][0];
				LastAction::logTweet($tweet['id']);
				$message = '@' . $tweet['user']['screen_name'] . ': ' . $tweet['text'];
//				self::publishNotifyr($message);
				self::publishFile($message);
			}
		}
	}
}
