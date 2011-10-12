<?
require_once 'php/user.php';
require_once 'php/util.php';
assertAdminLoggedIn();

// First, assemble the new user-data
$user_data = array();
foreach ($_REQUEST as $username => $array)
	if (is_array($array))
		foreach ($array as $key => $value)
			$user_data[$username][$key] = $value === 'on' ? true : false;

// If all checkboxes are disabled, no form-data is transferred for that user. Add the rest of the users.
foreach(allUsers() as $user) {
	if (!array_key_exists($user->username, $user_data)) {
		$user_data[$user->username] = array();
	}
}

// Now loop the new data, check for correctness and apply it
foreach ($user_data as $username => $newUserData) {
	updateUserFlags($username, $newUserData);
}

redirect('admin_users');

?>
