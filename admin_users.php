<?
require 'php/ui/bodyTop.php';
require_once 'php/user.php';
require_once 'php/ui/util.php';
assertAdminLoggedIn();

if (queried('save_changes')) {
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
	
	// Redirect here to get rid of the query-parameters
	redirect('admin_users');
}

// This table will be enhanced with DataTable. Attributes & css copied from example.
includeJs(array(
	'js/DataTables-1.8.2/media/js/jquery.js',
	'js/DataTables-1.8.2/media/js/jquery.dataTables.js',
	'js/checkbox_datasource_sorting.js',
	'js/date_datasource_sorting.js',
	'js/init_users_table.js'
));
includeCss('js/DataTables-1.8.2/media/css/demo_table.css');

_form('admin_users', 'save_changes', function() {
	_table(
	array('Username', 'Aktiviert', 'Admin', 'Root', 'Letzter Login', 'Account löschen', 'Passwort zurücksetzen'),
		function() {
			_rows(allUsers(), function($user) {
				_cell($user->username);
				_cell(function() use($user) { _checkbox(
						$user->username.'[isActivated]',
						$user->isActivated,
						hasRightToChange('isActivated', $user)); });
				_cell(function() use($user) { _checkbox(
						$user->username.'[isAdmin]',
						$user->isAdmin,
						hasRightToChange('isAdmin', $user)); });
				_cell(function() use($user) { _checkbox(
						$user->username.'[isRoot]',
						$user->isRoot,
						hasRightToChange('isRoot', $user)); });
				_cell($user->lastLogin);
				_cell(function() use($user) {
					_link('Löschen', 'admin_delete_account?user='.$user->username, array('admin-table-link')); },
					hasRightToAlter($user));
				_cell(function() use($user) {
					_link('Zurücksetzen', 'admin_reset_password?user='.$user->username, array('admin-table-link')); },
					hasRightToAlter($user));
			});
	});
	_br();
	_submit('Änderungen speichern');
});

require 'php/ui/bodyBottom.php';
?>
