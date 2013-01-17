<?php
class Sms extends TSController {

	const NOTIFYR_CHANNEL = 'sms';

	protected function init() {
		$this->setTemplate('twiml-empty.tpl');
	}

	public function doDefault() {
		dbdLog($this->getParams());
		$this->getNotifyrClient()->publish(self::NOTIFYR_CHANNEL, $this->getParam('Body'));
	}
}
