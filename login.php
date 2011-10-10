<? require 'php/ui/bodyTop.php' ?>

<div id="login-panel">
	
	<? 
	$render_error = isset($_REQUEST['failed']);
	if ($render_error) { ?>
		<div class="error-box">
		<span>You failed!</span>
	<? } ?>
	
	<form action="perform_login" method="GET">
		<p>Username: <input required type="text" name="username"/></p>
		<p>Passwort: <input required type="password" name="password"/></p>
		<p><input type="submit" value="Login"/></p>
	</form>
	
	<? if ($render_error) { ?></div><? } ?>
	
</div>

<? require 'php/ui/bodyBottom.php' ?>
