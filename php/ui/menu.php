<?
require_once 'php/user.php';
require_once 'php/ui/util.php';

$menu_elements = array(
	'Main page' => 'index'
);
if (isLoggedIn()) {
	$menu_elements['Forum'] = 'forum';
	$menu_elements['Tracker'] = 'tracker';
	if (isAdminLoggedIn()) {
		$menu_elements['Alle User'] = 'admin_users';
	}
	$menu_elements['Account'] = 'manage_account';
	$menu_elements['Logout'] = 'logout';
} else {
	$menu_elements['Login'] = 'login';
	$menu_elements['Registrieren'] = 'register';
}

// Render the menu-items configured above
foreach ($menu_elements as $title => $link) {
	menu_element($title, $link, isCurrentPath($link));
}

?>
