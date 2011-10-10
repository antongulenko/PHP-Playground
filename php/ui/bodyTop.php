<? require_once 'php/session.php' ?>

<html>
	<head>
		<title>Bros ' r ' Us</title>
		<link rel="shortcut icon" type="image/x-icon" href="/favicon_big.ico">
		
		<link href="style/main.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<div id="header">
			<div id="header-content">
				<h1>Jo, welcome at bros'r'us!!</h1>
				<div id="loginStatus"><? include 'loggedInHeader.php' ?></div>
			</div>
		</div>
		<div id="menu">
			<? include 'menu.php' ?>
		</div>
		
		<div id="main">
		
<? // Here comes the website content... ?>
<? // bodyBottom.php is included at the end ?>
