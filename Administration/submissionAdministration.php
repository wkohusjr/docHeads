<?php
include '../Lib/Session.php';
Session::validateSession();
include ('../templates/header.php');
?>

<h2>User Submissions Administration</h2>
<p>
	Below is a list of user submissions.
</p>
<br />

<?php
include ('../templates/footer.html');
?>