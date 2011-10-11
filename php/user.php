<?
require_once 'php/session.php';
require_once 'php/orm.php';
require_once 'php/util.php';

// If the credentials are correct, login the user. Return a string-status depicting the success.
function login($user, $password) {
	$user = R::findOne('user', 'name = ? AND password = ?', array($user, hash_password($password)));
	if (!$user) return 'failed';
	if (!$user.isActivated) return 'notActivated';
	$Session->loggedInUser = $user;
	return 'ok';
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

function isAdminLoggedIn() {
	return isLoggedIn() && $Session->loggedInUser->isAdmin == true;
}

function isRootLoggedIn() {
	return isLoggedIn() && $Session->loggedInUser->isRoot == true;
}

function assertLoggedOut() {
	if (isLoggedIn()) kill();
}

function assertLoggedIn() {
	if (!isLoggedIn()) kill();
}

function assertAdminLoggedIn() {
	if (!isAdminLoggedIn()) kill();
}

// Return a string-status depiciting the success of the registration
function createUser($username, $password, $password2) {
	if ($password != $password2) return 'passwords';
	$existingUser = R::findOne('user', 'name = ?', array($username));
	if (isset($existingUser)) return 'usernameExists';
	$user = R::dispense('user');
	$user->username = $username;
	$user->password = has_password($username);
	$user->isAdmin = false;
	$user->isActivated = false;
	$user->isRoot = false;
	R::store($user);
	return 'ok';
}

function hash_password($pw) {
	return md5($pw);
}

?>
