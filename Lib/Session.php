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
        else
    {
      // if user session is registered, check to see if the 15 min timeout window
      // has elapsed
      if ($_SESSION['timeout'] + 15 * 60 < time())
      {
        // if so, log out/destroy the session and redirect to login
        $this -> logOutSession();
        header("location:../Authentication/login.php");
      }
      else
      {
        // if not, update the timeout to a recent timestamp
        $_SESSION['timeout'] = time();
      }
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