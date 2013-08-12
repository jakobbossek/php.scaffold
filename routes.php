<?php
	/*
	 * Define routes here. Beyond there are some examples of routes
	 * with and without variable parameters.
	 *
	 * Keep in mind: syntatically correct routes have a trailing slash (/). 
	 */

	/* 
	 * Constant routes work fine on both controllers and closures.
	 */

	Routes::register("demo/", "DemoPresenter@index");

	Routes::register("/", "UserController@index");
	Routes::register("user/", "UserController@profile");
	Routes::register("user/closure/", function() { echo "SIMPLE CLOSURE."; });

	Routes::register("user/newuser/", "UserController@newuser");

	/*
	 * Dynamic routes (with variables)
	 */

	// route with predefined variable form
	Routes::register("user/(:num)/task/(:any)/", function($id, $task_id) {
		echo "USER/TASK: " . $id . "/" . $task_id . "<br>";
	});

	// Route with specific variable form with regular expressions
	Routes::register("user/([a-z]{3,5}){1}/task/(:num)/", function($text, $number) {
		echo "TEXT/NUMBER: " . $text . "/" .$number . "<br>";
	});
?>