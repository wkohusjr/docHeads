<?php
 include '../Lib/Session.php';
 Session::validateSession();
include ('../templates/header.php');
?>

<h2>Submit a document to the Computer Apps Repository (*=required field)</h2>
<form action="submission.php" method="post" accept-charset="utf-8" enctype="multipart/form-data">
	<input type="hidden" id="volume" value="1" />

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
	<input type="radio" name="willYouGrade" id="willYouGrade" value="Yes" class="radio-box" checked >
	Yes &nbsp
	<input type="radio" name="willYouGrade" id="willYouGrade" value="No"  class="radio-box"         >
	No
	<p>
		<label for="department">Department *</label>
		<select name="department" id="department" required="required">
			<option value="" selected="selected">Select a Department</option>
			<?php $departments = "../Data/departments.xml";
			$xml = simplexml_load_file($departments);
			foreach ($xml as $department) {
				echo '<option value=' . $department -> name . '>' . $department -> name . '</option>';
			}
			?>
		</select>
		<br>

		<label for="department">Course *</label>
		<select name="course" id="course" required="required">
			<option value="" selected="selected">Select a Course</option>
			<?php
			$courses = "../Data/courses.xml";
			$xml = simplexml_load_file($courses);
			foreach ($xml as $course) {
				echo '<option value=' . $course -> name . '>' . $course -> name . '</option>';
			}
			?>
		</select>
		<br>
		
		<label for="additionalComments">Additional Comments (optional)</label>
		<textarea	id="additionalComments" name="additionalComments" value="" wrap="virtual" 
									rows="5em" cols="80em"
									valign="top"
									align="left"
						>
						</textarea>
		<br>
		<div class="btn-holder">
			<button type="submit">
				Submit
			</button>
		</div>
</form>

<?php
include ('../templates/footer.html');
?>
