<?php
include ('/templates/header.php');
?>

<h2>Edit your Profile</h2>
<p>
	Edit your profile below.  Choose submit when finished.
</p>
<br />

<form style="width: 450px;" action="">
	<fieldset>
		<legend>
			<strong>Personal Information:</strong>
		</legend>
		<br>
		<table>
			<tr>
				<td width="200px"> First Name: </td>
				<td>
				<input type="text" size="30">
				</td>
			</tr>
			<tr>
				<td> Last Name: </td>
				<td>
				<input type="text" size="30">
				</td>
			</tr>
			<tr>
				<td> E-mail: </td>
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
<br />
<br />
<form style="width: 450px;" action="">
	<fieldset>
		<legend>
			<strong>Account Information:</strong>
		</legend>
		<br>
		<table>
			<tr>
				<td width="200px"> Username:</td>
				<td>
				<input type="text" size="30">
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
include ('/templates/footer.html');
?>