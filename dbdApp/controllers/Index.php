<?php
class Index extends TSController {

	const NOTIFYR_CHANNEL = 'sms';

	protected function init() {
		$this->noRender();
	}

	public function doSms() {
		dbdLog($this->getParams());
		$this->getNotifyrClient()->publish(self::NOTIFYR_CHANNEL, $this->getParam('Body'));
	}
}
