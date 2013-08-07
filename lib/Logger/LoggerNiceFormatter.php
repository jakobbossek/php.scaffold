<?php
	class Logger_LoggerNiceFormatter implements LoggerFormatter {
		public function format(LoggerEvent $event) {
			$event_data = $event->getEventAsHashMap();
			$event_level = Logger::getLevelDescription($event_data["type"]);
			$event_data = ucfirst($event_data["message"]) . " at " . $event_data["date"] . " (" . $event_data["type"] . "/" . $event_level . ")" . PHP_EOL;
			return $event_data;
		}
	}
?>