<?php
class TSController extends dbdController {

	const NOTIFYR_KEY = 'JTnrOhQhR4d38Kue7YvezCbETms7r4xS7iX2njULmE0';
	const NOTIFYR_SMS_PERMIT = 'HJkF7XJ4EDTITciD6W1idiTdyS9SPDalm5zPKOcaDTE';

	/**
	 * @var null|NotifyrClient
	 */
	protected $notifyr_client = null;

	/**
	 * @return NotifyrClient
	 */
	protected function getNotifyrClient() {
		if ($this->notifyr_client === null) {
			$this->notifyr_client = new NotifyrClient(self::NOTIFYR_KEY, self::NOTIFYR_SMS_PERMIT);
		}
		return $this->notifyr_client;
	}
}
