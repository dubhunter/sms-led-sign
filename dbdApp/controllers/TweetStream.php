<?php
class TweetStream extends TSController {

	protected function init() {
		$this->noRender();
	}

	public function doDefault() {
//		//Set the ticks
//		declare(ticks = 1);
//
//		//Fork the current process
//		$processID = pcntl_fork();
//
//		//Check to make sure if forked ok.
//		if ($processID == -1) {
//			echo "\n Error:  The process failed to fork. \n";
//		} else if ($processID) {
//			//This is the parent process.
//			exit;
//		} else {
//			//We're now in the child process.
//		}
//
//		//Now, we detach from the terminal window, so that we stay alive when
//		//it is closed.
//		if (posix_setsid() == -1) {
//			echo "\n Error: Unable to detach from the terminal window. \n";
//		}
//
//		//Get out process id now that we've detached from the window.
//		$posixProcessID = posix_getpid();
//
//		//Create a new file with the process id in it.
//		$filePointer = fopen("/var/run/php/twilio-sign-tweet-stream.pid", "w");
//		fwrite($filePointer, $posixProcessID);
//		fclose($filePointer);

		//Now, do something forever.
		$method = 'https://stream.twitter.com/1.1/statuses/filter.json';

		$params = array(
			'track' => 'twilio,hyduino',
//			'follow' => '138862289',
			'follow' => '1118284267',
		);

		self::getTwitterClient()->streaming_request('POST', $method, $params, function ($data, $length, $metrics) {
			$data = json_decode($data, true);
			dbdLog($data);
			dbdLog($length);
			dbdLog($metrics);
			self::getNotifyrClient()->publish(self::NOTIFYR_CHANNEL, $data['text']);
		});
	}
}
