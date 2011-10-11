<? 
require_once 'php/user.php';
require_once 'php/util.php';
assertLoggedOut();

$registrationStatusRedirects = array(
	'ok' => 'registered',
	'usernameExists' => 'register?usernameExists',
	'passwords' => 'register?passwordsDontMatch'
);

list($username, $password, $password2) = assert_query_data(array('username', 'password', 'password2'));
redirect($registrationStatusRedirects[createUser($username, $password, $password2)]);

?>
