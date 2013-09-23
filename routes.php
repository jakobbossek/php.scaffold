<?php
	/*
	 * Define routes here. Beyond there are some examples of routes
	 * with and without variable parameters.
	 *
	 * Keep in mind: syntatically correct routes have a trailing slash (/).
	 * Also keep in mind. If there are route definitions with 'matching clashes', the rule
	 * defined prior in the code is preferred.
	 */

	/* 
	 * Constant routes work fine on both controller methods and closures.
	 * Routes of these types are strings build up like directory pathes in common
	 * operating system, i. e., they have the form 'I/am/a/route/to/somewhere/'.
	 * They are restricted in power. If you need to register routes with parameters,
	 * see the next section for some examples on dynamic/parametrized routes.
	 */

	// ROOT route ;-)
	Routes::register("/", "DemoPresenter@index");

	// Simple root which is handled by the index method of the DemoPresenter class  
	Routes::register("demo/", "DemoPresenter@index");

	// This routes action is a even simpler closure. Mostly you will use this to indicate work in progress.
	Routes::register("user/closure/", function() { echo "SIMPLE CLOSURE."; });

	/*
	 * Dynamic routes with variables of type :num (integer) or :any (arbitrary strings) are accepted as
	 * well as arbitrary regular expressions. See the examples below to get in touch with this feature.
	 * Search the web for regular expressions if you are not familiar with this magic. 
	 */

	// Dynamic rule with one single integer parameter
	Routes::register("demo/(:num)/", function($id) {
		echo "Called page with ID: " . $id . "<br>";
	});

	// Dynamic rule with single alphanumeric (:any) parameter handled by a controller method
	// Do you see the route clash? Since each parameter of type :num is especially of tpe :any
	// integer parameters will be handled by the route above! Keep this always in mind!
	Routes::register("demo/(:any)/", "DemoPresenter@showid");

	// Route with specific variable form with regular expressions
	Routes::register("demo/([a-z]{3,5}){1}/task/(:num)/", function($text, $number) {
		echo "TEXT/NUMBER: " . $text . "/" .$number . "<br>";
	});
?>