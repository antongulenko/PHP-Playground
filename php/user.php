<?
require_once 'session.php';
require_once 'orm.php';

// If the credentials are correct, login the user and return true. Else, return false.
function login($user, $password) {
	$user = userObject($user, $password);
	if (!$user) return false;
	$Session->loggedInUser = $user;
	return true;
}

function currentUser() {
	return $Session->loggedInUser;
}

function logout() {
	unset($Session->loggedInUser);
}

function isLoggedIn() {
	return isset($Session->loggedInUser);
}

function userObject($user, $password) {
	return R::findOne('user', 'name is ? AND password is ?', array($user, hash_password($password)));
}

function hash_password($pw) {
	return md5($pw);
}

?>
