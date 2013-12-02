<?php
  /* General system settings
   * Stores the database settings, such as host and table names
  */
  
  // General site info
  function getSiteName() { return "RPI Textbook Exchange"; }
  function getNumBooks() { return "dozens"; }
  function getSiteEmail() { return "nope@nope.com"; }
  
  // Database info lookups
  function getDBHost() { return "localhost"; }
  function getDBUser() { return "root"; }
  function getDBPass() { return ""; }
  function getDBName() { return "WebSysProject"; }
  
  // Database info
  $dbHost = getDBHost();
  $dbUser = getDBUser();
  $dbPass = getDBPass();
  $dbName = getDBName();
  
  // Google API
  function getGoogleKey() { return "AIzaSyD2FxaIBhdLTA7J6K5ktG4URdCFmQZOCUw"; }
  $sample_isbns = array('9780073523323', '9780072463521', '9780199959570', '9780130673893', '9780873895620', '9780073341521', '9780470458365', '9780538733519', '9780470115398', '9780123850737', '9780070168930', '9780538482127', '9781893281080', '9780273713630', '9780132168380', '9781422162606', '9789970086979', '9780133063004', '9780078029103', '9781133586548', '9780521148436', '9780521066013', '9780393310351', '9781608193387', '9780133020267', '9780133058789', '9780078112621');
  
  // Names of functions that may be called by functions.php
  $allowed_functions = array(
    'publicLogin', 'publicCheckValidity', 'publicCreateUser', 'publicAddBook', 'publicSearch', 'publicGetBookEntries'
  );
  foreach($allowed_functions as $name)
    $allowed_functions[$name] = true;
  
  /* Book particulars
  */
  
  $bookCondDefault = 'Good';
  $bookStates      = array('Terrible', 'Poor', 'Fair', 'Good', 'Very Good', 'Like New');
  $bookActions     = array('Buy', 'Sell', 'Trade', 'Wish');
  $historyRatings  = array('0', '1', '2', '3', '4', '5');
  
  // getActionOpposite("action")
  // Returns the opposite action (like Buy / Sell) for a transaction
  function getActionOpposite($action) {
    switch($action) {
      case 'Buy': return 'Sell';
      // Currently there are no others.
      default: return $action;
    }
  }
  
  /* Quick PDO Functions
  */
  
  // getPDO("dbHost", "dbName", "dbUser", "dbPass")
  // Gets a new PDO object with the given settings
  // Sample usage: $dbConn = getPDO($dbHost, $dbName, $dbUser, $dbPass);
  function getPDO($dbHost, $dbName, $dbUser, $dbPass) {
    try {
      $dbConn = new PDO('mysql:host=' . $dbHost . ';dbname=' . $dbName, $dbUser, $dbPass);
      // This helps with debugging (enables the PDOExceptions)
      $dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } 
    catch(PDOException $err) {
      echo 'Error creating PDO: ' . $err->getMessage();
      $dbConn = false;
    }
    return $dbConn;
  }
  
  // getPDOQuick()
  // Gets a new PDO object with the default settings
  // Sample usage: $dbConn = getPDOQuick();
  function getPDOQuick() {
    return getPDO(getDBHost(), getDBName(), getDBUser(), getDBPass());
  } 
  
  // getSessionPDO()
  // Returns $_SESSION['dbConn'] (after creating it if it doesn't exist)
  function getSessionPDO() {
    // First grab the info about the book
    if(!isset($_SESSION)) session_start();
    if(!isset($_SESSION['dbConn']))
      $_SESSION['dbConn'] = getPDOQuick();
    return $_SESSION['dbConn'];
  }
  
  // getPDOStatement($dbConn, $query)
  // Runs the typical preparation function on the PDO object for a statement
  function getPDOStatement($dbConn, $query) {
    return $dbConn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
  }
  
  
  /* Quick SQL Functions
  */
  
  // makeSQLEnum([...])
  // Turns [7,14] into "'7', '14'"
  function makeSQLEnum($myarr) {
    if(is_string($myarr)) return $myarr;
    return '\'' . implode($myarr, '\', \'') . '\'';
  }
  
  // makeSQLSelects([...])
  // Turns [7,14] into "`7`, `14`"
  function makeSQLSelects($myarr) {
    if(is_string($myarr)) return $myarr;
    return '`' . implode($myarr, '`, `') . '`';
  }
  
  // filterUserID(userID)
  // Makes the id a string of only numbers
  function filterUserID($userID) {
    return str_replace(['+', '-'], '', filter_var('' . $userID, FILTER_SANITIZE_NUMBER_FLOAT));
  }
  
  
  /* Common SQL Queries
  */
  
  // checkKeyExists($dbConn, "table", "row", "value")
  // Returns a bool of whether a key of the value exists under the row, in that table
  function checkKeyExists($dbConn, $table, $row, $value) {
    $query = '
      SELECT `' . $row . '` FROM `' . $table . '`
      WHERE `' . $row . '` LIKE :value
    ';
    $stmnt = getPDOStatement($dbConn, $query);
    $stmnt->execute(array(':value' => $value));
    $results = $stmnt->fetch(PDO::FETCH_ASSOC);
    return !empty($results);
  }
  
  // getRowValue($dbConn, "table"", "valCol", "keyCol", "keyVal")
  // Returns the single value at a specified column of a specified row
  function getRowValue($dbConn, $table, $valCol, $keyCol, $keyVal) {
    $query = '
      SELECT `' . $valCol . '` FROM `' . $table . '`
      WHERE `' . $keyCol . '` = :myval
    ';
    $stmnt = getPDOStatement($dbConn, $query);
    $stmnt->execute(array(':myval' => $keyVal));
    $result = $stmnt->fetch(PDO::FETCH_OBJ);
    return $result->$valCol;
  }
  
  
  /* Common SQL Gets
  */
  
  // getUserInfo(PDO, #userID)
  // Gets all the info about a user from the database  
  function getUserInfo($dbConn, $userID) {
    // Grab and return that userID's information from the database
    return $dbConn->query('
      SELECT * FROM `users`
      WHERE `user_id` LIKE ' . filterUserID($userID) . '
      LIMIT 1
    ')->fetch();
  }
  
  // getUserEntries(PDO, $userID[, 'action'])
  // Gets all entries from a user
  // Optionally filters on action type
  function getUserEntries($dbConn, $userID, $action='%') {
    // Prepare the query SQL
    $query = '
      SELECT * FROM `entries`
      WHERE `user_id` LIKE ' . filterUserID($userID) . '
      AND `action` LIKE :action
    ';
    // Create, run, and return a statement from the query
    $stmnt = getPDOStatement($dbConn, $query);
    $stmnt->execute(array(':action' => $action));
    return $stmnt->fetchAll();
  }
  
  // getUserRatings(PDO, $userID[, 'actions'])
  // Returns the average of all ratings regarding a user
  // Optionally filters on action type
  function getUserRating($dbConn, $userID, $action='%') {
    $query = '
      SELECT AVG(`user_rating`) FROM `history`
      WHERE `user_rated` LIKE ' . filterUserID($userID) . '
      AND `action` LIKE :action
    ';
    // Create, run, and return a statement from the query
    $stmnt = getPDOStatement($dbConn, $query);
    $stmnt->execute(array(':action' => $action));
    return $stmnt->fetchAll();
  }

  
  /* Other Utilities
  */
  
  // getHTTPPage("url")
  // Runs a cURL request on a page, returning the result
  function getHTTPPage($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 7);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
    $data = curl_exec($ch);
    if($data === FALSE)
      echo curl_error($ch);
    curl_close($ch);
    return $data;
  }
?>