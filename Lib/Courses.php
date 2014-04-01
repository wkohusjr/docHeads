<?php
class Courses
{
  protected $courseId;
  protected $courseName;
  protected $deptId;

  /**
   * Method used to return ALL courses in the system in the form of an array of
   * string arrays. Each course record returned consists of the course ID and
   * name.
   *
   * Ex.
   *    $courseList = [ '1' => 'Accounting 101', '2' => 'Acounting 201', '3' =>
   * 'Biology 101',...]
   *
   * @return $courseList - associative array of strings of ALL course IDs and
   * names in the system; alphabetical by course name
   */
  public static function getCourseList()
  {
    $courseList = array();
    include 'MySqlConnect.php';
    $conn = new MySqlConnect();
    $conn -> __construct();

    $sqlQuery = "SELECT courseId, courseName FROM Courses ORDER BY courseName";

    $courseListResult = $conn -> executeQueryResult($sqlQuery);

    if ($row = mysql_fetch_array($result, MYSQL_ASSOC))
    {
      // makes and array of $key = courseId, $value = course name
      $courseList[$row[0]] = $row[1];
    }

    $conn -> freeConnection();
    return $courseListResult;
  }

  /**
   * Method used to return a course list associated to a specific department.
   * Each course record returned consists of the course ID and name
   *
   * Ex.
   *    $courseList = [ '1' => 'Accounting 101', '2' => 'Acounting 201', '3' =>
   * 'Accounting 301',...]
   *
   * @param $deptId - int value of the deptId the course list relates to
   * @return $courseList - associative array of strings of course IDs and names
   */
  public static function getCourseListByDept($deptId)
  {
    $courseList = array();
    include 'MySqlConnect.php';
    $conn = new MySqlConnect();
    $conn -> __construct();
    $deptId = $conn -> sqlCleanup($deptId);

    //
    $sqlQuery = "SELECT courseId, courseName FROM Courses WHERE deptId = '{$deptId}' ORDER BY courseName";

    $courseListResult = $conn -> executeQueryResult($sqlQuery);

    if ($row = mysql_fetch_array($result, MYSQL_ASSOC))
    {
      // makes and array of $key = courseId, $value = course name
      $courseList[$row[0]] = $row[1];
    }

    $conn -> freeConnection();
    return $courseListResult;
  }

  /**
   * Method used to return an associative array of string data representing
   * course properties ($key) and corresponding values ($value)
   *
   * Ex.
   *    $propertiesArray = [ 'deptId' => '1', 'courseName' => 'Acounting 201']
   *
   * @param $courseID - int value of course primary key in database
   * @return $propertiesArray - associative array with course properties as array
   * $key and corresponding values as array $value
   */
  public static function getCourseProperties($courseId)
  {
    $propertiesArray = array();
    include 'MySqlConnect.php';
    $conn = new MySqlConnect();
    $conn -> __construct();

    $sqlQuery = "SELECT deptId, courseName FROM Courses WHERE courseId = '{$courseId}'";

    $courseListResult = $conn -> executeQueryResult($sqlQuery);

    if ($row = mysql_fetch_array($result, MYSQL_ASSOC))
    {
      // makes and array of $key = courseId, $value = course name
      $propertiesArray[$row[0]] = $row[1];
    }

    $conn -> freeConnection();
    return $propertiesArray;
  }

  /**
   * Method used to delete a course in the database from the courseId
   *
   * @param $courseId - int value; primary key of course record
   * @return $isCommit - returns true if delete committed in db, else MySQL error
   * message
   */
  public function deleteCourse($courseId)
  {
    $isCommit = FALSE;
    include 'MySqlConnect.php';
    $conn = new MySqlConnect();
    $conn -> __construct();

    $courseId = $conn -> sqlCleanup($courseId);

    $sqlQuery = "DELETE FROM Courses WHERE courseId = '{$courseId}'  ORDER BY courseName";

    $isCommit = $conn -> executeQuery($sqlQuery);

    $conn -> freeConnection();
    return $isCommit;
  }

  /**
   * Method used to create/insert a new course record in the system
   *
   * @param $courseName - string value naming the course
   * @param $deptId - int value for the foreign keyed department record
   * @return $isCommit - returns TRUE if commited to db, else MySQL error message
   *
   */
  public static function createCourse($courseName, $deptId)
  {
    $isCommit = FALSE;
    include 'MySqlConnect.php';
    $conn = new MySqlConnect();
    $conn -> __construct();
    $ts = $conn -> getCurrentTs();

    $courseName = $conn -> sqlCleanup($courseName);
    $deptId = $conn -> sqlCleanup($deptId);

    $sqlQuery = "INSERT INTO Courses (courseName, deptId, createdDate, updateDate)";
    $sqlQuery .= "            VALUES ('{$courseName}', '{$deptId}', '{$ts}', '$ts')";

    $isCommit = $conn -> executeQuery($sqlQuery);

    $conn -> freeConnection();
    return $isCommit;
  }

  /**
   * Method called to update a course record in the database
   *
   * @param $courseId - int value of the primary key of course record
   * @param $courseName - string value of the name of the course
   * @param $deptId - int value of the foreign keyed department record
   * @return $isCommit - returns TRUE if update commits to db, else MySQL error
   * message
   */
  public static function updateCourse($courseId, $courseName, $deptId)
  {
    $isCommit = FALSE;
    include 'MySqlConnect.php';
    $conn = new MySqlConnect();
    $conn -> __construct();
    $ts = $conn -> getCurrentTs();

    $courseName = $conn -> sqlCleanup($courseId);
    $courseName = $conn -> sqlCleanup($courseName);
    $deptId = $conn -> sqlCleanup($deptId);

    $sqlQuery = "UPDATE Courses ";
    $sqlQuery .= "  SET courseName = '{$courseName}', deptId = '{$deptId}', updateDate = '{$ts}'";
    $sqlQuery .= "WHERE courseId = '{$courseId}'";

    $isCommit = $conn -> executeQuery($sqlQuery);

    $conn -> freeConnection();
    return $isCommit;
  }

}
?>