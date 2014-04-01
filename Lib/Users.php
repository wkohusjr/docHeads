<?php
/*
 * Users.php object used to manage all user functions.
 * - CRUD functionality
 * - Password encryption
 * - Password resets
 * - Registering users
 * - Validating users
 */
include ('MySqlConnect.php');
class Users
{
  protected $username;
  protected $password;
  protected $firstName;
  protected $lastName;
  protected $email;
  protected $userType;
  protected $emailOptIn;

  /**
   * Method used to encode user passwords. Uses the SHA512 hash algorithm to
   * encode the passwords.
   *
   * @param $password - string value to encode
   * @return $passEncoding - string value representing the hashed encoding
   */
  public static function encodePassword($password)
  {
    // hash the password and return a 128 bit hash
    $passEncoding = hash("sha512", $password);

    return $passEncoding;
  }

  /**
   * Method used to return the corresponding primary key value for the passed in
   * user type reference.
   *
   * @param $userType - string value corresponding to the db primary key:
   * 'STANDARD' or 'ADMIN'
   * @return $id - int value of the primary key
   */
  public static function getUserTypeIDValue($userType)
  {
    $conn = new MySqlConnect();
    $id;

    $userType = $conn -> sqlCleanup($userType);
    // query the db for the value comparison
    $result = $conn -> executeQueryResult("SELECT userTypeId FROM UserTypes WHERE userTypeName = '{$userType}'");

    // use mysql_fetch_array($result, MYSQL_ASSOC) to access the result object
    while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
    {
      // access the password value in the db
      $id = $row['userTypeId'];
    }
    $conn -> freeConnection();
    return $id;
  }

  /**
   * Method used to check the user record isValidated value in the db. Indicates
   * if the registered user is authorized to access the site.
   *
   * @return $isValid - boolean; returns TRUE if the user is validated/authorized
   */
  public static function isAuthorized()
  {
    $conn = new MySqlConnect();
    $isValid = FALSE;

    if (isset($_SESSION['email']))
    {
      $email = $_SESSION['email'];
      // query the db for the value comparison
      $result = $conn -> executeQueryResult("SELECT isValidated FROM Users WHERE emailAddress = '{$email}'");
      // get a row count to verify only 1 row is returned
      $count = mysql_num_rows($result);
      if ($count == 1)
      {
        // use mysql_fetch_array($result, MYSQL_ASSOC) to access the result
        // object
        while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
        {
          // check the boolean value
          if ($row['isValidated'] == 1)
          {
            $isValid = TRUE;
          }
        }
      }
      $conn -> freeConnection();
    }
    return $isValid;
  }

  /**
   * Method used to validate the username and password credentials against the
   * values in the database. Method also sets the following Session variables
   * upon validation:
   *
   * $_SESSION['name']
   * $_SESSION['userType']
   * $_SESSION['email']
   *
   * @param $email - string value to check against the email/username in the db
   * @param $password - string value to check against the password in the db
   * @return isValid - boolean value: returns TRUE if user record exists
   */
  public static function validateUser($email, $password)
  {
    $conn = new MySqlConnect();
    $isValid = FALSE;
    $dbHash = null;
    $userId = null;
    $name = null;
    $userType = null;

    // hash the submitted password to to verify against the value in the db
    $hash = Users::encodePassword($password);

    $email = $conn -> sqlCleanup($email);
    // query the db for the value comparison
    $result = $conn -> executeQueryResult("SELECT password, fName, lName, userTypeId FROM Users WHERE emailAddress = '{$email}'");

    // get a row count to verify only 1 row is returned
    $count = mysql_num_rows($result);
    if ($count == 1)
    {
      // use mysql_fetch_array($result, MYSQL_ASSOC) to access the result object
      while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
      {
        // access the password value in the db
        $dbHash = $row['password'];
        $userType = $row['userTypeId'];
        $name = "{$row['fName']} {$row['lName']}";
      }

      // compare the input password hash with the db hash, and set as valid if
      // they match
      if ($hash == $dbHash)
      {
        $isValid = TRUE;
        session_start();
        // register the userId, name, and userType in the $_SESSION
        $_SESSION['name'] = $name;
        $_SESSION['userType'] = $userType;
        $_SESSION['email'] = $email;
        $_SESSION['timeout'] = time();
      }
    }
    $conn -> freeConnection();
    return $isValid;
  }

  /**
   * Method used to if a user with the same email already exists in the database.
   *
   * @param $email - string value of the email/username to check in the db
   * @return $isFound - boolean; returns TRUE if the user's email record already
   * exists
   */
  public static function exists($email)
  {
    $conn = new MySqlConnect();
    $isFound = FALSE;

    $email = $conn -> sqlCleanup($email);
    // query the db for the value comparison
    $result = $conn -> executeQueryResult("SELECT userId FROM Users WHERE emailAddress = '{$email}'");

    // get a row count to verify only 1 row is returned
    $count = mysql_num_rows($result);
    if ($count == 1)
    {
      $isFound = TRUE;
    }
    $conn -> freeConnection();
    return $isFound;
  }

  /**
   * Method used to reset a user's password. Calls encodePassword to hash the
   * value of the password parameter before it gets updated in the database
   *
   * @param $username - string value of the username used in the database update
   * @param $password - string of the plain text password to hash before updated
   * in the database
   * @return $isCommit - boolean; returns TRUE if update is committed
   */
  public function resetPassword($username, $password)
  {
    $conn = new MySqlConnect();
    $isCommit = FALSE;

    $username = $conn -> sqlCleanup($username);
    $hash = Users::encodePassword($password);
    $ts = $conn -> getCurrentTs();

    $isCommit = $conn -> executeQuery("UPDATE Users SET password = '%s', updatedTs = '%s' WHERE username = '%s'", $hash, $ts, $username);
    $conn -> freeConnection();
    return $isCommit;
  }

  /**
   * Method used to register/create a new user in the system.
   *
   * @param $username- string value for the username
   * @return $isCommit - boolean; returns TRUE if the user record is committed
   */
  public static function registerUser($password, $firstName, $lastName, $email, $emailOptIn)
  {
    $isCommit = FALSE;
    $conn = new MySqlConnect();
    $ts = $conn -> getCurrentTs();

    $password = $conn -> sqlCleanup($password);
    $firstName = $conn -> sqlCleanup($firstName);
    $lastName = $conn -> sqlCleanup($lastName);
    $email = $conn -> sqlCleanup($email);
    $emailOptIn = $conn -> sqlCleanup($emailOptIn);
    $userTypeId = Users::getUserTypeIDValue('STANDARD');

    // hash the password
    $hash = Users::encodePassword($password);
    $sqlQuery = "INSERT INTO Users (password, fName, lName, emailAddress, userTypeID, emailOptIn, isValidated, createDate, updateDate)";
    $sqlQuery .= "VALUES ('{$hash}', '{$firstName}', '{$lastName}', '{$email}', '{$userTypeId}', '{$emailOptIn}', 0, '{$ts}', '{$ts}')";

    $isCommit = $conn -> executeQuery($sqlQuery);
    $conn -> freeConnection();

    return $isCommit;
  }

  /**
   * Method used to delete a user record from the database.
   *
   * @param $username - string value of the username value to delete
   * @return $isCommit - boolean; returns TRUE if delete is committed
   */
  public function deleteUser($username)
  {
    $isCommit = FALSE;
    $conn = new MySqlConnect();

    $username = $conn -> sqlCleanup($username);
    $isCommit = $conn -> executeQuery("DELETE FROM Users WHERE username = '%s'", $username);

    $conn -> freeConnection();
    return $isCommit;
  }

  public function getUserList()
  {
    $result;
    $userList = array();
    $conn = new MySqlConnect();

    $result = $conn -> executeQueryResult("SELECT username FROM Users");
    if (isset($result))
    {
      // use mysql_fetch_array($result, MYSQL_ASSOC) to access the result object
      while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
      {
        // access the password value in the db
        $userList = array_push($row[0]);
      }
    }
    $conn -> freeConnection();
    return $userList;
  }

  /**
   * Method used to return an associative array of unauthorized users still in
   * the system
   *
   * Ex.
   *
   * 		$userList['email'] = test@test.com
   *
   * @return $userList - associative array of emails/usernames
   */
  public static function getUnauthorizedUserList()
  {
    $result;
    $userList = array();
    $conn = new MySqlConnect();

    $result = $conn -> executeQueryResult("SELECT email FROM Users WHERE isValidated = 0");
    if (isset($result))
    {
      // use mysql_fetch_array($result, MYSQL_ASSOC) to access the result object
      while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
      {
        // access the password value in the db
        $userList = array_push($row['email']);
      }
    }

    $conn -> freeConnection();
    return $userList;
  }

  /**
   * Method used to authorize a user to access the web app. Method updates the
   * corresponding isValidated column value to TRUE (1) in the db for the passed
   * in email/username.
   *
   * @param $email - string value representing the corresponding email/username
   * to authorize
   * @return $isCommit - boolean; returns TRUE if user authorization is committed
   */
  public static function authorizeUser($email)
  {
    $isCommit = FALSE;
    $conn = new MySqlConnect();
    $ts = $conn -> getCurrentTs();

    $updateSql = "UPDATE Users";
    $updateSql .= "   SET isValidated = 1";
    $updateSql .= " WHERE emailAddress = '{$email}'";

    // update existing user record in the database
    $isCommit = $conn -> executeQuery($updateSql);
    $conn -> freeConnection();

    return $isCommit;
  }

  public static function updateUser($email, $fName, $lName, $userType, $emailOptIn, $newPass)
  {
    $isCommit = FALSE;

    $conn = new MySqlConnect();
    $ts = $conn -> getCurrentTs();

    $email = $conn -> sqlCleanup($email);
    $fName = $conn -> sqlCleanup($fName);
    $lName = $conn -> sqlCleanup($lName);
    $emailOptIn = $conn -> sqlCleanup($emailOptIn);

    // start building the UPDATE statement
    $updateSql = "UPDATE Users";
    $updateSql .= "  SET fName = '{$fName}',";
    $updateSql .= "      lName = '{$lName}',";
    $updateSql .= "      userTypeId = '{$userType}',";
    $updateSql .= "      emailOptIn = '{$emailOptIn}',";

    // check for the new password and insert the hash value
    if ($newPass != null)
    {
      $newPass = $conn -> sqlCleanup($newPass);
      $hash = Users::encodePassword($newPass);
      $updateSql .= "      password = '{$hash}',";
    }
    $updateSql .= "      updateDate = '{$ts}'";
    $updateSql .= "WHERE emailAddress = '{$email}'";

    // update existing submission record in the database
    $isCommit = $conn -> executeQuery($updateSql);
    $conn -> freeConnection();

    return $isCommit;
  }

  /**
   * Method used to retrieve user properties for a corresponding email/username.
   *
   * @param $email - string value of the email/username record to retrieve
   * @return $userPropsArray - associative array containing the column names as
   * $key and column values as $value
   */
  public static function getUserProperties($email)
  {
    $userPropsArray = array();

    $conn = new MySqlConnect();

    $sql = "SELECT fName, lName, userTypeId, emailOptIn, isValidated FROM Users WHERE emailAddress = '{$email}'";

    // update existing submission record in the database
    $result = $conn -> executeQueryResult($sql);
    if ($row = mysql_fetch_array($result, MYSQL_ASSOC))
    {
      foreach ($row as $key => $value)
      {
        // access the password value in the db
        $userPropsArray[$key] = $value;
      }
    }

    $conn -> freeConnection();
    return $userPropsArray;
  }

  /**
   * Method used to bring retrieve a multi-dimensional array of associative
   * arrays of the user type IDs ($key) and user type names ($value). First
   * dimension key is an integer index, second dimension key is column name
   *
   * @return $userTypesArray - multi-dimensional array of associative arrays of
   * userTypeID values as the key
   * and userTypeName values as the value
   */
  public static function getUserTypesArray()
  {
    $userTypesArray = array();

    $conn = new MySqlConnect();

    $sql = "SELECT userTypeId, userTypeName FROM UserTypes";

    // update existing submission record in the database
    $result = $conn -> executeQueryResult($sql);
    while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
    {
      // assign the primary key value to the name
      array_push($userTypesArray, $row);
    }

    $conn -> freeConnection();
    return $userTypesArray;
  }

}
?>