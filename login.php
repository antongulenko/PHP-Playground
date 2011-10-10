<? require 'php/ui/bodyTop.php' ?>

<div id="login-panel">
	
	<? 
	$render_error = isset($_REQUEST['failed']);
	if ($render_error) { ?>
		<div class="error-box">
		<span>You failed!</span>
	<? } ?>
	
	<form action="perform_login" method="GET">
		<p>Username: <input tabindex=1 required type="text" name="username"/></p>
		<p>Passwort: <input tabindex=2 required type="password" name="password"/></p>
		<p><input type="submit" tabindex=3 value="Login"/></p>
	</form>
	
	<? if ($render_error) { ?></div><? } ?>
	
</div>

<? require 'php/ui/bodyBottom.php' ?>
