<?php
class Sms extends TSController {

	protected function init() {
		$this->setTemplate('twiml-empty.tpl');
	}

	public function doDefault() {
		dbdLog($this->getParams());
		LastAction::logSms();
		self::getNotifyrClient()->publish(self::NOTIFYR_CHANNEL, $this->sanitize($this->getParam('Body')));
	}
}
