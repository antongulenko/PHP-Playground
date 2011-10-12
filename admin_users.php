<?
require 'php/ui/bodyTop.php';
require_once 'php/user.php';
require_once 'php/ui/util.php';

assertAdminLoggedIn();

// This table will be enhanced with DataTable. Attributes & css copied from example.
includeJs(array(
	'js/DataTables-1.8.2/media/js/jquery.js',
	'js/DataTables-1.8.2/media/js/jquery.dataTables.js',
	'js/checkbox_datasource_sorting.js',
	'js/date_datasource_sorting.js',
	'js/init_users_table.js'
));
includeCss('js/DataTables-1.8.2/media/css/demo_table.css');

function userHeaderRow() {
	tableHeaderRow(array('User name', 'Activated', 'Admin', 'Root', 'Last Login', 'Delete account', 'Reset password'));
}
?>

<form method="GET" action="admin_users_save_changes">
<table id="users_table" cellpadding="0" cellspacing="0" border="0" class="display" >
<thead><? userHeaderRow() ?></thead>
<?
$editableValues = array('isActivated', 'isAdmin', 'isRoot');
foreach (allUsers() as $user) {
	$columns = array($user->username);
	foreach ($editableValues as $parameter) {
		$columns[] =
			'<input type="checkbox" '.
				'name="'. $user->username.'['.$parameter.']'. '" '. 
				($user->$parameter ? 'CHECKED ' : '').
				(hasRightToChange($parameter, $user) ? '' : 'READONLY '). '/>';
	}
	$columns[] = $user->lastLogin;
	$columns[] = hasRightToAlter($user) ? render_link('Delete', 'delete_user?user='.$user->username) : '';
	$columns[] = hasRightToAlter($user) ? render_link('Reset password', 'reset_password?user='.$user->username) : '';
	tableRow($columns);
}
?>
<tfoot><? userHeaderRow() ?></tfoot>
</table>
<input value="Save changes" type="submit"/ >
</form>

<? require 'php/ui/bodyBottom.php' ?>
