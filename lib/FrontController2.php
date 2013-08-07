<?php
	final class FrontController2 {
		public static function handleRequest(Request $request, Response $response) {
			// set routes

			// constant routes work fine on both controllers and closures
			Routes::set("user/profile/", "UserController@profile");
			Routes::set("user/closure/", function() { echo "SIMPLE CLOSURE."; });

			// dynamic routes (with variables)
			Routes::set(
				"user/{id}/", 
				function($id) { echo "USER: " . $id; },
				array("id" => "[0-9]+"));

			// get query string (everything is pushed to the index2.php)
			echo "<b>" . $_SERVER['QUERY_STRING'] . "</b><br>";

			// just the stuff like blog/show/43/ is relevant
			$q = explode("=", $_SERVER['QUERY_STRING'])[1];

			// add trailing slash
			if (substr($q, -1) != "/") {
				$q .= "/";
			}

			// get matching route
			$res = Routes::matches($q);

			// what happens now? No matching route?
			if ($res === false) {
				return;
			}

			$params = (isset($res[1])) ? $res[1] : null;
			$action = $res[0];

			// closure? (move static is_function to helper file)
			if (self::is_function($action)) {
				if (is_array($params)) {
					call_user_func_array($action, $params);
				} else {
					$action();
				}
			}

			// action is method of controller object?
			if (is_array($action)) {
				// FIXME: rename this stuff
				$controller = $action[0];
				$act = $action[1];
				$controller->$act();
			}
		}

		// FIXME: move this to helper file
		public static function is_function($f) {
    		return (is_string($f) && function_exists($f)) || (is_object($f) && ($f instanceof Closure));
		}
	}


	final class Routes {
		// save routes in array
		private static $routes = array();

		// append new route
		public static function set($route, $action, array $constraints = array()) {
			self::$routes[] = new Route($route, $action, $constraints);
		}

		// search for matching route and return action
		public static function matches($actual_route) {
			foreach (self::$routes as $route) {
				if ($route->isAppropriate($actual_route)) {
					return $route->getAction();
				}
			}
			return (array(function() {
				echo "No matching route found!<br>";
			}));
		}
	}

	final class Route {
		private $route;
		private $action;
		private $constraints;
		private $params;
		private $q_params;

		public function __construct($route, $action, $constraints) {
			// check, if route contains variables
			preg_match("({.*})", $route, $matches);


			if (empty($matches)) {
				// if not it is a static route
				$this->route = $route;
			} else {
				// else only the first part forms rhe route
				// FIXME: what is with routes of the form blog/show/{id}?
				// Maybe set convention, that variable params must be the last
				// ones?
				$this->route = strstr($route, '/', true);
			}
			echo "ROUTE is set to " . $this->route . "<br>";

			// save parameters <param> of form {<param>} 
			foreach ($matches as $key => $value) {
				$this->params[] = str_replace(array("{","}"), "", $value);
			}

			// destinction of cases
			if (is_callable($action)) {
				// if closure, simply assign
				$this->action = $action;
			} else if (is_string($action)) {
				// if string of type controller@action split up and conquer
				$parts = explode("@", $action);
				$controller = $parts[0];
				if (!class_exists($controller)) {
					exit("Controller " . $controller . " does not exist.");
				}
				$action = $parts[1];
				if (!method_exists($controller, $action)) {
					exit("Action " . $action . " does not exist.");
				}
				$this->action = array(new $controller(), $action);
			}
			$this->constraints = $constraints;
		}

		public function isAppropriate($route) {
			#echo "Q is: " . $route . "<br>";
			#echo "ROUTE is: " . $this->route . "<br>";

			// if static route matches be happy and return
			if ($route == $this->route) {
				return true;
			}

			/* split query */
			$split_q = explode("/", $route);

			/* remove last empty element */
			unset($split_q[count($split_q)-1]);
			var_dump($split_q);
			echo "<br>";

			// check if static route part matches, for example user of user/{id}
			if ($this->route != $split_q[0]) {
				return false;
			}

			// check constraints 
			$sanity_passed = true;
			for ($i = 1; $i < count($split_q); $i++) {
				// FIMXE: constraints are not mandatory! Check if constraint exists!
				echo "(" . $split_q[$i] . ", " . $this->params[$i-1] . ")<br>";
				echo "Checking constraint " . $this->constraints[$this->params[$i-1]] . " on " . $split_q[$i] . "<br>";
				$sanity_passed &= preg_match("/" . $this->constraints[$this->params[$i-1]] . "/", $split_q[$i]);
			}
			if ($sanity_passed) {
				unset($split_q[0]);
				$this->q_params = $split_q;
			}
			return $sanity_passed;

			/* splitting query */

			#return false;
		}

		public function getAction() {
			return array($this->action, $this->q_params);
		}
	}
?>