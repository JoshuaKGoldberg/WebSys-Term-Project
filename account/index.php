<?php
  require_once('../php/settings.php');
  require_once('../php/db_actions.php');
  require_once('../php/html_header.php.inc');
  require_once('../php/html_footer.php.inc');
  session_start();

  if(isset($_SESSION['Logged In']) && isset($_SESSION['username']) && isset($_SESSION['user_id'])) {
    $username = $_SESSION['username'];
    $user_id = $_SESSION['user_id'];
    if (isset($_SESSION['email'])) $email = $_SESSION['email'];
    if (isset($_SESSION['major'])) $major = $_SESSION['major'];
  } else {
    header('Location: ../');
  }

  if (isset($_SESSION['username']) && isset($_POST['logout']) && $_POST['logout'] == 'Logout') {
    // end the session here
    unset($_SESSION['Logged In']);
    session_unset(); 
    session_destroy();
    $err = 'You have been logged out.';
    header('Location: ../');
    exit();
  }

  $dbConn = getPDOQuick();

?>

<!-- Header -->
<?php html_print_header("ACCOUNT",$username); ?>

  <div id="listwrapper">
    <section id="wishlist" class="booklist">
      <h3>Wishlist</h3>
      <div id="listitem">
        <?php

        $user_wishes = dbEntriesGet($dbConn, $user_id, "Wish");
        if (isset($user_wishes)){ 
          if (count($user_wishes) == 0) {
            echo "<p style='text-align:center'>You have nothing on your wishlist.</p><p style='text-align:center'><a href=''>Add something!</a></p>";
          } else {
            foreach ($user_wishes as $book) {
              # code...

              //<img src="../images/book-cover-placeholder.png" height="86" width="86">
              //<p>Title</p>
              //<p>ISBN</p>
            }
          }
        } else {
          echo "<p>Nothing returned.</p>";
        }

        ?>
      </div>
    </section>
    <section id="tradelist" class="booklist">
      <h3>Tradelist</h3>
      <div id="listitem">
        <?php

        $user_trades = dbEntriesGet($dbConn, $user_id, "Trade");
        if (isset($user_trades)){ 
          if (count($user_trades) == 0) {
            echo "<p style='text-align:center'>You have nothing on your tradelist.</p><p style='text-align:center'><a href=''>Add something!</a></p>";
          } else {
            foreach ($user_trades as $book) {
              # code...

              //<img src="../images/book-cover-placeholder.png" height="86" width="86">
              //<p>Title</p>
              //<p>ISBN</p>
            }
          }
        } else {
          echo "<p>Nothing returned.</p>";
        }

        ?>
      </div>
    </section>
  </div>


<!-- Footer -->
<?php html_print_footer(); ?>