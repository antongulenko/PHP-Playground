<?
require_once 'php/user.php';
require_once 'php/util.php';

if (isLoggedIn()) {
	$user = currentUser(); 
	// Escape the user-name, as it's chosen by the user himself and can contain special html-chars ?>
	<span>Hello, <?php echo htmlspecialchars($user->username) ?></span><br/>
	<span>Last login: <?php echo $user->lastLogin ?></span><?php
} else { ?>
	<span>Du bist nicht eingeloggt.</span><?php
}
?>
