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
  function publicCreateUser($arguments, $noverbose=false) {
    $dbConn = $_SESSION['dbConn'];
    $username = $arguments['username'];
    $password = $arguments['password'];
    $email = $arguments['email'];
    
    // Make sure the arguments aren't blank
    if(!$username || !$password || !$email) return;
    
    if(dbUsersAdd($dbConn, $username, $password, $email, 0) && !$noverbose)
      echo 'Yes';
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
  function publicAddBook($arguments, $noverbose=false) {
    $dbConn = $_SESSION['dbConn'];
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
    
    // Don't continue if the name or authors are missing or blank
    if(!isset($info->title) || !isset($info->authors))
      return;
      
    $name = $info->title;
    $authors = $info->authors;
    $description = isset($info->description) ? explode("\n", $info->description)[0] : "";
    $publisher = isset($info->publisher) ? $info->publisher : "";
    $year = isset($info->publishedDate) ? $info->publishedDate : "";
    $pages = isset($info->pageCount) ? $info->pageCount : "";
    
    // Name and authors can't be blank, but other fields can be
    if(!$name || !$authors)
      return;
    
    if(dbBooksAdd($dbConn, $isbn, $name, $authors, $description, $publisher, $year, $pages) && !$noverbose)
      echo 'Yes';
  }
?>