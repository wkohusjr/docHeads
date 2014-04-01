<?php
include ('../templates/header.php');
$errMsg = '';
$firstName = null;
$lastName = null;
$email = null;
$password = null;
$passConfirm = null;
$emailOptIn = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
  // check first name
  if (!empty($_POST['fname']))
  {
    $firstName = $_POST['fname'];
    // check last name
    if (!empty($_POST['lname']))
    {
      $lastName = $_POST['lname'];
      // check email
      if (!empty($_POST['email']))
      {
        $email = $_POST['email'];
        // check to see if an existing user
        if (!empty($_POST['password']))
        {
          $password = $_POST['password'];

          if (!empty($_POST['passConfirm']))
          {
            $passConfirm = $_POST['passConfirm'];

            // confirm the password matches
            if ($password == $passConfirm)
            {
              // validate the opt-in check box
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
			     
			     // check to see if user exists before inserting record
                if (Users::registerUser($password, $firstName, $lastName, $email, $emailOptIn))
                {
                  // print "<script language='Javascript'>document.location.href='../Authentication/login.php' ;</script>";
                  header( "refresh:5;url=../Authentication/login.php" );
                  $errMsg = 'Success! A confirmation email will be sent to ' . $email . '<br /><br />Redirecting to the login page in <span id="countdown">5</span>.';
                }
            }
            else
            {
              $errMsg = 'Passwords do not match. Please verify input';
            }
          }
          else
          {
            $errMsg = 'Please confirm password';
          }
        }
        else
        {
          $errMsg = 'Password required';
        }

      }
      else
      {
        $errMsg = 'Email required';
      }
    }
    else
    {
      $errMsg = 'Last name required';
    }
  }
  else
  {
    $errMsg = 'First name required';
  }
}
?>

<h2>Create a new User!</h2>
<p>
	Complete the form below and choose submit.  You will receive a confirmation email shortly after.
</p>
<?php print '<br /><p><span style="color: #b11117"><b>' . $errMsg . '</b></span></p>'; ?>
<br />
<form id="register" name="register" style="width: 450px;" action="registerUser.php" method="POST">
	<fieldset>
		<legend>
			<strong>Personal Information:</strong>
		</legend>
		<br>
		<table>
			<tr>
				<td width="200px"> First Name: </td>
				<td>
				<input type="text" name="fname" size="30" onblur="this.value = toTitleCase(this.value)" value="<?php
        if (isset($_POST['fname']))
        {
          print $_POST['fname'];
        }
				?>">
				</td>
			</tr>
			<tr>
				<td> Last Name: </td>
				<td>
				<input type="text" onblur="this.value = toTitleCase(this.value)" name="lname" size="30" value="<?php
        if (isset($_POST['lname']))
        {
          print $_POST['lname'];
        }
				?>">
				</td>
			</tr>
			<tr>
				<td> E-mail: </td>
				<td>
				<input type="text" name="email" onblur="this.value= validateEmail(this.value)" size="30" value="<?php
        if (isset($_POST['email']))
        {
          print $_POST['email'];
        }
				?>">
				</td>
			</tr>
			<tr>
				<td> Check to receive e-mail updates on document submissions</td>
				<td>
				<input type="checkbox" name="optIn" <?php
        if (isset($_POST['optIn']))
        {
          if ($_POST['optIn'] == 'on')
          {
            print 'checked';
          }
        }
				?>
				</td>
			</tr>
		</table>
	</fieldset>
	<br />
	<fieldset>
		<legend>
			<strong>Account Information:</strong>
		</legend>
		<br>
		<table>
			<tr>
				<td width="200"> Password:</td>
				<td>
				<input type="password" name="password" size="30" value="<?php
        if (isset($_POST['password']))
        {
          print $_POST['password'];
        }
				?>">
				</td>
			</tr>
			<tr>
				<td> Verify Password:</td>
				<td>
				<input type="password" name="passConfirm" size="30" value="<?php
        if (isset($_POST['passConfirm']))
        {
          print $_POST['passConfirm'];
        }
				?>">
				</td>
			</tr>
		</table>
	</fieldset>
	<p>
		<input type="submit" name="submit" value="Submit" />
	</p>
</form>

<?php
include ('../templates/footer.html');
?>