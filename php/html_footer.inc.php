<?php

require_once('settings.php');

function html_print_footer($js=false) {
  if(!$js) $js = array();
  // Begin the footer
  echo '    <!-- Footer -->' . PHP_EOL;
  echo '    <footer>' . PHP_EOL;
  echo '      Web Systems Development &mdash; Term Project' . PHP_EOL;
  echo '      <hr />' . PHP_EOL;
  echo '      Group Too! &mdash;  T.J. Callahan, Joshua Goldberg, Evan MacGregor, Candice Poon, &amp; Scott Sacci' . PHP_EOL;
  echo '    </footer>' . PHP_EOL;
  echo '  </body>' . PHP_EOL;
  echo PHP_EOL;
  
  // Always include search, requests, and JQuery
  echo '  <script type="text/javascript" src="js/search.js"></script>' . PHP_EOL;
  echo '  <script type="text/javascript" src="js/requests.js"></script>' . PHP_EOL;
  echo '  <script type="text/javascript" src="js/jquery-2.0.3.min.js"></script>' . PHP_EOL;
  // Add any other necessary JS files
  foreach($js as $filename)
    echo '  <script type="text/javascript" src="js/' . $filename . '.js"></script>' . PHP_EOL;
  
  echo '</html>';
}

?>