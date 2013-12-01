<?php
  require_once('php/settings.php');
  require_once('php/html_help.php');
  session_start();
  // If the user isn't logged in, don't bother with this page    
  if(!isset($_SESSION['Logged In']) || !$_SESSION['Logged In'])
    header('Location: index.php');
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Book Exchange</title>
    <link rel="stylesheet" type="text/css" href="css/default.css">
    <link href='http://fonts.googleapis.com/css?family=Doppio+One' rel='stylesheet' type='text/css'>
  </head>
  <body>
    <!-- Header -->
    <header>
      <h1>book exchange or something idk</h1>
    </header>
  
  
  <script type="text/javascript" src="js/jquery-2.0.3.min.js"></script>
  <script type="text/javascript" src="js/google_books_api.js"></script>
  <script type="text/javascript" src="js/requests.js"></script>
  </body>
</html>