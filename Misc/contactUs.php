<?php
include '../Lib/Session.php';
Session::validateSession();
include ('../templates/header.php');
?>

<h2>Contact Us</h2>
<p>
    Complete the form and submit!
</p>
<br />
<form name="contactUs" style="width: 450px;" action="">
    <fieldset>
        <legend>
            <strong>Contact Us</strong>
        </legend>
        <table>
            <tr>
                <td height="30px" width="200px"> Name:</td>
                <td>
                <input name="contactName" type="text" size="30">
                </td>
            </tr>
            <tr>
                <td height="30px" width="200px"> Email:</td>
                <td>
                <input name="contactEmail" type="text" size="30">
                </td>
            </tr>
            <tr>
                <td height="30px" width="200px"> Subject:</td>
                <td>
                <input name="contactSubject" type="text" size="30">
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top; padding-top: 10px;"> Message:</td>
                <td>                
                    <textarea   id="contactMessage" name="contactMessage" value="" wrap="virtual" 
                        rows="5em" cols="30em"
                        valign="top"
                        align="left">
                    </textarea>
               </td>
            </tr>
        </table>
    </fieldset>
    <p>
        <input type="submit" name="submit" value="Send Message" />
    </p>
</form>

<?php
include ('../templates/footer.html');
?>