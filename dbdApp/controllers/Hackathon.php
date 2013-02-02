<?php
class Hackathon extends TSController {

	protected function init() {
		$this->noRender();
	}

	public function doDefault() {
		dbdLog($this->getParams());
		$from = $this->getParam('From');
		$vote = (int) $this->getParam('Body');

		if (Vote::getCount(array('from' => $from)) == 0) {
			$V = new Vote();
			$V->setFrom($from);
			$V->setVote($vote);
			$V->save();
		}
	}
}
