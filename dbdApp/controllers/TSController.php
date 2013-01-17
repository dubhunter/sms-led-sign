<?php
class TSController extends dbdController {

	const NOTIFYR_CREDENTIALS = 'constant/notifyr.inc';

	/**
	 * @var null|NotifyrClient
	 */
	protected $notifyr_client = null;

	/**
	 * @return NotifyrClient
	 */
	protected function getNotifyrClient() {
		if ($this->notifyr_client === null) {
			// if we don't have the creds, try to load them
			if (!(NOTIFYR_KEY && NOTIFYR_SMS_PERMIT)) {
				dbdLoader::load(self::NOTIFYR_CREDENTIALS);
				// if we still don't have 'em, throw
				if (!(NOTIFYR_KEY && NOTIFYR_SMS_PERMIT)) {
					throw new dbdException("Notifyr credentials file could not be included. PATH=" . self::NOTIFYR_CREDENTIALS);
				}
			}
			$this->notifyr_client = new NotifyrClient(NOTIFYR_KEY, NOTIFYR_SMS_PERMIT);
		}
		return $this->notifyr_client;
	}
}
