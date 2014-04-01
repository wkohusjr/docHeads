<?php
class Submission
{
  /**
   * Method used to upload a file to the department repository. Method relies on
   * the value of the department 'select' drop down to be defined as
   * "department", and the 'option' values equal the department/directory names
   * to
   * upload the file. Course drop down selection requires the "value" to be
   * defined
   * as the courseId (primary) in the database
   *
   * Ex dept drop down:
   *
   * 		 <select name="department">
   * 				<option value="Accounting">Accounting</option>
   * 				<option value="Business">Business</option>
   * 		 </select>
   *
   * Ex course drop down:
   *
   *		 <select name="course">
   * 				<option value="1">Accounting 101</option>
   * 				<option value="2">Business 101</option>
   * 		 </select>
   *
   * The method also relies on the following variables being set in the
   * session/post:
   *
   * $_SESSION['username']
   * $_SESSION['userId']
   * $_POST['department']
   * $_POST['course']
   * $_POST['comments']
   * $_POST['courses'] - array from a multi-selection component in the form
   * submission
   *
   * @return $errMsg - string value equals 'Y' on success, otherwise an file
   * error message is returned.
   */
  public function uploadFile()
  {
    include 'MySqlConnect.php';
    $conn = new MySqlConnect();
    $conn -> __construct();
    $errMsg;
    $user = $_SESSION['username'];
    $userId = $_SESSION['userId'];
    $dept = $_POST['department'];
    $courseId = $_POST['course'];
    $comments = $_POST['comments'];
    $submissionUrl = "../DocsRepo/uploads/{$dept}/{$_FILES['submissionfile']['name']}";
    $gradingUrl = NULL;
    $studentInstUrl = NULL;
    $instructorInstUrl = NULL;
    $deptId = NULL;

    // get the dept ID for the corresponding
    $dept = $conn -> sqlCleanup($dept);
    $result = $conn -> executeQueryResult("SELECT deptId FROM Departments WHERE deptName = '%s'", $dept);
    //
    if ($row = mysql_fetch_array($result, MYSQL_ASSOC))
    {
      $deptId = $row[0];
      $conn -> freeConnection();
    }

    if (isset($_FILES['gradingFile']))
    {
      $gradingUrl = "../DocsRepo/uploads/{$dept}/{$_FILES['gradingFile']['name']}";
      if (!move_uploaded_file($_FILES['gradingFile']['tmp_name'], $gradingUrl))
      {
        // Problem! Set $errMsg value based upon the error:
        switch ($_FILES['gradingFile']['error'])
        {
          case 1 :
            $errMsg = 'Grading file exceeds the upload_max_filesize setting in php.ini';
            break;
          case 2 :
            $errMsg = 'Grading file exceeds the MAX_FILE_SIZE setting in the HTML form';
            break;
          case 3 :
            $errMsg = 'Grading file was only partially uploaded';
            break;
          case 4 :
            $errMsg = 'Grading file was uploaded';
            break;
          case 6 :
            $errMsg = 'Grading temporary folder does not exist.';
            break;
          default :
            $errMsg = 'Error uploading Grading file.';
            break;
        }
      }
    }
    if (isset($_FILES['studentInstFile']))
    {
      $studentInstUrl = "../DocsRepo/uploads/{$dept}/{$_FILES['studentInstFile']['name']}";
      if (!move_uploaded_file($_FILES['studentInstFile']['tmp_name'], $studentInstUrl))
      {
        // Problem! Set $errMsg value based upon the error:
        switch ($_FILES['studentInstFile']['error'])
        {
          case 1 :
            $errMsg = 'Student Instruction file exceeds the upload_max_filesize setting in php.ini';
            break;
          case 2 :
            $errMsg = 'Student Instruction file exceeds the MAX_FILE_SIZE setting in the HTML form';
            break;
          case 3 :
            $errMsg = 'Student Instruction file was only partially uploaded';
            break;
          case 4 :
            $errMsg = 'Student Instruction file was uploaded';
            break;
          case 6 :
            $errMsg = 'Student Instruction temporary folder does not exist.';
            break;
          default :
            $errMsg = 'Error uploading Student Instruction file.';
            break;
        }
      }
    }
    if (isset($_FILES['instructorInstFile']))
    {
      $instructorInstUrl = "../DocsRepo/uploads/{$dept}/{$_FILES['instructorInstFile']['name']}";
      if (!move_uploaded_file($_FILES['instructorInstFile']['tmp_name'], $instructorInstUrl))
      {
        // Problem! Set $errMsg value based upon the error:
        switch ($_FILES['instructorInstFile']['error'])
        {
          case 1 :
            $errMsg = 'Instructor Instruction file exceeds the upload_max_filesize setting in php.ini';
            break;
          case 2 :
            $errMsg = 'Instructor Instruction file exceeds the MAX_FILE_SIZE setting in the HTML form';
            break;
          case 3 :
            $errMsg = 'Instructor Instruction file was only partially uploaded';
            break;
          case 4 :
            $errMsg = 'Instructor Instruction file was uploaded';
            break;
          case 6 :
            $errMsg = 'Instructor Instruction temporary folder does not exist.';
            break;
          default :
            $errMsg = 'Error uploading Instructor Instruction file.';
            break;
        }
      }
    }

    // validate the submission file upload
    if (move_uploaded_file($_FILES['submissionfile']['tmp_name'], $submissionUrl))
    {
      $conn = new MySqlConnect();
      $conn -> __construct();

      $submissionUrl = $conn -> sqlCleanup($submissionUrl);
      $deptId = $conn -> sqlCleanup($deptId);
      $userId = $conn -> sqlCleanup($userId);
      $gradingUrl = $conn -> sqlCleanup($gradingUrl);
      $studentInstUrl = $conn -> sqlCleanup($studentInstUrl);
      $instructorInstUrl = $conn -> sqlCleanup($instructorInstUrl);
      $comments = $conn -> sqlCleanup($comments);
      $ts = $conn -> sqlCleanup($ts);

      // check to see if there is an existing entry in the database for this file
      // name and department. If so, just update that record.
      $sql = "SELECT count(*)\n";
      $sql .= "  FROM Submissions\n";
      $sql .= " WHERE docName = '{$submissionUrl}'\n";
      $sql .= "   AND deptId = '{$deptId}'";
      $sql .= "   AND courseId = '{$courseId}'";

      $result = $conn -> executeQueryResult($sql);
      $conn -> freeConnection();
      $ts = $conn -> getCurrentTs();

      if (count($result) >= 1)
      {
        // update existing submission record in the database
        $isCommit = $this -> updateSubmission($userId, $submissionUrl, $deptId, $courseId, $gradingUrl, $studentInstUrl, $instructorInstUrl, $comments);

        if ($isCommit)
        {
          $errMsg = 'Y';
        }
        else
        {
          $errMsg = "Error updating submission record to database";
        }

      }
      else
      {
        $conn = new MySqlConnect();
        $conn -> __construct();
        $insertSql = "INSERT INTO Submissions (docName, userId, deptId, courseId, rubricFileName, studentInstructions, instructorInstructions, comments, createdDate, updateDate)";
        $insertSql .= "                VALUES ('{$submissionUrl}', '{$userId}', '{$deptId}', '{$courseId}', '{$gradingUrl}, '{$studentInstUrl}', '{$instructorInstUrl}', '{$comments}', '{$ts}', '{$ts}')";

        // insert the submission record in the database
        $isCommit = $conn -> executeQuery($insertSql);

        // if commit is successful return 'Y', otherwise return an error
        if ($isCommit)
        {
          $errMsg = 'Y';
        }
        else
        {
          $errMsg = "Error inserting submission record to database";
        }
      }

    }
    else
    {
      // Problem! Set $errMsg value based upon the error:
      switch ($_FILES['submissionfile']['error'])
      {
        case 1 :
          $errMsg = 'Submission file exceeds the upload_max_filesize setting in php.ini';
          break;
        case 2 :
          $errMsg = 'Submission file exceeds the MAX_FILE_SIZE setting in the HTML form';
          break;
        case 3 :
          $errMsg = 'Submission file was only partially uploaded';
          break;
        case 4 :
          $errMsg = 'Submission file was uploaded';
          break;
        case 6 :
          $errMsg = 'Submission temporary folder does not exist.';
          break;
        default :
          $errMsg = 'Error uploading Submission file.';
          break;
      }
    }
    $conn -> freeConnection();
    return $errMsg;
  }

  public function updateSubmission($userId, $submissionUrl, $deptId, $courseId, $gradingUrl, $studentInstUrl, $instructorInstUrl, $comments)
  {
    $isCommit = FALSE;

    $conn = new MySqlConnect();
    $conn -> __construct();
    $ts = $conn -> getCurrentTs();

    $updateSql = "UPDATE Submissions";
    $updateSql .= "   SET userId = '{$userId}',";
    if (isset($gradingUrl))
    {
      $updateSql .= "       rubricFileName = '{$gradingUrl}',";
    }
    if (isset($studentInstUrl))
    {
      $updateSql .= "       studentInstructions = '{$studentInstUrl}',";
    }
    if (isset($instructorInstUrl))
    {
      $updateSql .= "       instructorInstructions = '{$instructorInstUrl}',";
    }
    $updateSql .= "       comments = '{$comments}',";
    $updateSql .= "       updateDate = '{$ts}'";
    $updateSql .= " WHERE docName = '{$submissionUrl}'";
    $updateSql .= "   AND deptId = '{$deptId}'";
    $updateSql .= "   AND courseId = '{$courseId}'";

    // update existing submission record in the database
    $isCommit = $conn -> executeQuery($updateSql);
    $conn -> freeConnection();

    return $isCommit;

  }

}
?>
