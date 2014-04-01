<?php
include '../Lib/Session.php';
Session::validateSession();
include ('../templates/header.php');
?>

<h2>Welcome to the (Department Name) Submission Database!</h2>

<?php 
 if (Users::isAuthorized() == TRUE) 
 {
     
     print '<p>Use the links above to navigate through the site!</p>';
 }
 
 else 
 {
     print '<p>Your account will be verified within 24-48 hours!  <br /><br />Please contact the site administrator to light a fire in his ass and get it done sooner.</p>';
 }
?>

<?php
include ('../templates/footer.html');
?>