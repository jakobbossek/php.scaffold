<?php
	/*
	 * PATH HELPERS
	 */

	/**
	 * Helper function for autoamtic generation of HTML links to (static) routes.
	 * 
	 * @param string $route
	 *   Route of the form some/route/.
	 * @param string $title
	 *   Link title.
	 * @param array $attributes
	 *   Optional assoziative array containing attribute => attribute_value mapping.
	 * @param boolean $secure
	 *   Should the SSL protocol be used?
	 *
	 * @return string
	 *   HTML link to specified route.
	 */
	function link_to($route, $title, $attributes = array(), $secure = false) {
		// build fully qulified URL
		$route = base_path() . str_trail($route, "/");
		$link = '<a href="' . $route . '"';

		// add attributes
		foreach ($attributes as $attr_name => $attr_value) {
			$link .= ' ' . $attr_name . '="' . $attr_value . '"';
		}
		$link .= '>' . $title . "</a>";
		return $link;
	}

	/**
	 * Returns the base path including the protocol and domain, i.e.,
	 * path of the form http://www.mydomain.com/path/to/app/
	 * 
	 * @param boolean $secure
	 *   Use https or not.
	 * 
	 * @return string
	 *   Base path.
	 */
	function base_path($secure = false) {
		// serve with SSL encryption or without
		$protocol = $secure ? "https://" : "http://";
		// delete protocol prefix
		$http_host = preg_replace("/^https?:\/\//i", "", $_SERVER['HTTP_HOST']);
		// extract path to root dir of application
		$request_uri = $_SERVER['SCRIPT_NAME']; // all stuff is processed on index.php in the root!
		$request_uri = substr($request_uri, 0, strrpos($request_uri, "/"));
		// put things together
		return $protocol . $http_host . str_trail($request_uri, "/");
	}

	/*
	 * STRING HELPERS
	 */

	/**
	 * Appends a trailing delimiter character to the given string, if this one
	 * is not already trailed by the delimiter
	 *
	 * @param string $string 
	 *   Source string.
	 * @param string $delimiter
	 *   Trailing character to append to source string.
	 *
	 * @return string
	 *   Modified string.
	 */
	function str_trail($string, $delimiter) {
		$delimiter = trim($delimiter);
		if (substr($string, -1) != $delimiter) {
			return $string . $delimiter;
		}
		return $string;
	}

	/*
	 * DEBUG HELPER FUNCTION
	 * (like amplified var_dump)
	 */
	
	/**
	 * Amplified version of the famous var_dump php build in function.
	 * Offers some nice color based emphasizing and gives the possibility
	 * to highlight specific elements, if given expression is (multidimensional)
	 * array.
	 * 
	 * @param mixed $expression
	 *   Exression to be dumped. For example array.
	 * @param array[string] $highlight_values
	 *   Array containing keys which should be highlighted for better identification.
	 * @param int $padding
	 *   Intendation depth in spaces (automatically amplified in deeper levels of arrays).
	 *
	 */
	function nice_dump($expression, $highlight_values = array(), $padding = 4) {
		// FIXME: add checks for other types.
		if (is_null($expression)) {
			return;
		}

		// the is the key working-horse
		if (is_array($expression)) {
			// handle empty array seperately
			if (empty($expression)) {
				echo "array()\n";
				return;
			}
			
			// start pre formatted content
			echo "<pre style='line-height: 1.7;'>\n";
			echo "<b style='background:#cfcfcf; border-radius: 3px; padding: 2px 5px; font-style:italic'>array</b>(" . count($expression) . ")\n";

			// we basically to depth-first-search in a tree here
			$stack = array();
			$depth_stack = array();

			// copy all value to the stack
			foreach ($expression as $key => $value) {
				array_unshift($stack, array($key, $value));
				array_unshift($depth_stack, 1);
			}

			// iterate until stack has no more elements
			while (!empty($stack)) {
				// get current element for processing
				$current = array_shift($stack);
				$depth = array_shift($depth_stack);

				// set space
				echo str_repeat(" ", $depth * $padding);

				// check if value of current element is array
				if (!is_array($current[1])) {
					// if not, print element, element type and highlight it if wished
					$style = (is_string($current[0]) & in_array($current[0], $highlight_values, false)) ? " style='color:#f47063'" : "";
					echo "<b>[<span" . $style . ">" . $current[0] . "</span></b> (" . gettype($current[1]) . ")<b>]</b> => " . $current[1] . "\n";
				} else {
					// if so, push children on stack and go on
					echo "<b style='background:#cfcfcf; border-radius: 3px; padding: 2px 5px; font-style:italic'>array</b>(" . count($current[1]) . ")\n";
					if (count($current[1]) > 0) {
						foreach ($current[1] as $key => $value) {
							array_unshift($stack, array($key, $value));
							array_unshift($depth_stack, $depth + 1);
						}
					}
				}
			}
			echo "</pre>";
		}
	}
?>