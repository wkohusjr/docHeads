<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Create a Table</title>
</head>
<body>
<?php // create_table.php 
/* This script connects to the MySQL server, selects the database, and creates a table. */

// Connect and select:
if ($dbc = @mysql_connect('localhost', 'root', '')) {
	
	// Handle the error if the database couldn't be selected:
	if (!@mysql_select_db('docdatabase', $dbc)) {
		print '<p style="color: red;">Could not select the database because:<br />' . mysql_error($dbc) . '.</p>';
		mysql_close($dbc);
		$dbc = FALSE;
	}

} else { // Connection failure.
	print '<p style="color: red;">Could not connect to MySQL:<br />' . mysql_error() . '.</p>';
}

if ($dbc) {

	// Define the Users table query:
	// $query = 'CREATE TABLE users (
// userID INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
// password VARCHAR(100) NOT NULL,
// passwordVerification TEXT NOT NULL,
// lname TEXT NOT NULL,
// fname TEXT NOT NULL,
// emailAddress TEXT NOT NULL,
// createDate TEXT NOT NULL,
// updateDate TEXT NOT NULL,
// phoneNumber DATETIME NOT NULL
// )';

	// Define the UserType table query:
	$query = 'CREATE TABLE userTypes (
userTypeID INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
userTypeName VARCHAR(100) NOT NULL,
updateDate TEXT NOT NULL,
createDate TEXT NOT NULL
)';

	// Define the Submissions table query:
	// $query = 'CREATE TABLE submissions (
// subID INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
// docName VARCHAR(100) NOT NULL,
// rating VARCHAR(5) NOT NULL,
// comments VARCHAR(5) NOT NULL,
// instructorInstruction VARCHAR(5) NOT NULL,
// studentInstruction VARCHAR(5) NOT NULL,
// rubricFileName VARCHAR(5) NOT NULL,
// willYouGrade VARCHAR(5) NOT NULL,
// updateDate TEXT NOT NULL,
// createDate TEXT NOT NULL
// )';

	
	// Execute the query:
	if (@mysql_query($query, $dbc)) {
		print '<p>The table has been created!</p>';
	} else {
		print '<p style="color: red;">Could not create the table because:<br />' . mysql_error($dbc) . '.</p><p>The query being run was: ' . $query . '</p>';
	}
		
	mysql_close($dbc); // Close the connection.

}
?>
</body>
</html>