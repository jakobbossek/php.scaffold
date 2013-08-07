<?php
	interface LoggerFormatter {
		public function format(LoggerEvent $event);
	}
?>