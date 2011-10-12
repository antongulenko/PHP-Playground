<?
require 'php/ui/bodyTop.php';
require_once 'php/user.php';
require_once 'php/ui/util.php';
assertLoggedIn();

$messages = array(
	'success' => 'Password changed successfully',
	'wrongPassword' => 'Wrong password, try again',
	'passwordEmpty' => 'Please enter a password',
	'passwordsDontMatch' => 'Passwords don\'t match',
);

foreach ($messages as $key => $message) {
	if (isset($_REQUEST[$key])) {
		openBox($message, true);
		closeBox();
		?><br/><?
	}
}

openBox('Change password', true);
simpleForm(array(
	array('password', 'Alted Passwort:', 'old'),
	array('password', 'Neues Passwort:', 'new1'),
	array('password', 'Passwort wiederholen:', 'new2'),
	array('submit', 'Change', ''),
), 'GET', 'perform_change_password');
closeBox();

require 'php/ui/bodyBottom.php';
?>
