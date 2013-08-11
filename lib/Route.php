<?php
	/**
	 * Route represents a route and the linked action if the route is called.
	 */
	final class Route {
		/* static route part, i.e., with no variable parameters */
		private $route_pattern;
		
		/*
		 * provided action. Either an array with controller object and action method,
		 * or a function/closure.
		 */
		private $action;
		
		/*
		 * Assoziative array of constraints for the variable parameters. If there is a
		 * parameter {id}, then $constraints['id'] contains a string which is used in 
		 * a regular expression to restrict the possible values of id.
		 */
		private $constraints;
		
		/*
		 * Dynamic part of the route. Maybe empty, if route is plain static. Otherwise it contains
		 * a numeric array with the names of the variable parmeters.
		 */
		private $params;

		/*
		 * Actual parameters extracted from the query string.
		 * FIXME: outsource this eventually in special callee object.
		 */
		private $q_params;

		/**
		 * Generates a new route.
		 *
		 * @param string $route
		 *   String containing the route.
		 * @param $action (function|closure|string)
		 *   Action to be performed on this route. Either a simple function/closure 
		 *   or a String of the form "Controller@action".
		 * @param $constraints array[string]
		 *   Array of constraints. Each constraint is bind to a variable route parameter
		 *   and restricts the type to a regular expression.	 
		 */
		public function __construct($route, $action, $constraints) {
			// remove trailing slash (/)
			if (substr($route, -1) == "/") {
				$route = substr($route, 0, strrpos($route, '/'));
			}

			// not more static and dynamic part shit
			// make regex pattern out of route. Much more flexible way!
			$route_pattern = str_replace("/", "\/", $route);
			$route_pattern = str_replace("(:num)", "([0-9]+){1}", $route_pattern);
			$route_pattern = str_replace("(:any)", "([a-zA-Z0-9]+){1}", $route_pattern);
			$route_pattern = "/^" . $route_pattern . "$/";

			#echo "ROUTE PATTERN: " . $route_pattern . "<br>";
			$this->route_pattern = $route_pattern;

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

		public function matches($route) {
			if (substr($route, -1) == "/") {
				$route = substr($route, 0, strrpos($route, '/'));
			}
			$m = preg_match($this->route_pattern, $route, $matches);

			if ($m === false) {
				return $m;
			} 
			// FIXME: saving actual parameters in route object is not intuitive. Outsource this!
			$this->q_params = array_slice($matches, 1);

			// if static route matches be happy and return
			nice_dump($matches);
			nice_dump($this->q_params);

			return ($m === 1); 
		}

		public function getAction() {
			return array($this->action, $this->q_params);
		}
	}
?>