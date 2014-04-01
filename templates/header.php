<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
	<head>
		<title>Document Repository </title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />

		<link rel="stylesheet" href="../css/layout.css">
		<link rel="stylesheet" href="../css/modal.css">
		<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/themes/base/jquery-ui.css">

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
		<script>
			window.jQuery||document.write('<script src="/_assets/js/libs/jquery-1.6.2.min.js"><\/script>')
		</script>

		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/jquery-ui.min.js"></script>

		<script language="JavaScript" src="../Scripts/validate.js"></script>

		<script src="/_assets/js/plugins.js"></script>
		<script src="/_assets/js/script.js"></script>

		<SCRIPT TYPE="text/javascript">
			function popup(mylink,windowname) {
			if(!window.focus)
				return true;
			var href;
			if( typeof (mylink)=='string')
				href=mylink;
			else
				href=mylink.href;
			window.open(href,windowname,'width=800,height=200,scrollbars=yes');
			return false;
			}
		</SCRIPT>

		<script type="text/javascript">
			(function() {
		var timeLeft=5, cinterval;
		var timeDec= function() {
		timeLeft--;
		document.getElementById('countdown').innerHTML=timeLeft;
		if(timeLeft===0) {
		clearInterval(cinterval);
		}
		};
		cinterval=setInterval(timeDec,1000);
		})();
		</script>

		<?php
	include ('../Lib/Users.php');
 ?>

	</head>
	<body>
		<div class="wrapper">

			<div id="content">

				<div id="header">
					<table width="800px">
						<tr>
							<td colspan="2"><span class="badge"></span></td>
						</tr>

						<?php
						if(Users::isAuthorized()==TRUE) {
						if(isset($_SESSION['name'])) {
						print '<tr><td><ul id="nav"><li><a href="../Home/index.php">Home</a></li><li><a href="../User/userSubmissions.php">Documents</a></li><li><a href="../Submission/submissionUpload.php">Upload Document</a></li><li><a href="../Misc/help.php">Help</a><ul><li><a href="../Misc/contactUs.php">Contact Us</a></li></ul></li>';
						if(isset($_SESSION['userType'])) {
						if(Session::getLoggedInUserType()==Users::getUserTypeIDValue("ADMIN")) {
						print '<li><a href="../Administration/adminHome.php">Administration</a>
						<ul><li><a href="../Administration/userAdministration.php">User Administration</a></li>
						<li><a href="../Administration/submissionAdministration.php">Submission Administration</a></li>
						<li><a href="../Administration/createDept.php">Department Administration</a></li>
                        <li><a href="../Administration/createCourse.php">Course Administration</a></li>
                        <li><a href="../Administration/emailUsers.php">Email Users</a></li></ul>
						</li>';
						}
						}
						print '</ul></td><td align="right"><h6 style="color: #333333;">Welcome, '.Session::getLoggedInName().' | <a href="../User/profile.php">Edit Profile</a> | <a href="../Authentication/logout.php">Logout</a></h6>';
						print '</td></tr>';
						} else {
						print '</ul></td><td style="padding-right: 10px;" align="right"><h6><a href="../Authentication/login.php">Login</a> | <a href="../User/registerUser.php">Register</a></h6>';
						print '</td></tr>';
						}
						} else {
						if(isset($_SESSION['name'])) {
						print '<tr><td><ul id="nav"><li><a href="../Home/index.php">Home</a></li><li><a href="../Misc/help.php">Help</a></li>';
						print '</ul></td><td align="right"><h6 style="color: #333333;"><a href="../User/profile.php">Edit Profile</a> | <a href="../Authentication/logout.php">Logout</a></h6>';
						print '</td></tr>';
						} else {
						print '<tr><td>';
						print '</td><td align="right"><h6 style="color: #333333;"><a href="../Authentication/login.php">Login</a></h6>';
						print '</td></tr>';
						}
						}
						?>
					</table>

				</div>
				<div id="form-container">

					<!-- BEGIN CHANGEABLE CONTENT. -->
