<?php
	/**
	 * Form helper class.
	 * 
	 * Offers some neat functions to open/close HTML forms, set labels
	 * and generate all imaginable type of form elements.
	 * 
	 * (This class is not meant to be extended.)
	 */
	final class Form {
		public static function open($action, $method = "POST", $file = false, $params = array()) {
			$method = strtoupper($method);
			// sanity checks
			// FIXME: later add support for PUT, DELETE, ...
			if (!in_array($method, array("GET", "POST"))) {
				die("Unsupported HTTP method type " . $method . " provided to form.");
			}
			$form = "<form";
			// add optional params like id, name or css inline styles
			if (isset($params) AND !empty($params)) {
				foreach ($params as $param_name => $param_value) {
					$form .= ' ' . $param_name . '="' . $param_value . '"';
				}
			}

			$form .= ' action="' . $action . '"';
			// file upload  
			if ($file) {
				$form .= "enctype=\"multipart/form-data\"";
			}
			$form .= ">\n";
			return $form;
		}

		public static function close() {
			return "</form>\n";
		}
	}
?>