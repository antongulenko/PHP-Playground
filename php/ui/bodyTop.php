<?
require_once 'php/session.php';
require_once 'php/ui/util.php';
?>

<html>
	<head>
		<title>Bros ' r ' Us</title>
		<link rel="shortcut icon" type="image/x-icon" href="/favicon_big.ico">
		<? includeJs('js/skip_tabcycle_links.js') ?>
		<? includeCss('style/main.css') ?>
	</head>
	<body>
		<div id="header">
			<div id="header-content">
				<img id="logo" src="style/background.png" alt="(Logo)" />
				<h1>Hallo, Leute!</h1>
				<div id="loginStatus"><? include 'loggedInHeader.php' ?></div>
			</div>
		</div>
		<div id="menu">
			<? include 'menu.php' ?>
		</div>
		
		<div id="main-container">
		<div id="main">
		
<? // Here comes the website content... ?>
<? // bodyBottom.php is included at the end ?>
