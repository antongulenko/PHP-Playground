<?
require 'php/ui/bodyTop.php';
require_once 'php/user.php';
require_once 'php/util.php';
require_once 'php/ui/util.php';

list($username) = assertQueryData(array('user'));
$user = assertAlterableUser($username);
if (queried('really')) {
	deleteUser($user);
	_box("Der User $username wurde erfolgreich gel�scht!");
} else {
	_areYouSureBox(
		'Soll der User '. $user->username. ' wirklich gel�scht werden?',
		'Nein, doch nicht',
		'Ja, jetzt l�schen',
		'admin_delete_account?user='. $user->username. '&really'
	);
}

require 'php/ui/bodyBottom.php';
?>
