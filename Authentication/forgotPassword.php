<?php
include ('../templates/header.php');
?>

<h2>Forgot Your Password!</h2>
<p>
	To reset your password, please enter the email address associated with your account and choose submit.
	<br /><br />
	You will recieve a temporary password shortly.
</p>
<br />
<form style="width: 450px;" action="">
	<fieldset>
		<legend>
			<strong>Enter Your Email Address:</strong>
		</legend>
		<br>
		<table>
			<tr>
				<td width="180px">Email Address:</td>
				<td>
				<input type="text" size="30">
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