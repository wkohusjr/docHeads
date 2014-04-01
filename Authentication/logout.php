<?php
include '../Lib/Session.php';
include ('../templates/header.php');
if(Session::logOutSession())
{
	print '<h2>You Are Now Logged Out!</h2>';
	print '<p>Thank you for using this site!</p><br />';
}
include ('../templates/footer.html');
?>