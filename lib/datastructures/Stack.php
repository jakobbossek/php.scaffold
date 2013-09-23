<?php
	/**
	 * Stack data structure
	 */

	final class Stack {
		private $stack;

		public function __construct($elems = array()) {
			$this->stack = new LinkedList();
			$elems = array_map(function($el) { return (new ListElement($el)); }, $elems);
			$this->stack->append_array($elems);
		}

		public function pop() {
			if ($this->stack->length() == 0) {
				throw new StackEmptyException();
			}
			$elem = $this->stack->last();
			$this->stack->deleteLast();
			return $elem;
		}

		public function push($elem) {
			if ($elem instanceof ListElement) {
				$this->stack->append($elem);
			} else if (is_array($elem)) {
				$this->stack->append_array($elem);
			}
		}

		// redundant
		public function top() {
			if ($this->stack->length() == 0) {
				throw new StackEmptyException();
			}
			$elem = $this->stack->last();
			return $elem;
		}

		public function show() {
			$this->stack->showList();
		}
	}

	class StackEmptyException extends Exception {}

?>