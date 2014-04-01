<?php
include '../Lib/Session.php';
Session::validateSession();
include ('../templates/header.php');
?>

 	<h2>Your Password has been Reset!</h2>
 	<br />
 	<p>You will recive an email confirmation within 24 hours.  <br /><br />Contact admin@admin.com with any issues.</p><br />

<?php
include ('../templates/footer.html');
?>
