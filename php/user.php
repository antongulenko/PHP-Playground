<?
require_once 'php/session.php';
require_once 'php/orm.php';
require_once 'php/util.php';

/* 
 * ===================================================================
 * Session Related Setup
 * ===================================================================
 */

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

/* 
 * ===================================================================
 * User Session Management
 * ===================================================================
 */

// If the credentials are correct, login the user. Return a string-status depicting the success.
function login($user, $password) {
	$user = findUser($user, $password);
	if ($user === false) return 'failed';
	if (!$user->isActivated) return 'notActivated';
	session()->isLoggedIn = true;
	$user->lastLogin = $user->currentLogin;
	$user->currentLogin = date('d.m.Y H:i:s (l)');
	R::store($user);
	$db_session = currentDatabaseSession(); // Just to make sure, look it up. Should not exist.
	if ($db_session === false) {
		$db_session = R::dispense('session');
	}
	$db_session->ip = requestIp();
	$db_session->username = $user->username;
	R::store($db_session);
	return 'ok';
}

function logout() {
	deleteDatabaseSession();
	unset(session()->isLoggedIn);
	$loggedInUser = null;
}

function currentUser() {
	global $loggedInUser;
	return $loggedInUser;
}

function isLoggedIn() {
	return currentUser() !== null;
}

function isAdminLoggedIn() {
	return isLoggedIn() && currentUser()->isAdmin;
}

function isRootLoggedIn() {
	return isLoggedIn() && currentUser()->isRoot;
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

/* 
 * ===================================================================
 * User Data Management
 * ===================================================================
 */
 
function changeUserPassword($oldPassword, $newPassword1, $newPassword2) {
	if (hash_password($oldPassword) !== currentUser()->password) return 'failed';
	if ($newPassword1 !== $newPassword2) return 'dontMatch';
	if (empty($newPassword1)) return 'empty';
	currentUser()->password = hash_password($newPassword1);
	R::store(currentUser());
	return 'ok';
}

function deleteCurrentUser() {
	if (!isLoggedIn()) return;
	deleteUser(currentUser());
	logout();
}

/* 
 * ===================================================================
 * User Data Administration
 * ===================================================================
 */

// Return a string-status depiciting the success of the registration
function createUser($username, $password, $password2) {
	if ($password != $password2) return 'passwords';
	if (empty($password) && empty($username)) return 'empty';
	preg_match('/^([A-Za-z0-9]|_)*$/',$username, $matches);
	if (empty($matches)) return 'illegalUsername';
	$existingUser = findUser($username);
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

function deleteUser($userOrName) {
	if (is_string($userOrName)) {
		$userOrName = findUser($userOrName);
	}
	if (isset($userOrName) && $userOrName !== false) {
		R::trash($userOrName);
	}
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

// Update changeable settings of the specified user. Return success state.
// Only handles boolean attributes (flags)
function updateUserFlags($username, $newData) {
	global $user_flags;
	$db_user = findUser($username);
	if ($db_user !== false) {
		foreach (array_keys($user_flags) as $attribute) {
			if (hasRightToChange($attribute, $db_user)) {
				$newValue = array_key_exists($attribute, $newData) && $newData[$attribute] === true;
				if ($db_user->$attribute != $newValue) {
					// Only set changed attributes... Dunno, how the orm reacts.
					$db_user->$attribute = $newValue;
					
					echo 'set '. $attribute. ' of '. $db_user->username;
					var_dump($newValue);
				}
			}
		}
		// Make adjustments to keep the flags consistent and logical
		if ($db_user->isRoot && !$db_user->isAdmin) {
			$db_user->isAdmin = true;
		}
		if ($db_user->isAdmin && !$db_user->isActivated) {
			$db_user->isActivated = true;
		}
		
		if ($username !== 'Anton') ;
			// exit();
		
		R::store($db_user);
		return true;
	}
	return false;
}

function resetUserPassword($user) {
	if (!hasRightToAlter($user)) return;
	$new_pw = preg_replace('/([ ])/e', 'chr(rand(97,122))', '       '); // 7 characters
	$user->password = hash_password($new_pw);
	R::store($user);
	return $new_pw;
}

/* 
 * ===================================================================
 * User Query Functions
 * ===================================================================
 */

function allUsers() {
	return R::find('user');
}

function findUser($username, $password = null) {
	if (isset($password)) {
		return R::findOne('user', 'username = ? AND password = ?', array($username, hash_password($password)));
	} else {
		return R::findOne('user', 'username = ?', array($username));
	}
}

/* 
 * ===================================================================
 * User Rights
 * ===================================================================
 */

// This contains the flags of user-data and whether root is required to change it.
$user_flags = array(
	'isRoot' => true,
	'isAdmin' => true,
	'isActivated' => false
);

// Depicts the rights of the user-roles. Root can change everything, admin can change activated-status of non-admins.
function hasRightToChange($parameter, $targetUser) {
	global $user_flags;
	if (isRootLoggedIn()) return true;
	if (!isAdminLoggedIn()) return false;
	if ($targetUser->isAdmin) return false;
	return !$user_flags[$parameter];
}

// Combines the right to delete and to reset the password
function hasRightToAlter($user) {
	if (isRootLoggedIn()) return true;
	if (!isAdminLoggedIn()) currentUser() === $user; // Can alter himself
	if ($user->isAdmin) return false;
	return true;
}

function assertAlterableUser($username) {
	assertLoggedIn();
	$user = findUser($username);
	if ($user === false || !hasRightToAlter($user)) {
		kill();
	}
	return $user;
}

/* 
 * ===================================================================
 * Private Functions
 * ===================================================================
 */

function hash_password($pw) {
	return md5($pw);
}
 
function currentDatabaseSession() {
	return R::findOne('session', 'ip = ?', array(requestIp()));
}
 
function deleteDatabaseSession() {
	$db_session = currentDatabaseSession();
	if ($db_session !== false) {
		R::trash($db_session);
	}
}

?>
