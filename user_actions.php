<?php
  /*
   * Back-end actions the user is allowed to do
   * Includes manipulating their lists of books
  */
  
  require_once('settings.php');
  
  
  /* Entries Functions
  */
  
  // userWishlistAdd(#isbn, #user_id, #price, "condition")
  // Adds an entry to `entries` 
  // Sample usage: userEntriesAdd($dbConn, 12341, 123, 'Buy', 12.34, 'Fair');
  function userEntriesAdd($dbConn, $isbn, $user_id, $action, $price=0, $condition='Good') {
    // Ensure the isbn and user_id both exist in the database
    if(!ensureKeyExists($dbConn, 'books', 'isbn', $isbn)) {
      echo 'No such ISBN exists: ' . $isbn;
      return false;
    }
    if(!ensureKeyExists($dbConn, 'users', 'user_id', $user_id)) {
      echo 'No such user exists: ' . $user_id;
      return false;
    }
    
    // Query more information on the book (really just the name)
    $book_name = 'NOPE';
    
    // Pipe to the actual function
    $query = '
      INSERT INTO `entries` (
        `isbn`, `user_id`, `name`, `price`, `condition`, `action`
      ) VALUES (
        :isbn, :user_id, :name, :price, :condition, :action
      )
    ';
    $stmnt = $dbConn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    $stmnt->execute(array(':isbn'      => $isbn,
                          ':user_id'   => $user_id,
                          ':name'      => $book_name,
                          ':price'     => $price,
                          ':condition' => $condition,
                          ':action'    => $action));
  }
  
  $dbConn = getPDO($dbHost, $dbName, $dbUser, $dbPass);
  userEntriesAdd($dbConn, 12341, 123, 'Buy', 12.34, 'Fair');
?>