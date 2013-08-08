<?php
	class ListElement {
		private $next;
		private $prev;
		private $value;

		public function __construct($value, ListElement $next = null) {
			$this->value = $value;
			$this->next = $next;
		}

		public function n() {
			return $this->next;
		}

		public function v() {
			return $this->value;
		}

		public function p() {
			return $this->prev;
		}

		public function val($value) {
			$this->value = $value;
		}

		public function next(ListElement $next = null) {
			$this->next = $next;
		}

		public function prev(ListElement $prev = null) {
			$this->prev = $prev;
		}
	}
?>