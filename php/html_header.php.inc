<?php

require_once('settings.php');

function html_print_header($page,$username="") {
  
  // BEGIN HEADER
  echo "
    <!DOCTYPE html>
    <html>
      <head>
  ";

  // DISTINCT TITLES AND STYLESHEETS FOR PAGES
  if ($page == "MAIN") { 
    echo "
        <title>" . getSiteName() . "</title>
        <link rel='stylesheet' type='text/css' href='css/default.css'>
        <link rel='stylesheet' type='text/css' href='css/mainpage.css'>
    ";
  } 

  elseif ($page == "ACCOUNT") {
    if (isset($username)) {
      echo "<title>$username - Account</title>";
    } else { 
      echo "<title>Account - " . getSiteName() . "</title>";
    }
    echo "
        <link rel='stylesheet' href='http://yui.yahooapis.com/pure/0.3.0/pure-min.css'>
        <link rel='stylesheet' type='text/css' href='../css/profilepage.css'>
    ";
  }

  // COMMON STYLESHEETS, END OF HEADER, BEGIN BODY
  echo "
        <link href='http://fonts.googleapis.com/css?family=Doppio+One' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Lato:300' rel='stylesheet' type='text/css'>
      </head>
      <body>
  ";

  // DISTINCT HTML HEADER ELEMENTS
  if ($page == "MAIN") { 
    echo "
        <header>
          <div id='header_main'>
            <h1 style='text-transform:lowercase'>" . getSiteName() . "</h1>
            <div id='header_search'>
              <div id='header_search_results'>
                <div id='search_results_title'></div>
                <div id='search_results_description'></div>
                <div id='search_results_authors'></div>
              </div>
              <form id='header_search_form' onkeydown='searchStart();' onsubmit='event.preventDefault(); searchStartFull();'>
                <input id='header_search_input' type='text' placeholder='search' />
              </form>
              <div id='header_search_submit' onclick='searchStartFull();'></div>
            </div>
          </div>
        </header>
    ";
  } 

  elseif ($page == "ACCOUNT") {
    echo "
        <div id='badge'>
          <img src='../images/profile-photo-placeholder.jpg' alt=' height='60' width='60'>
    ";
    if (isset($username)) echo "<p>$username</p>";
    //if (isset($email)) echo '<p>$email</p>';
    //if (isset($major)) echo '<p>$major</p>';
    echo "
          <form method='post' action='index.php'>
            <input name='logout' type='submit' value='Logout' class='pure-button' />
          </form>
        </div>
        <header>
          <h1 style='text-transform:lowercase'><a href='../index.php'>" . getSiteName() . "</a></h1>
        </header>
        <form class='pure-form' id='search'>
          <input type='search' placeholder='Search'>
          <button type='submit' class='pure-button'>Search</button>
        </form>
    ";
  }

}

?>