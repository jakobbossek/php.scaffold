<?php
	require_once("lib/Autoload/Locator.php");
	require_once("lib/Autoload/LocatorQueue.php");
	require_once("lib/Autoload/LibLocator.php");
	require_once("config/config.php");

	LocatorQueue::enqueueLocator("oldlib", new LibLocator("oldlib"));
	LocatorQueue::enqueueLocator("lib", new LibLocator("lib"));

	spl_autoload_register(array('LocatorQueue', 'autoload'));

	$request = new Request_Http();
	$response = new Response_Http();

	function nice_var_dump($expression) {
		echo "<pre>";
		var_dump($expression);
		echo "</pre>";
	}

	// init logger object
	// $logger = new Logger();
	// // define writer, which saves logs in a spefific way
	// $simpleWriter = new Logger_LoggerSimpleFileWriter("logs/logfile.csv");
	// $niceWriter = new Logger_LoggerSimpleFileWriter("logs/logfile.txt");
	// // the formatter defines the Format of the Log messages
	// $simpleFormatter = new Logger_LoggerSimpleFormatter();
	// $niceFormatter = new Logger_LoggerNiceFormatter();
	// $simpleWriter->setFormatter($simpleFormatter);
	// $niceWriter->setFormatter($niceFormatter);

	// $logger->addWriter("file_logger", $simpleWriter);
	// $logger->addWriter("file_logger_2", $niceWriter);
	// $logger->log("test_message", Logger::INFO);

	require_once("routes.php");
	FrontController2::handleRequest($request, $response);
?>