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

		public function newuser() {
			echo "ADDING NEW USER!<br>";
			@nice_var_dump($_POST);
		}
	}
?>