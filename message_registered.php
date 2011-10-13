<?
require 'php/ui/bodyTop.php';
require_once 'php/user.php';
assertLoggedOut();

_box('Du wurdest registriert.', function() {
	_br();
	_span('Ein Admin wird deinen Account bald aktivieren.');
});

require 'php/ui/bodyBottom.php';
?>
