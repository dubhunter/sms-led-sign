<?php
class TSController extends dbdController {

	const TWITTER_CREDENTIALS = 'constant/twitter.inc';
	const NOTIFYR_CREDENTIALS = 'constant/notifyr.inc';
	const NOTIFYR_CHANNEL = 'sms';

	/**
	 * @var null|Twitter
	 */
	private static $twitter_client = null;

	/**
	 * @var null|NotifyrClient
	 */
	private static $notifyr_client = null;

	/**
	 * @throws TSException
	 * @return tmhOAuth
	 */
	protected static function getTwitterClient() {
		if (self::$twitter_client === null) {
			// if we don't have the creds, try to load them
			if (!(defined('TWITTER_CONSUMER_KEY') && defined('TWITTER_CONSUMER_SECRET') && defined('TWITTER_ACCESS_TOKEN') && defined('TWITTER_ACCESS_TOKEN_SECRET'))) {
				dbdLoader::load(self::TWITTER_CREDENTIALS);
				// if we still don't have 'em, throw
				if (!(defined('TWITTER_CONSUMER_KEY') && defined('TWITTER_CONSUMER_SECRET') && defined('TWITTER_ACCESS_TOKEN') && defined('TWITTER_ACCESS_TOKEN_SECRET'))) {
					throw new TSException("Twilio credentials file could not be included. PATH=" . self::TWITTER_CREDENTIALS);
				}
			}
			self::$twitter_client = new tmhOAuth(array(
				'consumer_key'    => TWITTER_CONSUMER_KEY,
				'consumer_secret' => TWITTER_CONSUMER_SECRET,
				'user_token'      => TWITTER_ACCESS_TOKEN,
				'user_secret'     => TWITTER_ACCESS_TOKEN_SECRET,
			));
		}
		return self::$twitter_client;
	}

	/**
	 * @throws TSException
	 * @return NotifyrClient
	 */
	protected static function getNotifyrClient() {
		if (self::$notifyr_client === null) {
			// if we don't have the creds, try to load them
			if (!(defined('NOTIFYR_KEY') && defined('NOTIFYR_SMS_PERMIT'))) {
				dbdLoader::load(self::NOTIFYR_CREDENTIALS);
				// if we still don't have 'em, throw
				if (!(defined('NOTIFYR_KEY') && defined('NOTIFYR_SMS_PERMIT'))) {
					throw new TSException("Notifyr credentials file could not be included. PATH=" . self::NOTIFYR_CREDENTIALS);
				}
			}
			self::$notifyr_client = new NotifyrClient(NOTIFYR_KEY, NOTIFYR_SMS_PERMIT);
		}
		return self::$notifyr_client;
	}
}
