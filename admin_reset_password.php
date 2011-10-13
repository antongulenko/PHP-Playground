<?
require 'php/ui/bodyTop.php';
require_once 'php/user.php';
require_once 'php/util.php';
require_once 'php/ui/util.php';

list($username) = assertQueryData(array('user'));
$user = assertAlterableUser($username);
if (queried('really')) {
	$new_password = resetUserPassword($user);
	_box('Das Password von '. $username. ' wurde gesetzt auf: '. $new_password);
} else {
	_areYouSureBox(
		'Soll das Passwort von '. $user->username. ' wirklich zurückgesetzt werden?',
		'Nein, doch nicht',
		'Ja, jetzt zurücksetzen',
		'admin_reset_password?user='. $user->username. '&really'
	);
}

require 'php/ui/bodyBottom.php';
?>
