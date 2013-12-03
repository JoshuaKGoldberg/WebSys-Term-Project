<?php
  /* Functions the public may access via requests.js -> requests.php
   * The names of these functions are in settings.php -> $allowed_functions
  */
  require_once('db_actions.php');
  
  // publicCheckValidity({...})
  // Checks if a field (username, email) is taken and echos if it's unavailable
  // Required fields:
  // * "type"   - "username" or "email" 
  // * "value"  - the value to see if it's duplicate or not
  function publicCheckValidity($arguments, $noverbose=false) {
    $dbConn = getPDOQuick();
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
  function publicCreateUser($arguments, $noverbose=false) {
    $dbConn = getPDOQuick();
    $username = $arguments['username'];
    $password = $arguments['password'];
    $email = $arguments['email'];
    
    // Make sure the arguments aren't blank
    if(!$username || !$password || !$email) return;

    // If successful, log in
    if(dbUsersAdd($dbConn, $username, $password, $email, 0)) {
      publicLogin($arguments, true);
      if(!$noverbose)
        echo 'Yes';
    }
  }
  
  // publicLogin({...})
  // Public pipe to loginAttempt("username", "password")
  // Required fields:
  // * "username"
  // * "password"
  function publicLogin($arguments, $noverbose=false) {
    $username = $arguments['username'];
    $password = $arguments['password'];
    if(loginAttempt($username, $password) && !$noverbose)
      echo 'Yes';
  }

  // publicAddBook({...})
  // Gets the info on a book from the Google API, then pipes it to dbBooksAdd
  // Required fields:
  // * "isbn"
  // https://developers.google.com/books/docs/v1/using
  // https://www.googleapis.com/books/v1/volumes?q=isbn:9780073523323&key=AIzaSyD2FxaIBhdLTA7J6K5ktG4URdCFmQZOCUw
  function publicAddBook($arguments, $noverbose=false) {
    $dbConn = getPDOQuick();
    $isbn = $arguments['isbn'];
    
    // Make sure the arguments aren't blank
    if(!$isbn) return;
    
    // Get the actual JSON contents and decode it
    $url = "https://www.googleapis.com/books/v1/volumes?q=isbn:" . $isbn . "&key=" . getGoogleKey();
    $result = json_decode(getHTTPPage($url));
    
    // If there was an error, oh no!
    if(isset($result->error)) {
      echo $result->error->message;
      return;
    }
    
    // Attempt to get the first item in the list (which will be the book)
    if(!isset($result->items) || !isset($result->items[0]))
      return;
    $book = $result->items[0];
    
    // Attempt to get the book's info (stored as volumeInfo)
    if(!isset($book->volumeInfo))
      return;
    $info = $book->volumeInfo;
    
    // Don't continue if the title or authors are missing or blank
    if(!isset($info->title) || !isset($info->authors))
      return;
      
    $title = $info->title;
    $authors = $info->authors;
    $description = isset($info->description) ? explode("\n", $info->description)[0] : "";
    $publisher = isset($info->publisher) ? $info->publisher : "";
    $year = isset($info->publishedDate) ? $info->publishedDate : "";
    $pages = isset($info->pageCount) ? $info->pageCount : "";
    $googleID = isset($book->id) ? $book->id : "";
    
    // Title and authors can't be blank, but other fields can be
    if(!$title || !$authors)
      return;
    
    if(dbBooksAdd($dbConn, $isbn, $googleID, $title, $authors, $description, $publisher, $year, $pages) && !$noverbose) {
      echo 'Yes';
      return true;
    }
    return false;
  }

  // publicSearch({...})
  // Runs a search for a given value on a given field
  // Required fields:
  // * "column"
  // * "value"
  // This needs protection against SQL injections
  function publicSearch($arguments, $noverbose=false) {
    $dbConn = getPDOQuick();
    $column = $arguments['column'];
    $value = '%' . $arguments['value'] . '%';
    
    // Prepare the initial query
    $query = '
      SELECT * FROM `books`
      WHERE `' . $column . '` LIKE :value
    ';
    
    // Run the query
    $stmnt = getPDOStatement($dbConn, $query);
    $durp = $stmnt->execute(array(':value' => $value));
    
    // Return a JSON encoding of the results
    $result = $stmnt->fetchAll(PDO::FETCH_ASSOC);
    echo $column . " " . json_encode($result);
  }

  // publicGetBookEntries({...})
  // Gets all entries for an isbn of the given action
  // Required fields:
  // * #isbn
  // * "action"
  function publicGetBookEntries($arguments, $noverbose=false) {
    $dbConn = getPDOQuick();
    $isbn = $arguments['isbn'];
    $action = $arguments['action'];
    
    // Prepare the initial query
    $query = '
      SELECT * FROM `entries`
      WHERE `isbn` LIKE :isbn
      AND `action` LIKE :action
    ';
    
    // Run the query
    $stmnt = getPDOStatement($dbConn, $query);
    $durp = $stmnt->execute(array(':isbn' => $isbn,
                                  ':action' => $action));
    
    // Return a JSON encoding of the results
    $result = $stmnt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($result);
  }
  
  // publicGetSIS
  // Simply outputs the HTTP page of the specified SIS page
  // No required fields!
  function publicGetSIS($arguments=false, $noverbose=false) {
    echo getHTTPPage(getSISAPI());
  }
  
  function publicGetSISBookISBN($arguments=false) {
    // // Get the raw page itself
    // $url_arguments = $arguments['url_arguments'];
    // $page = getHTTPPage($getSISPageStart() . $urlArguments);
    
    // echo "temp1";
    
    // Filter for just the ISBN
    // $key = "<strong>ISBN:</strong>";
    // $loc = strpos($page, $key); // Ending right before the space
    // $loc = strpos($page, " ", $loc) + 1; // The one after the space
    // $loc_end = strpos($page, "<br/>", $loc);
    
    // $result = substr($page, $loc, $loc_end - $loc);
    // echo $result;
    echo "hi";
  }
  
  // publicISBNCheck({...})
  // Goes through the motions of checking if an ISBN is in the database
  // If it isn't, it calls the function to add the book 
  function publicISBNCheck($arguments) {
    $dbConn = getPDOQuick();
    $isbn = $arguments['isbn'];
    
    // Does the ISBN exist?
    if(checkKeyExists($dbConn, 'books', 'isbn', $isbn)) {
      echo '<aside>ISBN ' . $isbn . ' is already in our database as ';
      echo '<a href="books.php?isbn=' . $isbn . '">';
      echo getRowValue($dbConn, 'books', 'title', 'isbn', $isbn);
      echo '</a>.</aside>';
      return;
    }
    
    // Since it doesn't yet, attempt to add it
    $added = publicAddBook($arguments);
    
    // If that was successful, hooray!
    if($added) {
      echo '<aside class="success">ISBN ' . $isbn . ' was added to our database as ';
      echo '<a href="books.php?isbn=' . $isbn . '">';
      echo getRowValue($dbConn, 'books', 'title', 'isbn', $isbn);
      echo '</a>.</aside>';
      return;
    }
    // Otherwise nope
    echo '<aside class="failure">ISBN ' . $isbn . ' returned no results.</aside>';
  }
?>