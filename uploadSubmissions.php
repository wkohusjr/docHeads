<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title>Upload a File</title>
	</head>
	<body>
		<?php 
		include ('./Lib/Submissions.php');
		$sub = new Submission();

    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
    	print $sub -> uploadFile();
    } // End of submission IF.

    // Leave PHP and display the form:
		?>

		<form action="uploadSubmissions.php" enctype="multipart/form-data" method="post">
			<p>
				Upload a file using this form:
			</p>
			<input type="hidden" name="MAX_FILE_SIZE" value="300000" />
			<p>
				<input type="file" name="submissionfile" />
			</p>
			<p>
				<select name="department">
					<option value="Accounting">Accounting</option>
					<option value="Biology">Biology</option>
					<option value="Business">Business</option>
					<option value="History">History</option>
					<option value="Marketing">Marketing</option>
					<option value="Paralegal">Paralegal</option>
					<option value="Physics">Physics</option>
				</select>
			</p>
			<p>
				<input type="submit" name="submit" value="Upload This File" />
			</p>
		</form>

	</body>
</html>

