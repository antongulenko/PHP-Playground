<?

/* 
 * ===================================================================
 * General Functions
 * ===================================================================
 */

function beginsWith($str, $sub) {
	return (strncmp($str, $sub, strlen($sub)) == 0);
}

function isExternalLink($link) {
	return
		beginsWith($link, 'http://') ||
		beginsWith($link, 'https://') ||
		beginsWith($link, 'ftp://');
}

// Check, whether array contains only numbers as keys
function isNumbered($array) {
    return array_keys($array) === range(0, count($array) - 1);
}

/* 
 * ===================================================================
 * Request related Functions
 * ===================================================================
 */

function requestIp() {
	return $_SERVER['REMOTE_ADDR'];
}

// $path should not include leading / and trailing .php; e.g. forum/aScript (instead of /forum/aScript.php)
// We cannot check the path directly because of the reqrites performed by apache
function isCurrentPath($path) {
	return in_array($_SERVER['PHP_SELF'], array(
		$path, "$path.php", "/$path.php", "/$path"
	));
}

// If the required data is not found, redirect to root.
// Else return the data as array, assignable to a list().
function assertQueryData($data_keys) {
	$result = array();
	foreach ($data_keys as $key) {
		if (array_key_exists($key, $_REQUEST)) {
			$result[] = $_REQUEST[$key];
		} else {
			kill();
		}
	}
	return $result;
}

function queried($key) {
	return isset($_REQUEST[$key]);
}

/* 
 * ===================================================================
 * Redirect Functions
 * ===================================================================
 */

// TODO - 301 (moved permanently) seems not right, we just want to move to another page
function redirect($location) {
	header( "HTTP/1.1 301 Moved Permanently" );
	header( "Location: ". $location );
	exit();
}

function kill() {
	redirect('/');
}

function conditionalRedirect($status, $statusArray) {
	if (array_key_exists($status, $statusArray))
		redirect($statusArray[$status]);
	else
		kill();
}

?>
