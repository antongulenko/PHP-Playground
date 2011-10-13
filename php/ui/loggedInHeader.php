<?
require_once 'php/user.php';

if (isLoggedIn()) {
	$user = currentUser(); 
	// Escape the user-name, as it's chosen by the user himself and can contain special html-chars ?>
	<span>Hallo, <? echo htmlspecialchars($user->username) ?></span><br/>
	<span>Letzter Login: <? echo $user->lastLogin ?></span><?
} else { ?>
	<span>Du bist nicht eingeloggt.</span><?
}
?>
