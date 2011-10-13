<?
require 'php/ui/bodyTop.php';
require_once 'php/user.php';
require_once 'php/ui/util.php';
assertLoggedOut();

if (queried('perform_login')) {
	list($username, $password) = assertQueryData(array('username', 'password'));
	conditionalRedirect(login($username, $password),
		array(
			'ok' => 'index',
			'failed' => 'login?failed',
			'notActivated' => 'login?notActivated' ));
}

_errorBoxes(array(
	'failed' => 'Login fehlgeschlagen, falscher Username oder Passwort',
	'notActivated' => 'Dein Account wurde noch nicht aktiviert'
));
_box('Login', function() {
	_simpleForm('login', 'perform_login', function() {
		_textInput('Username:', 'username'); _br();
		_passwordInput('Passwort:', 'password'); _br();
		_submit('Login');
	});
});

require 'php/ui/bodyBottom.php'
?>
