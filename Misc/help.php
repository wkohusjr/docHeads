<?php
include '../Lib/Session.php';
Session::validateSession();
include ('../templates/header.php');
?>

<h2>Help!</h2>
<p>
	See helpful tips below for this site!
</p>
<br />

<?php
include ('../templates/footer.html');
?>