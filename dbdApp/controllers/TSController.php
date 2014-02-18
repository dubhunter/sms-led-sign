<?php
class TSController extends dbdController {

	const TWILIO_CREDENTIALS = 'constant/twilio.inc';
	const TWITTER_CREDENTIALS = 'constant/twitter.inc';
	const NOTIFYR_CREDENTIALS = 'constant/notifyr.inc';
	const NOTIFYR_CHANNEL = 'sms';
	const MESSAGE_FILE = 'message.txt';

	/**
	 * @var null|Twitter
	 */
	private static $twitter_client = null;

	/**
	 * @var null|TwilioRestClient
	 */
	private static $twilio_client = null;

	/**
	 * @var null|NotifyrClient
	 */
	private static $notifyr_client = null;

	/**
	 * @throws TSException
	 * @return TwilioRestClient
	 */
	protected static function getTwilioClient() {
		if (self::$twilio_client === null) {
			// if we don't have the creds, try to load them
			if (!(defined('TWILIO_ACCOUNT_SID') && defined('TWILIO_AUTH_TOKEN'))) {
				dbdLoader::load(self::TWILIO_CREDENTIALS);
				// if we still don't have 'em, throw
				if (!(defined('TWILIO_ACCOUNT_SID') && defined('TWILIO_AUTH_TOKEN'))) {
					throw new TSException("Twilio credentials file could not be included. PATH=" . self::TWILIO_CREDENTIALS);
				}
			}
			self::$twilio_client = new TwilioRestClient(TWILIO_ACCOUNT_SID, TWILIO_AUTH_TOKEN);
		}
		return self::$twilio_client;
	}

	/**
	 * @throws TSException
	 * @return Twitter
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
			self::$twitter_client = new Twitter(TWITTER_CONSUMER_KEY, TWITTER_CONSUMER_SECRET, TWITTER_ACCESS_TOKEN, TWITTER_ACCESS_TOKEN_SECRET);
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

	/**
	 * Strip non-printable characters.
	 * @param $str
	 * @return mixed
	 */
	protected static function sanitize($str) {
		return preg_replace('/[^ -~]/', '', $str);
	}

	/**
	 * Sanitize and publish a message to Notifyr
	 * @param $message
	 */
	protected static function publishNotifyr($message) {
		self::getNotifyrClient()->publish(self::NOTIFYR_CHANNEL, self::sanitize($message));
	}

	/**
	 * Sanitize and publish a message to a file
	 * @param $message
	 */
	protected static function publishFile($message) {
		$file = DBD_DOC_ROOT . '/' . self::MESSAGE_FILE;
		file_put_contents($file, 'data: "' . self::sanitize($message) . '"' . PHP_EOL . PHP_EOL);
	}
}
