<?php
include '../Lib/Session.php';
Session::validateSession();
include ('../templates/header.php');
?>

<h2>Email User Administration</h2>
<p>
	List of all users opted in.
</p>
<br />

<?php
include ('../templates/footer.html');
?>