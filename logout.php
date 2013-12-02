<?php
  /* Logout script
   * Clears the user's session and brings them to the index
  */
  
  session_start();
  session_unset();
  session_destroy();
  header('Location: index.php');
?>