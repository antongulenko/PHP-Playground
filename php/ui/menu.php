<?
require_once 'php/session.php';
require_once 'php/user.php';
require_once 'php/util.php';

function menu_element($text, $link, $isSelected) { 
	?><a <? 
	if ($isSelected) { ?>class="selected" <? } ?>
	href="<? echo session_link($link) ?>"><? echo $text ?></a><?
}

// Have to use the real file-names here.. results in redirects when the menu is clicked
$menu_elements = array(
	'Main page' => 'index',
	'Forum' => 'forum',
	'Tracker' => 'tracker',
);
if (isLoggedIn()) {
	$menu_elements['Logout'] = 'logout';
} else {
	$menu_elements['Login'] = 'login';
}

foreach ($menu_elements as $title => $link) {
	menu_element($title, $link, isCurrentPath($link));
}

?>
