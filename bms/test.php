<? require('../php/sessions.php'); ?>

<html>
<body>
<?php
	
	if (isset($_SESSION['clicks'])) {
		$Session.mod('clicks', function($clicks) { return $clicks + 1 } );
	} else {
		$Session.put('clicks', 0);
	}
	
	echo "Click-count: {$_SESSION['clicks']}";
	echo "<a href='", session_link('/bms/test.php'), "'>Click here</a>";
	
?>
</body>
</html>
