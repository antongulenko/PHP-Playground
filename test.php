
<?

class A {
	
	static function __callStatic($key, $args) {
		return 123;
	}
	
}

var_dump(A::a());

?>
