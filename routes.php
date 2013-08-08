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

	// FIXME: there is a problem with the "/" route!!!
	Routes::set("/", "UserController@index");
	Routes::set("user/", "UserController@profile");
	Routes::set("user/closure/", function() { echo "SIMPLE CLOSURE."; });

	Routes::set("user/newuser/", "UserController@newuser");

	/*
	 * Dynamic routes (with variables)
	 */
	Routes::set(
		"user/{id}/{name}", 
		function($id, $name) { echo "USER: (" . $id . ", " . $name . ")"; },
		array("id" => "[0-9]+", "name" => "[a-z]+"));
?>