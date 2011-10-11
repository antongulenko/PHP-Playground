<? 
require_once 'php/user.php';
require_once 'php/util.php';
assertLoggedOut();

// Redirect-targets depending on the login-success
$loginStatusRedirects = array(
	'ok' => 'index',
	'failed' => 'login?failed',
	'notActivated' => 'login?notActivated'
);

list($username, $password) = assert_query_data(array('username', 'password'));
redirect($loginStatusRedirects[login($username, $password)]);

?>
