<?php
	class UserController {

		public function index() {
			echo "WELCOME TO THE FRAMEWORK!";
		}
		
		public function profile() {
			echo "USER PROFILE<br>";
		}

		public function show($id, $name) {
			echo "(id: " . $id . ", name: " . $name .")<br>";
		}
	}
?>