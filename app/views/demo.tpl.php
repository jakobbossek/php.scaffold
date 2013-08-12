<!doctype html>
<html>
	<head>
		<title>Demo Page</title>
	</head>
	<body>
		<h1>Hello demo</h1>
		<p>I am <?= $data["name"] ?> and I work as a professional <?= $data["profession"] ?><br>
			<a href="http://<?= trim($data["website"]) ?>">my website</a></p>

		<p>Lorem ipsum Culpa reprehenderit laborum mollit pariatur sint voluptate ea incididunt Excepteur laborum minim aliquip exercitation irure nisi pariatur dolor nostrud nulla dolor ad incididunt consectetur tempor pariatur Ut mollit velit reprehenderit reprehenderit proident irure laboris ut proident voluptate ut in dolor.</p>

		<?= $this->sub("test") ?>

		<p>Lorem ipsum Occaecat aliqua commodo culpa deserunt Duis officia sit laborum reprehenderit sed et quis in ad.</p>
	</body>
</html>