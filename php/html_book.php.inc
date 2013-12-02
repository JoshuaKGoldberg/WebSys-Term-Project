<?php
  require_once('settings.php');
  
  // printBookDisplayLarge(#isbn, {info})
  // Prints the large, single-page display of a book
  // Optionally takes in info so it doesn't repeat lookups
  function printBookDisplayLarge($isbn, $info = false) {
    if(!$info) $info = dbBooksGet(getPDOQuick(), $isbn);
    
    // Record that data for ease of use
    $google_id = $info['google_id'];
    $title = $info['title'];
    $authors = $info['authors'];
    $publisher = $info['publisher'];
    $description = $info['description'];
    $year = $info['year'];
    $pages = $info['pages'];
    
    echo '<div class="display_book display_book_large">' . PHP_EOL;
    echo '  <img src="http://bks2.books.google.com/books?id=' . $google_id . '&printsec=frontcover&img=1&zoom=1&source=gbs_api" />' . PHP_EOL;
    echo '    <div class="display_book_info">' . PHP_EOL;
    echo '      <h1>' . $title . ' <aside>(' . $year . ')</aside></h1>' . PHP_EOL;
    echo '      <h3>' . str_replace('\n', ', ', $authors) . '</h3>' . PHP_EOL;
    echo '    </div>' . PHP_EOL;
    echo '    <div class="display_book_description">' . PHP_EOL;
    echo '      <blockquote>' . htmlentities($description) . '</blockquote>' . PHP_EOL;
    echo '    </div>' . PHP_EOL;
    echo '    <div class="display_book_published">' . PHP_EOL;
    echo '      <p><em>Published by</em> ' . $publisher . '</p>' . PHP_EOL;
    echo '    </div>' . PHP_EOL;
    echo '  </div>' . PHP_EOL;
  }
  
  // Prints out all the entries
  // printBookEntriesPlaceholder("type")
  // Prints out all the wrapper div, to be filled out by books.js::printBookEntries()
  function printBookEntriesPlaceholder($type, $info) {
    echo '<div class="display_entries_in display_entries_' . $type . '">' . PHP_EOL;
    echo '<h3>Offers to ' . $type . '...</h3>' . PHP_EOL;
    echo '<aside>loading...</aside>' . PHP_EOL;
    echo '</div>' . PHP_EOL;
  }
?>