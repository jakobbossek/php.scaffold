<?php
	/**
	 * Frontcontroller gets the request and handles the forwarding to 
	 * request control elements, i.e., methods of controller classes or
	 * simple functions/closures.
	 *
	 * The FrontController is initiated once in the bootstrap respectivly 
	 * index file. The configuration in the .htaccess file ensures, that all
	 * requests of the type www.domain.com/this/is/a/path are related to
	 * index.php?q=this/is/a/path. Simply speaking the frontcontroller handles
	 * the processing of the q parameter. 
	 *
	 * @param Request $request 
	 *   (HTTP) request object.
	 * @param Response $response
	 *   (HTTP) response object.
	 */
	final class FrontController {
		public static function handleRequest(Request $request, Response $response) {
			// just the stuff like blog/show/43/ is relevant
			$q = $_SERVER['QUERY_STRING'];
			if ($q != "") {
				$q = explode("=", $_SERVER['QUERY_STRING'])[1];	
			}

			// add trailing slash to query (all correct routes end with a slash)
			if (substr($q, -1) != "/") {
				$q .= "/";
			}

			// get matching route
			$res = Routes::matches($q);

			// No matching route?
			if ($res === false) {
				// FIXME: return is not enough. "Redirect" to /
				return;
			}

			$params = (isset($res[1])) ? $res[1] : null;
			$action = $res[0];

			// closure? (move static is_function to helper file)
			if (isFunction($action)) {
				if (is_array($params)) {
					call_user_func_array($action, $params);
				} else {
					$action();
				}
			}

			// action is method of controller object?
			if (is_array($action)) {
				$controller = $action[0];
				$act = $action[1];
				if (is_array($params)) {
					// there are params of type {param} in query string
					call_user_func_array(array($controller, $act), $params);
				} else {
					// there are no params
					$controller->$act();
				}	
			}
		}
	}
?>