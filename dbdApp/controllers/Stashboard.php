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
			$this->getNotifyrClient()->publish(self::NOTIFYR_CHANNEL, $this->getParam('closed') ? 0 : 1);
		}
	}
}
