<?
require_once 'php/session.php';
require_once 'php/orm.php';
require_once 'php/util.php';

// Synchronize the logged-in-status between database and Session
// The Session is used to expire the login, the database contains the actual status
$db_session = currentDatabaseSession();
$client_session = session()->isLoggedIn;
if ($db_session === false || !$client_session->is_set()) {
	// Either the client is not actually logged in (no db-entry) or the session has expired in the cookie
	logout();
} else {
	$loggedInUser = findUser($db_session->username);
	if ($loggedInUser === false) {
		// Something is not right in the database, the logged in user does not exist, a logout() cleans it up
		logout();
	}
}

// If the credentials are correct, login the user. Return a string-status depicting the success.
function login($user, $password) {
	$user = findUser($user, $password);
	if ($user === false) return 'failed';
	if (!$user->isActivated) return 'notActivated';
	session()->isLoggedIn = true;
	$user->lastLogin = $user->currentLogin;
	$user->currentLogin = date('l, d.m.Y H:i:s');
	R::store($user);
	$db_session = currentDatabaseSession(); // Just to make sure, look it up. Should not exist.
	if ($db_session === false) {
		$db_session = R::dispense('session');
	}
	$db_session->ip = ip();
	$db_session->username = $user->username;
	R::store($db_session);
	return 'ok';
}

function currentDatabaseSession() {
	return R::findOne('session', 'ip = ?', array(ip()));
}

function deleteDatabaseSession() {
	$db_session = currentDatabaseSession();
	if ($db_session !== false) {
		R::trash($db_session);
	}
}

function currentUser() {
	global $loggedInUser;
	return $loggedInUser;
}

function logout() {
	deleteDatabaseSession();
	unset(session()->isLoggedIn);
	$loggedInUser = null;
}

// Dangerous function for the first user in the system :)
function makeRoot($username) {
	$newRoot = findUser($username);
	if (isset($newRoot)) {
		$newRoot->isActivated = true;
		$newRoot->isAdmin = true;
		$newRoot->isRoot = true;
		R::store($newRoot);
		return true;
	}
	return false;
}

function isLoggedIn() {
	return currentUser() !== null;
}

function isAdminLoggedIn() {
	return isLoggedIn() && currentUser()->isAdmin == true;
}

function isRootLoggedIn() {
	return isLoggedIn() && currentUser()->isRoot == true;
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

function findUser($username, $password = null) {
	if (isset($password)) {
		return R::findOne('user', 'username = ? AND password = ?', array($username, hash_password($password)));
	} else {
		return R::findOne('user', 'username = ?', array($username));
	}
}

// Return a string-status depiciting the success of the registration
function createUser($username, $password, $password2) {
	if ($password != $password2) return 'passwords';
	$existingUser = findUser($username, $password);
	if ($existingUser !== false) return 'usernameExists';
	$user = R::dispense('user');
	$user->username = $username;
	$user->password = hash_password($password);
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
