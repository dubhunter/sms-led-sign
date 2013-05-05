<?php
class Sms extends TSController {

	protected function init() {
		$this->setTemplate('twiml-empty.tpl');
	}

	public function doDefault() {
		dbdLog($this->getParams());
		self::getNotifyrClient()->publish(self::NOTIFYR_CHANNEL, $this->getParam('Body'));
	}
}
