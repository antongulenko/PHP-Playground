<?
require_once 'php/user.php';
require_once 'php/util.php';

if (isLoggedIn()) {
	$user = currentUser(); ?>
	<span>Hello, <?php echo $user->name ?></span><br/>
	<span>Last login: <?php echo $user->lastLogin ?></span><?php
} else { ?>
	<span>You are currently not logged in.</span><?php
}
?>
