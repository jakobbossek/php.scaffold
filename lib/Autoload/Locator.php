<?php
	/**
	 * Locator interface.
	 *
	 * Locators search for class files in specific directories. They support
	 * a boolean method class_exists, which determine if the class has been
	 * located and a get_path_to_class function, which returns the path to the
	 * class file as a string.
	 */
	interface Locator {
		public function class_exists($class_name);
		public function get_path_to_class($class_name);
	}
?>