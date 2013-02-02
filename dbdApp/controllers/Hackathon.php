<?php
class Hackathon extends TSController {

	protected function init() {
		$this->noRender();
	}

	public function doDefault() {
		dbdLog($this->getParams());
		$from = $this->getParam('From');
		$vote = $this->getParam('Body');

		if (is_numeric($vote) && Vote::getCount(array('from' => $from)) < 5 && Vote::getCount(array('from' => $from, 'vote' => $vote)) == 0) {
			$V = new Vote();
			$V->setFrom($from);
			$V->setVote($vote);
			$V->save();
		}
	}
}
