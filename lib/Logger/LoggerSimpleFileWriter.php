<?php
	class Logger_LoggerSimpleFileWriter implements LoggerWriter {
		private $logfile;
		private $mode;
		public function __construct($logfile, LoggerFormatter $formatter = null, $mode = 'ab') {
			$this->logfile = trim($logfile);
			$this->mode = $mode;
			/*
			 * Append mode parameter b to force binary mode 
			 * (see http://php.net/manual/de/function.fopen.php)
			 */
			if (substr($mode, -1) != "b") {
				$mode .= "b";
			}
			$this->formatter = (!is_null($formatter)) ? $formatter : new Logger_LoggerSimpleFormatter();
		}

		#@Override
		public function setFormatter(LoggerFormatter $formatter) {
			$this->formatter = $formatter;
		}

		#@Override
		public function logEvent(LoggerEvent $event) {
			$fd = fopen($this->logfile, $this->mode);
			if (!$fd) {
				echo "File " . $this->logfile . " is not readable.<br>";
				exit();
			}

			$output = $this->formatter->format($event);
			echo $output;
			if(!fwrite($fd, $output)) {
				echo "Writing to file " . $this->logfile . " failed!<br>";
				exit();
			}
			fclose($fd);
		}
	}
?>