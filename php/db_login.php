<?php
  /* Scripts for logging into the site
  */
  require_once('settings.php');
  require_once('db_actions.php');
  
  // Runs through all the motions of attempting to log in with the given credentials
  // If successfull, the timetamp and users info are copied to $_SESSION
  // Otherwise $_SESSION['Fail Counter'] is incremented
  function loginAttempt($username, $password) {
    $dbConn = getPDOQuick();
    session_start();
    
    // First check if the passwords match
    $user_info = loginCheckPassword($dbConn, $username, $password);
    if(!$user_info) {
      // If they didn't, increase the session's fail counter
      if(!isset($_SESSION['Fail Counter']))
        $_SESSION['Fail Counter'] = 1;
      else ++$_SESSION['Fail Counter'];
      return false;
    }
    
    // Since they did, copy the user info over
    foreach($user_info as $key => $value)
      if(!is_numeric($key)) # Skip '0', '1', etc.
        $_SESSION[$key] = $value;
    $_SESSION['Logged In'] = time();
    
    return true;
  }
  
  // loginCheckPassword("username", "password")
  // Returns whether the password matches
  // false is returned on failure
  // $user_info (an associative array of user info) is returned on success
  function loginCheckPassword($dbConn, $username, $password) {
    // Grab all relevant information about the user from the database
    $user_info = dbUsersGet($dbConn, $username);
    
    // Get the salt to hash the password, making sure they match
    $salted = hash('sha256', $user_info['salt'] . $password);
    return ($salted == $user_info['password']) ? $user_info : false;
  }
?>