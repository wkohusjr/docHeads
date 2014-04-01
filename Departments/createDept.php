<?php
include '../Lib/Session.php';
Session::validateSession();
include ('../templates/header.php');
?>

<?php 

$errMsg = '';
    if(Session::getLoggedInUserType()==Users::getUserTypeIDValue("ADMIN")) {
print'

<h2>Create a Department</h2>
<p>
    Complete the form to create a new Department!
</p>
<br />

<form name="createDept" style="width: 450px;" action="">
    <fieldset>
        <legend>
            <strong>Department Information:</strong>
        </legend>
        <br>
        <table>
            <tr>
                <td height="30px" width="200px"> Department Name</td>
                <td>
                <input name="deptName" type="text" size="30">
                </td>
            </tr>
            <tr>
                <td> Department Description: </td>
                <td>                
                    <textarea   id="deptDescription" name="deptDescription" value="" wrap="virtual" 
                        rows="5em" cols="30em"
                        valign="top"
                        align="left">
                    </textarea>
               </td>
            </tr>
        </table>
    </fieldset>
    <p>
        <input type="submit" name="submit" value="Create" />
    </p>
</form>';

    }
    else {
            
        $errMsg = 'Redirecting to the login page in <span id="countdown">5</span>.<br /><br />';
        print '<br /><p><span style="color: #b11117"><b>' . $errMsg . '</b></span></p>';
        print '<div align="center"><img width="350" src="../Images/bearcat.jpg"></div>';
        header( "refresh:5;url=../Authentication/login.php" );          
    }
?>

<?php
include ('../templates/footer.html');
?>