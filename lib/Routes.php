<?php
	/**
	 * Wrapper object for routes.
	 *
	 * Offers means to add new routes in a simple and convenient way.
	 */
	final class Routes {
		// save routes in array
		private static $routes = array();

		/**
		 * Register a new route.
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
		public static function register($route, $action, array $constraints = array()) {
			self::$routes[] = new Route($route, $action, $constraints);
		}

		/**
		 * Search for matching route and return action.
		 *
		 * @param string $actual_route
		 *   The route extracted from the query string.
		 *
		 * @return array
		 *   This array contains two elements. The first is either a callable object like
		 *   a function or clusure, or an array containig an controller object and a method 
		 *   which can be called on the object. The second element contains the parameters
		 *   which shall be forwarded to the action method or null if none provided.
		 *
		 * @see Route::getAction()
		 */
		public static function matches($actual_route) {
			foreach (self::$routes as $route) {
				if ($route->matches($actual_route)) {
					return $route->getAction();
				}
			}
			// FIXME: overthink this. Maybe better throw exception, or return false?
			return (array(function() {
				echo "No matching route found!<br>";
			}));
		}
	}

?>