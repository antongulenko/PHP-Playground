<?
require 'php/ui/bodyTop.php';
require_once 'php/user.php';
assertLoggedIn();

if (queried('really')) {
	deleteCurrentUser();
	redirect('message_account_deleted');
} else {
	_areYouSureBox(
		'Willst Du wirklich Deinen Account l�schen?',
		'Nein, doch nicht',
		'Ja, jetzt l�schen',
		'delete_account?really'
	);
}

require 'php/ui/bodyBottom.php';
?>
