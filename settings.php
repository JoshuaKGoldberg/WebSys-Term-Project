<?php
  /* General system settings
   * Stores the database settings, such as host and table names
  */
  
  // Database info
  $dbHost = "localhost";
  $dbUser = "root";
  $dbPass = "";
  $dbName = "WebSysProject";
  
  /* Book particulars
  */
  
  $bookStates  = array('Terrible', 'Poor', 'Fair', 'Good', 'Very Good', 'Like New');
  $bookCondDefault = 'Good';
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
      $conn = new PDO('mysql:host=' . $dbHost . ';dbname=' . $dbName, $dbUser, $dbPass);
      // This helps with debugging (enables the PDOExceptions)
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } 
    catch(PDOException $err) {
      echo 'Error creating PDO: ' . $err->getMessage();
    }
    return($conn);
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
  // Returns whether a key of the value exists under the row, in that table
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
?>