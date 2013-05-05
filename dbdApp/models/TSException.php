<?php
class TSException extends dbdHoldableException {

	private static $msgs = array();

	public function __construct($code = 0) {
		parent::__construct(self::g($code), $code);
	}

	public static function setMsgArray($msgs) {
		self::$msgs = is_array($msgs) ? $msgs : array();
	}

	public static function g($code) {
		$key = "error" . $code;
		return isset(self::$msgs[$key]) ? self::$msgs[$key] : get_class() . ": Message for code " . $code . " could not be found.";
	}

	public static function ensure($expr, $code) {
		if (!$expr) {
			self::intercept(new self($code));
		}
	}
}