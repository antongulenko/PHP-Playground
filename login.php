<?
require 'php/ui/bodyTop.php';
require_once 'php/user.php';
require_once 'php/ui/util.php';
assertLoggedOut();

openBox(array(
	'failed' => 'Login failed, wrong username or password.',
	'notActivated' => 'Your account has not yet been activated.'
));
simpleForm(array(
	array('text', 'Username:', 'username'),
	array('password', 'Passwort:', 'password'),
	array('submit', 'Login', ''),
), 'GET', 'perform_login');
closeBox();

require 'php/ui/bodyBottom.php' ?>
