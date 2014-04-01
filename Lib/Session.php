<?php
Class Session
{
  protected $sessionUsername;
  protected $sessionUserId;

  public static function validateSession()
  {
    session_start();
    if (!isset($_SESSION['name']) && !isset($_SESSION['userId']) && !isset($_SESSION['userType']))
    {
      header("location:../Authentication/login.php");
    }
  }

  public static function getLoggedInName()
  {
    // return the session username value from the session variable
    return $_SESSION['name'];
  }

  public static function getLoggedInUserId()
  {
    // return the session userId value from the session variable
    return $_SESSION['userId'];
  }

  public static function getLoggedInUserType()
  {
    // return the session userId value from the session variable
    return $_SESSION['userType'];
  }

  public static function getLoggedInUserEmail()
  {
    // return the session userId value from the session variable
    return $_SESSION['email'];
  }

  public static function logOutSession()
  {
    session_start();
    return session_destroy();
  }
}
?>