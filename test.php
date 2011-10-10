
<?

function testf() { return $aaa; }

function testff() {
	$aaa = 123;
	return testf();
}

var_dump(testff());

?>
