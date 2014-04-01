<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title>Check Login</title>
	</head>
	<body>
		<?php

		$host = "localhost";
		// Host name
		$username = "";
		// Mysql username
		$password = "";
		// Mysql password
		$db_name = "test";
		// Database name
		$tbl_name = "members";
		// Table name

		// Connect to server and select databse.
		mysql_connect("$host", "$username", "$password") or die("cannot connect");
		mysql_select_db("$db_name") or die("cannot select DB");

		// Define $myusername and $mypassword
		$myusername = $_POST['myusername'];
		$mypassword = $_POST['mypassword'];

		// To protect MySQL injection (more detail about MySQL injection)
		$myusername = stripslashes($myusername);
		$mypassword = stripslashes($mypassword);
		$myusername = mysql_real_escape_string($myusername);
		$mypassword = mysql_real_escape_string($mypassword);
		$sql = "SELECT * FROM $tbl_name WHERE username='$myusername' and password='$mypassword'";
		$result = mysql_query($sql);

		// Mysql_num_row is counting table row
		$count = mysql_num_rows($result);

		// If result matched $myusername and $mypassword, table row must be 1 row
		if ($count == 1) {
			session_start();
			// Register $myusername, $mypassword and redirect to file "loginSuccess.php"
			$_SESSION['myusername'] = 'myusername';
			//$_SESSION['mypassword'] = $mypassword;
			header("location:loginSuccess.php");
		} else {
			echo "Wrong Username or Password";
		}
	?>
	</body>
</html>