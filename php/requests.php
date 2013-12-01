<?php
  /* Public API for running a limited subset of PHP functions
   * The allowed functions are defined by $allowed_functions in settings.php
  */
  require_once('settings.php');
  require_once('db_actions.php');
  require_once('db_login.php');
  require_once('public_functions.php');
  
  // Make sure $_SESSION['dbConn'] exists
  if(!isset($_SESSION['dbConn']))
    $_SESSION['dbConn'] = getPDOQuick();
  
  // Make sure a function is provided
  if(!isset($_GET['Function'])) return;
  
  // Get the requested function
  $function_name = $_GET['Function'];
  $function_name = preg_replace("/[^A-Za-z_0-9]/", '', $function_name);
  
  // Make sure that function is allowed
  if(!isset($allowed_functions[$function_name])) return;
  
  // If it is, run the function
  call_user_func($function_name, $_GET);
?>