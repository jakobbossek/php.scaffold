<?php include_once("layouts/header.php"); ?>

		<p>I am <?= $data["name"] ?> and I work as a professional <?= $data["profession"] ?><br>
			<a href="http://<?= trim($data["website"]) ?>">my website</a></p>

		<p>Lorem ipsum Culpa reprehenderit laborum mollit pariatur sint voluptate ea incididunt Excepteur laborum minim aliquip exercitation irure nisi pariatur dolor nostrud nulla dolor ad incididunt consectetur tempor pariatur Ut mollit velit reprehenderit reprehenderit proident irure laboris ut proident voluptate ut in dolor.</p>

		<?= $this->sub("test") ?>

		<p>Lorem ipsum Occaecat aliqua commodo culpa deserunt Duis officia sit laborum reprehenderit sed et quis in ad.</p>

		<?php
			$defaults = array("user" => "root", "pass" => "", "server" => "localhost");
			nice_dump($defaults);
			$options = array_extend($defaults, array("pass" => "password", "server" => "domain.com"));
			nice_dump($options);
		?>

<?php include_once("layouts/footer.php"); ?>