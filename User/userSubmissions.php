<?php
include '../Lib/Session.php';
Session::validateSession();
include ('../templates/header.php');
?>

<h2>User Submissions!</h2>

<p>
	Here is a list of submitted documents.  Choose one to download!  
</p>
            
<?php
include ('../templates/footer.html');
?>
