<?php
  require_once('settings.php');
  
  function printBookDisplayLarge($isbn) {
    // First grab the info about the book
    if(!isset($_SESSION)) session_start();
    $dbConn = isset($_SESSION['dbConn']) ? $_SESSION['dbConn'] : getPDOQuick();
    $info = dbBooksGet($dbConn, $isbn);
    
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
    echo '      <h1>' . $title . '<aside>(' . $year . ')</aside></h1>' . PHP_EOL;
    echo '      <h3>' . $authors . '</h3>' . PHP_EOL;
    echo '    </div>' . PHP_EOL;
    echo '    <div class="display_book_description">' . PHP_EOL;
    echo '      <blockquote>' . htmlentities($description) . '</blockquote>' . PHP_EOL;
    echo '    </div>' . PHP_EOL;
    echo '    <div class="display_book_published">' . PHP_EOL;
    echo '      <p><em>Published by</em> ' . $publisher . '</p>' . PHP_EOL;
    echo '    </div>' . PHP_EOL;
    echo '  </div>' . PHP_EOL;
  }
?>