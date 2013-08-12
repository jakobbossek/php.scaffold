<!doctype html>
<!--[if lt IE 7]><html lang="en" class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]><html lang="en" class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]><html lang="en" class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="en" class="no-js"><!--<![endif]-->
    <head>
        <meta charset="utf-8">
		<meta http-equiv="content-type" content="text/html; charset=utf-8"><!-- for older browsers -->
		
		<title>Jakob Bossek</title>
				
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<meta name="author" content="Jakob Bossek">
		<meta name="robots" content="index, follow, noarchive">
		
		<meta name="description" lang="de" content="Jakob Bossek, Student der Informatik und Statistik an der TU-Dortmund.">
		<meta name="description" lang="en-US" content="Jakob Bossek, computer science and statistics student at TU-Dortmund.">
		
		<meta name="keywords" lang="de" content="Jakob Bossek, TU-Dortmund, computer science, R programming, combinatorial optimizazion">
		
		<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">
		<link rel="stylesheet" type="text/css" href="<?=Helper::stylesheet('main')?>" title="website default" media="screen, projection, handheld">
		<!--[if lt IE 9]><script src="<?=Helper::js('html5shiv')?>" defer="defer"></script><![endif]-->
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		<script src="<?=Helper::js('jquery.tooltip-1.0')?>"></script>
		<script src="<?=Helper::js('enhancements')?>"></script>
	</head>
	
	<body id="<?=$this->getModuleName()?>">
		<div class="page">
			<? // var_dump($_SESSION); ?>
			<header>
				<? if (array_key_exists('flash', $_SESSION)): ?>
				<div id="flash"><?=$_SESSION['flash']?></div>
				<? unset($_SESSION['flash']); ?>
				<? endif; ?>
				<h1 id="logo"><a href="<?=Helper::getCurrentBasename()?>" title="back to homepage">Jakob Bossek</a></h1>
				<nav id="nav">
					<ul>
						<li class="active"><a href="<?=Helper::getCurrentBasename()?>"))">Homepage</a></li>
						<li class="active"><a href="<?=Helper::link(array("blog"))?>">Blog</a></li>
						<? if (isset($_SESSION['data'])): ?>
						<li><a href="<?=Helper::link(array("auth", "logout"))?>">Logout</a></li>
						<? endif; ?>
					</ul>
				</nav>
				<?php if($this->isHomepage()): ?>
				<p id="welcome">
					Hello,my name is Jakob Bossek. I study Computer Science and Statistics at<br><a href="http://www.tu-dortmund.de/" class="reg">TU-Dortmund</a>. Welcome to my site.
				</p>
				<?php endif; ?>
			</header>
		
			<div id="content">