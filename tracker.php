<?
require 'php/ui/bodyTop.php' ;
require_once 'php/user.php';
assertLoggedIn();

_iframe("php/phpbttrkplus-2.2/tracker.php");

require 'php/ui/bodyBottom.php';
?>
