<? require('../php/sessions.php'); ?>

<html>
<body>
<?php
	
	$clicks = $Session->clicks;
	if ($clicks->is_set()) {
		$clicks(function($clicks) { return $clicks + 1; });
	} else {
		$clicks(0);
	}
	
	echo "Click-count: {$clicks()}";
	echo "<a href='", session_link('/bms/test.php'), "'>Click here</a>";
	
?>
</body>
</html>
