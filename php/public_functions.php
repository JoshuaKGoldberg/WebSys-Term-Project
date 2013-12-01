<?php
  /* Functions the public may access via requests.js -> requests.php
   * The names of these functions are in settings.php -> $allowed_functions
  */
  
  // publicCheckValidity({...})
  // Checks if a field (username, email) is taken and echos if it's unavailable
  // Required fields:
  // * "type"   - "username" or "email" 
  // * "value"  - the value to see if it's duplicate or not
  function publicCheckValidity($arguments) {
    $dbConn = $_SESSION['dbConn'];
    $field = $arguments['type'];
    $value = $arguments['value'];
    if(checkKeyExists($dbConn, 'users', $field, $value))
      echo "The " . $field . " '" . $value . "' is already taken :(";
  }
  
  // publicCreateUser({...})
  // Public pipe to dbUsersAdd("username", "password")
  // Required fields:
  // * "username"
  // * "password"
  // * "email"
  function publicCreateUser($arguments) {
    $dbConn = $_SESSION['dbConn'];
    $username = $arguments['username'];
    $password = $arguments['password'];
    $email = $arguments['email'];
    return dbUsersAdd($dbConn, $username, $password, $email, 0);
  }
  
  // publicLogin({...})
  // Public pipe to loginAttempt("username", "password")
  // Required fields:
  // * "username"
  // * "password"
  function publicLogin($arguments) {
    $username = $arguments['username'];
    $password = $arguments['password'];
    loginAttempt($username, $password);
    print_r($_SESSION);
  }
?>