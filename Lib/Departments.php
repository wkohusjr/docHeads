<?php
class Departments
{
  protected $departmentId;
  protected $departmentName;
  protected $createdTs;
  protected $updatedTs;

  public function getDeptList()
  {
    include 'MySqlConnect.php';
    $deptList = array();

    $conn = new MySqlConnect();
    $conn -> __construct();
    $result = $conn -> executeQuery("SELECT departmentName FROM Departments ORDER BY departmentName Desc");

    while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
    {
      $deptList = array_push($row[0]);
    }
    $conn -> freeConnection();

    return $deptList;
  }

  public function createDept($deptName)
  {
    include 'MySqlConnect.php';
    $conn = new MySqlConnect();
    $conn -> __construct();
    $isCreated = FALSE;
    $currentTs = $conn -> getCurrentTs();

    $deptName = $conn -> sqlCleanup($deptName);
    $isCreated = $conn -> executeQuery("INSERT INTO Departments(departmentName, createTs, updatedTs) VALUES ('%s', '%s', '%s')", $deptName, $currentTs, $currentTs);
    $conn -> freeConnection();
    return $isCreated;
  }

  public function deleteDept($deptName)
  {
    include 'MySqlConnect.php';
    $conn = new MySqlConnect();
    $conn -> __construct();
    $isDeleted = FALSE;
    $currentTs = $conn -> getCurrentTs();

    $deptName = $conn -> sqlCleanup($deptName);
    $isDeleted = $conn -> executeQuery("DELETE FROM Departments WHERE departmentName = '%s'", $deptName);
    $conn -> freeConnection();
    return $isDeleted;
  }
}
?>