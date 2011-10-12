<?
require 'php/ui/bodyTop.php';
require_once 'php/user.php';
require_once 'php/ui/util.php';
assertLoggedOut();

openBox(array(
	'usernameExists' => 'The chosen username already exists',
	'passwordsDontMatch' => 'The passwords don\'t match',
	'empty' => 'Bitte f�lle alle Felder aus',
	'illegalUsername' => 'Im Usernamen sind nur alphanumerische Zeichen und _ erlaubt'
));
simpleForm(array(
	array('text', 'Username:', 'username'),
	array('password', 'Passwort:', 'password1'),
	array('password', 'Passwort wiederholen:', 'password2'),
	array('submit', 'Create Account', ''),
), 'GET', 'perform_registration');
closeBox();

require 'php/ui/bodyBottom.php'
?>
