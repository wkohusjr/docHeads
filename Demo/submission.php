<?php
	$verbose = false;
//	$verbose = true;
	$submissionStatus = true;		// Hope for the best
	$validationMsg = "";

// submission.php
	echo("<!doctype html>");
	echo("<head>");
	echo("<meta charset=\"utf-8\">");
	echo("<title>Confirmation</title>");
	echo("<meta name=\"about\" content=\"\" >");

	echo("<meta name=\"author\" content=\"Bill Nicholson\">");
	echo("<meta name=\"viewport\" content=\"width=device-width,initial-scale=1\" >");
	echo("<link rel=\"stylesheet\" href=\"https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/themes/base/jquery-ui.css\" > ");
	echo("<link rel=\"stylesheet\" href=\"css/layout.css\">");
	echo("<link rel=\"stylesheet\" href=\"css/modal.css\">");

	echo("</head>");
	echo("<body>");


    echo('<a href="#x" class="overlay" id="submission_form"></a>\n');
    echo('<div class="popupImmediatly">');

	echo("<div class=\"wrapper\">");
	echo("<div id=\"form-container\">");

	$x = Process($validationMsg);

	if ($x == true) {
		echo('<h2>It looks great.</h2>');
		echo('<span class="badge"></span>');
		echo("</br></br>Thank you for your submission to the Computer Apps Document Repository." );
	} else {
		echo('<h2>oops</h2>');
		echo('<span class="badge"></span>');
		echo('</br></br>');
		echo($validationMsg);
		echo('</br></br>Please click your Back Button and try again.');
	}

//	echo('<a class="close" href="#close"></a>');
	echo('</div>');

	echo("</div>");
	echo("</div>");

	echo("</body>");
	echo("</html> ");
//	********************************************************************
//	* Process the user input                                           *
//	********************************************************************
	function Process() {	
		global $validationMsg;
		$validationMsg = "";
		
		$submissionStatus = true;	// Hope for the best

		$firstname = $_POST["firstname"];
		$lastname = $_POST["lastname"];

		$fileDescription = $_POST["fileDescription"];

		$willYouGrade = $_POST["willYouGrade"];
		$additionalComments = $_POST["additionalComments"];
		$department = $_POST["department"];
		$email = $_POST["email"];
		$phone_area = $_POST["phone_area"];
		$phone_prefix = $_POST["phone_prefix"];
		$phone_suffix = $_POST["phone_suffix"];

		$status = "";
		$status = Validate($firstname, $lastname, $fileDescription, $department, $email, $validationMsg);

		$result = "";
		$validation = true;
		if ($status == false ) {
			$result = $validationMsg . "<br>";
			$validation = false;
			$submissionStatus = false;
			Verbose ("<br>Validate() returned false: ");
			Verbose ($validationMsg);
		} else {
			Verbose ("<br>Validate() returned true");
		}
		$result .= "You sent me this: <br>";

		/*
		if ($_FILES["fileName"]["error"] > 0)
		{
			echo "Error: " . $_FILES["fileName"]["error"] . "<br>";
		} else {
			$file_count = count($file_post['name']); 
			echo "File upload count " . $file_count;
		}
	*/
	/*
		echo "Processing " . $_FILES["fileName"]["name"] . "...";
		echo "Processing " . $_FILES["gradingRubric"]["name"] . "...";
		echo "Processing " . $_FILES["instructionsToTheStudent"]["name"] . "...";
		echo "Processing " . $_FILES["instructionsToTheInstructor"]["name"] . "...";
		echo("<br>");
	*/
		$result .= "Processing uploaded files: " . MakeBold($_FILES["fileName"]["name"][0]) . "...<br>"; 
		$result .= "Processing uploaded files: " . MakeBold($_FILES["fileName"]["name"][1]) . "...<br>"; 
		$result .= "Processing uploaded files: " . MakeBold($_FILES["fileName"]["name"][2]) . "...<br>";
		$result .= "Processing uploaded files: " . MakeBold($_FILES["fileName"]["name"][3]) . "...<br>";

		$uploadBase = "uploads/" . $department;
		// If this is the first upload for this department, create the subdirectory for the department
		if (!file_exists($uploadBase)) {
			mkdir ($uploadBase);
		}
		$repository = explode(".", $_FILES["fileName"]["name"][0]);

		$result .= "<br>" . "repository = " . $repository[0];
		$count = 0;
		$tmp = $repository[0];
		while (true) {
			if (file_exists($uploadBase . "/" . $repository[0])) {
				$result .= "<br>" . $repository[0] . " already exists. ";
				$repository[0] = $tmp . ("_" . $count);
				$count += 1;
			} else {
				break;
			}
		}

		// Make the repository and move the document into the repository. It now has a home.
		$result .= "<br>" . $repository[0] . " does not exist. ";
		mkdir ($uploadBase . "/" . $repository[0]); 
		$result .= "<br>" . $repository[0] . " created. ";

		$result .= "<br>" . "moving " . $_FILES["fileName"]["tmp_name"][0];
		move_uploaded_file($_FILES["fileName"]["tmp_name"][0], $uploadBase . "/" . $repository[0] . "/" . $_FILES["fileName"]["name"][0]);
		$result .= "<br>" . "Stored in: " . $uploadBase . "/" . $repository[0] . "/" . $_FILES["fileName"]["name"][0];
		$documentFileName = $_FILES["fileName"]["name"][0];
		$result .= "<br>";

	//	Grading Rubric
		if (strlen($_FILES["fileName"]["tmp_name"][1]) != 0) {
			$rubricFileName = trim($_FILES["fileName"]["name"][1]);
			$result .= "<br>" . "moving " .  $_FILES["fileName"]["tmp_name"][1];
			move_uploaded_file($_FILES["fileName"]["tmp_name"][1], $uploadBase . "/" . $repository[0] . "/" . $_FILES["fileName"]["name"][1]);
			$result .= "<br>" . "Stored in: " . $uploadBase . "/" . $repository[0] . "/" . $_FILES["fileName"]["name"][1];
		} else {
			$result .= "<br>" . "No grading rubric was uploaded.";
			$rubricFileName = '';
		}
	//	Instructions to the student
		if (strlen($_FILES["fileName"]["tmp_name"][2]) != 0) {
			$studentInstructionsFileName = trim($_FILES["fileName"]["name"][2]);
			$result .= "<br>" . "moving " .  $_FILES["fileName"]["tmp_name"][2];
			move_uploaded_file($_FILES["fileName"]["tmp_name"][2], $uploadBase . "/" . $repository[0] . "/" . $_FILES["fileName"]["name"][2]);
			$result .= "<br>" . "Stored in: " . $uploadBase . "/" . $repository[0] . "/" . $_FILES["fileName"]["name"][2];
		} else {
			$result .= "<br>" . "No instructions to the student document was uploaded.";
			$studentInstructionsFileName = '';
		}
	//	Instructions to the instructor
		if (strlen($_FILES["fileName"]["tmp_name"][3]) != 0) {
			$instructorInstructionsFileName = trim($_FILES["fileName"]["name"][3]);
			$result .= "<br>" . "moving " .  $_FILES["fileName"]["tmp_name"][3];
			move_uploaded_file($_FILES["fileName"]["tmp_name"][3], $uploadBase . "/" . $repository[0] . "/" . $_FILES["fileName"]["name"][3]);
			$result .= "<br>" . "Stored in: " . $uploadBase . "/" . $repository[0] . "/" . $_FILES["fileName"]["name"][3];
		} else {
			$instructorInstructionsFileName = '';
			$result .= "<br>" . "No instructions to the instructor document was uploaded.";
		}
		
		WriteXMLFile($firstname, $lastname, $fileDescription, $additionalComments, $department, 
					 $email, $willYouGrade, $phone_area, $phone_prefix,	$phone_suffix, $uploadBase . "/" . $repository[0] . "/",
					 $documentFileName, $rubricFileName, $studentInstructionsFileName, $instructorInstructionsFileName);
		
		$result .= "<br>";

		$result .= "First Name: ";
		$result .= MakeBold($firstname);
		$result .= "<br>";
		$result .= "Last Name: ";
		$result .= MakeBold($lastname);
		$result .= "<br>";

		$result .= "<br>";
		$result .= "File Description: ";
		$result .= MakeBold($fileDescription);

		$result .= "<br>";
		$result .= "Will You Grade: ";
		$result .= MakeBold($willYouGrade);
		
		$result .= "<br>";
		$result .= "Additional Comments: ";
		$result .= MakeBold($additionalComments);
		
		$result .= "<br>";
		$result .= "Department: ";
		$result .= MakeBold($department);
		
		$result .= "<br>";
		$result .= "email: ";
		$result .= MakeBold($email);
		$result .= "<br>";
		
		$result .= "phone: ";
		$result .= MakeBold("(" . $phone_area . ") " . $phone_prefix . "-" . $phone_suffix);
		$result .= "<br>";

		Verbose($result);
		
		if ($submissionStatus == true) {
			$tmp = "true";
		} else {
			$tmp = "false";
		}
		Verbose ("<br>Process() returning " . $tmp);
		
		return($submissionStatus );
	}
	
	function NewLine() {
		echo("<br>");
	}
	function getNewLine() {
		return("<br>");
	}
	function MakeBold($string) {
		return("<b>" . $string . "</b>");
	}

	// Validate the user input from the submission page
	function Validate($firstname, $lastname, $fileDescription, $department, $email)
	{
		global $validationMsg;
		$validationMsg = "";
		$myStatus = true;		// Hope for the best
		if (strlen(trim($firstname)) == 0) {
			$validationMsg .= "First Name required" . getNewLine();
			$myStatus = false;
		}
		if (strlen(trim($lastname)) == 0) {
			$validationMsg .= "Last Name required" . getNewLine();
			$myStatus = false;
		}
		if (strlen(trim($fileDescription)) == 0) {
			$validationMsg .= "File Description required" . getNewLine();
			$myStatus = false;
		}
		if (strlen(trim($department)) == 0) {
			$validationMsg .= "Department required" . getNewLine();
			$myStatus = false;
		}
		if (strlen(trim($email)) == 0) {
			$validationMsg .= "email address required" . getNewLine();
			$myStatus = false;
		} else {
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$validationMsg .= "This email address is not considered valid: " . $email . ".";
				$myStatus = false;
			}		
		}
		Verbose ("<br>Validate(): " . $validationMsg);
		return ($myStatus);
	}

	function WriteXMLFile($firstname, $lastname, $fileDescription, $additionalComments, $department, $email, $willYouGrade, $phone_area, $phone_prefix, $phone_suffix, $path,
						  $documentFileName, $rubricFileName, $studentInstructionsFileName, $instructorInstructionsFileName) {
		Verbose(getNewLine() . "writing metadata to " . $path);
		$myFile = $path . "metaData.xml";
		$fh = fopen($myFile, 'w') or die("can't open file:" . $myFile);
		fwrite($fh, "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>");                                                          fwrite($fh, "\n");
		fwrite($fh, "<metadata>");                                                                                               fwrite($fh, "\n");
			fwrite($fh, "<firstname>"                     ); fwrite($fh, $firstname                             ); fwrite($fh, "</firstname>"                        ); fwrite($fh, "\n");
			fwrite($fh, "<lastname>"                      ); fwrite($fh, $lastname                              ); fwrite($fh, "</lastname>"                         ); fwrite($fh, "\n");
			fwrite($fh, "<fileDescription>"               ); fwrite($fh, $fileDescription                       ); fwrite($fh, "</fileDescription>"                  ); fwrite($fh, "\n");
			fwrite($fh, "<additionalComments>"            ); fwrite($fh, $additionalComments                    ); fwrite($fh, "</additionalComments>"               ); fwrite($fh, "\n");
			fwrite($fh, "<department>"                    ); fwrite($fh, $department                            ); fwrite($fh, "</department>"                       ); fwrite($fh, "\n");
			fwrite($fh, "<email>"                         ); fwrite($fh, $email                                 ); fwrite($fh, "</email>"                            ); fwrite($fh, "\n");
			fwrite($fh, "<willYouGrade>"                  ); fwrite($fh, $willYouGrade                          ); fwrite($fh, "</willYouGrade>"                     ); fwrite($fh, "\n");
			fwrite($fh, "<phone_area>"                    ); fwrite($fh, $phone_area                            ); fwrite($fh, "</phone_area>"                       ); fwrite($fh, "\n");
			fwrite($fh, "<phone_prefix>"                  ); fwrite($fh, $phone_prefix                          ); fwrite($fh, "</phone_prefix>"                     ); fwrite($fh, "\n");
			fwrite($fh, "<phone_suffix>"                  ); fwrite($fh, $phone_suffix                          ); fwrite($fh, "</phone_suffix>"                     ); fwrite($fh, "\n");
			fwrite($fh, "<path>"                          ); fwrite($fh, $path                                  ); fwrite($fh, "</path>"                             ); fwrite($fh, "\n");
			fwrite($fh, "<documentFileName>"              ); fwrite($fh, $documentFileName                      ); fwrite($fh, "</documentFileName>"                 ); fwrite($fh, "\n");
			fwrite($fh, "<rubricFileName>"                ); fwrite($fh, $rubricFileName                        ); fwrite($fh, "</rubricFileName>"                   ); fwrite($fh, "\n");
			fwrite($fh, "<studentInstructionsFileName>"   ); fwrite($fh, $studentInstructionsFileName           ); fwrite($fh, "</studentInstructionsFileName>"      ); fwrite($fh, "\n");
			fwrite($fh, "<instructorInstructionsFileName>"); fwrite($fh, $instructorInstructionsFileName        ); fwrite($fh, "</instructorInstructionsFileName>"   ); fwrite($fh, "\n");
		fwrite($fh, "</metadata>\n");                                                                                            
		fwrite($fh, "\n");
		fclose($fh);
		Verbose(getNewLine() . "metadata written.");
	}

	/* Use this to write to the html stream */
	function Verbose($msg) {
		global $verbose;
		if ($verbose)
			echo($msg);
	}
?> 
