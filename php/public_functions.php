<?php
  /* Functions the public may access via requests.js -> requests.php
   * The names of these functions are in settings.php -> $allowed_functions
  */
  
  // publicCheckValidity({..})
  // Checks if a field (username, email) is taken and echos if it's unavailable
  // Required fields:
  // * "type"   - "username" or "email" 
  // * "value"  - the value to see if it's duplicate or not
  function publicCheckValidity($arguments) {
    $field = $arguments['type'];
    $value = $arguments['value'];
    if(checkKeyExists($_SESSION['dbConn'], 'users', $field, $value))
      echo "The " . $field . " '" . $value . "' is already taken :(";
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