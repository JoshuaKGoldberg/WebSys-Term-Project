<?php
  require_once('php/settings.php');
  require_once('php/db_actions.php');
  require_once('php/html_header.php.inc');
  require_once('php/html_footer.php.inc');
  require_once('php/html_book.php.inc');
  session_start();
  
?>

<?php html_print_header("book"); ?>

<?php printBookDisplayLarge($_GET['isbn']); ?>

<?php html_print_footer(); ?>