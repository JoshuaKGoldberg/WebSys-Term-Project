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
          <div id="header_search_results">
            <div id="search_results_title"></div>
            <div id="search_results_description"></div>
            <div id="search_results_authors"></div>
          </div>
          <form id="header_search_form" onkeydown="searchStart();" onsubmit="event.preventDefault(); searchStart();">
            <input id="header_search_input" type="text" placeholder="search" />
          </form>
          <div id="header_search_submit" onclick="searchStart();"></div>
        </div>
      </div>
    </header>
  ';
  }
?>