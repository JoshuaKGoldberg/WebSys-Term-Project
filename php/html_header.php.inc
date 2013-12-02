<?php
  require_once('settings.php');
  
  // printUserBadge("spaces")
  // Prints the user's badge, drawing info from $_SESSION
  function printUserBadge($spaces='') {
    echo $spaces . '<!-- User Badge -->' . PHP_EOL;
    // The badge's contents are displayed in this front div
    echo $spaces . '<div id="badge">' . PHP_EOL;
    echo $spaces . '  <div id="badge_main">' . PHP_EOL;
    echo $spaces . '    <div id="badge_main_contents">' . PHP_EOL;
    // User information is shown...
    echo $spaces . '    <div id="badge_user_info">' . PHP_EOL;
    echo $spaces . '        <div id="badge_username"><a href="/account.php">' . chop_length($_SESSION['username'], 17) . '</a></div>' . PHP_EOL;
    echo $spaces . '        <div id="badge_email">' . chop_length($_SESSION['email'], 21) . '</div>' . PHP_EOL;
    echo $spaces . '    </div>' . PHP_EOL;
    // ...on top of the logout button
    echo $spaces . '      <div id="badge_logout"><form action="logout.php"><input type="submit" value="Log Out" /></form></div>' . PHP_EOL;
    echo $spaces . '    </div>' . PHP_EOL;
    echo $spaces . '  </div>' . PHP_EOL;
    echo $spaces . '  <div id="badge_image">' . PHP_EOL;
    echo $spaces . '    <img src="../images/profile-photo-placeholder.jpg" />' . PHP_EOL;
    echo $spaces . '  </div>' . PHP_EOL;
    echo $spaces . '</div>' . PHP_EOL;
    // A second div is used for positioning (pushing the h1 over)
    echo $spaces . '<div id="badge_back"></div>' . PHP_EOL;
  }
  function chop_length($string, $length, $after='...') {
    if(strlen($string) > $length)
      return substr($string, 0, $length) . $after;
    else return $string;
  }
  
  function html_print_header($css=false) {
    if(!$css) $css = array();
    if(!isset($_SESSION)) session_start();
    
    // Begin the header with the doctype
    echo '<!DOCTYPE html>' . PHP_EOL;
    echo '<html>' . PHP_EOL;
    echo '  <head>' . PHP_EOL;
    
    // The title used depends on the page
    echo '    <title>' . getSiteName() . '</title>' . PHP_EOL;

    // Import the required CSS files
    foreach($css as $filename)
      echo '    <link rel="stylesheet" type="text/css" href="css/' . $filename . '.css">' . PHP_EOL;

    echo '    <link href="http://fonts.googleapis.com/css?family=Doppio+One" rel="stylesheet" type="text/css">' . PHP_EOL;
    echo '    <link href="http://fonts.googleapis.com/css?family=Lato:300" rel="stylesheet" type="text/css">' . PHP_EOL;
    
    // Finish the head, and start the body (meaning the header itself)
    echo '  </head>' . PHP_EOL;
    echo '  <body>' . PHP_EOL . PHP_EOL;
    echo '    <!-- Header -->' . PHP_EOL;
    echo '    <header>' . PHP_EOL;
    echo '      <div id="header_main">' . PHP_EOL;
    
    // User badge, if the user is logged in
    if(isset($_SESSION['Logged In']) && $_SESSION['Logged In']) {
      printUserBadge('          ');
      echo PHP_EOL;
    }
    
    // Main header slogon
    echo '        <h1><a href="/">' . getSiteName() . '</a></h1>' . PHP_EOL;
    
    // Persistent search bar
    echo '        <!-- Search Bar -->' . PHP_EOL;
    echo '        <div id="header_search">' . PHP_EOL;
    echo '          <div id="header_search_results">' . PHP_EOL;
    echo '            <div id="search_results_title"></div>' . PHP_EOL;
    echo '            <div id="search_results_description"></div>' . PHP_EOL;
    echo '            <div id="search_results_authors"></div>' . PHP_EOL;
    echo '          </div>' . PHP_EOL;
    echo '          <form id="header_search_form" onkeydown="searchStart();" onsubmit="event.preventDefault(); searchStartFull();">' . PHP_EOL;
    echo '            <input id="header_search_input" type="text" placeholder="search" />' . PHP_EOL;
    echo '          </form>' . PHP_EOL;
    echo '          <div id="header_search_submit" onclick="searchStartFull();"></div>' . PHP_EOL;
    echo '        </div>' . PHP_EOL;
    echo '      </div>' . PHP_EOL;
    echo '    </header>' . PHP_EOL;
  }

?>