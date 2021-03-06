<?php
  /* Back-end actions the user is allowed to do
   *
   * I would write a class for this, but that 
   * might be above the above the scope of what
   * the team is willing to deal with.
  */
  require_once('settings.php');
  
  /* User Functions
  */
  
  // dbUsersGet("identity"[, "type"])
  // Gets the user of the given identity (by default, username)
  // Sample usage: dbUsersGet($dbConn, $username, "username");
  function dbUsersGet($dbConn, $identity, $type='username') {
    // Ensure the identity exists in the database
    if(!checkKeyExists($dbConn, 'users', $type, $identity)) {
      echo 'No such ' . $type . ' exists: ' . $identity;
      return false;
    }
    
    // Prepare the initial query
    $query = '
      SELECT * FROM `users`
      WHERE `' . $type . '` = :identity
    ';
    
    // Run the query
    $stmnt = getPDOStatement($dbConn, $query);
    $stmnt->execute(array(':identity' => $identity));
    
    // Get the results
    return $stmnt->fetch();
  }

  // dbUsersAdd("username", "password", "email", #role)
  // Adds a user to `users`
  // Sample usage: dbUsersAdd($dbConn, $username, $password, $email, $role);
  function dbUsersAdd($dbConn, $username, $password, $email, $role) {
    // Ensure the username and email and email don't exist in the database
    if(checkKeyExists($dbConn, 'users', 'username', $username)) {
      echo 'Such a user already exists: ' . $username;
      return false;
    }
    if(checkKeyExists($dbConn, 'users', 'username', $username)) {
      echo 'Such an email already exists: ' . $username;
      return false;
    }
    
    // Create the password, salt and all
    $salt = hash('sha256', uniqid(mt_rand(), true));
    $salted = hash('sha256', $salt . $password);
    
    // Run the insertion query
    $query = '
      INSERT INTO  `users` (
        `username`, `password`, `email`, `role`, `salt`
      )
      VALUES (
        :username,  :password, :email, :role, :salt
      )
    ';
    $stmnt = getPDOStatement($dbConn, $query);
    $stmnt->execute(array(':username' => $username,
                          ':password' => $salted,
                          ':email'    => $email,
                          ':role'     => $role,
                          ':salt'     => $salt));
    return true;
  }
  
  // dbUsersRemove("identity"[, "type"])
  // Removes a user from `users` of the given identity (by default, username)
  // Sample usage: dbUsersRemove($dbConn, $username, "username");
  function dbUsersRemove($dbConn, $identity, $type='username') {
    // Ensure the identity exists in the database
    if(!checkKeyExists($dbConn, 'users', $type, $identity)) {
      echo 'No such ' . $type . ' exists: ' . $identity;
      return false;
    }
    
    // Run the deletion query
    $query = '
      DELETE FROM `users`
      WHERE `' . $type . '` = :identity
    ';
    $stmnt = getPDOStatement($dbConn, $query);
    $stmnt->execute(array(':identity'    => $identity));
  }
  
  
  /* Book Functions
  */
  
  // dbBooksGet(#isbn)
  // Gets information on a book of the given ISBN
  // Sample usage: dbBooksGet($dbConn, $isbn);
  function dbBooksGet($dbConn, $isbn) {
    // Ensure the isbn exists in the database
    if(!checkKeyExists($dbConn, 'books', 'isbn', $isbn)) {
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
  
  // dbBooksAdd(#isbn, #googleID, "title", "authors", "description", "publisher", "year", "pages")
  // Adds a book to `books`
  // Authors may be given as an array or string (separated by endlines)
  // Sample usage: dbBooksAdd($dbConn, $googleID, $isbn, $title, $authors, $genre);
  function dbBooksAdd($dbConn, $isbn, $googleID, $title, $authors, $description, $publisher, $year, $pages) {
    // Ensure the isbn doesn't already exist
    if(checkKeyExists($dbConn, 'books', 'isbn', $isbn)) {
      echo 'The ISBN already exists: ' . $isbn;
      return false;
    }
    
    // Convert the $authors argument if needed
    if(is_array($authors))
      $authors = implode($authors, '\n');
    
    // Make sure $year only contains the 4-digit year string
    if(strlen($year) > 4) {
      $year = explode("-", $year);
      foreach($year as $sub)
        if(strlen($sub) == 4) {
            $year = $sub;
            break;
        }
    }
    
    // Run the insertion query
    $query = '
      INSERT INTO  `books` (
        `isbn`, `google_id`, `title`, `authors`, `description`, `publisher`, `year`, `pages`
      )
      VALUES (
        :isbn, :google_id,  :title, :authors, :description, :publisher, :year, :pages
      )
    ';
    $stmnt = getPDOStatement($dbConn, $query);
    $stmnt->execute(array(':isbn'        => $isbn,
                          ':google_id'   => $googleID,
                          ':title'       => $title,
                          ':authors'     => $authors,
                          ':description' => $description,
                          ':publisher'   => $publisher,
                          ':year'        => $year,
                          ':pages'       => $pages));
    
    return true;
  }
  
  // (missing Remove)
  
  /* Entries Functions
  */
  
  // dbEntriesGet(#user_id[, "action"])
  // Gets all entries of a given user (optionally, of a given action
  // Sample usage: dbEntriesGet($dbConn, $user_id);
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
    
    return $stmnt->fetchAll(PDO::FETCH_ASSOC);
  }
  
  // dbBookEntriesGet(#isbn)
  // Gets all the entires related to an isbn (rather than user_id)
  function dbBookEntriesGet($dbConn, $isbn) {
    $query = '
      SELECT * FROM `entries`
      WHERE `isbn` = :isbn
    ';
    $stmnt = getPDOStatement($dbConn, $query);
    $stmnt->execute(array(':isbn' => $isbn));
    
    return $stmnt->fetchAll(PDO::FETCH_ASSOC);
  }
  
  // dbEntriesAdd(#isbn, #user_id, #price, "state")
  // Adds an entry to `entries`
  // Sample usage: dbEntriesAdd($dbConn, $isbn, $user_id, 'Buy', 12.34, 'Fair');
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
    
    // Query more information on the book (really just the title)
    $book_title = getRowValue($dbConn, 'books', 'title', 'isbn', $isbn);
    
    // Run the insertion query
    $query = '
      INSERT INTO `entries` (
        `isbn`, `user_id`, `title`, `price`, `state`, `action`
      ) VALUES (
        :isbn, :user_id, :title, :price, :state, :action
      )
    ';
    $stmnt = getPDOStatement($dbConn, $query);
    $stmnt->execute(array(':isbn'      => $isbn,
                          ':user_id'   => $user_id,
                          ':title'     => $book_title,
                          ':price'     => $price,
                          ':state'     => $state,
                          ':action'    => $action));
  }
  
  // dbEntriesRemove(#isbn, #user_id)
  // Removes an entry from `entries`
  // Sample usage: dbEntriesRemove($dbConn, $isbn, $user_id);
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
  
  
  /* History Functions
  */
  
  // dbHistoryAdd(#isbn, #user_id_a, #user_id_b, #rating_by_a, #rating_by_b, "action")
  // Creates the two listings in history for a single transaction
  // Sample usage: dbHistoryAdd($dbConn, $isbn, $user_id_a, $user_id_b, $rating_by_a, $rating_by_b, $action);
  function dbHistoryAdd($dbConn, $isbn, $user_id_a, $user_id_b, $rating_by_a, $rating_by_b, $action) {
    // Get the current timestamp, so it isn't marginally different between the two
    $timestamp = time();
    
    // Add the two event markers (one from each perspective)
    dbHistoryAddSingle($dbConn, $isbn, $timestamp, $user_id_a, $user_id_b, $rating_by_a, $action);
    dbHistoryAddSingle($dbConn, $isbn, $timestamp, $user_id_b, $user_id_a, $rating_by_b, getActionOpposite($action));
  }
  // Helper function for dbHistoryAdd
  // Creates a single listing in history, which is one of the two representing a single transaction
  function dbHistoryAddSingle($dbConn, $isbn, $timestamp, $user_rater, $user_rated, $rating, $action) {
    $query = '
      INSERT INTO `history` (
        `isbn`, `timestamp`, `user_rater`, `user_rated`, `rating`, `action`
      ) VALUES (
        :isbn, :timestamp, :user_rater, :user_rated, :rating, :action
      )
    ';
    $stmnt = getPDOStatement($dbConn, $query);
    $stmnt->execute(array(':isbn'        => $isbn,
                          ':timestamp'   => $timestamp,
                          ':user_rater'  => $user_rater,
                          ':user_rating' => $user_rating,
                          ':rating'      => $rating,
                          ':action'      => $action));
  }
  
  // (missing Get, Remove)
?>