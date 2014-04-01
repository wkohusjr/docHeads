<?php
include ('../Lib/Users.php');
include ('../templates/header.php');

$errMsg = '';
$firstName = null;
$lastName = null;
$email = null;
$password = null;
$emailOptIn = null;

if (!empty($_POST['fname']))
{
  $firstName = $_POST['fname'];
	
}
else
{
	$errMsg = 'First name required.'; 
}
if (isset($_POST['lname']))
{
  $lastName = $_POST['lname'];
}
if (isset($_POST['email']))
{
  $email = $_POST['email'];
}
if (isset($_POST['password']))
{
  $password = $_POST['password'];
}
if (isset($_POST['optIn']))
{
  if ($_POST['optIn'] == 'on')
  {
    $emailOptIn = TRUE;
  }
  else if ($_POST['optIn'] == 'off')
  {
    $emailOptIn = FALSE;
  }
}
if (Users::registerUser($password, $firstName, $lastName, $email, $emailOptIn))
{
  $errMsg = 'Success';
}
?>

<div id="form-container">
	<?php
  print '<p><span style="color: #b11117"><b>' . $errMsg . '</b></span></p>';
  print '<br />';
  print '<p>Thank you for registering your account ' . $firstName . ' ' . $lastName . '. A confirmation email has been sent to ' . $email . '.</p>';
	?>
</div>

<?php
include ('../templates/footer.html');
?>
