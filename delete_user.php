<?
require 'php/ui/bodyTop.php';
require_once 'php/user.php';
require_once 'php/util.php';
require_once 'php/ui/util.php';
list($username) = assert_query_data(array('user'));

if (isset($_REQUEST['success'])) {
	openBox('User '. $username. ' has been deleted successfully!');
	closeBox();
} else {
	$user = assertAlterableUser($username);
	if (isset($_REQUEST['really'])) {
		deleteUser($user);
		redirect('delete_user?user='. $user->username. '&success');
	} else {
		openBox('Do you really want to delete the user '. $user->username. '?'.
			'<br/>'. renderBackLink('No, go back'). 
			'<br/>'. render_link('Yes, delete it now', 'delete_user?user='. $user->username. '&really'));
		closeBox();
	}
}



require 'php/ui/bodyBottom.php';
?>
