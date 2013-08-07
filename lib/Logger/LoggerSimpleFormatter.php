<?php
	class Logger_LoggerSimpleFormatter implements LoggerFormatter {
		public function format(LoggerEvent $event) {
			if (is_null($event)) {
				exit("There is no event object!<br>");
			}
			$event_data = array_values($event->getEventAsHashMap());
			$event_data = implode(",", $event_data) . PHP_EOL;
			return $event_data;
		}
	}
?>