<?php
  /* Functions for HTML pages
  */
  
  require_once('settings.php');
  
  
  // Prints the general header
  function html_print_header() {
  echo '
    <header>
      <div id="header_main">
        <h1>book exchange or something idk
        </h1>
        <div id="header_search">
          <div id="header_search_results"></div>
          <form id="header_search_form">
            <input type="text" placeholder="search" />
          </form>
          <div id="header_search_submit"></div>
        </div>
      </div>
    </header>
  ';
  }
?>