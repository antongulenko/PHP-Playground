<?php

session_cache_expire(60 * 5); // 5 minutes
session_start();

require('util.php');

function session_parameter() {
	return htmlspecialchars(SID);
}

function session_link($link) {
	if (SID == "" || isExternalLink($link))
		return $link;
	return $link . (strpos($link, "?") ? "&amp;" : "?") . session_parameter();
}

private class Session {
	
	function get($key) {
		return _SESSION[$key];
	}
	
	function put($key, $value) {
		_SESSION[$key] = $value;
	}
	
	function mod($key, $callback) {
		$this.put($key, $callback($this.get($key)));
	}
	
}

$Session = new Session();

?>
