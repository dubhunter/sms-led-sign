<?php
class Stashboard extends TSController {

	const NOTIFYR_CHANNEL = 'sms';

	protected function init() {
		$this->noRender();
	}

	public function doDefault() {
		dbdLog($this->getParams());
		if ($this->getParam('hub_challenge') && $this->getParam('hub_mode') == 'subscribe') {
			echo $this->getParam('hub_challenge');
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
