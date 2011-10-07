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

?>
