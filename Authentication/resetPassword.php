<?php
include '../Lib/Session.php';
Session::validateSession();
include ('../templates/header.php');
?>

<h2>Reset Password</h2>
<p>
	Change Password for the Spreadsheet Repository Database.
</p>
<br />
<form style="width: 450px;" action="">
	<fieldset>
		<legend>
			<strong>Account Information:</strong>
		</legend>
		<br>
		<table>
			<tr>
				<td height="30px" width="200px"> Username:</td>
				<td>
					&nbsp;
				</td>
			</tr>
			<tr>
				<td> Current Password: </td>
				<td>
				<input type="text" size="30">
				</td>
			</tr>
			<tr>
				<td> New Password:</td>
				<td>
				<input type="text" size="30">
				</td>
			</tr>
			<tr>
				<td> Verify New Password:</td>
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