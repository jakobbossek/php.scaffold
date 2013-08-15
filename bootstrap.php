<?php
	require_once("lib/Autoload/Locator.php");
	require_once("lib/Autoload/LocatorQueue.php");
	require_once("lib/Autoload/LibLocator.php");
	require_once("config/config.php");
	require_once("helpers.php");

	LocatorQueue::enqueueLocator("oldlib", new LibLocator("oldlib"));
	LocatorQueue::enqueueLocator("lib", new LibLocator("lib"));
	LocatorQueue::enqueueLocator("app", new LibLocator("app/controllers"));

	spl_autoload_register(array('LocatorQueue', 'autoload'));

	$request = new Request_Http();
	$response = new Response_Http();

	require_once("routes.php");
	FrontController::handleRequest($request, $response);

	nice_dump($_SERVER, array("REQUEST_METHOD", "SCRIPT_NAME"));
?>