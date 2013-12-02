<?php

require_once('settings.php');

function html_print_footer() {
  
  // BEGIN FOOTER
  echo '
        <footer>
          Web Systems Development &mdash; Term Project
          <hr />
          Group Too! &mdash;  T.J. Callahan, Joshua Goldberg, Evan MacGregor, Candice Poon, &amp; Scott Sacci
        </footer>
      </body>
      
      <script type="text/javascript" src="js/jquery-2.0.3.min.js"></script>
      <script type="text/javascript" src="js/mainpage.js"></script>
      <script type="text/javascript" src="js/requests.js"></script>
      <script type="text/javascript" src="js/search.js"></script>
    </html>
  ';
}

?>