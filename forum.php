<?
require 'php/ui/bodyTop.php';
require_once 'php/user.php';
assertLoggedIn();

_iframe("php/bbpress/index.php");

require 'php/ui/bodyBottom.php';
?>
