<?php
  class LocatorQueue {
    protected static $locators = array();

    public static function enqueueLocator($key, Locator $locator) {
      self::$locators[$key] = $locator;
    }

    public static function dequeLocator($key) {
      if (array_key_exists($key, self::$locators)) {
        unset(self::$locators[$key]);
      }
    }

    public static function autoload($class_name) {
      foreach (self::$locators as $locator) {
        if ($locator->class_exists($class_name)) {
          #echo "Loading class <b>" . $class_name . "</b> at path: " . $locator->get_path_to_class($class_name) . "<br>";
          require($locator->get_path_to_class($class_name));
          return true;
        }
      }
      return false;
    }
  }
?>