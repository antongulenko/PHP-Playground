<?
require_once 'php/session.php';
require_once 'php/user.php';
require_once 'php/ui/util.php';

$menu_elements = array(
	'Main page' => 'index'
);
if (isLoggedIn()) {
	$menu_elements['Forum'] = 'forum';
	$menu_elements['Tracker'] = 'tracker';
	if (isAdminLoggedIn()) {
		$menu_elements['Manage Users'] = 'admin_users';
	}
	$menu_elements['Manage Account'] = 'manage_account';
	$menu_elements['Logout'] = 'logout';
} else {
	$menu_elements['Login'] = 'login';
	$menu_elements['Create Account'] = 'register';
}

// Render the menu-items configured above
foreach ($menu_elements as $title => $link) {
	menu_element($title, $link, isCurrentPath($link));
}

?>
