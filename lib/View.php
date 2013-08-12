<?php
	class View {
		private $data = array();
		private $view_path;

		public static function make($view_path, $data = array()) {
			return new View($view_path, $data);
		}

		private function __construct($view_path, $data = array()) {
			$this->view_path = $view_path;
			$this->data = $data;
		}

		public function assign($key, $value) {
			$this->data[$key] = $value;
			return $this;
		}

		public function show() {
			$data = $this->data;
			echo "including VIEW " . $this->view_path . "<br>";
			include_once($this->view_path);
		}
	}
?>