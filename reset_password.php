<?
require 'php/ui/bodyTop.php';
require_once 'php/user.php';
list($username) = assert_query_data(array('user'));
$user = assertAlterableUser($username);

echo 'Nothing here yet!';

require 'php/ui/bodyBottom.php';
?>
