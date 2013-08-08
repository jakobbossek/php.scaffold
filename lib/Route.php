<?php
	/**
	 * Route represents a route and the linked action if the route is called.
	 */
	final class Route {
		/* static route part, i.e., with no variable parameters */
		private $static_route_part;
		
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

			// init static and dynamic part of route
			$static = "";
			$dynamic = array();

			// split route by slash symbol
			$route_parts = explode("/", $route);
			#nice_var_dump($route_parts);

			/* 
			 * for each part check whether it belongs to the first (static) part 
			 * or a variable of the form {var}.
			 */
			foreach ($route_parts as $part) {
				if (preg_match("/^{.*}$/", $part)) {
					// save parameters <param> of form {<param>} 
					$dynamic[] = str_replace(array("{", "}"), "", $part);
				} else {
					// set static part
					$static .= $part . "/";
				}
			}

			
			$this->static_route_part = $static;
			$this->params = $dynamic;

			#echo "ROUTE is set to " . $this->static_route_part. "<br>";

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
			if (substr($route, -1) == "/") {
				$route = substr($route, 0, strrpos($route, '/'));
			}

			/* split query */
			$split_q = explode("/", $route);

			// if static route matches be happy and return
			nice_var_dump($split_q);

			// matching static part
			$i = 0;
			$sanity_passed = false;
			for (; $i < count($split_q); ++$i) {
				#echo "i is " . $i . "<br>";
				$route_part_to_check = implode("/", array_slice($split_q, 0, $i+1)) . "/";
				#echo "Checking route part " . $route_part_to_check . "<br>";
				if ($this->static_route_part == $route_part_to_check) {
					$sanity_passed = true; 
					break;
				}
			}
			
			if (!$sanity_passed) {
				return false;
			}

			// check if static route part matches, for example user of user/{id}
			if ($sanity_passed & $i == count($split_q)) {
				echo "FOUND matching static route " . $this->static_route_part ." " . $i . "<br>";
				return true;
			}
			
			// check constraints 
			$sanity_passed = true;
			for ($j = $i+1, $k = $j-($i+1); $j < count($split_q) & $k < count($this->params); $j++, $k++) {
				// FIMXE: constraints are not mandatory! Check if constraint exists!
				echo "(" . $split_q[$j] . ", " . $this->params[$k] . ")<br>";
				if (isset($this->constraints[$this->params[$k]])) {
					echo "Checking constraint " . $this->constraints[$this->params[$k]] . " on " . $split_q[$j] . "<br>";
					$sanity_passed &= preg_match("/^" . $this->constraints[$this->params[$k]] . "$/i", $split_q[$j]);
				}
			}

			if ($sanity_passed && ($j == count($split_q)) && ($k == count($this->params))) {
				$this->q_params = array_splice($split_q, $i+1);
				nice_var_dump($this->q_params);
				return $sanity_passed;
			}

			return false;
		}

		public function getAction() {
			return array($this->action, $this->q_params);
		}
	}
?>