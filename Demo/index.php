<!doctype html>

<!-- Adapted from FinancialApprovalNetwork.com -->

<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->

<head>
	<meta charset="utf-8">
	
	<title>Submit a document to the Computer Apps Repository <?php echo date('l, F jS, Y'); ?> </title>

	<meta name="description" content="">
	<meta name="author" content="Bill Nicholson">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	
<!--   <link rel="stylesheet" href="/_assets/css/style_volume_page.css">	-->
		   
	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/themes/base/jquery-ui.css"> 

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="/_assets/js/libs/jquery-1.6.2.min.js"><\/script>')</script>

	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/jquery-ui.min.js"></script>

	<script src="/_assets/js/plugins.js"></script>
	<script src="/_assets/js/script.js"></script>

	<!--[if lt IE 7 ]>
	<script src="https://ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
	<script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
	<![endif]-->
	<SCRIPT TYPE="text/javascript">
	<!--
	function popup(mylink, windowname)
	{
	if (! window.focus)return true;
	var href;
	if (typeof(mylink) == 'string')
	   href=mylink;
	else
	   href=mylink.href;
	window.open(href, windowname, 'width=800,height=200,scrollbars=yes');
	return false;
	}
//-->
</SCRIPT>
	<script type="text/javascript">
      
    </script>	

</head>
   
<body>
         
  <div class="wrapper">
	<link rel="stylesheet" href="css/layout.css">	
	<link rel="stylesheet" href="css/modal.css">	
	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/themes/base/jquery-ui.css">

	<!--    <div id="form-column"> -->
	<div id="form-container">
            <form action="submission.php" method="post" accept-charset="utf-8" enctype="multipart/form-data">            
				<input type="hidden" id="volume" value="1" />
				<h2>Submit a document to the Computer Apps Repository (*=required field)</h2>
<!--				<a href="aboutPopUp.html" class="overlay" >About</a> -->

				<a href="#about_form" id="about_pop">About</a>
				<br>
			    <span class="badge"></span>
                    <label for="firstname">First Name *</label>
						<input id="firstname" name="firstname" type="text" value="" required="required">
					&nbsp
                    
						<label for="lastname">Last Name *</label>
						<input id="lastname" name="lastname" type="text" value="" required="required">
				<br>
					
						<label for="fileName">Document *</label> &nbsp
						<input type="file" name="fileName[]" size="200" required="required">
<!--						<input type="file" name="fileName[]" id="fileName" class="clsFile" required="required" size="200"> -->
				<br>
                    
						<label for="fileDescription">Document Description *</label>
						<textarea	id="fileDescription" name="fileDescription" value="" wrap="virtual" 
									rows="5em" cols="80em"
									valign="top"
									align="left"
									required="required"
						>
						</textarea>
				<br>
					
						<label for="gradingRubric">Grading Rubric (optional)</label>
						<input type="file" name="fileName[]" id="gradingRubric" class="clsFile">
					
					<br>
					
						<label for="instructionsToTheStudent">Instructions to the student (optional)</label>
						<input type="file" name="fileName[]" id="instructionsToTheStudent" class="clsFile">
					
					<br>
					
						<label for="instructionsToTheInstructor">Instructions to the instructor (optional)</label>
						<input type="file" name="fileName[]" id="instructionsToTheInstructor" class="clsFile">
					
					<br>
					
						<label for="willGrade">Will you grade assignments based on this document? &nbsp </label>
						<input type="radio" name="willYouGrade" id="willYouGrade" value="Yes" class="radio-box" checked >Yes &nbsp
						<input type="radio" name="willYouGrade" id="willYouGrade" value="No"  class="radio-box"         > No <p>
					
					<br>
                    
						<label for="additionalComments">Additional Comments (optional)</label>
						<textarea	id="additionalComments" name="additionalComments" value="" wrap="virtual" 
									rows="5em" cols="80em"
									valign="top"
									align="left"
						>
						</textarea>
				<br>
					
						<label for="department">Department *</label>
						<select name="department" id="department" required="required">
							<option value="" selected="selected">Select a Department</option>
<?php
							$departments = "Data/departments.xml";
							$xml = simplexml_load_file($departments);
							foreach($xml as $department){
								echo '<option value=' . $department->name .'>' . $department->name . '</option>';
							}
?>
<!--
							<option value="Accounting">Accounting</option>
							<option value="Biology">Biology</option>
							<option value="Business">Business</option>
							<option value="History">History</option>
							<option value="Marketing">Marketing</option>
							<option value="Paralegal">Paralegal</option>
							<option value="Physics">Physics</option>
-->
						</select>
				<br>
					
                    
						<label for="email">Email *</label>
						<input id="email" name="email" type="text" value="" required="required">
				<br>					
                    
						<label for="phone-area">Phone</label>
						<input id="phone-area"   name="phone_area"   id="phone_area"   type="text" maxlength="3" value="" size="3" class="shorter auto_advance">
						<input id="phone-prefix" name="phone_prefix" id="phone_prefix" type="text" maxlength="3" value="" size="3" class="shorter auto_advance">
						<input id="phone-suffix" name="phone_suffix" id="phone_suffix" type="text" maxlength="4" value="" size="4" class="short auto_advance">
					
                  
               <div class="btn-holder">
                  <button type="submit">Submit</button>
               </div>               
            </form>
         </div><!--/form-container-->        
         <!-- Form Support -->
		 
<!--	</div> -->
  
        <!-- popup form #1 -->
        <a href="#x" class="overlay" id="about_form"></a>
        <div class="popup">
            <h3>Continuous improvement, <br>with your help!</h3>
			<br>
            <p>Submit suggested assignments related to MS Word, Excel, Powerpoint, and Access. These assignments will become part of a repository available to all instructors at UC Clermont
				for all sections of IT-1001C. <br><br>Submissions are encouraged to be department-specific in order to make the course more effective across the college. <br>				
				<br>Please contact <a href=mailto:nicholdw@ucmail.uc.edu>Bill Nicholson</a> for more information. 
			</p>
            <a class="close" href="#close"></a>
		</div>  
     </body>
</html>
