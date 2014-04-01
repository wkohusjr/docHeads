<?php
/**
 * Class used to establish a data connection to a MySql database, execute sql
 * queries, get result sets, and close the db connection.
 */

class MySqlConnect
{
  protected $hostname = "localhost";
  protected $mysqlUsername = "root";
  protected $mysqlPassword = "";
  protected $databaseName = "docdatabase";
  protected $sqlQuery;
  protected $result;
  
  /**
   * Method called just before execution of a sql query. Use this to prevent sql
   * injection on each where clause parameter - escapes special string
   * characters, and un-quotes a quoted statement.
   *
   * @param $queryValue - string value used for the WHERE clause to clean up
   * @return $cleanQueryValue - the proper value format to use as a value in
   * query string
   */
  public function sqlCleanup($queryValue)
  {
    $cleanQueryValue = stripslashes($queryValue);
    $cleanQueryValue = mysql_real_escape_string($cleanQueryValue);

    return $cleanQueryValue;
  }

  /**
   * Method used to execute a query that doesn't expect a result set - CREATE,
   * UPDATE, DELETE
	 * 
   * @param $sqlQuery - string value representing the SQL query
   * @return $isCommit - boolean: returns true if query is committed
   */
  public function executeQuery($sqlQuery)
  {
    $isCommit = FALSE;
		mysql_connect($this -> hostname, $this -> mysqlUsername, $this -> mysqlPassword) or die('Could not connect: ' . mysql_error());
		mysql_select_db($this -> databaseName);
    $isCommit = mysql_query($sqlQuery) or die("MySql Error: " . mysql_error());

    return $isCommit;
  }

  /**
   * Method used to execute a query when you expect a result set object in
   * return. Use mysql_fetch_array($result, MYSQL_ASSOC) on the returned object
   * to iterate through each row as an array and access the values via index
   * number or column name
   *
   * @param $sqlQuery - string value representing the SQL query
   * @return $result - MySQL result object as the query result set
   */
  public function executeQueryResult($sqlQuery)
  {
  	mysql_connect($this -> hostname, $this -> mysqlUsername, $this -> mysqlPassword) or die('Could not connect: ' . mysql_error());
  	mysql_select_db('docdatabase');
    $this -> result = mysql_query($sqlQuery) or die("MySql Error: " . mysql_error());

    return $this -> result;
  }

  public function freeConnection()
  {
    if (isset($this -> result))
    {
      mysql_free_result($this -> result);
    }
    mysql_close();
  }

  public function getCurrentTs()
  {
    date_default_timezone_set('America/New_York');
    $currentTs = date('Y-m-d H:i:s');

    return $currentTs;
  }

}
?>