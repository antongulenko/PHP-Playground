<?

# better version than built in, from http://php.net/manual/de/ref.strings.php
function beginsWith($str, $sub) {
    return (strncmp($str, $sub, strlen($sub)) == 0);
}

function isExternalLink($link) {
	return
		beginsWith($link, 'http://') ||
		beginsWith($link, 'https://') ||
		beginsWith($link, 'ftp://');
}

// Try to get the url, that has been invoked.
// mod_rewrite passes the original path into the original_accessed variable;
// if it's absent, take the name of the script.
// It's only fetched once, as it does not change for one script-invokation
function currentPath() {
	static $currentPath;
	if (!isset($currentPath)) {
		if (isset($_GET['original_accessed'])) {
			$currentPath = $_GET['original_accessed'];
		} else {
			$currentPath = $_SERVER['PHP_SELF'];
		}
	}
	return $currentPath;
}

// $path should not include leading / and trailing .php; e.g. forum/aScript (instead of /forum/aScript.php)
function isCurrentPath($path) {
	return in_array(currentPath(), array(
		$path, "$path.php", "/$path.php", "/$path"
	));
}

function redirect($location) {
	header( "HTTP/1.1 301 Moved Permanently" );
	header( "Location: ". $location );
}

function http_method() {
	if (isset($_SERVER['REQUEST_METHOD']))
		return $_SERVER['REQUEST_METHOD'];
	return '';
}

function kill() {
	redirect('/');
	exit();	
}

function assert_method($http_method) {
	if (http_method() != $http_method) {
		kill();
	}
}

// If the required data is not found, redirect to root. Else return the data s array, assignable to a list()
function assert_query_data($data_keys) {
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

?>
