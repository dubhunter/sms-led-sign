<?php
class Stashboard extends TSController {

	const NOTIFYR_CHANNEL = 'sms';

	protected function init() {
		$this->noRender();
	}

	public function doDefault() {
		dbdLog($this->getParams());
		if ($this->getParam('hub.challenge') && $this->getParam('hub.mode') == 'subscribe') {
			echo $this->getParam('challenge');
		} else {
			$payload = $this->getParam('payload');
			$payload = json_decode($payload);
			dbdLog($payload);
			$alarm = 'off';
			if ($payload['opened'] && !$payload['closed']) {
				$alarm = 'on';
			}
			dbdLog($alarm);
			$this->getNotifyrClient()->publish(self::NOTIFYR_CHANNEL, $alarm);
		}
	}
}
