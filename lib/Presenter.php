<?php

	abstract class Presenter {
		protected $layout;
		private $protected_actions;

		public function __construct() {
			$this->protected_actions = array();
		}

		public function layout($path_to_layout) {
			$this->layout = $path_to_layout;
		}
	}

?>