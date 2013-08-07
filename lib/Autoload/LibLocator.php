<?php
    final class LibLocator implements Locator {
        private $lib_base_path = null;

      	public function __construct($lib_base_path) {
        	$this->lib_base_path = $lib_base_path;
        	if (substr($this->lib_base_path, -1) != '/') {
        		$this->lib_base_path .= '/';
        	}
        }

      	public function class_exists($class_name) {
          	$class_path = self::get_path_to_class($class_name);
          	echo $class_path . "<br>";
          	return (file_exists($class_path));
      	}

      	public function get_path_to_class($class_name) {
        	return ($this->lib_base_path . str_replace("_", "/", $class_name) . ".php");
      	}
    }
?>