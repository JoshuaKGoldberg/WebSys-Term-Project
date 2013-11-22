<?php
  /* Back-end actions the user is allowed to do
   *
   * I would write a class for this, but that 
   * might be above the above the scope of what
   * the team is willing to deal with.
  */
  
  require_once('settings.php');
  
  
  /* Entries Functions
  */
  
  // userEntriesGet(#user_id[, "action"])
  // Gets all entries of a given user (optionally, of a given action
  // Sample user: userEntriesGet($dbConn, $user_id);
  function dbEntriesGet($dbConn, $user_id, $action='') {
    // Ensure the user_id exists in the database
    if(!checkKeyExists($dbConn, 'users', 'user_id', $user_id)) {
      echo 'No such user exists: ' . $user_id;
      return false;
    }
    
    // Prepare the initial query and the initial arguments
    $query = '
      SELECT * FROM `entries`
      WHERE `user_id` = :user_id
    ';
    // Add in the extra filter, if needed
    if($action != '') {
      $query .= ' AND `action` = :action';
      $args = array(':user_id' => $user_id,
                    ':action'  => $action);
    }
    else $args = array(':user_id' => $user_id);
    
    // Run the insertion query
    $stmnt = getPDOStatement($dbConn, $query);
    $stmnt->execute($args);
    
    return $stmnt->fetch(PDO::FETCH_ASSOC);
  }
  
  // userEntriesAdd(#isbn, #user_id, #price, "state")
  // Adds an entry to `entries`
  // Sample usage: userEntriesAdd($dbConn, $isbn, $user_id, 'Buy', 12.34, 'Fair');
  function dbEntriesAdd($dbConn, $isbn, $user_id, $action, $price=0, $state='Good') {
    // Ensure the isbn and user_id both exist in the database
    if(!checkKeyExists($dbConn, 'books', 'isbn', $isbn)) {
      echo 'No such ISBN exists: ' . $isbn;
      return false;
    }
    if(!checkKeyExists($dbConn, 'users', 'user_id', $user_id)) {
      echo 'No such user exists: ' . $user_id;
      return false;
    }
    
    // Query more information on the book (really just the name)
    $book_name = getRowValue($dbConn, 'books', 'name', 'isbn', $isbn);
    
    // Run the insertion query
    $query = '
      INSERT INTO `entries` (
        `isbn`, `user_id`, `name`, `price`, `state`, `action`
      ) VALUES (
        :isbn, :user_id, :name, :price, :state, :action
      )
    ';
    $stmnt = getPDOStatement($dbConn, $query);
    $stmnt->execute(array(':isbn'      => $isbn,
                          ':user_id'   => $user_id,
                          ':name'      => $book_name,
                          ':price'     => $price,
                          ':state'     => $state,
                          ':action'    => $action));
  }
  
  // userEntriesAdd(#isbn, #user_id)
  // Removes an entry from `entries`
  // Sample usage: userEntriesAdd($dbConn, $isbn, $user_id);
  function dbEntriesRemove($dbConn, $isbn, $user_id) {
    // Ensure the isbn and user_id both exist in the database
    if(!checkKeyExists($dbConn, 'books', 'isbn', $isbn)) {
      echo 'No such ISBN exists: ' . $isbn;
      return false;
    }
    if(!checkKeyExists($dbConn, 'users', 'user_id', $user_id)) {
      echo 'No such user exists: ' . $user_id;
      return false;
    }
    
    // Run the deletion query
    $query = '
      DELETE FROM `entries`
      WHERE
        `isbn` = :isbn
        AND
        `user_id` = :user_id
    ';
    $stmnt = getPDOStatement($dbConn, $query);
    $stmnt->execute(array(':isbn'    => $isbn,
                          ':user_id' => $user_id));
  }

  
  /* Book Functions
  */
  
  // dbBooksGet(#isbn)
  // Gets information on a book of the given ISBN
  function dbBooksGet($dbConn, $isbn) {
    // Ensure the isbn exists in the database
    if(!checkKeyExists($dbConn, 'books', 'isbn', $user_id)) {
      echo 'No such isbn exists: ' . $isbn;
      return false;
    }
    
    // Prepare the initial query
    $query = '
      SELECT * FROM `books`
      WHERE `isbn` = :isbn
    ';
    
    // Run the query
    $stmnt = getPDOStatement($dbConn, $query);
    $stmnt->execute(array(':isbn' => $isbn));
    
    // Get the results
    return $stmnt->fetch(PDO::FETCH_ASSOC);
  }
  
  // dbBooksAdd(#isbn, "name", ["authors"], "genre", #edition)
  // Adds a book to the database with the given information
  // Authors may be given as an array or string (separated by endlines)
  function dbBooksAdd($dbConn, $isbn, $name, $authors, $genre, $edition=1) {
    // Ensure the isbn doesn't already exist
    if(checkKeyExists($dbConn, 'books', 'isbn', $isbn)) {
      echo 'The ISBN already exists: ' . $user_id;
      return false;
    }
    
    // Convert the $authors argument if needed
    if(isarray($authors))
      $authors = implode($authors, '\n');
    
    // Run the insertion query
    $query = '
      INSERT INTO  `books` (
        `isbn`, `name`, `authors`, `genre`, `edition`
      )
      VALUES (
        :isbn,  :name, :authors, :genre, :edition
      )
    ';
    $stmnt = getPDOStatement($dbConn, $query);
    $stmnt->execute(array(':isbn'    => $isbn,
                          ':name'    => $name,
                          ':authors' => $authors,
                          ':genre'   => $genre,
                          ':edition' => $edition));
  }
  
?>