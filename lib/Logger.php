<?php
	final class Logger {
		const INFO = 1;

		private static $levels = array(
			1 => "info",
			2 => "warning",
			3 => "fatal"
			);

		private $writer = array();

		public function addWriter($key, LoggerWriter $writer) {
			if (!array_key_exists($key, $this->writer)) {
				$this->writer[$key] = $writer;	
			}
		}

		public function removeWriter($key) {
			unset($this->writer[$key]);
		}

		public function log($message, $type = Logger::INFO) {
			$date = date('h:m:s');
			$logger_event = new LoggerEvent($message, $type, $date);
			foreach ($this->writer as $writer_key => $writer) {
				echo "Writing with logger " . $writer_key . "<br>";
				$writer->logEvent($logger_event);
			}
		}

		public static function getLevelDescription($level) {
			return self::$levels[$level];
		}

	}