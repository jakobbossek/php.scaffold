<?php
	class LinkedList {
		private $head = null;
		private $tail = null;
		private $length;

		// iterator vars
		// FIXME: add iterator support
		private $current = 0;

		public function __construct(ListElement $elem = null) {
			$this->append($elem);
		}

		public function append(ListElement $elem = null) {
			if (is_null($elem)) {
				return $this;
			}

			if (is_null($this->head)) {
				$this->head = $this->tail = $elem;
				$this->length = 1;
				// chaining
				return $this;
			}

			$this->tail->next($elem);
			$this->tail->n()->prev($this->tail);
			$this->tail = $this->tail->n();
			$this->length += 1;
			return $this;
		}

		public function prepend(ListElement $elem = null) {
			if (is_null($elem)) {
				return $this;
			}

			if (is_null($this->head)) {
				$this->head = $this->tail = $elem;
				$this->length = 1;
				return $this;
			}

			$elem->next($this->head);
			$this->head->prev($elem);
			$this->head = $elem;
			$this->length += 1;
			return $this;
		}

		public function last() {
			if ($this->length == 0) {
				throw new ListEmptyException("List is empty!");
			}
			return $this->tail;
		}

		public function first() {
			if ($this->length == 0) {
				throw new ListEmptyException("List is empty!");
			}
			return $this->head;
		}

		public function concat(LinkedList $list) {
			if ($this === $list) {
				throw new Exception("List can not be concatenated with itself!");
			}
			if (is_null($list)) {
				return $this;
			}

			$current = $list->head;

			while (!is_null($current)) {
				$this->append($current);
				break;
				$current = $current->n();
			}
			return $this;
		}

		public function deleteAtIndex($index) {
			if ($index >= $this->length) {
				throw new ListOutOfBoundsException("Index " . $index . " is out of bounds!");
			}
			$i = 0;
			$pre_current = null;
			$current = $this->head;
			while ($i < $index) {
				$pre_current = $current;
				$current = $current->n();
				$i++; 
			}

			// deleting head element
			if (is_null($pre_current)) {
				// head element is only element
				if ($this->head === $this->tail) {
					$this->head = $this->tail = null;
					$this->length = 0;
				} else {
					$this->head->n()->prev(null);
					$this->head = $this->head->n();
					$this->length--;
				}
			} else {
				$pre_current->next($current->n());
				if (!is_null($current->n())) {
					$current->n()->prev($pre_current);
				}
				$this->length--;
			}
			return $this;
		}

		public function deleteLast() {
			if ($this->length == 0) {
				throw new ListEmptyException("List is empty!");
			}
			return $this->deleteAtIndex($this->length - 1);
		}

		public function append_array($elems = array()) {
			foreach ($elems as $elem) {
				if (!$elem instanceof ListElement) {
					$elem = new ListElement($elem);
					//throw new Exception("Wrong type of element to be added to list!");
				}
				$this->append($elem);
			}
			return $this;
		}

		public function length() {
			return $this->length;
		}

		public function showList() {
			$current = $this->head;
			while ($current != null) {
				echo $current->v() . ", ";
				$current = $current->n();
			}
			echo "<br>\n";
		}
	}
?>