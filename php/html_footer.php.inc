<?php

require_once('settings.php');

function html_print_footer($js=[]) {
  // Begin the footer
  echo '    <!-- Footer -->' . PHP_EOL;
  echo '    <footer>' . PHP_EOL;
  echo '      Web Systems Development &mdash; Term Project' . PHP_EOL;
  echo '      <hr />' . PHP_EOL;
  echo '      Group Too! &mdash;  T.J. Callahan, Joshua Goldberg, Evan MacGregor, Candice Poon, &amp; Scott Sacci' . PHP_EOL;
  echo '    </footer>' . PHP_EOL;
  echo '  </body>' . PHP_EOL;
  echo PHP_EOL;
  
  // Add the necessary JS files
  foreach($js as $filename)
    echo '  <script type="text/javascript" src="js/' . $filename . '.js"></script>' . PHP_EOL;
  
  echo '</html>';
}

?>