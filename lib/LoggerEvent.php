<?php
	class LoggerEvent {
		private $message = null;
		private $date = null;
		private $type = null;

		public function __construct($message, $type = null, $date = null) {
			$this->message = trim($message);
			$this->type = is_null($type) ? Logger::INFO : $type;
			$this->date = is_null($date) ? date('d.m.Y_h:m:s') : $date;
		}

		public function getEventAsHashMap() {
			$a = array(
				"message" => $this->message,
				"type" => $this->type,
				"date" => $this->date);
			return $a;
		}
	}
?>