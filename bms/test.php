<? require('../php/sessions.php'); ?>

<html>
<body>
<?php
	
	if (isset($_SESSION['clicks'])) {
		$_SESSION['clicks'] = $_SESSION['clicks'] + 1;
	} else {
		$_SESSION['clicks'] = 0;
	}
	
	echo "Click-count: {$_SESSION['clicks']}";
	echo "<a href='", session_link('/bms/test.php'), "'>Click here</a>";
	
?>
</body>
</html>
