<?
require_once 'php/util.php';
require_once 'php/user.php';
assertLoggedIn();
list($old, $new1, $new2) = assert_query_data(array('old', 'new1', 'new2'));

$changeStatusRedirects = array(
	'ok' => 'manage_account?success',
	'failed' => 'manage_account?wrongPassword',
	'empty' => 'manage_account?passwordEmpty',
	'dontMatch' => 'manage_account?passwordsDontMatch'
);
redirect($changeStatusRedirects[changeUserPassword($old, $new1, $new2)]);

?>
