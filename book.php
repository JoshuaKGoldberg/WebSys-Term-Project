<?php
  require_once('php/html_helpers.php');
  require_once('php/html_book.inc.php');
  page_start(array("books"));
  
  if(!isset($_GET['isbn']))
    header('Location: index.php');
  $isbn = $_GET['isbn'];
  
  // Grab info on the book itself
  $dbConn = getPDOQuick();
  $book_info = dbBooksGet($dbConn, $isbn);
  
  printBookDisplayLarge($isbn, $book_info);
  
  // Print the entries (offers) divs
  echo PHP_EOL;
  echo '<!-- Entries -->' . PHP_EOL;
  echo '<div id="display_entries" class="width_standard">' . PHP_EOL;
  printBookEntriesPlaceholder('buy', $book_info);
  printBookEntriesPlaceholder('sell', $book_info);
  echo '</div>' . PHP_EOL;
  
  // There may be wrong information, provide a form for that
  echo '<aside class="display_entries_after">Wrong information here? <a href="mailto:' . getSiteEmail() . '">Let us know!</a></aside>' . PHP_EOL;
  
  page_end(array("books"));
  
  // Make the page auto-load via js
  echo '<script type = "text/javascript"> startLoadingBookEntries("' . $isbn . '"); </script>';
  
?>