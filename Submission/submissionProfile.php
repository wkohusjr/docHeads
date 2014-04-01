<?php
include '../Lib/Session.php';
Session::validateSession();
include ('../templates/header.php');
?>

<h2>Submission Profile</h2>
<p>
	Edit - Submission Name
</p>
<br />

<?php
include ('../templates/footer.html');
?>