<?php
  require_once('php/settings.php');
  require_once('php/db_actions.php');
  require_once('php/html_header.php.inc');
  require_once('php/html_footer.php.inc');
  session_start();
  
?>

<!-- Header -->
<?php html_print_header("book"); ?>
<?php html_print_footer(); ?>