<?
require_once 'php/session.php';
require_once 'php/user.php';
require_once 'php/util.php';

function menu_element($text, $link, $isSelected) { 
	?><a <? 
	if ($isSelected) { ?>class="selected" <? } ?>
	href="<? echo session_link($link) ?>"><? echo $text ?></a><?
}

$menu_elements = array(
	'Main page' => 'index'
);
if (isLoggedIn()) {
	$menu_elements['Forum'] = 'forum';
	$menu_elements['Tracker'] = 'tracker';
	if (isAdminLoggedIn()) {
		$menu_elements['Manage Users'] = 'admin_users';
	}
	$menu_elements['Logout'] = 'logout';
} else {
	$menu_elements['Login'] = 'login';
	$menu_elements['Create Account'] = 'register';
}

foreach ($menu_elements as $title => $link) {
	menu_element($title, $link, isCurrentPath($link));
}

?>
