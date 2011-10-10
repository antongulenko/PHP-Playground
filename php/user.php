<?php

# better version than built in, from http://php.net/manual/de/ref.strings.php
function beginsWith($str, $sub) {
    return (strncmp($str, $sub, strlen($sub)) == 0);
}

function isExternalLing($link) {
	return
		beginsWith($link, 'http://') ||
		beginsWith($link, 'https://') ||
		beginsWith($link, 'ftp://');
}

?>
