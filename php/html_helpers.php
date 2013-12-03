<?php
  require_once('settings.php');
  require_once('db_actions.php');
  require_once('html_header.inc.php');
  require_once('html_footer.inc.php');
  
  // page_start(["css"])
  // Start a page, including the correct PHP and CSS files and printing the header
  function page_start($css=[]) {
    // Ensure the session exists
    if(!isset($_SESSION))
      session_start();
    
    // Add the default CSS
    //$css[] = "default";
    array_unshift($css, "default");
    
    // Print the header, using the required CSS files
    html_print_header($css);
  }
  
  // page_end(["js"])
  // Ends a page, including the correct JS files
  function page_end($js=[]) {
    // Add the default JS
    $js[] = "jquery-2.0.3.min";
    $js[] = "requests";
    $js[] = "search";
    html_print_footer($js);
  }

  // ensure_logged_in()
  // Redirects anonymous users to index.php
  function ensure_logged_in() {
    if(!isset($_SESSION['Logged In']) || !$_SESSION['Logged In'])
      header('Location: /index.php');
  }
  
  // ensure_logged_out()
  // Redirects logged in users to account.php
  function ensure_logged_out() {
    if(isset($_SESSION['Logged In']) && $_SESSION['Logged In'])
      header('Location: /account.php');
  }
?>