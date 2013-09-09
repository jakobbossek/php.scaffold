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
		public static function open($action, $method = "POST", $file = false, $attributes = array()) {
			$method = strtoupper($method);
			// sanity checks
			// FIXME: later add support for PUT, DELETE, ...
			if (!in_array($method, array("GET", "POST"))) {
				die("Unsupported HTTP method type " . $method . " provided to form.");
			}
			$form = "<form";
			$form .= ' method="' . $method . '"';
			// add optional params like id, name or css inline styles
			$form = self::attributes($form, $attributes);

			$form .= ' action="' . $action . '"';
			// file upload form
			if ($file) {
				$form .= "enctype=\"multipart/form-data\"";
			}
			$form .= ">\n";
			return $form;
		}

		public static function close() {
			return "</form>\n";
		}
		/*
		 * FIXME: unfortunately php has no support for named attributes
		 * Providing only $options and some $attributes leaving all other attributes on their defaults
		 * requires the rather ugly call
		 * select(array(...), 1, 1, false, array(...));
		 * Better solution is surely an assoziative array:
		 * select(array("options" => array(...), "attributes" => array(...)));
		 */
		public static function select(array $options, $selected = 1, $size = 1, $multiple = false, $attributes = array()) {
			$select = "<select";

			// append attributes
			$select = self::attributes($select, $attributes);

			// shall files be uploaded by the form?
			if ($multiple) {
				$select .= " multiple";
			}

			$select .= ' size="' . $size . '"';
			$select .= ">";

			if (!is_multidimensional($options)) {
				// "regular" select field (no option groups)
				$index = 1;
				foreach ($options as $label => $value) {
					$select .= '<option label="' . $label . '" value="' . $value . '"';
					// is this the selected item?
					// FIXME: make the $selected var a string (the value of the option selected)
					if ($selected === $index) {
						$select .= ' selected';
					}
					$select .= '>' . $label . '</option>';
					$index++;
				}
			} else {
				// option groups
				$optgroup_index = 1;
				$split_selected = explode(":", $selected);
				$optgroup_selected = (count($split_selected) == 2) ? $split_selected[0] : 1;
				$selected = (count($split_selected) == 2) ? $split_selected[1] : 1;
				#echo $optgroup_selected . ":" . $selected . "<br>";
				foreach ($options as $optgroup_label => $the_options) {
					$select .= '<optgroup label="' . $optgroup_label . '">';
					$index = 1;
					foreach ($the_options as $label => $value) {
						$select .= '<option label="' . $label . '" value="' . $value . '"';
						if ($optgroup_selected == $optgroup_index AND $selected == $index) {
							$select .= ' selected';
						}
						$select .= '>' . $label . '</option>';
						#echo $optgroup_index . ":" . $index . "<br>";

						$index++;
					}
					$select .= '</optgroup>';
					$optgroup_index++;
				}
			}
			$select .= '</select>';
			return $select;
		}

		public static function text($options = array()) {
			return self::input("text", $options);
		}

		public static function password($options = array()) {
			return self::input("password", $options);
		}

		private static function input($type, $options) {
			$field = '<input type="' . $type . '"';
			if (isset($options['attributes']) AND is_array($options['attributes'])) {
				$field = self::attributes($field, $options['attributes']);
			}
			if (isset($options['value'])) {
				$field .= ' value="' . $options['value'] . '"';
 			}
 			if (isset($options['maxlength'])) {
 				$maxlength = (int) $options['maxlength'];
 				$field .= ' maxlength="' . $maxlength . '"';
 			}
 			$field .= '>';
 			return $field;
		}

		public static function label($options = array()) {
			if (!isset($options["for"])) {
				die("Option 'for' is mandatory for labels.");
			}
			if (!isset($options["label"])) {
				die("Option 'label' is mandatory for labels.");
			}
			$label = '<label for="' . trim($options["for"]) . '"';
			if (isset($options['attributes']) AND is_array($options['attributes'])) {
				$label = self::attributes($label, $options['attributes']);
			}
			$label .= '>' . $options["label"] . "</label>";
			return $label;
		}

		private static function attributes($obj, $attributes = array()) {
			if (isset($attributes) AND !empty($attributes)) {
				foreach ($attributes as $attribute_name => $attribute_value) {
					$obj .= ' ' . $attribute_name . '="' . $attribute_value . '"';
				}
			}
			return $obj;
		}
	}
?>