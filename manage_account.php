<?
require 'php/ui/bodyTop.php';
require_once 'php/user.php';
require_once 'php/ui/util.php';
assertLoggedIn();

if (queried('change_password')) {
	list($old, $new1, $new2) = assertQueryData(array('old', 'new1', 'new2'));
	conditionalRedirect(changeUserPassword($old, $new1, $new2),
		array(
			'ok' => 'manage_account?success',
			'failed' => 'manage_account?wrongPassword',
			'empty' => 'manage_account?passwordEmpty',
			'dontMatch' => 'manage_account?passwordsDontMatch'));
}

_boxes(array(
	'success' => 'Passwort erfolgreich ge�ndert'
));
_errorBoxes(array(
	'wrongPassword' => 'Falsches Passwort, versuche es nochmal',
	'passwordEmpty' => 'Bitte alle Felder ausf�llen',
	'passwordsDontMatch' => 'Passw�rter stimmen nicht �berein'
));
_box('Passwort �ndern', function() {
	_simpleForm('manage_account', 'change_password', function() {
		_passwordInput('Altes Passwort:', 'old'); _br();
		_passwordInput('Neues Passwort:', 'new1'); _br();
		_passwordInput('Passwort wiederholen:', 'new2'); _br();
		_submit('Change', 'change-pw');
	}, array('change-pw'));
});
_br();
_br();
_box('Account l�schen', function() {
	_navigationLink('Meinen Account jetzt l�schen', 'delete_account');
});

require 'php/ui/bodyBottom.php';
?>
