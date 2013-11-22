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
  function userEntriesAdd($isbn, $user_id, $action, $price=0, $condition=$bookConditions[3]) {
    // Ensure the isbn and user_id both exist in the database
    if(!ensureKeyExists('books', 'isbn', $isbn))
      return false;
    if(!ensureKeyExists('users', 'user_id', $user_id))
      return false;
    
    // Pipe to the actual function
  }
?>