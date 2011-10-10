<?
require_once 'util.php';

session_cache_expire(60 * 5); // 5 minutes
session_start();

// String to be appended to a link to keep a session intact, if cookies are not used
function session_parameter() {
	return htmlspecialchars(SID);
}

// Transparently transforms the link to keep the session intact, if cookies are not used
function session_link($link) {
	if (SID == "" || isExternalLink($link))
		return $link;
	return $link . (strpos($link, "?") ? "&amp;" : "?") . session_parameter();
}

class Session {
	
	private $valueObjects = array();
	private static $instance;
	
	static function instance() {
		if (!isset(self::$instance)) {
			$className = __CLASS__;
            self::$instance = new $className;
		}
		return self::$instance;
	}
	
	// Getting an instance field lazily creates SessionValue objects
	function __get($key) {
		if (!array_key_exists($key, $this->valueObjects)) {
			$this->valueObjects[$key] = new SessionValue($key);
		}
		return $this->valueObjects[$key];
	}
	
	// calling an instance function directly invokes the SessionValue functionality
	static function __callStatic($key, $args) {
		$obj = self::instance();
		$obj = $obj->$key;
		return call_user_func_array($obj, $args);
	}
	
	// A shortcut for setting the session-values without using a SessionValue object
	function __set($key, $value) {
		$_SESSION[$key] = $value;
	}
	
	function __unset($key) {
		unset($_SESSION[$key]);
	}
	
	function __isset($key) {
		return isset($_SESSION[$key]);
	}
	
}

// Objects got from $Session can be invoked like functions.
// Passing no parameter returns the current value.
// Passing a value sets the Session-key to this value.
// Passing a callable object invokes it with the current value 
// and sets the value to the result.
class SessionValue {
	
	private $key;
	
	function __construct($keyValue) {
		$this->key = $keyValue;
	}
	
	function __invoke($value = null) {
		if (isset($value)) {
			if (is_callable($value)) {
				$value = $value($_SESSION[$this->key]);
			}
			$_SESSION[$this->key] = $value;
		} else {
			return $_SESSION[$this->key];
		}
	}
	
	function is_set() {
		return isset($_SESSION[$this->key]);
	}
	
	function un_set() {
		unset($_SESSION[$this->key]);
	}
	
}

$Session = Session::instance();

// Example of using this Session-API
/*
	$clicks = $Session->clicks;
	if ($clicks->is_set()) {
		$clicks(function($clicks) { return $clicks + 1; });
		// Alternative here: $Session->clicks(function ...);
	} else {
		$clicks(0);
	}
	
	echo "Click-count: {$clicks()}";
	echo "<br/><a href='", session_link('/bms/test.php'), "'>Click here</a>";
*/

?>
