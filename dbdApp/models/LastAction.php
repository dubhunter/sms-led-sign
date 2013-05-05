<?php
class LastAction {
	const TABLE_NAME = 'last_actions';
	/**
	 * @var dbdDB
	 */
	protected static $db = null;
	/**
	 * @var LastAction
	 */
	protected static $instance = null;
	protected $last_sms = 0;
	protected $last_tweet = 0;

	protected function __construct() {
		self::$db = dbdDB::getInstance();
		$sql = "select * from `" . self::TABLE_NAME . "`";
		list($this->last_sms, $this->last_tweet) = self::$db->prepExec($sql)->fetch();
	}

	protected static function getInstance() {
		if (self::$instance === null) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public static function getLastSms() {
		return self::getInstance()->last_sms;
	}

	public static function getLastTweet() {
		return self::getInstance()->last_tweet;
	}

	public static function logSms() {
		self::$db = dbdDB::getInstance();
		$sql = "update `" . self::TABLE_NAME . "` set last_sms = ?";
		self::$db->prepExec($sql, array(dbdDB::date()))->execute();
	}

	public static function logTweet($id) {
		self::$db = dbdDB::getInstance();
		$sql = "update `" . self::TABLE_NAME . "` set last_tweet = ?";
		self::$db->prepExec($sql, array($id))->execute();
	}
}
