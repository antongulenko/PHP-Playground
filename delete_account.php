<?
require 'php/ui/bodyTop.php';
require_once 'php/user.php';
assertLoggedIn();

if (queried('really')) {
	deleteCurrentUser();
	redirect('message_account_deleted');
} else {
	_areYouSureBox(
		'Willst Du wirklich Deinen Account löschen?',
		'Nein, doch nicht',
		'Ja, jetzt löschen',
		'delete_account?really'
	);
}

require 'php/ui/bodyBottom.php';
?>
