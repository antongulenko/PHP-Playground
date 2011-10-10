<?
require_once 'php/user.php';

if (isLoggedIn()) {
	$user = currentUser(); ?>
	<span>Hello, <?php $user->name ?></span><br/>
	<span>Last login: <?php $user->lastLogin ?></span><?php
} else { ?>
	<span>You are currently not logged in.</span><?php
}
?>
