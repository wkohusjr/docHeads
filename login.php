<?php 
include ('/templates/header.php');
?>

 	<h2>Login Form</h2>
 	<br />
 	<br />
 	<p>Please enter your username and password.</p><br />

	<form style="width: 350px;" action="login.php" method="post">
	<table>
	<tr>
	<td style="width: 120px;">
	<p>Email Address:</p>
	</td>
	<td style="width: 200px;">
	<p><input type="text" name="email" size="20" /></p>
	</td>
	</tr>
	<tr>
	<td style="width: 120px;">
	<p>Password:</p>
	</td>
	<td style="width: 200px;">
	<p><input type="password" name="password" size="20" /></p>
	</td>
	</tr>
	<tr>
	<td colspan="2">
	<p><input type="submit" name="submit" value="Log In!" /></p>
	</td>
	</tr>
	</table>
	</form>

<?php
include ('/templates/footer.html');
?>
