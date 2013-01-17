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
			$alarm = 'off';
			if ($this->getParam('opened') && !$this->getParam('closed')) {
				$alarm = 'on';
			}
			dbdLog($alarm);
			$this->getNotifyrClient()->publish(self::NOTIFYR_CHANNEL, $alarm);
		}
	}
}
