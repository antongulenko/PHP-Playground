<?
require 'php/ui/bodyTop.php';
require_once 'php/user.php';
require_once 'php/ui/util.php';
assertLoggedOut();

if (queried('perform_registration')) {
	list($username, $password, $password2) = assertQueryData(array('username', 'password1', 'password2'));
	conditionalRedirect(createUser($username, $password, $password2),
		array(
			'ok' => 'message_registered',
			'usernameExists' => 'register?usernameExists',
			'passwords' => 'register?passwordsDontMatch',
			'empty' => 'register?empty',
			'illegalUsername' => 'register?illegalUsername'));
}

_errorBoxes(array(
	'usernameExists' => 'Der gewählte Username existiert bereits',
	'passwordsDontMatch' => 'Die Passwörter stimmen nicht überein',
	'empty' => 'Bitte fülle alle Felder aus',
	'illegalUsername' => 'Im Username sind nur alphanumerische Zeichen und _ erlaubt'
));
_box('Registrieren', function() {
	_simpleForm('register', 'perform_registration', function() {
		_textInput('Username:', 'username'); _br();
		_passwordInput('Passwort:', 'password1'); _br();
		_passwordInput('Passwort wiederholen:', 'password2'); _br();
		_submit('Registrieren');
	});
});

require 'php/ui/bodyBottom.php'
?>
