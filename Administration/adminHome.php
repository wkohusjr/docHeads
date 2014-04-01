<?php
include '../Lib/Session.php';
Session::validateSession();
include ('../templates/header.php');
?>
<?php
$errMsg = '';
    if(Session::getLoggedInUserType()==Users::getUserTypeIDValue("ADMIN")) {
        print'<h2>Administration</h2>
<table>
    <tbody>
        <tr>
            <td colspan="2"><h5>User Administration</h5></td>
        </tr>
        
        <tr>
            <td><h6>Manage Users</h6></td>
            <td><h6><a href="userAdministration.php">Manage</a></h6></td>
        </tr>
        <tr>
            <td colspan="2"><h5>Submission Administration</h5></td>
        </tr>
        
        <tr>
            <td><h6>Manage Submissions</h6></td>
            <td><h6><a href="submissionAdministration.php">Manage</a></h6></td>
        </tr>
        
        <tr>
            <td><h6>Create a Department</h6></td>
            <td><h6><a href="createDept.php">Create</a></h6></td>
        </tr>

        <tr>
            <td><h6>Create a Course</h6></td>
            <td><h6><a href="createCourse.php">Create</a></h6></td>
        </tr>
    </tbody>

</table>';
    }
    else {
            
        $errMsg = 'Redirecting to the login page in <span id="countdown">5</span>.<br /><br />';
        print '<br /><p><span style="color: #b11117"><b>' . $errMsg . '</b></span></p>';
        print '<div align="center"><img width="350" src="../Images/bearcat.jpg"></div>';
        header( "refresh:5;url=../Authentication/login.php" );          
    }
?>


<br />
<?php
include ('../templates/footer.html');
?>