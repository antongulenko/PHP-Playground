<? require 'php/ui/bodyTop.php' ?>

<h2>Hello, this is the main page!</h2>
<? 

$u = findUser('Anton_12');
$u->lastLogin = '13.05.2011 01:54:48 (Wednesday)';
R::store($u);
 ?>

<? require 'php/ui/bodyBottom.php' ?>
