<?php
	interface LoggerWriter {
		public function logEvent(LoggerEvent $event);
		public function setFormatter(LoggerFormatter $formatter);
	}
?>