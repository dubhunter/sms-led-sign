<?php
class Sms extends TSController {

	protected function init() {
		$this->setTemplate('twiml-empty.tpl');
	}

	public function doDefault() {
		dbdLog($this->getParams());
		LastAction::logSms();
//		self::publishNotifyr($this->getParam('Body'));
		self::publishFile($this->getParam('Body'));
	}
}
