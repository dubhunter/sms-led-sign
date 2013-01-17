<?php
class Stashboard extends TSController {

	const NOTIFYR_CHANNEL = 'sms';

	protected function init() {
		$this->noRender();
	}

	public function doDefault() {
		dbdLog($this->getParams());
		if ($this->getParam('challenge')) {
			echo $this->getParam('challenge');
		} else {
			$alarm = 'Off';
			if ($this->getParam('opened') && !$this->getParam('closed')) {
				$alarm = 'On';
			}
			dbdLog($alarm);
			$this->getNotifyrClient()->publish(self::NOTIFYR_CHANNEL, $alarm);
		}
	}
}
