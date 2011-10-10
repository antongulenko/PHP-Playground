<? 
require_once 'php/user.php';
require_once 'php/util.php';

list($username, $password) = assert_query_data(array('username', 'password'));
if (login($username, $password)) {
	redirect('index.php'); // Login successfull - directly go to the main page
} else {
	redirect('login?failed'); // Login failed - stay here, display error message
}

?>
