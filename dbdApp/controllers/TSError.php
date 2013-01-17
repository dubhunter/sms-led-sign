<?php
class TSError extends TSController {
	public function doDefault() {
		dbdError::doError($this);
	}
}